
$(function(){


    $( "#dialogFirstSetting" ).dialog({
        autoOpen: false,
        modal: true,
        width:'800px',
        height : 260
    });

    $( "#dialogOnce" ).dialog({
        autoOpen: false,
        modal: true,
        width:'800px',
        height : 500
    });

    $( "#dialogClaim" ).dialog({
        autoOpen: false,
        modal: true,
        width:'710px',
        height : 700
    });

    $( "#dialogBill" ).dialog({
        autoOpen: false,
        modal: true,
        width:'710px',
        height : 700
    });

    $( "#dialogInput" ).dialog({
        autoOpen: false,
        modal: true,
        width:'500px',
        height : 400
    });

    $("#all_payment").click(function(){
        if($(this).is(":checked")){
            $(".payment_check").prop("checked",true);
        }else{
            $(".payment_check").prop("checked",false);
        }
        paymentCal();
    })

    $("#claim_all").click(function(){
        if($(this).is(":checked")){
            $(".claim_check").prop("checked",true);
        }else{
            $(".claim_check").prop("checked",false);
        }
        claimCal();
    })

    $("#service_display").click(function(){
        if($(this).is(":checked")){
            $(".payment_tr").each(function(){
                if($(this).data("price") == "0"){
                    $(this).hide();
                }
            })
        }else{
            $(".payment_tr").show();
        }
    })
    $(".detailView").click(function(){

        var seq = $(this).data("seq")
        var url = "/api/memberPaymentView/"+seq
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                // console.log(response);
                console.log(response.sva_seq);
                if(response.sva_seq == "" || response.sva_seq === null){
                    $("#sv_code").text(response.sv_code);
                    $("#pc_name").text(response.pc_name);
                    $("#pr_name").text(response.pr_name);
                    $("#ps_name").text(response.ps_name);
                    $("#sv_number").text(response.sv_number)
                }else{
                    $("#sv_code").text(response.sv_code);
                    $("#pc_name").text(response.pi_name+" - 부가항목");
                    $("#pr_name").text(response.sva_name);
                    $("#ps_name").text(response.sv_number);
                }
                $(".sv_seq").val(response.sv_seq);
                $("#sv_claim_name").val(response.sv_claim_name);
                $("#sv_bill_name").val(response.sv_bill_name);
                $("#sv_payment_type").val(response.sv_payment_type).trigger("change");
                $("#sv_payment_period").val(response.sv_payment_period);
                $("#sv_pay_type").val(response.sv_pay_type).trigger("change");
                $("#sv_pay_day").val(response.sv_pay_day).trigger("change");
                $("#sv_pay_publish").val(response.sv_pay_publish).trigger("change");
                $("#sv_pay_publish_type").val(response.sv_pay_publish_type).trigger("change");
                $("#sv_payment_day").val(response.sv_payment_day);
                $("#sv_account_start").val(response.sv_account_start);
                $("#sv_account_end").val(response.sv_account_end);
                $("#sv_c_name").val(response.c_name);
                $("#sv_register_discount").val(response.sv_register_discount)
                $("#sv_input_price").val(response.sv_input_price);
                $("#first_price").val(response.ap_once_price);
                $("#first_dis_price").val(response.ap_once_dis_price);
                var first_sum = response.ap_once_price-response.ap_once_dis_price;
                var first_surtax = first_sum*0.1;
                $("#first_sum").html($.number(first_sum));
                $("#first_surtax").html( $.number(Math.round(first_surtax)) )
                $("#first_total").html($.number(first_sum+Math.round(first_surtax)));
                $("#service_month_price").val(response.ap_price);
                $("#service_month_dis_price").val(response.ap_dis_price);
                var month_price = response.ap_price-response.ap_dis_price;
                var period_price = month_price*response.sv_payment_period;
                var discount_price = 0;
                $("#month_price1").html($.number(month_price));
                $("#month_price2").html($.number(period_price));
                $("#month_price3").html($.number(discount_price));

                $("#month_price4").html(period_price-discount_price);
                var total_surtax = (period_price-discount_price)*0.1;
                $("#month_price5").html($.number(total_surtax));
                $("#month_price_total").html(period_price-discount_price+total_surtax);
                $(".total_contract").html(response.sv_payment_period);


                if(response.sv_pay_format == "1"){
                    var text_format = "1의 자리";
                }else if(response.sv_pay_format == "2"){
                    var text_format = "10의 자리";
                }else if(response.sv_pay_format == "3"){
                    var text_format = "100의 자리";
                }else if(response.sv_pay_format == "4"){
                    var text_format = "1000의 자리";
                }

                if(response.sv_pay_format_policy == "1"){
                    var text_format2 = "내림";
                }else if(response.sv_pay_format_policy == "2"){
                    var text_format2 = "올림";
                }else if(response.sv_pay_format_policy == "3"){
                    var text_format2 = "반올림";
                }

                if(response.sv_basic_type == "1"){
                    if(response.sv_policy == "1"){
                        var text = "당월분 일할 계산";
                    }else{
                        var text = response.sv_pay_start_day+"일(과금시작) 이후 건 익월분 통합";
                    }
                    var html = '<div class="input"><span id="policy_text"><span id="policy_text1">'+text+'</span> (<span id="policy_text2">'+text_format+' '+text_format2+'</span>)</span> <span id="policy_text_2" style="display:none"></span> <button class="btn btn-brown" type="button" onclick=\'$( "#dialogFirstSetting" ).dialog("open");$("#dialogFirstSetting").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();\'>변경</button></div>';
                }else{

                    var html = '<div class="input"><span id="policy_text" style="display:none"><span id="policy_text1">당월분 일할 계산</span> (<span id="policy_text2">'+text_format+' '+text_format2+'</span>)</span> <span id="policy_text_2">과금 시작일 기준 결제 주기로 처리</span> <button class="btn btn-brown" type="button" onclick=\'$( "#dialogFirstSetting" ).dialog("open");$("#dialogFirstSetting").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();\'>변경</button></div>';
                }
                $("#policy").html(html);

                $("#sv_account_type").val(response.sv_account_type);
                $("#sv_account_policy").val(response.sv_account_policy);
                $("#sv_account_start_day").val(response.sv_account_start_day);
                $("#sv_account_format").val(response.sv_account_format);
                $("#sv_account_format_policy").val(response.sv_account_format_policy);

                $("input:radio[name='sp_basic_type'][value='"+response.sv_account_type+"']").prop("checked",true);
                $("input:radio[name='sp_policy'][value='"+response.sv_account_policy+"']").prop("checked",true);
                $("#sp_pay_start_day").val(response.sv_account_start_day).trigger("change");
                $("#sp_pay_format").val(response.sv_account_format).trigger("change");
                $("#sp_pay_format_policy").val(response.sv_account_format_policy).trigger("change");
                $('#dialog').dialog({
                    title: '서비스 요금 상세',
                    modal: true,
                    width: '800px',
                    draggable: true
                });
            }
        });
    })

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

    $("body").on("click",".option_extend",function(){
        var seq = $(this).data("seq");
        // console.log($(this).text());
        if($(this).text() == " + "){
            $("#child_add_"+seq).show();
            $(this).text(" - ");
            var oneprice = $(this).parent().find(".oneprice").data("oneprice");
            var monthprice = $(this).parent().find(".monthprice").data("oneprice");
            $(this).parent().find(".oneprice").html(oneprice);
            $(this).parent().find(".monthprice").html(monthprice);
            var url = "/api/serviceAddList/"+seq;
            if($(".child_add_content_"+seq).length > 0){
                $(".child_add_content_"+seq).show();
            }else{
                $.ajax({
                    url : url,
                    type : 'GET',
                    dataType : 'JSON',
                    success:function(response){
                        console.log(response);
                        var html = "";
                        if($(".basic").css("display") != "none"){
                            var col = "14";

                        }else{
                            var col = "10";

                        }
                        for(var i = 0; i < response.length;i++){
                            html += '<tr class="child_add_content_'+seq+'" style="border:0px">\
                                        <td colspan='+col+' class="addcol2"></td>\
                                        <td style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_name+'</td>\
                                        <td class="basic" style="border-bottom: 1px solid #d9d9d9"></td>\
                                        <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                        <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                        <td style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_number+'</td>\
                                        <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9" >'+response[i].sva_claim_name+'</td>\
                                        <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].svp_first_price+'</td>\
                                        <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+(response[i].svp_month_price-response[i].svp_month_dis_price-response[i].svp_discount_price)+'</td>\
                                        <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_pay_day+'</td>\
                                        <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_input_price+'</td>\
                                        <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_input_unit+'</td>\
                                        <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].c_name+'</td>\
                                        <td style="border-bottom: 1px solid #d9d9d9">'+moment(response[i].sv_regdate).format("YYYY-MM-DD")+'<br></td>\
                                        <td style="border-bottom: 1px solid #d9d9d9" class="basic">'+response[i].sva_input_date+'</td>\
                                        <td style="border-bottom: 1px solid #d9d9d9">등록</td>\
                                        <td style="border-bottom: 1px solid #d9d9d9">'+moment(response[i].sv_account_start).format("YYYY-MM-DD")+'<br>'+moment(response[i].sv_account_end).format("YYYY-MM-DD")+'</td>\
                                        <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                        <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                    </tr>';
                        }
                        $("#child_add_"+seq).after(html);
                        if($(".payment1").css("display") != "none"){
                            $(".payment2").show();
                        }
                    }
                });
            }
        }else{
            $("#child_add_"+seq).hide();
            $(".child_add_content_"+seq).hide();
            $(this).text(" + ");
            var oneprice = $(this).parent().find(".oneprice").data("allprice");
            var monthprice = $(this).parent().find(".monthprice").data("allprice");
            $(this).parent().find(".oneprice").html(oneprice);
            $(this).parent().find(".monthprice").html(monthprice);
        }


    })
    $("#pm_service_price").keyup(function(){
        if($("#pm_service_dis_price").val() > 0){
            var price = parseInt($(this).val()) - parseInt($("#pm_service_dis_price").val());
            $("#once_price_info").html(price+"원");
            $("#once_surtax_info").html((price*0.1)+"원");
            if($("#pm_surtax_type").val() == "0"){
                $("#once_total_price").html( (price+(price*0.1))+"원" );
            }else{
                $("#once_total_price").html( price+"원" );
            }
        }
    })

    $("#pm_service_dis_price").keyup(function(){
        if($("#pm_service_price").val() > 0){
            var price = parseInt($("#pm_service_price").val()) - parseInt($(this).val());
            $("#once_price_info").html(price+"원");
            $("#once_surtax_info").html((price*0.1)+"원");
            if($("#pm_surtax_type").val() == "0"){
                $("#once_total_price").html( (price+(price*0.1))+"원" );
            }else{
                $("#once_total_price").html( price+"원" );
            }
        }
    })

    $("#pm_surtax_type").change(function(){
        if($(this).val() == 0){
            if($("#pm_service_price").val() > 0 && $("#pm_service_dis_price").val() > 0 ){
                var price = parseInt($("#pm_service_price").val()) - parseInt($("#pm_service_dis_price").val());

                $("#once_total_price").html( (price+(price*0.1))+"원" );

            }
        }else{
            if($("#pm_service_price").val() > 0 && $("#pm_service_dis_price").val() > 0 ){
                var price = parseInt($("#pm_service_price").val()) - parseInt($("#pm_service_dis_price").val());

                $("#once_total_price").html( price+"원" );

            }
        }
    });

    $(".btn-once-reg").click(function(){
        var url = "/api/paymentOnceAdd";
        var datas = $("#onceInput").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                console.log(response);
                // document.location.reload();
            }
        });
    });

    $(".btn-payment-modify").click(function(){
        var url = "/api/serviceUpdate";
        var datas = $("#serviceUpdate").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                console.log(response);
                // document.location.reload();
            },
            error:function(error){
                console.log(error);
            }
        });
    })

    $(".btn-check-delete").click(function(){
        var checkDelete = new Array();
        $(".claim_check").each(function(){
            if($(this).is(":checked")){
                checkDelete.push($(this).val());
            }
        });
        if(checkDelete.length == 0){
            alert("삭제할 내역을 선택해 주시기 바랍니다.");
            return false;
        }
        if(confirm("삭제 시 복구할 수 없습니다. 정말 삭제 하시겠습니까?")){
            var url = "/api/paymentDelete/";
            console.log(checkDelete);
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "pm_seq="+checkDelete.join(","),
                success:function(response){
                    console.log(response);
                    // document.location.reload();
                },
                error : function(error){
                    console.log(error);
                }
            });
        }
    });

    $(".claimView").click(function(){
        $( "#dialogClaim" ).dialog("open");$("#dialogClaim").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
    });

    $(".billView").click(function(){
        $( "#dialogBill" ).dialog("open");$("#dialogBill").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
    });

    $(".btn-claim-reg").click(function(){
        if(confirm("수정하시겠습니까?")){
            var url = "/api/paymentClaimUpdate";
            var datas = $("#claimEdit").serialize();
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    alert("수정완료");
                    $('#dialogClaim').dialog('close');
                    // document.location.reload();
                },
                error : function(error){
                    console.log(error);
                }
            });
        }
    })

    $(".btn-bill-reg").click(function(){
        if(confirm("수정하시겠습니까?")){
            var url = "/api/paymentClaimUpdate";
            var datas = $("#billEdit").serialize();
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    alert("수정완료");
                    $('#dialogBill').dialog('close');
                    // document.location.reload();
                },
                error : function(error){
                    console.log(error);
                }
            });
        }
    })

    $(".btn-com").click(function(){
        var checkDelete = new Array();
        $(".claim_check").each(function(){
            if($(this).is(":checked")){
                checkDelete.push($(this).val());
            }
        });
        if(checkDelete.length == 0){
            alert("가결제 처리할 내역을 선택해 주시기 바랍니다.");
            return false;
        }
        $("#input_pm_seq").val(checkDelete.join(","));
        $( "#dialogInput" ).dialog("open");$("#dialogInput").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
        // if(confirm("삭제 시 복구할 수 없습니다. 정말 삭제 하시겠습니까?")){
        //     var url = "/api/paymentDelete/";
        //     console.log(checkDelete);
        //     $.ajax({
        //         url : url,
        //         type : 'GET',
        //         dataType : 'JSON',
        //         data : "pm_seq="+checkDelete.join(","),
        //         success:function(response){
        //             console.log(response);
        //             // document.location.reload();
        //         },
        //         error : function(error){
        //             console.log(error);
        //         }
        //     });
        // }
    })

    $(".btn-input-date").click(function(){
        if(confirm("작성 날짜로 가결제 처리하시겠습니까?")){
            var url = "/api/paymentInput";
            var datas = $("#pmInputForm").serialize();
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    alert("처리되었습니다.");
                    $('#dialogInput').dialog('close');
                    // document.location.reload();
                },
                error : function(error){
                    console.log(error);
                }
            });
        }
    })

    $(".detailPView").click(function(){
        var seq = $(this).data("seq")
        var url = "/api/paymentView/"+seq

        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                console.log(response);
                // console.log(response.sva_seq);

                $("#p_pm_sv_code").text(response.sv_code);
                $("#p_pm_pc_name").text(response.pc_name);
                $("#p_pm_pr_name").text(response.pr_name);
                $("#p_pm_ps_name").text(response.ps_name);
                $("#p_pm_sv_number").text(response.sv_number)

                $(".sv_seq").val(response.sv_seq);
                $("#p_pm_claim_name").html(response.sv_claim_name);
                $("#p_pm_bill_name").html(response.sv_bill_name);
                $("#p_pm_payment_type").val(response.pm_payment_type).trigger("change");
                $("#p_pm_payment_period").html(response.pm_pay_period+"개월");
                $("#p_pm_pay_type").val(response.pm_pay_type).trigger("change");
                $("#p_pm_pay_day").html(response.sv_pay_day+"개월");
                if(response.sv_pay_publish_type == "0"){
                    $("#p_pm_payment_publish").html("영수발행");
                }else{
                    $("#p_pm_payment_publish").html("청구발행");
                }
                $("#p_pm_end_date").html(response.pm_end_date);
                // $("#p_pm_pay_publish_type").html(response.sv_pay_publish_type);
                $("#p_pm_payment_day").val(response.sv_payment_day);
                $("#p_pm_payment_start").val(response.pm_service_start);
                $("#p_pm_payment_end").val(response.pm_service_end);
                // $("#p_pm_c_name").val(response.c_name);
                // $("#p_pm_register_discount").val(response.sv_register_discount)
                $("#p_pm_input_price").val(response.sv_input_price);
                $("#p_pm_first_price").val(response.ap_once_price);
                $("#p_pm_first_dis_price").val(response.ap_once_dis_price);
                var first_sum = response.ap_once_price-response.ap_once_dis_price;
                var first_surtax = first_sum*0.1;
                $("#first_sum").html($.number(first_sum));
                $("#first_surtax").html( $.number(Math.round(first_surtax)) )
                $("#first_total").html($.number(first_sum+Math.round(first_surtax)));
                $("#service_month_price").val(response.ap_price);
                $("#service_month_dis_price").val(response.ap_dis_price);
                var month_price = response.ap_price-response.ap_dis_price;
                var period_price = month_price*response.sv_payment_period;
                var discount_price = 0;
                $("#month_price1").html($.number(month_price));
                $("#month_price2").html($.number(period_price));
                $("#month_price3").html($.number(discount_price));

                $("#month_price4").html(period_price-discount_price);
                var total_surtax = (period_price-discount_price)*0.1;
                $("#month_price5").html($.number(total_surtax));
                $("#month_price_total").html(period_price-discount_price+total_surtax);
                $(".total_contract").html(response.sv_payment_period);


                if(response.sv_pay_format == "1"){
                    var text_format = "1의 자리";
                }else if(response.sv_pay_format == "2"){
                    var text_format = "10의 자리";
                }else if(response.sv_pay_format == "3"){
                    var text_format = "100의 자리";
                }else if(response.sv_pay_format == "4"){
                    var text_format = "1000의 자리";
                }

                if(response.sv_pay_format_policy == "1"){
                    var text_format2 = "내림";
                }else if(response.sv_pay_format_policy == "2"){
                    var text_format2 = "올림";
                }else if(response.sv_pay_format_policy == "3"){
                    var text_format2 = "반올림";
                }

                if(response.sv_basic_type == "1"){
                    if(response.sv_policy == "1"){
                        var text = "당월분 일할 계산";
                    }else{
                        var text = response.sv_pay_start_day+"일(과금시작) 이후 건 익월분 통합";
                    }
                    var html = '<div class="input"><span id="policy_text"><span id="policy_text1">'+text+'</span> (<span id="policy_text2">'+text_format+' '+text_format2+'</span>)</span> <span id="policy_text_2" style="display:none"></span> <button class="btn btn-brown" type="button" onclick=\'$( "#dialogFirstSetting" ).dialog("open");$("#dialogFirstSetting").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();\'>변경</button></div>';
                }else{

                    var html = '<div class="input"><span id="policy_text" style="display:none"><span id="policy_text1">당월분 일할 계산</span> (<span id="policy_text2">'+text_format+' '+text_format2+'</span>)</span> <span id="policy_text_2">과금 시작일 기준 결제 주기로 처리</span> <button class="btn btn-brown" type="button" onclick=\'$( "#dialogFirstSetting" ).dialog("open");$("#dialogFirstSetting").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();\'>변경</button></div>';
                }
                $("#policy").html(html);

                $("#sv_account_type").val(response.sv_account_type);
                $("#sv_account_policy").val(response.sv_account_policy);
                $("#sv_account_start_day").val(response.sv_account_start_day);
                $("#sv_account_format").val(response.sv_account_format);
                $("#sv_account_format_policy").val(response.sv_account_format_policy);

                $("input:radio[name='sp_basic_type'][value='"+response.sv_account_type+"']").prop("checked",true);
                $("input:radio[name='sp_policy'][value='"+response.sv_account_policy+"']").prop("checked",true);
                $("#sp_pay_start_day").val(response.sv_account_start_day).trigger("change");
                $("#sp_pay_format").val(response.sv_account_format).trigger("change");
                $("#sp_pay_format_policy").val(response.sv_account_format_policy).trigger("change");
                $('#dialogPay').dialog({
                    title: '서비스 요금 상세',
                    modal: true,
                    width: '800px',
                    draggable: true
                });
            }
        });
    });

    $(".btn-payment_modify").click(function(){
        if(confirm("수정 처리하시겠습니까?")){
            var url = "/api/paymentUpdate";
            var datas = $("#payForm").serialize();
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    alert("처리되었습니다.");
                    // $('#dialogInput').dialog('close');
                    // document.location.reload();
                },
                error : function(error){
                    console.log(error);
                }
            });
        }
    })
})
var basic_date_info = [];
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

    contractPriceDateInfo();
}

