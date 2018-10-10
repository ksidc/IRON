
$(function(){
    getPaymentList();

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

    $( "#dialogInput" ).dialog({
        autoOpen: false,
        modal: true,
        width:'500px',
        height : 400
    });

    $( "#dialogMemo" ).dialog({
        autoOpen: false,
        modal: true,
        width:'700px',
        height : 400
    });

    $( "#dialogBill" ).dialog({
        autoOpen: false,
        modal: true,
        width:'720px',
        height : 695
    });

    $( "#dialogClaim" ).dialog({
        autoOpen: false,
        modal: true,
        width:'720px',
        height : 645
    });

    $('#dialogEmail').dialog({
        autoOpen: false,
        title: '이메일 발송',
        modal: true,
        width: '800px',
        draggable: true
    });

    $('#summernote').summernote({
        placeholder: '',
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
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
    $("#paycom_all").click(function(){
        if($(this).is(":checked")){
            $(".paycom_check").prop("checked",true);
        }else{
            $(".paycom_check").prop("checked",false);
        }
        paycomCal();
    })

    $(".payment_check").click(function(){
        // alert(1);
        paymentCal();
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
    $("#all_payment").trigger("click");


    $("body").on("click",".option_extend",function(){
            var seq = $(this).data("seq");
            // console.log($(this).text());
            if($(this).text() == " + "){
                $("#child_add_"+seq).show();
                $(this).text(" - ");
                var oneprice = $(this).parent().find(".oneprice").data("oneprice");
                var monthprice = $(this).parent().find(".monthprice").data("oneprice");
                $(this).parent().find(".oneprice").html($.number(oneprice)+" 원");
                $(this).parent().find(".monthprice").html($.number(monthprice)+" 원");
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
                                var col = "13";

                            }else{
                                var col = "9";

                            }
                            $(".child_add_content_"+seq).remove();

                            for(var i = 0; i < response.length;i++){
                                if(response[i].sv_status == "0"){
                                    var sv_status = '입금대기중';
                                }else if(response[i].sv_status == "1"){
                                    var sv_status = '서비스준비중';
                                }else if(response[i].sv_status == "2"){
                                    var sv_status = '서비스작업중';
                                }else if(response[i].sv_status == "3"){
                                    var sv_status = '서비스중';
                                }else if(response[i].sv_status == "4"){
                                    var sv_status = '서비스중지';
                                }else if(response[i].sv_status == "5"){
                                    var sv_status = '서비스해지';
                                }else if(response[i].sv_status == "6"){
                                    var sv_status = '직권중지';
                                }else if(response[i].sv_status == "7"){
                                    var sv_status = '직권해지';
                                }
                                // console.log(response[i].paymentinfo);
                                if(response[i].paymentinfo !== null){
                                    var paymentinfo = response[i].paymentinfo.split("|");
                                }else{
                                    var paymentinfo = [];
                                }

                                var pm_status = paymentinfo[0];
                                var pm_pay_period = paymentinfo[1];
                                var pm_date = paymentinfo[2];
                                var pm_end_date = paymentinfo[3];
                                var pm_input_date = paymentinfo[4];

                                if(pm_status == "0"){
                                    if(pm_pay_period > 1){
                                        var custom_end_date = moment(pm_date).add(1,'months').format("YYYY-MM-DD");
                                        if(moment().format("YYYY-MM-DD") >= custom_end_date){
                                            var payment_status = "연체";
                                        }else{
                                            if(pm_end_date >= moment().format("YYYY-MM-DD")){
                                                var payment_status = "청구("+pm_pay_period+"개월)";
                                            }else{
                                                var payment_status = "미납("+pm_pay_period+"개월)";
                                            }
                                        }
                                    }else{
                                        // 연체 로직 추가
                                        if(pm_end_date >= moment().format("YYYY-MM-DD")){
                                            var payment_status = "청구("+pm_pay_period+"개월)";
                                        }else{
                                            var payment_status = "미납("+pm_pay_period+"개월)";
                                        }

                                    }
                                }else if(pm_status == "1"){
                                    var payment_status = "가결제("+pm_pay_period+"개월) " +pm_input_date
                                }else{
                                    var payment_status = "완납";
                                }

                                html += '<tr class="child_add_content_'+seq+'" style="border:0px">\
                                            <td colspan='+col+' class="addcol2"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9;text-align:left;padding-left:30px;" colspan=2>'+response[i].sva_name+'</td>\
                                            <td class="basic" style="border-bottom: 1px solid #d9d9d9"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_number+'</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9" >'+response[i].sva_claim_name+'</td>\
                                            <td class="payment payment2 right" style="border-bottom: 1px solid #d9d9d9">'+$.number(response[i].svp_once_price - response[i].svp_once_dis_price)+' 원</td>\
                                            <td class="payment payment2 right" style="border-bottom: 1px solid #d9d9d9">'+$.number(response[i].svp_month_price-response[i].svp_month_dis_price-(response[i].svp_discount_price/response[i].svp_payment_period))+' 원</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].svp_payment_period+'</td>\
                                            <td class="payment payment2 right" style="border-bottom: 1px solid #d9d9d9">'+$.number(response[i].sva_input_price)+' 원</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+(response[i].sva_input_unit != "" ? response[i].sva_input_unit:"1")+'개월</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].c_name+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+moment(response[i].sv_regdate).format("YYYY-MM-DD")+'<br>'+(response[i].sv_service_start !== null ? response[i].sv_service_start.substring(0,10):'')+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9" class="basic">'+response[i].sva_input_date+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+sv_status+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+moment(response[i].sv_account_start).format("YYYY-MM-DD")+'<br>'+moment(response[i].sv_account_end).format("YYYY-MM-DD")+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+payment_status+'</td>\
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
                $(this).parent().find(".oneprice").html($.number(oneprice));
                $(this).parent().find(".monthprice").html($.number(monthprice));
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
                if(response.result){
                    alert("청구 완료");
                    document.location.reload();
                }
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
                if(response.result){
                    alert("수정 완료");
                    document.location.reload();
                }
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
        }
    });

    $(".btn-paycomcheck-delete").click(function(){
        var checkDelete = new Array();
        $(".paycom_check").each(function(){
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
        }
    });
    
    $(".claimView").click(function(){

        var url = "/api/claimView/"+$(this).data("seq");
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                console.log(response);

                $("#ca_seq").val(response.info.ca_seq);
                $("#ca_from_number").val(response.info.ca_from_number);
                $("#ca_to_number").val(response.info.ca_to_number);
                $("#ca_from_name").val(response.info.ca_from_name);
                $("#ca_from_ceo").val(response.info.ca_from_ceo);
                $("#ca_to_name").val(response.info.ca_to_name);
                $("#ca_to_ceo").val(response.info.ca_to_ceo);
                $("#ca_from_address").val(response.info.ca_from_address);
                $("#ca_to_address").val(response.info.ca_to_address);
                $("#ca_from_condition").val(response.info.ca_from_condition);
                $("#ca_from_type").val(response.info.ca_from_type);
                $("#ca_to_condition").val(response.info.ca_to_condition);
                $("#ca_to_type").val(response.info.ca_to_type);
                $("#ca_from_team").val(response.info.ca_from_team);
                $("#ca_from_charger").val(response.info.ca_from_charger);
                $("#ca_to_team").val(response.info.ca_to_team);
                $("#ca_to_charger").val(response.info.ca_to_charger);
                $("#ca_from_tel").val(response.info.ca_from_tel);
                $("#ca_to_tel").val(response.info.ca_to_tel);
                $("#ca_from_email").val(response.info.ca_from_email);
                $("#ca_to_email").val(response.info.ca_to_email);
                $("#ca_date").val(response.info.ca_date);
                $("#ca_empty_size").val(response.info.ca_empty_size);
                $("#ca_price").val(response.info.ca_price);
                $("#ca_surtax").val(response.info.ca_surtax);
                $("#ca_total_price").val(response.info.ca_total_price);
                $("#ca_price_info1").val(response.info.ca_price_info1);
                $("#ca_price_info2").val(response.info.ca_price_info2);
                $("#ca_price_info3").val(response.info.ca_price_info3);
                $("#ca_price_info4").val(response.info.ca_price_info4);
                $("#ca_price_info5").val(response.info.ca_price_info5);

                for(var i = 0; i < response.list.length;i++){
                    // console.log()
                    $("#cl_seq"+response.list[i].ca_sort).val(response.list[i].cl_seq);
                    $("#ca_item_date"+response.list[i].ca_sort).val(response.info.ca_monthday);
                    $("#ca_item_name"+response.list[i].ca_sort).val(response.list[i].ca_item_name);
                    $("#ca_item_price"+response.list[i].ca_sort).val(response.list[i].ca_item_price);
                    $("#ca_item_surtax"+response.list[i].ca_sort).val(response.list[i].ca_item_surtax);
                }
                $( "#dialogClaim" ).dialog("open");$("#dialogClaim").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
            },
            error : function(error){
                console.log(error);
            }
        });

    });

    $(".billView").click(function(){
        var publish_type = $(this).data("p_type");
        var url = "/api/claimView/"+$(this).data("seq");
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                console.log(response);
                if(publish_type == "0"){
                    $("#tax_title").html("작성");
                    var date1 = moment().format("YYYY-MM-DD");
                    var date2 = moment().format("MM-DD");
                    $(".btn-bill-reg").html("작성")
                }else{
                    $("#tax_title").html("수정");
                    var date1 = response.info.ca_date;
                    var date2 = response.info.ca_monthday;
                    $(".btn-bill-reg").html("수정")
                }

                $("#ba_seq").val(response.info.ca_seq);
                $("#ba_from_number").val(response.info.ca_from_number);
                $("#ba_to_number").val(response.info.ca_to_number);
                $("#ba_from_name").val(response.info.ca_from_name);
                $("#ba_from_ceo").val(response.info.ca_from_ceo);
                $("#ba_to_name").val(response.info.ca_to_name);
                $("#ba_to_ceo").val(response.info.ca_to_ceo);
                $("#ba_from_address").val(response.info.ca_from_address);
                $("#ba_to_address").val(response.info.ca_to_address);
                $("#ba_from_condition").val(response.info.ca_from_condition);
                $("#ba_from_type").val(response.info.ca_from_type);
                $("#ba_to_condition").val(response.info.ca_to_condition);
                $("#ba_to_type").val(response.info.ca_to_type);
                $("#ba_from_team").val(response.info.ca_from_team);
                $("#ba_from_charger").val(response.info.ca_from_charger);
                $("#ba_to_team").val(response.info.ca_to_team);
                $("#ba_to_charger").val(response.info.ca_to_charger);
                $("#ba_from_tel").val(response.info.ca_from_tel);
                $("#ba_to_tel").val(response.info.ca_to_tel);
                $("#ba_from_email").val(response.info.ca_from_email);
                $("#ba_to_email").val(response.info.ca_to_email);
                $("#ba_date").val(date1);
                $("#ba_empty_size").val(response.info.ca_empty_size);
                $("#ba_price").val(response.info.ca_price);
                $("#ba_surtax").val(response.info.ca_surtax);
                $("#ba_total_price").val(response.info.ca_total_price);
                $("#ba_price_info1").val(response.info.ca_price_info1);
                $("#ba_price_info2").val(response.info.ca_price_info2);
                $("#ba_price_info3").val(response.info.ca_price_info3);
                $("#ba_price_info4").val(response.info.ca_price_info4);
                $("#ba_price_info5").val(response.info.ca_price_info5);

                for(var i = 0; i < response.list.length;i++){
                    $("#bl_seq"+response.list[i].ca_sort).val(response.list[i].cl_seq);
                    $("#ba_item_date"+response.list[i].ca_sort).val(date2);
                    $("#ba_item_name"+response.list[i].ca_sort).val(response.list[i].ca_item_name);
                    $("#ba_item_price"+response.list[i].ca_sort).val(response.list[i].ca_item_price);
                    $("#ba_item_surtax"+response.list[i].ca_sort).val(response.list[i].ca_item_surtax);
                }

                $( "#dialogBill" ).dialog("open");$("#dialogBill").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
            },
            error : function(error){
                console.log(error);
            }
        });

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
                    document.location.reload();
                },
                error : function(error){
                    console.log(error);
                }
            });
        }
    })



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
    });

    $(".btn-basic-view").click(function(){
        if($(".basic").css("display") != "none"){
            $(".basic").hide();
            $(".addcol").attr("colspan",9);
            $(".addcol2").attr("colspan",10);
            $(this).html("확장하기(기본)");
        }else{
           $(".basic").show();
            $(".addcol").attr("colspan",13);
            $(".addcol2").attr("colspan",14);
            $(this).html("축소하기(기본)");
        }

    })

    $(".btn-payment-view").click(function(){
        if($(".payment").css("display") != "none"){
            $(".payment").hide();
            $(this).html("확장하기(요금)");
        }else{
            $(".payment").show();
            $(this).html("축소하기(요금)");
        }
    });
    $(".detailView").click(function(){
        var specs = "left=10,top=10,width=1000,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/member/payment_view/"+$(this).data("seq"), 'serviceMake', specs);
    });

    $(".detailPView").click(function(){
        var specs = "left=10,top=10,width=1000,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/member/claim_view/"+$(this).data("seq"), 'serviceMake', specs);
    });

    $(".detailCView").click(function(){
        var specs = "left=10,top=10,width=1000,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/member/paycom_view/"+$(this).data("seq"), 'serviceMake', specs);
    });

    $(".memo").click(function(){
        getPaymentMemo();
        $( "#dialogMemo" ).dialog("open");$("#dialogMemo").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
    })

    $(".btn-memo-reg").click(function(){
        if($("#po_seq").val() == ""){
            var url = "/api/paymentMemoAdd";
        }else{
            var url = "/api/paymentMemoUpdate";
        }

        var datas = $("#memoReg").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                alert("등록되었습니다.");
                getPaymentMemo();
                // $('#dialogInput').dialog('close');
                // document.location.reload();
            },
            error : function(error){
                console.log(error);
            }
        });
    });

    $("body").on("click",".memo_mode",function(){
        if($(this).data("edit") == "N"){
            $("#po_seq").val($(this).data("seq"));
            $("#po_input_date").val($(this).data("inputdate"));
            $("#po_memo").val($(this).data("memo"));
            $(".btn-memo-reg").html("수정");
            $(this).data("edit","Y");
        }else{
            $("#po_seq").val("");
            $("#po_input_date").val("");
            $("#po_memo").val("");
            $(".btn-memo-reg").html("등록");
            $(this).data("edit","N");
        }

    })

    $("body").on("click",".memo_del",function(){
        if(confirm("정말 삭제하시겠습니까?")){
            var url = "/api/paymentMemoDelete";
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "po_seq="+$(this).data("seq"),
                success:function(response){
                    alert("삭제되었습니다.");
                    getPaymentMemo();
                    // $('#dialogInput').dialog('close');
                    // document.location.reload();
                },
                error : function(error){
                    console.log(error);
                }
            });
        }
    });

    $(".btn-com-pay").click(function(){
        var checkDelete = new Array();
        $(".claim_check").each(function(){
            if($(this).is(":checked")){
                checkDelete.push($(this).data("caseq"));
            }
        });
        if(checkDelete.length == 0){
            alert("완납 처리할 내역을 선택해 주시기 바랍니다.");
            return false;
        }
        var uniq = checkDelete.reduce(function(a,b){
            if (a.indexOf(b) < 0 ) a.push(b);
            return a;
        },[]);
        // console.log(uniq);
        if(uniq.length > 1){
            alert("각각의 세금계산서 건별로 완납 처리가 가능합니다. 체크상태를 확인해 주세요");
            return false;
        }
        var data = [];
        var total;
        var publish;
        var ca_seq;
        $(".claim_check").each(function(){
            if($(this).is(":checked")){
                total = $(this).data("caseqcount");
                publish = $(this).data("publish");
                ca_seq = $(this).data("caseq");
                data.push($(this).val());
            }
        });
        // console.log(data);
        if(total != data.length && publish == "1"){
            alert("계산서가 청구발행인 서비스는 부분 완납 처리가 불가합니다. 체크 상태를 확인해 주세요");
            return false;
        }
        console.log(publish);
        if(publish == "1"){
            var url = "/api/paymentComPay";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "data="+data.join(","),
                success:function(response){
                    console.log(response);
                    if(response.result){
                        alert("완납 처리 되었습니다.");
                        document.location.reload();
                    }
                    // alert("삭제되었습니다.");
                    // getPaymentMemo();
                    // $('#dialogInput').dialog('close');
                    // document.location.reload();
                },
                error : function(error){
                    console.log(error);
                }
            });
        }else{ // 영수처리
            var url = "/api/paymentComPayPost";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "data="+data.join(",")+"&pm_total="+total,
                success:function(response){
                    if(confirm("완납 처리되었습니다. 계산서를 작성하겠습니까?")){
                        var publish_type = 0;
                        var url = "/api/claimView/"+ca_seq;
                        $.ajax({
                            url : url,
                            type : 'GET',
                            dataType : 'JSON',
                            success:function(response){
                                // console.log(response);
                                if(publish_type == "0"){
                                    $("#tax_title").html("작성");
                                    var date1 = moment().format("YYYY-MM-DD");
                                    var date2 = moment().format("MM-DD");
                                    $(".btn-bill-reg").html("작성")
                                }else{
                                    $("#tax_title").html("수정");
                                    var date1 = response.info.ca_date;
                                    var date2 = response.info.ca_monthday;
                                    $(".btn-bill-reg").html("수정")
                                }

                                $("#ba_seq").val(response.info.ca_seq);
                                $("#ba_from_number").val(response.info.ca_from_number);
                                $("#ba_to_number").val(response.info.ca_to_number);
                                $("#ba_from_name").val(response.info.ca_from_name);
                                $("#ba_from_ceo").val(response.info.ca_from_ceo);
                                $("#ba_to_name").val(response.info.ca_to_name);
                                $("#ba_to_ceo").val(response.info.ca_to_ceo);
                                $("#ba_from_address").val(response.info.ca_from_address);
                                $("#ba_to_address").val(response.info.ca_to_address);
                                $("#ba_from_condition").val(response.info.ca_from_condition);
                                $("#ba_from_type").val(response.info.ca_from_type);
                                $("#ba_to_condition").val(response.info.ca_to_condition);
                                $("#ba_to_type").val(response.info.ca_to_type);
                                $("#ba_from_team").val(response.info.ca_from_team);
                                $("#ba_from_charger").val(response.info.ca_from_charger);
                                $("#ba_to_team").val(response.info.ca_to_team);
                                $("#ba_to_charger").val(response.info.ca_to_charger);
                                $("#ba_from_tel").val(response.info.ca_from_tel);
                                $("#ba_to_tel").val(response.info.ca_to_tel);
                                $("#ba_from_email").val(response.info.ca_from_email);
                                $("#ba_to_email").val(response.info.ca_to_email);
                                $("#ba_date").val(date1);
                                $("#ba_empty_size").val(response.info.ca_empty_size);
                                $("#ba_price").val(response.info.ca_price);
                                $("#ba_surtax").val(response.info.ca_surtax);
                                $("#ba_total_price").val(response.info.ca_total_price);
                                $("#ba_price_info1").val(response.info.ca_price_info1);
                                $("#ba_price_info2").val(response.info.ca_price_info2);
                                $("#ba_price_info3").val(response.info.ca_price_info3);
                                $("#ba_price_info4").val(response.info.ca_price_info4);
                                $("#ba_price_info5").val(response.info.ca_price_info5);

                                for(var i = 0; i < response.list.length;i++){
                                    $("#ba_seq"+response.list[i].ca_sort).val(response.list[i].cl_seq);
                                    $("#ba_item_date"+response.list[i].ca_sort).val(date2);
                                    $("#ba_item_name"+response.list[i].ca_sort).val(response.list[i].ca_item_name);
                                    $("#ba_item_price"+response.list[i].ca_sort).val(response.list[i].ca_item_price);
                                    $("#ba_item_surtax"+response.list[i].ca_sort).val(response.list[i].ca_item_surtax);
                                }

                                $( "#dialogBill" ).dialog("open");$("#dialogBill").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
                            },
                            error : function(error){
                                console.log(error);
                            }
                        });
                    }
                },
                error : function(error){
                    console.log(error);
                }
            });
        }

    })

    $("#mb_auto_claim_yn").click(function(){
        if($(this).is(":checked")){
            var value_ = "Y";
        }else{
            var value_ = "N";
        }
        var url = "/api/memberAutoClaim";
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : "mb_seq="+$("#mb_seq").val()+"&mb_auto_claim_yn="+value_,
            success:function(response){
                console.log(response);
                // alert("삭제되었습니다.");
                // getPaymentMemo();
                // $('#dialogInput').dialog('close');
                // document.location.reload();
            },
            error : function(error){
                console.log(error);
            }
        });

    })

    $("#mb_auto_email_yn").click(function(){
        if($(this).is(":checked")){
            var value_ = "Y";
        }else{
            var value_ = "N";
        }
        var url = "/api/memberAutoEmail";
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : "mb_seq="+$("#mb_seq").val()+"&mb_auto_email_yn="+value_,
            success:function(response){
                console.log(response);
                // alert("삭제되었습니다.");
                // getPaymentMemo();
                // $('#dialogInput').dialog('close');
                // document.location.reload();
            },
            error : function(error){
                console.log(error);
            }
        });

    })

    $("#mb_over_pay_yn").click(function(){
        if($(this).is(":checked")){
            var value_ = "Y";
        }else{
            var value_ = "N";
        }
        var url = "/api/memberOverPay";
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : "mb_seq="+$("#mb_seq").val()+"&mb_over_pay_yn="+value_,
            success:function(response){
                console.log(response);
                // alert("삭제되었습니다.");
                // getPaymentMemo();
                // $('#dialogInput').dialog('close');
                // document.location.reload();
            },
            error : function(error){
                console.log(error);
            }
        });

    });

    $("#emailForm").submit(function(){
        if($("#from").val() == ""){
            alert("보내는 사람을 입력해 주세요");
            return false;
        }
        if($("#to").val() == ""){
            alert("받는 사람을 입력해 주세요");
            return false;
        }
        if($("#subject").val() == ""){
            alert("제목을 입력해 주세요");
            return false;
        }
        if($('#summernote').summernote('code') == ""){
            alert("내용을 입력해 주시기 바랍니다.");
            return false;
        }
        var url = "/api/sendEmail";
        $("#content").val($('#summernote').summernote('code'));
        // console.log($('#summernote').summernote('code'));
        // return false;
        var emailForm = $("#emailForm").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : emailForm,
            success:function(response){
                console.log(response);
            }

        });
    })

    $("body").on("click",".fileCount",function(){
        fileCheck();
    });

    $(".btn-addfile-delete").click(function(){
        if($(".add_file").length > 0){
            if(confirm("삭제 하시겠습니까?")){
                var checkSeq = [];
                $(".add_file").each(function(){
                    if($(this).prop("checked") == true){
                        var valueArray = $(this).val().split("|");

                        checkSeq.push(valueArray[0]);
                    }
                })
                var url = "/api/estimateEmailFileDelete";
                $.ajax({
                    url : url,
                    type : 'GET',
                    dataType : 'JSON',
                    data : "checkSeq="+checkSeq.join(","),
                    success:function(response){
                        // console.log(response);
                        if(response.result){
                            alert("삭제 완료");
                            $(".add_file").each(function(){
                                if($(this).prop("checked") == true){
                                    $(this).parent().remove();
                                }
                            })
                        }else{
                            alert("오류가 발생했습니다.");
                        }

                    },
                    error : function(error){
                        console.log(error);
                    }

                });

            }
        }
    });

    $(".btn-mail-view").click(function(){
        $("#preview_content").html($('#summernote').summernote('code'));
        $('#dialogMailPreview').dialog({
            title: '',
            modal: true,
            width: '800px',
            draggable: true
        });

        $("#dialogMailPreview").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
    });

    $('#sms').keyup(function(){
        cut_80(this);
    });

    $('#sms').click(function(){
        var str_length = getTextLength($('#sms').val());
        if(str_length > 80){
            alert("문자는 80바이트 이하로 적어 주세요.");
            return false;
        }
    });
    $(".allView").click(function(){
        if($(this).data("allview") == "N"){
            $(this).data("allview","Y");
            $(this).html('<i class="fa fa-minus" ></i>');
            $(".option_extend").each(function(){
                $(this).trigger("click");
            })
        }else{
            $(this).data("allview","N");
            $(this).html('<i class="fa fa-plus" ></i>');
            $(".option_extend").each(function(){
                $(this).trigger("click");
            })
        }

    });

    $("#mf_file").change(function(evt){
        var url="/api/emailFile";
        // $("#em_es_code").val($("#currentMailCode").val());
        $("#fileMailUpload").ajaxForm({ // submit 액션 생성
            url : url, // url 입력
            enctype : "multipart/form-data", // 파일 업로드 처리
            dataType : "json", // 전송 타입 및 리턴 타입 설정
            error : function(xhr,option,error){ // 에러 처리
                console.log(error);
            },
            success : function(data){ // 성공 처리
                var html = '';

                for(var i = 0; i < data.list.length;i++){
                    html += '<div style="height:30px" class="fileCount" data-filesize="'+data.list[i].mf_file_size+'">\
                                <input type="checkbox" name="add_file[]" class="add_file checkfile" value="'+data.list[i].mf_seq+'|'+data.list[i].mf_origin_file+'|'+data.list[i].mf_file+'" checked> '+data.list[i].mf_origin_file+'\
                            </div>';
                }
                $("#mail_add_file").html(html);
                // $("#attachedCnt").html($(".fileCount").length);
                fileCheck();
            }
        });
        // console.log($("#fileForm").serialize());
        // return false;

        $("#fileMailUpload").submit();
        $("#mf_file").val('');

        return false;
    });

    $(".btn-addfile-delete").click(function(){
        if($(".add_file").length > 0){
            if(confirm("삭제 하시겠습니까?")){
                var checkSeq = [];
                $(".add_file").each(function(){
                    if($(this).prop("checked") == true){
                        var valueArray = $(this).val().split("|");

                        checkSeq.push(valueArray[0]);
                    }
                })
                var url = "/api/emailFileDelete";
                $.ajax({
                    url : url,
                    type : 'GET',
                    dataType : 'JSON',
                    data : "checkSeq="+checkSeq.join(","),
                    success:function(response){
                        // console.log(response);
                        if(response.result){
                            alert("삭제 완료");
                            $(".add_file").each(function(){
                                if($(this).prop("checked") == true){
                                    $(this).parent().remove();
                                }
                            })
                        }else{
                            alert("오류가 발생했습니다.");
                        }

                    },
                    error : function(error){
                        console.log(error);
                    }

                });

            }
        }
    });
})

