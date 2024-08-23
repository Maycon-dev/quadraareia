<?php

    // require_once "helpers/protectNivel.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    if (isset($_POST['local_id'])) {

        $db = new Database();

        try {

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