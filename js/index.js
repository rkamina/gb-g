
$(function () {


    $(window).load(function() {
        getdata();
    });
    
    var vsLinkget = function(id, name){
        return "・対戦相手 「 <b>" + name + "</b> 」 : <a href='http://gbf.game.mbga.jp/#guild/detail/" + id +"' target ='_gild'>【詳細】</a>";
    }

    var getdata = function(){
        
        var value = $("#Slider5").val();
        value = value.split(";");
        
        var hours = Math.floor( value[0] / 60 );
        var mins = ( value[0] - hours*60 );
        var ret_from =  (hours < 10 ? "0"+hours : hours) + ":" + ( mins == 0 ? "00" : mins );
        hours = Math.floor( value[1] / 60 );
        mins = ( value[1] - hours*60 );
        var ret_to =  (hours < 10 ? "0"+hours : hours) + ":" + ( mins == 0 ? "00" : mins );
        $.ajax({
            type: 'POST',
            url: './getAveData.php',
            data: {"from":ret_from, "to":ret_to},
            dataType: 'json',
            async : false,
            success: function(obj) {
                
                if(obj.is_null != undefined){
                    if(obj.is_null == 2){
                        //対戦相手なし
                        $("#u_guild").hide();
                        return;
                    }
                    alert('データが取れませんでした');
                }
                
                var value = vsLinkget(obj.op_id, obj.op_name);
                gr(obj);
                $('#d_g_name').html(value);
                $("#g_list").empty();
                $('#guild_box').hide();
                $('#d_guild_box').show();
                $('#container').css("visibility","visible");
                $('#layout_slider').css("visibility","visible");
            }
        });
    }

    var gr = function(obj){
        $('#container').highcharts(obj);
        $('#sl_my_name').html(obj.my_name);
        $('#sl_op_name').html(obj.op_name);
        $('#sl_my_data').val(obj.my_last);
        $('#sl_op_data').val(obj.op_last);
    }
    
    $("#Slider5").slider({ 
        from: 420, to: 1440, step: 10, dimension: '', 
        scale: ['07:00', '08:00','09:00','10:00','11:00','12:00','13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00' ,'22:00', '23:00', '24:00'], 
        limits: false, 
        calculate: function( value ){
            var hours = Math.floor( value / 60 );
            var mins = ( value - hours*60 );
            return (hours < 10 ? "0"+hours : hours) + ":" + ( mins == 0 ? "00" : mins );
        }
    })
    
    $("#guild").click(function(){
        if($('#g_name').val() == ''){
            return false;
        }
        
        $("#g_list").empty();
        
        $.ajax({
            type: 'POST',
            url: './getGuildList.php',
            data: {"g_name":$('#g_name').val()},
            dataType: 'json',
            async : false,
            success: function(obj) {
                $.each(obj,function(i, v){
                    var g_name = "<span data-i=" + v["id"] +" data-n=" +  v["name"] + "   '>[確定] </span>"
                    var value = "";
                    if(v["id"] != "-NOT-"){
                        value = g_name + " : <a href='http://gbf.game.mbga.jp/#guild/detail/" + v["id"] +"' target ='_gild'>"+  v["name"] +"</a>";
                    }else{
                        value = v["name"];
                    }
                    $("#g_list").append($("<li>" + value +"</li>"));
                    
                });
            }
        });
    });
    
    $("#g_list").on("click", 'span', function(){
        var name = $(this).data("n");
        var id = $(this).data("i");
        var result = confirm("対戦相手は id["+ id + "]: " + name + " ですか？");
        if(result){

            $.ajax({
                type: 'POST',
                url: './setGuildList.php',
                data: {"g_id":$(this).data("i")},
                dataType: 'json',
                async : false,
                success: function(obj) {
                    $('#guild_box').hide();
                    $('#d_guild_box').show();
                    $("#g_list").empty();
                    getdata();
                }
            });
        }else{
            return;
        }
    });
    
    $("#u_guild").on("click", function(){
        var cancel = '[ 修正キャンセル ]';
        if($("#u_guild").html() != cancel){
            $("#u_guild").html(cancel);
            $('#d_guild_box').hide();
            $('#guild_box').show();
        }else{
            $("#u_guild").html("[ 対戦相手修正 ]");
            $('#d_guild_box').show();
            $('#guild_box').hide();
        }
    });
    
    $("#u_data_show").on("click", function() {
        $("#u_data_dd").toggle();
    });
    
    $("#slider_search").on("click", function() {
        getdata();
    });

    $("#u_data_input").on("click", function(){
        var my_data   = $("#sl_my_data").val();
        var op_data   = $("#sl_op_data").val();
        var date_data = $("#Slider5").val();

        $.ajax({
            type: 'POST',
            url: './setData.php',
            data: {
                "my_data":my_data,
                "op_data":op_data,
                "date":date_data
            },
            dataType: 'json',
            async : false,
            success: function(obj) {
                $("#Slider5").slider("value", "420", "1440");
                getdata();
                $("#u_data_dd").hide();
                
            }
        });

    });

});
