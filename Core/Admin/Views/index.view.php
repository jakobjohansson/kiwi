<?php require __DIR__ . '/partials/admin-header.php'; ?>

<div class="column is-offset-3 is-6">
    <?php
    foreach ($posts as $post) {
        ?>
        <h2 class="title"><?=$post->title?></h2>
        <h3>Written <?=$post->created_at; ?>.</h3>
        <div class="content">
            <?=$post->body ?>
        </div>
        <?php
    }
    ?>
</div>

<?php require __DIR__ . '/partials/admin-footer.php'; ?>
