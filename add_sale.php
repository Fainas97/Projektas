<?php
$page_title = 'Sukurti pardavimą';
require_once('includes/load.php');
$roles = array(2);
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

<?php

if (isset($_POST['add_sale'])) {
    $req_fields = array('prekes-kiekis', 'prekiu-suma', 'prod_id');
    $req_numbers = array('prekes-kiekis', 'prekiu-suma', 'prod_id');
    validate_fields($req_fields);
    validate_numbers($req_numbers);
    if (empty($errors)) {
        $p_id = $db->escape((int)$_POST['prod_id']);
        $s_qty = $db->escape((int)$_POST['prekes-kiekis']);
        $s_total = $db->escape($_POST['prekiu-suma']);
        $s_date = make_date();

        $sql = "INSERT INTO sales (";
        $sql .= " product_id,qty,price,date";
        $sql .= ") VALUES (";
        $sql .= "'{$p_id}','{$s_qty}','{$s_total}','{$s_date}'";
        $sql .= ")";

        if ($db->query($sql)) {
            update_product_qty("products_taken", $s_qty, $p_id);
            $session->msg('s', "Pardavimas pridėtas.");
            redirect('add_sale.php', false);
        } else {
            $session->msg('d', ' Atsiprašome nepavyko pridėti!');
            redirect('add_sale.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_sale.php', false);
    }
}

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
                <div class="pull-left">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <span>Pridėti pardavimą</span>
                    </strong>
                </div>
                <form action="add_sale.php" method="post">
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
                <form method="post" action="add_sale.php">
                    <table class="table table-bordered">
                        <thead>
                        <th class="text-center" style="width: 50px;"> #</th>
                        <th class="text-center" style="width: 50px;"> Prekės pavadinimas</th>
                        <th class="text-center" style="width: 10%;"> Tiekėjas</th>
                        <th class="text-center" style="width: 10%;"> Kategorija</th>
                        <th class="text-center" style="width: 10%;"> Kiekis</th>
                        <th class="text-center" style="width: 10%;"> Pirkimo kaina</th>
                        <th class="text-center" style="width: 10%;"> Pardavimo kaina</th>
                        <th class="text-center" style="width: 100px;"> Norimas kiekis</th>
                        <th class="text-center" style="..."> Bendra suma</th>
                        <th class="text-center" style="width: 50px"> Veiksmas</th>
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
                                <form action="add_sale.php" name="sell" method="post">
                                    <td><input type="number" min="1"
                                               max="<?php echo remove_junk($product['quantity']); ?>"
                                               class="form-control" name="prekes-kiekis"
                                               placeholder="Kiekis" id="kiekis<?php echo $product['id']; ?>" value="1"
                                               onchange="f(<?php echo $product['id']; ?>);"></td>
                                    <td><input type="number" class="form-control"
                                               id="saleIn<?php echo $product['id']; ?>" name="prekiu-suma"
                                               value="<?php echo $product['sale_price'] ?>"></td>
                                    <input type="hidden" id="sale<?php echo $product['id'] ?>"
                                           value="<?php echo $product['sale_price']; ?>">
                                    <td class="text-center">
                                        <input type="hidden" name="prod_id" value="<?php echo $product['id']; ?>">
                                        <input type="submit" name="add_sale" class="btn btn-primary"
                                               value="Parduoti">
                                    </td>
                                </form>
                                <script type="text/javascript">
                                    function f(id) {
                                        var kaina = document.getElementById("sale" + id).value;
                                        var kiekis = document.getElementById("kiekis" + id).value;
                                        document.getElementById("saleIn" + id).value = kaina * kiekis;
                                    }
                                </script>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include_once('layouts/footer.php'); ?>
