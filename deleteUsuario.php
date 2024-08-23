<?php

    require_once "helpers/protectNivel.php";
    // carrega a class do banco de dados
    require_once "library/Database.php";

    // verifica se há um post['id']
    if (isset($_POST['id'])) {

        // $db recebe a conexão com o banco de dados
        $db = new Database();
        // tenta conectar com o banco de dados
        try {
            // tenta executar a query no banco de dados
            $result = $db->dbDelete("DELETE FROM usuario 
                                    WHERE id = ?",
                                    [$_POST['id']]
                                );
            
            if ($result) {
                return header("Location: listaUsuario.php?msgSucesso=Registro excluído com sucesso.");
            } else {
                return header("Location: listaUsuario.php?msgError=Falha ao tentar excluír o registro.");
            }
        
        // se não for possivel conectar com o banco de dados o erro é retornado pelo bloco catch
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }

    // não existe nenhum id de usuário para deletar, redireciona para a página listaUsuario.php
    } else {
        return header("Location: listaUsuario.php");
    }