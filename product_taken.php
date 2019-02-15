<?php
$page_title = 'Visos prekės';
require_once('includes/load.php');
$roles = array(4, 3, 2);
page_require_level($roles);
$all_categories = find_all('categories');
?>

<?php
if (isset($_POST['search'])) {
    if ($_POST['prekes-kategorija'] == null) {
        $products = join_product_taken_table();
    } else {
        $products = find_products_taken_by_categorie($_POST['prekes-kategorija']);
    }
} else {
    $products = join_product_taken_table();
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
                <div class="pull-left">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <span>Sandėlio prekės</span>
                    </strong>
                </div>
                <form action="product_taken.php" method="post">
                    <div class="col-md-3 pull-right">
                        <select class="form-control" name="prekes-kategorija">
                            <option value="">Pasirinkite kategoriją</option>
                            <?php foreach ($all_categories as $cat): ?>
                                <option value="<?php echo (int)$cat['id'] ?>">
                                    <?php echo $cat['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="pull-right">
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
                        <th class="text-center" style="..."> Pridėta į sandėlį</th>
                        <th class="text-center" style="width: 100px;"> Prekių vertė</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="text-center"><?php echo count_id(); ?></td>
                            <td class="text-center"> <?php echo remove_junk($product['name']); ?></td>
                            <td class="text-center"> <?php echo remove_junk($product['user']); ?></td>
                            <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
                            <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
                            <td class="text-center"> €<?php echo remove_junk($product['buy_price']); ?></td>
                            <td class="text-center"> €<?php echo remove_junk($product['sale_price']); ?></td>
                            <td class="text-center"> <?php echo read_date($product['date']); ?></td>
                            <td class="text-center"> €<?php echo remove_junk($product['sale_price'] * $product['quantity']); ?>.00</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
