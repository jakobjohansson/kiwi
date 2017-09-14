<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.2/css/bulma.min.css">
    <title>kiwi</title>
</head>
<body>

    <section class="section">
        <div class="container">
            <div class="column is-6 is-offset-3">
                <h1 class="title">
                    <a href="/"><?=app()->name?></a>
                </h1>
                <h2 class="subtitle">
                    <?=app()->description?>
                </h2>
                <hr />
            </div>
            <div class="column is-6 is-offset-3">
                <div class="content">
                    <?php
                    foreach ($posts as $post) {
                        ?>
                        <h3 class="subtitle is-4"><a href="/post/<?=$post->id?>"><?=$post->title?></a></h3>
                        <div class="content">
                            <?=nl2br($post->body)?>
                        </div>
                        <footer>
                            <small>Written <?=$post->created_at?>.</small>
                        </footer>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="column is-6 is-offset-3">
                <a href="admin">admin</a>
            </div>
        </div>
    </section>
</body>
</html>
