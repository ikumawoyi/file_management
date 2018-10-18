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
$name ='';

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {

    if (!empty($_POST['name'])) {
    }

    if (!empty($_POST['email'])) {

        $name = $_POST['name'].'';
        $email = $_POST['email'].'';

        $rand = substr((rand()), 0, 12);
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

    $body = "Dear: $name, \n Your password reset is successful. Kindly see below your new password: \n $rand";

    $mail->addAddress("$email", 'flrp');
    $mail->Subject = 'Forgot Password';
    $mail->Body = $body;
//    if (!$mail->send()) {
//        //echo 'Email could not be sent.';
//        echo "$rand";
//        echo $mail->ErrorInfo;
//    } else {
//        echo 'Email has been sent';
//    };
    if($mail->Send())
        echo "Request processed, check your email to get new password! ";
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
    <header class="sidebar-section">

    </header>
    <!--    </div>-->
    <div id="content">
        <div class="box-section contact-section triggerAnimation animated" data-animate="flipInY">

            <p> <strong>To get new password, kindly fill the form below. </strong>  </p>

            <form id="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="text-fields">

                    <div class="float-input">
                        <input name="name" id="name" type="text" required = "required" placeholder="name">
                        <span><i class="fa fa-user"></i></span>
                    </div>


                    <div class="float-input">
                        <input name="email" id="email" type="text" required = "required" placeholder="e-mail">
                        <span><i class="fa fa-envelope-open"></i></span>
                    </div>

                    <div class="float-input">
                        <button type="submit" name="submit" style="font-size:25px">Request Reset
                            <i class="fa fa-key" style="font-size:30px;color:white"></i>
                        </button>
                    </div>
                    <div align="centre">
                        <a href="login.php">Login?</a>
                        <span><i class="fa fa-lock-open"></i></span>
                    </div>
                </div>
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