-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2020 at 05:17 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etutor`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign`
--

CREATE TABLE `assign` (
  `Id` int(11) NOT NULL,
  `StudentEmail` varchar(30) NOT NULL,
  `TutorEmail` varchar(30) NOT NULL,
  `DateAssigned` date NOT NULL,
  `DateCreated` date NOT NULL DEFAULT current_timestamp(),
  `StaffId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assign`
--

INSERT INTO `assign` (`Id`, `StudentEmail`, `TutorEmail`, `DateAssigned`, `DateCreated`, `StaffId`) VALUES
(82, 'khorjinho96@gmail.com', 'jinhomobile@gmail.com', '2020-03-04', '2020-03-04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(11) NOT NULL,
  `blog_title` varchar(45) DEFAULT NULL,
  `blog_category` varchar(45) DEFAULT NULL,
  `blog_description` varchar(45) DEFAULT NULL,
  `blog_content` varchar(500) DEFAULT NULL,
  `blog_img` varchar(45) DEFAULT NULL,
  `blog_author` varchar(45) DEFAULT NULL,
  `blog_created` timestamp NULL DEFAULT NULL,
  `blog_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blog_id`, `blog_title`, `blog_category`, `blog_description`, `blog_content`, `blog_img`, `blog_author`, `blog_created`, `blog_updated`) VALUES
(2, 'Why PHP?', 'PHP', 'PHP is useless !', 'PHP is a popular general-purpose scripting language that is especially suited to web development. It was originally created by Rasmus Lerdorf in 1994; the PHP reference implementation is now produced by The PHP Group. ', 'html3.png,', 'jinho', '2020-02-24 16:21:11', '2020-02-24 16:30:55'),
(3, 'Why Bootstrap?', 'Bootstrap', 'Bootstrap is very useful for web designing.', 'Bootstrap is a free and open-source CSS framework directed at responsive, mobile-first front-end web development. It contains CSS- and JavaScript-based design templates for typography, forms, buttons, navigation, and other interface components', NULL, 'jinho', '2020-02-24 16:31:52', '2020-02-24 16:31:52'),
(5, 'Why javascript?', 'JavaScript', 'javascript is a very powerful script', 'JavaScript, often abbreviated as JS, is an interpreted programming language that conforms to the ECMAScript specification. JavaScript is high-level, often just-in-time compiled, and multi-paradigm. It has curly-bracket syntax, dynamic typing, prototype-based object-orientation, and first-class functions.', 'javascript.png,', 'jinho', '2020-02-24 16:48:59', '2020-02-24 16:48:59'),
(6, 'why jquery ?', 'Jquery', 'jquery is a very useful thing! ', 'Query is a JavaScript library designed to simplify HTML DOM tree traversal and manipulation, as well as event handling, CSS animation, and Ajax. It is free, open-source software using the permissive MIT License. As of May 2019, jQuery is used by 73% of the 10 million most popular websites.', 'jqeury.jpg,', 'jinho', '2020-02-24 16:50:15', '2020-02-24 16:50:15'),
(7, 'HTML lates update 2020', 'HTML', 'HTML has released a new update for mobile dev', 'Hypertext Markup Language (HTML) is the standard markup language for documents designed to be displayed in a web browser. It can be assisted by technologies such as Cascading Style Sheets (CSS) and scripting languages such as JavaScript.\n\nWeb browsers receive HTML documents from a web server or from local storage and render the documents into multimedia web pages. HTML describes the structure of a web page semantically and originally included cues for the appearance of the document.\n\nHTML elemen', 'html.jpg,', 'jinho', '2020-02-24 16:51:50', '2020-02-24 16:51:50'),
(8, 'Testing', 'My SQL', 'hi', '', NULL, 'jinho', '2020-02-26 10:38:25', '2020-02-26 10:38:25'),
(9, 'Testing', 'Bootstrap', 'dsfasd', 'hi', 'home-run (3).png,home-run (2).png,home-run (1', 'jinho', '2020-02-26 11:40:17', '2020-02-26 11:40:17'),
(12, '&#39;', 'JavaScript', '      dd          &#39;', '               &#39;', NULL, 'student1', '2020-03-05 07:31:09', '2020-03-05 16:16:08'),
(13, ' &#39; ', 'PHP', '123123', 'lol', NULL, 'student1', '2020-03-05 07:33:18', '2020-03-05 16:15:41');

-- --------------------------------------------------------

--
-- Table structure for table `commentdb`
--

CREATE TABLE `commentdb` (
  `Comment_ID` int(11) NOT NULL,
  `D_ID` int(11) NOT NULL,
  `Comment_Content` varchar(500) NOT NULL,
  `Comment_User_Email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `commentdb`
--

INSERT INTO `commentdb` (`Comment_ID`, `D_ID`, `Comment_Content`, `Comment_User_Email`) VALUES
(28, 14, 'McDonald is good.', 'student1@gmail.com'),
(34, 15, 'first comment yo', 'student2@gmail.com'),
(42, 14, 'chicken', 'student1@gmail.com'),
(46, 14, 'chop', 'student2@gmail.com'),
(47, 14, 'is', 'student2@gmail.com'),
(49, 14, 'HI', 'student1@gmail.com'),
(50, 14, 'cheekang', 'student1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `docdb`
--

CREATE TABLE `docdb` (
  `Doc_ID` int(11) NOT NULL,
  `Doc_Title` varchar(200) NOT NULL,
  `Doc_Name` varchar(200) NOT NULL,
  `Doc_New_Name` varchar(200) NOT NULL,
  `User_Email` varchar(200) NOT NULL,
  `Date_Uploaded` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `docdb`
--

INSERT INTO `docdb` (`Doc_ID`, `Doc_Title`, `Doc_Name`, `Doc_New_Name`, `User_Email`, `Date_Uploaded`) VALUES
(14, 'Test Zip', 'Proposal_COMP1108.zip', 'Uploaded_Documents/Proposal_COMP1108.zip1768232954.proposal comp1108.zip', 'student1@gmail.com', '2020-02-18'),
(15, 'Test PDF', 'Proposal_COMP1108.pdf', 'Uploaded_Documents/Proposal_COMP1108.pdf1658208069.proposal comp1108.pdf', 'student1@gmail.com', '2020-02-18'),
(17, 'doraemon', '1-s2.0-S1571066104808946-main.pdf', 'Uploaded_Documents/1-s2.0-S1571066104808946-main.pdf1153158463.1-s2.0-s1571066104808946-main.pdf', 'student1@gmail.com', '2020-02-26');

-- --------------------------------------------------------

--
-- Table structure for table `meeting`
--

CREATE TABLE `meeting` (
  `meeting_id` int(11) NOT NULL,
  `meeting_name` text NOT NULL,
  `meeting_date` date NOT NULL,
  `meeting_start` time NOT NULL,
  `meeting_end` time NOT NULL,
  `meeting_record` text DEFAULT NULL,
  `user_email` varchar(30) NOT NULL,
  `recipient_email` varchar(30) NOT NULL,
  `meeting_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meeting`
--

INSERT INTO `meeting` (`meeting_id`, `meeting_name`, `meeting_date`, `meeting_start`, `meeting_end`, `meeting_record`, `user_email`, `recipient_email`, `meeting_status`) VALUES
(4, 'test', '2020-02-17', '01:01:00', '01:01:00', 'records/0.80274900 1582716020y2mate.com - Tones and I - Dance Monkey (Lyrics)_3Evj-ssq_9M_144p.mp4', 'student1@gmail.com', 'tutor1@gmail.com', 'Approve'),
(5, 'test jinho', '2020-02-21', '01:00:00', '02:00:00', NULL, 'student1@gmail.com', 'tutor1@gmail.com', 'Approve'),
(6, '919', '2020-02-21', '13:00:00', '14:00:00', NULL, 'student1@gmail.com', 'tutor1@gmail.com', 'Approve'),
(8, 'Henlo', '2020-02-21', '13:00:00', '14:00:00', NULL, 'student1@gmail.com', 'tutor1@gmail.com', 'Approve'),
(10, 'Hey', '2020-02-24', '11:02:00', '12:01:00', NULL, 'student1@gmail.com', 'tutor1@gmail.com', 'Approve'),
(13, '1lapu', '2020-02-24', '01:01:00', '01:02:00', NULL, 'student1@gmail.com', 'tutor1@gmail.com', 'Approve'),
(15, 'bab', '2020-02-26', '10:00:00', '11:00:00', 'records/0.11462900 1582717085y2mate.com - Tones and I - Dance Monkey (Lyrics)_3Evj-ssq_9M_144p.mp4', 'student1@gmail.com', 'tutor1@gmail.com', 'Approve'),
(16, 'HOSEH', '2020-02-26', '10:10:00', '10:10:00', NULL, 'student1@gmail.com', 'tutor1@gmail.com', 'Approve'),
(19, 'xxx', '2020-02-26', '01:01:00', '01:01:00', NULL, 'tutor1@gmail.com', 'student1@gmail.com', 'Approve');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `Id` int(11) NOT NULL,
  `SenderEmail` varchar(30) NOT NULL,
  `RecipientEmail` varchar(30) NOT NULL,
  `Message` varchar(500) NOT NULL,
  `DateSend` datetime NOT NULL,
  `DateCreated` date NOT NULL DEFAULT current_timestamp(),
  `IsRecalled` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`Id`, `SenderEmail`, `RecipientEmail`, `Message`, `DateSend`, `DateCreated`, `IsRecalled`) VALUES
(428, 'student1@gmail.com', 'tutor2@gmail.com', 'help', '2020-02-19 15:50:45', '2020-02-19', 0),
(429, 'student1@gmail.com', 'tutor2@gmail.com', 'cat', '2020-02-19 15:52:46', '2020-02-19', 1),
(431, 'student3@gmail.com', 'tutor3@gmail.com', 'dog', '2020-01-31 15:53:00', '2020-02-19', 0),
(433, 'student1@gmail.com', 'tutor2@gmail.com', 'pig', '2020-02-19 15:53:06', '2020-02-19', 1),
(434, 'student1@gmail.com', 'tutor2@gmail.com', 'chciekn', '2020-02-19 15:53:09', '2020-02-19', 1),
(435, 'student1@gmail.com', 'tutor2@gmail.com', 'lo', '2020-02-19 15:53:12', '2020-02-19', 1),
(436, 'student1@gmail.com', 'tutor2@gmail.com', 'li', '2020-02-19 15:53:14', '2020-02-19', 1),
(437, 'student1@gmail.com', 'tutor2@gmail.com', 'lu', '2020-02-19 15:53:16', '2020-02-19', 0),
(438, 'student1@gmail.com', 'tutor2@gmail.com', 'lu', '2020-02-19 15:56:39', '2020-02-19', 1),
(439, 'rockjiann@gmail.com', 'jinhomobile@gmail.com', 'hi', '2020-02-19 16:14:58', '2020-02-19', 0),
(440, 'rockjiann@gmail.com', 'khorjinho96@gmail.com', 'hi', '2020-02-19 19:03:35', '2020-02-19', 0),
(441, 'student1@gmail.com', 'tutor2@gmail.com', '1', '2020-02-22 22:37:18', '2020-02-22', 0),
(442, 'student1@gmail.com', 'tutor2@gmail.com', '2', '2020-02-22 22:37:21', '2020-02-22', 1),
(443, 'student1@gmail.com', 'tutor2@gmail.com', '2', '2020-02-22 22:38:36', '2020-02-22', 1),
(444, 'student1@gmail.com', 'tutor2@gmail.com', '2', '2020-02-22 22:38:49', '2020-02-22', 1),
(445, 'student1@gmail.com', 'tutor2@gmail.com', '2', '2020-02-22 22:39:06', '2020-02-22', 1),
(446, 'student1@gmail.com', 'tutor2@gmail.com', '3', '2020-02-22 22:39:11', '2020-02-22', 1),
(447, 'student1@gmail.com', 'tutor2@gmail.com', '4', '2020-02-22 22:39:14', '2020-02-22', 1),
(448, 'student1@gmail.com', 'tutor2@gmail.com', '6', '2020-02-22 22:39:18', '2020-02-22', 1),
(449, 'student1@gmail.com', 'tutor2@gmail.com', '7', '2020-02-22 22:39:22', '2020-02-22', 1),
(450, 'student1@gmail.com', 'tutor2@gmail.com', '8', '2020-02-22 22:39:24', '2020-02-22', 1),
(451, 'tutor2@gmail.com', 'student1@gmail.com', '9', '2020-02-22 22:43:33', '2020-02-22', 1),
(452, 'tutor2@gmail.com', 'student1@gmail.com', '10', '2020-02-22 22:43:40', '2020-02-22', 0),
(454, 'tutor2@gmail.com', 'student1@gmail.com', '12', '2020-02-22 22:43:48', '2020-02-22', 1),
(455, 'student1@gmail.com', 'tutor2@gmail.com', '13', '2020-02-22 22:43:53', '2020-02-22', 1),
(456, 'tutor2@gmail.com', 'student1@gmail.com', '11', '2020-02-22 22:50:12', '2020-02-22', 1),
(457, 'tutor2@gmail.com', 'student1@gmail.com', '12', '2020-02-22 22:50:14', '2020-02-22', 0),
(458, 'tutor2@gmail.com', 'student1@gmail.com', '13', '2020-02-22 22:50:16', '2020-02-22', 0),
(459, 'tutor2@gmail.com', 'student1@gmail.com', '14', '2020-02-22 22:50:18', '2020-02-22', 0),
(460, 'tutor2@gmail.com', 'student1@gmail.com', '15', '2020-02-22 22:50:29', '2020-02-22', 0),
(461, 'tutor2@gmail.com', 'student1@gmail.com', '16', '2020-02-22 22:50:31', '2020-02-22', 0),
(462, 'tutor2@gmail.com', 'student1@gmail.com', '17', '2020-02-22 22:50:33', '2020-02-22', 0),
(463, 'tutor2@gmail.com', 'student1@gmail.com', '17', '2020-02-22 22:56:19', '2020-02-22', 0),
(464, 'tutor2@gmail.com', 'student1@gmail.com', 'dog 11-11-2020', '2020-02-26 12:25:34', '2020-02-26', 0),
(465, 'tutor2@gmail.com', 'student1@gmail.com', '@@', '2020-02-26 12:25:43', '2020-02-26', 0),
(466, 'tutor2@gmail.com', 'student1@gmail.com', '<small>##</small>', '2020-02-26 12:25:59', '2020-02-26', 0),
(467, 'student1@gmail.com', 'tutor2@gmail.com', 'Hi', '2020-02-26 19:31:30', '2020-02-26', 0),
(468, 'student1@gmail.com', 'tutor1@gmail.com', 'hi', '2020-02-26 19:31:42', '2020-02-26', 0),
(469, 'tutor1@gmail.com', 'student1@gmail.com', 'helo', '2020-02-26 19:31:49', '2020-02-26', 0),
(470, 'student1@gmail.com', 'tutor1@gmail.com', 'hi', '2020-02-26 19:32:02', '2020-02-26', 0),
(471, 'khorjinho96@gmail.com', 'jinhomobile@gmail.com', 'hi', '2020-03-04 14:42:54', '2020-03-04', 0),
(472, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', 'macDonald', '2020-03-04 14:48:20', '2020-03-04', 0),
(473, 'khorjinho96@gmail.com', 'jinhomobile@gmail.com', 'hi', '2020-03-04 14:51:30', '2020-03-04', 0),
(474, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', 'yes', '2020-03-04 14:51:41', '2020-03-04', 0),
(475, 'khorjinho96@gmail.com', 'jinhomobile@gmail.com', 'lolo', '2020-03-04 14:51:45', '2020-03-04', 0),
(476, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', 'pancake', '2020-03-04 14:51:59', '2020-03-04', 0),
(477, 'khorjinho96@gmail.com', 'jinhomobile@gmail.com', '1', '2020-03-04 14:52:06', '2020-03-04', 0),
(478, 'khorjinho96@gmail.com', 'jinhomobile@gmail.com', '1', '2020-03-04 14:52:30', '2020-03-04', 0),
(479, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', 'pancake', '2020-03-04 14:52:33', '2020-03-04', 0),
(480, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', 'pancake', '2020-03-04 14:52:34', '2020-03-04', 0),
(481, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', 'pancake', '2020-03-04 14:52:34', '2020-03-04', 0),
(482, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', 'pancake', '2020-03-04 14:52:35', '2020-03-04', 0),
(483, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', 'pancake', '2020-03-04 14:52:36', '2020-03-04', 0),
(484, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', '1', '2020-03-04 14:53:00', '2020-03-04', 0),
(485, 'khorjinho96@gmail.com', 'jinhomobile@gmail.com', '2', '2020-03-04 14:53:07', '2020-03-04', 1),
(486, 'khorjinho96@gmail.com', 'jinhomobile@gmail.com', 'boss', '2020-03-04 14:54:08', '2020-03-04', 1),
(487, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', 'YES', '2020-03-04 14:54:29', '2020-03-04', 0),
(488, 'khorjinho96@gmail.com', 'jinhomobile@gmail.com', 'hilo', '2020-03-04 14:54:36', '2020-03-04', 1),
(489, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', 'YES', '2020-03-04 14:56:26', '2020-03-04', 0),
(490, 'khorjinho96@gmail.com', 'jinhomobile@gmail.com', '12', '2020-03-04 14:56:39', '2020-03-04', 1),
(491, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', '12', '2020-03-04 14:56:49', '2020-03-04', 0),
(492, 'khorjinho96@gmail.com', 'jinhomobile@gmail.com', 'aa', '2020-03-04 14:56:53', '2020-03-04', 1),
(493, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', '12', '2020-03-04 14:57:04', '2020-03-04', 0),
(494, 'khorjinho96@gmail.com', 'jinhomobile@gmail.com', '12', '2020-03-04 14:57:06', '2020-03-04', 1),
(495, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', '12', '2020-03-04 14:57:29', '2020-03-04', 0),
(496, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', '12', '2020-03-04 14:57:38', '2020-03-04', 0),
(497, 'jinhomobile@gmail.com', 'khorjinho96@gmail.com', '12', '2020-03-04 14:57:42', '2020-03-04', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign`
--
ALTER TABLE `assign`
  ADD PRIMARY KEY (`StudentEmail`,`TutorEmail`),
  ADD KEY `Id` (`Id`) USING BTREE;

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `commentdb`
--
ALTER TABLE `commentdb`
  ADD PRIMARY KEY (`Comment_ID`),
  ADD KEY `fk_D_ID` (`D_ID`);

--
-- Indexes for table `docdb`
--
ALTER TABLE `docdb`
  ADD PRIMARY KEY (`Doc_ID`);

--
-- Indexes for table `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`meeting_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign`
--
ALTER TABLE `assign`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `commentdb`
--
ALTER TABLE `commentdb`
  MODIFY `Comment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `docdb`
--
ALTER TABLE `docdb`
  MODIFY `Doc_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `meeting`
--
ALTER TABLE `meeting`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=498;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commentdb`
--
ALTER TABLE `commentdb`
  ADD CONSTRAINT `fk_D_ID` FOREIGN KEY (`D_ID`) REFERENCES `docdb` (`Doc_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
