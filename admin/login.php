<?php
defined("ROOT") or die("Acesso inválido");
?>

<div class="container">
    <div class="row my-5 card bg-light p-3">
        <div class="col-sm-4 offset-sm-4">
            <form action="index.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Usuário</label>
                    <input type="text" name="text_usuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="text_senha" class="form-control" required>
                </div>
                <div class="text-center">
                    <input type="submit" value="Entrar" class="btn btn-primary">
                </div>
            </form>
            <?php if(isset($_SESSION['error'])):?>
                <div class="row">
                    <div class="col">
                        <div class="text-center alert alert-danger p2 m-2">
                            <?= $_SESSION['error'] ?>
                            <?php unset($_SESSION['error'])?>
                        </div>    
                    </div>
                </div>
                <?php endif?>
        </div>
    </div>
</div>