var fileCheck = function(){
    var count = 0;
    var fileTotalSize = 0;
    $(".fileCount").each(function(){
        // console.log($(this).data("filesize"));
        // console.log($(this).children(".checkfile").length);
        if($(this).children(".checkfile").length > 0){
            // console.log($(this).children(".checkfile").prop("checked"));
            if($(this).children(".checkfile").prop("checked") == true){
                count++;
                // console.log($(this).data("filesize"));
                fileTotalSize = fileTotalSize + parseInt($(this).data("filesize"));
            }
        }else{
            count++;
            fileTotalSize = fileTotalSize + parseInt($(this).data("filesize"));
        }

    });

    $("#attachedCnt").html(count);
    $("#attachedSize").html(formatBytes(fileTotalSize));
}

var formatBytes = function(bytes) {
    if(bytes < 1024) return bytes + " Bytes";
    else if(bytes < 1048576) return(bytes / 1024).toFixed(2) + " KB";
    else if(bytes < 1073741824) return(bytes / 1048576).toFixed(2) + " MB";
    else return(bytes / 1073741824).toFixed(2) + " GB";
};

function getTextLength(str) {
    var len = 0;
    for (var i = 0; i < str.length; i++) {
        if (escape(str.charAt(i)).length == 6) {
            len++;
        }
        len++;
    }
    return len;
}

