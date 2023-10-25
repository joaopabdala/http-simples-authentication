<?php  
defined("ROOT") or die("Acesso inválido");
?>

<?php 
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        die('acesso inválido');
    }
    $usuario = $_POST['text_usuario'];
    $senha = $_POST['text_senha'];

    if(empty($usuario) || empty($senha)){
        $_SESSION['error'] = 'Dados insuficientes';
        header('Location: index.php');
        return;
    }

    $bd = new database();
    $params = [
        ':usuario' => $usuario
    ];

    $resultados = $bd->EXE_QUERY("SELECT * FROM admin_users WHERE username = :usuario", $params);

    if(count($resultados) == 0){
        $_SESSION['error'] = 'Login inválido';
        header('Location: index.php');
        return;
    }

    if(!password_verify($senha, $resultados[0]['passwrd'])){
        $_SESSION['error'] = 'Login inválido';
        header('Location: index.php');
        return;
    }

    $_SESSION['id_admin'] = $resultados[0]['id_admin'];
    $_SESSION['usuario'] = $resultados[0]['username'];

    header('Location: index.php');


?>