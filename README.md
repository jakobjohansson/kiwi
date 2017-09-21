# kiwi [![Codacy Badge](https://api.codacy.com/project/badge/Grade/d91c9b74721a47e4a124bc5da221ac73)](https://www.codacy.com/app/jakobjohansson2/kiwi?utm_source=github.com&utm_medium=referral&utm_content=jakobjohansson/kiwi&utm_campaign=badger) [![StyleCI](https://styleci.io/repos/75422681/shield?branch=master)](https://styleci.io/repos/75422681)

kiwi is a minimalistic and lightweight blog framework for php.

## Documentation
To install and make the autoloader work, clone the repository and run `composer dumpautoload` while standing in the directory.

### Configuration
Included in the package is a `.env.example` file, which should be renamed to `.env` and omitted from version control. It is a simple environment file containing fields for database settings, user settings and more general application settings. Kiwi will not run without this file.

### Routes
Custom routes can be set in the `app/routes.php` file, pointing a route towards a controller and a target method:
```php
<?php
/*
 * Routes file.
 * You can create your own custom routes in here, at the end of this file.
 */

 $router->get('', 'PageController/index');
 $router->get('post/{id}', 'PageController/show');
```

### Controllers
All controllers reside in the `app/Controllers` directory. An example controller is included with the following methods:
```php
<?php
/**
 * Render the main page.
 *
 * @return void
 */
public function index()
{
    View::render('index', ['posts' => Post::all()]);
}

/**
 * Render a specific post page.
 *
 * @param Post $post
 *
 * @return void
 */
public function show(Post $post)
{
    if (!$post) {
        throw new HttpException("That post doesn't exist.");
    }

    View::render('post', ['post' => $post]);
}
```
Notice the type hinted *Post* parameter in the show method. It will be automatically injected when you provide a wildcard in your route!

### Views
As seen in the example above, views can be requested from a controller method by stating `View::render($viewpath, $arrayOfData)`. The view path is relative to the `app/Views` folder, with a suffixed `.view.php` added at the end, meaning you can simply enter the file name.

### Templating
Kiwi supports templating similar to that of Laravel Blade:
```php
<div class="content">
    @foreach ($posts as $post)
        <h3 class="subtitle is-4">
            <a href="/post/{{$post->id}}">
                {{$post->title}}
            </a>
        </h3>
        <div class="content">
            {{nl2br($post->body)}}
        </div>
        <footer>
            <small>Written {{$post->created_at}}.</small>
        </footer>
    @endforeach
</div>
```
At the time of writing, the following directives are supported:
- if / else statements
- echo expressions
- foreach loops
- includes

### Validation
Validation is rather simple with kiwi. Simply access a form field using the `Input` class, which takes the field name as the first parameter and an array of rules as the second parameter:
```php
<?php
$post->title = Input::field(
    'title',
    [
        'required' => 'The title is required.',
        'min:3'    => 'The title need to be atleast 3 characters long.',
    ]
);
```
The supported rules can be found in the `Rule` class. At the time of writing, the following rules are supported:
- min
- max
- required
- email

If validation fails, kiwi will redirect back with access to a `$errors` variable, containing all the data you need to display an informative error message!

## License
Kiwi is MIT licensed, meaning you are free modify and do as you wish with the code.
