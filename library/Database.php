<?php

class Database
{
    /**
     * dbConect
     *
     * @return object
     */
    function dbConect()
    {
        // faz a conexão com o banco de dados
        try {
            $conn = new PDO(
                "mysql:host=localhost;dbname=marcacao_locais", 
                "root", 
                "",
                // define o padrão de codificação que será usado pelo banco de dados
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
            );
            // define os atributos de tratamento de erro do PDO que serão usados
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // return a conexão 
            return $conn;
        // se houver algum erro na hora de conectar com o banco de dados é retornado pelo bloco catch
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
        }
    }

    /**
     * select
     *
     * @param string $query 
     * @param string $tipoRetorno 
     * @param array $dados 
     * @return array|object
     */
    function dbSelect($query, $tipoRetorno = 'all', $dados = [])
    {
        try {
            // recupera a $conn da função dbConect
            $conn = $this->dbConect();
            // prepara a $query que é recebida na função 
            $data = $conn->prepare($query);
            // executa a query
            $data->execute($dados);

            if ($tipoRetorno == "all") {
                // recupera todas as linhas resultantes da consulta
                return $data->fetchAll();
            } else {
                // recupera linha por linha resultantes da consulta
                return $data->fetch(PDO::FETCH_OBJ);
            }
        // se houver algum erro na hora de conectar com o banco de dados é retornado pelo bloco catch
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
            return [];
        }
    }

    /**
     * dbInsert
     *
     * @param string $queryInsert 
     * @param array $data 
     * @return bool
     */
    function dbInsert(string $queryInsert, array $dados) : bool
    {
        try {
            // recupera a $conn da função dbConect
            $conn = $this->dbConect();
            // prepara a $queryinsert para ser executada
            $data = $conn->prepare($queryInsert);
            // executa a query
            $data->execute($dados);
            // verifica se o ultimo id é maior que zero 
            if ($conn->lastInsertId() > 0) {
                // retorna true, registro inserido com sucesso
                return true;
            } else {
                // retorna falso, falha ao inserir registro
                return false;
            }
        // se houver algum erro durante a conexão com o banco de dados e retornado pelo bloco catch
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>"; exit;
            return false;
        }
    }

    /**
     * dbUpdate
     *
     * @param string $queryUpdate 
     * @param array $dados 
     * @return bool
     */
    function dbUpdate(string $queryUpdate, array $dados) : bool
    {
        try {
            // recupera a conexão da função dbConnect()
            $conn = $this->dbConect();
            // prepara a $queryUpdate
            $data = $conn->prepare($queryUpdate);
            // executa a query
            $data->execute($dados);
            // verifica se o objeto resultante é maior que zero
            if ($data->rowCount() > 0) {
                // registro inserido com sucesso
                return true;
            } else {
                // falha ao inserir registro
                return false;
            }
        
        // se houver algum erro na conexao com o banco de dados é retornado pelo bloco catch
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>"; exit;
            return false;
        }
    }
    /**
     * dbDelete
     *
     * @param string $queryDelete 
     * @param array $dados 
     * @return bool
     */
    function dbDelete(string $queryDelete, array $dados) : bool
    {
        try {
            // recupera a $conn da função dbConect()
            $conn = $this->dbConect();
            // prepaara a queryDelete
            $data = $conn->prepare($queryDelete);
            // executa a query
            $data->execute($dados);
             // verifica se o objeto resultante é maior que zero
            if ($data->rowCount() > 0) {
                // registro deletado com sucesso
                return true;
            } else {
                // falha ao deletar registro
                return false;
            }
        // se houver algum erro ao tentar se conectar com o banco de dados é retornado pelo catch    
        } catch (Exception $ex) {
            echo '<p style="color: red;">ERROR: '. $ex->getMessage(). "</p>";
            return false;
        }
    }
}