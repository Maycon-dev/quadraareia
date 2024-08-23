<?php

    // require_once "helpers/protectNivel.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    if (isset($_POST['nome'])) {

        $db = new Database();

        try {

            $result = $db->dbInsert("INSERT INTO tipo_local
                                    (nome, descricao, statusRegistro)
                                    VALUES (?, ?, ?)",
                                    [
                                        $_POST['nome'],
                                        $_POST['descricao'],
                                        $_POST['statusRegistro']
                                        
                                    ]);

            if ($result) {
                return header("Location: listaTipoLocal.php?msgSucesso=Registro inserido com sucesso.");
            } else {
                return header("Location: listaTipoLocal.php?msgError=Falha ao tentar inserir o registro.");
            }
                
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }
        
    } else {
        return header("Location: listaTipoLocal.php");
    }