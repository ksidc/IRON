var estimateFiles = [];
$(function(){
    $("#all").click(function(){
        // console.log($(this).is(":checked"));
        if($(this).is(":checked")){
            $(".listCheck").prop("checked",true);
        }else{
            $(".listCheck").prop("checked",false);
        }
    });

    // datepicker
    $( ".datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd',
        showOn: "both",
        buttonText: "<i class='fa fa-calendar-alt'></i>"
    });

    $(".btn-add").click(function(){
        $(".btn-register").text("등록");
        $("#es_seq").val("");
        var url = "/api/estimateNextCode";
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "ef_sessionkey="+$("#ef_sessionkey").val(),
            success:function(response){
                var es_number = response.split("-");
                $("#es_number1").val(es_number[0]);
                $("#es_number2").val("01");

                $("#es_seq").val("");

                $("#es_part").val($("#es_part option:eq(0)").val());
                $("#es_register").val($("#es_register option:eq(0)").val());
                $("#es_part_str").text($("#es_part option:eq(0)").text());
                $("#es_register_str").text($("#es_register option:eq(0)").text());
                $("#es_status").val($("#es_status option:eq(0)").val());
                $("#es_status_str").text("등록");
                $("#es_name").val("");
                $("#es_mb_seq").val("");
                $("#es_charger").val("");
                $("#es_tel").val("");
                $("#es_phone").val("");
                $("#es_email").val("");
                $("#es_fax").val("");
                $("#es_type").val("0");
                $("#es_type_str").text("신규");
                $("#es_company_type").val("");
                $("#es_shot").val("");
                $("#es_end_user").val("");
                $("#es_memo").val("");
                $("#b_es_number").val("");


                $('#dialog').dialog({
                    title: '견적 등록',
                    modal: true,
                    width: '800px',
                    draggable: true
                });
            }
        });


    });

    $(".btn-send-mail").click(function(){

        var checkCount = 0;
        var checkSeq = "";
        $(".listCheck").each(function(){
            if($(this).is(":checked")){
                checkCount++;
                checkSeq = $(this).val();
            }
        });
        if(checkCount > 1){
            alert("한 개의 견적만 발송 가능합니다.");
            return false;
        }else if(checkCount == 0){
            alert("견적을 선택해 주시기 바랍니다.");
            return false;
        }
        var url = "/api/estimateView/"+checkSeq;
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                // console.log(response);
                $("#to").val(response.info.es_email);
                $("#phone").val(response.info.es_phone);
                $("#em_es_seq").val(response.info.es_seq);
                var fileTotalSize = 0;
                if(response.files.length > 0){
                    var html = "";
                    for(var i =0;i < response.files.length;i++){
                        html += '<div style="width:100%;height:30px" class="fileCount" data-filesize="'+response.files[i].ef_file_size+'">\
                                    <div style="width:200px;display:inline-block" >'+response.files[i].ef_origin_file+'</div> <button class="btn btn-default" type="button" style="display:inline-block" onclick="$(this).parent().remove()">삭제</button>\
                                    <input type="hidden" name="ef_file_seq[]" value="'+response.files[i].ef_seq+'|'+response.files[i].ef_origin_file+'|'+response.files[i].ef_file+'">\
                                </div>';
                        fileTotalSize = fileTotalSize+parseInt(response.files[i].ef_file_size);
                    }

                    $(".es_file").html(html);
                }else{
                    $(".es_file").html("");
                }

                if(response.basicfiles.length > 0){
                    html = "";
                    for(var i = 0; i < response.basicfiles.length;i++){
                        html += '<div style="height:30px" class="fileCount" data-filesize="'+response.basicfiles[i].bf_file_size+'">\
                                    첨부파일1 <input type="checkbox" name="file[]" class="basic_file checkfile" value="'+response.basicfiles[i].bf_seq+'|'+response.basicfiles[i].bf_origin_file+'|'+response.basicfiles[i].bf_file+'" checked> '+response.basicfiles[i].bf_origin_file+'\
                                </div>';
                        fileTotalSize = fileTotalSize+parseInt(response.basicfiles[i].bf_file_size);
                    }
                    $(".es_basic_file").html(html);
                }

                if(response.addfiles.length > 0){
                    html = "";
                    for(var i = 0; i < response.addfiles.length;i++){
                        html += '<div style="height:30px" class="fileCount" data-filesize="'+response.addfiles[i].em_file_size+'">\
                                    <input type="checkbox" name="add_file[]" class="add_file checkfile" value="'+response.addfiles[i].em_seq+'|'+response.addfiles[i].em_origin_file+'|'+response.addfiles[i].em_file+'" checked> '+response.addfiles[i].em_origin_file+'\
                                </div>';
                        fileTotalSize = fileTotalSize+parseInt(response.addfiles[i].em_file_size);
                    }
                    $("#mail_add_file").html(html);
                }

                fileCheck();

                $('#dialogEmail').dialog({
                    title: '이메일 발송',
                    modal: true,
                    width: '800px',
                    draggable: true
                });
            }
        });

    });

    $(".btn-basic-setting").click(function(){
        var url = "/api/estimateBasicFileList";
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                console.log(response);
                for(var i =0 ; i < response.list.length;i++){
                    // 기본 4 이상
                    if(i > 3){
                        var add_html = '<div class="modal-field ">\
                                            <div class="modal-field-input">\
                                                <div class="label">첨부파일'+(i+1)+'</div>\
                                                <div class="input"><input type="file" name="basic_file[]" ></div>\
                                                <input type="hidden" name="bf_sort[]" id="bf_sort'+(i+1)+'" value="'+(i+1)+'">\
                                            </div>\
                                            <div class="modal-field-input">\
                                                <div class="file_name'+(i+1)+'"></div>\
                                                <input type="hidden" name="bf_seq[]" id="bf_seq'+(i+1)+'" value="">\
                                            </div>\
                                        </div>';
                        $("#fileForm").append(add_html);

                    }
                    $(".file_name"+response.list[i].bf_sort).html("<a href='/api/fileDownload/basic_file?filename="+response.list[i].bf_file+"&originname="+response.list[i].bf_origin_file+"'>"+response.list[i].bf_origin_file+"</a> <a href='javascript:void(0)' class='btn-file-delete' data-seq='"+response.list[i].bf_seq+"' data-sort='"+response.list[i].bf_sort+"'>X</a>");
                    $("#bf_sort"+response.list[i].bf_sort).val(response.list[i].bf_sort);
                    $("#bf_seq"+response.list[i].bf_sort).val(response.list[i].bf_seq);

                }
                $('#dialogFile').dialog({
                    title: '기본 첨부 파일',
                    modal: true,
                    width: '600px',
                    draggable: true
                });
            }
        });


    });


    $(".fileform").uniform({
        fileBtnText : "찾아보기"
    });

    $(".btn-register").click(function(){
        var PT_email = /[a-z0-9_]{2,}@[a-z0-9-]{2,}\.[a-z0-9]{2,}/i;



        if($("#es_seq").val() == ""){
            if($("#dupleNumberYn").val() == ""){
                alert("견적번호 중복체크를 진행해 주시기 바랍니다.");
                return false;
            }
            if($("#dupleNumberYn").val() == "N"){
                alert("견적번호가 중복입니다.");
                return false;
            }
        }else{

            if($("#b_es_number").val() != $("#es_number1").val()+"-"+$("#es_number2").val()){
                if($("#dupleNumberYn").val() == ""){
                    alert("견적번호 중복체크를 진행해 주시기 바랍니다.");
                    return false;
                }

                if($("#dupleNumberYn").val() == "N"){
                    alert("견적번호가 중복입니다.");
                    return false;
                }
            }
        }

        if($("#es_name").val() == ""){
            alert("상호/이름을 입력해주시기 바랍니다.");
            return false;
        }

        if($("#es_charger").val() == ""){
            alert("담당자를 입력해주시기 바랍니다.");
            return false;
        }

        if($("#es_tel").val() == ""){
            alert("전화번호를 입력해주시기 바랍니다.");
            return false;
        }

        if($("#es_phone").val() == ""){
            alert("휴대폰번호를 입력해주시기 바랍니다.");
            return false;
        }

        if($("#es_shot").val() == ""){
            alert("견적요약을 입력해주시기 바랍니다.");
            return false;
        }

        // if($("#es_end_user").val() == ""){
        //     alert("End User를 입력해주시기 바랍니다.");
        //     return false;
        // }

        if($("#es_email").val() == ""){
            alert("이메일을 입력해 주세요");
                return false;
        }

        if($("#es_email").val() == ""){
            if (!PT_email.test($("#es_email").val())){
                alert("이메일 형식이 맞지 않습니다.");
                return false;
                // $(this).focus();
            }
        }


        if($("#es_depth1_1").val() == ""){
            alert("서비스종류를 선택해 주세요");
            return false;
        }

        if($("#es_depth2_1").val() == ""){
            alert("상품명을 선택해 주세요");
            return false;
        }

        if($("#es_seq").val() == ""){
            var url = "/api/estimateAdd";
        }else{
            var url = "/api/estimateUpdate/"+$("#es_seq").val();
        }


        $("#registerForm").ajaxForm({ // submit 액션 생성
            url : url, // url 입력
            enctype : "multipart/form-data", // 파일 업로드 처리
            dataType : "json", // 전송 타입 및 리턴 타입 설정
            error : function(xhr,option,error){ // 에러 처리
                console.log(error);
            },
            success : function(data){ // 성공 처리
                // console.log(data);
                if(data.result){
                    if($("#es_seq").val() == ""){
                        alert("견적이 등록 되었습니다.");
                    }else{
                        alert("견적이 수정 되었습니다.");
                    }
                    getList();
                    $("#dialog").dialog( "close" );
                }
            }
        });
        $("#registerForm").submit();
        return false;
    });

    $(".btn-file-register").click(function(){
        // console.log($(".basic_file"));
        $(".basic_file").each(function(i){
            if($(this).val() == ""){
                $(".bf_sort").eq(i).attr("disabled","disabled");
                $(".bf_seq").eq(i).attr("disabled","disabled");
            }
        })

        var url = "/api/estimateBasicFileAdd";
        $("#fileForm").ajaxForm({ // submit 액션 생성
            url : url, // url 입력
            enctype : "multipart/form-data", // 파일 업로드 처리
            dataType : "json", // 전송 타입 및 리턴 타입 설정
            error : function(xhr,option,error){ // 에러 처리
                console.log(xhr);
            },
            success : function(data){ // 성공 처리
                $(".basic_file").each(function(i){
                    $(".bf_sort").eq(i).attr("disabled",false);
                    $(".bf_seq").eq(i).attr("disabled",false);
                });
                alert("기본 첨부파일이 저장 되었습니다.");
                $("#dialogFile").dialog("close");
            }
        });
        // console.log($("#fileForm").serialize());
        // return false;

        $("#fileForm").submit();
        return false;
    })

    $("body").on("click",".btn-file-delete", function(){
        if(confirm("파일을 삭제 하시겠습니까?")){
            var url = "/api/estimateBasicFileDelete/"+$(this).data("seq");
            var sort = $(this).data("sort");
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    if(response.result){
                        alert("삭제 되었습니다.");
                        $(".file_name"+sort).html("");
                        $(".file_name"+sort).next().remove();
                    }
                }
            });
        }
    });

    $( "#dialogUserSearch" ).dialog({
        autoOpen: false,
        modal: true,
        width:'600px',
        height : 450
    });

    $( "#dialogTypeSearch" ).dialog({
        autoOpen: false,
        modal: true,
        width:'400px',
        height : 450
    });

    $( "#dialogEndSearch" ).dialog({
        autoOpen: false,
        modal: true,
        width:'400px',
        height : 450
    });

    getList();


    // 삭제
    $("body").on("click",".btn-delete",function(){
        if(confirm("정말 삭제하시겠습니까?")){
            var es_seq = $(this).data("seq");
            var url = "/api/estimateDelete/";
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "es_seq="+es_seq,
                success:function(response){
                    // console.log(response);
                    if(response.result == true){
                        alert("삭제 되었습니다.");
                        getList();
                    }else{
                        alert("오류가 발생했습니다.");
                        return false;
                    }
                }
            });
        }
    });

    $("body").on("click",".btn-modify",function(){
        var es_seq = $(this).data("seq");
        var url = "/api/estimateView/"+es_seq;
        $(".btn-register").text("수정");
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                // console.log(response);
                if(!response.es_part){
                    response.es_part = "영업팀";
                }

                $("#es_seq").val(response.info.es_seq);
                $("#es_part").val(response.info.es_part);
                $("#es_register").val(response.info.es_register);
                $("#es_part_str").text(response.info.es_part);
                $("#es_register_str").text(response.info.es_register);
                $("#es_status").val(response.info.es_status);
                if(response.info.es_status == "0"){
                    $("#es_status_str").text("등록");
                }else{
                    $("#es_status_str").text("신청완료");
                }
                $("#es_name").val(response.info.es_name);
                $("#es_mb_seq").val(response.info.es_mb_seq);
                $("#es_charger").val(response.info.es_charger);
                $("#es_tel").val(response.info.es_tel);
                $("#es_phone").val(response.info.es_phone);
                $("#es_email").val(response.info.es_email);
                $("#es_fax").val(response.info.es_fax);
                $("#es_type").val(response.info.es_type);
                $("#es_company_type").val(response.info.es_company_type);
                $("#es_company_type_name").val(response.info.ct_name);
                $("#es_shot").val(response.info.es_shot);
                $("#es_end_user").val(response.info.es_end_user);
                $("#es_end_user_name").val(response.info.eu_name);
                $("#es_memo").val(response.info.es_memo);
                $("#b_es_number").val(response.info.es_number);

                var estimateNumber = response.info.es_number.split("-");
                $("#es_number1").val(estimateNumber[0]);
                $("#es_number2").val(estimateNumber[1]);
                var html = "";
                for(var i = 0; i < response.files.length;i++){
                    html += '<div class="modal-field">\
                                <div class="modal-field-input">\
                                    <div class="label"></div>\
                                    <div class="input"><a href="/api/fileDownload/estimate_file/?filename='+response.files[i].ef_file+'&originname='+response.files[i].ef_origin_file+'">'+response.files[i].ef_origin_file+'</a></div>\
                                </div>\
                                <div class="modal-field-input">\
                                    <div class="label"><button class="btn btn-black btn-upload-del" type="button" data-seq="'+response.files[i].ef_seq+'">삭제</button></div>\
                                    <div class="input"></div>\
                                </div>\
                            </div>';
                }
                $(".upload-item").html(html);
                var categoryInfo = JSON.parse(category);
                if(response.depths.length > 0){
                    $(".depth-area").html("");

                    for(var i = 0; i < response.depths.length;i++){
                        var depthLength = $(".depth-item").length;
                        var add_html = '<div class="depth-item" style="padding-top:5px">\
                                <div class="modal-field-input">\
                                    <div class="label">서비스 종류</div>\
                                    <div class="input">\
                                        <input type="hidden" name="ed_seq[]" value="'+response.depths[i].ed_seq+'">\
                                        <select id="es_depth1_'+(depthLength+1)+'" name="es_depth1[]" class="es_depth1 select2" data-index="'+(depthLength+1)+'" data-childvalue="'+response.depths[i].ed_depth2+'" style="width:140px">\
                                            <option value="" selected>서비스 종류 선택</option>';
                                            for(var j = 0; j < categoryInfo.length;j++){
                                                add_html += '<option value="'+categoryInfo[j].pc_seq+'">'+categoryInfo[j].pc_name+'</option>';
                                            }
                                        add_html += '</select>\
                                    </div>\
                                </div>\
                                <div class="modal-field-input">\
                                    <div class="label">상품명</div>\
                                    <div class="input">\
                                        <select id="es_depth2_'+(depthLength+1)+'" name="es_depth2[]" class="select2" style="width:140px">\
                                            <option value="" selected>상품명 선택</option>\
                                        </select>\
                                    </div>\
                                </div>\
                            </div>';
                        $(".depth-area").append(add_html);
                        $("#es_depth1_"+(depthLength+1)).val(response.depths[i].ed_depth1).trigger("change");
                        $(".es_depth1").each(function(){

                            if($(this).attr("id") == "es_depth1_"+(depthLength+1)){
                                $(this).trigger("change");
                            }
                        })
                        $(".select2").select2();
                    }
                }

                $('#dialog').dialog({
                    title: '견적 수정',
                    modal: true,
                    width: '40%',
                    draggable: true
                });
            }
        });
    });

    $(".basicFileAdd").click(function(){
        var fileLength = $(".basic_file").length;

        var add_html = '<div class="modal-field ">\
                            <div class="modal-field-input" style="width:60%">\
                                <div class="label">첨부파일'+(fileLength+1)+'</div>\
                                <div class="input"><input type="file" name="basic_file[]" class="basic_file fileform" ></div>\
                                <input type="hidden" name="bf_sort[]" id="bf_sort'+(fileLength+1)+'" value="'+(fileLength+1)+'" class="bf_sort">\
                            </div>\
                            <div class="modal-field-input" style="width:38%">\
                                <div class="file_name'+(fileLength+1)+'"></div>\
                                <input type="hidden" name="bf_seq[]" id="bf_seq'+(fileLength+1)+'" value="" class="bf_seq">\
                            </div>\
                        </div>';
        $("#fileForm").append(add_html);
        $(".fileform").uniform({
            fileBtnText : "찾아보기"
        });
    });

    $(".basicFileMinus").click(function(){
        var target = $(".basic_file").length-1;
        // console.log($(".bf_seq").eq(target).val());
        // return false;
        if($(".bf_seq").eq(target).val() == ""){
            $(".bf_seq").eq(target).parent().parent().remove();
        }else{
            alert("파일이 등록되어 있으면 삭제가 불가능합니다.");
            return false;
        }
    });

    $("#userSearchForm").submit(function(e){

        if($("#memberSearchWord").val() == ""){
            alert("검색어를 입력해주세요");
            return false;
        }

        var url = "/api/memberSearchList";
        var userSearchForm = $("#userSearchForm").serialize();
        // console.log(userSearchForm);
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : userSearchForm,
            success:function(response){
                var html ="";
                if(response.length == 0){
                    html += "<tr><td colspan=5 align=center>검색결과가 없습니다.</td></tr>";
                }else{
                    for(var i = 0; i < response.length;i++){
                        html += '<tr>\
                                    <td><a href="javascript:void(0)" class="clickMember" data-name="'+response[i].mb_name+'" data-contractname="'+response[i].mb_contract_name+'" data-id="'+response[i].mb_id+'" data-tel="'+response[i].mb_tel+'" data-phone="'+response[i].mb_phone+'" data-email="'+response[i].mb_email+'" data-fax="'+response[i].mb_fax+'" data-seq="'+response[i].mb_seq+'">'+response[i].mb_name+'('+response[i].mb_id+')</a></td>\
                                    <td>'+response[i].mb_contract_name+'</td>\
                                    <td>'+response[i].mb_number+'</td>\
                                    <td>'+response[i].mb_tel+'<br>'+response[i].mb_phone+'</td>\
                                    <td>'+response[i].mb_email+'</td>\
                                </tr>\
                        ';
                    }
                }
                $("#modalSearchMember").html(html);
            }
        });
        return false;
    })

    $("body").on("click",".clickMember",function(){
        var mb_name= $(this).data("name");
        var mb_contract_name= $(this).data("contractname");
        var mb_id = $(this).data("id");
        var mb_tel = $(this).data("tel");
        var mb_phone = $(this).data("phone");
        var mb_email = $(this).data("email");
        var mb_fax = $(this).data("fax");
        var mb_seq = $(this).data("seq");
        $("#mb_id").val(mb_id);
        $("#es_name").val(mb_name);
        $("#es_charger").val(mb_contract_name);
        $("#es_tel").val(mb_tel);
        $("#es_phone").val(mb_phone);
        $("#es_email").val(mb_email);
        $("#es_fax").val(mb_fax);
        $("#es_mb_seq").val(mb_seq);
        $('#dialogUserSearch').dialog('close');
    });

    $("#typeAdd").submit(function(){
        if($("#addType").val() == ""){
            alert("코드를 입력해 주세요");
            return false;
        }

        if($("#ct_name").val() == ""){
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
                console.log(response);
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
                    typeGetList();
                }
            });
        }else{
            $(this).parent().children("td").eq(1).html("<input type='text' name='mode_name' value='"+$(this).data("name")+"'>");
        }

    });

    $("body").on("click",".clickType",function(){
        $("#es_company_type_name").val($(this).data("name"));
        $("#es_company_type").val($(this).data("seq"));
        $('#dialogTypeSearch').dialog('close');
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

    $("#endAdd").submit(function(){
        if($("#addEnd").val() == ""){
            alert("코드를 입력해 주시기 바랍니다.");
            return false;
        }
        if($("#eu_name").val() == ""){
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
                }else{
                    alert(response.msg);
                }
            }
        });
        return false;
    });

    $("#endSearchForm").submit(function(event){

        // if($("#endSearchWord").val() == ""){
        //     alert("검색어를 입력해주세요");
        //     return false;
        // }

        var url = "/api/endUserList";
        var endSearchForm = $("#endSearchForm").serialize();
        // console.log(userSearchForm);
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : endSearchForm,
            success:function(response){
                // console.log(response);
                var html ="";
                if(response.length == 0){
                    html += "<tr><td colspan=4 align=center>검색결과가 없습니다.</td></tr>";
                }else{
                    for(var i = 0; i < response.list.length;i++){
                        html += '<tr>\
                                    <td><a href="javascript:void(0)" class="clickEnd" data-name="'+response.list[i].eu_name+'" data-seq="'+response.list[i].eu_seq+'">'+response.list[i].eu_code+'</a></td>\
                                    <td>'+response.list[i].eu_name+'</td>\
                                    <td class="editEnd" data-name="'+response.list[i].eu_name+'" data-seq="'+response.list[i].eu_seq+'"><i class="fas fa-edit"></i></td>\
                                    <td class="deleteEnd" data-seq="'+response.list[i].eu_seq+'"><i class="fas fa-trash"></i></td>\
                                </tr>\
                        ';
                    }
                }
                $("#modalSearchEnd").html(html);
            }
        });
        return false;
    });

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
                    that.parent().children("td").eq(1).html(editname);
                }
            });
        }else{
            $(this).parent().children("td").eq(1).html("<input type='text' name='end_mode_name' value='"+$(this).data("name")+"'>");
        }

    });

    $("body").on("click",".clickEnd",function(){
        $("#es_end_user_name").val($(this).data("name"));
        $("#es_end_user").val($(this).data("seq"));
        $('#dialogEndSearch').dialog('close');
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

    $(".depthAdd").click(function(){
        var categoryInfo = JSON.parse(category);
        var depthLength = $(".depth-item").length;

        var add_html = '<div class="depth-item" style="padding-top:5px">\
                <div class="modal-field-input">\
                    <div class="label">서비스 종류</div>\
                    <div class="input">\
                    <input type="hidden" name="ed_seq[]" value="">\
                        <select id="es_depth1_'+(depthLength+1)+'" name="es_depth1[]" class="es_depth1 select2" data-index="'+(depthLength+1)+'" data-childvalue="" style="width:140px">\
                            <option value="" selected>서비스 종류 선택</option>';
                            for(var i = 0; i < categoryInfo.length;i++){
                                add_html += '<option value="'+categoryInfo[i].pc_seq+'">'+categoryInfo[i].pc_name+'</option>';
                            }
                        add_html += '</select>\
                    </div>\
                </div>\
                <div class="modal-field-input">\
                    <div class="label">상품명</div>\
                    <div class="input">\
                        <select id="es_depth2_'+(depthLength+1)+'" name="es_depth2[]" class="select2" style="width:140px">\
                            <option value="" selected>상품명 선택</option>\
                        </select>\
                    </div>\
                </div>\
            </div>';
        $(".depth-area").append(add_html);
        $(".select2").select2();
    });

    $(".depthMinus").click(function(){
        var target = $(".depth-item").length-1;

        // console.log($(".bf_seq").eq(target).val());
        // return false;
        $(".depth-item").eq(target).remove();
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


    $("#es_file").change(function(evt){
        var url="/api/estimateFilesTmp";
        $("#ef_es_code").val($("#es_number1").val()+"-"+$("#es_number2").val());
        $("#fileTmpUpload").ajaxForm({ // submit 액션 생성
            url : url, // url 입력
            enctype : "multipart/form-data", // 파일 업로드 처리
            dataType : "json", // 전송 타입 및 리턴 타입 설정
            error : function(xhr,option,error){ // 에러 처리
                console.log(error);
            },
            success : function(data){ // 성공 처리
                var html = '';
                for(var i = 0; i < data.list.length;i++){
                    html += '<div class="modal-field">\
                                <div class="modal-field-input">\
                                    <div class="label"></div>\
                                    <div class="input">'+data.list[i].ef_origin_file+'</div>\
                                </div>\
                                <div class="modal-field-input">\
                                    <div class="label"><button class="btn btn-black btn-tmp-upload-del" type="button" data-seq="'+data.list[i].ef_seq+'">삭제</button></div>\
                                    <div class="input"></div>\
                                </div>\
                            </div>';
                }
                $(".upload-item").html(html);

            }
        });
        // console.log($("#fileForm").serialize());
        // return false;

        $("#fileTmpUpload").submit();
        $("#es_file").val('');
        return false;
    });

    $("#em_file").change(function(evt){
        var url="/api/estimateEmailFile";
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
                    html += '<div style="height:30px" class="fileCount" data-filesize="'+data.list[i].em_file_size+'">\
                                <input type="checkbox" name="add_file[]" class="add_file checkfile" value="'+data.list[i].em_seq+'|'+data.list[i].em_origin_file+'|'+data.list[i].em_file+'" checked> '+data.list[i].em_origin_file+'\
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
        $("#em_file").val('');

        return false;
    });

    $("body").on("click",".btn-tmp-upload-del",function(){
        if(confirm("삭제 하시겠습니까?")){
            var url = "/api/estimateFilesTmpDelete/"+$(this).data("seq");
            var that = $(this);
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    alert("삭제되었습니다.");
                    that.parent().parent().parent().remove();
                }

            });
        }
    });

    $("body").on("click",".btn-upload-del",function(){
        if(confirm("삭제 하시겠습니까?")){
            var url = "/api/estimateFilesDelete/"+$(this).data("seq");
            var that = $(this);
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    that.parent().parent().parent().remove();
                }

            });
        }
    });

    $("body").on("click",".statusEdit",function(){
        if(confirm("서비스 상태를 신청완료로 변경하시겠습니까?")){
            var url = "/api/estimateStatus/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                success:function(response){
                    if(response.result){
                        alert("변경 완료");
                        getList();
                    }else{
                        alert("오류가 발생했습니다.");
                    }

                }

            });
        }
    });

    // $('.summernote').summernote({
    //     height: 300,
    //     tabsize: 2
    // });
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

    $(".btn-copy").click(function(){
        var checkCount = 0;
        var checkSeq = [];
        $(".listCheck").each(function(){
            if($(this).is(":checked")){
                checkCount++;
                checkSeq.push($(this).val());
            }
        });
        if(checkCount == 0){
            alert("견적을 선택해 주시기 바랍니다.");
            return false;
        }
        if(confirm("해당 견적 내용과 동일하게 복사하시겠습니까?")){
            var url = "/api/estimateCopy";
            // console.log(userSearchForm);
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "checkSeq="+checkSeq.join(","),
                success:function(response){
                    if(response.result){
                        alert("복사 완료");
                        getList();
                    }
                }
            });
        }
    })

    $(".btn-re-copy").click(function(){
        var checkCount = 0;
        var checkSeq = "";
        $(".listCheck").each(function(){
            if($(this).is(":checked")){
                checkCount++;
                checkSeq = $(this).val();
            }
        });
        if(checkCount > 1){
            alert("한 개의 견적만 복사 가능합니다.");
            return false;
        }else if(checkCount == 0){
            alert("견적을 선택해 주시기 바랍니다.");
            return false;
        }
        if(confirm("해당 견적의 재견적 내용으로 복사하시겠습니까?")){
            var url = "/api/estimateReCopy";
            // console.log(userSearchForm);
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "checkSeq="+checkSeq,
                success:function(response){
                    // console.log(response);
                    if(response.result){
                        alert("복사 완료");
                        getList();
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

    });

    $(".btn-success-register").click(function(){
        var checkCount = 0;
        var checkSeq = [];
        $(".listCheck").each(function(){
            if($(this).is(":checked")){
                checkCount++;
                checkSeq.push($(this).val());
            }
        });
        if(checkCount == 0){
            alert("견적을 선택해 주시기 바랍니다.");
            return false;
        }

        if(confirm("서비스 상태를 신청완료로 변경하시겠습니까?")){
            var url = "/api/estimateSuccess";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "checkSeq="+checkSeq,
                success:function(response){
                    if(response.result){
                        alert("변경 완료");
                        getList();
                    }else{
                        alert("오류가 발생했습니다.");
                    }

                }

            });
        }
    });
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

    $(".btn-check-excel").click(function(){
        var down = false;
        $(".listCheck").each( function(){

            if($(this).is(":checked")){
                down = true;
            }
        });
        if(down){
            $("#listForm").submit();
        }
        else
            alert("다운 받으실 견적을 선택해 주시기 바랍니다.");

    });

    $("body").on("click",".fileDownload",function(){
        var folder = $(this).data("folder");
        var filename = $(this).data("filename");
        var originname = $(this).data("originname");
        var url = "/api/fileDownload/"+folder;

        document.location.href=url+'/?filename='+filename+'&originname='+originname;
    })

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

    $("#searchDepth1").change(function(){
        if($(this).val() != ""){
            var url = "/api/productSearch/"+$(this).val();
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    $('select[name="searchDepth2"]').empty().append('<option value="">상품명 선택</option>');
                    $("#searchDepth2Str").html("상품명 선택");
                    for(var i in response){
                        $('select[name="searchDepth2"]').append('<option value="'+response[i].pr_seq+'" >'+response[i].pr_name+'</option>');
                    }
                }

            });
        }else{
            $('select[name="searchDepth2"]').empty().append('<option value="">상품명 선택</option>');
            $("#searchDepth2Str").html("상품명 선택");
        }
    })

    $("body").on("change",".es_depth1",function(){
        // console.log(1);
        if($(this).val() != ""){
            var index = $(this).data("index");
            var url = "/api/productSearch/"+$(this).val();
            var target = $("#es_depth2_"+index);
            var childvalue = $(this).data("childvalue");
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    target.empty().append('<option value="">상품명 선택</option>');
                    $("#es_depth2_"+index+"_str").html("상품명 선택");
                    var selected_yn = false;
                    for(var i in response){
                        var selected = "";
                        if(childvalue == response[i].pr_seq){
                            selected = "selected";
                            selected_yn = true;
                        }
                        target.append('<option value="'+response[i].pr_seq+'" '+selected+'>'+response[i].pr_name+'</option>');
                    }
                    if(selected_yn){
                        target.trigger("change");
                    }
                }

            });
        }else{

        }
    });

    $(".btn-number-duple").click(function(){
        if($("#es_number1").val() == ""){
            alert("견적번호를 입력해 주세요");
            return false;
        }

        if($("#es_number2").val() == ""){
            alert("견적번호를 입력해 주세요");
            return false;
        }
        var url = "/api/estimateNumberCheck";
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "es_number="+$("#es_number1").val()+"-"+$("#es_number2").val(),
            success:function(response){
                if(response.result == true){
                    alert("견적번호가 존재 합니다. 다른 견적번호로 설정해주시기 바랍니다.");
                    $("#dupleNumberYn").val("N");
                    return false;
                }else{
                    alert("사용가능한 견적번호 입니다.");
                    $("#dupleNumberYn").val("Y");
                    return false;
                }
            }
        });
    });

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
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
            .append( item.ct_name )
            .appendTo( ul );
    };

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
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
            .append( item.eu_name )
            .appendTo( ul );
    };

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
});

