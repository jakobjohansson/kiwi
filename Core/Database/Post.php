<?php

namespace kiwi\Database;

class Post extends Model
{
    public static $type = 1;

    public static function all()
    {
        $builder = static::builder();

        return $builder->select('*')
            ->from('posts')
            ->expect(self::class)
            ->get();
    }

    public function save()
    {
        return $builder->insert()
            ->to('posts');

    }
}
