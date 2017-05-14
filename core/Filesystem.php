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
     * @param  mixed $contents contents to write
     * @param  mixed $file     file path
     * @param  array  $settings file write settings
     * @return boolean           true|false
     */
    public static function write($contents, $file, array $settings = null)
    {
        file_put_contents($file, $contents);
    }
}
