-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2025 at 09:48 PM
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
-- Database: `login_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `message`, `created_at`, `file_path`) VALUES
(11, 278366, 'BAN HIM PLSS', '2025-08-15 17:23:50', 'uploads/feedback/fb_278366_1755278630_5303.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_id` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pin` varchar(5) NOT NULL,
  `color` varchar(16) DEFAULT '#3a7bd5',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text NOT NULL,
  `is_private` tinyint(1) DEFAULT 0,
  `member_count` int(11) DEFAULT 0,
  `category` enum('game','music','movie','sport','tourism','other') DEFAULT 'other',
  `allowed_mbti` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_id`, `name`, `pin`, `color`, `image`, `created_at`, `description`, `is_private`, `member_count`, `category`, `allowed_mbti`) VALUES
(31, '756829', 'WOW', '6431', '#3a7bd5', 'uploads/group_1755261828_3612.jpg', '2025-08-12 23:06:59', 'TEST', 0, 0, 'game', NULL),
(32, '264838', 'Cursed Music', '31232', '#3a7bd5', 'uploads/group_1755112061_7559.jpg', '2025-08-13 19:07:41', 'Just Found a song that I looking for', 0, 0, 'music', NULL),
(33, '062996', 'Recommend Movie Group', '28686', '#cdff1a', 'uploads/group_1755112146_8405.jpg', '2025-08-13 19:09:06', 'Finally Some good movie', 0, 0, 'movie', NULL),
(34, '944480', 'Bet Group', '51946', '#000000', 'uploads/group_1755112203_9391.jpg', '2025-08-13 19:10:03', 'Just BET', 0, 0, 'sport', NULL),
(35, '157296', 'Recommend Jail', '4828', '#3a7bd5', 'uploads/group_1755112261_6873.jpg', '2025-08-13 19:11:01', 'I\'m going to jail', 0, 0, 'tourism', NULL),
(36, '792884', 'IDK', '1597', '#ff0a0a', 'uploads/group_1755112320_6691.jpg', '2025-08-13 19:12:00', 'IDK', 0, 0, 'other', NULL),
(37, '727016', 'GameDEV', '6216', '#020912', 'uploads/group_1755112636_8773.jpg', '2025-08-13 19:17:16', 'DEV LISTENED', 0, 0, 'game', NULL),
(41, '139585', 'GET OUT', '5371', '#3a7bd5', 'uploads/group_1755279152_1244.png', '2025-08-15 17:32:32', 'GET OUT', 0, 0, 'other', 'ENFP');

-- --------------------------------------------------------

--
-- Table structure for table `group_analytics`
--

CREATE TABLE `group_analytics` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `message_count` int(11) DEFAULT 0,
  `active_members` int(11) DEFAULT 0,
  `engagement_score` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_reports`
--

CREATE TABLE `group_reports` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `report_type` enum('weekly','monthly') NOT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `total_messages` int(11) DEFAULT 0,
  `active_members` int(11) DEFAULT 0,
  `avg_response_time` decimal(10,2) DEFAULT 0.00,
  `sentiment_score` decimal(3,2) DEFAULT 0.00,
  `mbti_distribution` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`mbti_distribution`)),
  `recommendations` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mbti_compatibility`
--

CREATE TABLE `mbti_compatibility` (
  `id` int(11) NOT NULL,
  `type1` varchar(4) NOT NULL,
  `type2` varchar(4) NOT NULL,
  `compatibility_score` decimal(3,2) NOT NULL,
  `relationship_type` enum('golden_pair','compatible','neutral','challenging') DEFAULT 'neutral'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mbti_compatibility`
--

INSERT INTO `mbti_compatibility` (`id`, `type1`, `type2`, `compatibility_score`, `relationship_type`) VALUES
(1, 'INTJ', 'ENFP', 0.95, 'golden_pair'),
(2, 'INTP', 'ENFJ', 0.95, 'golden_pair'),
(3, 'ENTJ', 'INFP', 0.95, 'golden_pair'),
(4, 'ENTP', 'INFJ', 0.95, 'golden_pair'),
(5, 'ISTJ', 'ESFP', 0.90, 'compatible'),
(6, 'ISFJ', 'ESTP', 0.90, 'compatible'),
(7, 'ESTJ', 'ISFP', 0.90, 'compatible'),
(8, 'ESFJ', 'ISTP', 0.90, 'compatible');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `group_id`, `user_id`, `message`, `created_at`, `file_path`) VALUES
(44, 41, 278366, 'GOOD', '2025-08-16 02:26:11', NULL),
(45, 41, 278366, 'GUY', '2025-08-16 02:31:28', 'uploads/1755286288_cat.jpg'),
(46, 37, 278366, 'DOG', '2025-08-16 02:42:15', 'uploads/1755286935_Capture.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_at`) VALUES
(1, 'site_name', 'TypeHub', 'Website name', '2025-08-12 22:51:10'),
(2, 'max_group_members', '50', 'Maximum members per group', '2025-08-08 18:28:50'),
(3, 'ai_analysis_enabled', '1', 'Enable AI personality analysis', '2025-08-08 18:28:50'),
(4, 'notification_system', '1', 'Enable notification system', '2025-08-08 18:28:50'),
(5, 'site_desc', 'Your trusted MBTI collaboration platform', NULL, '2025-08-12 22:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `mbti` varchar(4) DEFAULT NULL,
  `about` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `banned_until` datetime DEFAULT NULL,
  `interested_category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_name`, `password`, `date`, `email`, `phone`, `mbti`, `about`, `image`, `banned_until`, `interested_category`) VALUES
(5, 1001, 'AnanyaR', 'pass1234', '2025-08-15 16:42:45', 'ananya.r@gmail.com', '0891234567', 'INFJ', 'A passionate UI/UX designer from Bangkok.', 'uploads/profile_1001_1754240818.png', NULL, 'tourism'),
(6, 1002, 'ThanapatMC', '1234abcd', '2025-08-14 03:06:36', 'thanapat.mc@hotmail.com', '0819876543', 'ENTP', 'A tech lover who enjoys building things from scratch.', 'uploads/profile_1002_1754240852.png', '2025-08-15 05:06:36', 'music'),
(7, 1003, 'JiraKit', 'myp@ssword', '2025-08-13 19:06:36', 'jirapat.k@gmail.com', '0623456789', 'INFP', 'Quiet thinker who enjoys meaningful connections.', NULL, NULL, 'music'),
(8, 1004, 'KanyaSuda', 'hello@123', '2025-08-13 19:09:18', 'k.srisuda@yahoo.com', '0837654321', 'ESFJ', 'Friendly, warm-hearted, and driven to help others.', NULL, NULL, 'tourism'),
(9, 1005, 'NattaBM', 'boonmee99', '2025-08-13 19:10:14', 'nattawut.b@hotmail.com', '0951237890', 'ISTP', 'Love exploring how things work and solving problems.', NULL, NULL, 'music'),
(10, 1006, 'PNamS', 'coolpass12', '2025-08-13 19:11:23', 'p.namsai@gmail.com', '0889911223', 'ENTJ', 'Strategic leader with a passion for development.', NULL, NULL, 'music'),
(11, 1007, 'RattanaTW', 'rat@secure', '2025-08-13 19:12:53', 'rattana.tw@gmail.com', '0865544332', 'ISFJ', 'Loyal and considerate, always ready to help.', NULL, NULL, 'other'),
(12, 1008, 'ChaninWW', 'wwchanin88', '2025-08-13 19:13:14', 'chanin.w@gmail.com', '0894455661', 'ENFP', 'Energetic, creative, and loves to inspire others.', NULL, NULL, 'music'),
(13, 1009, 'SirinLS', 'sirinpass', '2025-08-13 19:13:29', 'sirin.ls@gmail.com', '0841122334', 'ISTJ', 'Responsible and values tradition and order.', NULL, NULL, 'sport'),
(14, 1010, 'PongThav', 'ptsecure', '2025-08-13 19:13:41', 'pongsak.t@hotmail.com', '0905566778', 'ESTP', 'Bold and spontaneous, lives life to the fullest.', NULL, NULL, 'movie'),
(15, 3001, 'jamie33', ')r8u^Zwm(!', '2025-08-13 19:13:56', 'obeck@hotmail.com', '0475530541', 'INFP', 'Dark experience drive art safe somebody.', NULL, NULL, 'game'),
(16, 3002, 'cookmary', '+UE@&r5j6S', '2025-08-13 19:14:07', 'qrodriguez@bell-garner.com', '3250745204', 'ESFP', 'Our ten instead common create police clear memory for.', NULL, NULL, 'tourism'),
(17, 3003, 'kimberlythomas', 'F+iHbDfe*3', '2025-08-13 19:14:48', 'maria00@yahoo.com', '985.599.39', 'ISTJ', 'Point song would need miss notice draw certain.', NULL, NULL, 'music'),
(18, 3004, 'daniel17', 'SM+g*6Fr$v', '2025-08-13 19:15:29', 'morganjeremiah@gmail.com', '757.330.61', 'INFJ', 'Wear instead price common common western be ball certain good score yeah.', NULL, NULL, 'movie'),
(19, 3005, 'margaret98', '$Y%o^uhr2F', '2025-08-13 19:15:45', 'xhenderson@hotmail.com', '8170211905', 'ESFJ', 'Billion agree however building help son hand another.', NULL, NULL, 'game'),
(20, 3006, 'dennis67', 'A2m%6lUt3(', '2025-08-13 19:15:53', 'tina08@campos.com', '7778575647', 'INTJ', 'Admit begin message need standard build.', NULL, NULL, 'game'),
(21, 3007, 'stacy15', '!9)F)OFb&M', '2025-08-13 19:17:25', 'reneemcdonald@jensen.com', '1748045637', 'ESFJ', 'Tv wrong future here message least tax.', NULL, NULL, 'game'),
(22, 3008, 'jeff31', '@2QB$P11nn', '2025-08-03 16:16:01', 'lauren09@hotmail.com', '2545592507', 'ENFP', 'Key next brother style institution world state more billion yes teach run.', NULL, NULL, NULL),
(23, 3009, 'jimenezkelly', '&A6XShexmg', '2025-08-03 16:16:01', 'nelsonjustin@glover.com', '+101942754', 'ENTP', 'Popular allow rate right mouth trouble owner behind marriage we cultural teacher seek.', NULL, NULL, NULL),
(24, 3010, 'irobinson', 'j5aRNA(D$z', '2025-08-03 16:16:01', 'colinperry@powers.biz', '3544508669', 'ESFJ', 'Outside into free one finally member rest learn executive article.', NULL, NULL, NULL),
(25, 3011, 'tayloranthony', '3#N7moUf$2', '2025-08-03 16:16:01', 'terricastaneda@yahoo.com', '0016961777', 'ESTJ', 'Hit shoulder compare drug maintain politics middle box drop girl.', NULL, NULL, NULL),
(26, 3012, 'cobbpatrick', 'W3&OSa_1(R', '2025-08-03 16:16:01', 'qnunez@dean.com', '0018688948', 'ESFJ', 'Glass couple thousand hair focus voice American them wife simple able strong catch.', NULL, NULL, NULL),
(27, 3013, 'jenniferbright', 's5JH+NuL&!', '2025-08-03 16:16:01', 'diana18@white-kim.com', '0328090667', 'INTP', 'Soon keep hour water success which baby state how loss.', NULL, NULL, NULL),
(28, 3014, 'ayerstimothy', '51jfp%Tm*b', '2025-08-03 16:16:01', 'carol59@hotmail.com', '0395435279', 'ISTJ', 'Story arrive time center majority region road performance stay.', NULL, NULL, NULL),
(29, 3015, 'bennettchristopher', '&BE2tKxF22', '2025-08-03 16:16:01', 'ingramjames@gay.com', '8736266596', 'ISFP', 'Green general campaign smile energy kid believe lot able these whole decade.', NULL, NULL, NULL),
(30, 3016, 'kaitlynsmith', '$1WCl6wGXO', '2025-08-15 16:20:00', 'james57@gmail.com', '4423153985', 'ESTJ', 'Eat professor number southern a training behavior hot particularly TV conference receive.', NULL, NULL, 'music'),
(31, 3017, 'tonyramos', ')&v7EG!p&b', '2025-08-15 16:20:13', 'alvarezheather@guzman.biz', '+187604971', 'ENFJ', 'Decision reveal expert free pick cut.', NULL, NULL, 'sport'),
(32, 3018, 'qwhite', '1h+vAjjS(8', '2025-08-15 16:20:27', 'rjohnson@griffith.com', '0018735723', 'ESFP', 'Same Mrs discussion you wind plant material who adult us to significant.', NULL, NULL, 'movie'),
(33, 3019, 'dale73', 'X!&5pZ)v&r', '2025-08-15 16:20:57', 'carolyn20@gmail.com', '3103920985', 'INTJ', 'Information or its face agree growth.', NULL, NULL, NULL),
(34, 3020, 'chayes', '#6*iGIjkKn', '2025-08-15 16:21:09', 'jodynorman@bryant-morrison.com', '+183038143', 'ESTJ', 'Science address their operation truth dark decide themselves.', NULL, NULL, 'tourism'),
(35, 3021, 'lanefernando', 'kV%6PUxomK', '2025-08-15 16:21:31', 'jessica11@wright-reese.biz', '8109372974', 'INFJ', 'Customer paper direction in follow nearly within.', NULL, NULL, NULL),
(36, 3022, 'jordanjeffery', 'SaIs9Hr^%2', '2025-08-15 16:21:43', 'michaellittle@miller.org', '735.576.05', 'ISTP', 'By child different fill inside seem its yard style hot guess number vote.', NULL, NULL, 'music'),
(37, 3023, 'colekathryn', 'oOEB2kUcf!', '2025-08-15 16:26:37', 'laurenfigueroa@yahoo.com', '0016752125', 'ISTJ', 'Purpose able miss success middle wish fire different matter life despite edge.', NULL, NULL, NULL),
(38, 3024, 'ryan52', 'Z2H1IaL2)j', '2025-08-03 16:16:01', 'chancock@nielsen-lucero.com', '1299369004', 'ENFP', 'Start into west he ready audience individual.', NULL, NULL, NULL),
(39, 3025, 'mrodriguez', 'k1ByJjaW*L', '2025-08-03 16:16:01', 'tnichols@contreras.com', '4751649625', 'ESFP', 'Scene must structure present option yourself talk real we after up.', NULL, NULL, NULL),
(40, 3026, 'robin05', 'Ei2TshJzu_', '2025-08-03 16:16:01', 'silvaadam@yahoo.com', '+159162841', 'ENTP', 'Board generation message boy method least forget second training democratic should nor yourself.', NULL, NULL, NULL),
(41, 3027, 'calebneal', 'O)@4Ju96d8', '2025-08-03 16:16:01', 'kking@hotmail.com', '0012625286', 'ESFJ', 'Station us administration PM send air career score add small use rock.', NULL, NULL, NULL),
(42, 3028, 'sheilalewis', 'MW7QoxFD^$', '2025-08-03 16:16:01', 'josephmatthews@yahoo.com', '9003913754', 'ENFP', 'Support conference improve color quality gun alone do.', NULL, NULL, NULL),
(43, 3029, 'yrodriguez', '$5ZgG7j6fN', '2025-08-03 16:16:01', 'ncook@gmail.com', '897.386.13', 'ENTJ', 'Kid remain again early indicate TV past begin analysis argue.', NULL, NULL, NULL),
(44, 3030, 'vanessa36', '#!Y6ZIKoei', '2025-08-03 16:16:01', 'nicholsonbrian@yahoo.com', '0013739795', 'ENFJ', 'In look strategy mean fund region drive much.', NULL, NULL, NULL),
(45, 3031, 'darryl04', '_HORIyd488', '2025-08-03 16:16:01', 'wadedennis@hotmail.com', '0011755415', 'ISTP', 'Way whom middle expert give themselves summer anything strong open employee.', NULL, NULL, NULL),
(46, 3032, 'klinejames', 't!xh6qUlP0', '2025-08-03 16:16:01', 'tannerlopez@collins.com', '0015992915', 'ESTP', 'Respond choose detail phone purpose role main hand small go sense.', NULL, NULL, NULL),
(47, 3033, 'welchjeanette', '1cyeNsVf@S', '2025-08-03 16:16:01', 'wendybrown@miller.com', '7462770381', 'ENTJ', 'Five present address choice simply behind agree dream decision party close.', NULL, NULL, NULL),
(48, 3034, 'kevindavis', 'W_qg1Dz7rQ', '2025-08-03 16:16:01', 'melissapatrick@yahoo.com', '2248526063', 'INTP', 'Election think current tough base organization natural property such fact.', NULL, NULL, NULL),
(49, 3035, 'barrjacob', 'O+D8aF*aOT', '2025-08-03 16:16:01', 'zlopez@smith.net', '0013624076', 'INTP', 'Security who firm sometimes although call tough film performance so company pass upon investment.', NULL, NULL, NULL),
(50, 3036, 'torresroger', 'Q()@8DcC!T', '2025-08-03 16:16:01', 'georgehubbard@hotmail.com', '592.578.07', 'INFJ', 'Goal PM American ago share several very coach create.', NULL, NULL, NULL),
(51, 3037, 'terri21', '2xx2&L+(w%', '2025-08-03 16:16:01', 'ymanning@gmail.com', '+129005376', 'ISFP', 'Start name material station high item along.', NULL, NULL, NULL),
(52, 3038, 'millerstephanie', '0hd6ML^k(5', '2025-08-03 16:16:01', 'wlynch@hotmail.com', '0018196115', 'ISFJ', 'Sea development water this hear year child political election do serious former law.', NULL, NULL, NULL),
(53, 3039, 'omckinney', 'jJ_O7jvW_6', '2025-08-03 16:16:01', 'tammyhenry@yahoo.com', '6574227510', 'INTJ', 'Husband green somebody treatment alone difficult gas partner our tend film indicate.', NULL, NULL, NULL),
(54, 3040, 'tammymoore', 'TF1OcUls_(', '2025-08-03 16:16:01', 'garzastefanie@hotmail.com', '0016857615', 'ENTP', 'Thank entire reduce mother task ask song last between herself then.', NULL, NULL, NULL),
(55, 3041, 'felicia33', '^34xMjuvUa', '2025-08-03 16:16:01', 'mcguiremelissa@lozano-little.org', '275.435.69', 'ESTJ', 'Former industry six one fact nice structure program stuff population sit.', NULL, NULL, NULL),
(56, 3042, 'wrightbrian', ')p2@JK)ye0', '2025-08-03 16:16:01', 'jeanettebrown@hotmail.com', '783.602.62', 'INFJ', 'Reduce service foot line reveal window.', NULL, NULL, NULL),
(57, 3043, 'stevensonmario', '@!1XWXZvUz', '2025-08-03 16:16:01', 'jonathan97@hotmail.com', '4229386796', 'INFJ', 'Event past school source along marriage beyond.', NULL, NULL, NULL),
(58, 3044, 'patriciamorgan', 'p_3Fx2#qeV', '2025-08-03 16:16:01', 'qmiller@gmail.com', '669.906.19', 'ESTJ', 'Official case street why information such participant like.', NULL, NULL, NULL),
(59, 3045, 'kristin62', '*MbuDQlrb7', '2025-08-03 16:16:01', 'megan84@gmail.com', '0010763014', 'INTP', 'Clear owner moment mission price article down without its indeed behavior item.', NULL, NULL, NULL),
(60, 3046, 'bergerdeborah', '(l4GAniq89', '2025-08-03 16:16:01', 'mirandaball@adams-smith.com', '182.057.47', 'ENFJ', 'Final wife knowledge late stay record involve ability.', NULL, NULL, NULL),
(61, 3047, 'sarah36', 'y*3CR+AF5f', '2025-08-03 16:16:01', 'allen01@arnold-lopez.net', '680.826.46', 'ESTP', 'Rest art without customer bad the exist range gas.', NULL, NULL, NULL),
(62, 3048, 'lopezmichelle', '_++B1s@l3M', '2025-08-03 16:16:01', 'kwarren@collins.com', '437.754.58', 'ISTP', 'Raise outside question office occur fact so single indicate become.', NULL, NULL, NULL),
(63, 3049, 'rkennedy', 'NV0B9WhB(M', '2025-08-03 16:16:01', 'acarter@gmail.com', '7531739546', 'ENTJ', 'Article heavy response grow race responsibility step lot maintain center foot accept.', NULL, NULL, NULL),
(64, 3050, 'stewartnathan', '^jvAl5zs^3', '2025-08-03 16:16:01', 'qthompson@gmail.com', '5105705694', 'ENFJ', 'Owner American effect citizen seven edge forget my this there enough.', NULL, NULL, NULL),
(65, 3051, 'miranda98', '29fY_0h&_B', '2025-08-03 16:16:01', 'kelsey10@carter.net', '+175497816', 'INTP', 'Husband upon of beyond feel require tonight vote team its pattern level data.', NULL, NULL, NULL),
(66, 3052, 'bhardin', '#dIjgl#8R5', '2025-08-03 16:16:01', 'jruiz@yahoo.com', '1655018667', 'ENTJ', 'During region he training food participant condition draw.', NULL, NULL, NULL),
(67, 3053, 'scoleman', 'Y6nGerQg&j', '2025-08-03 16:16:01', 'joan27@garcia.com', '9097070646', 'ENFJ', 'Protect true garden admit paper add project.', NULL, NULL, NULL),
(68, 3054, 'nphillips', 'w&x5jJdwMW', '2025-08-03 16:16:01', 'tsimpson@yahoo.com', '8017419302', 'ESTP', 'Debate above source sea ability involve site international receive lose.', NULL, NULL, NULL),
(69, 3055, 'clewis', 'IfED7Gu9m)', '2025-08-03 16:16:01', 'nmccoy@price-cline.info', '8692592998', 'ISFP', 'No who such work according decade sure.', NULL, NULL, NULL),
(70, 3056, 'smithbelinda', '&(U9Gqbx0I', '2025-08-03 16:16:01', 'nicole32@edwards.net', '872.757.32', 'ESFJ', 'Law score recently social old difference something conference investment bed early.', NULL, NULL, NULL),
(71, 3057, 'tara37', 'Ni9tPPuN_4', '2025-08-03 16:16:01', 'cookeric@hill.com', '5476308768', 'ESTJ', 'I father east rate prepare front.', NULL, NULL, NULL),
(72, 3058, 'rivascharles', '4!12oY4le_', '2025-08-03 16:16:01', 'elizabethmcbride@reyes.com', '3733227522', 'ESTP', 'Cut tell still program door from second traditional field war woman.', NULL, NULL, NULL),
(73, 3059, 'brownbrad', '@#N%3$Cv50', '2025-08-03 16:16:01', 'esanchez@armstrong-parker.org', '0912021867', 'INFJ', 'Me evidence thousand defense mouth view station produce try.', NULL, NULL, NULL),
(74, 3060, 'washingtoncynthia', '(pT4GlpDO(', '2025-08-03 16:16:01', 'richardwhite@hotmail.com', '2330515568', 'INTJ', 'Heavy catch hope increase picture there old consumer charge any wish.', NULL, NULL, NULL),
(75, 3061, 'marcia85', '2U1njBgBR$', '2025-08-03 16:16:01', 'michael21@carrillo.com', '0017075804', 'INFP', 'Treat score country test evidence early can level or figure area position.', NULL, NULL, NULL),
(76, 3062, 'rodriguezmeghan', 'bT(L7L+imW', '2025-08-03 16:16:01', 'daniel25@foster-rosario.com', '+180493923', 'ENFP', 'Save must Democrat give imagine clearly look attorney voice.', NULL, NULL, NULL),
(77, 3063, 'richard69', 'L()7Wief!O', '2025-08-03 16:16:01', 'priceanthony@hotmail.com', '167.598.12', 'INTJ', 'Newspaper trouble land us then likely station miss statement glass purpose beat until.', NULL, NULL, NULL),
(78, 3064, 'caseypatterson', 'I3Etv%1v+F', '2025-08-03 16:16:01', 'kirbyjessica@hotmail.com', '1516931789', 'ENTP', 'Energy tonight then improve dream cover team huge Democrat task national.', NULL, NULL, NULL),
(79, 3065, 'vstanley', 'HV7Di#wY_a', '2025-08-03 16:16:01', 'terrimurphy@gmail.com', '976.662.55', 'ISTP', 'Tax a happen physical shake politics dream.', NULL, NULL, NULL),
(80, 3066, 'rpowell', '%l+_y8Dv2w', '2025-08-03 16:16:01', 'qblankenship@christensen.com', '101.125.00', 'ISFJ', 'When because sing role quickly beautiful trial pick while.', NULL, NULL, NULL),
(81, 3067, 'brittany65', 'x%J0CIDkrg', '2025-08-03 16:16:01', 'walkerjohn@hotmail.com', '0017549042', 'ISFJ', 'Nor change site purpose avoid station to spend watch.', NULL, NULL, NULL),
(82, 3068, 'brianbrooks', 'Ou*k8Ernj5', '2025-08-03 16:16:01', 'renee51@gmail.com', '0396394607', 'INFP', 'Fine democratic onto sit plant five traditional painting way expect safe together clearly.', NULL, NULL, NULL),
(83, 3069, 'beckydavidson', 'M^X78Xy*+G', '2025-08-03 16:16:01', 'darryl07@yahoo.com', '0015714008', 'ENFJ', 'Product several subject help forward hundred support.', NULL, NULL, NULL),
(84, 3070, 'mark65', '*g3zZ%Tx2T', '2025-08-03 16:16:01', 'hmendoza@yahoo.com', '9754357877', 'ESTP', 'The other third fact high director.', NULL, NULL, NULL),
(85, 3071, 'mooreteresa', '%0OLX#HuIr', '2025-08-03 16:16:01', 'sullivanmary@hotmail.com', '324.918.72', 'ISTP', 'Maybe same five relationship wrong tend how remember despite blue Mrs to result.', NULL, NULL, NULL),
(86, 3072, 'pmiddleton', '@amVNivR4o', '2025-08-03 16:16:01', 'donald98@hotmail.com', '2257405763', 'INTP', 'Its edge ahead recent wait civil science.', NULL, NULL, NULL),
(87, 3073, 'grayjimmy', 'C!7%WTMnhy', '2025-08-03 16:16:01', 'hessteresa@cook-jackson.org', '8557117360', 'ENTJ', 'Likely put environmental major there employee air computer.', NULL, NULL, NULL),
(88, 3074, 'powellbruce', 'Q@89YJJhd0', '2025-08-03 16:16:01', 'cbryant@stephenson.biz', '879.649.92', 'ISFP', 'Three trial Republican popular offer should ability buy.', NULL, NULL, NULL),
(89, 3075, 'rogersstephen', ')O1Rh%yMDU', '2025-08-03 16:16:01', 'lorraine12@chavez-raymond.com', '690.968.31', 'ENTP', 'Way because reduce team sell social professional.', NULL, NULL, NULL),
(90, 3076, 'wgreene', '#jX5jA(ey4', '2025-08-03 16:16:01', 'clopez@gmail.com', '102.640.84', 'ESFJ', 'Hair task exactly others then alone write adult between work name argue.', NULL, NULL, NULL),
(91, 3077, 'steven60', 'b1_JV!ZD$h', '2025-08-03 16:16:01', 'juarezwilliam@hotmail.com', '0645558628', 'ISFJ', 'Hundred recently western music majority what book four field clear cover team.', NULL, NULL, NULL),
(92, 3078, 'oreynolds', '^lqgJE&j(1', '2025-08-03 16:16:01', 'peter51@macias.com', '+191537577', 'ENTJ', 'Notice dinner arrive fall according bit pattern she public effort prove budget.', NULL, NULL, NULL),
(93, 3079, 'jacobsnyder', '4231ATLh$R', '2025-08-03 16:16:01', 'kenneth62@gmail.com', '0013958206', 'ESFJ', 'Sort challenge happen option land since source sea threat however religious.', NULL, NULL, NULL),
(94, 3080, 'markfernandez', '4NQqd6Os#7', '2025-08-03 16:16:01', 'patricia44@bradley.com', '8413965176', 'ENTP', 'Trade system top impact sell before western her financial.', NULL, NULL, NULL),
(95, 3081, 'nbriggs', '5W+9NPIhCd', '2025-08-03 16:16:01', 'nicholas45@blanchard.net', '+164949693', 'INFJ', 'Practice enjoy second cause positive radio Democrat single beautiful black operation form yeah.', NULL, NULL, NULL),
(96, 3082, 'michael18', 'Z05j1^Rd@U', '2025-08-03 16:16:01', 'kevin03@gmail.com', '1715091707', 'ISFP', 'Involve president wish employee certain check performance relationship learn news sure when.', NULL, NULL, NULL),
(97, 3083, 'sarah57', 'n2*EFYLt%T', '2025-08-03 16:16:01', 'ehill@hotmail.com', '730.027.32', 'ESFJ', 'Save star learn have stuff everybody direction key discuss.', NULL, NULL, NULL),
(98, 3084, 'jacobgonzalez', '^ov14PaVbz', '2025-08-03 16:16:01', 'cody42@gmail.com', '6123536639', 'ESTJ', 'Cover wonder every threat take start democratic artist.', NULL, NULL, NULL),
(99, 3085, 'ronald86', 'PN5Vgm9#v)', '2025-08-03 16:16:01', 'carlsparks@gmail.com', '970.163.63', 'ENFP', 'Chair everything land hand everybody really fund hope increase be chair design.', NULL, NULL, NULL),
(100, 3086, 'bellbrooke', '^8kK1X9^zE', '2025-08-03 16:16:01', 'brian43@hunt-daniels.com', '0013160729', 'ESFP', 'Against last lot office treatment share high three sit tree.', NULL, NULL, NULL),
(101, 3087, 'trodriguez', '%V%ThWOe7z', '2025-08-03 16:16:01', 'karaburnett@yahoo.com', '0018289330', 'ESTP', 'Resource seek our sometimes nice country grow step my create.', NULL, NULL, NULL),
(102, 3088, 'olawrence', 's+3UO5oov6', '2025-08-03 16:16:01', 'raymond05@torres.info', '0013451985', 'ENTJ', 'Late yet main move deal measure teach sound medical evidence middle.', NULL, NULL, NULL),
(103, 3089, 'qramos', 'S6P7Vp4l#G', '2025-08-03 16:16:01', 'priscilla66@peck-joseph.com', '4684316705', 'ENTP', 'Event catch mother nothing beat court these so issue culture.', NULL, NULL, NULL),
(104, 3090, 'dustin39', 'eCD%ItMJ^6', '2025-08-03 16:16:01', 'willie33@bryan.org', '472.554.34', 'INTP', 'Husband during especially yeah so manager blood.', NULL, NULL, NULL),
(105, 3091, 'riveracraig', 'nzVx1F7j@Z', '2025-08-03 16:16:01', 'tarnold@hotmail.com', '7268268071', 'ESFJ', 'Marriage trial would report but heavy third history this push goal half.', NULL, NULL, NULL),
(106, 3092, 'martinezkatherine', '(v7APA&q(0', '2025-08-03 16:16:01', 'qcohen@yahoo.com', '4795760841', 'INFP', 'At know mention within eye can develop growth involve soldier offer get involve.', NULL, NULL, NULL),
(107, 3093, 'april79', 'g%S9IhKt#K', '2025-08-03 16:16:01', 'mcneilamy@harris.com', '0012533026', 'ESTJ', 'Instead specific yes person tough save.', NULL, NULL, NULL),
(108, 3094, 'dylanallen', 'p!6S_8Or6a', '2025-08-12 20:04:11', 'rhonda84@gmail.com', '2175980110', 'INTP', 'Administration food feeling close forward teacher computer generation institution leader.', NULL, NULL, 'music'),
(109, 3095, 'fernandezjacob', 'z#9Ud_uoAF', '2025-08-03 16:16:01', 'janet87@yahoo.com', '+116529012', 'ESFJ', 'Short machine do public old tree common court whom concern build.', NULL, NULL, NULL),
(110, 3096, 'francotaylor', '+9ZcgNtc+k', '2025-08-03 16:16:01', 'mistyzimmerman@webster-hurley.com', '4448609716', 'ISFP', 'Side traditional store fill kid meet produce.', NULL, NULL, NULL),
(111, 3097, 'rochadennis', 'I*3yGGYH1o', '2025-08-03 16:16:01', 'egilbert@weeks-palmer.com', '+116279266', 'ISFP', 'Particular perhaps management read report mission memory on.', NULL, NULL, NULL),
(112, 3098, 'kenneth64', 'q*5H$jP6&1', '2025-08-03 16:16:01', 'sjacobs@yahoo.com', '269.466.65', 'INTJ', 'Movie international poor song day open modern wind enough floor.', NULL, NULL, NULL),
(113, 3099, 'anitakim', 'Q_B8SjLs&G', '2025-08-03 16:16:01', 'wreid@yahoo.com', '547.524.32', 'INFP', 'Push no industry only politics throw inside listen seat coach yard continue claim.', NULL, NULL, NULL),
(114, 3100, 'michael38', 'X!2GfUZlYa', '2025-08-03 16:16:01', 'ghatfield@hotmail.com', '6476785934', 'ISFP', 'Usually happen drug big rest choice.', NULL, NULL, NULL),
(115, 971221, 'ADMIN', '1', '2025-08-15 19:34:58', 'admin@email.com', '', 'ENTP', '', 'uploads/profile_971221_1755028188.jpg', NULL, NULL),
(116, 278366, 'narakorn ', '1120', '2025-08-15 19:45:46', 'narakorn.tess@bumail.net', '', 'ENFP', 'Hello', 'uploads/profile_278366_1755285683.jpg', NULL, NULL),
(117, 723242, 'korn', '1234', '2025-08-15 14:01:03', 'korn@email.com', '', 'INTJ', '', NULL, NULL, 'game');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity_logs`
--

CREATE TABLE `user_activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `user_id`, `group_id`) VALUES
(65, 1001, 31),
(66, 1002, 31),
(67, 1003, 32),
(68, 1004, 33),
(69, 1005, 34),
(70, 1006, 35),
(71, 1007, 36),
(72, 1008, 32),
(73, 1009, 34),
(74, 1010, 33),
(75, 3001, 31),
(76, 3002, 35),
(77, 3003, 32),
(78, 3004, 34),
(79, 3005, 33),
(80, 3004, 33),
(81, 3006, 31),
(82, 3007, 35),
(83, 3007, 37),
(88, 723242, 34),
(95, 723242, 31),
(106, 3016, 32),
(107, 3017, 34),
(108, 3018, 33),
(109, 3019, 37),
(110, 3019, 31),
(111, 3020, 35),
(112, 3021, 36),
(113, 3022, 32),
(114, 3023, 34),
(116, 3023, 33),
(117, 3023, 37),
(118, 3023, 31),
(119, 3023, 35),
(120, 3023, 36),
(121, 3023, 32),
(125, 278366, 33),
(126, 278366, 41),
(127, 971221, 37),
(129, 278366, 37);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_analytics`
--
ALTER TABLE `group_analytics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_date` (`group_id`,`date`);

--
-- Indexes for table `group_reports`
--
ALTER TABLE `group_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `report_type` (`report_type`);

--
-- Indexes for table `mbti_compatibility`
--
ALTER TABLE `mbti_compatibility`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_pair` (`type1`,`type2`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `date` (`date`),
  ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `user_activity_logs`
--
ALTER TABLE `user_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `action` (`action`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `group_analytics`
--
ALTER TABLE `group_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_reports`
--
ALTER TABLE `group_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mbti_compatibility`
--
ALTER TABLE `mbti_compatibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `user_activity_logs`
--
ALTER TABLE `user_activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
