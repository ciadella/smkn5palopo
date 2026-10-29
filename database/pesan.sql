-- Database untuk menyimpan pesan dari form kontak (satu-satunya yang memakai database).
-- Import lewat HeidiSQL (File > Run SQL file) atau phpMyAdmin (tab Import).
CREATE DATABASE IF NOT EXISTS smkn_5_palopo CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE smkn_5_palopo;

CREATE TABLE IF NOT EXISTS tabel_pesan (
  id_pesan INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL,
  isi TEXT NOT NULL,
  dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
