<?php

namespace kiwi\System;

use kiwi\Http\Request;

class RecursiveRemover
{
    /**
     * Initiates the remover with the install folder as target.
     *
     * @return Request::redirect
     */
    public function init()
    {
        $this->removeFiles('install');
        $this->dumpAutoload();

        return Request::redirect('/');
    }

    /**
     * Use composer to dump the autoload.
     *
     * @return void
     */
    private function dumpAutoload()
    {
        exec('composer dumpautoload');
    }

    /**
     * Recurse through the given path, removing everything inside it.
     *
     * @param string $dir directory path
     *
     * @return RemoveFiles|true
     */
    private function removeFiles($dir)
    {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->removeFiles("$dir/$file") : unlink("$dir/$file");
        }

        return ($dir == getcwd()) ? true : rmdir($dir);
    }
}
