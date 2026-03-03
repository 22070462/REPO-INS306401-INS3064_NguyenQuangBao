-- =============================================
-- A1COREUrgency - Student Ops: Build the Student Database
-- Script: a1_student_ops.sql
-- =============================================

-- 1. Tạo database với collation đúng yêu cầu
CREATE DATABASE IF NOT EXISTS `student_management_db`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- 2. Chọn database để tạo bảng
USE `student_management_db`;

-- 3. Tạo bảng classes
CREATE TABLE IF NOT EXISTS `classes` (
    `id`          INT AUTO_INCREMENT PRIMARY KEY,
    `class_name`  VARCHAR(255) NOT NULL,
    `department`  VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tạo bảng students (có FK đúng, email UNIQUE + NOT NULL)
CREATE TABLE IF NOT EXISTS `students` (
    `id`           INT AUTO_INCREMENT PRIMARY KEY,
    `student_code` VARCHAR(50) UNIQUE,
    `full_name`    VARCHAR(255),
    `email`        VARCHAR(255) UNIQUE NOT NULL,
    `age`          INT,
    `class_id`     INT,
    FOREIGN KEY (`class_id`) REFERENCES `classes`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Kiểm tra nhanh (không bắt buộc)
SHOW TABLES;
