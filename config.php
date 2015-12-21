<?php
    
    ini_set("date.timezone", "Asia/Tokyo");
    
    require_once("orm/idiorm.php");
    
    require_once("lib/lib.class.php");
    
    // $servername = getenv('IP');
    // $username = getenv('C9_USER');
    // $database = "c9";
    // $password = "";
    
    $servername = "mysql.hostinger.jp";
    $username = "u920304969_kamin";
    $database = "u920304969_c9";
    $password = "jdmru300";
    
    ORM::configure("mysql:host=$servername;dbname=$database");
    ORM::configure('username', $username);
    ORM::configure('password', $password);
    ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    ORM::configure('caching', true);
    ORM::configure('caching_auto_clear', true);

    static $MI_GUILD_ID   = 8081;
    static $MI_GUILD_NAME = '霧クマ艦隊だクマ';
    
    class DATE_UPDATE{
        
    public $NOW_TIME;
    public $NOW_DATE;
    public $VS_ID;
    public $NOW_TIME_0;
    public $NOW_TIME_5;
    public $FROM_TIME;
    public $TO_TIME;
    public $MI_GUILD_ID;
    
        public function __construct($MI_GUILD_ID, $date = NULL){
            $this->update($MI_GUILD_ID, $date);
        }
        
        public function update($MI_GUILD_ID, $date = NULL){
            $this->MI_GUILD_ID = $MI_GUILD_ID;
            if(is_null($date)){
                $tm = date("Y-m-d H:i:s");
            }else{
                $tm = $date;
            }
            $this->NOW_TIME = $tm;
            $this->NOW_DATE = date("Y-m-d", strtotime($tm));
            $this->VS_ID = date("Ymd", strtotime($tm)) .$MI_GUILD_ID;
            
            $this->NOW_TIME_0 = date("Y-m-d H:i:00" ,floor(strtotime($tm)/300)*300);//五分刻み開始
            $this->NOW_TIME_5 = date("Y-m-d H:i:59"  ,ceil(strtotime($tm)/300)*300);//五分刻み終了
            if($this->NOW_TIME_0 == $this->NOW_TIME_5){//0秒だと起こり得る
                $this->NOW_TIME_5 = date("Y-m-d H:i:59"  ,ceil(strtotime($tm)/300 + 1)*300) ;
            }
            
            $this->FROM_TIME  = $this->NOW_DATE ." 07:00:00";
            $this->TO_TIME    = $this->NOW_DATE ." 23:59:59";
        }
    }
    
    $t = new DATE_UPDATE($MI_GUILD_ID);
    
    
    // $t->NOW_TIME = $ret['TIME'];
    // $NOW_DATE = $ret['DATE'];
    // $VS_ID = date("Ymd") .$MI_GUILD_ID;
    // $t->NOW_TIME_0 = date("Y-m-d H:i:00" ,floor(strtotime($t->NOW_TIME)/300)*300);//五分刻み開始
    // $t->NOW_TIME_5 = date("Y-m-d H:i:00"  ,ceil(strtotime($t->NOW_TIME)/300)*300);//五分刻み終了
    // $FROM_TIME  = $NOW_DATE ." 07:00:00";
    // $TO_TIME    = $NOW_DATE ." 23:59:59";

?>