-- =========================================================
-- Barangay Cansangaya Household Information System
-- Database Schema
-- =========================================================

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  username VARCHAR(60) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('ADMIN','STAFF') NOT NULL DEFAULT 'STAFF',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE households (
  id INT AUTO_INCREMENT PRIMARY KEY,
  household_no VARCHAR(40) NOT NULL UNIQUE,
  purok VARCHAR(60) NOT NULL,
  address VARCHAR(200) NOT NULL,
  head_name VARCHAR(120) NOT NULL,
  members_count INT NOT NULL DEFAULT 1,

  -- Profiling fields from your doc
  housing_type ENUM('Concrete','Semi-Concrete','Wood','Mixed','Other') DEFAULT 'Other',
  has_cr TINYINT(1) NOT NULL DEFAULT 0,
  water_access ENUM('Piped','Well','Refill','Other') DEFAULT 'Other',
  has_vehicle TINYINT(1) NOT NULL DEFAULT 0,

  -- Livelihood
  has_sari_sari TINYINT(1) NOT NULL DEFAULT 0,
  is_farmer TINYINT(1) NOT NULL DEFAULT 0,
  is_fisherfolk TINYINT(1) NOT NULL DEFAULT 0,

  -- Social sectors
  is_solo_parent TINYINT(1) NOT NULL DEFAULT 0,
  has_pwd_member TINYINT(1) NOT NULL DEFAULT 0,
  is_4ps_beneficiary TINYINT(1) NOT NULL DEFAULT 0,

  -- Social concern
  has_teen_pregnancy_case TINYINT(1) NOT NULL DEFAULT 0,

  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Demo admin user (password: admin123) - generate real hash in PHP later if you want
INSERT INTO users (full_name, username, password_hash, role) VALUES ('System Administrator', 'admin', '$2y$10$examplehashedpassword1234567890', 'ADMIN');

-- =========================================================
-- END OF SCHEMA
-- =========================================================