function contractPriceDateInfo(){
    if(basic_date_info.length == 1){
        if(basic_date_info[0].interval == "day"){
            var date_array = basic_date_info[0].end_date.split("-");

            var month_total_date = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            // var one_day_price = parseInt($("#sp_month_total_price").val())/month_total_date;
            // var total_price = one_day_price*basic_date_info[0].period;

            var month_price = parseInt($("#sv_month_price").val())/parseInt($("#sv_payment_period").val());
            var dis_price = parseInt($("#sv_month_dis_price").val());
            var dis_per = parseInt($("#sv_register_discount").val());
            var period_day = parseInt(basic_date_info[0].period);

            if($("#sv_discount_yn").is(":checked")){
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

            $("#use_price_str_0_1").html($.number(price));
            basic_date_info[0].price = price;
        }else{
            $("#use_price_str_0_1").html($.number($("#sv_month_total_price").val()));
            basic_date_info[0].price = $("#sv_month_total_price").val();
        }

    }else if(basic_date_info.length == 2){
        var date_array = basic_date_info[0].end_date.split("-");

        var month_total_date = ( new Date( date_array[0], date_array[1], 0) ).getDate();
            // var one_day_price = parseInt($("#sp_month_total_price").val())/month_total_date;
            // var total_price = one_day_price*basic_date_info[0].period;

        var month_price = parseInt($("#sv_month_price").val())/parseInt($("#sv_payment_period").val());
        var dis_price = parseInt($("#sv_month_dis_price").val());
        var dis_per = parseInt($("#sv_register_discount").val());
        var period_day = parseInt(basic_date_info[0].period);
        // console.log(month_total_date+"::"+period_day);
        // console.log(period_day);
        if($("#sv_discount_yn").is(":checked")){
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
    }
    var totalprice = 0;
    totalprice = parseInt(totalprice) + parseInt($("#sv_once_total_price").val()) || 0;
    for(var i = 0; i < basic_date_info.length;i++){
        totalprice = parseInt(totalprice) + parseInt(basic_date_info[i].price);
    }

    $("#total_str0").data("price",totalprice);
    $("#total_str0").html($.number(totalprice));
}
function viewAll(){
    $(".payment-basic").show();
}

function viewAll2(){
    $(".claim_payment").show();
}

function oncePayment(){
    var checkCnt = 0;
    $(".payment_check").each(function(){
        if($(this).is(":checked")){
            checkCnt++;
        }
    })
    if(checkCnt == 0){
        alert("서비스를 선택해 주세요");
        return false;
    }

    if(checkCnt > 1){
        alert("서비스를 하나만 선택해 주세요");
        return false;
    }
    $(".payment_check").each(function(){
        if($(this).is(":checked")){
            $("#pm_sv_seq").val($(this).val())
            $("#once_service").html($(this).parent().parent().children(".once_service").html());
            $("#once_number").html($(this).parent().parent().children(".once_number").text());
            $("#once_product").html($(this).parent().parent().children(".once_product").text());
            $("#once_service_number").html($(this).parent().parent().children(".once_service_number").text());
        }
    })
    $( "#dialogOnce" ).dialog("open");$("#dialogOnce").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
}

function servicePayment(){
    var checkCnt = 0;
    $(".payment_check").each(function(){
        if($(this).is(":checked")){
            checkCnt++;
        }
    })
    if(checkCnt == 0){
        alert("서비스를 선택해 주세요");
        return false;
    }

    if(checkCnt > 1){
        alert("서비스를 하나만 선택해 주세요");
        return false;
    }
    // $( "#dialogService" ).dialog("open");$("#dialogOnce").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
}

function memberUpdate1(mb_seq){
    var url = "/api/memberUpdate1/"+mb_seq;
    var datas = $("#update1").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            document.location.reload();
        }
    });
}

