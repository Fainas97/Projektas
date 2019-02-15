<?php
$page_title = 'Visi pardavimai';
require_once('includes/load.php');
$roles = array(2);
page_require_level($roles);
?>
<?php
$sales = find_all_sale();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Visi pardavimai</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th> Prekės pavadinimas</th>
                        <th class="text-center" style="width: 15%;"> Kategorija</th>
                        <th class="text-center" style="width: 15%;"> Kiekis</th>
                        <th class="text-center" style="width: 15%;"> Suma</th>
                        <th class="text-center" style="width: 15%;"> Data</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sales as $sale): ?>
                        <tr>
                            <td class="text-center"><?php echo count_id(); ?></td>
                            <td><?php echo remove_junk($sale['name']); ?></td>
                            <td class="text-center"><?php echo $sale['cat']; ?></td>
                            <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
                            <td class="text-center">€<?php echo remove_junk($sale['price']); ?></td>
                            <td class="text-center"><?php echo $sale['date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
