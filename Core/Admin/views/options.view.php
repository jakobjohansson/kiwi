<div class="column is-one-third">
    <h2 class="subtitle">Settings</h2>
    <div class="panel">
        <div class="panel-heading">
            ello
        </div>
        <div class="panel-block">
            <form>
                <div class="field">
                    <p class="control">
                        <label>Site name</label>
                        <input type="text" class="input" value="<?=$app->name; ?>"/>
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <label>Site description</label>
                        <input type="text" class="input" value="<?=$app->description; ?>" />
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <label>Theme</label>
                        <select class="input">
                            <?php
                            foreach ($themes as $theme) {
                                echo "<option class='select' name='{$theme}'>
                                    {$theme}
                                </option>";
                            }
                            ?>
                        </select>
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <input type="submit" class="button is-danger" value="Save" />
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
