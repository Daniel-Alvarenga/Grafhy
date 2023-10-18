<?php

include_once('config.php');

$erro = "";
$email = "";
$senha = "";

if(isset($_POST['submit'])){
    if(!empty($_POST['email']) && !empty($_POST['senha'])){
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM users where user_email = '$email' AND user_pass = '$senha'";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) == 0){
            $erro = "ERRO: email ou senha inválidos";
        }
        else{
            $resultado = mysqli_query($conn, "SELECT user_name FROM users WHERE user_email = '$email' AND user_pass = '$senha'");
            $usuario = mysqli_fetch_assoc($resultado);
            $_SESSION['user'] = $usuario['user_name'];
            header('location: index.php');
            $erro = "";
        }
    }
    else{
        $erro = "Preencha todos os campos!";
    }

    $senha = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafhy</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>

    <?php echo $nav?> 
    
    <main>
        <form action="" method="POST" id="login">
            <legend>LOGIN</legend>
            <div class="conteudo">
                <input type="email" id="email" name="email" placeholder="E-mail" autocomplete="off" value="<?php echo $email;?>">
            </div>
            <div class="conteudo">
                <input type="password" id="senha" name="senha" placeholder="Senha" autocomplete="off" value="<?php echo $senha;?>">
            </div>

            <div class="erro"><?php echo $erro?></div>
    
            <input type="submit" id="submit" name="submit" value="Login" autocomplete="off">

            <div class="cadastre">
                <a href="cadastro.php" id="c">Cadastre-se</a>
            </div>
        </form>
    </main>

    <?php echo $footer?>
    
</body>
<script src="script.js"></script>
</html>