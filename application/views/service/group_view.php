<div style="background:#fff;width:100%;overflow-x:hidden">
    <div class="popup_title" style="padding:10px">

        상세 계약 정보

    </div>
    <div style="padding:5px">
        <form name="registerForm" id="registerForm" method="post" >
            <input type="hidden" name="sg_sv_seq" id="sg_sv_seq" value="<?=$sv_seq?>">
            <input type="hidden" name="sv_auto_extension" id="sv_auto_extension" value="<?=$list[0]["sv_auto_extension"]?>">
            <div class="modal-title">
                <div class="modal-title-text">기본 정보</div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label padd"><div>상호/이름</div></div>
                    <div class="input padd" >
                        <?=$list[0]["mb_name"]?>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label padd"><div>End User</div></div>
                    <div class="input">
                        <?php if(!$same1): ?>
                            데이터가 일치하지 않습니다.
                        <?php else: ?>
                            <?=$list[0]["eu_name"]?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label padd" ><div>계약 담당자 정보</div></div>
                    <div class="input padd">
                         <?=$list[0]["mb_contract_name"]?> / <?=$list[0]["mb_contract_email"]?> / <?=$list[0]["mb_contract_phone"]?>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label padd"><div>업체 분류</div></div>
                    <div class="input">
                        <?php if(!$same2): ?>
                            데이터가 일치하지 않습니다.
                        <?php else: ?>
                            <?=$list[0]["ct_name"]?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label padd"><div>계약 번호</div></div>
                    <div class="input">
                        <?=$sv_code?>

                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label padd"><div>사내 담당자</div></div>
                    <div class="input">
                        <?php if(!$same3): ?>
                            데이터가 일치하지 않습니다.
                        <?php else: ?>
                        <select name="sv_part" class="select2" style="width:110px">
                            <option value="">기술팀</option>
                            <option value=""></option>
                        </select>
                        <select name="sv_charger" class="select2" style="width:110px">
                            <option value="">노성민</option>
                            <option value=""></option>
                        </select>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label padd"><div>계약 기간</div></div>
                    <div class="input">
                        <?php if(!$same4): ?>
                            데이터가 일치하지 않습니다.
                        <?php else: ?>
                            <?=$list[0]["sv_contract_start"]?> ~ <?=$list[0]["sv_contract_end"]?>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label padd"><div>자동 계약 연장 단위</div></div>
                    <div class="input">
                        <?php if(!$same5): ?>
                            데이터가 일치하지 않습니다.
                        <?php else: ?>
                            <input type="text" style="width:50px" name="sv_auto_extension_month" value="<?=$list[0]["sv_auto_extension_month"]?>">개월 <input type="checkbox" name="sv_auto_extension_check" id="sv_auto_extension_check" <?=($list[0]["sv_auto_extension"] == "2" ? "checked":"")?> > 재 계약 필요
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </form>
        <div style="text-align:center;padding:10px 0px">
            <button class="btn btn-default btn-edit" type="button">수정</button>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">서비스 내역</div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>계약번호</th>
                    <th>서비스 상태</th>
                    <th>서비스 종류</th>
                    <th>상품명</th>
                    <th>소분류</th>
                    <th>초기 일회성</th>
                    <th>월(기준)요금</th>
                </tr>
                </thead>
                <tbody>
                    <?php $totalprice1 = 0;?>
                    <?php $totalprice2 = 0;?>
                    <?php foreach($list as $row): ?>
                    <tr>
                        <td><?=$row["sv_code"]?></td>
                        <td>
                            <?php if($row["sv_status"] == "0"): ?>
                                입금대기중
                            <?php elseif($row["sv_status"] == "1"): ?>
                                서비스준비중
                            <?php elseif($row["sv_status"] == "2"): ?>
                                서비스작업중
                            <?php elseif($row["sv_status"] == "3"): ?>
                                서비스중
                            <?php elseif($row["sv_status"] == "4"): ?>
                                서비스중지
                            <?php elseif($row["sv_status"] == "5"): ?>
                                서비스해지
                            <?php elseif($row["sv_status"] == "6"): ?>
                                직권중지
                            <?php elseif($row["sv_status"] == "7"): ?>
                                직권해지
                            <?php endif;?>
                        </td>
                        <td><?=$row["pc_name"]?></td>
                        <td><?=$row["pr_name"]?></td>
                        <td><?=$row["ps_name"]?></td>
                        <td class="right"><?=number_format($row["svp_once_price"]-$row["svp_once_dis_price"])?> 원</td>
                        <?php if($row["svp_discount_price"] > 0): ?>
                        <td class="right"><?=number_format($row["svp_month_price"]-$row["svp_month_dis_price"]-($row["svp_discount_price"]/$row["svp_payment_period"]))?> 원</td>
                        <?php else: ?>
                        <td class="right"><?=number_format($row["svp_month_price"]-$row["svp_month_dis_price"]-$row["svp_discount_price"])?> 원</td>
                        <?php endif; ?>
                        <?php $totalprice1 = $totalprice1+$row["svp_once_price"]-$row["svp_once_dis_price"]; ?>

                        <?php 
                        if($row["svp_discount_price"] > 0){
                            $totalprice2 = $totalprice2+$row["svp_month_price"]-$row["svp_month_dis_price"]-($row["svp_discount_price"]/$row["svp_payment_period"]); 
                        }else{
                            $totalprice2 = $totalprice2+$row["svp_month_price"]-$row["svp_month_dis_price"]-$row["svp_discount_price"];
                        }
                        ?>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="5">합계</td>
                        <td class="right"><?=number_format($totalprice1)?> 원</td>
                        <td class="right"><?=number_format($totalprice2)?> 원</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">계약 변경 내역</div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>계약 구분</th>
                    <th>처리일</th>
                    <th>계약 기간</th>
                    <th>자동 연장</th>
                    <th>관련 서류 링크</th>
                    <th>수정/삭제</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div>
            <div style="display:inline-block">
                <select name="" class="select2">
                    <option value="">선택</option>
                    <option value="1">변경 계약</option>
                    <option value="2">수동 연장</option>
                    <option value="3">계약 해지</option>
                </select>
            </div>
            <div style="display:inline-block">
                계약 기간
                <input type="text" name="" class="datepicker3"> ~ <input type="text" name="" class="datepicker3">
            </div>
            <div style="display:inline-block">
                <i></i><input type="text"><button class="btn btn-small">등록</button>
            </div>
        </div>
        <div class="modal-title" style="clear:both">
            <div class="modal-title-text"><div>메모</div></div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>입력시간</th>
                    <th>내용</th>
                    <th>작성자</th>
                    <th>수정</th>
                    <th>삭제</th>
                </tr>
                </thead>
                <tbody id="memoList">
                </tbody>
            </table>
        </div>
        <div>
            <div id="memoPaging"></div>
        </div>
        <div style="background:#f4f4f4;padding-top:3px">
            <form name="service_msg" id="service_msg">
                <input type="hidden" name="sg_sv_code" id="sg_sv_code" value="<?=$sv_code?>">
                <div style="display:inline-block;width:17%;text-align:right;vertical-align:top;padding:20px 5px 0px 0px">메모</div>
                <div style="display:inline-block;width:70%;vertical-align:top">
                    <textarea style="width:100%;height:50px" name="sg_msg" id="sg_msg"></textarea>
                </div>
                <div style="display:inline-block;width:10%;vertical-align:top"><button class="btn btn-service-msg" type="button" style="padding:20px 20px;">등록</button></div>
            </form>
        </div>
    </div>
