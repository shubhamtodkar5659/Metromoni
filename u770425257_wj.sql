-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 17, 2023 at 05:04 AM
-- Server version: 10.5.19-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u770425257_wj`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `mobile`, `password`, `status`, `created_at`, `updated_at`, `type`) VALUES
(1, 'rajesh', 'rajesh@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, '2022-11-05 17:43:41', '2022-11-05 17:43:41', 'NULL'),
(10, 'Renuka', 'renukakul93@gmail.com', '9404241172', '18bef42857abd5eef4358facd37bc22b', NULL, '2023-03-07 18:38:01', '2023-03-07 18:38:01', NULL),
(11, 'shahid', 'shahid@gmail.com', '9875642133', '18bef42857abd5eef4358facd37bc22b', NULL, '2023-04-27 06:24:41', '2023-04-27 06:24:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL COMMENT '1=active,0=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `state_id`, `is_active`) VALUES
(1, 'North and Middle Andaman', 32, 1),
(2, 'South Andaman', 32, 1),
(3, 'Nicobar', 32, 1),
(4, 'Adilabad', 1, 1),
(5, 'Anantapur', 1, 1),
(6, 'Chittoor', 1, 1),
(7, 'East Godavari', 1, 1),
(8, 'Guntur', 1, 1),
(9, 'Hyderabad', 1, 1),
(10, 'Kadapa', 1, 1),
(11, 'Karimnagar', 1, 1),
(12, 'Khammam', 1, 1),
(13, 'Krishna', 1, 1),
(14, 'Kurnool', 1, 1),
(15, 'Mahbubnagar', 1, 1),
(16, 'Medak', 1, 1),
(17, 'Nalgonda', 1, 1),
(18, 'Nellore', 1, 1),
(19, 'Nizamabad', 1, 1),
(20, 'Prakasam', 1, 1),
(21, 'Rangareddi', 1, 1),
(22, 'Srikakulam', 1, 1),
(23, 'Vishakhapatnam', 1, 1),
(24, 'Vizianagaram', 1, 1),
(25, 'Warangal', 1, 1),
(26, 'West Godavari', 1, 1),
(27, 'Anjaw', 3, 1),
(28, 'Changlang', 3, 1),
(29, 'East Kameng', 3, 1),
(30, 'Lohit', 3, 1),
(31, 'Lower Subansiri', 3, 1),
(32, 'Papum Pare', 3, 1),
(33, 'Tirap', 3, 1),
(34, 'Dibang Valley', 3, 1),
(35, 'Upper Subansiri', 3, 1),
(36, 'West Kameng', 3, 1),
(37, 'Barpeta', 2, 1),
(38, 'Bongaigaon', 2, 1),
(39, 'Cachar', 2, 1),
(40, 'Darrang', 2, 1),
(41, 'Dhemaji', 2, 1),
(42, 'Dhubri', 2, 1),
(43, 'Dibrugarh', 2, 1),
(44, 'Goalpara', 2, 1),
(45, 'Golaghat', 2, 1),
(46, 'Hailakandi', 2, 1),
(47, 'Jorhat', 2, 1),
(48, 'Karbi Anglong', 2, 1),
(49, 'Karimganj', 2, 1),
(50, 'Kokrajhar', 2, 1),
(51, 'Lakhimpur', 2, 1),
(52, 'Marigaon', 2, 1),
(53, 'Nagaon', 2, 1),
(54, 'Nalbari', 2, 1),
(55, 'North Cachar Hills', 2, 1),
(56, 'Sibsagar', 2, 1),
(57, 'Sonitpur', 2, 1),
(58, 'Tinsukia', 2, 1),
(59, 'Araria', 4, 1),
(60, 'Aurangabad', 4, 1),
(61, 'Banka', 4, 1),
(62, 'Begusarai', 4, 1),
(63, 'Bhagalpur', 4, 1),
(64, 'Bhojpur', 4, 1),
(65, 'Buxar', 4, 1),
(66, 'Darbhanga', 4, 1),
(67, 'Purba Champaran', 4, 1),
(68, 'Gaya', 4, 1),
(69, 'Gopalganj', 4, 1),
(70, 'Jamui', 4, 1),
(71, 'Jehanabad', 4, 1),
(72, 'Khagaria', 4, 1),
(73, 'Kishanganj', 4, 1),
(74, 'Kaimur', 4, 1),
(75, 'Katihar', 4, 1),
(76, 'Lakhisarai', 4, 1),
(77, 'Madhubani', 4, 1),
(78, 'Munger', 4, 1),
(79, 'Madhepura', 4, 1),
(80, 'Muzaffarpur', 4, 1),
(81, 'Nalanda', 4, 1),
(82, 'Nawada', 4, 1),
(83, 'Patna', 4, 1),
(84, 'Purnia', 4, 1),
(85, 'Rohtas', 4, 1),
(86, 'Saharsa', 4, 1),
(87, 'Samastipur', 4, 1),
(88, 'Sheohar', 4, 1),
(89, 'Sheikhpura', 4, 1),
(90, 'Saran', 4, 1),
(91, 'Sitamarhi', 4, 1),
(92, 'Supaul', 4, 1),
(93, 'Siwan', 4, 1),
(94, 'Vaishali', 4, 1),
(95, 'Pashchim Champaran', 4, 1),
(96, 'Bastar', 36, 1),
(97, 'Bilaspur', 36, 1),
(98, 'Dantewada', 36, 1),
(99, 'Dhamtari', 36, 1),
(100, 'Durg', 36, 1),
(101, 'Jashpur', 36, 1),
(102, 'Janjgir-Champa', 36, 1),
(103, 'Korba', 36, 1),
(104, 'Koriya', 36, 1),
(105, 'Kanker', 36, 1),
(106, 'Kawardha', 36, 1),
(107, 'Mahasamund', 36, 1),
(108, 'Raigarh', 36, 1),
(109, 'Rajnandgaon', 36, 1),
(110, 'Raipur', 36, 1),
(111, 'Surguja', 36, 1),
(112, 'Diu', 29, 1),
(113, 'Daman', 29, 1),
(114, 'Central Delhi', 25, 1),
(115, 'East Delhi', 25, 1),
(116, 'New Delhi', 25, 1),
(117, 'North Delhi', 25, 1),
(118, 'North East Delhi', 25, 1),
(119, 'North West Delhi', 25, 1),
(120, 'South Delhi', 25, 1),
(121, 'South West Delhi', 25, 1),
(122, 'West Delhi', 25, 1),
(123, 'North Goa', 26, 1),
(124, 'South Goa', 26, 1),
(125, 'Ahmedabad', 5, 1),
(126, 'Amreli District', 5, 1),
(127, 'Anand', 5, 1),
(128, 'Banaskantha', 5, 1),
(129, 'Bharuch', 5, 1),
(130, 'Bhavnagar', 5, 1),
(131, 'Dahod', 5, 1),
(132, 'The Dangs', 5, 1),
(133, 'Gandhinagar', 5, 1),
(134, 'Jamnagar', 5, 1),
(135, 'Junagadh', 5, 1),
(136, 'Kutch', 5, 1),
(137, 'Kheda', 5, 1),
(138, 'Mehsana', 5, 1),
(139, 'Narmada', 5, 1),
(140, 'Navsari', 5, 1),
(141, 'Patan', 5, 1),
(142, 'Panchmahal', 5, 1),
(143, 'Porbandar', 5, 1),
(144, 'Rajkot', 5, 1),
(145, 'Sabarkantha', 5, 1),
(146, 'Surendranagar', 5, 1),
(147, 'Surat', 5, 1),
(148, 'Vadodara', 5, 1),
(149, 'Valsad', 5, 1),
(150, 'Ambala', 6, 1),
(151, 'Bhiwani', 6, 1),
(152, 'Faridabad', 6, 1),
(153, 'Fatehabad', 6, 1),
(154, 'Gurgaon', 6, 1),
(155, 'Hissar', 6, 1),
(156, 'Jhajjar', 6, 1),
(157, 'Jind', 6, 1),
(158, 'Karnal', 6, 1),
(159, 'Kaithal', 6, 1),
(160, 'Kurukshetra', 6, 1),
(161, 'Mahendragarh', 6, 1),
(162, 'Mewat', 6, 1),
(163, 'Panchkula', 6, 1),
(164, 'Panipat', 6, 1),
(165, 'Rewari', 6, 1),
(166, 'Rohtak', 6, 1),
(167, 'Sirsa', 6, 1),
(168, 'Sonepat', 6, 1),
(169, 'Yamuna Nagar', 6, 1),
(170, 'Palwal', 6, 1),
(171, 'Bilaspur', 7, 1),
(172, 'Chamba', 7, 1),
(173, 'Hamirpur', 7, 1),
(174, 'Kangra', 7, 1),
(175, 'Kinnaur', 7, 1),
(176, 'Kulu', 7, 1),
(177, 'Lahaul and Spiti', 7, 1),
(178, 'Mandi', 7, 1),
(179, 'Shimla', 7, 1),
(180, 'Sirmaur', 7, 1),
(181, 'Solan', 7, 1),
(182, 'Una', 7, 1),
(183, 'Anantnag', 8, 1),
(184, 'Badgam', 8, 1),
(185, 'Bandipore', 8, 1),
(186, 'Baramula', 8, 1),
(187, 'Doda', 8, 1),
(188, 'Jammu', 8, 1),
(189, 'Kargil', 8, 1),
(190, 'Kathua', 8, 1),
(191, 'Kupwara', 8, 1),
(192, 'Leh', 8, 1),
(193, 'Poonch', 8, 1),
(194, 'Pulwama', 8, 1),
(195, 'Rajauri', 8, 1),
(196, 'Srinagar', 8, 1),
(197, 'Samba', 8, 1),
(198, 'Udhampur', 8, 1),
(199, 'Bokaro', 34, 1),
(200, 'Chatra', 34, 1),
(201, 'Deoghar', 34, 1),
(202, 'Dhanbad', 34, 1),
(203, 'Dumka', 34, 1),
(204, 'Purba Singhbhum', 34, 1),
(205, 'Garhwa', 34, 1),
(206, 'Giridih', 34, 1),
(207, 'Godda', 34, 1),
(208, 'Gumla', 34, 1),
(209, 'Hazaribagh', 34, 1),
(210, 'Koderma', 34, 1),
(211, 'Lohardaga', 34, 1),
(212, 'Pakur', 34, 1),
(213, 'Palamu', 34, 1),
(214, 'Ranchi', 34, 1),
(215, 'Sahibganj', 34, 1),
(216, 'Seraikela and Kharsawan', 34, 1),
(217, 'Pashchim Singhbhum', 34, 1),
(218, 'Ramgarh', 34, 1),
(219, 'Bidar', 9, 1),
(220, 'Belgaum', 9, 1),
(221, 'Bijapur', 9, 1),
(222, 'Bagalkot', 9, 1),
(223, 'Bellary', 9, 1),
(224, 'Bangalore Rural District', 9, 1),
(225, 'Bangalore Urban District', 9, 1),
(226, 'Chamarajnagar', 9, 1),
(227, 'Chikmagalur', 9, 1),
(228, 'Chitradurga', 9, 1),
(229, 'Davanagere', 9, 1),
(230, 'Dharwad', 9, 1),
(231, 'Dakshina Kannada', 9, 1),
(232, 'Gadag', 9, 1),
(233, 'Gulbarga', 9, 1),
(234, 'Hassan', 9, 1),
(235, 'Haveri District', 9, 1),
(236, 'Kodagu', 9, 1),
(237, 'Kolar', 9, 1),
(238, 'Koppal', 9, 1),
(239, 'Mandya', 9, 1),
(240, 'Mysore', 9, 1),
(241, 'Raichur', 9, 1),
(242, 'Shimoga', 9, 1),
(243, 'Tumkur', 9, 1),
(244, 'Udupi', 9, 1),
(245, 'Uttara Kannada', 9, 1),
(246, 'Ramanagara', 9, 1),
(247, 'Chikballapur', 9, 1),
(248, 'Yadagiri', 9, 1),
(249, 'Alappuzha', 10, 1),
(250, 'Ernakulam', 10, 1),
(251, 'Idukki', 10, 1),
(252, 'Kollam', 10, 1),
(253, 'Kannur', 10, 1),
(254, 'Kasaragod', 10, 1),
(255, 'Kottayam', 10, 1),
(256, 'Kozhikode', 10, 1),
(257, 'Malappuram', 10, 1),
(258, 'Palakkad', 10, 1),
(259, 'Pathanamthitta', 10, 1),
(260, 'Thrissur', 10, 1),
(261, 'Thiruvananthapuram', 10, 1),
(262, 'Wayanad', 10, 1),
(263, 'Alirajpur', 11, 1),
(264, 'Anuppur', 11, 1),
(265, 'Ashok Nagar', 11, 1),
(266, 'Balaghat', 11, 1),
(267, 'Barwani', 11, 1),
(268, 'Betul', 11, 1),
(269, 'Bhind', 11, 1),
(270, 'Bhopal', 11, 1),
(271, 'Burhanpur', 11, 1),
(272, 'Chhatarpur', 11, 1),
(273, 'Chhindwara', 11, 1),
(274, 'Damoh', 11, 1),
(275, 'Datia', 11, 1),
(276, 'Dewas', 11, 1),
(277, 'Dhar', 11, 1),
(278, 'Dindori', 11, 1),
(279, 'Guna', 11, 1),
(280, 'Gwalior', 11, 1),
(281, 'Harda', 11, 1),
(282, 'Hoshangabad', 11, 1),
(283, 'Indore', 11, 1),
(284, 'Jabalpur', 11, 1),
(285, 'Jhabua', 11, 1),
(286, 'Katni', 11, 1),
(287, 'Khandwa', 11, 1),
(288, 'Khargone', 11, 1),
(289, 'Mandla', 11, 1),
(290, 'Mandsaur', 11, 1),
(291, 'Morena', 11, 1),
(292, 'Narsinghpur', 11, 1),
(293, 'Neemuch', 11, 1),
(294, 'Panna', 11, 1),
(295, 'Rewa', 11, 1),
(296, 'Rajgarh', 11, 1),
(297, 'Ratlam', 11, 1),
(298, 'Raisen', 11, 1),
(299, 'Sagar', 11, 1),
(300, 'Satna', 11, 1),
(301, 'Sehore', 11, 1),
(302, 'Seoni', 11, 1),
(303, 'Shahdol', 11, 1),
(304, 'Shajapur', 11, 1),
(305, 'Sheopur', 11, 1),
(306, 'Shivpuri', 11, 1),
(307, 'Sidhi', 11, 1),
(308, 'Singrauli', 11, 1),
(309, 'Tikamgarh', 11, 1),
(310, 'Ujjain', 11, 1),
(311, 'Umaria', 11, 1),
(312, 'Vidisha', 11, 1),
(313, 'Ahmednagar', 12, 1),
(314, 'Akola', 12, 1),
(315, 'Amrawati', 12, 1),
(316, 'Aurangabad', 12, 1),
(317, 'Bhandara', 12, 1),
(318, 'Beed', 12, 1),
(319, 'Buldhana', 12, 1),
(320, 'Chandrapur', 12, 1),
(321, 'Dhule', 12, 1),
(322, 'Gadchiroli', 12, 1),
(323, 'Gondiya', 12, 1),
(324, 'Hingoli', 12, 1),
(325, 'Jalgaon', 12, 1),
(326, 'Jalna', 12, 1),
(327, 'Kolhapur', 12, 1),
(328, 'Latur', 12, 1),
(329, 'Mumbai City', 12, 1),
(330, 'Mumbai suburban', 12, 1),
(331, 'Nandurbar', 12, 1),
(332, 'Nanded', 12, 1),
(333, 'Nagpur', 12, 1),
(334, 'Nashik', 12, 1),
(335, 'Osmanabad', 12, 1),
(336, 'Parbhani', 12, 1),
(337, 'Pune', 12, 1),
(338, 'Raigad', 12, 1),
(339, 'Ratnagiri', 12, 1),
(340, 'Sindhudurg', 12, 1),
(341, 'Sangli', 12, 1),
(342, 'Solapur', 12, 1),
(343, 'Satara', 12, 1),
(344, 'Thane', 12, 1),
(345, 'Wardha', 12, 1),
(346, 'Washim', 12, 1),
(347, 'Yavatmal', 12, 1),
(348, 'Bishnupur', 13, 1),
(349, 'Churachandpur', 13, 1),
(350, 'Chandel', 13, 1),
(351, 'Imphal East', 13, 1),
(352, 'Senapati', 13, 1),
(353, 'Tamenglong', 13, 1),
(354, 'Thoubal', 13, 1),
(355, 'Ukhrul', 13, 1),
(356, 'Imphal West', 13, 1),
(357, 'East Garo Hills', 14, 1),
(358, 'East Khasi Hills', 14, 1),
(359, 'Jaintia Hills', 14, 1),
(360, 'Ri-Bhoi', 14, 1),
(361, 'South Garo Hills', 14, 1),
(362, 'West Garo Hills', 14, 1),
(363, 'West Khasi Hills', 14, 1),
(364, 'Aizawl', 15, 1),
(365, 'Champhai', 15, 1),
(366, 'Kolasib', 15, 1),
(367, 'Lawngtlai', 15, 1),
(368, 'Lunglei', 15, 1),
(369, 'Mamit', 15, 1),
(370, 'Saiha', 15, 1),
(371, 'Serchhip', 15, 1),
(372, 'Dimapur', 16, 1),
(373, 'Kohima', 16, 1),
(374, 'Mokokchung', 16, 1),
(375, 'Mon', 16, 1),
(376, 'Phek', 16, 1),
(377, 'Tuensang', 16, 1),
(378, 'Wokha', 16, 1),
(379, 'Zunheboto', 16, 1),
(380, 'Angul', 17, 1),
(381, 'Boudh', 17, 1),
(382, 'Bhadrak', 17, 1),
(383, 'Bolangir', 17, 1),
(384, 'Bargarh', 17, 1),
(385, 'Baleswar', 17, 1),
(386, 'Cuttack', 17, 1),
(387, 'Debagarh', 17, 1),
(388, 'Dhenkanal', 17, 1),
(389, 'Ganjam', 17, 1),
(390, 'Gajapati', 17, 1),
(391, 'Jharsuguda', 17, 1),
(392, 'Jajapur', 17, 1),
(393, 'Jagatsinghpur', 17, 1),
(394, 'Khordha', 17, 1),
(395, 'Kendujhar', 17, 1),
(396, 'Kalahandi', 17, 1),
(397, 'Kandhamal', 17, 1),
(398, 'Koraput', 17, 1),
(399, 'Kendrapara', 17, 1),
(400, 'Malkangiri', 17, 1),
(401, 'Mayurbhanj', 17, 1),
(402, 'Nabarangpur', 17, 1),
(403, 'Nuapada', 17, 1),
(404, 'Nayagarh', 17, 1),
(405, 'Puri', 17, 1),
(406, 'Rayagada', 17, 1),
(407, 'Sambalpur', 17, 1),
(408, 'Subarnapur', 17, 1),
(409, 'Sundargarh', 17, 1),
(410, 'Karaikal', 27, 1),
(411, 'Mahe', 27, 1),
(412, 'Puducherry', 27, 1),
(413, 'Yanam', 27, 1),
(414, 'Amritsar', 18, 1),
(415, 'Bathinda', 18, 1),
(416, 'Firozpur', 18, 1),
(417, 'Faridkot', 18, 1),
(418, 'Fatehgarh Sahib', 18, 1),
(419, 'Gurdaspur', 18, 1),
(420, 'Hoshiarpur', 18, 1),
(421, 'Jalandhar', 18, 1),
(422, 'Kapurthala', 18, 1),
(423, 'Ludhiana', 18, 1),
(424, 'Mansa', 18, 1),
(425, 'Moga', 18, 1),
(426, 'Mukatsar', 18, 1),
(427, 'Nawan Shehar', 18, 1),
(428, 'Patiala', 18, 1),
(429, 'Rupnagar', 18, 1),
(430, 'Sangrur', 18, 1),
(431, 'Ajmer', 19, 1),
(432, 'Alwar', 19, 1),
(433, 'Bikaner', 19, 1),
(434, 'Barmer', 19, 1),
(435, 'Banswara', 19, 1),
(436, 'Bharatpur', 19, 1),
(437, 'Baran', 19, 1),
(438, 'Bundi', 19, 1),
(439, 'Bhilwara', 19, 1),
(440, 'Churu', 19, 1),
(441, 'Chittorgarh', 19, 1),
(442, 'Dausa', 19, 1),
(443, 'Dholpur', 19, 1),
(444, 'Dungapur', 19, 1),
(445, 'Ganganagar', 19, 1),
(446, 'Hanumangarh', 19, 1),
(447, 'Juhnjhunun', 19, 1),
(448, 'Jalore', 19, 1),
(449, 'Jodhpur', 19, 1),
(450, 'Jaipur', 19, 1),
(451, 'Jaisalmer', 19, 1),
(452, 'Jhalawar', 19, 1),
(453, 'Karauli', 19, 1),
(454, 'Kota', 19, 1),
(455, 'Nagaur', 19, 1),
(456, 'Pali', 19, 1),
(457, 'Pratapgarh', 19, 1),
(458, 'Rajsamand', 19, 1),
(459, 'Sikar', 19, 1),
(460, 'Sawai Madhopur', 19, 1),
(461, 'Sirohi', 19, 1),
(462, 'Tonk', 19, 1),
(463, 'Udaipur', 19, 1),
(464, 'East Sikkim', 20, 1),
(465, 'North Sikkim', 20, 1),
(466, 'South Sikkim', 20, 1),
(467, 'West Sikkim', 20, 1),
(468, 'Ariyalur', 21, 1),
(469, 'Chennai', 21, 1),
(470, 'Coimbatore', 21, 1),
(471, 'Cuddalore', 21, 1),
(472, 'Dharmapuri', 21, 1),
(473, 'Dindigul', 21, 1),
(474, 'Erode', 21, 1),
(475, 'Kanchipuram', 21, 1),
(476, 'Kanyakumari', 21, 1),
(477, 'Karur', 21, 1),
(478, 'Madurai', 21, 1),
(479, 'Nagapattinam', 21, 1),
(480, 'The Nilgiris', 21, 1),
(481, 'Namakkal', 21, 1),
(482, 'Perambalur', 21, 1),
(483, 'Pudukkottai', 21, 1),
(484, 'Ramanathapuram', 21, 1),
(485, 'Salem', 21, 1),
(486, 'Sivagangai', 21, 1),
(487, 'Tiruppur', 21, 1),
(488, 'Tiruchirappalli', 21, 1),
(489, 'Theni', 21, 1),
(490, 'Tirunelveli', 21, 1),
(491, 'Thanjavur', 21, 1),
(492, 'Thoothukudi', 21, 1),
(493, 'Thiruvallur', 21, 1),
(494, 'Thiruvarur', 21, 1),
(495, 'Tiruvannamalai', 21, 1),
(496, 'Vellore', 21, 1),
(497, 'Villupuram', 21, 1),
(498, 'Dhalai', 22, 1),
(499, 'North Tripura', 22, 1),
(500, 'South Tripura', 22, 1),
(501, 'West Tripura', 22, 1),
(502, 'Almora', 33, 1),
(503, 'Bageshwar', 33, 1),
(504, 'Chamoli', 33, 1),
(505, 'Champawat', 33, 1),
(506, 'Dehradun', 33, 1),
(507, 'Haridwar', 33, 1),
(508, 'Nainital', 33, 1),
(509, 'Pauri Garhwal', 33, 1),
(510, 'Pithoragharh', 33, 1),
(511, 'Rudraprayag', 33, 1),
(512, 'Tehri Garhwal', 33, 1),
(513, 'Udham Singh Nagar', 33, 1),
(514, 'Uttarkashi', 33, 1),
(515, 'Agra', 23, 1),
(516, 'Allahabad', 23, 1),
(517, 'Aligarh', 23, 1),
(518, 'Ambedkar Nagar', 23, 1),
(519, 'Auraiya', 23, 1),
(520, 'Azamgarh', 23, 1),
(521, 'Barabanki', 23, 1),
(522, 'Badaun', 23, 1),
(523, 'Bagpat', 23, 1),
(524, 'Bahraich', 23, 1),
(525, 'Bijnor', 23, 1),
(526, 'Ballia', 23, 1),
(527, 'Banda', 23, 1),
(528, 'Balrampur', 23, 1),
(529, 'Bareilly', 23, 1),
(530, 'Basti', 23, 1),
(531, 'Bulandshahr', 23, 1),
(532, 'Chandauli', 23, 1),
(533, 'Chitrakoot', 23, 1),
(534, 'Deoria', 23, 1),
(535, 'Etah', 23, 1),
(536, 'Kanshiram Nagar', 23, 1),
(537, 'Etawah', 23, 1),
(538, 'Firozabad', 23, 1),
(539, 'Farrukhabad', 23, 1),
(540, 'Fatehpur', 23, 1),
(541, 'Faizabad', 23, 1),
(542, 'Gautam Buddha Nagar', 23, 1),
(543, 'Gonda', 23, 1),
(544, 'Ghazipur', 23, 1),
(545, 'Gorkakhpur', 23, 1),
(546, 'Ghaziabad', 23, 1),
(547, 'Hamirpur', 23, 1),
(548, 'Hardoi', 23, 1),
(549, 'Mahamaya Nagar', 23, 1),
(550, 'Jhansi', 23, 1),
(551, 'Jalaun', 23, 1),
(552, 'Jyotiba Phule Nagar', 23, 1),
(553, 'Jaunpur District', 23, 1),
(554, 'Kanpur Dehat', 23, 1),
(555, 'Kannauj', 23, 1),
(556, 'Kanpur Nagar', 23, 1),
(557, 'Kaushambi', 23, 1),
(558, 'Kushinagar', 23, 1),
(559, 'Lalitpur', 23, 1),
(560, 'Lakhimpur Kheri', 23, 1),
(561, 'Lucknow', 23, 1),
(562, 'Mau', 23, 1),
(563, 'Meerut', 23, 1),
(564, 'Maharajganj', 23, 1),
(565, 'Mahoba', 23, 1),
(566, 'Mirzapur', 23, 1),
(567, 'Moradabad', 23, 1),
(568, 'Mainpuri', 23, 1),
(569, 'Mathura', 23, 1),
(570, 'Muzaffarnagar', 23, 1),
(571, 'Pilibhit', 23, 1),
(572, 'Pratapgarh', 23, 1),
(573, 'Rampur', 23, 1),
(574, 'Rae Bareli', 23, 1),
(575, 'Saharanpur', 23, 1),
(576, 'Sitapur', 23, 1),
(577, 'Shahjahanpur', 23, 1),
(578, 'Sant Kabir Nagar', 23, 1),
(579, 'Siddharthnagar', 23, 1),
(580, 'Sonbhadra', 23, 1),
(581, 'Sant Ravidas Nagar', 23, 1),
(582, 'Sultanpur', 23, 1),
(583, 'Shravasti', 23, 1),
(584, 'Unnao', 23, 1),
(585, 'Varanasi', 23, 1),
(586, 'Birbhum', 24, 1),
(587, 'Bankura', 24, 1),
(588, 'Bardhaman', 24, 1),
(589, 'Darjeeling', 24, 1),
(590, 'Dakshin Dinajpur', 24, 1),
(591, 'Hooghly', 24, 1),
(592, 'Howrah', 24, 1),
(593, 'Jalpaiguri', 24, 1),
(594, 'Cooch Behar', 24, 1),
(595, 'Kolkata', 24, 1),
(596, 'Malda', 24, 1),
(597, 'Midnapore', 24, 1),
(598, 'Murshidabad', 24, 1),
(599, 'Nadia', 24, 1),
(600, 'North 24 Parganas', 24, 1),
(601, 'South 24 Parganas', 24, 1),
(602, 'Purulia', 24, 1),
(603, 'Uttar Dinajpur', 24, 1),
(604, '', 0, 1),
(605, '29', 3, 0),
(606, '5', 1, 0),
(607, '316', 12, 0),
(608, '263', 11, 0);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(5) NOT NULL,
  `countryCode` char(2) NOT NULL DEFAULT '',
  `name` varchar(45) NOT NULL DEFAULT '',
  `is_active` tinyint(4) NOT NULL COMMENT '1=active,0=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `countryCode`, `name`, `is_active`) VALUES
(1, 'AD', 'Andorra', 0),
(2, 'AE', 'United Arab Emirates', 0),
(3, 'AF', 'Afghanistan', 0),
(4, 'AG', 'Antigua and Barbuda', 0),
(5, 'AI', 'Anguilla', 0),
(6, 'AL', 'Albania', 0),
(7, 'AM', 'Armenia', 0),
(8, 'AO', 'Angola', 0),
(9, 'AQ', 'Antarctica', 0),
(10, 'AR', 'Argentina', 0),
(11, 'AS', 'American Samoa', 0),
(12, 'AT', 'Austria', 0),
(13, 'AU', 'Australia', 0),
(14, 'AW', 'Aruba', 0),
(15, 'AX', 'Åland', 0),
(16, 'AZ', 'Azerbaijan', 0),
(17, 'BA', 'Bosnia and Herzegovina', 0),
(18, 'BB', 'Barbados', 0),
(19, 'BD', 'Bangladesh', 0),
(20, 'BE', 'Belgium', 0),
(21, 'BF', 'Burkina Faso', 0),
(22, 'BG', 'Bulgaria', 0),
(23, 'BH', 'Bahrain', 0),
(24, 'BI', 'Burundi', 0),
(25, 'BJ', 'Benin', 0),
(26, 'BL', 'Saint Barthélemy', 0),
(27, 'BM', 'Bermuda', 0),
(28, 'BN', 'Brunei', 0),
(29, 'BO', 'Bolivia', 0),
(30, 'BQ', 'Bonaire', 0),
(31, 'BR', 'Brazil', 0),
(32, 'BS', 'Bahamas', 0),
(33, 'BT', 'Bhutan', 0),
(34, 'BV', 'Bouvet Island', 0),
(35, 'BW', 'Botswana', 0),
(36, 'BY', 'Belarus', 0),
(37, 'BZ', 'Belize', 0),
(38, 'CA', 'Canada', 0),
(39, 'CC', 'Cocos [Keeling] Islands', 0),
(40, 'CD', 'Democratic Republic of the Congo', 0),
(41, 'CF', 'Central African Republic', 0),
(42, 'CG', 'Republic of the Congo', 0),
(43, 'CH', 'Switzerland', 0),
(44, 'CI', 'Ivory Coast', 0),
(45, 'CK', 'Cook Islands', 0),
(46, 'CL', 'Chile', 0),
(47, 'CM', 'Cameroon', 0),
(48, 'CN', 'China', 0),
(49, 'CO', 'Colombia', 0),
(50, 'CR', 'Costa Rica', 0),
(51, 'CU', 'Cuba', 0),
(52, 'CV', 'Cape Verde', 0),
(53, 'CW', 'Curacao', 0),
(54, 'CX', 'Christmas Island', 0),
(55, 'CY', 'Cyprus', 0),
(56, 'CZ', 'Czech Republic', 0),
(57, 'DE', 'Germany', 0),
(58, 'DJ', 'Djibouti', 0),
(59, 'DK', 'Denmark', 0),
(60, 'DM', 'Dominica', 0),
(61, 'DO', 'Dominican Republic', 0),
(62, 'DZ', 'Algeria', 0),
(63, 'EC', 'Ecuador', 0),
(64, 'EE', 'Estonia', 0),
(65, 'EG', 'Egypt', 0),
(66, 'EH', 'Western Sahara', 0),
(67, 'ER', 'Eritrea', 0),
(68, 'ES', 'Spain', 0),
(69, 'ET', 'Ethiopia', 0),
(70, 'FI', 'Finland', 0),
(71, 'FJ', 'Fiji', 0),
(72, 'FK', 'Falkland Islands', 0),
(73, 'FM', 'Micronesia', 0),
(74, 'FO', 'Faroe Islands', 0),
(75, 'FR', 'France', 0),
(76, 'GA', 'Gabon', 0),
(77, 'GB', 'United Kingdom', 0),
(78, 'GD', 'Grenada', 0),
(79, 'GE', 'Georgia', 0),
(80, 'GF', 'French Guiana', 0),
(81, 'GG', 'Guernsey', 0),
(82, 'GH', 'Ghana', 0),
(83, 'GI', 'Gibraltar', 0),
(84, 'GL', 'Greenland', 0),
(85, 'GM', 'Gambia', 0),
(86, 'GN', 'Guinea', 0),
(87, 'GP', 'Guadeloupe', 0),
(88, 'GQ', 'Equatorial Guinea', 0),
(89, 'GR', 'Greece', 0),
(90, 'GS', 'South Georgia and the South Sandwich Islands', 0),
(91, 'GT', 'Guatemala', 0),
(92, 'GU', 'Guam', 0),
(93, 'GW', 'Guinea-Bissau', 0),
(94, 'GY', 'Guyana', 0),
(95, 'HK', 'Hong Kong', 0),
(96, 'HM', 'Heard Island and McDonald Islands', 0),
(97, 'HN', 'Honduras', 0),
(98, 'HR', 'Croatia', 0),
(99, 'HT', 'Haiti', 0),
(100, 'HU', 'Hungary', 0),
(101, 'ID', 'Indonesia', 0),
(102, 'IE', 'Ireland', 0),
(103, 'IL', 'Israel', 0),
(104, 'IM', 'Isle of Man', 0),
(105, 'IN', 'India', 1),
(106, 'IO', 'British Indian Ocean Territory', 0),
(107, 'IQ', 'Iraq', 0),
(108, 'IR', 'Iran', 0),
(109, 'IS', 'Iceland', 0),
(110, 'IT', 'Italy', 0),
(111, 'JE', 'Jersey', 0),
(112, 'JM', 'Jamaica', 0),
(113, 'JO', 'Jordan', 0),
(114, 'JP', 'Japan', 0),
(115, 'KE', 'Kenya', 0),
(116, 'KG', 'Kyrgyzstan', 0),
(117, 'KH', 'Cambodia', 0),
(118, 'KI', 'Kiribati', 0),
(119, 'KM', 'Comoros', 0),
(120, 'KN', 'Saint Kitts and Nevis', 0),
(121, 'KP', 'North Korea', 0),
(122, 'KR', 'South Korea', 0),
(123, 'KW', 'Kuwait', 0),
(124, 'KY', 'Cayman Islands', 0),
(125, 'KZ', 'Kazakhstan', 0),
(126, 'LA', 'Laos', 0),
(127, 'LB', 'Lebanon', 0),
(128, 'LC', 'Saint Lucia', 0),
(129, 'LI', 'Liechtenstein', 0),
(130, 'LK', 'Sri Lanka', 0),
(131, 'LR', 'Liberia', 0),
(132, 'LS', 'Lesotho', 0),
(133, 'LT', 'Lithuania', 0),
(134, 'LU', 'Luxembourg', 0),
(135, 'LV', 'Latvia', 0),
(136, 'LY', 'Libya', 0),
(137, 'MA', 'Morocco', 0),
(138, 'MC', 'Monaco', 0),
(139, 'MD', 'Moldova', 0),
(140, 'ME', 'Montenegro', 0),
(141, 'MF', 'Saint Martin', 0),
(142, 'MG', 'Madagascar', 0),
(143, 'MH', 'Marshall Islands', 0),
(144, 'MK', 'Macedonia', 0),
(145, 'ML', 'Mali', 0),
(146, 'MM', 'Myanmar [Burma]', 0),
(147, 'MN', 'Mongolia', 0),
(148, 'MO', 'Macao', 0),
(149, 'MP', 'Northern Mariana Islands', 0),
(150, 'MQ', 'Martinique', 0),
(151, 'MR', 'Mauritania', 0),
(152, 'MS', 'Montserrat', 0),
(153, 'MT', 'Malta', 0),
(154, 'MU', 'Mauritius', 0),
(155, 'MV', 'Maldives', 0),
(156, 'MW', 'Malawi', 0),
(157, 'MX', 'Mexico', 0),
(158, 'MY', 'Malaysia', 0),
(159, 'MZ', 'Mozambique', 0),
(160, 'NA', 'Namibia', 0),
(161, 'NC', 'New Caledonia', 0),
(162, 'NE', 'Niger', 0),
(163, 'NF', 'Norfolk Island', 0),
(164, 'NG', 'Nigeria', 0),
(165, 'NI', 'Nicaragua', 0),
(166, 'NL', 'Netherlands', 0),
(167, 'NO', 'Norway', 0),
(168, 'NP', 'Nepal', 0),
(169, 'NR', 'Nauru', 0),
(170, 'NU', 'Niue', 0),
(171, 'NZ', 'New Zealand', 0),
(172, 'OM', 'Oman', 0),
(173, 'PA', 'Panama', 0),
(174, 'PE', 'Peru', 0),
(175, 'PF', 'French Polynesia', 0),
(176, 'PG', 'Papua New Guinea', 0),
(177, 'PH', 'Philippines', 0),
(178, 'PK', 'Pakistan', 0),
(179, 'PL', 'Poland', 0),
(180, 'PM', 'Saint Pierre and Miquelon', 0),
(181, 'PN', 'Pitcairn Islands', 0),
(182, 'PR', 'Puerto Rico', 0),
(183, 'PS', 'Palestine', 0),
(184, 'PT', 'Portugal', 0),
(185, 'PW', 'Palau', 0),
(186, 'PY', 'Paraguay', 0),
(187, 'QA', 'Qatar', 0),
(188, 'RE', 'Réunion', 0),
(189, 'RO', 'Romania', 0),
(190, 'RS', 'Serbia', 0),
(191, 'RU', 'Russia', 0),
(192, 'RW', 'Rwanda', 0),
(193, 'SA', 'Saudi Arabia', 0),
(194, 'SB', 'Solomon Islands', 0),
(195, 'SC', 'Seychelles', 0),
(196, 'SD', 'Sudan', 0),
(197, 'SE', 'Sweden', 0),
(198, 'SG', 'Singapore', 0),
(199, 'SH', 'Saint Helena', 0),
(200, 'SI', 'Slovenia', 0),
(201, 'SJ', 'Svalbard and Jan Mayen', 0),
(202, 'SK', 'Slovakia', 0),
(203, 'SL', 'Sierra Leone', 0),
(204, 'SM', 'San Marino', 0),
(205, 'SN', 'Senegal', 0),
(206, 'SO', 'Somalia', 0),
(207, 'SR', 'Suriname', 0),
(208, 'SS', 'South Sudan', 0),
(209, 'ST', 'São Tomé and Príncipe', 0),
(210, 'SV', 'El Salvador', 0),
(211, 'SX', 'Sint Maarten', 0),
(212, 'SY', 'Syria', 0),
(213, 'SZ', 'Swaziland', 0),
(214, 'TC', 'Turks and Caicos Islands', 0),
(215, 'TD', 'Chad', 0),
(216, 'TF', 'French Southern Territories', 0),
(217, 'TG', 'Togo', 0),
(218, 'TH', 'Thailand', 0),
(219, 'TJ', 'Tajikistan', 0),
(220, 'TK', 'Tokelau', 0),
(221, 'TL', 'East Timor', 0),
(222, 'TM', 'Turkmenistan', 0),
(223, 'TN', 'Tunisia', 0),
(224, 'TO', 'Tonga', 0),
(225, 'TR', 'Turkey', 0),
(226, 'TT', 'Trinidad and Tobago', 0),
(227, 'TV', 'Tuvalu', 0),
(228, 'TW', 'Taiwan', 0),
(229, 'TZ', 'Tanzania', 0),
(230, 'UA', 'Ukraine', 0),
(231, 'UG', 'Uganda', 0),
(232, 'UM', 'U.S. Minor Outlying Islands', 0),
(233, 'US', 'United States', 0),
(234, 'UY', 'Uruguay', 0),
(235, 'UZ', 'Uzbekistan', 0),
(236, 'VA', 'Vatican City', 0),
(237, 'VC', 'Saint Vincent and the Grenadines', 0),
(238, 'VE', 'Venezuela', 0),
(239, 'VG', 'British Virgin Islands', 0),
(240, 'VI', 'U.S. Virgin Islands', 0),
(241, 'VN', 'Vietnam', 0),
(242, 'VU', 'Vanuatu', 0),
(243, 'WF', 'Wallis and Futuna', 0),
(244, 'WS', 'Samoa', 0),
(245, 'XK', 'Kosovo', 0),
(246, 'YE', 'Yemen', 0),
(247, 'YT', 'Mayotte', 0),
(248, 'ZA', 'South Africa', 0),
(249, 'ZM', 'Zambia', 0),
(250, 'ZW', 'Zimbabwe', 0);

-- --------------------------------------------------------

--
-- Table structure for table `create_plans`
--

CREATE TABLE `create_plans` (
  `id` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `months` varchar(255) DEFAULT NULL,
  `discription` text DEFAULT NULL,
  `rule1` text DEFAULT NULL,
  `rule2` text DEFAULT NULL,
  `rule3` text DEFAULT NULL,
  `rule4` text DEFAULT NULL,
  `visiblePro` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `create_plans`
--

INSERT INTO `create_plans` (`id`, `label`, `heading`, `price`, `months`, `discription`, `rule1`, `rule2`, `rule3`, `rule4`, `visiblePro`, `created_at`, `updated_at`) VALUES
(12, 'vip', 'gold plus', '2699,4599,6999,10000', '1,3,6,12', 'gold plus plan', 'Chat with your matches', 'View 75 contact numbers', 'Get highlighted to your matches', 'Feature on top of search results', 75, '2022-11-23 11:51:40', '2022-11-23 11:51:40'),
(13, 'vip', 'gold ', '2699,4599,6999,11111', '1,3,6,12', 'gold plan', 'Chat with your matches', 'View 50 contact numbers', 'Get highlighted to your matches', 'Feature on top of search results', 50, '2022-11-23 11:54:25', '2022-11-23 11:54:25'),
(14, 'supreme', 'diamond', '2699,4599,6999,12222', '1,3,6,12', 'diamond plan', 'Chat with your matches', 'View 100 contact numbers', 'Get highlighted to your matches', 'Feature on top of search results', 100, '2022-11-23 11:56:59', '2022-11-23 11:56:59'),
(15, 'premium', 'diamond plus', '13333,87874,87897,89578', '4', 'diamond plus plan', 'Chat with your matches', 'View 200 contact numbers', 'Get highlighted to your matches', 'Feature on top of search results', 200, '2022-11-23 11:58:10', '2022-11-23 11:58:10'),
(22, 'premium', 'Silver membership', '1000,2000,3000,4000', '1,2,3,4', 'Silver membership', 'Feature 1 :', 'Feature 2 :', 'Feature 3 :', 'Feature 4 :', 10, '2023-01-09 23:44:52', '2023-01-09 23:44:52');

-- --------------------------------------------------------

--
-- Table structure for table `higher_education`
--

CREATE TABLE `higher_education` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `higher_education`
--

INSERT INTO `higher_education` (`id`, `name`, `is_active`) VALUES
(1, 'ME', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiry`
--

