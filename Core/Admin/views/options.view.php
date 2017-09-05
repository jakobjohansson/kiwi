<?php require __DIR__.'/partials/admin-header.php'; ?>

<div class="column is-offset-3 is-6">
<form>
    <div class="field">
        <p class="control">
            <label class="label">Site name</label>
            <input type="text" class="input" value="<?=$app->name; ?>"/>
        </p>
    </div>
    <div class="field">
        <p class="control">
            <label class="label">Site description</label>
            <input type="text" class="input" value="<?=$app->description; ?>" />
        </p>
    </div>
    <div class="field">
        <p class="control">
            <label class="label">Theme</label>
            <div class="select">
                <select>
                    <?php
                    foreach ($themes as $theme) {
                        echo "<option name='{$theme}'>
                            {$theme}
                        </option>";
                    }
                    ?>
                </select>
            </div>
        </p>
    </div>
    <div class="field">
        <p class="control">
            <input type="submit" class="button is-danger" value="Save" />
        </p>
    </div>
</form>
</div>

<?php require __DIR__.'/partials/admin-footer.php'; ?>
