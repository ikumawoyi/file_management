<?php
/**
 * Created by PhpStorm.
 * User: toluo
 * Date: 12/07/2018
 * Time: 18:55
 */

$page = "documents";
$error = null;
$success = null;
$getfolder = null;
$editing ="";

require "../models/User.php";
require "../models/Category.php";

if(isset($_GET['del'])){
    \FMDQ\FLRP\Category::disableDocument($_GET['del']);
    header("Location: ./documents.php?cat=".$_GET['cat']);
    exit;
}
if(isset($_GET['restore'])){
    \FMDQ\FLRP\Category::enableDocument($_GET['restore']);
    header("Location: ./documents.php?cat=".$_GET['cat']);
    exit;
}

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    if (!empty($_POST['name']) && !empty($_POST['path']) && !empty($_POST['category'])) {

        $name = $_POST['name'];
        $path = $_POST['path'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $id = $_POST['id'];

        try {
            if (!isset($_POST["path"]) && isset($_FILES['upload'])) {
                move_uploaded_file($_FILES["upload"]["tmp_name"], "../uploads/" . $_FILES["upload"]["name"]);
                $docurl = "../uploads/" . $_FILES["upload"]["name"];
            } else
                $docurl = str_replace("'", "`", $_POST["path"]);

            $docname = str_replace("'", "`", $_POST["name"]);
            $doccategory = str_replace("'", "`", $_POST["category"]);
            $description = str_replace("'", "`", $_POST["description"]);
            if (isset($_FILES['archive'])) {
                $file = "../uploads/" . basename($_FILES["archive"]["name"]);
                move_uploaded_file($_FILES["archive"]["tmp_name"], $file);
                $archive = basename($_FILES["archive"]["name"]);
            }

            \FMDQ\FLRP\Category::saveDocument($docname, $docurl, $doccategory, $description, $archive, $id);
        } catch (Exception $ex) {
            $error = $ex->getMessage();
        }
    } else {
        $error = "Invalid parameters posted";
    }
}
?>

<!doctype html>
<html lang="en" class="no-js">
<?php include("../views/baseview-head.php")?>
<body background="/img/fmdq-logo.png">


<!--<div id="container" class="container">-->
    <!-- header -->
<!--    <div class="header-logo">-->
<!--        <a class="logo" href="#"><img alt="" height ="70px" width="150px" src="../img/fmdq-logo.png"></a>-->
<!--    </div>-->
    <header class="sidebar-section">

    </header>
    <?php
        include("../views/baseview-menu.php");
        /*if(!isset($_GET["cat"]) || $role == \FMDQ\FLRP\User::$AdminRole){
            header("refresh: 2; url=../");
            echo "Invalid request, redirecting ...";
            exit;
        }*/
        $code = htmlspecialchars($_GET["cat"]);
        $catd = \FMDQ\FLRP\Category::getDocuments($code);
        if($catd == null){
            $error = "No such category found, please use the menu to navigate";
        }
        else {
            $header = $catd->name;
            $c = $catd->parent;
            while ($c != null) {
                $header = $c->name . " / " . $header;
                $c = $c->parent;
            }
        }

    ?>
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
            <h2><?php if(!$error) echo $header ?></h2>
            <blockquote><?php if(!$error) echo $catd->description;?></blockquote>
            <?php
            if($role == \FMDQ\FLRP\User::$AdminRole) {
                echo '<a href="#" class="float-right buttonStyle" data-toggle="modal" data-target="#new-document">';
                echo '<i class="fa fa-file-upload"></i>  ';
                echo 'New Document';
                echo '</a>';
            }
            ?>
            <div class="table-responsive">
                <table class="table">
                    <?php
