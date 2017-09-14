<?php

namespace kiwi\Database;

class Post extends Model
{
    public static $table = 'posts';

    /**
     * Create a new Post instance.
     *
     * @param int $id
     */
    public function __construct($id = null)
    {
        if ($id) {
            $this->id = $id;
        }
    }
}
