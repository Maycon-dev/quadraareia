<?php

    // require_once "helpers/protectNivel.php";
    require_once "library/Database.php";
    require_once "library/Funcoes.php";

    if (isset($_POST['reserva_id'])) {

        $db = new Database();

        try {

            $result = $db->dbInsert("INSERT INTO pagamento
                                    (reserva_id, data_pagamento, valor_pago, metodo_pagamento, statusPagamento)
                                    VALUES (?, ?, ?, ?, ?)",
                                    [
                                        $_POST['reserva_id'],
                                        $_POST['data_pagamento'],
                                        $_POST['valor_pago'],
                                        $_POST['metodo_pagamento'],
                                        $_POST['statusPagamento']
                                    ]);

            if ($result) {
                return header("Location: listaPagamento.php?msgSucesso=Registro inserido com sucesso.");
            } else {
                return header("Location: listaPagamento.php?msgError=Falha ao tentar inserir o registro.");
            }
                
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }
        
    } else {
        return header("Location: listaPagamento.php");
    }