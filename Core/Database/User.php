<?php

namespace kiwi\Database;

class User extends Model
{
    /**
     * Return all users.
     *
     * @return array
     */
    public static function all()
    {
        $builder = static::builder();

        return $builder->select('*')
            ->from('users')
            ->expect(self::class)
            ->run();
    }
}
