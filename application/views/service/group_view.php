<div style="background:#fff;width:100%;overflow-x:hidden">
    <div class="popup_title" style="padding:10px;margin-right:5px">

        상세 계약 정보

    </div>
    <div style="padding:0px 5px 0px 0px;">
        <form name="registerForm" id="registerForm" method="post" >
            <input type="hidden" name="sg_sv_seq" id="sg_sv_seq" value="<?=$sv_seq?>">
            <input type="hidden" name="sv_auto_extension" id="sv_auto_extension" value="<?=$list[0]["sv_auto_extension"]?>">
            <div class="modal-title">
                <div class="modal-title-text"><div>기본 정보</div></div>
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
            <div class="modal-title-text"><div>서비스 내역</div></div>
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
                    <th style="text-align:right;">초기 일회성</th>
                    <th style="text-align:right;">월(기준)요금</th>
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
                        <td><?=($row["sva_seq"] == "" ? $row["pc_name"]:"부가항목")?></td>
                        <td><?=($row["sva_seq"] == "" ? $row["pr_name"]:$row["sva_name"])?></td>
                        <td><?=($row["sva_seq"] == "" ? $row["ps_name"]:"")?></td>
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
                    <tr style="border-top:3px double #d9d9d9;">
                        <td colspan="5">합계</td>
                        <td class="right"><?=number_format($totalprice1)?> 원</td>
                        <td class="right"><?=number_format($totalprice2)?> 원</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-title">
            <div class="modal-title-text"><div>계약 변경 내역</div></div>
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
                    <?php foreach($history_list as $i=>$row): ?>
                        <?php $num = $i+1;?>
                    <tr>
                        <td><?=$num?></td>
                        <td>
                            <?php if($row["sh_type"] == "0"): ?>
                                최초계약
                            <?php elseif($row["sh_type"] == "1"): ?>
                                변경계약
                            <?php elseif($row["sh_type"] == "2"): ?>
                                수동연장
                            <?php elseif($row["sh_type"] == "3"): ?>
                                계약해지
                            <?php elseif($row["sh_type"] == "4"): ?>
                                자동연장
                            <?php endif; ?>
                        </td>
                        <td><?=$row["sh_date"]?></td>
                        <?php if($row["sh_service_start"] == "0000-00-00"): ?>
                        <td></td>
                        <?php else:?>
                        <td><?=$row["sh_service_start"]?> ~ <?=$row["sh_service_end"]?></td>
                        <?php endif; ?>
                        <td>
                            <?php if($row["sh_auto_extension"] == "1"): ?>
                                <?=$row["sh_auto_extension_month"]?>개월
                            <?php else: ?>
                                재 계약 필요
                            <?php endif; ?>
                        </td>
                        <td><a href="<?=$row["sh_link"]?>" target="_blank"><?=$row["sh_link"]?></a></td>
                        <td><i class="fa fa-edit historyEdit" data-seq="<?=$row["sh_seq"]?>" data-shtype="<?=$row["sh_type"]?>" data-shservicestart="<?=$row["sh_service_start"]?>" data-shserviceend="<?=$row["sh_service_end"]?>" data-shlink="<?=$row["sh_link"]?>"></i> <i class="fa fa-trash historyDel" data-seq="<?=$row["sh_seq"]?>"></i></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <form id="historyAdd">
            <input type="hidden" id="sh_sv_code" name="sh_sv_code" value="<?=$sv_code?>">
            <input type="hidden" id="sh_seq" name="sh_seq" value="">
        <div style="font-size:12px;padding:5px 0px 5px 56px;">
            <div style="display:inline-block;width:15%;">
                <select name="sh_type" id="sh_type" class="select2" style="width:80%">
                    <option value="">선택</option>
                    <option value="1">변경 계약</option>
                    <option value="2">수동 연장</option>
                    <option value="3">계약 해지</option>
                </select>
            </div>
            <div style="display:inline-block;width:44%;text-align:center" id="contract_date">
                계약 기간
                <input type="text" name="sh_service_start" id="sh_service_start" class="datepicker3" style="width:20%" value="<?=date("Y-m-d")?>"> ~ <input type="text" name="sh_service_end" id="sh_service_end" class="datepicker3" style="width:20%" value="<?=date("Y-m-d")?>">
            </div>
            <div style="display:inline-block;width:37%">
				링크
                <input type="text" name="sh_link" id="sh_link" style="width:75%"><button class="btn btn-brown btn-small btn-history-add" type="button">등록</button>
            </div>
        </div>
        </form>
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
        <div style="background:#f4f4f4;padding:10px 0px 30px">
            <form name="service_msg" id="service_msg">
                <input type="hidden" name="sg_sv_code" id="sg_sv_code" value="<?=$sv_code?>">
                <div style="display:inline-block;width:17%;text-align:right;vertical-align:top;padding:20px 5px 0px 0px">메모</div>
                <div style="display:inline-block;width:70%;vertical-align:top">
                    <textarea class="memo" name="sg_msg" id="sg_msg"></textarea>
                </div>
                <div style="display:inline-block;width:10%;vertical-align:top"><button class="btn btn-brown btn-service-msg" type="button" style="padding:20px 20px;">등록</button></div>
            </form>
        </div>
    </div>
</div>
<input type="hidden" id="memo_start" value=1>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
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

    $(".btn-history-add").click(function(){
        if($("#sh_seq").val() == ""){
            var url = "/api/serviceHistoryAdd";
            var msg = "등록하시겠습니까?";
        }else{
            var url = "/api/serviceHistoryEdit";
            var msg = "수정하시겠습니까?";
        }
        if(confirm(msg)){
            
            var datas = $("#historyAdd").serialize();
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    if(response.result){
                        if($("#sh_seq").val() == ""){
                            alert("등록 되었습니다.");
                        }else{
                            alert("수정 되었습니다.");
                        }
                        document.location.reload();
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    });

    $("body").on("click",".historyDel",function(){
        if(confirm("삭제하시겠습니까?")){
            var sh_seq = $(this).data("seq");
            var url = "/api/serviceHistoryDel";
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "sh_seq="+sh_seq,
                success:function(response){
                    if(response.result){
                        alert("삭제 되었습니다.");
                        document.location.reload();
                    }else{
                        alert("오류발생")
                    }
                }
            });
        }
    })

    $("body").on("click",".historyEdit",function(){
        var sh_type = $(this).data("shtype");
        var sh_service_start = $(this).data("shservicestart");
        var sh_service_end = $(this).data("shserviceend");
        var sh_link = $(this).data("shlink");
        var sh_seq = $(this).data("seq");

        $("#sh_type").val(sh_type).trigger("change");
        $("#sh_service_start").val(sh_service_start);
        $("#sh_service_end").val(sh_service_end);
        $("#sh_link").val(sh_link);
        $("#sh_seq").val(sh_seq);
        $(".btn-history-add").text("수정");
    })

    $("#sh_type").change(function(){
        if($(this).val() == "3"){
            $("#contract_date").css("opacity",0);
        }else{
            $("#contract_date").css("opacity",1);
        }
    })
});

function getMemo(){

    var url = "/api/serviceGroupMemoFetch";
    var end = 5;
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
                var num = parseInt(response.total) - (($("#memo_start").val()-1)*end) - i;
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