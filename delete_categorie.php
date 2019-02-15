<?php
require_once('includes/load.php');
$roles = array(1);
page_require_level($roles);
?>
<?php
$categorie = find_by_id('categories', (int)$_GET['id']);
if (!$categorie) {
    $session->msg("d", "Trūksta kategorijos ID.");
    redirect('categorie.php');
}
?>
<?php
$delete_id = delete_by_id('categories', (int)$categorie['id']);
if ($delete_id) {
    $session->msg("s", "Kategorija ištrinta.");
    redirect('categorie.php');
} else {
    $session->msg("d", "Kategorijos pašalinimas nepavyko.");
    redirect('categorie.php');
}
?>
