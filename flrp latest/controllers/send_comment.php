<?php
/**
 * Created by PhpStorm.
 * User: toluo
 * Date: 10/07/2018
 * Time: 06:28
 */

$page = "users";

require('../models/User.php');
//phpinfo();

$error = null;
$success = null;

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    if (!empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['name'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $name = $_POST['name'];
        $isadmin = $_POST['isadmin'];
        $organization = $_POST['organization'];

        if($password == $cpassword) {
            try {
                \FMDQ\FLRP\User::save($email, $name, $password, $isadmin, $organization);
                $success = "Successfully saved the record";
            }catch(Exception $ex){
                $error = $ex->getMessage();
            }
        }else{
            $error = "Password mismatch";
        }
    }else{
        $error = "Invalid parameters posted";
    }
}
?>

<!doctype html>
<html lang="en" class="no-js">
<?php include("../views/baseview-head.php")?>
<body>
<div id="container" class="container">
    <!-- header -->
    <header class="sidebar-section">
        <div class="header-logo">
            <a class="logo" href="#"><img alt="" src="../img/fmdq-logo.png"></a>
        </div>
    </header>
    <?php include("../views/baseview-menu.php")?>




    <?php
    if(isset($_POST['email'])) {

        $email_to = "grg@fmdqotc.com";
        $email_subject = "comment & feedback";

        function died($error) {
            // your error code can go here
            echo "We are very sorry, but there were error(s) found with the form you submitted. ";
            echo "These errors appear below.<br /><br />";
            echo $error."<br /><br />";
            echo "Please go back and fix these errors.<br /><br />";
            die();
        }


        // validation expected data exists
        if(!isset($_POST['name']) ||
            !isset($_POST['email']) ||
            !isset($_POST['telephone']) ||
            !isset($_POST['comments'])) {
            died('We are sorry, but there appears to be a problem with the form you submitted.');
        }

        $name = $_POST['name']; // required
        $email = $_POST['email']; // required
        $telephone = $_POST['telephone']; // not required
        $comments = $_POST['comments']; // required

        $error_message = "";
        $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

        if(!preg_match($email_exp,$email)) {
            $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
        }

        $string_exp = "/^[A-Za-z .'-]+$/";

        if(!preg_match($string_exp,$name)) {
            $error_message .= 'The Name you entered does not appear to be valid.<br />';
        }


        if(strlen($comments) < 2) {
            $error_message .= 'The Comments you entered do not appear to be valid.<br />';
        }

        if(strlen($error_message) > 0) {
            died($error_message);
        }

        $email_message = "Form details below.\n\n";


        function clean_string($string) {
            $bad = array("content-type","bcc:","to:","cc:","href");
            return str_replace($bad,"",$string);
        }

        $email_message .= "Name: ".clean_string($name)."\n";
        $email_message .= "Email: ".clean_string($email)."\n";
        $email_message .= "Telephone: ".clean_string($telephone)."\n";
        $email_message .= "Comments: ".clean_string($comments)."\n";

// create email headers
        $headers = 'From: '.$email."\r\n".
            'Reply-To: '.$email."\r\n" .
            'X-Mailer: PHP/' . phpversion();
        @mail($email_to, $email_subject, $email_message, $headers);
        ?>

        <!-- include your own success html here -->

        <h3>Thank you for your comment, you will get a feedback very soon.</h3>
        <br>

        <?php
    }
    ?>


    <?php include("../views/baseview-footer.php")?>
</div>

<?php include("../views/baseview-scripts.php")?>
</body>
