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
        if($("#b_sv_code").val() == $("#sv_code1").val()+"-"+$("#sv_code2").val()){
            alert("사용가능한 계약번호 입니다.");
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
        if($(this).data("modify") == "0"){
            var msg = "등록하시겠습니까?";
        }else{
            var msg = "수정하시겠습니까?";
        }
        if(confirm(msg)){
            var url = "/api/updateServiceOutInfo";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sv_seq="+$("#sv_seq").val()+"&"+$("#outForm").serialize(),
                success:function(response){
                    if(response.result){
                        alert("처리완료");
                        $("#sv_out_date_str").html($("#sv_out_date").val());
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

    $(".btn-delete").click(function(){
        if(confirm("삭제하시겠습니까?")){
            var sv_seq = $(this).data("seq");
            var url = "/api/serviceDelete";

            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sv_seq="+sv_seq,
                success:function(response){
                    if(response.result){
                        alert("삭제되었습니다");
                        // getMemo();
                        document.location.href='/service/list'
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    })

    $(".btn-edit").click(function(){
        if($("#b_sv_code").val() != $("#sv_code1").val()+"-"+$("#sv_code2").val()){
            if($("#dupleNumberYn").val() == "N"){
                alert("계약번호 중복체크를 하시기 바랍니다.");
                return false;
            }
        }
        if(confirm("수정하시겠습니까?")){
            // var sv_seq = $(this).data("seq");
            // $("#edit").submit();
            // return false;
            var url = "/api/serviceViewUpdate";
            // $("#edit").attr("method",)
            var datas = $("#edit").serialize();
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    if(response.result){
                        alert("수정되었습니다");
                        // getMemo();
                        document.location.reload();
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    })

    $("body").on("click",".editEnd",function(){
        // console.log($(this).parent().children("td").eq(1).children("input").length);
        if($(this).parent().children("td").eq(1).children("input").length > 0){
            var url = "/api/endUserUpdate/"+$(this).data("seq");
            var editname = $(this).parent().children("td").eq(1).children("input").val();
            var that = $(this);
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "eu_name="+editname,
                success:function(response){
                    // typeGetList();
                    alert("수정되었습니다.");
                    that.parent().children("td").eq(0).children("a").data("name",editname);
                    that.parent().children("td").eq(1).html(editname);
                    that.parent().children("td").eq(2).data("name",editname);
                }
            });
        }else{
            $(this).parent().children("td").eq(1).html("<input type='text' name='end_mode_name' value='"+$(this).data("name")+"'>");
        }

    });

    $("body").on("click",".deleteEnd",function(){
        if(confirm("삭제하시겠습니까?")){
            var that = $(this);
            var url = "/api/endUserDelete/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    // typeGetList();
                    alert("삭제되었습니다.");
                    that.parent().remove();
                }
            });
        }
    });

    $("#endAdd").submit(function(){
        if($("#addEnd").val() == ""){
            alert("코드를 입력해 주시기 바랍니다.");
            return false;
        }
        if($("#add_eu_name").val() == ""){
            alert("End User를 입력해 주시기 바랍니다.");
            return false;
        }
        var url = "/api/endUserAdd";
        var datas = $("#endAdd").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                // typeGetList();
                if(response.result){
                    alert("등록되었습니다.");
                    getEndUserNextNumber();
                    $("#endSearchForm").submit();
                }else{
                    alert(response.msg);
                }
            }
        });
        return false;
    });

    $("body").on("click",".editType",function(){
        // console.log($(this).parent().children("td").eq(1).children("input").length);
        if($(this).parent().children("td").eq(1).children("input").length > 0){
            var url = "/api/companyTypeUpdate/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "ct_name="+$(this).parent().children("td").eq(1).children("input").val(),
                success:function(response){
                    alert("수정되었습니다.");
                    typeGetList();
                }
            });
        }else{
            $(this).parent().children("td").eq(1).html("<input type='text' name='mode_name' value='"+$(this).data("name")+"'>");
        }

    });

    $("body").on("click",".deleteType",function(){
        if(confirm("삭제하시겠습니까?")){
            var url = "/api/companyTypeDelete/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    typeGetList();
                }
            });
        }
    });

    $("#typeAdd").submit(function(){
        if($("#addType").val() == ""){
            alert("코드를 입력해 주세요");
            return false;
        }

        if($("#add_ct_name").val() == ""){
            alert("분류명을 입력해 주세요");
            return false;
        }
        var url = "/api/companyTypeAdd";
        var datas = $("#typeAdd").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                // console.log(response);
                if(response.result){
                    alert("저장되었습니다.");
                    typeGetList();
                }else{
                    alert(response.msg);

                }

            }
        });
        return false;
    });

    $("#endSearchWord").autocomplete({
        source : function (request, response) {
            // $.post('http://'+$('#apiHost').val()+':'+$('#apiPort').val()+'/products/_search/1/limit/20', request, response);
            $.ajax( {
                method : "GET",
                url: '/api/endUserList',
                dataType: "json",
                data: {
                    endSearchWord: request.term
                },
                success: function( data ) {
                    // alert(1);
                    // console.log(data);
                    response( data.list );
                }
            });
        },
        minLength: 1,
        focus: function( event, ui ) {
            $( "#endSearchWord" ).val( ui.item.eu_name );
            return false;
        },
        select : function(event,ui){
            $( "#endSearchWord" ).val( ui.item.eu_name );
            return false;
        },
        open: function(){
            setTimeout(function () {
                $('.ui-autocomplete').css('z-index', 102);
            }, 0);
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        console.log(ul);
        return $( "<li>" )
            .append( item.eu_name )
            .appendTo( ul );
    };

    $("#typeSearchWord").autocomplete({
        source : function (request, response) {
            // $.post('http://'+$('#apiHost').val()+':'+$('#apiPort').val()+'/products/_search/1/limit/20', request, response);
            $.ajax( {
                method : "GET",
                url: '/api/companyTypeList',
                dataType: "json",
                data: {
                    typeSearchWord: request.term
                },
                success: function( data ) {
                    response( data.list );
                }
            });
        },
        minLength: 1,
        focus: function( event, ui ) {
            $( "#typeSearchWord" ).val( ui.item.ct_name );
            return false;
        },
        select : function(event,ui){
            $( "#typeSearchWord" ).val( ui.item.ct_name );
            return false;
        },
        open: function(){
            setTimeout(function () {
                $('.ui-autocomplete').css('z-index', 102);
            }, 0);
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
            .append( item.ct_name )
            .appendTo( ul );
    };

    $("#sv_rental_type").change(function(){
        if($(this).val() == "1"){
            $("#sv_rental_date").hide();
            $(".sv_rental_date").hide();
        }else{
            $("#sv_rental_date").show();
            $(".sv_rental_date").show();
        }
    })

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
})

var getEndUserNextNumber = function(){
    var url = "/api/endUserNextCode";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){

            $("#addEnd").val(response);
            $("#add_eu_name").val("");
        }
    });
}
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
    if($("#view_service_open").css("display") != "none"){
        $("#view_service_open").hide();
        $("#edit_service_open").show();
    }else{
        if(confirm("수정 하시겠습니까?")){
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
                var num = parseInt(response.list.length)  - i;
                html += '<tr>\
                            <td>'+num+'</td>\
                            <td>'+response.list[i].sm_regdate+'</td>\
                            <td><div id="msg_show_'+response.list[i].sm_seq.replace(/\n/g, "<br />")+'">'+response.list[i].sm_msg.replace(/\n/g, "<br />")+'</div><div id="msg_hide_'+response.list[i].sm_seq+'" style="display:none"><textarea style="width:100%;height:50px" id="sm_msg_'+response.list[i].sm_seq+'">'+response.list[i].sm_msg+'</textarea></div></td>\
                            <td></td>\
                            <td class="btn-service-msg-modify" data-seq="'+response.list[i].sm_seq+'"><i class="fas fa-edit"></i></td>\
                            <td class="btn-service-msg-delete" data-seq="'+response.list[i].sm_seq+'"><i class="fas fa-trash"></i></td>\
                        </tr>';
            }
            if(html == ""){
                html = "<tr><td colspan=6 align=center>내용이 없습니다.</td></tr>";
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

function openProductView(sv_seq){
        var specs = "left=10,top=10,width=1000,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/service/product_view/"+sv_seq, 'serviceProductView', specs);
    }

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