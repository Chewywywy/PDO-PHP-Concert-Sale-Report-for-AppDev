CREATE DATABASE IF NOT EXISTS concert_db;
USE concert_db;

DROP TABLE IF EXISTS ticket_purchases;
DROP TABLE IF EXISTS concerts;
DROP TABLE IF EXISTS customers;

-- Customers who buy tickets
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name   VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL UNIQUE,
    phone       VARCHAR(20)
);

-- Concerts that are being sold
CREATE TABLE concerts (
    concert_id   INT AUTO_INCREMENT PRIMARY KEY,
    artist_name  VARCHAR(100) NOT NULL,
    venue        VARCHAR(100) NOT NULL,
    concert_date DATE NOT NULL,
    ticket_price DECIMAL(10,2) NOT NULL,
    total_seats  INT NOT NULL
);

-- CONCERT TICKET PURCHASES TABLE (links customers and concerts)
CREATE TABLE ticket_purchases (
    purchase_id    INT AUTO_INCREMENT PRIMARY KEY,
    customer_id    INT NOT NULL,
    concert_id     INT NOT NULL,
    ticket_type    ENUM('General Admission','VIP','Balcony') NOT NULL,
    quantity       INT NOT NULL CHECK (quantity > 0),
    total_amount   DECIMAL(10,2) NOT NULL,
    payment_status ENUM('Pending','Paid','Cancelled') NOT NULL DEFAULT 'Pending',
    purchase_date  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (concert_id)  REFERENCES concerts(concert_id)  ON DELETE CASCADE
);

-- ---------- RECORDS ----------
INSERT INTO customers (full_name, email, phone) VALUES
('Juan Dela Cruz',  'juan@email.com',   '09171234567'),
('Maria Santos',    'maria@email.com',  '09181234567'),
('Pedro Reyes',     'pedro@email.com',  '09191234567'),
('Ana Garcia',      'ana@email.com',    '09201234567'),
('Luis Mendoza',    'luis@email.com',   '09211234567');

INSERT INTO concerts (artist_name, venue, concert_date, ticket_price, total_seats) VALUES
('Ben&Ben',       'SM Mall of Asia Arena', '2026-11-15', 2500.00, 15000),
('Taylor Swift',  'Philippine Arena',      '2026-12-05', 8500.00, 50000),
('Eraserheads',   'Araneta Coliseum',      '2026-11-28', 3200.00, 14000),
('SB19',          'New Frontier Theater',  '2026-12-20', 4000.00, 2000);

INSERT INTO ticket_purchases (customer_id, concert_id, ticket_type, quantity, total_amount, payment_status, purchase_date) VALUES
(1, 1, 'General Admission', 2, 5000.00,  'Paid',      '2026-09-01 10:15:00'),
(2, 2, 'VIP',               1, 8500.00,  'Paid',      '2026-09-03 14:30:00'),
(3, 3, 'Balcony',           4, 12800.00, 'Pending',   '2026-09-10 09:00:00'),
(4, 4, 'VIP',               2, 8000.00,  'Paid',      '2026-09-12 18:45:00'),
(5, 1, 'Balcony',           3, 7500.00,  'Cancelled', '2026-09-15 11:20:00'),
(1, 2, 'General Admission', 2, 17000.00, 'Pending',   '2026-09-18 16:05:00'),
(2, 4, 'General Admission', 5, 20000.00, 'Paid',      '2026-09-20 13:10:00');
