            <div class="form-holder">
                <p>Great! The connection is established, now we just need to make you an administrator!</p>
                <form class="text-left col" action="/user" method="POST">
                    <label>username</label>
                    <input type="text" name="username" required>
                    <label>email</label>
                    <input type="email" name="email" required>
                    <label>password</label>
                    <input type="password" name="password" required>
                    <label>repeat password</label>
                    <input type="password" name="password_confirm" required>
                    <div class="buttons self-right">
                        <input type="submit" class="button continue" value="Create user">
                    </div>
                </form>
            </div>