//
                    $catd = \FMDQ\FLRP\Category::getDocuments($code);

                    $caty = FMDQ\FLRP\Category::$allcats = $cats;

                    if (!$error)
                        foreach ($catd->documents as $p => $desc) {
                            $arr = explode("|", $p);
                            if ($role != \FMDQ\FLRP\User::$AdminRole && $arr[3] == 0)
                                continue;
                            echo "<tr>";
//                            echo "<td><a href='" . $arr[2] . "' target='_blank'>" . $arr[1] . "</a></td>";
                            echo "<td>" . $arr[1] . "</td>";
//                            echo "<td>" . $desc . "</td>";
                            if(isset($_GET['edit']) && $arr[0] == $_GET['edit']) {
                                $editing = $arr;
                                $editdesc = $desc;
                            }
                            echo
                                "<td>
                           <a href='".$arr[2]."' target='_blank' >Current Version</a>
                             </td>";
                            echo
                            "<td>
                                <a href='../uploads/".$arr[4]."' target='_blank'>Archive </a>
                             </td>";
                            if ($role == \FMDQ\FLRP\User::$AdminRole) {
                                echo "<td>
                                        <a href='./documents.php?cat=".$code."&edit=".$arr[0]."'><i class=\"fa fa-edit\" ></i></a>
                                    </td>";
                                if ($arr[3] == "1")
                                    $action = "del=" . $arr[0] . "'><i class='fa fa-trash'></i>";
                                else
                                    $action = "restore=" . $arr[0] . "'><i class='fa fa-undo'></i>";
                                echo "<td><a href='./documents.php?" . $action . "</a></td>";
                            }

                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
            <div id="new-document" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="post" action="./documents.php?cat=<?php echo $code?>" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title">Add / Modify a Document</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="contact-form">
                                <div class="text-fields">
                                    <div class="float-input">
                                        <input name="name" id="name" type="text" placeholder="Name of document" required">
                                        <span><i class="fa fa-inbox"></i></span>
                                    </div>
                                    <div class="float-input">
                                        <input name="path" id="path" type="text" placeholder="Url of document" required>
                                        <span><i class="fa fa-location-arrow"></i></span>
                                    </div>
                                    <div class="float-input">
                                        <div>Upload Document</div>
                                        <input name="upload" id="upload" type="file" placeholder="Upload local document">
                                    </div>
                                    <div class="float-input">
                                        <div>Upload Archive</div>
                                        <input name="archive" id="archive" type="file" placeholder="Upload archive document">
                                    </div>
                                    <div class="comment-area">
                                        <textarea name="description" id="description" placeholder="Description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <input name="category" type="hidden" value="<?php echo $code; ?>" required>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="edit-document" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="post" action="./documents.php?cat=<?php echo $code?>" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title">Add / Modify a Document</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="contact-form">
                                <div class="text-fields">
                                    <?php
                                    if($editing)
                                        echo '<input type="hidden" name="id" value="'.$editing[0].'">';
                                    ?>
                                    <div class="float-input">
                                        <input name="name" id="name" type="text" placeholder="Name of document" required value="<?php echo $editing[1]?>">
                                        <span><i class="fa fa-inbox"></i></span>
                                    </div>
                                    <div class="float-input">
                                        <input name="path" id="path" type="text" placeholder="Url of document" required value="<?php echo $editing[2]?>">
                                        <span><i class="fa fa-location-arrow"></i></span>
                                    </div>
                                    <div class="float-input">
                                        <div>Upload Document</div>
                                        <input name="upload" id="upload" type="file" placeholder="Upload local document">
                                    </div>
                                    <div class="float-input">
                                        <div>Upload Archive</div>
                                        <input name="archive" id="archive" type="file" placeholder="Upload archive document">
                                    </div>
                                    <div class="comment-area">
                                        <textarea name="description" id="description" placeholder="Description"><?php echo $editdesc?></textarea>
                                    </div>
                                </div>
                            </div>
                            <input name="category" type="hidden" value="<?php echo $code; ?>" required>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php

        include("../views/baseview-footer.php");
        ?>

    </div>
<!--</div>-->
<?php
include("../views/baseview-scripts.php");

if(isset($_GET['edit']))
    echo "<script>$('#edit-document').modal();</script>";
?>
<script type="application/javascript">
    let upload = document.getElementById("upload");
    upload.onchange = function() {
        let input = this.files[0];
        let fullPath = upload.value;
        if (input) {
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            var path = document.getElementById("path");
            path.value = "../uploads/"+filename.toLowerCase();
        }
    };
</script>
</body>
