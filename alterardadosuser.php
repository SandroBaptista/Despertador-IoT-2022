<?php
    include 'database.php';

    session_start();

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $password = $_POST['user-password'];
    $password_cifrada =  hash_hmac("sha256", $password, 'dpt_data');
    $sql = "UPDATE user SET nome='".$_POST['username']."', password='".$password_cifrada."', email='".$_POST['user-email']."' WHERE id=".$_SESSION['idUser'];

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    header('Location: alterarnomeuser.php');

    $conn->close();
?>