<div class="columns">
    <div class="column is-offset-one-third is-one-third">

        <p class="field">
            So to start with we need your database settings before we move on.
        </p>

        <form action="/database" method="POST" name="connectionForm">

            <div class="field">
                <p class="control">
                    <label>host</label>
                    <input type="text" class="input" id="host" name="host" placeholder="localhost" required>
                </p>
            </div>

            <div class="field">
                <p class="control">
                    <label>username</label>
                    <input type="text" class="input" id="username" name="username" placeholder="root" required>
                </p>
            </div>

            <div class="field">
                <p class="control">
                    <label>password</label>
                    <input class="input" type="password" id="password" name="password">
                </p>
            </div>

            <div class="field">
                <p class="control">
                   <label>database name</label>
                   <input type="text" class="input" placeholder="kiwi" id="name" name="name" required>
                </p>
            </div>

            <div class="field">
                <div class="level">
                    <div class="level-left">
                        <div id="flash"></div>
                    </div>
                    <div class="level-right">
                        <div class="level-item">
                            <button class="button" onclick="testConnection(event)">Test connection</button>
                        </div>
                        <div class="level-item">
                            <input type="submit" class="button is-info" value="Continue">
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <progress class="progress is-info" value="25" max="100">25%</progress>
            </div>
            
        </form>
    </div>
</div>
