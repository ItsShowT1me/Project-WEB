-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2025 at 08:58 PM
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `is_private` tinyint(1) DEFAULT 0,
  `member_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_id`, `name`, `pin`, `color`, `created_at`, `description`, `is_private`, `member_count`) VALUES
(19, '945669', 'WOW', '3066', '#a0cc00', '2025-08-08 18:27:00', NULL, 0, 0),
(20, '435365', 'TEST', '41585', '#fbff05', '2025-08-08 18:27:00', NULL, 0, 0);

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
(24, 20, 1002, 'TEST', '2025-08-05 10:30:02', NULL),
(25, 20, 1002, 'F', '2025-08-05 10:30:21', 'uploads/1754364621_a.png'),
(26, 20, 1003, 'Hello', '2025-08-05 10:54:13', NULL);

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
(1, 'site_name', 'BUMBTI', 'Website name', '2025-08-08 18:28:50'),
(2, 'max_group_members', '50', 'Maximum members per group', '2025-08-08 18:28:50'),
(3, 'ai_analysis_enabled', '1', 'Enable AI personality analysis', '2025-08-08 18:28:50'),
(4, 'notification_system', '1', 'Enable notification system', '2025-08-08 18:28:50');

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
  `mbti` varchar(4) NOT NULL,
  `portfolio` varchar(255) DEFAULT NULL,
  `portfolio_file` varchar(255) DEFAULT NULL,
  `about` text NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_name`, `password`, `date`, `email`, `phone`, `mbti`, `portfolio`, `portfolio_file`, `about`, `image`) VALUES
(5, 1001, 'AnanyaR', 'pass1234', '2025-08-03 17:06:58', 'ananya.r@gmail.com', '0891234567', 'INFJ', '', NULL, 'A passionate UI/UX designer from Bangkok.', 'uploads/profile_1001_1754240818.png'),
(6, 1002, 'ThanapatMC', '1234abcd', '2025-08-03 17:07:32', 'thanapat.mc@hotmail.com', '0819876543', 'ENTP', '', NULL, 'A tech lover who enjoys building things from scratch.', 'uploads/profile_1002_1754240852.png'),
(7, 1003, 'JiraKit', 'myp@ssword', '2025-08-03 11:33:34', 'jirapat.k@gmail.com', '0623456789', 'INFP', NULL, NULL, 'Quiet thinker who enjoys meaningful connections.', NULL),
(8, 1004, 'KanyaSuda', 'hello@123', '2025-08-03 11:33:34', 'k.srisuda@yahoo.com', '0837654321', 'ESFJ', NULL, NULL, 'Friendly, warm-hearted, and driven to help others.', NULL),
(9, 1005, 'NattaBM', 'boonmee99', '2025-08-03 11:33:34', 'nattawut.b@hotmail.com', '0951237890', 'ISTP', NULL, NULL, 'Love exploring how things work and solving problems.', NULL),
(10, 1006, 'PNamS', 'coolpass12', '2025-08-03 11:33:34', 'p.namsai@gmail.com', '0889911223', 'ENTJ', NULL, NULL, 'Strategic leader with a passion for development.', NULL),
(11, 1007, 'RattanaTW', 'rat@secure', '2025-08-03 11:33:34', 'rattana.tw@gmail.com', '0865544332', 'ISFJ', NULL, NULL, 'Loyal and considerate, always ready to help.', NULL),
(12, 1008, 'ChaninWW', 'wwchanin88', '2025-08-03 11:33:34', 'chanin.w@gmail.com', '0894455661', 'ENFP', NULL, NULL, 'Energetic, creative, and loves to inspire others.', NULL),
(13, 1009, 'SirinLS', 'sirinpass', '2025-08-03 11:33:34', 'sirin.ls@gmail.com', '0841122334', 'ISTJ', NULL, NULL, 'Responsible and values tradition and order.', NULL),
(14, 1010, 'PongThav', 'ptsecure', '2025-08-03 11:33:34', 'pongsak.t@hotmail.com', '0905566778', 'ESTP', NULL, NULL, 'Bold and spontaneous, lives life to the fullest.', NULL),
(15, 3001, 'jamie33', ')r8u^Zwm(!', '2025-08-03 16:16:01', 'obeck@hotmail.com', '0475530541', 'INFP', NULL, NULL, 'Dark experience drive art safe somebody.', NULL),
(16, 3002, 'cookmary', '+UE@&r5j6S', '2025-08-03 16:16:01', 'qrodriguez@bell-garner.com', '3250745204', 'ESFP', NULL, NULL, 'Our ten instead common create police clear memory for.', NULL),
(17, 3003, 'kimberlythomas', 'F+iHbDfe*3', '2025-08-03 16:16:01', 'maria00@yahoo.com', '985.599.39', 'ISTJ', NULL, NULL, 'Point song would need miss notice draw certain.', NULL),
(18, 3004, 'daniel17', 'SM+g*6Fr$v', '2025-08-03 16:16:01', 'morganjeremiah@gmail.com', '757.330.61', 'INFJ', NULL, NULL, 'Wear instead price common common western be ball certain good score yeah.', NULL),
(19, 3005, 'margaret98', '$Y%o^uhr2F', '2025-08-03 16:16:01', 'xhenderson@hotmail.com', '8170211905', 'ESFJ', NULL, NULL, 'Billion agree however building help son hand another.', NULL),
(20, 3006, 'dennis67', 'A2m%6lUt3(', '2025-08-03 16:16:01', 'tina08@campos.com', '7778575647', 'INTJ', NULL, NULL, 'Admit begin message need standard build.', NULL),
(21, 3007, 'stacy15', '!9)F)OFb&M', '2025-08-03 16:16:01', 'reneemcdonald@jensen.com', '1748045637', 'ESFJ', NULL, NULL, 'Tv wrong future here message least tax.', NULL),
(22, 3008, 'jeff31', '@2QB$P11nn', '2025-08-03 16:16:01', 'lauren09@hotmail.com', '2545592507', 'ENFP', NULL, NULL, 'Key next brother style institution world state more billion yes teach run.', NULL),
(23, 3009, 'jimenezkelly', '&A6XShexmg', '2025-08-03 16:16:01', 'nelsonjustin@glover.com', '+101942754', 'ENTP', NULL, NULL, 'Popular allow rate right mouth trouble owner behind marriage we cultural teacher seek.', NULL),
(24, 3010, 'irobinson', 'j5aRNA(D$z', '2025-08-03 16:16:01', 'colinperry@powers.biz', '3544508669', 'ESFJ', NULL, NULL, 'Outside into free one finally member rest learn executive article.', NULL),
(25, 3011, 'tayloranthony', '3#N7moUf$2', '2025-08-03 16:16:01', 'terricastaneda@yahoo.com', '0016961777', 'ESTJ', NULL, NULL, 'Hit shoulder compare drug maintain politics middle box drop girl.', NULL),
(26, 3012, 'cobbpatrick', 'W3&OSa_1(R', '2025-08-03 16:16:01', 'qnunez@dean.com', '0018688948', 'ESFJ', NULL, NULL, 'Glass couple thousand hair focus voice American them wife simple able strong catch.', NULL),
(27, 3013, 'jenniferbright', 's5JH+NuL&!', '2025-08-03 16:16:01', 'diana18@white-kim.com', '0328090667', 'INTP', NULL, NULL, 'Soon keep hour water success which baby state how loss.', NULL),
(28, 3014, 'ayerstimothy', '51jfp%Tm*b', '2025-08-03 16:16:01', 'carol59@hotmail.com', '0395435279', 'ISTJ', NULL, NULL, 'Story arrive time center majority region road performance stay.', NULL),
(29, 3015, 'bennettchristopher', '&BE2tKxF22', '2025-08-03 16:16:01', 'ingramjames@gay.com', '8736266596', 'ISFP', NULL, NULL, 'Green general campaign smile energy kid believe lot able these whole decade.', NULL),
(30, 3016, 'kaitlynsmith', '$1WCl6wGXO', '2025-08-03 16:16:01', 'james57@gmail.com', '4423153985', 'ESTJ', NULL, NULL, 'Eat professor number southern a training behavior hot particularly TV conference receive.', NULL),
(31, 3017, 'tonyramos', ')&v7EG!p&b', '2025-08-03 16:16:01', 'alvarezheather@guzman.biz', '+187604971', 'ENFJ', NULL, NULL, 'Decision reveal expert free pick cut.', NULL),
(32, 3018, 'qwhite', '1h+vAjjS(8', '2025-08-03 16:16:01', 'rjohnson@griffith.com', '0018735723', 'ESFP', NULL, NULL, 'Same Mrs discussion you wind plant material who adult us to significant.', NULL),
(33, 3019, 'dale73', 'X!&5pZ)v&r', '2025-08-03 16:16:01', 'carolyn20@gmail.com', '3103920985', 'INTJ', NULL, NULL, 'Information or its face agree growth.', NULL),
(34, 3020, 'chayes', '#6*iGIjkKn', '2025-08-03 16:16:01', 'jodynorman@bryant-morrison.com', '+183038143', 'ESTJ', NULL, NULL, 'Science address their operation truth dark decide themselves.', NULL),
(35, 3021, 'lanefernando', 'kV%6PUxomK', '2025-08-03 16:16:01', 'jessica11@wright-reese.biz', '8109372974', 'INFJ', NULL, NULL, 'Customer paper direction in follow nearly within.', NULL),
(36, 3022, 'jordanjeffery', 'SaIs9Hr^%2', '2025-08-03 16:16:01', 'michaellittle@miller.org', '735.576.05', 'ISTP', NULL, NULL, 'By child different fill inside seem its yard style hot guess number vote.', NULL),
(37, 3023, 'colekathryn', 'oOEB2kUcf!', '2025-08-03 16:16:01', 'laurenfigueroa@yahoo.com', '0016752125', 'ISTJ', NULL, NULL, 'Purpose able miss success middle wish fire different matter life despite edge.', NULL),
(38, 3024, 'ryan52', 'Z2H1IaL2)j', '2025-08-03 16:16:01', 'chancock@nielsen-lucero.com', '1299369004', 'ENFP', NULL, NULL, 'Start into west he ready audience individual.', NULL),
(39, 3025, 'mrodriguez', 'k1ByJjaW*L', '2025-08-03 16:16:01', 'tnichols@contreras.com', '4751649625', 'ESFP', NULL, NULL, 'Scene must structure present option yourself talk real we after up.', NULL),
(40, 3026, 'robin05', 'Ei2TshJzu_', '2025-08-03 16:16:01', 'silvaadam@yahoo.com', '+159162841', 'ENTP', NULL, NULL, 'Board generation message boy method least forget second training democratic should nor yourself.', NULL),
(41, 3027, 'calebneal', 'O)@4Ju96d8', '2025-08-03 16:16:01', 'kking@hotmail.com', '0012625286', 'ESFJ', NULL, NULL, 'Station us administration PM send air career score add small use rock.', NULL),
(42, 3028, 'sheilalewis', 'MW7QoxFD^$', '2025-08-03 16:16:01', 'josephmatthews@yahoo.com', '9003913754', 'ENFP', NULL, NULL, 'Support conference improve color quality gun alone do.', NULL),
(43, 3029, 'yrodriguez', '$5ZgG7j6fN', '2025-08-03 16:16:01', 'ncook@gmail.com', '897.386.13', 'ENTJ', NULL, NULL, 'Kid remain again early indicate TV past begin analysis argue.', NULL),
(44, 3030, 'vanessa36', '#!Y6ZIKoei', '2025-08-03 16:16:01', 'nicholsonbrian@yahoo.com', '0013739795', 'ENFJ', NULL, NULL, 'In look strategy mean fund region drive much.', NULL),
(45, 3031, 'darryl04', '_HORIyd488', '2025-08-03 16:16:01', 'wadedennis@hotmail.com', '0011755415', 'ISTP', NULL, NULL, 'Way whom middle expert give themselves summer anything strong open employee.', NULL),
(46, 3032, 'klinejames', 't!xh6qUlP0', '2025-08-03 16:16:01', 'tannerlopez@collins.com', '0015992915', 'ESTP', NULL, NULL, 'Respond choose detail phone purpose role main hand small go sense.', NULL),
(47, 3033, 'welchjeanette', '1cyeNsVf@S', '2025-08-03 16:16:01', 'wendybrown@miller.com', '7462770381', 'ENTJ', NULL, NULL, 'Five present address choice simply behind agree dream decision party close.', NULL),
(48, 3034, 'kevindavis', 'W_qg1Dz7rQ', '2025-08-03 16:16:01', 'melissapatrick@yahoo.com', '2248526063', 'INTP', NULL, NULL, 'Election think current tough base organization natural property such fact.', NULL),
(49, 3035, 'barrjacob', 'O+D8aF*aOT', '2025-08-03 16:16:01', 'zlopez@smith.net', '0013624076', 'INTP', NULL, NULL, 'Security who firm sometimes although call tough film performance so company pass upon investment.', NULL),
(50, 3036, 'torresroger', 'Q()@8DcC!T', '2025-08-03 16:16:01', 'georgehubbard@hotmail.com', '592.578.07', 'INFJ', NULL, NULL, 'Goal PM American ago share several very coach create.', NULL),
(51, 3037, 'terri21', '2xx2&L+(w%', '2025-08-03 16:16:01', 'ymanning@gmail.com', '+129005376', 'ISFP', NULL, NULL, 'Start name material station high item along.', NULL),
(52, 3038, 'millerstephanie', '0hd6ML^k(5', '2025-08-03 16:16:01', 'wlynch@hotmail.com', '0018196115', 'ISFJ', NULL, NULL, 'Sea development water this hear year child political election do serious former law.', NULL),
(53, 3039, 'omckinney', 'jJ_O7jvW_6', '2025-08-03 16:16:01', 'tammyhenry@yahoo.com', '6574227510', 'INTJ', NULL, NULL, 'Husband green somebody treatment alone difficult gas partner our tend film indicate.', NULL),
(54, 3040, 'tammymoore', 'TF1OcUls_(', '2025-08-03 16:16:01', 'garzastefanie@hotmail.com', '0016857615', 'ENTP', NULL, NULL, 'Thank entire reduce mother task ask song last between herself then.', NULL),
(55, 3041, 'felicia33', '^34xMjuvUa', '2025-08-03 16:16:01', 'mcguiremelissa@lozano-little.org', '275.435.69', 'ESTJ', NULL, NULL, 'Former industry six one fact nice structure program stuff population sit.', NULL),
(56, 3042, 'wrightbrian', ')p2@JK)ye0', '2025-08-03 16:16:01', 'jeanettebrown@hotmail.com', '783.602.62', 'INFJ', NULL, NULL, 'Reduce service foot line reveal window.', NULL),
(57, 3043, 'stevensonmario', '@!1XWXZvUz', '2025-08-03 16:16:01', 'jonathan97@hotmail.com', '4229386796', 'INFJ', NULL, NULL, 'Event past school source along marriage beyond.', NULL),
(58, 3044, 'patriciamorgan', 'p_3Fx2#qeV', '2025-08-03 16:16:01', 'qmiller@gmail.com', '669.906.19', 'ESTJ', NULL, NULL, 'Official case street why information such participant like.', NULL),
(59, 3045, 'kristin62', '*MbuDQlrb7', '2025-08-03 16:16:01', 'megan84@gmail.com', '0010763014', 'INTP', NULL, NULL, 'Clear owner moment mission price article down without its indeed behavior item.', NULL),
(60, 3046, 'bergerdeborah', '(l4GAniq89', '2025-08-03 16:16:01', 'mirandaball@adams-smith.com', '182.057.47', 'ENFJ', NULL, NULL, 'Final wife knowledge late stay record involve ability.', NULL),
(61, 3047, 'sarah36', 'y*3CR+AF5f', '2025-08-03 16:16:01', 'allen01@arnold-lopez.net', '680.826.46', 'ESTP', NULL, NULL, 'Rest art without customer bad the exist range gas.', NULL),
(62, 3048, 'lopezmichelle', '_++B1s@l3M', '2025-08-03 16:16:01', 'kwarren@collins.com', '437.754.58', 'ISTP', NULL, NULL, 'Raise outside question office occur fact so single indicate become.', NULL),
(63, 3049, 'rkennedy', 'NV0B9WhB(M', '2025-08-03 16:16:01', 'acarter@gmail.com', '7531739546', 'ENTJ', NULL, NULL, 'Article heavy response grow race responsibility step lot maintain center foot accept.', NULL),
(64, 3050, 'stewartnathan', '^jvAl5zs^3', '2025-08-03 16:16:01', 'qthompson@gmail.com', '5105705694', 'ENFJ', NULL, NULL, 'Owner American effect citizen seven edge forget my this there enough.', NULL),
(65, 3051, 'miranda98', '29fY_0h&_B', '2025-08-03 16:16:01', 'kelsey10@carter.net', '+175497816', 'INTP', NULL, NULL, 'Husband upon of beyond feel require tonight vote team its pattern level data.', NULL),
(66, 3052, 'bhardin', '#dIjgl#8R5', '2025-08-03 16:16:01', 'jruiz@yahoo.com', '1655018667', 'ENTJ', NULL, NULL, 'During region he training food participant condition draw.', NULL),
(67, 3053, 'scoleman', 'Y6nGerQg&j', '2025-08-03 16:16:01', 'joan27@garcia.com', '9097070646', 'ENFJ', NULL, NULL, 'Protect true garden admit paper add project.', NULL),
(68, 3054, 'nphillips', 'w&x5jJdwMW', '2025-08-03 16:16:01', 'tsimpson@yahoo.com', '8017419302', 'ESTP', NULL, NULL, 'Debate above source sea ability involve site international receive lose.', NULL),
(69, 3055, 'clewis', 'IfED7Gu9m)', '2025-08-03 16:16:01', 'nmccoy@price-cline.info', '8692592998', 'ISFP', NULL, NULL, 'No who such work according decade sure.', NULL),
(70, 3056, 'smithbelinda', '&(U9Gqbx0I', '2025-08-03 16:16:01', 'nicole32@edwards.net', '872.757.32', 'ESFJ', NULL, NULL, 'Law score recently social old difference something conference investment bed early.', NULL),
(71, 3057, 'tara37', 'Ni9tPPuN_4', '2025-08-03 16:16:01', 'cookeric@hill.com', '5476308768', 'ESTJ', NULL, NULL, 'I father east rate prepare front.', NULL),
(72, 3058, 'rivascharles', '4!12oY4le_', '2025-08-03 16:16:01', 'elizabethmcbride@reyes.com', '3733227522', 'ESTP', NULL, NULL, 'Cut tell still program door from second traditional field war woman.', NULL),
(73, 3059, 'brownbrad', '@#N%3$Cv50', '2025-08-03 16:16:01', 'esanchez@armstrong-parker.org', '0912021867', 'INFJ', NULL, NULL, 'Me evidence thousand defense mouth view station produce try.', NULL),
(74, 3060, 'washingtoncynthia', '(pT4GlpDO(', '2025-08-03 16:16:01', 'richardwhite@hotmail.com', '2330515568', 'INTJ', NULL, NULL, 'Heavy catch hope increase picture there old consumer charge any wish.', NULL),
(75, 3061, 'marcia85', '2U1njBgBR$', '2025-08-03 16:16:01', 'michael21@carrillo.com', '0017075804', 'INFP', NULL, NULL, 'Treat score country test evidence early can level or figure area position.', NULL),
(76, 3062, 'rodriguezmeghan', 'bT(L7L+imW', '2025-08-03 16:16:01', 'daniel25@foster-rosario.com', '+180493923', 'ENFP', NULL, NULL, 'Save must Democrat give imagine clearly look attorney voice.', NULL),
(77, 3063, 'richard69', 'L()7Wief!O', '2025-08-03 16:16:01', 'priceanthony@hotmail.com', '167.598.12', 'INTJ', NULL, NULL, 'Newspaper trouble land us then likely station miss statement glass purpose beat until.', NULL),
(78, 3064, 'caseypatterson', 'I3Etv%1v+F', '2025-08-03 16:16:01', 'kirbyjessica@hotmail.com', '1516931789', 'ENTP', NULL, NULL, 'Energy tonight then improve dream cover team huge Democrat task national.', NULL),
(79, 3065, 'vstanley', 'HV7Di#wY_a', '2025-08-03 16:16:01', 'terrimurphy@gmail.com', '976.662.55', 'ISTP', NULL, NULL, 'Tax a happen physical shake politics dream.', NULL),
(80, 3066, 'rpowell', '%l+_y8Dv2w', '2025-08-03 16:16:01', 'qblankenship@christensen.com', '101.125.00', 'ISFJ', NULL, NULL, 'When because sing role quickly beautiful trial pick while.', NULL),
(81, 3067, 'brittany65', 'x%J0CIDkrg', '2025-08-03 16:16:01', 'walkerjohn@hotmail.com', '0017549042', 'ISFJ', NULL, NULL, 'Nor change site purpose avoid station to spend watch.', NULL),
(82, 3068, 'brianbrooks', 'Ou*k8Ernj5', '2025-08-03 16:16:01', 'renee51@gmail.com', '0396394607', 'INFP', NULL, NULL, 'Fine democratic onto sit plant five traditional painting way expect safe together clearly.', NULL),
(83, 3069, 'beckydavidson', 'M^X78Xy*+G', '2025-08-03 16:16:01', 'darryl07@yahoo.com', '0015714008', 'ENFJ', NULL, NULL, 'Product several subject help forward hundred support.', NULL),
(84, 3070, 'mark65', '*g3zZ%Tx2T', '2025-08-03 16:16:01', 'hmendoza@yahoo.com', '9754357877', 'ESTP', NULL, NULL, 'The other third fact high director.', NULL),
(85, 3071, 'mooreteresa', '%0OLX#HuIr', '2025-08-03 16:16:01', 'sullivanmary@hotmail.com', '324.918.72', 'ISTP', NULL, NULL, 'Maybe same five relationship wrong tend how remember despite blue Mrs to result.', NULL),
(86, 3072, 'pmiddleton', '@amVNivR4o', '2025-08-03 16:16:01', 'donald98@hotmail.com', '2257405763', 'INTP', NULL, NULL, 'Its edge ahead recent wait civil science.', NULL),
(87, 3073, 'grayjimmy', 'C!7%WTMnhy', '2025-08-03 16:16:01', 'hessteresa@cook-jackson.org', '8557117360', 'ENTJ', NULL, NULL, 'Likely put environmental major there employee air computer.', NULL),
(88, 3074, 'powellbruce', 'Q@89YJJhd0', '2025-08-03 16:16:01', 'cbryant@stephenson.biz', '879.649.92', 'ISFP', NULL, NULL, 'Three trial Republican popular offer should ability buy.', NULL),
(89, 3075, 'rogersstephen', ')O1Rh%yMDU', '2025-08-03 16:16:01', 'lorraine12@chavez-raymond.com', '690.968.31', 'ENTP', NULL, NULL, 'Way because reduce team sell social professional.', NULL),
(90, 3076, 'wgreene', '#jX5jA(ey4', '2025-08-03 16:16:01', 'clopez@gmail.com', '102.640.84', 'ESFJ', NULL, NULL, 'Hair task exactly others then alone write adult between work name argue.', NULL),
(91, 3077, 'steven60', 'b1_JV!ZD$h', '2025-08-03 16:16:01', 'juarezwilliam@hotmail.com', '0645558628', 'ISFJ', NULL, NULL, 'Hundred recently western music majority what book four field clear cover team.', NULL),
(92, 3078, 'oreynolds', '^lqgJE&j(1', '2025-08-03 16:16:01', 'peter51@macias.com', '+191537577', 'ENTJ', NULL, NULL, 'Notice dinner arrive fall according bit pattern she public effort prove budget.', NULL),
(93, 3079, 'jacobsnyder', '4231ATLh$R', '2025-08-03 16:16:01', 'kenneth62@gmail.com', '0013958206', 'ESFJ', NULL, NULL, 'Sort challenge happen option land since source sea threat however religious.', NULL),
(94, 3080, 'markfernandez', '4NQqd6Os#7', '2025-08-03 16:16:01', 'patricia44@bradley.com', '8413965176', 'ENTP', NULL, NULL, 'Trade system top impact sell before western her financial.', NULL),
(95, 3081, 'nbriggs', '5W+9NPIhCd', '2025-08-03 16:16:01', 'nicholas45@blanchard.net', '+164949693', 'INFJ', NULL, NULL, 'Practice enjoy second cause positive radio Democrat single beautiful black operation form yeah.', NULL),
(96, 3082, 'michael18', 'Z05j1^Rd@U', '2025-08-03 16:16:01', 'kevin03@gmail.com', '1715091707', 'ISFP', NULL, NULL, 'Involve president wish employee certain check performance relationship learn news sure when.', NULL),
(97, 3083, 'sarah57', 'n2*EFYLt%T', '2025-08-03 16:16:01', 'ehill@hotmail.com', '730.027.32', 'ESFJ', NULL, NULL, 'Save star learn have stuff everybody direction key discuss.', NULL),
(98, 3084, 'jacobgonzalez', '^ov14PaVbz', '2025-08-03 16:16:01', 'cody42@gmail.com', '6123536639', 'ESTJ', NULL, NULL, 'Cover wonder every threat take start democratic artist.', NULL),
(99, 3085, 'ronald86', 'PN5Vgm9#v)', '2025-08-03 16:16:01', 'carlsparks@gmail.com', '970.163.63', 'ENFP', NULL, NULL, 'Chair everything land hand everybody really fund hope increase be chair design.', NULL),
(100, 3086, 'bellbrooke', '^8kK1X9^zE', '2025-08-03 16:16:01', 'brian43@hunt-daniels.com', '0013160729', 'ESFP', NULL, NULL, 'Against last lot office treatment share high three sit tree.', NULL),
(101, 3087, 'trodriguez', '%V%ThWOe7z', '2025-08-03 16:16:01', 'karaburnett@yahoo.com', '0018289330', 'ESTP', NULL, NULL, 'Resource seek our sometimes nice country grow step my create.', NULL),
(102, 3088, 'olawrence', 's+3UO5oov6', '2025-08-03 16:16:01', 'raymond05@torres.info', '0013451985', 'ENTJ', NULL, NULL, 'Late yet main move deal measure teach sound medical evidence middle.', NULL),
(103, 3089, 'qramos', 'S6P7Vp4l#G', '2025-08-03 16:16:01', 'priscilla66@peck-joseph.com', '4684316705', 'ENTP', NULL, NULL, 'Event catch mother nothing beat court these so issue culture.', NULL),
(104, 3090, 'dustin39', 'eCD%ItMJ^6', '2025-08-03 16:16:01', 'willie33@bryan.org', '472.554.34', 'INTP', NULL, NULL, 'Husband during especially yeah so manager blood.', NULL),
(105, 3091, 'riveracraig', 'nzVx1F7j@Z', '2025-08-03 16:16:01', 'tarnold@hotmail.com', '7268268071', 'ESFJ', NULL, NULL, 'Marriage trial would report but heavy third history this push goal half.', NULL),
(106, 3092, 'martinezkatherine', '(v7APA&q(0', '2025-08-03 16:16:01', 'qcohen@yahoo.com', '4795760841', 'INFP', NULL, NULL, 'At know mention within eye can develop growth involve soldier offer get involve.', NULL),
(107, 3093, 'april79', 'g%S9IhKt#K', '2025-08-03 16:16:01', 'mcneilamy@harris.com', '0012533026', 'ESTJ', NULL, NULL, 'Instead specific yes person tough save.', NULL),
(108, 3094, 'dylanallen', 'p!6S_8Or6a', '2025-08-03 16:16:01', 'rhonda84@gmail.com', '2175980110', 'INTP', NULL, NULL, 'Administration food feeling close forward teacher computer generation institution leader.', NULL),
(109, 3095, 'fernandezjacob', 'z#9Ud_uoAF', '2025-08-03 16:16:01', 'janet87@yahoo.com', '+116529012', 'ESFJ', NULL, NULL, 'Short machine do public old tree common court whom concern build.', NULL),
(110, 3096, 'francotaylor', '+9ZcgNtc+k', '2025-08-03 16:16:01', 'mistyzimmerman@webster-hurley.com', '4448609716', 'ISFP', NULL, NULL, 'Side traditional store fill kid meet produce.', NULL),
(111, 3097, 'rochadennis', 'I*3yGGYH1o', '2025-08-03 16:16:01', 'egilbert@weeks-palmer.com', '+116279266', 'ISFP', NULL, NULL, 'Particular perhaps management read report mission memory on.', NULL),
(112, 3098, 'kenneth64', 'q*5H$jP6&1', '2025-08-03 16:16:01', 'sjacobs@yahoo.com', '269.466.65', 'INTJ', NULL, NULL, 'Movie international poor song day open modern wind enough floor.', NULL),
(113, 3099, 'anitakim', 'Q_B8SjLs&G', '2025-08-03 16:16:01', 'wreid@yahoo.com', '547.524.32', 'INFP', NULL, NULL, 'Push no industry only politics throw inside listen seat coach yard continue claim.', NULL),
(114, 3100, 'michael38', 'X!2GfUZlYa', '2025-08-03 16:16:01', 'ghatfield@hotmail.com', '6476785934', 'ISFP', NULL, NULL, 'Usually happen drug big rest choice.', NULL),
(115, 971221, 'ADMIN', '1', '2025-08-07 19:53:26', 'admin@email.com', '', '', NULL, NULL, '', NULL);

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
(30, 1001, 19),
(31, 1001, 20),
(32, 1002, 20),
(33, 1003, 20);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `user_activity_logs`
--
ALTER TABLE `user_activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
