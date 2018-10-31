$(function(){
    getServiceUrl();
    getServiceLicense();
    getServiceModule();
    getLog();
    $("body").on("click",".serviceIpDel",function(){
        var url = "/api/serviceInstallIpDel";
        console.log($(this).data("seq"));
        if(confirm("삭제 하시겠습니까?")){
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "sii_seq="+$(this).data("seq"),
                success:function(response){
                    alert("삭제 되었습니다.");
                    getServiceUrl();
                }
            });
        }
    })

    $(".btn-edit").click(function(){
        var url = "/api/productItemSub/"+$("#sv_pi_seq").val();
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                // console.log(response);
                // console.log($("#b_sv_pi_seq").val());
                // console.log($("#sv_pi_seq").val());
                // return false;
                if($("#b_sv_pi_seq").val() != $("#sv_pi_seq").val()){
                    if(response.length > 0){
                        alert("부가항목이 있는 제품군으로 변경은 불가합니다");
                        return false;
                    }
                }

                if(confirm("상품/기술/관제 정보를 수정하시겠습니까?")){
                    var url = "/api/serviceInstallEdit";
                    var datas = $("#edit").serialize();
                    $.ajax({
                        url : url,
                        type : 'POST',
                        dataType : 'JSON',
                        data : datas,
                        success:function(response){
                            alert("수정 되었습니다.");
                            document.location.reload();
                            // getServiceUrl();
                        }
                    });
                }
                
            }

        });
        
    })

    $(".licenseAdd").click(function(){
        if($("#sl_license_name").val() == ""){
            alert("라이선스명을 입력하세요");
            return false;
        }
        if($("#sl_start_date").val() == ""){
            alert("기간을 입력하세요");
            return false;
        }
        if($("#sl_end_date").val() == ""){
            alert("기간을 입력하세요");
            return false;
        }
        if($("#sl_contract_number").val() == ""){
            alert("계약 등록 코드를 입력하세요");
            return false;
        }
        var url = "/api/serviceLicenseAdd";
        var datas = $("#licenseForm").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                alert("등록 되었습니다.");
                $("#sl_license_name").val("");
                $("#sl_start_date").val("");
                $("#sl_end_date").val("");
                $("#sl_contract_number").val("");
                getServiceLicense();
            }
        });
    })

    $(".moduleAdd").click(function(){
        if($("#sm_name").val() == ""){
            alert("모듈명을 입력하세요");
            return false;
        }
        if($("#sm_cnt").val() == ""){
            alert("수량을 선택하세요");
            return false;
        }
        if($("#sm_div").val() == ""){
            alert("분류를 선택하세요");
            return false;
        }
        if($("#sm_date").val() == ""){
            alert("추가 장착일을 입력하세요");
            return false;
        }
        var url = "/api/serviceModuleAdd";
        var datas = $("#moduleForm").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                alert("등록 되었습니다.");
                $("#sm_name").val("");
                $("#sm_cnt").val("1");
                $("#sm_div").val("1");
                $("#sm_date").val("");
                getServiceModule();
            }
        });
    });
    $("body").on("click",".serviceLicenseDel",function(){
        if(confirm("삭제 하시겠습니까?")){
            var url = "/api/serviceLicenseDel";
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "sl_seq="+$(this).data("seq"),
                success:function(response){
                    alert("삭제 되었습니다.");
                    getServiceLicense();
                }
            });
        }
    });

    $("body").on("click",".serviceModuleDel",function(){
        if(confirm("삭제 하시겠습니까?")){
            var url = "/api/serviceModuleDel";
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "sm_seq="+$(this).data("seq"),
                success:function(response){
                    alert("삭제 되었습니다.");
                    getServiceModule();
                }
            });
        }
    });

    $("body").on("click",".serviceIpEdit",function(){
        if($(this).parent().prev().children("input").hasClass("border-no")){
            $(this).parent().prev().children("input").removeClass("border-no").attr("readonly",false)
        }else{
            if(confirm("수정하시겠습니까?")){
                var sii_seq = $(this).parent().prev().children("input").data("seq");
                var sii_name = $(this).parent().prev().children("input").val();
                var url = "/api/serviceInstallIpEdit";
                $.ajax({
                    url : url,
                    type : 'POST',
                    dataType : 'JSON',
                    data : "sii_seq="+sii_seq+"&sii_ip="+sii_name,
                    success:function(response){
                        alert("수정 되었습니다.");
                        getServiceUrl();
                    }
                });
            }
        }
    });

    $("body").on("click",".serviceLicenseEdit",function(){
        if($(this).parent().parent().find("input").hasClass("border-no")){
            $(this).parent().parent().find("input").removeClass("border-no").attr("readonly",false)
        }else{
            if(confirm("수정하시겠습니까?")){
                var sl_seq = $(this).data("seq");
                var sl_license_name = $(this).parent().parent().children("td").eq(1).children("input").val();
                var sl_start_date = $(this).parent().parent().children("td").eq(2).children("input").eq(0).val();
                var sl_end_date = $(this).parent().parent().children("td").eq(2).children("input").eq(1).val();
                var sl_contract_number = $(this).parent().parent().children("td").eq(3).children("input").val();
                var url = "/api/serviceLicenseEdit";
                $.ajax({
                    url : url,
                    type : 'POST',
                    dataType : 'JSON',
                    data : "sl_seq="+sl_seq+"&sl_license_name="+sl_license_name+"&sl_start_date="+sl_start_date+"&sl_end_date="+sl_end_date+"&sl_contract_number="+sl_contract_number,
                    success:function(response){
                        alert("수정 되었습니다.");
                        getServiceLicense();
                    }
                });
            }
        }
    })

    $("body").on("click",".serviceModuleEdit",function(){
        // console.log($(this).parent().parent().children("td").eq(1).children("input"));
        if($(this).parent().parent().children("td").eq(1).children("input").hasClass("border-no")){
            $(this).parent().parent().find("input").removeClass("border-no").attr("readonly",false);
            $(this).parent().parent().children("td").eq(2).children("div").eq(0).hide();
            $(this).parent().parent().children("td").eq(2).children("div").eq(1).show();
            $(this).parent().parent().children("td").eq(3).children("div").eq(0).hide();
            $(this).parent().parent().children("td").eq(3).children("div").eq(1).show();
        }else{

            if(confirm("수정하시겠습니까?")){
                var sm_seq = $(this).data("seq");
                var sm_name = $(this).parent().parent().children("td").eq(1).children("input").val();
                var sm_cnt = $(this).parent().parent().children("td").eq(2).find("select").val();
                var sm_div = $(this).parent().parent().children("td").eq(3).find("select").val();
                var sm_date = $(this).parent().parent().children("td").eq(4).children("input").val();
                var url = "/api/serviceModuleEdit";
                $.ajax({
                    url : url,
                    type : 'POST',
                    dataType : 'JSON',
                    data : "sm_seq="+sm_seq+"&sm_name="+sm_name+"&sm_cnt="+sm_cnt+"&sm_div="+sm_div+"&sm_date="+sm_date,
                    success:function(response){
                        alert("수정 되었습니다.");
                        getServiceModule();
                    }
                });
            }
        }
    });

    $("#sv_pc_seq").change(function(){

        if($(this).val() != ""){
            $("#pc_name").val($("#sv_pc_seq option:selected").text());
            var url = "/api/productItemSearch/"+$(this).val();
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    $('select[name="sv_pi_seq"]').empty().append('<option value="">선택</option>');
                    $("#sv_pi_seq_str").html("선택");
                    for(var i in response){
                        $('select[name="sv_pi_seq"]').append('<option value="'+response[i].pi_seq+'" >'+response[i].pi_name+'</option>');
                    }

                    // if(allPiSeq != ""){
                    //     $('select[name="sv_pi_seq"]').val(allPiSeq).trigger("change");
                    // }
                }

            });
        }else{
            $('select[name="sv_pi_seq"]').empty().append('<option value="">선택</option>');
            $("#sv_pi_seq_str").html("선택");

            $('select[name="sv_pr_seq"]').empty().append('<option value="">선택</option>');
            $("#sv_pr_seq_str").html("선택");

            $("#sv_pr_name").html("상품명");

            $('select[name="sv_pd_seq"]').empty().append('<option value="">선택</option>');
            $("#sv_pd_seq_str").html("선택");

            $('select[name="sv_ps_seq"]').empty().append('<option value="">선택</option>');
            $("#sv_ps_seq_str").html("선택");
        }
    })

    $("#sv_pi_seq").change(function(){
        if($(this).val() != ""){
            $("#pi_name").val($("#sv_pi_seq option:selected").text());
            var url = "/api/productSearch/"+$("#sv_pc_seq").val();
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data:"pi_seq="+$(this).val(),
                success:function(response){
                    $('select[name="sv_pr_seq"]').empty().append('<option value="">선택</option>');
                    $("#sv_pr_seq_str").html("선택");
                    for(var i in response){
                        $('select[name="sv_pr_seq"]').append('<option value="'+response[i].pr_seq+'" data-cseq="'+response[i].pr_c_seq+'" data-cname="'+response[i].c_name+'">'+response[i].pr_name+'</option>');
                    }

                    // if(allPrSeq != ""){
                    //     $('select[name="sv_pr_seq"]').val(allPrSeq).trigger("change");
                    // }
                }

            });

            
        }else{
            $('select[name="sv_pr_seq"]').empty().append('<option value="">선택</option>');
            $("#sv_pr_seq_str").html("선택");

            $("#sv_pr_name").html("상품명");

            $('select[name="sv_pd_seq"]').empty().append('<option value="">선택</option>');
            $("#sv_pd_seq_str").html("선택");

            $('select[name="sv_ps_seq"]').empty().append('<option value="">선택</option>');
            $("#sv_ps_seq_str").html("선택");
        }
    })

    $("#sv_pr_seq").change(function(){
        if($(this).val() != ""){
            $("#pr_name").val($("#sv_pr_seq option:selected").text());
            $("#sv_pr_name").html($("#sv_pr_seq option:selected").text());
            $("#sv_c_seq_str").val($("#sv_pr_seq option:selected").data("cname"));
            $("#sv_c_seq").val($("#sv_pr_seq option:selected").data("cseq"));
            var url = "/api/productSubDepth1Search/"+$(this).val();
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    $('select[name="sv_pd_seq"]').empty().append('<option value="">선택</option>');
                    $("#sv_pd_seq_str").html("선택");
                    for(var i in response){
                        $('select[name="sv_pd_seq"]').append('<option value="'+response[i].pd_seq+'" >'+response[i].pd_name+'</option>');
                    }
                }

            });
        }else{
            $("#sv_pr_name").html("상품명");
            $('select[name="sv_pd_seq"]').empty().append('<option value="">선택</option>');
            $("#sv_pd_seq_str").html("선택");

            $('select[name="sv_ps_seq"]').empty().append('<option value="">선택</option>');
            $("#sv_ps_seq_str").html("선택");
        }
    })

    $("#sv_pd_seq").change(function(){
        if($(this).val() != ""){
            $("#pd_name").val($("#sv_pd_seq option:selected").text());
            var url = "/api/productSubDepth2Search/"+$("#sv_pr_seq").val()+"/"+$(this).val();
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    // console.log(response);
                    $('select[name="sv_ps_seq"]').empty().append('<option value="">선택</option>');
                    $("#sv_ps_seq_str").html("선택");
                    for(var i in response){
                        $('select[name="sv_ps_seq"]').append('<option value="'+response[i].ps_seq+'" data-price="'+response[i].prs_price+'" data-prsoneprice="'+response[i].prs_one_price+'" data-prsmonthprice="'+response[i].prs_month_price+'" data-prsdiv="'+response[i].prs_div+'" data-prsonedisprice="'+response[i].prs_one_dis_price+'" data-prsmonthdisprice="'+response[i].prs_month_dis_price+'">'+response[i].ps_name+'</option>');
                    }
                }

            });
        }else{
            $('select[name="sv_ps_seq"]').empty().append('<option value="">선택</option>');
            $("#sv_ps_seq_str").html("선택");
        }
    });

    $("#sv_ps_seq").change(function(){
        if($(this).val() == ""){
            $("#sv_ps_name").html("소분류");
        }else{
            $("#ps_name").val($("#sv_ps_seq option:selected").text());
            $("#sv_ps_name").html($("#sv_ps_seq option:selected").text());
            
        }

    });

    $(".btn-log-search").click(function(){
        getLog();
    })

    $("#log_end").change(function(){
        getLog();
    })
})

function addServiceUrl(){
    if($("#addUrl").val() == ""){
        alert("IP/URL을 입력하세요");
        return false;
    }
    var url = "/api/serviceInstallIpAdd";
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : "sii_sv_seq="+$("#sv_seq").val()+"&sii_ip="+$("#addUrl").val(),
        success:function(response){
            alert("등록 되었습니다.");

            getServiceUrl();
        }
    });
}

function getServiceUrl(){
    var url = "/api/serviceInstallIpList"
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : "sii_sv_seq="+$("#sv_seq").val(),
        success:function(response){
            console.log(response);
            var html = "";
            for(var i = 0; i < response.length;i++){
                html += '<ul style="list-style:none;padding:0;margin:0;height:20px">\
                    <li style="float:left;width:80%"><input type="text" id="addUrl_'+response[i].sii_ip+'" class="border-no" value="'+response[i].sii_ip+'" readonly data-seq="'+response[i].sii_seq+'" style="width:85%"></li>\
                    <li style="float:left;padding-top:5px"><i class="fas fa-edit serviceIpEdit"></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-trash serviceIpDel" data-seq="'+response[i].sii_seq+'"></i></li>\
                </ul>';
            }
            $(".urlList").html(html);
        }
    });
}

function getServiceLicense(){
    var url = "/api/serviceLicenseList"
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : "sv_seq="+$("#sv_seq").val(),
        success:function(response){
            // console.log(response);
            var html = "";
            if(response.length > 0){
                for(var i = 0; i < response.length;i++){
                    var num = response.length -i;
                    html += '<tr>\
                    <td class="text-center">'+num+'</td>\
                    <td><input type="text" id="sl_license_name_'+response[i].sl_seq+'" value="'+response[i].sl_license_name+'" class="border-no" readonly style="font-size:9pt;color:#7f7f7f;width:100%;"></td>\
                    <td class="text-center"><input type="text" id="sl_start_date_'+response[i].sl_seq+'" value="'+response[i].sl_start_date+'" class="border-no text-center" readonly style="font-size:9pt;color:#7f7f7f;width:80px;"> ~ <input type="text" id="sl_end_date_'+response[i].sl_seq+'" value="'+response[i].sl_end_date+'" class="border-no text-center" readonly style="font-size:9pt;color:#7f7f7f;width:80px;"></td>\
                    <td><input type="text" id="sl_start_date_'+response[i].sl_seq+'" value="'+response[i].sl_contract_number+'" class="border-no" readonly style="font-size:9pt;color:#7f7f7f;width:100%;"></td>\
                    <td class="text-center"><i class="fas fa-edit serviceLicenseEdit" data-seq="'+response[i].sl_seq+'"></i> <i class="fas fa-trash serviceLicenseDel" data-seq="'+response[i].sl_seq+'"></i></td>\
                    </tr>';
                }
            }else{
                html += '<tr><td colspan=6 align=center>내용이 없습니다</td></tr>';
            }
            $("#licenseList").html(html);
        }
    });
}

function getServiceModule(){
    var url = "/api/serviceModuleList"
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : "sv_seq="+$("#sv_seq").val(),
        success:function(response){
            // console.log(response);
            var html = "";
            if(response.length > 0){
                for(var i = 0; i < response.length;i++){
                    var num = response.length -i;
                    if(response[i].sm_div == "1"){
                        var sm_div = "임대";
                    }else if(response[i].sm_div == "2"){
                        var sm_div = "판매";
                    }else{
                        var sm_div = "고객 구매";
                    }
                    html += '<tr>\
                    <td class="text-center">'+num+'</td>\
                    <td><input type="text" id="sm_name_'+response[i].sm_seq+'" value="'+response[i].sm_name+'" class="border-no" readonly style="font-size:9pt;color:#7f7f7f;width:100%;"></td>\
                    <td class="text-center">\
                        <div>'+response[i].sm_cnt+'</div>\
                        <div style="display:none">\
                            <select id="sm_cnt_'+response[i].sm_seq+'" class="select2" style="width:160px" style="font-size:9pt;color:#7f7f7f">\
                                <option value="1" '+(response[i].sm_cnt == "1" ? "selected":"")+'>1</option>\
                                <option value="2" '+(response[i].sm_cnt == "2" ? "selected":"")+'>2</option>\
                                <option value="3" '+(response[i].sm_cnt == "3" ? "selected":"")+'>3</option>\
                                <option value="4" '+(response[i].sm_cnt == "4" ? "selected":"")+'>4</option>\
                                <option value="5" '+(response[i].sm_cnt == "5" ? "selected":"")+'>5</option>\
                                <option value="6" '+(response[i].sm_cnt == "6" ? "selected":"")+'>6</option>\
                                <option value="7" '+(response[i].sm_cnt == "7" ? "selected":"")+'>7</option>\
                                <option value="8" '+(response[i].sm_cnt == "8" ? "selected":"")+'>8</option>\
                                <option value="9" '+(response[i].sm_cnt == "9" ? "selected":"")+'>9</option>\
                                <option value="10" '+(response[i].sm_cnt == "10" ? "selected":"")+'>10</option>\
                            </select>\
                        </div>\
                    </td>\
                    <td class="text-center">\
                        <div>'+sm_div+'</div>\
                        <div style="display:none" >\
                            <select id="sm_div_'+response[i].sm_seq+'" class="select2" style="width:160px;font-size:9pt;color:#7f7f7f";width:120px;>\
                                <option value="1" '+(response[i].sm_div == "1" ? "selected":"")+'>임대</option>\
                                <option value="2" '+(response[i].sm_div == "2" ? "selected":"")+'>판매</option>\
                                <option value="3" '+(response[i].sm_div == "3" ? "selected":"")+'>고객 구매</option>\
                            </select>\
                        </div>\
                    </td>\
                    <td class="text-center"><input type="text" id="sm_date_'+response[i].sm_seq+'" value="'+response[i].sm_date+'" class="border-no text-center" readonly style="font-size:9pt;color:#7f7f7f;width:80px;"></td>\
                    <td class="text-center"><i class="fas fa-edit serviceModuleEdit" data-seq="'+response[i].sm_seq+'"></i> <i class="fas fa-trash serviceModuleDel" data-seq="'+response[i].sm_seq+'"></i></td>\
                    </tr>';
                }
            }else{
                html += '<tr><td colspan=7 align=center>내용이 없습니다.</td></tr>';
            }
            $("#moduleList").html(html);
            $(".select2").select2();
        }
    });
}

function getLog(){

    var url = "/api/fetchLogs/5/"+$("#sv_seq").val();
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