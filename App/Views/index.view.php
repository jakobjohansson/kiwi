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
            <h1 class="title">
                <?=app()->name ?>
            </h1>
            <h2 class="subtitle">
                <?=app()->description?>
            </h2>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <?php

            foreach ($posts as $post) {
                ?>
                <h3 class="subtitle is-4"><?=$post->title; ?></h3>
                <div class="content">
                    <?=$post->body; ?>
                </div>
                <footer>
                    <small><?=$post->created_at?></small>
                </footer>
            <?php
            }
            ?>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <a href="admin">admin</a>
        </div>
    </section>
</body>
</html>
