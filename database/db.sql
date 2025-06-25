CREATE DATABASE bus_ticket;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role TINYINT NOT NULL, -- 1 = admin, 2 = agent, 3 = customer
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


INSERT INTO users (full_name, email, phone, password, role)
VALUES ('Admin User', 'admin@example.com', '09171234567', SHA2('admin123', 256), 1);


CREATE TABLE buses (
    bus_id INT AUTO_INCREMENT PRIMARY KEY,
    bus_number VARCHAR(50) NOT NULL,
    capacity INT NOT NULL,
    type VARCHAR(50), -- e.g., AC, Non-AC
    status ENUM('Active', 'Inactive') DEFAULT 'Active'
);


CREATE TABLE routes (
    route_id INT AUTO_INCREMENT PRIMARY KEY,
    origin VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    distance_km DECIMAL(6,2),
    estimated_time TIME
);


CREATE TABLE routes (
    route_id INT AUTO_INCREMENT PRIMARY KEY,
    origin VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    distance_km DECIMAL(6,2),
    estimated_time TIME
);


CREATE TABLE trips (
    trip_id INT AUTO_INCREMENT PRIMARY KEY,
    bus_id INT,
    route_id INT,
    departure_date DATE NOT NULL,
    departure_time TIME NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    status ENUM('Scheduled', 'Cancelled', 'Completed') DEFAULT 'Scheduled',
    FOREIGN KEY (bus_id) REFERENCES buses(bus_id),
    FOREIGN KEY (route_id) REFERENCES routes(route_id)
);


CREATE TABLE seats (
    seat_id INT AUTO_INCREMENT PRIMARY KEY,
    bus_id INT,
    seat_number VARCHAR(10),
    FOREIGN KEY (bus_id) REFERENCES buses(bus_id)
);


CREATE TABLE tickets (
    ticket_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    trip_id INT,
    seat_number VARCHAR(10),
    booking_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Booked', 'Cancelled', 'Completed') DEFAULT 'Booked',
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (trip_id) REFERENCES trips(trip_id)
);


CREATE INDEX idx_trip_date ON trips(departure_date);
CREATE INDEX idx_user_email ON users(email);

