<?php 
session_start();

define("ROOT", true);
    require_once('inc/config.php');
    require_once('inc/database.php');

    require_once('inc/html_header.php');

    $rota = '';
    if(!isset($_SESSION['id_admin']) && $_SERVER['REQUEST_METHOD'] != 'POST'){
        $rota = 'login';
    } elseif(!isset($_SESSION['id_admin']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $rota = 'login_submit';
    } else {
        $rota = 'home';

        if(isset($_GET['r'])){
            $rota = $_GET['r'];
        }
    }

    switch($rota){
        case 'login':
            require_once('login.php');
            break;
        case 'login_submit':
            require_once('login_submit.php');
            break;
        case 'home':
            require_once('bo/home.php');
            break;
        case 'new_client':
            require_once('bo/new_client.php');
            break;
        case 'client_delete':
            require_once('bo/client_delete.php');
            break;
        case 'client_delete_ok':
            require_once('bo/client_delete_ok.php');
            break;
        case 'client_recover':
            require_once('bo/client_recover.php');
            break;
        case 'client_edit':
            require_once('bo/client_edit.php');
            break;
        default:
            echo 'Rota não definida';
            break;
    }

    require_once('inc/html_footer.php');
?>
