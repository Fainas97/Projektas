<?php
require_once('includes/load.php');
$roles = array(1);
page_require_level($roles);
?>
<?php
$delete_id = delete_by_id('user_groups', (int)$_GET['id']);
if ($delete_id) {
    $session->msg("s", "Grupė buvo ištrinta.");
    redirect('group.php');
} else {
    $session->msg("d", "Grupės ištrynimas nepavyko arba trūko prm.");
    redirect('group.php');
}
?>
