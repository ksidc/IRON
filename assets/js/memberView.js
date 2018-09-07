
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
                    $("#ca_seq"+response.list[i].ca_sort).val(response.list[i].cl_seq);
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
        var specs = "left=10,top=10,width=1000,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/member/payment_view/"+$(this).data("seq"), 'serviceMake', specs);
    });

    $(".detailPView").click(function(){
        var specs = "left=10,top=10,width=1000,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/member/claim_view/"+$(this).data("seq"), 'serviceMake', specs);
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
        console.log(data);
        if(total != data.length && publish == "1"){
            alert("계산서가 청구발행인 서비스는 부분 완납 처리가 불가합니다. 체크 상태를 확인해 주세요");
            return false;
        }

        if(publish == "1"){
            var url = "/api/paymentComPay";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "data="+data.join(","),
                success:function(response){
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