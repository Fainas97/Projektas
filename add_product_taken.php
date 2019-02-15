<?php
$page_title = 'Sandėlio prekės';
require_once('includes/load.php');
$roles = array(3, 2);
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

<?php
if (isset($_POST['add_product'])) {
    $id_prod = (int)$_POST['prod_id'];
    $count = (int)$_POST['prekes-pavadinimas'];
    if (insert_product_taken($id_prod, $count) == true) {
        $session->msg('d', "Atsiprašome! Nepavyko pridėti prekės(-ių) į sandėlį!");
        redirect('add_product_taken.php', false);
    } else {
        update_product_qty("products",$count, $id_prod);
        $session->msg('s', "Prekė(-ės) buvo pridėtą(-os) į sandėlį");
        redirect('add_product_taken.php', false);
    }
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
                        <span>Pasiūlytos prekės</span>
                    </strong>
                </div>
                <form action="add_product_taken.php" method="post">
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
                        <th class="text-center" style="width: 10%;"> Kiekis pasiūlytas</th>
                        <th class="text-center" style="width: 10%;"> Pirkimo kaina</th>
                        <th class="text-center" style="width: 10%;"> Pardavimo kaina</th>
                        <th class="text-center" style="width: 10%;"> Norimas kiekis</th>
                        <th class="text-center" style="width: 50px"> Veiksmas</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="text-center" style="vertical-align: middle"><?php echo count_id(); ?></td>
                            <td class="text-center"
                                style="vertical-align: middle"> <?php echo remove_junk($product['name']); ?></td>
                            <td class="text-center"
                                style="vertical-align: middle"> <?php echo remove_junk($product['user']); ?></td>
                            <td class="text-center"
                                style="vertical-align: middle"> <?php echo remove_junk($product['categorie']); ?></td>
                            <td class="text-center"
                                style="vertical-align: middle"> <?php echo remove_junk($product['quantity']); ?></td>
                            <td class="text-center"
                                style="vertical-align: middle"> €<?php echo remove_junk($product['buy_price']); ?></td>
                            <td class="text-center"
                                style="vertical-align: middle"> €<?php echo remove_junk($product['sale_price']); ?></td>
                            <form action="add_product_taken.php" method="post">
                                <td><input type="number" min="1" max="<?php echo remove_junk($product['quantity']); ?>"
                                           class="form-control" name="prekes-pavadinimas"
                                           placeholder="Kiekis"></td>
                                <td class="text-center">
                                    <input type="hidden" name="prod_id" value="<?php echo (int)$product['id']; ?>">
                                    <input type="submit" name="add_product" class="btn btn-primary"
                                           value="Pridėti prekę(-es)">
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
