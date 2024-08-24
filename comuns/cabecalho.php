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
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body>

    <?php
        session_start();
    ?>

    <div class="main-wrapper">
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
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span class="badge badge-pill bg-danger float-right">3</span></a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span>Notifications</span>
                        </div>
                        <div class="drop-scroll">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
											<span class="avatar">
												<img alt="John Doe" src="assets/img/user.jpg" class="img-fluid">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
												<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
											</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
											<span class="avatar">V</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
												<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
											</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
											<span class="avatar">L</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
												<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
											</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
											<span class="avatar">G</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
												<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
											</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
											<span class="avatar">V</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
												<p class="noti-time"><span class="notification-time">2 days ago</span></p>
											</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="activities.html">View all Notifications</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown d-none d-sm-block">
                    <a href="javascript:void(0);" id="open_msg_box" class="hasnotifications nav-link"><i class="fa fa-comment-o"></i> <span class="badge badge-pill bg-danger float-right">8</span></a>
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
                            <a class="dropdown-item" href="profile.html">My Profile</a>
                            <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
                            <a class="dropdown-item" href="settings.html">Settings</a>
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
                            <a href="index.php"><i class="fa fa-dashboard"></i> <span>Painel</span></a>
                        </li>
                        <li>
                            <a href="listaUsuario.php"><i class="fa fa-hospital-o"></i> <span>Usuário</span></a>
                        </li>
                        <li>
                            <a href="listaMetodoPagamento.php"><i class="fa fa-hospital-o"></i> <span>Metodo de Pagamento</span></a>
                        </li>
                        <li>
                            <a href="listaPagamento.php"><i class="fa fa-hospital-o"></i> <span>Pagamento</span></a>
                        </li>
                        <li>
                            <a href="listaTipoLocal.php"><i class="fa fa-calendar"></i> <span>Tipo local</span></a>
                        </li>
						<li>
                            <a href="listaLocal.php"><i class="fa fa-user-md"></i> <span>Local</span></a>
                        </li>
                        <li>
                            <a href="listaHorario.php"><i class="fa fa-wheelchair"></i> <span>Horario</span></a>
                        </li>
                        <li>
                            <a href="listaPenalidade.php"><i class="fa fa-calendar-check-o"></i> <span>Penalidade</span></a>
                        </li>
                        <?php endif; ?>
                        <li class="menu-title">Usuário</li>
                        <li>
                            <a href="agendamento.php?acao=insert"><i class="fa fa-calendar"></i> <span>Agendamento</span></a>
                        </li>

                        <li>
                            <a href="<?= !isset($_SESSION["userId"]) ? "logar.php" : "listaAgendamento.php" ?>"><i class="fa fa-calendar"></i> <span>Meus agendamentos</span></a>
                        </li>
   

						<!-- <li class="submenu">
							<a href="#"><i class="fa fa-user"></i> <span> Employees </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="employees.html">Employees List</a></li>
								<li><a href="leaves.html">Leaves</a></li>
								<li><a href="holidays.html">Holidays</a></li>
								<li><a href="attendance.html">Attendance</a></li>
							</ul>
						</li> -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- <script>
        $(document).ready(function() {
            $('#tipo').change(function() {
                var tipo = $(this).val();
                if (tipo == '2') {
                    $('#fornecedor').prop('disabled', true);
                } else {
                    $('#fornecedor').prop('disabled', false);
                }
            });
        });
    </script> -->