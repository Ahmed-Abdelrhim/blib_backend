-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 15, 2023 at 05:38 PM
-- Server version: 8.0.34-0ubuntu0.20.04.1
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blip`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `company_id`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(54, 'test0001', 2, 'ibrahim1605025@miuegypt.edu.eg', '2023-09-18 08:51:50', '$2y$10$DcVJ2TcZq4gX0/QSey9r6.JqWdB6WmqZdqvW2NC4jUOHlmum/TLAO', NULL, '2023-08-31 10:02:22', '2023-09-18 08:51:50', NULL),
(66, 'nabil', 1, 'nabil@cairoterion.com', '2023-09-10 09:39:16', '$2y$10$iGaCOliM6cDUrBXZv19zGeWDoj4BQtKdEviXkClZZ6v3vRhaH4UcC', NULL, '2023-09-10 06:35:27', '2023-09-10 06:35:27', NULL),
(68, 'شسي', 5, 'hager.mazhar@gmail.com', '2023-09-17 14:22:01', '$2y$10$uoVVRs9FTYZ0BqXJJYziUus.Kgrn4Mg.s5WElMaDZSu/6eHUGxeii', NULL, '2023-09-17 14:13:18', '2023-09-17 14:22:01', NULL),
(69, 'ahmed', 6, 'ahmed@ahmed.com', '2023-09-17 14:14:06', '$2y$10$1Y/rR4X38cW/LiD9MSVwi.l39WSCLJ0eGhqeiGgT88kwVVVe4oGvy', NULL, '2023-09-17 14:13:40', '2023-09-17 14:14:06', NULL),
(70, 'test', 7, 'test@test.test', '2023-09-20 07:39:58', '$2y$10$swHtQmizaxbsrfCth5umUOTLKVmEuE5KtvSgx3cI0UqJ4sksBQ2em', NULL, '2023-09-20 07:39:01', '2023-09-20 07:39:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ceos`
--

CREATE TABLE `ceos` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `company_id`, `title`, `type`, `value`, `created_at`, `updated_at`) VALUES
(51, 1, 'male', 'gender', NULL, NULL, NULL),
(52, 1, 'female', 'gender', NULL, NULL, NULL),
(53, 1, 'Active Duty', 'military_status', NULL, NULL, NULL),
(54, 1, 'Postponed', 'military_status', NULL, NULL, NULL),
(55, 1, 'Reservist', 'military_status', NULL, NULL, NULL),
(56, 1, 'Exempted', 'military_status', NULL, NULL, NULL),
(57, 7, 'Male', 'gender', NULL, '2023-09-20 07:45:49', '2023-09-20 07:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `industry_id` bigint UNSIGNED NOT NULL,
  `plan_id` int NOT NULL,
  `is_imported` tinyint(1) NOT NULL DEFAULT '0',
  `import_excel_status` enum('pending','imported','invitations','skipped') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ceo_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `domain`, `logo`, `industry_id`, `plan_id`, `is_imported`, `import_excel_status`, `created_at`, `updated_at`, `deleted_at`, `ceo_id`) VALUES
