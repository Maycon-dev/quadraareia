<?php

    // require_once "helpers/protectNivel.php";
    require_once "helpers/Formulario.php";
    require_once "library/Database.php";
    require_once "comuns/cabecalho.php";

    // Criando o objeto Db para classe de base de dados
    $db = new Database();

    // Buscar a lista de Rotas na base de dados
    $data = $db->dbSelect("SELECT * FROM usuario ORDER BY nome");
?>

    <div class="page-wrapper">
        <div class="row">
            <?= getMensagem() ?>

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
                        <table id="tbListaUsuario" class="table table-border table-striped custom-table mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Tipo de usuário</th>
                                    <th>CPF</th>
                                    <th>Status do registro</th>
                                    <th class="text-right">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($data as $row) {
                                    ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><img width="28" height="28" src="assets/img/user.jpg" class="rounded-circle m-r-5" alt=""> <?= $row['nome'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['tipo_usuario'] ?></td>
                                    <td><?= $row['cpf'] ?></td>
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

    echo datatables("tbListaUsuario");

    require_once 'comuns/rodape.php';
?>
