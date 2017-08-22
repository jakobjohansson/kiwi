<?php

/**
 * kiwi helpers file.
 */
if (!function_exists('dd')) {
    function dd($param)
    {
        echo '<pre>';
        var_dump($param);
        echo '</pre>';
        die();
    }
}
