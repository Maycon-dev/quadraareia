<?php

// require_once "helpers/protectNivel.php";
require_once 'comuns/cabecalho.php';
require_once "library/Database.php";
require_once "helpers/Formulario.php";

// Criando o objeto Db para classe de base de dados
$db = new Database();

$data = $db->dbSelect("SELECT * FROM penalidade");

?>

    <div class="page-wrapper">
        <div class="row">
            <div class="col-12">
                <?php if (isset($_GET['msgSucesso'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><?= $_GET['msgSucesso'] ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['msgError'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?= $_GET['msgError'] ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-sm-4 col-3">
                    <h4 class="page-title">Penalidades</h4>
                </div>
                <div class="col-sm-8 col-9 text-right m-b-20">
                    <a href="formPenalidade.php?acao=insert" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-border table-striped custom-table datatable mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuário</th>
                                    <th>Faltas</th>
                                    <th>Dias bloqueado</th>
                                    <th>Bloqueado até</th>
                                    <th>Status do registor</th>
                                    <th class="text-right">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($data as $row) {
                                    ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><img width="28" height="28" src="assets/img/user.jpg" class="rounded-circle m-r-5" alt=""> <?= $row['usuario_id'] ?></td>
                                    <td><?= $row['faltas'] ?></td>
                                    <td><?= $row['dias_bloqueio'] ?></td>
                                    <td><?= $row['bloqueado_ate'] ?></td>
                                    <td><?= getStatusDescricao($row['statusRegistro']) ?></td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="formPenalidade.php?acao=update&id=<?= $row['id'] ?>"><i class="fa fa-pencil m-r-5"></i> Editar</a>
                                                <a class="dropdown-item" href="formPenalidade.php?acao=delete&id=<?= $row['id'] ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php 
                                } 
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>

<?php 
require_once 'comuns/rodape.php';
?>
