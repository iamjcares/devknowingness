CREATE TABLE `course_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `course_categories` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`)
VALUES
	(1,NULL,1,'Animation','animation','2015-01-11 05:32:27','2015-02-04 14:47:23'),
	(2,NULL,3,'Sports','sports','2015-01-30 16:34:33','2015-02-04 14:47:23'),
	(3,19,10,'Trailers','trailers','2015-01-30 16:34:50','2015-02-04 14:47:23'),
	(4,NULL,4,'Comedy','comedy','2015-02-04 14:16:23','2015-02-20 14:37:54'),
	(5,23,6,'How-to & DIY','how-to-diy','2015-02-04 14:21:14','2015-02-05 13:52:31'),
	(6,NULL,8,'Tech','tech','2015-02-04 14:21:40','2015-02-04 14:47:23'),
	(7,NULL,9,'Movies','movies','2015-02-04 14:22:07','2015-02-04 14:47:23'),
	(8,NULL,11,'TV Shows','tv-shows','2015-02-04 14:22:15','2015-02-04 14:46:49'),
	(9,NULL,2,'Education','education','2015-02-04 14:23:03','2015-02-04 14:47:23'),
	(10,11,7,'Cooking & Health','cooking-and-health','2015-02-04 14:23:42','2015-02-04 14:47:23'),
	(11,NULL,5,'Lifestyle','lifestyle','2015-02-04 14:25:37','2015-02-05 13:52:31');

CREATE TABLE `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `detail` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `course_category_id` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `courses` (`id`, `title`,`description`, `detail`, `user_id`, `image`, `course_category_id`, `active`, `featured`, `price`, `created_at`, `updated_at`)
VALUES
	(1,'4 Handy Tools to Make Gmail Better','Checkout this short video talking about some Chrome extensions to make Gmail better.','<p>A video originally by Revision3 talking about 4 awesome tools and chrome extensions to make gmail better. Here are the tools below:</p>\r\n<ul>\r\n<li><a href=\"https://chrome.google.com/webstore/detail/sndlatr-beta-for-gmail/nfddgbpdnaeliohhkbdbcmenpnkepkgn\" target=\"_blank\">Sndlatr Beta</a></li>\r\n<li><a href=\"https://chrome.google.com/webstore/detail/right-inbox-for-gmail/mflnemhkomgploogccdmcloekbloobgb\" target=\"_blank\">Right Inbox</a></li>\r\n<li><a href=\"https://chrome.google.com/webstore/detail/streak-for-gmail/pnnfemgpilpdaojpnkjdgfgbnnjojfik\" target=\"_blank\">Streak</a></li>\r\n<li><a href=\"https://chrome.google.com/webstore/detail/send-from-gmail-by-google/pgphcomnlaojlmmcjmiddhdapjpbgeoc\" target=\"_blank\">Send From Gmail</a></li>\r\n</ul>\r\n<p>View the original source here:&nbsp;<a href=\"https://revision3.com/tekzillabites/4-handy-tools-to-make-gmail-better/\" target=\"_blank\">https://revision3.com/tekzillabites/4-handy-tools-to-make-gmail-better/</a></p>',1,'October2014/4-handy-tools-to-make-gmail-better.jpg',1,0,0,100,'2014-10-03 03:02:12','2015-02-04 14:40:04'),
	(2,'History of TMNT!','Today Arris tells you all you need to know about the Teenage Mutant Ninja Turtles!','<p>You remember that beloved show Teenage Mutant Ninja Turtles. In this video you will get a brief run down of the history of Teenage Mutant Ninja Turtles. The Teenage Mutant Ninja Turtles originated from a Comic Book back in 1984. This beloved comic book then evolved into the loved cartoon show that many people still remember. The famous cartoon show began in 1986 and lasted for 10 years. Since then there have been many remakes of the Teenage Mutant Ninja Turtles that still air on TV today.</p>\r\n<p>Learn More about the Ninja Turtles on their <a href=\"http://en.wikipedia.org/wiki/Teenage_Mutant_Ninja_Turtles\" target=\"_blank\">Wikipedia Page</a>.</p>\r\n<p><a href=\"http://revision3.com/variant/history-of-tmnt/\" target=\"_blank\">View the original source of this video here.</a></p>',1,'October2014/history-of-tmnt.jpg',1,0,0,100,'2014-10-04 16:31:57','2015-02-28 15:26:59');
	

CREATE TABLE `course_chapters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `faqs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `requirements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `objectives` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `prerequisites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `course_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_course_course_id_index` (`course_id`),
  KEY `tag_course_tag_id_index` (`tag_id`),
  CONSTRAINT `tag_course_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tag_course_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;