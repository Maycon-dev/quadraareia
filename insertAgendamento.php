<?php

    require_once "helpers/Formulario.php";
    require_once "library/Database.php";

    session_start();

    $db = new Database();
    $dados_horario = $db->dbSelect("SELECT * FROM horario_disponivel WHERE id = ?", 'first', [$_POST['horario_id']]);

    // Captura dos dados do formulário
    $usuario_id = isset($_SESSION['userId']) ? $_SESSION['userId'] : NULL;
    $cpf = preg_replace("/[^0-9]/", "", $_POST['cpf']);
    $telefone = preg_replace("/[^0-9]/", "", $_POST['telefone']);
    $local_id = $_POST['local_id'];
    $tipo_pagamento = $_POST['tipo_pagamento'];
    $data_hora_inicio = $dados_horario->hora_inicio;
    $data_hora_fim = $dados_horario->hora_fim;
    $status = 1; // Inicialmente, o status pode ser "pendente"
    $valor = $db->dbSelect("SELECT preco_hora FROM local WHERE id = ?", 'first', [$local_id])->preco_hora;

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (!empty($cpf) && !empty($telefone) && !empty($local_id) && !empty($data_hora_inicio) && !empty($data_hora_fim)) {
        // Insere a reserva
        $reserva = $db->dbInsert("INSERT INTO reserva (usuario_id, cpf, telefone, local_id, horario_id, data_hora_inicio, data_hora_fim, status, valor_total) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", 
        [$usuario_id, $cpf, $telefone, $local_id, $_POST['horario_id'], $data_hora_inicio, $data_hora_fim, $status, $valor]);

        if($reserva) {
            // Atualiza o status do horário para inativo
            $inativaHorario = $db->dbUpdate("UPDATE horario_disponivel SET statusRegistro = 2 WHERE id = ?", [$_POST['horario_id']]);

            if($inativaHorario) {
                // Registra o pagamento
                $id_reserva = $db->dbSelect("SELECT id FROM reserva ORDER BY id DESC LIMIT 1", 'first');
                // $db->dbInsert("INSERT INTO pagamento (id_reserva, valor_pago, metodo_pagamento) VALUES (?, ?, ?)", [$id_reserva->id, $valor, $tipo_pagamento]);

                return header("Location: agendamento.php?msgSucesso=Agendamento inserido com sucesso.&acao=insert");
                exit;
            }
        }

        return header("Location: agendamento.php?msgError=Erro ao inserir registro.&acao=insert");
        exit;
    } else {
        echo "Por favor, preencha todos os campos obrigatórios!";
    }

?>
