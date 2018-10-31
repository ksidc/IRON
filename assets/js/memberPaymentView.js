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
        if($("#svp_payment_period").val() != "" && $("#sv_account_start").val() != ""){
            priceInfoDate();

            $(".addList").each(function(){
                priceInfoDateAdd($(this).data("svaseq"));
            })  

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
                if($("#svp_payment_period").val() != "" && $("#sv_account_start").val() != ""){
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
    $("#svp_payment_period").change(function(){
        var $this = $(this);
        var url = "/api/basicPolicyDetail/"+$("#sv_payment_type").val()
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "period="+$("#svp_payment_period").val(),
            success:function(response){
                if(response.result === null){
                    $("#svp_register_discount").val(0);
                    // $("#sr_register_discount_str").html(0);
                }else{
                    $("#svp_register_discount").val(response.result.discount);
                    // $("#sr_register_discount_str").html(response.result.discount);
                }
                $(".total_contract").html($this.val())
                calculatePrice();
                if($("#svp_payment_period").val() != "" && $("#sv_account_start").val() != ""){
                    priceInfoDate();
                }
            },
            error:function(error){
                console.log(error);
            }
        });
        
    });

    $(".btn-payment-modify").click(function(){
        if(confirm("요금정보를 수정하시겠습니까?")){
            var url = "/api/serviceUpdate";
            var datas = $("#serviceUpdate").serialize();
            // $("#serviceUpdate").submit();
            // return false;
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    console.log(response);
                    if(response.result){
                        alert("수정완료");
                        opener.getPriceList();
                        document.location.reload();

                    }
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
                    if(response.result){
                        alert("수정완료");
                        opener.getPriceList();
                        document.location.reload();
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
    })

    $("#svp_register_discount").change(function(){
        calculatePrice();
    })
    $("#defaultRegister").click(function(){
        if($(this).is(":checked")){
            var url = "/api/basicPolicyDetail/"+$("#sv_payment_type").val()
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "period="+$("#svp_payment_period").val(),
                success:function(response){
                    if(response.result === null){
                        $("#svp_register_discount").val(0);
                        // $("#sr_register_discount_str").html(0);
                    }else{
                        $("#svp_register_discount").val(response.result.discount);
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

    $("#sv_payment_type").change(function(){
        
        var url = "/api/basicPolicyDetail/"+$(this).val()
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "period="+$("#svp_payment_period").val(),
            success:function(response){
                console.log(response);
                if(response.result === null){
                    $("#svp_register_discount").val(0);
                    // $("#sr_register_discount_str").html(0);
                }else{
                    $("#svp_register_discount").val(response.result.discount);
                    // $("#sr_register_discount_str").html(response.result.discount);
                }
                calculatePrice();
            },
            error:function(error){
                console.log(error);
            }
        });
        
    })
    if($("#svp_payment_period").val() == 0)
        $("#svp_payment_period").trigger("change");

    $("#sv_rental_type").change(function(){
        if($(this).val() == "1"){
            $(".retaltype2").hide();
        }else{
            $(".retaltype2").show();
        }
    })

    $("#sva_claim_type").change(function(){
        if($(this).val() == "1"){
            $(".notshow").hide();
        }else{
            $(".notshow").show();
        }
    })

    $("#sv_pay_publish").change(function(){
        if($(this).val() == "1"){
            $("#sv_pay_publish_type").hide();
            $("#sv_pay_publish_type").next().hide();
        }else{

            $("#sv_pay_publish_type").show();
            $("#sv_pay_publish_type").next().show();
            $("#sv_pay_publish_type").addClass("select2");
            $(".select2").select2();
        }
    })

    $(":input:radio[name=p_sv_account_type]").change(function(){
        if($(this).val() == "1"){
            $(".type-hidden").show();
        }else{
            $(".type-hidden").hide();
        }
    });
    $(".btn-log-search").click(function(){
        getLog();
    })

    $("#log_end").change(function(){
        getLog();
    })
})

var basic_date_info = [];

var calculatePrice = function(){
    var sv_register_discount = parseInt($("#svp_register_discount").val() || 0); // 결제방법 할인
    var sv_payment_period = parseInt($("#svp_payment_period").val() || 0); // 결제주기
    var sv_month_price = parseInt($("#svp_month_price").val().replace(/,/gi, "") || 0); // 월금액
    var sv_month_dis_price = parseInt($("#svp_month_dis_price").val().replace(/,/gi, "") || 0); // 월금액 할인

    if($("#svp_discount_yn").is(":checked")){ // 결제방법할인 체크
        var price = Math.floor((sv_month_price-sv_month_dis_price)*sv_register_discount/100*sv_payment_period);
        $("#month_price3").html(" - "+$.number(price));
        $("#svp_discount_price").val(price);
    }else{
        $("#month_price3").html(" - 0");
        $("#svp_discount_price").val(0);
    }

    var sp_once_price = parseInt($("#svp_once_price").val().replace(/,/gi, "")|| 0);
    var sp_once_dis_price = parseInt($("#svp_once_dis_price").val().replace(/,/gi, "") || 0);

    var once_price = Math.floor((sp_once_price-sp_once_dis_price));
    $("#first_sum").html($.number(once_price));

    var first_surtax = once_price*0.1;
    $("#first_surtax").html( $.number(Math.round(first_surtax)) )
    $("#first_total").html($.number(once_price+Math.round(first_surtax)));
    $("#sv_once_total_price").val(once_price);
    $("#one_price_str0").html($.number(once_price));
    // $("#show_all_once_total").val(price);

    if($("#svp_discount_yn").is(":checked")){
        var sv_discount_price = parseInt($("#svp_discount_price").val() || 0);
    }else{
        var sv_discount_price = 0;
    }
    var total_price1 = sv_month_price - sv_month_dis_price; // 소계
    var total_price2 = total_price1*sv_payment_period; // 결제 기간 합계

    var total_price = parseInt(sv_month_price-(sv_month_dis_price*sv_payment_period)-sv_discount_price);
    var total_price_1 = parseInt(sv_month_price*sv_payment_period-(sv_month_dis_price*sv_payment_period)-sv_discount_price);
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

    var month_surtax = total_price_1*0.1;
    $("#month_price4").html($.number(total_price_1));
    $("#month_price5").html($.number(month_surtax));
    $("#month_price_total").html($.number(total_price_1+month_surtax));
    $("#sv_month_total_price").val(total_price_1);
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

    var sr_account_type = $("#sv_account_type").val();
    var sr_account_policy = $("#sv_account_policy").val();
    var sr_account_start_day = $("#sv_account_start_day").val();
    var date_array = selectedDate.split("-");
    var period = parseInt($("#svp_payment_period").val());

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
                    date_info2.start_date = moment(end_date).add(1,'months').format("YYYY-MM-01");

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
                        date_info2.start_date = moment(end_date).add(1,'months').format("YYYY-MM-01");

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
        $("#svp_first_month_start").val(basic_date_info[1].start_date);
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

            var month_price = parseInt($("#svp_month_price").val().replace(/,/gi, ""));
            var dis_price = parseInt($("#svp_month_dis_price").val().replace(/,/gi, ""));
            var dis_per = parseInt($("#svp_register_discount").val().replace(/,/gi, ""));
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
            $("#svp_first_month_price").val(basic_date_info[0].price);
        }

    }else if(basic_date_info.length == 2){
        var date_array = basic_date_info[0].end_date.split("-");

        var month_total_date = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            // var one_day_price = parseInt($("#sp_month_total_price").val())/month_total_date;
            // var total_price = one_day_price*basic_date_info[0].period;

        var month_price = parseInt($("#svp_month_price").val().replace(/,/gi, ""));
        var dis_price = parseInt($("#svp_month_dis_price").val().replace(/,/gi, ""));
        var dis_per = parseInt($("#svp_register_discount").val().replace(/,/gi, ""));
        var period_day = parseInt(basic_date_info[0].period);
        console.log(month_total_date+"::"+period_day);
        // console.log(period_day);
        console.log(month_price);
        if($("#svp_discount_yn").is(":checked")){
            var total_price = (month_price - dis_price) * (1-dis_per/100) / month_total_date * (period_day);
        }else{
            var total_price = (month_price - dis_price) / month_total_date * (period_day);
        }
        // console.log(total_price);
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
        basic_date_info[0].price = price;
        var month2 = parseInt($("#sv_month_total_price").val());
        var period_month = parseInt($("#svp_payment_period").val());
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

function priceInfoDateAdd(sva_seq){
    // console.log(sva_seq);
    basic_date_info = [];
    var selectedDate = $("#sv_account_start").val();

    var sr_account_type = $("#sv_account_type").val();
    var sr_account_policy = $("#sv_account_policy").val();
    var sr_account_start_day = $("#sv_account_start_day").val();
    var date_array = selectedDate.split("-");
    var period = parseInt($("#svp_payment_period_"+sva_seq).val());
    console.log(period);

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
                    date_info2.start_date = moment(end_date).add(1,'months').format("YYYY-MM-01");

                    end_date = moment(end_date).add((period-1),'months').format("YYYY-MM-DD");

                    end_str[1] = moment(end_date).format("YYYY년 MM월 DD일");
                    start_str[1] = moment(date_info1.end_date).add(1,'months').format("YYYY년 MM월 01일");
                    date_info2.end_date = end_date;

                    date_info2.interval = 'month';
                    basic_date_info.push(date_info2);

                    
                }else{
                    end_str[1] = "0000년 00월 00일";
                    start_str[0] = selectedDate;
                    start_str[1] = "0000년 00월 00일";
                   
                }
                console.log(1);
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
                console.log(2);

          
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
                        date_info2.start_date = moment(end_date).add(1,'months').format("YYYY-MM-01");

                        end_date = moment(end_date).add((period-1),'months').format("YYYY-MM-DD");

                        end_str[1] = moment(end_date).format("YYYY년 MM월 DD일");
                        start_str[1] = moment(date_info1.end_date).add(1,'months').format("YYYY년 MM월 01일");
                        date_info2.end_date = end_date;

                        date_info2.interval = 'month';
                        basic_date_info.push(date_info2);

                        // $("#view_add").show();
                    }else{
                        end_str[1] = "0000년 00월 00일";
                        start_str[0] = selectedDate;
                        start_str[1] = "0000년 00월 00일";
                        // $("#view_add").hide();
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


    }
    console.log(basic_date_info);
    // console.log(start_str[0]);
    // var month = moment(selectedDate).add(period,'months').format("YYYY-MM-DD");

    // 부가서비스 hidden값으로 처리
    if(basic_date_info.length > 1){
        $("#svp_first_day_start_"+sva_seq).val(start_str[0]);
        $("#svp_first_day_end_"+sva_seq).val(basic_date_info[0].end_date);
        $("#svp_first_month_start_"+sva_seq).val(basic_date_info[1].start_date);
        $("#svp_first_month_end_"+sva_seq).val(basic_date_info[1].end_date);
        // console.log(start_str[0]+"::"+basic_date_info[0].end_date+"::"+basic_date_info[1].end_date);
    }else{
        if(basic_date_info[0].interval == "day"){
            $("#svp_first_day_start_"+sva_seq).val(start_str[0]);
            $("#svp_first_day_end_"+sva_seq).val(basic_date_info[0].end_date);
            $("#svp_first_month_start_"+sva_seq).val("");
            $("#svp_first_month_end_"+sva_seq).val("");
        }else{
            $("#svp_first_day_start_"+sva_seq).val("");
            $("#svp_first_day_end_"+sva_seq).val("");
            $("#svp_first_month_start_"+sva_seq).val(start_str[0]);
            $("#svp_first_month_end_"+sva_seq).val(basic_date_info[0].end_date);
        }

        // console.log(start_str[0]+"::"+basic_date_info[0].end_date);
    }
    

    contractPriceDateInfoAdd(sva_seq);
}

function contractPriceDateInfoAdd(sva_seq){
    // console.log(basic_date_info.length);
    if(basic_date_info.length == 1){
        // console.log(basic_date_info[0].interval);
        if(basic_date_info[0].interval == "day"){
            var date_array = basic_date_info[0].end_date.split("-");

            var month_total_date = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            // var one_day_price = parseInt($("#sp_month_total_price").val())/month_total_date;
            // var total_price = one_day_price*basic_date_info[0].period;

            var month_price = parseInt($("#svp_month_price_"+sva_seq).val());
            var dis_price = parseInt($("#svp_month_dis_price_"+sva_seq).val());
            var dis_per = parseInt($("#svp_register_discount_"+sva_seq).val());
            var period = parseInt($("#svp_payment_period_"+sva_seq).val());
            var period_day = parseInt(basic_date_info[0].period);

            if($("#svp_discount_price_"+sva_seq).val() >0){
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
            

            basic_date_info[0].price = price;
            $("#svp_first_day_price_"+sva_seq).val(price);
            $("#svp_first_month_price_"+sva_seq).val(0);
        }else{
            // 월금액 가져와야함
            var total_price_1 = parseInt(month_price*period-(dis_price*period)-parseInt($("#svp_discount_price_"+sva_seq).val()));
            basic_date_info[0].price = total_price_1;
            $("#svp_first_day_price_"+sva_seq).val(0);
            $("#svp_first_month_price_"+sva_seq).val(basic_date_info[0].price);
        }

    }else if(basic_date_info.length == 2){
        var date_array = basic_date_info[0].end_date.split("-");

        var month_total_date = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            // var one_day_price = parseInt($("#sp_month_total_price").val())/month_total_date;
            // var total_price = one_day_price*basic_date_info[0].period;

        var month_price = parseInt($("#svp_month_price_"+sva_seq).val());
        var dis_price = parseInt($("#svp_month_dis_price_"+sva_seq).val());
        var dis_per = parseInt($("#svp_register_discount_"+sva_seq).val());
        var period = parseInt($("#svp_payment_period_"+sva_seq).val());
        var period_day = parseInt(basic_date_info[0].period);
        // console.log(month_total_date+"::"+period_day);
        // console.log(period_day);
        // console.log(month_price);
        if($("#svp_discount_price_"+sva_seq).val() >0){
            var total_price = (month_price - dis_price) * (1-dis_per/100) / month_total_date * (period_day);
        }else{
            var total_price = (month_price - dis_price) / month_total_date * (period_day);
        }
        // console.log(total_price);
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
        basic_date_info[0].price = price;
        console.log($("#svp_discount_price_"+sva_seq).val());
        var month2 = parseInt(month_price*period-(dis_price*period)-parseInt($("#svp_discount_price_"+sva_seq).val()));
        var period_month = parseInt($("#svp_payment_period_"+sva_seq).val());
        var once_period = basic_date_info[1].period;
        // console.log(period_month+":"+once_period)
        var price2 = month2 / period_month * once_period;

        basic_date_info[1].price = price2;

        $("#svp_first_day_price_"+sva_seq).val(price);
        $("#svp_first_month_price_"+sva_seq).val(price2);
    }
    
}

function getLog(){

    var url = "/api/fetchLogs/3/"+$(".sv_seq").val();
    console.log(url);
    var end = $("#log_end").val();
    var start = $("#log_start").val();
    var datas = $("#logForm").serialize();
// alert(start);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : datas+"&sv_seq="+$("#sv_seq").val()+"&start="+start+"&end="+end,
        success:function(response){
            console.log(response);
            var html = "";
            for(var i = 0;i<response.list.length;i++){
                var num = parseInt(response.total) - (($("#log_start").val()-1)*end) - i;
                html += '<tr>\
                            <td>'+num+'</td>\
                            <td>'+response.list[i].lo_regdate+'</td>\
                            <td>'+response.list[i].lo_type+'</td>\
                            <td>'+response.list[i].lo_item+'</td>\
                            <td>'+response.list[i].lo_origin+'</td>\
                            <td>'+response.list[i].lo_after+'</td>\
                            <td>';
                                if(response.list[i].lo_user == "1"){
                                    html += "ADMIN";
                                }else if(response.list[i].lo_user == "2"){
                                    html += "SYSTEM";
                                }else{
                                    html += "USER";
                                }
                            html += '</td>\
                            <td></td>\
                            <td>'+response.list[i].lo_ip+'</td>\
                        </tr>';
                
            }
            if(html == ""){
                html = "<tr><td colspan=9 align=center>내용이 없습니다.</td></tr>";
            }
            console.log(html);
            $("#log-list").html(html);

            $("#logPaging").bootpag({
                total : Math.ceil(parseInt(response.total)/end), // 총페이지수 (총 Row / list노출개수)
                page : $("#log_start").val(), // 현재 페이지 default = 1
                maxVisible:5, // 페이지 숫자 노출 개수
                wrapClass : "pagination",
                next : ">",
                prev : "<",
                nextClass : "last",
                prevClass : "first",
                activeClass : "active"

            }).on('page', function(event,num){ // 이벤트 액션
                // document.location.href='/pageName/'+num; // 페이지 이동
                $("#log_start").val(num);
                getLog();
            })
        },
        error: function(error){
            console.log(error);
        }
    });
}

