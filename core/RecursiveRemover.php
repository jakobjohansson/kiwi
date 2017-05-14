<?php namespace kiwi;

class RecursiveRemover
{
    /**
     * Initiates the remover with the install folder as target
     *
     * @return Request::redirect
     */
    public function init()
    {
        removeFiles('install/');
        return Request::redirect('/');
    }

    /**
     * Recurse through the given path, removing everything inside it
     *
     * @param  string $dir directory path
     * @return RemoveFiles|true
     */
    private function removeFiles($dir)
    {
        $files = scandir($dir);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->removeFiles("$dir/$file") : unlink("$dir/$file");
        }
        return ($dir == getcwd()) ? true : rmdir($dir);
    }
}
