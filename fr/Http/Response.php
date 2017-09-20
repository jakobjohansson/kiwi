<?php

namespace kiwi\Http;

class Response
{
    /**
     * Return a json response.
     *
     * @param mixed $payload
     *
     * @return void
     */
    public function json($payload)
    {
        echo Json::make($payload);
        exit;
    }

    /**
     * Return a status code.
     *
     * @param int $code
     *
     * @return void
     */
    public function status($code)
    {
        http_response_code($code);
    }
}
