<?php
$page_title = 'Visos prekės';
require_once('includes/load.php');
$roles = array(4,3);
page_require_level($roles);
$all_categories = find_all('categories');
?>

<?php
if (isset($_POST['search'])) {
    if ($_POST['prekes-kategorija'] == null) {
        $products = join_product_table();
    } else {
        $products = find_all_product_info_by_categorie($_POST['prekes-kategorija']);
    }
} else {
    $products = join_product_table();
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-right">
                    <a href="add_product.php" class="btn btn-primary">Pridėti naują</a>
                </div>
                <form action="product.php" method="post">
                    <div class="col-md-3">
                        <select class="form-control" name="prekes-kategorija">
                            <option value="">Pasirinkite kategoriją</option>
                            <?php foreach ($all_categories as $cat): ?>
                                <option value="<?php echo (int)$cat['id'] ?>">
                                    <?php echo $cat['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="pull-left">
                        <input type="submit" name="search" class="btn btn-primary" value="Filtruoti">
                    </div>
                </form>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;"> #</th>
                        <th class="text-center" style="width: 50px;"> Prekės pavadinimas</th>
                        <th class="text-center" style="width: 10%;"> Tiekėjas</th>
                        <th class="text-center" style="width: 10%;"> Kategorija</th>
                        <th class="text-center" style="width: 10%;"> Kiekis sandėlyje</th>
                        <th class="text-center" style="width: 10%;"> Pirkimo kaina</th>
                        <th class="text-center" style="width: 10%;"> Pardavimo kaina</th>
                        <th> Pasiūlymo data</th>
                        <th class="text-center" style="width: 100px;"> Veiksmai</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="text-center"> <?php echo count_id(); ?></td>
                            <td class="text-center"> <?php echo remove_junk($product['name']); ?></td>
                            <td class="text-center"> <?php echo remove_junk($product['user']); ?></td>
                            <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
                            <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
                            <td class="text-center"> €<?php echo remove_junk($product['buy_price']); ?></td>
                            <td class="text-center"> €<?php echo remove_junk($product['sale_price']); ?></td>
                            <td> <?php echo read_date($product['date']); ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="edit_product.php?id=<?php echo (int)$product['id']; ?>"
                                       class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <a href="delete_product.php?id=<?php echo (int)$product['id']; ?>"
                                       class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-trash"></span>
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
