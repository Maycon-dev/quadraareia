<?php

    require_once "helpers/protectNivel.php";
    // carrega o formulário
    require_once "helpers/Formulario.php";
    // carrega o cabecalho
    require_once "comuns/cabecalho.php";
    //carrega a classe de concexão com o banco de dados
    require_once "library/Database.php";
    // carrega as funções
    require_once "library/Funcoes.php";

    // verifica se o usuario está logado
    if (!Funcoes::userLogado()) {
        return header("Location: index.php");
    }

    // $db recebe a conexão com o banco de dados
    $db = new Database();
    // cria um array vazio $dados
    $dados = [];

    // verifica se a ação é diferente de insert, se sim faz uma consulta no banco de dados
    if ($_GET['acao'] != "insert") {

        $dados = $db->dbSelect("SELECT * FROM usuario WHERE id = ?", 'first', [$_GET['id']]);

    };
?>

    <!-- inicio da  página -->
    <main class="container mt-5">

        <div class="row">
            <div class="col-10">
                <h2>Usuário<?= subTitulo($_GET['acao']) ?></h2>
            </div>
            <div class="col-2 text-end">
                <a href="listaUsuario.php" class="btn btn-outline-secondary btn-sm" title="Voltar">Voltar</a>
            </div>

        </div>

        <!--
            action => recebe a ação que foi adicionada no hyperlink da lista (insert, update, delete) mais Uf.php
        -->

        <!-- formulário que direciona para a página de acordo com o que o usuário estiver fazendo, insert, update, delete -->
        <form class="g-3" action="<?= $_GET['acao'] ?>Usuario.php" method="POST">

            <!-- input hidden verifica se em $dados  existe algum id e se sim recupera esse id, se não retorna vazio -->
            <input type="hidden" name="id" id="id" value="<?= isset($dados->id) ? $dados->id : "" ?>">

            <div class="row">

                <div class="col-8">
                    <label for="nome" class="form-label">Nome</label>
                    <!-- recupera o nome em $dados e se não houver retorna vázio -->
                    <input type="text" class="form-control" name="nome" id="nome" 
                        placeholder="Nome do usuário" required autofocus
                        value="<?= isset($dados->nome) ? $dados->nome : "" ?>">
                </div>

                <div class="col-8">
                    <label for="cpf" class="form-label">Cpf</label>
                    <!-- recupera o cpf em $dados e se não houver retorna vázio -->
                    <input type="text" class="form-control" name="cpf" id="cpf" 
                        placeholder="cpf do usuário" required autofocus
                        value="<?= isset($dados->cpf) ? $dados->cpf : "" ?>">
                </div>

                <div class="col-8">
                    <label for="tipo_usuario" class="form-label">Tipo de usuário</label>
                    <!-- recupera o tipo_usuario em $dados e se não houver retorna vázio -->
                    <input type="text" class="form-control" name="tipo_usuario" id="tipo_usuario" 
                        placeholder="tipo_usuario do usuário" required autofocus
                        value="<?= isset($dados->tipo_usuario) ? $dados->tipo_usuario : "" ?>">
                </div>

                <div class="col-4">
                    <label for="nivel" class="form-label">Nível</label>
                    <!-- verifica se há algum nivel em $daos e se houver ele retorna e seleciona, se não ele retorna vazio -->
                    <select name="nivel" id="nivel" class="form-control" required>
                        <option value=""  <?= isset($dados->nivel) ? $dados->nivel == "" ? "selected" : "" : "" ?>>...</option>
                        <option value="1" <?= isset($dados->nivel) ? $dados->nivel == 1  ? "selected" : "" : "" ?>>Administrador</option>
                        <option value="2" <?= isset($dados->nivel) ? $dados->nivel == 2  ? "selected" : "" : "" ?>>Garçom</option>
                    </select>
                </div>
            </div>

            <div class="row mt-3">

                <div class="col-8">
                    <label for="email" class="form-label">E-mail/Login</label>
                    <!-- verifica se há um email em dados e retorna se houver, se não houver retorna vázio -->
                    <input type="email" class="form-control" name="email" 
                        id="email" placeholder="email" required
                        value="<?= isset($dados->email) ? $dados->email : "" ?>">
                </div>

                <div class="col-4">
                    <label for="statusRegistro" class="form-label">Status</label>
                    <!-- verifica se há um statusRegistro em $dados se sim retorna e seleciona e se não retorna vázio -->
                    <select name="statusRegistro" id="statusRegistro" class="form-control" required>
                        <option value=""  <?= isset($dados->statusRegistro) ? $dados->statusRegistro == "" ? "selected" : "" : "" ?>>...</option>
                        <option value="1" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == 1  ? "selected" : "" : "" ?>>Ativo</option>
                        <option value="2" <?= isset($dados->statusRegistro) ? $dados->statusRegistro == 2  ? "selected" : "" : "" ?>>Inativo</option>
                    </select>
                </div>

            </div>

            <!-- atualizar a senha ou criar a senha para aquele usuário -->
            <div class="row mt-3">

                <div class="col-6">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" name="senha" id="senha"  maxlength="250"
                        placeholder="Senha">
                </div>

                <div class="col-6">
                    <label for="confSenha" class="form-label">Confere Nova Senha</label>
                    <input type="password" class="form-control" name="confSenha" id="confSenha"  maxlength="250"
                        placeholder="Confere senha">
                </div>

            </div>

            <div class="col-auto mt-5">
                <a href="listaUsuario.php" class="btn btn-outline-secondary btn-sm">Voltar</a>
                
                <?php if ($_GET['acao'] != "view"): /* botão gravar não é exibido na visualização dos dados */ ?>
                    <button type="submit" class="btn btn-primary btn-sm">Gravar</button>
                <?php endif; ?>
            </div>
        </form>

    </main>

    <?php
    
        // carrega o rodapé da página
        require_once "comuns/rodape.php";