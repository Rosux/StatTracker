<?php
    require_once "../php/admin-class.php";
    $admin = new Admin();
    $admin->protectPage();
    $user = $admin;
    if($user->admin < 1){
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
    <script defer src="../scripts/teams.js"></script>
</head>
<body>
    <?php require_once("header.php"); ?>
    <div class="center">
        <div class="admin-user-search-wrapper">
            <div class="admin-search-bar shadow-small">
                <form action="../php/manage-team.php" method="POST">
                    <input type="text" name="idfilter" placeholder="Filter For Id" autocomplete="off" style="width: calc(100%/2);">
                    <input type="text" name="namefilter" placeholder="Filter For Team Name" autocomplete="off" style="width: calc(100%/2);">
                    <input type="hidden" name="internalMethod" value="getTeams">
                    <input type="hidden" name="id" value="true">
                </form>
            </div>
            <div class="admin-search-result-wrapper">
                <div class="admin-search-result">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Id</th>
                                <th>TeamName</th>
                                <th>TeamGoals</th>
                                <th>TeamAssists</th>
                                <th>Edit Team</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="admin-search-result-error-row"><td colspan="6"><p>No Teams Found</p></td></tr>
                        </tbody>
                    </table>
                </div>
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
            <button style="background-color: var(--accent-color-2); font-size: inherit;" class="bulkUserButton" type="button" onclick="loadOverlay('../pages/admin-team-overlay.php');">Create New Team</button>
        </div>
    </div>
    <div class="center">
    </div>
    <?php require_once("footer.php"); ?>
</body>
</html>