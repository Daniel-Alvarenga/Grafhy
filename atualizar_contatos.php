<?php 

include_once('config.php');

$user_name = $_POST['user_name'];

?>

<?php 

    // $solicit = "SELECT * FROM contatos c 
    // INNER JOIN privado p ON (p.user_name = c.user_name AND p.contato = c.user_name1) OR 
    // (p.user_name = c.user_name1 AND p.contato = c.user_name) 
    // WHERE c.user_name = '$user_name' OR c.user_name1 = '$user_name'
    // ORDER BY p.data_hora DESC";
    
    $solicit = "SELECT * FROM contatos WHERE user_name = '$user_name' OR user_name1 = '$user_name'";
    $result = mysqli_query($conn, $solicit);
    
    while($var = mysqli_fetch_assoc($result)){?>
        <?php 
        
        if($var['user_name'] == $user_name){
            $contato = $var['user_name1'];
        }
        else{
            $contato = $var['user_name'];
        }

        $qtd_a = mysqli_query($conn, "SELECT * FROM privado WHERE (contato = '$user_name' AND user_name = '$contato') OR (contato = '$contato' AND user_name = '$user_name')");
        $qtd = mysqli_num_rows($qtd_a);

        $qtd_v = mysqli_query($conn, "SELECT * FROM visualizadas WHERE contato = '$contato' AND user_name = '$user_name'");

        if(mysqli_num_rows($qtd_v) > 0){
            $visualizadas = mysqli_fetch_assoc($qtd_v)['visualizadas'];
            
            $dif = $qtd - $visualizadas;

            $getlast = mysqli_query($conn, "SELECT * FROM online_users WHERE user_name = '$contato'"); 
            $last = mysqli_fetch_assoc($getlast)['ultima'];

            $current_time = time();
            $last_time = strtotime($last);

            $diff = $current_time - $last_time;

            if($diff<=1){
                if($dif > 0){
                    echo "<div class=\"contato\">
                            <a href=\"privadas.php?id='$contato'\">
                                $contato
                                <div>
                                    <div class=\"notificacao\"></div>
                                    <div class=\"online\"></div>
                                </div>
                            </a>
                        </div>";
                }
                else{
                    echo "<div class=\"contato\">
                            <a href=\"privadas.php?id='$contato'\">
                                $contato
                                <div>
                                    <div class=\"online\"></div>
                                </div>
                            </a>
                            </div>";
                }
            }
            else{
                if($dif > 0){
                    echo "<div class=\"contato\">
                            <a href=\"privadas.php?id='$contato'\">
                                $contato
                                <div>
                                    <div class=\"notificacao\"></div>
                                </div>
                            </a>
                        </div>";
                }
                else{
                    echo "<div class=\"contato\">
                                <a href=\"privadas.php?id='$contato'\">
                                    $contato
                                </a>
                            </div>";
                }
            }
        }
        else{

            $get_last = mysqli_query($conn, "SELECT * FROM online_users WHERE user_name = '$contato'");
            $last = mysqli_fetch_assoc($get_last)['ultima'];

            $current_time = time();
            $last_time = strtotime($last);

            $diff = $current_time - $last_time;

            if($diff<=2){
                echo "<div class=\"contato\">
                        <a href=\"privadas.php?id='$contato'\">
                            $contato
                            <div>
                                <div class=\"online\"></div>
                            </div>
                        </a>
                    </div>";
            }
            else{
                echo "<div class=\"contato\">
                        <a href=\"privadas.php?id='$contato'\">$contato</a>
                    </div>";
            }
            
        }
        
        ?>
<?php } ?>

<?php 
    $solicit = "SELECT * FROM acessos_grupos WHERE user_name = '$user_name'";
    $result = mysqli_query($conn, $solicit);
    
    while($var = mysqli_fetch_assoc($result)){
        
        $grupo = $var['grupo'];
        $n = mysqli_query($conn, "SELECT user_number FROM grupos WHERE grupo = '$grupo'");
        $n = mysqli_fetch_assoc($n)['user_number'];

        echo "<div class=\"contato\"><a href=\"grupo.php?id='$grupo'\"><p>" . $grupo . "</p><div>".$n."
        <svg fill=\"none\" height=\"24\" stroke-width=\"1.5\" viewBox=\"0 0 24 24\" width=\"24\">
            <path d=\"M1 20V19C1 15.134 4.13401 12 8 12V12C11.866 12 15 15.134 15 19V20\" stroke=\"currentColor\" stroke-linecap=\"round\"/>
            <path d=\"M13 14V14C13 11.2386 15.2386 9 18 9V9C20.7614 9 23 11.2386 23 14V14.5\" stroke=\"currentColor\" stroke-linecap=\"round\"/>
            <path d=\"M8 12C10.2091 12 12 10.2091 12 8C12 5.79086 10.2091 4 8 4C5.79086 4 4 5.79086 4 8C4 10.2091 5.79086 12 8 12Z\" stroke=\"currentColor\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
            <path d=\"M18 9C19.6569 9 21 7.65685 21 6C21 4.34315 19.6569 3 18 3C16.3431 3 15 4.34315 15 6C15 7.65685 16.3431 9 18 9Z\" stroke=\"currentColor\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>
        </svg></div></a></div>";
    } ?>

<?php 
$solicit = "SELECT * FROM solicitacoes WHERE user_name_recebe = '$user_name'";
$result = mysqli_query($conn, $solicit);

if(mysqli_num_rows($result) > 0){

while($var = mysqli_fetch_assoc($result)){ 
    if($var['situacao'] == 0){?>
    <form name="form2" method="POST" class="contato2">
        <div>
            <p><?php echo "Pedido de: " . $var['user_name_envia'];?></p>
            <p class="data"><?php echo $var['data_hora'];?></p>
        </div>
        <div class="acr">
            <button type="submit" name="aceitar" value="<?php echo $var['id'];?>">Aceitar</button>
            <button type="submit" name="recusar" value="<?php echo $var['id'];?>">Recusar</button>
        </div>
    </form>
<?php }}} ?>

<?php 
    $solicit = "SELECT * FROM solicitacoes WHERE user_name_envia = '$user_name'";
    $result = mysqli_query($conn, $solicit);
    if(mysqli_num_rows($result) > 0){
    while($var = mysqli_fetch_assoc($result)){
    if($var['situacao'] == 0){?>
    <form name="form3" method="POST" class="contato2">
        <div>
            <p><?php echo "Para: " . $var['user_name_recebe'];?></p>
            <p class="data"><?php echo $var['data_hora'];?></p>
        </div>
        <button type="submit" name="excluir" value="<?php echo $var['id'];?>">Apagar</button>
    </form>
<?php } } }?>
    
<?php 
$solicit = "SELECT * FROM convites WHERE user_name_recebe = '$user_name'";
$result = mysqli_query($conn, $solicit);

if(mysqli_num_rows($result) > 0){

while($var = mysqli_fetch_assoc($result)){ 
    
    $grupo = $var['grupo'];?>

    <form name="form7" method="POST" class="contato2">
        <div>
            <p><?php echo "Convite para " . $grupo;?></p>
            <p class="data"><?php echo $var['data_hora'];?></p>
        </div>
        <div class="acr">
            <button type="submit" name="entrar" value="<?php echo $var['id'];?>">Entrar</button>
            <button type="submit" name="recusargrupo" value="<?php echo $var['id'];?>">Recusar</button>
        </div>
    </form>
<?php }} ?>