<!DOCTYPE html>
<html lang="en">

<?php
    session_start();
    if ( !isset($_SESSION['email']) ){
        header( "refresh:2;url=login.php" );
        die( "Acesso restrito. A redirecionar para a página login.." );
    }

    if ( !isset($_COOKIE['id']) ){
        header( "refresh:2;url=listadespertadores.php" );
        die( "Despertador não escolhido. A redirecionar para a página da lista de despertadores.." );
    }

    include('database.php');
    $sql = "SELECT * FROM despertador WHERE id=".$_COOKIE['id'];

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $nomeDesp = $row['nome'];
        $tempoAtualizacao = $row['tempo_atualizacao'];
        $date = preg_split ("/\ /", $row['data']); 
    }
    } else {
    
    }
    $conn->close();
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Despertador IoT - Alterar</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/adicionar.css" rel="stylesheet">
    <link href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet" type="text/css">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa-solid fa-alarm-clock"></i>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard - Despertador</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading" style="color: #fff;">
                Despertador:
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="listadespertadores.php">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Lista de Despertadores</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="lista.php">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Lista de Alarmes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="listamusicas.php">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Lista de Músicas</span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link collapsed" href="alterarnome.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Definições</span>
                </a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Adicionar</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="adicionaralarme.php">Alarme</a>
                        <a class="collapse-item" href="adicionarmusica.php">Música</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading" style="color:#fff;">
                Utilizador:
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="alterarnomeuser.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Definições</span>
                </a>
            </li>

            
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw "></i>
                    <span>Terminar Sessão</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"> <i class="fas fa-sign-out-alt fa-sm fa-fw "></i></button>
            </div>

            

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><b><?php echo $_SESSION['nomeUser']; ?></b></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="perfil.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <a class="dropdown-item" href="alterarnomeuser.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Definições
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Terminar Sessão
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid text-center">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-primary" style="font-weight: bold;">Definições do Despertador</h1>
<br><br>
                    <div class="row justify-content-center">

                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary font-weight-bold m-0">Preencha os seguintes campos</p>
                                        </div>
                                        <div class="card-body shadow">
                                            <div class="col mr-2">
                                                <form method="post" id="form-add-alarm" action="alterardadosdesp.php">
                                                    <div class="form-group">
                                                        <label for="username">
                                                            <strong>Nome Atual: <span class="text-primary"><?php echo $nomeDesp; ?></span></strong>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Novo Nome:</strong>
                                                        </label>
                                                        <input id="textInput" type="text" value="" name="despertadorName">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tempo-atualizacao">
                                                                <strong>Tempo de Atualização Atual: <span class="text-primary"><?php echo $tempoAtualizacao; ?></span></strong>
                                                        </label>
                                                        <input id="despertador-tempo" type="number" name="tempo-atualizacao">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="servidor_ntp">
                                                            <strong>Servidor NTP:</strong>
                                                        </label>
                                                        <div class="dropdown">
                                                            <select data-toggle="dropdown" aria-expanded="false" name="servidor_ntp">
                                                                <option value="pt.pool.ntp.org" selected>pt.pool.ntp.org</option>
                                                                <option value="pool.ntp.org">pool.ntp.org</option>
                                                                <option value="time.windows.com">time.windows.com</option>
                                                                <option value="time.google.com">time.google.com</option>
                                                                <option value="time.cloudflare.com">time.cloudflare.com</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group text-center">
                                                        <button id="add-alarm" class="btn btn-primary btn-sm" type="submit">Aplicar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                        <b class="text-primary">ID do Despertador: <?php echo $_COOKIE['id'];?></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Configuração manual das horas</h6>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" id="form-add-alarm" action="confighorasdata.php">
                                                <div class="form-row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <strong>Data definida:</strong>
                                                            <a><?php echo $date[0]; ?></a>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="date">
                                                                <strong>Nova data:</strong>
                                                            </label>
                                                            <input class="form-control" id="date" name="date" type="date">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <strong>Hora definida:</strong>
                                                            <a><?php
                                                                    echo $date[1];
                                                                ?></a>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="time">
                                                                <strong>Nova hora:</strong>
                                                            </label>
                                                            <input class="form-control" id="time" name="time" type="time" step="2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group text-center"><button
                                                        class="btn btn-primary btn-sm" type="submit">Aplicar</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-footer">
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; 2022 Despertador IoT - Sandro Baptista & José Pereira</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="exampleModalLabel"><b>Terminar Sessão</b></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"><b>Tem a certeza que pretende terminar sessão?</b></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger" href="logout.php">Confirmar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>