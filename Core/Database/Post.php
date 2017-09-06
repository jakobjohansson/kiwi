<?php

namespace kiwi\Database;

use kiwi\Http\Request;

class Post extends Model
{
    /**
     * Get all posts in descending order.
     *
     * @return array
     */
    public static function all()
    {
        $builder = static::builder();

        return $builder->select('*')
            ->from('posts')
            ->expect(self::class)
            ->get();
    }

    /**
     * Save a post to the database.
     *
     * @return PDOStatement
     */
    public function save()
    {
        $builder = static::builder();

        $builder->insert($this)
            ->to('posts')
            ->run();

        Request::redirect('/');
    }
}
