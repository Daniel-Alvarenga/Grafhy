<?php

include_once('config.php');

if(!isset($_SESSION['user'])){
    header('location: login.php');
}
else{
    $user_name = $_SESSION['user'];
}

$chave = $_SESSION['id'];
$chave = str_replace('\'', "", $chave);

if(isset($_POST['mensagem'])){
    $chat = $chave;
    $mensagem = $_POST['mensagem'];
    $dia = date("Y-m-d H:i:s");

    mysqli_query($conn,"INSERT INTO $chat VALUES (DEFAULT, '$mensagem', '$dia', '$user_name')");
    exit(); 
}

$sql = mysqli_query($conn, "SELECT * FROM $chave ORDER BY mensagem_id");

while ($row = mysqli_fetch_assoc($sql)) {
    $mensagem = $row['mensagem'];
    $dia = $row['data_hora'];
    $user = $row['user_name'];

    if($user == $user_name){
        echo '<div class="message"><fieldset class="me"><p class="mensagem">'.$mensagem.'</p><p class="data">'.$dia.'</p></fieldset></div>';
    }
    else{
        echo '<div class="message"><fieldset><label class="remetente">'.$user .'</label><p class="mensagem">'.$mensagem.'</p><p class="data">'.$dia.'</p></fieldset></div>';
    }

}

?>