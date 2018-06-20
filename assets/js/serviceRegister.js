$(function(){
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
                        bank_html += '<li><input type="text" style="width:50px" name="sb_min_month[]" class="sb_min_month" value="'+response.bank[i].sb_min_month+'"> 개월 이상 ~ <input type="text" style="width:50px" name="sb_max_month[]" class="sb_max_month" value="'+response.bank[i].sb_max_month+'"> 개월 미만 <input type="text" style="width:50px" name="sb_discount[]" class="sb_discount" value="'+response.bank[i].sb_discount+'"> % (할인) <input type="hidden" name="sb_seq[]" value="'+response.bank[i].sb_seq+'"> </li>';
                    }
                }else{
                    bank_html = '<li><input type="text" style="width:50px" name="sb_min_month[]" class="sb_min_month"> 개월 이상 ~ <input type="text" style="width:50px" name="sb_max_month[]" class="sb_max_month"> 개월 미만 <input type="text" style="width:50px" name="sb_discount[]" class="sb_discount"> % (할인) <input type="hidden" name="sb_seq[]" value=""></li>';
                }
                $(".sb_add").html(bank_html);

                var card_html = "";
                if(response.card.length > 0){
                    for(var i =0; i < response.card.length;i++){
                        card_html += '<li><input type="text" style="width:50px" name="sc_min_month[]" class="sc_min_month" value="'+response.card[i].sc_min_month+'"> 개월 이상 ~ <input type="text" style="width:50px" name="sc_max_month[]" class="sc_max_month" value="'+response.card[i].sc_max_month+'"> 개월 미만 <input type="text" style="width:50px" name="sc_discount[]" class="sc_discount" value="'+response.card[i].sc_discount+'"> % (할인) <input type="hidden" name="sc_seq[]" value="'+response.card[i].sc_seq+'"> </li>';
                    }
                }else{
                    card_html = '<li><input type="text" style="width:50px" name="sc_min_month[]" class="sc_min_month"> 개월 이상 ~ <input type="text" style="width:50px" name="sc_max_month[]" class="sc_max_month"> 개월 미만 <input type="text" style="width:50px" name="sc_discount[]" class="sc_discount"> % (할인) <input type="hidden" name="sc_seq[]" value=""></li>';
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
    })
})