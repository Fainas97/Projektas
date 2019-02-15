<?php
$page_title = 'Visi vartotojai';
require_once('includes/load.php');
?>
<?php
$roles = array(1);
page_require_level($roles);
//pull out all user form database
$all_users = find_all_user();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Vartotojai</span>
                </strong>
                <a href="add_user.php" class="btn btn-info pull-right">Pridėti naują naudotoją</a>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Vardas</th>
                        <th>Prisijungimo vardas</th>
                        <th class="text-center" style="width: 15%;">Vartotojo vaidmuo</th>
                        <th class="text-center" style="width: 10%;">Statusas</th>
                        <th style="width: 20%;">Paskutinis prisijungimas</th>
                        <th class="text-center" style="width: 100px;">Veiksmai</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($all_users as $a_user): ?>
                        <tr>
                            <td class="text-center"><?php echo count_id(); ?></td>
                            <td><?php echo remove_junk(ucwords($a_user['name'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_user['username'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($a_user['group_name'])) ?></td>
                            <td class="text-center">
                                <?php if ($a_user['status'] === '1'): ?>
                                    <span class="label label-success"><?php echo "Aktyvus"; ?></span>
                                <?php else: ?>
                                    <span class="label label-danger"><?php echo "Neaktyvus"; ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo read_date($a_user['last_login']) ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="edit_user.php?id=<?php echo (int)$a_user['id']; ?>"
                                       class="btn btn-xs btn-warning" data-toggle="tooltip" title="Redaguoti">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>
                                    <a href="delete_user.php?id=<?php echo (int)$a_user['id']; ?>"
                                       class="btn btn-xs btn-danger" data-toggle="tooltip" title="Pašalinti">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
