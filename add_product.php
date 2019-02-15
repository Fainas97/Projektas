<?php
$page_title = 'Pridėti prekę';
require_once('includes/load.php');
$roles = array(4);
page_require_level($roles);
$all_categories = find_all('categories');
$user = current_user();
?>
<?php
if (isset($_POST['add_product'])) {
    $req_fields = array('prekes-pavadinimas', 'id', 'prekes-kategorija', 'prekes-kiekis', 'pirkimo-kaina', 'pardavimo-kaina');
    $req_numbers = array('prekes-kiekis', 'pirkimo-kaina', 'pardavimo-kaina');
    validate_fields($req_fields);
    validate_numbers($req_numbers);
    if (empty($errors)) {
        $id = (int)$_POST['id'];
        $p_name = remove_junk($db->escape($_POST['prekes-pavadinimas']));
        $p_cat = remove_junk($db->escape($_POST['prekes-kategorija']));
        $p_qty = remove_junk($db->escape($_POST['prekes-kiekis']));
        $p_buy = remove_junk($db->escape($_POST['pirkimo-kaina']));
        $p_sale = remove_junk($db->escape($_POST['pardavimo-kaina']));
        $date = make_date();
        $query = "INSERT INTO products (";
        $query .= " user_id,name,quantity,buy_price,sale_price,categorie_id,date";
        $query .= ") VALUES (";
        $query .= " '{$id}', '{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$p_cat}', '{$date}'";
        $query .= ")";
        if ($db->query($query)) {
            $session->msg('s', "Prekė pridėta ");
            redirect('add_product.php', false);
        } else {
            $session->msg('d', ' Atsiprašome nepavyko pridėti!');
            redirect('product.php', false);
        }

    } else {
        $session->msg("d", $errors);
        redirect('add_product.php', false);
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
                    <span>Pridėti naują prekę</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form method="post" action="add_product.php" class="clearfix">
                        <div class="form-group">
                            <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                                <input type="text" class="form-control" name="prekes-pavadinimas"
                                       placeholder="Prekės pavadinimas">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" name="prekes-kategorija">
                                        <option value="">Pasirinkite prekės kategoriją</option>
                                        <?php foreach ($all_categories as $cat): ?>
                                            <option value="<?php echo (int)$cat['id'] ?>">
                                                <?php echo $cat['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                                        <input type="number" min="1" class="form-control" name="prekes-kiekis"
                                               placeholder="Prekės kiekis">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-eur"></i>
                     </span>
                                        <input type="number" min="1" class="form-control" name="pirkimo-kaina"
                                               placeholder="Pirkimo kaina">
                                        <span class="input-group-addon">.00</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-eur"></i>
                      </span>
                                        <input type="number" min="1" class="form-control" name="pardavimo-kaina"
                                               placeholder="Pardavimo kaina">
                                        <span class="input-group-addon">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">
                        <button type="submit" name="add_product" class="btn btn-danger">Pridėti prekę</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