(1, 'cairoterion', 'cairoterion.com', NULL, 2, 1, 0, 'skipped', NULL, '2023-09-18 09:37:44', NULL, NULL),
(2, 'test0001', 'miuegypt.edu.eg', NULL, 1, 1, 0, 'skipped', NULL, '2023-09-18 08:55:55', NULL, NULL),
(5, 'Hager', 'gmail.com', '', 2, 1, 1, 'skipped', '2023-09-17 14:13:18', '2023-09-17 14:31:17', NULL, NULL),
(6, 'ahmed', 'ahmed.com', '', 2, 1, 1, 'invitations', '2023-09-17 14:13:39', '2023-09-17 14:17:18', NULL, NULL),
(7, 'test', 'test.test', '', 1, 2, 1, 'skipped', '2023-09-20 07:39:01', '2023-09-20 07:44:54', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `title`, `description`, `company_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Department 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', 1, '2023-06-02 05:31:48', '2023-07-16 11:50:39', NULL),
(2, 'Department 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam', 1, '2023-06-02 05:31:48', '2023-06-08 05:39:48', NULL),
(266, 'COO', NULL, 2, '2023-08-31 10:25:23', '2023-10-15 09:19:24', NULL),
(267, 'Tech', NULL, 2, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL),
(268, 'Business', NULL, 2, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL),
(269, 'HR', NULL, 2, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL),
(270, 'Traffc', NULL, 2, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL),
(271, 'Management', NULL, 2, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL),
(277, 'Tech', NULL, 1, '2023-09-14 04:58:32', '2023-09-14 04:58:32', NULL),
(278, 'software', NULL, 6, '2023-09-17 14:17:16', '2023-09-17 14:17:16', NULL),
(279, 'Software Team', NULL, 6, '2023-09-17 14:17:16', '2023-09-17 14:17:16', NULL),
(280, 'Tech', NULL, 7, '2023-09-20 07:44:50', '2023-09-20 07:44:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department_titles`
--

CREATE TABLE `department_titles` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joined_at` date DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `reports_to_id` bigint UNSIGNED DEFAULT NULL,
  `temp_reports_to_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender_id` bigint UNSIGNED DEFAULT NULL,
  `military_status_id` bigint UNSIGNED DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` double(8,2) DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EGP',
  `work_hours` enum('Full Time','Part Time','Fully Remotely','Part Time Remotely','Casual','Fixed Term Contract','Apprenticeship','Internship') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Full Time',
  `is_important` tinyint(1) NOT NULL DEFAULT '0',
  `is_personal_information_complete` tinyint(1) NOT NULL DEFAULT '0',
  `is_work_information_complete` tinyint(1) NOT NULL DEFAULT '0',
  `is_vacations_complete` tinyint(1) NOT NULL DEFAULT '0',
  `is_first_time` tinyint(1) NOT NULL DEFAULT '1',
  `is_complete` tinyint(1) NOT NULL DEFAULT '0',
  `vacation_activate_at` date DEFAULT NULL,
  `vacation_expire_carry_at` date DEFAULT NULL,
  `vacation_first_approval_id` bigint UNSIGNED DEFAULT NULL,
  `vacation_second_approval_id` bigint UNSIGNED DEFAULT NULL,
  `vacation_annual_days` int NOT NULL DEFAULT '0',
  `vacation_carry_days` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `company_id`, `name`, `email`, `title`, `joined_at`, `password`, `phone`, `country_code`, `date_of_birth`, `department_id`, `reports_to_id`, `temp_reports_to_email`, `role_id`, `image`, `banner`, `description`, `bio`, `gender_id`, `military_status_id`, `country`, `address`, `salary`, `currency`, `work_hours`, `is_important`, `is_personal_information_complete`, `is_work_information_complete`, `is_vacations_complete`, `is_first_time`, `is_complete`, `vacation_activate_at`, `vacation_expire_carry_at`, `vacation_first_approval_id`, `vacation_second_approval_id`, `vacation_annual_days`, `vacation_carry_days`, `created_at`, `updated_at`, `deleted_at`, `deleted_by_id`) VALUES
(1, 1, 'Dr. Chester McCullough', 'mosciski.eric@cairoterion.com', 'CEO', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-05-31 21:00:00', '2023-07-27 10:42:06', NULL, NULL),
(2, 1, 'Prof. Agnes Hauck', 'tillman.dagmar@cairoterion.com', 'Head', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-06-01 21:00:00', '2023-07-16 08:47:48', NULL, NULL),
(3, 1, 'Kaia Leuschke IV', 'cheyanne88@cairoterion.com', 'Senior', '2023-07-01', NULL, '125225335', 'eg', '2006-11-15', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, 51, NULL, 'EG', NULL, 10000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-06-02 21:00:00', '2023-07-27 10:32:42', NULL, NULL),
(4, 1, 'Miss Jailyn Gleichner III', 'walsh.lola@cairoterion.com', 'Senior', NULL, NULL, NULL, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-06-08 05:39:48', '2023-07-16 10:07:53', NULL, NULL),
(5, 1, 'Dr. Danny Roob IV', 'marcella.rempel@cairoterion.com', 'Senior', '2023-06-01', NULL, '1129886336', 'eg', '1999-07-21', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, 51, NULL, 'AF', NULL, 10000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-06-08 05:39:48', '2023-07-16 10:07:29', NULL, NULL),
(6, 1, 'Marcella', 'rempel@cairoterion.com', 'Senior', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-06-08 05:39:48', '2023-07-16 08:53:31', NULL, NULL),
(7, 1, 'Jay Cassin', 'klein.evangeline@cairoterion.com', 'Junior', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-06-08 05:39:48', '2023-07-16 10:08:52', NULL, NULL),
(665, 2, 'Tarek Kadour', 'tarek@miuegypt.edu.eg', 'COO', NULL, NULL, NULL, NULL, NULL, 266, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-08-31 10:25:23', '2023-10-15 09:19:24', NULL, NULL),
(666, 2, 'Ahmed Mamdouh', 'mamdouh@miuegypt.edu.eg', 'Sr. Front End Developer', NULL, NULL, NULL, NULL, NULL, 267, 665, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL, NULL),
(667, 2, 'Paula Adel', 'paula@miuegypt.edu.eg', 'Sr. Front End Developer', NULL, NULL, NULL, NULL, NULL, 267, 666, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL, NULL),
(668, 2, 'Abdelrahman Shaaban', 'abdelrahman@miuegypt.edu.eg', 'Sr. Front End Developer', NULL, NULL, NULL, NULL, NULL, 267, 666, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL, NULL),
(669, 2, 'Nader Mazhar', 'nader@miuegypt.edu.eg', 'Business Manager', NULL, NULL, NULL, NULL, NULL, 268, 665, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL, NULL),
(670, 2, 'Mariam Diaa', 'mariam@miuegypt.edu.eg', 'HR Manager', NULL, NULL, NULL, NULL, NULL, 269, 665, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL, NULL),
(671, 2, 'Wael Hassan', 'wael@miuegypt.edu.eg', 'Traffic Manager', NULL, NULL, NULL, NULL, NULL, 270, 665, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL, NULL),
(672, 2, 'Muhmed Salah', 'salah@miuegypt.edu.eg', 'Project Manager', NULL, NULL, NULL, NULL, NULL, 271, 665, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL, NULL),
(673, 2, 'Duha Ayman', 'duha@miuegypt.edu.eg', 'Project Manager', NULL, NULL, NULL, NULL, NULL, 271, 665, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-08-31 10:25:23', '2023-08-31 10:25:23', NULL, NULL),
(689, 1, 'Ahmed mokhtar', 'ahmed@cairoterion.com', 'Front End', NULL, NULL, NULL, NULL, NULL, 277, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-14 05:27:59', '2023-09-14 05:27:59', NULL, NULL),
(690, 1, 'Ayman ali', 'ayman@cairoterion.com', 'Junior Front End', NULL, NULL, NULL, NULL, NULL, 277, 689, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-14 05:27:59', '2023-09-14 05:27:59', NULL, NULL),
(691, 1, 'mohamed', 'mohamed@cairoterion.com', 'Back End', NULL, NULL, NULL, NULL, NULL, 277, 689, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-14 05:27:59', '2023-09-14 05:27:59', NULL, NULL),
(692, 1, 'Gamal', 'gamal@cairoterion.com', 'Tester', NULL, NULL, NULL, NULL, NULL, 277, 691, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-14 05:27:59', '2023-09-14 05:27:59', NULL, NULL),
(693, 6, 'ahmed Mamdouh Ahmed ', 'ahmed11@ahmed.com', 'frontend frontend', NULL, '$2y$10$teG2SrN58MwkNf1jCFjv.O6B4SyvO/bJjMUyZTCuOStdZSG1hcB5.', NULL, NULL, NULL, 278, NULL, 'ahmed@ahmed.com', NULL, NULL, NULL, 'description', NULL, NULL, NULL, NULL, NULL, 1000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-17 14:17:16', '2023-09-17 14:17:20', NULL, NULL),
(694, 6, 'abdo', 'abdo@ahmed.com', 'frontend frontend', NULL, '$2y$10$FCobwHDpYf7FJurArmaNrO/RTwN43ITo4jq8FcQCZYMRmizMwN812', NULL, NULL, NULL, 278, NULL, 'ahmed@ahmed.com', NULL, NULL, NULL, 'description', NULL, NULL, NULL, NULL, NULL, 1000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-17 14:17:16', '2023-09-17 14:17:21', NULL, NULL),
(695, 6, 'pola frontend frontend1', 'pola@ahmed.com', 'frontend frontend', NULL, '$2y$10$yE5aJTyks71e6KpeXJL0NON9T2ww7C.zoj1lHZIXdaVmCqpVyu.5u', NULL, NULL, NULL, 278, NULL, 'ahmed@ahmed.com', NULL, NULL, NULL, 'description', NULL, NULL, NULL, NULL, NULL, 1000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-17 14:17:16', '2023-09-17 14:17:21', NULL, NULL),
(696, 6, 'pola frontend frontend', 'pola1@ahmed.com', 'frontend frontend', NULL, '$2y$10$Zvr8BHQIxa3pckiVKQpvI.0exAr3JIQqsduZagAhliA2bVLj319Ii', NULL, NULL, NULL, 278, NULL, 'ahmed@ahmed.com', NULL, NULL, NULL, 'description', NULL, NULL, NULL, NULL, NULL, 1000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-17 14:17:16', '2023-09-17 14:17:21', NULL, NULL),
(697, 6, 'ahmed Mamdouh1', 'ahmed1@ahmed.com', 'frontend frontend', NULL, '$2y$10$h6..6o7TJRyUA.sq8VEMju9mdFiDuwLOmFugbVzsZXUUrqFIHHBxq', NULL, NULL, NULL, 279, NULL, 'ahmed@ahmed.com', NULL, NULL, NULL, 'description', NULL, NULL, NULL, NULL, NULL, 1000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-17 14:17:16', '2023-09-17 14:17:22', NULL, NULL),
(698, 6, 'abdo 1', 'abdo1@ahmed.com', 'frontend frontend', NULL, '$2y$10$mnFBKKCYKw.WA7yeqPL6ZOOdB.aKP90f4oOcg9IcJmRWppVcM9Gtq', NULL, NULL, NULL, 279, NULL, 'ahmed@ahmed.com', NULL, NULL, NULL, 'description', NULL, NULL, NULL, NULL, NULL, 1000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-17 14:17:16', '2023-09-17 14:17:22', NULL, NULL),
(699, 6, 'pola frontend frontend3', 'pola2@ahmed.com', 'frontend frontend', NULL, '$2y$10$Y60WFXwvjbThFvAAMA9wu.gKcV.GYEjPuAzY2Sc4TbxiCpNv32EZK', NULL, NULL, NULL, 279, NULL, 'ahmed@ahmed.com', NULL, NULL, NULL, 'description', NULL, NULL, NULL, NULL, NULL, 1000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-17 14:17:16', '2023-09-17 14:17:22', NULL, NULL),
(700, 6, 'abdo2', 'abdo2@ahmed.com', 'frontend frontend', NULL, '$2y$10$8S.KijwIvAcHYryyNZCIteQMg4FIHVP1o9Z2twCjo2ZyB5t8uAniu', NULL, NULL, NULL, 279, NULL, 'ahmed@ahmed.com', NULL, NULL, NULL, 'description', NULL, NULL, NULL, NULL, NULL, 1000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-17 14:17:16', '2023-09-17 14:17:23', NULL, NULL),
(701, 7, 'Ahmed mokhtar', 'ahmed@test.test', 'Front Enddd', NULL, NULL, NULL, NULL, NULL, 280, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-20 07:44:50', '2023-09-20 07:44:50', NULL, NULL),
(702, 7, 'Ayman ali', 'ayman@test.test', 'Junior Front End', NULL, NULL, NULL, NULL, NULL, 280, 701, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5000.00, 'EGP', 'Full Time', 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, 0, '2023-09-20 07:44:50', '2023-09-20 07:44:50', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_equipment`
--

CREATE TABLE `employee_equipment` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `equipment_id` bigint UNSIGNED NOT NULL,
  `taken_at` date DEFAULT NULL,
  `returned_at` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `in_use_by` bigint UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

CREATE TABLE `industries` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `industries`
--

INSERT INTO `industries` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Advertising', NULL, NULL),
(2, 'Software Engineering', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_03_27_113322_create_employees_table', 1),
(6, '2023_03_27_113957_create_companies_table', 1),
(7, '2023_03_27_114117_create_industries_table', 1),
(8, '2023_03_27_114123_create_plans_table', 1),
(9, '2023_03_27_114331_create_departments_table', 1),
(10, '2023_03_28_113638_rename_users_table', 1),
(11, '2023_04_02_092834_add_company_id_to_admins', 1),
(12, '2023_04_02_133725_create_otps_table', 1),
(13, '2023_04_09_105207_create_jobs_table', 1),
(14, '2023_06_14_120732_create_cms_table', 1),
(15, '2023_07_11_102354_add_deleted_by_to_employees_table', 1),
(16, '2023_07_16_113622_add_import_excel_status_to_companies_table', 1),
(17, '2023_09_12_115844_update_foriegn_keys_columns_in_all_tables', 1),
(18, '2023_09_13_110854_add_soft_delete_for_tables', 1),
(19, '2023_09_14_113250_add_ceo_id_field_to_companies_table', 1),
(20, '2023_03_27_114409_create_department_titles_table', 2),
(21, '2023_03_27_114457_create_salaries_table', 2),
(22, '2023_09_14_102049_create_ceos_table', 2),
(23, '2023_09_20_093248_update_employees_table', 3),
(24, '2023_09_20_120437_create_vacations_table', 4),
(25, '2023_09_20_124019_create_equipments_table', 4),
(26, '2023_09_20_134410_create_employee_equipment_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` bigint UNSIGNED NOT NULL,
  `type` int NOT NULL,
  `otp` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `type`, `otp`, `email`, `attempts`, `created_at`, `updated_at`) VALUES
(15, 1, 893487, 'test@testo.com', 0, '2023-07-16 09:46:05', '2023-07-16 09:46:05'),
(16, 1, 814953, 'test@tosto.com', 0, '2023-07-16 09:49:22', '2023-07-16 09:49:22'),
(31, 1, 373019, 'paula@xxx.com', 0, '2023-07-16 13:55:39', '2023-07-16 13:55:39'),
(32, 1, 644626, 'paula@ooo.com', 0, '2023-07-16 13:57:34', '2023-07-16 13:57:34'),
(40, 1, 299295, 'Create@Create.com', 0, '2023-07-16 14:53:47', '2023-07-16 14:53:47'),
(45, 1, 271620, 'Bob@test01.com', 0, '2023-08-13 15:04:15', '2023-08-13 15:04:15'),
(46, 1, 212778, 'Bob@test02.com', 0, '2023-08-13 15:06:18', '2023-08-13 15:06:18'),
(47, 1, 220175, 'Bob@test03.com', 0, '2023-08-13 15:12:47', '2023-08-13 15:12:47'),
(48, 1, 731752, 'Bob@test04.com', 0, '2023-08-13 15:18:31', '2023-08-13 15:18:31'),
(49, 1, 917905, 'Bob@test06.com', 0, '2023-08-13 15:23:55', '2023-08-13 15:23:55'),
(50, 1, 487136, 'Bob@test07.com', 0, '2023-08-13 15:28:04', '2023-08-13 15:28:04'),
(51, 1, 664797, 'Bob@test08.com', 0, '2023-08-13 15:30:32', '2023-08-13 15:30:32'),
(52, 1, 865997, 'Bob@test09.com', 0, '2023-08-13 15:39:11', '2023-08-13 15:39:11'),
(53, 1, 403531, 'Bob@test10.com', 0, '2023-08-13 15:40:42', '2023-08-13 15:40:42'),
(54, 1, 672817, 'Bob@test11.com', 0, '2023-08-13 15:44:56', '2023-08-13 15:44:56'),
(55, 1, 254916, 'Bob@test12.com', 0, '2023-08-13 15:59:58', '2023-08-13 15:59:58'),
(56, 1, 495569, '123@testtest.com', 1, '2023-08-14 10:37:59', '2023-08-14 10:38:10'),
(74, 1, 335344, 'test24@test24.com', 0, '2023-08-15 13:02:01', '2023-08-15 13:02:01'),
(75, 1, 947205, 'moh@d.com', 1, '2023-08-15 13:26:01', '2023-08-15 13:26:08'),
(142, 1, 214413, 'embaby@embaby.embaby', 0, '2023-09-05 10:03:43', '2023-09-05 10:03:43'),
(143, 1, 906693, 'embabyx@embabyx.embabyx', 0, '2023-09-05 10:54:46', '2023-09-05 10:54:46'),
(144, 1, 794309, 'embabyxx@embabyxx.embabyxx', 0, '2023-09-05 10:55:26', '2023-09-05 10:55:26'),
(145, 1, 162805, 'embabyxx@haha.com', 0, '2023-09-05 10:56:40', '2023-09-05 10:56:40'),
(146, 1, 489383, 'emsbabyxx@hsaha.com', 0, '2023-09-05 11:02:58', '2023-09-05 11:02:58'),
(157, 1, 810051, 'nabil@cairoterion.com', 0, '2023-09-10 09:35:27', '2023-09-10 09:35:27'),
(158, 1, 331640, 'asd@asd3.asdasd', 0, '2023-09-17 14:01:08', '2023-09-17 14:01:08');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Admin', 67, 'API TOKEN', '0cd0670073eee21992a54ee48a515aa05131c13caafaaac005cb472c6533e3a9', '[\"otp\"]', NULL, NULL, '2023-09-17 14:01:10', '2023-09-17 14:01:10'),
(2, 'App\\Models\\Admin', 68, 'API TOKEN', '86adab2daf86c4c1df019c1f2fcfc2d0966b4131b7b4644ad3c69a0c92991ff5', '[\"otp\"]', NULL, NULL, '2023-09-17 14:13:19', '2023-09-17 14:13:19'),
(3, 'App\\Models\\Admin', 69, 'API TOKEN', '7749392f77bda0a0b563a8a4d9643a7e3c166833003d81e20eb779c400a48eef', '[\"otp\"]', '2023-09-17 14:14:06', NULL, '2023-09-17 14:13:41', '2023-09-17 14:14:06'),
(4, 'App\\Models\\Admin', 69, 'API TOKEN', '23edc96efab4368d40a6dcc5878388e445fdc644e0128e5f4291d5805913d641', '[\"admin\"]', '2023-09-17 14:41:09', NULL, '2023-09-17 14:14:06', '2023-09-17 14:41:09'),
(5, 'App\\Models\\Admin', 68, 'API TOKEN', 'c03b5a0ba62b8608647e852bb77e73253163296b7ee09869f12fdc060c3efce2', '[\"otp\"]', '2023-09-17 14:22:01', NULL, '2023-09-17 14:21:45', '2023-09-17 14:22:01'),
(6, 'App\\Models\\Admin', 68, 'API TOKEN', '15d1224b4a847236380f53b8bb468ccc8e3aa1014fb999e3d13f3f1fb04a5316', '[\"admin\"]', '2023-09-17 14:36:22', NULL, '2023-09-17 14:22:01', '2023-09-17 14:36:22'),
(7, 'App\\Models\\Admin', 69, 'API TOKEN', '0588548ff7dcf69c15e211be9fa6af2ea8bd2864cb2b6f992e63c0f043056940', '[\"admin\"]', '2023-09-25 08:32:57', NULL, '2023-09-18 08:48:07', '2023-09-25 08:32:57'),
(8, 'App\\Models\\Admin', 54, 'API TOKEN', '3678be748cd10713d3febd57b25df01e1c3c172235fd8d0785a1219f76dd6a41', '[\"otp\"]', '2023-09-18 08:51:50', NULL, '2023-09-18 08:49:26', '2023-09-18 08:51:50'),
(9, 'App\\Models\\Admin', 54, 'API TOKEN', 'dce9a8282a7e1e8ea621775bdabf44ea047c10a4eb8775b570cb25bfce01e7b4', '[\"admin\"]', '2023-09-18 08:51:59', NULL, '2023-09-18 08:51:50', '2023-09-18 08:51:59'),
(10, 'App\\Models\\Admin', 54, 'API TOKEN', '42979bafc2797b21dd406559208ecd9224e5e997b114358d2bcb788c3afff5b7', '[\"admin\"]', '2023-10-15 09:19:28', NULL, '2023-09-18 08:55:50', '2023-10-15 09:19:28'),
(11, 'App\\Models\\Admin', 66, 'API TOKEN', '4ce59316bd3d9a3528f502764dd960c82cb7316f00cc0e0643ca365edbf862f7', '[\"admin\"]', '2023-09-26 12:19:42', NULL, '2023-09-18 09:37:38', '2023-09-26 12:19:42'),
(12, 'App\\Models\\Admin', 70, 'API TOKEN', '8bb27d4dc5a7d34bbe8f877875ecca3b9e6cd841263dd209959d3ab669a3b60e', '[\"otp\"]', '2023-09-20 07:39:58', NULL, '2023-09-20 07:39:03', '2023-09-20 07:39:58'),
(13, 'App\\Models\\Admin', 70, 'API TOKEN', 'd47f061414b555d2dd7c741ea87cf96956286ca89c196eab9ec6b5caf36a73ab', '[\"admin\"]', '2023-09-20 07:49:47', NULL, '2023-09-20 07:39:58', '2023-09-20 07:49:47'),
(14, 'App\\Models\\Admin', 66, 'API TOKEN', 'c06781a5d596e3d711b3d0e61dec807753ccbc2b11bf709cb40fe09f2994257e', '[\"admin\"]', '2023-09-20 09:25:04', NULL, '2023-09-20 09:20:48', '2023-09-20 09:25:04'),
(15, 'App\\Models\\Admin', 66, 'API TOKEN', '07628131615906242294739939b34a74ad87326a8c324c41ddbd181f1b60cb8b', '[\"admin\"]', '2023-09-20 10:59:57', NULL, '2023-09-20 10:50:52', '2023-09-20 10:59:57');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint UNSIGNED NOT NULL,
  `min_employees` int NOT NULL,
  `max_employees` int NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_free` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `min_employees`, `max_employees`, `description`, `is_free`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 10, 'test', 1, '2023-04-03 12:04:28', '2023-04-03 12:04:28', NULL),
(2, 11, 50, 'test', 0, '2023-04-03 12:04:45', '2023-04-03 12:04:45', NULL),
(3, 51, 100, 'test', 0, '2023-04-03 12:05:03', '2023-04-03 12:05:03', NULL),
(4, 101, 300, 'test', 0, '2023-04-03 12:05:11', '2023-04-03 12:05:11', NULL),
(5, 301, 500, 'test', 0, '2023-04-03 12:05:21', '2023-04-03 12:05:21', NULL),
(6, 15, 30, 'asdasd', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` int NOT NULL,
  `salary` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vacations`
--

CREATE TABLE `vacations` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `first_approval_status` tinyint(1) DEFAULT NULL,
  `second_approval_status` tinyint(1) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `admins_company_id_foreign` (`company_id`);

--
-- Indexes for table `ceos`
--
ALTER TABLE `ceos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ceos_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cms_company_id_foreign` (`company_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_industry_id_foreign` (`industry_id`),
  ADD KEY `companies_ceo_id_foreign` (`ceo_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_company_id_foreign` (`company_id`);

--
-- Indexes for table `department_titles`
--
ALTER TABLE `department_titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_company_id_foreign` (`company_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`),
  ADD KEY `employees_reports_to_id_foreign` (`reports_to_id`),
  ADD KEY `employees_gender_id_foreign` (`gender_id`),
  ADD KEY `employees_military_status_id_foreign` (`military_status_id`),
  ADD KEY `employees_vacation_first_approval_id_foreign` (`vacation_first_approval_id`),
  ADD KEY `employees_vacation_second_approval_id_foreign` (`vacation_second_approval_id`);

--
-- Indexes for table `employee_equipment`
--
ALTER TABLE `employee_equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_equipment_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_equipment_equipment_id_foreign` (`equipment_id`);

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipments_serial_number_unique` (`serial_number`),
  ADD KEY `equipments_company_id_foreign` (`company_id`),
  ADD KEY `equipments_category_id_foreign` (`category_id`),
  ADD KEY `equipments_in_use_by_foreign` (`in_use_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `industries`
--
ALTER TABLE `industries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vacations`
--
ALTER TABLE `vacations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vacations_employee_id_foreign` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `ceos`
--
ALTER TABLE `ceos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT for table `department_titles`
--
ALTER TABLE `department_titles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=703;

--
-- AUTO_INCREMENT for table `employee_equipment`
--
ALTER TABLE `employee_equipment`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `industries`
--
ALTER TABLE `industries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vacations`
--
ALTER TABLE `vacations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ceos`
--
ALTER TABLE `ceos`
  ADD CONSTRAINT `ceos_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cms`
--
ALTER TABLE `cms`
  ADD CONSTRAINT `cms_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_ceo_id_foreign` FOREIGN KEY (`ceo_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `companies_industry_id_foreign` FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `employees_gender_id_foreign` FOREIGN KEY (`gender_id`) REFERENCES `cms` (`id`),
  ADD CONSTRAINT `employees_military_status_id_foreign` FOREIGN KEY (`military_status_id`) REFERENCES `cms` (`id`),
  ADD CONSTRAINT `employees_reports_to_id_foreign` FOREIGN KEY (`reports_to_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `employees_vacation_first_approval_id_foreign` FOREIGN KEY (`vacation_first_approval_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `employees_vacation_second_approval_id_foreign` FOREIGN KEY (`vacation_second_approval_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employee_equipment`
--
ALTER TABLE `employee_equipment`
  ADD CONSTRAINT `employee_equipment_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `employee_equipment_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`);

--
-- Constraints for table `equipments`
--
ALTER TABLE `equipments`
  ADD CONSTRAINT `equipments_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `cms` (`id`),
  ADD CONSTRAINT `equipments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `equipments_in_use_by_foreign` FOREIGN KEY (`in_use_by`) REFERENCES `employees` (`id`);

--
-- Constraints for table `vacations`
--
ALTER TABLE `vacations`
  ADD CONSTRAINT `vacations_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
