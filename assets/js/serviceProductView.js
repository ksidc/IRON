$(function(){
    getServiceUrl();
    getServiceLicense();
    getServiceModule();
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
        var url = "/api/serviceInstallEdit";
        var datas = $("#installForm").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                alert("수정 되었습니다.");
                // getServiceUrl();
            }
        });
    })

    $(".licenseAdd").click(function(){
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
                html += '<ul style="list-style:none;padding:0;margin:0;height:30px">\
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
            for(var i = 0; i < response.length;i++){
                html += '<tr>\
                <td>1</td>\
                <td><input type="text" id="sl_license_name_'+response[i].sl_seq+'" value="'+response[i].sl_license_name+'" class="border-no" readonly></td>\
                <td><input type="text" id="sl_start_date_'+response[i].sl_seq+'" value="'+response[i].sl_start_date+'" class="border-no" readonly> ~ <input type="text" id="sl_end_date_'+response[i].sl_seq+'" value="'+response[i].sl_end_date+'" class="border-no" readonly></td>\
                <td><input type="text" id="sl_start_date_'+response[i].sl_seq+'" value="'+response[i].sl_contract_number+'" class="border-no" readonly></td>\
                <td><i class="fas fa-edit serviceLicenseEdit" data-seq="'+response[i].sl_seq+'"></i></td>\
                <td><i class="fas fa-trash serviceLicenseDel" data-seq="'+response[i].sl_seq+'"></i></td>\
                </tr>';
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
            for(var i = 0; i < response.length;i++){
                if(response[i].sm_div == "1"){
                    var sm_div = "임대";
                }else if(response[i].sm_div == "2"){
                    var sm_div = "판매";
                }else{
                    var sm_div = "고객 구매";
                }
                html += '<tr>\
                <td>1</td>\
                <td><input type="text" id="sm_name_'+response[i].sm_seq+'" value="'+response[i].sm_name+'" class="border-no" readonly></td>\
                <td>\
                    <div>'+response[i].sm_cnt+'</div>\
                    <div style="display:none">\
                        <select id="sm_cnt_'+response[i].sm_seq+'" class="select2" style="width:160px">\
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
                <td>\
                    <div>'+sm_div+'</div>\
                    <div style="display:none">\
                        <select id="sm_div_'+response[i].sm_seq+'" class="select2" style="width:160px">\
                            <option value="1" '+(response[i].sm_div == "1" ? "selected":"")+'>임대</option>\
                            <option value="2" '+(response[i].sm_div == "2" ? "selected":"")+'>판매</option>\
                            <option value="3" '+(response[i].sm_div == "3" ? "selected":"")+'>고객 구매</option>\
                        </select>\
                    </div>\
                </td>\
                <td><input type="text" id="sm_date_'+response[i].sm_seq+'" value="'+response[i].sm_date+'" class="border-no" readonly></td>\
                <td><i class="fas fa-edit serviceModuleEdit" data-seq="'+response[i].sm_seq+'"></i></td>\
                <td><i class="fas fa-trash serviceModuleDel" data-seq="'+response[i].sm_seq+'"></i></td>\
                </tr>';
            }
            $("#moduleList").html(html);
            $(".select2").select2();
        }
    });
}