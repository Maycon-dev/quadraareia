<?php

require_once "helpers/protectNivel.php";
require_once "library/Database.php";

if (isset($_POST['id']) && isset($_POST['usuario']) && isset($_POST['fim']) && isset($_POST['motivo']) && isset($_POST['statusRegistro'])) {

    $db = new Database();

    try {
        // Atualização dos dados na tabela penalidade
        $result = $db->dbUpdate("UPDATE penalidade 
                                SET usuario_id = ?, 
                                    statusRegistro = ?, 
                                    fim = ?, 
                                    motivo = ?
                                WHERE id = ?",
                                [
                                    $_POST['usuario_id'],        // Valor selecionado no campo 'usuario'
                                    $_POST['statusRegistro'], // Status do registro
                                    $_POST['fim'],            // Data final da penalidade
                                    $_POST['motivo'],         // Motivo da penalidade
                                    $_POST['id']              // ID da penalidade a ser atualizada
                                ]);

        if ($result) {
            header("Location: listaPenalidade.php?msgSucesso=Registro atualizado com sucesso.");
            exit; // Certifique-se de encerrar o script após redirecionar
        } else {
            header("Location: listaPenalidade.php?msgError=Falha ao tentar atualizar o registro.");
            exit; // Certifique-se de encerrar o script após redirecionar
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }

} else {
    header("Location: listaPenalidade.php?msgError=Dados incompletos.");
    exit; // Certifique-se de encerrar o script após redirecionar
}
