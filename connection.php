<?php      
    $host = "localhost";  
    $user = "despertador_admin";  
    $password = 'Despertador_iot48';  
    $db_name = "despertador_iot";  
      
    $con = mysqli_connect($host, $user, $password, $db_name);  
    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }  
?>  