function cut_80(obj){
    var text = $(obj).val();
    var leng = text.length;
    while(getTextLength(text) > 80){
        leng--;
        text = text.substring(0, leng);
    }
    $(obj).val(text);
    $('.bytes').text(getTextLength(text));
}

function viewAll(){
    if($(".payment-basic").css("display") != "none"){
        $(".payment-basic").hide();
        $("#payment_extend").html(">");
    }else{
        $(".payment-basic").show();
        $("#payment_extend").html(">");
    }

}

function viewAll2(){
    if($(".claim_payment").css("display") != "none"){
        $(".claim_payment").hide();
        $("#claim_extend").html(">");
    }else{
        $(".claim_payment").show();
        $("#claim_extend").html(">");
    }
    // $(".claim_payment").show();
}

function viewAll3(){
    if($(".paycom_payment").css("display") != "none"){
        $(".paycom_payment").hide();
        $("#paycom_extend").html(">");
    }else{
        $(".paycom_payment").show();
        $("#paycom_extend").html(">");
    }
    // $(".claim_payment").show();
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

function servicePayment(mb_seq){
    var checkCnt = 0;
    var checkSeq = [];
    $(".payment_check").each(function(){
        if($(this).is(":checked")){
            checkCnt++;
            checkSeq.push($(this).val());
        }
    })
    if(checkCnt == 0){
        alert("서비스를 선택해 주세요");
        return false;
    }

    // if(checkCnt > 1){
    //     alert("서비스를 하나만 선택해 주세요");
    //     return false;
    // }

    var url = "/api/claimMake/"+mb_seq;
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : "pm_sv_seq="+checkSeq.join(","),
        success:function(response){
            console.log(response);
            if(response.result){
                alert("청구 되었습니다.");
                document.location.reload();
            }
            //
        },
        error:function(error){
            console.log(error);
        }
    });
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
            alert("수정완료");
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
            alert("수정완료");
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
            alert("수정완료");
            document.location.reload();
        }
    });
}

