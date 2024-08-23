<?php

    require_once "helpers/Formulario.php";
    require_once "library/Database.php";

    $db = new Database();
    $dados = [];

    $dados_horario = $db->dbSelect("SELECT * FROM horario_disponivel WHERE id = ?", 'first', [$_POST['horario_id']]);

    // Captura dos dados do formulário
    $usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : NULL;
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];

    $local_id = $_POST['local_id'];
    $preco_hora_local = $db->dbSelect("SELECT preco_hora FROM local WHERE id = ?", 'first', [$local_id]);

    // var_dump($_POST);
    // exit;

    $data_hora_inicio =  $dados_horario->hora_inicio;
    $data_hora_fim = $dados_horario->hora_fim; // Data e hora de fim da reserva
    $status = 1; // Inicialmente, o status pode ser "pendente"
    $valor = $preco_hora_local->preco_hora; // Valor da reserva

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (!empty($cpf) && !empty($telefone) && !empty($local_id) && !empty($data_hora_inicio) && !empty($data_hora_fim)) {
        // Monta a query de inserção
        $query = "";

        // Executa a query
        $db->dbInsert("INSERT INTO reserva (usuario_id, cpf, telefone, local_id, data_hora_inicio, data_hora_fim, status, valor)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$usuario_id, $cpf, $telefone, $local_id, $data_hora_inicio, $data_hora_fim, $status, $valor]);

        // Redireciona para uma página de sucesso ou exibe uma mensagem
        return header("Location: agendamento.php?msgSucesso=Agendamento inserido com sucesso.&acao=insert");
        exit;
    } else {
        // Exibe mensagem de erro caso algum campo obrigatório esteja vazio
        echo "Por favor, preencha todos os campos obrigatórios!";
    }

    require_once "comuns/rodape.php";
?>
