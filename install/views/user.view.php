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
                <p>Great! The connection is established, tables are migrated, now we just need to make you an administrator!</p>
                <form class="text-left col" action="/install/success">
                    <label>username</label>
                    <input type="text" required>
                    <label>email</label>
                    <input type="email" required>
                    <label>password</label>
                    <input type="password" required>
                    <label>repeat password</label>
                    <input type="password" required>
                    <div class="buttons self-right">
                        <input type="submit" class="button continue" value="Create user">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>