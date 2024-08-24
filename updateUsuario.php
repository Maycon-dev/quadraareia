<?php

    // require_once "helpers/protectNivel.php";

    require_once "library/Database.php";

    if (isset($_POST['nome'])) {

        $db = new Database();

        try {

            if (!empty($_POST['senha'])) {

                if (trim($_POST['senha']) == trim($_POST['confSenha'])) {

                    $result = $db->dbUpdate("UPDATE usuario 
                                    SET nome = ?, email = ?, statusRegistro = ?, tipo_usuario = ?, senha = ?
                                    WHERE id = ?",
                                    [
                                        $_POST['nome'],
                                        $_POST['email'],
                                        $_POST['statusRegistro'],
                                        $_POST['tipo_usuario'],
                                        password_hash(trim($_POST['senha']), PASSWORD_DEFAULT),
                                        $_POST['id']
                                    ]);

                    if ($result) {
                    return header("Location: listaUsuario.php?msgSucesso=Registro alterado com sucesso.");
                    } else {
                    return header("Location: listaUsuario.php?msgError=Falha ao tentar alterar o registro.");
                    }

                } else {
                    return header("Location: listaUsuario.php?msgError=Senha não confere.");
                }

            } else {

                $result = $db->dbUpdate("UPDATE usuario 
                                        SET nome = ?, email = ?, statusRegistro = ?, tipo_usuario = ?
                                        WHERE id = ?",
                                        [
                                            $_POST['nome'],
                                            $_POST['email'],
                                            $_POST['statusRegistro'],
                                            $_POST['tipo_usuario'],
                                            $_POST['id']
                                        ]);

                if ($result) {
                return header("Location: listaUsuario.php?msgSucesso=Registro alterado com sucesso.");
                } else {
                return header("Location: listaUsuario.php?msgError=Falha ao tentar alterar o registro.");
                }
            }

        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }

    } else {
        return header("Location: listaUsuario.php");
    }