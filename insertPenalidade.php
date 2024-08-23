<?php

    // require_once "helpers/protectNivel.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    if (isset($_POST['usuario_id'])) {

        $db = new Database();

        try {

            $result = $db->dbInsert("INSERT INTO penalidade
                                    (usuario_id, faltas, dias_bloqueio, bloqueado_ate, statusRegistro)
                                    VALUES (?, ?, ?, ?, ?)",
                                    [
                                        $_POST['usuario_id'],
                                        $_POST['faltas'],
                                        $_POST['dias_bloqueio'],
                                        $_POST['bloqueado_ate'],
                                        $_POST['statusRegistro'],
                                    ]);

            if ($result) {
                return header("Location: listaPenalidade.php?msgSucesso=Registro inserido com sucesso.");
            } else {
                return header("Location: listaPenalidade.php?msgError=Falha ao tentar inserir o registro.");
            }
                
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }
        
    } else {
        return header("Location: listaPenalidade.php");
    }