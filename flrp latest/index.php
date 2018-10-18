<?php
/**
 * Created by PhpStorm.
 * User: toluo
 * Date: 09/07/2018
 * Time: 14:24
 */

$page = "home";
?>

<!doctype html>
<html lang="en" class="no-js">
<?php include("views/baseview-head.php") ?>
<body>
<!--<div id="container" class="container">-->
<!-- header -->
<!--    <div class="header-logo">-->
<!--        <a class="logo" href="#"><img alt="" height ="70px" width="150px" src="/img/fmdq-logo.png"></a>-->
<!--    </div>-->
<header class="sidebar-section">

</header>
<nav class="navbar navbar-expand-lg navbar-collapse bg-light">

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!--        <ul class="navbar-nav ml-auto">-->
        <!--            <li class="nav-item">-->
        <!--                <a class="nav-link" -->
        <?php //if($page == "home") print("class=\"active\" href=\"#\""); else print(" href=\"../index.php\""); ?><!-- >HOME</a>-->
        <!--            </li>-->
        <!---->
        <!--            <li class="nav-item">-->
        <!--                <a class="nav-link" --><?php //if($page == "comments") print("class=\"active\"") ?>
        <!--                   href="--><?php //print $path ?><!--views/comments.php">CONTACT</a>-->
        <!--            </li>-->
        <!---->
        <!--            <li class="nav-item">-->
        <!--                <a class="nav-link" --><?php //if($page == "about") print("class=\"active\"")?>
        <!--                   href="--><?php //print $path ?><!--views/about.php">ABOUT</a>-->
        <!--            </li>-->
        <!---->
        <!--            <li class="nav-item">-->
        <!--                <a class="nav-link" href="-->
        <?php //print $path ?><!--/controllers/logout.php">LOGOUT</a>-->
        <!--            </li>-->
        <!--        </ul>-->
    </div>
</nav>


<?php include("views/baseview-menu.php") ?>


<div id="content">
    <!--    <a class="homepics" href="#"><img alt="" src="/img/fmdq.png" style="width:850px;height:300px;"></a>-->

    <video width="950" height="500" controls autoplay loop>

        <source src="http://188.166.147.52/fmdq/flrp/img/newfmdqvideo.mp4" type="video/mp4">
        Sorry, your browser doesn't support the video element.
    </video>


    <?php include("views/baseview-footer.php") ?>
</div>
<?php include("views/baseview-scripts.php") ?>
</body>
</html>