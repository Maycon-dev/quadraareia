<?php

    // require_once "helpers/protectNivel.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    if (isset($_POST['nome_local'])) {

        $db = new Database();

        try {

            $result = $db->dbInsert("INSERT INTO local
                                    (nome_local, tipo_local, capacidade, descricao, preco_hora, statusRegistro)
                                    VALUES (?, ?, ?, ?, ?, ?)",
                                    [
                                        $_POST['nome_local'],
                                        $_POST['tipo_local'],
                                        $_POST['capacidade'],
                                        $_POST['descricao'],
                                        $_POST['preco_hora'],
                                        $_POST['statusRegistro']
                                    ]);

            if ($result) {
                return header("Location: listaLocal.php?msgSucesso=Registro inserido com sucesso.");
            } else {
                return header("Location: listaLocal.php?msgError=Falha ao tentar inserir o registro.");
            }
                
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }
        
    } else {
        return header("Location: listaLocal.php");
    }