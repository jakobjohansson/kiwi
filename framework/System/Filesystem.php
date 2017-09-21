<?php

namespace kiwi\System;

class Filesystem
{
    /**
     * Find a file in the project directory.
     *
     * @param string $file
     *
     * @return bool true|false
     */
    public static function find($file)
    {
        return file_exists($file);
    }

    /**
     * Write to a file in the project directory.
     *
     * @param mixed $content
     * @param mixed $file
     *
     * @return bool
     */
    public static function write($content, $file)
    {
        file_put_contents($file, $content);
    }

    /**
     * Read a file.
     *
     * @param  string $file
     * @return string
     */
    public static function read($file)
    {
        file_get_contents($file);
    }

    /**
     * Remove a file.
     *
     * @param string $path
     *
     * @return unlink
     */
    public static function remove($path)
    {
        return unlink($path);
    }

    /**
     * Scan a folder of its files, skipping wildcards.
     *
     * @param string $folder
     *
     * @return array
     */
    public static function scanFolder($folder)
    {
        return array_diff(scandir($folder), ['.', '..']);
    }

    /**
     * Recurse through a folder, removing everything inside it,
     * as well as the folder itself.
     *
     * @param string $folder
     *
     * @return bool
     */
    public static function removeFolder($folder)
    {
        foreach (self::scanFolder($folder) as $file) {
            is_dir("$folder/$file") ? self::removeFolder("$folder/$file") : self::remove("$folder/$file");
        }

        return $folder == getcwd() ? true : rmdir($folder);
    }
}
