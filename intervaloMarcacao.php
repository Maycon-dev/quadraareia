<?php

    require_once "helpers/Formulario.php";
    require_once "library/Database.php";
    require_once "comuns/cabecalho.php";
    require_once "library/Funcoes.php";

    $db = new Database();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $intervalo_dias = (int)$_POST['intervalo_dias'];
        
        // Obter a data atual
        $data_hoje = date('Y-m-d');

        // Atualizar configuração de intervalo
        $intervalo_inserido = $db->dbInsert("INSERT INTO configuracoes_intervalo (intervalo_dias, data_ultima_atualizacao) VALUES (?, ?)
                    ON DUPLICATE KEY UPDATE intervalo_dias = VALUES(intervalo_dias), data_ultima_atualizacao = VALUES(data_ultima_atualizacao)",
                    [$intervalo_dias, $data_hoje]);

        if($intervalo_inserido) {
            return ("Location: intervaloMarcacao.php?msgSucesso=Configuração de intervalo atualizada com sucesso!");
        } else {
            return ("Location: intervaloMarcacao.php?msgError=Falha ao tentar inserir o registro.");

        }
    }

    // Obter o último registro baseado no maior ID
    $dados = $db->dbSelect("SELECT intervalo_dias, data_ultima_atualizacao FROM configuracoes_intervalo ORDER BY id DESC LIMIT 1", 'first');

?>

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

<div class="page-wrapper">
    <div class="container" style="margin-top: 100px;">
        <h4>Configurar Intervalo de Horários</h4>
        <form method="POST">
            <div class="form-group">
                <label for="intervalo_dias">Número de Dias:</label>
                <input type="number" class="form-control" id="intervalo_dias" name="intervalo_dias" min="1" value="<?= isset($dados->intervalo_dias) ? $dados->intervalo_dias : '' ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>

<?php
    require_once "comuns/rodape.php";
?>
