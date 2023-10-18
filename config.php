<?php

session_start();

$bd_host = 'localhost';
$bd_user = 'root';
$bd_pass = '';
$bd_name = 'grafhy';

$conn = new mysqli($bd_host, $bd_user, $bd_pass, $bd_name);

if(isset($_SESSION['user'])){
    $name = $_SESSION['user'];
}

else{
    $name = "Login";
}

$nav= "<nav>
<div class=\"logo\">Grafy</div>
<div class=\"content\">
    <a href=\"index.php\">Chats</a>
    <a href=\"contatos.php\">Contatos</a>
    <a id=\"btn1\">$name</a>
</div>
</nav>";

$footer = "  <footer>
<p id=\"year\"></p>
<script>
    var data = new Date();
    year.innerText = \"Copyright © \" + data.getFullYear() + \" - Grafhy\";
</script>
</footer>";
?>