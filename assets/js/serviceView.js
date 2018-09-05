$(function(){
    getMemo();
    $( "#dialogOut" ).dialog({
        autoOpen: false,
        modal: true,
        width:'700px',
        height : 450
    });

    $( "#dialogStop" ).dialog({
        autoOpen: false,
        modal: true,
        width:'700px',
        height : 450
    });

    $( "#dialogEnd" ).dialog({
        autoOpen: false,
        modal: true,
        width:'700px',
        height : 450
    });

    $("body").on("click",".clickEnd",function(){
        $("#eu_name").val($(this).data("name"));
        $("#sv_eu_seq").val($(this).data("seq"));
        $('#dialogEndSearch').dialog('close');
    });

    $("body").on("click",".clickType",function(){
        $("#ct_name").val($(this).data("name"));
        $("#sv_ct_seq").val($(this).data("seq"));
        $('#dialogTypeSearch').dialog('close');
    });

    $(".btn-number-duple").click(function(){
        if($("#sv_code1").val() == "" || $("#sv_code2").val() == ""){
            alert("계약 번호를 입력해 주시기 바랍니다.");
            return false;
        }
        var url = "/api/serviceNumberCheck";
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "sr_code="+$("#sv_code1").val()+"-"+$("#sv_code2").val(),
            success:function(response){
                if(response.result == true){
                    alert("계약번호가 존재 합니다. 다른 계약번호로 설정해주시기 바랍니다.");
                    $("#dupleNumberYn").val("N");
                    return false;
                }else{
                    alert("사용가능한 계약번호 입니다.");
                    $("#dupleNumberYn").val("Y");
                    return false;
                }
            }
        });
    });

    $(".btn-out-reg").click(function(){
        if($("#sv_out_date").val() == ""){
            alert("출고일을 입력해 주세요");
            return false;
        }

        if($("#sv_out_serial").val() == ""){
            alert("제품 시리얼을 입력해 주세요");
            return false;
        }
        if(confirm("등록하시겠습니까?")){
            var url = "/api/updateServiceOutInfo";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sv_seq="+$("#sv_seq").val()+"&"+$("#outForm").serialize(),
                success:function(response){
                    if(response.result){
                        alert("처리완료");
                        $('#dialogOut').dialog('close')
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    });

    $(".btn-manager-change").click(function(){
        if($("#sv_engineer_part").val() == ""){
            alert("부서를 선택해 주세요");
            return false;
        }

        if($("#sv_engineer_charger").val() == ""){
            alert("담당자를 선택해 주세요");
            return false;
        }

        if($("#sv_status").val() == "0"){
            alert("입금대기중 상태는 담당자 지정 및 서비스 상태 변경이 불가합니다.");
            return false;
        }

        if($("#sv_status").val() == "1"){
            var url = "/api/updateServiceCharger";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sv_seq="+$("#sv_seq").val()+"&sv_status=2&sv_engineer_part="+$("#sv_engineer_charger").val()+"&sv_engineer_charger="+$("#sv_engineer_charger").val(),
                success:function(response){
                    if(response.result){
                        alert("처리완료");
                        // $('#dialogOut').dialog('close')
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }else{
            var url = "/api/updateServiceCharger";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sv_seq="+$("#sv_seq").val()+"&sv_engineer_part="+$("#sv_engineer_charger").val()+"&sv_engineer_charger="+$("#sv_engineer_charger").val(),
                success:function(response){
                    if(response.result){
                        alert("처리완료");
                        // $('#dialogOut').dialog('close')
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    })

    $(".btn-service-open").click(function(){
        if(confirm("서비스 상태를 [서비스중]으로 변경합니다. 진행하시겠습니까?")){
            var url = "/api/updateServiceOpen";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sv_seq="+$("#sv_seq").val(),
                success:function(response){
                    if(response.result){
                        alert("처리완료");
                        // $('#dialogOut').dialog('close')
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    })

    $("#sv_service_end_msg").change(function(){
        if($(this).val() == "기타"){
            $("#sv_service_end_msg_etc").show();
        }else{
            $("#sv_service_end_msg_etc").hide();
        }
    })

    $(".btn-stop-reg").click(function(){
        if($("#sv_service_stop").val() == ""){
            alert("서비스 중지일을 선택해 주세요");
            return false;
        }

        if($("#sv_service_restart").val() == ""){
            alert("서비스 재시작일을 선택해 주세요");
            return false;
        }

        if($("#sv_service_stop").val() > $("#sv_service_restart").val()){
            alert("날짜를 다시 선택해 주세요");
            return false;
        }

        var monthAdd = moment($("#sv_service_stop").val()).add(1, 'M');
        console.log(monthAdd);
        if(monthAdd > $("#sv_service_restart").val()){
            alert("서비스 중지 기간은 1개월을 초과할 수 없습니다.");
            return false;
        }

        if(confirm("서비스 상태를 [서비스중지]로 변경합니다. 진행하시겠습니까?")){
            var url = "/api/updateServiceStop";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sv_seq="+$("#sv_seq").val()+"&sv_status=4&sv_service_stop="+$("#sv_service_stop").val()+"&sv_service_restart="+$("#sv_service_restart").val()+"&sv_service_stop_msg="+$("#sv_service_stop_msg").val(),
                success:function(response){
                    if(response.result){
                        alert("처리완료");
                        $('#dialogStop').dialog('close')
                        // $('#dialogOut').dialog('close')
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    })

    $(".btn-end-reg").click(function(){
        if($("#sv_service_end_msg").val() == "etc"){
            if($("#sv_service_end_msg_etc").val() == ""){
                alert("기타 사유를 입력해 주세요");
                return false;
            }
        }

        if(confirm("서비스 상태를 [서비스해지]로 변경합니다. 진행하시겠습니까?")){
            $("#end_yn").val("Y");
            alert("서비스 해지 버튼을 한번더 클릭하면 해지처리됩니다.");
            $('#dialogEnd').dialog('close')
        }
    })

    $(".btn-service-forcestop").click(function(){
        if(confirm("서비스 상태를 [직권중지]로 변경합니다. 진행하시겠습니까?")){
            var url = "/api/updateServiceForceStop";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sv_seq="+$("#sv_seq").val(),
                success:function(response){
                    if(response.result){
                        alert("처리완료");
                        // $('#dialogStop').dialog('close')
                        // $('#dialogOut').dialog('close')
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    })
    $(".btn-forceend-reg").click(function(){
        if($("#sv_service_end_msg").val() == "etc"){
            if($("#sv_service_end_msg_etc").val() == ""){
                alert("기타 사유를 입력해 주세요");
                return false;
            }
        }

        if(confirm("서비스 상태를 [직권해지]로 변경합니다. 진행하시겠습니까?")){
            $("#force_end_yn").val("Y");
            alert("직권 해지 버튼을 한번더 클릭하면 해지처리됩니다.");
            $('#dialogForceEnd').dialog('close')
        }
    })

    $(".btn-service-restart").click(function(){
        if(confirm("서비스 상태를 [서비스중]으로 변경합니다. 진행하시겠습니까?")){
            var url = "/api/updateServiceRestart";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sv_seq="+$("#sv_seq").val(),
                success:function(response){
                    if(response.result){
                        alert("처리완료");
                        // $('#dialogStop').dialog('close')
                        // $('#dialogOut').dialog('close')
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    })

    $("#file1").change(function(){
        var url = "/api/serviceFileAdd";
        $("#form_file1").ajaxForm({ // submit 액션 생성
            url : url, // url 입력
            enctype : "multipart/form-data", // 파일 업로드 처리
            dataType : "json", // 전송 타입 및 리턴 타입 설정
            error : function(xhr,option,error){ // 에러 처리
                console.log(xhr);
            },
            success : function(data){ // 성공 처리
                console.log(data);
                // $(".basic_file").each(function(i){
                //     $(".bf_sort").eq(i).attr("disabled",false);
                //     $(".bf_seq").eq(i).attr("disabled",false);
                // });
                // alert("기본 첨부파일이 저장 되었습니다.");
                // $("#dialogFile").dialog("close");
                var html = "";
                for(var i = 0; i < data.length;i++){
                    html += '<div style="clear:both;padding-top:3px">\
                                <div style="float:left">\
                                    <div><a href="/api/fileDownload/service_file/?filename='+data[i].sf_file+'&originname='+data[i].sf_origin_file+'">'+data[i].sf_origin_file+'</a></div>\
                                </div>\
                                <div style="float:right">\
                                    <div><button class="btn btn-black btn-upload-del" type="button" data-seq="'+data[i].sf_seq+'">삭제</button></div>\
                                </div>\
                            </div>';
                }
                $("#file1_area").html(html);
            }
        });
        // console.log($("#fileForm").serialize());
        // return false;

        $("#form_file1").submit();
        return false;
    })

    $("#file2").change(function(){
        var url = "/api/serviceFileAdd";
        $("#form_file2").ajaxForm({ // submit 액션 생성
            url : url, // url 입력
            enctype : "multipart/form-data", // 파일 업로드 처리
            dataType : "json", // 전송 타입 및 리턴 타입 설정
            error : function(xhr,option,error){ // 에러 처리
                console.log(xhr);
            },
            success : function(data){ // 성공 처리
                // $(".basic_file").each(function(i){
                //     $(".bf_sort").eq(i).attr("disabled",false);
                //     $(".bf_seq").eq(i).attr("disabled",false);
                // });
                // alert("기본 첨부파일이 저장 되었습니다.");
                // $("#dialogFile").dialog("close");
                var html ="";
                for(var i = 0; i < data.length;i++){
                    html += '<div style="clear:both;padding-top:3px">\
                                <div style="float:left">\
                                    <div><a href="/api/fileDownload/service_file/?filename='+data[i].sf_file+'&originname='+data[i].sf_origin_file+'">'+data[i].sf_origin_file+'</a></div>\
                                </div>\
                                <div style="float:right">\
                                    <div><button class="btn btn-black btn-upload-del" type="button" data-seq="'+data[i].sf_seq+'">삭제</button></div>\
                                </div>\
                            </div>';
                }
                $("#file2_area").html(html);
            }
        });
        // console.log($("#fileForm").serialize());
        // return false;

        $("#form_file2").submit();
        return false;
    })

    $("#file3").change(function(){
        var url = "/api/serviceFileAdd";
        $("#form_file3").ajaxForm({ // submit 액션 생성
            url : url, // url 입력
            enctype : "multipart/form-data", // 파일 업로드 처리
            dataType : "json", // 전송 타입 및 리턴 타입 설정
            error : function(xhr,option,error){ // 에러 처리
                console.log(xhr);
            },
            success : function(data){ // 성공 처리
                // $(".basic_file").each(function(i){
                //     $(".bf_sort").eq(i).attr("disabled",false);
                //     $(".bf_seq").eq(i).attr("disabled",false);
                // });
                // alert("기본 첨부파일이 저장 되었습니다.");
                // $("#dialogFile").dialog("close");
                var html = "";
                for(var i = 0; i < data.length;i++){
                    html += '<div style="clear:both;padding-top:3px">\
                                <div style="float:left">\
                                    <div><a href="/api/fileDownload/service_file/?filename='+data[i].sf_file+'&originname='+data[i].sf_origin_file+'">'+data[i].sf_origin_file+'</a></div>\
                                </div>\
                                <div style="float:right">\
                                    <div><button class="btn btn-black btn-upload-del" type="button" data-seq="'+data[i].sf_seq+'">삭제</button></div>\
                                </div>\
                            </div>';
                }
                $("#file3_area").html(html);
            }
        });
        // console.log($("#fileForm").serialize());
        // return false;

        $("#form_file3").submit();
        return false;
    })

    $("#file4").change(function(){
        var url = "/api/serviceFileAdd";
        $("#form_file4").ajaxForm({ // submit 액션 생성
            url : url, // url 입력
            enctype : "multipart/form-data", // 파일 업로드 처리
            dataType : "json", // 전송 타입 및 리턴 타입 설정
            error : function(xhr,option,error){ // 에러 처리
                console.log(xhr);
            },
            success : function(data){ // 성공 처리
                // $(".basic_file").each(function(i){
                //     $(".bf_sort").eq(i).attr("disabled",false);
                //     $(".bf_seq").eq(i).attr("disabled",false);
                // });
                // alert("기본 첨부파일이 저장 되었습니다.");
                // $("#dialogFile").dialog("close");
                var html = "";
                for(var i = 0; i < data.length;i++){
                    html += '<div style="clear:both;padding-top:3px">\
                                <div style="float:left">\
                                    <div><a href="/api/fileDownload/service_file/?filename='+data[i].sf_file+'&originname='+data[i].sf_origin_file+'">'+data[i].sf_origin_file+'</a></div>\
                                </div>\
                                <div style="float:right">\
                                    <div><button class="btn btn-black btn-upload-del" type="button" data-seq="'+data[i].sf_seq+'">삭제</button></div>\
                                </div>\
                            </div>';
                }
                $("#file4_area").html(html);
            }
        });
        // console.log($("#fileForm").serialize());
        // return false;

        $("#form_file4").submit();
        return false;
    })

    $("#file5").change(function(){
        var url = "/api/serviceFileAdd";
        $("#form_file5").ajaxForm({ // submit 액션 생성
            url : url, // url 입력
            enctype : "multipart/form-data", // 파일 업로드 처리
            dataType : "json", // 전송 타입 및 리턴 타입 설정
            error : function(xhr,option,error){ // 에러 처리
                console.log(xhr);
            },
            success : function(data){ // 성공 처리
                // $(".basic_file").each(function(i){
                //     $(".bf_sort").eq(i).attr("disabled",false);
                //     $(".bf_seq").eq(i).attr("disabled",false);
                // });
                // alert("기본 첨부파일이 저장 되었습니다.");
                // $("#dialogFile").dialog("close");
                var html ="";
                for(var i = 0; i < data.length;i++){
                    html += '<div style="clear:both;padding-top:3px">\
                                <div style="float:left">\
                                    <div><a href="/api/fileDownload/service_file/?filename='+data[i].sf_file+'&originname='+data[i].sf_origin_file+'">'+data[i].sf_origin_file+'</a></div>\
                                </div>\
                                <div style="float:right">\
                                    <div><button class="btn btn-black btn-upload-del" type="button" data-seq="'+data[i].sf_seq+'">삭제</button></div>\
                                </div>\
                            </div>';
                }
                $("#file5_area").html(html);
            }
        });
        // console.log($("#fileForm").serialize());
        // return false;

        $("#form_file5").submit();
        return false;
    })
    $("#file6").change(function(){
        var url = "/api/serviceFileAdd";
        $("#form_file6").ajaxForm({ // submit 액션 생성
            url : url, // url 입력
            enctype : "multipart/form-data", // 파일 업로드 처리
            dataType : "json", // 전송 타입 및 리턴 타입 설정
            error : function(xhr,option,error){ // 에러 처리
                console.log(xhr);
            },
            success : function(data){ // 성공 처리
                // $(".basic_file").each(function(i){
                //     $(".bf_sort").eq(i).attr("disabled",false);
                //     $(".bf_seq").eq(i).attr("disabled",false);
                // });
                // alert("기본 첨부파일이 저장 되었습니다.");
                // $("#dialogFile").dialog("close");
                var html = "";
                for(var i = 0; i < data.length;i++){
                    html += '<div style="clear:both;padding-top:3px">\
                                <div style="float:left">\
                                    <div><a href="/api/fileDownload/service_file/?filename='+data[i].sf_file+'&originname='+data[i].sf_origin_file+'">'+data[i].sf_origin_file+'</a></div>\
                                </div>\
                                <div style="float:right">\
                                    <div><button class="btn btn-black btn-upload-del" type="button" data-seq="'+data[i].sf_seq+'">삭제</button></div>\
                                </div>\
                            </div>';
                }
                $("#file6_area").html(html);
            }
        });
        // console.log($("#fileForm").serialize());
        // return false;

        $("#form_file6").submit();
        return false;
    })
    $("#file7").change(function(){
        var url = "/api/serviceFileAdd";
        $("#form_file7").ajaxForm({ // submit 액션 생성
            url : url, // url 입력
            enctype : "multipart/form-data", // 파일 업로드 처리
            dataType : "json", // 전송 타입 및 리턴 타입 설정
            error : function(xhr,option,error){ // 에러 처리
                console.log(xhr);
            },
            success : function(data){ // 성공 처리
                // $(".basic_file").each(function(i){
                //     $(".bf_sort").eq(i).attr("disabled",false);
                //     $(".bf_seq").eq(i).attr("disabled",false);
                // });
                // alert("기본 첨부파일이 저장 되었습니다.");
                // $("#dialogFile").dialog("close");
                var html = "";
                for(var i = 0; i < data.length;i++){
                    html += '<div style="clear:both;padding-top:3px">\
                                <div style="float:left">\
                                    <div><a href="/api/fileDownload/service_file/?filename='+data[i].sf_file+'&originname='+data[i].sf_origin_file+'">'+data[i].sf_origin_file+'</a></div>\
                                </div>\
                                <div style="float:right">\
                                    <div><button class="btn btn-black btn-upload-del" type="button" data-seq="'+data[i].sf_seq+'">삭제</button></div>\
                                </div>\
                            </div>';
                }
                $("#file7_area").html(html);
            }
        });
        // console.log($("#fileForm").serialize());
        // return false;

        $("#form_file7").submit();
        return false;
    })
    $("#file8").change(function(){
        var url = "/api/serviceFileAdd";
        $("#form_file8").ajaxForm({ // submit 액션 생성
            url : url, // url 입력
            enctype : "multipart/form-data", // 파일 업로드 처리
            dataType : "json", // 전송 타입 및 리턴 타입 설정
            error : function(xhr,option,error){ // 에러 처리
                console.log(xhr);
            },
            success : function(data){ // 성공 처리
                // $(".basic_file").each(function(i){
                //     $(".bf_sort").eq(i).attr("disabled",false);
                //     $(".bf_seq").eq(i).attr("disabled",false);
                // });
                // alert("기본 첨부파일이 저장 되었습니다.");
                // $("#dialogFile").dialog("close");
                var html = "";
                for(var i = 0; i < data.length;i++){
                    html += '<div style="clear:both;padding-top:3px">\
                                <div style="float:left">\
                                    <div><a href="/api/fileDownload/service_file/?filename='+data[i].sf_file+'&originname='+data[i].sf_origin_file+'">'+data[i].sf_origin_file+'</a></div>\
                                </div>\
                                <div style="float:right">\
                                    <div><button class="btn btn-black btn-upload-del" type="button" data-seq="'+data[i].sf_seq+'">삭제</button></div>\
                                </div>\
                            </div>';
                }
                $("#file8_area").html(html);
            }
        });
        // console.log($("#fileForm").serialize());
        // return false;

        $("#form_file8").submit();
        return false;
    })

    $("body").on("click",".btn-upload-del",function(){
        var data = $(this).data("seq");
        var $this = $(this);
        if(confirm("삭제 하시겠습니까?")){
            var url = "/api/serviceFileDelete";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sf_seq="+data,
                success:function(response){
                    if(response.result){

                        $this.parent().parent().parent().remove();
                        // $('#dialogStop').dialog('close')
                        // $('#dialogOut').dialog('close')
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    })

    $(".btn-service-msg").click(function(){
        if($("#sm_msg").val() == ""){
            alert("내용을 입력해 주세요");
            return false;
        }
        var url = "/api/serviceMemoAdd";
        var datas = $("#service_msg").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                if(response.result){

                    getMemo();
                }else{
                    alert("오류발생")
                }
            }
        });

    })

    $("body").on("click",".btn-service-msg-modify",function(){
        var sm_seq = $(this).data("seq");
        console.log($("#msg_hide_"+sm_seq).css("display"));
        if($("#msg_hide_"+sm_seq).css("display") != "none"){
            var url = "/api/serviceMemoModify";
            if($("#sm_msg_"+sm_seq).val() == ""){
                alert("내용을 입력해 주세요");
                return false;
            }
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sm_seq="+sm_seq+"&sm_msg="+$("#sm_msg_"+sm_seq).val(),
                success:function(response){
                    if(response.result){

                        getMemo();
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }else{
            $("#msg_hide_"+sm_seq).show();
            $("#msg_show_"+sm_seq).hide();
        }


    })

    $("body").on("click",".btn-service-msg-delete",function(){
        if(confirm("삭제하시겠습니까?")){
            var sm_seq = $(this).data("seq");
            var url = "/api/serviceMemoDelete";

            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sm_seq="+sm_seq,
                success:function(response){
                    if(response.result){
                        alert("삭제되었습니다");
                        getMemo();
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    });

})
function serviceEnd(){
    if($("#end_yn").val() == "Y"){
        var url = "/api/updateServiceEnd";
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : "sv_seq="+$("#sv_seq").val()+"&sv_service_end="+$("#sv_service_end").val()+"&sv_service_end_msg="+$("#sv_service_end_msg").val()+"&sv_service_end_msg_etc="+$("#sv_service_end_msg_etc").val(),
            success:function(response){
                if(response.result){
                    alert("처리완료")
                }else{
                    alert("오류발생")
                }
            }
        });
    }else{
        $( "#dialogEnd" ).dialog("open");
        $("#dialogEnd").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
    }
}

function serviceForceEnd(){
    if($("#force_end_yn").val() == "Y"){
        var url = "/api/updateServiceForceEnd";
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : "sv_seq="+$("#sv_seq").val()+"&sv_service_end="+$("#sv_service_force_end").val()+"&sv_service_end_msg="+$("#sv_service_force_end_msg").val()+"&sv_service_end_msg_etc="+$("#sv_service_force_end_msg_etc").val(),
            success:function(response){
                if(response.result){
                    alert("처리완료");
                    // $('#dialogStop').dialog('close')
                    // $('#dialogOut').dialog('close')
                }else{
                    alert("오류발생")
                }
            }
        });
    }else{
        $( "#dialogForceEnd" ).dialog("open");
        $("#dialogForceEnd").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
    }
}
function setServiceDate(){
    if($("#view_service_open").css("display") == ""){
        $("#view_service_open").hide();
        $("#edit_service_open").show();
    }else{
        var url = "/api/updateServiceOpenTime";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sv_seq="+$("#sv_seq").val()+"&service_open="+$("#sv_service_start1").val()+" "+$("#sv_service_start2").val()+":"+$("#sv_service_start3").val()+":"+$("#sv_service_start4").val(),
                success:function(response){
                    if(response.result){
                        alert("처리완료");
                        // $('#dialogOut').dialog('close')
                    }else{
                        alert("오류발생")
                    }
                }
            });
    }
}

function getMemo(){

    var url = "/api/serviceMemoFetch";
    var end = 10;
    var start = (parseInt($("#memo_start").val())-1)*end;
// alert(start);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : "sv_seq="+$("#sv_seq").val()+"&start="+start+"&end="+end,
        success:function(response){
            console.log(response);
            var html = "";
            for(var i = 0;i<response.list.length;i++){
                html += '<tr>\
                            <td>1</td>\
                            <td>'+response.list[i].sm_regdate+'</td>\
                            <td><div id="msg_show_'+response.list[i].sm_seq+'">'+response.list[i].sm_msg+'</div><div id="msg_hide_'+response.list[i].sm_seq+'" style="display:none"><textarea style="width:100%;height:50px" id="sm_msg_'+response.list[i].sm_seq+'">'+response.list[i].sm_msg+'</textarea></div></td>\
                            <td></td>\
                            <td class="btn-service-msg-modify" data-seq="'+response.list[i].sm_seq+'">[수정]</td>\
                            <td class="btn-service-msg-delete" data-seq="'+response.list[i].sm_seq+'">[삭제]</td>\
                        </tr>';
            }
            $("#memoList").html(html);

            $("#memoPaging").bootpag({
                total : Math.ceil(parseInt(response.total)/5), // 총페이지수 (총 Row / list노출개수)
                page : $("#memo_start").val(), // 현재 페이지 default = 1
                maxVisible:5, // 페이지 숫자 노출 개수
                wrapClass : "pagination",
                next : ">",
                prev : "<",
                nextClass : "last",
                prevClass : "first",
                activeClass : "active"

            }).on('page', function(event,num){ // 이벤트 액션
                // document.location.href='/pageName/'+num; // 페이지 이동
                $("#memo_start").val(num);
                getMemo();
            })
        }
    });
}