<?php

namespace kiwi\Http;

use kiwi\Database\Post;

class AdminController extends Controller
{
    /**
     * Dont access without authorizing.
     *
     * @return void
     */
    public function middleware()
    {
        if (!auth()->check()) {
            Request::redirect('/login');
        }
    }

    /**
     * Render the index page.
     *
     * @return void
     */
    public function index()
    {
        View::renderAdminView(
            'index',
            [
                'posts' => Post::all(),
            ]
        );
    }

    /**
     * Render the write page.
     *
     * @return void
     */
    public function create()
    {
        View::renderAdminView('create');
    }

    /**
     * Store a post in the database.
     *
     * @return void
     */
    public function store()
    {
        $post = new Post();

        $post->title = Input::field(
            'title',
            [
                'required' => 'The title is required.',
                'min:3'    => 'The title need to be atleast 3 characters long.',
            ]
        );

        $post->body = Input::field(
            'body',
            [
                'required' => 'The body field is required.',
                'min:5'    => 'The body needs to be atleast 5 characters long.',
            ]
        );

        $post->save();

        Request::redirect('/admin');
    }

    /**
     * Delete a post.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy($id)
    {
        $post = Post::from($id);
        dd($post);
        $post->delete();
    }
}
