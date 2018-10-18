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
$ex = "";

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {

    if (!empty($_POST['email']) && (empty($_POST['isadmin'])||!empty($_POST['isadmin']) ) ) {
        $email = $_POST['email'];

        if (isset($_POST['isadmin'])) {
            $isadmin = $_POST['isadmin'];
        }
        $isadmin = $_POST['isadmin'] == "on" ? 1 : 0;
//        $organization = $_POST['organization'];

        if ($email = $_POST['email']) {
            try {
                \FMDQ\FLRP\User::updateRole($email, $isadmin);
                $success = "User Role has been Successfully updated";
            } catch (Exception $ex) {
                $error = $ex->getMessage();
            }
        } else {
            $error = "email mismatch";
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
            <h2>Update User</h2>
            <form id="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="modal-body" id="contact-form">
                    <div class="text-fields">
                        <div class="float-input">
                            <input name="email" id="email" type="text" required = "required" placeholder="e-mail">
                            <span><i class="fa fa-envelope-open"></i></span>
                        </div>
<!--                        <div class="float-input">-->
<!--                            <input name="name" id="name" type="text" required = "required" placeholder="Name">-->
<!--                            <span><i class="fa fa-user"></i></span>-->
<!--                        </div>-->
                        <div class="float-input form-check">
                            <input type="checkbox" class="form-check-input" id="isadmin" name="isadmin">
                            <label class="form-check-label" for="isadmin">Administrator</label>
                        </div>
<!--                        <div class="float-input">-->
<!--                            <input name="organization" id="organization" type="text" required = "required" placeholder="Organization">-->
<!--                            <span><i class="fa fa-building"></i></span>-->
<!--                        </div>-->
                    </div>
                </div>
                <!--<div class="comment-area">
                    <textarea name="comment" id="comment" placeholder="Message"></textarea>
                </div>-->
                <div class="submit-area">
                    <div class="modal-footer">
                        <button type="submit"   class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
            <a href ="../index.php"> Go back to Home </a>
        </div>
        <?php include("../views/baseview-footer.php")?>
    </div>
</div>
<?php include("../views/baseview-scripts.php") ?>
</body>
</html>
