<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.2/css/bulma.min.css">
    <title>kiwi - woops</title>
</head>
<body>

    <section class="hero is-bold is-danger is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="columns">
                    <div class="column is-half is-offset-one-quarter">
                        <h1 class="title">Woops!</h1>
                        <p class="field">Something went wrong. The server sent the following message:</p>
                        <p class="field"><?=$e->getMessage(); ?></p>
                        <p class="field">
                            <a href="javascript:history.back();" class="button is-info">Go back</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
