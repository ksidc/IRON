var basic_date_info = [];
var basic_date_info_add = [];
$(function(){
    // var num = Math.floor(1076/100)*100;
    // console.log(num);
    $( ".datepicker" ).datepicker({
        "dateFormat" : "yy-mm-dd",
        onSelect: function(selectedDate) {
            // console.log(selectedDate);
            if($(":input:radio[name=sr_contract_type]:checked").val() == "2"){
                 $("#sr_contract_end").val(moment($("#sr_contract_start").val()).add(1,'months').subtract(1, "days").format("YYYY-MM-DD"));
            }
            if($("#sr_contract_start").val() != "" && $("#sr_contract_end").val() != ""){
                var start = new Date($("#sr_contract_start").val());
                var end = moment($("#sr_contract_end").val()).add(1,'days').format("YYYY-MM-DD");
                end = new Date(end);
                var diff = Date.getFormattedDateDiff(start, end);
                $("#contractinfo").html("("+diff[0]+"개월 "+diff[1]+"일)");
            }else {
                if($("#sr_contract_start").val() != "" && $(":input:radio[name=sr_contract_type]:checked").val() == "2"){
                    // console.log(moment($("#sr_contract_start").val()).add(1,'months').subtract(1, "days").format("YYYY-MM-DD"));
                    $("#sr_contract_end").val(moment($("#sr_contract_start").val()).add(1,'months').subtract(1, "days").format("YYYY-MM-DD"));
                    var start = new Date($("#sr_contract_start").val());
                    // var end = new Date($("#sr_contract_end").val());
                    var end = moment($("#sr_contract_end").val()).add(1,'days').format("YYYY-MM-DD");
                    end = new Date(end);
                    var diff = Date.getFormattedDateDiff(start, end);
                    $("#contractinfo").html("("+diff[0]+"개월 "+diff[1]+"일)");
                }
            }
        }
    });
    $( ".datepicker2" ).datepicker({
        "dateFormat" : "yy-mm-dd",
        onSelect: function(selectedDate){
            // 날짜 및 초기 청구 요금 내용
            priceInfoDate();
            $(".addoptionprice").each(function(){
                var add_seq = $(this).data("seq");
                if($("#sa_pay_day_"+add_seq).val() != ""){
                    priceInfoDateAdd(add_seq);
                    calculateAddPrice(add_seq);

                }
            })
        }
    });

    $(".sa_input_date").datepicker({
        "dateFormat" : "yy-mm-dd"
    })
    $( "#dialogUserSearch" ).dialog({
        autoOpen: false,
        modal: true,
        width:'700px',
        height : 450
    });

    $( "#dialogTypeSearch" ).dialog({
        autoOpen: false,
        modal: true,
        width:'500px',
        height : 450
    });

    $( "#dialogEndSearch" ).dialog({
        autoOpen: false,
        modal: true,
        width:'500px',
        height : 450
    });

    $( "#dialogClientSearch" ).dialog({
        autoOpen: false,
        modal: true,
        width:'500px',
        height : 450
    });

    $( "#dialogFirstSetting" ).dialog({
        autoOpen: false,
        modal: true,
        width:'800px',
        height : 260
    });

    $("#userSearchForm").submit(function(e){

        if($("#memberSearchWord").val() == ""){
            alert("검색어를 입력해주세요");
            return false;
        }

        var url = "/api/memberSearchList";
        var userSearchForm = $("#userSearchForm").serialize();
        // console.log(userSearchForm);
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : userSearchForm,
            success:function(response){
                var html ="";
                if(response.length == 0){
                    html += "<tr><td colspan=5 align=center>검색결과가 없습니다.</td></tr>";
                }else{
                    for(var i = 0; i < response.length;i++){
                        html += '<tr>\
                                    <td><a href="javascript:void(0)" class="clickMember" data-name="'+response[i].mb_name+'" data-contractname="'+response[i].mb_contract_name+'" data-id="'+response[i].mb_id+'" data-tel="'+response[i].mb_tel+'" data-phone="'+response[i].mb_phone+'" data-email="'+response[i].mb_email+'" data-fax="'+response[i].mb_fax+'" data-seq="'+response[i].mb_seq+'" data-mbpaymenttype="'+response[i].mb_payment_type+'" data-mbautopayment="'+response[i].mb_auto_payment+'" data-mbpaymentpublish="'+response[i].mb_payment_publish+'" data-mbpaymentpublishtype="'+response[i].mb_payment_publish_type+'" data-mbpaymentday="'+response[i].mb_payment_day+'">'+response[i].mb_name+'('+response[i].mb_id+')</a></td>\
                                    <td>'+response[i].mb_contract_name+'</td>\
                                    <td>'+response[i].mb_number+'</td>\
                                    <td>'+response[i].mb_tel+'<br>'+response[i].mb_phone+'</td>\
                                    <td>'+response[i].mb_email+'</td>\
                                </tr>\
                        ';
                    }
                }
                $("#modalSearchMember").html(html);
            }
        });
        return false;
    });

    $("#sr_pc_seq").change(function(){
        if($(this).val() != ""){
            var url = "/api/productItemSearch/"+$(this).val();
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    $('select[name="sr_pi_seq"]').empty().append('<option value="">선택</option>');
                    $("#sr_pi_seq_str").html("선택");
                    for(var i in response){
                        $('select[name="sr_pi_seq"]').append('<option value="'+response[i].pi_seq+'" >'+response[i].pi_name+'</option>');
                    }
                }

            });
        }else{
            $('select[name="sr_pi_seq"]').empty().append('<option value="">선택</option>');
            $("#sr_pi_seq_str").html("선택");

            $('select[name="sr_pr_seq"]').empty().append('<option value="">선택</option>');
            $("#sr_pr_seq_str").html("선택");

            $("#sr_pr_name").html("상품명");

            $('select[name="sr_pd_seq"]').empty().append('<option value="">선택</option>');
            $("#sr_pd_seq_str").html("선택");

            $('select[name="sr_ps_seq"]').empty().append('<option value="">선택</option>');
            $("#sr_ps_seq_str").html("선택");
        }
    })

    $("#sr_pi_seq").change(function(){
        if($(this).val() != ""){
            var url = "/api/productSearch/"+$("#sr_pc_seq").val();
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data:"pi_seq="+$(this).val(),
                success:function(response){
                    $('select[name="sr_pr_seq"]').empty().append('<option value="">선택</option>');
                    $("#sr_pr_seq_str").html("선택");
                    for(var i in response){
                        $('select[name="sr_pr_seq"]').append('<option value="'+response[i].pr_seq+'" >'+response[i].pr_name+'</option>');
                    }
                }

            });

            var addoption = "";
            var url = "/api/productItemSub/"+$(this).val();
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    for(var i = 0; i < response.length;i++){
                        addoption += '<input type="hidden" name="sa_c_seq[]" id="sa_c_seq_'+response[i].pis_seq+'"><div class="modal-title" style="background:#ddd">\
                                <div class="modal-title-text" style="display:inline-block;background:#ddd;font-size:12px;font-weight:normal">부가 항목 '+(i+1)+'</div>\
                                <div style="display:inline-block"><input type="checkbox" data-seq="'+response[i].pis_seq+'" class="pis_yn" name="pis_yn[]" value="'+response[i].pis_seq+'" checked> 사용</div>\
                                <div style="display:inline-block;padding-left:552px"></div>\
                            </div>\
                            <div class="modal-field" style="padding-bottom:0px;padding-top:5px;text-align:right" id="addoption_view_'+response[i].pis_seq+'">\
                                <div style="width:100%">\
                                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">\
                                        <li class="dib">부가 항목명 <i class="fas fa-info-circle"></i></li>\
                                        <li class="dib" style="padding:0px 10px">\
                                            <input type="text" style="width:570px" name="sa_name[]" id="sa_name_'+response[i].pis_seq+'" value="'+response[i].pis_name+'" readonly>\
                                        </li>\
                                        <li class="dib" style="padding-right:50px"><input type="checkbox" data-num="'+(i+1)+'" data-seq="'+response[i].pis_seq+'" data-name="'+response[i].pis_name+'" data-piname="'+response[i].pi_name+'" class="etc_yn" name="etc_yn[]" id="etc_yn_'+response[i].pis_seq+'"> 계산서 품목 분류 <i class="fas fa-info-circle"></i></li>\
                                    </ul>\
                                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px;display:none" class="more_view_'+response[i].pis_seq+'">\
                                        <li class="dib">청구명(*) <i class="fas fa-info-circle"></i></li>\
                                        <li class="dib" style="padding:0px 10px">\
                                            <input type="text" style="width:286px" name="sa_claim_name[]" id="sa_claim_name_'+response[i].pis_seq+'">\
                                        </li>\
                                        <li class="dib" style="padding-left:40px">계산서 품목명(*) <i class="fas fa-info-circle"></i></li>\
                                        <li class="dib" style="padding:0px 0px 0px 10px">\
                                            <input type="text" style="width:285px" name="sa_bill_name[]" id="sa_bill_name_'+response[i].pis_seq+'" >\
                                        </li>\
                                    </ul>\
                                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px;display:none" class="more_view_'+response[i].pis_seq+'">\
                                        <li class="dib">일회성 요금(*) <i class="fas fa-info-circle"></i></li>\
                                        <li class="dib" style="padding:0px 10px">\
                                            <input type="text" style="width:80px" name="sa_once_price[]" id="sa_once_price_'+response[i].pis_seq+'" class="sa_once_price right" data-seq="'+response[i].pis_seq+'" value="0"> 원\
                                        </li>\
                                        <li class="dib" style="padding-left:50px">월 요금(*) <i class="fas fa-info-circle"></i></li>\
                                        <li class="dib" style="padding:0px 10px">\
                                            <input type="text" style="width:80px" name="sa_month_price[]" id="sa_month_price_'+response[i].pis_seq+'" class="sa_month_price right" data-seq="'+response[i].pis_seq+'" value="0"> 원/월\
                                        </li>\
                                        <li class="dib" style="padding-left:48px">결제주기 <i class="fas fa-info-circle"></i></li>\
                                        <li class="dib" style="padding:0px 172px 0px 10px">\
                                            <input type="text" style="width:50px" name="sa_pay_day[]" id="sa_pay_day_'+response[i].pis_seq+'" class="sa_pay_day" data-seq="'+response[i].pis_seq+'" value="0"> 개월\
                                        </li>\
                                    </ul>\
                                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">\
                                        <li class="dib">부가 항목 매입처 <i class="fas fa-info-circle"></i></li>\
                                        <li class="dib" style="padding:0px 10px">\
                                            <input type="text" style="width:146px" name="sa_c_name[]" id="sa_c_name_'+response[i].pis_seq+'" readonly><button class="btn btn-brown" type="button" onclick=\'$("#searchSeq").val("'+response[i].pis_seq+'");$( "#dialogClientSearch" ).dialog("open");$("#dialogClientSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();\'>검색</button>\
                                        </li>\
                                        <li class="dib" style="padding-left:171px">부가 항목 매입가 <i class="fas fa-info-circle"></i></li>\
                                        <li class="dib" style="padding:0px 56px 0px 10px">\
                                            <input type="text" style="width:180px" name="sa_input_price[]" id="sa_input_price_'+response[i].pis_seq+'" class="right">원\
                                        </li>\
                                    </ul>\
                                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">\
                                        <li class="dib">부가 항목 매입 단위 <i class="fas fa-info-circle"></i></li>\
                                        <li class="dib" style="padding:0px 10px">\
                                            <input type="text" style="width:146px" name="sa_input_unit[]" id="sa_input_unit_'+response[i].pis_seq+'"> 개월\
                                        </li>\
                                        <li class="dib" style="padding-left:174px">부가 항목 매입 시작일 <i class="fas fa-info-circle"></i></li>\
                                        <li class="dib" style="padding:0px 66px 0px 10px">\
                                            <input type="text" style="width:180px" name="sa_input_date[]" id="sa_input_date_'+response[i].pis_seq+'" class="sa_input_date datepicker3">\
                                        </li>\
                                    </ul>\
                                </div>\
                            </div>';
                    }
                    $(".addoption").html(addoption);
                    $( ".datepicker3" ).datepicker({
                        "dateFormat" : "yy-mm-dd"
                    });
                }

            });
        }else{
            $('select[name="sr_pr_seq"]').empty().append('<option value="">선택</option>');
            $("#sr_pr_seq_str").html("선택");

            $("#sr_pr_name").html("상품명");

            $('select[name="sr_pd_seq"]').empty().append('<option value="">선택</option>');
            $("#sr_pd_seq_str").html("선택");

            $('select[name="sr_ps_seq"]').empty().append('<option value="">선택</option>');
            $("#sr_ps_seq_str").html("선택");
        }
    })

    $("#sr_pr_seq").change(function(){
        if($(this).val() != ""){
            $("#sr_pr_name").html($("#sr_pr_seq option:selected").text());
            var url = "/api/productSubDepth1Search/"+$(this).val();
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    $('select[name="sr_pd_seq"]').empty().append('<option value="">선택</option>');
                    $("#sr_pd_seq_str").html("선택");
                    for(var i in response){
                        $('select[name="sr_pd_seq"]').append('<option value="'+response[i].pd_seq+'" >'+response[i].pd_name+'</option>');
                    }
                }

            });
        }else{
            $("#sr_pr_name").html("상품명");
            $('select[name="sr_pd_seq"]').empty().append('<option value="">선택</option>');
            $("#sr_pd_seq_str").html("선택");

            $('select[name="sr_ps_seq"]').empty().append('<option value="">선택</option>');
            $("#sr_ps_seq_str").html("선택");
        }
    })

    $("#sr_pd_seq").change(function(){
        if($(this).val() != ""){
            var url = "/api/productSubDepth2Search/"+$("#sr_pr_seq").val()+"/"+$(this).val();
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    // console.log(response);
                    $('select[name="sr_ps_seq"]').empty().append('<option value="">선택</option>');
                    $("#sr_ps_seq_str").html("선택");
                    for(var i in response){
                        $('select[name="sr_ps_seq"]').append('<option value="'+response[i].ps_seq+'" data-price="'+response[i].prs_price+'" data-prsoneprice="'+response[i].prs_one_price+'" data-prsmonthprice="'+response[i].prs_month_price+'" data-prsdiv="'+response[i].prs_div+'">'+response[i].ps_name+'</option>');
                    }
                }

            });
        }else{
            $('select[name="sr_ps_seq"]').empty().append('<option value="">선택</option>');
            $("#sr_ps_seq_str").html("선택");
        }
    });

    $("#sr_ps_seq").change(function(){
        if($(this).val() == ""){
            $("#sr_ps_name").html("소분류");
        }else{
            $("#sr_ps_name").html($("#sr_ps_seq option:selected").text());
            $("#sr_once_price").val($(this).find(':selected').data('prsoneprice')).trigger("change");
            $("#sr_month_price").val($(this).find(':selected').data('prsmonthprice')).trigger("change");
            $("#sr_input_price").val($(this).find(':selected').data('price'));
            if($(this).find(':selected').data('prsdiv') == "1"){
                $("#sr_month_price_str").html("원<span style='color:transparent'>/월</span>");
                $("#sr_after_price_str").html("원<span style='color:transparent'>/월</span>");
                $("#sr_input_price_text").html("원<span style='color:transparent'>/월</span>");
            }else{
                $("#sr_month_price_str").html("원/월");
                $("#sr_after_price_str").html("원/월");
                $("#sr_input_price_text").html("원/월");
            }
        }

    });

    $("#sr_rental").change(function(){
        if($(this).val() == "Y"){
            $(".rental_yn").show();
        }else{
            $(".rental_yn").hide();
        }
    })

    $("body").on("click",".etc_yn",function(){
        if($(this).is(":checked")){
            $(".more_view_"+$(this).data("seq")).show();
            var num = $(this).data("num");
            var seq = $(this).data("seq");
            var pi_name = $(this).data("piname");
            var pis_name = $(this).data("name");
            var addoptionprice = '<div style="clear:both;width:100%;border-top:1px solid #ddd" id="addoptionprice_'+seq+'" class="addoptionprice" data-seq="'+seq+'"><input type="hidden" name="sap_seq[]" id="sap_seq_'+seq+'"><input type="hidden" name="etc_yn_v[]" id="etc_yn_v_'+seq+'"><input type="hidden" name="pis_seq_add[]" id="pis_seq_add_'+seq+'" value="'+seq+'"><input type="hidden" name="sp_discount_yn_add[]" id="sp_discount_yn_add'+seq+'" value="N"><input type="hidden" name="sap_first_price_add[]" id="sap_first_price_'+seq+'" value=0><input type="hidden" name="sap_first_start_add[]" id="sap_first_start_'+seq+'"><input type="hidden" name="sap_first_end_add[]" id="sap_first_end_'+seq+'"><input type="hidden" name="sap_first_month_price_add[]" id="sap_first_month_price_'+seq+'" value=0><input type="hidden" name="sap_first_month_start_add[]" id="sap_first_start_'+seq+'"><input type="hidden" name="sap_first_month_end_add[]" id="sap_first_month_end_'+seq+'">\
                    <div style="width:10%;float:left;vertical-align:top; ">\
                        <p style="text-align:center;padding-top:100px">부가'+num+'</p>\
                    </div>\
                    <div style="width:90%;float:left;">\
                        <div style="width:38%;float:left;vertical-align:top">\
                            <ul style="text-align:right;border-left:1px solid #ddd">\
                                <li style="line-height:35px;padding-right:20px">'+pi_name+' - '+pis_name+'</li>\
                                <li style="line-height:35px;padding-right:20px;color:red">할인 금액</li>\
                                <li style="line-height:35px;padding-right:20px">할인 사유</li>\
                                <li style="line-height:35px;padding-right:20px;color:red">요금 납부 방법 및 결제 주기에 따른 할인 금액</li>\
                                <li style="line-height:35px;background:#eee;padding-right:20px;border-bottom:1px solid #ddd">소계</li>\
                            </ul>\
                        </div>\
                        <input type="hidden" name="sp_ps_seq[]" value="'+seq+'">\
                        <div style="width:30%;float:left;vertical-align:top ">\
                            <ul style="list-style:none;padding:0;margin:0">\
                                <li style="line-height:35px;padding-left:5px;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:160px" name="sp_once_price_add[]" id="sp_once_price_add_'+seq+'" class="sp_once_price_add right" data-seq="'+seq+'" readonly value=0> 원</li>\
                                <li style="line-height:35px;padding-left:5px;color:red;border-left:1px solid #ddd"> - <input type="text" style="width:160px" name="sp_once_dis_price_add[]" id="sp_once_dis_price_add'+seq+'" class="sp_once_dis_price_add right" data-seq="'+seq+'" value=0> 원</li>\
                                <li style="line-height:35px;padding-left:5px;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:160px" name="sp_once_dis_msg_add[]" id="sp_once_dis_msg_add'+seq+'"></li>\
                                <li style="line-height:35px;font-size:11px;padding-left:12px"><input type="checkbox" value="Y" id="sp_discount_yn_add_check'+seq+'" class="sp_discount_yn_add_check" data-seq="'+seq+'"> 할인적용(<span id="sr_register_discount_str_'+seq+'">0</span>%)<input type="hidden" name="sr_register_discount_add[]" id="sr_register_discount_'+seq+'" value=0></li>\
                                <li style="line-height:35px;background:#eee;padding-left:5px;border-bottom:1px solid #ddd;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:160px" name="sp_once_total_price_add[]" id="sp_once_total_price_add'+seq+'" readonly class="add_service_once_total right"> 원</li>\
                            </ul>\
                        </div>\
                        <div style="width:32%;float:left;vertical-align:top; ">\
                            <ul style="list-style:none;padding:0;margin:0">\
                                <li style="line-height:35px;padding-left:5px;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:180px" name="sp_month_price_add[]" id="sp_month_price_add'+seq+'" class="right" readonly value="0"> 원 / <span class="sa_payment_str_'+seq+'">결주</span></li>\
                                <li style="line-height:35px;padding-left:5px;color:red;border-left:1px solid #ddd"> - <input type="text" style="width:180px" name="sp_month_dis_price_add[]" id="sp_month_dis_price_add'+seq+'" class="sp_month_dis_price_add right" data-seq="'+seq+'" value="0"><span style=";color:red"> 원 / 월</span></li>\
                                <li style="line-height:35px;padding-left:4px;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:180px" name="sp_month_dis_msg_add[]" id="sp_month_dis_msg_add'+seq+'"></li>\
                                <li style="line-height:35px;padding-left:5px;color:red"> - <input type="text" style="width:180px" name="sp_discount_price_add[]" id="sp_discount_price_add'+seq+'" class="right" readonly> 원 / <span class="sa_payment_str_'+seq+'">[[결제]]</span></li>\
                                <li style="line-height:35px;background:#eee;padding-left:4px;border-bottom:1px solid #ddd;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:180px" name="sp_month_total_price_add[]" id="sp_month_total_price_add'+seq+'" readonly class="add_service_month_total right" data-seq="'+seq+'"> 원 / <span class="sa_payment_str_'+seq+'">[[결제]]</span></li>\
                            </ul>\
                        </div>\
                        <div style="clear:both;width:100%;background-color:#EBE9E4;height:50px;border-left:1px solid #ddd">\
                            <div style="width:10%;float:left">\
                                <div style="line-height:50px;padding-left:10px">초기 청구 요금</div>\
                            </div>\
                            <div style="width:90%;float:left">\
                                <ul style="padding-top:10px;padding-right:5px;letter-spacing:-1">\
                                    <li style="text-align:right;font-size:11px" id="sp_price_info_'+seq+'">일회성 요금 (<span style=";color:red" id="one_price_str_add_'+seq+'">0</span>) + <span id="start_date_str_add_0_1_'+seq+'">0000년 00월 00일</span> ~ <span id="end_date_str_add_0_1_'+seq+'">0000년 00월 00일</span> 이용료 (<span style=";color:red" id="use_price_str_add_0_1_'+seq+'">0</span>) <span id="view_add_'+seq+'" style="display:none">+ <span id="start_date_str_add_0_2_'+seq+'">0000년 00월 00일</span> ~ <span id="end_date_str_add_0_2_'+seq+'">0000년 00월 00일</span> 이용료 (<span style=";color:red" id="use_price_str_add_0_2_'+seq+'">0</span>)</span></li>\
                                    <li style=";text-align:right;padding-top:3px"> = 합계 (<span style=";color:red" id="total_str_add_'+seq+'" class="total-cal-price" data-price=0>0</span>)</li>\
                                </ul>\
                            </div>\
                        </div>\
                    </div>\
                </div>';
            $(".addoptionprice_html").append(addoptionprice);
            if($("#sa_pay_day_"+seq).val() != ""){
                priceInfoDateAdd(seq);
                calculateAddPrice(seq);

            }

        }else{
            $("#addoptionprice_"+$(this).data("seq")).remove();
            $(".more_view_"+$(this).data("seq")).hide();
        }
    });

    $("body").on("click",".pis_yn",function(){
        var seq = $(this).data("seq");
        if($(this).is(":checked")){
            $("#addoption_view_"+$(this).data("seq")).show();
            $("#sa_name_"+seq).attr("disabled",false);
            $("#sa_claim_name_"+seq).attr("disabled",false);
            $("#sa_bill_name_"+seq).attr("disabled",false);
            $("#sa_once_price_"+seq).attr("disabled",false);
            $("#sa_month_price_"+seq).attr("disabled",false);
            $("#sa_pay_day_"+seq).attr("disabled",false);
            $("#sa_c_name_"+seq).attr("disabled",false);
            $("#sa_input_price_"+seq).attr("disabled",false);
            $("#sa_input_unit_"+seq).attr("disabled",false);
            $("#sa_input_date_"+seq).attr("disabled",false);
            $("#etc_yn_"+seq).attr("disabled",false);
            $("#etc_yn_v_"+seq).attr("disabled",false);
            $("#pis_seq_add_"+seq).attr("disabled",false);
            $("#sa_seq_"+seq).attr("disabled",false);
            $("#sa_c_seq_"+seq).attr("disabled",false);
        }else{
            $("#addoption_view_"+$(this).data("seq")).hide();
            $("#sa_name_"+seq).attr("disabled",true);
            $("#sa_claim_name_"+seq).attr("disabled",true);
            $("#sa_bill_name_"+seq).attr("disabled",true);
            $("#sa_once_price_"+seq).attr("disabled",true);
            $("#sa_month_price_"+seq).attr("disabled",true);
            $("#sa_pay_day_"+seq).attr("disabled",true);
            $("#sa_c_name_"+seq).attr("disabled",true);
            $("#sa_input_price_"+seq).attr("disabled",true);
            $("#sa_input_unit_"+seq).attr("disabled",true);
            $("#sa_input_date_"+seq).attr("disabled",true);
            $("#etc_yn_"+seq).attr("disabled",true);
            $("#etc_yn_v_"+seq).attr("disabled",true);
            $("#pis_seq_add_"+seq).attr("disabled",true);
            $("#sa_seq_"+seq).attr("disabled",true);
            $("#sa_c_seq_"+seq).attr("disabled",true);
        }
    })

    $("body").on("click",".more_view_yn",function(){
        if($(this).is(":checked")){
            $(".more_view_"+$(this).data("seq")).show();
        }else{
            $(".more_view_"+$(this).data("seq")).hide();
        }
    });

    $("body").on("click",".c_click",function(){
        if($("#searchSeq").val() == ""){
            $("#sr_c_seq").val($(this).data("seq"));
            $("#sr_c_seq_str").val($(this).data("name"));

        }else{
            var searchSeq = $("#searchSeq").val();
            $("#sa_c_seq_"+searchSeq).val($(this).data("seq"));
            $("#sa_c_name_"+searchSeq).val($(this).data("name"));
        }
        $('#dialogClientSearch').dialog('close');
    });

    $("body").on("click",".clickMember",function(){
        var mb_name= $(this).data("name");

        var mb_id = $(this).data("id");

        var mb_seq = $(this).data("seq");
        $("#mb_id").val(mb_id);
        $("#mb_name").val(mb_name);

        $("#sr_mb_seq").val(mb_seq);

        $("#sr_pay_type").val($(this).data("mbpaymenttype")).trigger("change");
        $("#sr_pay_publish").val($(this).data("mbpaymentpublish")).trigger("change");
        $("#sr_pay_publish_type").val($(this).data("mbpaymentpublishtype")).trigger("change");
        $("#sr_pay_day").val($(this).data("mbautopayment")).trigger("change");
        if($(this).data("mbpaymentday") == 32){
            var mbpaymentday = "말일";
        }else{
            var mbpaymentday = $(this).data("mbpaymentday");
        }
        $("#sr_payment_day").val(mbpaymentday);
        $('#dialogUserSearch').dialog('close');
    });

    $("body").on("click",".clickEnd",function(){
        $("#eu_name").val($(this).data("name"));
        $("#sr_eu_seq").val($(this).data("seq"));
        $('#dialogEndSearch').dialog('close');
    });

    $("body").on("click",".clickType",function(){
        $("#ct_name").val($(this).data("name"));
        $("#sr_ct_seq").val($(this).data("seq"));
        $('#dialogTypeSearch').dialog('close');
    });

    $(".btn-price-policy").click(function(){
        var sp_basic_policy = $(":input:radio[name=sp_basic_type]:checked").val();
        var sp_policy = $(":input:radio[name=sp_policy]:checked").val();
        var sp_pay_day = $("#sp_pay_start_day").val();
        var sp_pay_format = $("#sp_pay_format").val();
        var sp_pay_format_policy = $("#sp_pay_format_policy").val();

        $("#sr_account_type").val(sp_basic_policy);
        $("#sr_account_policy").val(sp_policy);
        $("#sr_account_start_day").val(sp_pay_day);
        $("#sr_account_format").val(sp_pay_format);
        $("#sr_account_format_policy").val(sp_pay_format_policy);
        if(sp_basic_policy == "1"){
            if(sp_policy == "1"){
                var text = "당월분 일할 계산";
                var text2_1 = $("#sp_pay_format option:selected").text();
                var text2_2 = $("#sp_pay_format_policy option:selected").text();
                $("#policy_text1").html(text);
                $("#policy_text2").html(text2_1+" "+text2_2);
            }else{
                var text = sp_pay_day+"일(과금시작) 이후 건 익월분 통합";
                var text2_1 = $("#sp_pay_format option:selected").text();
                var text2_2 = $("#sp_pay_format_policy option:selected").text();
                $("#policy_text1").html(text);
                $("#policy_text2").html(text2_1+" "+text2_2);
            }
            $("#policy_text_2").hide();
            $("#policy_text").show();
        }else{
            var text = "과금 시작일 기준 결제 주기로 처리";
            $("#policy_text_2").html(text);
            $("#policy_text").hide();
            $("#policy_text_2").show();
        }
        if($("#sr_payment_period").val() != "" && $("#sr_account_start").val() != ""){
            priceInfoDate();
        }

        $(".addoptionprice").each(function(){
            var add_seq = $(this).data("seq");
            if($("#sa_pay_day_"+add_seq).val() != ""){
                priceInfoDateAdd(add_seq);
                calculateAddPrice(add_seq);

            }
        })

        alert("적용되었습니다.");
        $('#dialogFirstSetting').dialog('close');

    });

    $(":input:radio[name=sr_payment_type]").change(function(){
        if($("#sr_payment_period").val() != ""){
            var url = "/api/basicPolicyDetail/"+$(this).val();
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "period="+$("#sr_payment_period").val(),
                success:function(response){
                    if(response.result.discount === null){
                        $("#sr_register_discount").val(0);
                        $("#sr_register_discount_str").html(0);
                    }else{
                        $("#sr_register_discount").val(response.result.discount);
                        $("#sr_register_discount_str").html(response.result.discount);
                    }

                    $(".addoptionprice").each(function(){
                        priceInfoDateAdd($(this).data("seq"));
                        calculateAddPrice($(this).data("seq"));

                    })

                    calculatePrice();
                    priceInfoDate();
                    contractPriceDateInfo();
                }
            });
            return false;
        }
    });

    $("#sr_payment_period").change(function(){
        var url = "/api/basicPolicyDetail/"+$(":input:radio[name=sr_payment_type]:checked").val();
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "period="+$(this).val(),
            success:function(response){
                // console.log(response);
                if(response.result === null){
                    $("#sr_register_discount").val(0);
                    $("#sr_register_discount_str").html(0);
                }else{
                    $("#sr_register_discount").val(response.result.discount);
                    $("#sr_register_discount_str").html(response.result.discount);
                }
                var price = parseInt($("#sr_month_price").val() || 0);
                var period = parseInt($("#sr_payment_period").val() || 0);
                $("#sp_month_price").val(price*period);
                // $("#sp_month_total_price").val(price*period);
                // $("#use_price_str_0_1").html($.number(price*period));
                $(".sp_payment_str").html($("#sr_payment_period").val()+"개월");
                // $("#sp_discount_price").trigger("change");
                // $("#sp_month_total_price").trigger("change");
                calculatePrice();
                if($("#sr_payment_period").val() != "" && $("#sr_account_start").val() != ""){
                    priceInfoDate();
                }
            }
        });
        return false;
    });

    $("#sr_pay_day").change(function(){
        $(".auto_payment_str").html($(this).val())
    });

    $("body").on("change",".sa_once_price",function(){
        var seq = $(this).data("seq");
        $("#sp_once_price_add_"+seq).val($(this).val());
        $("#sp_once_total_price_add"+seq).val($(this).val());

        priceInfoDateAdd(seq);
        calculateAddPrice(seq);
    })

    $("#sr_once_price").change(function(){
        $("#sp_once_price").val($(this).val());
        $("#sp_once_total_price").val($(this).val());
        $("#one_price_str0").html($.number($(this).val()));
        calculatePrice();
    });

    $("#sp_month_dis_price").change(function(){
        calculatePrice();
    });

    $("#sp_once_dis_price").change(function(){
        calculatePrice();
    })

    $("#sr_month_price").change(function(){
        var price = parseInt($(this).val());
        var period = parseInt($("#sr_payment_period").val() || 0);
        $("#sp_month_price").val(price*period);
        // $("#sp_month_total_price").val(price*period);
        // $("#use_price_str_0_1").html($.number(price*period));
        // $(".price_cal").trigger("change");
        // $(".price_cal3").trigger("change");
        // $("#sp_discount_price").trigger("change");
        // $("#sp_month_total_price").trigger("change");
        calculatePrice();
    });

    $("body").on("change",".sa_month_price",function(){
        var seq = $(this).data("seq");
        var price = parseInt($(this).val());
        var period = parseInt($("#sa_pay_day_"+seq).val() || 0);
        $("#sp_month_price_add"+seq).val(price*period);
        // $("#sp_month_total_price").val(price*period);
        // $("#use_price_str_add_"+seq+"_1").html($.number(price*period));

        if($("#sa_pay_day_"+seq).val() != ""){
            priceInfoDateAdd(seq);
        }
        calculateAddPrice(seq);
    })

    $(".sp_basic_type").change(function(){
        if($(this).val() == "2"){
            $(".type-hidden").hide();
        }else{
            $(".type-hidden").show();
        }
    })
    // $("#sp_discount_price").change(function(){
    //     calculatePrice();
    // });

    $("#sp_once_total_price").change(function(){
        calculatePrice();
    });

    $("#sp_month_total_price").change(function(){
        calculatePrice();
    });

    $(".price_cal4").change(function(){
        calculatePrice();
    });

    $("body").on("change",".sp_month_dis_price_add",function(){
        var seq = $(this).data("seq");
        calculateAddPrice(seq);
    })

    $("body").on("change",".sp_once_dis_price_add",function(){
        var seq = $(this).data("seq");
        calculateAddPrice(seq);
    });

    $("#registerForm").submit(function(){
        if($("#sr_mb_seq").val() == ""){
            alert("상호/이름 을 검색해주시기 바랍니다.");
            return false;
        }
        if($("#sr_eu_seq").val() == ""){
            alert("End User 를 검색해주시기 바랍니다.");
            return false;
        }
        if($("#sr_ct_seq").val() == ""){
            alert("업체분류를 검색해주시기 바랍니다.");
            return false;
        }

        if($("#sr_payment_period").val() == ""){
            alert("결제 주기를 입력해 주시기 바랍니다.");
            return false;
        }
        if($("#sr_pay_day").val() == ""){
            alert("자동 청구일을 입력해 주시기 바랍니다.");
            return false;
        }

        if($("#sr_account_start").val() == ""){
            alert("과금 시작일을 입력해 주시기 바랍니다.");
            return false;
        }

        if($("#sr_pc_seq").val() == ""){
            alert("서비스 종류를 선택해 주시기 바랍니다.");
            return false;
        }

        if($("#sr_pi_seq").val() == ""){
            alert("제품군을 선택해 주시기 바랍니다.");
            return false;
        }

        if($("#sr_pr_seq").val() == ""){
            alert("상품을 선택해 주시기 바랍니다.");
            return false;
        }

        if($("#sr_pd_seq").val() == ""){
            alert("대분류를 선택해 주시기 바랍니다.");
            return false;
        }

        if($("#sr_ps_seq").val() == ""){
            alert("소분류를 선택해 주시기 바랍니다.");
            return false;
        }

        if($("#sr_claim_name").val() == ""){
            alert("청구명을 입력해 주시기 바랍니다.");
            return false;
        }
        if($("#sr_bill_name").val() == ""){
            alert("계산서 품목명을 입력해 주시기 바랍니다.");
            return false;
        }

        if($("#sr_once_price").val() == ""){
            alert("일회성 요금을 입력해 주시기 바랍니다.");
            return false;
        }
        if($("#sr_month_price").val() == ""){
            alert("월요금을 입력해 주시기 바랍니다.");
            return false;
        }
        var insertfalse = false;
        $(".pis_yn").each(function(){
            if($(this).is(":checked")){
                if($("#etc_yn_"+$(this).data("seq")).is(":checked")){
                    if($("#sa_claim_name_"+$(this).data("seq")).val() == "" || $("#sa_month_price_"+$(this).data("seq")).val() == "" || $("#sa_bill_name_"+$(this).data("seq")).val() == "" || $("#sa_once_price_"+$(this).data("seq")).val() == ""){
                        insertfalse = true;
                    }
                }
            }
        });
        if(insertfalse){
            alert("부가항목 필수값을 입력해 주시기 바랍니다.");
            return false;
        }

        if($("#sr_seq").val() == ""){
            var url = "/api/serviceRegister";
            var actionType = "add";
        }else{
        // 수정
            var url = "/api/serviceRegisterEdit/"+$("#sr_seq").val();
            var actionType = "edit";
        }

        $(".etc_yn").each(function(){
            var seq = $(this).data("seq");
            if($(this).attr("disabled") == false){
                if($(this).is(":checked")){
                    $("#etc_yn_v_"+seq).val("Y");
                }else{
                    $("#etc_yn_v_"+seq).val("N");
                }
            }

        })
        var datas = $("#registerForm").serialize();

        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                // console.log(response);
                if(response.result == true){
                    if(actionType == "add"){
                        alert("등록 되었습니다.");
                    }else{
                        alert("수정 되었습니다.");
                    }
                    // getList();
                    // $("#dialog").dialog( "close" );
                }else{
                    alert("오류가 발생했습니다.");
                    return false;
                }
            },
            error:function(error){
                console.log(error);
            }
        });
        return false;
    })

    $("body").on("change",".sa_pay_day",function(){
        var seq = $(this).data("seq");

        var url = "/api/basicPolicyDetail/"+$(":input:radio[name=sr_payment_type]:checked").val();
        var period = $(this).val();
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "period="+$(this).val(),
            success:function(response){
                // console.log(response);
                if(response.result === null){
                    $("#sr_register_discount_"+seq).val(0);
                    $("#sr_register_discount_str_"+seq).html(0);
                }else{
                    $("#sr_register_discount_"+seq).val(response.result.discount);
                    $("#sr_register_discount_str_"+seq).html(response.result.discount);
                }
                $(".sa_payment_str_"+seq).html(period+"개월");

                var price = parseInt($("#sa_month_price_"+seq).val() || 0);
                period = parseInt(period);
                $("#sp_month_price_add"+seq).val(price*period);
                priceInfoDateAdd(seq);
                calculateAddPrice(seq);
            }
        });


        return false;


    })

    $(".btn-number-duple").click(function(){
        if($("#sr_code1").val() == "" || $("#sr_code2").val() == ""){
            alert("계약 번호를 입력해 주시기 바랍니다.");
            return false;
        }
        var url = "/api/serviceNumberCheck";
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "sr_code="+$("#sr_code1").val()+"-"+$("#sr_code2").val(),
            success:function(response){
                if(response.result == true){
                    alert("계약번호가 존재 합니다. 다른 계약번호로 설정해주시기 바랍니다.");
                    $("#dupleNumberYn").val("N");
                    return false;
                }else{
                    alert("사용가능한 계약번호 입니다.");
                    $("#dupleNumberYn").val("Y");
                    return false;
                }
            }
        });
    })
    $(".sp_discount_yn_add_check").click(function(){
        if($(this).is(":checked")){
            $(".sp_discount_yn_add"+$(this).data("seq")).val("Y");
        }else{
            $(".sp_discount_yn_add"+$(this).data("seq")).val("N");
        }
    })

    $("#sp_discount_yn").click(function(){
        calculatePrice();
    });

    $("body").on("click",".sp_discount_yn_add_check",function(){
        calculateAddPrice($(this).data("seq"));
    });

    $(".sr_contract_type").change(function(){
        if($("#sr_contract_start").val() != "" && $(this).val() == "2"){
            $("#sr_contract_end").val(moment($("#sr_contract_start").val()).add(1,'months').subtract(1, "days").format("YYYY-MM-DD"));
            var start = new Date($("#sr_contract_start").val());
            // var end = new Date($("#sr_contract_end").val());
            var end = moment($("#sr_contract_end").val()).add(1,'days').format("YYYY-MM-DD");
            end = new Date(end);
            var diff = Date.getFormattedDateDiff(start, end);
            $("#contractinfo").html("("+diff[0]+"개월 "+diff[1]+"일)");
        }
    });

    $("body").on("click",".editEnd",function(){
        // console.log($(this).parent().children("td").eq(1).children("input").length);
        if($(this).parent().children("td").eq(1).children("input").length > 0){
            var url = "/api/endUserUpdate/"+$(this).data("seq");
            var editname = $(this).parent().children("td").eq(1).children("input").val();
            var that = $(this);
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "eu_name="+editname,
                success:function(response){
                    // typeGetList();
                    alert("수정되었습니다.");
                    that.parent().children("td").eq(1).html(editname);
                }
            });
        }else{
            $(this).parent().children("td").eq(1).html("<input type='text' name='end_mode_name' value='"+$(this).data("name")+"'>");
        }

    });

    $("body").on("click",".deleteEnd",function(){
        if(confirm("삭제하시겠습니까?")){
            var that = $(this);
            var url = "/api/endUserDelete/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    // typeGetList();
                    alert("삭제되었습니다.");
                    that.parent().remove();
                }
            });
        }
    });

    $("#endAdd").submit(function(){
        if($("#addEnd").val() == ""){
            alert("코드를 입력해 주시기 바랍니다.");
            return false;
        }
        if($("#eu_name").val() == ""){
            alert("End User를 입력해 주시기 바랍니다.");
            return false;
        }
        var url = "/api/endUserAdd";
        var datas = $("#endAdd").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                // typeGetList();
                if(response.result){
                    alert("등록되었습니다.");
                    getEndUserNextNumber();
                }else{
                    alert(response.msg);
                }
            }
        });
        return false;
    });

    $("body").on("click",".editType",function(){
        // console.log($(this).parent().children("td").eq(1).children("input").length);
        if($(this).parent().children("td").eq(1).children("input").length > 0){
            var url = "/api/companyTypeUpdate/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "ct_name="+$(this).parent().children("td").eq(1).children("input").val(),
                success:function(response){
                    typeGetList();
                }
            });
        }else{
            $(this).parent().children("td").eq(1).html("<input type='text' name='mode_name' value='"+$(this).data("name")+"'>");
        }

    });

    $("body").on("click",".deleteType",function(){
        if(confirm("삭제하시겠습니까?")){
            var url = "/api/companyTypeDelete/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    typeGetList();
                }
            });
        }
    });

    $("#typeAdd").submit(function(){
        if($("#addType").val() == ""){
            alert("코드를 입력해 주세요");
            return false;
        }

        if($("#ct_name").val() == ""){
            alert("분류명을 입력해 주세요");
            return false;
        }
        var url = "/api/companyTypeAdd";
        var datas = $("#typeAdd").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                console.log(response);
                if(response.result){
                    alert("저장되었습니다.");
                    typeGetList();
                }else{
                    alert(response.msg);

                }

            }
        });
        return false;
    });
});

