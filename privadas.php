<?php

include_once('config.php');

$user_name = $_SESSION['user'];

$contato = $_GET['id'];
$contato = str_replace("'", "", $contato);

$verificar = "SELECT * FROM contatos WHERE (user_name = '$user_name' AND user_name1 = '$contato') OR (user_name = '$contato' AND user_name1 = '$user_name')";
$resultado = mysqli_query($conn, $verificar) or die(mysqli_error($conn));

if(mysqli_num_rows($resultado) == 0){
    header("location: contatos.php");
    exit();
}

$tipo = "contato";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafhy</title>
    <link rel="stylesheet" href="style/privado.css">
</head>
<body>
    <nav>
        <a href="contatos.php"><</a>
        <a id="btn1"><?php echo $contato;?></a>
    </nav>

    <div class="perfil" id="perfil">
        <aside id="aside">
            <ul>
                <li><?php echo $contato?></li>
                <?php 
                $perfil = mysqli_query($conn, "SELECT * FROM perfil where user_name='$contato'");
                $perfil = mysqli_fetch_assoc($perfil);
                
                ?>
                <li>
                    <div class="img-box"><img src="data:<?php echo $perfil['arquivo']; ?>;base64,<?php echo base64_encode($perfil['foto']); ?>"></div>
                </li>
                
                <li>
                    <p><?php echo $perfil['recado'];?></p>
                </li>
                
                <li id="acesso">
                    
                </li>
            </ul>
        </aside>
        <button class="LeftBar" id="btn2"></button>
    </div>

    <div class="mensagens" id="mensagens">

    </div>

    <input class="mensagens2" id="mensagens2" type="hidden">

    <form id="enviar-mensagem" method="POST">
        <input type="text" id="mensagem" name="mensagem" placeholder="Mensagem" autocomplete="off">
        <input type="submit" value="Enviar" id="submit" name="submit" class="btn">
    </form>
    
</body>
<script src="script/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   var num_novas_mensagens;
   var num_mensagens;

   $(document).ready(function() {

    $('#enviar-mensagem').submit(function(event) {

        console.log("CLIQUE");

        event.preventDefault();
        var mensagem = $('#mensagem').val();
        var tipo = <?php echo $tipo;?>;
        var user_name = '<?php echo $user_name; ?>';
        var destino = '<?php $contato = $_GET['id'];
        $contato = str_replace("'", "", $contato); echo $contato; ?>';
        
        $.ajax({
            url: 'envio.php',
            type: 'POST',
            data:{
                mensagem: mensagem,
                tipo: tipo,
                user_name: user_name,
                destino: destino
            },
            success: function(response) {
            $('#mensagem').val('');
            atualizarMensagens();
            }
        });
    });
    
    function atualizarMensagens() {
        var contato = '<?php echo $contato; ?>';
        num_mensagens = $('#mensagens2 .mensagem').length;
        $.ajax({
        url: 'atualizar_privadas.php',
        type: 'POST',
        data: {
            contato: contato
        },
        success: function(response) {
            $('#mensagens2').html(response)
            num_novas_mensagens = $('#mensagens2 .mensagem').length - num_mensagens;
            if(num_novas_mensagens > 0){
                $('#mensagens').html(response)
                const div = document.querySelector('#mensagens');
                div.scrollTop = div.scrollHeight;

                console.log("Atualizei.");
            }
            else{
                console.log("Nada novo.");
            }
        }
        });
        
    }

    function scroll(){
        const div = document.querySelector('#mensagens');
        div.scrollTop = div.scrollHeight;
    }

    setInterval(atualizarMensagens, 100);

    function atualizarPerfil() {
        var contato = '<?php echo $contato; ?>';
        $.ajax({
        url: 'atualizar_perfil.php',
        type: 'POST',
        data: {
            contato: contato
        },
        success: function(response) {
            $('#acesso').html(response)
        }
        });
        
    }

    setInterval(atualizarPerfil, 100);
    });

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

    

</script>

<style>
    nav:first-of-type a{
       width: 40px;
       transition: 0.2s ease-out;
       z-index: 10000;
    }

    nav:first-of-type a:hover {
        text-decoration: none;
        transform: translateX(-10px);
    }
       
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
        overflow: hidden;
        border: 1px solid (--color);
        border-radius: 50%;
    }

    .img-box img{
        width: 100%;
        height: 100%;
    }

</style>

</html>