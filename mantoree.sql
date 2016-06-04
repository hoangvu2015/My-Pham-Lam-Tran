-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2015 at 02:32 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mantoree`
--

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_09_04_074807_entrust_setup_tables', 1),
('2015_09_08_163354_create_topics_table', 1),
('2015_09_10_161743_create_session_table', 1),
('2015_09_11_142935_create_learning_request_table', 1),
('2015_09_14_145105_create_teachers_table', 1),
('2015_09_14_145119_create_students_table', 1),
('2015_09_14_145757_create_classrooms_table', 1),
('2015_09_20_163939_courses', 1),
('2015_09_20_191910_create_user_notifications', 1),
('2015_09_23_233308_topics_courses', 1),
('2015_09_24_132258_create_reviews_table', 1),
('2015_09_25_100833_create_topics_teachers_table', 1),
('2015_09_28_072223_blog_categories', 1),
('2015_09_28_072311_blog_articles', 1),
('2015_09_28_072349_blog_categories_articles', 1),
('2015_10_01_165222_create_tmp_learning_requests_table', 1),
('2015_10_01_170247_create_app_options_table', 1),
('2015_10_09_071253_create_user_works_table', 1),
('2015_10_09_071316_create_user_educations_table', 1),
('2015_10_13_115224_modify_users', 1),
('2015_10_13_134655_create_jobs_table', 1),
('2015_10_13_211502_create_failed_jobs_table', 1),
('2015_10_14_142720_enable_multilang_topics', 1),
('2015_10_26_055508_update_tmp_learning_request', 1),
('2015_10_26_220035_update_categories_and_articles', 1),
('2015_10_26_235556_update_teachers', 1),
('2015_10_29_033953_create_link_items_table', 1),
('2015_10_29_083624_link_categories_link_items', 1),
('2015_10_30_023131_create_theme_widget', 1),
('2015_11_03_062437_create_user_records', 1),
('2015_11_09_205852_fix_links', 1),
('2015_11_11_235302_update_reviews', 1),
('2015_11_11_235348_create_article_reviews', 1),
('2015_11_15_200138_update_reviews2', 1),
('2015_11_18_040611_update_teacher2', 1),
('2015_11_18_161217_update_blog_article2', 1),
('2015_11_19_091338_create_tests', 1),
('2015_11_19_093328_create_questions', 1),
('2015_11_19_093937_create_answers', 1),
('2015_11_19_094443_create_tests_questions', 1),
('2015_11_20_020555_create_lessons', 1),
('2015_11_20_021903_create_tests_lessons', 1),
('2015_11_20_030551_create_tests_courses', 1),
('2015_11_20_031900_update_courses_new', 1),
('2015_11_23_115727_create_topics_lessons_table', 1),
('2015_11_23_115749_create_courses_lessons_table', 1),
('2015_11_30_115555_create_course_reviews', 1);

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'access-admin', 'Access admin', 'Access admin pages', '2015-12-13 17:14:15', '2015-12-13 17:14:15'),
(2, 'compose-blog-articles', 'Compose blog articles', 'Add/Edit/Delete blog articles', '2015-12-13 17:14:15', '2015-12-13 17:14:15'),
(3, 'compose-learning-resources', 'Compose learning resources', 'Add/Edit/Delete learning resources such as courses, lessons, tests', '2015-12-13 17:14:15', '2015-12-13 17:14:15');

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(3, 3),
(3, 4),
(1, 5),
(2, 5),
(2, 6),
(2, 9),
(3, 9);

--
-- Dumping data for table `realtime_channels`
--

INSERT INTO `realtime_channels` (`id`, `secret`, `name`, `type`, `created_at`, `updated_at`) VALUES
(1, 'nt_566e09dab26366.00172525', NULL, 'notification', '2015-12-13 17:14:18', '2015-12-13 17:14:18');

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `public`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 'admin', 'Administrator', 'Manage system''s operation', '2015-12-13 17:14:16', '2015-12-13 17:14:16'),
(2, 0, 'learning-manager', 'Learning Manager', 'Manage learning items such as teachers, students, learning requests', '2015-12-13 17:14:16', '2015-12-13 17:14:16'),
(3, 0, 'learning-editor', 'Learning Editor', 'Manage learning resources such as topics, courses, lessons, tests', '2015-12-13 17:14:17', '2015-12-13 17:14:17'),
(4, 0, 'learning-contributor', 'Learning Contributor', 'Compose learning resources such as courses, lessons, tests', '2015-12-13 17:14:17', '2015-12-13 17:14:17'),
(5, 0, 'blog-editor', 'Blog Editor', 'Manage blog items', '2015-12-13 17:14:17', '2015-12-13 17:14:17'),
(6, 0, 'blog-contributor', 'Blog Contributor', 'Compose blog articles', '2015-12-13 17:14:18', '2015-12-13 17:14:18'),
(7, 0, 'supporter', 'Supporter', 'Help students to make their best choices', '2015-12-13 17:14:18', '2015-12-13 17:14:18'),
(8, 1, 'student', 'Student', 'Learning courses', '2015-12-13 17:14:18', '2015-12-13 17:14:18'),
(9, 1, 'teacher', 'Teacher', 'Teaching students', '2015-12-13 17:14:18', '2015-12-13 17:14:18');

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 5);

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `payload`, `last_activity`, `client_ip`, `support_key`, `user_id`, `status`) VALUES
('e519adddc09d76aacc1f24d714786c0a65c8809d', 'YTo2OntzOjU6ImZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NjoiX3Rva2VuIjtzOjQwOiJWVEFEVFpmNFpSR3dVVk96TFUxOExDUmFWZTU5bG1hVHRqb2J6aHpEIjtzOjEyOiJsb2NhbGl6YXRpb24iO2E6ODp7czo3OiJjb3VudHJ5IjtzOjI6IlVTIjtzOjg6InRpbWV6b25lIjtzOjU6IlVUQys3IjtzOjE3OiJmaXJzdF9kYXlfb2Zfd2VlayI7aTowO3M6MTY6ImxvbmdfZGF0ZV9mb3JtYXQiO2k6MDtzOjE3OiJzaG9ydF9kYXRlX2Zvcm1hdCI7aToyO3M6MTY6ImxvbmdfdGltZV9mb3JtYXQiO2k6MDtzOjE3OiJzaG9ydF90aW1lX2Zvcm1hdCI7aTowO3M6ODoibGFuZ3VhZ2UiO3M6MjoidmkiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NzoiaHR0cDovL2xvY2FsaG9zdC9tYW50b3JlZS92aS94YWMtdGh1Yy9kYW5nLW5oYXAiO31zOjY6ImxvY2FsZSI7czoyOiJ2aSI7czo5OiJfc2YyX21ldGEiO2E6Mzp7czoxOiJ1IjtpOjE0NDk4MzQ3Mjc7czoxOiJjIjtpOjE0NDk4MzQ3MDc7czoxOiJsIjtzOjE6IjAiO319', 1449834728, '::1', 'mod_sp_566ab8e89fa256.83016645_', NULL, '');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `provider`, `provider_id`, `profile_picture`, `name`, `slug`, `channel_id`, `phone`, `phone_verified`, `skype`, `gender`, `date_of_birth`, `address`, `city`, `country`, `language`, `timezone`, `first_day_of_week`, `long_date_format`, `short_date_format`, `long_time_format`, `short_time_format`, `activation_code`, `active`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `phone_code`, `voice`, `interests`, `facebook`, `fastest_contact_ways`, `bio`) VALUES
(1, 'admin@antoree.com', '$2y$10$lpfTMR0LXKsri24B2tPMCurkQ1EE9hN8Cru33T6Yq.MMREBrJEGAq', '', '', 'http://localhost/mantoree/storage/app/profile_pictures/default.png', 'Admin', 'admin', 1, '', 0, '', '', NULL, NULL, NULL, 'US', 'en', 'UTC', 0, 0, 0, 0, 0, 'VebsWPL27qLbEU4Kd4h0BZGh8I9lCX0B', 1, NULL, '2015-12-13 17:14:19', '2015-12-13 17:14:19', NULL, 'US', '', '', '', '', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
