<?php require __DIR__.'/partials/admin-header.php'; ?>

<div class="column is-offset-3 is-6">
    <table class="table">
        <thead>
            <tr>
                <th>
                    Username
                </th>
                <th>
                    Email
                </th>
                <th>
                    Role
                </th>
                <th>
                    Created at
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($users as $user) {
                echo "<tr>";

                echo "<td>{$user->username}</td>";
                echo "<td>{$user->email}</td>";
                echo "<td>{$user->role}</td>";
                echo "<td>{$user->created_at}</td>";

                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php require __DIR__.'/partials/admin-footer.php'; ?>
