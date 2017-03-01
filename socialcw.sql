-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 01, 2017 at 04:38 PM
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
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admins` (`userID`) VALUES ('24');
INSERT INTO `admins` (`userID`) VALUES ('25');

-- --------------------------------------------------------

--
-- Table structure for table `blogposts`
--

CREATE TABLE IF NOT EXISTS `blogposts` (
  `postID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `dateTime` varchar(240) NOT NULL,
  `blogPostBody` varchar(240) NOT NULL,
  PRIMARY KEY (`postID`),
  KEY `blogID` (`userID`),
  KEY `postID` (`postID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `blogposts`
--

INSERT INTO `blogposts` (`postID`, `userID`, `dateTime`, `blogPostBody`) VALUES
(1, 24, '2017-03-01 15:25:27', 'sd flasd sladfj '),
(2, 24, '2017-03-01 15:31:57', 'jkk\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `circlememberships`
--

CREATE TABLE IF NOT EXISTS `circlememberships` (
  `circleID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`circleID`,`userID`),
  KEY `userID` (`userID`),
  KEY `circleID` (`circleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `circlememberships`
--

INSERT INTO `circlememberships` (`circleID`, `userID`) VALUES
(8, 24),
(6, 25),
(6, 26),
(7, 26),
(8, 26),
(7, 27);

-- --------------------------------------------------------

--
-- Table structure for table `circles`
--

CREATE TABLE IF NOT EXISTS `circles` (
  `circleID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(240) NOT NULL,
  `adminUserId` int(11) NOT NULL,
  PRIMARY KEY (`circleID`),
  KEY `circleID` (`circleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `circles`
--

INSERT INTO `circles` (`circleID`, `name`, `adminUserId`) VALUES
(6, 'First group', 24),
(7, 'second group', 24),
(8, 'bagus group', 25);

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
  `messageID` int(11) NOT NULL AUTO_INCREMENT,
  `circleID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `message` varchar(300) NOT NULL,
  `timeSent` datetime NOT NULL,
  PRIMARY KEY (`messageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `messagecircles`
--

INSERT INTO `messagecircles` (`messageID`, `circleID`, `userID`, `message`, `timeSent`) VALUES
(4, 8, 24, 'asdasd', '2017-02-28 23:09:01'),
(5, 8, 24, 'asdasd', '2017-02-28 23:09:19'),
(6, 8, 24, 'skajnkdsf', '2017-02-28 23:11:01'),
(7, 8, 24, 'skajnkdsfasd asdkjhakdsj ', '2017-02-28 23:11:32'),
(8, 8, 24, 'awdas', '2017-02-28 23:21:09'),
(9, 8, 24, 'what do you want', '2017-03-01 00:05:10'),
(10, 8, 24, 'huh', '2017-03-01 00:06:07'),
(11, 8, 26, 'what you want to fight?', '2017-03-01 00:25:48'),
(12, 8, 24, 'no obviously you need your boy bandi for that', '2017-03-01 00:26:05');

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
(25, 'Bagus', 'Maulana', 'Male', '2017-02-03', 'Jakarta', 'Indonesia'),
(26, 'Shivam', 'Bandi', 'Male', '2017-02-12', 'London', 'United Kingdom'),
(27, 'Nijam', 'Abubakar', 'Male', '2017-02-27', 'Birmingham', 'United Kingdom');

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
  `photoCollectionID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`photoCollectionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `photoID` int(11) NOT NULL AUTO_INCREMENT,
  `photoCollectionID` int(11) NOT NULL,
  `image` blob NOT NULL,
  `name` varchar(240) NOT NULL,
  `string` varchar(240) NOT NULL,
  `caption` varchar(240) NOT NULL,
  `dateUploaded` date NOT NULL,
  PRIMARY KEY (`photoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
(24, 25, 25, 1, '2017-02-27 23:16:20', '2017-02-27 23:16:54'),
(24, 26, 26, 1, '2017-02-28 12:17:41', '2017-02-28 12:18:30'),
(24, 27, 27, 1, '2017-02-27 23:20:37', '2017-02-27 23:20:50'),
(25, 24, 25, 1, '2017-02-27 23:16:20', '2017-02-27 23:16:54'),
(25, 26, 25, 1, '2017-02-27 23:16:26', '2017-02-27 23:17:07'),
(26, 24, 26, 1, '2017-02-28 12:17:41', '2017-02-28 12:18:30'),
(26, 25, 25, 1, '2017-02-27 23:16:26', '2017-02-27 23:17:07'),
(27, 24, 27, 1, '2017-02-27 23:20:37', '2017-02-27 23:20:50');

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
(25, 0, 0, 0, 0, 0),
(26, 1, 0, 0, 0, 0),
(27, 0, 0, 0, 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `email`, `password`, `securityQuestion`, `securityAnswer`) VALUES
(24, 'osman@gmail.com', '14f8f4bb8c0e79a02670a5fea5682da717a5b3d3dc7b1706f7a4bab9afae18c2', '', 'I done'),
(25, 'bagus@gmail.com', '14f8f4bb8c0e79a02670a5fea5682da717a5b3d3dc7b1706f7a4bab9afae18c2', '', 'Life'),
(26, 'shivam@gmail.com', '14f8f4bb8c0e79a02670a5fea5682da717a5b3d3dc7b1706f7a4bab9afae18c2', '', 'Bandi'),
(27, 'nijam@gmail.com', '14f8f4bb8c0e79a02670a5fea5682da717a5b3d3dc7b1706f7a4bab9afae18c2', '', 'Word');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `personalinfo`
--
ALTER TABLE `personalinfo`
  ADD CONSTRAINT `personalInfo_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
