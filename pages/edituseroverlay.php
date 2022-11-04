<?php
    require_once "../php/admin-class.php";
    $admin = new Admin();
    $admin->protectPage();
    if(isset($_GET["userid"])){
        $user = $admin->adminGetUser($_GET["userid"]);
    }
?>
<?php
if(!isset($_GET["userid"])) : ?>
<?php
    if(isset($_POST["bulkUserIds"])) :
    $data = json_decode($_POST["bulkUserIds"])
?>
<div class="center">
    <form action="../php/edit-users.php" method="POST" class="shadow user-overlay-wrapper" onsubmit="postForm(event);">
        <p class="form-title">Bulk Edit:</p>
        <table class="bulk-edit-table">
            <thead>
                <tr>
                    <th>Remove</th>
                    <th>Id</th>
                    <th>Username</th>
                    <th>E-mail</th>
                    <th>Admin-Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for($i=0;$i<count($data);$i++){
                    $userData = $admin->adminGetUser($data[$i]);
                    echo('<tr>');
                    echo('<td><p><button type="button" onclick="users.editUsers.removeUser(' . $userData["id"] . ', this);"></button></p></td>');
                    echo('<td><p>' . $userData["id"] . '</p></td>');
                    echo('<td><p>' . $userData["name"] . '</p></td>');
                    echo('<td><p>' . $userData["email"] . '</td>');
                    echo('<td><p>' . $userData["admin"] . '</td>');
                    echo('<input type="hidden" name="id[]" value=' . $userData["id"] . '>');
                    echo('</tr>');
                }
                ?>
            </tbody>
        </table>
        <div class="form-full-width">
            <input type="text" name="teamId" placeholder="Team Id" autocomplete="off">
        </div>
        <div class="form-full-width">
            <input type="password" name="adminPass" placeholder="Current Admin Password" autocomplete="off">
        </div>
        <div class="form-full-width">
            <input type="submit" value="Delete Users" class="delete-button button" name="delete">
            <input type="submit" value="Add Users To Team" class="button" name="addToTeam">
        </div>
    </form>
</div>
<?php endif; ?>
<?php else : ?>
<div class="center">
    <form action="../php/edit-users.php" method="POST" class="shadow user-overlay-wrapper" onsubmit="postForm(event);">
        <p class="form-title"><?php echo $user["name"]; ?>'s Settings:</p>
        <div class="user-overlay-wrapper-card">
            <p class="title">Current Username: <span><?php echo $user["name"]; ?></span></p>
            <input type="text" name="username" placeholder="New Username" autocomplete="off">
        </div>
        <div class="user-overlay-wrapper-card">
            <p class="title">Current E-mail: <span><?php echo $user["email"]; ?></span></p>
            <input type="text" name="email" placeholder="New E-mail" autocomplete="off">
        </div>
        <div class="user-overlay-wrapper-card">
            <p class="title">Current Goals: <span><?php echo $user["goals"]; ?></span></p>
            <input type="text" name="goals" placeholder="New Goals" autocomplete="off">
        </div>
        <div class="user-overlay-wrapper-card">
            <p class="title">Current Assists: <span><?php echo $user["assists"]; ?></span></p>
            <input type="text" name="assists" placeholder="New Assists" autocomplete="off">
        </div>
        <div class="user-overlay-wrapper-card">
            <p class="title">Current Admin role: <span><?php echo $user["admin"]; ?></span></p>
            <a href="../pages/admin-roles.php">Read more over admin roles here</a>
            <select name="admin">
                <option value="0"<?php if($user["admin"] == 0){echo(' selected="selected"');} ?>>No Admin Rights</option>
                <option value="1"<?php if($user["admin"] == 1){echo(' selected="selected"');} ?>>Manage Teams</option>
                <option value="2"<?php if($user["admin"] == 2){echo(' selected="selected"');} ?>>Manage Player Points/Teams</option>
                <option value="3"<?php if($user["admin"] == 3){echo(' selected="selected"');} ?>>Manage Players/Teams/Points</option>
                <option value="4"<?php if($user["admin"] == 4){echo(' selected="selected"');} ?>>Manage Players/teams/Admin rights</option>
            </select>
        </div>
        <div class="form-full-width">
            <input type="password" name="adminPass" placeholder="Current Admin Password" autocomplete="off">
        </div>
        <div class="form-full-width">
            <input type="submit" value="Update User" name="update">
        </div>
        <input type="hidden" name="id" value="<?php echo $user["id"]; ?>">
    </form>
</div>
<?php endif; ?>