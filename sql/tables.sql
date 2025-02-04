--
-- Table structure for table `feedback`
--

CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flight_id VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