INSERT INTO `inquiry` (`id`, `name`, `email`, `phone`, `message`, `created_at`, `updated_at`) VALUES
(1, 'shubhangi shinde', 'shubhangi@gmail.com', '9876543210', 'Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. \r\n', '2022-11-08', '2022-11-08'),
(2, 'ashutosh rana', 'ashu@gmail.com', '7894561230', 'kldsfjio aerjtfksdo lmfk jkjo hdi fhsui  eryrfius   fuiuif ds re rojkdsf hsduyf  dufh djshfjkdhufe  udhfj dujfhudi', '2022-11-17', '2022-11-17');

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_id` varchar(150) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `payment_flag` varchar(15) NOT NULL,
  `metadata` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`id`, `user_id`, `payment_id`, `plan_id`, `amount`, `payment_flag`, `metadata`, `created_at`) VALUES
(1, 26, 'pay_LPgyiYEGUrixMx', 14, 2699.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-10 00:00:00'),
(2, 26, 'pay_LPh0iMQegOZRWx', 14, 2699.00, 'success', '', '2023-03-10 10:09:57'),
(3, 26, 'pay_LPuTzOC4XycIgE', 14, 2699.00, 'success', '', '2023-03-10 23:20:41'),
(4, 26, 'pay_LPucAcHtuIf6ek', 14, 2699.00, 'success', '', '2023-03-10 23:28:27'),
(5, 26, 'pay_LPud00mEmhUp6A', 14, 2699.00, 'success', '', '2023-03-10 23:29:14'),
(6, 26, 'pay_LPufklDUbH0orP', 14, 2699.00, 'success', '', '2023-03-10 23:31:47'),
(7, 26, 'pay_LPugF07YmGUcKu', 12, 2699.00, 'success', '', '2023-03-10 23:32:15'),
(8, 26, 'pay_LPuhopJQ9ricI6', 12, 2699.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-10 23:33:39'),
(9, 26, 'pay_LPux8E9BTdc1ed', 14, 2699.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-10 23:48:21'),
(10, 26, 'pay_LPv1ZpAIXpuOFY', 14, 2699.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-10 23:52:21'),
(11, 26, 'pay_LPv1xnBdnVRgY0', 13, 2699.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-10 23:52:48'),
(12, 26, 'pay_LPv33asDWlJmT1', 14, 2699.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-10 23:53:47'),
(13, 26, 'pay_LPv3r3cAFDMAD2', 14, 2699.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-10 23:54:37'),
(14, 26, 'pay_LPv4SYg7qSVOh2', 13, 2699.00, 'success', '', '2023-03-10 23:55:19'),
(15, 26, 'pay_LPv5NEz2DyFY3U', 12, 2699.00, 'success', '', '2023-03-10 23:56:05'),
(16, 26, 'pay_LPv6T77EjvdmcV', 13, 2699.00, 'success', '', '2023-03-10 23:57:07'),
(17, 26, 'pay_LPv7Zf2ZsajSKa', 12, 2699.00, 'success', '', '2023-03-10 23:58:10'),
(18, 26, 'pay_LPv8R1girUGpZv', 13, 2699.00, 'success', '', '2023-03-10 23:59:01'),
(19, 26, 'pay_LPv94yA1c47pi1', 12, 2699.00, 'success', '', '2023-03-10 23:59:34'),
(20, 26, 'pay_LPv9QuoB4i4l9X', 14, 2699.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-10 23:59:51'),
(21, 26, 'pay_LPvpelnK3WHuLD', 13, 2699.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-11 00:39:46'),
(22, 26, 'pay_LPvq3ZINGVgtvi', 15, 13333.00, 'success', '', '2023-03-11 00:40:15'),
(23, 26, 'pay_LPvtRJL8hsXqnm', 22, 1000.00, 'success', '', '2023-03-11 00:43:27'),
(24, 26, 'pay_LPvu6ClyU59zMr', 14, 2699.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-11 00:43:59'),
(25, 26, 'pay_LWo7UipskWTnVo', 14, 2699.00, 'success', '', '2023-03-28 09:39:57'),
(26, 26, 'pay_LWo7xoswojGv4Y', 15, 13333.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-28 09:40:16'),
(27, 26, 'pay_LWo8riIhGNDGPO', 15, 13333.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-28 09:41:07'),
(28, 26, 'pay_LWo9RcGgm6NyT1', 15, 13333.00, 'fail', '{\"code\":\"BAD_REQUEST_ERROR\",\"description\":\"Your payment didnt go through as it was declined by the bank Try another payment method or contact your bank\",\"source\":\"bank\",\"step\":\"payment_authorization\",\"reason\":\"payment_failed\"}', '2023-03-28 09:41:40'),
(29, 26, 'pay_LWoCO21gfEcwZl', 22, 1000.00, 'success', '', '2023-03-28 09:44:37'),
(30, 26, 'pay_LZHMDZcyQ4QCQD', 15, 13333.00, 'success', '', '2023-04-03 10:04:22');

-- --------------------------------------------------------

--
-- Table structure for table `religion`
--

CREATE TABLE `religion` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `religion`
--

INSERT INTO `religion` (`id`, `name`, `is_active`) VALUES
(1, 'Hindu', 1);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'interest shown by',
  `sent_id` int(11) NOT NULL COMMENT 'interest shown in',
  `status` int(11) DEFAULT NULL COMMENT '1=sent,0=delete,2=accepted,3=rejected',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `sent_id`, `status`, `created_at`, `updated_at`) VALUES
(69, 12, 1, 1, '2022-12-30 18:07:44', '2022-12-30 18:07:44'),
(70, 23, 20, 3, '2022-12-31 00:27:56', '2022-12-31 00:27:56'),
(71, 21, 23, 1, '2022-12-31 00:29:08', '2022-12-31 00:29:08'),
(72, 23, 21, 0, '2022-12-31 15:36:52', '2022-12-31 15:36:52'),
(73, 21, 20, 2, '2023-01-01 00:34:36', '2023-01-01 00:34:36'),
(74, 20, 23, 3, '2023-01-01 11:20:42', '2023-01-01 11:20:42'),
(75, 20, 21, 0, '2023-01-01 11:43:31', '2023-01-01 11:43:31'),
(76, 20, 28, 1, '2023-01-05 21:51:18', '2023-01-05 21:51:18'),
(77, 20, 27, 1, '2023-01-07 20:09:13', '2023-01-07 20:09:13'),
(78, 29, 24, 1, '2023-01-07 20:19:23', '2023-01-07 20:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `name`, `date`, `location`, `message`, `filename`, `created_at`, `updated_at`) VALUES
(2, 'nikhil', '2022-11-23', 'Location ', 't', '1552561678_i_xLvmDxd_X2.webp', '2022-11-08 17:47:06', '2022-11-08 17:47:06'),
(3, 'Sneha', '', 'Nashik', 'I sent her invitation on this platform and she accepted. it has given me tremendous help in finding my soul-mate, and we found each other as life partner which we had dreamed for.', '269847665_294811262605180_1971103402336625723_n-1024x683.webp', '2022-12-22 02:24:24', '2022-12-22 02:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `shortlist`
--

CREATE TABLE `shortlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'liker user\r\n',
  `liked_p_id` int(11) DEFAULT NULL COMMENT 'liked user',
  `liked_p_name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shortlist`
