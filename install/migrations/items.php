<?php

return "CREATE TABLE IF NOT EXISTS `items` (
            `item_id` int(11) NOT NULL AUTO_INCREMENT,
            `type_id` int(11) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `title` varchar(255) DEFAULT NULL,
            `body` text,
            `public` tinyint(4) DEFAULT '1',
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT NULL,
            `belongs_to_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`item_id`),
            KEY `user_id_idx` (`user_id`),
            KEY `type_id_idx` (`type_id`),
            CONSTRAINT `type_id` FOREIGN KEY (`type_id`) REFERENCES `types` (`type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contains all items on the site.';";
