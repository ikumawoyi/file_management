<?php
/**
 * Created by PhpStorm.
 * User: toluo
 * Date: 09/07/2018
 * Time: 20:22
 */

if($page == "home")
    require_once('models/ModelBase.php');
else
    require_once('../models/ModelBase.php');
\FMDQ\FLRP\ModelBase::closeDB();
?>
<script src="<?php print $path?>js/jquery-3.3.1.min.js"></script>
<script src="<?php print $path?>js/popper.min.js"></script>
<script src="<?php print $path?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php print $path?>js/less.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>