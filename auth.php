<?php include_once('includes/load.php'); ?>
<?php
$req_fields = array('slaptazodis', 'slapyvardis');
validate_fields($req_fields);
$username = remove_junk($_POST['slaptazodis']);
$password = remove_junk($_POST['slapyvardis']);

if (empty($errors)) {
    $user_id = authenticate($username, $password);
    if ($user_id) {
        //create session with id
        $session->login($user_id);
        //Update Sign in time
        updateLastLogIn($user_id);
        $session->msg("s", "Sveiki prisijungę į sandėlio sistemą!");
        redirect('home.php', false);

    } else {
        $session->msg("d", "Atsiprašome Slapyvardis/Slaptažodis neteisingas.");
        redirect('index.php', false);
    }

} else {
    $session->msg("d", $errors);
    redirect('index.php', false);
}

?>
