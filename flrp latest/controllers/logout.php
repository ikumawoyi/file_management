<?php
/**
 * Created by PhpStorm.
 * User: toluo
 * Date: 12/07/2018
 * Time: 07:39
 */

$page = "logout";
require('../models/User.php');

header("refresh: 2; url=../");
setcookie(\FMDQ\FLRP\User::$Cookie, "|", time() - 6*60*60, "/");
echo "Processing, please wait...";
exit;