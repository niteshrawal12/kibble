-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2019 at 06:32 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kibble`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `user_id` int(20) NOT NULL,
  `user_name` varchar(1024) NOT NULL,
  `user_email` varchar(512) NOT NULL,
  `user_mobile` varchar(512) NOT NULL,
  `user_password` varchar(512) NOT NULL,
  `user_modified` datetime DEFAULT NULL,
  `user_created` datetime DEFAULT NULL,
  `user_type` varchar(255) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `user_name`, `user_email`, `user_mobile`, `user_password`, `user_modified`, `user_created`, `user_type`) VALUES
(1, 'Suraj Sugandhi', 'surajsugandhi11@gmail.com', '8720880991', '123456', '2019-11-05 13:07:29', '2019-11-05 13:07:29', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `video_tbl`
--

CREATE TABLE `video_tbl` (
  `web_series_id` int(30) NOT NULL,
  `web_series_name` longtext NOT NULL,
  `web_series_genre` longtext NOT NULL,
  `web_series_no_session_no_episodes` longtext NOT NULL,
  `web_series_episode_duration` longtext NOT NULL,
  `web_series_ratings` longtext NOT NULL,
  `web_series_image` longtext NOT NULL,
  `web_series_video` longtext NOT NULL,
  `web_series_modified` datetime DEFAULT NULL,
  `web_series_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_tbl`
--

INSERT INTO `video_tbl` (`web_series_id`, `web_series_name`, `web_series_genre`, `web_series_no_session_no_episodes`, `web_series_episode_duration`, `web_series_ratings`, `web_series_image`, `web_series_video`, `web_series_modified`, `web_series_created`) VALUES
(1, 'Sacred Games', 'Triller', '8 Seasons 8 Episodes', '70 Min', '6', 'server/uploads/image/t1_1572974817.jpg', 'server/uploads/video/sacredgames_1572974817.mp4', '2019-11-05 18:26:57', '2019-11-05 18:26:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`user_email`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `video_tbl`
--
ALTER TABLE `video_tbl`
  ADD PRIMARY KEY (`web_series_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `video_tbl`
--
ALTER TABLE `video_tbl`
  MODIFY `web_series_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
