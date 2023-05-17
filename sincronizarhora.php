<?php
    include('database.php');
    
    $current_date = "";

    date_default_timezone_set('Europe/Lisbon'); 

    $info = getdate();
    $date = $info['mday'];
    $month = $info['mon'];
    $year = $info['year'];
    $hour = $info['hours'];
    $min = $info['minutes'];
    $sec = $info['seconds'];

    $current_date = date('Y-m-d H:i:s');
    
    $sql = "UPDATE despertador SET data='".$current_date."' WHERE id=".$_COOKIE['id'];

    if ($conn->query($sql) === TRUE) {
        echo $current_date;
        $sqlUpdate = "UPDATE despertador SET is_atualizado=0, ultima_atualizacao=NOW() WHERE id=".$_COOKIE['id'];
        if ($conn->query($sqlUpdate) === TRUE) {
        //    echo "Updated";
        }
        else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }

?>