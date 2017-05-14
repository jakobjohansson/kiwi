<?php namespace kiwi;

class Input implements InputInterface
{

    /**
     * Returns a sanitized POST field
     *
     * @param  string $key the input field
     * @return string
     */
    public static function field($key)
    {
        return Sanitizer::input($_POST[$key]);
    }

    /**
     * Returns a sanitized GET field
     *
     * @param  string $key the input field
     * @return string
     */
    public static function query($key)
    {
        return Sanitizer::input($_GET[$key]);
    }

    /**
     * Sanitize all the fields in a GET|POST collection
     *
     * @param  string $type GET|POST
     * @return array        Sanitized array.
     */
    public static function all($type)
    {
        $sendback = [];

        switch ($type) {
            case 'POST':
                foreach ($_POST as $key => $value) {
                    $sendback[$key] = Sanitizer::input($_POST[$key]);
                }
            break;
            case 'GET':
                foreach ($_GET as $key => $value) {
                    $sendback[$key] = Sanitizer::input($_GET[$key]);
                }
            break;
        }

        return $sendback;
    }
}
