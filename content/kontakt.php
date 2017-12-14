<?php
include 'csrf.class.php';

$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);

$action=$_REQUEST['action'];
if ($action=="")    /* display the contact form */
    {
    ?>
    <form  action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="submit">
    <input type="hidden" name="token" value="<?= $token_value; ?>" />
    Your name:<br>
    <input name="name" type="text" value="" size="30"/><br>
    Your email:<br>
    <input name="email" type="text" value="" size="30"/><br>
    Your message:<br>
    <textarea name="message" rows="7" cols="30"></textarea><br>
    <input type="submit" value="Send email"/>
    </form>
    <?php
    }
else                /* send the submitted data */
    {
    if($token_value != $_REQUEST['token']){
        echo "Email maybe sent :D :D :D";
    }
    else {
        $name=$_REQUEST['name'];
        $email=$_REQUEST['email'];
        $message=$_REQUEST['message'];
        if (($name=="")||($email=="")||($message==""))
            {
            echo "All fields are required, please fill <a href=\"\">the form</a> again.";
            }
        else{
            $from="From: $name<$email>\r\nReturn-path: $email";
            $subject="Message sent using your contact form";
            mail("youremail@yoursite.com", $subject, $message, $from);
            echo "Email sent!";
            }
        }
   }
?>
