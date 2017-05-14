            <div class="form-holder">
                <p>So to start with we need your database settings before we move on.</p>
                <form class="text-left col" action="/database" method="POST" name="connectionForm">
                    <label>host</label>
                    <input type="text" id="host" name="host" placeholder="localhost" required>
                    <label>username</label>
                    <input type="text" id="username" name="username" placeholder="root" required>
                    <label>password</label>
                    <input type="password" id="password" name="password">
                    <label>database name</label>
                    <input type="text" placeholder="kiwi" id="name" name="name" required>
                    <div class="buttons self-right">
                        <div id="flash"></div>
                        <button class="button" id="testConnection">Test connection</button>
                        <input type="submit" class="button continue" value="Continue">
                    </div>
                </form>
            </div>