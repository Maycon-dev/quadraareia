<?php

    // require_once "helpers/protectNivel.php";
    require_once 'comuns/cabecalho.php';
    require_once "library/Database.php";
    require_once "helpers/Formulario.php";

    // Criando o objeto Db para classe de base de dados
    $db = new Database();

    $data = $db->dbSelect("SELECT 
        h.id AS horario_id,
        h.local_id,
        l.nome_local,
        h.dia_semana,
        h.hora_inicio,
        h.hora_fim,
        h.statusRegistro
    FROM 
        horario_disponivel h
    INNER JOIN 
        local l ON h.local_id = l.id;
    ");

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
                <h4 class="page-title">Horários</h4>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="formHorario.php?acao=insert" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i></a>
            </div>
            
    
        </div>

        <div class="row">
            <div class="d-flex justify-content-start align-items-center ml-3 mb-3">
                <a href="intervaloMarcacao.php" class="btn btn-secondary"><span>Configurar intervalo marcação</span></a>       
            </div>
            
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-border table-striped custom-table datatable mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Local</th>
                                <th>Dia semana</th>
                                <th>Hora inicio</th>
                                <th>Hora fim</th>
                                <th>Status do registro</th>
                                <th class="text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($data as $row) {
                                ?>
                            <tr>
                                <td><?= $row['horario_id'] ?></td>
                                <td><?= $row['nome_local'] ?></td>
                                <td><?= getDiaSemana($row['dia_semana']) ?></td>
                                <td><?= $row['hora_inicio'] ?></td>
                                <td><?= $row['hora_fim'] ?></td>
                                <td><?= getStatusDescricao($row['statusRegistro']) ?></td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="formHorario.php?acao=update&id=<?= $row['horario_id'] ?>"><i class="fa fa-pencil m-r-5"></i> Editar</a>
                                            <a class="dropdown-item" href="formHorario.php?acao=delete&id=<?= $row['horario_id'] ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
