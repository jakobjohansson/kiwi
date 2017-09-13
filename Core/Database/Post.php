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

    /**
     * Fetch a post from an id.
     *
     * @param int $id
     */
    public static function from($id)
    {
        $builder = self::builder();

        return $builder->select('*')
            ->from('posts')
            ->expect(self::class)
            ->where('id', '=', $id)
            ->get()[0];
    }

    /**
     * Get all posts in descending order.
     *
     * @return array
     */
    public static function all()
    {
        $builder = self::builder();

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
        $this->runValidation();
        $builder = self::builder();

        $builder->insert($this)
            ->to('posts')
            ->run();
    }

    /**
     * Delete the current post.
     *
     * @return void
     */
    public function delete()
    {
    }
}
