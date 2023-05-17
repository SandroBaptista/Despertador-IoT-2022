<?php
include_once 'database.php';
$sql = "DELETE FROM alarme WHERE id='" . $_GET["alarmeid"] . "'";
if (mysqli_query($conn, $sql)) {
    header('Location: lista.php');
    $sqlUpdate = "UPDATE despertador SET is_atualizado=0, ultima_atualizacao=NOW() WHERE id=".$_COOKIE['id'];
    if ($conn->query($sqlUpdate) === TRUE) {
        echo "Updated";
    }
    else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
mysqli_close($conn);
?>