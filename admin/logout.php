
<?php 

session_start();

unset($_SESSION['id_admin']);
unset($_SESSION['usuario']);

    print_r($_SESSION);

header('Location: index.php');
?>