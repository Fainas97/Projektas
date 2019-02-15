<?php
$page_title = 'Pridėti grupę';
require_once('includes/load.php');
$roles = array(1);
page_require_level($roles);
?>
<?php
if (isset($_POST['add'])) {

    $req_fields = array('grupes-vardas', 'grupes-lygis');
    validate_fields($req_fields);

    if (find_by_groupName($_POST['grupes-vardas']) === false) {
        $session->msg('d', '<b>Atsiprašome!</b> Įvestas grupės pavadinimas jau yra duomenų bazėje!');
        redirect('add_group.php', false);
    } elseif (find_by_groupLevel($_POST['grupes-lygis']) === false) {
        $session->msg('d', '<b>Atsiprašome!</b> Įvestas grupės lygis jau yra duomenų bazėje!');
        redirect('add_group.php', false);
    }
    if (empty($errors)) {
        $name = remove_junk($db->escape($_POST['grupes-vardas']));
        $level = remove_junk($db->escape($_POST['grupes-lygis']));
        $status = remove_junk($db->escape($_POST['status']));

        $query = "INSERT INTO user_groups (";
        $query .= "group_name,group_level,group_status";
        $query .= ") VALUES (";
        $query .= " '{$name}', '{$level}','{$status}'";
        $query .= ")";
        if ($db->query($query)) {
            //sucess
            $session->msg('s', "Grupė sukurta! ");
            redirect('add_group.php', false);
        } else {
            //failed
            $session->msg('d', ' Atsiprašome nepavyko sukurti grupės!');
            redirect('add_group.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_group.php', false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
        <h3>Pridėti naują naudotojų grupę</h3>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="add_group.php" class="clearfix">
        <div class="form-group">
            <label for="name" class="control-label">Grupės pavadinimas</label>
            <input type="name" class="form-control" name="grupes-vardas">
        </div>
        <div class="form-group">
            <label for="level" class="control-label">Grupės lygis</label>
            <input type="number" class="form-control" name="grupes-lygis">
        </div>
        <div class="form-group">
            <label for="status">Statusas</label>
            <select class="form-control" name="status">
                <option value="1">Aktyvus</option>
                <option value="0">Neaktyvus</option>
            </select>
        </div>
        <div class="form-group clearfix">
            <button type="submit" name="add" class="btn btn-info">Atnaujinti</button>
        </div>
    </form>
</div>

<?php include_once('layouts/footer.php'); ?>
