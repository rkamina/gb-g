<?php

class lib{


    //ギルドリスト用配列返却処理
    public static function retArray($list){
        $ret = array();
        switch(count($list)){
            case 0:
                $ret = NULL;
            break;
            case 1:
                $ret[0] = array("id" => $list[0]["id"], "name" => $list[0]["name"]);
            break;
            default:
                foreach($list as $dat){
                    $ret[] = array("id" => $dat["id"], "name" => $dat["name"]);
                }
            break;
        }
        return $ret;
    }
    
    //貢献度 未入力部分穴埋め処理
    public static function notDataUpdate($time, $my, $op){
        
        $d_my = self::sabun($time, $my);
        $d_op = self::sabun($time, $op);
        
        //最大配列取得
        $r_flg = false;
        $d_up = $d_my;
        $d_dn = $d_op;
        if(count($d_my) < count($d_op)){
          $d_up = $d_op;
          $d_dn = $d_my;
          $r_flg = true;
        } 

        $last_key = null;
        foreach($d_dn as $d_key => $d_val){
            if(is_null($last_key)){
                $last_key = $d_key;
            }
            //足りないほうの情報がある場合は何もせず次へ
            if($d_val != 0 ){
                $last_key = $d_key;
                continue;
            }
            //なければ、一番最後の情報をコピーする
            $d_dn[$d_key] = $d_dn[$last_key];
        }
        $last_key = null;
        foreach($d_up as $d_key => $d_val){
            if(is_null($last_key)){
                $last_key = $d_key;
            }
            //足りないほうの情報がある場合は何もせず次へ
            if($d_val != 0 ){
                $last_key = $d_key;
                continue;
            }
            
            //なければ、一番最後の情報をコピーする
            $d_up[$d_key] = $d_up[$last_key];
        }
        
        $d_my =  array_values($r_flg?$d_dn:$d_up);
        $d_op =  array_values($r_flg?$d_up:$d_dn);
        
        $last_my_val = null;
        $last_op_val = null;
        $last_data_flg = false;
        $r_time = array();
            
        foreach(array_reverse($d_my, true) as $d_time => $d_my_val){
            if($last_data_flg){
                $r_time[] = $time[$d_time];
                continue;
            }
            
            $d_op_val = $d_op[$d_time];
            if(is_null($last_my_val) || is_null($last_op_val)){
                $last_my_val = $d_my_val;
                $last_op_val = $d_op_val;
                unset($d_my[$d_time]);
                unset($d_op[$d_time]);
                continue;
            }
            $my_c_flg = false;
            $op_c_flg = false;
            if($d_my_val != $last_my_val){
                $last_my_val = $d_my_val;
                $my_c_flg = true;
            }
            if($d_op_val != $last_op_val){
                $last_op_val = $d_op_val;
                $op_c_flg = true;
            }
            if($my_c_flg == false && $op_c_flg == false){
                unset($d_my[$d_time]);
                unset($d_op[$d_time]);
                continue;
            }
            
            $last_data_flg = true;
            $r_time[] = $time[$d_time];
        }
        $r_time = array_reverse($r_time);

        return array('time' =>$r_time,
                    'my' => $d_my,
                    'op' => $d_op
                );
    }

    private static function sabun($time, $val){
        //未入力情報算出
        $w_key = array();
        $last_input = 0;
        foreach($time as $t){
            $tm[$t] = (int)$val[$t];

	        $sa = $tm[$t] - $last_input;
	        $sa = count($w_key) == 0 ? 0 : round($sa / count($w_key) ,0);
	        $i = 0;
	        foreach($w_key as $w_t){
	            $tm[$w_t] = (int)(($sa * $i++) + $last_input);
	        }
	        $last_input = $tm[$t];
	        $w_key = array();
        }
        //尻がない場合の後処理
        foreach($w_key as $w_k){
            unset($tm[$w_k]);
        }
        return $tm;
    }
    
}

?>