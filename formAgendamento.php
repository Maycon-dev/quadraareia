<?php

    // require_once "helpers/protectNivel.php";
    require_once "helpers/Formulario.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db = new Database();
    $dados = [];

    /*
    *   Se for alteração, exclusão ou visualização busca a UF pelo ID que foi recebido via método GET
    */
    if ($_GET['acao'] != "insert") {
        
        $dados = $db->dbSelect("SELECT 
            r.id AS reserva_id,
            r.cpf AS reserva_cpf,
            r.telefone AS reserva_telefone,
            r.local_id AS reserva_local_id,
            r.data_reserva AS reserva_data_reserva,
            r.data_hora_inicio AS reserva_data_hora_inicio,
            r.data_hora_fim AS reserva_data_hora_fim,
            r.statusRegistro AS reserva_status_registro,
            r.status AS reserva_status,
            r.valor AS reserva_valor,
            r.motivo_cancelamento,
            u.id AS usuario_id,
            u.nome AS usuario_nome,
            u.email AS usuario_email,
            u.telefone AS usuario_telefone,
            u.cpf AS usuario_cpf,
            h.id AS horario_id,
            h.hora_inicio AS horario_inicio,
            h.hora_fim AS horario_fim
        FROM 
            reserva r
        INNER JOIN 
            usuario u ON r.usuario_id = u.id
        INNER JOIN 
            horario_disponivel h ON r.local_id = h.local_id 
            -- AND DAYOFWEEK(r.data_reserva) = h.dia_semana
        WHERE 
            r.id = ?;
        ", 'first', [$_GET['id']]);
        };


?>

    <div class="page-wrapper mt-4">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Editar Horário<?= subTitulo($_GET['acao']) ?></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form class="g-3" action="<?= $_GET['acao'] ?>Agendamento.php" method="POST" 
                    enctype="multipart/form-data">

                    <input type="hidden" name="id" id="id" value="<?= isset($dados->reserva_id) ? $dados->reserva_id : "" ?>">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="usuario_id">Usuário <span class="text-danger">*</span></label>
                                <input class="form-control" name="usuario_id" id="usuario_id" type="text" value="<?= isset($dados->usuario_nome) ? $dados->usuario_nome : "" ?>" disabled>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cpf">Usuário <span class="text-danger">*</span></label>
                                <input class="form-control" name="cpf" id="cpf" type="text" value="<?= isset($dados->reserva_cpf) ? $dados->reserva_cpf : "" ?>" disabled>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="telefone">Telefone <span class="text-danger">*</span></label>
                                <input class="form-control" name="telefone" id="telefone" type="text" value="<?= isset($dados->reserva_telefone) ? $dados->reserva_telefone : "" ?>" disabled>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="local_id">Local <span class="text-danger">*</span></label>
                                <input class="form-control" name="local_id" id="local_id" type="text" value="<?= isset($dados->reserva_local_id) ? $dados->reserva_local_id : "" ?>" disabled>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="data_reserva">Data da reserva <span class="text-danger">*</span></label>
                                <input class="form-control" name="data_reserva" id="data_reserva" type="text" value="<?= isset($dados->reserva_data_reserva) ? $dados->reserva_data_reserva : "" ?>" disabled>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="valor">Valor <span class="text-danger">*</span></label>
                                <input class="form-control" name="valor" id="valor" type="text" value="<?= isset($dados->reserva_valor) ? $dados->reserva_valor : "" ?>" disabled>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="data_hora_inicio">Hora inicio <span class="text-danger">*</span></label>
                                <input class="form-control" name="data_hora_inicio" id="data_hora_inicio" type="text" value="<?= isset($dados->reserva_data_hora_inicio) ? $dados->reserva_data_hora_inicio : "" ?>" disabled>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="data_hora_fim">Hora fim <span class="text-danger">*</span></label>
                                <input class="form-control" name="data_hora_fim" id="data_hora_fim" type="text" value="<?= isset($dados->reserva_data_hora_fim) ? $dados->reserva_data_hora_fim : "" ?>" disabled>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label for="status" class="form-label">Status do Registro  <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control" onchange="toggleMotivoCancelamento()" required>
                                    <option value=""  <?= isset($dados->reserva_status) ? $dados->reserva_status == "" ? "selected" : "" : "" ?>>...</option>
                                    <!-- <option value="1" <?= isset($dados->reserva_status) ? $dados->reserva_status == 1  ? "selected" : "" : "" ?>>Pendente</option> -->
                                    <option value="2" <?= isset($dados->reserva_status) ? $dados->reserva_status == 2  ? "selected" : "" : "" ?>>Confirmado</option>
                                    <option value="3" <?= isset($dados->reserva_status) ? $dados->reserva_status == 3  ? "selected" : "" : "" ?>>Cancelar</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12" id="motivo-cancelamento-container" style="display: none;">
                            <label for="motivo_cancelamento" class="form-label">Motivo cancelamento <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="motivo_cancelamento" id="motivo_cancelamento" required><?= isset($dados->motivo_cancelamento) ? $dados->motivo_cancelamento : "" ?></textarea>
                        </div>

                        <input type="hidden" name="horario_id" value="<?= isset($dados->horario_id) ? $dados->horario_id : "" ?>">
                        <input type="hidden" name="cpf" value="<?= isset($dados->reserva_cpf) ? $dados->reserva_cpf : "" ?>">

                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary submit-btn">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">


        function toggleMotivoCancelamento() {
            var status = document.getElementById('status').value;
            var motivoContainer = document.getElementById('motivo-cancelamento-container');

            console.log("opa");
            
            if (status == '3') { // Status "Cancelar"
                motivoContainer.style.display = 'block';
            } else {
                motivoContainer.style.display = 'none';
            }
        }

        // Chama a função para definir o estado inicial baseado no valor atual
        document.addEventListener('DOMContentLoaded', toggleMotivoCancelamento);


    </script>

    <?php
    // carrega o rodapé
    require_once "comuns/rodape.php";