var getEndUserNextNumber = function(){
    var url = "/api/endUserNextCode";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){

            $("#addEnd").val(response);
            $("#eu_name").val("");
        }
    });
}
var calculatePrice = function(){
    var sr_register_discount = parseInt($("#sr_register_discount").val() || 0);
    var sr_payment_period = parseInt($("#sr_payment_period").val() || 0);
    var sr_month_price = parseInt($("#sr_month_price").val() || 0);
    var sp_month_dis_price = parseInt($("#sp_month_dis_price").val() || 0);
    // console.log(sr_register_discount + "::"+sr_payment_period+"::"+sr_month_price+"::"+sp_month_dis_price);
    if($("#sp_discount_yn").is(":checked")){
        var price = Math.floor((sr_month_price-sp_month_dis_price)*sr_register_discount/100*sr_payment_period);
        $("#sp_discount_price").val(price);
    }else{
        $("#sp_discount_price").val(0);
    }

    var sp_once_price = parseInt($("#sp_once_price").val()|| 0);
    var sp_once_dis_price = parseInt($("#sp_once_dis_price").val() || 0);

    var price = Math.floor((sp_once_price-sp_once_dis_price));
    $("#sp_once_total_price").val(price);

    $("#show_once_total").val(price);

    $("#one_price_str0").html($.number(price));
    // $("#show_all_once_total").val(price);

    var sr_payment_period = parseInt($("#sr_payment_period").val()|| 0);
    var sp_month_price = parseInt($("#sp_month_price").val() || 0);
    var sp_month_dis_price = parseInt($("#sp_month_dis_price").val() || 0);
    if($("#sp_discount_yn").is(":checked")){
        var sp_discount_price = parseInt($("#sp_discount_price").val() || 0);
    }else{
        var sp_discount_price = 0;
    }


    var total_price = parseInt(sp_month_price-(sp_month_dis_price*sr_payment_period)-sp_discount_price);
    if($("#sr_account_format").val() == "1"){
        if($("#sr_account_format_policy").val() == "1"){ // 버림
            var price = Math.floor(total_price/10)*10;
        }else if($("#sr_account_format_policy").val() == "2"){ //올림
            var price = Math.ceil(total_price/10)*10;
        }else if($("#sr_account_format_policy").val() == "3"){ //반올림
            var price = Math.round(total_price/10)*10;
        }
    }else if($("#sr_account_format").val() == "2"){
        if($("#sr_account_format_policy").val() == "1"){ // 버림
            var price = Math.floor(total_price/100)*100;
        }else if($("#sr_account_format_policy").val() == "2"){ //올림
            var price = Math.ceil(total_price/100)*100;
        }else if($("#sr_account_format_policy").val() == "3"){ //반올림
            var price = Math.round(total_price/100)*100;
        }
    }else if($("#sr_account_format").val() == "3"){
        if($("#sr_account_format_policy").val() == "1"){ // 버림
            var price = Math.floor(total_price/1000)*1000;
        }else if($("#sr_account_format_policy").val() == "2"){ //올림
            var price = Math.ceil(total_price/1000)*1000;
        }else if($("#sr_account_format_policy").val() == "3"){ //반올림
            var price = Math.round(total_price/1000)*1000;
        }
    }else if($("#sr_account_format").val() == "4"){
        if($("#sr_account_format_policy").val() == "1"){ // 버림
            var price = Math.floor(total_price/10000)*10000;
        }else if($("#sr_account_format_policy").val() == "2"){ //올림
            var price = Math.ceil(total_price/10000)*10000;
        }else if($("#sr_account_format_policy").val() == "3"){ //반올림
            var price = Math.round(total_price/10000)*10000;
        }
    }
    // console.log(price);
    // $("#use_price_str_0_1").html($.number(price));
    $("#sp_month_total_price").val(total_price);

    $("#show_month_total").val(total_price);

    var sp_once_total_price = parseInt($("#sp_once_total_price").val() || 0);
    var sp_month_total_price = parseInt($("#sp_month_total_price").val() || 0);
    // $("#total_str0").html($.number(sp_once_total_price+sp_month_total_price));
    var show_total_price = 0;
    $(".total-cal-price").each(function(){
        show_total_price = show_total_price + parseInt($(this).data("price"));
    })
    $("#show_all_total").val(show_total_price);

    var total_month_price = parseInt($("#show_all_total").val()) - parseInt($("#show_all_once_total").val());
    $("#show_all_month_total").val(total_month_price);


    contractPriceDateInfo();
    calculateTotalPrice();
}

