<?php

require_once "helpers/protectNivel.php";
require_once "library/Database.php";

if (isset($_POST['usuario']) && isset($_POST['fim']) && isset($_POST['motivo']) && isset($_POST['statusRegistro'])) {

    $db = new Database();

    try {
        // Inserção de dados na tabela penalidade
        $result = $db->dbInsert("INSERT INTO penalidade 
                                (usuario_id, statusRegistro, inicio, fim, motivo)
                                VALUES (?, ?, NOW(), ?, ?)",
                                [
                                    $_POST['usuario'],        // Valor selecionado no campo 'usuario'
                                    $_POST['statusRegistro'], // Status do registro
                                    $_POST['fim'],            // Data final da penalidade
                                    $_POST['motivo']          // Motivo da penalidade
                                ]);

        if ($result) {
            header("Location: listaPenalidade.php?msgSucesso=Registro inserido com sucesso.");
            exit; // Certifique-se de encerrar o script após redirecionar
        } else {
            header("Location: listaPenalidade.php?msgError=Falha ao tentar inserir o registro.");
            exit; // Certifique-se de encerrar o script após redirecionar
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }

} else {
    header("Location: listaPenalidade.php?msgError=Dados incompletos.");
    exit; // Certifique-se de encerrar o script após redirecionar
}
