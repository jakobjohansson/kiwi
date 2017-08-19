<?php

namespace kiwi;

class Post extends Model
{
    public static $type = 1;

    public static function all()
    {
        return static::builder()->selectAll('items', Post::class, ['item_id', '=', static::$type]);
    }
}
