$(function(){
    var PT_email = /[a-z0-9_]{2,}@[a-z0-9-]{2,}\.[a-z0-9]{2,}/i;
    // 리스트 전체 체크/해제
    $("#all").click(function(){
        // console.log($(this).is(":checked"));
        if($(this).is(":checked")){
            $(".listCheck").prop("checked",true);
        }else{
            $(".listCheck").prop("checked",false);
        }
    });
    $(".fileform").uniform({
        fileBtnText : "찾아보기"
    });
    // datepicker
    $( ".datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd',
        showOn: "both",
        buttonText: "<i class='fa fa-calendar-alt'></i>"
    });

    //등록 버튼 클릭
    $(".btn-add").click(function(){
        $(".btn-register").text("등록");

        $("#dupleIdYn").val("N");
        $("#dupleNumberYn").val("N");
        $(".write").show();
        $(".edit").hide();
        $(".c-id-str").html("");
        $("#c_address").val("");
        $("#c_bank").val("");
        $("#c_bank_input_number").val("");
        $("#c_bank_name").val("");
        $("#c_bank_name_relationship").val("");
        $("#c_bank_number").val("");
        $("#c_business_conditions").val("");
        $("#c_business_type").val("");
        $("#c_ceo").val("");
        $("#c_contract_email").val("");
        $("#c_contract_name").val("");
        $("#c_contract_phone").val("");
        $("#c_contract_tel").val("");
        $("#c_detail_address").val("");
        $("#c_email").val("");
        $("#c_fax").val("");
        $("#c_name").val("");
        $("#c_number").val("");
        $("#c_payment_email").val("");
        $("#c_payment_name").val("");
        $("#c_payment_phone").val("");
        $("#c_payment_tel").val("");
        $("#c_payment_type").val("");
        $("#c_zipcode").val("");
        $("#c_seq").val("");
        $("#c_item").val("");

        $('#dialog').dialog({
            title: '매입처 등록',
            modal: true,
            width: '800px',
            draggable: true
        });
    });

    // 아이디 중복 체크
    $(".btn-id-duple").click(function(){
        if($("#mb_id").val() == ""){
            alert("매입처 아이디(코드)를 입력해 주세요");
            return false;
        }
        var url = "/api/clientIdCheck";
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "c_id="+$("#c_id").val(),
            success:function(response){
                if(response.result == true){
                    alert("아이디가 존재 합니다. 다른 아이디로 설정해주시기 바랍니다.");
                    $("#dupleIdYn").val("N");
                    return false;
                }else{
                    alert("사용가능한 아이디 입니다.");
                    $("#dupleIdYn").val("Y");
                    return false;
                }
            }
        });
    });

    // 사업자번호 중복 체크
    $(".btn-number-duple").click(function(){
        if($("#c_number").val() == ""){
            alert("사업자등록번호를 입력해 주세요");
            return false;
        }
        var url = "/api/clientNumberCheck";
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "c_number="+$("#c_number").val(),
            success:function(response){
                if(response.result == true){
                    alert("사업자번호가 존재 합니다. 다른 사업자번호로 설정해주시기 바랍니다.");
                    $("#dupleNumberYn").val("N");
                    return false;
                }else{
                    alert("사용가능한 사업자번호 입니다.");
                    $("#dupleNumberYn").val("Y");
                    return false;
                }
            }
        });
    });

    // 수정 클릭시 데이터 로드
    $("body").on("click",".btn-modify",function(){
        var c_seq = $(this).data("seq");
        var url = "/api/clientView/"+c_seq;
        $(".btn-register").text("수정");
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                $("#dupleIdYn").val("Y");
                $("#dupleNumberYn").val("Y");
                $(".write").hide();
                $(".edit").show();


                $(".c-id-str").html(response.c_id);
                $("#c_address").val(response.c_address);
                $("#c_bank").val(response.c_bank);
                $("#c_bank_input_number").val(response.c_bank_input_number);
                $("#c_bank_name").val(response.c_bank_name);
                $("#c_bank_name_relationship").val(response.c_bank_name_relationship);
                $("#c_bank_number").val(response.c_bank_number);
                $("#c_business_conditions").val(response.c_business_conditions);
                $("#c_business_type").val(response.c_business_type);
                $("#c_ceo").val(response.c_ceo);
                $("#c_contract_email").val(response.c_contract_email);
                $("#c_contract_name").val(response.c_contract_name);
                $("#c_contract_phone").val(response.c_contract_phone);
                $("#c_contract_tel").val(response.c_contract_tel);
                $("#c_detail_address").val(response.c_detail_address);
                $("#c_email").val(response.c_email);
                $("#c_fax").val(response.c_fax);
                $("#c_name").val(response.c_name);
                $("#c_number").val(response.c_number);
                $("#c_payment_email").val(response.c_payment_email);
                $("#c_payment_name").val(response.c_payment_name);
                $("#c_payment_phone").val(response.c_payment_phone);
                $("#c_payment_tel").val(response.c_payment_tel);
                $("#c_payment_type").val(response.c_payment_type);
                $("#c_zipcode").val(response.c_zipcode);
                $("#c_seq").val(response.c_seq);
                if(response.c_origin_file1 != ""){
                    $(".file_name1").html(response.c_origin_file1+" <i class='fileDelete' data-seq='"+response.c_seq+"' data-type='1'>x</i>");
                }
                if(response.c_origin_file2 != ""){
                    $(".file_name2").html(response.c_origin_file2+" <i class='fileDelete' data-seq='"+response.c_seq+"' data-type='2'>x</i>");
                }
                $("#c_item").val(response.c_item);
                if(response.c_payment_type == "1"){
                    $("#c_payment_type_select_str").html("당월");
                    $("#c_payment_type_select").val(response.c_payment_type);
                }else if(response.c_payment_type == "2"){
                    $("#c_payment_type_select_str").html("익월");
                    $("#c_payment_type_select").val(response.c_payment_type);
                }else if(response.c_payment_type == "3"){
                    $("#c_payment_type_select_str").html("익익월");
                    $("#c_payment_type_select").val(response.c_payment_type);
                }else if(response.c_payment_type == "4"){
                    $("#c_payment_type_select_str").html("기타");
                    $("#c_payment_type_select").val(response.c_payment_type);
                }

                $('#dialog').dialog({
                    title: '매입처 수정',
                    modal: true,
                    width: '800px',
                    draggable: true
                });
            }
        });
    });
    // 등록 & 수정

    $("#registerForm").submit(function(event){

        var PT_E_N = /^[a-zA-Z0-9]+$/;
        var PT_comnum = /^\d{3}-\d{2}-\d{5}$/;
        var PT_birth = /^(19[0-9][0-9]|20\d{2})-(0[0-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
        var PT_phone = /^\d{3}-\d{3,4}-\d{4}$/;
        var PT_tel = /^\d{2,3}-\d{3,4}-\d{4}$/;
        if($("#c_seq").val() == ""){
            if($("#c_id").val() == ""){
                alert("매입처 아이디(코드)를 입력해 주세요");
                return false;
            }

            if(!PT_E_N.test($("#c_id").val())){
                alert("영문/숫자만 입력 가능합니다.");
                return false;
            }
        }
        if($("#dupleIdYn").val() == "N"){
            alert("매입처 아이디(코드) 중복확인을 해주시기 바랍니다.");
            return false;
        }


        if($("#c_name").val() == ""){
            alert("상호명을 입력해 주세요");
            return false;
        }

        if($("#c_number").val() == ""){
            alert("사업자등록번호를 입력해 주세요");
            return false;
        }


        // console.log(PT_comnum.test($("#mb_number").val()));
        if(!PT_comnum.test($("#c_number").val())){
            alert("사업자 번호를 정확히 입력해 주세요.");
            return false;
        }
        if($("#c_seq").val() == ""){
            if($("#dupleNumberYn").val() == "N"){
                alert("사업자등록번호 중복확인을 해주시기 바랍니다.");
                return false;
            }
        }




        if($("#c_ceo").val() == ""){
            alert("대표자를 입력해 주세요");
            return false;
        }

        if($("#c_zipcode").val() == ""){
            alert("주소를 입력해 주세요");
            return false;
        }

        if($("#c_email").val() == ""){
            alert("이메일을 입력해 주세요");
            return false;
        }

        // if($("#mb_fax").val() == ""){
        //     alert("팩스를 입력해 주세요");
        //     return false;
        // }

        if($("#c_business_conditions").val() == ""){
            alert("업태를 입력해 주세요");
            return false;
        }

        if($("#c_business_type").val() == ""){
            alert("종목을 입력해 주세요");
            return false;
        }


        $(".emailCheck").each(function(){
            if($(this).val() != ""){
                if (!PT_email.test($(this).val())){
                    alert("이메일 형식이 맞지 않습니다.");
                    // $(this).focus();
                }
            }
        })

        // 회원 키값이 빈값이므로 등록 판단
        if($("#c_seq").val() == ""){
            var url = "/api/clientAdd";
            var actionType = "add";
        }else{
        // 수정
            var url = "/api/clientUpdate/"+$("#c_seq").val();
            var actionType = "edit";
        }
        // var datas = $("#registerForm").serialize();
        // datas += "&c_payment_type="+$("#c_payment_type").val();
        $("#c_payment_type").val($("#c_payment_type_select").val());
        // $("#registerForm").ajaxForm({ // submit 액션 생성
        //     url : url, // url 입력
        //     enctype : "multipart/form-data", // 파일 업로드 처리
        //     dataType : "json", // 전송 타입 및 리턴 타입 설정
        //     error : function(xhr,option,error){ // 에러 처리
        //         console.log(xhr);
        //     },
        //     success : function(data){ // 성공 처리
        //         // console.log(data);
        //         if(data.result){
        //             if(actionType == "add"){
        //                 alert("등록 되었습니다.");
        //             }else{
        //                 alert("수정 되었습니다.");
        //             }
        //             getList();
        //             $("#dialog").dialog( "close" );
        //         }
        //     }
        // });
        // $("#registerForm").submit();
        // return false;
        event.preventDefault(); //prevent default action
        var post_url = url; //get form action url
        var request_method = "POST"; //get form GET/POST method
        var form_data = new FormData(this); //Creates new FormData object
        $.ajax({
            url : post_url,
            type: request_method,
            data : form_data,
            contentType: false,
            cache: false,
            processData:false
        }).done(function(response){ //
            response = JSON.parse(response);
            if(response.result){
                if(actionType == "add"){
                    alert("등록 되었습니다.");
                }else{
                    alert("수정 되었습니다.");
                }
                getList();
                $("#dialog").dialog( "close" );
            }
        });

    });
    // 삭제
    $("body").on("click",".btn-delete",function(){
        if(confirm("삭제시 모든 매입처정보가 삭제됩니다. 정말 삭제하시겠습니까?")){
            var c_seq = $(this).data("seq");
            var url = "/api/clientDelete/";
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "c_seq="+c_seq,
                success:function(response){
                    // console.log(response);
                    if(response.result == true){
                        alert("삭제 되었습니다.");
                        getList();
                    }else{
                        alert("오류가 발생했습니다.");
                        return false;
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
    });

    $(".btn-check-delete").click(function(){
        var checkDelete = new Array();
        $(".listCheck").each(function(){
            if($(this).is(":checked")){
                checkDelete.push($(this).val());
            }
        });
        if(checkDelete.length == 0){
            alert("삭제할 매입처 선택해 주시기 바랍니다.");
            return false;
        }

        if(confirm("삭제시 모든 매입처정보가 삭제됩니다. 정말 삭제하시겠습니까?")){
            // var mb_seq = $(this).data("seq");

            var url = "/api/clientDelete/";
            // console.log(url);
            // return false;
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "c_seq="+checkDelete.join(","),
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
        };
    });

    // 리스트
    getList();

    // 검색

    $(".emailCheck").focusout(function(){
        if($(this).val() != ""){

            if (!PT_email.test($(this).val())){
                alert("이메일 형식이 맞지 않습니다.");
                // $(this).focus();
            }
        }
    });

    // 리스트 엑셀 다운로드
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
            alert("다운 받으실 회원을 선택해 주시기 바랍니다.");

    })

    $("body").on("click",".fileDelete",function(){
        var c_seq = $(this).data("seq");
        var type = $(this).data("type");
        var that = $(this);
        var url = "/api/clientFileDelete/"+c_seq+"/"+type;
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                // console.log(response);
                if(response.result == true){
                    alert("삭제 되었습니다.");
                    $(".file_name"+type).html("");
                    // getList();
                }else{
                    alert("오류가 발생했습니다.");
                    // return false;
                }
            }
        });
    });

    $("body").on("click",".fileDownload",function(){
        var folder = $(this).data("folder");
        var filename = $(this).data("filename");
        var originname = $(this).data("originname");
        var url = "/api/fileDownload/"+folder;
        // $.ajax({
        //     url : url,
        //     type : 'GET',
        //     dataType : 'JSON',
        //     data : 'filename='+filename+'&originname='+originname,
        //     success:function(response){
        //         // console.log(response);

        //     }
        // });
        document.location.href=url+'/?filename='+filename+'&originname='+originname;
    })

})


