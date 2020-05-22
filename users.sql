--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `useremail` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `useremail` (`useremail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

