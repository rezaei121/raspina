SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for rs_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `rs_auth_assignment`;
CREATE TABLE `rs_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `rs_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `rs_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rs_auth_assignment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `rs_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- ----------------------------
-- Table structure for rs_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `rs_auth_item`;
CREATE TABLE `rs_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `rs_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `rs_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of rs_auth_item
-- ----------------------------
INSERT INTO `rs_auth_item` VALUES ('admin', '1', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('approveComment', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('approveOwnComment', '2', null, 'AuthorRule', null, null, null);
INSERT INTO `rs_auth_item` VALUES ('author', '1', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('category', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('comment', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('contact', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('deleteCategory', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('deleteComment', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('deleteContact', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('deleteFile', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('deleteLink', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('deleteNewsletter', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('deleteOwnCategory', '2', '', 'AuthorRule', '', null, null);
INSERT INTO `rs_auth_item` VALUES ('deleteOwnComment', '2', '', 'AuthorRule', null, null, null);
INSERT INTO `rs_auth_item` VALUES ('deleteOwnFile', '2', '', 'AuthorRule', '', null, null);
INSERT INTO `rs_auth_item` VALUES ('deleteOwnPost', '2', '', 'AuthorRule', null, null, null);
INSERT INTO `rs_auth_item` VALUES ('deletePost', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('deleteUser', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('file', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('link', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('moderator', '1', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('newsletter', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('post', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('replyComment', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('replyOwnComment', '2', '', 'AuthorRule', '', null, null);
INSERT INTO `rs_auth_item` VALUES ('settings', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('statistics', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('template', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('updateCategory', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('updateLink', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('updateOwnCategory', '2', '', 'AuthorRule', '', null, null);
INSERT INTO `rs_auth_item` VALUES ('updateOwnPost', '2', null, 'AuthorRule', null, null, null);
INSERT INTO `rs_auth_item` VALUES ('updatePost', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('updateUser', '2', null, null, null, null, null);
INSERT INTO `rs_auth_item` VALUES ('user', '2', null, null, null, null, null);

-- ----------------------------
-- Table structure for rs_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `rs_auth_item_child`;
CREATE TABLE `rs_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `rs_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `rs_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rs_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `rs_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of rs_auth_item_child
-- ----------------------------
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'approveComment');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'approveComment');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'approveOwnComment');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'category');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'category');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'category');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'comment');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'comment');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'comment');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'contact');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'contact');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'deleteCategory');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'deleteCategory');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'deleteComment');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'deleteComment');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'deleteContact');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'deleteContact');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'deleteFile');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'deleteFile');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'deleteLink');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'deleteLink');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'deleteNewsletter');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'deleteNewsletter');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'deleteOwnCategory');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'deleteOwnComment');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'deleteOwnFile');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'deleteOwnPost');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'deletePost');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'deletePost');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'deleteUser');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'file');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'file');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'file');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'link');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'link');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'newsletter');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'newsletter');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'post');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'post');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'post');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'replyComment');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'replyComment');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'replyOwnComment');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'settings');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'settings');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'statistics');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'statistics');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'statistics');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'template');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'template');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'updateCategory');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'updateCategory');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'updateLink');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'updateLink');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'updateOwnCategory');
INSERT INTO `rs_auth_item_child` VALUES ('author', 'updateOwnPost');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'updatePost');
INSERT INTO `rs_auth_item_child` VALUES ('moderator', 'updatePost');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'updateUser');
INSERT INTO `rs_auth_item_child` VALUES ('admin', 'user');

-- ----------------------------
-- Table structure for rs_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `rs_auth_rule`;
CREATE TABLE `rs_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of rs_auth_rule
-- ----------------------------
INSERT INTO `rs_auth_rule` VALUES ('AuthorRule', 0x4F3A33363A2264617368626F6172645C636F6D706F6E656E74735C726261635C417574686F7252756C65223A333A7B733A343A226E616D65223B733A31303A22417574686F7252756C65223B733A393A22637265617465644174223B693A313530313835313331393B733A393A22757064617465644174223B693A313530313835313331393B7D, '1501851319', '1501851319');


