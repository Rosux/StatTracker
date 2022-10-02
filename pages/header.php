<div class="header shadow">
    <p>Stat-Tracker<a href="index.php">About</a></p>
    <div class="header-links">
        <a href="home.php">Home</a>
        <?php
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