function getAddLog(){

    var url = "/api/fetchLogs/6/"+$(".sva_seq").val();
    console.log(url);
    var end = $("#log_end").val();
    var start = $("#log_start").val();
    var datas = $("#logForm").serialize();
// alert(start);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : datas+"&sva_seq="+$(".sva_seq").val()+"&start="+start+"&end="+end,
        success:function(response){
            console.log(response);
            var html = "";
            for(var i = 0;i<response.list.length;i++){
                var num = parseInt(response.total) - (($("#log_start").val()-1)*end) - i;
                html += '<tr>\
                            <td>'+num+'</td>\
                            <td>'+response.list[i].lo_regdate+'</td>\
                            <td>'+response.list[i].lo_type+'</td>\
                            <td>'+response.list[i].lo_item+'</td>\
                            <td>'+response.list[i].lo_origin+'</td>\
                            <td>'+response.list[i].lo_after+'</td>\
                            <td>';
                                if(response.list[i].lo_user == "1"){
                                    html += "ADMIN";
                                }else if(response.list[i].lo_user == "2"){
                                    html += "SYSTEM";
                                }else{
                                    html += "USER";
                                }
                            html += '</td>\
                            <td></td>\
                            <td>'+response.list[i].lo_ip+'</td>\
                        </tr>';
                
            }
            if(html == ""){
                html = "<tr><td colspan=9 align=center>내용이 없습니다.</td></tr>";
            }
            console.log(html);
            $("#log-list").html(html);

            $("#logPaging").bootpag({
                total : Math.ceil(parseInt(response.total)/end), // 총페이지수 (총 Row / list노출개수)
                page : $("#log_start").val(), // 현재 페이지 default = 1
                maxVisible:5, // 페이지 숫자 노출 개수
                wrapClass : "pagination",
                next : ">",
                prev : "<",
                nextClass : "last",
                prevClass : "first",
                activeClass : "active"

            }).on('page', function(event,num){ // 이벤트 액션
                // document.location.href='/pageName/'+num; // 페이지 이동
                $("#log_start").val(num);
                getLog();
            })
        },
        error: function(error){
            console.log(error);
        }
    });
}