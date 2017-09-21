<?php

namespace kiwi\Filesystem;

use kiwi\Error\EnvironmentException;

class Loader
{
    /**
     * Array of environment lines.
     *
     * @var array
     */
    private $lines;

    /**
     * Create a new loader instance.
     */
    public function __construct()
    {
        $this->lines = $this->getLines();

        $this->stripComments();

        $this->setEnvironment();
    }

    /**
     * Search for environment file and return the lines in an array.
     *
     * @return array
     */
    private function getLines()
    {
        if (!Filesystem::find('.env')) {
            throw new EnvironmentException('No environment file found.');
        }

        $autodetect = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', '1');
        $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        ini_set('auto_detect_line_endings', $autodetect);

        return $lines;
    }

    /**
     * Strip comments.
     *
     * @return void
     */
    private function stripComments()
    {
        $this->lines = array_filter($this->lines, function ($line) {
            return strpos($line, '#') !== 0;
        });
    }

    /**
     * Loop the lines and call a variable setter.
     *
     * @return void
     */
    private function setEnvironment()
    {
        foreach ($this->lines as $line) {
            if (strpos($line, '=')) {
                $this->setEnvironmentVariable(...explode('=', $line));
            }
        }
    }

    /**
     * Set an environment variable.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    private function setEnvironmentVariable($key, $value)
    {
        if (function_exists('putenv')) {
            putenv("$key=$value");
        }

        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }

    /**
     * Fancy constructor.
     *
     * @return self
     */
    public static function run()
    {
        return new self();
    }
}
