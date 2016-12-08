--
-- Table structure for table `rs_about`
--

CREATE TABLE `rs_about` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `avatar` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(55) DEFAULT NULL,
  `short_text` text,
  `more_text` text,
  `facebook` varchar(1000) DEFAULT NULL,
  `twitter` varchar(1000) DEFAULT NULL,
  `googleplus` varchar(1000) DEFAULT NULL,
  `instagram` varchar(1000) DEFAULT NULL,
  `linkedin` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rs_category`
--

CREATE TABLE `rs_category` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rs_comment`
--

CREATE TABLE `rs_comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `reply_text` text,
  `create_time` int(11) NOT NULL,
  `ip` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rs_contact`
--

CREATE TABLE `rs_contact` (
  `id` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `email` varchar(255) NOT NULL,
  `site` varchar(2000) DEFAULT NULL,
  `message` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `ip` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rs_file`
--

CREATE TABLE `rs_file` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `extension` varchar(4) NOT NULL,
  `content_type` varchar(55) NOT NULL,
  `upload_date` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `real_name` varchar(255) NOT NULL,
  `download_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rs_link`
--

CREATE TABLE `rs_link` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rs_migration`
--

CREATE TABLE `rs_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rs_migration`
--

INSERT INTO `rs_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1480883074),
('m130524_201442_init', 1480883091),
('m160409_001715_about', 1480883092),
('m160409_081901_file', 1480883092),
('m160409_082357_link', 1480883092),
('m160409_083040_newsletter', 1480883092),
('m160409_083418_contact', 1480883092),
('m160415_045156_post', 1480883092),
('m160415_051211_category', 1480883092),
('m160415_054931_comment', 1480883092),
('m160522_144801_setting', 1480883092),
('m160603_124624_visit', 1480883092);

-- --------------------------------------------------------

--
-- Table structure for table `rs_newsletter`
--

CREATE TABLE `rs_newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rs_post`
--

CREATE TABLE `rs_post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_text` text NOT NULL,
  `more_text` text,
  `tags` text,
  `keywords` text,
  `meta_description` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `pin_post` int(1) DEFAULT '0',
  `comment_active` int(1) DEFAULT '1',
  `view` int(11) DEFAULT '0',
  `send_newsletter` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rs_post_category`
--

CREATE TABLE `rs_post_category` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rs_setting`
--

CREATE TABLE `rs_setting` (
  `id` int(11) NOT NULL,
  `url` varchar(2000) NOT NULL,
  `template` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keyword` text,
  `page_size` int(3) NOT NULL DEFAULT '0',
  `date_format` varchar(255) DEFAULT NULL,
  `sult` varchar(17) DEFAULT NULL,
  `activation_newsletter` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rs_user`
--

CREATE TABLE `rs_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rs_visitors`
--

CREATE TABLE `rs_visitors` (
  `id` int(11) NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `visit_date` int(11) DEFAULT NULL,
  `group_date` int(11) DEFAULT NULL,
  `location` varchar(2000) DEFAULT NULL,
  `browser` varchar(60) DEFAULT NULL,
  `os` varchar(30) DEFAULT NULL,
  `referer` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rs_about`
--
ALTER TABLE `rs_about`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `rs_category`
--
ALTER TABLE `rs_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rs_comment`
--
ALTER TABLE `rs_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_post_id` (`post_id`);

--
-- Indexes for table `rs_contact`
--
ALTER TABLE `rs_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rs_file`
--
ALTER TABLE `rs_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rs_link`
--
ALTER TABLE `rs_link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rs_migration`
--
ALTER TABLE `rs_migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `rs_newsletter`
--
ALTER TABLE `rs_newsletter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `rs_post`
--
ALTER TABLE `rs_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rs_post_category`
--
ALTER TABLE `rs_post_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post_category` (`category_id`),
  ADD KEY `index_post_category` (`post_id`,`category_id`);

--
-- Indexes for table `rs_setting`
--
ALTER TABLE `rs_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rs_user`
--
ALTER TABLE `rs_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `rs_visitors`
--
ALTER TABLE `rs_visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rs_about`
--
ALTER TABLE `rs_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rs_category`
--
ALTER TABLE `rs_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rs_comment`
--
ALTER TABLE `rs_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rs_contact`
--
ALTER TABLE `rs_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rs_file`
--
ALTER TABLE `rs_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rs_link`
--
ALTER TABLE `rs_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rs_newsletter`
--
ALTER TABLE `rs_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rs_post`
--
ALTER TABLE `rs_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rs_post_category`
--
ALTER TABLE `rs_post_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rs_setting`
--
ALTER TABLE `rs_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rs_user`
--
ALTER TABLE `rs_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rs_visitors`
--
ALTER TABLE `rs_visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `rs_about`
--
ALTER TABLE `rs_about`
  ADD CONSTRAINT `fk_about_user` FOREIGN KEY (`user_id`) REFERENCES `rs_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rs_comment`
--
ALTER TABLE `rs_comment`
  ADD CONSTRAINT `fk_post_comment` FOREIGN KEY (`post_id`) REFERENCES `rs_post` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rs_post_category`
--
ALTER TABLE `rs_post_category`
  ADD CONSTRAINT `fk_post` FOREIGN KEY (`post_id`) REFERENCES `rs_post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_post_category` FOREIGN KEY (`category_id`) REFERENCES `rs_category` (`id`) ON DELETE CASCADE;
