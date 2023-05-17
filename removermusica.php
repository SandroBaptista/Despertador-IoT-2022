<?php
include_once 'database.php';
$sql = "DELETE FROM musica WHERE id='" . $_GET["musicaid"] . "'";
if (mysqli_query($conn, $sql)) {
    header('Location: listamusicas.php');
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
mysqli_close($conn);
?>