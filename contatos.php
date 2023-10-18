<?php

include_once('config.php');

if(!isset($_SESSION['user'])){
    header('location: login.php');
}
else{
    $user_name = $_SESSION['user'];
}

$erro2 = "";

if(isset($_POST['submit']) && !empty($_POST['solicitacao'])){

    $userSelect = $_POST['solicitacao'];

   if($userSelect != $user_name){
    $verificar = "SELECT user_name FROM users WHERE user_name = '$userSelect'";

    $resultado = mysqli_query($conn, $verificar);

    $userNameReceiv = $_POST['solicitacao'];
    $userNameSend = $_SESSION['user'];
    $data = date("Y-m-d H:i:s");

    $contato = mysqli_query($conn, "SELECT * FROM users WHERE user_name = '$user_name'");
    $contato2 = mysqli_query($conn, "SELECT * FROM users WHERE user_name = '$userNameReceiv'");

    if(mysqli_num_rows($contato) > 0 && mysqli_num_rows($contato2) > 0){
        $verificar = mysqli_query($conn, "SELECT * FROM solicitacoes WHERE user_name_recebe = '$userNameReceiv' AND user_name_envia = '$userNameSend'");

        if(mysqli_num_rows($verificar) > 0){
            $erro = "ERRO: Já existe uma solicitação de ou para ".$userNameReceiv;
        }
        else{
            $verificar = mysqli_query($conn, "SELECT * FROM contatos WHERE (user_name = '$userNameReceiv' AND user_name1 = '$userNameSend') OR (user_name1 = '$userNameReceiv' AND user_name = '$userNameSend')");
            if(mysqli_num_rows($verificar) > 0){
                $erro = "ERRO: ".$userNameReceiv." já é um contato.";
            }
            else{
                if(!empty($userNameReceiv) && !empty($userNameSend))
                mysqli_query($conn, "INSERT INTO solicitacoes VALUES (DEFAULT, '$userNameReceiv', '$userNameSend', '$data', '0')");
                $erro = "";
            }
        }
    }
    else{
        $erro = "ERRO: Usuário não encontrado";
    }
}

}

if(isset($_POST['aceitar'])){
    $id = $_POST['aceitar'];

    $contato1 = $user_name;

    $solicit = "SELECT user_name_envia FROM solicitacoes WHERE id = '$id'";
    $contato2_result = mysqli_query($conn, $solicit);
    $contato2 = mysqli_fetch_assoc($contato2_result)['user_name_envia'];

    $s = "SELECT * FROM contatos WHERE (user_name = '$user_name' AND user_name1 = '$contato2') OR(user_name = '$contato2' AND user_name1 = '$user_name')";
    $r = mysqli_query($conn, $s);

    if(mysqli_num_rows($r) == 0){
        mysqli_query($conn, "INSERT INTO contatos VALUES (DEFAULT, '$contato1', '$contato2')");
        mysqli_query($conn, "DELETE FROM solicitacoes WHERE id = '$id'");
        mysqli_query($conn, "INSERT INTO visualizadas VALUES ('DEFAULT', '$contato1', '$contato2', '0')");
        mysqli_query($conn, "INSERT INTO visualizadas VALUES ('DEFAULT', '$contato2', '$contato1', '0')");
    }  
}

if(isset($_POST['recusar'])){
    $id = $_POST['recusar'];
    mysqli_query($conn, "DELETE FROM solicitacoes WHERE id = '$id'");
}

if(isset($_POST['excluir'])){
    $id = $_POST['excluir'];
    mysqli_query($conn, "DELETE FROM solicitacoes WHERE id = '$id'");
}

if(isset($_POST['contato'])){
    $id = $_POST['contato'];
   
    header("location: privadas.php?id='$id'");
}

if(isset($_POST['criargrupo'])){
    if(!empty($_POST['grupo'])){
        $grupo = $_POST['grupo'];

        $s = "SELECT * FROM grupos WHERE grupo = '$grupo'";
        $r = mysqli_query($conn, $s);

        if(mysqli_num_rows($r) == 0){
            mysqli_query($conn, "INSERT INTO grupos VALUES (DEFAULT, '$grupo', '1', '1')");
            mysqli_query($conn, "INSERT INTO acessos_grupos VALUES (DEFAULT, '$user_name', '$grupo')");
        }
    }
    else{
        $erro2 = "Insira um nome!";
    }
}

