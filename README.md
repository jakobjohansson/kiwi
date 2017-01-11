# VB
"humble effort at a blog module"

## Information

- use ``while($vb->loopPosts())`` to loop through all $post objects.
- ``$post`` object is always available on pages with id's.
- ``auth()`` returns true if user is logged in.
- ``userExists()`` returns true if vb_user has any rows.
- ``createUser()`` creates a new user, linking to $_post.

## Guide
In VB, there's no need to touch the index.php file. The ``views\`` folder is where all your templates go. You can however extend these possibilities by editing the statements in the index file. 

###Flow.php
Flow.php is the front page. This is cover-up for all kinds of pages.
By making the while loop shown below, you can access all your posts:
```php
while ($vb->loopPosts()) {
    echo $post->title;
    echo $post->content;
    echo $post->date;
}
```

###Single.php
The permalink, or single post page.
In here, the $post object variable will be containing the post of the current GET-id.
This makes it very easy to display your post.
```php
var_dump($post);

object(Post)#6 (8) {
    ["id"]=>
    string(2) "16"
    ["title"]=>
    string(11) "Sample post"
    ["date"]=>
    string(16) "December 4, 2016"
    ["public"]=>
    string(1) "1"
    ["thumb"]=>
    string(0) ""
    ["authorID"]=>
    string(1) "1"
    ["authorName"]=>
    string(5) "admin"
    ["content"]=>
    string(161) "Hello."
}
```
