
-- phpMyAdmin SQL Dump
-- Improved version for perfume shop database
-- Compatible with MySQL 8.0+
-- Generated: 2025-05-26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- CHARACTER SET
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
 /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
 /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 /*!40101 SET NAMES utf8mb4 */;

-- DATABASE
CREATE DATABASE IF NOT EXISTS `perfume_store` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `perfume_store`;

-- TABLE: users
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABLE: perfumes
CREATE TABLE `perfumes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `fragrance` varchar(50),
  `size` varchar(20),
  `durability` varchar(20),
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int NOT NULL DEFAULT 0,
  `image` varchar(255),
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABLE: orders
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `status` enum('in procesare', 'confirmată', 'livrată', 'anulată') DEFAULT 'in procesare',
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABLE: order_items
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `perfume_id` int NOT NULL,
  `quantity` int DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `perfume_id` (`perfume_id`),
  CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_order_items_perfume` FOREIGN KEY (`perfume_id`) REFERENCES `perfumes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABLE: reviews
CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `perfume_id` int NOT NULL,
  `rating` int NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
  `comment` text,
  `review_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`perfume_id`) REFERENCES `perfumes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert admin user
INSERT INTO `users` (`username`, `email`, `password`, `role`) VALUES
('admin', 'admin@admin.com', '$2y$12$P4lOImyZnYQ2IEOT.5HjsOQogmdBKll2CNz57tAkAuKNnK.6LEgXK', 'admin');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
 /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
 /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Populare tabel perfumes cu date reale
INSERT INTO `perfumes` (`name`, `description`, `fragrance`, `size`, `durability`, `price`, `stock`, `image`) VALUES
('Chanel No. 5', 'Un parfum clasic floral cu note de iasomie și trandafir.', 'floral', '100ml', 'peste 8h', 499.99, 25, 'images/chanel_no5.jpg'),
('Dior Sauvage', 'Parfum bărbătesc intens cu bergamotă și ambroxan.', 'aromatic', '100ml', '7-9h', 420.00, 30, 'images/dior_sauvage.jpg'),
('Versace Eros', 'Note fresh și senzuale, inspirate de mitologia greacă.', 'fresh', '100ml', '6-8h', 379.99, 18, 'images/versace_eros.jpg'),
('YSL Libre', 'Parfum unisex cu lavandă și vanilie.', 'oriental', '90ml', 'până la 10h', 450.50, 20, 'images/ysl_libre.jpg'),
('Gucci Bloom', 'Parfum de damă floral, cu tuberoză și iasomie.', 'floral', '100ml', '6h+', 399.00, 12, 'images/gucci_bloom.jpg');


-- Inserare suplimentară parfumuri pentru tipuri variate de arome
INSERT INTO `perfumes` (`name`, `description`, `fragrance`, `size`, `durability`, `price`, `stock`, `image`) VALUES
('Tom Ford Oud Wood', 'Parfum oriental lemnos, sofisticat și intens.', 'woody', '100ml', 'peste 10h', 850.00, 10, 'images/tom_ford_oud_wood.jpg'),
('CK One', 'Aromă unisex fresh și citrică, ideală pentru zi.', 'citrus', '200ml', '4-6h', 280.00, 20, 'images/ck_one.jpg'),
('Armani Code', 'Parfum elegant pentru bărbați, cu tonuri de piele și tabac.', 'leather', '75ml', '8h+', 430.00, 15, 'images/armani_code.jpg'),
('Lancôme La Vie Est Belle', 'Note dulci și florale cu accente de vanilie.', 'sweet', '100ml', 'peste 8h', 510.00, 18, 'images/lancome_lavie.jpg'),
('Jo Malone Wood Sage & Sea Salt', 'Parfum fresh, marin, cu note sărate și lemnoase.', 'marine', '100ml', '4-6h', 570.00, 8, 'images/jo_malone_seasalt.jpg');


-- Populare parfumuri după criterii: aromă, mărime, durabilitate
INSERT INTO `perfumes` (`name`, `description`, `fragrance`, `size`, `durability`, `price`, `stock`, `image`) VALUES
-- Floral
('Chanel No. 5', 'Un parfum floral clasic cu note de iasomie și trandafir.', 'Floral', '100ml', '8 hours', 499.99, 25, 'images/chanel_no5.jpg'),
('Gucci Bloom', 'Parfum de damă cu tuberoză și iasomie.', 'Floral', '50ml', '6 hours', 379.99, 15, 'images/gucci_bloom.jpg'),
-- Citrus
('CK One', 'Parfum fresh unisex cu note citrice.', 'Citrus', '200ml', '5 hours', 280.00, 20, 'images/ck_one.jpg'),
-- Woody
('Tom Ford Oud Wood', 'Parfum lemnos sofisticat.', 'Woody', '100ml', '10 hours', 850.00, 10, 'images/tom_ford_oud_wood.jpg'),
-- Fresh
('Versace Eros', 'Parfum fresh și vibrant.', 'Fresh', '100ml', '6 hours', 389.99, 18, 'images/versace_eros.jpg'),
-- Musk
('Musk by Alyssa Ashley', 'Parfum cu mosc alb, potrivit pentru orice moment al zilei.', 'Musk', '75ml', '7 hours', 260.00, 8, 'images/musk_alyssa.jpg'),
-- Herbal
('Hermès Eau de Basilic Pourpre', 'Note verzi de busuioc proaspăt și ierburi.', 'Herbal', '100ml', '4 hours', 440.00, 6, 'images/hermes_basilic.jpg'),
-- Amber
('Prada Amber Pour Homme', 'Oriental-ambar, cu note lemnoase și vanilate.', 'Amber', '100ml', '12 hours', 520.00, 9, 'images/prada_amber.jpg'),
-- Gourmand
('Montale Chocolate Greedy', 'Parfum gurmand cu ciocolată, vanilie și cafea.', 'Gourmand', '50ml', '12+ hours', 610.00, 5, 'images/montale_chocolate.jpg');