var getList = function(){
    var start = $("#start").val();
    var end = 5;
    var url = "/api/estimateList/"+start+"/"+end;
    var searchForm = $("#searchForm").serialize();
    // console.log(searchForm);
    // console.log(url);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : searchForm,
        success:function(response){
            // console.log(response);
            var html = "";
            if(response.list.length > 0){
                for(var i = 0; i < response.list.length;i++){
                    var num = response.total - ((start-1)*end) - i;
                    if(response.list[i].mb_id !== null){
                        var mb_seq_str = "("+response.list[i].mb_id+")";
                    }else{
                        var mb_seq_str = "";
                    }
                    html += '<tr>\
                                <td><input type="checkbox" class="listCheck" name="es_seq[]" value="'+response.list[i].es_seq+'"></td>\
                                <td>'+num+'</td>\
                                <td>'+response.list[i].es_number+'</td>\
                                <td>'+response.list[i].es_name+mb_seq_str+'</td>\
                                <td>'+response.list[i].depth1.join("<br>")+'</td>\
                                <td>'+response.list[i].depth2.join("<br>")+'</td>\
                                <td>'+response.list[i].es_shot+'</td>\
                                <td>'+response.list[i].es_charger+'</td>\
                                <td>'+response.list[i].es_tel+'<br>'+response.list[i].es_phone+'</td>\
                                <td>'+response.list[i].es_email+'</td>\
                                <td>'+(response.list[i].es_register ? response.list[i].es_register:"")+'</td>\
                                <td>'+moment(response.list[i].es_regdate).format("YYYY-MM-DD HH:mm")+'</td>\
                                <td>'+(response.list[i].es_status == 0 ? "<span class='statusEdit' style='cursor:pointer;color:#0070C0' data-seq='"+response.list[i].es_seq+"'>등록</span>":"<span style='color:#FF0000'>신청완료</span>")+'</td>\
                                <td>';
                                if(response.list[i].file_seq != ""){
                                    var file_seq = response.list[i].file_seq.split("|");
                                    for(var j =0; j < file_seq.length;j++){
                                        var file_info = file_seq[j].split(", ");
                                        html += " <i class='fas fa-save fileDownload' data-filename='"+file_info[1]+"' data-originname='"+file_info[2]+"' data-folder='estimate_file' alt='"+file_info[2]+"' title='"+file_info[2]+"'></i>";
                                    }
                                }
                                html += '</td>\
                                <td class="btn-modify" data-seq="'+response.list[i].es_seq+'"><i class="fas fa-edit"></i></td>\
                                <td class="btn-delete" data-seq="'+response.list[i].es_seq+'"><i class="fas fa-trash"></i></td>\
                            </tr>';
                }

                $(".pagination-html").bootpag({
                    total : Math.ceil(parseInt(response.total)/5), // 총페이지수 (총 Row / list노출개수)
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
                    getList();
                })
            }else{
                html += '<tr><td colspan="16" style="text-align:center">견적이 없습니다.</td></tr>';
            }
            $("#tbody-list").html(html);
        }
    });
    return false;
}

