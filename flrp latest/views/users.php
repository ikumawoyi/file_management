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
$body = "";
$email = '';
$name = "";
$pass = "";
$isadmin = "";

if(isset($_GET['del'])){
    \FMDQ\FLRP\User::disable($_GET['del']);
    header("Location: ./users.php");
    exit;
}
if(isset($_GET['restore'])){
    \FMDQ\FLRP\User::enable($_GET['restore']);
    header("Location: ./users.php");
    exit;
}

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['name'])) {

        $email = $_POST['email'];
        $name = $_POST['name'];
        $rand = substr((rand()), 0, 12);
        $pass = $rand;
        $hasspass = hash('sha256', $pass);
        $isadmin = $_POST['isadmin'] == "on" ? 1 : "0";
        $organization = $_POST['organization'];

        if ($pass == $rand) {
            try {
                \FMDQ\FLRP\User::save($email, $name, $hasspass, $isadmin,  $organization);
                $success = "Successfully saved the record";
            }catch (Exception $ex) {
                $error = $ex->getMessage();
            }
        } else {
            $error = "Password mismatch";
        }
    } else {
        $error = "Invalid parameters posted";
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
    $mail->setFrom('ayotunde@trusoftng.com', 'flrp Admin');

    $body = "Dear: $name,\n You have been profiled on our portal with your E-Mail: $email.\n  Your Password is: $pass";

    $mail->addAddress("$email", 'FLRP');
    $mail->Subject = 'User registration';
    $mail->Body = $body;
//    if (!$mail->send()) {
//        echo 'Email could not be sent.';
//           $mail->ErrorInfo;
////        echo "$pass";
////        echo "$hasspass";
//    } else {
//        echo 'Email has been sent';
//    };
    if($mail->Send())
        echo "Email has been Successfully sent!";
    else
        echo "Fail - " . $mail->ErrorInfo. $mail->SMTPDebug = 2;


};

?>

<!doctype html>
<html lang="en" class="no-js" xmlns="http://www.w3.org/1999/html">
<?php include("../views/baseview-head.php")?>
<body>
<!--<div id="container" class="container">-->
    <!-- header -->
<!--    <div class="header-logo">-->
<!--        <a class="logo" href="#"><img alt="" height ="70px" width="150px"  src="../img/fmdq-logo.png"></a>-->
<!--    </div>-->
    <header class="sidebar-section">

    </header>
    <?php include("../views/baseview-menu.php")?>
    <div id="content">
        <div class="box-section table-section triggerAnimation animated" data-animate="wobble">
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
            <h2>Manage Users</h2>
            <a href="#" class="float-right buttonStyle" data-toggle="modal" data-target="#edit-user">
                <i class="fa fa-user-edit"></i>
                New User
            </a>
            <div align="right">
                <form action="edit.php">
                    <input type="submit" value="Edit User Role" />
                </form>
            </div>



            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>E-mail</th>
                        <th>Name</th>
                        <th>Organization</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                    <?php
                    $users = \FMDQ\FLRP\User::getAll();
                    if ($users->num_rows > 0) {
                        while ($user = $users->fetch_assoc()) {
                            if($user['isadmin'] == 0)
                                $role = \FMDQ\FLRP\User::$UserRole;
                            else
                                $role = \FMDQ\FLRP\User::$AdminRole;

                            if ($user['enabled'] == 1)
                                $action = "del=" . $user['email'] . "'><i class='fa fa-trash'></i>";
                            else
                                $action = "restore=" . $user['email'] . "'><i class='fa fa-undo'></i>";

                            echo "<tr>";
                            echo "<td>" . $user['email'] . "</td>";
                            echo "<td>" . $user['fullname'] . "</td>";
                            echo "<td>" . $user['organization'] . "</td>";
                            echo "<td>" . $role . "</td>";
                            echo "<td><a href='./users.php?" . $action . "</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
            <div id="edit-user" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="modal-header">
                            <h5 class="modal-title">Create/Update User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="contact-form">
                                <div class="text-fields">
                                    <div class="float-input">
                                        <input name="email" id="email" type="text" required = "required" placeholder="e-mail">
                                        <span><i class="fa fa-envelope-open"></i></span>
                                    </div>
                                    <div class="float-input">
                                        <input name="name" id="name" type="text" required = "required" placeholder="Name">
                                        <span><i class="fa fa-user"></i></span>
                                    </div>
                                    <div class="float-input form-check">
                                        <input type="checkbox" class="form-check-input" id="isadmin" name="isadmin">
                                        <label class="form-check-label" for="isadmin">Administrator</label>
                                    </div>
                                    <div class="float-input">
                                        <input name="organization" id="organization" type="text" required = "required" placeholder="Organization">
                                        <span><i class="fa fa-building"></i></span>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include("../views/baseview-footer.php")?>
    </div>
</div>
<?php include("../views/baseview-scripts.php")?>
</body>
