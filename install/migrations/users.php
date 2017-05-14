<?php return "CREATE TABLE IF NOT EXISTS `users` (
            `user_id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(16) NOT NULL,
            `email` varchar(255) DEFAULT NULL,
            `password` varchar(32) NOT NULL,
            `avatar` varchar(45) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `role` int(11) NOT NULL DEFAULT '1' COMMENT '1: user,\n2: contributor,\n3: moderator,\n4: admin',
            PRIMARY KEY (`user_id`),
            UNIQUE KEY `username_UNIQUE` (`username`),
            UNIQUE KEY `email_UNIQUE` (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users table. The higher role number the higher privileges.';";
