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

        $dados = $db->dbSelect("SELECT * FROM metodo_pagamento WHERE id = ?", 'first', [$_GET['id']]);

    }

    // if (($_GET['acao'] == "delete") && $dados->SITUACAO_MESA == 2) {
    //     return header("Location: listaMesa.php?msgError=Não é possível excluir uma mesa com comanda em aberto");
    // }

?>

    <div class="page-wrapper mt-4">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Editar Metodo de pagamento<?= subTitulo($_GET['acao']) ?></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form class="g-3" action="<?= $_GET['acao'] ?>MetodoPagamento.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="id" id="id" value="<?= isset($dados->id) ? $dados->id : "" ?>">

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nome">Nome <span class="text-danger">*</span></label>
                                <input class="form-control" name="nome" id="nome" type="text" value="<?= isset($dados->nome) ? $dados->nome : "" ?>">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="descricao">Descrição <span class="text-danger">*</span></label>
                                <input class="form-control" name="descricao" id="descricao" type="text" value="<?= isset($dados->descricao) ? $dados->descricao : "" ?>">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label for="statusRegistro" class="form-label">Status do Registro</label>
                            <select name="statusRegistro" id="statusRegistro" class="form-control" required>
                                <option value="" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == "" ? "selected" : "" : "" ?>>...</option>
                                <option value="1" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == 1 ? "selected" : "" : "" ?>>Ativo</option>
                                <option value="2" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == 2 ? "selected" : "" : "" ?>>Inativo</option>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="criado_em">Criado em <span class="text-danger">*</span></label>
                                <input class="form-control" name="criado_em" id="criado_em" type="text" value="<?= isset($dados->criado_em) ? $dados->criado_em : "" ?>" disabled>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="atualizado_em">Atualizado em <span class="text-danger">*</span></label>
                                <input class="form-control" name="atualizado_em" id="atualizado_em" type="text" value="<?= isset($dados->atualizado_em) ? $dados->atualizado_em : "" ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Salvar</button>
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