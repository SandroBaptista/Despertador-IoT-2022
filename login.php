<!DOCTYPE html>
<html lang="en">

<!-- Autenticação para o Login-->
<?php      
    session_start();
    include('connection.php');  
    $email = $_POST['email'];  
    $password = $_POST['pass'];  
    
      
        //to prevent from mysqli injection  
        $email = stripcslashes($email);  
        $password = stripcslashes($password);  
        $email = mysqli_real_escape_string($con, $email);  
        $password = mysqli_real_escape_string($con, $password);
        $passwordcifrada = hash_hmac("sha256", $password, 'dpt_data');
        
      
        $sql = "select * from user where email = '$email' and password= '$passwordcifrada'";  

        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_row($result)) {
                    $_SESSION['idUser'] = $row[0];
                    $_SESSION['nomeUser'] = $row[1];
            }
       }

        
        $count = mysqli_num_rows($result);  


        if($count == 1){  
            header("Location: listadespertadores.php");
            $_SESSION["email"] = $_POST['email'];
        }
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Despertador IoT - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

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
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>
                                    <form name="user" class="user" action="login.php" method="POST">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="email" name="email" aria-describedby="email"
                                                placeholder="Introduza o seu email" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="pass" name="pass" placeholder="Introduza a sua palavra-passe" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <input type="submit" id="btn" class="btn btn-primary btn-user btn-block" value="Login" />  
                                        <!--<hr> -->
                                        <!--<a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>-->
                                    </form>
                                   <!-- <hr> -->
                                  <!--  <div class="text-center">
                                        <br><a class="small" href="forgot-password.html">Esqueceu-se da Password?</a>
                                    </div>-->
                                    <div class="text-center">
                                        <a class="small" href="register.php">Crie uma conta!</a>
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