</div>
<input type="hidden" id="memo_start" value=1>
<script>
$(function(){
    getMemo()
    $(".btn-edit").click(function(){
        if(confirm("수정 하시겠습니까?")){
            if($("#sv_auto_extension_check").prop("checked") == true){
                $("#sv_auto_extension").val("2");
            }else{
                $("#sv_auto_extension").val("1");
            }
            var datas = $("#registerForm").serialize();
            var url = "/api/groupServiceEdit";
           
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    if(response.result){
                        alert("수정완료");
                        document.location.reload();
                        // getMemo();
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    })

    $(".btn-service-msg").click(function(){
        if($("#sg_msg").val() == ""){
            alert("내용을 입력해 주세요");
            return false;
        }
        var url = "/api/serviceGroupMemoAdd";
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
        var sg_seq = $(this).data("seq");
        console.log($("#msg_hide_"+sg_seq).css("display"));
        if($("#msg_hide_"+sg_seq).css("display") != "none"){
            var url = "/api/serviceGroupMemoModify";
            if($("#sg_msg_"+sg_seq).val() == ""){
                alert("내용을 입력해 주세요");
                return false;
            }
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sg_seq="+sg_seq+"&sg_msg="+$("#sg_msg_"+sg_seq).val(),
                success:function(response){
                    if(response.result){

                        getMemo();
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }else{
            $("#msg_hide_"+sg_seq).show();
            $("#msg_show_"+sg_seq).hide();
        }


    })

    $("body").on("click",".btn-service-msg-delete",function(){
        if(confirm("삭제하시겠습니까?")){
            var sg_seq = $(this).data("seq");
            var url = "/api/serviceGroupMemoDelete";

            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sg_seq="+sg_seq,
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
});

function getMemo(){

    var url = "/api/serviceGroupMemoFetch";
    var end = 10;
    var start = (parseInt($("#memo_start").val())-1)*end;
// alert(start);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : "sg_sv_code="+$("#sg_sv_code").val()+"&start="+start+"&end="+end,
        success:function(response){
            console.log(response);
            var html = "";
            for(var i = 0;i<response.list.length;i++){
                var num = parseInt(response.list.length)  - i;
                html += '<tr>\
                            <td>'+num+'</td>\
                            <td>'+response.list[i].sg_regdate+'</td>\
                            <td><div id="msg_show_'+response.list[i].sg_seq.replace(/\n/g, "<br />")+'">'+response.list[i].sg_msg.replace(/\n/g, "<br />")+'</div><div id="msg_hide_'+response.list[i].sg_seq+'" style="display:none"><textarea style="width:100%;height:50px" id="sg_msg_'+response.list[i].sg_seq+'">'+response.list[i].sg_msg+'</textarea></div></td>\
                            <td></td>\
                            <td class="btn-service-msg-modify" data-seq="'+response.list[i].sg_seq+'"><i class="fas fa-edit"></i></td>\
                            <td class="btn-service-msg-delete" data-seq="'+response.list[i].sg_seq+'"><i class="fas fa-trash"></i></td>\
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
</script>