-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 05, 2025 at 10:09 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skoolpilot2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('skoolpilot-cache-boost.roster.scan', 'a:2:{s:6:\"roster\";O:21:\"Laravel\\Roster\\Roster\":3:{s:13:\"\0*\0approaches\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"\0*\0packages\";O:32:\"Laravel\\Roster\\PackageCollection\":2:{s:8:\"\0*\0items\";a:7:{i:0;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^12.0\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:LARAVEL\";s:14:\"\0*\0packageName\";s:17:\"laravel/framework\";s:10:\"\0*\0version\";s:7:\"12.40.2\";s:6:\"\0*\0dev\";b:0;}i:1;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"v0.3.8\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PROMPTS\";s:14:\"\0*\0packageName\";s:15:\"laravel/prompts\";s:10:\"\0*\0version\";s:5:\"0.3.8\";s:6:\"\0*\0dev\";b:0;}i:2;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:1:\"*\";s:10:\"\0*\0package\";E:38:\"Laravel\\Roster\\Enums\\Packages:LIVEWIRE\";s:14:\"\0*\0packageName\";s:17:\"livewire/livewire\";s:10:\"\0*\0version\";s:5:\"3.7.1\";s:6:\"\0*\0dev\";b:0;}i:3;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:0;s:13:\"\0*\0constraint\";s:6:\"v0.3.4\";s:10:\"\0*\0package\";E:33:\"Laravel\\Roster\\Enums\\Packages:MCP\";s:14:\"\0*\0packageName\";s:11:\"laravel/mcp\";s:10:\"\0*\0version\";s:5:\"0.3.4\";s:6:\"\0*\0dev\";b:1;}i:4;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.24\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:PINT\";s:14:\"\0*\0packageName\";s:12:\"laravel/pint\";s:10:\"\0*\0version\";s:6:\"1.26.0\";s:6:\"\0*\0dev\";b:1;}i:5;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:5:\"^1.41\";s:10:\"\0*\0package\";E:34:\"Laravel\\Roster\\Enums\\Packages:SAIL\";s:14:\"\0*\0packageName\";s:12:\"laravel/sail\";s:10:\"\0*\0version\";s:6:\"1.48.1\";s:6:\"\0*\0dev\";b:1;}i:6;O:22:\"Laravel\\Roster\\Package\":6:{s:9:\"\0*\0direct\";b:1;s:13:\"\0*\0constraint\";s:7:\"^11.5.3\";s:10:\"\0*\0package\";E:37:\"Laravel\\Roster\\Enums\\Packages:PHPUNIT\";s:14:\"\0*\0packageName\";s:15:\"phpunit/phpunit\";s:10:\"\0*\0version\";s:7:\"11.5.45\";s:6:\"\0*\0dev\";b:1;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:21:\"\0*\0nodePackageManager\";E:43:\"Laravel\\Roster\\Enums\\NodePackageManager:NPM\";}s:9:\"timestamp\";i:1764833197;}', 1764919597);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
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
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_04_063906_create_schools_table', 2),
(5, '2025_12_05_050206_create_subscription_plans_table', 3),
(6, '2025_12_05_051335_add_additional_fields_to_subscription_plans_table', 4),
(7, '2025_12_05_071347_create_teachers_table', 5),
(8, '2025_12_05_073454_create_students_table', 6),
(9, '2025_12_05_085002_create_staff_table', 7);

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
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `subscription_plan_id` bigint UNSIGNED NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `email`, `phone`, `address`, `logo`, `theme_color`, `status`, `subscription_plan_id`, `trial_ends_at`, `created_at`, `updated_at`) VALUES
(3, 'Green Valley School', 'green1@example.com', '9876500011', 'Address 1', 'logo1.png', '#3B82F6', 1, 1, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(4, 'Sunrise Public School', 'sun2@example.com', '9876500012', 'Address 2', 'logo2.png', '#10B981', 0, 2, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(5, 'Modern Academy', 'modern3@example.com', '9876500013', 'Address 3', 'logo3.png', '#F59E0B', 2, 3, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(6, 'Silver Oak School', 'oak4@example.com', '9876500014', 'Address 4', 'logo4.png', '#3B82F6', 1, 1, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(7, 'Little Angels School', 'angel5@example.com', '9876500015', 'Address 5', 'logo5.png', '#10B981', 0, 2, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(8, 'Bright Future School', 'bright6@example.com', '9876500016', 'Address 6', 'logo6.png', '#F59E0B', 2, 3, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(9, 'Royal International School', 'royal7@example.com', '9876500017', 'Address 7', 'logo7.png', '#3B82F6', 1, 1, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(10, 'Horizon Public School', 'horizon8@example.com', '9876500018', 'Address 8', 'logo8.png', '#10B981', 0, 2, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(11, 'Oxford High School', 'ox9@example.com', '9876500019', 'Address 9', 'logo9.png', '#F59E0B', 2, 3, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(12, 'St. Mary School', 'mary10@example.com', '9876500020', 'Address 10', 'logo10.png', '#3B82F6', 1, 1, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(13, 'National Public School', 'nps11@example.com', '9876500021', 'Address 11', 'logo11.png', '#10B981', 0, 2, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(14, 'Crescent School', 'crescent12@example.com', '9876500022', 'Address 12', 'logo12.png', '#F59E0B', 2, 3, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(15, 'Everest Academy', 'everest13@example.com', '9876500023', 'Address 13', 'logo13.png', '#3B82F6', 1, 1, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(16, 'Blue Bells School', 'bells14@example.com', '9876500024', 'Address 14', 'logo14.png', '#10B981', 0, 2, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(17, 'Apple Tree School', 'apple15@example.com', '9876500025', 'Address 15', 'logo15.png', '#F59E0B', 2, 3, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(18, 'Global Public School', 'global16@example.com', '9876500026', 'Address 16', 'logo16.png', '#3B82F6', 1, 1, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(19, 'Star Academy', 'star17@example.com', '9876500027', 'Address 17', 'logo17.png', '#10B981', 0, 2, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(20, 'Hill Top School', 'hill18@example.com', '9876500028', 'Address 18', 'logo18.png', '#F59E0B', 2, 3, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(21, 'St. Xavier School', 'xavier19@example.com', '9876500029', 'Address 19', 'logo19.png', '#3B82F6', 1, 1, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(22, 'City Model School', 'city20@example.com', '9876500030', 'Address 20', 'logo20.png', '#10B981', 0, 2, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(23, 'Future Kids School', 'kids21@example.com', '9876500031', 'Address 21', 'logo21.png', '#F59E0B', 2, 3, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(24, 'Elite Public School', 'elite22@example.com', '9876500032', 'Address 22', 'logo22.png', '#3B82F6', 1, 1, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(25, 'Heritage School', 'heritage23@example.com', '9876500033', 'Address 23', 'logo23.png', '#10B981', 0, 2, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(26, 'New Era School', 'era24@example.com', '9876500034', 'Address 24', 'logo24.png', '#F59E0B', 2, 3, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(27, 'Happy Kids School', 'happy25@example.com', '9876500035', 'Address 25', 'logo25.png', '#3B82F6', 1, 1, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(28, 'Vision Public School', 'vision26@example.com', '9876500036', 'Address 26', 'logo26.png', '#10B981', 0, 2, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(29, 'EduCare School', 'educare27@example.com', '9876500037', 'Address 27', 'logo27.png', '#F59E0B', 2, 3, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(30, 'Galaxy Public School', 'galaxy28@example.com', '9876500038', 'Address 28', 'logo28.png', '#3B82F6', 1, 1, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(31, 'Shining Star School', 'shine29@example.com', '9876500039', 'Address 29', 'logo29.png', '#10B981', 0, 2, NULL, '2025-12-04 08:59:42', '2025-12-04 08:59:42'),
(32, 'Smart Kids Academy', 'smart30@example.com', '9876500040', 'Address 30', 'logo30.png', '#f59e0b', 2, 6, NULL, '2025-12-04 08:59:42', '2025-12-05 01:40:49');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('KqmQwuwWNth11DIUnd9Br3vWbb21uAlwdwl8tJwn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTE5JZ3J3ZmZjSlhWOUJSSnMzQ2xueHJQUExxZzFLMkVFSXBwcWs4VyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0OToiaHR0cHM6Ly9za29vbHBpbG90LnRlc3Qvc3VwZXItYWRtaW4vc2Nob29sLzEvZWRpdCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQyOiJodHRwczovL3Nrb29scGlsb3QudGVzdC9zY2hvb2wtYWRtaW4vc3RhZmYiO3M6NToicm91dGUiO3M6MjQ6InNjaG9vbC1hZG1pbi5zdGFmZi5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764929334);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint UNSIGNED NOT NULL,
  `school_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `school_id`, `first_name`, `last_name`, `email`, `phone`, `employee_id`, `date_of_birth`, `gender`, `address`, `designation`, `department`, `joining_date`, `salary`, `profile_image`, `is_active`, `created_at`, `updated_at`) VALUES
(32, 9, 'Amit', 'Sharma', 'amit.sharma@example.com', '9876600011', 'STF001', '1988-03-12', 'male', 'Address 1', 'Administrator', 'Administration', '2020-06-15', 45000.00, 'staff1.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(33, 11, 'Sneha', 'Verma', 'sneha.verma@example.com', '9876600012', 'STF002', '1990-07-21', 'female', 'Address 2', 'Accountant', 'Accounts', '2019-04-10', 38000.00, 'staff2.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(34, 27, 'Rahul', 'Kumar', 'rahul.kumar@example.com', '9876600013', 'STF003', '1985-11-10', 'male', 'Address 3', 'Clerk', 'Office', '2018-11-05', 30000.00, 'staff3.jpg', 0, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(35, 11, 'Pooja', 'Singh', 'pooja.singh@example.com', '9876600014', 'STF004', '1992-09-18', 'female', 'Address 4', 'Receptionist', 'Front Desk', '2021-03-12', 28000.00, 'staff4.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(36, 3, 'Rohit', 'Patel', 'rohit.patel@example.com', '9876600015', 'STF005', '1987-02-05', 'male', 'Address 5', 'Lab Assistant', 'Science Lab', '2020-01-20', 32000.00, 'staff5.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(37, 11, 'Anita', 'Mehta', 'anita.mehta@example.com', '9876600016', 'STF006', '1993-05-15', 'female', 'Address 6', 'Librarian', 'Library', '2019-09-15', 34000.00, 'staff6.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(38, 16, 'Deepak', 'Yadav', 'deepak.yadav@example.com', '9876600017', 'STF007', '1989-08-20', 'male', 'Address 7', 'Sports Coach', 'Sports', '2018-07-10', 36000.00, 'staff7.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(39, 17, 'Kavita', 'Rao', 'kavita.rao@example.com', '9876600018', 'STF008', '1991-04-14', 'female', 'Address 8', 'Counselor', 'Student Support', '2020-10-05', 40000.00, 'staff8.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(40, 7, 'Suresh', 'Gill', 'suresh.gill@example.com', '9876600019', 'STF009', '1986-12-01', 'male', 'Address 9', 'Driver', 'Transport', '2019-06-11', 25000.00, 'staff9.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(41, 15, 'Shalini', 'Goyal', 'shalini.goyal@example.com', '9876600020', 'STF010', '1994-01-17', 'female', 'Address 10', 'Nurse', 'Health Center', '2021-08-05', 33000.00, 'staff10.jpg', 0, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(42, 21, 'Vinay', 'Thakur', 'vinay.thakur@example.com', '9876600021', 'STF011', '1987-03-22', 'male', 'Address 11', 'IT Support', 'IT Department', '2020-03-17', 38000.00, 'staff11.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(43, 30, 'Ritu', 'Arora', 'ritu.arora@example.com', '9876600022', 'STF012', '1990-10-10', 'female', 'Address 12', 'HR Executive', 'HR', '2018-09-09', 41000.00, 'staff12.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(44, 28, 'Manish', 'Saxena', 'manish.saxena@example.com', '9876600023', 'STF013', '1985-06-12', 'male', 'Address 13', 'Security Guard', 'Security', '2019-11-14', 22000.00, 'staff13.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(45, 19, 'Divya', 'Chopra', 'divya.chopra@example.com', '9876600024', 'STF014', '1992-07-19', 'female', 'Address 14', 'Office Assistant', 'Office', '2021-02-21', 26000.00, 'staff14.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43'),
(46, 8, 'Arjun', 'Nair', 'arjun.nair@example.com', '9876600025', 'STF015', '1988-09-16', 'male', 'Address 15', 'Peon', 'General', '2020-12-12', 20000.00, 'staff15.jpg', 1, '2025-12-05 10:05:43', '2025-12-05 10:05:43');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint UNSIGNED NOT NULL,
  `school_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admission_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roll_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `parent_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `school_id`, `first_name`, `last_name`, `email`, `phone`, `parent_phone`, `admission_number`, `date_of_birth`, `gender`, `address`, `class`, `section`, `roll_number`, `admission_date`, `parent_name`, `parent_email`, `blood_group`, `profile_image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 18, 'Elvis', 'Sullivan', 'mujoxyfon@mailinator.com', '+1 (182) 503-5841', '+1 (768) 899-3968', '990', '1977-05-09', 'male', 'Nulla perspiciatis', 'Veritatis rerum sint', 'Dolores vero suscipi', '675', '2012-04-25', 'Damian Sawyer', 'zapow@mailinator.com', 'A+', NULL, 1, '2025-12-05 02:48:39', '2025-12-05 02:55:21'),
(92, 18, 'Emi', 'Osborne', 'guruved@mailinator.com', '+1 (136) 913-2101', '+1 (373) 108-9978', '135', '2018-09-21', 'other', 'Consequatur Autem a', 'Voluptates iure labo', 'Temporibus quo inven', '984', '2009-07-27', 'Kenneth Wall', 'muxijumomy@mailinator.com', 'A+', NULL, 1, '2025-12-05 03:02:02', '2025-12-05 03:02:02'),
(93, 20, 'Aarav', 'Sharma', 'aarav.sharma1@example.com', '9876510001', '9876520001', 'ADM001', '2010-05-12', 'male', 'Address 1', '5', 'A', '01', '2020-04-10', 'Rohit Sharma', 'parent1@example.com', 'A+', 's1.jpg', 1, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(94, 29, 'Diya', 'Verma', 'diya.verma2@example.com', '9876510002', '9876520002', 'ADM002', '2011-03-19', 'female', 'Address 2', '4', 'B', '02', '2019-06-12', 'Suman Verma', 'parent2@example.com', 'B+', 's2.jpg', 1, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(95, 22, 'Vivaan', 'Singh', 'vivaan.singh3@example.com', '9876510003', '9876520003', 'ADM003', '2009-08-25', 'male', 'Address 3', '6', 'C', '03', '2021-07-01', 'Amit Singh', 'parent3@example.com', 'O+', 's3.jpg', 0, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(96, 23, 'Ananya', 'Gupta', 'ananya.g4@example.com', '9876510004', '9876520004', 'ADM004', '2012-01-14', 'female', 'Address 4', '3', 'A', '04', '2020-05-25', 'Neeraj Gupta', 'parent4@example.com', 'AB+', 's4.jpg', 1, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(97, 17, 'Reyansh', 'Patel', 'reyansh.p5@example.com', '9876510005', '9876520005', 'ADM005', '2010-11-11', 'male', 'Address 5', '5', 'D', '05', '2019-03-15', 'Karan Patel', 'parent5@example.com', 'A-', 's5.jpg', 1, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(98, 17, 'Myra', 'Khan', 'myra.k6@example.com', '9876510006', '9876520006', 'ADM006', '2011-04-28', 'female', 'Address 6', '4', 'A', '06', '2021-09-10', 'Imran Khan', 'parent6@example.com', 'B-', 's6.jpg', 0, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(99, 3, 'Kabir', 'Yadav', 'kabir.y7@example.com', '9876510007', '9876520007', 'ADM007', '2008-07-05', 'male', 'Address 7', '7', 'B', '07', '2018-02-20', 'Raj Yadav', 'parent7@example.com', 'O-', 's7.jpg', 1, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(100, 22, 'Ishita', 'Rao', 'ishita.r8@example.com', '9876510008', '9876520008', 'ADM008', '2012-09-22', 'female', 'Address 8', '3', 'C', '08', '2020-06-06', 'Ravi Rao', 'parent8@example.com', 'A+', 's8.jpg', 1, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(101, 13, 'Atharv', 'Nair', 'atharv.n9@example.com', '9876510009', '9876520009', 'ADM009', '2010-02-02', 'male', 'Address 9', '5', 'B', '09', '2019-08-14', 'Suresh Nair', 'parent9@example.com', 'B+', 's9.jpg', 0, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(102, 28, 'Sara', 'Mehta', 'sara.m10@example.com', '9876510010', '9876520010', 'ADM010', '2011-10-11', 'female', 'Address 10', '4', 'A', '10', '2021-01-18', 'Tarun Mehta', 'parent10@example.com', 'AB+', 's10.jpg', 1, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(103, 12, 'Arnav', 'Joshi', 'arnav.j11@example.com', '9876510011', '9876520011', 'ADM011', '2009-06-26', 'male', 'Address 11', '6', 'C', '11', '2020-03-01', 'Vikas Joshi', 'parent11@example.com', 'O+', 's11.jpg', 1, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(104, 5, 'Riya', 'Kulkarni', 'riya.k12@example.com', '9876510012', '9876520012', 'ADM012', '2012-12-20', 'female', 'Address 12', '3', 'D', '12', '2021-07-25', 'Sanjay Kulkarni', 'parent12@example.com', 'A+', 's12.jpg', 0, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(105, 17, 'Dev', 'Shetty', 'dev.s13@example.com', '9876510013', '9876520013', 'ADM013', '2010-08-16', 'male', 'Address 13', '5', 'A', '13', '2019-11-30', 'Mahesh Shetty', 'parent13@example.com', 'B-', 's13.jpg', 1, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(106, 12, 'Kiara', 'Bhatia', 'kiara.b14@example.com', '9876510014', '9876520014', 'ADM014', '2011-03-04', 'female', 'Address 14', '4', 'C', '14', '2021-05-14', 'Puneet Bhatia', 'parent14@example.com', 'AB-', 's14.jpg', 1, '2025-12-05 08:39:39', '2025-12-05 08:39:39'),
(107, 6, 'Ayaan', 'Gill', 'ayaan.g15@example.com', '9876510015', '9876520015', 'ADM015', '2009-09-09', 'male', 'Address 15', '6', 'A', '15', '2018-12-18', 'Manjeet Gill', 'parent15@example.com', 'O-', 's15.jpg', 1, '2025-12-05 08:39:39', '2025-12-05 08:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('monthly','quarterly','yearly','lifetime') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tier` enum('basic','standard','premium') COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_status` enum('free','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `price` decimal(10,2) NOT NULL,
  `offer_price` decimal(10,2) DEFAULT NULL,
  `features` json DEFAULT NULL,
  `trial_days` int NOT NULL DEFAULT '15',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `name`, `description`, `type`, `tier`, `plan_status`, `price`, `offer_price`, `features`, `trial_days`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Basic Monthly Plan', NULL, 'monthly', 'basic', 'paid', 29.99, NULL, '[\"Up to 100 students\", \"Basic attendance tracking\", \"Email support\", \"Monthly reports\", \"5GB storage\"]', 15, 1, '2025-12-04 23:38:42', '2025-12-04 23:38:42'),
(2, 'Basic Quarterly Plan', NULL, 'quarterly', 'basic', 'paid', 80.97, NULL, '[\"Up to 100 students\", \"Basic attendance tracking\", \"Email support\", \"Monthly reports\", \"5GB storage\", \"10% discount (3 months)\"]', 15, 1, '2025-12-04 23:38:43', '2025-12-04 23:38:43'),
(3, 'Basic Yearly Plan', NULL, 'yearly', 'basic', 'paid', 287.90, NULL, '[\"Up to 100 students\", \"Basic attendance tracking\", \"Email support\", \"Monthly reports\", \"5GB storage\", \"20% discount (12 months)\"]', 30, 1, '2025-12-04 23:38:43', '2025-12-04 23:38:43'),
(4, 'Standard Monthly Plan', NULL, 'monthly', 'standard', 'paid', 59.99, NULL, '[\"Up to 500 students\", \"Advanced attendance tracking\", \"Email & phone support\", \"Weekly reports\", \"Parent portal access\", \"SMS notifications\", \"25GB storage\"]', 15, 1, '2025-12-04 23:38:43', '2025-12-04 23:38:43'),
(5, 'Standard Quarterly Plan', NULL, 'quarterly', 'standard', 'paid', 161.97, NULL, '[\"Up to 500 students\", \"Advanced attendance tracking\", \"Email & phone support\", \"Weekly reports\", \"Parent portal access\", \"SMS notifications\", \"25GB storage\", \"10% discount (3 months)\"]', 15, 1, '2025-12-04 23:38:43', '2025-12-04 23:38:43'),
(6, 'Standard Yearly Plan', NULL, 'yearly', 'standard', 'paid', 575.90, NULL, '[\"Up to 500 students\", \"Advanced attendance tracking\", \"Email & phone support\", \"Weekly reports\", \"Parent portal access\", \"SMS notifications\", \"25GB storage\", \"20% discount (12 months)\"]', 30, 1, '2025-12-04 23:38:43', '2025-12-04 23:38:43'),
(7, 'Premium Monthly Plan', NULL, 'monthly', 'premium', 'paid', 99.99, NULL, '[\"Unlimited students\", \"Advanced attendance & analytics\", \"24/7 priority support\", \"Real-time reports\", \"Parent & student portals\", \"SMS & email notifications\", \"Custom branding\", \"API access\", \"Unlimited storage\", \"Dedicated account manager\"]', 15, 1, '2025-12-04 23:38:43', '2025-12-04 23:38:43'),
(8, 'Premium Quarterly Plan', NULL, 'quarterly', 'premium', 'paid', 269.97, NULL, '[\"Unlimited students\", \"Advanced attendance & analytics\", \"24/7 priority support\", \"Real-time reports\", \"Parent & student portals\", \"SMS & email notifications\", \"Custom branding\", \"API access\", \"Unlimited storage\", \"Dedicated account manager\", \"10% discount (3 months)\"]', 15, 1, '2025-12-04 23:38:43', '2025-12-04 23:38:43'),
(9, 'Premium Yearly Plan', NULL, 'yearly', 'premium', 'paid', 959.90, NULL, '[\"Unlimited students\", \"Advanced attendance & analytics\", \"24/7 priority support\", \"Real-time reports\", \"Parent & student portals\", \"SMS & email notifications\", \"Custom branding\", \"API access\", \"Unlimited storage\", \"Dedicated account manager\", \"20% discount (12 months)\", \"Priority feature requests\"]', 30, 1, '2025-12-04 23:38:43', '2025-12-04 23:38:43'),
(12, 'Free Starter Plan', 'Perfect for trying out our platform. Get started with essential features at no cost.', 'lifetime', 'basic', 'free', 0.00, NULL, '[\"Up to 25 students\", \"Basic attendance tracking\", \"Email support\", \"1GB storage\", \"Limited features\"]', 0, 1, '2025-12-04 23:49:57', '2025-12-04 23:49:57'),
(13, 'Basic Monthly Plan', 'Ideal for small schools looking to manage up to 100 students efficiently.', 'monthly', 'basic', 'paid', 29.99, NULL, '[\"Up to 100 students\", \"Basic attendance tracking\", \"Email support\", \"Monthly reports\", \"5GB storage\"]', 15, 1, '2025-12-04 23:49:57', '2025-12-04 23:49:57'),
(14, 'Basic Quarterly Plan', 'Save 10% with our quarterly plan. Best for schools planning ahead.', 'quarterly', 'basic', 'paid', 80.97, 72.87, '[\"Up to 100 students\", \"Basic attendance tracking\", \"Email support\", \"Monthly reports\", \"5GB storage\", \"10% discount (3 months)\"]', 15, 1, '2025-12-04 23:49:57', '2025-12-04 23:49:57'),
(15, 'Basic Yearly Plan', 'Maximum savings! Get 20% off with our annual subscription.', 'yearly', 'basic', 'paid', 287.90, 230.32, '[\"Up to 100 students\", \"Basic attendance tracking\", \"Email support\", \"Monthly reports\", \"5GB storage\", \"20% discount (12 months)\"]', 30, 1, '2025-12-04 23:49:57', '2025-12-04 23:49:57'),
(16, 'Standard Monthly Plan', 'Most popular! Perfect for growing schools with advanced features and parent engagement tools.', 'monthly', 'standard', 'paid', 59.99, NULL, '[\"Up to 500 students\", \"Advanced attendance tracking\", \"Email & phone support\", \"Weekly reports\", \"Parent portal access\", \"SMS notifications\", \"25GB storage\"]', 15, 1, '2025-12-04 23:49:57', '2025-12-04 23:49:57'),
(17, 'Standard Quarterly Plan', 'Great value for medium-sized schools. Save 10% on our most popular tier.', 'quarterly', 'standard', 'paid', 161.97, 145.77, '[\"Up to 500 students\", \"Advanced attendance tracking\", \"Email & phone support\", \"Weekly reports\", \"Parent portal access\", \"SMS notifications\", \"25GB storage\", \"10% discount (3 months)\"]', 15, 1, '2025-12-04 23:49:57', '2025-12-04 23:49:57'),
(18, 'Standard Yearly Plan', 'Best value! Unlock all standard features with maximum annual savings.', 'yearly', 'standard', 'paid', 575.90, 460.72, '[\"Up to 500 students\", \"Advanced attendance tracking\", \"Email & phone support\", \"Weekly reports\", \"Parent portal access\", \"SMS notifications\", \"25GB storage\", \"20% discount (12 months)\"]', 30, 1, '2025-12-04 23:49:57', '2025-12-04 23:49:57'),
(19, 'Premium Monthly Plan', 'Ultimate package for large institutions. Unlimited everything with priority support.', 'monthly', 'premium', 'paid', 99.99, NULL, '[\"Unlimited students\", \"Advanced attendance & analytics\", \"24/7 priority support\", \"Real-time reports\", \"Parent & student portals\", \"SMS & email notifications\", \"Custom branding\", \"API access\", \"Unlimited storage\", \"Dedicated account manager\"]', 15, 1, '2025-12-04 23:49:57', '2025-12-04 23:49:57'),
(20, 'Premium Quarterly Plan', 'Enterprise solution with quarterly savings. Perfect for schools requiring full customization.', 'quarterly', 'premium', 'paid', 269.97, 242.97, '[\"Unlimited students\", \"Advanced attendance & analytics\", \"24/7 priority support\", \"Real-time reports\", \"Parent & student portals\", \"SMS & email notifications\", \"Custom branding\", \"API access\", \"Unlimited storage\", \"Dedicated account manager\", \"10% discount (3 months)\"]', 15, 1, '2025-12-04 23:49:57', '2025-12-04 23:49:57'),
(21, 'Premium Yearly Plan', 'The ultimate annual deal! Get all premium features with maximum savings and priority support.', 'yearly', 'premium', 'paid', 959.90, 767.92, '[\"Unlimited students\", \"Advanced attendance & analytics\", \"24/7 priority support\", \"Real-time reports\", \"Parent & student portals\", \"SMS & email notifications\", \"Custom branding\", \"API access\", \"Unlimited storage\", \"Dedicated account manager\", \"20% discount (12 months)\", \"Priority feature requests\"]', 30, 1, '2025-12-04 23:49:57', '2025-12-04 23:49:57'),
(22, 'Premium Lifetime Access', 'One-time payment, lifetime access! The best investment for your school. Never pay again!', 'lifetime', 'premium', 'paid', 2999.00, 2499.00, '[\"Unlimited students - Forever\", \"All premium features - Lifetime\", \"24/7 priority support\", \"Real-time reports & analytics\", \"Parent & student portals\", \"SMS & email notifications\", \"Custom branding\", \"API access\", \"Unlimited storage\", \"Dedicated account manager\", \"Priority feature requests\", \"Free future updates\", \"One-time payment only\"]', 30, 1, '2025-12-04 23:49:57', '2025-12-04 23:49:57');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint UNSIGNED NOT NULL,
  `school_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specialization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `school_id`, `first_name`, `last_name`, `email`, `phone`, `employee_id`, `date_of_birth`, `gender`, `address`, `qualification`, `specialization`, `joining_date`, `salary`, `profile_image`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 6, 'Amit', 'Sharma', 'amit.sharma1@example.com', '9876500101', 'EMP001', '1988-03-12', 'male', 'Address 1', 'B.Ed', 'Maths', '2020-06-15', 35000.00, 'p1.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(3, 11, 'Neha', 'Verma', 'neha.verma2@example.com', '9876500102', 'EMP002', '1990-07-21', 'female', 'Address 2', 'M.Sc', 'Physics', '2019-05-12', 38000.00, 'p2.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(4, 7, 'Rahul', 'Kumar', 'rahul.kumar3@example.com', '9876500103', 'EMP003', '1985-11-10', 'male', 'Address 3', 'B.Ed', 'English', '2021-01-10', 32000.00, 'p3.jpg', 0, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(5, 3, 'Pooja', 'Singh', 'pooja.singh4@example.com', '9876500104', 'EMP004', '1992-09-18', 'female', 'Address 4', 'M.A', 'Hindi', '2020-03-01', 36000.00, 'p4.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(6, 21, 'Rohit', 'Patel', 'rohit.patel5@example.com', '9876500105', 'EMP005', '1987-02-05', 'male', 'Address 5', 'B.Sc', 'Science', '2018-11-20', 34000.00, 'p5.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(7, 8, 'Anita', 'Mehta', 'anita.mehta6@example.com', '9876500106', 'EMP006', '1993-05-15', 'female', 'Address 6', 'M.Com', 'Accounts', '2019-02-10', 39000.00, 'p6.jpg', 0, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(8, 7, 'Suresh', 'Yadav', 'suresh.yadav7@example.com', '9876500107', 'EMP007', '1989-08-20', 'male', 'Address 7', 'B.Ed', 'Social Science', '2021-07-01', 33000.00, 'p7.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(9, 12, 'Kavita', 'Kapoor', 'kavita.kapoor8@example.com', '9876500108', 'EMP008', '1991-04-14', 'female', 'Address 8', 'M.Sc', 'Biology', '2020-04-22', 37000.00, 'p8.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(10, 5, 'Deepak', 'Rana', 'deepak.rana9@example.com', '9876500109', 'EMP009', '1986-12-01', 'male', 'Address 9', 'B.Tech', 'Computer', '2019-06-11', 40000.00, 'p9.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(11, 21, 'Shalini', 'Goyal', 'shalini.goyal10@example.com', '9876500110', 'EMP010', '1994-01-17', 'female', 'Address 10', 'M.A', 'Geography', '2021-08-05', 35500.00, 'p10.jpg', 0, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(12, 28, 'Vinay', 'Thakur', 'vinay.thakur11@example.com', '9876500111', 'EMP011', '1987-03-22', 'male', 'Address 11', 'B.Ed', 'History', '2020-03-17', 34500.00, 'p11.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(13, 15, 'Ritu', 'Arora', 'ritu.arora12@example.com', '9876500112', 'EMP012', '1990-10-10', 'female', 'Address 12', 'M.Sc', 'Chemistry', '2018-09-09', 39500.00, 'p12.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(14, 23, 'Manish', 'Saxena', 'manish.saxena13@example.com', '9876500113', 'EMP013', '1985-06-12', 'male', 'Address 13', 'M.A', 'Civics', '2019-11-14', 36000.00, 'p13.jpg', 0, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(15, 8, 'Sneha', 'Reddy', 'sneha.reddy14@example.com', '9876500114', 'EMP014', '1992-07-19', 'female', 'Address 14', 'B.Ed', 'English', '2021-02-21', 32500.00, 'p14.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(16, 30, 'Arjun', 'Nair', 'arjun.nair15@example.com', '9876500115', 'EMP015', '1988-09-16', 'male', 'Address 15', 'M.Sc', 'Maths', '2020-12-12', 38000.00, 'p15.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(17, 6, 'Lakshmi', 'Iyer', 'lakshmi.iyer16@example.com', '9876500116', 'EMP016', '1993-05-11', 'female', 'Address 16', 'M.Com', 'Business Studies', '2019-04-14', 36500.00, 'p16.jpg', 0, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(18, 30, 'Rajesh', 'Mishra', 'rajesh.mishra17@example.com', '9876500117', 'EMP017', '1991-08-09', 'male', 'Address 17', 'B.Ed', 'Hindi', '2020-08-18', 33000.00, 'p17.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(19, 10, 'Divya', 'Chopra', 'divya.chopra18@example.com', '9876500118', 'EMP018', '1994-12-22', 'female', 'Address 18', 'M.Sc', 'Physics', '2021-01-10', 38500.00, 'p18.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(20, 21, 'Harish', 'Gill', 'harish.gill19@example.com', '9876500119', 'EMP019', '1989-11-11', 'male', 'Address 19', 'B.Tech', 'Computer', '2018-07-07', 41000.00, 'p19.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(21, 15, 'Preeti', 'Malhotra', 'preeti.malhotra20@example.com', '9876500120', 'EMP020', '1992-02-20', 'female', 'Address 20', 'M.A', 'Social Science', '2020-05-05', 34500.00, 'p20.jpg', 0, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(22, 11, 'Sanjay', 'Bhardwaj', 'sanjay.b21@example.com', '9876500121', 'EMP021', '1986-03-03', 'male', 'Address 21', 'B.Ed', 'Geography', '2021-04-04', 35000.00, 'p21.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(23, 11, 'Nisha', 'Shah', 'nisha.shah22@example.com', '9876500122', 'EMP022', '1993-06-25', 'female', 'Address 22', 'M.Sc', 'Biology', '2019-01-19', 37000.00, 'p22.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(24, 21, 'Gaurav', 'Khandelwal', 'gaurav.k23@example.com', '9876500123', 'EMP023', '1987-04-30', 'male', 'Address 23', 'M.Com', 'Accounts', '2018-12-12', 39000.00, 'p23.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(25, 9, 'Prachi', 'Deshmukh', 'prachi.d24@example.com', '9876500124', 'EMP024', '1991-10-08', 'female', 'Address 24', 'B.Ed', 'English', '2021-03-03', 33000.00, 'p24.jpg', 0, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(26, 14, 'Anand', 'Joshi', 'anand.j25@example.com', '9876500125', 'EMP025', '1988-05-05', 'male', 'Address 25', 'M.Sc', 'Chemistry', '2019-09-10', 38000.00, 'p25.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(27, 10, 'Rashmi', 'Kulkarni', 'rashmi.k26@example.com', '9876500126', 'EMP026', '1994-03-27', 'female', 'Address 26', 'M.A', 'Hindi', '2020-10-10', 34000.00, 'p26.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(28, 10, 'Yogesh', 'Shetty', 'yogesh.s27@example.com', '9876500127', 'EMP027', '1989-06-16', 'male', 'Address 27', 'B.Ed', 'History', '2021-06-06', 34500.00, 'p27.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(29, 20, 'Meena', 'Pawar', 'meena.p28@example.com', '9876500128', 'EMP028', '1990-09-29', 'female', 'Address 28', 'M.Sc', 'Maths', '2019-08-08', 36000.00, 'p28.jpg', 0, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(30, 10, 'Aditya', 'Rao', 'aditya.r29@example.com', '9876500129', 'EMP029', '1987-12-19', 'male', 'Address 29', 'M.Sc', 'Computer', '2018-05-05', 42000.00, 'p29.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(31, 21, 'Simran', 'Bhatia', 'simran.b30@example.com', '9876500130', 'EMP030', '1993-11-14', 'female', 'Address 30', 'B.Ed', 'Science', '2021-09-09', 35000.00, 'p30.jpg', 1, '2025-12-05 07:29:53', '2025-12-05 07:29:53'),
(32, 3, 'Tasha', 'Mccarty', 'pisyfojy@mailinator.com', '+1 (987) 776-6487', 'Quasi sunt ea exerc', '1976-11-10', 'female', 'Nisi quis earum ut d', 'Doloribus ut nihil a', 'Velit proident non', '1985-03-14', 13.00, NULL, 1, '2025-12-05 04:25:46', '2025-12-05 04:25:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$FO3Va8D5FzHkXPJCvq.Hden6ND.p98OXpeuN0rajiMVWtgfHIfERK', NULL, '2025-12-03 23:59:01', '2025-12-03 23:59:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_email_unique` (`email`),
  ADD UNIQUE KEY `staff_employee_id_unique` (`employee_id`),
  ADD KEY `staff_school_id_foreign` (`school_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_admission_number_unique` (`admission_number`),
  ADD UNIQUE KEY `students_email_unique` (`email`),
  ADD KEY `students_school_id_foreign` (`school_id`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_email_unique` (`email`),
  ADD UNIQUE KEY `teachers_employee_id_unique` (`employee_id`),
  ADD KEY `teachers_school_id_foreign` (`school_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
