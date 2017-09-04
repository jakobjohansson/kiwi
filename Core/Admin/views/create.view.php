<?php require(__DIR__.'/partials/admin-header.php'); ?>

<div class="column is-offset-3 is-6">
    <form>
        <div class="field">
            <label class="label">Title</label>
            <div class="control">
                <input type="text" class="input" name="title" placeholder="Title" />
            </div>
        </div>
        <div class="field">
            <label class="label">Body</label>
            <div class="control">
                <textarea class="textarea" rows="10" name="body"></textarea>
            </div>
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

<?php require(__DIR__.'/partials/admin-footer.php'); ?>