function memberUpdate2(mb_seq){
    var url = "/api/memberUpdate2/"+mb_seq;
    var datas = $("#update2").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            document.location.reload();
        }
    });
}

function memberUpdate3(mb_seq){
    var url = "/api/memberUpdate3/"+mb_seq;
    var datas = $("#update3").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            document.location.reload();
        }
    });
}

function memberUpdate4(mb_seq){
    var url = "/api/memberUpdate4/"+mb_seq;
    var datas = $("#update4").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            document.location.reload();
        }
    });
}

function memberUpdate5(mb_seq){
    var url = "/api/memberUpdate5/"+mb_seq;
    var datas = $("#update5").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            document.location.reload();
        }
    });
}

function memberUpdate6(mb_seq){
    var url = "/api/memberUpdate6/"+mb_seq;
    var datas = $("#update6").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            document.location.reload();
        }
    });
}

function openPopup(mb_seq){
    var specs = "left=10,top=10,width=1000,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/member/payment_setting/"+mb_seq, specs);
}
function paymentCal(){
    var price1 = 0;
    var price2 = 0;
    var price3 = 0;
    var price4 = 0;
    var price5 = 0;
    var price6 = 0;
    var price7 = 0;
    var price8 = 0;
    var price9 = 0;
    $(".payment_check").each(function(){
        var sumprice1 = parseInt($(this).data("price1")) || 0;
        var sumprice2 = parseInt($(this).data("price2")) || 0;
        var sumprice3 = parseInt($(this).data("price3")) || 0;
        var sumprice4 = parseInt($(this).data("price4")) || 0;
        var sumprice5 = parseInt($(this).data("price5")) || 0;
        var sumprice6 = parseInt($(this).data("price6")) || 0;
        var sumprice7 = parseInt($(this).data("price7")) || 0;
        var sumprice8 = parseInt($(this).data("price8")) || 0;
        var sumprice9 = parseInt($(this).data("price9")) || 0;

        price1 = price1 + sumprice1;
        price2 = price2 + sumprice2;
        price3 = price3 + sumprice3;
        price4 = price4 + sumprice4;
        price5 = price5 + sumprice5;
        price6 = price6 + sumprice6;
        price7 = price7 + sumprice7;
        price8 = price8 + sumprice8;
        price9 = price9 + sumprice9;
    })
    $(".payment_price1").html($.number(price1));
    $(".payment_price2").html($.number(price2));
    $(".payment_price3").html($.number(price3));
    $(".payment_price4").html($.number(price4));
    $(".payment_price5").html($.number(price5));
    $(".payment_price6").html($.number(price6));
    $(".payment_price7").html($.number(price7));
    $(".payment_price8").html($.number(price8));
    $(".payment_price9").html($.number(price9));
}

