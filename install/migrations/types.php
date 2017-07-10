<?php

return "CREATE TABLE `types` (
    `type_id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(45) NOT NULL,
    PRIMARY KEY (`type_id`),
    UNIQUE KEY `name_UNIQUE` (`name`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Registered types of items. Defaults to post, project and comment.';";