function memberUpdate4(mb_seq){
    // console.log(mb_seq);
    var url = "/api/memberUpdate4/"+mb_seq;
    var datas = $("#update4").serialize();

    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            // console.log(response);
            alert("수정완료");
            document.location.reload();
        },
        error : function(error){
            console.log(error);
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
            alert("수정완료");
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
            alert("수정완료");
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
        if($(this).is(":checked")){
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
        }
    })
    $(".payment_price1").html($.number(price1)+" 원");
    $(".payment_price2").html("- "+$.number(price2)+" 원");
    $(".payment_price3").html($.number(price3)+" 원");
    $(".payment_price4").html($.number(price4)+" 원");
    $(".payment_price5").html("- "+$.number(price5)+" 원");
    $(".payment_price6").html("- "+$.number(price6)+" 원");
    $(".payment_price7").html($.number(price7)+" 원");
    $(".payment_price8").html($.number(price8)+" 원");
    $(".payment_price9").html($.number(price9)+" 원");
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
    $(".claim_price1").html($.number(price1)+" 원");
    $(".claim_price2").html($.number(price2)+" 원");
    $(".claim_price3").html($.number(price3)+" 원");
    $(".claim_price4").html($.number(price4)+" 원");
    $(".claim_price5").html($.number(price5)+" 원");
    $(".claim_price6").html($.number(price6)+" 원");
    $(".claim_price7").html($.number(price7)+" 원");
    $(".claim_price8").html($.number(price8)+" 원");
    $(".claim_price9").html($.number(price9)+" 원");
    $(".claim_price10").html($.number(price10)+" 원");
    $(".claim_price11").html($.number(price11)+" 원");
    $(".claim_price12").html($.number(price12)+" 원");
}

