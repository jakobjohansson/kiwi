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
            ->get();
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
            ->descending()
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
        $builder = self::builder();

        $builder->delete($this, 'posts');
    }

    /**
     * Update the post.
     *
     * @return void
     */
    public function update()
    {
        $this->runValidation();
        $builder = self::builder();

        $this->updated_at = date('Y-m-d H:i:s');

        $builder->update($this, 'posts');
    }
}
