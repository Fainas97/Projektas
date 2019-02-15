<?php
$page_title = 'Redaguoti prekę';
require_once('includes/load.php');
page_require_id_level(4, $_GET['id']);
?>
<?php
$product = find_by_id('products', (int)$_GET['id']);
$all_categories = find_all('categories');
if (!$product) {
    $session->msg("d", "Trūksta prekės ID.");
    redirect('product.php');
}
?>
<?php
if (isset($_POST['product'])) {
    $req_fields = array('prekes-pavadinimas', 'prekes-kategorija', 'prekes-kiekis', 'pirkimo-kaina', 'pardavimo-kaina');
    validate_fields($req_fields);

    if (empty($errors)) {
        $p_name = remove_junk($db->escape($_POST['prekes-pavadinimas']));
        $p_cat = (int)$_POST['prekes-kategorija'];
        $p_qty = remove_junk($db->escape($_POST['prekes-kiekis']));
        $p_buy = remove_junk($db->escape($_POST['pirkimo-kaina']));
        $p_sale = remove_junk($db->escape($_POST['pardavimo-kaina']));
        $query = "UPDATE products SET";
        $query .= " name ='{$p_name}', quantity ='{$p_qty}',";
        $query .= " buy_price ='{$p_buy}', sale_price ='{$p_sale}', categorie_id ='{$p_cat}'";
        $query .= " WHERE id ='{$product['id']}'";
        $result = $db->query($query);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Prekė atnaujinta");
            redirect('product.php', false);
        } else {
            $session->msg('d', ' Atsiprašome nepavyko atnaujinti!');
            redirect('edit_product.php?id=' . $product['id'], false);
        }

    } else {
        $session->msg("d", $errors);
        redirect('edit_product.php?id=' . $product['id'], false);
    }

}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Redaguoti prekę</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
                        <div class="form-group">
                            <label for="prodName">Pavadinimas</label>
                            <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                                <input type="text" class="form-control" name="prekes-pavadinimas"
                                       readonly="readonly" value="<?php echo remove_junk($product['name']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="qty">Kategorija</label>
                                        <select class="form-control" name="prekes-kategorija">
                                            <option value=""> Pasirinkite kategoriją</option>
                                            <?php foreach ($all_categories as $cat): ?>
                                                <option value="<?php echo (int)$cat['id']; ?>" <?php if ($product['categorie_id'] === $cat['id']):
                                                    echo "selected"; else: echo "disabled"; endif; ?>>
                                                    <?php echo remove_junk($cat['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="qty">Kiekis</label>
                                        <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                                            <input type="number" min="0" class="form-control" name="prekes-kiekis"
                                                   value="<?php echo remove_junk($product['quantity']); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="qty">Pirkimo kaina</label>
                                        <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-eur"></i>
                      </span>
                                            <input readonly="readonly" type="number" class="form-control"
                                                   name="pirkimo-kaina"
                                                   value="<?php echo remove_junk($product['buy_price']); ?>">
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="qty">Pardavimo kaina</label>
                                        <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-eur"></i>
                       </span>
                                            <input readonly="readonly" type="number" class="form-control"
                                                   name="pardavimo-kaina"
                                                   value="<?php echo remove_junk($product['sale_price']); ?>">
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="product" class="btn btn-danger">Atnaujinti</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
