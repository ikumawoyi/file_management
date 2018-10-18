<?php
/**
 * Created by PhpStorm.
 * User: toluo
 * Date: 09/07/2018
 * Time: 20:25
 */

$page = "login";
require('../models/User.php');

$error = null;
$success = null;

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    if (!empty($_POST['password']) && !empty($_POST['email'])) {

        $email = ($_POST['email']);
        $password = ($_POST['password']);
        try {
            $role = \FMDQ\FLRP\User::validate($email, $password);
            if($role) {
                header("refresh: 2; url=../");
                setcookie(\FMDQ\FLRP\User::$Cookie, $email."|".$role, time() + 6*60*60, "/");
                echo "Processing, please wait...";
                exit;
            } else {
                throw new Exception("Invalid credentials");
            }
        } catch(Exception $ex){
            $error = $ex->getMessage();
        }
    } else {
        $error = "Invalid parameters posted";
    }
}
?>

<!doctype html>
<html lang="en" class="no-js">
<?php include("../views/baseview-head.php") ?>
<body>
<div id="container" class="container">
<!--    <div id="sidebar">-->
    <div class="header-logo">
        <a class="logo" href="#"><img alt="" height ="70px" width="150px" src="../img/fmdq-logo.png"></a>
    </div>
        <!-- header -->
        <header class="sidebar-section">

        </header>
<!--    </div>-->
    <div id="content">
        <div class="box-section contact-section triggerAnimation animated" data-animate="flipInY">
            <?php
            if($error) {
                echo "<div class=\"alert alert-danger\" role=\"alert\">$error";
                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>";
            }
            if($success) {
                echo "<div class=\"alert alert-success\" role=\"alert\">$success";
                echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>";
            }
            ?>
            <h2>Login</h2>
            <form id="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="text-fields">
                    <div class="float-input">
                        <input name="email" id="email" type="text" required = "required" placeholder="e-mail">
                        <span><i class="fa fa-envelope-open"></i></span>
                    </div>
                    <div class="float-input">
                        <input name="password" id="password" type="password" required = "required"  placeholder="password">
                        <span><i class="fa fa-lock-open"></i></span>
                    </div>
                    <div class="float-input">
                        <button type="submit">
                            <i class="fa fa-user-lock"></i>
                            Login
                        </button>
                    </div>
                </div>
                <!--<div class="comment-area">
                    <textarea name="comment" id="comment" placeholder="Message"></textarea>
                </div>-->
                <div class="submit-area">

                </div>
                <!--<div id="msg" class="message"></div>-->
            </form> <br>
            <div align="centre">
                <span><i class="fa fa-lock-open"></i></span>
                <a href="forgotPassword.php">Forgot password?</a>

<!--                <span><i class="fa fa-lock-open"></i></span>-->
<!--                <a href="resetPassword.php">Reset password?</a>-->
            </div>
        </div>
        <?php include("../views/baseview-footer.php")?>
    </div>
</div>
<?php include("../views/baseview-scripts.php") ?>
</body>
</html>
