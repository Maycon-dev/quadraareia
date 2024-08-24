<?php

    require_once "helpers/Formulario.php";
    require_once "library/Database.php";

    session_start();

    $db = new Database();
    $dados = [];

    $dados_horario = $db->dbSelect("SELECT * FROM horario_disponivel WHERE id = ?", 'first', [$_POST['horario_id']]);

    // Captura dos dados do formulário
    $usuario_id = isset($_SESSION['userId']) ? $_SESSION['userId'] : NULL;
    $cpf = preg_replace("/[^0-9]/", "", $_POST['cpf']);
    $telefone = preg_replace("/[^0-9]/", "", $_POST['telefone']);

    $local_id = $_POST['local_id'];
    $preco_hora_local = $db->dbSelect("SELECT preco_hora FROM local WHERE id = ?", 'first', [$local_id]);

    $tipo_pagamento = $_POST['tipo_pagamento'];

    // var_dump($usuario_id);
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
        $reserva = $db->dbInsert("INSERT INTO reserva (usuario_id, cpf, telefone, local_id, data_hora_inicio, data_hora_fim, status, valor)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$usuario_id, $cpf, $telefone, $local_id, $data_hora_inicio, $data_hora_fim, $status, $valor]);

        if($reserva) {
            $inativaHorario = $db->dbUpdate("UPDATE horario_disponivel SET statusRegistro = ? WHERE id = ?"
            , [2, $_POST['horario_id']]);
        }

        if($reserva && $inativaHorario) {

            $id_reserva = $db->dbSelect("SELECT id FROM reserva ORDER BY id DESC LIMIT 1", 'first');

            // Executa a query
            $pagamento = $db->dbInsert("INSERT INTO pagamento (reserva_id, valor_pago, metodo_pagamento) VALUES (?, ?, ?)", [$id_reserva->id, $valor, $tipo_pagamento]);

            return header("Location: agendamento.php?msgSucesso=Agendamento inserido com sucesso.&acao=insert");
            exit;
        } else {
            return header("Location: agendamento.php?msgError=Erro ao inserir registro.&acao=insert");
            exit;
        }


    } else {
        // Exibe mensagem de erro caso algum campo obrigatório esteja vazio
        echo "Por favor, preencha todos os campos obrigatórios!";
    }

    require_once "comuns/rodape.php";
?>
