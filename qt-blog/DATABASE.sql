-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.67


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema qt_blog
--

CREATE DATABASE IF NOT EXISTS qt_blog;
USE qt_blog;

--
-- Definition of table `qt_blog`.`comments`
--

DROP TABLE IF EXISTS `qt_blog`.`comments`;
CREATE TABLE  `qt_blog`.`comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `post_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) default NULL,
  `body` text NOT NULL,
  `email` varchar(255) NOT NULL default '',
  `url` varchar(255) default NULL,
  `author` varchar(30) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qt_blog`.`comments`
--

/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
LOCK TABLES `comments` WRITE;
INSERT INTO `qt_blog`.`comments` VALUES  (4,7,NULL,'In euismod felis sit amet elit faucibus commodo! In rutrum orci eget elit. Etiam bibendum porttitor nulla. In tincidunt erat quis nulla? Nullam commodo leo in odio. Maecenas id tortor! Praesent id nunc. Etiam arcu. Suspendisse ultricies suscipit sem. Nulla nibh. Morbi ut libero id eros laoreet consequat.','fake@fake','','Nulla lacus eros','0000-00-00 00:00:00'),
 (3,9,NULL,'In laoreet, sapien id posuere condimentum, urna quam aliquet dui, eget scelerisque leo leo non lacus. Nulla facilisi. Sed nec felis eu ipsum porta suscipit. Sed volutpat?','','','Cras risus tortor','0000-00-00 00:00:00');
UNLOCK TABLES;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;


--
-- Definition of table `qt_blog`.`posts`
--

DROP TABLE IF EXISTS `qt_blog`.`posts`;
CREATE TABLE  `qt_blog`.`posts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `body` text,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `comments_count` int(11) default '0',
  `slug` varchar(255) NOT NULL default '',
  `published` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qt_blog`.`posts`
--

/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
LOCK TABLES `posts` WRITE;
INSERT INTO `qt_blog`.`posts` VALUES  (7,'Test post 1','Ut sapien metus, egestas non, luctus et, tincidunt sed, nisl. Integer vel sapien at elit molestie tempus? Ut placerat imperdiet sem. Nulla vehicula lectus a lectus viverra adipiscing.','2008-11-21 12:44:21','2008-11-24 18:48:56',1,'test1',0),
 (8,'Test post 2','Etiam libero. Morbi venenatis posuere diam. Sed auctor enim ac mi. Nunc ipsum dolor, consequat ut, rhoncus at, molestie ut, lacus. Integer et libero. Maecenas mi nisi, lacinia ut, congue nec, tempor a, purus. Donec ullamcorper, ligula imperdiet porttitor sagittis, libero elit vestibulum est, non sodales augue lorem viverra massa.','2008-11-21 13:56:43','2008-11-25 11:43:19',0,'test2',1),
 (9,'Test post 3','Maecenas scelerisque, felis vitae viverra ornare, diam quam vehicula nisi, at consequat turpis metus nec nisi. Etiam dui. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed tempor tincidunt nulla.','2008-11-21 13:56:57','2008-11-25 11:42:46',1,'test3',0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;


--
-- Definition of table `qt_blog`.`posts_tags`
--

DROP TABLE IF EXISTS `qt_blog`.`posts_tags`;
CREATE TABLE  `qt_blog`.`posts_tags` (
  `post_id` int(10) unsigned NOT NULL default '0',
  `tag_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`post_id`,`tag_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qt_blog`.`posts_tags`
--

/*!40000 ALTER TABLE `posts_tags` DISABLE KEYS */;
LOCK TABLES `posts_tags` WRITE;
INSERT INTO `qt_blog`.`posts_tags` VALUES  (7,25),
 (8,27);
UNLOCK TABLES;
/*!40000 ALTER TABLE `posts_tags` ENABLE KEYS */;


--
-- Definition of table `qt_blog`.`tags`
--

DROP TABLE IF EXISTS `qt_blog`.`tags`;
CREATE TABLE  `qt_blog`.`tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(35) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qt_blog`.`tags`
--

/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
LOCK TABLES `tags` WRITE;
INSERT INTO `qt_blog`.`tags` VALUES  (25,'php'),
 (26,'js'),
 (27,'cakephp');
UNLOCK TABLES;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
