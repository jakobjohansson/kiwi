<?php

namespace kiwi\Http;

class Response
{
    /**
     * Return a json response.
     *
     * @param mixed $payload
     *
     * @return Json
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
     * @return Response
     */
    public function status($code)
    {
        http_response_code($code);
    }
}
