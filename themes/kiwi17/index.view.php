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
                <?=$app['name'] ?>
            </h1>
            <h2 class="subtitle">
                <?=$app['description']?>
            </h2>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h3 class="subtitle is-4">Hello world</h3>
            <div class="content">
                <p>This is basically an article.</p>
            </div>
            <footer>
                <small>Written by jakob.</small>
            </footer>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <a href="admin">admin</a>
        </div>
    </section>
</body>
</html>
