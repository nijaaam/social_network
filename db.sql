-- MySQL dump 10.13  Distrib 5.5.53, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: socialcw
-- ------------------------------------------------------
-- Server version	5.5.53-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blogPostComments`
--

DROP TABLE IF EXISTS `blogPostComments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogPostComments` (
  `commentID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `blogID` int(11) NOT NULL,
  `blogPostID` int(11) NOT NULL,
  `comment` varchar(240) NOT NULL,
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`commentID`),
  KEY `userID` (`userID`),
  KEY `blogID` (`blogID`),
  KEY `blogPostID` (`blogPostID`),
  CONSTRAINT `blogPostComments_ibfk_3` FOREIGN KEY (`blogPostID`) REFERENCES `blogPosts` (`postID`),
  CONSTRAINT `blogPostComments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  CONSTRAINT `blogPostComments_ibfk_2` FOREIGN KEY (`blogID`) REFERENCES `blogs` (`blogID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogPostComments`
--

LOCK TABLES `blogPostComments` WRITE;
/*!40000 ALTER TABLE `blogPostComments` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogPostComments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogPosts`
--

DROP TABLE IF EXISTS `blogPosts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogPosts` (
  `postID` int(11) NOT NULL,
  `blogID` int(11) NOT NULL,
  `blogTitle` varchar(240) NOT NULL,
  `dateTime` varchar(240) NOT NULL,
  `blogPostBody` varchar(240) NOT NULL,
  PRIMARY KEY (`postID`),
  KEY `blogID` (`blogID`),
  KEY `postID` (`postID`),
  CONSTRAINT `blogPosts_ibfk_1` FOREIGN KEY (`blogID`) REFERENCES `blogs` (`blogID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogPosts`
--

LOCK TABLES `blogPosts` WRITE;
/*!40000 ALTER TABLE `blogPosts` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogPosts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs` (
  `blogID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `blogIntro` varchar(240) NOT NULL,
  PRIMARY KEY (`blogID`),
  UNIQUE KEY `userID_2` (`userID`),
  KEY `blogID` (`blogID`),
  KEY `userID` (`userID`),
  CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `circleMemberships`
--

DROP TABLE IF EXISTS `circleMemberships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `circleMemberships` (
  `circleID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`circleID`),
  KEY `userID` (`userID`),
  KEY `circleID` (`circleID`),
  CONSTRAINT `circleMemberships_ibfk_2` FOREIGN KEY (`circleID`) REFERENCES `circles` (`circleID`),
  CONSTRAINT `circleMemberships_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `circleMemberships`
--

LOCK TABLES `circleMemberships` WRITE;
/*!40000 ALTER TABLE `circleMemberships` DISABLE KEYS */;
/*!40000 ALTER TABLE `circleMemberships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `circles`
--

DROP TABLE IF EXISTS `circles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `circles` (
  `circleID` int(11) NOT NULL,
  `name` varchar(240) NOT NULL,
  PRIMARY KEY (`circleID`),
  KEY `circleID` (`circleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `circles`
--

LOCK TABLES `circles` WRITE;
/*!40000 ALTER TABLE `circles` DISABLE KEYS */;
/*!40000 ALTER TABLE `circles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactInfo`
--

DROP TABLE IF EXISTS `contactInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactInfo` (
  `userID` int(11) NOT NULL,
  `mobileNo` int(11) NOT NULL,
  `landlineN` int(11) NOT NULL,
  `email` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactInfo`
--

LOCK TABLES `contactInfo` WRITE;
/*!40000 ALTER TABLE `contactInfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generalSettings`
--

DROP TABLE IF EXISTS `generalSettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generalSettings` (
  `userID` int(11) NOT NULL,
  `language` varchar(240) NOT NULL,
  `timeZone` varchar(240) NOT NULL,
  `country` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generalSettings`
--

LOCK TABLES `generalSettings` WRITE;
/*!40000 ALTER TABLE `generalSettings` DISABLE KEYS */;
/*!40000 ALTER TABLE `generalSettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messageCircles`
--

DROP TABLE IF EXISTS `messageCircles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messageCircles` (
  `messageID` int(11) NOT NULL,
  `circleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messageCircles`
--

LOCK TABLES `messageCircles` WRITE;
/*!40000 ALTER TABLE `messageCircles` DISABLE KEYS */;
/*!40000 ALTER TABLE `messageCircles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messageUsers`
--

DROP TABLE IF EXISTS `messageUsers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messageUsers` (
  `messageID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `isSender` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messageUsers`
--

LOCK TABLES `messageUsers` WRITE;
/*!40000 ALTER TABLE `messageUsers` DISABLE KEYS */;
/*!40000 ALTER TABLE `messageUsers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `messageID` int(11) NOT NULL,
  `contents` varchar(240) NOT NULL,
  `timeSent` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personalInfo`
--

DROP TABLE IF EXISTS `personalInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personalInfo` (
  `userID` int(11) NOT NULL,
  `firstname` varchar(240) NOT NULL,
  `surname` varchar(240) NOT NULL,
  `gender` varchar(240) NOT NULL,
  `birthday` date NOT NULL,
  KEY `userID` (`userID`),
  CONSTRAINT `personalInfo_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personalInfo`
--

LOCK TABLES `personalInfo` WRITE;
/*!40000 ALTER TABLE `personalInfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `personalInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photoColFriendCirclePermissions`
--

DROP TABLE IF EXISTS `photoColFriendCirclePermissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photoColFriendCirclePermissions` (
  `photoCollectionId` int(11) NOT NULL,
  `friendCircleId` int(11) NOT NULL,
  `grantPermission` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photoColFriendCirclePermissions`
--

LOCK TABLES `photoColFriendCirclePermissions` WRITE;
/*!40000 ALTER TABLE `photoColFriendCirclePermissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `photoColFriendCirclePermissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photoColUserPermissions`
--

DROP TABLE IF EXISTS `photoColUserPermissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photoColUserPermissions` (
  `photoCollectionId` int(11) NOT NULL,
  `firendUserID` int(11) NOT NULL,
  `grantPermission` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photoColUserPermissions`
--

LOCK TABLES `photoColUserPermissions` WRITE;
/*!40000 ALTER TABLE `photoColUserPermissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `photoColUserPermissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photoCollection`
--

DROP TABLE IF EXISTS `photoCollection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photoCollection` (
  `photoCollectionID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`photoCollectionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photoCollection`
--

LOCK TABLES `photoCollection` WRITE;
/*!40000 ALTER TABLE `photoCollection` DISABLE KEYS */;
/*!40000 ALTER TABLE `photoCollection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photoCollectionPermissions`
--

DROP TABLE IF EXISTS `photoCollectionPermissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photoCollectionPermissions` (
  `photoCollectionID` int(11) NOT NULL,
  `allFriends` tinyint(1) NOT NULL,
  `allFriendsCircles` tinyint(1) NOT NULL,
  `firendsOfFriends` tinyint(1) NOT NULL,
  PRIMARY KEY (`photoCollectionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photoCollectionPermissions`
--

LOCK TABLES `photoCollectionPermissions` WRITE;
/*!40000 ALTER TABLE `photoCollectionPermissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `photoCollectionPermissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photoComments`
--

DROP TABLE IF EXISTS `photoComments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photoComments` (
  `commentID` int(11) NOT NULL,
  `photoID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `comment` varchar(240) NOT NULL,
  `dateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photoComments`
--

LOCK TABLES `photoComments` WRITE;
/*!40000 ALTER TABLE `photoComments` DISABLE KEYS */;
/*!40000 ALTER TABLE `photoComments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos` (
  `photoID` int(11) NOT NULL,
  `photoCollectionID` int(11) NOT NULL,
  `name` varchar(240) NOT NULL,
  `string` varchar(240) NOT NULL,
  `caption` varchar(240) NOT NULL,
  `dateUploaded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photos`
--

LOCK TABLES `photos` WRITE;
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relationships`
--

DROP TABLE IF EXISTS `relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relationships` (
  `userID1` int(11) NOT NULL,
  `userID2` int(11) NOT NULL,
  `invitationSentBy` int(11) NOT NULL,
  `invitationAccepted` tinyint(1) NOT NULL,
  `timeRequestSent` datetime NOT NULL,
  `timeRequestAccepted` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relationships`
--

LOCK TABLES `relationships` WRITE;
/*!40000 ALTER TABLE `relationships` DISABLE KEYS */;
/*!40000 ALTER TABLE `relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `securitySettings`
--

DROP TABLE IF EXISTS `securitySettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `securitySettings` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `securitySettings`
--

LOCK TABLES `securitySettings` WRITE;
/*!40000 ALTER TABLE `securitySettings` DISABLE KEYS */;
/*!40000 ALTER TABLE `securitySettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `photoID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `email` varchar(240) NOT NULL,
  `password` varchar(240) NOT NULL,
  `securityQuestion` varchar(240) NOT NULL,
  `securityAnswer` varchar(240) NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userID` (`userID`),
  KEY `userID_2` (`userID`),
  KEY `userID_3` (`userID`),
  KEY `userID_4` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'j','jh','jh','jh');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-10  8:43:41
