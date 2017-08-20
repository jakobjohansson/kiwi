<?php

namespace kiwi;

class Filesystem
{
    /**
     * Find a file in the project directory.
     *
     * @param string $file The file path
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
     * @param mixed $contents contents to write
     * @param mixed $file     file path
     *
     * @return bool true|false
     */
    public static function write($contents, $file)
    {
        file_put_contents($file, $contents);
    }

    /**
     * Remove a file.
     *
     * @method remove
     *
     * @param string $path the file path
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
     * @method scanFolder
     *
     * @param string $folder the folder path
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
     * @method removeFolder
     *
     * @param string $folder the folder path
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
