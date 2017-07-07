-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 06, 2017 at 03:46 PM
-- Server version: 5.5.55-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mkcheng_PollMaster`
--

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE IF NOT EXISTS `color` (
  `cid` int(11) NOT NULL DEFAULT '0',
  `hex` varchar(7) DEFAULT NULL,
  `descrip` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `favourite`
--

CREATE TABLE IF NOT EXISTS `favourite` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `gid` int(11) NOT NULL DEFAULT '0',
  `Adminid` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groupsurvey`
--

CREATE TABLE IF NOT EXISTS `groupsurvey` (
  `gid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `oid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) DEFAULT NULL,
  `options` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surtags`
--

CREATE TABLE IF NOT EXISTS `surtags` (
  `sid` int(11) NOT NULL DEFAULT '0',
  `tid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE IF NOT EXISTS `survey` (
  `sid` int(11) NOT NULL DEFAULT '0',
  `question` varchar(200) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tid` int(11) NOT NULL DEFAULT '0',
  `tname` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(15) DEFAULT NULL,
  `pw` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usergroup`
--

CREATE TABLE IF NOT EXISTS `usergroup` (
  `gid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uservote`
--

CREATE TABLE IF NOT EXISTS `uservote` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `oid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `color`
--
ALTER TABLE `color`
 ADD PRIMARY KEY (`cid`), ADD UNIQUE KEY `hex` (`hex`,`descrip`);

--
-- Indexes for table `favourite`
--
ALTER TABLE `favourite`
 ADD PRIMARY KEY (`userid`,`sid`), ADD KEY `userid` (`userid`), ADD KEY `sid` (`sid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`gid`), ADD KEY `Adminid` (`Adminid`), ADD KEY `name` (`name`);

--
-- Indexes for table `groupsurvey`
--
ALTER TABLE `groupsurvey`
 ADD PRIMARY KEY (`gid`,`sid`), ADD KEY `gid` (`gid`), ADD KEY `sid` (`sid`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
 ADD PRIMARY KEY (`oid`), ADD KEY `sid` (`sid`), ADD KEY `sid_2` (`sid`);

--
-- Indexes for table `surtags`
--
ALTER TABLE `surtags`
 ADD PRIMARY KEY (`sid`,`tid`), ADD KEY `sid` (`sid`), ADD KEY `tid` (`tid`), ADD KEY `sid_2` (`sid`);

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
 ADD PRIMARY KEY (`sid`), ADD KEY `cid` (`cid`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`tid`), ADD UNIQUE KEY `tname` (`tname`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`userid`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `usergroup`
--
ALTER TABLE `usergroup`
 ADD PRIMARY KEY (`gid`,`userid`), ADD KEY `userid` (`userid`), ADD KEY `gid` (`gid`);

--
-- Indexes for table `uservote`
--
ALTER TABLE `uservote`
 ADD PRIMARY KEY (`userid`,`oid`), ADD KEY `userid` (`userid`), ADD KEY `oid` (`oid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favourite`
--
ALTER TABLE `favourite`
ADD CONSTRAINT `favourite_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `survey` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `favourite_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`Adminid`) REFERENCES `user` (`userid`) ON UPDATE CASCADE;

--
-- Constraints for table `groupsurvey`
--
ALTER TABLE `groupsurvey`
ADD CONSTRAINT `groupsurvey_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `survey` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `groupsurvey_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `groups` (`gid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `options`
--
ALTER TABLE `options`
ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `survey` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `surtags`
--
ALTER TABLE `surtags`
ADD CONSTRAINT `surtags_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `survey` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `surtags_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `tags` (`tid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `survey`
--
ALTER TABLE `survey`
ADD CONSTRAINT `survey_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `color` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usergroup`
--
ALTER TABLE `usergroup`
ADD CONSTRAINT `usergroup_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `groups` (`gid`) ON UPDATE CASCADE,
ADD CONSTRAINT `usergroup_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON UPDATE CASCADE;

--
-- Constraints for table `uservote`
--
ALTER TABLE `uservote`
ADD CONSTRAINT `uservote_ibfk_2` FOREIGN KEY (`oid`) REFERENCES `options` (`oid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `uservote_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
