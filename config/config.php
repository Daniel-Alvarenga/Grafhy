<?php

session_start();

$bd_host = 'localhost';
$bd_user = 'root';
$bd_pass = '';
$bd_name = 'grafhy';

$conn = new mysqli($bd_host, $bd_user, $bd_pass, $bd_name);

$imagem = "";

if(isset($_SESSION['user'])){
    $name = $_SESSION['user'];

    $perfil = mysqli_query($conn, "SELECT * FROM perfil where user_name='$name'");
    $perfil = mysqli_fetch_assoc($perfil);
    
    $imagem = "<img src=\"data:" . $perfil['arquivo'] . ";base64," . base64_encode($perfil['foto']) . "\" class=\"profile\"/>";
}

else{
    $name = "Login";
}

echo "
<style>
    .content{
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile{
        width: 45px;
        height: 45px;
        border-radius: 50%; 
    }
</style>
";


$nav= "<nav>
<div class=\"logo\">Grafy</div>
<div class=\"content\">
    <a href=\"../\">Chats</a>
    <a href=\"pages/contatos.php\">Contatos</a>
    <a id=\"btn1\">$name</a>"
    . $imagem . 
"</div>
</nav>";

$footer = "  <footer>
<p id=\"year\"></p>
<script>
    var data = new Date();
    year.innerText = \"Copyright © \" + data.getFullYear() + \" - Grafhy\";
</script>
</footer>";
?>