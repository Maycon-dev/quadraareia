<?php    

    // require_once "helpers/protectNivel.php";
    // carrega a classe do banco de dados
    require_once "library/Database.php";
    // atribui a conexão a variável $db
    $db = new Database();
    // tenta fazer a conexão com banco de dados
    try {
        // atribui o resultado do dbDelete a variavel $result
        $result = $db->dbDelete("DELETE FROM pagamento 
                                WHERE id = ?",
                                [$_POST['id']]
                            );

        // verifica se a váriavel $result é true
        if ($result) {
            return header("Location: listaPagamento.php?msgSucesso=Registro excluído com sucesso.");
        } else {
            return header("Location: listaPagamento.php?msgError=Falha ao tentar excluír o registro.");
        }
    // se ocorrer um erro de conexão é retornado pelo bloco catch
    } catch (Exception $ex) {
        echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
    }