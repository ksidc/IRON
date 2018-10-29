$(function(){
    $(".btn-claim-modify").click(function(){
        if(confirm("청구 내용을 수정하시겠습니까?")){
            var url = "/api/paymentUpdate";
            var datas = $("#payForm").serialize();
            // console.log(datas);
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
                        opener.getClaimList();
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
    })

    $(".btn-paycom-modify").click(function(){
        if(confirm("결제 내용을 수정하시겠습니까?")){
            var url = "/api/paymentComUpdate";
            var datas = $("#payForm").serialize();
            // console.log(datas);
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
                        opener.getComList(false);
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
    })

    $("#pm_pay_type").change(function(){
        var $this = $(this);
        var url = "/api/basicPolicyDetail/"+$("#pm_pay_type").val()
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "period="+$("#pm_pay_period").val(),
            success:function(response){
                if(response.result === null){
                    $("#pm_register_discount").val(0);
                    // $("#sr_register_discount_str").html(0);
                }else{
                    $("#pm_register_discount").val(response.result.discount);
                    // $("#sr_register_discount_str").html(response.result.discount);
                }
               
                calculatePrice();
                
            },
            error:function(error){
                console.log(error);
            }
        });
        
    });
    $( ".datepicker2" ).datepicker({
        "dateFormat" : "yy-mm-dd",
        onSelect: function(selectedDate){
            // 날짜 및 초기 청구 요금 내용
            var pay_day = parseInt($("#sv_payment_day").val());
            var end = moment(selectedDate).add(pay_day,'days').format("YYYY-MM-DD");
            $("#pm_end_date").val(end);
            $("#p_pm_end_date").html(end);
        }
    });

    $("#pm_once_price").keyup(function(){
        calculatePrice();
    })

    $("#pm_once_dis_price").keyup(function(){
        calculatePrice();
    })

    $("#pm_service_price").keyup(function(){
        calculatePrice();
    })

    $("#pm_service_dis_price").keyup(function(){
        calculatePrice();
    })
})

var calculatePrice = function(){
    var once_price = parseInt($("#pm_once_price").val().replace(/,/gi, ""));
    var once_dis_price = parseInt($("#pm_once_dis_price").val().replace(/,/gi, ""));
    var first_day_price = parseInt($("#pm_first_day_price").val())

    $("#p_pm_once_total").html($.number(once_price-once_dis_price)+" 원");
    if($("#pm_service_price").val() !== undefined ){
        var month_price = parseInt($("#pm_service_price").val().replace(/,/gi, ""));
        var month_dis_price = parseInt($("#pm_service_dis_price").val().replace(/,/gi, ""));
        var discount_percent = $("#pm_register_discount").val();
        var pay_period = $("#pm_pay_period").val();
        var month = $("#month").val();
    }else{
        var month_price = 0;
        var month_dis_price = 0;
        var discount_percent = 0;
        var pay_period = 0;
        var month = 0;
        first_day_price = 0;
    }
    if(discount_percent > 0){
        var discount_price = Math.floor((month_price-month_dis_price)*discount_percent/100*pay_period);
    }else{
        var discount_price = 0;
    }

    $("#p_month_price1").html($.number(month_price-month_dis_price));
    $("#p_month_price2").html($.number((month_price-month_dis_price)*month));
    console.log(discount_price);
    if(discount_price != 0){
        $("#p_month_price3").html("- "+$.number((discount_price/pay_period)*month));
        $("#pm_payment_dis_price").val(discount_price);
        $("#p_month_price4").html($.number((month_price-month_dis_price)*month-(discount_price/pay_period)*month));
        $("#p_pm_total_price2").html($.number(once_price-once_dis_price+first_day_price+((month_price-month_dis_price)*month)-(discount_price/pay_period)*month)+" 원");

        $("#p_pm_total_price4").html($.number((once_price-once_dis_price+first_day_price+((month_price-month_dis_price)*month)-(discount_price/pay_period)*month)*0.1)+" 원");
        $("#p_pm_total_price5").html($.number((month_price-month_dis_price)*month-(discount_price/pay_period)*month)+" 원");
        $("#p_pm_total_price6").html($.number((once_price-once_dis_price+first_day_price+((month_price-month_dis_price)*month)-(discount_price/pay_period)*month)*1.1)+" 원");
    }else{
        $("#p_month_price3").html("- 0");
        $("#pm_payment_dis_price").val(0);
        $("#p_month_price4").html($.number((month_price-month_dis_price)*month));
        $("#p_pm_total_price2").html($.number(once_price-once_dis_price+first_day_price+((month_price-month_dis_price)*month))+" 원");
        $("#p_pm_total_price4").html($.number((once_price-once_dis_price+first_day_price+((month_price-month_dis_price)*month))*0.1)+" 원");
        $("#p_pm_total_price5").html($.number((month_price-month_dis_price)*month)+" 원");
        $("#p_pm_total_price6").html($.number((once_price-once_dis_price+first_day_price+((month_price-month_dis_price)*month))*1.1)+" 원");
    }
    
    $("#p_pm_total_price1").html($.number(once_price-once_dis_price)+" 원");
    $("#p_pm_total_price3").html($.number(first_day_price)+" 원");

    
    
}