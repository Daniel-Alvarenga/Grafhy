<?php

include_once('config.php');

if(!isset($_SESSION['user'])){
    header('location: login.php');
}
else{
    $user_name = $_SESSION['user'];
}

if(isset($_POST['submit']) && !empty($_POST['chave'])){
    $chave = $_POST['chave'];
    $chave = str_replace(' ', '_', $_POST['chave']);

    $seeKey = "SELECT * FROM chats where chat_name = '$chave'";
    $result = mysqli_query($conn, $seeKey);

    if(mysqli_num_rows($result) == 0){
        mysqli_query($conn, "INSERT INTO chats VALUES (DEFAULT, '$chave', '1', '1')");
        mysqli_query($conn, "INSERT INTO acessos VALUES (DEFAULT, '$user_name', '$chave');");
        mysqli_query($conn, "CREATE TABLE $chave (mensagem_id INT AUTO_INCREMENT PRIMARY KEY, mensagem TEXT NOT NULL, data_hora VARCHAR(20) NOT NULL, user_name VARCHAR(100) NOT NULL)");
    }
    
    else{
        $seeKey = "SELECT * FROM acessos WHERE chat_name = '$chave' AND user_name = '$user_name'";
        $result = mysqli_query($conn, $seeKey);

        if(mysqli_num_rows($result) == 0){

            mysqli_query($conn, "INSERT INTO acessos VALUES (DEFAULT, '$user_name', '$chave');");

            $seeNumber = "SELECT user_number FROM chats where chat_name = '$chave'";
            $userNumber = mysqli_query($conn, $seeNumber);
            $row = mysqli_fetch_assoc($userNumber);
            $number_n = $row['user_number'];

            $number_n = $number_n + 1;

            mysqli_query($conn, "UPDATE chats SET user_number = '$number_n' WHERE chat_name = '$chave'");
        }
    }

    header("location: chat.php?id='$chave'");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafhy</title>
    <link rel="stylesheet" href="style/index.css">
</head>
<body>

    <?php echo $nav?>

    <div class="perfil" id="perfil">
        <aside id="aside">
            <ul>
                <li><?php echo $user_name?></li>
                <?php 
                $perfil = mysqli_query($conn, "SELECT * FROM perfil where user_name='$user_name'");
                $perfil = mysqli_fetch_assoc($perfil);
                $user = mysqli_query($conn, "SELECT * FROM users where user_name='$user_name'");
                $user = mysqli_fetch_assoc($user);
                
                ?>
                <li>
                    <div class="img-box"><img src="data:<?php echo $perfil['arquivo']; ?>;base64,<?php echo base64_encode($perfil['foto']); ?>"></div>
                </li>
                
                <li>
                    <p><?php echo $perfil['recado'];?></p>
                </li>
                
                <li>
                    <p><?php echo $user['user_email'];?></p>
                </li>
            </ul>
        </aside>
        <button class="LeftBar" id="btn2"></button>
    </div>

    <form action="" method="POST" id="setChave">
        <div class="conteudo">
            <label>Chave: </label>
            <input type="text" id="chave" name="chave" placeholder="public chat" autocomplete="off">
        </div>
        <input type="submit" id="submit" name="submit" value="Acessar">
        </form>

    <main>
        <div class="chats" id="chats">
            
        </div>
    </main>

    <?php echo $footer?>
     
</body>

<script src="script/script.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function atualizarLastOnline() {
        var user_name = '<?php echo $user_name; ?>';
        $.ajax({
            url: 'online.php',
            type: 'POST',
            data: {
            user_name: user_name
            },
            success: function(response) {
            },
            error: function(xhr, status, error) {
            console.log("Erro no AJAX: " + error);
            }
        });
    }

    setInterval(atualizarLastOnline, 100);

    atualizarConexoes();

    function atualizarConexoes() {
        var user_name = '<?php echo $user_name; ?>';
        $.ajax({
        url: 'atualizar_chats.php',
        type: 'POST',
        data: {
            user_name: user_name
        },
        success: function(response) {
            $('#chats').html(response);
        }
        });
        
    }

    setInterval(atualizarConexoes, 1000);
</script>
</html>

<style>
    .perfil{
        display: none;
        flex-direction: row-reverse;
        height: 100vh;
        position: fixed;
        right: -300px;
        width: 100vw;
        height: 100vh;
        z-index: 1001;
        overflow: hidden;
    }

    #btn1{
        height: auto;
        width: auto;
    }

    #btn2{
        height: 100%;
        width: calc(100vw - 300px);
        display: none;
        background-color: transparent;
        border: none;
    }

    aside{
        display: flex;
        flex-direction: column;
        width: 300px;
        backdrop-filter: blur(15px);
        background-color:  rgba(0, 0, 0, 0.397);
        border-left: var(--color) solid 1px;
    }

    aside ul{
        height: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
    }

    aside ul li{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #fff;
    }

    aside ul li{
        color: #fff;
    }

    aside ul li a{
        text-decoration: none;
        color: #fff;
        font-size: 20px;
        font-family: Arial, Helvetica, sans-serif;
    }


    .fechar{
        animation: fechar .2s ease-out;
        right: -300px;
        top: 0px;
        position: fixed;
        display: flex;
        flex-direction: row-reverse;
        height: 100vh;
        z-index: 1001;
        overflow: hidden;
    }

    .abrir{
        animation: abrir .2s ease-out;
        right: 0px;
        top: 0px;
        position: fixed;
        display: flex;
        flex-direction: row-reverse;
        height: 100vh;
        z-index: 1001;
        overflow: hidden;
    }

    @keyframes abrir {
        0%{
            right: -300px;
        }
        100%{
            leright: 0px;
        }
    }

    @keyframes  fechar{
        0%{
            right: 0px;
        }
        100%{
            right: -300px;
        }
    }

    li p{
        margin: 20px;
    }

    .img-box{
        width: 160px;
        height: 160px;
        object-fit: cover;
        background-size: cover;
        background-position: center;
        overflow: hidden;
        border: 1px solid (--color);
        border-radius: 50%;
    }

    .img-box img{
        width: 100%;
        height: 100%;
    }
</style>