var typeGetList = function(){
    // alert(1);
    var url = "/api/companyTypeList";
    var typeSearchForm = $("#typeSearchForm").serialize();
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : typeSearchForm,
        success:function(response){
            var html ="";
            if(response.list.length == 0){
                html += "<tr><td colspan=4 align=center>검색결과가 없습니다.</td></tr>";
            }else{
                for(var i = 0; i < response.list.length;i++){
                    html += '<tr>\
                                <td><a href="javascript:void(0)" class="clickType" data-seq="'+response.list[i].ct_seq+'" data-name="'+response.list[i].ct_name+'">'+response.list[i].ct_code+'</a></td>\
                                <td>'+response.list[i].ct_name+'</td>\
                                <td class="editType" data-name="'+response.list[i].ct_name+'" data-seq="'+response.list[i].ct_seq+'"><i class="fas fa-edit"></i></td>\
                                <td class="deleteType" data-seq="'+response.list[i].ct_seq+'"><i class="fas fa-trash"></i></td>\
                            </tr>\
                    ';
                }
            }
            $("#modalSearchType").html(html);
            $("#addType").val(pad(response.nextCode,3));
            $("#ct_name").val("");
        }
    });
    return false;
}

var getEndUserNextNumber = function(){
    var url = "/api/endUserNextCode";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){

            $("#addEnd").val(response);
            $("#eu_name").val("");
        }
    });
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
