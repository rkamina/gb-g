<?php

    require_once("config.php");
    
    $id = $_POST["g_id"];
    
    ORM::configure('id_column',"vs_id");
    $vs =ORM::for_table('vs')->find_one($t->VS_ID);
    
    if($vs == FALSE){
        $vsData = ORM::for_table('vs')->create();
        $vsData->vs_id = $t->VS_ID;
        $vsData->my_id = $t->MI_GUILD_ID;
        $vsData->op_id = $id;
        $vsData->save();
    }else{
        $vs->my_id = $t->MI_GUILD_ID;
        $vs->op_id = $id;
        $vs->create_at = $t->NOW_TIME;
        $vs->save();
    }
    
    

    return TRUE;
?>
