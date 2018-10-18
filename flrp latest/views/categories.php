<?php
/**
 * Created by PhpStorm.
 * User: toluo
 * Date: 11/07/2018
 * Time: 16:58
 */
$page = "categories";

require('../models/Category.php');
//phpinfo();

$error = null;
$success = null;
$editing = null;
if(isset($_GET['del'])){
    \FMDQ\FLRP\Category::disableCategory($_GET['del']);
    header("Location: ./categories.php");
    exit;
}
if(isset($_GET['restore'])){
    \FMDQ\FLRP\Category::enableCategory($_GET['restore']);
    header("Location: ./categories.php");
    exit;
}

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    if (!empty($_POST['name']) && !empty($_POST['code']) && !empty($_POST['icons'])) {

        $code = $_POST['code'];
        $name = $_POST['name'];
        $parent = $_POST['parent'];
        $description = $_POST['description'];
        $icons = $_POST['icons'];
        $old = null;
        if(isset($_POST['oldcode']))
            $old = $_POST['oldcode'];
        try {
            \FMDQ\FLRP\Category::save($code, $name, $parent, $description, $icons, $old);
            $success = "Successfully saved the record";
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
<body>

<!--<div id="container" class="container" >-->

<!--    <div class="header-logo">-->
<!--        <a class="logo" href="#"><img alt="" height ="70px" width="150px" src="../img/fmdq-logo.png"></a>-->
<!--    </div>-->
    <!-- header -->
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
            <h2>Manage Categories</h2>
            <a href="#" class="float-right buttonStyle" data-toggle="modal" data-target="#new-category">
                <i class="fa fa-cogs"></i>
                New Category
            </a>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Description</th>
                        <th>Edit</th>
                        <th></th>
                    </tr>
                    <?php
                    $categories = \FMDQ\FLRP\Category::$allcats;

                    if(isset($_GET['edit'])){
                        $editing = $categories[$_GET['edit']];

                    }
                    if (count($categories) > 0) {
                        foreach ($categories as $catcode => $category) {
                            if ($category->enabled)
                                $action = "del=" . $category->code . "'><i class='fa fa-trash'></i>";
                            else
                                $action = "restore=" . $category->code . "'><i class='fa fa-undo'></i>";
                            echo "<tr>";
                            echo "<td>" . $category->code . "</td>";
                            echo "<td>" . $category->name . "</td>";
                            echo "<td>" . $category->parentCode . "</td>";
                            echo "<td>" . $category->description . "</td>";
                            echo "<td> <a href='./categories.php?edit=".$category->code."'> <i class=\"fa fa-edit\" ></i></a></td>";
                            echo "<td><a href='./categories.php?" . $action . "</a></td>";

                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
            <div id="new-category" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="modal-header">
                                <h5 class="modal-title">Create/Update Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="contact-form">
                                <div class="text-fields">
                                    <div class="float-input">
                                        <input name="code" id="code" type="text" placeholder="Code" required>
                                        <span><i class="fa fa-envelope-open"></i></span>
                                    </div>
                                    <div class="float-input">
                                        <input name="name" id="name" type="text" placeholder="Name" required>
                                        <span><i class="fa fa-user"></i></span>
                                    </div>
                                    <div class="float-input">
                                        <input name="parent" id="parent" type="text" list="categories" placeholder="Parent category">
                                        <span><i class="fa fa-object-group"></i></span>
                                    </div>

                                    <select name="icons" <select name="icons" style="font-family: 'Font Awesome 5 Free', 'Font Awesome 5 Brands', sans-serif;font-weight: 900;">
                                        <option value="fa-address-book">&#xf2b9; address-book-o</option>
                                        <option value="fa-address-card">&#xf2bb; address-card</option>
                                        <option value="fa-adjust">&#xf042; adjust</option>
                                        <option value="fa-adn">&#xf170; adn</option>
                                        <option value="fa-angle-double-down">&#xf103; angle-double-down</option>
                                        <option value="fa-angle-double-left">&#xf100; angle-double-left</option>
                                        <option value="fa-angle-double-right">&#xf101; angle-double-right</option>
                                        <option value="fa-angle-double-up">&#xf102; angle-double-up</option>
                                        <option value='fa-apple'>&#xf179; apple</option>
                                        <option value='fa-archive'>&#xf187; archive</option>
                                        <option value='fa-arrow-alt-circle-down'>&#xf358; arrow-circle-down</option>
                                        <option value='fa-arrow-alt-circle-left'>&#xf359; arrow-circle-left</option>
                                        <option value='fa-balance-scale'>&#xf24e; balance-scale</option>
                                        <option value='fa-ban'>&#xf05e; ban</option>
                                        <option value='fa-dollar-sign'>&#xf155; bank</option>
                                        <option value='fa-chart-bar'>&#xf080; bar-chart</option>
                                        <option value='fa-barcode'>&#xf02a; barcode</option>
                                        <option value='fa-battery-full'>&#xf240; battery</option>
                                        <option value='fa-battery-three-quarters'>&#xf241; battery-0</option>
                                        <option value='fa-battery-half'>&#xf242; battery-1</option>
                                        <option value='fa-bed'>&#xf236; bed</option>
                                        <option value='fa-behance'>&#xf1b4; behance</option>
                                        <option value='fa-bell'>&#xf0f3; bell</option>
                                        <option value='fa-bicycle'>&#xf206; bicycle</option>
                                        <option value='fa-binoculars'>&#xf1e5; binoculars</option>
                                        <option value='fa-bitcoin'>&#xf379; bitcoin</option>
                                        <option value='fa-bluetooth-b'>&#xf294; bluetooth</option>
                                        <option value='fa-bold'>&#xf032; bold</option>
                                        <option value='fa-bolt'>&#xf0e7; bolt</option>
                                        <option value='fa-book-open'>&#xf518; book</option>
                                        <option value='fa-calculator'>&#xf1ec; calculator</option>
                                        <option value='fa-calendar-alt'>&#xf073; calendar</option>
                                        <option value='fa-video'>&#xf03d; camera</option>
                                        <option value='fa-car'>&#xf1b9; car</option>
                                        <option value='fa-cc-mastercard'>&#xf1f1; mastercard</option>
                                        <option value='fa-paypal'>&#xf1ed; paypal</option>
                                        <option value='fa-certificate'>&#xf0a3; certificate</option>
                                        <option value='fa-check-circle-o'>&#xf05d; check-circle-o</option>
                                        <option value='fa-check-square'>&#xf14a; check-square</option>
                                        <option value='fa-check-square-o'>&#xf046; check-square-o</option>
                                        <option value='fa-chevron-circle-down'>&#xf13a; chevron-circle-down</option>
                                        <option value='fa-chevron-circle-left'>&#xf137; chevron-circle-left</option>
                                        <option value='fa-chevron-circle-right'>&#xf138; chevron-circle-right</option>
                                        <option value='fa-chevron-circle-up'>&#xf139; chevron-circle-up</option>
                                        <option value='fa-chevron-down'>&#xf078; chevron-down</option>
                                        <option value='fa-chevron-left'>&#xf053; chevron-left</option>
                                        <option value='fa-chevron-right'>&#xf054; chevron-right</option>
                                        <option value='fa-chevron-up'>&#xf077; chevron-up</option>
                                        <option value='fa-child'>&#xf1ae; child</option>
                                        <option value='fa-chrome'>&#xf268; chrome</option>
                                        <option value='fa-circle'>&#xf111; circle</option>
                                        <option value='fa-circle-o'>&#xf10c; circle-o</option>
                                        <option value='fa-circle-o-notch'>&#xf1ce; circle-o-notch</option>
                                        <option value='fa-circle-thin'>&#xf1db; circle-thin</option>
                                        <option value='fa-clipboard'>&#xf0ea; clipboard</option>
                                        <option value='fa-clock-o'>&#xf017; clock-o</option>
                                        <option value='fa-clone'>&#xf24d; clone</option>
                                        <option value='fa-close'>&#xf00d; close</option>
                                        <option value='fa-cloud'>&#xf0c2; cloud</option>
                                        <option value='fa-cloud-download'>&#xf0ed; cloud-download</option>
                                        <option value='fa-cloud-upload'>&#xf0ee; cloud-upload</option>
                                        <option value='fa-cny'>&#xf157; cny</option>
                                        <option value='fa-code'>&#xf121; code</option>
                                        <option value='fa-code-fork'>&#xf126; code-fork</option>
                                        <option value='fa-codepen'>&#xf1cb; codepen</option>
                                        <option value='fa-codiepie'>&#xf284; codiepie</option>
                                        <option value='fa-coffee'>&#xf0f4; coffee</option>
                                        <option value='fa-cog'>&#xf013; cog</option>
                                        <option value='fa-cogs'>&#xf085; cogs</option>
                                        <option value='fa-columns'>&#xf0db; columns</option>
                                        <option value='fa-comment'>&#xf075; comment</option>
                                        <option value='fa-comment-o'>&#xf0e5; comment-o</option>
                                        <option value='fa-commenting'>&#xf27a; commenting</option>
                                        <option value='fa-commenting-o'>&#xf27b; commenting-o</option>
                                        <option value='fa-comments'>&#xf086; comments</option>
                                        <option value='fa-compass'>&#xf14e; compass</option>
                                        <option value='fa-file-archive'>&#xf1c6; compress</option>
                                        <option value='fa-connectdevelop'>&#xf20e; connectdevelop</option>
                                        <option value='fa-futbol'>&#xf1e3; national flag</option>
                                        <option value='fa-money-bill-alt'>&#xf3d1; money-bill-alt</option>
                                        <option value='fa-lock'>&#xf023; lock</option>
                                        <option value='fa-globe-africa'>&#xf0ec; globe-africa</option>
                                        <option value='fa-exchange'>&#xf501; exchange</option>
                                    </select>
                                    <div class="comment-area">
                                        <textarea name="description" id="description" placeholder="Description"></textarea>
                                    </div>
                                    <datalist id="categories">
                                        <?php
                                        foreach (\FMDQ\FLRP\Category::$allcats as $catd) {
                                            $header = $catd->name;
                                            $c = $catd->parent;
                                            while ($c != null) {
                                                $header = $c->name . " / " . $header;
                                                $c = $c->parent;
                                            }
                                            echo "<option value='" . $catd->code . "'>" . $header . "</option>";
                                        }
                                        ?>
                                    </datalist>
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
            <div id="edit-category" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="modal-header">
                                <h5 class="modal-title">Create/Update Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="contact-form">
                                <div class="text-fields">
                                    <?php
                                    if($editing)
                                        echo '<input type="hidden" name="oldcode" value="'.$editing->code.'">';
                                    ?>
                                    <div class="float-input">
                                        <input name="code" id="code" type="text" placeholder="Code" required value="<?php echo $editing->code?>">
                                        <span><i class="fa fa-envelope-open"></i></span>
                                    </div>
                                    <div class="float-input">
                                        <input name="name" id="name" type="text" placeholder="Name" required value="<?php echo $editing->name?>">
                                        <span><i class="fa fa-user"></i></span>
                                    </div>
                                    <div class="float-input">
                                        <input name="parent" id="parent" type="text" list="categories" placeholder="Parent category" value="<?php echo $editing->parentCode?>">
                                        <span><i class="fa fa-object-group"></i></span>
                                    </div>

                                    <select name="icons" style="font-family: 'Font Awesome 5 Free', 'Font Awesome 5 Brands', sans-serif;font-weight: 900;">
                                        <option value="fa-address-book">&#xf2b9; address-book-o</option>
                                        <option value="fa-address-card">&#xf2bb; address-card</option>
                                        <option value="fa-adjust">&#xf042; adjust</option>
                                        <option value="fa-adn">&#xf170; adn</option>
                                        <option value="fa-angle-double-down">&#xf103; angle-double-down</option>
                                        <option value="fa-angle-double-left">&#xf100; angle-double-left</option>
                                        <option value="fa-angle-double-right">&#xf101; angle-double-right</option>
                                        <option value="fa-angle-double-up">&#xf102; angle-double-up</option>
                                        <option value='fa-apple'>&#xf179; apple</option>
                                        <option value='fa-archive'>&#xf187; archive</option>
                                        <option value='fa-arrow-alt-circle-down'>&#xf358; arrow-circle-down</option>
                                        <option value='fa-arrow-alt-circle-left'>&#xf359; arrow-circle-left</option>
                                        <option value='fa-balance-scale'>&#xf24e; balance-scale</option>
                                        <option value='fa-ban'>&#xf05e; ban</option>
                                        <option value='fa-dollar-sign'>&#xf155; bank</option>
                                        <option value='fa-chart-bar'>&#xf080; bar-chart</option>
                                        <option value='fa-barcode'>&#xf02a; barcode</option>
                                        <option value='fa-battery-full'>&#xf240; battery</option>
                                        <option value='fa-battery-three-quarters'>&#xf241; battery-0</option>
                                        <option value='fa-battery-half'>&#xf242; battery-1</option>
                                        <option value='fa-bed'>&#xf236; bed</option>
                                        <option value='fa-behance'>&#xf1b4; behance</option>
                                        <option value='fa-bell'>&#xf0f3; bell</option>
                                        <option value='fa-bicycle'>&#xf206; bicycle</option>
                                        <option value='fa-binoculars'>&#xf1e5; binoculars</option>
                                        <option value='fa-bitcoin'>&#xf379; bitcoin</option>
                                        <option value='fa-bluetooth-b'>&#xf294; bluetooth</option>
                                        <option value='fa-bold'>&#xf032; bold</option>
                                        <option value='fa-bolt'>&#xf0e7; bolt</option>
                                        <option value='fa-book-open'>&#xf518; book</option>
                                        <option value='fa-calculator'>&#xf1ec; calculator</option>
                                        <option value='fa-calendar-alt'>&#xf073; calendar</option>
                                        <option value='fa-video'>&#xf03d; camera</option>
                                        <option value='fa-car'>&#xf1b9; car</option>
                                        <option value='fa-cc-mastercard'>&#xf1f1; mastercard</option>
                                        <option value='fa-paypal'>&#xf1ed; paypal</option>
                                        <option value='fa-certificate'>&#xf0a3; certificate</option>
                                        <option value='fa-check-circle-o'>&#xf05d; check-circle-o</option>
                                        <option value='fa-check-square'>&#xf14a; check-square</option>
                                        <option value='fa-check-square-o'>&#xf046; check-square-o</option>
                                        <option value='fa-chevron-circle-down'>&#xf13a; chevron-circle-down</option>
                                        <option value='fa-chevron-circle-left'>&#xf137; chevron-circle-left</option>
                                        <option value='fa-chevron-circle-right'>&#xf138; chevron-circle-right</option>
                                        <option value='fa-chevron-circle-up'>&#xf139; chevron-circle-up</option>
                                        <option value='fa-chevron-down'>&#xf078; chevron-down</option>
                                        <option value='fa-chevron-left'>&#xf053; chevron-left</option>
                                        <option value='fa-chevron-right'>&#xf054; chevron-right</option>
                                        <option value='fa-chevron-up'>&#xf077; chevron-up</option>
                                        <option value='fa-child'>&#xf1ae; child</option>
                                        <option value='fa-chrome'>&#xf268; chrome</option>
                                        <option value='fa-circle'>&#xf111; circle</option>
                                        <option value='fa-circle-o'>&#xf10c; circle-o</option>
                                        <option value='fa-circle-o-notch'>&#xf1ce; circle-o-notch</option>
                                        <option value='fa-circle-thin'>&#xf1db; circle-thin</option>
                                        <option value='fa-clipboard'>&#xf0ea; clipboard</option>
                                        <option value='fa-clock-o'>&#xf017; clock-o</option>
                                        <option value='fa-clone'>&#xf24d; clone</option>
                                        <option value='fa-close'>&#xf00d; close</option>
                                        <option value='fa-cloud'>&#xf0c2; cloud</option>
                                        <option value='fa-cloud-download'>&#xf0ed; cloud-download</option>
                                        <option value='fa-cloud-upload'>&#xf0ee; cloud-upload</option>
                                        <option value='fa-cny'>&#xf157; cny</option>
                                        <option value='fa-code'>&#xf121; code</option>
                                        <option value='fa-code-fork'>&#xf126; code-fork</option>
                                        <option value='fa-codepen'>&#xf1cb; codepen</option>
                                        <option value='fa-codiepie'>&#xf284; codiepie</option>
                                        <option value='fa-coffee'>&#xf0f4; coffee</option>
                                        <option value='fa-cog'>&#xf013; cog</option>
                                        <option value='fa-cogs'>&#xf085; cogs</option>
                                        <option value='fa-columns'>&#xf0db; columns</option>
                                        <option value='fa-comment'>&#xf075; comment</option>
                                        <option value='fa-comment-o'>&#xf0e5; comment-o</option>
                                        <option value='fa-commenting'>&#xf27a; commenting</option>
                                        <option value='fa-commenting-o'>&#xf27b; commenting-o</option>
                                        <option value='fa-comments'>&#xf086; comments</option>
                                        <option value='fa-compass'>&#xf14e; compass</option>
                                        <option value='fa-file-archive'>&#xf1c6; compress</option>
                                        <option value='fa-connectdevelop'>&#xf20e; connectdevelop</option>
                                        <option value='fa-futbol'>&#xf1e3; national flag</option>
                                        <option value='fa-money-bill-alt'>&#xf3d1; money-bill-alt</option>
                                        <option value='fa-lock'>&#xf023; lock</option>
                                        <option value='fa-globe-africa'>&#xf0ec; globe-africa</option>
                                        <option value='fa-exchange'>&#xf501; exchange</option>
                                    </select>
                                    <div class="comment-area">
                                        <textarea name="description" id="description" placeholder="Description"> <?php echo $editing->description?></textarea>
                                    </div>
                                    <datalist id="categories">
                                        <?php
                                        foreach (\FMDQ\FLRP\Category::$allcats as $catd) {
                                            $header = $catd->name;
                                            $c = $catd->parent;
                                            while ($c != null) {
                                                $header = $c->name . " / " . $header;
                                                $c = $c->parent;
                                            }
                                            echo "<option value='" . $catd->code . "'>" . $header . "</option>";
                                        }
                                        ?>
                                    </datalist>
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
<?php

include("../views/baseview-scripts.php");

if(isset($_GET['edit']))
    echo "<script>$('#edit-category').modal();</script>";
?>
</body>