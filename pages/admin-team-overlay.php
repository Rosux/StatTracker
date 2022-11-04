<?php
    require_once "../php/admin-class.php";
    $admin = new Admin();
    $admin->protectPage();
?>
<?php
if(isset($_GET["teamid"])) :
$team = $admin->adminGetTeam($_GET["teamid"]);
?>
<div class="center">
    <form action="../php/manage-team.php" method="POST" class="shadow user-overlay-wrapper" onsubmit="postTeamUserForm(event);">
        <p class="form-title">Edit Team:</p>

        <div class="user-overlay-wrapper-card" style="margin-bottom: 2rem;">
            <p class="title">Current Team name: <span class="current-team-name"><?php echo $team["name"]; ?></span></p>
            <input type="text" name="teamname" placeholder="New Teamname" autocomplete="off">
        </div>
        <p class="form-title">Team Players:</p>
        <table class="bulk-edit-table">
        <thead>
            <tr>
                <th>Remove</th>
                <th>Id</th>
                <th>Username</th>
                <th>Goals</th>
                <th>Assists</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $teamPlayers = $team["players"];
                $players = json_decode(json_decode(json_encode($teamPlayers))); // wtf is this
                $players = json_decode(json_encode($players), true);
                if($players != null){
                    foreach($players as $key=>$value) {
                        // echo($players[23]["goals"]);
                        $user = $admin->adminGetUser($key);
                        if($user == 1){
                            $user = [];
                            $user["name"] = "User does not exist";
                        }
                        echo('
                            <tr>
                                <td><p><input type="checkbox" id="'.$key.'" name="delete[]"><label for="'.$key.'"></p></td>
                                <td><p>'.$key.'</p></td>
                                <td><p>'.$user["name"].'</p></td>
                                <td>
                                    <p><input type="text" name="newGoals" id="'.$key.'" placeholder="'.$players[$key]["goals"].'" autocomplete="off"></p>
                                </td>
                                <td>
                                    <p><input type="text" name="newAssists" id="'.$key.'" placeholder="'.$players[$key]["assists"].'" autocomplete="off"></p>
                                </td>
                            </tr>
                        ');
                    }
                }
            ?>
        </tbody>
        </table>
        <div class="form-full-width">
            <input type="password" name="adminPass" placeholder="Current Admin Password" autocomplete="off">
        </div>

        <div class="form-full-width">
            <input type="submit" value="Delete Team" name="delete" class="delete-button">
            <input type="submit" value="Update Team" name="edit">
        </div>
        <input type="hidden" name="teamid" value="<?php echo $_GET["teamid"]; ?>">
        <input type="hidden" name="internalMethod" value="edit">
    </form>
</div>

<?php else : ?>

<div class="center">
    <form action="../php/manage-team.php" method="POST" class="shadow user-overlay-wrapper" onsubmit="postTeamForm(event);">
        <p class="form-title">New Team:</p>
        <div class="user-overlay-wrapper-card">
            <p class="title">Team name:</span></p>
            <input type="text" name="teamname" placeholder="New Teamname" autocomplete="off">
        </div>

        <div class="form-full-width">
            <input type="password" name="adminPass" placeholder="Current Admin Password" autocomplete="off">
        </div>

        <div class="form-full-width">
            <input type="submit" value="Create Team" name="create">
        </div>

        <input type="hidden" name="internalMethod" value="create">
    </form>
</div>
<?php endif; ?>