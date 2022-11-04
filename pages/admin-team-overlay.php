<?php
    require_once "../php/admin-class.php";
    $admin = new Admin();
    $admin->protectPage();
?>
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