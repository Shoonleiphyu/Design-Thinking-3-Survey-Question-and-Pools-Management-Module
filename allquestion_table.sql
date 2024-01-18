-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 07, 2024 at 11:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testsurveyq_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `allquestion_table`
--

CREATE TABLE `allquestion_table` (
  `QUESTION_ID` int(100) NOT NULL,
  `QUESTION_TEXT` longtext NOT NULL,
  `QUESTION_TYPE` varchar(45) NOT NULL,
  `QUESTION_OPT` longtext DEFAULT NULL,
  `QUESTION_CAT` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allquestion_table`
--

INSERT INTO `allquestion_table` (`QUESTION_ID`, `QUESTION_TEXT`, `QUESTION_TYPE`, `QUESTION_OPT`, `QUESTION_CAT`) VALUES
(1, 'What is your age?', 'text', '', 'demographic'),
(2, 'What is your gender?', 'multipleChoice', 'Male,Female', 'demographic'),
(3, 'What is your nationality?', 'text', '', 'demographic'),
(4, 'Where are you currently residing?', 'text', '', 'demographic'),
(5, 'What is your highest level of education?', 'multipleChoice', 'Preschool,Elementary School,Junior Highschool,Senior Highschool,Undergraduate Level,Postgraduate Level,Master Degree,Phd/Doctorate Degree', 'education'),
(6, 'What is your current academic level?', 'multipleChoice', 'Preschool,Elementary School,Junior Highschool,Senior Highschool,Undergraduate Level,Postgraduate Level,Master Degree,Phd/Doctorate Degree', 'education'),
(7, 'What is your field of specialization?', 'text', '', 'education'),
(8, 'How satisfied are you with your current educational program?', 'scaleRating', '1,2,3,4,5', 'education'),
(9, 'What types of educational technology tools do you find most effective?', 'text', '', 'education'),
(10, 'What teaching methods do you find most engaging and effective?', 'text', '', 'education'),
(11, 'How important do you consider hands-on, practical learning experiences?\n', 'scaleRating', '1,2,3,4,5', 'education'),
(12, 'How satisfied are you with the current assessment methods used in your educational program?', 'scaleRating', '1,2,3,4,5', 'education'),
(13, 'How would you describe your preferred learning environment?', 'multipleChoice', 'Small class size,Interactive teaching,Use of technology,Collarborative projects', 'education'),
(14, 'What factors contribute most to your learning experience?', 'multipleChoice', 'Lectures,Group Discussions,Hand-on Activities,Online Tutorials', 'education'),
(15, 'What are your career aspirations or educational goals for the future?', 'text', '', 'education'),
(16, 'How well do you feel your current education is preparing you for your future career or further education?\n', 'scaleRating', '1,2,3,4,5', 'education'),
(17, 'What challenges do you face in your current educational experience?', 'text', '', 'education'),
(18, 'Are there any specific barriers that hinder your learning progress?\n', 'text', '', 'education'),
(19, 'On a scale of 1 to 10, how satisfied are you with your overall educational experience?\n', 'scaleRating', '1,2,3,4,5', 'education'),
(105, 'How often do you smoke', 'multipleChoice', 'daily,once/ twice a week,once/twice a month,in a specific time', 'smoking'),
(124, 'what is your occupation?', 'multipleChoice', 'job5555,job2,job3', 'demographic'),
(126, 'Rate this work', 'scaleRating', '1,2,3', 'rating'),
(127, 'what is your name?', 'text', '', 'demographic'),
(128, 'your favourite fruit', 'multipleChoice', 'apple,mango,kiwi', 'favourite'),
(129, 'tell me about you', 'text', '', 'demographic'),
(130, 'who are your parents?', 'text', '', 'demographic'),
(133, 'what is your university name?', 'text', '', 'education'),
(137, 'rate this course', 'scaleRating', '1,2,3', 'education');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allquestion_table`
--
ALTER TABLE `allquestion_table`
  ADD PRIMARY KEY (`QUESTION_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allquestion_table`
--
ALTER TABLE `allquestion_table`
  MODIFY `QUESTION_ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