var calculateAddPrice = function(seq){
    var sr_register_discount = parseInt($("#sr_register_discount_"+seq).val() || 0);
    var sr_payment_period = parseInt($("#sa_pay_day_"+seq).val() || 0);
    var sr_month_price = parseInt($("#sa_month_price_"+seq).val() || 0);
    var sp_month_dis_price = parseInt($("#sp_month_dis_price_add"+seq).val() || 0);

    $("#sp_discount_price_add"+seq).val(price);

    if($("#sp_discount_yn_add_check"+seq).is(":checked")){
        var price = Math.floor((sr_month_price-sp_month_dis_price)*sr_register_discount/100*sr_payment_period);
        $("#sp_discount_price_add"+seq).val(price);
    }else{
        $("#sp_discount_price_add"+seq).val(0);
    }

    var sp_once_price = parseInt($("#sa_once_price_"+seq).val()|| 0);
    var sp_once_dis_price = parseInt($("#sp_once_dis_price_add"+seq).val() || 0);

    var price = Math.floor((sp_once_price-sp_once_dis_price));
    $("#sp_once_total_price_add"+seq).val(price);
    $("#one_price_str_add_"+seq).html($.number(price));
    // $("#show_once_total").val(price);
    // $("#show_all_once_total").val(price);

    var sr_payment_period = parseInt($("#sa_pay_day_"+seq).val()|| 0);
    var sp_month_price = parseInt($("#sp_month_price_add"+seq).val() || 0);
    var sp_month_dis_price = parseInt($("#sp_month_dis_price_add"+seq).val() || 0);
    var sp_discount_price = parseInt($("#sp_discount_price_add"+seq).val() || 0);

    if($("#sp_discount_yn_add_check"+seq).is(":checked")){
        var sp_discount_price = parseInt($("#sp_discount_price_add"+seq).val() || 0);
    }else{
        var sp_discount_price = 0;
    }

    // console.log(sr_payment_period+"::"+sp_month_price+"::"+sp_month_dis_price+"::"+sp_discount_price);
    var total_price = parseInt(sp_month_price-(sp_month_dis_price*sr_payment_period)-sp_discount_price);


    if($("#sr_account_format").val() == "1"){
        if($("#sr_account_format_policy").val() == "1"){ // 버림
            var price = Math.floor(total_price/10)*10;
        }else if($("#sr_account_format_policy").val() == "2"){ //올림
            var price = Math.ceil(total_price/10)*10;
        }else if($("#sr_account_format_policy").val() == "3"){ //반올림
            var price = Math.round(total_price/10)*10;
        }
    }else if($("#sr_account_format").val() == "2"){
        if($("#sr_account_format_policy").val() == "1"){ // 버림
            var price = Math.floor(total_price/100)*100;
        }else if($("#sr_account_format_policy").val() == "2"){ //올림
            var price = Math.ceil(total_price/100)*100;
        }else if($("#sr_account_format_policy").val() == "3"){ //반올림
            var price = Math.round(total_price/100)*100;
        }
    }else if($("#sr_account_format").val() == "3"){
        if($("#sr_account_format_policy").val() == "1"){ // 버림
            var price = Math.floor(total_price/1000)*1000;
        }else if($("#sr_account_format_policy").val() == "2"){ //올림
            var price = Math.ceil(total_price/1000)*1000;
        }else if($("#sr_account_format_policy").val() == "3"){ //반올림
            var price = Math.round(total_price/1000)*1000;
        }
    }else if($("#sr_account_format").val() == "4"){
        if($("#sr_account_format_policy").val() == "1"){ // 버림
            var price = Math.floor(total_price/10000)*10000;
        }else if($("#sr_account_format_policy").val() == "2"){ //올림
            var price = Math.ceil(total_price/10000)*10000;
        }else if($("#sr_account_format_policy").val() == "3"){ //반올림
            var price = Math.round(total_price/10000)*10000;
        }
    }
    $("#use_price_str_add_0_1_"+seq).html($.number(total_price));
    $("#sp_month_total_price_add"+seq).val(total_price);

    var sp_once_total_price = parseInt($("#sp_once_total_price_add"+seq).val() || 0);
    var sp_month_total_price = parseInt($("#sp_month_total_price_add"+seq).val() || 0);
    $("#total_str_add_"+seq).html($.number(sp_once_total_price+sp_month_total_price));
    // $("#sap_first_price_"+seq).val(sp_once_total_price+sp_month_total_price);
    contractPriceDateInfoAdd(seq);
    calculateTotalPrice();

}

