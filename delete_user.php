<?php
require_once('includes/load.php');
$roles = array(1);
page_require_level($roles);
?>
<?php
$delete_id = delete_by_id('users', (int)$_GET['id']);
if ($delete_id) {
    $session->msg("s", "Vartotojas ištrintas");
    redirect('users.php');
} else {
    $session->msg("d", "Vartotojo ištrinimas nepavyko");
    redirect('users.php');
}
?>
