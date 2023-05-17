<?php
    session_start();
    //REGISTAR UTILIZADOR
    include('database.php');

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    $sqlUsers = "SELECT * FROM user ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sqlUsers);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $ultimo_idalarme = $row["id"];
    }
    } else {
        echo "0 results";
    }

    $proximo_id = $ultimo_idalarme + 1;

    $nome = $_POST['name'];    
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $password_cifrada =  hash_hmac("sha256", $password, 'dpt_data');

    $sql = "INSERT INTO user (id, nome, email, password) VALUES ('$proximo_id', '$nome', '$email', '$password_cifrada')";


    if ($conn->query($sql) === TRUE) {
        echo "Inserido";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    header('Location: login.php');
?>