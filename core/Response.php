<?php

namespace kiwi;

class Response
{
    /**
     * Return a json response.
     *
     * @method json
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
     * @method status
     *
     * @param int $code
     *
     * @return Response
     */
    public function status($code)
    {
        // TODO: Return a status code and exit the application.
    }
}