function paycomCal(){
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
    $(".paycom_check").each(function(){
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
    $(".paycom_price1").html($.number(price1)+" 원");
    $(".paycom_price2").html($.number(price2)+" 원");
    $(".paycom_price3").html($.number(price3)+" 원");
    $(".paycom_price4").html($.number(price4)+" 원");
    $(".paycom_price5").html($.number(price5)+" 원");
    $(".paycom_price6").html($.number(price6)+" 원");
    $(".paycom_price7").html($.number(price7)+" 원");
    $(".paycom_price8").html($.number(price8)+" 원");
    $(".paycom_price9").html($.number(price9)+" 원");
    $(".paycom_price10").html($.number(price10)+" 원");
    $(".paycom_price11").html($.number(price11)+" 원");
    $(".paycom_price12").html($.number(price12)+" 원");
}

function getPaymentMemo(){
    var url = "/api/paymentMemoList/"+$("#mb_seq").val();
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){

            var html = "";
            for(var i = 0;i < response.list.length;i++){
                html += '<tr>\
                            <td>1</td>\
                            <td>'+response.list[i].po_memo+'</td>\
                            <td>'+response.list[i].po_regdate+'</td>\
                            <td>'+response.list[i].po_input_date+'</td>\
                            <td></td>\
                            <td><i class="fas fa-edit memo_mode" data-edit="N" data-inputdate="'+response.list[i].po_input_date+'" data-memo="'+response.list[i].po_memo+'" data-seq="'+response.list[i].po_seq+'"></i> <i class="fas fa-trash memo_del" data-seq="'+response.list[i].po_seq+'"></i></td>\
                        </tr>';
            }
            $("#memo-list").html(html);
        },
        error : function(error){
            console.log(error);
        }
    });
}

