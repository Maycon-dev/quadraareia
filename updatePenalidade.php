<?php

    // require_once "helpers/protectNivel.php";

    require_once "library/Database.php";

    $db = new Database();

    try {

        $result = $db->dbUpdate("UPDATE penalidade 
                                SET usuario_id = ?, faltas = ?, dias_bloqueio = ?, bloqueado_ate = ?, statusRegistro = ?
                                WHERE id = ?",
                                [
                                    $_POST['usuario_id'],
                                    $_POST['faltas'],
                                    $_POST['dias_bloqueio'],
                                    $_POST['bloqueado_ate'],
                                    $_POST['statusRegistro'],

                                    $_POST['id']
                                ]);

        if ($result) {
            return header("Location: listaPenalidade.php?msgSucesso=Registro alterado com sucesso.");
        } else {
            return header("Location: listaPenalidade.php?msgError=Falha ao tentar alterar o registro.");
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }