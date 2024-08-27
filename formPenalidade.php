<?php

    require_once "helpers/Formulario.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    $db = new Database();
    $dados = [];


    if ($_GET['acao'] != "insert") {

        $dados = $db->dbSelect("SELECT * FROM penalidade WHERE id = ?", 'first', [$_GET['id']]);
    }


    $dados_usuarios = $db->dbSelect("SELECT * FROM usuario_formatado");

?>

<div class="page-wrapper mt-4">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h4 class="page-title">Penalidade<?= subTitulo($_GET['acao']) ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <form class="g-3" action="<?= $_GET['acao'] ?>Penalidade.php" method="POST" 
                enctype="multipart/form-data">

                <input type="hidden" name="id" id="id" value="<?= isset($dados->id) ? $dados->id : "" ?>">

                <div class="row">

                <div class="col-sm-10">
                    <label for="usuario" class="form-label">Usuário</label>
                    <select class="form-control" name="usuario" id="usuario">
                        <option value="" <?= !isset($dados->usuario_id) || empty($dados->usuario_id) ? "selected" : "" ?>>Selecione um usuário</option>
                        <?php foreach ($dados_usuarios as $usuario): ?>
                            <option value="<?= $usuario['id'] ?>" <?= isset($dados->usuario_id) && $dados->usuario_id == $usuario['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($usuario['usu']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                    <div class="col-sm-2">
                        <label for="statusRegistro" class="form-label">Status do Registro</label>
                        <select name="statusRegistro" id="statusRegistro" class="form-control" required>
                            <option value=""  <?= isset($dados->statusRegistro) ? $dados->statusRegistro == "" ? "selected" : "" : "" ?>>...</option>
                            <option value="1" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == 1  ? "selected" : "" : "" ?>>Ativo</option>
                            <option value="2" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == 2  ? "selected" : "" : "" ?>>Inativo</option>
                        </select>
                    </div>

                    <div class="col-sm-4 mt-3">
                        <div class="form-group">
                            <label>Ínicio da Penalidade</label>
                            <input class="form-control" name="inicio" id="inicio" type="text" value="<?= isset($dados->inicio) ? $dados->inicio : "" ?>" disabled>
                        </div>
                    </div>
                    
                    <div class="col-sm-2 mt-3">
                        <div class="form-group">
                            <label for="dias_bloqueio">Dias</label>
                            <input class="form-control" name="dias_bloqueio" id="dias_bloqueio" type="number" value="<?= isset($dados->dias_bloqueio) ? $dados->dias_bloqueio : "" ?>">
                        </div>
                    </div>

                    <div class="col-sm-6 mt-3">
                        <label for="fim" class="form-label">Último dia da penalidade</label>
                            <input class="form-control" name="fim" id="fim" type="date" value="<?= isset($dados->fim) ? $dados->fim : "" ?>">
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="motivo">Motivo</label>
                            <textarea class="form-control" name="motivo" id="motivo" rows="3"><?= isset($dados->motivo) ? htmlspecialchars($dados->motivo) : "" ?></textarea>
                        </div>
                    </div>


                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button class="btn btn-primary submit-btn">Salvar</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const diasBloqueioInput = document.getElementById('dias_bloqueio');
        const bloqueadoAteInput = document.getElementById('fim');
        const inicioInput = document.getElementById('inicio');

        // Função para adicionar dias a uma data
        function adicionarDias(data, dias) {
            let resultado = new Date(data);
            resultado.setDate(resultado.getDate() + dias);
            return resultado.toISOString().split('T')[0];
        }

        // Atualiza o campo "Bloqueado até a data" quando o número de dias é alterado
        diasBloqueioInput.addEventListener('input', function() {
            const diasBloqueio = parseInt(diasBloqueioInput.value, 10);
            if (!isNaN(diasBloqueio)) {
                const criadoEmValor = inicioInput.value;
                if (criadoEmValor) {
                    const criadoEm = new Date(criadoEmValor);
                    const novaData = adicionarDias(criadoEm, diasBloqueio);
                    bloqueadoAteInput.value = novaData;
                }
            } else {
                bloqueadoAteInput.value = ''; // Limpa o campo se o valor não for um número
            }
        });

        // Atualiza o campo "Dias bloqueado" quando a data final é alterada
        bloqueadoAteInput.addEventListener('input', function() {
            const dataFinal = new Date(bloqueadoAteInput.value);
            const criadoEmValor = inicioInput.value;
            if (criadoEmValor && !isNaN(dataFinal)) {
                const criadoEm = new Date(criadoEmValor);
                const diferenca = Math.ceil((dataFinal - criadoEm) / (1000 * 60 * 60 * 24));
                diasBloqueioInput.value = diferenca;
            }
        });

        // Inicializa o campo "Criado em" com a data atual se estiver vazio
        if (!inicioInput.value) {
            inicioInput.value = new Date().toISOString().split('T')[0];
        }
    });
</script>


<?php
// carrega o rodapé
require_once "comuns/rodape.php";
?>
