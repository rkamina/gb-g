<?php

    require_once("config.php");
    
    $my_data = $_POST["my_data"];
    $op_data = $_POST["op_data"];
    $date    = $_POST["date"];

    if($my_data == ''){
        $my_data = -1;
    }
    if($op_data == ''){
        $op_data = -1;
    }
    
    ORM::configure('id_column',array("vs_id","data_time"));
    $vs =ORM::for_table('min_data')
        ->where("data_time", $t->NOW_TIME)
        ->where("vs_id", $t->VS_ID)
        ->find_one();

    if($vs == FALSE){
        $vs = ORM::for_table('min_data')->create();
        $vs->vs_id     = $t->VS_ID;
        $vs->my_data   = $my_data;
        $vs->op_data   = $op_data;
        $vs->data_time = $t->NOW_TIME;
        $vs->save();
    }else{
        $vs->my_data   = $my_data;
        $vs->op_data   = $op_data;
        $vs->data_time = $t->NOW_TIME;
        $vs->save();
    }
    
    //五分毎に平均値をとり、AVEテーブルに投入する
    $min_data = ORM::for_table('min_data')
        ->where_equal("vs_id", $t->VS_ID)
        ->where_gte("data_time", $t->NOW_TIME_0)
        ->where_lte("data_time", $t->NOW_TIME_5)
        ->find_array();
    if(count($min_data) > 1){
        $my_no = 0;
        $op_no = 0;
        foreach($min_data as $dat){
            $dat['my_data'] == -1 ? $my_no++ : $my_sum += $dat['my_data'];
            $dat['op_data'] == -1 ? $op_no++ : $op_sum += $dat['op_data'];
        }
        $my_data = (int)round($my_sum/(count($min_data)-$my_no));
        $op_data = (int)round($op_sum/(count($min_data)-$op_no));
    }
    
    
    ORM::configure('id_column',array("vs_id","data_time"));
    $vs = ORM::for_table('ave_data')
        ->where("vs_id", $t->VS_ID)
        ->where("data_time", $t->NOW_TIME_0)
        ->find_one();
    if($vs == FALSE){
        $vs = ORM::for_table('ave_data')->create();
        $vs->vs_id     = $t->VS_ID;
        $vs->my_data   = $my_data;
        $vs->op_data   = $op_data;
        $vs->data_time = $t->NOW_TIME_0;
        $vs->save();
    }else{
        $vs->my_data   = $my_data;
        $vs->op_data   = $op_data;
        $vs->save();
    }

    return TRUE;
?>