--

INSERT INTO `shortlist` (`id`, `user_id`, `liked_p_id`, `liked_p_name`, `status`) VALUES
(22, 21, 20, 'Renukakul93@gmail.com', 1),
(23, 20, 21, 'Nikhil', 1),
(24, 20, 23, 'Sanket@gmail.com', 0),
(25, 23, 20, 'Renukakul93@gmail.com', 1),
(26, 23, 21, 'Nikhil', 0),
(27, 29, 25, 'Vani kabra', 0),
(28, 20, 28, 'Kunal', 1),
(29, 29, 24, 'Radhika', 0),
(30, 29, 20, 'Renukakul93@gmail.com', 0),
(31, 26, 25, 'Vani kabra', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `image_name` text NOT NULL,
  `created_date` date NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `image_name`, `created_date`, `is_active`) VALUES
(2, 'real-wedding-3.jpg', '2023-01-06', 0),
(3, 'couple-page-header1-1-1.jpg', '2023-01-06', 0),
(13, 'wedding-ritual-putting-ring-finger-india.jpg', '2023-05-22', 1),
(18, '1000_F_399821658_iQfNFm3pxVuDPQfVbsAnJn2as48kZxU7-transformed.jpeg', '2023-05-22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `country_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL COMMENT '1=active,0=inactive	'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`, `is_active`) VALUES
(1, 'ANDHRA PRADESH', 105, 1),
(2, 'ASSAM', 105, 1),
(3, 'ARUNACHAL PRADESH', 105, 1),
(4, 'BIHAR', 105, 1),
(5, 'GUJRAT', 105, 1),
(6, 'HARYANA', 105, 1),
(7, 'HIMACHAL PRADESH', 105, 1),
(8, 'JAMMU & KASHMIR', 105, 1),
(9, 'KARNATAKA', 105, 1),
(10, 'KERALA', 105, 1),
(11, 'MADHYA PRADESH', 105, 1),
(12, 'MAHARASHTRA', 105, 1),
(13, 'MANIPUR', 105, 1),
(14, 'MEGHALAYA', 105, 1),
(15, 'MIZORAM', 105, 1),
(16, 'NAGALAND', 105, 1),
(17, 'ORISSA', 105, 1),
(18, 'PUNJAB', 105, 1),
(19, 'RAJASTHAN', 105, 1),
(20, 'SIKKIM', 105, 1),
(21, 'TAMIL NADU', 105, 1),
(22, 'TRIPURA', 105, 1),
(23, 'UTTAR PRADESH', 105, 1),
(24, 'WEST BENGAL', 105, 1),
(25, 'DELHI', 105, 1),
(26, 'GOA', 105, 1),
(27, 'PONDICHERY', 105, 1),
(28, 'LAKSHDWEEP', 105, 1),
(29, 'DAMAN & DIU', 105, 1),
(30, 'DADRA & NAGAR', 105, 1),
(31, 'CHANDIGARH', 105, 1),
(32, 'ANDAMAN & NICOBAR', 105, 1),
(33, 'UTTARANCHAL', 105, 1),
(34, 'JHARKHAND', 105, 1),
(35, 'CHATTISGARH', 105, 1),
(36, '', 1, 1),
(37, '3', 105, 0),
(38, '1', 105, 0),
(39, '12', 105, 0),
(40, '11', 105, 0);

-- --------------------------------------------------------

--
-- Table structure for table `success_story`
--

CREATE TABLE `success_story` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `success_story`
--

INSERT INTO `success_story` (`id`, `name`, `location`, `message`, `filename`, `created_at`, `updated_at`) VALUES
(3, 'Deepika & Ranveer', 'Mumbai', 'We Took Premium Membership To Contact ..', '80985-wwi-recommends-wedding-calendar-2021-gautam-khullar-lead.jpeg', '2022-11-08 17:46:00', '2022-11-08 17:46:00'),
(4, 'Virat & Anushka', 'Delhi', 'Ours Was A Fairy Tale Come True', 'pexels-photo-936554.jpeg', '2022-11-08 17:48:36', '2022-11-08 17:48:36'),
(7, 'Sachin & Anjali', 'Pune', 'Thanks To Devyog Vivah For Helping Me Find My Life Partner', '134481-PR_Faves-123-of-285.jpeg', '2022-11-28 09:56:43', '2022-11-28 09:56:43');

-- --------------------------------------------------------

--
-- Table structure for table `table_plan`
--

CREATE TABLE `table_plan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `plan_duration` varchar(255) NOT NULL,
  `type_plan` varchar(2552) NOT NULL,
  `plan_price` int(11) NOT NULL,
  `type_plan_id` int(11) NOT NULL,
  `plan_purchase_date` datetime DEFAULT NULL,
  `plan_expiry_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_plan`
--

INSERT INTO `table_plan` (`id`, `user_id`, `label`, `payment_status`, `plan_duration`, `type_plan`, `plan_price`, `type_plan_id`, `plan_purchase_date`, `plan_expiry_date`) VALUES
(34, 29, 'premium', 1, '3', 'Silver membership', 3000, 22, '2023-01-10 00:00:00', '2023-04-09 00:00:00'),
(35, 20, 'supreme', 1, '1,3,6,12', 'diamond', 2699, 14, '2023-01-10 00:00:00', '2023-02-09 00:00:00'),
(36, 20, 'premium', 1, '4', 'diamond plus', 13333, 15, '2023-01-10 00:00:00', '2023-05-10 00:00:00'),
(37, 20, 'supreme', 1, '6', 'diamond', 6999, 14, '2023-01-10 00:00:00', '2023-07-09 00:00:00'),
(38, 29, 'supreme', 1, '6', 'diamond', 6999, 14, '2023-01-10 00:00:00', '2023-07-09 00:00:00'),
(39, 29, 'vip', 1, '1,3,6,12', 'gold ', 2699, 13, '2023-01-10 00:00:00', '2023-02-09 00:00:00'),
(40, 29, 'supreme', 1, '1,3,6,12', 'diamond', 2699, 14, '2023-01-11 00:00:00', '2023-02-10 00:00:00'),
(41, 29, 'vip', 1, '6', 'gold ', 2699, 13, '2023-01-11 00:00:00', '2023-07-10 00:00:00'),
(42, 29, 'vip', 1, '6', 'gold ', 2699, 13, '2023-01-11 00:00:00', '2023-07-10 00:00:00'),
(43, 29, 'supreme', 1, '6', 'diamond', 2699, 14, '2023-01-11 00:00:00', '2023-07-10 00:00:00'),
(44, 29, 'supreme', 1, '6', 'diamond', 2699, 14, '2023-01-11 00:00:00', '2023-07-10 00:00:00'),
(45, 29, 'supreme', 1, '6', 'diamond', 2699, 14, '2023-01-11 00:00:00', '2023-07-10 00:00:00'),
(46, 29, 'vip', 1, '3', 'gold plus', 0, 12, '2023-01-11 00:00:00', '2023-04-11 00:00:00'),
(47, 29, 'vip', 1, '3', 'gold plus', 0, 12, '2023-01-11 00:00:00', '2023-04-11 00:00:00'),
(48, 29, 'supreme', 1, '12', 'diamond', 12222, 14, '2023-01-11 00:00:00', '2024-01-06 00:00:00'),
(49, 29, 'supreme', 1, '12', 'diamond', 12222, 14, '2023-01-11 00:00:00', '2024-01-06 00:00:00'),
(50, 29, 'vip', 1, '6', 'gold ', 6999, 13, '2023-01-11 00:00:00', '2023-07-10 00:00:00'),
(51, 26, 'vip', 1, '1', 'gold plus', 2699, 12, '2023-03-07 00:00:00', '2023-04-06 00:00:00'),
(52, 26, 'vip', 1, '1', 'gold plus', 2699, 12, '2023-03-07 00:00:00', '2023-04-06 00:00:00'),
(53, 26, 'vip', 1, '1', 'gold ', 2699, 13, '2023-03-10 00:00:00', '2023-04-08 00:00:00'),
(54, 26, 'vip', 1, '1', 'gold ', 2699, 13, '2023-03-10 00:00:00', '2023-04-08 00:00:00'),
(55, 26, 'supreme', 1, '1', 'diamond', 2699, 14, '2023-03-10 00:00:00', '2023-04-08 00:00:00'),
(56, 26, 'vip', 1, '1', 'gold ', 2699, 13, '2023-03-10 00:00:00', '2023-04-08 00:00:00'),
(57, 26, 'supreme', 1, '1', 'diamond', 2699, 14, '2023-03-10 00:00:00', '2023-04-09 00:00:00'),
(58, 26, 'supreme', 1, '1', 'diamond', 2699, 14, '2023-03-10 00:00:00', '2023-04-09 00:00:00'),
(59, 26, 'vip', 1, '1', 'gold plus', 2699, 12, '2023-03-10 00:00:00', '2023-04-09 00:00:00'),
(60, 26, 'vip', 1, '1', 'gold ', 2699, 13, '2023-03-10 00:00:00', '2023-04-09 00:00:00'),
(61, 26, 'vip', 1, '1', 'gold plus', 2699, 12, '2023-03-10 00:00:00', '2023-04-09 00:00:00'),
(62, 26, 'vip', 1, '1', 'gold ', 2699, 13, '2023-03-10 00:00:00', '2023-04-09 00:00:00'),
(63, 26, 'vip', 1, '1', 'gold plus', 2699, 12, '2023-03-10 00:00:00', '2023-04-09 00:00:00'),
(64, 26, 'vip', 1, '1', 'gold ', 2699, 13, '2023-03-10 00:00:00', '2023-04-09 00:00:00'),
(65, 26, 'vip', 1, '1', 'gold plus', 2699, 12, '2023-03-10 00:00:00', '2023-04-09 00:00:00'),
(66, 26, 'premium', 1, '4', '', 13333, 15, '2023-03-11 00:00:00', '2023-07-08 00:00:00'),
(67, 26, 'premium', 1, '1', 'Silver membership', 1000, 22, '2023-03-11 00:00:00', '2023-04-09 00:00:00'),
(68, 26, 'supreme', 1, '1', 'diamond', 2699, 14, '2023-03-28 00:00:00', '2023-04-27 00:00:00'),
(69, 26, 'premium', 1, '1', 'Silver membership', 1000, 22, '2023-03-28 00:00:00', '2023-04-27 00:00:00'),
(70, 26, 'premium', 1, '4', 'diamond plus', 13333, 15, '2023-04-03 00:00:00', '2023-08-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_regiter`
--

CREATE TABLE `user_regiter` (
  `id` int(11) NOT NULL,
  `profile_for` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `marStat` varchar(255) DEFAULT NULL,
  `lang` varchar(255) DEFAULT NULL,
  `diet` varchar(255) DEFAULT NULL,
  `height` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `sub-com` varchar(255) DEFAULT NULL,
  `community-checkbox` varchar(255) DEFAULT NULL,
  `HighEdu` varchar(255) DEFAULT NULL,
  `collage` varchar(255) DEFAULT NULL,
  `prof` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `income` varchar(255) DEFAULT NULL,
  `yes/no` varchar(255) DEFAULT NULL,
  `bGrp` varchar(255) DEFAULT NULL,
  `bDate` varchar(255) DEFAULT NULL,
  `age` int(22) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `bTime` varchar(255) DEFAULT NULL,
  `bLocation` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `payment_status` int(11) NOT NULL DEFAULT 1,
  `plan_duration` varchar(255) NOT NULL DEFAULT '1',
  `type_plan` varchar(255) NOT NULL DEFAULT 'Free',
  `label` varchar(255) NOT NULL DEFAULT 'other',
  `plan_price` int(11) NOT NULL DEFAULT 0,
  `type_plan_id` int(11) DEFAULT NULL,
  `plan_purchase_date` datetime NOT NULL DEFAULT current_timestamp(),
  `plan_expiry_date` date DEFAULT NULL,
  `OTP` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `other_lang` varchar(50) NOT NULL,
  `smoking` varchar(10) NOT NULL,
  `drinking` varchar(10) NOT NULL,
  `gotra` varchar(50) NOT NULL,
  `caste` varchar(100) NOT NULL,
  `native_place` varchar(50) NOT NULL,
  `out_of_india` varchar(10) NOT NULL,
  `p_father` varchar(50) NOT NULL,
  `p_father_occ` varchar(50) NOT NULL,
  `p_mother` varchar(50) NOT NULL,
  `p_mother_occ` varchar(50) NOT NULL,
  `m_father` varchar(50) NOT NULL,
  `m_father_occ` varchar(50) NOT NULL,
  `m_mother` varchar(50) NOT NULL,
  `m_mother_occ` varchar(50) NOT NULL,
  `no_of_brothers` int(11) NOT NULL,
  `no_of_sisters` int(11) NOT NULL,
  `brothers_details` varchar(50) NOT NULL,
  `sisters_details` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_regiter`
--

INSERT INTO `user_regiter` (`id`, `profile_for`, `name`, `surname`, `email`, `phone`, `password`, `country`, `state`, `city`, `address`, `marStat`, `lang`, `diet`, `height`, `religion`, `sub-com`, `community-checkbox`, `HighEdu`, `collage`, `prof`, `specialization`, `income`, `yes/no`, `bGrp`, `bDate`, `age`, `gender`, `bTime`, `bLocation`, `filename`, `bio`, `payment_status`, `plan_duration`, `type_plan`, `label`, `plan_price`, `type_plan_id`, `plan_purchase_date`, `plan_expiry_date`, `OTP`, `status`, `created_at`, `updated_at`, `other_lang`, `smoking`, `drinking`, `gotra`, `caste`, `native_place`, `out_of_india`, `p_father`, `p_father_occ`, `p_mother`, `p_mother_occ`, `m_father`, `m_father_occ`, `m_mother`, `m_mother_occ`, `no_of_brothers`, `no_of_sisters`, `brothers_details`, `sisters_details`) VALUES
(20, '', 'Renukakul93@gmail.com', '', 'renukakul93@gmail.com', '9404241172', '0e255a03d759b2e6c26c614336d15442', '105', '12', '310', '', 'Never married', '', '', '5', 'Hindu', 'Sonar', '', '', '', '', 'Endocrininologist', '', '', 'A+', '1993-04-15', 29, 'Female', '', '', 'bride.jpg', '', 1, '6', 'diamond', 'supreme', 6999, 14, '2023-01-10 00:00:00', '2023-07-09', NULL, 1, '2022-12-31 00:06:50', '2022-12-31 00:06:50', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', ''),
(21, '', 'Nikhil', '', 'nik@gmail.com', '9812345678', 'd50a3893ae7b7c297e55bf0fcf9e5012', '105', '12', '320', '', 'Never married', '', '', '6', 'Hindu', 'Jain', '', '', '', 'Armed Forces', 'Dermatologist', '', '', 'A+', '1992-05-17', 30, 'Male', '', '', 'couple-4.jpg', '', 1, '1', 'Free', 'other', 0, NULL, '2022-12-31 00:14:36', '2023-01-29', NULL, 0, '2022-12-31 00:14:36', '2022-12-31 00:14:36', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', ''),
(23, '', 'Sanket@gmail.com', '', 'sanke@gmail.com', '7588643826', '18bef42857abd5eef4358facd37bc22b', '105', '12', '330', '', 'Divorced', '', 'Non-Neg', '5', 'Hindu', 'Lohar', '', '', '', '', 'Psychiatrist', '', '', 'A+', '1996-07-26', 26, 'Male', '', '', 'aguiam-wedding-photography-21.jpg', '', 1, '1,3,6,12', 'gold ', 'vip', 2699, 13, '2022-12-31 00:00:00', '2023-01-29', NULL, 1, '2022-12-31 00:25:09', '2022-12-31 00:25:09', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', ''),
(24, '', 'Radhika', '', 'radhika@gmail.com', '9404241086', '18bef42857abd5eef4358facd37bc22b', '105', '12', '325', '', 'Never married', 'Marathi', 'Veg', '4', 'Hindu', 'Koli', '', 'BOT', '', 'Studying', 'Dentist', '', 'Yes', 'A+', '1997-03-06', 26, 'Female', '', '', 'cartoon_bride_groom.jpg', '', 1, '1', 'Free', 'other', 0, NULL, '2023-01-05 00:25:01', '2023-02-03', NULL, 1, '2023-01-05 00:25:01', '2023-01-05 00:25:01', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', ''),
(25, '', 'Vani kabra', '', 'vk@gmail.com', '9784592355', '18bef42857abd5eef4358facd37bc22b', '105', '12', '325', '', 'Never married', 'Marathi', 'Veg', '4', 'Hindu', 'Maratha', '', 'BOT', '', 'Studying', 'Dentist', '', 'Yes', 'A+', '1997-03-06', 28, 'Female', '', '', 'cartoon_bride_groom.jpg', '', 1, '1', 'Free', 'other', 0, NULL, '2023-01-05 00:25:04', '2023-02-03', NULL, 1, '2023-01-05 00:25:04', '2023-01-05 00:25:04', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', ''),
(26, '', 'Shahid Kapoor', '', 'shahid@gmail.com', '9875642133', '18bef42857abd5eef4358facd37bc22b', '105', '17', '394', '', 'Divorced', 'Hindi', 'Occasionally Non-Veg', '6', 'Hindu', 'Punjabi', '', 'MD', '', 'Armed Forces', 'Cardiovascular Surgeon', '', 'Yes', 'A+', '2005-11-18', 18, 'Male', '', '', '43df5cf101cf190ca81bcb7b16c9307d.jpg', '', 1, '4', 'diamond plus', 'premium', 13333, 15, '2023-04-03 00:00:00', '2023-08-01', NULL, 1, '2023-01-05 00:27:10', '2023-01-05 00:27:10', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', ''),
(27, '', 'Vijay', '', 'vijay@gmail.com', '4597982355', '18bef42857abd5eef4358facd37bc22b', '105', '12', '329', '', 'Widowed', 'Hindi', '', '6', 'Hindu', 'Koli', '', 'BAMS', '', '', 'Homeopathy', '', 'Yes', 'A+', '1996-03-14', 27, 'Male', '', '', 'real-wedding-3.jpg', '', 1, '1', 'Free', 'other', 0, NULL, '2023-01-05 00:32:11', '2023-02-03', NULL, 1, '2023-01-05 00:32:11', '2023-01-05 00:32:11', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', ''),
(28, '', 'Kunal', '', 'kunal@gmail.com', '6547885522', '18bef42857abd5eef4358facd37bc22b', '105', '18', '428', '', 'Widowed', 'Hindi', 'Eggetarian', '5', 'Hindu', 'Punjabi', '', 'Bachelor in Speach and Hearing', '', '', 'Endocrininologist', '', 'Yes', 'A+', '1995-10-15', 28, 'Male', '', '', 'post-pic-3.jpg', '', 1, '1', 'Free', 'other', 0, NULL, '2023-01-05 00:33:40', '2023-02-03', NULL, 0, '2023-01-05 00:33:40', '2023-01-05 00:33:40', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', ''),
(29, 'My Son', 'Abhijit T', '', 'abhijit@gmail.com', '9456789123', '18bef42857abd5eef4358facd37bc22b', '105', '12', '315', 'Cidco', 'Never married', 'Marathi', 'Occasionally Non-Veg', '5.8', '1', 'Marwadi', 'I am not particular about my Partners Community', 'ME', 'S.B', 'Private Practice', 'Business', '5000000.5', 'yes', 'B+', '2023-02-03', 0, 'Male', '20:04', 'Mumbai', 'couple-page-header1-1-1.jpg', '', 1, '6', 'gold ', 'vip', 6999, 13, '2023-01-11 00:00:00', '2023-07-10', NULL, 0, '2023-01-07 20:15:51', '2023-01-07 20:15:51', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', ''),
(30, 'My Son', 'Nikita', '', 'Nyjhala13@gmail.com', '9359486033', '4c22bd444899d3b6047a10b20a2f26db', '105', '5', '136', 'Devyog', 'Never married', 'Hindi', 'Veg', '6', 'Hindu', 'Rajput', '', 'ME', 'College', 'Studying', 'MS', '90000', 'Yes', 'A+', '1987-12-29', 36, 'Male', '21:59', 'Kutch', '', 'Hi ', 1, '1', 'Free', 'other', 0, NULL, '2023-05-24 15:29:05', '2023-06-23', NULL, 1, '2023-05-24 15:29:05', '2023-05-24 15:29:05', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', ''),
(31, 'My Son', 'Nikita', '', 'Nyjhala13@gmail.com', '9359486033', '4c22bd444899d3b6047a10b20a2f26db', '105', '5', '136', 'Devyog', 'Never married', 'Hindi', 'Veg', '6', 'Hindu', 'Rajput', '', 'ME', 'College', 'Studying', 'MS', '90000', 'Yes', 'A+', '1987-12-29', 36, 'Male', '21:59', 'Kutch', '', 'Hi ', 1, '1', 'Free', 'other', 0, NULL, '2023-05-24 15:29:08', '2023-06-23', NULL, 1, '2023-05-24 15:29:08', '2023-05-24 15:29:08', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `visited_profile_records`
--

CREATE TABLE `visited_profile_records` (
  `id` int(11) NOT NULL,
  `profile_viewer` int(11) NOT NULL,
  `profile_viewed` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visited_profile_records`
--

INSERT INTO `visited_profile_records` (`id`, `profile_viewer`, `profile_viewed`, `plan_id`) VALUES
(1, 23, 20, 0),
(2, 23, 21, 0),
(3, 20, 23, 7),
(4, 20, 5, 7),
(5, 20, 21, 7),
(6, 20, 26, 7),
(7, 20, 28, 13),
(11, 20, 27, 13),
(16, 29, 24, 13),
(17, 26, 29, 15),
(18, 26, 20, 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `create_plans`
--
ALTER TABLE `create_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `higher_education`
--
ALTER TABLE `higher_education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `religion`
--
ALTER TABLE `religion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shortlist`
--
ALTER TABLE `shortlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `success_story`
--
ALTER TABLE `success_story`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_plan`
--
ALTER TABLE `table_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_regiter`
--
ALTER TABLE `user_regiter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visited_profile_records`
--
ALTER TABLE `visited_profile_records`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=609;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `create_plans`
--
ALTER TABLE `create_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `higher_education`
--
ALTER TABLE `higher_education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `religion`
--
ALTER TABLE `religion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shortlist`
--
ALTER TABLE `shortlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `success_story`
--
ALTER TABLE `success_story`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `table_plan`
--
ALTER TABLE `table_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `user_regiter`
--
ALTER TABLE `user_regiter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `visited_profile_records`
--
ALTER TABLE `visited_profile_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
