<?php
    require_once "../php/user.php";
    $user = new User();
    $user->protectPage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - StatTracker</title>
    <link rel="icon" type="image/png" href="../images/ico.png"/>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/admin.css">
    <script src="../scripts/main.js"></script>
    <script defer src="../scripts/admin.js"></script>
</head>
<body>
    <?php require_once("header.php"); ?>
    <div class="center">
        <div class="admin-user-search-wrapper">
            <div class="admin-search-bar shadow-small">
                <form action="../php/admin.php" method="POST">
                    <input type="text" name="username" placeholder="Filter For User" autocomplete="off">
                </form>
            </div>
            <div class="admin-search-result-wrapper">
                <div class="admin-search-result">


                    <!-- TODO fix shitty broken ass tables -->
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>E-mail</th>
                                <th>Goals</th>
                                <th>Assists</th>
                                <th>Edit User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <span class="admin-search-result-error-row">No Users Found</span>
                        </tbody>
                    </table>


                    
                </div>
                <!-- add page buttons here -->
                <div class="admin-search-result-page-navigator">
                    <p style="margin-right: .25rem;">Number Of Rows:</p>
                    <select class="admin-search-result-row-ammount" style="margin-right: 1rem;">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                
                    <button onclick="navigate('min');" style="margin-right: .25rem;"><<</button>
                    <button onclick="navigate(-1);"><</button>
                    <p class="current-page-number">1</p>
                    <button onclick="navigate(1);" style="margin-right: .25rem;">></button>
                    <button onclick="navigate('max');">>></button>
                </div>
            </div>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>