        <?php 
            require_once 'comuns/cabecalho.php';
        ?>
        <div class="page-wrapper">
            <div class="row">
                <div class="col-12">
                    <?php if (isset($_GET['msgSucesso'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><?= $_GET['msgSucesso'] ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['msgError'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><?= $_GET['msgError'] ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg1"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                            <div class="dash-widget-info text-right">
                                <h3>98</h3>
                                <span class="widget-title1">Disponíveis <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
                            <div class="dash-widget-info text-right">
                                <h3>1072</h3>
                                <span class="widget-title2">Marcados <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg3"><i class="fa fa-user-md" aria-hidden="true"></i></span>
                            <div class="dash-widget-info text-right">
                                <h3>72</h3>
                                <span class="widget-title3">Cancelados <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <span class="dash-widget-bg4"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                            <div class="dash-widget-info text-right">
                                <h3>618</h3>
                                <span class="widget-title4">Total marcações <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="chart-title">
                                    <h4>Total de marcações</h4>
                                    <div class="float-right">
                                        <ul class="chat-user-total">
                                            <li><i class="fa fa-circle current-users" aria-hidden="true"></i>Confirmados</li>
                                            <li><i class="fa fa-circle old-users" aria-hidden="true"></i>Cancelados</li>
                                        </ul>
                                    </div>
                                </div>  
                                <canvas id="bargraph"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title d-inline-block">Próximas Horários</h4> <a href="appointments.html" class="btn btn-primary float-right">Ver todas</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="d-none">
                                            <tr>
                                                <th>Nome do Paciente</th>
                                                <th>Nome do Médico</th>
                                                <th>Horário</th>
                                                <th class="text-right">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="min-width: 200px;">
                                                    <a class="avatar" href="profile.html">B</a>
                                                    <h2><a href="profile.html">Bernardo Galaviz <span>Nova York, EUA</span></a></h2>
                                                </td>                 
                                                <td>
                                                    <h5 class="time-title p-0">Consulta com</h5>
                                                    <p>Dra. Cristina Groves</p>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">Horário</h5>
                                                    <p>19:00</p>
                                                </td>
                                                <td class="text-right">
                                                    <a href="appointments.html" class="btn btn-outline-primary take-btn">Realizar</a>
                                                </td>
                                            </tr>
                                            <!-- Repetir para outras linhas -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="card member-panel">
                            <div class="card-header bg-white">
                                <h4 class="card-title mb-0">Locais</h4>
                            </div>
                            <div class="card-body">
                                <ul class="contact-list">
                                    <li>
                                        <div class="contact-cont">
                                            <div class="float-left user-img m-r-10">
                                                <a href="profile.html" title="John Doe"><img src="assets/img/user.jpg" alt="" class="w-40 rounded-circle"><span class="status online"></span></a>
                                            </div>
                                            <div class="contact-info">
                                                <span class="contact-name text-ellipsis">John Doe</span>
                                                <span class="contact-date">MBBS, MD</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-cont">
                                            <div class="float-left user-img m-r-10">
                                                <a href="profile.html" title="Richard Miles"><img src="assets/img/user.jpg" alt="" class="w-40 rounded-circle"><span class="status offline"></span></a>
                                            </div>
                                            <div class="contact-info">
                                                <span class="contact-name text-ellipsis">Richard Miles</span>
                                                <span class="contact-date">MD</span>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Repetir para outros médicos -->
                                </ul>
                            </div>
                            <div class="card-footer text-center bg-white">
                                <a href="doctors.html" class="text-muted">Ver todos os Locais</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



<?php 
    require_once 'comuns/rodape.php';
?>