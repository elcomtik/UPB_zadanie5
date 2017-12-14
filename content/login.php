<?php
include 'csrf.class.php';

$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);

//function verify_login($token_value){
function verify_login(){
    /*if($token_value != $_GET['token']){
        return false;
    }*/
    global $db;
    $id = "";
    $name = "";
    if ($stmt = $db->prepare('SELECT id,name,password FROM admins WHERE name="?" AND password="?" LIMIT 1')) {

        /* bind parameters for markers */
        $stmt->bind_param("ss", $_POST['name'], hash("sha512",$_POST['pass']));

        /* execute query */
        $stmt->execute();


        /* bind result variables */
         $stmt->bind_result($id, $name);

        /* fetch value */
        $stmt->fetch();

        if(isset($id) && isset($name)){
            $_SESSION['id']  = $id;
            $_SESSION['name'] = $name;
            $_SESSION['session_id'] = session_id();
            return true;
        }else{
            return false;
        }

    /* close statement */
    $stmt->close();

}

if(@$_GET['logIN']){
    //if(verify_login($token_value)) {
    if(verify_login()) {
        header('LOCATION: index.php');
    }else{
        $error = "Wrong name or password!! Pls try it again!!";
    }
}
?>
<?if(!isLogin()){?>
<div style="width:20%;">
    <?=@$error?>
    <form method="get" name="login">
        //<input type="hidden" name="token" value="<?php $token_value; ?>" />
        <label>Meno</label>
        <input name="name" value="" type="text" placeholder="LamaCoder" autofocus />
        <label>Heslo</label>
        <input name="pass" value="" type="password" placeholder="********" />
        <br />
        <button class="button" name="logIN" value="1">Prihlasiť</button>
    </form>
</div>
<?}else{?>
    <div style="width:20%;">
        <?=@$error?>
        <a href="./?page=logout.php"><button class="button">Odhlásiť sa</button></a>
    </div>
<?}?>
