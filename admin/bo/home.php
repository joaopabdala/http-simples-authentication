<?php
defined("ROOT") or die("Acesso inválido");
?>

<?php
require_once("navegacao.php");
?>

<?php
$db = new database();
$clientes_da_api = $db->EXE_QUERY("SELECT * FROM authentication ORDER BY client_name");
?>

<div class="container mt-5">
    <div class="row">
        <div class="col">

            <div class="row">
                <div class="col-sm-6">
                    <h3>Clientes da API</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="?r=new_client" class="btn btn-primary btn-sm">+ Cliente</a>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Cliente</th>
                                <th>Chave</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes_da_api as $cliente_api) : ?>
                                <tr>
                                    <td class="<?= (empty($cliente_api['deleted_at'])) ? "" : "bg-danger"?>">
                                        <?= $cliente_api['client_name'] ?>
                                    </td>
                                    <td>
                                        <?= $cliente_api['username'] ?>
                                    </td>
                                    <td class="text-end" >
                                        <?php if(empty($cliente_api['deleted_at'])): ?>
                                            <a href="?r=client_delete&id=<?= $cliente_api['id_client']?>">Eliminar</a>
                                        <?php else:?>
                                            <a href="?r=client_recover&id=<?= $cliente_api['id_client']?>">Recuperar</a>
                                        <?php endif?>
                                        <span class="mx-2">|</span>
                                            <a href="?r=client_edit&id=<?= $cliente_api['id_client']?>">Editar</a>
                                            
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>



        </div>
    </div>
</div>