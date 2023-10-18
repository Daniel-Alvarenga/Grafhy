<?php

include_once('config.php');

$user_name = $_POST['user_name'];
    
$solicit = "SELECT * FROM acessos WHERE user_name = '$user_name'";
$result = mysqli_query($conn, $solicit);

while($var = mysqli_fetch_assoc($result)){?>
    <?php 
    
    $chat = $var['chat_name'];

    $seenumber = "SELECT user_number FROM chats where chat_name = '$chat'";
    $number = mysqli_query($conn, $seenumber);
    if (!$number) {
        die('Erro na consulta: ' . mysqli_error($conn));
    }  
    $row = mysqli_fetch_assoc($number);
    $number_value = $row['user_number'];

    echo "<div class=\"chat\"><a href=\"chat.php?id='$chat'\"><p>$chat</p> <p>$number_value</p></a></div>";?></p>
<?php } ?>