var calculateTotalPrice = function(){

    var price = parseInt($("#sp_once_total_price").val() || 0);
    $(".add_service_once_total").each(function(){
        price = price+parseInt($(this).val());
    });
    $("#show_once_total").val(price);
    $("#show_all_once_total").val(price)

    var monthPrice = parseInt($("#sp_month_total_price").val() || 0);
    monthPrice = monthPrice / parseInt($("#sr_payment_period").val());
    $(".add_service_month_total").each(function(){
        var period = $("#sa_pay_day_"+$(this).data("seq")).val();
        monthPrice = monthPrice+(parseInt($(this).val()) / parseInt(period));
    });
    $("#show_month_total").val(monthPrice);

    var sp_once_total_price = parseInt($("#show_all_once_total").val() || 0);
    var sp_month_total_price = parseInt($("#show_month_total").val() || 0);
    // $("#show_all_total").val(sp_once_total_price+sp_month_total_price);

    var show_total_price = 0;
    $(".total-cal-price").each(function(){
        show_total_price = show_total_price + parseInt($(this).data("price"));
    })
    $("#show_all_total").val(show_total_price);

    var total_month_price = parseInt($("#show_all_total").val()) - parseInt($("#show_all_once_total").val());
    $("#show_all_month_total").val(total_month_price);
}



