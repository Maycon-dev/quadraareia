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

        $dados = $db->dbSelect("SELECT * FROM local WHERE id = ?", 'first', [$_GET['id']]);
    }

    // if (($_GET['acao'] == "delete") && $dados->SITUACAO_MESA == 2) {
    //     return header("Location: listaMesa.php?msgError=Não é possível excluir uma mesa com comanda em aberto");
    // }

    $dados_tipo_local = $db->dbSelect("SELECT * FROM tipo_local");

?>

    <div class="page-wrapper mt-4">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Editar Local<?= subTitulo($_GET['acao']) ?></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form class="g-3" action="<?= $_GET['acao'] ?>Local.php" method="POST" 
                    enctype="multipart/form-data">

                    <input type="hidden" name="id" id="id" value="<?= isset($dados->id) ? $dados->id : "" ?>">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nome_local">Nome do local <span class="text-danger">*</span></label>
                                <input class="form-control" name="nome_local" id="nome_local" type="text" value="<?= isset($dados->nome_local) ? $dados->nome_local : "" ?>">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <label for="tipo_local" class="form-label">Tipo do local</label>
                            <select class="form-control" name="tipo_local" id="tipo_local" type="text" value="<?= isset($dados->nome_local) ? $dados->nome_local : "" ?>">
                                <option value=""  <?= isset($dados->id) ? ($dados->id == "" ? "selected" : "") : "" ?>>...</option>
                                <?php foreach ($dados_tipo_local as $tipo_local): ?>
                                    <option <?= (isset($dados->tipo_local) ? ($dados->tipo_local == $tipo_local['id'] ? 'selected' : '') : "") ?> 
                                    value="<?= $tipo_local['id'] ?>"><?= $tipo_local['nome'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="capacidade">Capacidade <span class="text-danger">*</span></label>
                                <input class="form-control" name="capacidade" id="capacidade" type="text" value="<?= isset($dados->capacidade) ? $dados->capacidade : "" ?>">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="descricao">Descrição <span class="text-danger">*</span></label>
                                <input class="form-control" name="descricao" id="descricao" type="text" value="<?= isset($dados->descricao) ? $dados->descricao : "" ?>">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Preço por hora<span class="text-danger">*</span></label>
                                <input class="form-control" name="preco_hora" id="preco_hora" type="text" value="<?= isset($dados->preco_hora) ? $dados->preco_hora : "" ?>">
                            </div>
                        </div>

                        <div class="col-sm-6">
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