<?php

    // require_once "helpers/protectNivel.php";

    require_once "library/Database.php";

    $db = new Database();



    try {

        $result = $db->dbUpdate("UPDATE reserva 
                                SET motivo_cancelamento = ?, status = ?
                                WHERE id = ?",
                                [
                                    $_POST['motivo_cancelamento'],
                                    $_POST['status'],

                                    $_POST['id']
                                ]);

        if ($result) { 
            if($_POST['status'] == '3') {
                $disponibiliza_horario = $db->dbUpdate("UPDATE horario_disponivel SET statusRegistro = ? WHERE id = ?", [1, $_POST['horario_id']]);

                $cpf = $_POST['cpf'];

                $dado_penalidade = $db->dbSelect("SELECT faltas FROM penalidade WHERE cpf = ?",'first', [$cpf]);

                if (!$dado_penalidade) {
                    $soma_faltas = $db->dbUpdate("INSERT INTO penalidade SET statusRegistro = ?, faltas = ?, cpf = ?", [2, 1, $cpf]);
                } else {

                    $falta_penalidade = $dado_penalidade->faltas + 1;

                    // condicao para se as faltas forem maior do que o numero configurado aplicar penalidade

                    $atualiza_soma_faltas = $db->dbUpdate("UPDATE penalidade SET statusRegistro = ?, faltas = ? WHERE cpf = ?", [1, $falta_penalidade, $cpf]);
                }

            }

            if($_POST['status'] == '2') {
                $disponibiliza_horario = $db->dbUpdate("UPDATE horario_disponivel SET statusRegistro = ? WHERE id = ?", [2, $_POST['horario_id']]);
            }
            return header("Location: listaAgendamento.php?msgSucesso=Registro alterado com sucesso.");
        } else {
            return header("Location: formAgendamento.php?msgError=Falha ao tentar alterar o registro.&id=" . $_POST['id']);
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }