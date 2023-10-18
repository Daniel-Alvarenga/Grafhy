<?php

include_once('config.php');

if(!isset($_SESSION['user'])){
    exit;
}
else{
    $user_name = $_SESSION['user'];
}

if(isset($_POST['chat']) && isset($_POST['mensagem'])){
    $chat = mysqli_real_escape_string($conn, $_POST['chat']);
    $mensagem = mysqli_real_escape_string($conn, $_POST['mensagem']);
    $dia = date("Y-m-d H:i:s");

    if(!empty($mensagem)){
        mysqli_query($conn,"INSERT INTO $chat VALUES (DEFAULT, '$mensagem', '$dia', '$user_name')");
    }
}

?>
