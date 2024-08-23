<?php

 $db = new Database();
 $dados = [];

class Funcoes
{
    /**
     * gerarNomeAleatorio
     *
     * @param string $nomeArquivo 
     * @return string
     */
    // gera um nome aleatorio para as imagens
    public static function gerarNomeAleatorio($nomeArquivo) 
    {
        $retNome    = "";
        // separa o nome do arquivo da sua extensão
        $arquivo    = explode(".", $nomeArquivo);
        // pega o ultimo elemento do array arquivo
        $arqExt     = $arquivo[count($arquivo) -1 ];
        // substitui a extensão do arquivo por uma string vaziae armazena o nome do arquivo sem a extensão em $arqNome
        $arqNome    = str_replace('.' . $arqExt, "",  $nomeArquivo);
        // gera um numero aleatorio de 0-99999
        $aleatorio  = rand(0, 99999);
        // retorna o nome do arquivo com o nome aleatorio
        return $arqNome . '-' . $aleatorio . '.' .  $arqExt;

    }

    /**
     * strDecimais
     *
     * @param string $valor 
     * @return float
     */
    public static function strDecimais($valor)
    {
        // substitui por a virgula pelo ponto
        return str_replace(",", ".", str_replace(".", "", $valor));
    } 
    /**
     * valorBr
     *
     * @param float $valor 
     * @return float
     */
    public static function valorBr($valor, $decimais = 2) 
    {
        // virgula separa decimal e ponto separa milhar
        return number_format($valor, $decimais, ",", ".");
    }

    /**
     * userLogado
     *
     * @return bool
     */
    public static function userLogado($nivel = 1)
    {
        // verifica se o usuário é um administrador
        if (isset($_SESSION['userId'])) {
            if ($_SESSION['userNivel'] == $nivel) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    // public static function redirectPageSearch($pagina) 
    // {
    //     require_once "library/Database.php";

    //     $dados = $db->dbSelect("SELECT * FROM produtocategoria");

    //     foreach ($dados as $item) {
    //         if($item['descricao'] == $pagina) {
    //             $produtocategoria_id = $item['id'];
    //         }
    //     }
    // }

    function total_valor($quantidade, $Valor){
        $total = $quantidade * $Valor;
        return $total;
    }
}