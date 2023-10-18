<?php 

include_once('config.php');

$user_name = $_POST['user_name'];

$id = $_POST['entrar'];

$solicit = "SELECT grupo FROM convites WHERE id = '$id' ORDER BY grupo";
$grupo_result = mysqli_query($conn, $solicit);
$grupo = mysqli_fetch_assoc($grupo_result)['grupo'];

$s = "SELECT * FROM acessos_grupos WHERE user_name = '$user_name' AND grupo = '$grupo' ORDER BY grupo";
$r = mysqli_query($conn, $s);

if(mysqli_num_rows($r) == 0){
    mysqli_query($conn, "INSERT INTO acessos_grupos VALUES (DEFAULT, '$user_name', '$grupo')");

    $seeNumber = "SELECT user_number FROM grupos where grupo = '$grupo'";
    $userNumber = mysqli_query($conn, $seeNumber);
    $row = mysqli_fetch_assoc($userNumber);
    $number_n = $row['user_number'];

    $number_n = $number_n + 1;

    mysqli_query($conn, "UPDATE grupos SET user_number = '$number_n' WHERE grupo = '$grupo'");

    mysqli_query($conn, "DELETE FROM convites WHERE id = '$id'");
}  


?>