var getList = function(){
    var start = $("#start").val();
    var end = 5;
    var url = "/api/clientList/"+start+"/"+end;
    var searchForm = $("#searchForm").serialize();
    // console.log(url);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : searchForm,
        success:function(response){

            var html = "";
            if(response.list.length > 0){
                for(var i = 0; i < response.list.length;i++){
                    var num = response.total - ((start-1)*end) - i;

                    if(response.list[i].c_payment_type == "1"){
                        var c_payment_type = "당월";
                    }else if(response.list[i].c_payment_type == "2"){
                        var c_payment_type = "익월";
                    }else if(response.list[i].c_payment_type == "3"){
                        var c_payment_type = "익익월";
                    }else if(response.list[i].c_payment_type == "4"){
                        var c_payment_type = "기타";
                    }
                    var fileinfo = "";
                    if(response.list[i].c_file1 != "" && response.list[i].c_file1 !== null ){
                        fileinfo += "<i class='fas fa-save fileDownload' data-filename='"+response.list[i].c_file1+"' data-originname='"+response.list[i].c_origin_file1+"' data-folder='client_file'></i> ";
                    }
                    if(response.list[i].c_file2 != "" && response.list[i].c_file2 !== null){
                        fileinfo += "<i class='fas fa-save fileDownload' data-filename='"+response.list[i].c_file2+"' data-originname='"+response.list[i].c_origin_file2+"' data-folder='client_file'></i> ";
                    }
                    html += '<tr>\
                                <td><input type="checkbox" class="listCheck" name="c_seq[]" value="'+response.list[i].c_seq+'"></td>\
                                <td>'+num+'</td>\
                                <td>'+response.list[i].c_id+'</td>\
                                <td>'+response.list[i].c_name+'</td>\
                                <td>'+response.list[i].c_number+'</td>\
                                <td>'+response.list[i].c_contract_name+'</td>\
                                <td>'+response.list[i].c_contract_email+'</td>\
                                <td>'+response.list[i].c_contract_tel+'</td>\
                                <td>'+response.list[i].c_contract_phone+'</td>\
                                <td>'+response.list[i].c_item+'</td>\
                                <td>'+c_payment_type+'</td>\
                                <td>'+fileinfo+'</td>\
                                <td class="btn-modify" data-seq="'+response.list[i].c_seq+'" style="cursor:pointer"><i class="fas fa-edit"></i></td>\
                                <td class="btn-delete" data-seq="'+response.list[i].c_seq+'" style="cursor:pointer"><i class="fas fa-trash"></i></td>\
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
                html += '<tr><td colspan="14" style="text-align:center">매입처가 없습니다.</td></tr>';
            }
            $("#tbody-list").html(html);
        }
    });
    return false;
}



// 다음 우편번호 호출
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
            document.getElementById('c_zipcode').value = data.zonecode; //5자리 새우편번호 사용
            document.getElementById('c_address').value = fullRoadAddr;
            // document.getElementById('sample4_jibunAddress').value = data.jibunAddress;

            $("#c_detail_address").focus();
        }
    }).open();
}