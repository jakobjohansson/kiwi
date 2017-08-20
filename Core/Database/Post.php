<?php

namespace kiwi\Database;

class Post extends Model
{
    public static $type = 1;

    public static function all()
    {
        return static::builder()->selectAll('items', self::class, ['item_id', '=', static::$type]);
    }
}
