<?php
include_once('config.php');

$user_name = $_POST['user_name'];
$data = date("Y-m-d H:i:s");
$query = "UPDATE online_users SET ultima = '$data' WHERE user_name = '$user_name'";
mysqli_query($conn, $query)

?>
