<?php

include_once('config.php');

$erro = "";
$email = "";
$userName = "";

if(isset($_POST['submit'])){

    $userName = $_POST['userName'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if(!empty($_POST['email']) && !empty($_POST['senha']) && !empty($_POST['userName'])){

        $sql = "SELECT * FROM users where user_email = '$email'";

        $result = mysqli_query($conn, $sql);

        $sql2 = "SELECT * FROM users where user_name = '$userName'";

        $result2 = mysqli_query($conn, $sql2);

        if(mysqli_num_rows($result) != 0){
        $erro =  "ERRO: Email já cadastrado";
        $email = "";
        }
        else if(mysqli_num_rows($result2)){
        $erro = "ERRO: UserName indisponível";
        $userName = "";
        }
        else{
        
            mysqli_query($conn, "INSERT INTO pre_users VALUES (DEFAULT, '$userName', '$email', '$senha')");

            $resultado = mysqli_query($conn, "SELECT user_id FROM pre_users WHERE user_email = '$email' AND user_pass = '$senha'");
            if(!$resultado){
                die(mysqli_error($conn));
            }
            $usuario = mysqli_fetch_assoc($resultado);
            $_SESSION['pre_user'] = $usuario['user_id'];
            header("location: perfil.php");
        }
    }
    else{
        $erro = "Preencha todos os campos!";
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
        <form action="" method="POST" id="cadastro">
            <legend>CADASTRO</legend>
            <div class="conteudo">
                <input type="text" id="userName" name="userName" placeholder="UserName" autocomplete="off" value="<?php echo $userName;?>">
            </div>
            <div class="conteudo">
                <input type="email" id="email" name="email" placeholder="E-mail" autocomplete="off" value="<?php echo $email;?>">
            </div>
            <div class="conteudo">
                <input type="password" id="senha" name="senha" placeholder="Senha" autocomplete="off">
            </div>

            <div class="erro"><?php echo $erro;?></div>
            
            <input type="submit" id="submit" name="submit" value="Cadastrar">

            <div class="login">
                <a href="login.php" id="c">Fazer login</a>
            </div>
        </form>
    </main>

    <?php echo $footer?>
    
</body>

</html>