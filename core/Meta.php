<?php

namespace kiwi;

class Meta
{
    /**
     * Fetch a meta value.
     *
     * @param string $property
     * @param Query  $query
     *
     * @return mixed
     */
    public static function get($property, Query $query)
    {
        return $query->select('site_meta', 'value', ['key', '=', $property]);
    }
}
