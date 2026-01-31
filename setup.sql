CREATE DATABASE IF NOT EXISTS contest_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE contest_db;

CREATE TABLE IF NOT EXISTS registrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  national_id VARCHAR(20) NOT NULL,
  email VARCHAR(190) NOT NULL,
  city VARCHAR(80) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(60) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- AR: أدمن افتراضي | EN: default admin | SA: أدمن جاهز
INSERT IGNORE INTO admins (username, password_hash)
VALUES ('admin', '$2y$10$0m9gKq6v8n2Qv7m0l1X6vO3hZJ7m9K1d9wqJm3v8pTg5lYtQvS2x2');
