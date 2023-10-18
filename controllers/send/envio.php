<?php
session_start();
include_once('../../config/config.php');

if(!isset($_SESSION['user'])){
    exit;
}

$user_name = $_POST['user_name'];
$mensagem = $_POST['mensagem'];
$tipo = $_POST['tipo'];
$destino = $_POST['destino'];

if(isset($_POST['mensagem'])){
    $dia = date("Y-m-d H:i:s");

    if($tipo == "contato"){
        mysqli_query($conn, "INSERT INTO privado VALUES (DEFAULT, '$mensagem', '$dia', '$destino', '$user_name')");
    }

}
?>
