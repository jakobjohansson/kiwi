<?php
$root = "../../";
require($root.'lib/config.php');

if (!auth()) {
    header("Location: login.php");
}
?>
<h1>Account</h1>
<form action="?page=changeaccount" method="post">
    <div class="row">
        <div class="col-xs-12 col-sm-7">
            <div class="content-wrapper">
                <div class="clicker">
                    <h4>Trivial <i class="fa fa-arrow-right" aria-hidden="true"></i></h4>
                </div>
                <div class="reveal">
                    <label>Age</label>
                    <input type="text" name="age" value="<?=$user->getAge()?>"/>
                    <label>City</label>
                    <input type="text" name="city" value="<?=$user->getCity()?>"/>
                    <label>Website</label>
                    <input type="url" name="website" value="<?=$user->getWebsite()?>"/>
                    <label>Optionally write a short introduction</label>
                    <textarea name="bio"><?=$user->getBio()?></textarea>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-7">
            <div class="content-wrapper">
                <div class="clicker">
                    <h4>Visual <i class="fa fa-arrow-right" aria-hidden="true"></i></h4>
                </div>
                <div class="reveal">
                    <label>Enable pagination <input type="checkbox" name="pagination" checked /></label>
                    <label>Posts per page</label>
                    <input type="number" name="postsperpage" />
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-7">
            <div class="content-wrapper">
                <div class="clicker">
                    <h4>Security <i class="fa fa-arrow-right" aria-hidden="true"></i></h4>
                </div>
                <div class="reveal">
                    <label>Change your username</label>
                    <input type="text" name="username" value="<?=$user->getName()?>"/>
                    <small>Old names: <em>
                        <?php
                        foreach ($user->getAliases() as $alias) {
                            echo $alias." ";
                        }
                        ?>
                    </em></small>
                    <label>Change your password</label>
                    <input type="password" name="password" />
                    <label>Repeat password</label>
                    <input type="password" name="passrepeat" />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <input type="submit" value="Save settings" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-7">
            <div id="response"></div>
        </div>
    </div>
</form>

