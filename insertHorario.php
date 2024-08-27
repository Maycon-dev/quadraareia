<?php

    // require_once "helpers/protectNivel.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    if (isset($_POST['local_id'])) {

        $db = new Database();

        try {

            // Conexão ao banco de dados
            require_once "library/Database.php";
            $db = new Database();   

            $intervalo_dias = $db->dbSelect("SELECT intervalo_dias FROM configuracoes_intervalo", "first");

            var_dump($_POST, $intervalo_dias->intervalo_dias);
            exit;

            // Configuração do intervalo de dias e horários
            $intervaloDias = 7;
            $horaInicio = "08:00:00";
            $horaFim = "09:00:00";

            // // Apagar os horários antigos
            // $sqlDelete = "DELETE FROM horarios WHERE dia < CURDATE()";
            // $db->dbDelete($sqlDelete);

            // Data atual
            $dataAtual = new DateTime();

            // Loop para adicionar os horários dos próximos 7 dias
            for ($i = 0; $i < $intervaloDias; $i++) {
                // Calcula o dia específico
                $dia = clone $dataAtual;
                $dia->modify("+$i days");
                $diaFormatada = $dia->format('Y-m-d');
                
                // Inserir horário no banco de dados
                $sql = "INSERT INTO horarios (dia, hora_inicio, hora_fim) VALUES (:dia, :hora_inicio, :hora_fim)";
                $params = [
                    ':dia' => $diaFormatada,
                    ':hora_inicio' => $horaInicio,
                    ':hora_fim' => $horaFim,
                ];
                $db->dbInsert($sql, $params);
            }

            // Mensagem de sucesso
            echo "Horários atualizados com sucesso!";



            $result = $db->dbInsert("INSERT INTO horario_disponivel
                                    (local_id, dia_semana, hora_inicio, hora_fim, statusRegistro)
                                    VALUES (?, ?, ?, ?, ?)",
                                    [
                                        $_POST['local_id'],
                                        $_POST['dia_semana'],
                                        $_POST['hora_inicio'],
                                        $_POST['hora_fim'],
                                        $_POST['statusRegistro']
                                    ]);

            if ($result) {
                return header("Location: listaHorario.php?msgSucesso=Registro inserido com sucesso.");
            } else {
                return header("Location: listaHorario.php?msgError=Falha ao tentar inserir o registro.");
            }
                
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }
        
    } else {
        return header("Location: listaHorario.php");
    }