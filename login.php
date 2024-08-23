<?php

    session_start();

    require_once "library/Database.php";

    if (isset($_POST['email'])) {

        // Criando o objeto Db para classe de base de dados
        $db = new Database();

        // Buscar a lista de Produtos

        $data = $db->dbSelect("SELECT * FROM usuario WHERE email = ?", 'first', [$_POST['email']]);

        if ($data === false) {  // Base de dados sem usuários cadastrados

            $data = $db->dbSelect("SELECT * FROM usuario", 'count');

            if ($data == 0) {
                // Criar super user
                $result = $db->dbInsert("INSERT INTO usuario 
                                        (tipo_usuario, statusRegistro, nome, senha, email, cpf)
                                        VALUES (?, ?, ?, ?, ?, ?)",
                                        [
                                            1,
                                            1,
                                            "Administrador",
                                            password_hash("admin", PASSWORD_DEFAULT),
                                            "sistemaagenda@gmail.com",
                                            "09068489512"
                                        ]);

                return header("Location: index.php?msgSucesso=Super usuário criado com sucesso.");

            } else {
                return header("Location: index.php?msgError=Login ou senha inválido");
            }

        } else {

            // verifica o status do usuário
            if ($data->statusRegistro != 1) {
                return header("Location: index.php?msgError=Usuário bloqueado, favor entrar em contato com o Administrador.");
            }

            // Verifica a senha
            if (!password_verify(trim($_POST["senha"]), $data->senha) ) {
                return header("Location: index.php?msgError=Login ou senha inválido");
            }

            //  Criar flag's de usuário logado no sistema
            $_SESSION["userId"]     = $data->id;
            $_SESSION["userNome"]   = $data->nome;
            $_SESSION["userEmail"]  = $data->email;
            $_SESSION["userNivel"]  = $data->nivel;
            $_SESSION["userSenha"]  = $data->senha;
            
            // Direcionar o usuário para página home
            return header("Location: index.php");
        }

    } else {
        return header("Location: index.php");
    }

    require_once "comuns/cabecalho.php";

?>
