<?php

require_once "helpers/Formulario.php";
require_once "library/Database.php";
require_once "comuns/cabecalho.php";
require_once "library/Funcoes.php";

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = (int)$_POST['valor'];
    $nome_configuracao = $_POST['nome_configuracao'];

    // Verifica se já existe um registro na tabela
    $existe_configuracao = $db->dbSelect("SELECT COUNT(*) as count FROM configuracao", 'first');

    if ($existe_configuracao->count > 0) {
        // Se já existir um registro, atualiza o valor e o nome
        $intervalo_atualizado = $db->dbInsert(
            "UPDATE configuracao SET nome_configuracao = ?, valor = ?",
            [$nome_configuracao, $valor]
        );

        if($intervalo_atualizado) {
            header("Location: listaPenalidade.php?msgSucesso=Configuração de intervalo atualizada com sucesso!");
        } else {
            header("Location: listaPenalidade.php?msgError=Falha ao tentar atualizar o registro.");
        }
    } else {
        // Se não existir, insere um novo registro
        $intervalo_inserido = $db->dbInsert(
            "INSERT INTO configuracao (nome_configuracao, valor) VALUES (?, ?)",
            [$nome_configuracao, $valor]
        );

        if($intervalo_inserido) {
            header("Location: listaPenalidade.php?msgSucesso=Configuração de intervalo inserida com sucesso!");
        } else {
            header("Location: listaPenalidade.php?msgError=Falha ao tentar inserir o registro.");
        }
    }

    exit; // Finaliza o script para garantir que o redirecionamento ocorra imediatamente.
}

// Obter o último registro baseado no maior ID
$dados = $db->dbSelect("SELECT nome_configuracao, valor FROM configuracao ORDER BY id DESC LIMIT 1", 'first');

?>

<!-- <div class="row">
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
</div> -->

<div class="page-wrapper">
    <div class="container" style="margin-top: 100px;">
        <h4>Configurar Intervalo de Horários</h4>
        <form method="POST">
            <div class="form-group">
                <label for="nome_configuracao">Nome configuração:</label>
                <input type="text" class="form-control" id="nome_configuracao" name="nome_configuracao" value="<?= isset($dados->nome_configuracao) ? $dados->nome_configuracao : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="valor">Número de Dias:</label>
                <input type="number" class="form-control" id="valor" name="valor" min="1" value="<?= isset($dados->valor) ? $dados->valor : '' ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>

<?php
    require_once "comuns/rodape.php";
?>
