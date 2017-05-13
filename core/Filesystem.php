<?php namespace kiwi;

class Filesystem
{
    /**
     * Find a file in the project directory.
     *
     * @param  string $file The file path
     * @return boolean       true|false
     */
    public static function find($file)
    {
        return file_exists($file);
    }

    /**
     * Write to a file in the project directory.
     *
     * @param  mixed $file     file path
     * @param  mixed $contents contents to write
     * @param  array  $settings file write settings
     * @return boolean           true|false
     */
    public static function write($file, $contents, array $settings)
    {
    }
}
