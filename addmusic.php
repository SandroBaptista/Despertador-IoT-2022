<?php
    session_start();
    $nomeMusica = $_POST['namemusic'];
    $visibilidade = (int) $_POST['visibilidadevalor'];
    $idUser = $_SESSION['idUser'];
    
    $target_dir = "musicas/user/" . $idUser . "/";
    $target_file = $target_dir . basename($_FILES["filemusic"]["name"]);
    $name_file = $_FILES["filemusic"]["name"];
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(isset($_POST["add-music"]))
    {

        if (!file_exists($path)) {
            mkdir($target_dir, 0777, true);
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["filemusic"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["filemusic"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    //INSERIR MUSICA NA BASE DE DADOS
    $conn = mysqli_connect("localhost","despertador_admin","Despertador_iot48","despertador_iot");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
    $sqlMusicas = "SELECT * FROM musica ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sqlMusicas);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $ultimoidMusica = $row["id"];
    }
    } else {
        echo "0 results";
    }

    $proximo_id = $ultimoidMusica + 1;
    $_SESSION['ultimoid'] = $ultimoidMusica;

    $sql = "INSERT INTO musica (id, nome, musica, link, visibilidade, duracao, id_utilizador) VALUES ('$proximo_id', '$nomeMusica', '$name_file', '$target_file', '$visibilidade', '60', '$idUser')";


    if ($conn->query($sql) === TRUE) {
        echo "Inserido";
        header('Location: listamusicas.php');
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
?>