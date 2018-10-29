
var item1 = 0;
var item2 = 0;
var item3 = 0;
var item4 = 0;
$(function(){
    $(".btn-add-bill").click(function(){
        var insertYn = true;
        var info = $(this).data("view");

        info.active_payment = $("#active_payment").val();
        var addYn = 0;
        addList[$("#active_payment").val()].some(function(one){
            if(one.active_payment == $("#active_payment").val()){
                addYn++;
                if(one.sv_payment_type == info.sv_payment_type && one.sv_pay_type == info.sv_pay_type && one.sv_payment_day == info.sv_payment_day && one.sv_pay_publish_type == info.sv_pay_publish_type && one.svp_payment_period == info.svp_payment_period){
                    info.view_type = "M";
                    // console.log(one.item_num+"::"+one.view_type);
                    if(one.item_num == "1" && one.view_type == "M"){
                        if(one.sv_number > info.sv_number){

                            one.view_type = "S";
                            $("#addClaim"+$("#active_payment").val()).find("#main_"+addYn).prop("checked",false);
                            $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+addYn).val("S");
                            info.view_type = "M";
                            
                            // console.log(one)
                            return true;
                        }else{
                            // $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+addYn).val("S");
                            info.view_type = "S";
                            
                            return true;
                        }
                    }
                }else{
                    alert("계산서 묶음 발행이 불가한 서비스 입니다.");
                    insertYn = false;
                    return true;
                }
            }
        });

        if(insertYn){
            // console.log(addYn);
            info.item_num = 1;
            // var view_length = addList.length;
            if(addList[$("#active_payment").val()].length == 0){
                info.view_type = "M";
            }
            // console.log(addList);
            addList[$("#active_payment").val()].push(info);
            $(this).parent().hide();
            var svpseq = $(this).parent().data("svpseq");
            if(info.sv_payment_type == "1"){
                var payment_type = "무통장";
            }else if(info.sv_payment_type == "2"){
                var payment_type = "카드";
            }else{
                var payment_type = "CMS";
            }

            if(info.sv_pay_type == "0"){
                var pay_type = "전월 "+info.sv_pay_day+"일";
            }else if(info.sv_pay_type == "1"){
                var pay_type = "당월 "+info.sv_pay_day+"일";
            }else{
                var pay_type = "익월 "+info.sv_pay_day+"일";
            }

            var html = '<tr class="dynamicclaim" data-svpseq="'+svpseq+'"><input type="hidden" name="cd_main[]" id="cd_main_'+$("#active_payment").val()+'_'+addList[$("#active_payment").val()].length+'" value="'+info.view_type+'"><input type="hidden" name="cd_seq[]" id="cd_seq_'+$("#active_payment").val()+'_'+addList[$("#active_payment").val()].length+'" value="">\
                            <td>'+(info.sva_seq === null ? info.sv_number:info.sva_number)+'</td>\
                            <td>'+payment_type+'</td>\
                            <td>'+pay_type+'</td>\
                            <td class="code_'+info.active_payment+'" data-index="'+addList[$("#active_payment").val()].length+'">T0'+info.active_payment+'-1'+info.view_type+'</td>\
                            <input type="hidden" name="cd_svp_seq[]" value="'+info.svp_seq+'">\
                            <td><select name="cd_num[]" class="select2 item_num" data-index="'+addList[$("#active_payment").val()].length+'" id="view_select_'+addList[$("#active_payment").val()].length+'"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option></select></td>\
                            <td><input type="checkbox" name="cd_main_check[]" class="view_type_change" id="main_'+(addList[$("#active_payment").val()].length)+'" data-index="'+addList[$("#active_payment").val()].length+'" '+(info.view_type == "M" ? "checked":"")+'></td>\
                            <td><input type="text" name="cd_name[]" id="bill_name_'+addList[$("#active_payment").val()].length+'" value="'+(info.sva_seq === null ? info.sv_bill_name:info.sva_bill_name) +'"></td>\
                            <td class="btn-del-bill" ><i class="fa fa-caret-up fa-2x" aria-hidden="true"></i></td>\
                        </tr>';
            $("#after-list"+$("#active_payment").val()).append(html);
            setPayment();
        }
        if(info.sv_pay_publish_type == 0){
            $("#paytype"+$("#active_payment").val()).html("영수");
        }else{
            $("#paytype"+$("#active_payment").val()).html("청구");
        }
        setNum();
        $(".select2").select();
    });

    $("body").on("click",".btn-del-bill",function(){
        var trdata = $(this).parent();
        if(trdata.hasClass("dynamicclaim")){
            var svpseq = trdata.data("svpseq");
            $(".noclaim").each(function(){
                if(svpseq == $(this).data("svpseq")){
                    $(this).show();
                }
            })
            trdata.remove();
            addList[$("#active_payment").val()].forEach(function(one,i){
                if(one.svp_seq == svpseq){
                    addList[$("#active_payment").val()].splice(i,1);
                }
            })
        }else{
            var svpseq = trdata.data("svpseq");
            // console.log(svpseq);
            $(".noclaim").each(function(){
                if(svpseq == $(this).data("svpseq")){
                    $(this).show();
                }
            })
            trdata.remove();
            addList[$("#active_payment").val()].forEach(function(one,i){
                if(one.svp_seq == svpseq){
                    addList[$("#active_payment").val()].splice(i,1);
                }
            })
        }
        setNum();
        setPayment();
        console.log(addList);
    })

    $("body").on("change",".item_num",function(){
        // console.log($(this).data("index"));
        var old_num = addList[$("#active_payment").val()][$(this).data("index")-1].item_num;
        var old_view_type = addList[$("#active_payment").val()][$(this).data("index")-1].view_type;
        
        item1 = 0;
        item2 = 0;
        item3 = 0;
        item4 = 0;
        var target_index = $(this).data("index");
        var target = addList[$("#active_payment").val()][$(this).data("index")-1];
        target.item_num = $(this).val();
        var item_num = $(this).val();
        // console.log(addList[$(this).data("index")]);
        addList[$("#active_payment").val()].some(function(one,i){
            // console.log(i+"::"+target_index);
            if((i+1) != target_index){
                if(one.active_payment == $("#active_payment").val()){
                    target.view_type = "M";
                    // console.log(one.item_num+"::"+target.item_num);
                    if(one.item_num == target.item_num){
                        if(one.sva_seq === null && target.sva_seq === null){
                            if(one.sv_number > target.sv_number){
                                console.log(1);
                                $("#addClaim"+$("#active_payment").val()).find("#main_"+(i+1)).prop("checked",false);
                                $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+(i+1)).val("S");
                                $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+target_index).val("M");
                                one.view_type = "S";
                                target.view_type = "M";
                                return true;
                            }else{
                                console.log(2);
                                $("#addClaim"+$("#active_payment").val()).find("#main_"+target_index).prop("checked",false);
                                $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+target_index).val("S");
                                target.view_type = "S";
                                return true;
                            }
                        }else if(one.sva_seq !== null && target.sva_seq === null){
                            console.log(3);
                            $("#addClaim"+$("#active_payment").val()).find("#main_"+(i+1)).prop("checked",false);
                            $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+(i+1)).val("S");
                            $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+target_index).val("M");
                            one.view_type = "S";
                            target.view_type = "M";
                            return true;
                        }else if(one.sva_seq === null && target.sva_seq !== null){
                            console.log(4);
                            $("#addClaim"+$("#active_payment").val()).find("#main_"+target_index).prop("checked",false);
                            $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+target_index).val("S");
                            target.view_type = "S";
                            return true;
                        }else{
                            if(one.sva_number > target.sva_number){
                                // console.log(1);
                                console.log(5);
                                $("#addClaim"+$("#active_payment").val()).find("#main_"+(i+1)).prop("checked",false);
                                $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+target_index).val("M");
                                $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+(i+1)).val("S");
                                one.view_type = "S";
                                target.view_type = "M";
                                return true;
                            }else{
                                // console.log(2);
                                console.log(6);
                                $("#addClaim"+$("#active_payment").val()).find("#main_"+target_index).prop("checked",false);
                                $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+target_index).val("S");
                                target.view_type = "S";
                                return true;
                            }
                        }
                    }
                }
            }else{
                one.item_num = item_num;
            }
        });
        // console.log(target.view_type);
        if(target.view_type == "M"){
            console.log(7);
            $("#addClaim"+$("#active_payment").val()).find("#main_"+$(this).data("index")).prop("checked",true);
            $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+$(this).data("index")).val("M");
        }
        if(old_view_type == "M"){
            addList[$("#active_payment").val()].some(function(one,i){
                if(one.item_num == old_num){
                    console.log(8);
                    one.view_type = "M";
                    $("#addClaim"+$("#active_payment").val()).find("#main_"+(i+1)).prop("checked",true);
                    $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$("#active_payment").val()+"_"+(i+1)).val("M");
                    return true;
                }
            })
        }

        // console.log(addList);
        setPayment();
        setNum();
    });

    $("body").on("click",".view_type_change",function(e){
        // e.preventDefault();
        var view = $("#addClaim"+$("#active_payment").val()).find("#view_select_"+$(this).data("index")).val();
        var view_cnt = 0;
        $("#addClaim"+$("#active_payment").val()).find(".item_num").each(function(){
            if($(this).val() == view){
                view_cnt++;
                $("#addClaim"+$("#active_payment").val()).find("#main_"+$(this).data("index")).prop("checked",false);
                $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$(this).data("index")).val("S");
            }
        })
        // console.log($(this).data("index"));
        $("#addClaim"+$("#active_payment").val()).find("#main_"+$(this).data("index")).prop("checked",true);
        $("#addClaim"+$("#active_payment").val()).find("#cd_main_"+$(this).data("index")).val("M");
        if(view_cnt > 1){
            var addText = " 외";
        }else{
            var addText = "";
        }
        $("#item_name"+view+"_"+$("#active_payment").val()).html($("#addClaim"+$("#active_payment").val()).find("#bill_name_"+$(this).data("index")).val()+addText);
        setNum();
    });

    
    $(".btn-save").click(function(){
        var seq = $("#payment"+$("#active_payment").val()).data("seq");
        // console.log(seq);
        var inputLenth = $("#after-list"+$("#active_payment").val()).find("tr");
        if(inputLenth.length == 0){
            alert("설정된 값이 없습니다.");
            return false;
        }
        if(confirm("저장 하시겠습니까?")){
            if(seq == ""){
                var url = "/api/claimAdd/"+$(this).data("mbseq");
                var datas = $("#addClaim"+$("#active_payment").val()).serialize();
                
                $.ajax({
                    url : url,
                    type : 'POST',
                    dataType : 'JSON',
                    data : datas+"&cl_code="+(parseInt($("#active_payment").val())+1),
                    success:function(response){
                        console.log(response);
                        if(response.result){
                            alert("저장 되었습니다.");
                        }
                        // document.location.reload();
                    },
                    error : function(error){
                        console.log(error);
                    }
                });
            }else{
                // console.log($("#cl_seq").val());
                var url = "/api/claimUpdate/"+$("#cl_seq").val();
                var datas = $("#addClaim"+$("#active_payment").val()).serialize();
                
                $.ajax({
                    url : url,
                    type : 'POST',
                    dataType : 'JSON',
                    data : datas+"&seq="+seq,
                    success:function(response){
                        console.log(response);
                        if(response.result){
                            alert("저장 되었습니다.");
                        }
                        // document.location.reload();
                    },
                    error : function(error){
                        console.log(error);
                    }
                });
            }
        }
    });

    $(".btn-delete").click(function(){
        var seq = $("#payment"+$("#active_payment").val()).data("seq");
        if(seq !== undefined){
            var url = "/api/claimDel/"+seq;
            // var datas = $("#addClaim").serialize();
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                success:function(response){
                    console.log(response);
                    if(response.result){
                        alert("삭제 되었습니다.");
                        document.location.reload();
                    }
                    // document.location.reload();
                },
                error : function(error){
                    console.log(error);
                }
            });  
        }else{
            $("#payment"+$("#active_payment").val()).remove();
        }
          
    })

})
function setNum(){
    $(".code_"+$("#active_payment").val()).each(function(){
        // console.log($("#main_"+$(this).data("index")).prop("checked"));

        if($("#addClaim"+$("#active_payment").val()).find("#main_"+$(this).data("index")).prop("checked") == true){
            var code_add = "M";
        }else{
            var code_add = "S";
        }
        var code = "T0"+(parseInt($("#active_payment").val())+1)+"-"+$("#addClaim"+$("#active_payment").val()).find("#view_select_"+$(this).data("index")).val()+code_add;
        // console.log(code);
        $(this).html(code)
    })
}
function setPayment(){
    item1 = 0;
    item2 = 0;
    item3 = 0;
    item4 = 0;
    var active_payment = $("#active_payment").val();
    var item1_price = 0;
    var item2_price = 0;
    var item3_price = 0;
    var item4_price = 0;
    var totalprice = 0;
    var totalsurtax = 0;
    $("#item_date1_1_"+active_payment).html("");
    $("#item_date1_2_"+active_payment).html("");
    $("#item_name1_"+active_payment).html("");
    $("#item_oprice1_"+active_payment).html("");
    $("#item_sprice1_"+active_payment).html("");
    $("#item_msg1_"+active_payment).html("");

    $("#item_date2_1_"+active_payment).html("");
    $("#item_date2_2_"+active_payment).html("");
    $("#item_name2_"+active_payment).html("");
    $("#item_oprice2_"+active_payment).html("");
    $("#item_sprice2_"+active_payment).html("");
    $("#item_msg2_"+active_payment).html("");

    $("#item_date3_1_"+active_payment).html("");
    $("#item_date3_2_"+active_payment).html("");
    $("#item_name3_"+active_payment).html("");
    $("#item_oprice3_"+active_payment).html("");
    $("#item_sprice3_"+active_payment).html("");
    $("#item_msg3_"+active_payment).html("");

    $("#item_date4_1_"+active_payment).html("");
    $("#item_date4_2_"+active_payment).html("");
    $("#item_name4_"+active_payment).html("");
    $("#item_oprice4_"+active_payment).html("");
    $("#item_sprice4_"+active_payment).html("");
    $("#item_msg4_"+active_payment).html("");
    
    addList[$("#active_payment").val()].forEach(function(one){
        // console.log(one);
        if(one.active_payment == active_payment){
            console.log(one);
            var insertYn = false;
            var addName = "";
            // console.log(one.item_num);
            if(one.item_num == 1){
                item1++;
                // console.log(item1);
                if(item1 == 1){
                    insertYn = true;
                }else{
                    insertYn = false;
                    addName = " 외";
                }
                item1_price = parseInt(item1_price)+(parseInt(one.svp_once_price)-parseInt(one.svp_once_dis_price)+(parseInt(one.svp_month_price)-parseInt(one.svp_month_dis_price))*parseInt(one.svp_payment_period) - parseInt(one.svp_discount_price));
            }else if(one.item_num == 2){
                item2++;
                if(item2 == 1){
                    insertYn = true;
                }else{
                    insertYn = false;
                    addName = " 외";
                }
                item2_price = parseInt(item2_price)+(parseInt(one.svp_once_price)-parseInt(one.svp_once_dis_price)+(parseInt(one.svp_month_price)-parseInt(one.svp_month_dis_price))*parseInt(one.svp_payment_period) - parseInt(one.svp_discount_price));
            }else if(one.item_num == 3){
                item3++;
                if(item3 == 1){
                    insertYn = true;
                }else{
                    insertYn = false;
                    addName = " 외";
                }
                item3_price = parseInt(item3_price)+(parseInt(one.svp_once_price)-parseInt(one.svp_once_dis_price)+(parseInt(one.svp_month_price)-parseInt(one.svp_month_dis_price))*parseInt(one.svp_payment_period) - parseInt(one.svp_discount_price));
            }else if(one.item_num == 4){
                item4++;
                if(item4 == 1){
                    insertYn = true;
                }else{
                    insertYn = false;
                    addName = " 외";
                }
                item4_price = parseInt(item4_price)+(parseInt(one.svp_once_price)-parseInt(one.svp_once_dis_price)+(parseInt(one.svp_month_price)-parseInt(one.svp_month_dis_price))*parseInt(one.svp_payment_period) - parseInt(one.svp_discount_price));
            }
            totalprice = item1_price + item2_price + item3_price + item4_price;
            surtaxprice = (item1_price*0.1) + (item2_price*0.1) + (item3_price*0.1) + (item4_price*0.1);
            // console.log(insertYn);
            var month = moment(new Date()).format("M");
            var day = moment(new Date()).format("DD");
            if(insertYn){
                // console.log(one.sv_bill_name);
                // console.log(one.sva_seq);
                // console.log(one.item_num);
                $("#item_date"+one.item_num+"_1_"+active_payment).html(month);
                $("#item_date"+one.item_num+"_2_"+active_payment).html(day);
                if(one.view_type == "M")
                    $("#item_name"+one.item_num+"_"+active_payment).html((one.sva_seq === null ? one.sv_bill_name:one.sva_bill_name));
                // $("#item_etc"+i+"_1").html();
                // $("#item_cnt"+i+"_1").html();
                // $("#item_price"+i+"_1").html();
                if(one.item_num == "1"){
                    $("#item_oprice1_"+active_payment).html($.number(item1_price));
                    $("#item_sprice1_"+active_payment).html($.number(item1_price*0.1));
                }else if(one.item_num == "2"){
                    $("#item_oprice2_"+active_payment).html($.number(item2_price));
                    $("#item_sprice2_"+active_payment).html($.number(item2_price*0.1));
                }else if(one.item_num == "3"){
                    $("#item_oprice3_"+active_payment).html($.number(item3_price));
                    $("#item_sprice3_"+active_payment).html($.number(item3_price*0.1));
                }else if(one.item_num == "4"){
                    $("#item_oprice4_"+active_payment).html($.number(item4_price));
                    $("#item_sprice4_"+active_payment).html($.number(item4_price*0.1));
                }

                $("#item_sprice"+one.item_num+"_"+active_payment).html();
                $("#item_msg"+one.item_num+"_"+active_payment).html();
            }else{
                console.log(one.sv_bill_name);
                $("#item_date"+one.item_num+"_1_"+active_payment).html(month);
                $("#item_date"+one.item_num+"_2_"+active_payment).html(day);
                if(one.view_type == "M")
                    $("#item_name"+one.item_num+"_"+active_payment).html((one.sva_seq === null ? one.sv_bill_name:one.sva_bill_name));

                if(one.item_num == "1"){
                    $("#item_oprice1_"+active_payment).html($.number(item1_price));
                    $("#item_sprice1_"+active_payment).html($.number(item1_price*0.1));
                }else if(one.item_num == "2"){
                    $("#item_oprice2_"+active_payment).html($.number(item2_price));
                    $("#item_sprice2_"+active_payment).html($.number(item2_price*0.1));
                }else if(one.item_num == "3"){
                    $("#item_oprice3_"+active_payment).html($.number(item3_price));
                    $("#item_sprice3_"+active_payment).html($.number(item3_price*0.1));
                }else if(one.item_num == "4"){
                    $("#item_oprice4_"+active_payment).html($.number(item4_price));
                    $("#item_sprice4_"+active_payment).html($.number(item4_price*0.1));
                }
            }
            $("#totalprice1_"+active_payment).html($.number(totalprice+surtaxprice));
            $("#totalprice2_"+active_payment).html($.number(totalprice+surtaxprice));
            $("#totalprice3_"+active_payment).html(0);
            $("#totalprice4_"+active_payment).html(0);
            $("#totalprice5_"+active_payment).html(0);
            // console.log(totalprice.toString().length);
            $("#number"+active_payment).html(11 - totalprice.toString().length);
            $("#top_totalprice"+active_payment).html($.number(totalprice));
            $("#top_surtax"+active_payment).html($.number(surtaxprice));
            // for(var i = 0; i < totalprice.toString().length;i++){
            //     var index =totalprice.toString().length - (i+1)
            //     $("#price"+active_payment+"_"+(i+1)).html(totalprice.toString().substr(index,1));
            // }

            // for(var i = 0; i < surtaxprice.toString().length;i++){
            //     var index =surtaxprice.toString().length - (i+1)
            //     $("#sprice"+active_payment+"_"+(i+1)).html(surtaxprice.toString().substr(index,1));
            // }

        }
    });
    console.log(item1);
    if(item1 > 1){
        $("#item_name1_"+active_payment).html($("#item_name1_"+active_payment).html()+" 외");
    }
    if(item2 > 1){
        $("#item_name2_"+active_payment).html($("#item_name2_"+active_payment).html()+" 외");
    }
    if(item3 > 1){
        $("#item_name3_"+active_payment).html($("#item_name3_"+active_payment).html()+" 외");
    }
    if(item4 > 1){
        $("#item_name4_"+active_payment).html($("#item_name4_"+active_payment).html()+" 외");
    }
}