function claimCal(){
    var price1 = 0;
    var price2 = 0;
    var price3 = 0;
    var price4 = 0;
    var price5 = 0;
    var price6 = 0;
    var price7 = 0;
    var price8 = 0;
    var price9 = 0;
    var price10 = 0;
    var price11 = 0;
    var price12 = 0;
    $(".claim_check").each(function(){
        var sumprice1 = parseInt($(this).data("price1")) || 0;
        var sumprice2 = parseInt($(this).data("price2")) || 0;
        var sumprice3 = parseInt($(this).data("price3")) || 0;
        var sumprice4 = parseInt($(this).data("price4")) || 0;
        var sumprice5 = parseInt($(this).data("price5")) || 0;
        var sumprice6 = parseInt($(this).data("price6")) || 0;
        var sumprice7 = parseInt($(this).data("price7")) || 0;
        var sumprice8 = parseInt($(this).data("price8")) || 0;
        var sumprice9 = parseInt($(this).data("price9")) || 0;
        var sumprice10 = parseInt($(this).data("price10")) || 0;
        var sumprice11 = parseInt($(this).data("price11")) || 0;
        var sumprice12 = parseInt($(this).data("price12")) || 0;

        price1 = price1 + sumprice1;
        price2 = price2 + sumprice2;
        price3 = price3 + sumprice3;
        price4 = price4 + sumprice4;
        price5 = price5 + sumprice5;
        price6 = price6 + sumprice6;
        price7 = price7 + sumprice7;
        price8 = price8 + sumprice8;
        price9 = price9 + sumprice9;
        price10 = price10 + sumprice10;
        price11 = price11 + sumprice11;
        price12 = price12 + sumprice12;
    })
    $(".claim_price1").html($.number(price1));
    $(".claim_price2").html($.number(price2));
    $(".claim_price3").html($.number(price3));
    $(".claim_price4").html($.number(price4));
    $(".claim_price5").html($.number(price5));
    $(".claim_price6").html($.number(price6));
    $(".claim_price7").html($.number(price7));
    $(".claim_price8").html($.number(price8));
    $(".claim_price9").html($.number(price9));
    $(".claim_price10").html($.number(price10));
    $(".claim_price11").html($.number(price11));
    $(".claim_price12").html($.number(price12));
}