<?php 

    if(!isset($_SESSION)) {
        session_start();
    }

    if(!isset($_SESSION['userId'])) {
        header("Location: index.php?msgError=É necessário estar logado para acessar essa página.");
    }