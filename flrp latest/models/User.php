<?php
/**
 * Created by PhpStorm.
 * User: toluo
 * Date: 10/07/2018
 * Time: 05:52
 */

namespace FMDQ\FLRP;

require_once('ModelBase.php');

class User extends ModelBase
{
    public static $Cookie = "fmdq-flrp-user";
    public static $UserRole = "User";
    public static $AdminRole = "Admin";

    public static function getAll()
    {
        $db = static::getDB();
        $results = mysqli_query($db, 'SELECT email, fullname, organization, isadmin, enabled FROM flrp.users');

        return $results;
    }

    public static function validate($email, $password){
        $pass = hash('sha256', $password);
        $db = static::getDB();
        $user = mysqli_query($db, "SELECT email, isadmin, password FROM flrp.users where enabled = 1 and email = '" .$email."'");
        if ($user->num_rows > 0)
            $useri = $user->fetch_assoc();
        $passi = $useri["password"];
        if($pass == $passi) {
            if ($useri['isadmin'] == 0)
                $role = User::$UserRole;
            else
                $role = User::$AdminRole;
            return $role;
        }
        else
            return null;
    }

    public static function save($email, $name, $pass, $isadmin, $organization)
    {

        $db = static::getDB();
        mysqli_query($db, "INSERT INTO flrp.users (email, fullname, password, isadmin, organization) VALUES ('" .$email."', '".$name."', '".$pass."',  '".$isadmin."', '".$organization."')");
        mysqli_commit($db);
            throw new \Exception(mysqli_error($db));
    }

    public static function updateRole($email, $isadmin)
    {
        $db = static::getDB();
        $userrole = mysqli_query($db, "update flrp.users set email = '" . $email . "',  isadmin = '" . $isadmin . "' where email = '" . $email . "'");
        return $userrole;
    }

    public static function disable($email){
        $db = static::getDB();
        if(!mysqli_query($db, "update flrp.users set enabled = 0 where email = '".$email."'"))
            throw new \Exception(mysqli_error($db));
    }

    public static function enable($email){
        $db = static::getDB();
        if(!mysqli_query($db, "update flrp.users set enabled = 1 where email = '".$email."'"))
            throw new \Exception(mysqli_error($db));
    }

    public static function updatePass($email, $rand){
        $pass = hash('sha256', $rand);
        $db = static::getDB();
        $resetpass = mysqli_query($db, "update flrp.users set password = '".$pass."' where email = '".$email."'");
        return $resetpass;


    }
}




