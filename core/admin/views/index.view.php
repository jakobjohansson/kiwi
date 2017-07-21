<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.2/css/bulma.min.css">
    <link rel="stylesheet" href="bulma.css" />
    <title>kiwi</title>
</head>
<body>
    <div class="hero is-medium is-bold is-danger has-text-right">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    <?=$app['name']?>
                </h1>
                <h2 class="subtitle">Dashboard</h2>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-one-third">
                    <h2 class="subtitle">Posts</h2>
                </div>
                <div class="column is-one-third">
                    <h2 class="subtitle">Pages</h2>
                </div>
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
                                        <input type="text" class="input" value="<?=$app['name']?>"/>
                                    </p>
                                </div>
                                <div class="field">
                                    <p class="control">
                                        <label>Site description</label>
                                        <input type="text" class="input" value="<?=$app['description']?>" />
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
