<?php

namespace kiwi;

use PDO;
use kiwi\Database\Model;

class Application extends Model
{
    /**
     * Create a new application instance.
     */
    public function __construct()
    {
        $properties = $this->getAll();

        foreach ($properties as $property) {
            $this[$property['key']] = $property['value'];
        }
    }

    /**
     * Fetch a meta value.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function get($property)
    {
        return static::builder()->column('value')
            ->from('site_meta')
            ->where('key', '=', $property)
            ->run();
    }

    public function getAll()
    {
        $builder = static::builder();

        return $builder->select('*')
            ->from('site_meta')
            ->format(PDO::FETCH_ASSOC)
            ->run();
    }
}
