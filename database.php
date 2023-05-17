<?php
    $url='localhost';
    $username='despertador_admin';
    $password='Despertador_iot48';
    $db='despertador_iot';
    $conn=mysqli_connect($url,$username,$password,$db);
    if(!$conn){
        die('Could not Connect My Sql:' .mysql_error());
    }
?>