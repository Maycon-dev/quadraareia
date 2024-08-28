<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Marcação de horários</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <script src="assets/js/jquery-3.2.1.min.js"></script>

</head>

<body>

    <?php
        session_start();
    ?>

    <div class="main-wrapper" id="cabecalho">
        <div class="header">
			<div class="header-left">
				<a href="index.php" class="logo">
					<img src="assets/img/logo.png" width="35" height="35" alt=""> <span>Agenda</span>
				</a>
			</div>
			<a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
            <ul class="nav user-menu float-right">
                <li class="nav-item dropdown d-none d-sm-block">
                    <?php if(isset($_SESSION["userId"])) : ?>
                   
                </li>

                <?php endif; ?>

                <?php if(isset($_SESSION["userId"])) : ?>

                    <li class="nav-item dropdown has-arrow">
                        <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                            <span class="user-img">
                                <img class="rounded-circle" src="assets/img/user.jpg" width="24" alt="Admin">
                                <span class="status online"></span>
                            </span>
                            <span><?= isset($_SESSION["userNome"]) ? $_SESSION["userNome"] : "" ?></span>
                        </a>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" href="formUsuario.php?acao=update&id=<?= $_SESSION['userId'] ?>">Meu Perfil</a>
                        <a class="dropdown-item" href="logoff.php">Sair</a>
                        </div>
                    </li>
                
                <?php endif; ?>

                <?php if(!isset($_SESSION["userId"])) : ?>
                    <a class="btn btn-primary float-right" href="logar.php">Entrar</a>
                <?php endif; ?>
            </ul>
        </div>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <?php if(isset($_SESSION["userNivel"]) && $_SESSION["userNivel"] == '1') : ?>
                        <li class="menu-title">Administrador</li>
                        <li class="active">
                            <a href="index.php"><i class="fa fa-bar-chart"></i> <span>Painel</span></a>
                        </li>
                        <li>
                            <a href="listaUsuario.php"><i class="fa fa-address-card-o"></i> <span>Usuário</span></a>
                        </li>
                        <li>
                            <a href="listaMetodoPagamento.php"><i class="fa fa-money"></i> <span>Metodo de Pagamento</span></a>
                        </li>
                        <li>
                            <a href="listaPagamento.php"><i class="fa fa-line-chart"></i> <span>Pagamento</span></a>
                        </li>
                        <li>
                            <a href="listaTipoLocal.php"><i class="fa fa-area-chart"></i> <span>Tipo local</span></a>
                        </li>
						<li>
                            <a href="listaLocal.php"><i class="fa fa-object-group"></i> <span>Local</span></a>
                        </li>
                        <li>
                            <a href="listaHorario.php"><i class="fa fa-hourglass-half"></i> <span>Horario</span></a>
                        </li>
                        <li>
                            <a href="listaPenalidade.php"><i class="fa fa-ban"></i> <span>Penalidade</span></a>
                        </li>
                        <?php endif; ?>
                        <li class="menu-title">Usuário</li>
                        <li>
                            <a href="agendamento.php?acao=insert"><i class="fa fa-calendar"></i> <span>Agendamento</span></a>
                        </li>

                        <li>
                            <a href="<?= !isset($_SESSION["userId"]) ? "logar.php" : "listaAgendamento.php" ?>"><i class="fa fa-calendar-check-o"></i> <span>Meus agendamentos</span></a>
                        </li>
   

                    </ul>
                </div>
            </div>
        </div>