Date.getFormattedDateDiff = function(date1, date2) {
  var b = moment(date1),
      a = moment(date2),
      intervals = ['months','days'],
      out = [];

  for(var i=0; i<intervals.length; i++){
      var diff = a.diff(b, intervals[i]);
      // console.log(diff);
      b.add(diff, intervals[i]);
      out.push(diff);
  }
  return out;
};

function priceInfoDate(){
    basic_date_info = [];
    var selectedDate = $("#sr_account_start").val();

    var sr_account_type = $("#sr_account_type").val();
    var sr_account_policy = $("#sr_account_policy").val();
    var sr_account_start_day = $("#sr_account_start_day").val();
    var date_array = selectedDate.split("-");
    var period = parseInt($("#sr_payment_period").val());

    var start_str = [];
    var end_str = [];
    var end_period = [];
    var date_info1 = {};
    var date_info2 = {};
    if(sr_account_type == "1"){
        if(sr_account_policy == "1"){
            var lastDay = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            var end_date = date_array[0]+"-"+date_array[1]+"-"+lastDay;

            // end_period[0] = moment.duration(moment(end_date).diff(moment(selectedDate))).asDays()+"일";
            date_info1.start_date = selectedDate;
            date_info1.end_date = end_date;
            start_str[0] = selectedDate;
            if(date_array[2] != "01"){
                date_info1.period = moment.duration(moment(end_date).diff(moment(selectedDate))).asDays()+1;
                date_info1.interval = 'day';
                end_period[0] = date_info1.period+"일";

                if(period > 1){
                    end_period[1] = (period - 1)+"개월";
                    date_info2.period = (period - 1);
                }else{
                    end_period[1] = "0개월";
                    date_info2.period = 0;
                }
                basic_date_info.push(date_info1);
                end_str[0] = date_array[0]+"년 "+date_array[1]+"월 "+lastDay+"일";
                if(period > 1){
                    date_info2.start_date = moment(end_date).format("YYYY-MM-01");

                    end_date = moment(end_date).add((period-1),'months').format("YYYY-MM-DD");

                    end_str[1] = moment(end_date).format("YYYY년 MM월 DD일");
                    start_str[1] = moment(date_info1.end_date).add(1,'months').format("YYYY년 MM월 01일");
                    date_info2.end_date = end_date;

                    date_info2.interval = 'month';
                    basic_date_info.push(date_info2);

                    $("#view_add").show();
                }else{
                    end_str[1] = "0000년 00월 00일";
                    start_str[0] = selectedDate;
                    start_str[1] = "0000년 00월 00일";
                    $("#view_add").hide();
                }

            }else{

                date_info1.period = period;
                date_info1.interval = 'month';
                end_period[0] = date_info1.period+"개월";
                if(period > 1){
                    end_period[1] = (period - 1)+"개월";
                    date_info2.period = period-1;
                }else{
                    end_period[1] = "1개월";
                    date_info2.period = 1;
                }
                basic_date_info.push(date_info1);

                end_str[0] = date_array[0]+"년 "+date_array[1]+"월 "+lastDay+"일";
                if(period > 1){
                    date_info2.start_date = moment(end_date).format("YYYY-MM-01");

                    end_date = moment(end_date).add((period-1),'months').format("YYYY-MM-DD");

                    end_str[1] = moment(end_date).format("YYYY년 MM월 DD일");
                    start_str[1] = moment(date_info1.end_date).add(1,'months').format("YYYY년 MM월 01일");
                    date_info2.end_date = end_date;

                    date_info2.interval = 'month';
                    basic_date_info.push(date_info2);

                    $("#view_add").show();
                }else{
                    end_str[1] = "0000년 00월 00일";
                    start_str[0] = selectedDate;
                    start_str[1] = "0000년 00월 00일";
                    $("#view_add").hide();
                }




                // end_period[0] = date_info1.period+"일";

            }
        }else{
            // console.log(sr_account_start_day+"::"+parseInt(date_array[2]));
            if(parseInt(sr_account_start_day) <= parseInt(date_array[2])){
                var lastDay = ( new Date( date_array[0], date_array[1], 0) ).getDate();
                var end_date = date_array[0]+"-"+date_array[1]+"-"+lastDay;

                end_str[0] = moment(end_date).format("YYYY년 MM월 DD일");
                end_str[1] = moment(end_date).add(period,'months').format("YYYY년 MM월 DD일");
                end_period[0] = (moment.duration(moment(end_date).diff(moment(selectedDate))).asDays()+1)+"일";

                date_info1.start_date = selectedDate;
                date_info1.end_date = end_date;
                date_info1.period = moment.duration(moment(end_date).diff(moment(selectedDate))).asDays()+1;
                date_info1.interval = 'day';
                basic_date_info.push(date_info1);

                date_info2.start_date = moment(end_date).add(1,'months').format("YYYY-MM-01");
                start_str[1] = moment(end_date).add(1,'months').format("YYYY년 MM월 01일");

                end_date = moment(end_date).add(period,'months').format("YYYY-MM-DD");

                start_str[0] = selectedDate;


                end_period[1] = period+"개월";


                date_info2.end_date = end_date;
                date_info2.period = period;
                date_info2.interval = 'month';
                basic_date_info.push(date_info2);


                $("#view_add").show();
            }else{
                var lastDay = ( new Date( date_array[0], date_array[1], 0) ).getDate();
                var end_date = date_array[0]+"-"+date_array[1]+"-"+lastDay;

                date_info1.start_date = selectedDate;
                date_info1.end_date = end_date;
                // date_info1.period = period;
                // date_info1.interval = 'month';
                if(date_array[2] != "01"){
                    date_info1.period = moment.duration(moment(end_date).diff(moment(selectedDate))).asDays()+1;
                    date_info1.interval = 'day';
                    end_period[0] = date_info1.period+"일";
                }else{
                    date_info1.period = period;
                    date_info1.interval = 'month';
                    end_period[0] = date_info1.period+"개월";
                }
                basic_date_info.push(date_info1);
                end_str[0] = date_array[0]+"년 "+date_array[1]+"월 "+lastDay+"일";
                start_str[0] = selectedDate;
                if(period > 1){
                    end_period[1] = (period - 1)+"개월";
                    date_info2.period = period-1;
                }else{
                    end_period[1] = "1개월";
                    date_info2.period = 1;
                }

                if(period > 1){
                    date_info2.start_date = moment(end_date).format("YYYY-MM-01");

                    end_date = moment(end_date).add((period-1),'months').format("YYYY-MM-DD");

                    end_str[1] = moment(end_date).format("YYYY년 MM월 DD일");
                    start_str[1] = moment(date_info1.end_date).add(1,'months').format("YYYY년 MM월 01일");
                    date_info2.end_date = end_date;

                    date_info2.interval = 'month';
                    basic_date_info.push(date_info2);

                    $("#view_add").show();
                }else{
                    end_str[1] = "0000년 00월 00일";
                    start_str[0] = selectedDate;
                    start_str[1] = "0000년 00월 00일";
                    $("#view_add").hide();
                }
            }
        }
    }else{
        var end_date = moment(selectedDate).add(period,'months').subtract(1, "days").format("YYYY-MM-DD");
        end_str[0] = moment(selectedDate).add(period,'months').subtract(1, "days").format("YYYY년 MM월 DD일");
        end_str[1] = "0000년 00월 00일";

        start_str[0] = selectedDate;
        start_str[1] = "0000년 00월 00일";

        end_period[0] = period+"개월";
        end_period[1] = "0개월";

        date_info1.start_date = selectedDate;
        date_info1.end_date = moment(selectedDate).add(period,'months').subtract(1, "days").format("YYYY-MM-DD");
        date_info1.period = period;
        date_info1.interval = 'month';
        basic_date_info.push(date_info1);

        $("#view_add").hide();
    }
    // console.log(basic_date_info);
    // console.log(start_str[0]);
    // var month = moment(selectedDate).add(period,'months').format("YYYY-MM-DD");
    $("#sr_account_end").val(end_date);
    $("#start_date_str_0_1").html(moment(start_str[0]).format("YYYY년 MM월 DD일"));
    $("#end_date_str_0_1").html(end_str[0]+" ("+end_period[0]+")");


    $("#start_date_str_0_2").html(start_str[1]);
    $("#end_date_str_0_2").html(end_str[1]+" ("+end_period[1]+")");

    if(basic_date_info.length > 1){
        $("#sp_first_start").val(start_str[0]);
        $("#sp_first_end").val(basic_date_info[0].end_date);
        $("#sp_first_month_start").val(start_str[1]);
        $("#sp_first_month_end").val(basic_date_info[1].end_date);
        // console.log(start_str[0]+"::"+basic_date_info[0].end_date+"::"+basic_date_info[1].end_date);
    }else{
        if(basic_date_info[0].interval == "day"){
            $("#sp_first_start").val(start_str[0]);
            $("#sp_first_end").val(basic_date_info[0].end_date);
            $("#sp_first_month_start").val("");
            $("#sp_first_month_end").val("");
        }else{
            $("#sp_first_start").val("");
            $("#sp_first_end").val("");
            $("#sp_first_month_start").val(start_str[0]);
            $("#sp_first_month_end").val(basic_date_info[0].end_date);
        }

        // console.log(start_str[0]+"::"+basic_date_info[0].end_date);
    }

    contractPriceDateInfo();
}