-- ----------------------------
-- Table structure for rs_category
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_category`;
CREATE TABLE `rs_category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `user_id` (`created_by`),
  CONSTRAINT `rs_category_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `rs_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_comment
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_comment`;
CREATE TABLE `rs_comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `status` int(1) unsigned NOT NULL DEFAULT '0',
  `reply_text` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_post_id` (`post_id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`) USING BTREE,
  CONSTRAINT `rs_comment_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `rs_user` (`id`),
  CONSTRAINT `rs_comment_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `rs_user` (`id`),
  CONSTRAINT `rs_comment_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `rs_post` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_contact
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_contact`;
CREATE TABLE `rs_contact` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL,
  `email` varchar(255) NOT NULL,
  `site` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` int(1) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_file
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_file`;
CREATE TABLE `rs_file` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `extension` varchar(4) NOT NULL,
  `content_type` varchar(55) NOT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uploaded_by` bigint(20) unsigned NOT NULL,
  `real_name` varchar(255) NOT NULL,
  `download_count` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `rs_file_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `rs_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_link
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_link`;
CREATE TABLE `rs_link` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_migration
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_migration`;
CREATE TABLE `rs_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_newsletter
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_newsletter`;
CREATE TABLE `rs_newsletter` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `registered_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_newsletter_log
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_newsletter_log`;
CREATE TABLE `rs_newsletter_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `rs_newsletter_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `rs_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_post
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_post`;
CREATE TABLE `rs_post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `short_text` text NOT NULL,
  `more_text` text,
  `keywords` text,
  `meta_description` varchar(255) DEFAULT NULL,
  `status` int(1) unsigned DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `pin_post` int(1) unsigned DEFAULT '0',
  `enable_comments` int(1) unsigned DEFAULT '1',
  `view` bigint(20) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `author_id` (`created_by`),
  KEY `rs_post_ibfk_2` (`updated_by`),
  CONSTRAINT `rs_post_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `rs_user` (`id`),
  CONSTRAINT `rs_post_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `rs_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_post_category
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_post_category`;
CREATE TABLE `rs_post_category` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_category` (`category_id`),
  KEY `index_post_category` (`post_id`,`category_id`),
  CONSTRAINT `rs_post_category_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `rs_post` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rs_post_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `rs_category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_post_tag
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_post_tag`;
CREATE TABLE `rs_post_tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_id` (`post_id`,`tag_id`),
  KEY `rs_post_tag_ibfk_2` (`tag_id`),
  CONSTRAINT `rs_post_tag_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `rs_post` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rs_post_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `rs_tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=510 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_setting
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_setting`;
CREATE TABLE `rs_setting` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `template` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keyword` text,
  `page_size` int(3) unsigned NOT NULL DEFAULT '0',
  `language` varchar(12) DEFAULT NULL,
  `direction` varchar(3) DEFAULT NULL,
  `time_zone` varchar(25) DEFAULT NULL,
  `date_format` varchar(55) DEFAULT NULL,
  `sult` varchar(17) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_tag
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_tag`;
CREATE TABLE `rs_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_user
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_user`;
CREATE TABLE `rs_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `about_text` text,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) unsigned NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for rs_visitors
-- ----------------------------
-- DROP TABLE IF EXISTS `rs_visitors`;
CREATE TABLE `rs_visitors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  `visit_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `group_date` int(11) unsigned DEFAULT NULL,
  `location` varchar(2000) DEFAULT NULL,
  `browser` varchar(60) DEFAULT NULL,
  `os` varchar(30) DEFAULT NULL,
  `referer` varchar(2000) DEFAULT NULL,
  `user_agent` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24830 DEFAULT CHARSET=utf8;
