<div class="header shadow noise-texture">
    <p>Stat-Tracker<a href="index.php">About</a></p>
    <div class="header-links">
        <a style="text-decoration: none;font-size:0.8rem;">
            <div class="button-switch">
                <input type="checkbox" id="darkmode" darkmode-selector="1">
                <label for="darkmode"><p>&#127761;</p><p>&#127774;</p></label>
            </div>
        </a>
        <a href="home.php">Home</a>
        <?php
            if($user->admin > 2){
                echo '<a href="admin.php">Admin-Panel</a>';
            }
            if($user->admin > 0){
                echo '<a href="admin-teams.php">Teams-Panel</a>';
            }
            if(isset($user) && $user->checkLoggedIn() == 0){
                echo '
                    <a href="logout.php">Logout</a>
                    <a href="settings.php">Settings</a>
                    <a href="profile.php?user=' . $user->id . '">Profile</a>
                ';
            }else{
                echo '
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                ';
            }
        ?>
    </div>
</div>