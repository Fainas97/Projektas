<?php
$page_title = 'Redaguoti vartotoją';
require_once('includes/load.php');
$roles = array(1);
page_require_level($roles);
?>
<?php
$e_user = find_by_id('users', (int)$_GET['id']);
$groups = find_all('user_groups');
if (!$e_user) {
    $session->msg("d", "Trūksta vartotojo ID.");
    redirect('users.php');
}
?>

<?php
//Update User basic info
if (isset($_POST['update'])) {
    $req_fields = array('name', 'username', 'level');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_user['id'];
        $name = remove_junk($db->escape($_POST['name']));
        $username = remove_junk($db->escape($_POST['username']));
        $level = (int)$db->escape($_POST['level']);
        $status = remove_junk($db->escape($_POST['status']));
        $sql = "UPDATE users SET name ='{$name}', username ='{$username}',user_level='{$level}',status='{$status}' WHERE id='{$db->escape($id)}'";
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Paskyra atnaujinta ");
            redirect('edit_user.php?id=' . (int)$e_user['id'], false);
        } else {
            $session->msg('d', ' Atsiprašome nepavyko atnaujinti!');
            redirect('edit_user.php?id=' . (int)$e_user['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_user.php?id=' . (int)$e_user['id'], false);
    }
}
?>
<?php
// Update user password
if (isset($_POST['update-pass'])) {
    $req_fields = array('password');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_user['id'];
        $password = remove_junk($db->escape($_POST['password']));
        $h_pass = sha1($password);
        $sql = "UPDATE users SET password='{$h_pass}' WHERE id='{$db->escape($id)}'";
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Vartotojo slaptažodis atnaujintas ");
            redirect('edit_user.php?id=' . (int)$e_user['id'], false);
        } else {
            $session->msg('d', ' Atsiprašome nepavyko atnaujinti vartotojo slaptažodžio!');
            redirect('edit_user.php?id=' . (int)$e_user['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_user.php?id=' . (int)$e_user['id'], false);
    }
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    Atnaujinti <?php echo remove_junk(ucwords($e_user['name'])); ?> paskyrą
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_user.php?id=<?php echo (int)$e_user['id']; ?>" class="clearfix">
                    <div class="form-group">
                        <label for="name" class="control-label">Vardas</label>
                        <input type="name" class="form-control" name="name"
                               value="<?php echo remove_junk(ucwords($e_user['name'])); ?>">
                    </div>
                    <div class="form-group">
                        <label for="username" class="control-label">Vartotojo vardas</label>
                        <input type="text" class="form-control" name="username"
                               value="<?php echo remove_junk(ucwords($e_user['username'])); ?>">
                    </div>
                    <div class="form-group">
                        <label for="level">Vartotojo vaidmuo</label>
                        <select class="form-control" name="level">
                            <?php foreach ($groups as $group): ?>
                                <option <?php if ($group['group_level'] === $e_user['user_level']) echo 'selected="selected"'; ?>
                                        value="<?php echo $group['group_level']; ?>"><?php echo ucwords($group['group_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Statusas</label>
                        <select class="form-control" name="status">
                            <option <?php if ($e_user['status'] === '1') echo 'selected="selected"'; ?>value="1">
                                Aktyvus
                            </option>
                            <option <?php if ($e_user['status'] === '0') echo 'selected="selected"'; ?> value="0">
                                Neaktyvus
                            </option>
                        </select>
                    </div>
                    <div class="form-group clearfix">
                        <button type="submit" name="update" class="btn btn-info">Atnaujinti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Change password form -->
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    Pakeisti <?php echo remove_junk(ucwords($e_user['name'])); ?> slaptažodį
                </strong>
            </div>
            <div class="panel-body">
                <form action="edit_user.php?id=<?php echo (int)$e_user['id']; ?>" method="post" class="clearfix">
                    <div class="form-group">
                        <label for="password" class="control-label">Slaptažodis</label>
                        <input type="password" class="form-control" name="password"
                               placeholder="Įveskite naują slaptažodį">
                    </div>
                    <div class="form-group clearfix">
                        <button type="submit" name="update-pass" class="btn btn-danger pull-right">Pakeisti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php include_once('layouts/footer.php'); ?>
