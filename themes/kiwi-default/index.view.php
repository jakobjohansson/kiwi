<?php
require 'partials/head.view.php';
?>

<section class="section">
    <div class="container">
        <div class="columns">
            <aside class="menu column is-3">
                <p class="menu-label">
                    Navigation
                </p>
                <ul class="menu-list">
                    <li><a>Blog</a></li>
                    <li><a>About</a></li>
                </ul>
                <p class="menu-label">
                    Latest posts
                </p>
                <ul class="menu-list">
                    <li>
                        <a class="is-active">December 2016</a>
                        <ul>
                            <li><a>Creating a site</a></li>
                            <li><a>Guide to Wordpress</a></li>
                            <li><a>Doin stuff</a></li>
                        </ul>
                    </li>
                </ul>
                <p class="menu-label">
                    Actions
                </p>
                <ul class="menu-list">
                    <li><a>Contact</a></li>
                    <li><a>Administrate</a></li>
                </ul>
            </aside>
            <main class="column is-9">
                <h1 class="title">
                    <?=$app['name'] ?>
                </h1>
                <h2 class="subtitle">
                    <?=$app['description']?>
                </h2>
            </main>
        </div>
    </div>
</section>

<?php
require 'partials/foot.view.php';
