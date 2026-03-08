-- =========================================================
-- Barangay Cansangaya Household Information System
-- Database Setup
-- =========================================================

CREATE DATABASE IF NOT EXISTS bchis CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE bchis;

SET time_zone = '+08:00';

-- =========================================================
-- USERS TABLE
-- =========================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    username VARCHAR(60) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM ('ADMIN', 'STAFF') NOT NULL DEFAULT 'STAFF',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =========================================================
-- SECURITY QUESTIONS TABLE
-- Questions are stored per user
-- =========================================================
CREATE TABLE security_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    question VARCHAR(255) NOT NULL,
    answer_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_security_questions_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT uq_user_question
        UNIQUE (user_id, question)
);

CREATE INDEX idx_security_questions_user_id ON security_questions(user_id);

-- Demo Admin user (password: admin123)
INSERT INTO users (full_name, username, password_hash, role)
VALUES ('System Administrator', 'admin', '$2y$10$avell4wi0IzOscScWW8HW.ozWZnL.pkcpUnVpaSGlEd1f2B/OT27y', 'ADMIN');

-- Demo Staff user (password: staff123)
INSERT INTO users (full_name, username, password_hash, role)
VALUES ('Barangay Staff', 'staff', '$2y$10$cRLnC4R97XVT9A7Whi8HB.I2IgOr3BCTFCFr7o4DWXEjPQB1WcMee', 'STAFF');

-- Example security questions
INSERT INTO security_questions (user_id, question, answer_hash) VALUES
(1, 'What is your favorite color?', '$2y$10$examplehashedanswer1'),
(1, 'What is the name of your first pet?', '$2y$10$examplehashedanswer2'),
(2, 'What is your mother''s maiden name?', '$2y$10$examplehashedanswer3'),
(2, 'What was your first school?', '$2y$10$examplehashedanswer4');

-- =========================================================
-- END OF SCHEMA
-- =========================================================