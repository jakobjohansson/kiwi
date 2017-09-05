<?php

namespace kiwi;

use kiwi\Database\Model;
use PDO;

class Application extends Model
{
    /**
     * Create a new application instance.
     */
    public function __construct()
    {
        $properties = $this->all();

        foreach ($properties as $property) {
            $this[$property['key']] = $property['value'];
        }
    }

    /**
     * Return the site meta.
     * @return array
     */
    public function all()
    {
        $builder = static::builder();

        return $builder->select('*')
            ->from('site_meta')
            ->format(PDO::FETCH_ASSOC)
            ->run();
    }
}
