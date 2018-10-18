<?php
/**
 * Created by PhpStorm.
 * User: toluo
 * Date: 10/07/2018
 * Time: 06:29
 */

require_once $path."models/User.php";
require_once $path."models/Category.php";

if(!isset($_COOKIE[\FMDQ\FLRP\User::$Cookie])) {
    header("Location: ".$path."views/login.php");
    exit;
}else {
    $user = $_COOKIE[\FMDQ\FLRP\User::$Cookie];
    $arr = explode("|", $user);
    $email = $arr[0];
    $role = $arr[1];

    if(($page == "documents" && strtoupper($_SERVER['REQUEST_METHOD']) == 'GET' && !isset($_GET['cat'])) ||
        ($role != \FMDQ\FLRP\User::$AdminRole && (
                ($page == "documents" && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') ||
                ($page == "categories" || $page == "users")))) { //protect admin pages
        header("refresh: 1; url=../");
        echo "Invalid request, redirecting ...";
        exit;
    }
}

function createAdminMenu($page, $path, $menu, $fa, $label)
{
    $txt = "<li><a ";
    if ($page == $menu)
        $txt .= "class=\"active\" ";
    /*if ($page == "home")
        $txt .= "href=\"views/" . $menu . ".php\"><i class=\"fa fa-" . $fa . "\"></i>" . $label . "</a></li>";
    else
        $txt .= "href=\"" . $menu . ".php\"><i class=\"fa fa-" . $fa . "\"></i>" . $label . "</a></li>";*/
    $txt .= "href=\"".$path."views/" . $menu . ".php\"><i class=\"fa fa-" . $fa . "\"></i>" . $label . "</a></li>";
    return $txt;
}
?>




<nav class="navbar navbar-expand-lg navbar-collapse bg-light" >
    <a class="navbar-brand ml-lg-5" href="#">
        <img alt="" height="70px" width="150px" src="../img/fmdq-logo.png">
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" <?php if($page == "home") print("class=\"active\" href=\"#\""); else print(" href=\"../index.php\""); ?> >HOME</a>
            </li>


            <li class="nav-item">
                <a class="nav-link" <?php if($page == "about") print("class=\"active\"")?>
                   href="<?php print $path ?>views/about.php">ABOUT</a>
            </li>


            <li class="nav-item">
                <a class="nav-link" <?php if($page == "comments") print("class=\"active\"") ?>
                   href="<?php print $path ?>views/comments.php">CONTACT</a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="<?php print $path ?>/controllers/logout.php">LOGOUT</a>
            </li>
        </ul>
    </div>
</nav>

<div id="container" class="container">
<div id="sidebar">
    <header class="sidebar-section">
        <a class="elemadded responsive-link" href="#">Menu</a>
        <div class="navbar-vertical">
            <ul class="main-menu">
                <?php
                $cats = \FMDQ\FLRP\Category::getHierarchy();
                function walk($path, $cat) {
                    if(!$cat->enabled)
                        return;
                    if(!isset($cat->parent))
                        echo "<li class='drop'><a href=\"".$path."views/documents.php?cat=".$cat->code."\"><i class=\"fa ".$cat->icon."\"></i> ".$cat->name."</a>";
                    else if(count($cat->children) > 0)
                        echo "<li class='drop'><a href=\"".$path."views/documents.php?cat=".$cat->code."\"></i>".$cat->name."</a>";
                    else
                        echo "<li><a href=\"".$path."views/documents.php?cat=".$cat->code."\"></i>".$cat->name."</a>";
                    if(count($cat->children) > 0){
                        echo "<ul class=\"drop-down\">";
                        foreach ($cat->children as $child)
                            walk($path, $child);
                        echo "</ul>";
                    }
                    echo "</li>";
                }

                foreach ($cats as $cat) {
                    walk($path, $cat);
                }
                if($role == \FMDQ\FLRP\User::$AdminRole){
                    print createAdminMenu($page, $path, "users", "users", " Manage Users");
                    print createAdminMenu($page, $path, "categories", "object-group", " Manage Categories");
//                    print createAdminMenu($page, $path, "upload", "cloud-upload-alt", "Upload Files");
                }
                ?>
<!--                <li><a --><?php //if($page == "comment") print("class=\"active\"")?><!-- href="--><?php //print $path?><!--views/comments.php"><i class="fa fa-comments"></i>Comments/Feedback</a></li>-->
<!--                <li><a href="--><?php //print $path?><!--controllers/logout.php"><i class="fa fa-user-lock"></i>Logout</a></li>-->
            </ul>
        </div>
    </header>
</div>