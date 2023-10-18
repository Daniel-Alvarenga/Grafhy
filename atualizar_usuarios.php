<?php

include_once('config.php');

if(!isset($_SESSION['user'])){
    header('location: login.php');
}
else{
    $user_name = $_SESSION['user'];
}

$grupo = $_POST['grupo'];

$sql = mysqli_query(
    $conn,
    "SELECT user_name
    FROM acessos_grupos
    WHERE grupo = '$grupo'
    ORDER BY user_name"
);

if (!$sql) {
    die('Erro na consulta: ' . mysqli_error($conn));
}  

while ($row = mysqli_fetch_assoc($sql)) {
    $user = $row['user_name'];
    
    if($user == $user_name){
        echo '<li>Você<li>';
    }
    else{
        echo '<li>'.$user.'<li>';
    }
    
}

?>