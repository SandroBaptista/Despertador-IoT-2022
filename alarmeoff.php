<?php
    include('database.php');
    $sql = "UPDATE alarme SET estado=0 WHERE id=".$_GET['alarme'];

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

    header('Location: lista.php');

    $conn->close();
?>