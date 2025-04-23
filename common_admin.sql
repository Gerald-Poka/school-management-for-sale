-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 12:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `common_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_levels`
--

CREATE TABLE `academic_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_levels`
--

INSERT INTO `academic_levels` (`id`, `name`, `code`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Standard One', 'STD1', 1, 1, '2025-03-26 00:02:44', '2025-03-26 00:02:44'),
(2, 'Standard Two', 'STD2', 2, 1, '2025-03-26 00:02:45', '2025-03-26 00:02:45'),
(3, 'Standard Three', 'STD3', 3, 1, '2025-03-26 00:02:45', '2025-03-26 00:02:45'),
(4, 'Standard Four', 'STD4', 4, 1, '2025-03-26 00:02:45', '2025-03-26 00:02:45'),
(5, 'Standard Five', 'STD5', 5, 1, '2025-03-26 00:02:45', '2025-03-26 00:02:45'),
(6, 'Standard Six', 'STD6', 6, 1, '2025-03-26 00:02:45', '2025-03-26 00:02:45');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fee_structures`
--

CREATE TABLE `fee_structures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fee_type_id` bigint(20) UNSIGNED NOT NULL,
  `route_name` varchar(255) DEFAULT NULL,
  `academic_level_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `effective_from` date NOT NULL,
  `effective_to` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_structures`
--

INSERT INTO `fee_structures` (`id`, `fee_type_id`, `route_name`, `academic_level_id`, `amount`, `effective_from`, `effective_to`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(26, 5, NULL, 1, 1000000.00, '2025-02-25', '2025-03-25', 1, '2025-03-26 00:21:06', '2025-03-26 00:21:06', NULL),
(30, 7, 'Mbezi', 5, 50000.00, '2025-03-01', '2025-03-29', 1, '2025-03-26 00:51:32', '2025-03-26 00:51:32', NULL),
(31, 3, NULL, 4, 40000.00, '2025-03-28', '2025-04-10', 1, '2025-03-26 00:58:24', '2025-03-26 00:58:24', NULL),
(34, 7, 'Mbezi', 4, 400000.00, '2024-12-11', '2025-06-19', 1, '2025-03-26 01:33:34', '2025-03-26 01:33:34', NULL),
(35, 5, NULL, 4, 1400000.00, '2025-01-07', '2025-12-03', 1, '2025-04-07 06:53:11', '2025-04-07 06:53:11', NULL),
(36, 5, NULL, 2, 1200000.00, '2025-04-01', '2025-07-02', 1, '2025-04-07 06:53:53', '2025-04-07 06:53:53', NULL),
(37, 5, NULL, 3, 1500000.00, '2025-01-06', '2025-12-12', 1, '2025-04-07 13:11:49', '2025-04-07 13:11:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fee_types`
--

CREATE TABLE `fee_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `frequency` enum('one_time','term','annual') NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_types`
--

INSERT INTO `fee_types` (`id`, `name`, `code`, `frequency`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tuition Fee', 'TF', 'term', 'Regular tuition fee per term', 1, '2025-03-26 00:02:45', '2025-03-26 00:02:45', NULL),
(2, 'Registration Fee', 'RF', 'one_time', 'One-time registration fee for new students', 1, '2025-03-26 00:02:45', '2025-03-26 00:02:45', NULL),
(3, 'Development Fee', 'DF', 'annual', 'Annual development fee', 1, '2025-03-26 00:02:45', '2025-03-26 00:02:45', NULL),
(4, 'Library Fee', 'LF', 'term', 'Library usage and maintenance fee', 1, '2025-03-26 00:02:45', '2025-03-26 00:02:45', NULL),
(5, 'Tuition Fee', 'TUT', 'term', 'Regular tuition fee charged per term', 1, '2025-03-26 00:16:15', '2025-03-26 00:16:15', NULL),
(6, 'Registration Fee', 'REG', 'one_time', 'One-time registration fee', 1, '2025-03-26 00:16:15', '2025-03-26 00:36:43', NULL),
(7, 'Transport Fee', 'TRANS', 'term', 'School transport service fee', 1, '2025-03-26 00:36:43', '2025-03-26 00:36:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `relationship` enum('father','mother','uncle','aunt','guardian','other') NOT NULL,
  `primary_phone` varchar(255) NOT NULL,
  `alternative_phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `residential_address` text NOT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `is_emergency_contact` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guardians`
--

INSERT INTO `guardians` (`id`, `full_name`, `relationship`, `primary_phone`, `alternative_phone`, `email`, `residential_address`, `occupation`, `is_emergency_contact`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'John Doe', 'father', '255712345678', '255787654321', 'john.doe@example.com', 'Plot 123, Kinondoni Street, Dar es Salaam', 'Business Owner', 1, '2025-03-26 00:09:58', '2025-03-26 00:09:58', NULL),
(2, 'Mary Smith', 'mother', '255723456789', '255789876543', 'mary.smith@example.com', '45 Msasani Road, Dar es Salaam', 'Teacher', 1, '2025-03-26 00:09:58', '2025-03-26 00:09:58', NULL),
(3, 'Robert Wilson', 'guardian', '255734567890', NULL, 'robert.wilson@example.com', '78 Kariakoo Street, Dar es Salaam', 'Doctor', 0, '2025-03-26 00:09:59', '2025-03-26 00:09:59', NULL),
(17, 'Mzee Baba', 'father', '0756565', '0765676', 'mtoto@gmail.com', 'Dodoma\r\nDodoma', 'Programmer', 1, '2025-03-28 02:40:40', '2025-03-28 02:40:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('pending','partial','paid') DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `student_id`, `invoice_number`, `invoice_date`, `due_date`, `status`, `total_amount`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 1, 'INV2025040001', '2025-04-07', '2025-07-07', 'paid', 0.00, NULL, '2025-04-07 14:15:19', '2025-04-14 17:50:23', NULL),
(5, 1, 'INV2025040002', '2025-04-07', '2025-04-16', 'partial', 0.00, NULL, '2025-04-07 15:51:22', '2025-04-14 17:39:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `fee_structure_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `fee_structure_id`, `amount`, `description`, `created_at`, `updated_at`) VALUES
(6, 4, 31, 40000.00, 'Pesa ya ada hii', '2025-04-07 14:15:19', '2025-04-07 14:15:19'),
(7, 5, 37, 1500000.00, 'FEE PAYMENT ', '2025-04-07 15:51:22', '2025-04-07 15:51:22');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_03_25_000001_create_academic_levels_table', 1),
(6, '2024_03_25_000001_create_subjects_table', 1),
(7, '2024_03_25_000002_create_guardians_table', 1),
(8, '2024_03_25_000002_create_students_table', 1),
(9, '2024_03_25_000003_create_fee_types_table', 1),
(10, '2024_03_25_000004_create_fee_structures_table', 1),
(11, '2024_03_25_000005_create_invoices_table', 1),
(12, '2024_03_25_000007_create_payments_table', 1),
(13, '2025_03_25_113040_create_topic_management_tables', 1),
(14, '2025_03_25_174940_add_route_name_to_fee_structures', 2),
(15, '2024_03_25_000010_create_teachers_table', 3),
(16, '2024_03_25_000022_recreate_teacher_assignments_table', 4),
(17, '2024_03_25_create_teaching_schedules_table', 5),
(18, '2024_03_25_add_wing_to_teaching_schedules_table', 6),
(19, '2025_03_26_080835_add_is_active_to_teachers_table', 7),
(21, '2025_03_26_083525_add_academic_year_and_term_to_teaching_schedules_table', 8),
(22, '2025_03_26_000001_create_timetables_table', 9),
(23, '2025_03_26_000002_create_timetable_slots_table', 10),
(24, '2025_03_26_190409_add_profile_picture_to_students_table', 11),
(25, '2025_03_27_193757_add_guardian_id_to_students_table', 12),
(26, '2024_04_14_000000_add_approval_columns_to_payments_table', 13),
(27, '2024_04_14_000003_update_invoice_status_enum', 14),
(28, '2024_04_23_000000_create_results_table', 15),
(29, '2024_04_23_000001_create_student_subject_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `receipt_number` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `payment_proof` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `invoice_id`, `amount`, `payment_date`, `payment_method`, `reference_number`, `receipt_number`, `notes`, `payment_proof`, `status`, `approved_at`, `approved_by`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(1, 5, 700000.00, '2025-04-14', 'bank_transfer', 'REF202504147F43', 'RCP-20250414-0001', 'For Testing', 'payment_proofs/MRfKeKG7ybKb1UHcnGbdTJ3HIFJ5rTU7ONNJXCJf.pdf', 'approved', '2025-04-14 17:50:09', 1, NULL, '2025-04-14 16:28:25', '2025-04-14 17:50:09'),
(2, 5, 600000.00, '2025-04-14', 'mobile_money', 'REF20250414B3AC', 'RCP-20250414-0002', 'For Testing', 'payment_proofs/FjJhO5tOKJf8ZNZ9ZiukO4psmtnYhXQ6HK3PUcBl.pdf', 'approved', '2025-04-14 17:39:29', 1, NULL, '2025-04-14 16:44:49', '2025-04-14 17:39:29'),
(3, 4, 40000.00, '2025-04-14', 'bank_transfer', 'REF2025041466D3', 'RCP-20250414-0003', 'Done', 'payment_proofs/9MmgTCih39NOGbCNZuBcDVjrL4vOhVuIh0wRcPYt.pdf', 'approved', '2025-04-14 17:50:23', 1, NULL, '2025-04-14 17:49:22', '2025-04-14 17:50:23'),
(4, 5, 90000.00, '2025-04-14', 'mobile_money', 'REF20250414D387', 'RCP-20250414-0004', 'Last', 'payment_proofs/8yOsWZ8j3H2h766LAcNyvQ5PiGszAjfUpjzN4FiE.pdf', 'rejected', '2025-04-14 17:54:56', 1, 'Cheat', '2025-04-14 17:53:12', '2025-04-14 17:54:56'),
(5, 5, 50000.00, '2025-04-14', 'bank_transfer', 'REF20250414585C', 'RCP-20250414-0005', 'Testing', 'payment_proofs/t5xpgnsb9vkNBPV1t5uQSQoMM8jBt0YNCDwBQp8j.pdf', 'approved', '2025-04-14 17:55:03', 1, NULL, '2025-04-14 17:53:39', '2025-04-14 17:55:03');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `exam_type` varchar(255) NOT NULL,
  `marks_obtained` decimal(5,2) NOT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `exam_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `student_id`, `subject_id`, `exam_type`, `marks_obtained`, `grade`, `remarks`, `exam_date`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 'Mid Term', 90.00, 'A', 'Good Score', '2025-03-27', '2025-04-23 08:44:00', '2025-04-23 08:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admission_number` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `guardian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `academic_level_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `special_needs` text DEFAULT NULL,
  `date_of_admission` date NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `admission_number`, `first_name`, `middle_name`, `last_name`, `user_id`, `guardian_id`, `academic_level_id`, `date_of_birth`, `gender`, `special_needs`, `date_of_admission`, `profile_picture`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'GT-2025-9268', 'Katoto', 'Katoto', 'Mtoko', 35, 17, 3, '2024-11-07', 'male', 'no', '2025-03-28', 'student-photos/085ym8Nnh0IfDvk6NAZoKGokEZ0xBy0HsyJMZURh.jpg', 1, '2025-03-28 02:40:40', '2025-03-28 02:40:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_subject`
--

CREATE TABLE `student_subject` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `credits` int(11) NOT NULL DEFAULT 0,
  `level` enum('Standard 1','Standard 2','Standard 3','Standard 4','Standard 5','Standard 6') NOT NULL,
  `pdf_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `code`, `description`, `credits`, `level`, `pdf_link`, `created_at`, `updated_at`) VALUES
(1, 'TEST', 'TEST', 'TEST', 1, '', NULL, '2025-03-26 00:02:44', '2025-03-26 00:02:44'),
(3, 'Science', 'SCI101', 'Basic science concepts', 4, '', NULL, '2025-03-26 00:02:44', '2025-03-29 06:50:22'),
(4, 'Kiswahili', 'KIS101', 'Kiswahili language fundamentals', 4, '', NULL, '2025-03-26 00:02:44', '2025-03-26 00:02:44'),
(5, 'Science and Technology', 'STD5SAT10', 'yuyu', 7, 'Standard 5', 'uploads/subjects/science-and-technology-1742985931.pdf', '2025-03-26 17:45:31', '2025-04-19 05:32:46'),
(6, 'Kiswahili', 'STD3K82', 'Noma sana wanangu', 7, 'Standard 3', 'uploads/subjects/kiswahili-1743018073.pdf', '2025-03-27 02:38:46', '2025-03-27 02:41:13'),
(7, 'Mathematics', 'STD3M14', 'This is will help the keep to master math and shapers the brain', 7, 'Standard 3', 'uploads/subjects/mathematics-1743229191.pdf', '2025-03-29 06:19:51', '2025-03-29 06:19:51'),
(9, 'English', 'STD3E76', 'Will help in language', 7, 'Standard 3', 'uploads/subjects/english-1743231246.pdf', '2025-03-29 06:54:06', '2025-03-29 06:54:06'),
(10, 'Social Studies', 'STD3SS30', 'This will help in making articrafts', 7, 'Standard 3', 'uploads/subjects/social-studies-1743231491.pdf', '2025-03-29 06:58:11', '2025-03-29 06:58:11'),
(11, 'Science and Technology', 'STD3SAT78', 'This for science', 7, 'Standard 3', 'uploads/subjects/science-and-technology-1743231519.pdf', '2025-03-29 06:58:39', '2025-03-29 06:58:39'),
(12, 'Religious Studies', 'STD3RS48', 'This for religion', 7, 'Standard 3', 'uploads/subjects/religious-studies-1743231550.pdf', '2025-03-29 06:59:10', '2025-03-29 06:59:10'),
(13, 'Vocational Skills', 'STD3VS48', 'For arts', 7, 'Standard 3', 'uploads/subjects/vocational-skills-1743231574.pdf', '2025-03-29 06:59:34', '2025-03-29 06:59:44'),
(14, 'Arts and Sports', 'STD3AAS83', 'Games', 7, 'Standard 3', 'uploads/subjects/arts-and-sports-1743233024.pdf', '2025-03-29 07:23:44', '2025-03-29 07:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `subtopics`
--

CREATE TABLE `subtopics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `topic_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subtopics`
--

INSERT INTO `subtopics` (`id`, `topic_id`, `name`, `order`, `created_at`, `updated_at`) VALUES
(3, 2, 'Kuchora', 1, '2025-03-27 02:43:45', '2025-03-27 02:43:45'),
(4, 2, 'Kuimba', 2, '2025-03-27 02:43:45', '2025-03-27 02:43:45'),
(5, 3, 'Kusikiliza maelezo na kuelewa', 1, '2025-03-29 09:46:01', '2025-03-29 09:46:01'),
(6, 3, 'Matumizi sahihi ya lugha', 2, '2025-03-29 09:46:01', '2025-03-29 09:46:01'),
(7, 3, 'Mazungumzo ya kila siku', 3, '2025-03-29 09:46:01', '2025-03-29 09:46:01'),
(8, 4, 'Listening to short stories', 1, '2025-03-29 09:47:44', '2025-03-29 09:47:44'),
(9, 4, 'Expressing personal opinions', 2, '2025-03-29 09:47:44', '2025-03-29 09:47:44'),
(10, 4, 'Pronouncing words correctly', 3, '2025-03-29 09:47:44', '2025-03-29 09:47:44'),
(11, 5, 'Counting and writing numbers up to 10,000', 1, '2025-03-29 09:49:03', '2025-03-29 09:49:03'),
(12, 5, 'Multiplication and division', 2, '2025-03-29 09:49:03', '2025-03-29 09:49:03'),
(13, 5, 'Addition and subtraction', 3, '2025-03-29 09:49:03', '2025-03-29 09:49:03'),
(14, 6, 'Drawing and coloring', 1, '2025-03-29 09:50:09', '2025-03-29 09:50:09'),
(15, 6, 'Planting and caring for crops', 2, '2025-03-29 09:50:09', '2025-03-29 09:50:09'),
(16, 7, 'Human body parts and their functions', 1, '2025-03-29 09:51:45', '2025-03-29 09:51:45'),
(17, 7, 'Importance of personal cleanliness', 2, '2025-03-29 09:51:45', '2025-03-29 09:51:45'),
(18, 7, 'Sources of energy (sun, wind, water)', 3, '2025-03-29 09:51:45', '2025-03-29 09:51:45'),
(19, 7, 'Understanding weather changes', 4, '2025-03-29 09:51:45', '2025-03-29 09:51:45'),
(20, 8, 'Running, jumping, and balancing', 1, '2025-03-29 09:53:09', '2025-03-29 09:53:09'),
(21, 8, 'Simple stretching exercises', 2, '2025-03-29 09:53:09', '2025-03-29 09:53:09'),
(22, 8, 'Football, netball, athletics', 3, '2025-03-29 09:53:09', '2025-03-29 09:53:09'),
(23, 8, 'Avoiding injuries', 4, '2025-03-29 09:53:09', '2025-03-29 09:53:09'),
(24, 9, 'Kuguna kwa mipaka', 1, '2025-03-31 14:31:24', '2025-03-31 14:31:24'),
(25, 9, 'Kuguna kwa misito', 2, '2025-03-31 14:31:24', '2025-03-31 14:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `date_of_birth` date NOT NULL,
  `birth_certificate_number` varchar(255) DEFAULT NULL,
  `national_id` varchar(255) DEFAULT NULL,
  `passport_number` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `alternative_phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `physical_address` text NOT NULL,
  `postal_address` varchar(255) DEFAULT NULL,
  `secondary_school` varchar(255) DEFAULT NULL,
  `form_four_index` varchar(255) DEFAULT NULL,
  `form_six_index` varchar(255) DEFAULT NULL,
  `diploma_certificate` varchar(255) DEFAULT NULL,
  `degree_certificate` varchar(255) DEFAULT NULL,
  `highest_qualification` varchar(255) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `other_qualifications` text DEFAULT NULL,
  `teaching_license_number` varchar(255) DEFAULT NULL,
  `license_expiry_date` date DEFAULT NULL,
  `joining_date` date NOT NULL,
  `previous_experience` text DEFAULT NULL,
  `subjects_taught` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`subjects_taught`)),
  `responsibilities` text DEFAULT NULL,
  `achievements` text DEFAULT NULL,
  `ict_skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ict_skills`)),
  `language_proficiency` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`language_proficiency`)),
  `classroom_management_skills` text DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `teaching_license_path` varchar(255) DEFAULT NULL,
  `certificates_path` varchar(255) DEFAULT NULL,
  `recommendation_letters_path` varchar(255) DEFAULT NULL,
  `id_document_path` varchar(255) DEFAULT NULL,
  `birth_certificate_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `employee_id`, `first_name`, `last_name`, `nationality`, `gender`, `date_of_birth`, `birth_certificate_number`, `national_id`, `passport_number`, `phone`, `alternative_phone`, `email`, `physical_address`, `postal_address`, `secondary_school`, `form_four_index`, `form_six_index`, `diploma_certificate`, `degree_certificate`, `highest_qualification`, `specialization`, `other_qualifications`, `teaching_license_number`, `license_expiry_date`, `joining_date`, `previous_experience`, `subjects_taught`, `responsibilities`, `achievements`, `ict_skills`, `language_proficiency`, `classroom_management_skills`, `cv_path`, `teaching_license_path`, `certificates_path`, `recommendation_letters_path`, `id_document_path`, `birth_certificate_path`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 'TCH20250001', 'Gerald', 'Ndyamukama', 'Tanzanian', 'male', '2001-05-18', '90-3934-34', '200105183522510123', '098343', '0673128464', '0754318464', 'geraldndyamukama39@gmail.com', 'Dar es salaam', 'Dar es salaam', 'Katoke', '0930232', '343043', '2', '2', '2', 'eee', 'eeee', '09943434', '2024-11-05', '2025-03-26', 'vsdvfvfvsffs', '\"ddsffs\"', 'sffsfs', 'sdfsfsfsfs', '\"fsfsfs\"', '\"sfdfsf\"', 'fsfsfsfsvsdvs', 'teachers/cvs/k0R03gp3wiAt5SiXtYT3jrLLwam39sS451gnt2Ue.pdf', 'teachers/licenses/J8LBEkg6aIjjRx2wLwv4cw9XKOf9ynKYsN95nlfE.pdf', 'teachers/certificates/gugVNm3XjGG10QIgXxBlhmeFnCoCSQlMdy7p3gwF.pdf', 'teachers/recommendation_letterss/ODHmwcAaA0i2eFhqiAdivBMlJlygsMMjs8LKGCPp.pdf', 'teachers/id_documents/i7NPQy9L4D2etNmiFYtj0Kbf8wXIsu5Gp4pQ6f6J.pdf', 'teachers/birth_certificates/iQb5pILFstptPilIMSSzJjJMm4CU70ldXDooEbaL.pdf', 1, '2025-03-26 03:30:29', '2025-03-26 03:56:39', NULL),
(3, 9, 'TCH20250002', 'lucas', 'Michael', 'Tanzanian', 'male', '2025-02-25', '90-3934-33', '2001051835225101299', '098341', '0444333', '0764534530', 'leo@gmail.com', 'Dodoma', 'Dodoma', NULL, NULL, NULL, NULL, NULL, '2', 'eee', NULL, NULL, NULL, '2025-03-04', NULL, '[\"wdwdd\"]', NULL, NULL, '[\"wwwwddw\"]', NULL, NULL, 'teacher-documents/NApnaSnAPiDPphtT2SNqMrHSAen9exbkDH2ZpEtH.pdf', 'teacher-documents/MaCkEgKLDBB0kXUHoW9rYe9yA9t8xMo00ELkSzTQ.pdf', 'teacher-documents/aAWOZVZp9PLVlpeDHbXUP7Bc7mnHiLTefVtT5CjL.pdf', 'teacher-documents/X3V04CZQbq1Z01K1Bl2vO8jzQVUleyTFQ3cs5For.pdf', 'teacher-documents/G7vX8AHIhEN6whrW6ZtZIpBEGgnV30pgtAAfqGg7.pdf', 'teacher-documents/UrZBzf5Y2JcDYrVLuy7PumO88GkofBAphhVqm0cZ.pdf', 1, '2025-03-26 17:00:54', '2025-03-26 17:10:44', NULL),
(4, 11, 'TCH20250003', 'michael', 'john', 'Tanzanian', 'male', '2025-03-05', '90-3934-23', '20010518352251343', '0983444', '067312833', '0733318464', 'jonaha@gmail.com', 'Dodoma', 'Dodoma', NULL, NULL, NULL, NULL, NULL, '2', 'eee', NULL, '09943444', '2025-03-11', '2025-03-10', NULL, '\"ddsffs\"', NULL, NULL, '\"fsfsfs\"', NULL, NULL, 'teacher-documents/9Hy4qdHMO4tERWiWKPxkIrJ0qSIQOtxbRwvJYtnj.pdf', 'teacher-documents/6KFG5aiiisqyUUG0ollZORAUetV1kjVeQPx3Va5e.pdf', 'teacher-documents/EsOZGdpvypwipkkovvsl8henVS6c4RSrIwMtsfbi.pdf', 'teacher-documents/CQlHbUw08cn9JyE5DWPSPmbVEDOJtS2A9Hunb51c.pdf', 'teacher-documents/v5vrUbBL0hDBCuIPfy52POVjzwH3fFYw2wqhWMF1.pdf', 'teacher-documents/NbBxh9MxoFRtqy3C5MglQXXWXQ4GDYzxFwQOE8U6.pdf', 1, '2025-03-26 17:44:06', '2025-03-26 17:44:06', NULL),
(5, 12, 'TCH20250004', 'Fatuma', 'Parot', 'Tanzanian', 'female', '2025-03-05', '90-3934-11', '200105183432510125', '0453444', '0673778464', '0788818464', 'fetty@gmil.com', 'Dar es salaam', 'Iringa', NULL, NULL, NULL, NULL, NULL, '2', 'eee', NULL, '09323434', '2024-12-10', '2025-02-25', NULL, '\"xxxx\"', NULL, NULL, '\"xxxx\"', NULL, NULL, 'teacher-documents/vDtpCePCi189c3ZchNt035dyHutleG8Ynt0tLo5B.pdf', 'teacher-documents/bY6xPoNOGgDI7N6g3JHq0Ufcjmn4kgfQwFrAPKPo.pdf', 'teacher-documents/uayk9dPl6DMkPv1tU4Dl5MF1IoKPAhEXshkstRnb.pdf', 'teacher-documents/DwYdtUnx6Z8ionM9fbhMWIRoXwxrUAaMN97SkbXx.pdf', 'teacher-documents/Zawkz9CEVEpas58vzfLT3dK2IzAs9IspqM5qL9HW.pdf', 'teacher-documents/b4OK5swFZwY3qAbFbaTCi39aUHDiAoZaf0DHeEhW.pdf', 1, '2025-03-26 19:48:07', '2025-03-26 19:48:07', NULL),
(6, 13, 'TCH20250005', 'Kipolopolo', 'Machande', 'Tanzanian', 'male', '2024-11-13', '90-3934-32', '2001051334510123', '09811444', '067314424', '0755676674', 'kipolopolo@gmail.com', 'Dodoma', 'Dodoma', NULL, NULL, NULL, NULL, NULL, '2', 'eee', NULL, '09554434', '2025-03-11', '2025-03-27', NULL, '\"sfgff\"', NULL, NULL, '\"sfsff\"', NULL, NULL, 'teacher-documents/hubBbcgdkitppcfZeG6fLdWbWbCp1UrM3QP6Czb8.pdf', 'teacher-documents/2cwLi9bsPnkJh07rRav4IdzJQ38Gsa373OiMpGQn.pdf', 'teacher-documents/6nyaKq2YjSwmO41oT65StMXF0OG0LqoGOf01uTqI.pdf', 'teacher-documents/w1OBeO61aStoC8BqZVh4URI1l6gf0vdZum3ktm5R.pdf', 'teacher-documents/x0MD8AAngEQ3JSXrAsjGulK7cOjBnLB6wxZ7yTwE.pdf', 'teacher-documents/kFoLqfHOzzw2yPBsVSmGIYDKLNjmkvN59tCvcdq5.pdf', 1, '2025-03-27 02:59:45', '2025-03-27 02:59:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_assignments`
--

CREATE TABLE `teacher_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `academic_level_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `term` enum('1','2','3') NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_assignments`
--

INSERT INTO `teacher_assignments` (`id`, `teacher_id`, `subject_id`, `academic_level_id`, `academic_year`, `term`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 1, 1, 1, '2025-2026', '1', 1, '2025-03-26 12:32:58', '2025-03-27 03:03:11', '2025-03-27 03:03:11'),
(5, 3, 4, 3, '2025-2026', '1', 1, '2025-03-26 17:11:38', '2025-03-27 00:02:19', '2025-03-27 00:02:19'),
(6, 5, 4, 3, '2025-2026', '1', 1, '2025-03-26 19:48:38', '2025-03-26 19:48:38', NULL),
(7, 3, 4, 2, '2025-2026', '1', 1, '2025-03-27 00:02:34', '2025-03-27 00:02:34', NULL),
(8, 1, 3, 3, '2025-2026', '1', 1, '2025-03-27 03:02:07', '2025-03-27 03:02:07', NULL),
(9, 1, 5, 4, '2025-2026', '1', 1, '2025-03-27 03:02:37', '2025-03-27 03:02:37', NULL),
(10, 1, 1, 4, '2025-2026', '1', 1, '2025-03-27 03:03:29', '2025-03-27 03:03:29', NULL),
(11, 1, 6, 4, '2025-2026', '1', 1, '2025-03-27 03:03:44', '2025-03-27 03:03:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teaching_schedules`
--

CREATE TABLE `teaching_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `academic_level_id` bigint(20) UNSIGNED NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room_number` varchar(255) NOT NULL,
  `wing` enum('A','B') NOT NULL,
  `academic_year` varchar(255) NOT NULL DEFAULT '2025-2026',
  `term` enum('1','2','3') NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teaching_schedules`
--

INSERT INTO `teaching_schedules` (`id`, `teacher_id`, `subject_id`, `academic_level_id`, `day_of_week`, `start_time`, `end_time`, `room_number`, `wing`, `academic_year`, `term`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 5, 4, 1, 'Monday', '10:31:00', '12:31:00', '1', 'A', '2025-2026', '1', 1, '2025-03-27 00:31:22', '2025-03-27 00:31:22', NULL),
(4, 1, 6, 2, 'Tuesday', '13:06:00', '15:06:00', '1', 'A', '2025-2026', '1', 1, '2025-03-27 03:06:15', '2025-03-27 03:06:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `academic_level_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `term` enum('1','2','3') NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`id`, `academic_level_id`, `academic_year`, `term`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-2026', '1', 1, '2025-03-26 19:32:05', '2025-03-26 19:32:05'),
(2, 1, '2025-2026', '1', 1, '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(3, 1, '2025-2026', '1', 1, '2025-04-19 10:20:28', '2025-04-19 10:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `timetable_slots`
--

CREATE TABLE `timetable_slots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `timetable_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room_number` varchar(255) DEFAULT NULL,
  `type` enum('class','break','lunch') NOT NULL DEFAULT 'class',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timetable_slots`
--

INSERT INTO `timetable_slots` (`id`, `timetable_id`, `subject_id`, `teacher_id`, `day_of_week`, `start_time`, `end_time`, `room_number`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 'Monday', '08:45:00', '09:45:00', 'Room 5', 'class', '2025-03-26 19:32:05', '2025-03-26 19:32:05'),
(2, 1, 4, NULL, 'Monday', '09:45:00', '10:45:00', 'Room 10', 'class', '2025-03-26 19:32:05', '2025-03-26 19:32:05'),
(3, 1, NULL, NULL, 'Monday', '10:45:00', '11:15:00', NULL, 'break', '2025-03-26 19:32:05', '2025-03-26 19:32:05'),
(4, 1, 4, NULL, 'Monday', '11:15:00', '12:15:00', 'Room 5', 'class', '2025-03-26 19:32:05', '2025-03-26 19:32:05'),
(5, 1, 3, NULL, 'Monday', '12:15:00', '13:15:00', 'Room 10', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(6, 1, NULL, NULL, 'Monday', '13:15:00', '14:15:00', NULL, 'lunch', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(7, 1, 1, NULL, 'Monday', '14:15:00', '15:15:00', 'Room 4', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(8, 1, 3, NULL, 'Monday', '15:15:00', '16:15:00', 'Room 7', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(9, 1, 5, NULL, 'Tuesday', '08:45:00', '09:45:00', 'Room 8', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(10, 1, 5, NULL, 'Tuesday', '09:45:00', '10:45:00', 'Room 5', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(11, 1, NULL, NULL, 'Tuesday', '10:45:00', '11:15:00', NULL, 'break', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(12, 1, 5, NULL, 'Tuesday', '11:15:00', '12:15:00', 'Room 1', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(13, 1, 5, NULL, 'Tuesday', '12:15:00', '13:15:00', 'Room 2', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(14, 1, NULL, NULL, 'Tuesday', '13:15:00', '14:15:00', NULL, 'lunch', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(15, 1, 3, NULL, 'Tuesday', '14:15:00', '15:15:00', 'Room 1', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(16, 1, 1, NULL, 'Tuesday', '15:15:00', '16:15:00', 'Room 3', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(17, 1, 5, NULL, 'Wednesday', '08:45:00', '09:45:00', 'Room 10', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(18, 1, 5, NULL, 'Wednesday', '09:45:00', '10:45:00', 'Room 10', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(19, 1, NULL, NULL, 'Wednesday', '10:45:00', '11:15:00', NULL, 'break', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(20, 1, 3, NULL, 'Wednesday', '11:15:00', '12:15:00', 'Room 8', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(21, 1, 5, NULL, 'Wednesday', '12:15:00', '13:15:00', 'Room 2', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(22, 1, NULL, NULL, 'Wednesday', '13:15:00', '14:15:00', NULL, 'lunch', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(23, 1, 4, NULL, 'Wednesday', '14:15:00', '15:15:00', 'Room 5', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(24, 1, 1, NULL, 'Wednesday', '15:15:00', '16:15:00', 'Room 2', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(25, 1, 3, NULL, 'Thursday', '08:45:00', '09:45:00', 'Room 5', 'class', '2025-03-26 19:32:06', '2025-03-26 19:32:06'),
(26, 1, 3, NULL, 'Thursday', '09:45:00', '10:45:00', 'Room 1', 'class', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(27, 1, NULL, NULL, 'Thursday', '10:45:00', '11:15:00', NULL, 'break', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(28, 1, 5, NULL, 'Thursday', '11:15:00', '12:15:00', 'Room 3', 'class', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(29, 1, 4, NULL, 'Thursday', '12:15:00', '13:15:00', 'Room 9', 'class', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(30, 1, NULL, NULL, 'Thursday', '13:15:00', '14:15:00', NULL, 'lunch', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(31, 1, 3, NULL, 'Thursday', '14:15:00', '15:15:00', 'Room 6', 'class', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(32, 1, 5, NULL, 'Thursday', '15:15:00', '16:15:00', 'Room 9', 'class', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(33, 1, 4, NULL, 'Friday', '08:45:00', '09:45:00', 'Room 10', 'class', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(34, 1, 4, NULL, 'Friday', '09:45:00', '10:45:00', 'Room 9', 'class', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(35, 1, NULL, NULL, 'Friday', '10:45:00', '11:15:00', NULL, 'break', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(36, 1, 3, NULL, 'Friday', '11:15:00', '12:15:00', 'Room 8', 'class', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(37, 1, 1, NULL, 'Friday', '12:15:00', '13:15:00', 'Room 8', 'class', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(38, 1, NULL, NULL, 'Friday', '13:15:00', '14:15:00', NULL, 'lunch', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(39, 1, 4, NULL, 'Friday', '14:15:00', '15:15:00', 'Room 6', 'class', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(40, 1, 3, NULL, 'Friday', '15:15:00', '16:15:00', 'Room 8', 'class', '2025-03-26 19:32:07', '2025-03-26 19:32:07'),
(41, 2, NULL, NULL, 'Monday', '08:45:00', '09:45:00', '17', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(42, 2, NULL, NULL, 'Monday', '09:45:00', '10:45:00', '1', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(43, 2, NULL, NULL, 'Monday', '10:45:00', '11:15:00', '20', 'break', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(44, 2, NULL, NULL, 'Monday', '11:15:00', '12:15:00', '19', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(45, 2, NULL, NULL, 'Monday', '12:15:00', '13:15:00', '4', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(46, 2, NULL, NULL, 'Monday', '13:15:00', '14:15:00', '15', 'lunch', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(47, 2, NULL, NULL, 'Monday', '14:15:00', '15:15:00', '6', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(48, 2, NULL, NULL, 'Monday', '15:15:00', '16:15:00', '16', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(49, 2, NULL, NULL, 'Tuesday', '08:45:00', '09:45:00', '15', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(50, 2, NULL, NULL, 'Tuesday', '09:45:00', '10:45:00', '8', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(51, 2, NULL, NULL, 'Tuesday', '10:45:00', '11:15:00', '15', 'break', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(52, 2, NULL, NULL, 'Tuesday', '11:15:00', '12:15:00', '2', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(53, 2, NULL, NULL, 'Tuesday', '12:15:00', '13:15:00', '8', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(54, 2, NULL, NULL, 'Tuesday', '13:15:00', '14:15:00', '6', 'lunch', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(55, 2, NULL, NULL, 'Tuesday', '14:15:00', '15:15:00', '13', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(56, 2, NULL, NULL, 'Tuesday', '15:15:00', '16:15:00', '1', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(57, 2, NULL, NULL, 'Wednesday', '08:45:00', '09:45:00', '16', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(58, 2, NULL, NULL, 'Wednesday', '09:45:00', '10:45:00', '18', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(59, 2, NULL, NULL, 'Wednesday', '10:45:00', '11:15:00', '16', 'break', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(60, 2, NULL, NULL, 'Wednesday', '11:15:00', '12:15:00', '13', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(61, 2, NULL, NULL, 'Wednesday', '12:15:00', '13:15:00', '7', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(62, 2, NULL, NULL, 'Wednesday', '13:15:00', '14:15:00', '17', 'lunch', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(63, 2, NULL, NULL, 'Wednesday', '14:15:00', '15:15:00', '16', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(64, 2, NULL, NULL, 'Wednesday', '15:15:00', '16:15:00', '18', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(65, 2, NULL, NULL, 'Thursday', '08:45:00', '09:45:00', '11', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(66, 2, NULL, NULL, 'Thursday', '09:45:00', '10:45:00', '1', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(67, 2, NULL, NULL, 'Thursday', '10:45:00', '11:15:00', '20', 'break', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(68, 2, NULL, NULL, 'Thursday', '11:15:00', '12:15:00', '6', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(69, 2, NULL, NULL, 'Thursday', '12:15:00', '13:15:00', '1', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(70, 2, NULL, NULL, 'Thursday', '13:15:00', '14:15:00', '2', 'lunch', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(71, 2, NULL, NULL, 'Thursday', '14:15:00', '15:15:00', '7', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(72, 2, NULL, NULL, 'Thursday', '15:15:00', '16:15:00', '17', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(73, 2, NULL, NULL, 'Friday', '08:45:00', '09:45:00', '6', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(74, 2, NULL, NULL, 'Friday', '09:45:00', '10:45:00', '10', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(75, 2, NULL, NULL, 'Friday', '10:45:00', '11:15:00', '20', 'break', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(76, 2, NULL, NULL, 'Friday', '11:15:00', '12:15:00', '16', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(77, 2, NULL, NULL, 'Friday', '12:15:00', '13:15:00', '1', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(78, 2, NULL, NULL, 'Friday', '13:15:00', '14:15:00', '13', 'lunch', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(79, 2, NULL, NULL, 'Friday', '14:15:00', '15:15:00', '8', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(80, 2, NULL, NULL, 'Friday', '15:15:00', '16:15:00', '5', 'class', '2025-04-19 05:31:24', '2025-04-19 05:31:24'),
(81, 3, NULL, NULL, 'Monday', '08:45:00', '09:45:00', '12', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(82, 3, NULL, NULL, 'Monday', '09:45:00', '10:45:00', '19', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(83, 3, NULL, NULL, 'Monday', '10:45:00', '11:15:00', '4', 'break', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(84, 3, NULL, NULL, 'Monday', '11:15:00', '12:15:00', '6', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(85, 3, NULL, NULL, 'Monday', '12:15:00', '13:15:00', '4', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(86, 3, NULL, NULL, 'Monday', '13:15:00', '14:15:00', '4', 'lunch', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(87, 3, NULL, NULL, 'Monday', '14:15:00', '15:15:00', '13', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(88, 3, NULL, NULL, 'Monday', '15:15:00', '16:15:00', '17', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(89, 3, NULL, NULL, 'Tuesday', '08:45:00', '09:45:00', '12', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(90, 3, NULL, NULL, 'Tuesday', '09:45:00', '10:45:00', '19', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(91, 3, NULL, NULL, 'Tuesday', '10:45:00', '11:15:00', '10', 'break', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(92, 3, NULL, NULL, 'Tuesday', '11:15:00', '12:15:00', '11', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(93, 3, NULL, NULL, 'Tuesday', '12:15:00', '13:15:00', '16', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(94, 3, NULL, NULL, 'Tuesday', '13:15:00', '14:15:00', '19', 'lunch', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(95, 3, NULL, NULL, 'Tuesday', '14:15:00', '15:15:00', '18', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(96, 3, NULL, NULL, 'Tuesday', '15:15:00', '16:15:00', '11', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(97, 3, NULL, NULL, 'Wednesday', '08:45:00', '09:45:00', '2', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(98, 3, NULL, NULL, 'Wednesday', '09:45:00', '10:45:00', '11', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(99, 3, NULL, NULL, 'Wednesday', '10:45:00', '11:15:00', '9', 'break', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(100, 3, NULL, NULL, 'Wednesday', '11:15:00', '12:15:00', '17', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(101, 3, NULL, NULL, 'Wednesday', '12:15:00', '13:15:00', '13', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(102, 3, NULL, NULL, 'Wednesday', '13:15:00', '14:15:00', '12', 'lunch', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(103, 3, NULL, NULL, 'Wednesday', '14:15:00', '15:15:00', '9', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(104, 3, NULL, NULL, 'Wednesday', '15:15:00', '16:15:00', '20', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(105, 3, NULL, NULL, 'Thursday', '08:45:00', '09:45:00', '3', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(106, 3, NULL, NULL, 'Thursday', '09:45:00', '10:45:00', '19', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(107, 3, NULL, NULL, 'Thursday', '10:45:00', '11:15:00', '9', 'break', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(108, 3, NULL, NULL, 'Thursday', '11:15:00', '12:15:00', '16', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(109, 3, NULL, NULL, 'Thursday', '12:15:00', '13:15:00', '7', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(110, 3, NULL, NULL, 'Thursday', '13:15:00', '14:15:00', '19', 'lunch', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(111, 3, NULL, NULL, 'Thursday', '14:15:00', '15:15:00', '6', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(112, 3, NULL, NULL, 'Thursday', '15:15:00', '16:15:00', '4', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(113, 3, NULL, NULL, 'Friday', '08:45:00', '09:45:00', '12', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(114, 3, NULL, NULL, 'Friday', '09:45:00', '10:45:00', '3', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(115, 3, NULL, NULL, 'Friday', '10:45:00', '11:15:00', '9', 'break', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(116, 3, NULL, NULL, 'Friday', '11:15:00', '12:15:00', '15', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(117, 3, NULL, NULL, 'Friday', '12:15:00', '13:15:00', '17', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(118, 3, NULL, NULL, 'Friday', '13:15:00', '14:15:00', '14', 'lunch', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(119, 3, NULL, NULL, 'Friday', '14:15:00', '15:15:00', '16', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28'),
(120, 3, NULL, NULL, 'Friday', '15:15:00', '16:15:00', '4', 'class', '2025-04-19 10:20:28', '2025-04-19 10:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `class_level` varchar(255) NOT NULL,
  `learning_objectives` text DEFAULT NULL,
  `duration` enum('1 Week','2 Weeks','3 Weeks','4 Weeks','1 Month','2 Months','Term') NOT NULL,
  `teaching_methods` text DEFAULT NULL,
  `assessment_methods` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `subject_id`, `name`, `class_level`, `learning_objectives`, `duration`, `teaching_methods`, `assessment_methods`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 4, 'Lugha Sanifu', 'Primary 4', NULL, '2 Weeks', NULL, NULL, 0, 1, '2025-03-27 02:43:45', '2025-03-27 02:43:45'),
(3, 6, 'Kusikiliza na Kuzungumza', 'Primary 3', NULL, '2 Weeks', NULL, NULL, 0, 1, '2025-03-29 09:46:01', '2025-03-29 09:46:01'),
(4, 9, 'Listening and Speaking', 'Primary 3', NULL, '2 Weeks', NULL, NULL, 0, 1, '2025-03-29 09:47:44', '2025-03-29 09:47:44'),
(5, 7, 'Numbers and Operations', 'Primary 3', NULL, '1 Week', NULL, NULL, 0, 1, '2025-03-29 09:49:03', '2025-03-29 09:49:03'),
(6, 13, 'Handcraft and Creativity', 'Primary 3', NULL, '3 Weeks', NULL, NULL, 0, 1, '2025-03-29 09:50:09', '2025-03-29 09:50:09'),
(7, 3, 'Living Things and Their Environment', 'Primary 3', NULL, '3 Weeks', NULL, NULL, 0, 1, '2025-03-29 09:51:45', '2025-03-29 09:51:45'),
(8, 14, 'Physical Fitness', 'Primary 3', NULL, 'Term', NULL, NULL, 0, 1, '2025-03-29 09:53:09', '2025-03-29 09:53:09'),
(9, 6, 'Kuimba kwa kuguna', 'Primary 3', NULL, '1 Week', NULL, NULL, 0, 1, '2025-03-31 14:31:24', '2025-03-31 14:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `topic_activities`
--

CREATE TABLE `topic_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `topic_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('Assignment','Quiz','Homework') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topic_activities`
--

INSERT INTO `topic_activities` (`id`, `topic_id`, `type`, `title`, `description`, `created_at`, `updated_at`) VALUES
(3, 2, 'Quiz', 'Will work on them', NULL, '2025-03-27 02:43:45', '2025-03-27 02:43:45'),
(4, 2, 'Homework', 'things', NULL, '2025-03-27 02:43:45', '2025-03-27 02:43:45'),
(5, 3, 'Quiz', 'Mazungumzo ya kila siku', NULL, '2025-03-29 09:46:01', '2025-03-29 09:46:01'),
(6, 3, 'Homework', 'Matumizi sahihi ya lugha', NULL, '2025-03-29 09:46:01', '2025-03-29 09:46:01'),
(7, 4, 'Quiz', 'Pronouncing words correctly', NULL, '2025-03-29 09:47:44', '2025-03-29 09:47:44'),
(8, 4, 'Quiz', 'Expressing personal opinions', NULL, '2025-03-29 09:47:44', '2025-03-29 09:47:44'),
(9, 5, 'Quiz', 'Addition and subtraction', NULL, '2025-03-29 09:49:03', '2025-03-29 09:49:03'),
(10, 6, 'Homework', 'Planting and caring for crops', NULL, '2025-03-29 09:50:09', '2025-03-29 09:50:09'),
(11, 7, 'Quiz', 'Understanding weather changes', NULL, '2025-03-29 09:51:45', '2025-03-29 09:51:45'),
(12, 7, 'Homework', 'Effects of weather on daily life', NULL, '2025-03-29 09:51:45', '2025-03-29 09:51:45'),
(13, 7, 'Homework', 'Animals and their uses', NULL, '2025-03-29 09:51:45', '2025-03-29 09:51:45'),
(14, 8, 'Homework', 'First aid basics', NULL, '2025-03-29 09:53:09', '2025-03-29 09:53:09'),
(15, 9, 'Quiz', 'Kujua kutenga miguno', NULL, '2025-03-31 14:31:24', '2025-03-31 14:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('admin','teacher','supervisor','student','user') NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `avatar`, `role`, `is_active`, `phone`, `address`, `employee_id`, `department`, `email_verified_at`, `password`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Haha!, Boss', 'admin', 'admin@example.com', 'avatar-1.jpg', 'admin', 1, '1234567890', 'Admin Address', 'EMP001', 'Administration', NULL, '$2y$10$OuVdsK1Yzy76y0O7debh5uJlWKutI5Q/6tabLKzkqgy5fh8Xj1BWC', '2025-04-23 09:41:39', '4U0zhPN9V7hZSGdOpA0p87lcSi6Um5PREAr59OzMvHL6Q9H8uaZJSyrpG1GZ', '2025-03-26 00:02:44', '2025-04-23 09:41:39'),
(2, 'Teacher User', 'teacher1', 'teacher1@school.com', 'avatar-2.jpg', 'teacher', 1, '1234567891', 'Teacher Address', 'EMP002', 'Teaching', NULL, '$2y$10$zbcLb41awo8XZ0ovRvxHUOu9kvnrx7dNzRWHBZm.TeefkuD7Ajg/W', NULL, NULL, '2025-03-26 00:02:44', '2025-03-26 00:02:44'),
(3, 'Supervisor User', 'supervisor1', 'supervisor1@school.com', 'avatar-3.jpg', 'supervisor', 1, '1234567892', 'Supervisor Address', 'EMP003', 'Supervision', NULL, '$2y$10$btONwdb0.gMOmepvU7Sm9.af8lcMrjz/D4GpPMIt41KASfLQHVO8S', NULL, NULL, '2025-03-26 00:02:44', '2025-03-26 00:02:44'),
(4, 'Gerald Ndyamukama', 'TCH20250001', 'geraldndyamukama39@gmail.com', NULL, 'teacher', 1, NULL, NULL, NULL, NULL, NULL, '$2y$10$.1jihKlHnwj1ygI/AnhEHuUM/y.sXcDWpha0Ga2BHvUwy8m5BMy6W', '2025-04-17 17:57:03', NULL, '2025-03-26 03:30:27', '2025-04-17 17:57:03'),
(9, 'lucas Michael', 'TCH20250002', 'leo@gmail.com', NULL, 'teacher', 1, NULL, NULL, NULL, NULL, NULL, '$2y$10$vjlCHumkkmW./4VkC9Jbr.eWk53GSLDzFcIbbod81if8Q/Tup8QY2', NULL, NULL, '2025-03-26 17:00:54', '2025-03-26 17:00:54'),
(11, 'michael john', 'TCH20250003', 'jonaha@gmail.com', NULL, 'teacher', 1, NULL, NULL, NULL, NULL, NULL, '$2y$10$d1Bk1mbg3B4SzVE9a9I4beQ4WG.TRMryiFJd8H//fa.UzSPf4Lx.W', NULL, NULL, '2025-03-26 17:44:06', '2025-03-26 17:44:06'),
(12, 'Fatuma Parot', 'TCH20250004', 'fetty@gmil.com', NULL, 'teacher', 1, NULL, NULL, NULL, NULL, NULL, '$2y$10$CmROJ2ysv1ui7II.4tJidu5/iUpePcpwGmjvUYSevdOO29BnCYt9i', '2025-03-29 06:04:23', NULL, '2025-03-26 19:48:07', '2025-03-29 06:04:23'),
(13, 'Kipolopolo Machande', 'TCH20250005', 'kipolopolo@gmail.com', NULL, 'teacher', 1, NULL, NULL, NULL, NULL, NULL, '$2y$10$hbLc0sQtPOdsCBiznfsiueFIaLEPeDesazMyt1U1nu1Ny3VjUh5i2', NULL, NULL, '2025-03-27 02:59:45', '2025-03-27 02:59:45'),
(35, 'Katoto Mtoko', 'GT-2025-9268', 'mtoto@gmail.com', NULL, 'student', 1, NULL, NULL, NULL, NULL, NULL, '$2y$10$KGujIaIaaS9F47zPBkkWJejfUyBHP2KmrKDtsQ2yjBg492cM.LaUC', '2025-04-23 09:34:30', 'DcgCdqZmvCk9UBnhDTmG22WH1bd9phr1Jjgohti9PiyNaiOYGh9Gylcm7NDS', '2025-03-28 02:40:40', '2025-04-23 09:34:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_levels`
--
ALTER TABLE `academic_levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `academic_levels_code_unique` (`code`),
  ADD UNIQUE KEY `academic_levels_order_unique` (`order`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fee_structures_fee_type_id_foreign` (`fee_type_id`),
  ADD KEY `fee_structures_academic_level_id_foreign` (`academic_level_id`);

--
-- Indexes for table `fee_types`
--
ALTER TABLE `fee_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fee_types_code_unique` (`code`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `invoices_student_id_foreign` (`student_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_items_fee_structure_id_foreign` (`fee_structure_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_receipt_number_unique` (`receipt_number`),
  ADD KEY `payments_invoice_id_foreign` (`invoice_id`),
  ADD KEY `payments_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `results_student_id_foreign` (`student_id`),
  ADD KEY `results_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_admission_number_unique` (`admission_number`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_academic_level_id_foreign` (`academic_level_id`),
  ADD KEY `students_guardian_id_foreign` (`guardian_id`);

--
-- Indexes for table `student_subject`
--
ALTER TABLE `student_subject`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_subject_student_id_subject_id_unique` (`student_id`,`subject_id`),
  ADD KEY `student_subject_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subjects_code_unique` (`code`);

--
-- Indexes for table `subtopics`
--
ALTER TABLE `subtopics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subtopics_topic_id_foreign` (`topic_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_employee_id_unique` (`employee_id`),
  ADD UNIQUE KEY `teachers_email_unique` (`email`),
  ADD UNIQUE KEY `teachers_national_id_unique` (`national_id`),
  ADD UNIQUE KEY `teachers_passport_number_unique` (`passport_number`),
  ADD KEY `teachers_user_id_foreign` (`user_id`);

--
-- Indexes for table `teacher_assignments`
--
ALTER TABLE `teacher_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_assignments_teacher_id_foreign` (`teacher_id`),
  ADD KEY `teacher_assignments_subject_id_foreign` (`subject_id`),
  ADD KEY `teacher_assignments_academic_level_id_foreign` (`academic_level_id`);

--
-- Indexes for table `teaching_schedules`
--
ALTER TABLE `teaching_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teaching_schedules_teacher_id_foreign` (`teacher_id`),
  ADD KEY `teaching_schedules_subject_id_foreign` (`subject_id`),
  ADD KEY `teaching_schedules_academic_level_id_foreign` (`academic_level_id`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timetables_academic_level_id_foreign` (`academic_level_id`);

--
-- Indexes for table `timetable_slots`
--
ALTER TABLE `timetable_slots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `timetable_slots_timetable_id_day_of_week_start_time_unique` (`timetable_id`,`day_of_week`,`start_time`),
  ADD UNIQUE KEY `teacher_schedule_conflict` (`teacher_id`,`day_of_week`,`start_time`),
  ADD KEY `timetable_slots_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topics_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `topic_activities`
--
ALTER TABLE `topic_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_activities_topic_id_foreign` (`topic_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_levels`
--
ALTER TABLE `academic_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_structures`
--
ALTER TABLE `fee_structures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `fee_types`
--
ALTER TABLE `fee_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_subject`
--
ALTER TABLE `student_subject`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `subtopics`
--
ALTER TABLE `subtopics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teacher_assignments`
--
ALTER TABLE `teacher_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teaching_schedules`
--
ALTER TABLE `teaching_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `timetable_slots`
--
ALTER TABLE `timetable_slots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `topic_activities`
--
ALTER TABLE `topic_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD CONSTRAINT `fee_structures_academic_level_id_foreign` FOREIGN KEY (`academic_level_id`) REFERENCES `academic_levels` (`id`),
  ADD CONSTRAINT `fee_structures_fee_type_id_foreign` FOREIGN KEY (`fee_type_id`) REFERENCES `fee_types` (`id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_fee_structure_id_foreign` FOREIGN KEY (`fee_structure_id`) REFERENCES `fee_structures` (`id`),
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_academic_level_id_foreign` FOREIGN KEY (`academic_level_id`) REFERENCES `academic_levels` (`id`),
  ADD CONSTRAINT `students_guardian_id_foreign` FOREIGN KEY (`guardian_id`) REFERENCES `guardians` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_subject`
--
ALTER TABLE `student_subject`
  ADD CONSTRAINT `student_subject_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subject_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subtopics`
--
ALTER TABLE `subtopics`
  ADD CONSTRAINT `subtopics_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_assignments`
--
ALTER TABLE `teacher_assignments`
  ADD CONSTRAINT `teacher_assignments_academic_level_id_foreign` FOREIGN KEY (`academic_level_id`) REFERENCES `academic_levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_assignments_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_assignments_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teaching_schedules`
--
ALTER TABLE `teaching_schedules`
  ADD CONSTRAINT `teaching_schedules_academic_level_id_foreign` FOREIGN KEY (`academic_level_id`) REFERENCES `academic_levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teaching_schedules_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teaching_schedules_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timetables`
--
ALTER TABLE `timetables`
  ADD CONSTRAINT `timetables_academic_level_id_foreign` FOREIGN KEY (`academic_level_id`) REFERENCES `academic_levels` (`id`);

--
-- Constraints for table `timetable_slots`
--
ALTER TABLE `timetable_slots`
  ADD CONSTRAINT `timetable_slots_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `timetable_slots_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`),
  ADD CONSTRAINT `timetable_slots_timetable_id_foreign` FOREIGN KEY (`timetable_id`) REFERENCES `timetables` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `topic_activities`
--
ALTER TABLE `topic_activities`
  ADD CONSTRAINT `topic_activities_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
