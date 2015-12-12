<?php

    ini_set("date.timezone", "Asia/Tokyo");
    
    require_once("orm/idiorm.php");
    
    require_once("lib/lib.class.php");
    
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $database = "c9";
    $password = "";
    
    ORM::configure("mysql:host=$servername;dbname=$database");
    ORM::configure('username', $username);
    ORM::configure('password', $password);
    ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    ORM::configure('caching', true);
    ORM::configure('caching_auto_clear', true);

    static $MI_GUILD_ID   = 8081;
    static $MI_GUILD_NAME = '霧クマ艦隊だクマ';
    
    $NOW_TIME = date("Y-m-d H:i:s");
    $NOW_DATE = date("Y-m-d");
    $VS_ID = date("Ymd") .$MI_GUILD_ID;
    
    /**
    $NOW_TIME = "2015-10-28 23:47:30";
    $NOW_DATE = "2015-10-28";
    $VS_ID    = "20151028" .$MI_GUILD_ID;
    **/
    
    $NOW_TIME_0 = date("Y-m-d H:i:00" ,floor(strtotime($NOW_TIME)/300)*300);//五分刻み開始
    $NOW_TIME_5 = date("Y-m-d H:i:00"  ,ceil(strtotime($NOW_TIME)/300)*300);//五分刻み終了
    if($NOW_TIME_0 == $NOW_TIME_5){//0秒だと起こり得る
        $NOW_TIME_5 = date("Y-m-d H:i:00"  ,ceil(strtotime($NOW_TIME)/300 + 1)*300) ;
    }
    
    $FROM_TIME  = $NOW_DATE ." 07:00:00";
    $TO_TIME    = $NOW_DATE ." 23:59:59";

?>