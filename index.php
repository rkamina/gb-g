<?php

?>
<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>GF軍師（笑）ツール</title>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="bin/jquery.slider.min.js"></script>
    <script src="js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="js/locales/bootstrap-datepicker.ja.js" type="text/javascript"></script>

    <link rel="stylesheet" href="bin/jquery.slider.min.css" type="text/css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>

<body>
    <div id="d_guild_box" style="margin:20px 20px 20px 50px; display:none" >
        <h5>
        <div class="row">
            <div class="five  columns" id="d_g_name"></div>
            <div class="four  columns" id="d_g_name2">
                <h5>
                    <code id="u_data_show" >[ 貢献値 入力 ]</code>&nbsp;
                    <!-- code id="c_data_show" >[ 貢献値 削除 ]</code -->
                </h5>
            </div>
        </div>
        </h5>
    </div>
    
    <div id="guild_box" style="margin:20px 0px 0px 50px" >
        <span id="this_date"></span>○ 対戦する相手の団名を入れてください：
        <input type="text" title="騎空団名" value="" id="g_name" name="g_name" >
        <input type="button" title="検索" value="ギルド検索" id="guild" name="guild">
        

        <ul id="g_list"></ul>
    </div>

    <dl id="slidetoggle_menu" style="margin:20px 20px 20px 50px;">
        <dt>
            <h5><code id="u_guild" >[ 対戦相手修正 ]</code></h5>
        </dt>
        <dd id="u_data_dd" style="display:none">
            <div class="row">
                <div class="seven columns" style="border: medium solid #808080; padding:20px 10px 0px 10px">
                    <table class="u-full-width">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>貢献度</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><span id="sl_my_name"></span></td>
                          <td><input type="text" title="" value="" id="sl_my_data" name="sl_my_data" ></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td><span id="sl_op_name"></span></td>
                          <td><input type="text" title="" value="" id="sl_op_data" name="sl_op_data" ></td>
                          <td><input type="button" title="検索" value="登録" id="u_data_input" name="u_data_input"></td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </dd>
        
        <dd id="d_data_dd" style="display:none">
            <div class="row">
                <div class="seven columns" style="border: medium solid #808080; padding:20px 10px 0px 10px">
                    <table class="u-full-width">
                      <thead>
                        <tr>
                          <th>TIME</th>
                          <th id="d_my_name"></th>
                          <th id="d_op_name"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><span id="sl_my_name"></span></td>
                          <td><input type="text" title="" value="" id="sl_my_data" name="sl_my_data" ></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </dd>
    </dl>

    <script src="js/highcharts.js"></script>
    <script src="js/modules/exporting.js"></script>
    <div id="container" style="min-width: 300px; height: 500px; margin: 0px auto; padding:0px 40px; visibility:hidden"></div>

    <div class="layout-slider" id="layout_slider"  style="margin:10px 200px 10px 110px; visibility:hidden" >
        <input id="Slider5" type="slider" name="area" value="420;1440" /><br />
        <input id="dp1" maxlength="10" type="text" style="margin:10px" value="<?php echo date("Y-m-d") ?>">
        <input type="button" title="検索" value="絞り込み" id="slider_search" name="slider_search">
    </div>

    <div class="layout-slider" id="layout_slider"  style="margin:10px 200px 10px 110px; visibility:hidden" >
    </div>
    <div class="koukoku" id="koukoku"  style="margin:10px 200px 10px 110px;" >
        <!-- admax -->
        <script src="http://adm.shinobi.jp/s/625bb3900d062495a17fe10c4bce3fd0"></script>
        <!-- admax -->
        <!-- admax -->
        <script src="http://adm.shinobi.jp/s/6fb3c902e49e0a00f99a1f3c16dda998"></script>
        <!-- admax -->
    </div>
    
    
    

</body>

</html>