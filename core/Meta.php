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

    public static function getAll($query)
    {
        $result = $query->selectAll('site_meta');
        $app = [];

        foreach ($result as $row) {
            $app[$row['key']] = $row['value'];
        }

        return $app;
    }
}
