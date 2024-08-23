<?php

    // require_once "helpers/protectNivel.php";

    require_once "library/Database.php";

    $db = new Database();

    try {

        $result = $db->dbUpdate("UPDATE local 
                                SET nome_local = ?, tipo_local = ?, capacidade = ?, descricao = ?, preco_hora = ?, statusRegistro = ?
                                WHERE id = ?",
                                [
                                    $_POST['nome_local'],
                                    $_POST['tipo_local'],
                                    $_POST['capacidade'],
                                    $_POST['descricao'],
                                    $_POST['preco_hora'],
                                    $_POST['statusRegistro'],

                                    $_POST['id']
                                ]);

        if ($result) {
            return header("Location: listaLocal.php?msgSucesso=Registro alterado com sucesso.");
        } else {
            return header("Location: listaLocal.php?msgError=Falha ao tentar alterar o registro.");
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }