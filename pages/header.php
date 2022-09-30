<div class="header">
    <p>Stat-Tracker<a href="index.php">About</a></p>
    <div class="header-links">
        <a href="home.php">Home</a>
        <?php
            if(isset($user) && $user->checkLoggedIn() == 0){
                echo '<a href="logout.php">Logout</a>';
            }else{
                echo '
                    <a href="login.php">Login</a>
                    <a href="register.php">Register</a>
                ';
            }
        ?>
    </div>
</div>