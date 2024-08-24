<?php
// require_once "helpers/protectNivel.php";
require_once 'comuns/cabecalho.php';
require_once "library/Database.php";
require_once "helpers/Formulario.php";


// Criando o objeto Db para classe de base de dados
$db = new Database();

$dado_usuario = $db->dbSelect("SELECT cpf FROM usuario WHERE id = ?", 'first', [$_SESSION['userId']]);

$data = $db->dbSelect("
    SELECT 
        r.id AS reserva_id,
        u.nome AS usuario_nome,
        u.cpf AS usuario_cpf,
        u.email AS usuario_email,
        r.telefone AS reserva_telefone,
        r.local_id AS reserva_local_id,
        l.nome_local AS local_nome,  -- Nome do local
        r.data_reserva AS reserva_data_reserva,
        r.data_hora_inicio AS reserva_data_hora_inicio,
        r.data_hora_fim AS reserva_data_hora_fim,
        r.statusRegistro AS reserva_status_registro,
        r.status AS reserva_status,
        r.valor AS reserva_valor,
        r.cpf AS reserva_cpf,
        r.usuario_id AS usuario_id
    FROM 
        reserva r
    LEFT JOIN 
        usuario u ON r.usuario_id = u.id
    LEFT JOIN 
        local l ON r.local_id = l.id  -- JOIN com a tabela local
    WHERE 
        r.statusRegistro = 1 
        AND (u.statusRegistro = 1 OR u.statusRegistro IS NULL) 
        AND r.cpf = ?;
    ", 
    'all', 
    [$dado_usuario->cpf]
);





    // var_dump($data, $_SESSION['userId'], $dado_usuario->cpf);
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
                <h4 class="page-title">Lista de agendamentos</h4>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="agendamento.php?acao=insert" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="tbListaAgendamento" class="table table-border table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>CPF</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Local</th>
                                <th>Horario Inicio</th>
                                <th>Horario Fim</th>
                                <th>Status</th>
                                <th class="text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($data as $row) {
                                ?>
                            <tr>
                                <td><?= $row['reserva_id'] ?></td>
                                <td><img width="28" height="28" src="assets/img/user.jpg" class="rounded-circle m-r-5" alt=""> <?= $row['usuario_nome'] ?></td>
                                <td><?= $row['reserva_cpf'] ?></td>
                                <td><?= $row['reserva_telefone'] ?></td>
                                <td><?= $row['usuario_email'] ?></td>
                                <td><?= $row['local_nome'] ?></td>
                                <td><?= $row['reserva_data_hora_inicio'] ?></td>
                                <td><?= $row['reserva_data_hora_fim'] ?></td>
                                <td><?= $row['reserva_status'] ?></td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="formAgendamento.php?acao=update&id=<?= $row['reserva_id'] ?>"><i class="fa fa-pencil m-r-5"></i> Editar</a>
                                            <a class="dropdown-item" href="formAgendamento.php?acao=delete&id=<?= $row['reserva_id'] ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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

    echo datatables("tbListaAgendamento");
    require_once 'comuns/rodape.php';
?>