function daumApi() {
    new daum.Postcode({
        oncomplete: function(data) {
            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

            // 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
            var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
            var extraRoadAddr = ''; // 도로명 조합형 주소 변수

            // 법정동명이 있을 경우 추가한다. (법정리는 제외)
            // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
            if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                extraRoadAddr += data.bname;
            }
            // 건물명이 있고, 공동주택일 경우 추가한다.
            if(data.buildingName !== '' && data.apartment === 'Y'){
               extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
            }
            // 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
            if(extraRoadAddr !== ''){
                extraRoadAddr = ' (' + extraRoadAddr + ')';
            }
            // 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
            if(fullRoadAddr !== ''){
                fullRoadAddr += extraRoadAddr;
            }

            // 우편번호와 주소 정보를 해당 필드에 넣는다.
            document.getElementById('mb_zipcode').value = data.zonecode; //5자리 새우편번호 사용
            document.getElementById('mb_address').value = fullRoadAddr;
            // document.getElementById('sample4_jibunAddress').value = data.jibunAddress;

            $("#mb_detail_address").focus();
        }
    }).open();
}

function getPaymentList(){
    // var start = $("#start").val();
    // // console.log(start);
    // var end = 5;
    var url = "/api/memberService/"+$("#mb_seq").val();
    // var searchForm = $("#searchForm").serialize();
    // // console.log(searchForm);
    // console.log(url);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){
            console.log(response);
            var html = "";
            if($(".basic").css("display") != "none"){
                var basicView = true;
            }else{
                var basicView = false;
            }
            if($(".payment").css("display") != "none"){
                var paymentView = true;
            }else{
                var paymentView = false;
            }

            if(response.length > 0){
                for(var i = 0; i < response.length;i++){
                    // console.log(start);
                    var num = parseInt(response.length) - i;
                    var startdate = new Date(response[i].sv_contract_start);
                    var enddate = new Date(response[i].sv_contract_end);
                    var diffenddate = moment(enddate).add(2,'days').format('YYYY-MM-DD');
                    // console.log(diffenddate);
                    var diff = Date.getFormattedDateDiff(startdate, diffenddate);

                    if(response[i].sv_rental == "N"){
                        var sv_rental = "-";
                    }else{
                        if(response[i].sv_rental_type == "1"){
                            var sv_rental = "영구임대";
                        }else{
                            var sv_rental = "소유권이전<br>("+response[i].sv_rental_date+"개월)";
                        }
                    }
                    if(response[i].sv_auto_extension == "1"){
                        var sv_auto = response[i].sv_auto_extension_month+"개월";
                        var sv_auto_end = moment(response[i].sv_contract_end).add(sv_auto,'months').subtract(1, "days").format("YYYY-MM-DD")
                    }else{
                        var sv_auto = "-";
                        var sv_auto_end = response[i].sv_contract_end;
                    }
                    if(response[i].priceinfo !== null){
                        var priceinfo = response[i].priceinfo.split("|");
                    }else{
                        var priceinfo = [0,0,0,0,0];
                    }
                    var firstPrice = parseInt(priceinfo[0])-parseInt(priceinfo[1]);
                    var monthPrice = parseInt(priceinfo[2])-parseInt(priceinfo[3])-parseInt(priceinfo[4]);

                    if(response[i].sv_status == "0"){
                        var sv_status = '입금대기중';
                    }else if(response[i].sv_status == "1"){
                        var sv_status = '서비스준비중';
                    }else if(response[i].sv_status == "2"){
                        var sv_status = '서비스작업중';
                    }else if(response[i].sv_status == "3"){
                        var sv_status = '서비스중';
                    }else if(response[i].sv_status == "4"){
                        var sv_status = '서비스중지';
                    }else if(response[i].sv_status == "5"){
                        var sv_status = '서비스해지';
                    }else if(response[i].sv_status == "6"){
                        var sv_status = '직권중지';
                    }else if(response[i].sv_status == "7"){
                        var sv_status = '직권해지';
                    }
                    if(response[i].paymentinfo !== null){
                        var paymentinfo = response[i].paymentinfo.split("|");
                    }else{
                        var paymentinfo = [];
                    }
                    var pm_status = paymentinfo[0];
                    var pm_pay_period = paymentinfo[1];
                    var pm_date = paymentinfo[2];
                    var pm_end_date = paymentinfo[3];
                    var pm_input_date = paymentinfo[4];

                    if(pm_status == "0"){
                        if(pm_pay_period > 1){
                            var custom_end_date = moment(pm_date).add(1,'months').format("YYYY-MM-DD");
                            if(moment().format("YYYY-MM-DD") >= custom_end_date){
                                var payment_status = "연체";
                            }else{
                                if(pm_end_date >= moment().format("YYYY-MM-DD")){
                                    var payment_status = "청구("+pm_pay_period+"개월)";
                                }else{
                                    var payment_status = "미납("+pm_pay_period+"개월)";
                                }
                            }
                        }else{
                            // 연체 로직 추가
                            if(pm_end_date >= moment().format("YYYY-MM-DD")){
                                var payment_status = "청구("+pm_pay_period+"개월)";
                            }else{
                                var payment_status = "미납("+pm_pay_period+"개월)";
                            }

                        }
                    }else if(pm_status == "1"){
                        var payment_status = "가결제("+pm_pay_period+"개월) " +pm_input_date
                    }else{
                        var payment_status = "완납";
                    }

                    if(response[i].sv_input_unit == 0){
                        var sv_input_unit = "구매";
                    }else if(response[i].sv_input_unit == 1){
                        var sv_input_unit = "월";
                    }else{
                        var sv_input_unit = "";
                    }
                    console.log(response[i].sv_service_start );
                    html += '<tr>\
                                <td><input type="checkbox" class="listCheck" name="sv_seq[]" value="'+response[i].sv_seq+'"></td>\
                                <td>'+num+'</td>\
                                <td><a href="/member/view/'+response[i].mb_seq+'">'+response[i].mb_name+'</a></td>\
                                <td class="basic">'+response[i].eu_name+'</td>\
                                <td>'+response[i].sv_charger+'</td>\
                                <td><a href="javascript:void(0)" onclick="openGroupView(\''+response[i].sv_code+'\')">'+response[i].sv_code+'</a></td>\
                                <td>'+response[i].sv_contract_start+'</td>\
                                <td class="basic">'+response[i].sv_contract_end+'</td>\
                                <td>'+diff[0]+"개월 "+diff[1]+"일"+'</td>\
                                <td class="basic">'+sv_auto+'</td>\
                                <td class="basic">'+sv_auto_end+'</td>\
                                <td>'+response[i].pc_name+'</td>\
                                <td>'+response[i].pi_name+'</td>\
                                <td '+(response[i].addoptionTotal > 0 ? "class=\"option_extend\"":"")+'  data-seq="'+response[i].sv_seq+'" style="cursor:pointer;width:30px;height:30px;background:#414860;font-size:16px;color:#fff;margin:2px'+(response[i].addoptionTotal > 0 ? "":";opacity:0")+'"> + </td>\
                                <td><a href="javascript:void(0)" onclick="openProductView('+response[i].sv_seq+')">'+response[i].pr_name+'</a></td>\
                                <td class="basic">'+response[i].pd_name+'</td>\
                                <td>'+response[i].ps_name+'</td>\
                                <td>'+sv_rental+'</td>\
                                <td><a href="/service/view/'+response[i].sv_seq+'">'+response[i].sv_number+'</a></td>\
                                <td class="payment">'+response[i].sv_claim_name+'</td>\
                                <td class="payment oneprice right" data-oneprice="'+(response[i].svp_once_price-response[i].svp_once_dis_price)+'" data-allprice="'+firstPrice+'">'+$.number(firstPrice)+' 원</td>\
                                <td class="payment monthprice right" data-oneprice="'+(response[i].svp_month_price-response[i].svp_month_dis_price-(response[i].svp_discount_price/response[i].svp_payment_period))+'" data-allprice="'+monthPrice+'">'+$.number(monthPrice)+' 원</td>\
                                <td class="payment">'+response[i].svp_payment_period+'개월</td>\
                                <td class="payment right">'+$.number(response[i].sv_input_price)+' 원</td>\
                                <td class="payment">'+sv_input_unit+'</td>\
                                <td class="payment">'+response[i].c_name+'</td>\
                                <td>'+moment(response[i].sv_regdate).format("YYYY-MM-DD")+'<br>'+(response[i].sv_service_start !== null ? response[i].sv_service_start.substring(0,10):'')+'</td>\
                                <td class="basic"></td>\
                                <td>'+sv_status+'</td>\
                                <td>'+moment(response[i].sv_account_start).format("YYYY-MM-DD")+'<br>'+moment(response[i].sv_account_end).format("YYYY-MM-DD")+'</td>\
                                <td>'+payment_status+'</td>\
                                <td></td>\
                            </tr>\
                            <tr style="border-bottom:0px;display:none" id="child_add_'+response[i].sv_seq+'">\
                                <td colspan=9 class="addcol"></td>\
                                <th style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9;text-align:left;padding-left:30px" colspan=2>부가항목명</th>\
                                <th class="basic" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9"></th>\
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9"></td>\
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9"></td>\
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">서비스번호</td>\
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">청구명</td>\
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">초기일회성</td>\
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">월(기준)요금</td>\
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">결제주기</td>\
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">매입가</td>\
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">매입 단위</td>\
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">매입처</td>\
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">서비스신청일<br>서비스개시일</td>\
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9" class="basic">제품출고일</td>\
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">서비스상태</td>\
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">과금시작일<br>과금만료일</td>\
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">결제상태</td>\
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9s">문서</td>\
                            </tr>\
                            ';
                }

                
            }else{
                html += '<tr><td colspan="17" style="text-align:center">서비스가 없습니다.</td></tr>';
            }
            $("#payment-list").html(html);

            if($(".allView").data("allview") == "Y"){
                
                $(".option_extend").each(function(){
                    $(this).trigger("click");
                })
            }

            if(basicView)
                $(".basic").show();

            if(paymentView)
                $(".payment").show();
        }
    });
    return false;
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