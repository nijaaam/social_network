-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 27, 2017 at 08:45 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

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
-- Table structure for table `blogpostcomments`
--

CREATE TABLE IF NOT EXISTS `blogpostcomments` (
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
-- Table structure for table `blogposts`
--

CREATE TABLE IF NOT EXISTS `blogposts` (
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
-- Table structure for table `circlememberships`
--

CREATE TABLE IF NOT EXISTS `circlememberships` (
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
-- Table structure for table `contactinfo`
--

CREATE TABLE IF NOT EXISTS `contactinfo` (
  `userID` int(11) NOT NULL,
  `mobileNo` int(11) NOT NULL,
  `landlineN` int(11) NOT NULL,
  `email` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `generalsettings`
--

CREATE TABLE IF NOT EXISTS `generalsettings` (
  `userID` int(11) NOT NULL,
  `language` varchar(240) NOT NULL,
  `timeZone` varchar(240) NOT NULL,
  `country` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messagecircles`
--

CREATE TABLE IF NOT EXISTS `messagecircles` (
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
-- Table structure for table `messageusers`
--

CREATE TABLE IF NOT EXISTS `messageusers` (
  `messageID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `isSender` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `personalinfo`
--

CREATE TABLE IF NOT EXISTS `personalinfo` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(240) NOT NULL,
  `surname` varchar(240) NOT NULL,
  `gender` varchar(240) NOT NULL,
  `birthday` date NOT NULL,
  `city` varchar(40) NOT NULL,
  `country` varchar(40) NOT NULL,
  UNIQUE KEY `userID_2` (`userID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personalinfo`
--

INSERT INTO `personalinfo` (`userID`, `firstName`, `surname`, `gender`, `birthday`, `city`, `country`) VALUES
(24, 'Osman', 'Ahmed', 'Male', '2017-02-10', 'London', 'United Kingdom'),
(25, 'Bagus', 'Maulana', 'Male', '2017-02-03', 'Jakarta', 'Indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `photocolfriendcirclepermissions`
--

CREATE TABLE IF NOT EXISTS `photocolfriendcirclepermissions` (
  `photoCollectionId` int(11) NOT NULL,
  `friendCircleId` int(11) NOT NULL,
  `grantPermission` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photocollection`
--

CREATE TABLE IF NOT EXISTS `photocollection` (
  `photoCollectionID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`photoCollectionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photocollectionpermissions`
--

CREATE TABLE IF NOT EXISTS `photocollectionpermissions` (
  `photoCollectionID` int(11) NOT NULL,
  `allFriends` tinyint(1) NOT NULL,
  `allFriendsCircles` tinyint(1) NOT NULL,
  `firendsOfFriends` tinyint(1) NOT NULL,
  PRIMARY KEY (`photoCollectionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photocoluserpermissions`
--

CREATE TABLE IF NOT EXISTS `photocoluserpermissions` (
  `photoCollectionId` int(11) NOT NULL,
  `firendUserID` int(11) NOT NULL,
  `grantPermission` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photocomments`
--

CREATE TABLE IF NOT EXISTS `photocomments` (
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
  `timeRequestAccepted` datetime NOT NULL,
  PRIMARY KEY (`userID1`,`userID2`),
  UNIQUE KEY `userID2` (`userID2`,`userID1`),
  UNIQUE KEY `UQ_Friends_UserID2_UserID1` (`userID2`,`userID1`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `relationships`
--

INSERT INTO `relationships` (`userID1`, `userID2`, `invitationSentBy`, `invitationAccepted`, `timeRequestSent`, `timeRequestAccepted`) VALUES
(24, 25, 25, 1, '2017-02-27 18:49:03', '0000-00-00 00:00:00'),
(25, 24, 25, 1, '2017-02-27 18:49:03', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `securitysettings`
--

CREATE TABLE IF NOT EXISTS `securitysettings` (
  `userID` int(11) NOT NULL,
  `whoCanSeeBlog` tinyint(1) NOT NULL,
  `whoCanSeeProfile` tinyint(1) NOT NULL,
  `whoCanSendFriendRequests` tinyint(1) NOT NULL,
  `visibleName` tinyint(1) NOT NULL,
  `visiblePersonalInfo` tinyint(1) NOT NULL,
  UNIQUE KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `securitysettings`
--

INSERT INTO `securitysettings` (`userID`, `whoCanSeeBlog`, `whoCanSeeProfile`, `whoCanSendFriendRequests`, `visibleName`, `visiblePersonalInfo`) VALUES
(24, 2, 0, 0, 0, 0),
(25, 0, 0, 0, 0, 0);

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
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userID` (`userID`),
  KEY `userID_2` (`userID`),
  KEY `userID_3` (`userID`),
  KEY `userID_4` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `email`, `password`, `securityQuestion`, `securityAnswer`) VALUES
(24, 'osman@gmail.com', '14f8f4bb8c0e79a02670a5fea5682da717a5b3d3dc7b1706f7a4bab9afae18c2', '', 'I done'),
(25, 'bagus@gmail.com', '14f8f4bb8c0e79a02670a5fea5682da717a5b3d3dc7b1706f7a4bab9afae18c2', '', 'Life');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogpostcomments`
--
ALTER TABLE `blogpostcomments`
  ADD CONSTRAINT `blogPostComments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `blogPostComments_ibfk_2` FOREIGN KEY (`blogID`) REFERENCES `blogs` (`blogID`),
  ADD CONSTRAINT `blogPostComments_ibfk_3` FOREIGN KEY (`blogPostID`) REFERENCES `blogposts` (`postID`);

--
-- Constraints for table `blogposts`
--
ALTER TABLE `blogposts`
  ADD CONSTRAINT `blogPosts_ibfk_1` FOREIGN KEY (`blogID`) REFERENCES `blogs` (`blogID`);

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userId`);

--
-- Constraints for table `circlememberships`
--
ALTER TABLE `circlememberships`
  ADD CONSTRAINT `circleMemberships_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `circleMemberships_ibfk_2` FOREIGN KEY (`circleID`) REFERENCES `circles` (`circleID`);

--
-- Constraints for table `personalinfo`
--
ALTER TABLE `personalinfo`
  ADD CONSTRAINT `personalInfo_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
