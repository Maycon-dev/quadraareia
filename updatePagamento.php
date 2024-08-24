<?php

    // require_once "helpers/protectNivel.php";

    require_once "library/Database.php";

    $db = new Database();

    try {

        $result = $db->dbUpdate("UPDATE pagamento 
                                SET reserva_id = ?, data_pagamento = ?, valor_pago = ?, metodo_pagamento = ?, status_pagamento = ?
                                WHERE id = ?",
                                [
                                    $_POST['reserva_id'],
                                    $_POST['data_pagamento'],
                                    $_POST['valor_pago'],
                                    $_POST['metodo_pagamento'],
                                    $_POST['status_pagamento'],

                                    $_POST['id']
                                ]);

        if ($result) {
            return header("Location: listaPagamento.php?msgSucesso=Registro alterado com sucesso.");
        } else {
            return header("Location: listaPagamento.php?msgError=Falha ao tentar alterar o registro.");
        }
        
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }