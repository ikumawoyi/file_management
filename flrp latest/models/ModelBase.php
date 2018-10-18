<?php
/**
 * Created by PhpStorm.
 * User: toluo
 * Date: 10/07/2018
 * Time: 06:02
 */

namespace FMDQ\FLRP;
if($page == "home")
    require_once('controllers/Config.php');
else
    require('../controllers/Config.php');
use FMDQ\FLRP\Config;

abstract class ModelBase
{

    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $db = mysqli_connect(Config::DB_HOST,Config::DB_USER,
                Config::DB_PASSWORD,Config::DB_NAME);
        }

        return $db;
    }

    public static function closeDB()
    {
        static::getDB()->close();
    }
}