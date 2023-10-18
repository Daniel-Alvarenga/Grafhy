<?php

include_once('config.php');

if(!isset($_SESSION['pre_user'])){
  header("location: cadastro.php");
}
else{  
    $user_id = $_SESSION['pre_user'];
}

$erro = "";
$erro_perfil = "";
$text = "";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['submit'])){
    if(!empty($_POST['text'])){
        $userName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_name FROM pre_users WHERE user_id = '$user_id'"))['user_name'];
        $email = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_email FROM pre_users WHERE user_id = '$user_id'"))['user_email'];
        $senha = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_pass FROM pre_users WHERE user_id = '$user_id'"))['user_pass'];
        $text = $_POST['text'];
    
        $image = file_get_contents($_FILES['imagem']['tmp_name']);
        $tipo = $_FILES['imagem']['type'];

        $stmt = $conn->prepare("INSERT INTO perfil (user_name, recado, arquivo, foto) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $userName, $text, $tipo, $image);
        
        if($stmt->execute()){
            $data = date("Y-m-d H:i:s");
            mysqli_query($conn, "INSERT INTO users VALUES (DEFAULT, '$userName', '$email', '$senha')");
            mysqli_query($conn, "DELETE FROM pre_users WHERE user_id = '$user_id'");
            mysqli_query($conn, "INSERT INTO online_users VALUES ('$userName', '$data')");
            $resultado = mysqli_query($conn, "SELECT user_name FROM users WHERE user_email = '$email' AND user_pass = '$senha'");
            $usuario = mysqli_fetch_assoc($resultado);
            $_SESSION['user'] = $usuario['user_name'];
            header("location: index.php");
        } else {
            echo "<script> alert(\"Erro inserir imagem no banco de dados.\");</script>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $erro_perfil = "Preecha todos os campos!";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafhy</title>
    <link rel="stylesheet" href="style/cadastro.css">
</head>
<body>
    
    <?php echo $nav?> 
    
    <main>
        </form>
        <form action="" method="POST" id="perfil" enctype="multipart/form-data">
            <legend>PERFIL</legend>
            <div class="conteudo">
                <input type="file" id="imagem" name="imagem" placeholder="Imagem de Perfil">
            </div>
            <div class="conteudo">
                <input type="text" id="text" name="text" placeholder="Sobre mim" autocomplete="off" value="">
            </div>
            <div class="erro"><?php echo $erro_perfil;?></div>

            <input type="submit" id="submit" name="submit" value="Concluir Cadastro" style="width: 80%;">

            <div class="login">
                <a href="login.php" id="c">Fazer login</a>
            </div>
        </form>
    </main>

    <?php echo $footer?>
    
</body>
<script src="script.js"></scrip>
</html>

<style>
    #perfil{
        display: none;
    }

    input[type="submit"]{
        width: 80%;
    }

</style>