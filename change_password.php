<?php
$page_title = 'Slaptažodžio keitimas';
require_once('includes/load.php');
$roles = array(4, 3, 2, 1);
page_require_level($roles);
?>
<?php $user = current_user(); ?>
<?php
if (isset($_POST['update'])) {

    $req_fields = array('naujas-slaptazodis', 'senas-slaptazodis', 'id');
    validate_fields($req_fields);

    if (empty($errors)) {

        if (sha1($_POST['senas-slaptazodis']) !== current_user()['password']) {
            $session->msg('d', "Slaptažodis nesutampa!");
            redirect('change_password.php', false);
        }

        $id = (int)$_POST['id'];
        $new = remove_junk($db->escape(sha1($_POST['naujas-slaptazodis'])));
        $sql = "UPDATE users SET password ='{$new}' WHERE id='{$db->escape($id)}'";
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1):
            $session->logout();
            $session->msg('s', "Prisijunk su nauju slaptažodžiu.");
            redirect('index.php', false);
        else:
            $session->msg('d', ' Atleiskite, nepavyko atnaujinti!');
            redirect('change_password.php', false);
        endif;
    } else {
        $session->msg("d", $errors);
        redirect('change_password.php', false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
        <h3>Pasikeisk savo slaptažodį</h3>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="change_password.php" class="clearfix">
        <div class="form-group">
            <label for="newPassword" class="control-label">Naujas slaptažodis</label>
            <input type="password" class="form-control" name="naujas-slaptazodis" placeholder="Naujas slaptažodis">
        </div>
        <div class="form-group">
            <label for="oldPassword" class="control-label">Senas slaptažodis</label>
            <input type="password" class="form-control" name="senas-slaptazodis" placeholder="Senas slaptažodis">
        </div>
        <div class="form-group clearfix">
            <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">
            <button type="submit" name="update" class="btn btn-info">Keisti</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
