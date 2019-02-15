<?php
require_once('includes/load.php');
page_require_id_level(4, $_GET['id']);
?>
<?php
$product = find_by_id('products', (int)$_GET['id']);
if (!$product) {
    $session->msg("d", "Trūksta prekės ID.");
    redirect('product.php');
}
?>
<?php
$delete_id = delete_by_id('products', (int)$product['id']);
if ($delete_id) {
    $session->msg("s", "Prekės ištrintos.");
    redirect('product.php');
} else {
    $session->msg("d", "Prekių ištrynimas nepavyko.");
    redirect('product.php');
}
?>
