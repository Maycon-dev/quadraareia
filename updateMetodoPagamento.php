<?php

    // require_once "helpers/protectNivel.php";

    require_once "library/Database.php";

    $db = new Database();

    try {

        $result = $db->dbUpdate("UPDATE metodo_pagamento 
                                SET nome = ?, descricao = ?, statusRegistro = ?
                                WHERE id = ?",
                                [
                                    $_POST['nome'],
                                    $_POST['descricao'],
                                    $_POST['statusRegistro'],

                                    $_POST['id']
                                ]);

        if ($result) {
            return header("Location: listaMetodoPagamento.php?msgSucesso=Registro alterado com sucesso.");
        } else {
            return header("Location: listaMetodoPagamento.php?msgError=Falha ao tentar alterar o registro.");
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }