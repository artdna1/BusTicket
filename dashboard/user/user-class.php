<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../database/db_config.php'; // ✅ Correct filename
require_once __DIR__ . '/../../vendor/autoload.php'; // For PHPMailer

class USER
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->dbConnection();
    }

    public function runQuery($sql)
    {
        return $this->conn->prepare($sql);
    }

    public function register($fullname, $email, $password, $token = null)
    {
        try {
            // Check if email already exists
            $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            if ($stmt->rowCount() > 0) {
                return false;
            }

            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("INSERT INTO users (full_name, email, password, role, status, token)
                                      VALUES (:fullname, :email, :password, 3, 'inactive', :token)");
            $stmt->bindParam(":fullname", $fullname);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashPassword);
            $stmt->bindParam(":token", $token);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Enable this temporarily for debugging
            return false;
        }
    }


    public function login($email, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userRow) {
                if (password_verify($password, $userRow['password'])) {
                    if ($userRow['status'] === 'active') {
                        $_SESSION['userSession'] = $userRow['user_id']; // Corrected field
                        return true;
                    } else {
                        return "not_verified";
                    }
                } else {
                    return "invalid_password";
                }
            } else {
                return "not_found";
            }
        } catch (PDOException $e) {
            return false;
        }
    }


    public function isUserLoggedIn()
    {
        return isset($_SESSION['userSession']);
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = []; // Clear session array

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
        return true;
    }

    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    public function getUserDetails($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function sendOTP($email, $token)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = SMTP_PORT;

            $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "OTP Verification";
            $mail->Body = "Click this link to verify your account: <br><br>
                           <a href='" . SITE_URL . "dashboard/user/otp-verify.php?email=$email&token=$token'>Verify Account</a>";

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }

    public function activateUser($email, $token)
    {
        $stmt = $this->conn->prepare("UPDATE users SET status = 'active', token = '' WHERE email = :email AND token = :token");
        $stmt->execute([':email' => $email, ':token' => $token]);
        return $stmt->rowCount() > 0;
    }


    public function forgotPassword($email, $token)
    {
        $stmt = $this->conn->prepare("UPDATE users SET token = :token WHERE email = :email");
        if ($stmt->execute([':token' => $token, ':email' => $email])) {
            return $this->sendPasswordReset($email, $token);
        }
        return false;
    }

    private function sendPasswordReset($email, $token)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = SMTP_PORT;

            $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Reset Your Password";
            $mail->Body = "Click the link below to reset your password:<br><br>
                           <a href='" . SITE_URL . "auth/user-resetpassword.php?email=$email&token=$token'>Reset Password</a>";

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }

    public function resetPassword($email, $token, $newPassword)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=:email AND token=:token");
        $stmt->execute([':email' => $email, ':token' => $token]);
        if ($stmt->rowCount() > 0) {
            $hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $update = $this->conn->prepare("UPDATE users SET password=:password, token='' WHERE email=:email");
            return $update->execute([':password' => $hashPassword, ':email' => $email]);
        }
        return false;
    }

    public function siteSecretKey()
    {
        return RECAPTCHA_SECRET_KEY;
    }
}
