-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2024 at 04:51 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `take_note_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `user_ID` int(50) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(90) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`user_ID`, `fullName`, `email`, `password`) VALUES
(1, 'cath', 'cathexxan2@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(2, 'sdd', 'arcamoc@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(3, 'Catherine', 'admin@admin.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(4, 'sdd', 'admisssn@admin.com', '53ca423013b91e59f320d49356f6e430'),
(5, 'ss', 'click2eeeedit@gmail.com', 'eb7c1eabb2baa803f2635d2ba4792d3f'),
(6, 'sda', 'click2esdsddit@gmail.com', 'cc2bd8f09bb88b5dd20f9b432631b8ca'),
(7, 'asas', 'click2sasaedit@gmail.com', '8a48ec102b8ab752eacc30a03b71e1b6'),
(8, 'sdda', 'click2editdsdas@gmail.com', '945c1c2cc6e9ce758cbd5b4e869c0161'),
(9, 'dsds', 'sdsd@fdff.com', 'cef468eeda569cc1b16b45fd53200b9c'),
(10, 'sdds', 'click2esddsdit@gmail.com', '963017110c3d4f8b8a617203897535fa'),
(11, 'sdsd', 'dsds@adsad.c', '4ab47e54c2f73ad4c0eb3974709721cd'),
(12, 'sdd', 'click2edit@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b'),
(13, 'dfsfs', 'fsfsf@gsaddm.co', 'a6b14a3123d327627a887a6a442d427f');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notes`
--

CREATE TABLE `tbl_notes` (
  `tbl_notes_id` int(50) NOT NULL,
  `note_title` varchar(100) NOT NULL,
  `note` varchar(300) NOT NULL,
  `date_time` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `starred` int(10) NOT NULL,
  `archived` int(11) NOT NULL,
  `user_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_notes`
--

INSERT INTO `tbl_notes` (`tbl_notes_id`, `note_title`, `note`, `date_time`, `starred`, `archived`, `user_ID`) VALUES
(27, 'remember me', 'sfafafasfasfasffs', '2024-04-14 14:10:26.646301', 1, 1, NULL),
(28, 'ddsdsd', 'dsds', '2024-04-14 13:40:10.654274', 0, 1, NULL),
(29, ' Of course! Here\'s a short poem for you', '\r\nOf course! Here\'s a short poem for you:\r\n\r\nIn the quiet of the night, when stars softly gleam,\r\nAnd the moon casts its gentle, silvery beam,\r\nWhispers dance on the wings of the breeze,\r\nSwaying through the branches of ancient trees.\r\n\r\nDreams take flight on the wings of the dove,\r\nCarried aloft on', '2024-04-14 07:36:05.000000', 0, 0, NULL),
(30, 'test', 'poetry, literature that evokes a concentrated imaginative awareness of experience or a specific emotional response through language chosen and arranged for its meaning, sound, and rhythm.', '2024-04-14 14:27:19.541079', 0, 0, NULL),
(31, 'dff', 'dffd', '2024-04-14 08:35:23.000000', 0, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexes for table `tbl_notes`
--
ALTER TABLE `tbl_notes`
  ADD PRIMARY KEY (`tbl_notes_id`),
  ADD KEY `fk_user_notes` (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `user_ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_notes`
--
ALTER TABLE `tbl_notes`
  MODIFY `tbl_notes_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_notes`
--
ALTER TABLE `tbl_notes`
  ADD CONSTRAINT `fk_user_notes` FOREIGN KEY (`user_ID`) REFERENCES `register` (`user_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
