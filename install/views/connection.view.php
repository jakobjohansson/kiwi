<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/stock/installer/installer.css" rel="stylesheet">
    <title>kiwi - install</title>
</head>
<body>
    <div class="container full dark text-center">
        <div class="col center full">
            <h1>kiwi</h1>
            <div class="form-holder">
                <p>So to start with we need your database settings before we move on.</p>
                <form class="text-left col" action="/install/user">
                    <label>host</label>
                    <input type="text" placeholder="localhost" required>
                    <label>username</label>
                    <input type="text" placeholder="root" required>
                    <label>password</label>
                    <input type="password">
                    <label>database name</label>
                    <input type="text" placeholder="kiwi" required>
                    <div class="buttons self-right">
                        <button class="button">Test connection</button>
                        <input type="submit" class="button continue" value="Continue">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>