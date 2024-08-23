<?php

    // require_once "helpers/protectNivel.php";

    require_once "library/Database.php";

    $db = new Database();

    try {

        $result = $db->dbUpdate("UPDATE horario 
                                SET local_id = ?, dia_semana = ?, hora_inicio = ?, hora_fim = ?, statusRegistro = ?
                                WHERE id = ?",
                                [
                                    $_POST['local_id'],
                                    $_POST['dia_semana'],
                                    $_POST['hora_inicio'],
                                    $_POST['hora_fim'],
                                    $_POST['statusRegistro'],

                                    $_POST['id']
                                ]);

        if ($result) {
            return header("Location: listaHorario.php?msgSucesso=Registro alterado com sucesso.");
        } else {
            return header("Location: listaHorario.php?msgError=Falha ao tentar alterar o registro.");
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }