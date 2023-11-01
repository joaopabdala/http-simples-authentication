<?php
defined("ROOT") or die("Acesso inválido");
?>

<?php
require_once("navegacao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = '';
    $success = '';

    if (
        !isset($_POST['text_cliente']) ||
        !isset($_POST['text_usuario']) ||
        !isset($_POST['text_senha'])
    ) {
        $error = 'Não foram fornecidos todos os dados';
    }

    if (empty($error)) {
        $cliente = $_POST['text_cliente'];
        $usuario = $_POST['text_usuario'];
        $senha = $_POST['text_senha'];

        $bd = new database();

        $parametros = [
            ':cliente' => $cliente,
            ':username'=> $usuario,
        ];

        $resultados = $bd->EXE_QUERY("SELECT * FROM authentication WHERE client_name = :cliente OR username = :username", $parametros);
        if (!empty($resultados)) {
            $error = 'Já existe um cliente com o mesmo nome ou username';
        }
    }

    if (empty($error)) {

        $parametros = [
            ':client_name' => $cliente,
            ':username'=> $usuario,
            'passwrd'=> password_hash($senha, PASSWORD_DEFAULT)
        ];
        $bd->EXE_NON_QUERY("INSERT INTO authentication VALUE(
        0,
        :client_name,
        :username,
        :passwrd,
        NOW(),
        NOW(),
        NULL)
        ", $parametros);

        $success = 'Novo cliente adicionado com sucesso!';
    }
    
}

?>

<div class="container">
    <div class="row mt-5">
        <div class="col-sm-8 offset-sm-2">

            <form action="?r=new_client" method="post">
                <h3 class="text-center">Novo Cliente</h3>
                <hr>
                <div class="mb-3">
                    <label class="form-label" ">Cliente:</label>
                <input type=" text" name="text_cliente" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" ">Username:</label>
                <input type=" text" name="text_usuario" class="form-control" id="usuario" readonly required>
                </div>
                <div class="mb-3">
                    <label class="form-label" ">senha:</label>
                <input type=" text" name="text_senha" class="form-control" id="senha" readonly required>
                </div>

                <div class="mb-3 text-end">
                    <button type="button" class="btn btn-primary" onclick="gerarUsuarioPassword()">
                        Gerar
                    </button>
                </div>

                <div class="mb-3 text-center">
                    <a href="?r=home" class="btn btn-secondary btn-150">Cancelar</a>
                    <input type="submit" value="Criar" class="btn btn-primary btn-150">
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

    }
    gerarUsuarioPassword()
</script>