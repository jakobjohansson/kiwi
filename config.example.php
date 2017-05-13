<?php
/**
 * Credentials for the database connection.
 */

return [
    'host' => 'mysql:host=127.0.0.1',
    'username' => 'root',
    'password' => '',
    'name' => 'kiwi',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];
