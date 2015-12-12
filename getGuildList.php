<?php

    require_once("config.php");
    
    $name = $_POST["g_name"];
    
    $user_list =ORM::for_table('guild')->where("name" , $name)->find_array();
    $ret = lib::retArray($user_list);
    
    if(is_null($ret)){
        $user_list =ORM::for_table('guild')->where_raw("name LIKE '%$name%'")->find_array();
        $ret = lib::retArray($user_list);
        if(is_null($ret)){
            $ret[0] = array("id" => "-NOT-", "name" => "存在しません");
        }
    }

    echo json_encode($ret);
    return true;
    
?>
