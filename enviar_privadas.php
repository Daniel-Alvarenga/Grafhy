<?php

include_once('config.php');

if(!isset($_SESSION['user'])){
    exit;
}
else{
    $user_name = $_SESSION['user'];
}

$mensagem = $_POST['mensagem'];
$contato = $_POST['contato'];

if(isset($_POST['mensagem'])){
    $mensagem = $_POST['mensagem'];
    $dia = date("Y-m-d H:i:s");

    if(!empty($mensagem)){
        mysqli_query($conn, "INSERT INTO privado VALUES (DEFAULT, '$mensagem', '$dia', '$contato', '$user_name');");
    }
}
?>