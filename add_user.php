<?php
$page_title = 'Pridėti vartotoją';
require_once('includes/load.php');
$roles = array(1);
page_require_level($roles);
$groups = find_all('user_groups');
?>
<?php
if (isset($_POST['add_user'])) {

    $req_fields = array('vardas', 'prisijungimas', 'slaptazodis', 'level');
    validate_fields($req_fields);

    if (empty($errors)) {
        $name = remove_junk($db->escape($_POST['vardas']));
        $prisijungimas = remove_junk($db->escape($_POST['prisijungimas']));
        $slaptazodis = remove_junk($db->escape($_POST['slaptazodis']));
        $user_level = (int)$db->escape($_POST['level']);
        $slaptazodis = sha1($slaptazodis);
        $query = "INSERT INTO users (";
        $query .= "name,prisijungimas,slaptazodis,user_level,status";
        $query .= ") VALUES (";
        $query .= " '{$name}', '{$prisijungimas}', '{$slaptazodis}', '{$user_level}','1'";
        $query .= ")";
        if ($db->query($query)) {
            //sucess
            $session->msg('s', "Vartotojo paskyra sukurta! ");
            redirect('add_user.php', false);
        } else {
            //failed
            $session->msg('d', ' Atsiprašome nepavyko sukurti paskyros!');
            redirect('add_user.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_user.php', false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Pridėti naują vartotoją</span>
            </strong>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <form method="post" action="add_user.php">
                    <div class="form-group">
                        <label for="name">Vardas</label>
                        <input type="text" class="form-control" name="vardas" placeholder="Pilnas vardas">
                    </div>
                    <div class="form-group">
                        <label for="prisijungimas">Prisijungimo vardas</label>
                        <input type="text" class="form-control" name="prisijungimas" placeholder="Prisijungimo vardas">
                    </div>
                    <div class="form-group">
                        <label for="slaptazodis">Slaptažodis</label>
                        <input type="slaptazodis" class="form-control" name="slaptazodis" placeholder="Slaptažodis">
                    </div>
                    <div class="form-group">
                        <label for="level">Vartotojo vaidmuo</label>
                        <select class="form-control" name="level">
                            <?php foreach ($groups as $group): ?>
                                <option value="<?php echo $group['group_level']; ?>"><?php echo ucwords($group['group_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group clearfix">
                        <button type="submit" name="add_user" class="btn btn-primary">Pridėti vartotoją</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
