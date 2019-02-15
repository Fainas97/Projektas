<?php
ob_start();
require_once('includes/load.php');
if ($session->isUserLoggedIn(true)) {
    redirect('home.php', false);
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page" style="margin-left: 190px;">
    <div class="text-center">
        <h1>Sandėlio sistema</h1>
        <p>Karolis Fainas IFC-6</p>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="auth.php" class="clearfix">
        <div class="form-group">
            <label for="username" class="control-label">Slapyvardis</label>
            <input type="name" class="form-control" name="slapyvardis" placeholder="Slapyvardis">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Slaptažodis</label>
            <input type="password" name="slaptazodis" class="form-control" placeholder="Slaptažodis">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info  pull-right">Prisijungti</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
