<?php

$page = "comments";

if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $comment = $_POST['comment'];
    $from = 'Comment Form';
    $to = "tobainocycle@gmail.com";
    $subject = 'Comment from User ';

    $body ="From: $name\n E-Mail: $email\n Phone: $telephone\n Comment:\n $comment";

    // Check if name has been entered
    if (!$_POST['name']) {
        $errName = 'Please enter your name';
    }

    // Check if email has been entered and is valid
    if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errEmail = 'Please enter a valid email address';
    }

    //Check if comment has been entered
    if (!$_POST['comment']) {
        $errComment = 'Please enter your comment';
    }


    require '../PHPMailer/PHPMailerAutoload.php';
//        set_time_limit(60);
    $mail = new PHPMailer;
    $mail->isSMTP();

//$mail->Timeout = 120;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail-> isHTML();
    $mail->Username = 'ayotunde@trusoftng.com';
    $mail->Password = 'Ikumawoyi@1';
    $mail->Port = 465;
    $mail->setFrom('ayotunde@trusoftng.com', 'FLRP Admin');
    $mail->addAddress('tobainocycle@gmail.com', 'FMDQ');
    $mail->Subject = "Comment From: $name";
    $mail->Body    = $body;
//    if(!$mail->send())
////    {
//        echo "Comment sent";
//    }

    if($mail->Send())
        echo "Your comment has been Successfully sent!";
    else
        echo "Fail - " . $mail->ErrorInfo. $mail->SMTPDebug = 2;


}


?>

<!doctype html>
<html lang="en" class="no-js" xmlns:background="http://www.w3.org/1999/xhtml">
<?php include("../views/baseview-head.php")?>
<body>

<!--<div id="container" class="container">-->
    <!-- header -->

<!--    <div class="header-logo">-->
<!--        <a class="logo" href="#"><img alt="" height ="70px" width="150px" src="../img/fmdq-logo.png"></a>-->
<!--    </div>-->

    <header class="sidebar-section">

    </header>

    <?php include("../views/baseview-menu.php")?>


<div align ="center"><h3>CONTACT</h3></div>

<div class="card" style='float:left; line-height: 50px; width:23%; background-color: #dcdcdc'>
    <span><i class="fa fa-address-book"></i><strong> Office Address</strong></span>
    Idowu Taylor, Victoria Island
    <br>
    Lagos, Nigeria.
    <br> <br>
</div>

<div class="card" style='float:left; line-height: 50px; width:23%; margin-left:25px; background-color: #dcdcdc'>
    <span><i class="fa fa-phone"></i><strong> Phone numbers</strong> </span>
    +234 **** ****
    <br>
    +234 **** ****
    <br>
    +234 **** ****
</div>

<div class="card" style='float:left; line-height: 50px; width:23%; margin-left:25px; background-color: #dcdcdc'>
    <span><i class="fa fa-envelope-open"></i><strong> Email Addresses </strong> </span>
    info@fmdqotc.com
    <br>
    info@admin.com
    <br><br>
</div>
<br><br> <br><br><br>
<br><br> <br><br><br>


<div align ="center"><h2>Send us a message </h2></div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="modal-body" id="contact-form">
            <div class="text-fields">

                <div class="float-input">
                    <input name="name" id="name" type="text" placeholder="Name" required ="required">
                    <span><i class="fa fa-user"></i></span>
                </div>

                <div class="float-input">
                    <input name="email" id="email" type="text" placeholder="e-mail" required ="required">
                    <span><i class="fa fa-envelope-open"></i></span>
                </div>

                <div class="float-input">
                    <input name="telephone" id="telephone" type="text" placeholder="Telephone" maxlength="11" required ="required">
                    <span><i class="fa fa-phone"></i></span>
                </div>

                <div class="comment-area">
                    <textarea name="comment" id="comment" placeholder="Comment" maxlength="2000" required></textarea>
                </div>
                <div class="submit-area">
                    <button type="submit" name="submit" id="submit">
                        Send Message
                    </button>
                </div>
            </div>
        </div>

    </form>


    <?php include("../views/baseview-footer.php")?>

<?php include("../views/baseview-scripts.php")?>
</body>