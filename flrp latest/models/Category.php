<?php
/**
 * Created by PhpStorm.
 * User: toluo
 * Date: 11/07/2018
 * Time: 17:02
 */

namespace FMDQ\FLRP;

require_once('ModelBase.php');

class Category extends ModelBase
{
    public $code;
    public $name;
    public $parentCode;
    public $parent;
    public $children;
    public $description;
    public $documents;
    public $enabled;
    public $icon;

    public static $allcats;

    public function __construct($code, $name, $parent)
    {
        $this->code = $code;
        $this->name = $name;
        $this->parentCode = $parent;
        $this->parent = null;
        $this->children = array();
        $this->documents = array();
    }

    public function getDescendants(&$arr)
    {
        foreach($this->children as $cat){
            array_push($arr, $cat);
            $cat->getDescendants($arr);
        }
    }

    public static function getFiles($path)
    {
        $dir = '../uploads/'.$path;
        $arr = array();
        if (file_exists($dir)) {
            $files = array_diff(scandir($dir), array('..', '.'));
            foreach($files as $file)
                $arr[] = "$dir/$file";
        }
        return $arr;
    }
    public static function ifFolderExists($path)
    {
        $dir = '../uploads/'.$path;
        file_exists($dir);
    }

    public static function getAll()
    {
        $db = static::getDB();
        $results = mysqli_query($db, 'SELECT code, name, parent, description, enabled, icons FROM flrp.categories');

        return $results;
    }


//    public static function getCatByCode()
//    {
//        $db = static::getDB();
//        $catByCodeResults = mysqli_query($db, "SELECT code, name, parent, description FROM flrp.categories where code = '".$code."'");
//
//        return $catByCodeResults;
//    }
//
//    public static function UpdateCatByCode($code, $name, $parent, $description)
//    {
//        $db = static::getDB();
//        $updateCodeResults = mysqli_query($db, "update flrp.categories set code = '$code', name = '$name', parent = '$parent', description = '$description' where code = '".$code."'");
//
//        return $updateCodeResults;
//    }


//    public static function updatecategory($code,$name,$parent, $description)
//    {
//        $db = static::getDB();
//        $userrole = mysqli_query($db, "update flrp.users set code = '" . $code . "',  name = '" . $name . "' , parent  = '" . $parent . "',  description = '" . $description . "', where code = '" . $code . "'");
//        return $userrole;
//    }


    public static function save($code, $name, $parent, $description, $icons, $oldcode)
    {
        $db = static::getDB();
        if($oldcode){
            $vals = "code = '".$code."', ";
            $vals .= "name = '".$name."', ";
            if ($parent)
            $vals .= "parent = '".$parent."', ";
            $vals .= "description = '".$description."' ,";
            $vals .= "icons = '".$icons."'";
            $sql = "UPDATE flrp.categories set ".$vals." where code = '".$oldcode."'";
            if (!mysqli_query($db, "UPDATE flrp.categories set ". $vals . " where code = '".$oldcode."'"))
                throw new \Exception($sql.mysqli_error($db));
        }else {
            $vals = "'" . $code . "', ";
            $vals .= "'" . $name . "', ";
            if ($parent)
                $vals .= "'" . $parent . "', ";
            else
                $vals .= "null, ";
            if ($description)
                $vals .= "'" . $description . "', ";
            else
                $vals .= "null";
            if ($icons)
                $vals .= "'" . $icons . "'";
            else
                $vals .= "null";
            if (!mysqli_query($db, "INSERT INTO flrp.categories (code, name, parent, description, icons) VALUES (" . $vals . ")"))
                throw new \Exception(mysqli_error($db));
        }
        //mysqli_commit($db);
    }

    public static function getHierarchy(){
        $cats = array();
        $rows = self::getAll();
        if ($rows->num_rows > 0) {
            while ($row = $rows->fetch_assoc()) {
                $c = new Category($row['code'], $row['name'], $row['parent']);
                $c->description = $row['description'];
                $c->icon = $row['icons'];
                $c->enabled = $row['enabled'] == 1;
                $cats[$row['code']] = $c;
            }
        }
        Category::$allcats = $cats;
        $rootCats = array();
        foreach ($cats as $cat) {
            if (!isset($cat->parentCode)) {
                $rootCats[$cat->code] = $cat;
                continue;
            }
            $cat->parent = $cats[$cat->parentCode];
            $cat->parent->children[$cat->code] = $cat;
        }
        return $rootCats;
    }

    public static function getDocuments($catCode){
        $cats = Category::$allcats; //assume getHierarchy has been called.
        $cati = $cats[$catCode];
        $descendants = array();
        $codes = "'".$catCode."'";
        $cati->getDescendants($descendants);
        foreach($descendants as $desc)
            $codes .= ", '".$desc->code."'";
        $db = static::getDB();
        $results = mysqli_query($db, "SELECT id, name, path, category, description, archive, enabled FROM flrp.documents where category in (".$codes.") order by category desc");
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $cati->documents[$row['id']."|".$row['name']."|".$row['path']."|".$row['enabled']."|".$row['archive']] = $row['description'];
            }
        }
        return $cati;
    }

    public static function saveDocument($name, $path, $category, $description, $archive, $id)
    {
        $db = static::getDB();
        if ($id) {
            $vals = "name = '".$name."', ";
            $vals .= "path = '".$path."', ";
            if($archive)
                $vals .= "archive = '".$archive."', ";
            $vals .= "description = '".$description."' ";
            $sql = "UPDATE flrp.documents set " . $vals . " where id = '" . $id . "'";
            if (!mysqli_query($db, "UPDATE flrp.documents set " . $vals . " where id = '" . $id . "'"))
                throw new \Exception($sql . mysqli_error($db));
        } else {
            $vals = "'" . $name . "', ";
            $vals .= "'" . $path . "', ";
            if ($category)
                $vals .= "'" . $category . "', ";
            else
                $vals .= "null, ";
            if($archive)
                $vals .= "'".$archive."', ";
            else
                $vals .= "null, ";
            $vals .= "'" . $description . "'";

            if (!mysqli_query($db, "INSERT INTO flrp.documents (name, path, category, archive, description) VALUES (" . $vals . ")"))
                throw new \Exception(mysqli_error($db));
            //mysqli_commit($db);
        }

    }

    public static function disableCategory($code){
        $db = static::getDB();
        if(!mysqli_query($db, "update flrp.categories set enabled = 0 where code = '".$code."'"))
            throw new \Exception(mysqli_error($db));
    }

    public static function enableCategory($code){
        $db = static::getDB();
        if(!mysqli_query($db, "update flrp.categories set enabled = 1 where code = '".$code."'"))
            throw new \Exception(mysqli_error($db));
    }

    public static function disableDocument($docid){
        $db = static::getDB();
        if(!mysqli_query($db, "update flrp.documents set enabled = 0 where id = ".$docid))
            throw new \Exception(mysqli_error($db));
    }

    public static function enableDocument($docid){
        $db = static::getDB();
        if(!mysqli_query($db, "update flrp.documents set enabled = 1 where id = ".$docid))
            throw new \Exception(mysqli_error($db));
    }
}