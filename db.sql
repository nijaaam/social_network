-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 13, 2017 at 06:48 PM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `socialcw`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogPostComments`
--

CREATE TABLE IF NOT EXISTS `blogPostComments` (
  `commentID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `blogID` int(11) NOT NULL,
  `blogPostID` int(11) NOT NULL,
  `comment` varchar(240) NOT NULL,
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`commentID`),
  KEY `userID` (`userID`),
  KEY `blogID` (`blogID`),
  KEY `blogPostID` (`blogPostID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blogPosts`
--

CREATE TABLE IF NOT EXISTS `blogPosts` (
  `postID` int(11) NOT NULL,
  `blogID` int(11) NOT NULL,
  `blogTitle` varchar(240) NOT NULL,
  `dateTime` varchar(240) NOT NULL,
  `blogPostBody` varchar(240) NOT NULL,
  PRIMARY KEY (`postID`),
  KEY `blogID` (`blogID`),
  KEY `postID` (`postID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE IF NOT EXISTS `blogs` (
  `blogID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `blogIntro` varchar(240) NOT NULL,
  PRIMARY KEY (`blogID`),
  UNIQUE KEY `userID_2` (`userID`),
  KEY `blogID` (`blogID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `circleMemberships`
--

CREATE TABLE IF NOT EXISTS `circleMemberships` (
  `circleID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`circleID`),
  KEY `userID` (`userID`),
  KEY `circleID` (`circleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `circles`
--

CREATE TABLE IF NOT EXISTS `circles` (
  `circleID` int(11) NOT NULL,
  `name` varchar(240) NOT NULL,
  PRIMARY KEY (`circleID`),
  KEY `circleID` (`circleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contactInfo`
--

CREATE TABLE IF NOT EXISTS `contactInfo` (
  `userID` int(11) NOT NULL,
  `mobileNo` int(11) NOT NULL,
  `landlineN` int(11) NOT NULL,
  `email` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `generalSettings`
--

CREATE TABLE IF NOT EXISTS `generalSettings` (
  `userID` int(11) NOT NULL,
  `language` varchar(240) NOT NULL,
  `timeZone` varchar(240) NOT NULL,
  `country` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messageCircles`
--

CREATE TABLE IF NOT EXISTS `messageCircles` (
  `messageID` int(11) NOT NULL,
  `circleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `messageID` int(11) NOT NULL,
  `contents` varchar(240) NOT NULL,
  `timeSent` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messageUsers`
--

CREATE TABLE IF NOT EXISTS `messageUsers` (
  `messageID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `isSender` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `personalInfo`
--

CREATE TABLE IF NOT EXISTS `personalInfo` (
  `userID` int(11) NOT NULL,
  `firstname` varchar(240) NOT NULL,
  `surname` varchar(240) NOT NULL,
  `gender` varchar(240) NOT NULL,
  `birthday` date NOT NULL,
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photoColFriendCirclePermissions`
--

CREATE TABLE IF NOT EXISTS `photoColFriendCirclePermissions` (
  `photoCollectionId` int(11) NOT NULL,
  `friendCircleId` int(11) NOT NULL,
  `grantPermission` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photoCollection`
--

CREATE TABLE IF NOT EXISTS `photoCollection` (
  `photoCollectionID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`photoCollectionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photoCollectionPermissions`
--

CREATE TABLE IF NOT EXISTS `photoCollectionPermissions` (
  `photoCollectionID` int(11) NOT NULL,
  `allFriends` tinyint(1) NOT NULL,
  `allFriendsCircles` tinyint(1) NOT NULL,
  `firendsOfFriends` tinyint(1) NOT NULL,
  PRIMARY KEY (`photoCollectionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photoColUserPermissions`
--

CREATE TABLE IF NOT EXISTS `photoColUserPermissions` (
  `photoCollectionId` int(11) NOT NULL,
  `firendUserID` int(11) NOT NULL,
  `grantPermission` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photoComments`
--

CREATE TABLE IF NOT EXISTS `photoComments` (
  `commentID` int(11) NOT NULL,
  `photoID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `comment` varchar(240) NOT NULL,
  `dateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `photoID` int(11) NOT NULL,
  `photoCollectionID` int(11) NOT NULL,
  `name` varchar(240) NOT NULL,
  `string` varchar(240) NOT NULL,
  `caption` varchar(240) NOT NULL,
  `dateUploaded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `relationships`
--

CREATE TABLE IF NOT EXISTS `relationships` (
  `userID1` int(11) NOT NULL,
  `userID2` int(11) NOT NULL,
  `invitationSentBy` int(11) NOT NULL,
  `invitationAccepted` tinyint(1) NOT NULL,
  `timeRequestSent` datetime NOT NULL,
  `timeRequestAccepted` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `securitySettings`
--

CREATE TABLE IF NOT EXISTS `securitySettings` (
  `userID` int(11) NOT NULL,
  `whoCanSeeBlog` varchar(240) NOT NULL,
  `whoCanSeeProfile` varchar(240) NOT NULL,
  `whoCanSendFriendRequests` varchar(240) NOT NULL,
  `limitNoVisivlePastPosts` int(11) NOT NULL,
  `limitDataVisiblePosts` date NOT NULL,
  `visibleName` varchar(240) NOT NULL,
  `visiblePersonalInfo` tinyint(1) NOT NULL,
  `visibleContactInfo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `photoID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(240) NOT NULL,
  `password` varchar(240) NOT NULL,
  `securityQuestion` varchar(240) NOT NULL,
  `securityAnswer` varchar(240) NOT NULL,
  `username` varchar(240) NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userID` (`userID`),
  KEY `userID_2` (`userID`),
  KEY `userID_3` (`userID`),
  KEY `userID_4` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `email`, `password`, `securityQuestion`, `securityAnswer`, `username`) VALUES
(1, 'klj', 'a67ef84afbf01ea3d84adda4fabc4adc', 'lkj', 'kljl', 'sfaf'),
(2, 'klj', 'a67ef84afbf01ea3d84adda4fabc4adc', 'lkj', 'kljl', 'sfaf'),
(3, 'klj', 'a67ef84afbf01ea3d84adda4fabc4adc', 'lkj', 'kljl', 'sfaf'),
(4, 'klj', 'a67ef84afbf01ea3d84adda4fabc4adc', 'lkj', 'kljl', 'sfaf'),
(5, 'klj', 'a67ef84afbf01ea3d84adda4fabc4adc', 'lkj', 'kljl', 'sfaf'),
(6, 'klj', 'a67ef84afbf01ea3d84adda4fabc4adc', 'lkj', 'kljl', 'sfaf'),
(7, 'klj', 'a67ef84afbf01ea3d84adda4fabc4adc', 'lkj', 'kljl', 'sfaf');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogPostComments`
--
ALTER TABLE `blogPostComments`
  ADD CONSTRAINT `blogPostComments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `blogPostComments_ibfk_2` FOREIGN KEY (`blogID`) REFERENCES `blogs` (`blogID`),
  ADD CONSTRAINT `blogPostComments_ibfk_3` FOREIGN KEY (`blogPostID`) REFERENCES `blogPosts` (`postID`);

--
-- Constraints for table `blogPosts`
--
ALTER TABLE `blogPosts`
  ADD CONSTRAINT `blogPosts_ibfk_1` FOREIGN KEY (`blogID`) REFERENCES `blogs` (`blogID`);

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `circleMemberships`
--
ALTER TABLE `circleMemberships`
  ADD CONSTRAINT `circleMemberships_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `circleMemberships_ibfk_2` FOREIGN KEY (`circleID`) REFERENCES `circles` (`circleID`);

--
-- Constraints for table `personalInfo`
--
ALTER TABLE `personalInfo`
  ADD CONSTRAINT `personalInfo_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
