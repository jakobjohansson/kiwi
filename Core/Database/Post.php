<?php

namespace kiwi\Database;

class Post extends Model
{
    public static $type = 1;

    public static function all()
    {
        //return static::builder()->selectAll('items', self::class, ['item_id', '=', static::$type]);

        $builder = static::builder();

        return $builder->select('*')
            ->from('items')
            ->expect(self::class)
            ->where('item_id', '=', static::$type)
            ->run();
    }
}
