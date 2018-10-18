<?php
/**
 * Created by PhpStorm.
 * User: Trusoft Limited
 * Date: 7/18/2018
 * Time: 10:53 AM
 */


$page = "forgotPassword";

require('../models/User.php');
//phpinfo();


$email = '';
$success = '';
$error = '';

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {

    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['cpassword'])) {

        $email = $_POST['email'].'';
        $password = $_POST['password'].'';
        $cpassword = $_POST['cpassword'].'';
        $opassword = $_POST['opassword'].'';

        $rand = $password;
        try {
            \FMDQ\FLRP\User::updatePass($email,$rand);
            $success = "Successfully updated the record";
        }
        catch (Exception $ex) {
            $error = $ex->getMessage();
        }
    }

    require '../PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ayotunde@trusoftng.com';
    $mail->Password = 'Ikumawoyi@1';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('ayotunde@trusoftng.com', 'FLRP Admin');

    $body = "Your New Password Is: $rand";

    $mail->addAddress("$email", 'flrp');
    $mail->Subject = 'Reset Password';
    $mail->Body = $body;
//    if (!$mail->send()) {
//        //echo 'Email could not be sent.';
//        echo "$rand";
//        echo $mail->ErrorInfo;
//    } else {
//        echo 'Email has been sent';
//    };
    if($mail->Send())
        echo "Your request was Successfully, check your email to get password!";
    else
        echo "Fail - " . $mail->ErrorInfo. $mail->SMTPDebug = 2;


};
?>


<!doctype html>
<html lang="en" class="no-js">
<?php include("../views/baseview-head.php") ?>
<body>
<div id="container" class="container">
    <!--    <div id="sidebar">-->

    <!-- header -->
    <div class="header-logo">
        <a class="logo" href="#"><img alt="" height ="70px" width="150px" src="../img/fmdq-logo.png"></a>
    </div>
    <header class="sidebar-section">

    </header>
    <!--    </div>-->
    <div id="content">
        <div class="box-section contact-section triggerAnimation animated" data-animate="flipInY">

            <h2> Enter the details with which you registered </h2>

            <form id="contact-form" method="post" action="">
                <div class="text-fields">

                    <div class="float-input">
                        <input name="email" id="email" type="text" required = "required" placeholder="e-mail">
                        <span><i class="fa fa-envelope-open"></i></span>
                    </div>
                    <div class="float-input">
                        <input name="opassword" id="opassword" type="password" required = "required" placeholder="password">
                        <span><i class="fa fa-lock-open"></i></span>
                    </div>
                    <div class="float-input">
                        <input name="password" id="password" type="password" required = "required" placeholder="New password">
                        <span><i class="fa fa-lock-open"></i></span>
                    </div>
                    <div class="float-input">
                        <input name="cpassword" id="cpassword" type="password" required = "required" placeholder="Confirm new password">
                        <span><i class="fa fa-lock-open"></i></span>
                    </div>
                    <div class="float-input">
                        <button type="submit" name="submit" style="font-size:25px">Request Reset
                            <i class="fa fa-key" style="font-size:25px;color:white"></i>
                        </button>
                    </div>
                    <div align="centre">
                        <a href="login.php">Login?</a>
                        <span><i class="fa fa-lock-open"></i></span>
                    </div>

                </div>

                <!--<div class="comment-area">
                    <textarea name="comment" id="comment" placeholder="Message"></textarea>
                </div>-->
                <div class="submit-area">

                </div>

            </form>


        </div>
        <?php include("../views/baseview-footer.php")?>
    </div>
</div>
<?php include("../views/baseview-scripts.php") ?>
</body>
</html>