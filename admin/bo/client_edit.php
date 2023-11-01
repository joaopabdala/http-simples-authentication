<?php
defined("ROOT") or die("Acesso inválido");
?>

<?php
require_once("navegacao.php");

$bd = new database();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $success = '';

    if (
        !isset($_POST['alterar_user_e_senha']) ||
        !isset($_POST['id_client']) ||
        !isset($_POST['text_cliente']) ||
        !isset($_POST['text_usuario']) ||
        !isset($_POST['text_senha'])
    ) {
        $error = 'Não foram fornecidos todos os dados';
    }

    if (empty($error)) {

        $alterar_user_e_senha = $_POST['alterar_user_e_senha'] == false ? true : false;
        $cliente = $_POST['text_cliente'];
        $id_client = $_POST['id_client'];
        $usuario = $_POST['text_usuario'];
        $senha = $_POST['text_senha'];
        
        $parametros = [
            ':id_client'=> $id_client,
            ':client_name' => $cliente
        ];
        $resultado = $bd->EXE_QUERY("SELECT *  FROM authentication WHERE client_name = :client_name AND id_client <> :id_client", $parametros);
        if(count($resultado) != 0){
            $error = "Já existe outro cliente com o mesmo nome.";
        } else {
            $parametros = [
                ':id_client'=> $id_client,
                ':client_name' => $cliente,
            ];

            $bd->EXE_NON_QUERY('UPDATE authentication SET client_name = :client_name, updated_at = NOW() WHERE id_client = :id_client', $parametros);
            $success = 'Nome do cliente foi editado com sucesso!';
        }


        if(!$alterar_user_e_senha){
            $parametros = [
                ':usuario'=> $usuario,
                ':senha' => password_hash($senha, PASSWORD_DEFAULT),
                ':id_client'=> $id_client
            ];
            $bd->EXE_NON_QUERY('UPDATE authentication SET username = :usuario, passwrd = :senha, updated_at = NOW() WHERE id_client = :id_client', $parametros);
            $success = 'Nome do cliente e todos os seus dados editado com sucesso!';
        } 
    
    }
    
}

if(!isset($_GET['id'])){
    $error = 'Não existe id de cliente definido';
} else {
    $id_client = $_GET['id'];

    $parametros = [
        ':id_client'=> $id_client
    ];

    $resultados = $bd->EXE_QUERY('SELECT * FROM authentication WHERE id_client = :id_client', $parametros);

    if(count($resultados) != 1){
        $error  = "Não existe o cliente selecionado";
    } else {
        $resultados = $resultados[0];
    }
}

?>


<?php if(!empty($error)):?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
                <div class="alert alert-danger p-2 text-center">
                    <?= $error ?>
                </div>
                <div class="mt-3 text-center">
                    <a href="index.php" class="btn btn-primary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
<?php else:?>

<div class="container">
    <div class="row mt-5">
        <div class="col-sm-8 offset-sm-2">

            <form action="?r=client_edit&id=<?= $id_client?>" method="post">
                <input type="hidden" name="alterar_user_e_senha" id="alterar-user-e-senha" value="false">
                <input type="hidden" name="id_client" value="<?= $id_client?>">

                <h3 class="text-center">Editar Cliente</h3>
                <hr>
                <div class="mb-3">
                    <label class="form-label" ">Cliente:</label>
                <input type=" text" name="text_cliente" class="form-control" required value="<?= $resultados['client_name']?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" ">Username:</label>
                <input type=" text" name="text_usuario" class="form-control" id="usuario" readonly required value="<?= $resultados['username']?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" ">senha:</label>
                <input type=" text" name="text_senha" class="form-control" id="senha" readonly required placeholder="Senha Reservada">
                </div>

                <div class="mb-3 text-end">
                    <button type="button" class="btn btn-primary" onclick="gerarUsuarioPassword()">
                        Gerar
                    </button>
                </div>

                <div class="mb-3 text-center">
                    <a href="?r=home" class="btn btn-secondary btn-150">Cancelar</a>
                    <input type="submit" value="Editar" class="btn btn-primary btn-150">
                </div>
            </form>
            <?php if (!empty($error)) : ?>
                <p class="alert alert-danger p-2 text-center">
                    <?= $error ?>
                </p>
            <?php endif ?>
            <?php if (!empty($success)) : ?>
                <p class="alert alert-success p-2 text-center">
                    <?= $success ?>
                </p>
                <div class="mt-3 card p-2 bg-light">
                    <p>Cliente: <?=$cliente ?></p>
                    <p>Username: <?= $usuario?></p>
                    <p>Senha: <?=$senha ?></p>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?php endif?>

<script>
    function gerarUsuarioPassword() {
        let client_username = '';
        let client_password = '';
        let charbase = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        const client_username_length = 32;
        const client_password_length = 32;

        for (let i = 0; i < client_username_length; i++) {
            client_username += charbase.charAt(Math.floor(Math.random() * charbase.length));

        }
        for (let i = 0; i < client_password_length; i++) {
            client_password += charbase.charAt(Math.floor(Math.random() * charbase.length));

        }

        document.querySelector('#usuario').value = client_username;
        document.querySelector('#senha').value = client_password;
        document.querySelector('#alterar-user-e-senha').value = true;


    }

</script>