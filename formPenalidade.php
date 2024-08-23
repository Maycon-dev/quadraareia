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

        $dados = $db->dbSelect("SELECT * FROM penalidade WHERE id = ?", 'first', [$_GET['id']]);
    }

    // if (($_GET['acao'] == "delete") && $dados->SITUACAO_MESA == 2) {
    //     return header("Location: listaMesa.php?msgError=Não é possível excluir uma mesa com comanda em aberto");
    // }

?>

    <div class="page-wrapper mt-4">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Editar Penalidade<?= subTitulo($_GET['acao']) ?></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form class="g-3" action="<?= $_GET['acao'] ?>Penalidade.php" method="POST" 
                    enctype="multipart/form-data">

                    <input type="hidden" name="id" id="id" value="<?= isset($dados->id) ? $dados->id : "" ?>">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="usuario_id">Usuário <span class="text-danger">*</span></label>
                                <input class="form-control" name="usuario_id" id="usuario_id" type="text" value="<?= isset($dados->usuario_id) ? $dados->usuario_id : "" ?>">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="faltas">Faltas <span class="text-danger">*</span></label>
                                <input class="form-control" name="faltas" id="faltas" type="text" value="<?= isset($dados->faltas) ? $dados->faltas : "" ?>">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="dias_bloqueio">Dias bloqueado <span class="text-danger">*</span></label>
                                <input class="form-control" name="dias_bloqueio" id="dias_bloqueio" type="number" value="<?= isset($dados->dias_bloqueio) ? $dados->dias_bloqueio : "" ?>">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="bloqueado_ate" class="form-label">Bloqueado até a data</label>
                            <label for="descricao">Descrição <span class="text-danger">*</span></label>
                                <input class="form-control" name="bloqueado_ate" id="bloqueado_ate" type="date" value="<?= isset($dados->bloqueado_ate) ? $dados->bloqueado_ate : "" ?>">
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Criado em <span class="text-danger">*</span></label>
                                <input class="form-control" name="criado_em" id="criado_em" type="text" value="<?= isset($dados->criado_em) ? $dados->criado_em : "" ?>" disabled>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Atualizado em <span class="text-danger">*</span></label>
                                <input class="form-control" name="atualizado_em" id="atualizado_em" type="text" value="<?= isset($dados->atualizado_em) ? $dados->atualizado_em : "" ?>" disabled>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label for="statusRegistro" class="form-label">Status do Registro</label>
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