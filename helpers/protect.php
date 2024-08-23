<?php 

    // Da o start da seção na página
    if(!isset($_SESSION)) {
        session_start();
    }

    // Verifica o usuario e se não for administrador redireciona para a página de login 
    if(isset($_SESSION['userNivel']) != 1) {
        die("Você não pode acessar está página por que não é um administrador. <p> <a href='viewLogin.php'> Entrar </a> </p>");
    }

?>