var addList = [];
var item1 = 0;
var item2 = 0;
var item3 = 0;
var item4 = 0;
$(function(){
    $(".btn-add-bill").click(function(){
        var insertYn = true;
        var info = $(this).data("view");
        info.active_payment = $("#active_payment").val();
        addList.some(function(one){
            if(one.active_payment == $("#active_payment").val()){
                if(one.sv_payment_type == info.sv_payment_type && one.sv_pay_type == info.sv_pay_type && one.sv_pay_day == info.sv_pay_day && one.sv_pay_publish_type == info.sv_pay_publish_type){
                    info.view_type = "M";
                    if(one.item_num == "1" && one.view_type == "M"){
                        if(one.sv_number > info.sv_number){
                            one.view_type = "S";
                            info.view_type = "M";
                            return true;
                        }else{
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
            info.item_num = 1;
            var view_length = addList.length;
            if(view_length == 0){
                info.view_type = "M";
            }
            addList.push(info);
            $(this).parent().hide();
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

            var html = '<tr><input type="hidden" name="cd_main[]" id="cd_main_'+view_length+'" value="'+info.view_type+'">\
                            <td>'+info.sv_number+'</td>\
                            <td>'+payment_type+'</td>\
                            <td>'+pay_type+'</td>\
                            <td class="code_'+info.active_payment+'" data-index="'+view_length+'">T0'+info.active_payment+'-1'+info.view_type+'</td>\
                            <input type="hidden" name="cd_svp_seq[]" value="'+info.svp_seq+'">\
                            <td><select name="cd_num[]" class="select2 item_num" data-index="'+view_length+'" id="view_select_'+view_length+'"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option></select></td>\
                            <td><input type="checkbox" name="cd_main_check[]" class="view_type_change" id="main_'+view_length+'" data-index="'+view_length+'" '+(info.view_type == "M" ? "checked":"")+'></td>\
                            <td><input type="text" name="cd_name[]" id="bill_name_'+view_length+'" value="'+(info.sva_seq === null ? info.sv_bill_name:info.sva_bill_name) +'"></td>\
                            <td>올리기</td>\
                        </tr>';
            $("#after-list").append(html);
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

    $("body").on("change",".item_num",function(){
        // console.log($(this).data("index"));
        var old_num = addList[$(this).data("index")].item_num;
        var old_view_type = addList[$(this).data("index")].view_type;
        addList[$(this).data("index")].item_num = $(this).val();
        item1 = 0;
        item2 = 0;
        item3 = 0;
        item4 = 0;
        var target_index = $(this).data("index");
        var target = addList[$(this).data("index")];
        // console.log(addList[$(this).data("index")]);
        addList.some(function(one,i){
            if(i != target_index){
                if(one.active_payment == $("#active_payment").val()){
                    target.view_type = "M";
                    // console.log(one.item_num+"::"+target.item_num);
                    if(one.item_num == target.item_num){
                        if(one.sv_number > target.sv_number){
                            // console.log(1);
                            $("#main_"+i).prop("checked",false);
                            one.view_type = "S";
                            target.view_type = "M";
                            return true;
                        }else{
                            // console.log(2);
                            $("#main_"+target_index).prop("checked",false);
                            target.view_type = "S";
                            return true;
                        }
                    }
                }
            }
        });
        // console.log(target.view_type);
        if(target.view_type == "M"){
            $("#main_"+$(this).data("index")).prop("checked",true);
        }
        if(old_view_type == "M"){
            addList.some(function(one,i){
                if(one.item_num == old_num){
                    one.view_type = "M";
                    $("#main_"+i).prop("checked",true);
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
        var view = $("#view_select_"+$(this).data("index")).val();
        var view_cnt = 0;
        $(".item_num").each(function(){
            if($(this).val() == view){
                view_cnt++;
                $("#main_"+$(this).data("index")).prop("checked",false);
                $("#cd_main_"+$(this).data("index")).val("S");
            }
        })
        // console.log($(this).data("index"));
        $("#main_"+$(this).data("index")).prop("checked",true);
        $("#cd_main_"+$(this).data("index")).val("M");
        if(view_cnt > 1){
            var addText = " 외";
        }else{
            var addText = "";
        }
        $("#item_name"+view+"_"+$("#active_payment").val()).html($("#bill_name_"+$(this).data("index")).val()+addText);
        setNum();
    });

    $("body").on("click",".content-tab-item",function(){
        if($(this).hasClass("add")){
            $(".payment_claim").hide();
            var length = $(".payment_claim").length+1;

            var html = "<table width='700' cellpadding='0' cellspacing='0' align='center' class='border_all payment_claim' id='payment"+length+"' >\
                            <tr>\
                                <td width='100%'>\
                                    <table cellpadding='0' cellspacing='0' height='65' width='100%'>\
                                        <tr>\
                                            <td rowspan='2' align='center' width='360' class='border_tit'><font size='6'><b>세 금 계 산 서</b></font></td>\
                                            <td rowspan='2' width='5' align='center' class='border_tit'><font size='4'><b>[</b></font></td>\
                                            <td rowspan='2' width='70' align='center' class='border_tit'>공급받는자&nbsp;<br>보 &nbsp;관 &nbsp;용&nbsp;</td>\
                                            <td rowspan='2' width='5' align='center' class='border_tit'><font size='4'><b>]</b></font></td>\
                                            <td align='right' width='85' class='border_tit'>책 번 호&nbsp;&nbsp;</td>\
                                            <td colspan='3' align='right' class='border_both'>권 &nbsp;</td>\
                                            <td colspan='4' align='right' class='border_tit'>호 &nbsp;</td>\
                                        </tr>\
                                        <tr>\
                                            <td width='85' align='right' class='border_tit'>일련번호&nbsp;</td>\
                                            <td colspan='1' class='border_back ' width='25'>&nbsp;</td>\
                                            <td colspan='1' class='border_up' width='25'>&nbsp;</td>\
                                            <td colspan='1' class='border_up' width='25'>&nbsp;</td>\
                                            <td colspan='1' class='border_up' width='25'>&nbsp;</td>\
                                            <td colspan='1' class='border_up' width='25'>&nbsp;</td>\
                                            <td colspan='1' class='border_up' width='25'>&nbsp;</td>\
                                            <td colspan='1' class='border_top' width='25'>&nbsp;</td> \
                                        </tr>\
                                    </table>\
                                </td>\
                            </tr>\
                            <tr>\
                                <td>\
                                    <table cellpadding='0' cellspacing='0' width='700'>\
                                        <tr>\
                                            <td class='border_up' align='center' width='17' rowspan='4'>공<br><br><br>급<br><br><br>자</td>\
                                            <td class='border_up' align='center' width='55' height='33'>등록번호</td>\
                                            <td class='border_up' align='center' width='278' colspan='5'>&nbsp;</td>\
                                            <td class='border_up' align='center' width='17' rowspan='4'>공<br>급<br>받<br>는<br>자</td>\
                                            <td class='border_up' align='center' width='55'>등록번호</td>\
                                            <td class='border_top' align='center' width='278' colspan='5'>&nbsp;</td>\
                                        </tr>\
                                        <tr>\
                                            <td class='border_up' align='center' width='55' height='33'>상 호<br>(법인명)</td>\
                                            <td class='border_up' align='center' width='160' colspan='3'>&nbsp;</td>\
                                            <td class='border_up' align='center' width='12' colspan='1'>성<br>명</td>\
                                            <td class='border_up' align='right' width='94' colspan='1'>인</td>\
                                            <td class='border_up' align='center' width='55'>상 호<br>(법인명)</td>\
                                            <td class='border_up' align='center' width='160' colspan='3'>&nbsp;</td>\
                                            <td class='border_up' align='center' width='12' colspan='1'>성<br>명</td>\
                                            <td class='border_top' align='right' width='94' colspan='1'>인</td>\
                                        </tr>\
                                        <tr>\
                                            <td class='border_up' align='center' width='55' height='33'>사업장<br>주  소</td>\
                                            <td class='border_up' align='center' width='278' colspan='5'>&nbsp;</td>\
                                            <td class='border_up' align='center' width='55'>사업장<br>주  소</td>\
                                            <td class='border_top' align='center' width='278' colspan='5'>&nbsp;</td>\
                                        </tr>\
                                        <tr>\
                                            <td class='border_up' align='center' width='55' height='33'>업  태</td>\
                                            <td class='border_up' align='center' width='148' colspan='1'>&nbsp;</td>\
                                            <td class='border_up' align='center' width='12' colspan='1'>종<br>목</td>\
                                            <td class='border_up' align='center' width='106' colspan='3'>&nbsp;</td>\
                                            <td class='border_up' align='center' width='55'>업 &nbsp; 태</td>\
                                            <td class='border_up' align='center' width='148' colspan='1'>&nbsp;</td>\
                                            <td class='border_up' align='center' width='12' colspan='1'>종<br>목</td>\
                                            <td class='border_top' align='center' width='106' colspan='3'>&nbsp;</td>\
                                        </tr>\
                                    </table>\
                                </td>\
                            </tr>\
                            <tr>\
                                <td width='100%'>\
                                    <table cellpadding='0' cellspacing='0' width='700'>\
                                        <tr>\
                                            <td class='border_up' align='center' width='85' height='21'>작 &nbsp; 성</td>\
                                            <td class='border_up' colspan='12' width='250' align='center'>공 &nbsp; 급 &nbsp; 가 &nbsp; 액</td>\
                                            <td class='border_up' rowspan='3' align='center' width='4' height='15'>&nbsp;</td>\
                                            <td class='border_up' colspan='10' align='center' width='190' height='15'>세 &nbsp; 액</td>\
                                            <td class='border_top reset' align='center' width='156'>비 &nbsp; 고</td>\
                                        </tr>\
                                        <tr>\
                                            <td class='border_up' align='center' width='85' height='21'>년 &nbsp; 월 &nbsp; 일</td>\
                                            <td class='border_up' align='center' width='35'><font size='1'>공란수</font></td>\
                                            <td class='border_up' align='center' width='20'>백</td>\
                                            <td class='border_up' align='center' width='20'>십</td>\
                                            <td class='border_up' align='center' width='20'>억</td>\
                                            <td class='border_up' align='center' width='20'>천</td>\
                                            <td class='border_up' align='center' width='20'>백</td>\
                                            <td class='border_up' align='center' width='20'>십</td>\
                                            <td class='border_up' align='center' width='20'>만</td>\
                                            <td class='border_up' align='center' width='20'>천</td>\
                                            <td class='border_up' align='center' width='20'>백</td>\
                                            <td class='border_up' align='center' width='20'>십</td>\
                                            <td class='border_up' align='center' width='20'>일</td>\
                                            <td class='border_up' align='center' width='20'>십</td>\
                                            <td class='border_up' align='center' width='20'>억</td>\
                                            <td class='border_up' align='center' width='20'>천</td>\
                                            <td class='border_up' align='center' width='20'>백</td>\
                                            <td class='border_up' align='center' width='20'>십</td>\
                                            <td class='border_up' align='center' width='20'>만</td>\
                                            <td class='border_up' align='center' width='20'>천</td>\
                                            <td class='border_up' align='center' width='20'>백</td>\
                                            <td class='border_up' align='center' width='20'>십</td>\
                                            <td class='border_up' align='center' width='20'>일</td>\
                                            <td class='border_top reset' align='center' width='156' rowspan='2'>&nbsp;</td>\
                                        </tr>\
                                        <tr>\
                                            <td class='border_up reset' align='center' width='85' height='25' id='date"+length+"'> &nbsp; </td>\
                                            <td class='border_up reset' align='center' width='35' id='number"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='price"+length+"_11'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='price"+length+"_10'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='price"+length+"_9'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='price"+length+"_8'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='price"+length+"_7'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='price"+length+"_6'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='price"+length+"_5'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='price"+length+"_4'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='price"+length+"_3'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='price"+length+"_2'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='price"+length+"_1'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='sprice"+length+"_10'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='sprice"+length+"_9'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='sprice"+length+"_8'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='sprice"+length+"_7'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='sprice"+length+"_6'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='sprice"+length+"_5'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='sprice"+length+"_4'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='sprice"+length+"_3'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='sprice"+length+"_2'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='20' id='sprice"+length+"_1'>&nbsp;</td>\
                                        </tr>\
                                    </table>\
                                </td>\
                            </tr>\
                            <tr>\
                                <td width='100%'>\
                                    <table cellpadding='0' cellspacing='0' width='700'>\
                                        <tr>\
                                            <td class='border_up' align='center' width='50' height='21'>월 일</td>\
                                            <td class='border_up' align='center' width='195'>품 &nbsp; &nbsp; &nbsp; 목</td>\
                                            <td class='border_up' align='center' width='42'>규 격</td>\
                                            <td class='border_up' align='center' width='65'>수 량</td>\
                                            <td class='border_up' align='center' width='55'>단 가</td>\
                                            <td class='border_up' align='center' width='150'>공급가액</td>\
                                            <td class='border_up' align='center' width='83'>세 액</td>\
                                            <td class='border_top' align='center' width='60'>비고</td>\
                                        </tr>\
                                        <tr>\
                                            <td class='border_up reset' align='center' width='50' height='25' id='item_date1_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='195' id='item_name1_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='42' id='item_etc1_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='65' id='item_cnt1_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='55' id='item_price1_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='150' id='item_oprice1_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='83' id='item_sprice1_"+length+"'>&nbsp;</td>\
                                            <td class='border_top reset' align='center' width='60' id='item_msg1_"+length+"'>&nbsp;</td>\
                                        </tr>\
                                        <tr>\
                                            <td class='border_up reset' align='center' width='50' height='25' id='item_date2_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='195' id='item_name2_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='42' id='item_etc2_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='65' id='item_cnt2_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='55' id='item_price2_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='150' id='item_oprice2_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='83' id='item_sprice2_"+length+"'>&nbsp;</td>\
                                            <td class='border_top reset' align='center' width='60' id='item_msg2_"+length+"'>&nbsp;</td>\
                                        </tr>\
                                        <tr>\
                                            <td class='border_up reset' align='center' width='50' height='25' id='item_date3_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='195' id='item_name3_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='42' id='item_etc3_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='65' id='item_cnt3_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='55' id='item_price3_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='150' id='item_oprice3_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='83' id='item_sprice3_"+length+"'>&nbsp;</td>\
                                            <td class='border_top reset' align='center' width='60' id='item_msg3_"+length+"'>&nbsp;</td>\
                                        </tr>\
                                        <tr>\
                                            <td class='border_up reset' align='center' width='50' height='25' id='item_date4_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='195' id='item_name4_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='42' id='item_etc4_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='65' id='item_cnt4_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='55' id='item_price4_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='150' id='item_oprice4_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='83' id='item_sprice4_"+length+"'>&nbsp;</td>\
                                            <td class='border_top reset' align='center' width='60' id='item_msg4_"+length+"'>&nbsp;</td>\
                                        </tr>\
                                    </table>\
                                </td>\
                            </tr>\
                            <tr>\
                                <td width='100%'>\
                                    <table cellpadding='0' cellspacing='0' width='700'>\
                                        <tr align='justify'>\
                                            <td class='border_up' align='center' width='122' height='2' >합계금액</td>\
                                            <td class='border_up' align='center' width='108'>현 &nbsp; &nbsp; 금</td>\
                                            <td class='border_up' align='center' width='108'>수 &nbsp; &nbsp; 표</td>\
                                            <td class='border_up' align='center' width='108'>어 &nbsp; &nbsp; 음</td>\
                                            <td class='border_up' align='center' width='108'>외상미수금</td>\
                                            <td class='border_top' rowspan='2' align='center' width='143'>이 금액을 <span id='paytype"+length+"'>&nbsp;  &nbsp; &nbsp; &nbsp;</span>함</td>\
                                        </tr>\
                                        <tr>\
                                            <td class='border_up reset' align='center' width='122' height='25' id='totalprice1_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='108' id='totalprice2_"+length+"'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='108'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='108'>&nbsp;</td>\
                                            <td class='border_up reset' align='center' width='108'>&nbsp;</td>\
                                        </tr>\
                                    </table>\
                                </td>\
                            </tr>\
                        </table>";


            $("#payment").append(html);
            // $(".border_all").last().attr("id","payment"+length);
            // $(".border_all").last().addClass("payment_claim");
            $(this).before("<li class='content-tab-item' data-index='"+length+"'>계산서"+length+"</li>")
        }else{

            $(".content-tab-item").removeClass("active");
            $(this).addClass("active");
            var index = $(this).data("index");
            // console.log(index);
            $("#active_payment").val(index);
            $(".payment_claim").hide();
            $("#payment"+index).show();
            $("#after-list").html("");
            addList = [];
            $(".btn-add-bill").each(function(){
                if($(this).data("clcode") != ""){
                    // console.log($(this).data("clcode"));
                    if($("#active_payment").val() == $(this).data("clcode")){
                        console.log("111>>>>>>>"+$("#active_payment").val());
                        $("#payment"+$("#active_payment").val()).find(".reset").html("");
                        // if($("#price"+$(this).data("clcode")+"_1").html() == "&nbsp;"){
                        $(this).trigger("click");
                        // }
                    }else{
                        $(this).hide();
                    }
                }
            })
            // $("#pc_seq").val($(this).data("pcseq"));
            // getList();
            // getItemList();
        }
    })
    $(".btn-save").click(function(){
        var url = "/api/claimAdd/"+$(this).data("mbseq");
        var datas = $("#addClaim").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                console.log(response);
                // document.location.reload();
            },
            error : function(error){
                console.log(error);
            }
        });
    });


})
function setNum(){
    $(".code_"+$("#active_payment").val()).each(function(){
        // console.log($("#main_"+$(this).data("index")).prop("checked"));
        if($("#main_"+$(this).data("index")).prop("checked") == true){
            var code_add = "M";
        }else{
            var code_add = "S";
        }
        var code = "T0"+$("#active_payment").val()+"-"+$("#view_select_"+$(this).data("index")).val()+code_add;
        $(this).html(code)
    })
}
function setPayment(){

    var active_payment = $("#active_payment").val();
    var item1_price = 0;
    var item2_price = 0;
    var item3_price = 0;
    var item4_price = 0;
    var totalprice = 0;
    var totalsurtax = 0;
    $("#item_date1_"+active_payment).html("");
    $("#item_name1_"+active_payment).html("");
    $("#item_oprice1_"+active_payment).html("");
    $("#item_sprice1_"+active_payment).html("");
    $("#item_msg1_"+active_payment).html("");

    $("#item_date2_"+active_payment).html("");
    $("#item_name2_"+active_payment).html("");
    $("#item_oprice2_"+active_payment).html("");
    $("#item_sprice2_"+active_payment).html("");
    $("#item_msg2_"+active_payment).html("");

    $("#item_date3_"+active_payment).html("");
    $("#item_name3_"+active_payment).html("");
    $("#item_oprice3_"+active_payment).html("");
    $("#item_sprice3_"+active_payment).html("");
    $("#item_msg3_"+active_payment).html("");

    $("#item_date4_"+active_payment).html("");
    $("#item_name4_"+active_payment).html("");
    $("#item_oprice4_"+active_payment).html("");
    $("#item_sprice4_"+active_payment).html("");
    $("#item_msg4_"+active_payment).html("");
    addList.forEach(function(one){
        if(one.active_payment == active_payment){

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
                item1_price = parseInt(item1_price)+(parseInt(one.svp_once_price)-parseInt(one.svp_once_dis_price)+parseInt(one.svp_month_price)-parseInt(one.svp_month_dis_price) - parseInt(one.svp_discount_price));
            }else if(one.item_num == 2){
                item2++;
                if(item2 == 1){
                    insertYn = true;
                }else{
                    insertYn = false;
                    addName = " 외";
                }
                item2_price = parseInt(item2_price)+(parseInt(one.svp_once_price)-parseInt(one.svp_once_dis_price)+parseInt(one.svp_month_price)-parseInt(one.svp_month_dis_price) - parseInt(one.svp_discount_price));
            }else if(one.item_num == 3){
                item3++;
                if(item3 == 1){
                    insertYn = true;
                }else{
                    insertYn = false;
                    addName = " 외";
                }
                item3_price = parseInt(item3_price)+(parseInt(one.svp_once_price)-parseInt(one.svp_once_dis_price)+parseInt(one.svp_month_price)-parseInt(one.svp_month_dis_price) - parseInt(one.svp_discount_price));
            }else if(one.item_num == 4){
                item4++;
                if(item4 == 1){
                    insertYn = true;
                }else{
                    insertYn = false;
                    addName = " 외";
                }
                item4_price = parseInt(item4_price)+(parseInt(one.svp_once_price)-parseInt(one.svp_once_dis_price)+parseInt(one.svp_month_price)-parseInt(one.svp_month_dis_price) - parseInt(one.svp_discount_price));
            }
            totalprice = item1_price + item2_price + item3_price + item4_price;
            surtaxprice = (item1_price*0.1) + (item2_price*0.1) + (item3_price*0.1) + (item4_price*0.1);
            // console.log(insertYn);
            if(insertYn){
                // console.log(one.item_num);
                $("#item_date"+one.item_num+"_"+active_payment).html("8/3");
                $("#item_name"+one.item_num+"_"+active_payment).html((one.sva_seq === null ? one.sv_bill_name:one.sva_bill_name)+addName);
                // $("#item_etc"+i+"_1").html();
                // $("#item_cnt"+i+"_1").html();
                // $("#item_price"+i+"_1").html();
                if(one.item_num == "1"){
                    $("#item_oprice1_"+active_payment).html(item1_price);
                    $("#item_sprice1_"+active_payment).html(item1_price*0.1);
                }else if(one.item_num == "2"){
                    $("#item_oprice2_"+active_payment).html(item2_price);
                    $("#item_sprice2_"+active_payment).html(item2_price*0.1);
                }else if(one.item_num == "3"){
                    $("#item_oprice3_"+active_payment).html(item3_price);
                    $("#item_sprice3_"+active_payment).html(item3_price*0.1);
                }else if(one.item_num == "4"){
                    $("#item_oprice4_"+active_payment).html(item4_price);
                    $("#item_sprice4_"+active_payment).html(item4_price*0.1);
                }

                $("#item_sprice"+one.item_num+"_"+active_payment).html();
                $("#item_msg"+one.item_num+"_"+active_payment).html();
            }else{
                $("#item_date"+one.item_num+"_"+active_payment).html("8/3");
                $("#item_name"+one.item_num+"_"+active_payment).html((one.sva_seq === null ? one.sv_bill_name:one.sva_bill_name)+addName);

                if(one.item_num == "1"){
                    $("#item_oprice1_"+active_payment).html(item1_price);
                    $("#item_sprice1_"+active_payment).html(item1_price*0.1);
                }else if(one.item_num == "2"){
                    $("#item_oprice2_"+active_payment).html(item2_price);
                    $("#item_sprice2_"+active_payment).html(item2_price*0.1);
                }else if(one.item_num == "3"){
                    $("#item_oprice3_"+active_payment).html(item3_price);
                    $("#item_sprice3_"+active_payment).html(item3_price*0.1);
                }else if(one.item_num == "4"){
                    $("#item_oprice4_"+active_payment).html(item4_price);
                    $("#item_sprice4_"+active_payment).html(item4_price*0.1);
                }
            }
            $("#totalprice1_"+active_payment).html(totalprice+surtaxprice);
            $("#totalprice2_"+active_payment).html(totalprice+surtaxprice);
            // console.log(totalprice.toString().length);
            $("#number1").html(11 - totalprice.toString().length);
            for(var i = 0; i < totalprice.toString().length;i++){
                var index =totalprice.toString().length - (i+1)
                $("#price"+active_payment+"_"+(i+1)).html(totalprice.toString().substr(index,1));
            }

            for(var i = 0; i < surtaxprice.toString().length;i++){
                var index =surtaxprice.toString().length - (i+1)
                $("#sprice"+active_payment+"_"+(i+1)).html(surtaxprice.toString().substr(index,1));
            }

        }
    });
}