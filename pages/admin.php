<?php
    require_once "../php/admin-class.php";
    $admin = new Admin();
    $admin->protectPage();
    $user = $admin;
    if($admin->admin < 3){
        header("Location: " . "../pages/home.php");
        exit();
    }
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
    <link rel="stylesheet" href="../styles/overlay.css">
    <script src="../scripts/main.js"></script>
    <script defer src="../scripts/admin.js"></script>
    <script defer src="../scripts/update-users.js"></script>
</head>
<body>
    <?php require_once("header.php"); ?>
    <div class="center">
        <div class="admin-user-search-wrapper">
            <div class="admin-search-bar shadow-small">
                <form action="../php/admin.php" method="POST">
                    <input type="text" name="id" placeholder="Filter For Id" autocomplete="off">
                    <input type="text" name="username" placeholder="Filter For Username" autocomplete="off">
                    <input type="text" name="email" placeholder="Filter For E-mail" autocomplete="off">
                </form>
            </div>
            <div class="admin-search-result-wrapper">
                <div class="admin-search-result">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Id</th>
                                <th>Username</th>
                                <th>E-mail</th>
                                <th>Goals</th>
                                <th>Assists</th>
                                <th>Edit User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="admin-search-result-error-row"><td colspan="7"><p>No Users Found</p></td></tr>
                        </tbody>
                    </table>
                </div>
                <!-- page buttons -->
                <div class="admin-search-result-page-navigator">
                    <div class="left">
                        <p class="current-search-result-count">Results: 0</p>
                    </div>
                    <div class="right">
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
            <button class="bulkUserButton" style="background-color:hsl(109.6, 60%, 49%) !important;font-size:inherit;" onclick="users.editUsers.openOverlay();">BULK Edit</button>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>