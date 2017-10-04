<?php

namespace kiwi\Filesystem;

class File
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
     * @return void
     */
    public static function write($content, $file)
    {
        file_put_contents($file, $content);
    }

    /**
     * Read a file.
     *
     * @param string $file
     *
     * @return string
     */
    public static function read($file)
    {
        return file_get_contents($file);
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
}
