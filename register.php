<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Despertador IoT - Registar</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-12 col-md-9">
                <h1 class="h3 mb-4" style="text-align: center; margin-top: 20px; color: white; font-weight: bold;"><i class="fa-solid fa-alarm-clock"></i>
                    &nbsp;&nbsp;Despertador IoT - Servidor</h1>
                <div class="card o-hidden border-0 shadow-lg my-5">

                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Registar</h1>
                                    </div>
                                    <form name="user" class="user" action="regist.php" method="POST">
                                        <div class="form-group">
                                            <div class="text-center">
                                                <h1 class="h6 text-gray-900">Nome</h1>
                                            </div>
                                            <input type="text" class="form-control form-control-user" id="name" name="name" aria-describedby="name" placeholder="Introduza o seu nome" required>
                                            <br>
                                            <div class="text-center">
                                                <h1 class="h6 text-gray-900">Email</h1>
                                            </div>
                                            <input type="email" class="form-control form-control-user" id="email" name="email" aria-describedby="email" placeholder="Introduza o seu email" required>
                                            <br>
                                            <div class="text-center">
                                                <h1 class="h6 text-gray-900">Password</h1>
                                            </div>
                                            <input type="password" class="form-control form-control-user" id="pass" name="pass" placeholder="Introduza a sua palavra-passe" required>
                                            <br>
                                            <input type="submit" id="btn" class="btn btn-primary btn-user btn-block" value="Registar" />

                                            <!--    <a href="index.html" class="btn btn-google btn-user btn-block">
                                                    <i class="fab fa-google fa-fw"></i> Registar com a conta Google
                                                </a>-->
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Já tem conta? Clique aqui para entrar!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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