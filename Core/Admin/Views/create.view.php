<?php require __DIR__ . '/partials/admin-header.php'; ?>

<div class="column is-offset-3 is-6">
    <form method="post" action="write">
        <div class="field">
            <label class="label">Title</label>
            <div class="control">
                <input type="text" class="input" name="title" placeholder="Title" value="<?=$title ?? null?>"/>
            </div>
            <?php
            if ($errors->title) {
                foreach ($errors->title as $error) {
                    echo "<p class='help is-danger'>$error</p>";
                }
            }
            ?>
        </div>
        <div class="field">
            <label class="label">Body</label>
            <div class="control">
                <textarea class="textarea" rows="10" name="body"><?=$body ?? null?></textarea>
            </div>
            <?php
            if ($errors->body) {
                foreach ($errors->body as $error) {
                    echo "<p class='help is-danger'>$error</p>";
                }
            }
            ?>
        </div>
        <div class="field is-grouped is-grouped-right">
            <div class="control">
                <input type="submit" class="button" name="draft" value="Draft" />
            </div>
            <div class="control">
                <input type="submit" class="button is-danger" name="publish" value="Publish" />
            </div>
        </div>
    </form>
</div>

<?php require __DIR__ . '/partials/admin-footer.php'; ?>
