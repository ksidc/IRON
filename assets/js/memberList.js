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
        $(".user").hide();
        $(".company").show();

        $(".md-id-str").html("");
        $("#mb_address").val("");
        $("#mb_auto_payment").val(0);
        $("#mb_bank").val("");
        $("#mb_bank_input_number").val("");
        $("#mb_bank_name").val("");
        $("#mb_bank_name_relationship").val("");
        $("#mb_bank_number").val("");
        $("#mb_business_conditions").val("");
        $("#mb_business_type").val("");
        $("#mb_ceo").val("");
        $("#mb_contract_email").val("");
        $("#mb_contract_name").val("");
        $("#mb_contract_phone").val("");
        $("#mb_contract_tel").val("");
        $("#mb_detail_address").val("");
        $("#mb_email").val("");
        $("#mb_fax").val("");
        $("#mb_name").val("");
        $("#mb_number").val("");
        $("#mb_payment_day").val("");
        $("#mb_payment_email").val("");
        $("#mb_payment_name").val("");
        $("#mb_payment_phone").val("");
        $("#mb_payment_publish").val("");
        $("#mb_payment_publish_type").val("");
        $("#mb_payment_tel").val("");
        $("#mb_payment_type").val("");
        $("#mb_phone").val("");
        $("#mb_tel").val("");
        $("#mb_type").val("");
        $("#mb_zipcode").val("");
        $("#mb_seq").val("");

        $('#dialog').dialog({
            title: '회원 등록',
            modal: true,
            width: '40%',
            draggable: false
        });
    });

    // 아이디 중복 체크
    $(".btn-id-duple").click(function(){
        if($("#mb_id").val() == ""){
            alert("회원 아이디(코드)를 입력해 주세요");
            return false;
        }
        var url = "/api/memberIdCheck";
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "mb_id="+$("#mb_id").val(),
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
        if($("#mb_number").val() == ""){
            alert("사업자등록번호를 입력해 주세요");
            return false;
        }
        var url = "/api/memberNumberCheck";
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : "mb_number="+$("#mb_number").val(),
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
        var mb_seq = $(this).data("seq");
        var url = "/api/memberView/"+mb_seq;
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

                if(response.mb_type == "0"){
                    $(".user").hide();
                    $(".company").show();
                }else{
                    $(".user").show();
                    $(".company").hide();
                }
                $(".md-id-str").html(response.mb_id);
                $("#mb_address").val(response.mb_address);
                $("#mb_auto_payment").val(response.mb_auto_payment);
                $("#mb_bank").val(response.mb_bank);
                $("#mb_bank_input_number").val(response.mb_bank_input_number);
                $("#mb_bank_name").val(response.mb_bank_name);
                $("#mb_bank_name_relationship").val(response.mb_bank_name_relationship);
                $("#mb_bank_number").val(response.mb_bank_number);
                $("#mb_business_conditions").val(response.mb_business_conditions);
                $("#mb_business_type").val(response.mb_business_type);
                $("#mb_ceo").val(response.mb_ceo);
                $("#mb_contract_email").val(response.mb_contract_email);
                $("#mb_contract_name").val(response.mb_contract_name);
                $("#mb_contract_phone").val(response.mb_contract_phone);
                $("#mb_contract_tel").val(response.mb_contract_tel);
                $("#mb_detail_address").val(response.mb_detail_address);
                $("#mb_email").val(response.mb_email);
                $("#mb_fax").val(response.mb_fax);
                $("#mb_name").val(response.mb_name);
                $("#mb_number").val(response.mb_number);
                $("#mb_payment_day").val(response.mb_payment_day);
                $("#mb_payment_email").val(response.mb_payment_email);
                $("#mb_payment_name").val(response.mb_payment_name);
                $("#mb_payment_phone").val(response.mb_payment_phone);
                $("#mb_payment_publish").val(response.mb_payment_publish);
                $("#mb_payment_publish_type").val(response.mb_payment_publish_type);
                $("#mb_payment_tel").val(response.mb_payment_tel);
                $("#mb_payment_type").val(response.mb_payment_type);
                $("#mb_phone").val(response.mb_phone);
                $("#mb_tel").val(response.mb_tel);
                $("#mb_type").val(response.mb_type);
                $("#mb_zipcode").val(response.mb_zipcode);
                $("#mb_seq").val(response.mb_seq);

                $('#dialog').dialog({
                    title: '회원 수정',
                    modal: true,
                    width: '40%',
                    draggable: false
                });
            }
        });
    });
    // 등록 & 수정
    $(".btn-register").click(function(){
        if($("#mb_seq").val() == ""){
            if($("#mb_id").val() == ""){
                alert("회원 아이디(코드)를 입력해 주세요");
                return false;
            }
        }
        if($("#dupleIdYn").val() == "N"){
            alert("회원 아이디(코드) 중복확인을 해주시기 바랍니다.");
            return false;
        }


        if($("#mb_name").val() == ""){
            alert("상호명을 입력해 주세요");
            return false;
        }

        if($("#mb_number").val() == ""){
            alert("사업자등록번호를 입력해 주세요");
            return false;
        }
        if($("#mb_seq").val() == ""){
            if($("#dupleNumberYn").val() == "N"){
                alert("사업자등록번호 중복확인을 해주시기 바랍니다.");
                return false;
            }
        }

        if($("#mb_ceo").val() == ""){
            alert("대표자를 입력해 주세요");
            return false;
        }

        if($("#mb_zipcode").val() == ""){
            alert("주소를 입력해 주세요");
            return false;
        }

        if($("#mb_tel").val() == ""){
            alert("전화번호를 입력해 주세요");
            return false;
        }

        if($("#mb_phone").val() == ""){
            alert("휴대폰번호를 입력해 주세요");
            return false;
        }

        if($("#mb_email").val() == ""){
            alert("이메일을 입력해 주세요");
            return false;
        }

        if($("#mb_fax").val() == ""){
            alert("팩스를 입력해 주세요");
            return false;
        }

        if($("#mb_business_conditions").val() == ""){
            alert("업태를 입력해 주세요");
            return false;
        }

        if($("#mb_business_type").val() == ""){
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
        if($("#mb_seq").val() == ""){
            var url = "/api/memberAdd";
            var actionType = "add";
        }else{
        // 수정
            var url = "/api/memberUpdate/"+$("#mb_seq").val();
            var actionType = "edit";
        }
        var datas = $("#registerForm").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                if(response.result == true){
                    if(actionType == "add"){
                        alert("등록 되었습니다.");
                    }else{
                        alert("수정 되었습니다.");
                    }
                    getList();
                    $("#dialog").dialog( "close" );
                }else{
                    alert("오류가 발생했습니다.");
                    return false;
                }
            }
        });
    });

    // 삭제
    $("body").on("click",".btn-delete",function(){
        if(confirm("삭제시 모든 회원정보가 삭제됩니다. 정말 삭제하시겠습니까?")){
            var mb_seq = $(this).data("seq");
            var url = "/api/memberDelete/";
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "mb_seq="+mb_seq,
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

    $(".btn-check-delete").click(function(){
        var checkDelete = new Array();
        $(".listCheck").each(function(){
            if($(this).is(":checked")){
                checkDelete.push($(this).val());
            }
        });
        if(checkDelete.length == 0){
            alert("삭제할 회원을 선택해 주시기 바랍니다.");
            return false;
        }

        if(confirm("삭제시 모든 회원정보가 삭제됩니다. 정말 삭제하시겠습니까?")){
            // var mb_seq = $(this).data("seq");

            var url = "/api/memberDelete/";
            // console.log(url);
            // return false;
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "mb_seq="+checkDelete.join(","),
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
    $(".btn-form-search").click(function(){
        getList();
    })

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

    $("#mb_type").change(function(){

        if($(this).val() == "0"){
            $(".user").hide();
            $(".company").show();
        }else{
            $(".user").show();
            $(".company").hide();
        }
    });

    $("#mb_payment_day_select").change(function(){
        if($(this).val() != "etc"){

            $("#mb_payment_day").val($(this).val());
        }else{
            $("#mb_payment_day").val("");
        }
    })
})


var getList = function(){
    var start = $("#start").val();
    var end = 10;
    var url = "/api/memberList/"+start+"/"+end;
    var searchForm = $("#searchForm").serialize();
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : searchForm,
        success:function(response){

            var html = "";
            if(response.list.length > 0){
                for(var i = 0; i < response.list.length;i++){
                    html += '<tr>\
                                <td><input type="checkbox" class="listCheck" name="mb_seq[]" value="'+response.list[i].mb_seq+'"></td>\
                                <td>1</td>\
                                <td>'+response.list[i].mb_id+'</td>\
                                <td>'+response.list[i].mb_name+'</td>\
                                <td></td>\
                                <td>'+response.list[i].mb_tel+'</td>\
                                <td>'+response.list[i].mb_contract_name+'</td>\
                                <td>'+response.list[i].mb_payment_name+'</td>\
                                <td>'+response.list[i].mb_regdate+'</td>\
                                <td>0</td>\
                                <td class="btn-modify" data-seq="'+response.list[i].mb_seq+'">[수정]</td>\
                                <td class="btn-delete" data-seq="'+response.list[i].mb_seq+'">[삭제]</td>\
                            </tr>';
                }

                $(".pagination-html").bootpag({
                    total : Math.ceil(response.list.length/10), // 총페이지수 (총 Row / list노출개수)
                    page : $("#start").val(), // 현재 페이지 default = 1
                    maxVisible:10, // 페이지 숫자 노출 개수
                    wrapClass : "pagination",
                    next : ">",
                    prev : "<",
                    nextClass : "last",
                    prevClass : "first",
                    activeClass : "active"

                }).on('page', function(event,num){ // 이벤트 액션
                    // document.location.href='/pageName/'+num; // 페이지 이동
                })
            }else{
                html += '<tr><td colspan="12" style="text-align:center">회원이 없습니다.</td></tr>';
            }
            $("#tbody-list").html(html);
        }
    });
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
            document.getElementById('mb_zipcode').value = data.zonecode; //5자리 새우편번호 사용
            document.getElementById('mb_address').value = fullRoadAddr;
            // document.getElementById('sample4_jibunAddress').value = data.jibunAddress;

            $("#mb_detail_address").focus();
        }
    }).open();
}