function contractPriceDateInfo(){
    if(basic_date_info.length == 1){
        if(basic_date_info[0].interval == "day"){
            var date_array = basic_date_info[0].end_date.split("-");

            var month_total_date = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            // var one_day_price = parseInt($("#sp_month_total_price").val())/month_total_date;
            // var total_price = one_day_price*basic_date_info[0].period;

            var month_price = parseInt($("#sp_month_price").val())/parseInt($("#sr_payment_period").val());
            var dis_price = parseInt($("#sp_month_dis_price").val());
            var dis_per = parseInt($("#sr_register_discount").val());
            var period_day = parseInt(basic_date_info[0].period);

            if($("#sp_discount_yn").is(":checked")){
                var total_price = (month_price - dis_price) * (1-dis_per/100) / month_total_date * period_day;
            }else{
                var total_price = (month_price - dis_price) / month_total_date * period_day;
            }
            if($("#sr_account_format").val() == "1"){
                if($("#sr_account_format_policy").val() == "1"){ // 버림
                    var price = Math.floor(total_price/10)*10;
                }else if($("#sr_account_format_policy").val() == "2"){ //올림
                    var price = Math.ceil(total_price/10)*10;
                }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                    var price = Math.round(total_price/10)*10;
                }
            }else if($("#sr_account_format").val() == "2"){
                if($("#sr_account_format_policy").val() == "1"){ // 버림
                    var price = Math.floor(total_price/100)*100;
                }else if($("#sr_account_format_policy").val() == "2"){ //올림
                    var price = Math.ceil(total_price/100)*100;
                }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                    var price = Math.round(total_price/100)*100;
                }
            }else if($("#sr_account_format").val() == "3"){
                if($("#sr_account_format_policy").val() == "1"){ // 버림
                    var price = Math.floor(total_price/1000)*1000;
                }else if($("#sr_account_format_policy").val() == "2"){ //올림
                    var price = Math.ceil(total_price/1000)*1000;
                }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                    var price = Math.round(total_price/1000)*1000;
                }
            }else if($("#sr_account_format").val() == "4"){
                if($("#sr_account_format_policy").val() == "1"){ // 버림
                    var price = Math.floor(total_price/10000)*10000;
                }else if($("#sr_account_format_policy").val() == "2"){ //올림
                    var price = Math.ceil(total_price/10000)*10000;
                }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                    var price = Math.round(total_price/10000)*10000;
                }
            }

            $("#use_price_str_0_1").html($.number(price));
            basic_date_info[0].price = price;
            $("#sp_first_price").val(price);
            $("#sp_first_month_price").val(0);
        }else{
            $("#use_price_str_0_1").html($.number($("#sp_month_total_price").val()));
            basic_date_info[0].price = $("#sp_month_total_price").val();
            $("#sp_first_price").val(0);
            $("#sp_first_month_price").val(price);
        }

    }else if(basic_date_info.length == 2){
        var date_array = basic_date_info[0].end_date.split("-");

        var month_total_date = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            // var one_day_price = parseInt($("#sp_month_total_price").val())/month_total_date;
            // var total_price = one_day_price*basic_date_info[0].period;

        var month_price = parseInt($("#sp_month_price").val())/parseInt($("#sr_payment_period").val());
        var dis_price = parseInt($("#sp_month_dis_price").val());
        var dis_per = parseInt($("#sr_register_discount").val());
        var period_day = parseInt(basic_date_info[0].period);
        // console.log(month_total_date+"::"+period_day);
        // console.log(period_day);
        if($("#sp_discount_yn").is(":checked")){
            var total_price = (month_price - dis_price) * (1-dis_per/100) / month_total_date * (period_day);
        }else{
            var total_price = (month_price - dis_price) / month_total_date * (period_day);
        }

        if($("#sr_account_format").val() == "1"){
            if($("#sr_account_format_policy").val() == "1"){ // 버림
                var price = Math.floor(total_price/10)*10;
            }else if($("#sr_account_format_policy").val() == "2"){ //올림
                var price = Math.ceil(total_price/10)*10;
            }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                var price = Math.round(total_price/10)*10;
            }
        }else if($("#sr_account_format").val() == "2"){
            if($("#sr_account_format_policy").val() == "1"){ // 버림
                var price = Math.floor(total_price/100)*100;
            }else if($("#sr_account_format_policy").val() == "2"){ //올림
                var price = Math.ceil(total_price/100)*100;
            }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                var price = Math.round(total_price/100)*100;
            }
        }else if($("#sr_account_format").val() == "3"){
            if($("#sr_account_format_policy").val() == "1"){ // 버림
                var price = Math.floor(total_price/1000)*1000;
            }else if($("#sr_account_format_policy").val() == "2"){ //올림
                var price = Math.ceil(total_price/1000)*1000;
            }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                var price = Math.round(total_price/1000)*1000;
            }
        }else if($("#sr_account_format").val() == "4"){
            if($("#sr_account_format_policy").val() == "1"){ // 버림
                var price = Math.floor(total_price/10000)*10000;
            }else if($("#sr_account_format_policy").val() == "2"){ //올림
                var price = Math.ceil(total_price/10000)*10000;
            }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                var price = Math.round(total_price/10000)*10000;
            }
        }

        basic_date_info[0].price = price;
        var month2 = parseInt($("#sp_month_total_price").val());
        var period_month = parseInt($("#sr_payment_period").val());
        var once_period = basic_date_info[1].period;
        console.log(period_month+":"+once_period)
        var price2 = month2 / period_month * once_period;

        basic_date_info[1].price = price2;

        $("#use_price_str_0_1").html($.number(price));
        $("#use_price_str_0_2").html($.number(price2));
        $("#sp_first_price").val(price);
        $("#sp_first_month_price").val(price2);
    }
    var totalprice = 0;
    totalprice = parseInt(totalprice) + parseInt($("#sp_once_total_price").val()) || 0;
    for(var i = 0; i < basic_date_info.length;i++){
        totalprice = parseInt(totalprice) + parseInt(basic_date_info[i].price);
    }

    $("#total_str0").data("price",totalprice);

    $("#total_str0").html($.number(totalprice));


}

