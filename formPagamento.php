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

        $dados = $db->dbSelect("SELECT * FROM pagamento WHERE id = ?", 'first', [$_GET['id']]);

    }

    $dadosMetodoPagamento = $db->dbSelect("SELECT * FROM metodo_pagamento");

    // if (($_GET['acao'] == "delete") && $dados->SITUACAO_MESA == 2) {
    //     return header("Location: listaMesa.php?msgError=Não é possível excluir uma mesa com comanda em aberto");
    // }

?>

    <div class="page-wrapper mt-4">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Editar Pagamento<?= subTitulo($_GET['acao']) ?></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form class="g-3" action="<?= $_GET['acao'] ?>Pagamento.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="id" id="id" value="<?= isset($dados->id) ? $dados->id : "" ?>">

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="reserva_id">Reserva id <span class="text-danger">*</span></label>
                                <input class="form-control" name="reserva_id" id="reserva_id" type="text" value="<?= isset($dados->reserva_id) ? $dados->reserva_id : "" ?>">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="data_pagamento">Data de pagamento <span class="text-danger">*</span></label>
                                <input class="form-control" name="data_pagamento" id="data_pagamento" type="text" value="<?= isset($dados->data_pagamento) ? $dados->data_pagamento : "" ?>">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="valor_pago">Valor pago <span class="text-danger">*</span></label>
                                <input class="form-control" name="valor_pago" id="valor_pago" type="number" value="<?= isset($dados->valor_pago) ? $dados->valor_pago : "" ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Nova linha para Método de Pagamento e Status do Pagamento -->
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="metodo_pagamento" class="form-label">Método de pagamento</label>
                            <select class="form-control" name="metodo_pagamento" id="metodo_pagamento">
                                <option value="" <?= isset($dados->id) ? ($dados->id == "" ? "selected" : "") : "" ?>>...</option>
                                <?php foreach ($dadosMetodoPagamento as $metodoPagamento): ?>
                                    <option <?= (isset($dados->metodo_pagamento) ? ($dados->metodo_pagamento == $metodoPagamento['id'] ? 'selected' : '') : "") ?> 
                                    value="<?= $metodoPagamento['id'] ?>"><?= $metodoPagamento['nome'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="status_pagamento" class="form-label">Status do Pagamento</label>
                            <select name="status_pagamento" id="status_pagamento" class="form-control" required>
                                <option value="" <?= isset($dados->status_pagamento) ? $dados->status_pagamento == "" ? "selected" : "" : "" ?>>...</option>
                                <option value="1" <?= isset($dados->status_pagamento) ? $dados->status_pagamento == 1 ? "selected" : "" : "" ?>>Pago</option>
                                <option value="2" <?= isset($dados->status_pagamento) ? $dados->status_pagamento == 2 ? "selected" : "" : "" ?>>Pendente</option>
                            </select>
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