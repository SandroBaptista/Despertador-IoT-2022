<?php
    $servername = "localhost";
    $username = "despertador_admin";
    $password = "Despertador_iot48";
    $dbname = "despertador_iot";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE despertador SET data='".$_POST['date']." ".$_POST['time']."' WHERE id=".$_COOKIE['id'];

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        $sqlUpdate = "UPDATE despertador SET is_atualizado=0, ultima_atualizacao=NOW() WHERE id=".$_COOKIE['id'];
        if ($conn->query($sqlUpdate) === TRUE) {
            echo "Updated";
        }
        else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }

    header('Location: alterarnome.php');

    $conn->close();
?>