# Inserts

INSERT INTO `site_meta` (`key`, `value`)
VALUES
    ('name','kiwi'),
    ('description','an optional description of the site'),
    ('public','true'),
    ('theme','kiwi-default');

INSERT INTO `users` (`username`, `email`, `password`, `avatar`, `role`)
VALUES
    ('admin','admin@admin.com','password',NULL,4);

INSERT INTO `items` (`type_id`, `user_id`, `title`, `body`)
VALUES
  (1,1,'This is an example post','Welcome to kiwi');