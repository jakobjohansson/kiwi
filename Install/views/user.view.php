<div class="columns">
    <div class="column is-offset-one-third is-one-third">

        <p class="field">
            Great! The connection is established, now we just need to make you an administrator!
        </p>

        <form action="/user" method="POST">

            <div class="field">
                <p class="control">
                    <label>username</label>
                    <input class="input" type="text" name="username" required>
                </p>
            </div>

            <div class="field">
                <p class="control">
                    <label>email</label>
                    <input class="input" type="email" name="email" required>
                </p>
            </div>

            <div class="field">
                <p class="control">
                    <label>password</label>
                    <input class="input" type="password" name="password" required>
                </p>
            </div>

            <div class="field">
                <p class="control">
                    <label>repeat password</label>
                    <input class="input" type="password" name="password_confirm" required>
                </p>
            </div>

            <div class="field">
                <div class="level">
                    <div class="level-left"></div>
                    <div class="level-right">
                        <div class="level-item">
                            <p class="control">
                                <input type="submit" class="button is-info" value="Create user">
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <progress class="progress is-info" value="50" max="100">50%</progress>
            </div>

        </form>

    </div>
</div>