function contractPriceDateInfoAdd(seq){
    // console.log(basic_date_info_add[seq].length);

    if(basic_date_info_add[seq].length == 1){
        if(basic_date_info_add[seq][0].interval == "day"){
            var date_array = basic_date_info_add[seq][0].end_date.split("-");

            // var month_total_date = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            // var one_day_price = parseInt($("#sp_month_total_price_add"+seq).val())/month_total_date;
            // var total_price = one_day_price*basic_date_info_add[seq][0].period;

            var month_total_date = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            // var one_day_price = parseInt($("#sp_month_total_price").val())/month_total_date;
            // var total_price = one_day_price*basic_date_info[0].period;

            var month_price = parseInt($("#sp_month_price_add"+seq).val())/parseInt($("#sa_pay_day_"+seq).val());
            var dis_price = parseInt($("#sp_month_dis_price_add"+seq).val());
            var dis_per = parseInt($("#sr_register_discount_"+seq).val());
            var period_day = parseInt(basic_date_info_add[seq][0].period);

            if($("#sp_discount_yn_add_check"+seq).is(":checked")){
                var total_price = (month_price - dis_price) * (1-dis_per/100) / month_total_date * period_day;
            }else{
                var total_price = (month_price - dis_price) / month_total_date * period_day;
            }

            if($("#sr_account_format").val() == "1"){
                if($("#sr_account_format_policy").val() == "1"){ // 버림
                    var price = Math.floor(total_price/10)*10;
                }else if($("#sr_account_format_policy").val() == "2"){ //올림
                    var price = Math.ceil(total_price/10)*10;
                }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                    var price = Math.round(total_price/10)*10;
                }
            }else if($("#sr_account_format").val() == "2"){
                if($("#sr_account_format_policy").val() == "1"){ // 버림
                    var price = Math.floor(total_price/100)*100;
                }else if($("#sr_account_format_policy").val() == "2"){ //올림
                    var price = Math.ceil(total_price/100)*100;
                }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                    var price = Math.round(total_price/100)*100;
                }
            }else if($("#sr_account_format").val() == "3"){
                if($("#sr_account_format_policy").val() == "1"){ // 버림
                    var price = Math.floor(total_price/1000)*1000;
                }else if($("#sr_account_format_policy").val() == "2"){ //올림
                    var price = Math.ceil(total_price/1000)*1000;
                }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                    var price = Math.round(total_price/1000)*1000;
                }
            }else if($("#sr_account_format").val() == "4"){
                if($("#sr_account_format_policy").val() == "1"){ // 버림
                    var price = Math.floor(total_price/10000)*10000;
                }else if($("#sr_account_format_policy").val() == "2"){ //올림
                    var price = Math.ceil(total_price/10000)*10000;
                }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                    var price = Math.round(total_price/10000)*10000;
                }
            }

            $("#use_price_str_add_0_1_"+seq).html($.number(price));
            basic_date_info_add[seq][0].price = price;
            $("#sap_first_price_"+seq).val(price);
            $("#sap_first_month_price_"+seq).val(0);
        }else{
            $("#use_price_str_add_0_1_"+seq).html($.number($("#sp_month_total_price_add"+seq).val()));
            basic_date_info_add[seq][0].price = $("#sp_month_total_price_add"+seq).val();
            $("#sap_first_price_"+seq).val(0);
            $("#sap_first_month_price_"+seq).val(price);
        }

    }else if(basic_date_info_add[seq].length == 2){
        var date_array = basic_date_info_add[seq][0].end_date.split("-");

        var month_total_date = ( new Date( date_array[0], date_array[1], 0) ).getDate();

        var month_price = parseInt($("#sp_month_price_add"+seq).val())/parseInt($("#sa_pay_day_"+seq).val());
        var dis_price = parseInt($("#sp_month_dis_price_add"+seq).val());
        var dis_per = parseInt($("#sr_register_discount_"+seq).val());
        var period_day = parseInt(basic_date_info_add[seq][0].period);
        console.log(period_day);
        if($("#sp_discount_yn_add_check"+seq).is(":checked")){
            var total_price = (month_price - dis_price) * (1-dis_per/100) / month_total_date * period_day;
        }else{
            var total_price = (month_price - dis_price) / month_total_date * period_day;
        }

        if($("#sr_account_format").val() == "1"){
            if($("#sr_account_format_policy").val() == "1"){ // 버림
                var price = Math.floor(total_price/10)*10;
            }else if($("#sr_account_format_policy").val() == "2"){ //올림
                var price = Math.ceil(total_price/10)*10;
            }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                var price = Math.round(total_price/10)*10;
            }
        }else if($("#sr_account_format").val() == "2"){
            if($("#sr_account_format_policy").val() == "1"){ // 버림
                var price = Math.floor(total_price/100)*100;
            }else if($("#sr_account_format_policy").val() == "2"){ //올림
                var price = Math.ceil(total_price/100)*100;
            }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                var price = Math.round(total_price/100)*100;
            }
        }else if($("#sr_account_format").val() == "3"){
            if($("#sr_account_format_policy").val() == "1"){ // 버림
                var price = Math.floor(total_price/1000)*1000;
            }else if($("#sr_account_format_policy").val() == "2"){ //올림
                var price = Math.ceil(total_price/1000)*1000;
            }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                var price = Math.round(total_price/1000)*1000;
            }
        }else if($("#sr_account_format").val() == "4"){
            if($("#sr_account_format_policy").val() == "1"){ // 버림
                var price = Math.floor(total_price/10000)*10000;
            }else if($("#sr_account_format_policy").val() == "2"){ //올림
                var price = Math.ceil(total_price/10000)*10000;
            }else if($("#sr_account_format_policy").val() == "3"){ //반올림
                var price = Math.round(total_price/10000)*10000;
            }
        }

        basic_date_info_add[seq][0].price = price;
        // basic_date_info_add[seq][1].price = $("#sp_month_total_price_add"+seq).val();

        $("#use_price_str_add_0_1_"+seq).html($.number(price));

        var month2 = parseInt($("#sp_month_total_price_add"+seq).val());
        var period_month = parseInt($("#sa_pay_day_"+seq).val());
        var once_period = basic_date_info_add[seq][1].period;
        // console.log(period_month+":"+once_period)
        var price2 = month2 / period_month * once_period;

        basic_date_info_add[seq][1].price = price2;

        $("#use_price_str_add_0_2_"+seq).html($.number(price2)); // 여기 수정
        $("#sap_first_price_"+seq).val(price);
        $("#sap_first_month_price_"+seq).val(price2);
    }
    var totalprice = 0;
    totalprice = parseInt(totalprice) + parseInt($("#sp_once_total_price_add"+seq).val()) || 0
    for(var i = 0; i < basic_date_info_add[seq].length;i++){
        totalprice = parseInt(totalprice) + parseInt(basic_date_info_add[seq][i].price);
    }
    $("#total_str_add_"+seq).data("price",totalprice);

    $("#total_str_add_"+seq).html($.number(totalprice));
}

