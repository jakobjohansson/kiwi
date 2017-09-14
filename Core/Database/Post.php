<?php

namespace kiwi\Database;

class Post extends Model
{
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
