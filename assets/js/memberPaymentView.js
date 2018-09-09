var basic_date_info = [];
$(function(){
    priceInfoDate();
    calculatePrice();
    $( "#dialogFirstSetting" ).dialog({
        autoOpen: false,
        modal: true,
        width:'800px',
        height : 260
    });

    $(".btn-price-policy").click(function(){
        var sv_account_type = $(":input:radio[name=p_sv_account_type]:checked").val();
        var sv_account_policy = $(":input:radio[name=p_sv_account_policy]:checked").val();
        var sv_account_start_day = $("#p_sv_account_start_day").val();
        var sv_account_format = $("#p_sv_account_format").val();
        var sv_account_format_policy = $("#p_sv_account_format_policy").val();

        $("#sv_account_type").val(sv_account_type);
        $("#sv_account_policy").val(sv_account_policy);
        $("#sv_account_start_day").val(sv_account_start_day);
        $("#sv_account_format").val(sv_account_format);
        $("#sv_account_format_policy").val(sv_account_format_policy);
        if(sv_account_type == "1"){
            if(sv_account_policy == "1"){
                var text = "당월분 일할 계산";
                var text2_1 = $("#p_sv_account_format option:selected").text();
                var text2_2 = $("#p_sv_account_format_policy option:selected").text();
                $("#policy_text1").html(text);
                $("#policy_text2").html(text2_1+" "+text2_2);
            }else{
                var text = sv_account_start_day+"일(과금시작) 이후 건 익월분 통합";
                var text2_1 = $("#p_sv_account_format option:selected").text();
                var text2_2 = $("#p_sv_account_format_policy option:selected").text();
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
        if($("#sv_payment_period").val() != "" && $("#sv_account_start").val() != ""){
            priceInfoDate();
        }

        // $(".addoptionprice").each(function(){
        //     var add_seq = $(this).data("seq");
        //     if($("#sa_pay_day_"+add_seq).val() != ""){
        //         priceInfoDateAdd(add_seq);
        //         calculateAddPrice(add_seq);

        //     }
        // })
        alert("적용되었습니다.");
        $('#dialogFirstSetting').dialog('close');

    });

    // $(".detailView").click(function(){

    //     var seq = $(this).data("seq")
    //     var url = "/api/memberPaymentView/"+seq
    //     $.ajax({
    //         url : url,
    //         type : 'GET',
    //         dataType : 'JSON',
    //         success:function(response){
    //             // console.log(response);
    //             console.log(response.sva_seq);
    //             if(response.sva_seq == "" || response.sva_seq === null){
    //                 $("#sv_code").text(response.sv_code);
    //                 $("#pc_name").text(response.pc_name);
    //                 $("#pr_name").text(response.pr_name);
    //                 $("#ps_name").text(response.ps_name);
    //                 $("#sv_number").text(response.sv_number)
    //             }else{
    //                 $("#sv_code").text(response.sv_code);
    //                 $("#pc_name").text(response.pi_name+" - 부가항목");
    //                 $("#pr_name").text(response.sva_name);
    //                 $("#ps_name").text(response.sv_number);
    //             }
    //             $(".sv_seq").val(response.sv_seq);
    //             $("#sv_claim_name").val(response.sv_claim_name);
    //             $("#sv_bill_name").val(response.sv_bill_name);
    //             $("#sv_payment_type").val(response.sv_payment_type).trigger("change");
    //             $("#sv_payment_period").val(response.sv_payment_period);
    //             $("#sv_pay_type").val(response.sv_pay_type).trigger("change");
    //             $("#sv_pay_day").val(response.sv_pay_day).trigger("change");
    //             $("#sv_pay_publish").val(response.sv_pay_publish).trigger("change");
    //             $("#sv_pay_publish_type").val(response.sv_pay_publish_type).trigger("change");
    //             $("#sv_payment_day").val(response.sv_payment_day);
    //             $("#sv_account_start").val(response.sv_account_start);
    //             $("#sv_account_end").val(response.sv_account_end);
    //             $("#sv_c_name").val(response.c_name);
    //             $("#sv_register_discount").val(response.sv_register_discount)
    //             $("#sv_input_price").val(response.sv_input_price);
    //             $("#first_price").val(response.ap_once_price);
    //             $("#first_dis_price").val(response.ap_once_dis_price);
    //             var first_sum = response.ap_once_price-response.ap_once_dis_price;
    //             var first_surtax = first_sum*0.1;
    //             $("#first_sum").html($.number(first_sum));
    //             $("#first_surtax").html( $.number(Math.round(first_surtax)) )
    //             $("#first_total").html($.number(first_sum+Math.round(first_surtax)));
    //             $("#service_month_price").val(response.ap_price);
    //             $("#service_month_dis_price").val(response.ap_dis_price);
    //             var month_price = response.ap_price-response.ap_dis_price;
    //             var period_price = month_price*response.sv_payment_period;
    //             var discount_price = 0;
    //             $("#month_price1").html($.number(month_price));
    //             $("#month_price2").html($.number(period_price));
    //             $("#month_price3").html($.number(discount_price));

    //             $("#month_price4").html(period_price-discount_price);
    //             var total_surtax = (period_price-discount_price)*0.1;
    //             $("#month_price5").html($.number(total_surtax));
    //             $("#month_price_total").html(period_price-discount_price+total_surtax);
    //             $(".total_contract").html(response.sv_payment_period);


    //             if(response.sv_pay_format == "1"){
    //                 var text_format = "1의 자리";
    //             }else if(response.sv_pay_format == "2"){
    //                 var text_format = "10의 자리";
    //             }else if(response.sv_pay_format == "3"){
    //                 var text_format = "100의 자리";
    //             }else if(response.sv_pay_format == "4"){
    //                 var text_format = "1000의 자리";
    //             }

    //             if(response.sv_pay_format_policy == "1"){
    //                 var text_format2 = "내림";
    //             }else if(response.sv_pay_format_policy == "2"){
    //                 var text_format2 = "올림";
    //             }else if(response.sv_pay_format_policy == "3"){
    //                 var text_format2 = "반올림";
    //             }

    //             if(response.sv_basic_type == "1"){
    //                 if(response.sv_policy == "1"){
    //                     var text = "당월분 일할 계산";
    //                 }else{
    //                     var text = response.sv_pay_start_day+"일(과금시작) 이후 건 익월분 통합";
    //                 }
    //                 var html = '<div class="input"><span id="policy_text"><span id="policy_text1">'+text+'</span> (<span id="policy_text2">'+text_format+' '+text_format2+'</span>)</span> <span id="policy_text_2" style="display:none"></span> <button class="btn btn-brown" type="button" onclick=\'$( "#dialogFirstSetting" ).dialog("open");$("#dialogFirstSetting").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();\'>변경</button></div>';
    //             }else{

    //                 var html = '<div class="input"><span id="policy_text" style="display:none"><span id="policy_text1">당월분 일할 계산</span> (<span id="policy_text2">'+text_format+' '+text_format2+'</span>)</span> <span id="policy_text_2">과금 시작일 기준 결제 주기로 처리</span> <button class="btn btn-brown" type="button" onclick=\'$( "#dialogFirstSetting" ).dialog("open");$("#dialogFirstSetting").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();\'>변경</button></div>';
    //             }
    //             $("#policy").html(html);

    //             $("#sv_account_type").val(response.sv_account_type);
    //             $("#sv_account_policy").val(response.sv_account_policy);
    //             $("#sv_account_start_day").val(response.sv_account_start_day);
    //             $("#sv_account_format").val(response.sv_account_format);
    //             $("#sv_account_format_policy").val(response.sv_account_format_policy);

    //             $("input:radio[name='sp_basic_type'][value='"+response.sv_account_type+"']").prop("checked",true);
    //             $("input:radio[name='sp_policy'][value='"+response.sv_account_policy+"']").prop("checked",true);
    //             $("#sp_pay_start_day").val(response.sv_account_start_day).trigger("change");
    //             $("#sp_pay_format").val(response.sv_account_format).trigger("change");
    //             $("#sp_pay_format_policy").val(response.sv_account_format_policy).trigger("change");
    //             $('#dialog').dialog({
    //                 title: '서비스 요금 상세',
    //                 modal: true,
    //                 width: '800px',
    //                 draggable: true
    //             });
    //         }
    //     });
    // });

    $("#svp_once_price").change(function(){
        // $("#svp_once_price").val($(this).val());
        // $("#svp_once_total_price").val($(this).val());
        // $("#one_price_str0").html($.number($(this).val()));
        calculatePrice();
    });

    $("#svp_month_dis_price").change(function(){
        calculatePrice();
    });

    $("#svp_once_dis_price").change(function(){
        calculatePrice();
    })

    $("#svp_month_price").change(function(){

        calculatePrice();
    });

    $("#svp_discount_yn").click(function(){

        calculatePrice();
    });

    $( ".datepicker4" ).datepicker({
        "dateFormat" : "yy-mm-dd",
        onSelect: function(selectedDate) {
            // console.log(selectedDate);
                calculatePrice();
                if($("#sv_payment_period").val() != "" && $("#sv_account_start").val() != ""){
                    priceInfoDate();
                }
                // if($("#sv_account_start").val() != ""){
                //     // console.log(moment($("#sr_contract_start").val()).add(1,'months').subtract(1, "days").format("YYYY-MM-DD"));
                //     $("#sv_account_end").val(moment($("#sv_account_start").val()).add(1,'months').subtract(1, "days").format("YYYY-MM-DD"));
                //     var start = new Date($("#sv_account_start").val());
                //     // var end = new Date($("#sr_contract_end").val());
                //     var end = moment($("#sv_account_end").val()).add(1,'days').format("YYYY-MM-DD");
                //     end = new Date(end);
                //     // var diff = Date.getFormattedDateDiff(start, end);
                //     // $("#contractinfo").html("("+diff[0]+"개월 "+diff[1]+"일)");
                // }

        }
    });
    $("#sv_payment_period").change(function(){
        $(".total_contract").html($(this).val())
        calculatePrice();
        if($("#sv_payment_period").val() != "" && $("#sv_account_start").val() != ""){
            priceInfoDate();
        }
    });

    $(".btn-payment-modify").click(function(){
        if(confirm("요금정보를 수정하시겠습니까?")){
            var url = "/api/serviceUpdate";
            var datas = $("#serviceUpdate").serialize();
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    console.log(response);
                    if(response.result)
                        document.location.reload();
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
    })

    $(".btn-payment-modify-add").click(function(){
        if(confirm("요금정보를 수정하시겠습니까?")){
            var url = "/api/serviceAddUpdate";
            var datas = $("#serviceAddUpdate").serialize();
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    console.log(response);
                    if(response.result)
                        document.location.reload();
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
    })

    $("#sv_register_discount").change(function(){
        calculatePrice();
    })
    $("#defaultRegister").click(function(){
        if($(this).is(":checked")){
            var url = "/api/basicPolicyDetail/"+$("#sv_payment_type").val()
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "period="+$("#sv_payment_period").val(),
                success:function(response){
                    if(response.result === null){
                        $("#sv_register_discount").val(0);
                        // $("#sr_register_discount_str").html(0);
                    }else{
                        $("#sv_register_discount").val(response.result.sb_discount);
                        // $("#sr_register_discount_str").html(response.result.discount);
                    }
                    calculatePrice();
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
    })
})

var basic_date_info = [];

var calculatePrice = function(){
    var sv_register_discount = parseInt($("#sv_register_discount").val() || 0); // 결제방법 할인
    var sv_payment_period = parseInt($("#sv_payment_period").val() || 0); // 결제주기
    var sv_month_price = parseInt($("#svp_month_price").val() || 0); // 월금액
    var sv_month_dis_price = parseInt($("#svp_month_dis_price").val() || 0); // 월금액 할인

    if($("#svp_discount_yn").is(":checked")){ // 결제방법할인 체크
        var price = Math.floor((sv_month_price-sv_month_dis_price)*sv_register_discount/100*sv_payment_period);
        $("#month_price3").html($.number(price));
        $("#svp_register_discount").val(price);
    }else{
        $("#month_price3").html(0);
        $("#svp_register_discount").val(0);
    }

    var sp_once_price = parseInt($("#svp_once_price").val()|| 0);
    var sp_once_dis_price = parseInt($("#svp_once_dis_price").val() || 0);

    var once_price = Math.floor((sp_once_price-sp_once_dis_price));
    $("#first_sum").val(once_price);

    var first_surtax = once_price*0.1;
    $("#first_surtax").html( $.number(Math.round(first_surtax)) )
    $("#first_total").html($.number(once_price+Math.round(first_surtax)));
    $("#sv_once_total_price").val(once_price+Math.round(first_surtax));
    $("#one_price_str0").html($.number(once_price+Math.round(first_surtax)));
    // $("#show_all_once_total").val(price);

    if($("#svp_discount_yn").is(":checked")){
        var sv_discount_price = parseInt($("#svp_register_discount").val() || 0);
    }else{
        var sv_discount_price = 0;
    }
    var total_price1 = sv_month_price - sv_month_dis_price; // 소계
    var total_price2 = total_price1*sv_payment_period; // 결제 기간 합계

    var total_price = parseInt(sv_month_price-(sv_month_dis_price*sv_payment_period)-sv_discount_price);
    if($("#sv_account_format").val() == "1"){
        if($("#sv_account_format_policy").val() == "1"){ // 버림
            var price = Math.floor(total_price/10)*10;
        }else if($("#sv_account_format_policy").val() == "2"){ //올림
            var price = Math.ceil(total_price/10)*10;
        }else if($("#sv_account_format_policy").val() == "3"){ //반올림
            var price = Math.round(total_price/10)*10;
        }
    }else if($("#sv_account_format").val() == "2"){
        if($("#sv_account_format_policy").val() == "1"){ // 버림
            var price = Math.floor(total_price/100)*100;
        }else if($("#sv_account_format_policy").val() == "2"){ //올림
            var price = Math.ceil(total_price/100)*100;
        }else if($("#sv_account_format_policy").val() == "3"){ //반올림
            var price = Math.round(total_price/100)*100;
        }
    }else if($("#sv_account_format").val() == "3"){
        if($("#sv_account_format_policy").val() == "1"){ // 버림
            var price = Math.floor(total_price/1000)*1000;
        }else if($("#sv_account_format_policy").val() == "2"){ //올림
            var price = Math.ceil(total_price/1000)*1000;
        }else if($("#sv_account_format_policy").val() == "3"){ //반올림
            var price = Math.round(total_price/1000)*1000;
        }
    }else if($("#sv_account_format").val() == "4"){
        if($("#sv_account_format_policy").val() == "1"){ // 버림
            var price = Math.floor(total_price/10000)*10000;
        }else if($("#sv_account_format_policy").val() == "2"){ //올림
            var price = Math.ceil(total_price/10000)*10000;
        }else if($("#sv_account_format_policy").val() == "3"){ //반올림
            var price = Math.round(total_price/10000)*10000;
        }
    }
    // console.log(price);
    // $("#use_price_str_0_1").html($.number(price));
    $("#month_price1").html($.number(total_price1));
    $("#month_price2").html($.number(total_price2));

    var month_surtax = price*0.1;
    $("#month_price4").html($.number(price));
    $("#month_price5").html($.number(month_surtax));
    $("#month_price_total").html($.number(price+month_surtax));
    $("#sv_month_total_price").val(price+month_surtax);
    // $("#show_month_total").val(total_price);

    // var sp_once_total_price = parseInt($("#sp_once_total_price").val() || 0);
    // var sp_month_total_price = parseInt($("#sp_month_total_price").val() || 0);
    // // $("#total_str0").html($.number(sp_once_total_price+sp_month_total_price));
    // var show_total_price = 0;
    // $(".total-cal-price").each(function(){
    //     show_total_price = show_total_price + parseInt($(this).data("price"));
    // })
    // $("#show_all_total").val(show_total_price);

    // var total_month_price = parseInt($("#show_all_total").val()) - parseInt($("#show_all_once_total").val());
    // $("#show_all_month_total").val(total_month_price);


    contractPriceDateInfo();
    // calculateTotalPrice();
}

function priceInfoDate(){
    basic_date_info = [];
    var selectedDate = $("#sv_account_start").val();

    var sv_account_type = $("#sv_account_type").val();
    var sv_account_policy = $("#sv_account_policy").val();
    var sv_account_start_day = $("#sv_account_start_day").val();
    var date_array = selectedDate.split("-");
    var period = parseInt($("#sv_payment_period").val());

    var start_str = [];
    var end_str = [];
    var end_period = [];
    var date_info1 = {};
    var date_info2 = {};
    if(sv_account_type == "1"){
        if(sv_account_policy == "1"){
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
            if(parseInt(sv_account_start_day) <= parseInt(date_array[2])){
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
    $("#sv_account_end").val(end_date);
    $("#start_date_str_0_1").html(moment(start_str[0]).format("YYYY년 MM월 DD일"));
    $("#end_date_str_0_1").html(end_str[0]+" ("+end_period[0]+")");

    $("#start_date_str_0_2").html(start_str[1]);
    $("#end_date_str_0_2").html(end_str[1]+" ("+end_period[1]+")");

    if(basic_date_info.length > 1){
        $("#svp_first_day_start").val(start_str[0]);
        $("#svp_first_day_end").val(basic_date_info[0].end_date);
        $("#svp_first_month_start").val(start_str[1]);
        $("#svp_first_month_end").val(basic_date_info[1].end_date);
        // console.log(start_str[0]+"::"+basic_date_info[0].end_date+"::"+basic_date_info[1].end_date);
    }else{
        if(basic_date_info[0].interval == "day"){
            $("#svp_first_day_start").val(start_str[0]);
            $("#svp_first_day_end").val(basic_date_info[0].end_date);
            $("#svp_first_month_start").val("");
            $("#svp_first_month_end").val("");
        }else{
            $("#svp_first_day_start").val("");
            $("#svp_first_day_end").val("");
            $("#svp_first_month_start").val(start_str[0]);
            $("#svp_first_month_end").val(basic_date_info[0].end_date);
        }

        // console.log(start_str[0]+"::"+basic_date_info[0].end_date);
    }

    contractPriceDateInfo();
}

function contractPriceDateInfo(){
    // console.log(basic_date_info.length);
    if(basic_date_info.length == 1){
        // console.log(basic_date_info[0].interval);
        if(basic_date_info[0].interval == "day"){
            var date_array = basic_date_info[0].end_date.split("-");

            var month_total_date = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            // var one_day_price = parseInt($("#sp_month_total_price").val())/month_total_date;
            // var total_price = one_day_price*basic_date_info[0].period;

            var month_price = parseInt($("#svp_month_price").val())/parseInt($("#sv_payment_period").val());
            var dis_price = parseInt($("#svp_month_dis_price").val());
            var dis_per = parseInt($("#svp_register_discount").val());
            var period_day = parseInt(basic_date_info[0].period);

            if($("#svp_discount_yn").is(":checked")){
                var total_price = (month_price - dis_price) * (1-dis_per/100) / month_total_date * period_day;
            }else{
                var total_price = (month_price - dis_price) / month_total_date * period_day;
            }
            if($("#sv_account_format").val() == "1"){
                if($("#sv_account_format_policy").val() == "1"){ // 버림
                    var price = Math.floor(total_price/10)*10;
                }else if($("#sv_account_format_policy").val() == "2"){ //올림
                    var price = Math.ceil(total_price/10)*10;
                }else if($("#sv_account_format_policy").val() == "3"){ //반올림
                    var price = Math.round(total_price/10)*10;
                }
            }else if($("#sv_account_format").val() == "2"){
                if($("#sv_account_format_policy").val() == "1"){ // 버림
                    var price = Math.floor(total_price/100)*100;
                }else if($("#sv_account_format_policy").val() == "2"){ //올림
                    var price = Math.ceil(total_price/100)*100;
                }else if($("#sv_account_format_policy").val() == "3"){ //반올림
                    var price = Math.round(total_price/100)*100;
                }
            }else if($("#sv_account_format").val() == "3"){
                if($("#sv_account_format_policy").val() == "1"){ // 버림
                    var price = Math.floor(total_price/1000)*1000;
                }else if($("#sv_account_format_policy").val() == "2"){ //올림
                    var price = Math.ceil(total_price/1000)*1000;
                }else if($("#sv_account_format_policy").val() == "3"){ //반올림
                    var price = Math.round(total_price/1000)*1000;
                }
            }else if($("#sv_account_format").val() == "4"){
                if($("#sv_account_format_policy").val() == "1"){ // 버림
                    var price = Math.floor(total_price/10000)*10000;
                }else if($("#sv_account_format_policy").val() == "2"){ //올림
                    var price = Math.ceil(total_price/10000)*10000;
                }else if($("#sv_account_format_policy").val() == "3"){ //반올림
                    var price = Math.round(total_price/10000)*10000;
                }
            }
            console.log(price);
            $("#use_price_str_0_1").html($.number(price));
            basic_date_info[0].price = price;
            $("#svp_first_day_price").val(price);
            $("#svp_first_month_price").val(0);
        }else{
            // console.log($("#svp_month_total_price").val());
            $("#use_price_str_0_1").html($.number($("#sv_month_total_price").val()));
            basic_date_info[0].price = $("#sv_month_total_price").val();
            $("#svp_first_day_price").val(0);
            $("#svp_first_month_price").val(price);
        }

    }else if(basic_date_info.length == 2){
        var date_array = basic_date_info[0].end_date.split("-");

        var month_total_date = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            // var one_day_price = parseInt($("#sp_month_total_price").val())/month_total_date;
            // var total_price = one_day_price*basic_date_info[0].period;

        var month_price = parseInt($("#svp_month_price").val())/parseInt($("#sv_payment_period").val());
        var dis_price = parseInt($("#svp_month_dis_price").val());
        var dis_per = parseInt($("#svp_register_discount").val());
        var period_day = parseInt(basic_date_info[0].period);
        // console.log(month_total_date+"::"+period_day);
        // console.log(period_day);
        if($("#svp_discount_yn").is(":checked")){
            var total_price = (month_price - dis_price) * (1-dis_per/100) / month_total_date * (period_day);
        }else{
            var total_price = (month_price - dis_price) / month_total_date * (period_day);
        }

        if($("#sv_account_format").val() == "1"){
            if($("#sv_account_format_policy").val() == "1"){ // 버림
                var price = Math.floor(total_price/10)*10;
            }else if($("#sv_account_format_policy").val() == "2"){ //올림
                var price = Math.ceil(total_price/10)*10;
            }else if($("#sv_account_format_policy").val() == "3"){ //반올림
                var price = Math.round(total_price/10)*10;
            }
        }else if($("#sv_account_format").val() == "2"){
            if($("#sv_account_format_policy").val() == "1"){ // 버림
                var price = Math.floor(total_price/100)*100;
            }else if($("#sv_account_format_policy").val() == "2"){ //올림
                var price = Math.ceil(total_price/100)*100;
            }else if($("#sv_account_format_policy").val() == "3"){ //반올림
                var price = Math.round(total_price/100)*100;
            }
        }else if($("#sv_account_format").val() == "3"){
            if($("#sv_account_format_policy").val() == "1"){ // 버림
                var price = Math.floor(total_price/1000)*1000;
            }else if($("#sv_account_format_policy").val() == "2"){ //올림
                var price = Math.ceil(total_price/1000)*1000;
            }else if($("#sv_account_format_policy").val() == "3"){ //반올림
                var price = Math.round(total_price/1000)*1000;
            }
        }else if($("#sv_account_format").val() == "4"){
            if($("#sv_account_format_policy").val() == "1"){ // 버림
                var price = Math.floor(total_price/10000)*10000;
            }else if($("#sv_account_format_policy").val() == "2"){ //올림
                var price = Math.ceil(total_price/10000)*10000;
            }else if($("#sv_account_format_policy").val() == "3"){ //반올림
                var price = Math.round(total_price/10000)*10000;
            }
        }

        basic_date_info[0].price = price;
        var month2 = parseInt($("#sv_month_total_price").val());
        var period_month = parseInt($("#sv_payment_period").val());
        var once_period = basic_date_info[1].period;
        // console.log(period_month+":"+once_period)
        var price2 = month2 / period_month * once_period;

        basic_date_info[1].price = price2;

        $("#use_price_str_0_1").html($.number(price));
        $("#use_price_str_0_2").html($.number(price2));
        $("#svp_first_day_price").val(price);
        $("#svp_first_month_price").val(price2);
    }
    var totalprice = 0;
    totalprice = parseInt(totalprice) + parseInt($("#sv_once_total_price").val()) || 0;
    for(var i = 0; i < basic_date_info.length;i++){
        totalprice = parseInt(totalprice) + parseInt(basic_date_info[i].price);
    }

    $("#total_str0").data("price",totalprice);
    $("#total_str0").html($.number(totalprice));
}