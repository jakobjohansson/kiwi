<?php

namespace kiwi\Database;

class Post extends Model
{
    public static $type = 1;

    public static function all()
    {
        $builder = static::builder();

        return $builder->select('*')
            ->from('items')
            ->with('users')
            ->expect(self::class)
            ->where('item_id', '=', static::$type)
            ->run();
    }
}
