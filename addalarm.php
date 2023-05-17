<?php
    session_start();
    //INSERIR ALARMES
    $conn = mysqli_connect("localhost","despertador_admin","Despertador_iot48","despertador_iot");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    $sqlAlarmes = "SELECT * FROM alarme ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sqlAlarmes);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $ultimo_idalarme = $row["id"];
    }
    } else {
        echo "0 results";
    }

    $proximo_id = $ultimo_idalarme + 1;

    $_SESSION['proximoid'] = $proximo_id;

    $dias = array("0", "0", "0", "0", "0", "0", "0", "0");

   if ($_POST['domingo'] == '1'){
        $dias[0] = "1";
        if(strlen($diasTexto) != 0){
            $diasTexto .= ", ";
        }
        $diasTexto = "Domingo";

   }
   if($_POST['segunda'] == '1'){
        $dias[1] = "1";
        if(strlen($diasTexto) != 0){
            $diasTexto .= ", ";
        }
        $diasTexto .= "Segunda-feira";
   }
   if($_POST['terca'] == '1'){
        $dias[2] = "1";
        if(strlen($diasTexto) != 0){
            $diasTexto .= ", ";
        }
        $diasTexto .= "Terça-feira";
   }
   if($_POST['quarta'] == '1'){
        $dias[3] = "1";
        if(strlen($diasTexto) != 0){
            $diasTexto .= ", ";
        }
        $diasTexto .= "Quarta-feira";
   }
   if($_POST['quinta'] == '1'){
        $dias[4] = "1";
        if(strlen($diasTexto) != 0){
            $diasTexto .= ", ";
        }
        $diasTexto .= "Quinta-feira";
   }
   if($_POST['sexta'] == '1'){
        $dias[5] = "1";
        if(strlen($diasTexto) != 0){
            $diasTexto .= ", ";
        }
        $diasTexto .= "Sexta-feira";
   }
   if($_POST['sabado'] == '1'){
        $dias[6] = "1";
        if(strlen($diasTexto) != 0){
            $diasTexto .= ", ";
        }
        $diasTexto .= "Sábado";
   }
   if($_POST['unicavez'] == '1'){
        $dias[7] = "1";
        if(strlen($diasTexto) != 0){
            $diasTexto .= ", ";
        }
        $diasTexto .= "Uma vez";
   } 

   $horalarm = $_POST['hour-alarm'];    
   $duracao = $_POST['duration-alarm'];
   $volume = $_POST['volume-alarm'];
   $idMusica = $_POST['musica'];
   $idDespertador = $_COOKIE['id'];

   $stringDias = $dias[0].$dias[1].$dias[2].$dias[3].$dias[4].$dias[5].$dias[6].$dias[7];

    $sql = "INSERT INTO alarme (id, estado, hora, dias, duracao, volume, id_despertador, id_musica, dia_semana) VALUES ('$proximo_id', '1', '$horalarm', '$stringDias', '$duracao', '$volume', '$idDespertador', '$idMusica', '$diasTexto')";


    if ($conn->query($sql) === TRUE) {
        echo "Inserido";
        $sqlUpdate = "UPDATE despertador SET is_atualizado=0, ultima_atualizacao=NOW() WHERE id=".$idDespertador;
        if ($conn->query($sqlUpdate) === TRUE) {
            echo "Updated";
        }
        else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    header('Location: lista.php');
?>