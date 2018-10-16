$(function(){
    $("#all").click(function(){
        // console.log($(this).is(":checked"));
        if($(this).is(":checked")){
            $(".listCheck").prop("checked",true);
        }else{
            $(".listCheck").prop("checked",false);
        }
    });
    getList();
    $(".btn-basic-price").click(function(){
        $.ajax({
            url : "/api/basicPolicySetting",
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                // console.log(response);
                $("#discount").val(response.cms.discount);
                $('input:radio[name=sp_basic_type]:input[value=' + response.policy.sp_basic_type + ']').attr("checked", true);
                if(response.policy.sp_basic_type == "1"){
                    $(".service-type").show();
                }else{
                    $(".service-type").hide();
                }
                $('input:radio[name=sp_policy]:input[value=' + response.policy.sp_policy + ']').attr("checked", true);

                $("#sp_pay_start_day").val(response.policy.sp_pay_start_day).trigger("change");
                $("#sp_pay_format").val(response.policy.sp_pay_format).trigger("change");
                $("#sp_pay_format_policy").val(response.policy.sp_pay_format_policy).trigger("change");

                var bank_html = "";
                if(response.bank.length > 0){
                    for(var i =0; i < response.bank.length;i++){
                        bank_html += '<li style="padding:2px 0px"><input type="text" style="width:50px" name="sb_min_month[]" class="sb_min_month" value="'+response.bank[i].sb_min_month+'"> 개월 이상 ~ <input type="text" style="width:50px" name="sb_max_month[]" class="sb_max_month" value="'+response.bank[i].sb_max_month+'"> 개월 미만 <input type="text" style="width:50px" name="sb_discount[]" class="sb_discount" value="'+response.bank[i].sb_discount+'"> % (할인) <input type="hidden" name="sb_seq[]" value="'+response.bank[i].sb_seq+'"> </li>';
                    }
                }else{
                    bank_html = '<li style="padding:2px 0px"><input type="text" style="width:50px" name="sb_min_month[]" class="sb_min_month"> 개월 이상 ~ <input type="text" style="width:50px" name="sb_max_month[]" class="sb_max_month"> 개월 미만 <input type="text" style="width:50px" name="sb_discount[]" class="sb_discount"> % (할인) <input type="hidden" name="sb_seq[]" value=""></li>';
                }
                $(".sb_add").html(bank_html);

                var card_html = "";
                if(response.card.length > 0){
                    for(var i =0; i < response.card.length;i++){
                        card_html += '<li style="padding:2px 0px"><input type="text" style="width:50px" name="sc_min_month[]" class="sc_min_month" value="'+response.card[i].sc_min_month+'"> 개월 이상 ~ <input type="text" style="width:50px" name="sc_max_month[]" class="sc_max_month" value="'+response.card[i].sc_max_month+'"> 개월 미만 <input type="text" style="width:50px" name="sc_discount[]" class="sc_discount" value="'+response.card[i].sc_discount+'"> % (할인) <input type="hidden" name="sc_seq[]" value="'+response.card[i].sc_seq+'"> </li>';
                    }
                }else{
                    card_html = '<li style="padding:2px 0px"><input type="text" style="width:50px" name="sc_min_month[]" class="sc_min_month"> 개월 이상 ~ <input type="text" style="width:50px" name="sc_max_month[]" class="sc_max_month"> 개월 미만 <input type="text" style="width:50px" name="sc_discount[]" class="sc_discount"> % (할인) <input type="hidden" name="sc_seq[]" value=""></li>';
                }
                $(".sc_add").html(card_html);
                $('#dialogPolicy').dialog({
                    title: '기본 요금 체계 등록',
                    modal: true,
                    width: '800px',
                    draggable: true
                });
            }
        });

    });

    $('input:radio[name=sp_basic_type]').click(function(){
        if($(this).val() == "1"){
            $(".service-type").show();
        }else{
            $(".service-type").hide();
        }
    })
    $(".btn-add").click(function(){
        var specs = "left=10,top=10,width=1000,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/service/make/", 'serviceMake', specs);
    });

    $(".sbAdd").click(function(){
        var html = '<li style="padding-top:5px"><input type="text" style="width:50px" name="sb_min_month[]" class="sb_min_month"> 개월 이상 ~ <input type="text" style="width:50px" name="sb_max_month[]" class="sb_max_month"> 개월 미만 <input type="text" style="width:50px" name="sb_discount[]" class="sb_discount"> % (할인) <input type="hidden" name="sb_seq[]" value=""></li>';
        $(".sb_add").append(html);
    });

    $(".sbMinus").click(function(){
        $(".sb_add").children("li").last().remove();
    });

    $(".scAdd").click(function(){
        var html = '<li style="padding-top:5px"><input type="text" style="width:50px" name="sc_min_month[]" class="sc_min_month"> 개월 이상 ~ <input type="text" style="width:50px" name="sc_max_month[]" class="sc_max_month"> 개월 미만 <input type="text" style="width:50px" name="sc_discount[]" class="sc_discount"> % (할인) <input type="hidden" name="sc_seq[]" value=""></li>';
        $(".sc_add").append(html);
    });

    $(".scMinus").click(function(){
        $(".sc_add").children("li").last().remove();
    });

    $("#policyForm").submit(function(){
        var datas = $("#policyForm").serialize();
        console.log(datas);
        $.ajax({
            url : "/api/basicPolicyEdit",
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                if(response.result){
                    alert("변경되었습니다.");
                    $('#dialogPolicy').dialog("close");
                }
            },
            error : function(error){
                console.log(error);
            }
        });
        return false;
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
        if(checkCount > 1){
            alert("한 개의 서비스만 복사 가능합니다.");
            return false;
        }else if(checkCount == 0){
            alert("서비스를 선택해 주시기 바랍니다.");
            return false;
        }
        if(confirm("해당 서비스 내용과 동일하게 복사하시겠습니까?")){
            var url = "/api/serviceRegisterCopy";
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
                },
                error : function(error){
                    console.log(error);
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
            alert("한 개의 서비스만 복사 가능합니다.");
            return false;
        }else if(checkCount == 0){
            alert("서비스를 선택해 주시기 바랍니다.");
            return false;
        }
        if(confirm("해당 서비스 내용과 동일하게 복사하시겠습니까?")){
            var url = "/api/serviceRegisterReCopy";
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
    $("body").on("click",".btn-modify",function(){
        var seq = $(this).data("seq");
        var specs = "left=10,top=10,width=1000,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/service/edit/"+seq, 'serviceMake', specs);
    });

    $(".btn-apply").click(function(){
        var checkCount = 0;
        var checkSeq = [];
        var status = [];
        $(".listCheck").each(function(){
            if($(this).is(":checked")){
                checkCount++;
                checkSeq.push($(this).val());
                if($(this).data("status") != "0"){
                    status.push($(this).val())
                }
            }
        });
        if(checkCount == 0){
            alert("서비스를 선택해 주시기 바랍니다.");
            return false;
        }

        // var status = $(this).data("status");
        // console.log(status);
        // if(status.length > 0){
        //     alert("이미 신청 처리가 된 서비스가 있습니다");
        //     return false;
        // }

        if(confirm("선택한 서비스를 신청 처리하시겠습니까?")){
            var url = "/api/serviceMake/";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sr_seq="+checkSeq.join(","),
                success:function(response){
                    // console.log(response);
                    if(response.result){
                        alert("신청 처리되었습니다");
                        getList();
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
    })

    $("body").on("click",".btn-delete",function(){
        if(confirm("삭제하시겠습니까?")){
            var sr_seq = $(this).data("seq");
            var url = "/api/serviceRegisterDelete";

            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "sr_seq="+sr_seq,
                success:function(response){
                    if(response.result){
                        alert("삭제되었습니다");
                        // getMemo();
                        document.location.href='/service/register';
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    })
})

var getList = function(){
    var start = $("#start").val();
    // console.log(start);
    var end = 5;
    var url = "/api/serviceRegisterList/"+start+"/"+end;
    var searchForm = $("#searchForm").serialize();
    // console.log(searchForm);
    // console.log(url);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : searchForm,
        success:function(response){
            console.log(response);
            var html = "";
            if(response.list.length > 0){
                for(var i = 0; i < response.list.length;i++){
                    // console.log(start);
                    var num = parseInt(response.total) - ((start-1)*end) - i;
                    var startdate = new Date(response.list[i].sr_contract_start);
                    var enddate = new Date(response.list[i].sr_contract_end);
                    var diff = Date.getFormattedDateDiff(startdate, enddate);
                    html += '<tr>\
                                <td><input type="checkbox" class="listCheck" name="sr_seq[]" value="'+response.list[i].sr_seq+'" data-status="'+response.list[i].sr_status+'"></td>\
                                <td>'+num+'</td>\
                                <td>'+response.list[i].mb_name+'</td>\
                                <td>'+response.list[i].eu_name+'</td>\
                                <td>'+response.list[i].sr_code+'</td>\
                                <td>'+response.list[i].sr_contract_start+'</td>\
                                <td>'+diff[0]+"개월 "+diff[1]+"일"+'</td>\
                                <td>'+response.list[i].pc_name+'</td>\
                                <td>'+response.list[i].pr_name+'</td>\
                                <td>'+response.list[i].ps_name+'</td>\
                                <td>'+moment(response.list[i].sr_regdate).format("YYYY-MM-DD")+'</td>\
                                <td>'+response.list[i].sr_account_start+'</td>\
                                <td>'+response.list[i].sr_payment_period+'개월</td>\
                                <td>'+response.list[i].sr_charger+'</td>\
                                <td>'+(response.list[i].sr_status == 0 ? "<span class='statusEdit' style='cursor:pointer;color:#0070C0' data-seq='"+response.list[i].sr_seq+"'>등록</span>":"<span style='color:#FF0000'>신청완료</span>")+'</td>\
                                <td class="btn-modify" data-seq="'+response.list[i].sr_seq+'"><i class="fas fa-edit"></i></td>\
                                <td class="btn-delete" data-seq="'+response.list[i].sr_seq+'"><i class="fas fa-trash"></i></td>\
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
                html += '<tr><td colspan="17" style="text-align:center">서비스가 없습니다.</td></tr>';
            }
            $("#tbody-list").html(html);
        }
    });
    return false;
}

Date.getFormattedDateDiff = function(date1, date2) {
  var b = moment(date1),
      a = moment(date2).add(1,"days"),
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