function priceInfoDateAdd(pis_seq){
    basic_date_info_add[pis_seq] = [];
    var selectedDate = $("#sr_account_start").val();

    var sr_account_type = $("#sr_account_type").val();
    var sr_account_policy = $("#sr_account_policy").val();
    var sr_account_start_day = $("#sr_account_start_day").val();
    var date_array = selectedDate.split("-");
    var period = parseInt($("#sa_pay_day_"+pis_seq).val());

    var start_str = [];
    var end_str = [];
    var end_period = [];
    var date_info1 = {};
    var date_info2 = {};
    if(sr_account_type == "1"){
        if(sr_account_policy == "1"){
            var lastDay = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            var end_date = date_array[0]+"-"+date_array[1]+"-"+lastDay;

            // end_period[0] = moment.duration(moment(end_date).diff(moment(selectedDate))).asDays()+"일";
            date_info1.start_date = selectedDate;
            date_info1.end_date = end_date;
            start_str[0] = selectedDate;
            if(date_array[2] != "01"){
                date_info1.period = moment.duration(moment(end_date).diff(moment(selectedDate))).asDays()+1;
                date_info1.interval = 'day';
                end_period[0] = date_info1.period+"일";

                if(period > 1){
                    end_period[1] = (period - 1)+"개월";
                    date_info2.period = (period-1);
                }else{
                    end_period[1] = "0개월";
                    date_info2.period = 0;
                }
                basic_date_info_add[pis_seq].push(date_info1);
                end_str[0] = date_array[0]+"년 "+date_array[1]+"월 "+lastDay+"일";
                if(period > 1){
                    date_info2.start_date = moment(end_date).format("YYYY-MM-01");

                    end_date = moment(end_date).add((period-1),'months').format("YYYY-MM-DD");

                    end_str[1] = moment(end_date).format("YYYY년 MM월 DD일");
                    start_str[1] = moment(date_info1.end_date).add(1,'months').format("YYYY년 MM월 01일");
                    date_info2.end_date = end_date;
                    date_info2.interval = 'month';
                    basic_date_info_add[pis_seq].push(date_info2);

                    $("#view_add_"+pis_seq).show();
                }else{
                    end_str[1] = "0000년 00월 00일";
                    start_str[0] = selectedDate;
                    start_str[1] = "0000년 00월 00일";
                    $("#view_add_"+pis_seq).hide();
                }

            }else{

                date_info1.period = period;
                date_info1.interval = 'month';
                end_period[0] = date_info1.period+"개월";
                if(period > 1){
                    end_period[1] = (period - 1)+"개월";
                    date_info2.period = (period-1);
                }else{
                    end_period[1] = "0개월";
                    date_info2.period = 0;
                }
                basic_date_info_add[pis_seq].push(date_info1);

                end_str[0] = date_array[0]+"년 "+date_array[1]+"월 "+lastDay+"일";
                if(period > 1){
                    date_info2.start_date = moment(end_date).format("YYYY-MM-01");

                    end_date = moment(end_date).add((period-1),'months').format("YYYY-MM-DD");

                    end_str[1] = moment(end_date).format("YYYY년 MM월 DD일");
                    start_str[1] = moment(date_info1.end_date).add(1,'months').format("YYYY년 MM월 01일");
                    date_info2.end_date = end_date;

                    date_info2.interval = 'month';
                    basic_date_info_add[pis_seq].push(date_info2);

                    $("#view_add_"+pis_seq).show();
                }else{
                    end_str[1] = "0000년 00월 00일";
                    start_str[0] = selectedDate;
                    start_str[1] = "0000년 00월 00일";
                    $("#view_add_"+pis_seq).hide();
                }
            }

        }else{
            // console.log(sr_account_start_day+"::"+date_array[2]);
            if(parseInt(sr_account_start_day) <= parseInt(date_array[2])){
                var lastDay = ( new Date( date_array[0], date_array[1], 0) ).getDate();
                var end_date = date_array[0]+"-"+date_array[1]+"-"+lastDay;

                end_str[0] = moment(end_date).format("YYYY년 MM월 DD일");
                end_str[1] = moment(end_date).add(period,'months').format("YYYY년 MM월 DD일");
                end_period[0] = (moment.duration(moment(end_date).diff(moment(selectedDate))).asDays()+1)+"일";

                date_info1.start_date = selectedDate;
                date_info1.end_date = end_date;
                date_info1.period = moment.duration(moment(end_date).diff(moment(selectedDate))).asDays()+1;
                date_info1.interval = 'day';
                basic_date_info_add[pis_seq].push(date_info1);

                date_info2.start_date = moment(end_date).add(1,'months').format("YYYY-MM-01");
                start_str[1] = moment(end_date).add(1,'months').format("YYYY년 MM월 01일");
                end_date = moment(end_date).add(period,'months').format("YYYY-MM-DD");

                start_str[0] = selectedDate;


                end_period[1] = period+"개월";

                date_info2.end_date = end_date;
                date_info2.period = period;
                date_info2.interval = 'month';
                basic_date_info_add[pis_seq].push(date_info2);

                $("#view_add_"+pis_seq).show();
            }else{
                var lastDay = ( new Date( date_array[0], date_array[1], 0) ).getDate();
                var end_date = date_array[0]+"-"+date_array[1]+"-"+lastDay;

                date_info1.start_date = selectedDate;
                date_info1.end_date = end_date;
                // date_info1.period = period;
                // date_info1.interval = 'month';
                if(date_array[2] != "01"){
                    date_info1.period = moment.duration(moment(end_date).diff(moment(selectedDate))).asDays()+1;
                    date_info1.interval = 'day';
                    end_period[0] = date_info1.period+"일";
                }else{
                    date_info1.period = period;
                    date_info1.interval = 'month';
                    end_period[0] = date_info1.period+"개월";
                }
                basic_date_info_add[pis_seq].push(date_info1);
                end_str[0] = date_array[0]+"년 "+date_array[1]+"월 "+lastDay+"일";
                start_str[0] = selectedDate;
                if(period > 1){
                    end_period[1] = (period - 1)+"개월";
                    date_info2.period = (period-1);
                }else{
                    end_period[1] = "0개월";
                    date_info2.period = 0;
                }
                // console.log(period);
                if(period > 1){
                    date_info2.start_date = moment(end_date).format("YYYY-MM-01");

                    end_date = moment(end_date).add((period-1),'months').format("YYYY-MM-DD");

                    end_str[1] = moment(end_date).format("YYYY년 MM월 DD일");
                    start_str[1] = moment(date_info1.end_date).add(1,'months').format("YYYY년 MM월 01일");
                    date_info2.end_date = end_date;

                    date_info2.interval = 'month';
                    basic_date_info_add[pis_seq].push(date_info2);

                    $("#view_add_"+pis_seq).show();
                }else{
                    end_str[1] = "0000년 00월 00일";
                    start_str[0] = selectedDate;
                    start_str[1] = "0000년 00월 00일";
                    $("#view_add_"+pis_seq).hide();
                }


            }
        }
    }else{
        var end_date = moment(selectedDate).add(period,'months').subtract(1, "days").format("YYYY-MM-DD");
        end_str[0] = moment(selectedDate).add(period,'months').subtract(1, "days").format("YYYY년 MM월 DD일");
        end_str[1] = "0000년 00월 00일";

        start_str[0] = selectedDate;
        start_str[1] = "0000년 00월 00일";

        end_period[0] = period+"개월";
        end_period[1] = "0개월";

        date_info1.start_date = selectedDate;
        date_info1.end_date = moment(selectedDate).add(period,'months').subtract(1, "days").format("YYYY-MM-DD");
        date_info1.period = period;
        date_info1.interval = 'month';
        basic_date_info_add[pis_seq].push(date_info1);

        $("#view_add_"+pis_seq).hide();
    }

    // var month = moment(selectedDate).add(period,'months').format("YYYY-MM-DD");
    // $("#sr_account_end").val(end_date);
    $("#start_date_str_add_0_1_"+pis_seq).html(moment(start_str[0]).format("YYYY년 MM월 DD일"));
    $("#end_date_str_add_0_1_"+pis_seq).html(end_str[0]+" ("+end_period[0]+")");

    $("#start_date_str_add_0_2_"+pis_seq).html(start_str[1]);
    $("#end_date_str_add_0_2_"+pis_seq).html(end_str[1]+" ("+end_period[1]+")");

    if(basic_date_info_add[pis_seq].length > 1){
        $("#sap_first_start_"+pis_seq).val(start_str[0]);
        $("#sap_first_end_"+pis_seq).val(basic_date_info_add[pis_seq][0].end_date);
        $("#sap_first_month_start_"+pis_seq).val(start_str[1]);
        $("#sap_first_month_end_"+pis_seq).val(basic_date_info_add[pis_seq][1].end_date);
        // console.log(start_str[0]+"::"+basic_date_info_add[pis_seq][0].end_date+"::"+basic_date_info_add[pis_seq][1].end_date);
    }else{
        $("#sap_first_start_"+pis_seq).val("");
        $("#sap_first_end_"+pis_seq).val("");
        if(basic_date_info_add[pis_seq][0].interval == "day"){
            $("#sap_first_start_"+pis_seq).val(start_str[0]);
            $("#sap_first_end_"+pis_seq).val(basic_date_info_add[pis_seq][0].end_date);
            $("#sap_first_month_start_"+pis_seq).val("");
            $("#sap_first_month_end_"+pis_seq).val("");
        }else{
            $("#sap_first_start_"+pis_seq).val("");
            $("#sap_first_end_"+pis_seq).val("");
            $("#sap_first_month_start_"+pis_seq).val(start_str[0]);
            $("#sap_first_month_end_"+pis_seq).val(basic_date_info_Add[pis_seq][0].end_date);
        }
        // console.log(start_str[0]+"::"+basic_date_info_add[pis_seq][0].end_date);
    }

    // console.log(basic_date_info_add);
    // contractPriceDateInfo();
    contractPriceDateInfoAdd(pis_seq);
}
