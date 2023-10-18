<?php 

include_once('config.php');

$contato = $_POST['contato'];
                    
$getlast = mysqli_query($conn, "SELECT * FROM online_users WHERE user_name = '$contato'"); 
$last = mysqli_fetch_assoc($getlast)['ultima'];

$current_time = time();
$last_time = strtotime($last);

$diff = $current_time - $last_time;

if($diff<=1){
    echo "<p>Online</p>";
}
else{
    $last = date($last);
    echo"<p>último acesso em $last</p>";
}

?>