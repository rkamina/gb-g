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
        
        foreach($d_up as $d_key => $d_val){
            //双方の情報がなくなったら後処理
            if(($d_dn[$d_key]) == 0 && $d_val == 0 ){
                unset($d_dn[$d_key]);
                unset($d_up[$d_key]);
                continue;
            }
            $r_time[] = $d_key;
            
            //足りないほうの情報がある場合は何もせず次へ
            if(($d_dn[$d_key]) != 0 ){
                $last_key = $d_key;
                continue;
            }
            //なければ、一番最後の情報をコピーする
            $d_dn[$d_key] = $d_dn[$last_key];
        }
        $d_my =  array_values($r_flg?$d_dn:$d_up);
        $d_op =  array_values($r_flg?$d_up:$d_dn);
        
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
            if(is_null($tm[$t]) || $tm[$t] == -1){
                $tm[$t] = 0;
                $w_key[] = $t;
            }else{
                $sa = $tm[$t] - $last_input;
                $sa = count($w_key) == 0 ? 0 : round($sa / count($w_key) ,0);
                $i = 0;
                foreach($w_key as $w_t){
                    $tm[$w_t] = (int)(($sa * $i++) + $last_input);
                }
                $last_input = $tm[$t];
                $w_key = array();
            }
        }
        //尻がない場合の後処理
        foreach($w_key as $w_k){
            unset($tm[$w_k]);
        }
        return $tm;
    }
    
}

?>