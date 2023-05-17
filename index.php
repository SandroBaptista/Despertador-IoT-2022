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

    //Obter número de alarmes
    $sqlAlarmes = "SELECT * FROM alarme WHERE id_despertador=".$_COOKIE['id'];
    if ($resultAlarmes = mysqli_query($conn, $sqlAlarmes)) {
        $numAlarmes=mysqli_num_rows($resultAlarmes);
    }

    //Obter número de alarmes ativos
    $sqlAlarmesAtivos = "SELECT * FROM alarme WHERE estado=1 AND id_despertador=".$_COOKIE['id'];
    if ($resultAlarmesAtivos = mysqli_query($conn, $sqlAlarmesAtivos)) {
        $rowcount=mysqli_num_rows($resultAlarmesAtivos);
    }    

    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            $nomeDesp = $row['nome'];
            $timeZone = $row['timezone'];
            $date = preg_split ("/\ /", $row['data']);
            $hora = preg_split("/\:/", $date[1]);
            $fusohorario = $row['timezone'];
        }
    }
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Despertador IoT - Servidor</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/adicionar.css" rel="stylesheet">

</head>

<body id="page-top" onload="">

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
            <li class="nav-item active">
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

            <li class="nav-item">
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
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
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
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-solid fa-user"></i>
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
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><b>ID: <?php echo $_COOKIE['id']; ?> | Nome: <?php echo $nomeDesp ?></span></b></h1>
                        <button class="btn btn-primary btn-sm" type="submit" onclick="location.href='listadespertadores.php'">Mudar de Despertador</button>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                <b>Hora atual:</b></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="time"></span></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-clock fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                <b>Total de Alarmes</b></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $numAlarmes; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-alarm-clock fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                <b>Alarmes Ativos</b></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $rowcount; ?>/<?php echo $numAlarmes; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-check fa-2x"></i>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><b>Time Zone:</b>
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        <?php echo $timeZone; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-globe fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <p class="m-0 font-weight-bold text-primary">Lista de alarmes</p>
                                </div>
                                <div class="card-body shadow text-center">
                                    <div class="table-responsive">
                                        <table class="table" id="table">
                                            <thead>
                                                <tr>
                                                    <th>Ativar</th>
                                                    <th>Hora</th>
                                                    <th>Dia da semana</th>
                                                    <th>Remover</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $sql = "SELECT * FROM alarme WHERE id_despertador=".$_COOKIE['id']." LIMIT 0 , 4";


                                                if ($result = mysqli_query($conn, $sql)) {
                                                // Fetch one and one row
                                                while ($row = mysqli_fetch_row($result)) {
                                                
                                                echo "<tr>";
                                                    echo "<td>";
                                                    echo "<input type='text' id='idAlarm_".$row[0]."' name='idAlarm' value='".$row[0]."' hidden>";
                                                        if($row[1] == 1){
                                                            echo "<label class='switch'>
                                                            <input type='checkbox' onclick='myFunc(".$row[0]."), desativarAlarme();' checked>
                                                            <span class='slider round'></span>
                                                            </label>";
                                                        }
                                                        else{
                                                            echo "<label class='switch'>
                                                                <input type='checkbox' onclick='myFunc(".$row[0]."), ativarAlarme();'>
                                                                <span class='slider round'></span>
                                                                </label>";
                                                        }
                                                    ?></td>
                                                    <td><?php echo $row[2]; ?></td>
                                                    <td><?php echo $row[8]; ?></td>
                                                    <td><button onclick="myFunc('<?php echo $row[0];?>')" data-toggle="modal" data-target="#removeModal">X</button>
                                                </tr>   
                                                <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel" style="color:red;"><b>Aviso</b></h5>
                                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body"><b>Tem a certeza que pretende remover o alarme com o id <span id="demo"></span>?</b></div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                                <button class="btn btn-danger" type="button" data-dismiss="modal" onclick="remover()">Remover</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
                                                <?php
                                                    }
                                                }
                                                ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="form-group text-center">
                                            <button class="btn btn-primary btn-sm" type="submit" onclick="location.href='lista.php'">Ver Lista Completa</button>
                                            <button class="btn btn-primary btn-sm" type="submit" onclick="location.href='adicionaralarme.php'">Adicionar Alarme</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-lg-6 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Configuração manual das horas</h6>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" name="form" action="confighoras.php">
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <strong>Data definida:</strong>
                                                        <span id="dataValor"></span>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="date">
                                                            <strong>Nova data:</strong>
                                                        </label>
                                                        <input class="form-control" id="date" type="date" name="date">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <strong>Hora definida:</strong>
                                                        <span id="horasValor"></span>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="time">
                                                            <strong>Nova hora:</strong>
                                                        </label>
                                                        <input class="form-control" id="time" type="time" step="2" name="time">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <strong>Fuso horário definido:</strong>
                                                        <?php echo $fusohorario; ?>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="first_name">
                                                            <strong>Novo fuso horário:</strong>
                                                        </label>
                                                        <div class="dropdown">
                                                            <select data-toggle="dropdown" aria-expanded="false" name="fusohorario">
                                                            <?php
                                                                include('database.php');

                                                                $sql = "SELECT nome FROM timezone;";
                                                                ?>


                                                                <?php if ($result = mysqli_query($conn, $sql)) {
                                                                    while ($row = mysqli_fetch_row($result)) {
                                                                        echo "<option value='".$row[0]."'>".$row[0]."</option>";
                                                                ?>
                                                                <?php
                                                                    }
                                                                }
                                                            ?>   
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="form-group text-center"><button
                                                    class="btn btn-primary btn-sm" type="submit" onclick="">Aplicar</button><br><br>
                                            </div>
                                        </form>                                    
                                            <div class="form-group text-center">
                                                <button class="btn btn-primary btn-sm" type="submit" name="sincronize" onclick="getNTP();">Sincronizar automaticamente</button>
                                                <h1 id="currentNtp"></h1>
                                            </div>     
                                    </div>
                                </div>
                                
                            
    
                        </div>
                    </div>
                    
                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <p class="m-0 font-weight-bold text-primary">Lista de músicas</p>
                                </div>
                                <div class="card-body shadow text-center">
                                    <div class="table-responsive">
                                        <table class="table" id="table">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Música</th>
                                                    <th>Link</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql = "SELECT * FROM musica LIMIT 0 , 4";

                                                    if ($result = mysqli_query($conn, $sql)) {
                                                        // Fetch one and one row
                                                        while ($row = mysqli_fetch_row($result)) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $row[1]; ?></td>
                                                            <td><?php echo $row[2]; ?></td>
                                                            <td><?php echo $row[3]; ?></td>
                                                        </tr>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                            </tbody>
                                        </table>
                                        <div class="form-group text-center">
                                            <button class="btn btn-primary btn-sm" type="submit" onclick="location.href='listamusicas.php'">Ver Lista Completa</button>
                                            <button class="btn btn-primary btn-sm" type="submit" onclick="location.href='adicionarmusica.php'">Adicionar Música</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-lg-6 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Estatísticas</h6>
                                    </div>
                                    <div class="card-body" style="margin-top: 50px;">
                                        <form>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <strong>API:</strong>
                                                        <a href="#" class="btn btn-success btn-circle btn-sm">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="date">
                                                            <strong>ESP32:</strong>
                                                        </label>
                                                        <a href="#" class="btn btn-success btn-circle btn-sm">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <span style="margin-bottom: 60px;"></span>
                                        </form>
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



    <script>
            document.getElementById("dataValor").innerHTML = '<?php echo $date[0]; ?>';
            document.getElementById("horasValor").innerHTML = '<?php echo $date[1]; ?>';
            parseInt(document.getElementById("horasValor").value);
        function myFunc(id){
            document.getElementById("demo").innerHTML = id;
        }


        function remover(){
            var idAlar = document.getElementById("demo").innerHTML;
            window.location.href = "removeralarme.php?alarmeid=" + idAlar; 
        }

        function desativarAlarme(){
            var idAlar = document.getElementById("demo").innerHTML;
            window.location.href = "alarmeoff.php?alarme=" + idAlar; 
        }

        function ativarAlarme(){
            var idAlar = document.getElementById("demo").innerHTML;
            window.location.href = "alarmeon.php?alarme=" + idAlar; 
        }
    </script> 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- Obtenção da hora atualizada -->
    <script type="text/javascript">
        let d = "";
        let hora = <?php echo $hora[0]?>;
        function addZero(i) {
            if (i < 10) {i = "0" + i}
                return i;
        }
        function timedMsg(){
            var horas = document.getElementById("horasValor").innerHTML;
            d = new Date();
            d.setHours(horas.split(':')[0], horas.split(':')[1], horas.split(':')[2]);

            document.getElementById('time').innerHTML =
            addZero(d.getHours())+':'+addZero(d.getMinutes())+':'+addZero(d.getSeconds());
        }

        function changeTime(){
            d.setTime(d.getTime() + 1000);
            document.getElementById('time').innerHTML =
            addZero(d.getHours())+':'+addZero(d.getMinutes())+':'+addZero(d.getSeconds());
        }
        timedMsg();
        setInterval(changeTime,1000);
    </script>

    <script type="text/javascript">
        function getNTP() {
            jQuery(function($) {    
                $.ajax( {           
                    url : "sincronizarhora.php",
                    type : "GET",
                    success : function(data) {
                            const dataNtp = data.split(" ");

                            document.getElementById("dataValor").innerHTML = dataNtp[0];
                            document.getElementById("horasValor").innerHTML = dataNtp[1];
                            timedMsg();

                        }
                    });
                });
            }
    </script>

</body>

</html>