<?php

return "CREATE TABLE IF NOT EXISTS `site_meta` (
    `meta_id` int(11) NOT NULL AUTO_INCREMENT,
    `key` varchar(255) NOT NULL DEFAULT '',
    `value` varchar(255) NOT NULL DEFAULT '',
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`meta_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Meta data for the site, such as what theme to use, name, description, public etc.';";
