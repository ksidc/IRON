var claim_extend_view = false;
var payment_extend_view = false;
var paycom_extend_view =false;
$(function(){
    getPaymentList();
    getPriceList();
    getClaimList();
    getComList(false);
    getLog();
    getAllLog();
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

    $('#dialogLog').dialog({
        autoOpen: false,
        title: '변경로그',
        modal: true,
        width: '1200px',
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

    $("body").on("click",".payment_check",function(){
        // alert(1);
        paymentCal();
    })

    $("body").on("click",".claim_check",function(){
        // alert(1);
        claimCal();
    })

    $("body").on("click",".paycom_check",function(){
        // alert(1);
        paycomCal();
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
            $(this).attr("title","부가 항목 숨기기");
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
                                var sv_status = '<span style="color:#9E0000">입금대기중</span>';
                            }else if(response[i].sv_status == "1"){
                                var sv_status = '<span style="color:#0070C0">서비스준비중</span>';
                            }else if(response[i].sv_status == "2"){
                                var sv_status = '<span style="color:#548235">서비스작업중</span>';
                            }else if(response[i].sv_status == "3"){
                                var sv_status = '<span style="color:#000000">서비스중</span>';
                            }else if(response[i].sv_status == "4"){
                                var sv_status = '<span style="color:#FF0000">서비스중지</span>';
                            }else if(response[i].sv_status == "5"){
                                var sv_status = '<span style="color:#808080">서비스해지</span>';
                            }else if(response[i].sv_status == "6"){
                                var sv_status = '<span style="color:#FF0000">직권중지</span>';
                            }else if(response[i].sv_status == "7"){
                                var sv_status = '<span style="color:#808080">직권해지</span>';
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
                            var pm_service_start = paymentinfo[5];
                            var pm_service_end = paymentinfo[6];

                            if(pm_status == "0"){
                                if(pm_pay_period > 1){
                                    var custom_end_date = moment(pm_date).add(1,'months').format("YYYY-MM-DD");
                                    if(moment().format("YYYY-MM-DD") >= custom_end_date){
                                        var payment_status = "<span style='color:#FF0000'>연체</span>";
                                    }else{
                                        if(pm_end_date >= moment().format("YYYY-MM-DD")){
                                            var payment_status = "<span style='color:#0070C0'>청구("+pm_pay_period+"개월)</span>";
                                        }else{
                                            var payment_status = "<span style='color:#FF0000'>미납("+pm_pay_period+"개월)</span>";
                                        }
                                    }
                                }else{
                                    // 연체 로직 추가
                                    if(pm_end_date >= moment().format("YYYY-MM-DD")){
                                        var payment_status = "<span style='color:#0070C0'>청구("+pm_pay_period+"개월)</span>";
                                    }else{
                                        var payment_status = "<span style='color:#FF0000'>미납("+pm_pay_period+"개월)</span>";
                                    }

                                }
                            }else if(pm_status == "9"){
                                var payment_status = "<span style='color:#548235'>가결제("+pm_pay_period+"개월) <br>" +pm_input_date+"</span>";
                            }else if(pm_status == "1"){
                                var payment_status = "완납";
                            }else{
                                var payment_status = "청구내역없음";
                            }

                            html += '<tr class="child_add_content_'+seq+'" style="border:0px">\
                                        <td colspan='+col+' class="addcol2"></td>\
                                        <td style="border-bottom: 1px solid #d9d9d9;text-align:left;padding-left:30px;" colspan=2>'+response[i].sva_name+'</td>\
                                        <td class="basic" style="border-bottom: 1px solid #d9d9d9"></td>\
                                        <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                        <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                        <td style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_number+'</td>\
                                        <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9" >'+response[i].sva_claim_name+'</td>\
                                        <td class="payment payment2 right" style="border-bottom: 1px solid #d9d9d9">'+$.number(response[i].svp_once_price-response[i].svp_once_dis_price)+' 원</td>\
                                        <td class="payment payment2 right" style="border-bottom: 1px solid #d9d9d9">'+$.number(response[i].svp_month_price-response[i].svp_month_dis_price-(response[i].svp_discount_price/response[i].svp_payment_period))+' 원</td>\
                                        <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].svp_payment_period+'개월</td>\
                                        <td class="payment payment2 right" style="border-bottom: 1px solid #d9d9d9">'+$.number(response[i].sva_input_price)+' 원</td>\
                                        <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+(response[i].sva_input_unit != "" ? response[i].sva_input_unit:"1")+'개월</td>\
                                        <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].c_name+'</td>\
                                        <td style="border-bottom: 1px solid #d9d9d9">'+moment(response[i].sv_regdate).format("YYYY-MM-DD")+'<br>'+(response[i].sv_service_start !== null ? response[i].sv_service_start.substring(0,10):'')+'</td>\
                                        <td style="border-bottom: 1px solid #d9d9d9" class="basic">'+response[i].sva_input_date+'</td>\
                                        <td style="border-bottom: 1px solid #d9d9d9">'+sv_status+'</td>\
                                        <td style="border-bottom: 1px solid #d9d9d9">'+(pm_service_start == "" ? moment(response[i].sv_account_start).format("YYYY-MM-DD"):moment(pm_service_start).format("YYYY-MM-DD"))+'<br>'+(pm_service_end == "" ? moment(response[i].sv_account_end).format("YYYY-MM-DD"):moment(pm_service_end).format("YYYY-MM-DD"))+'</td>\
                                        <td style="border-bottom: 1px solid #d9d9d9">'+payment_status+'</td>\
                                        <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                    </tr>';
                        }
                        $("#child_add_"+seq).after(html);
                        if($(".payment1").css("display") != "none"){
                            $(".payment2").show();
                        }
                        if($(".basic").css("display") != "none"){
                            $(".basic").show();

                        }
                        // console.log($(".basic").css("display"));
                        
                            
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

        if($("#pm_service_dis_price").val().replace(/,/gi, "") != ""){
            var price = parseInt($(this).val().replace(/,/gi, "")) - parseInt($("#pm_service_dis_price").val().replace(/,/gi, ""));
            $("#once_price_info").html($.number(price)+"원");
            if($("#pm_surtax_type").val() == "0"){
                $("#once_surtax_info").html(($.number(price*0.1,0))+"원");
            }else{
                $("#once_surtax_info").html("0원");
            }
            
            if($("#pm_surtax_type").val() == "0"){
                $("#once_total_price").html( $.number((price+(price*0.1)))+"원" );
            }else{
                $("#once_total_price").html( $.number(price)+"원" );
            }
        }
    })

    $("#pm_service_dis_price").keyup(function(){
        if($("#pm_service_price").val().replace(/,/gi, "") != ""){
            var price = parseInt($("#pm_service_price").val().replace(/,/gi, "")) - parseInt($(this).val().replace(/,/gi, ""));
            $("#once_price_info").html($.number(price)+"원");
            if($("#pm_surtax_type").val() == "0"){
                $("#once_surtax_info").html(($.number(price*0.1,0))+"원");
            }else{
                $("#once_surtax_info").html("0원");
            }
            if($("#pm_surtax_type").val() == "0"){
                $("#once_total_price").html( ($.number(price+(price*0.1)))+"원" );
            }else{
                $("#once_total_price").html( $.number(price)+"원" );
            }
        }
    })

    $("#pm_surtax_type").change(function(){
        if($(this).val() == 0){
            if($("#pm_service_price").val() != "" && $("#pm_service_dis_price").val() != "" ){
                var price = parseInt($("#pm_service_price").val().replace(/,/gi, "")) - parseInt($("#pm_service_dis_price").val().replace(/,/gi, ""));
                $("#once_surtax_info").html(($.number(price*0.1,0))+"원");
                $("#once_total_price").html( $.number(price+(price*0.1))+"원" );

            }
        }else{
            if($("#pm_service_price").val() != "" && $("#pm_service_dis_price").val() != "" ){
                var price = parseInt($("#pm_service_price").val().replace(/,/gi, "")) - parseInt($("#pm_service_dis_price").val().replace(/,/gi, ""));
                 $("#once_surtax_info").html("0원");
                $("#once_total_price").html( $.number(price)+"원" );

            }
        }
    });

    $(".btn-once-reg").click(function(){
        if($("#pm_claim_name").val() == ""){
            alert("일회성 청구명을 입력해주시기 바랍니다.");
            return false;
        }
        if($("#pm_bill_name").val() == ""){
            alert("계산서 품목명을 입력해주시기 바랍니다.");
            return false;
        }
        if($("#pm_bill_name").val() == ""){
            alert("계산서 품목명을 입력해주시기 바랍니다.");
            return false;
        }

        if($("#pm_service_price").val() == 0 || $("#pm_service_price").val() == ""){
            alert("청구 금액을 0원 이상으로 입력하시기 바랍니다.");
            return false;
        }

        if($("#pm_end_date").val() == ""){
            alert("결제기한을 선택해 주시기 바랍니다.");
            return false;
        }
        if(confirm("일회성 요금을 청구하시겠습니까?")){
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
                        // document.location.reload();
                        getClaimList();
						$('#dialogOnce').dialog('close')
                    }
                    // document.location.reload();
                }
            });
        }{}
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
    
    $("body").on("click",".claimView",function(){

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
                $("#ca_price").val($.number(response.info.ca_price));
                $("#ca_surtax").val($.number(response.info.ca_surtax));
                $("#ca_total_price").val($.number(response.info.ca_total_price));
                $("#ca_price_info1").val($.number(response.info.ca_price_info1));
                $("#ca_price_info2").val($.number(response.info.ca_price_info2));
                $("#ca_price_info3").val($.number(response.info.ca_price_info3));
                $("#ca_price_info4").val($.number(response.info.ca_price_info4));
                $("#ca_price_info5").val($.number(response.info.ca_price_info5));

                for(var i = 0; i < response.list.length;i++){
                    // console.log()
                    var datemo = response.info.ca_monthday.split("-");
                    $("#cl_seq"+response.list[i].ca_sort).val(response.list[i].cl_seq);
                    $("#ca_item_date"+response.list[i].ca_sort+"_1").val(datemo[0]);
                    $("#ca_item_date"+response.list[i].ca_sort+"_2").val(datemo[1]);
                    $("#ca_item_name"+response.list[i].ca_sort).val(response.list[i].ca_item_name);
                    $("#ca_item_price"+response.list[i].ca_sort).val($.number(response.list[i].ca_item_price));
                    $("#ca_item_surtax"+response.list[i].ca_sort).val($.number(response.list[i].ca_item_surtax));
                }
                $( "#dialogClaim" ).dialog("open");$("#dialogClaim").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
            },
            error : function(error){
                console.log(error);
            }
        });

    });

    $("body").on("click",".billView",function(){
        var publish_type = $(this).data("p_type");
        var url = "/api/claimView/"+$(this).data("seq");
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                // console.log(response);
                console.log(publish_type);
                if(publish_type == "0"){
                    $("#tax_title").html("작성");
                    var date1 = moment().format("YYYY-MM-DD");
                    var date2 = moment().format("MM-DD");
                    $(".btn-bill-reg").html("작성")
                    $("#paytype1").html("영수");
                }else{
                    $("#tax_title").html("수정");
                    var date1 = response.info.ca_date;
                    var date2 = response.info.ca_monthday;
                    $(".btn-bill-reg").html("수정");
                    $("#paytype1").html("청구");
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
                $("#ba_price").val($.number(response.info.ca_price));
                $("#ba_surtax").val($.number(response.info.ca_surtax));
                $("#ba_total_price").val($.number(response.info.ca_total_price));
                $("#ba_price_info1").val($.number(response.info.ca_price_info1));
                $("#ba_price_info2").val($.number(response.info.ca_price_info2));
                $("#ba_price_info3").val($.number(response.info.ca_price_info3));
                $("#ba_price_info4").val($.number(response.info.ca_price_info4));
                $("#ba_price_info5").val($.number(response.info.ca_price_info5));
                // console.log(response.list.length);
                $("#bl_seq1").val("");
                $("#ba_item_date1_1").val("");
                $("#ba_item_date1_2").val("");
                $("#ba_item_name1").val("");
                $("#ba_item_price1").val("");
                $("#ba_item_surtax1").val("");
                $("#bl_seq2").val("");
                $("#ba_item_date2_1").val("");
                $("#ba_item_date2_2").val("");
                $("#ba_item_name2").val("");
                $("#ba_item_price2").val("");
                $("#ba_item_surtax2").val("");
                $("#bl_seq3").val("");
                $("#ba_item_date3_1").val("");
                $("#ba_item_date3_2").val("");
                $("#ba_item_name3").val("");
                $("#ba_item_price3").val("");
                $("#ba_item_surtax3").val("");
                $("#bl_seq4").val("");
                $("#ba_item_date4_1").val("");
                $("#ba_item_date4_2").val("");
                $("#ba_item_name4").val("");
                $("#ba_item_price4").val("");
                $("#ba_item_surtax4").val("");

                for(var i = 0; i < response.list.length;i++){
                    

                    var datemo = date2.split("-");
                    $("#bl_seq"+response.list[i].ca_sort).val(response.list[i].cl_seq);
                    $("#ba_item_date"+response.list[i].ca_sort+"_1").val(datemo[0]);
                    $("#ba_item_date"+response.list[i].ca_sort+"_2").val(datemo[1]);
                    $("#ba_item_name"+response.list[i].ca_sort).val(response.list[i].ca_item_name);
                    $("#ba_item_price"+response.list[i].ca_sort).val($.number(response.list[i].ca_item_price));
                    $("#ba_item_surtax"+response.list[i].ca_sort).val($.number(response.list[i].ca_item_surtax));
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
                    alert("처리완료");
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
        if(confirm($(this).html()+"하시겠습니까?")){
            var url = "/api/paymentClaimUpdate";
            var datas = $("#billEdit").serialize();

            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    alert("처리완료");
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
            $(".addcol2").attr("colspan",13);
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
    $("body").on("click",".detailView",function(){
        var specs = "left=10,top=10,width=1000,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/member/payment_view/"+$(this).data("seq"), 'serviceMake1', specs);
    });

    $("body").on("click",".detailPView",function(){
        if($(this).data("pmtype") == "1"){
            var specs = "left=10,top=10,width=1000,height=700";
            specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
            window.open("/member/claim_view/"+$(this).data("seq")+"/"+$(this).data("type"), 'serviceMake2', specs);
        }else{
            var specs = "left=10,top=10,width=1000,height=700";
            specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
            window.open("/member/claim_view_once/"+$(this).data("seq"), 'serviceMake2', specs);
        }
    });

    $("body").on("click",".detailCView",function(){
        if($(this).data("pmtype") == "1"){
            var specs = "left=10,top=10,width=1000,height=700";
            specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
            window.open("/member/paycom_view/"+$(this).data("seq"), 'serviceMake3', specs);
        }else{
            var specs = "left=10,top=10,width=1000,height=700";
            specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
            window.open("/member/paycom_view_once/"+$(this).data("seq"), 'serviceMake3', specs);
        }
        
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
                if($("#po_seq").val() == ""){
                    alert("등록되었습니다.");
                }else{
                    alert("수정되었습니다.");
                }
                getPaymentMemo();
                $("#po_seq").val("");
                $("#po_input_date").val("");
                $("#po_memo").val("");
                $(".btn-memo-reg").html("등록");
                $(this).data("edit","N");
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
        // console.log(publish);
        
        if(publish == "1"){
            if(confirm("완납 처리를 하시겠습니까?")){
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
                            getPaymentList();
                            getClaimList();
                            getComList(false);
                            // document.location.reload();
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
            }
        }else{ // 영수처리
            if(total != data.length ){
                var msg = "부분 완납 처리를 하시겠습니까?";
            }else{
                var msg = "완납 처리를 하시겠습니까?";
            }
            if(confirm(msg)){
                var url = "/api/paymentComPayPost";
                $.ajax({
                    url : url,
                    type : 'POST',
                    dataType : 'JSON',
                    data : "data="+data.join(",")+"&pm_total="+total,
                    success:function(response){
                        getPaymentList();
                        getClaimList();
                        getComList(false);
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
                                        $(".btn-bill-reg").html("작성");
                                        $("#paytype1").html("영수");
                                    }else{
                                        $("#tax_title").html("수정");
                                        var date1 = response.info.ca_date;
                                        var date2 = response.info.ca_monthday;
                                        $(".btn-bill-reg").html("수정");
                                        $("#paytype1").html("청구");
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
                                    $("#ba_price").val($.number(response.info.ca_price));
                                    $("#ba_surtax").val($.number(response.info.ca_surtax));
                                    $("#ba_total_price").val($.number(response.info.ca_total_price));
                                    $("#ba_price_info1").val($.number(response.info.ca_price_info1));
                                    $("#ba_price_info2").val($.number(response.info.ca_price_info2));
                                    $("#ba_price_info3").val($.number(response.info.ca_price_info3));
                                    $("#ba_price_info4").val($.number(response.info.ca_price_info4));
                                    $("#ba_price_info5").val($.number(response.info.ca_price_info5));

                                    for(var i = 0; i < response.list.length;i++){
                                        var datemo = date2.split("-");
                                        $("#bl_seq"+response.list[i].ca_sort).val(response.list[i].cl_seq);
                                        $("#ba_item_date"+response.list[i].ca_sort+"_1").val(datemo[0]);
                                        $("#ba_item_date"+response.list[i].ca_sort+"_2").val(datemo[1]);
                                        $("#ba_item_name"+response.list[i].ca_sort).val(response.list[i].ca_item_name);
                                        $("#ba_item_price"+response.list[i].ca_sort).val($.number(response.list[i].ca_item_price));
                                        $("#ba_item_surtax"+response.list[i].ca_sort).val($.number(response.list[i].ca_item_surtax));
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
        }

    })

    $("#mb_auto_claim_yn").click(function(){
        if($(this).is(":checked")){
            var value_ = "Y";
            var msg = "서비스 비용 자동 청구를 설정 하시겠습니까?";
        }else{
            var value_ = "N";
            var msg = "서비스 비용 자동 청구를 해제 하시겠습니까?";
        }
        if(confirm(msg)){
            var url = "/api/memberAutoClaim";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "mb_seq="+$("#mb_seq").val()+"&mb_auto_claim_yn="+value_,
                success:function(response){
                    console.log(response);
                    if(response.result){
                        alert("적용 되었습니다.");
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
        }

    })

    $("#mb_auto_email_yn").click(function(){
        if($(this).is(":checked")){
            var value_ = "Y";
            var msg = "메일 자동 발송을 설정 하시겠습니까?";
        }else{
            var value_ = "N";
            var msg = "메일 자동 발송을 해제 하시겠습니까?";
        }
        if(confirm(msg)){
            var url = "/api/memberAutoEmail";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "mb_seq="+$("#mb_seq").val()+"&mb_auto_email_yn="+value_,
                success:function(response){
                    console.log(response);
                    if(response.result){
                        alert("적용 되었습니다.");
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
        }

    })

    $("#mb_over_pay_yn").click(function(){
        if($(this).is(":checked")){
            var value_ = "Y";
            var msg = "연체 수수료 부과를 설정 하시겠습니까?";
        }else{
            var value_ = "N";
            var msg = "연체 수수료 부과를 해제 하시겠습니까?";
        }
        if(confirm(msg)){
            var url = "/api/memberOverPay";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "mb_seq="+$("#mb_seq").val()+"&mb_over_pay_yn="+value_,
                success:function(response){
                    console.log(response);
                    if(response.result){
                        alert("적용 되었습니다.");
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
        }

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
        var url = "/api/memberSendEmail";
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
        return false;
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
        cut_90(this);
    });

    $('#sms').click(function(){
        var str_length = getTextLength($('#sms').val());
        if(str_length > 90){
            alert("문자는 90바이트 이하로 적어 주세요.");
            return false;
        }
    });
    $(".allView").click(function(){
        if($(this).data("allview") == "N"){
            $(this).data("allview","Y");
            $(this).html('<i class="fa fa-minus" ></i>');
            $(this).attr("title","부가 항목 숨기기");
            $(".option_extend").each(function(){
                $(this).trigger("click");
            })
        }else{
            $(this).data("allview","N");
            $(this).html('<i class="fa fa-plus" ></i>');
            $(this).attr("title","부가 항목 보이기");
            $(".option_extend").each(function(){
                $(this).trigger("click");
            })
        }

    })
    $.widget("ui.tooltip", $.ui.tooltip, {
         options: {
             content: function () {
                 return $(this).prop('title');
             }
         }
     });
    $( '[rel=tooltip]' ).tooltip({
        position: {
            my: "center bottom-10",
            at: "center top",
            using: function( position, feedback ) {
                console.log(this);
                $( this ).css( position );
                $( "<div>" )
                    .addClass( "arrow" )
                    .addClass( feedback.vertical )
                    .addClass( feedback.horizontal )
                    .appendTo( this );
            }
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
                console.log(xhr);
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

    $("#sameBill").click(function(){
        if($(this).is(":checked")){
            $("#pm_bill_name").val($("#pm_claim_name").val());
        }
    });

    $(".pm_date").keyup(function(){
        var pay_day = $(this).parent().parent().find(".pay_day").val();
        var end = moment($(this).val()).add(pay_day,'days').format("YYYY-MM-DD");
        $(this).parent().parent().find(".pm_end_date").val(end);
        // $("#p_pm_end_date").html(end);
    })
    
    $("body").on("keyup",".pm_date",function(){
        var target = $(this).parent().parent().find(".pm_end_date");
        var plusDate = $(this).data("adddate");

        var end = moment($(this).val()).add(plusDate,'days').format("YYYY-MM-DD");
        console.log(end);
        target.val(end);
    })

    $(".btn-log-search").click(function(){
        getLog();
    })

    $("#log_end").change(function(){
        getLog();
    })

    $("#log_all_end").change(function(){
        getAllLog();
    })
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

function cut_90(obj){
    var text = $(obj).val();
    var leng = text.length;
    while(getTextLength(text) > 90){
        leng--;
        text = text.substring(0, leng);
    }
    $(obj).val(text);
    $('.bytes').text(getTextLength(text));
}

function viewAll(){
    if($(".payment-basic").css("display") != "none"){
        $(".payment-basic").hide();
        $("#payment_extend").html("<");
        payment_extend_view = false;
    }else{
        $(".payment-basic").show();
        $("#payment_extend").html(">");
        payment_extend_view = true;
    }

}

function viewAll2(){
    if($(".claim_payment").css("display") != "none"){
        $(".claim_payment").hide();
        $("#claim_extend").html("<");
        claim_extend_view = false;
    }else{
        $(".claim_payment").show();
        $("#claim_extend").html(">");
        claim_extend_view = true;
    }
    // $(".claim_payment").show();
}

function viewAll3(){
    if($(".paycom_payment").css("display") != "none"){
        $(".paycom_payment").hide();
        $("#paycom_extend").html("<");
        paycom_extend_view = false;
    }else{
        $(".paycom_payment").show();
        $("#paycom_extend").html(">");
        paycom_extend_view = true;
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
    // if(checkCnt == 0){
    //     alert("서비스를 선택해 주세요");
    //     return false;
    // }

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
            $("#pm_com_type").val($(this).data("paymenttype"));
            $("#pm_payment_publish").val($(this).data("paypublish"));
            $("#pm_payment_publish_type").val($(this).data("paypublishtype"));
            $("#pm_end_date").val($(this).data("pmdate"));
        }
    })
    if(checkCnt == 0){
        $(".service0").hide();
        $("#pm_end_date").val(moment(new Date()).format("YYYY-MM-DD"));
    }else{
        $(".service0").show();
    }
    $( "#dialogOnce" ).dialog("open");$("#dialogOnce").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
}

function servicePayment(mb_seq){
    var checkCnt = 0;
    var checkSeq = [];
    var checkSvaSeq = [];
    $(".payment_check").each(function(){
        if($(this).is(":checked")){
            checkCnt++;
            // console.log($(this).data("svaseq") );
            if($(this).data("svaseq") != "" && $(this).data("svaseq") !== null){
                checkSvaSeq.push($(this).val()+"|"+$(this).data("svaseq"));
            }else{
                checkSeq.push($(this).val()+"|");
            }
            
        }
    })

    if(checkCnt == 0){
        alert("서비스를 선택해 주세요");
        return false;
    }
    
    // console.log(checkSeq);
    // console.log(checkSvaSeq);
    // return false;
    // if(checkCnt > 1){
    //     alert("서비스를 하나만 선택해 주세요");
    //     return false;
    // }
    if(confirm("서비스 비용 청구를 하시겠습니까?")){
        var url = "/api/claimMake/"+mb_seq;
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : "pm_sv_seq="+checkSeq.join(",")+"&pm_sva_seq="+checkSvaSeq.join(","),
            success:function(response){
                console.log(response);
                if(response.result){
                    alert("청구 되었습니다.");
                    // document.location.reload();
                    getClaimList();
                }
                //
            },
            error:function(error){
                console.log(error);
            }
        });
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
    var specs = "left=10,top=10,width=1400,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/member/payment_setting/"+mb_seq,'paymentSetting', specs);
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
        }
    })
    $(".claim_price1").html($.number(price1)+" 원");
    $(".claim_price2").html("- "+$.number(price2)+" 원");
    $(".claim_price3").html($.number(price3)+" 원");
    $(".claim_price4").html($.number(price4)+" 원");
    $(".claim_price5").html($.number(price5)+" 원");
    $(".claim_price6").html("- "+$.number(price6)+" 원");
    $(".claim_price7").html("- "+$.number(price7)+" 원");
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
        }
    })
    $(".paycom_price1").html($.number(price1)+" 원");
    $(".paycom_price2").html("- "+$.number(price2)+" 원");
    $(".paycom_price3").html($.number(price3)+" 원");
    $(".paycom_price4").html($.number(price4)+" 원");
    $(".paycom_price5").html($.number(price5)+" 원");
    $(".paycom_price6").html("- "+$.number(price6)+" 원");
    $(".paycom_price7").html("- "+$.number(price7)+" 원");
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
                var num = parseInt(response.list.length) - i;
                html += '<tr>\
                            <td>'+num+'</td>\
                            <td>'+response.list[i].po_memo+'</td>\
                            <td>'+response.list[i].po_regdate+'</td>\
                            <td>'+(response.list[i].po_input_date == "0000-00-00" ? "":response.list[i].po_input_date)+'</td>\
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
        var start = $("#start").val();
        // console.log(start);
        var end = $("#end").val();
        var url = "/api/memberService/"+$("#mb_seq").val()+"/"+start+"/"+end;
        // console.log(searchForm);
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

                if(response.list.length > 0){
                    for(var i = 0; i < response.list.length;i++){
                        // console.log(start);
                        var num = parseInt(response.total) - ((start-1)*end) - i;
                        var startdate = new Date(response.list[i].sv_contract_start);
                        var enddate = new Date(response.list[i].sv_contract_end);
                        var diffenddate = moment(enddate).add(2,'days').format('YYYY-MM-DD');
                        // console.log(diffenddate);
                        var diff = Date.getFormattedDateDiff(startdate, diffenddate);

                        if(response.list[i].sv_rental == "N"){
                            var sv_rental = "-";
                        }else{
                            if(response.list[i].sv_rental_type == "1"){
                                var sv_rental = "영구임대";
                            }else{
                                var sv_rental = "소유권이전<br>("+response.list[i].sv_rental_date+"개월)";
                            }
                        }
                        if(response.list[i].sv_auto_extension == "1"){
                            var sv_auto = response.list[i].sv_auto_extension_month+"개월";
                           
                            // var sv_auto_end = moment(response[i].sv_contract_end).add(sv_auto,'months').subtract(1, "days").format("YYYY-MM-DD")
                            // var sv_auto_end = moment(response[i].sv_contract_end).add(response[i].sv_auto_extension_month,'months').format("YYYY-MM-DD")
                        }else{
                            var sv_auto = "-";
                            // var sv_auto_end = response[i].sv_contract_end;
                        }
                        if(response.list[i].sv_contract_extension_end != "0000-00-00"){
                            var sv_auto_end = response.list[i].sv_contract_extension_end;
                        }else{
                            var sv_auto_end = "";
                        }
                        if(response.list[i].priceinfo !== null){
                            var priceinfo = response.list[i].priceinfo.split("|");
                        }else{
                            var priceinfo = [0,0,0,0,0];
                        }
                        var firstPrice = parseInt(priceinfo[0])-parseInt(priceinfo[1]);
                        var monthPrice = parseInt(priceinfo[2])-parseInt(priceinfo[3])-parseInt(priceinfo[4]);

                        if(response.list[i].sv_status == "0"){
                            var sv_status = '<span style="color:#9E0000">입금대기중</span>';
                        }else if(response.list[i].sv_status == "1"){
                            var sv_status = '<span style="color:#0070C0">서비스준비중</span>';
                        }else if(response.list[i].sv_status == "2"){
                            var sv_status = '<span style="color:#548235">서비스작업중</span>';
                        }else if(response.list[i].sv_status == "3"){
                            var sv_status = '<span style="color:#000000">서비스중</span>';
                        }else if(response.list[i].sv_status == "4"){
                            var sv_status = '<span style="color:#FF0000">서비스중지</span>';
                        }else if(response.list[i].sv_status == "5"){
                            var sv_status = '<span style="color:#808080">서비스해지</span>';
                        }else if(response.list[i].sv_status == "6"){
                            var sv_status = '<span style="color:#FF0000">직권중지</span>';
                        }else if(response.list[i].sv_status == "7"){
                            var sv_status = '<span style="color:#808080">직권해지</span>';
                        }
                        if(response.list[i].paymentinfo !== null){
                            var paymentinfo = response.list[i].paymentinfo.split("|");
                        }else{
                            var paymentinfo = [];
                        }
                        var pm_status = paymentinfo[0];
                        var pm_pay_period = paymentinfo[1];
                        var pm_date = paymentinfo[2];
                        var pm_end_date = paymentinfo[3];
                        var pm_input_date = paymentinfo[4];
                        var pm_service_start = paymentinfo[5];
                        var pm_service_end = paymentinfo[6];

                        if(pm_status == "0"){
                            if(pm_pay_period > 1){
                                var custom_end_date = moment(pm_date).add(1,'months').format("YYYY-MM-DD");
                                if(moment().format("YYYY-MM-DD") >= custom_end_date){
                                    var payment_status = "<span style='color:#FF0000'>연체</span>";
                                }else{
                                    if(pm_end_date >= moment().format("YYYY-MM-DD")){
                                        var payment_status = "<span style='color:#0070C0'>청구("+pm_pay_period+"개월)</span>";
                                    }else{
                                        var payment_status = "<span style='color:#FF0000'>미납("+pm_pay_period+"개월)</span>";
                                    }
                                }
                            }else{
                                // 연체 로직 추가
                                if(pm_end_date >= moment().format("YYYY-MM-DD")){
                                    var payment_status = "<span style='color:#0070C0'>청구("+pm_pay_period+"개월)</span>";
                                }else{
                                    var payment_status = "<span style='color:#FF0000'>미납("+pm_pay_period+"개월)</span>";
                                }

                            }
                        }else if(pm_status == "9"){
                            var payment_status = "<span style='color:#548235'>가결제("+pm_pay_period+"개월) <br>" +pm_input_date+"</span>";
                        }else if(pm_status == "1"){
                            var payment_status = "완납";
                        }else{
                            var payment_status = "청구내역없음";
                        }

                        if(response.list[i].sv_input_unit == 0){
                            var sv_input_unit = "구매";
                        }else if(response.list[i].sv_input_unit == 1){
                            var sv_input_unit = "월";
                        }else{
                            var sv_input_unit = "";
                        }

                        var file_array = [];
                        if(response.list[i].file1 != ""){
                            file_array.push("A");
                        }
                        if(response.list[i].file2 != ""){
                            file_array.push("R");
                        }
                        if(response.list[i].file3 != ""){
                            file_array.push("T");
                        }
                        if(response.list[i].file4 != ""){
                            file_array.push("I");
                        }
                        if(response.list[i].file6 != ""){
                            file_array.push("C");
                        }
                        if(response.list[i].file8 != ""){
                            file_array.push("O");
                        }

                        console.log(response.list[i].sv_service_start );
                        html += '<tr>\
                                    <td><input type="checkbox" class="listCheck" name="sv_seq[]" value="'+response.list[i].sv_seq+'"></td>\
                                    <td>'+num+'</td>\
                                    <td><a href="/member/view/'+response.list[i].mb_seq+'">'+response.list[i].mb_name+'</a></td>\
                                    <td class="basic">'+response.list[i].eu_name+'</td>\
                                    <td>'+response.list[i].sv_charger+'</td>\
                                    <td><a href="javascript:void(0)" onclick="openGroupView(\''+response.list[i].sv_code+'\')">'+response.list[i].sv_code+'</a></td>\
                                    <td>'+response.list[i].sv_contract_start+'</td>\
                                    <td class="basic">'+response.list[i].sv_contract_end+'</td>\
                                    <td>'+diff[0]+"개월 "+diff[1]+"일"+'</td>\
                                    <td class="basic">'+sv_auto+'</td>\
                                    <td class="basic">'+sv_auto_end+'</td>\
                                    <td>'+response.list[i].pc_name+'</td>\
                                    <td>'+response.list[i].pi_name+'</td>\
                                    <td '+(response.list[i].addoptionTotal > 0 ? "class=\"option_extend\"":"")+'  data-seq="'+response.list[i].sv_seq+'" style="cursor:pointer;width:30px;height:30px;background:#516381;font-size:16px;color:#fff;margin:2px'+(response.list[i].addoptionTotal > 0 ? "":";opacity:0")+'" title="부가 항목 보이기" rel="tooltip"> + </td>\
                                    <td><a href="javascript:void(0)" onclick="openProductView('+response.list[i].sv_seq+')">'+response.list[i].pr_name+'</a></td>\
                                    <td class="basic">'+response.list[i].pd_name+'</td>\
                                    <td>'+response.list[i].ps_name+'</td>\
                                    <td>'+sv_rental+'</td>\
                                    <td><a href="/service/view/'+response.list[i].sv_seq+'">'+response.list[i].sv_number+'</a></td>\
                                    <td class="payment">'+response.list[i].sv_claim_name+'</td>\
                                    <td class="payment oneprice right" data-oneprice="'+(response.list[i].svp_once_price-response.list[i].svp_once_dis_price)+'" data-allprice="'+firstPrice+'">'+$.number(firstPrice)+' 원</td>\
                                    <td class="payment monthprice right" data-oneprice="'+(response.list[i].svp_month_price-response.list[i].svp_month_dis_price-response.list[i].svp_discount_price)+'" data-allprice="'+monthPrice+'">'+$.number(monthPrice)+' 원</td>\
                                    <td class="payment">'+response.list[i].svp_payment_period+'개월</td>\
                                    <td class="payment right">'+$.number(response.list[i].sv_input_price)+' 원</td>\
                                    <td class="payment">'+sv_input_unit+'</td>\
                                    <td class="payment">'+response.list[i].c_name+'</td>\
                                    <td>'+moment(response.list[i].sv_regdate).format("YYYY-MM-DD")+'<br>'+(response.list[i].sv_service_start !== null ? response.list[i].sv_service_start.substring(0,10):'')+'</td>\
                                    <td class="basic">'+response.list[i].sv_out_date.substring(0,10)+'</td>\
                                    <td>'+sv_status+'</td>\
                                    <td>'+(pm_service_start == "" ? moment(response.list[i].sv_account_start).format("YYYY-MM-DD"):moment(pm_service_start).format("YYYY-MM-DD"))+'<br>'+(pm_service_end == "" ? moment(response.list[i].sv_account_end).format("YYYY-MM-DD"):moment(pm_service_end).format("YYYY-MM-DD"))+'</td>\
                                    <td>'+payment_status+'</td>\
                                    <td>'+file_array.join(" ")+'</td>\
                                </tr>\
                                <tr style="border-bottom:0px;display:none" id="child_add_'+response.list[i].sv_seq+'">\
                                    <td colspan=9 class="addcol"></td>\
                                    <th style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9;text-align:left;padding-left:30px" colspan=2>부가항목명</th>\
                                    <th class="basic" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9"></th>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9"></td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9"></td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">서비스번호</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">청구명</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">초기일회성</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">월(기준)요금</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">결제주기</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">매입가</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">매입 단위</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">매입처</td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">서비스신청일<br>서비스개시일</td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9" class="basic">제품출고일</td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">서비스상태</td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">과금시작일<br>과금만료일</td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">결제상태</td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9s">문서</td>\
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

                $(".pagination-html").bootpag({
                        total : Math.ceil(parseInt(response.total)/parseInt($("#end").val())), // 총페이지수 (총 Row / list노출개수)
                        page : $("#start").val(), // 현재 페이지 default = 1
                        maxVisible:5, // 페이지 숫자 노출 개수
                        wrapClass : "pagination",
                        next : ">",
                        prev : "<",
                        nextClass : "last",
                        prevClass : "first",
                        activeClass : "active"

                    }).on('page', function(event,num){ // 이벤트 액션
                        // document.location.href='/pageName/'+num; // 페이지 이동
                        $("#start").val(num);
                        getPaymentList();
                    })

                $.widget("ui.tooltip", $.ui.tooltip, {
                     options: {
                         content: function () {
                             return $(this).prop('title');
                         }
                     }
                 });
                $( '[rel=tooltip]' ).tooltip({
                    position: {
                        my: "center bottom-10",
                        at: "center top",
                        using: function( position, feedback ) {
                            console.log(this);
                            $( this ).css( position );
                            $( "<div>" )
                                .addClass( "arrow" )
                                .addClass( feedback.vertical )
                                .addClass( feedback.horizontal )
                                .appendTo( this );
                        }
                    }
                });
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

function openGroupView(sv_code){

    var specs = "left=10,top=10,width=1000,height=700";
    specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
    window.open("/service/numberGroupView/"+sv_code, 'serviceProductView', specs);
}

function openProductView(sv_seq){
    var specs = "left=10,top=10,width=1000,height=700";
    specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
    window.open("/service/product_view/"+sv_seq, 'serviceProductView', specs);
}

function listModify(){
    var url = "/api/paymentListUpdate/";
    var datas = $("#listFormP").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){

            console.log(response);
            if(response.result){
                alert("수정완료");
                $(".after-border").each(function(){
                    if(!$(this).hasClass("border-trans")){
                        $(this).addClass("border-trans");
                    }
                })
                // document.location.reload();
            }
        },
        error : function(error){
            console.log(error);
        }
    });
    return false;
}

function getPriceList(){
    var url = "/api/memberPayment/"+$("#mb_seq").val();
        // console.log(searchForm);
        // console.log(url);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){
            // console.log(response);
            var html = "";
            if(response.length > 0){
                for(var i = 0; i < response.length;i++){
                    var num = response.length -  i;
                    var svp_once_price = parseInt(response[i].svp_once_price);
                    var svp_once_dis_price = parseInt(response[i].svp_once_dis_price);
                    var svp_month_price = parseInt(response[i].svp_month_price);
                    var svp_month_dis_price = parseInt(response[i].svp_month_dis_price);
                    var svp_payment_period = parseInt(response[i].svp_payment_period);
                    var svp_discount_price = parseInt(response[i].svp_discount_price);

                    var once_price = svp_once_price-svp_once_dis_price;
                    var price = ( (svp_month_price-svp_month_dis_price)*svp_payment_period-svp_discount_price);
                    var price2 = (((svp_month_price-svp_month_dis_price)*svp_payment_period-svp_discount_price)*1.1)-((svp_month_price-svp_month_dis_price)*svp_payment_period-svp_discount_price);
                    if(svp_discount_price > 0){
                        var price_1 = (svp_month_price-svp_month_dis_price-(svp_discount_price/svp_payment_period));
                        var price2_1 = ((svp_month_price-svp_month_dis_price-(svp_discount_price/svp_payment_period))*1.1)-(svp_month_price-svp_month_dis_price-(svp_discount_price/svp_payment_period));
                    }else{
                        var price_1 = (svp_month_price-svp_month_dis_price);
                        var price2_1 = ((svp_month_price-svp_month_dis_price)*1.1)-(svp_month_price-svp_month_dis_price);
                    }

                    // tax code
                    console.log(response[i].cd_cl_seq);
                    if(response[i].cd_cl_seq === null || response[i].cd_cl_seq == "0" || response[i].cd_cl_seq == ""){
                        var taxcode = "default";
                    }else{
                        var taxcode = "T0"+response[i].cl_code+"-"+response[i].cd_num+response[i].cd_main;
                    }
                    html += '<tr class="payment_tr" data-price="'+price+'">';
                    if(response[i].svp_display_yn == "Y"){
                        html += '<td><input type="checkbox" class="payment_check" value="'+response[i].sv_seq+'" data-price1="'+svp_once_price+'" data-price2="'+svp_once_dis_price+'" data-price3="'+once_price+'" data-price4="'+svp_month_price+'" data-price5="'+svp_month_dis_price+'" data-price6="'+(svp_discount_price/svp_payment_period)+'" data-price7="'+price_1+'" data-price8="'+price2_1+'" data-price9="'+(price_1+price2_1)+'" data-svaseq="'+response[i].sva_seq+'" data-paypublish="'+response[i].sv_pay_publish+'" data-paypublishtype="'+response[i].sv_pay_publish_type+'" data-paymenttype="'+response[i].sv_payment_type+'" data-pmdate="'+moment(new Date()).format("YYYY-MM-DD")+'"></td>'    
                    }else{
                        html += '<td><input type="checkbox" disabled></td>';
                    }
                    html += '<td>'+num+'</td>';
                    html += '<td class="once_number"><a href="javascript:void(0)" onclick="openGroupView(\''+response[i].sv_code+'\')">'+response[i].sv_code+'</td>';
                    html += '<td class="once_service">'+(response[i].sva_seq == "" || response[i].sva_seq === null ? response[i].pc_name:"부가항목")+'</td>';
                    html += '<td class="once_product" ><a href="javascript:void(0)" onclick="openProductView(\''+response[i].sv_seq+'\')">'+(response[i].sva_seq == "" || response[i].sva_seq === null ? response[i].pr_name:response[i].sva_name)+'</a></td>';
                    html += '<td>'+(response[i].sva_seq == "" || response[i].sva_seq === null ? response[i].ps_name:"")+'</td>';
                    html += '<td class="once_service_number"><a href="/service/view/'+response[i].sv_seq+'">'+(response[i].sva_seq == "" || response[i].sva_seq === null ? response[i].sv_number:response[i].sva_number)+'</a></td>';
                    if(response[i].sv_payment_type == "1"){
                        html += '<td>무통장</td>';
                    }else if(response[i].sv_payment_type == "2"){
                        html += '<td>카드</td>';
                    }else{
                        html += '<td>CMS</td>';
                    }
                    html += '<td>'+response[i].svp_payment_period+'개월</td>';
                    html += '<td class="payment-basic right">'+$.number(svp_once_price)+' 원</td>';
                    html += '<td class="payment-basic right" style="color:#FF5353"> - '+$.number(svp_once_dis_price)+' 원</td>';
                    html += '<td style="color:#404040" class="right">'+$.number(once_price)+' 원</td>';
                    html += '<td class="payment-basic right">'+$.number(svp_month_price*svp_payment_period)+' 원</td>';
                    html += '<td class="payment-basic right" style="color:#FF5353"> - '+$.number(svp_month_dis_price*svp_payment_period)+' 원</td>';
                    html += '<td class="payment-basic right" style="color:#FF7053"> - '+$.number(svp_discount_price)+' 원</td>';
                    html += '<td style="color:#404040" class="right">'+$.number(price)+' 원</td>';
                    html += '<td class="right">'+$.number(price2)+' 원</td>';
                    html += '<td class="right">'+$.number(price+price2)+' 원</td>';
                    if(response[i].sv_pay_type == "0"){
                        html += '<td>전월 '+(response[i].sv_pay_day != '28' ? response[i].sv_pay_day:"말")+'일</td>';
                        var cal1 = -1;
                    }else if(response[i].sv_pay_type == "1"){
                        html += '<td>당월 '+(response[i].sv_pay_day != '28' ? response[i].sv_pay_day:"말")+'일</td>';
                        var cal1 = 0;
                    }else if(response[i].sv_pay_type == "2"){
                        html += '<td>익월 '+(response[i].sv_pay_day != '28' ? response[i].sv_pay_day:"말")+'일</td>';
                        var cal1 = 1;
                    }
                    html += '<td>'+response[i].sv_payment_day+'일 이내</td>';
                    var cal = cal1+(parseInt(response[i].sv_pay_day)/30) + (parseInt(response[i].sv_payment_day)/30);
                    if(cal <= 0.3){
                        html += '<td>선불</td>';
                    }else if(cal > 0.3 && cal <= 1.3){
                        html += '<td>후불</td>';
                    }else if(cal > 1.3 && cal <= 2.3){
                        html += '<td>후후불</td>';
                    }else if(cal > 2.3 && cal <= 3.3){
                        html += '<td>후후후불</td>';
                    }else if(cal > 3.3){
                        html += '<td>조정필요</td>';
                    }
                    if(response[i].sv_pay_publish == "0"){
                        if(response[i].sv_pay_publish_type == "0"){
                            html += '<td>영수발행</td>';
                        }else{
                            html += '<td>청구발행</td>';
                        }
                    }else{
                        html += '<td>미발행</td>';
                    }
                    html += '<td>'+taxcode+'</td>';
                    if(response[i].sva_seq == ""){
                        html += '<td><i class="fas fa-edit detailView" data-seq="'+response[i].svp_seq+'" data-paytype="S"></i></td>';
                    }else{
                        html += '<td><i class="fas fa-edit detailView" data-seq="'+response[i].svp_seq+'" data-paytype="A"></i></td>';
                    }
                    html += '<td></td>';
                    html += '</tr>';
                }
            }else{
                html += '<tr>\
                            <td colspan="19" style="text-align:center">요금 정보가 없습니다.</td>\
                        </tr>';
            }

            $("#payment-tbody-list").html(html);
            if($("#all_payment").is(":checked")){
                $("#all_payment").trigger("click");
                $("#all_payment").trigger("click");
            }else{
                $("#all_payment").trigger("click");
            }
            if(payment_extend_view){
                 $(".payment-basic").show();
                $("#payment_extend").html(">");
            }
        }
    });
    
}

function getClaimList(){
    var url = "/api/memberClaim/"+$("#mb_seq").val();
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(row){
            console.log(row);
            var html = "";
            if(row.length > 0){
                var b_pm_ca_seq = ""
                for(var i = 0; i < row.length;i++){
                    if(row[i].sva_seq == "" || row[i].sva_seq === null){
                        var sv_claim_name = row[i].sv_claim_name;
                    }else{
                        var sv_claim_name = row[i].sva_claim_name;
                    }
                    var num = row.length - i;
                    if(row[i].pm_claim_type == "0"){
                        if(row[i].pm_first_month_start == "" || row[i].pm_first_month_start == "0000-00-00" || row[i].pm_first_month_start === null){
                            var month = 0;
                        }else{
                            // var date1 = date('Y-m-d', strtotime($row["pm_first_month_end"] . ' +1 day'));
                            var date1 = moment(row[i].pm_first_month_end).add(2,'days').format("YYYY-MM-DD");
                            var diff = Date.getFormattedDateDiff(row[i].pm_first_month_start, date1);
                            // console.log(diff);
                            var month = parseInt(diff[0]);
                        }
                    }else{
                        if(row[i].pm_service_start == "" || row[i].pm_service_start == "0000-00-00" || row[i].pm_service_start === null){
                            var month = 0;
                        }else{
                            // var date1 = date('Y-m-d', strtotime($row["pm_first_month_end"] . ' +1 day'));
                            var date1 = moment(row[i].pm_service_end).add(2,'days').format("YYYY-MM-DD");
                            var diff = Date.getFormattedDateDiff(row[i].pm_service_start, date1);
                            // console.log(diff);
                            var month = parseInt(diff[0]);
                        }
                    }
                  
                    var pm_once_price = parseInt(row[i].pm_once_price);
                    var pm_once_dis_price = parseInt(row[i].pm_once_dis_price);
                    var pm_payment_dis_price = parseInt(row[i].pm_payment_dis_price);
                    var pm_first_day_price = parseInt(row[i].pm_first_day_price || 0);
                    var pm_service_price = parseInt(row[i].pm_service_price);
                    var pm_service_dis_price = parseInt(row[i].pm_service_dis_price);
                    var pm_pay_period = parseInt(row[i].pm_pay_period);

                    var once_price = pm_once_price-pm_once_dis_price;
                    
                    if(pm_payment_dis_price > 0){
                        var price = pm_first_day_price+once_price+( (pm_service_price-pm_service_dis_price)*month-(pm_payment_dis_price/pm_pay_period)*month);
                        var price2 = (((pm_service_price-pm_service_dis_price)*month-(pm_payment_dis_price/pm_pay_period)*month)*1.1)-((pm_service_price-pm_service_dis_price)*month-(pm_payment_dis_price/pm_pay_period)*month); 
                        var price_1 = (pm_service_price-pm_service_dis_price-(pm_payment_dis_price/pm_pay_period));
                        var price2_1 = ((pm_service_price-pm_service_dis_price-(pm_payment_dis_price/pm_pay_period))*1.1)-(pm_service_price-pm_service_dis_price-(pm_payment_dis_price/pm_pay_period));
                    }else{
                        var price = pm_first_day_price+once_price+( (pm_service_price-pm_service_dis_price)*month);
                        var price2 = (((pm_service_price-pm_service_dis_price)*month)*1.1)-((pm_service_price-pm_service_dis_price)*month);

                        var price_1 = (pm_service_price-pm_service_dis_price);
                        var price2_1 = ((pm_service_price-pm_service_dis_price)*1.1)-(pm_service_price-pm_service_dis_price);
                    }
                    // console.log(price+"::"+price2+"::"+price_1+"::"+price2_1);
                    html += '<tr><input type="hidden" name="pm_seq[]" value="'+row[i].pm_seq+'"><input type="hidden" class="pay_day" value="'+row[i].sv_payment_day+'">';
                    if(pm_payment_dis_price > 0){

                        html += '<td><input type="checkbox" class="claim_check" value="'+row[i].pm_seq+'" data-price1="'+pm_once_price+'" data-price2="'+pm_once_dis_price+'" data-price3="'+once_price+'" data-price4="'+pm_first_day_price+'" data-price5="'+(pm_service_price*month)+'" data-price6="'+(pm_service_dis_price*month)+'" data-price7="'+(pm_payment_dis_price == 0 ? 0:(pm_payment_dis_price/pm_pay_period)*month)+'" data-price8="'+((pm_service_price-pm_service_dis_price)*month-(pm_payment_dis_price/pm_pay_period)*month)+'" data-price9="'+row[i].pm_delay_price+'" data-price10="'+price+'" data-price11="'+(price*0.1)+'" data-price12="'+(price*1.1)+'" data-caseq="'+row[i].pm_ca_seq+'" data-caseqcount="'+row[i].pm_ca_total+'" data-publish="'+row[i].pm_payment_publish_type+'"></td>';
                        // console.log(html);
                    }else{
                        
                        html += '<td><input type="checkbox" class="claim_check" value="'+row[i].pm_seq+'" data-price1="'+pm_once_price+'" data-price2="'+pm_once_dis_price+'" data-price3="'+once_price+'" data-price4="'+pm_first_day_price+'" data-price5="'+(pm_service_price*month)+'" data-price6="'+(pm_service_dis_price*month)+'" data-price7="'+(pm_payment_dis_price == 0 ? 0:(pm_payment_dis_price/pm_pay_period)*month)+'" data-price8="'+(pm_service_price-pm_service_dis_price)*month+'" data-price9="'+row[i].pm_delay_price+'" data-price10="'+price+'" data-price11="'+(price*0.1)+'" data-price12="'+(price*1.1)+'" data-caseq="'+row[i].pm_ca_seq+'" data-caseqcount="'+row[i].pm_ca_total+'" data-publish="'+row[i].pm_payment_publish_type+'"></td>';
                    }
                    html += '<td>'+num+'</td>';
                    html += '<td>'+(row[i].pm_type == "1" ? "서비스비용":"일회성비용")+'</td>';
                    html += '<td>'+row[i].pm_code+'</td>';
                    html += '<td><input type="text" name="pm_date[]" class="border-trans after-border pm_date" data-adddate="'+row[i].sv_payment_day+'" value="'+row[i].pm_date+'" style="width:70px;font-size:9pt;color:#7f7f7f" onfocus="$(this).removeClass(\'border-trans\')" onfocusout="$(this).addClass(\'border-trans\')" ></td>';
                    html += '<td><input type="text" name="pm_service_start[]" class="border-trans after-border" value="'+(row[i].pm_service_start == "0000-00-00" || row[i].pm_service_start === null ? "":row[i].pm_service_start)+'" style="width:70px;font-size:9pt;color:#7f7f7f" onfocus="$(this).removeClass(\'border-trans\')" onfocusout="$(this).addClass(\'border-trans\')">'+(row[i].pm_service_start == "0000-00-00" || row[i].pm_service_start === null ? "":"~")+'<input type="text" name="pm_service_end[]" class="border-trans after-border" value="'+(row[i].pm_service_end == "0000-00-00" || row[i].pm_service_end === null ? "":row[i].pm_service_end)+'" style="width:70px;font-size:9pt;color:#7f7f7f" onfocus="$(this).removeClass(\'border-trans\')" onfocusout="$(this).addClass(\'border-trans\')"></td>';
                    html += '<td >'+(row[i].sva_seq == "" || row[i].sva_seq === null  ? (row[i].pc_name !== null ? row[i].pc_name:""):"부가항목")+'</td>';
                    html += '<td ><a href="javascript:void(0)" onclick="openProductView(\''+row[i].sv_seq+'\')">'+(row[i].sva_seq == "" || row[i].sva_seq === null ? (row[i].pr_name !== null ? row[i].pr_name:""):row[i].sva_name)+'</a></td>';
                    html += '<td>'+(row[i].sva_seq == "" || row[i].sva_seq === null ? (row[i].ps_name !== null ? row[i].ps_name:""):"")+'</td>';
                    html += '<td ><a href="/service/view/'+row[i].sv_seq+'">'+(row[i].sva_seq == "" || row[i].sva_seq === null ? (row[i].sv_number !== null ? row[i].sv_number:""):(row[i].sva_number !== null ? row[i].sva_number:""))+'</a></td>';
                    console.log(row[i].pm_pay_type);
                    if(row[i].pm_pay_type == "1"){
                        html += '<td>무통장</td>';
                    }else if(row[i].pm_pay_type == "2"){
                        html += '<td>카드</td>';
                    }else{
                        html += '<td>CMS</td>';
                    }
                    html += '<td>'+(row[i].pm_type == "1" ? row[i].pm_pay_period+"개월":"0개월")+'</td>';
                    html += '<td class="claim_payment">'+(row[i].pm_claim_name == "" || row[i].pm_claim_name === null ? sv_claim_name:row[i].pm_claim_name)+'</td>';
                    html += '<td class="claim_payment right">'+$.number(pm_once_price)+' 원</td>';
                    html += '<td class="claim_payment right" style="color:#FF5353"> - '+$.number(pm_once_dis_price)+' 원</td>';
                    html += '<td class="claim_payment right" style="color:#404040">'+$.number(once_price)+' 원</td>';
                    html += '<td class="claim_payment right">'+$.number(pm_first_day_price)+' 원</td>';
                    html += '<td class="claim_payment right">'+$.number(pm_service_price*month)+' 원</td>';
                    html += '<td class="claim_payment right" style="color:#FF5353"> - '+$.number(pm_service_dis_price*month)+' 원</td>';
                    if(pm_payment_dis_price > 0){
                        html += '<td class="claim_payment right" style="color:#FF7053"> - '+$.number(pm_payment_dis_price/pm_pay_period*month)+' 원</td>';
                        html += '<td class="claim_payment right" style="color:#404040">'+$.number((pm_service_price-pm_service_dis_price)*month-(pm_payment_dis_price/pm_pay_period)*month)+' 원</td>';
                    }else{
                        html += '<td class="claim_payment right" style="color:#FF7053"> - 0 원</td>';
                        html += '<td class="claim_payment right" style="color:#404040">'+$.number((pm_service_price-pm_service_dis_price)*month)+' 원</td>';
                    }
                    html += '<td class="claim_payment right">'+(row[i].pm_delay_price !== null ? $.number(row[i].pm_delay_price):0)+' 원</td>';
                    html += '<td class="right">'+$.number(price)+' 원</td>';
                    html += '<td class="right">'+$.number(price*0.1)+' 원</td>';
                    html += '<td class="right">'+$.number(price*1.1)+' 원</td>';
                    html += '<td><input type="text" name="pm_end_date[]" class="pm_end_date border-trans" value="'+(row[i].pm_end_date == "0000-00-00" ? "":row[i].pm_end_date)+'" style="width:70px;font-size:9pt;color:#7f7f7f"></td>';

                    if(row[i].pm_status == "1"){
                        html += '<td>완납</td>';
                    }else if(row[i].pm_status == "0"){
                        html += '<td>'+(row[i].pm_end_date >= moment(new Date()).format("YYYY-MM-DD") ? "청구":"미납")+'</td>';
                    }else if(row[i].pm_status == "9"){
                        html += '<td>가결제</td>';
                    }

                    if(b_pm_ca_seq != row[i].pm_ca_seq){
                        html += '<td rowspan="'+row[i].pm_ca_total+'"><i class="fas fa-edit claimView" data-seq="'+row[i].pm_ca_seq+'" style="cursor:pointer"></i></td>';
                        if(row[i].pm_payment_publish == "0"){
                            if(row[i].pm_payment_publish_type == "0"){
                                html += '<td class="billView" data-seq="'+row[i].pm_ca_seq+'" rowspan="'+row[i].pm_ca_total+'" style="cursor:pointer" data-p_type="0">영수발행</td>';
                            }else{
                                html += '<td class="billView" data-seq="'+row[i].pm_ca_seq+'" rowspan="'+row[i].pm_ca_total+'" style="cursor:pointer" data-p_type="1">청구발행</td>';
                            }
                        }else{
                            html += '<td rowspan="'+row[i].pm_ca_total+'">미발행</td>';
                        }
                    }
                    html += '<td><i class="fas fa-edit detailPView" data-seq="'+row[i].pm_seq+'" data-pmtype="'+row[i].pm_type+'" '+(row[i].pm_sva_seq !== null ? "data-type=\"2\"":"data-type=\"1\"")+' style="cursor:pointer"></i></td>';
                    html += '<td></td>';
                    html += '</tr>';
                    b_pm_ca_seq = row[i].pm_ca_seq;
                }
            }else{
                html += '<tr>\
                                <td colspan="21" style="text-align:center">청구 내역이 없습니다.</td>\
                            </tr>';
            }    
            $("#tbody2-list").html(html);
            if($("#claim_all").is(":checked")){
                $("#claim_all").trigger("click");
                $("#claim_all").trigger("click");
            }else{
                $("#claim_all").trigger("click");
            }
            if(claim_extend_view){
                 $(".claim_payment").show();
                $("#claim_extend").html(">");
            }
        }
    });
}

function getComList(searchYn){
    var url = "/api/memberCom/"+$("#mb_seq").val();
    if(searchYn){
        var datas = $("#searchForm").serialize();
    }else{
        var datas = "search_year="+$("#search_year").val()+"&search_month="+$("#search_month").val();
    }
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : datas,
        success:function(row){
            console.log(row);
            var html = "";
            if(row.length > 0){
                var b_pm_ca_seq = ""
                for(var i = 0; i < row.length;i++){
                    if(row[i].sva_seq == "" || row[i].sva_seq === null){
                        var sv_claim_name = row[i].sv_claim_name;
                    }else{
                        var sv_claim_name = row[i].sva_claim_name;
                    }
                    var num = row.length - i;
                    if(row[i].pm_claim_type == "0"){
                        if(row[i].pm_first_month_start == "" || row[i].pm_first_month_start == "0000-00-00" || row[i].pm_first_month_start === null){
                            var month = 0;
                        }else{
                            // var date1 = date('Y-m-d', strtotime($row["pm_first_month_end"] . ' +1 day'));
                            var date1 = moment(row[i].pm_first_month_end).add(2,'days').format("YYYY-MM-DD");
                            var diff = Date.getFormattedDateDiff(row[i].pm_first_month_start, date1);
                            // console.log(diff);
                            var month = parseInt(diff[0]);
                        }
                    }else{
                        if(row[i].pm_service_start == "" || row[i].pm_service_start == "0000-00-00" || row[i].pm_service_start === null){
                            var month = 0;
                        }else{
                            // var date1 = date('Y-m-d', strtotime($row["pm_first_month_end"] . ' +1 day'));
                            var date1 = moment(row[i].pm_service_end).add(2,'days').format("YYYY-MM-DD");
                            var diff = Date.getFormattedDateDiff(row[i].pm_service_start, date1);
                            // console.log(diff);
                            var month = parseInt(diff[0]);
                        }
                    }
                    // console.log(month);
                    var pm_once_price = parseInt(row[i].pm_once_price);
                    var pm_once_dis_price = parseInt(row[i].pm_once_dis_price);
                    var pm_payment_dis_price = parseInt(row[i].pm_payment_dis_price);
                    var pm_first_day_price = parseInt(row[i].pm_first_day_price || 0);
                    var pm_service_price = parseInt(row[i].pm_service_price);
                    var pm_service_dis_price = parseInt(row[i].pm_service_dis_price);
                    var pm_pay_period = parseInt(row[i].pm_pay_period);

                    var once_price = pm_once_price-pm_once_dis_price;
                    
                    if(pm_payment_dis_price > 0){
                        var price = pm_first_day_price+once_price+( (pm_service_price-pm_service_dis_price)*month-(pm_payment_dis_price/pm_pay_period)*month);
                        var price2 = (((pm_service_price-pm_service_dis_price)*month-(pm_payment_dis_price/pm_pay_period)*month)*1.1)-((pm_service_price-pm_service_dis_price)*month-(pm_payment_dis_price/pm_pay_period)*month); 
                        var price_1 = (pm_service_price-pm_service_dis_price-(pm_payment_dis_price/pm_pay_period));
                        var price2_1 = ((pm_service_price-pm_service_dis_price-(pm_payment_dis_price/pm_pay_period))*1.1)-(pm_service_price-pm_service_dis_price-(pm_payment_dis_price/pm_pay_period));
                    }else{
                        var price = pm_first_day_price+once_price+( (pm_service_price-pm_service_dis_price)*month);
                        var price2 = (((pm_service_price-pm_service_dis_price)*month)*1.1)-((pm_service_price-pm_service_dis_price)*month);

                        var price_1 = (pm_service_price-pm_service_dis_price);
                        var price2_1 = ((pm_service_price-pm_service_dis_price)*1.1)-(pm_service_price-pm_service_dis_price);
                    }
                    // console.log(price+"::"+price2+"::"+price_1+"::"+price2_1);
                    html += '<tr><input type="hidden" name="pm_seq[]" value="'+row[i].pm_seq+'"><input type="hidden" class="pay_day" value="'+row[i].sv_payment_day+'">';
                    if(pm_payment_dis_price > 0){

                        html += '<td><input type="checkbox" class="paycom_check" value="'+row[i].pm_seq+'" data-price1="'+pm_once_price+'" data-price2="'+pm_once_dis_price+'" data-price3="'+once_price+'" data-price4="'+pm_first_day_price+'" data-price5="'+(pm_service_price*month)+'" data-price6="'+(pm_service_dis_price*month)+'" data-price7="'+(pm_payment_dis_price == 0 ? 0:(pm_payment_dis_price/pm_pay_period)*month)+'" data-price8="'+((pm_service_price-pm_service_dis_price)*month-(pm_payment_dis_price/pm_pay_period)*month)+'" data-price9="'+row[i].pm_delay_price+'" data-price10="'+price+'" data-price11="'+(price*0.1)+'" data-price12="'+(price*1.1)+'" data-caseq="'+row[i].pm_ca_seq+'" data-caseqcount="'+row[i].pm_ca_total+'" data-publish="'+row[i].pm_payment_publish_type+'"></td>';
                        // console.log(html);
                    }else{
                        
                        html += '<td><input type="checkbox" class="paycom_check" value="'+row[i].pm_seq+'" data-price1="'+pm_once_price+'" data-price2="'+pm_once_dis_price+'" data-price3="'+once_price+'" data-price4="'+pm_first_day_price+'" data-price5="'+(pm_service_price*month)+'" data-price6="'+(pm_service_dis_price*month)+'" data-price7="'+(pm_payment_dis_price == 0 ? 0:(pm_payment_dis_price/pm_pay_period)*month)+'" data-price8="'+(pm_service_price-pm_service_dis_price)*month+'" data-price9="'+row[i].pm_delay_price+'" data-price10="'+price+'" data-price11="'+(price*0.1)+'" data-price12="'+(price*1.1)+'" data-caseq="'+row[i].pm_ca_seq+'" data-caseqcount="'+row[i].pm_ca_total+'" data-publish="'+row[i].pm_payment_publish_type+'"></td>';
                    }
                    html += '<td>'+num+'</td>';
                    html += '<td>'+(row[i].pm_type == "1" ? "서비스비용":"일회성비용")+'</td>';
                    html += '<td>'+row[i].pm_code+'</td>';
                    html += '<td>'+row[i].pm_date+'</td>';
                    html += '<td>'+moment(row[i].pm_com_date).format("YYYY-MM-DD")+'</td>';
                    html += '<td>'+(row[i].pm_service_start == "0000-00-00" || row[i].pm_service_start === null ? "":row[i].pm_service_start)+''+(row[i].pm_service_start == "0000-00-00" || row[i].pm_service_start === null ? "":"~")+''+(row[i].pm_service_end == "0000-00-00" || row[i].pm_service_end === null ? "":row[i].pm_service_end)+'</td>';
                    html += '<td >'+(row[i].sva_seq == "" || row[i].sva_seq === null  ? (row[i].pc_name !== null ? row[i].pc_name:""):"부가항목")+'</td>';
                    html += '<td ><a href="javascript:void(0)" onclick="openProductView(\''+row[i].sv_seq+'\')">'+(row[i].sva_seq == "" || row[i].sva_seq === null ? (row[i].pr_name !== null ? row[i].pr_name:""):row[i].sva_name)+'</a></td>';
                    html += '<td>'+(row[i].sva_seq == "" || row[i].sva_seq === null ? (row[i].ps_name !== null ? row[i].ps_name:""):"")+'</td>';
                    html += '<td ><a href="/service/view/'+row[i].sv_seq+'">'+(row[i].sva_seq == "" || row[i].sva_seq === null ? (row[i].sv_number !== null ? row[i].sv_number:""):(row[i].sva_number !== null ? row[i].sva_number:""))+'</a></td>';
                    if(row[i].pm_pay_type == "1"){
                        html += '<td>무통장</td>';
                    }else if(row[i].pm_pay_type == "2"){
                        html += '<td>카드</td>';
                    }else{
                        html += '<td>CMS</td>';
                    }
                    html += '<td>'+(row[i].pm_type == "1" ? row[i].pm_pay_period+"개월":"0개월")+'</td>';
                    html += '<td class="paycom_payment">'+(row[i].pm_claim_name == "" || row[i].pm_claim_name === null ? sv_claim_name:row[i].pm_claim_name)+'</td>';
                    html += '<td class="paycom_payment right">'+$.number(pm_once_price)+' 원</td>';
                    html += '<td class="paycom_payment right" style="color:#FF5353"> - '+$.number(pm_once_dis_price)+' 원</td>';
                    html += '<td class="paycom_payment right" style="color:#404040">'+$.number(once_price)+' 원</td>';
                    html += '<td class="paycom_payment right">'+$.number(pm_first_day_price)+' 원</td>';
                    html += '<td class="paycom_payment right">'+$.number(pm_service_price*month)+' 원</td>';
                    html += '<td class="paycom_payment right" style="color:#FF5353"> - '+$.number(pm_service_dis_price*month)+' 원</td>';
                    if(pm_payment_dis_price > 0){
                        html += '<td class="paycom_payment right" style="color:#FF7053"> - '+$.number(pm_payment_dis_price/pm_pay_period*month)+' 원</td>';
                        html += '<td class="paycom_payment right" style="color:#404040">'+$.number((pm_service_price-pm_service_dis_price)*month-(pm_payment_dis_price/pm_pay_period)*month)+' 원</td>';
                    }else{
                        html += '<td class="paycom_payment right" style="color:#FF7053"> - 0 원</td>';
                        html += '<td class="paycom_payment right" style="color:#404040">'+$.number((pm_service_price-pm_service_dis_price)*month)+' 원</td>';
                    }
                    html += '<td class="paycom_payment right">'+(row[i].pm_delay_price !== null ? $.number(row[i].pm_delay_price):0)+' 원</td>';
                    html += '<td class="right">'+$.number(price)+' 원</td>';
                    html += '<td class="right">'+$.number(price*0.1)+' 원</td>';
                    html += '<td class="right">'+$.number(price*1.1)+' 원</td>';
                    // html += '<td><input type="text" name="pm_end_date[]" class="pm_end_date border-trans" value="'+(row[i].pm_end_date == "0000-00-00" ? "":row[i].pm_end_date)+'" style="width:70px;font-size:9pt;color:#7f7f7f"></td>';

                    // if(row[i].pm_status == "1"){
                    //     html += '<td>완납</td>';
                    // }else if(row[i].pm_status == "0"){
                    //     html += '<td>'+(row[i].pm_end_date >= moment(new Date()).format("YYYY-MM-DD") ? "청구":"미납")+'</td>';
                    // }else if(row[i].pm_status == "9"){
                    //     html += '<td>가결제</td>';
                    // }

                    if(b_pm_ca_seq != row[i].pm_ca_seq){
                        html += '<td rowspan="'+row[i].pm_ca_total+'"><i class="fas fa-edit claimView" data-seq="'+row[i].pm_ca_seq+'" style="cursor:pointer"></i></td>';
                        if(row[i].pm_payment_publish_type == "0"){
                            html += '<td class="billView" data-seq="'+row[i].pm_ca_seq+'" rowspan="'+row[i].pm_ca_total+'" style="cursor:pointer" data-p_type="0">영수발행</td>';
                        }else{
                            html += '<td class="billView" data-seq="'+row[i].pm_ca_seq+'" rowspan="'+row[i].pm_ca_total+'" style="cursor:pointer" data-p_type="1">청구발행</td>';
                        }
                    }
                    html += '<td><i class="fas fa-edit detailCView" data-seq="'+row[i].pm_seq+'" data-pmtype="'+row[i].pm_type+'" style="cursor:pointer"></i></td>';
                    html += '<td></td>';
                    html += '</tr>';
                    b_pm_ca_seq = row[i].pm_ca_seq;
                }
            }else{
                html += '<tr>\
                                <td colspan=20" style="text-align:center">결제내역이 없습니다.</td>\
                            </tr>';
            }    
            $("#tbody3-list").html(html);
            if($("#paycom_all").is(":checked")){
                $("#paycom_all").trigger("click");
                $("#paycom_all").trigger("click");
            }else{
                $("#paycom_all").trigger("click");
            }

            if(paycom_extend_view){
                 $(".paycom_payment").show();
                $("#paycom_extend").html(">");
            }
            
        }
    });
}
function getLog(){

    var url = "/api/fetchLogs/1/"+$("#mb_seq").val();
    var end = $("#log_end").val();
    var start = $("#log_start").val();
    var datas = $("#logForm").serialize();
// alert(start);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : datas+"&mb_seq="+$("#mb_seq").val()+"&start="+start+"&end="+end,
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

function getAllLog(){

    var url = "/api/fetchAllLogs/"+$("#mb_seq").val();
    var end = $("#log_all_end").val();
    var start = $("#log_all_start").val();
    var datas = $("#logFormAll").serialize();
// alert(start);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : datas+"&mb_seq="+$("#mb_seq").val()+"&start="+start+"&end="+end,
        success:function(response){
            var html = "";
            for(var i = 0;i<response.list.length;i++){
                var num = parseInt(response.total) - (($("#log_all_start").val()-1)*end) - i;
                if(response.list[i].sv_number !== null){
                    var sv_number = response.list[i].sv_number;
                }else if(response.list[i].sva_number !== null){
                    var sv_number = response.list[i].sva_number;
                }else{
                    var sv_number = "";
                }
                html += '<tr>\
                            <td>'+num+'</td>\
                            <td>'+response.list[i].lo_regdate+'</td>\
                            <td>'+sv_number+'</td>\
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
                html = "<tr><td colspan=10 align=center>내용이 없습니다.</td></tr>";
            }
            console.log(html);
            $("#log-list-all").html(html);

            $("#logPagingAll").bootpag({
                total : Math.ceil(parseInt(response.total)/end), // 총페이지수 (총 Row / list노출개수)
                page : $("#log_all_start").val(), // 현재 페이지 default = 1
                maxVisible:5, // 페이지 숫자 노출 개수
                wrapClass : "pagination",
                next : ">",
                prev : "<",
                nextClass : "last",
                prevClass : "first",
                activeClass : "active"

            }).on('page', function(event,num){ // 이벤트 액션
                // document.location.href='/pageName/'+num; // 페이지 이동
                $("#log_all_start").val(num);
                getAllLog();
            })
        },
        error: function(error){
            console.log(error);
        }
    });
}