if(isset($_POST['entrar'])){
    $id = $_POST['entrar'];

    $solicit = "SELECT grupo FROM convites WHERE id = '$id' ORDER BY grupo";
    $grupo_result = mysqli_query($conn, $solicit);
    $grupo = mysqli_fetch_assoc($grupo_result)['grupo'];

    $s = "SELECT * FROM acessos_grupos WHERE user_name = '$user_name' AND grupo = '$grupo' ORDER BY grupo";
    $r = mysqli_query($conn, $s);

    if(mysqli_num_rows($r) == 0){
        mysqli_query($conn, "INSERT INTO acessos_grupos VALUES (DEFAULT, '$user_name', '$grupo')");

        $seeNumber = "SELECT user_number FROM grupos where grupo = '$grupo'";
        $userNumber = mysqli_query($conn, $seeNumber);
        $row = mysqli_fetch_assoc($userNumber);
        $number_n = $row['user_number'];

        $number_n = $number_n + 1;

        mysqli_query($conn, "UPDATE grupos SET user_number = '$number_n' WHERE grupo = '$grupo'");

        mysqli_query($conn, "DELETE FROM convites WHERE id = '$id'");
    }  
}

if(isset($_POST['recusargrupo'])){
    $id = $_POST['recusargrupo'];
    mysqli_query($conn, "DELETE FROM convites WHERE id = '$id'");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafhy</title>
    <link rel="stylesheet" href="style/contato.css">
</head>
<body>

    <nav>
    <div class="logo\">Grafy</div>
    <div class="content">
        <a href="index.php">Chats</a>
        <a id="c4">Contatos</a>
        <a id="btn1"><?php echo $name?></a>
    </div>
    </nav>
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
    
   <main>
        
        <div class="contatos" id="contatos">
            
        </div>
       
        <div id="c3">+</div>
        
        <div id="newGroup">
            <div id="a"></div>
            <form action="" method="POST" id="criar" class="setChave" name="criar">
                <div class="conteudo">
                    <label>Criar grupo: </label>
                    <input type="text" id="grupo" name="grupo" placeholder="Nome" autocomplete="off">
                </div>
                <div class="erro"><?php if(isset($erro2)){echo $erro2;}?></div>
                <input type="submit" id="submit" name="criargrupo" value="Criar Grupo">
            </form>
        </div>

        <div id="newGroup1">
            <div id="b">
            </div>
            <form action="" method="POST" class="setChave" id="criar">
                <div class="conteudo">
                    <label>Procurar: </label>
                    <input type="text" id="solicitacao" name="solicitacao" placeholder="UserName" autocomplete="off">
                </div>
                <div class="erro">
                    <?php if(isset($erro)){echo $erro;}?>
                </div>
                <input type="submit" id="submit" name="submit" value="Enviar solicitação">
            </form>
        </div>
        
       

   </main>

   <?php echo $footer?>
   
</body>

<script src="script/script.js"></script>
 
<script>
    document.getElementById('c3').onclick = () => {
        newGroup.style.display = "flex";
    }

    document.getElementById('a').onclick = () => {
        newGroup.style.display = "none";
    }
    document.getElementById('c4').onclick = () => {
        newGroup1.style.display = "flex";
    }

    document.getElementById('b').onclick = () => {
        newGroup1.style.display = "none";
    }
    
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    function atualizarConexoes() {
        var user_name = '<?php echo $user_name; ?>';
        $.ajax({
        url: 'atualizar_contatos.php',
        type: 'POST',
        data: {
            user_name: user_name
        },
        success: function(response) {
            $('#contatos').html(response);
        }
        });
        
    }

    setInterval(atualizarConexoes, 1000);

    atualizarConexoes();

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
        });
    }

    setInterval(atualizarLastOnline, 100);


</script>

<style>
    main{
        position: relative;
    }

    #c3{
        position: absolute;
        height: 45px;
        width: 45px;
        color: var(--fonteColor);
        border: 1px solid var(--color);
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        bottom: 5px;
        right: 5px;
    }

    #c3:hover{
        position: absolute;
        color: var(--color2);
        box-shadow: 0px 0px 5px var(--color);
        background-color: var(--color);
    }

    svg{
        width: 25px;
        height: 25px;
        color: var(--fonteColor);        
    }

    .contato a{
        display: flex;
        justify-content: space-between;
        padding-left: 20px;
        padding-right: 20px;
    }

    .contato a div{
        display: flex;
    }
    .contato a div div{
        margin-left: 5px;
        box-shadow: inset 0px 0px 2px #FFF;
    }

    .notificacao{
        background-color: white;
        width: 10px; height: 10px;
        border-radius: 5px;
    }

    .online{
        background-color: rgb(0, 255, 0);
        width: 10px; height: 10px;
        border-radius: 5px;
    }

    #newGroup, #newGroup1{
        top: 0;
        position: fixed;
        display: none;
        margin: 0px;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.342);
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    #newGroup form, #newGroup1 form{
        position: fixed;
        width: 450px;
        height: 200px;
        border-radius: 10px;
        border: 1px solid var(--color);
        z-index: 2000;
    }

    #a, #b{
        position: absolute;
        width: 100vw;
        height: 100vh;
        z-index: 1000;
    }

    #ab{
        padding: 5px;
        display: flex;
        flex-direction: column;
        height: 15vh;
    }
    
    #n{
        display: none;
    }

    #contatos{
        width: 80%;
        height: 100%;
        border: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 5px;
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