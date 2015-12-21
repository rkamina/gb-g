<?php

    require_once("config.php");
    require_once("lib/graphData.class.php");
    
    $t->NOW_DATE  = $_POST["date"]? $_POST["date"] :$t->NOW_DATE;
    
    $t->update($t->MI_GUILD_ID, $t->NOW_DATE .date(' H:i:s'));
    
    $t->FROM_TIME = $_POST["from"]? $t->NOW_DATE ." " .$_POST["from"]: $t->FROM_TIME;
    $t->TO_TIME   = $_POST["to"]?   $t->NOW_DATE ." " .$_POST["to"]:   $t->TO_TIME;
    
    
    //JS用に返却用空データを用意しておく
    $ret = array (
        "op_id" => 0,
        "op_name" => '',
        "my_name" => $MI_GUILD_NAME,
        'my_last' => 0,
        'op_last' => 0,
        );
    
    $vs_Data = ORM::for_table('vs')->where("vs_id" , $t->VS_ID)->find_one();
    
    //対戦相手がいない場合はオワル
    if(!$vs_Data){
        $ret['is_null'] = '2';
        echo json_encode($ret);
        return $ret;
    }
    
    $guild_Data = ORM::for_table('guild')->where("id" , $vs_Data->op_id)->find_one();
    $ret["op_id"] = $guild_Data->id;
    $ret["op_name"] = $guild_Data->name;

    //グラフ用表示時間配列算出ループ
    for($i = strtotime($t->FROM_TIME); $i <= strtotime($t->TO_TIME); $i = strtotime( date( "Y-m-d H:i:s" ,$i) ." +5 min" ) ){
        $time[] = date( "H:i" ,$i);
    }

    $point = ORM::for_table('ave_data')
        ->where_equal("vs_id", $t->VS_ID)
        ->where_gte("data_time", $t->FROM_TIME)
        ->where_lte("data_time", $t->TO_TIME)
        ->order_by_asc("data_time")
        ->find_array();

    if(count($point) == 0){
        $ret['is_null'] = '1';
        echo json_encode($ret);
        return $ret;
    }
    

    foreach($point as $v){
        $t = date( "H:i" ,strtotime($v['data_time']));
        $my[$t] = $v['my_data'];
        $op[$t] = $v['op_data'];
    }
    
    //最終投入データ取得
    $last = ORM::for_table('min_data')
        ->where_equal("vs_id", $t->VS_ID)
        ->order_by_DESC("data_time")
        ->find_one();
    $ret['my_last'] = $last['my_data'];
    $ret['op_last'] = $last['op_data'];

    //未入力情報算出
    $tm = lib::notDataUpdate($time, $my, $op);
    
    $gD = new graphData($tm['time']);
    $gD->setSeries($MI_GUILD_NAME, $tm['my']);
    $gD->setSeries($guild_Data->name, $tm['op']);
    
    $ret = array_merge($ret,$gD->getviewData());
    echo json_encode($ret);
    return true;
    
?>
