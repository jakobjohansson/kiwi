<?php require __DIR__.'/partials/admin-header.php'; ?>

<div class="column is-offset-3 is-6">
    <?php
    foreach ($posts as $post) {
        ?>
        <h2 class="title"><?php echo $post->title?></h2>
        <h3 class="subtitle">Written by <?php echo $post->username ?></h3>
        <div class="content">
            <?php echo $post->body ?>
        </div>
        <?php
    }
    ?>
</div>

<?php require __DIR__.'/partials/admin-footer.php'; ?>
