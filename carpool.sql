-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 26, 2015 at 09:06 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `dbcarpooling`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `userid` int(11) NOT NULL,
  `user_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `user_street` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `user_subrub` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT '	',
  `zipcode` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `rideid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ride`
--

CREATE TABLE `ride` (
`rideid` int(11) NOT NULL,
  `source` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `destination` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `depart_date` date NOT NULL,
  `depart_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `return_date` date DEFAULT NULL,
  `return_time` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` varchar(1200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` decimal(4,2) DEFAULT NULL,
  `smoker` enum('Smoker','NonSmoker') COLLATE utf8_unicode_ci NOT NULL,
  `post_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rider`
--

CREATE TABLE `rider` (
  `rideid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
`userid` int(11) NOT NULL COMMENT '\\n',
  `firstname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female','other') COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `community` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regdate` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `firstname`, `lastname`, `username`, `password`, `dob`, `gender`, `phone`, `email`, `image`, `community`, `regdate`) VALUES
(6, 'Alok', 'Babu', 'alokbabu', '2d21a54fe7d060d5fdedac7bdbced7033cd743f9', '1988-04-17', 'male', '8281246907', 'alokbabu@nextuz.com', 'http://localhost:8888/carpool/userpic/no-profile-man.jpg', NULL, '2015-02-27');

-- --------------------------------------------------------

--
-- Table structure for table `user_preference`
--

CREATE TABLE `user_preference` (
  `userid` int(11) NOT NULL,
  `is_smoker` enum('Smoker','Nonsmoker') COLLATE utf8_unicode_ci NOT NULL,
  `is_mail_verified` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL,
  `is_fb_user` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL,
  `email_verification_code` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_code` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_email_anonymous` enum('true','false') COLLATE utf8_unicode_ci NOT NULL,
  `is_no_anonumous` enum('true','false') COLLATE utf8_unicode_ci NOT NULL,
  `preferred_contact_method` enum('both','email','phone') COLLATE utf8_unicode_ci NOT NULL,
  `recent_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_preference`
--

INSERT INTO `user_preference` (`userid`, `is_smoker`, `is_mail_verified`, `is_fb_user`, `email_verification_code`, `password_reset_code`, `is_email_anonymous`, `is_no_anonumous`, `preferred_contact_method`, `recent_login`) VALUES
(6, '', 'no', 'no', '83505354d8a3d389caf33742fc249170b147257f17211a85ea07631792fb1d3a', NULL, '', '', 'both', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
 ADD PRIMARY KEY (`userid`), ADD KEY `fk_userid_idx` (`userid`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
 ADD PRIMARY KEY (`rideid`,`userid`), ADD KEY `rideid_idx` (`rideid`), ADD KEY `FK_driver_user_idx` (`userid`);

--
-- Indexes for table `ride`
--
ALTER TABLE `ride`
 ADD PRIMARY KEY (`rideid`);

--
-- Indexes for table `rider`
--
ALTER TABLE `rider`
 ADD PRIMARY KEY (`rideid`,`userid`), ADD KEY `fk_rideid_idx` (`rideid`), ADD KEY `fk_userid_idx` (`userid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `user_preference`
--
ALTER TABLE `user_preference`
 ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ride`
--
ALTER TABLE `ride`
MODIFY `rideid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT '\\n',AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
ADD CONSTRAINT `FK_address_user` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `driver`
--
ALTER TABLE `driver`
ADD CONSTRAINT `FK_driver_ride` FOREIGN KEY (`rideid`) REFERENCES `ride` (`rideid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_driver_user` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rider`
--
ALTER TABLE `rider`
ADD CONSTRAINT `fk_rideid` FOREIGN KEY (`rideid`) REFERENCES `ride` (`rideid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_userid` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_preference`
--
ALTER TABLE `user_preference`
ADD CONSTRAINT `FK_userpreferences_user` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
