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
            h.id,
            h.local_id,
            l.nome_local,
            h.dia_semana,
            h.hora_inicio,
            h.hora_fim,
            h.statusRegistro
        FROM 
            horario h
        INNER JOIN 
            local l ON h.local_id = l.id
        WHERE 
            h.id = ?;
        ", 'first', [$_GET['id']]);
        };
  
        $dados_local = $db->dbSelect("SELECT * FROM local");

        // $dados_horario = $db->dbSelect("SELECTs * FROM horario_disponivel WHERE statusRegistro = 1 AND local_id = ?");

    // if (($_GET['acao'] == "delete") && $dados->SITUACAO_MESA == 2) {
    //     return header("Location: listaMesa.php?msgError=Não é possível excluir uma mesa com comanda em aberto");
    // }

?>

    <div class="page-wrapper mt-4">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Editar Horário<?= subTitulo($_GET['acao']) ?></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form class="g-3" action="<?= $_GET['acao'] ?>Horario.php" method="POST" 
                    enctype="multipart/form-data">

                    <input type="hidden" name="id" id="id" value="<?= isset($dados->id) ? $dados->id : "" ?>">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="local_id">Nome do local <span class="text-danger">*</span></label>
                                <select class="form-control" name="local_id" id="local_id" type="text" value="<?= isset($dados->nome_local) ? $dados->nome_local : "" ?>">
                                    <option value=""  <?= isset($dados->id) ? ($dados->id == "" ? "selected" : "") : "" ?>>...</option>
                                    <?php foreach ($dados_local as $local): ?>
                                        <option <?= (isset($dados->local_id) ? ($dados->local_id == $local['id'] ? 'selected' : '') : "") ?> 
                                        value="<?= $local['id'] ?>"><?= $local['nome_local'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="dia_semana" class="form-label">Dia da semana  <span class="text-danger">*</span></label>
                            <select name="dia_semana" id="dia_semana" class="form-control" required>
                                <option value="" <?= isset($dados->dia_semana) ? $dados->dia_semana == "" ? "selected" : "" : "" ?>>...</option>
                                <option value="1" <?= isset($dados->dia_semana) ? $dados->dia_semana == 1 ? "selected" : "" : "" ?>>Domingo</option>
                                <option value="2" <?= isset($dados->dia_semana) ? $dados->dia_semana == 2 ? "selected" : "" : "" ?>>Segunda</option>
                                <option value="3" <?= isset($dados->dia_semana) ? $dados->dia_semana == 3 ? "selected" : "" : "" ?>>Terça</option>
                                <option value="4" <?= isset($dados->dia_semana) ? $dados->dia_semana == 4 ? "selected" : "" : "" ?>>Quarta</option>
                                <option value="5" <?= isset($dados->dia_semana) ? $dados->dia_semana == 5 ? "selected" : "" : "" ?>>Quinta</option>
                                <option value="6" <?= isset($dados->dia_semana) ? $dados->dia_semana == 6 ? "selected" : "" : "" ?>>Sexta</option>
                                <option value="7" <?= isset($dados->dia_semana) ? $dados->dia_semana == 7 ? "selected" : "" : "" ?>>Sábado</option>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="hora_inicio">Hora de inicio: <span class="text-danger">*</span></label>
                                <input class="form-control" name="hora_inicio" id="hora_inicio" type="time" value="<?= isset($dados->hora_inicio) ? date('H:i', strtotime($dados->hora_inicio)) : "" ?>">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="hora_fim">Hora final: <span class="text-danger">*</span></label>
                                <input class="form-control" name="hora_fim" id="hora_fim" type="time" value="<?= isset($dados->hora_fim) ? date('H:i', strtotime($dados->hora_fim)) : "" ?>">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label for="statusRegistro" class="form-label">Status do Registro  <span class="text-danger">*</span></label>
                                <select name="statusRegistro" id="statusRegistro" class="form-control" required>
                                    <option value=""  <?= isset($dados->statusRegistro) ? $dados->statusRegistro == "" ? "selected" : "" : "" ?>>...</option>
                                    <option value="1" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == 1  ? "selected" : "" : "" ?>>Ativo</option>
                                    <option value="2" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == 2  ? "selected" : "" : "" ?>>Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary submit-btn">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        // JS do ckEditor
        ClassicEditor
            .create(document.querySelector('#caracteristicas'))
            .catch( error => {
                console.error(error);
            });

    </script>

    <?php
    // carrega o rodapé
    require_once "comuns/rodape.php";