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
    } else {
        $parametros = [
            ':id_client' => $id_client,
        ];
        $bd->EXE_NON_QUERY("UPDATE authentication SET deleted_at = NULL WHERE id_client = :id_client", $parametros);
        header('Location: index.php');
        return;
    }

    
}


?>

<?php if (!empty($error)) : ?>
    <div class="row my-5">
        <div class="col-sm-6 offset-sm-3 text-center">
            <p class="alert alert-danger"><?= $error ?></p>
            <a href="index.php" class="btn btn-primary">Voltar</a>
        </div>
    </div>

<?php endif ?>