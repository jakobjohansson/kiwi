<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.2/css/bulma.min.css">
    <title>kiwi</title>
</head>
<body>
    <div class="hero is-medium is-bold is-danger has-text-right">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    <a href="/">{{app()->name}}</a>
                </h1>
                <h2 class="subtitle">Dashboard</h2>
            </div>
        </div>
        <div class="hero-foot">
            <nav class="tabs is-boxed">
                <div class="container">
                    <ul>
                        <li{{isRoute('admin') ? ' class="is-active"' : null }}>
                            <a href="/admin">Browse</a>
                        </li>
                        <li{{isRoute('admin/write') ? ' class="is-active"' : null }}>
                            <a href="/admin/write">Write</a>
                        </li>
                        <li>
                            <a href="/logout">Log out</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <section class="section">
        <div class="container">
            <div class="columns">
