<?php
defined("ROOT") or die("Acesso inválido");
?>

<?php
require_once("navegacao.php");
?>

<?php
$error = '';

if (!isset($_GET["id"])) {
    $error = "Não foi definido um id";
}

if (empty($error)) {
    $id_client = $_GET["id"];

    $bd = new database();
    $parametros = [
        ':id_client' => $id_client,
    ];

    $resultados = $bd->EXE_QUERY("SELECT * FROM authentication WHERE id_client = :id_client", $parametros);
    if (empty($resultados)) {
        $error = 'Não foi encontrado o usuário';
    }
}



// if(empty($error)){ 

// }

// header('Location: index.php');

?>

<?php if (!empty($error)) : ?>
    <div class="row my-5">
        <div class="col-sm-6 offset-sm-3 text-center">
            <p class="alert alert-danger"><?= $error ?></p>
            <a href="index.php" class="btn btn-primary">Voltar</a>
        </div>
    </div>

<?php else : ?>
    <div class="row my-5">
        <div class="col-sm-6 offset-3 text-center">
            <p>Deseja eliminar o registro?</p>
            <p>Cliente: <?=$resultados[0]['client_name']?></p>
            <p>Username: <?=$resultados[0]['username']?></p>
            <div class="mt-4">
                <a href="index.php" class="btn btn-secondary">Voltar</a>
                <a href="?r=client_delete_ok&id=<?= $resultados[0]['id_client']?>" class="btn btn-primary">Eliminar</a>    
            </div>
        </div>
    </div>

<?php endif ?>