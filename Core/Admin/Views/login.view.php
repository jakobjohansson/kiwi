<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.2/css/bulma.min.css">
    <title>kiwi</title>
</head>
<body>
    <section class="hero is-fullheight is-bold is-danger">
        <div class="hero-body has-text-centered">
            <div class="container">
                <h1 class="title is-1">login brah</h1>
                <div class="columns">
                    <div class="column is-one-quarter is-offset-7">
                        <form method="post">
                            <div class="field">
                                <div class="control">
                                    <input type="text" class="input is-danger" placeholder="username" name="username" <?php echo isset($username) ? "value='$username'" : null; ?>/>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input type="password" class="input is-danger" placeholder="password" name="password" <?php echo isset($password) ? "value='$password'" : null; ?>/>
                                </div>
                            </div>
                            <div class="field has-text-right">
                                <input type="submit" class="button is-info" value="Login"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html
