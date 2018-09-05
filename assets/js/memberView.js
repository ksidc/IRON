
$(function(){


    $( "#dialogFirstSetting" ).dialog({
        autoOpen: false,
        modal: true,
        width:'700px',
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
    $(".detailView").click(function(){
        var specs = "left=10,top=10,width=900,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/member/payment_view/"+$(this).data("seq"), 'serviceMake', specs);
    });
})

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