function getClaimDetail(cl_seq,idx){
    // console.log(idx);
    var url = "/api/claimDetail/";
    // var datas = $("#addClaim").serialize();
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : "cl_seq="+cl_seq,
        success:function(response){
            console.log(response);
            for(var i = 0; i < response.length;i++){
                var info = response[i];
                info.active_payment = idx;
                info.item_num = info.cd_num;
                // var view_length = addList.length;
                info.view_type = info.cd_main;
                addList[idx].push(info);
                if(info.sv_payment_type == "1"){
                    var payment_type = "무통장";
                }else if(info.sv_payment_type == "2"){
                    var payment_type = "카드";
                }else{
                    var payment_type = "CMS";
                }

                if(info.sv_pay_type == "0"){
                    var pay_type = "전월 "+info.sv_pay_day+"일";
                }else if(info.sv_pay_type == "1"){
                    var pay_type = "당월 "+info.sv_pay_day+"일";
                }else{
                    var pay_type = "익월 "+info.sv_pay_day+"일";
                }
                var view_length = (i+1);
                var html = '<tr class="showclaim" data-svpseq="'+info.svp_seq+'"><input type="hidden" name="cd_main[]" id="cd_main_'+idx+'_'+view_length+'" value="'+info.cd_main+'"><input type="hidden" name="cd_seq[]" id="cd_seq_'+view_length+'" value="'+info.cd_seq+'">\
                                <td>'+(info.sva_seq === null ? info.sv_number:info.sva_number)+'</td>\
                                <td>'+payment_type+'</td>\
                                <td>'+pay_type+'</td>\
                                <td class="code_'+idx+'" data-index="'+view_length+'">T0'+info.cl_code+'-'+info.item_num+info.cd_main+'</td>\
                                <input type="hidden" name="cd_svp_seq[]" value="'+info.svp_seq+'">\
                                <td><select name="cd_num[]" class="select2 item_num" data-index="'+view_length+'" id="view_select_'+view_length+'"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option></select></td>\
                                <td><input type="checkbox" name="cd_main_check[]" class="view_type_change" id="main_'+view_length+'" data-index="'+view_length+'" '+(info.cd_main == "M" ? "checked":"")+'></td>\
                                <td><input type="text" name="cd_name[]" id="bill_name_'+view_length+'" value="'+(info.sva_seq === null ? info.sv_bill_name:info.sva_bill_name) +'"></td>\
                                <td class="btn-del-bill" ><i class="fa fa-caret-up fa-2x" aria-hidden="true"></i></td>\
                            </tr>';
                $("#after-list"+idx).append(html);
                $(".noclaim").each(function(){
                    if($(this).data("svpseq") == info.svp_seq){
                        $(this).hide();
                    }
                })
                if(info.sv_pay_publish_type == 0){
                    $("#paytype"+$("#active_payment").val()).html("영수");
                }else{
                    $("#paytype"+$("#active_payment").val()).html("청구");
                }
                console.log(info.item_num);
                $("#addClaim"+idx).find('#view_select_'+view_length).val(info.item_num);
              
                
            }
             setPayment();
             // setNum();
             $(".select2").select();
            // document.location.reload();
        },
        error : function(error){
            console.log(error);
        }
    });  
}