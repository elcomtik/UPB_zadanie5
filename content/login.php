<?php
function verify_login(){
    global $db;

    $id = "";
    $name = "";

    //Nahradime
    //$sql = $db->query("SELECT id,name,password FROM admins WHERE name='".$_GET['name']."' AND password='".hash("sha512",$_GET['pass'])."' LIMIT 1");
    //$data = $sql->fetch_array();


    //Tímto
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

//Toto som presunul vyssie
//    if(!empty($data)){
//        $_SESSION['id']  = $id;
//        $_SESSION['name'] = $name;
//        $_SESSION['session_id'] = session_id();
//        return true;
//    }else{
//        return false;
//    }
}

//echo hash("sha512","student");

if(@$_POST['logIN']){ //prerobene na POST
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
    <form method="post" name="login">
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
