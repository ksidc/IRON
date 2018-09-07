<style>

</style>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<div class="content">
    <form>
    <input type="hidden" name="sv_seq" id="sv_seq" value="<?=$info["sv_seq"]?>">
    <input type="hidden" name="sv_eu_seq" id="sv_eu_seq" value="<?=$info["sv_eu_seq"]?>">
    <input type="hidden" name="sv_ct_seq" id="sv_ct_seq" value="<?=$info["sv_ct_seq"]?>">
    <input type="hidden" id="sv_status" value="<?=$info["sv_status"]?>">
    <input type="hidden" id="end_yn" value="">
    <input type="hidden" id="force_end_yn" value="">
    <div style="border:1px solid #eee;background:#fff;border-radius:6px;margin-top:20px;width:70%">
        <div class="modal-title">
            <div class="modal-title-text"><div>신청 회원 정보</div></div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>상호/이름(아이디)</div></div>
                <div class="input padd" >
                    <a href="/member/view/<?=$info["mb_seq"]?>"><?=$info["mb_name"]?> (<?=$info["mb_id"]?>)</a>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>End User</div></div>
                <div class="input">
                    <input type="text" class="width-button" name="eu_name" id="eu_name" value="<?=$info["eu_name"]?>" readonly><button class="btn btn-brown " type="button" onclick='$( "#dialogEndSearch" ).dialog("open");$("#dialogEndSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd" ><div>서비스 번호</div></div>
                <div class="input padd">
                    <?=$info["sv_number"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>업체 분류</div></div>
                <div class="input">
                    <input type="text" class="width-button" name="ct_name" id="ct_name" value="<?=$info["ct_name"]?>" readonly><button class="btn btn-brown " type="button" onclick='typeGetList();$( "#dialogTypeSearch" ).dialog("open");$("#dialogTypeSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>계약 번호</div></div>
                <div class="input">
                    <?php
                    $code = explode("-",$info["sv_code"]);
                    ?>
                    <input type="text" name="sv_code1" id="sv_code1" style="width:30%;border:1px solid #ddd;height:22px" value="<?=$code[0]?>"> - <input type="text" name="sv_code2" id="sv_code2" style="width:20%;border:1px solid #ddd;height:22px" value="<?=$code[1]?>"> <button class="btn btn-brown btn-small btn-number-duple" type="button">중복확인</button>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>사내 담당자</div></div>
                <div class="input">
                    <select name="sv_part" class="select2" style="width:110px">
                        <option value="">기술팀</option>
                        <option value=""></option>
                    </select>
                    <select name="sv_charger" class="select2" style="width:110px">
                        <option value="">노성민</option>
                        <option value=""></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>계약 시작일</div></div>
                <div class="input">
                    <input type="text" name="sv_contract_start" value="<?=$info["sv_contract_start"]?>" class="datepicker3">
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>계약 만료일</div></div>
                <div class="input">
                    <input type="text" name="sv_contract_end" value="<?=$info["sv_contract_end"]?>" class="datepicker3">
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>자동 계약 연장 여부</div></div>
                <div class="input">
                    <input type="radio" name="sv_auto_extension" value="1" <?=($info["sv_auto_extension"] == "1" ? "checked":"")?> > <label>자동 계약 연장</label> (단위 : <input type="text" name="sv_auto_extension_month" value="<?=$info["sv_auto_extension_month"]?>" style="width:20px">개월) <input type="radio" name="sv_auto_extension" <?=($info["sv_auto_extension"] == "2" ? "checked":"")?>> 재 계약 필요
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>계약 만료일(연장)</div></div>
                <div class="input padd">
                    <?=$info["sv_contract_end"]?>
                </div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text"><div>상품 정보</div></div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>서비스 종류</div></div>
                <div class="input padd">
                    <?=$info["pc_name"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>제품군</div></div>
                <div class="input padd">
                    <?=$info["pi_name"]?>
                </div>
            </div>
        </div>

        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>상품명</div></div>
                <div class="input padd">
                    <?=$info["pr_name"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>청구명</div></div>
                <div class="input">
                    <input type="text" value="<?=$info["sv_claim_name"]?>">
                </div>
            </div>
        </div>

        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>대분류</div></div>
                <div class="input padd">
                    <?=$info["pd_name"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>소분류</div></div>
                <div class="input padd">
                    <?=$info["ps_name"]?>
                </div>
            </div>
        </div>

        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>임대 형태</div></div>
                <div class="input">
                    <?php if($info["sv_rental"] == "N"):?>
                        -
                    <?php else: ?>
                    <select name="" class="select2" style="width:120px">
                        <option value="">소유권 이전</option>
                        <option value="">영구 임대</option>
                    </select> <input type="text" style="width:40px"> 개월
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>소유권 이전일</div></div>
                <div class="input">
                    <?php if($info["sv_rental"] == "N"):?>

                    <?php else: ?>
                        <?php
                        $sv_rental_end_date = date("Y-m-d",mktime(0,0,0,substr($sv_contract_start,5,2)+$info["sr_rental_date"], substr($sv_contract_start,8,2),substr($sv_contract_start,0,4))) ;
                        ?>
                        <input type="text" class="datepicker3" name="sv_rental_end_date" id="sv_rental_end_date" value="<?=$sv_rental_end_date?>">
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full">
                <div class="label padd"><div>기술/관제 담당자</div></div>
                <div class="input">
                    <select name="sv_engineer_part" id="sv_engineer_part" class="select2" style="width:120px">
                        <option value="">팀을 선택해주세요</option>
                        <option value="1">기술팀</option>
                    </select>
                    <select name="sv_engineer_charger" id="sv_engineer_charger" class="select2" style="width:120px">
                        <option value="">팀을 선택해주세요</option>
                        <option value="1">노성민</option>
                    </select>
                    <button class="btn btn-brown btn-small btn-manager-change" type="button">담당자 지정</button>
                    <button class="btn btn-black btn-small" type="button">이메일 발송</button>
                </div>
            </div>
        </div>
        <div style="text-align:center;padding:10px 0px">
            <button class="btn btn-default" type="button" onclick="document.location.href='/service_list'">목록</button>
            <button class="btn btn-default btn-edit" type="button">수정</button>
            <button class="btn btn-default btn-delete" data-seq="<?=$info["sv_seq"]?>" type="button">삭제</button>
        </div>
    </form>
        <div class="modal-title">
            <div class="modal-title-text"><div>결제 상태 정보</div></div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>과금 시작일</div></div>
                <div class="input padd">
                    <?=$payment["pm_service_start"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>최종 결제일</div></div>
                <div class="input padd">

                </div>
            </div>
        </div>

        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>과금 만료일</div></div>
                <div class="input padd">
                    <?=$payment["pm_service_end"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>결제 상태</div></div>
                <div class="input padd">
                    <?php if($payment["pm_status"] == "0"): ?>
                        <?php if($payment["pm_pay_period"] > 1): ?>
                            <?php $custom_end_date = date("Y-m-d",mktime(0,0,0,substr($payment["pm_date"],5,2)+1,substr($payment["pm_date"],8,2), substr($payment["pm_date"],0,4))); ?>
                            <?php if(date("Y-m-d") >= $custom_end_date):?>
                                연체
                            <?php else: ?>
                                <?php if($payment["pm_end_date"] >= date("Y-m-d")): ?>
                                    청구(<?=$payment["pm_pay_period"]?>개월)
                                <?php else: ?>
                                    미납(<?=$payment["pm_pay_period"]?>개월)
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if($payment["leftCount"] > 1): ?>
                                연체(<?=$payment["leftCount"]?>개월)
                            <?php else: ?>
                                <?php if($payment["pm_end_date"] >= date("Y-m-d")): ?>
                                    청구(<?=$payment["pm_pay_period"]?>개월)
                                <?php else: ?>
                                    미납(<?=$payment["pm_pay_period"]?>개월)
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php elseif($payment["pm_status"] == "1"):?>
                        가결제(<?=$payment["pm_pay_period"]?>개월) <?=$payment["pm_input_date"]?>
                    <?php else: ?>
                        완납
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div style="width:49.8%;float:left">
            <div class="modal-title">
                <div class="modal-title-text"><div>처리 일자 정보 / 서비스 상태 변경</div></div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>서비스 상태</div></div>
                    <div class="input input2">
                        <?php if($info["sv_status"] == "0"): ?>
                            입금대기중
                        <?php elseif($info["sv_status"] == "1"): ?>
                            서비스준비중
                        <?php elseif($info["sv_status"] == "2"): ?>
                            서비스작업중
                        <?php elseif($info["sv_status"] == "3"): ?>
                            서비스중
                        <?php elseif($info["sv_status"] == "4"): ?>
                            서비스중지
                        <?php elseif($info["sv_status"] == "5"): ?>
                            서비스해지
                        <?php elseif($info["sv_status"] == "6"): ?>
                            직권중지
                        <?php elseif($info["sv_status"] == "7"): ?>
                            직권해지
                        <?php endif;?>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>서비스 신청일</div></div>
                    <div class="input input2">
                        <?=$info["sv_regdate"] ?>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>제품 출고일</div></div>
                    <div class="input input2">
                        <?php if($info["sv_out_date"] == ""):?>
                            <?php $inputdate = date("Y-m-d");?>
                            <div style="display:inline-block;width:50%">

                            </div>
                            <div style="text-align:right;display:inline-block;width:45%">
                                <button class="btn btn-black" onclick='$( "#dialogOut" ).dialog("open");$("#dialogOut").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();' type="button">제품 출고</button>
                            </div>
                        <?php else: ?>
                            <?php $inputdate = substr($info["sv_out_date"],0,10);?>
                            <div style="display:inline-block;width:50%">
                                <?=substr($info["sv_out_date"],0,10)?>
                            </div>
                            <div style="text-align:right;display:inline-block;width:45%">
                                <i class="fa fa-edit" onclick='$( "#dialogOut" ).dialog("open");$("#dialogOut").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();' type="button"></i>
                            </div>

                        <?php endif;?>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>서비스 개시일</div></div>
                    <div class="input input2">
                        <?php if($info["sv_service_start"] == ""):?>

                            <?php if($info["sv_status"] == "2"): ?>
                            <div style="display:inline-block;width:50%">

                            </div>
                            <div style="text-align:right;display:inline-block;width:45%">
                                <button class="btn btn-black btn-service-open"  type="button">서비스 개시</button>
                            </div>
                            <?endif; ?>
                        <?php else: ?>
                            <div style="display:inline-block;width:80%">
                                <div id="view_service_open"><?=substr($info["sv_service_start"],0,10)?></div>
                                <div id="edit_service_open" style="display:none">
                                    <input type="text" name="sv_service_start1" id="sv_service_start1" style="width:100px">
                                    <select name="sv_service_start2" class="select2" id="sv_service_start2" style="width:60px">
                                        <?php for($i = 0; $i < 24;$i++): ?>
                                        <option value="<?=$i?>" <?=($i == substr($info["sv_service_start"],11,2) ? "":"")?>><?=$i?></option>
                                        <?php endfor;?>
                                    </select> 시
                                    <select name="sv_service_start3" class="select2" id="sv_service_start3" style="width:60px">
                                        <?php for($i = 0; $i < 59;$i++): ?>
                                        <option value="<?=$i?>" <?=($i == substr($info["sv_service_start"],13,2) ? "":"")?>><?=$i?></option>
                                        <?php endfor;?>
                                    </select> 분
                                    <select name="sv_service_start4" class="select2" id="sv_service_start4" style="width:60px">
                                        <?php for($i = 0; $i < 59;$i++): ?>
                                        <option value="<?=$i?>" <?=($i == substr($info["sv_service_start"],15,2) ? "":"")?>><?=$i?></option>
                                        <?php endfor;?>
                                    </select> 초
                                </div>
                            </div>
                            <div style="text-align:right;display:inline-block;width:18%">
                                <i class="fa fa-edit"  type="button" onclick="setServiceDate()"></i>
                            </div>
                        <?php endif;?>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>서비스 중지일</div></div>
                    <div class="input input2">
                        <?php if($info["sv_service_stop"] == ""):?>
                            <?php if($info["sv_status"] == "3"): ?>
                            <div style="display:inline-block;width:40%">

                            </div>
                            <div style="text-align:right;display:inline-block;width:55%">
                                <button class="btn btn-black btn-service-stop" type="button" onclick='$( "#dialogStop" ).dialog("open");$("#dialogStop").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>서비스 중지</button>
                                <button class="btn btn-black btn-service-forcestop" type="button">직권 중지</button>
                            </div>
                            <?endif; ?>
                        <?php else: ?>
                            <?=$info["sv_service_stop"]?>
                        <?php endif;?>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>서비스 해지일</div></div>
                    <div class="input input2">
                        <?php if($info["sv_service_end"] == ""):?>
                            <?php if($info["sv_status"] == "3" || $info["sv_status"] == "4" || $info["sv_status"] == "7" || $info["sv_status"] == "6"): ?>
                            <div style="display:inline-block;width:40%">

                            </div>
                            <div style="text-align:right;display:inline-block;width:55%">
                                <button class="btn btn-black btn-service-end" type="button" onclick='serviceEnd()'>서비스 해지</button>
                                <button class="btn btn-black btn-service-forceend" type="button" onclick='serviceForceEnd()'>직권 해지</button>
                            </div>
                            <?endif; ?>
                        <?php else: ?>
                            <?=$info["sv_service_end"]?>
                        <?php endif;?>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>서비스 재시작일</div></div>
                    <div class="input input2">
                        <?php if($info["sv_service_restart"] == ""):?>
                            <?php if($info["sv_status"] == "4" || $info["sv_status"] == "5" || $info["sv_status"] == "7" || $info["sv_status"] == "6"): ?>
                            <div style="display:inline-block;width:40%">

                            </div>
                            <div style="text-align:right;display:inline-block;width:55%">
                                <button class="btn btn-black btn-service-restart" type="button" >서비스 재시작</button>
                            </div>
                            <?endif; ?>
                        <?php else: ?>
                            <?=$info["sv_service_restart"]?>
                        <?php endif;?>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"></div>
                    <div class="input input2">

                    </div>
                </div>

            </div>
        </div>
        <div style="width:49.8%;float:right">
            <div class="modal-title">
                <div class="modal-title-text"><div>처리 일자 정보 / 서비스 상태 변경</div></div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>서비스 신청서</div></div>
                    <div class="input input2" >
                        <div style="display:inline-block;width:30%;">
                            <button class="btn btn-black " type="button" onclick="$('#file1').trigger('click')">찾아보기</button>
                            <form name="form_file1" id="form_file1" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="sv_seq" value="<?=$info["sv_seq"]?>">
                                <input type="hidden" name="sf_type" value="1">
                                <input type="file" name="file[]" id="file1" multiple style="display:none">
                            </form>
                        </div>

                        <div id="file1_area" style="display:inline-block;width:68%">
                            <?php foreach($files as $row): ?>
                                <?php if($row["sf_type"] == "1"):?>
                                    <div style="clear:both;padding-top:3px">
                                        <div style="float:left">
                                            <div><a href="/api/fileDownload/service_file/?filename=<?=$row["sf_file"]?>&originname=<?=$row["sf_origin_file"]?>"><?=$row["sf_origin_file"]?></a></div>
                                        </div>
                                        <div style="float:right">
                                            <div><button class="btn btn-black btn-upload-del" type="button" data-seq="<?=$row["sf_seq"]?>">삭제</button></div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>서비스 계약서</div></div>
                    <div class="input input2">
                        <div style="display:inline-block;width:30%;">
                            <button class="btn btn-black " type="button" onclick="$('#file2').trigger('click')">찾아보기</button>
                            <form name="form_file2" id="form_file2" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="sv_seq" value="<?=$info["sv_seq"]?>">
                                <input type="hidden" name="sf_type" value="2">
                                <input type="file" name="file[]" id="file2" multiple style="display:none">
                            </form>
                        </div>

                        <div id="file2_area" style="display:inline-block;width:68%">
                            <?php foreach($files as $row): ?>
                                <?php if($row["sf_type"] == "2"):?>
                                    <div style="clear:both;padding-top:3px">
                                        <div style="float:left">
                                            <div><a href="/api/fileDownload/service_file/?filename=<?=$row["sf_file"]?>&originname=<?=$row["sf_origin_file"]?>"><?=$row["sf_origin_file"]?></a></div>
                                        </div>
                                        <div style="float:right">
                                            <div><button class="btn btn-black btn-upload-del" type="button" data-seq="<?=$row["sf_seq"]?>">삭제</button></div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>CMS 신청서</div></div>
                    <div class="input input2">
                        <div style="display:inline-block;width:30%;">
                            <button class="btn btn-black " type="button" onclick="$('#file3').trigger('click')">찾아보기</button>
                            <form name="form_file3" id="form_file3" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="sv_seq" value="<?=$info["sv_seq"]?>">
                                <input type="hidden" name="sf_type" value="3">
                                <input type="file" name="file[]" id="file3" multiple style="display:none">
                            </form>
                        </div>

                        <div id="file3_area" style="display:inline-block;width:68%">
                            <?php foreach($files as $row): ?>
                                <?php if($row["sf_type"] == "3"):?>
                                    <div style="clear:both;padding-top:3px">
                                        <div style="float:left">
                                            <div><a href="/api/fileDownload/service_file/?filename=<?=$row["sf_file"]?>&originname=<?=$row["sf_origin_file"]?>"><?=$row["sf_origin_file"]?></a></div>
                                        </div>
                                        <div style="float:right">
                                            <div><button class="btn btn-black btn-upload-del" type="button" data-seq="<?=$row["sf_seq"]?>">삭제</button></div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>신분증 사본</div></div>
                    <div class="input input2">
                        <div style="display:inline-block;width:30%;">
                            <button class="btn btn-black " type="button" onclick="$('#file4').trigger('click')">찾아보기</button>
                            <form name="form_file4" id="form_file4" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="sv_seq" value="<?=$info["sv_seq"]?>">
                                <input type="hidden" name="sf_type" value="4">
                                <input type="file" name="file[]" id="file4" multiple style="display:none">
                            </form>
                        </div>

                        <div id="file4_area" style="display:inline-block;width:68%">
                            <?php foreach($files as $row): ?>
                                <?php if($row["sf_type"] == "4"):?>
                                    <div style="clear:both;padding-top:3px">
                                        <div style="float:left">
                                            <div><a href="/api/fileDownload/service_file/?filename=<?=$row["sf_file"]?>&originname=<?=$row["sf_origin_file"]?>"><?=$row["sf_origin_file"]?></a></div>
                                        </div>
                                        <div style="float:right">
                                            <div><button class="btn btn-black btn-upload-del" type="button" data-seq="<?=$row["sf_seq"]?>">삭제</button></div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>통장 사본</div></div>
                    <div class="input input2">
                        <div style="display:inline-block;width:30%;">
                            <button class="btn btn-black " type="button" onclick="$('#file5').trigger('click')">찾아보기</button>
                            <form name="form_file5" id="form_file5" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="sv_seq" value="<?=$info["sv_seq"]?>">
                                <input type="hidden" name="sf_type" value="5">
                                <input type="file" name="file[]" id="file5" multiple style="display:none">
                            </form>
                        </div>

                        <div id="file5_area" style="display:inline-block;width:68%">
                            <?php foreach($files as $row): ?>
                                <?php if($row["sf_type"] == "5"):?>
                                    <div style="clear:both;padding-top:3px">
                                        <div style="float:left">
                                            <div><a href="/api/fileDownload/service_file/?filename=<?=$row["sf_file"]?>&originname=<?=$row["sf_origin_file"]?>"><?=$row["sf_origin_file"]?></a></div>
                                        </div>
                                        <div style="float:right">
                                            <div><button class="btn btn-black btn-upload-del" type="button" data-seq="<?=$row["sf_seq"]?>">삭제</button></div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>해지신청서</div></div>
                    <div class="input input2">
                        <div style="display:inline-block;width:30%;">
                            <button class="btn btn-black " type="button" onclick="$('#file6').trigger('click')">찾아보기</button>
                            <form name="form_file6" id="form_file6" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="sv_seq" value="<?=$info["sv_seq"]?>">
                                <input type="hidden" name="sf_type" value="6">
                                <input type="file" name="file[]" id="file6" multiple style="display:none">
                            </form>
                        </div>

                        <div id="file6_area" style="display:inline-block;width:68%"><?php foreach($files as $row): ?>
                                <?php if($row["sf_type"] == "6"):?>
                                    <div style="clear:both;padding-top:3px">
                                        <div style="float:left">
                                            <div><a href="/api/fileDownload/service_file/?filename=<?=$row["sf_file"]?>&originname=<?=$row["sf_origin_file"]?>"><?=$row["sf_origin_file"]?></a></div>
                                        </div>
                                        <div style="float:right">
                                            <div><button class="btn btn-black btn-upload-del" type="button" data-seq="<?=$row["sf_seq"]?>">삭제</button></div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?></div>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>명의 변경 신청서</div></div>
                    <div class="input input2">
                        <div style="display:inline-block;width:30%;">
                            <button class="btn btn-black " type="button" onclick="$('#file7').trigger('click')">찾아보기</button>
                            <form name="form_file7" id="form_file7" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="sv_seq" value="<?=$info["sv_seq"]?>">
                                <input type="hidden" name="sf_type" value="7">
                                <input type="file" name="file[]" id="file7" multiple style="display:none">
                            </form>
                        </div>

                        <div id="file7_area" style="display:inline-block;width:68%">
                            <?php foreach($files as $row): ?>
                                <?php if($row["sf_type"] == "7"):?>
                                    <div style="clear:both;padding-top:3px">
                                        <div style="float:left">
                                            <div><a href="/api/fileDownload/service_file/?filename=<?=$row["sf_file"]?>&originname=<?=$row["sf_origin_file"]?>"><?=$row["sf_origin_file"]?></a></div>
                                        </div>
                                        <div style="float:right">
                                            <div><button class="btn btn-black btn-upload-del" type="button" data-seq="<?=$row["sf_seq"]?>">삭제</button></div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label label2 padd"><div>기타</div></div>
                    <div class="input input2">
                       <div style="display:inline-block;width:30%;">
                            <button class="btn btn-black " type="button" onclick="$('#file8').trigger('click')">찾아보기</button>
                            <form name="form_file8" id="form_file8" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="sv_seq" value="<?=$info["sv_seq"]?>">
                                <input type="hidden" name="sf_type" value="8">
                                <input type="file" name="file[]" id="file8" multiple style="display:none">
                            </form>
                        </div>

                        <div id="file8_area" style="display:inline-block;width:68%">
                            <?php foreach($files as $row): ?>
                                <?php if($row["sf_type"] == "8"):?>
                                    <div style="clear:both;padding-top:3px">
                                        <div style="float:left">
                                            <div><a href="/api/fileDownload/service_file/?filename=<?=$row["sf_file"]?>&originname=<?=$row["sf_origin_file"]?>"><?=$row["sf_origin_file"]?></a></div>
                                        </div>
                                        <div style="float:right">
                                            <div><button class="btn btn-black btn-upload-del" type="button" data-seq="<?=$row["sf_seq"]?>">삭제</button></div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>

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
                <input type="hidden" name="sv_seq" value="<?=$info["sv_seq"]?>">
                <div style="display:inline-block;width:17%;text-align:right;vertical-align:top;padding:20px 5px 0px 0px">메모</div>
                <div style="display:inline-block;width:70%;vertical-align:top">
                    <textarea style="width:100%;height:50px" name="sm_msg" id="sm_msg"></textarea>
                </div>
                <div style="display:inline-block;width:10%;vertical-align:top"><button class="btn btn-service-msg" type="button" style="padding:20px 20px;">등록</button></div>
            </form>
        </div>
        <div class="modal-title">
            <div class="modal-title-text"><div>변경 로그</div></div>
        </div>
        <div>
            <table>
                <thead>
                <tr>
                    <th>No</th>
                    <th>입력시간</th>
                    <th>내용</th>
                    <th>작성자</th>
                    <th>수정/삭제</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>


</div>
<div id="dialogEndSearch" class="dialog" style="padding:5px">
    <form name="endSearchForm" id="endSearchForm" method="get">
    <div class="modal_search">
        <ul>
            <li>
                END User
            </li>
            <li >
                <input type="text" name="endSearchWord" id="endSearchWord" style="vertical-align:top"><button class="btn btn-brown btn-small btn-search-end" type="submit" style="padding:5.5px 7px;margin-bottom:3px">검색</button>
            </li>
        </ul>
    </div>
    </form>
    <div class="modal_search_list" style="height:230px">
        <table class="table">
            <thead>
            <tr>
                <th>코드</th>
                <th>END User</th>
                <th>수정</th>
                <th>삭제</th>
            </tr>
            </thead>
            <tbody style="height:230px" id="modalSearchEnd">

            </tbody>
        </table>
    </div>
    <p class="etc-info"> * END User 수정 시 기존 등록된 정보도 함께 변경됩니다.</p>
    <form id="endAdd">
    <div class="type-add">
        <div class="type-add-left">
            <div style="display:inline-block">코드</div>
            <div style="display:inline-block"><input type="text" name="addEnd" id="addEnd" style="width:50px"></div>
        </div>
        <div class="type-add-right" style="padding-left:30px">
            <div style="display:inline-block">END User</div>
            <div style="display:inline-block"><input type="text" name="eu_name" id="eu_name" style="vertical-align:top"><button class="btn btn-brown btn-small btn-end-add" type="submit" style="padding:5.5px 7px;margin-bottom:3px">신규 등록</button></div>
        </div>
    </div>
    </form>
    <div class="modal-close-btn"><button class="btn btn-black btn-small" onclick="$('#dialogEndSearch').dialog('close')">닫기</button></div>
</div>
<div id="dialogTypeSearch" class="dialog" style="padding:5px">
    <form name="typeSearchForm" id="typeSearchForm" method="get" onsubmit="return typeGetList()">
    <div class="modal_search">
        <ul>
            <li >
                분류명 (서비스 종류)
            </li>
            <li >
                <input type="text" name="typeSearchWord" id="typeSearchWord" style="vertical-align:top"><button class="btn btn-brown btn-small btn-search-type" type="submit" style="padding:5.5px 7px;margin-bottom:3px">검색</button>
            </li>
        </ul>
    </div>
    </form>
    <div class="modal_search_list" style="height:230px">
        <table class="table" >
            <thead>
            <tr>
                <th>코드</th>
                <th>분류명</th>
                <th>수정</th>
                <th>삭제</th>
            </tr>
            </thead>
            <tbody style="height:230px" id="modalSearchType">

            </tbody>
        </table>
    </div>
    <p class="etc-info"> * 분류명 수정 시 기존 등록된 정보도 함께 변경됩니다.</p>
    <form id="typeAdd">
    <div class="type-add">
        <div class="type-add-left">
            <div style="display:inline-block">코드</div>
            <div style="display:inline-block"><input type="text" name="addType" id="addType" style="width:50px"></div>
        </div>
        <div class="type-add-right" style="padding-left:30px">
            <div style="display:inline-block">분류명</div>
            <div style="display:inline-block"><input type="text" name="ct_name" id="ct_name" style="vertical-align:top"><button class="btn btn-brown btn-small btn-type-add" type="submit" style="padding:5.5px 7px;margin-bottom:3px">신규 등록</button></div>
        </div>
    </div>
    </form>
    <div class="modal-close-btn"><button class="btn btn-black btn-small" onclick="$('#dialogTypeSearch').dialog('close')">닫기</button></div>
</div>

<div id="dialogOut" class="dialog" style="padding:5px">
    <div class="modal_search">
        <ul>
            <li >
                제품 출고
            </li>

        </ul>
    </div>
    <form id="outForm">

        <div class="modal-field" style="margin-top:20px">
            <div class="modal-field-input">
                <div class="label"><div>출고일</div></div>
                <div class="input">
                    <input type="text" name="sv_out_date" id="sv_out_date" value="<?=$inputdate?>" class="datepicker3">
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>구분</div></div>

                <div class="input"><input type="radio" name="sv_out_type" id="sv_out_type_0" value="0" <?=($info["sv_out_type"] == "0" || $info["sv_out_type"] == "" ? "checked":"")?>>매입 <input type="radio" name="sv_out_type" id="sv_out_type_1" value="1" <?=($info["sv_out_type"] == "1" ? "checked":"")?>>재고</div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full">
                <div class="label"><div>제품 시리얼 No.</div></div>
                <div class="input">
                    <input type="text" name="sv_out_serial" id="sv_out_serial" value="<?=$info["sv_out_serial"]?>">
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full">
                <div class="label"><div>메모</div></div>
                <div class="input">
                    <input type="text" name="sv_out_memo" id="sv_out_memo" value="<?=$info["sv_out_memo"]?>">
                </div>
            </div>
        </div>
    </form>
    <div class="modal-close-btn" style="margin-top:115px"><button class="btn btn-black btn-small btn-out-reg">등록</button> <button class="btn btn-default btn-small" onclick="$('#dialogOut').dialog('close')">닫기</button></div>
</div>

<div id="dialogStop" class="dialog" style="padding:5px">
    <div class="modal_search">
        <ul>
            <li >
                서비스 중지
            </li>

        </ul>
    </div>
    <form id="stopForm">

        <div class="modal-field" style="margin-top:20px">
            <div class="modal-field-input">
                <div class="label"><div>서비스 중지일</div></div>
                <div class="input">
                    <input type="text" name="sv_service_stop" id="sv_service_stop" value="<?=date("Y-m-d")?>" class="datepicker3">
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>재시작일</div></div>

                <div class="input"><input type="text" name="sv_service_restart" id="sv_service_restart" value="<?=$info["sv_service_restart"]?>" ></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full">
                <div class="label"><div>서비스 중지 사유</div></div>
                <div class="input">
                    <input type="text" name="sv_service_stop_msg" id="sv_service_stop_msg" value="<?=$info["sv_service_stop_msg"]?>">
                </div>
            </div>
        </div>
        <p> 서비스 중지는 <span style="color:red">서비스 일시중지 신청 서류</span>가 접수된 후 처리해야 하며, 서비스 중지 기간은 <span style="color:red">최대 1개월</span>입니다.</p>
        <p> 만약 약정된 계약기간이 있을 경우, <span style="color:red">중지 기간 만큼 계약 기간이 연장</span>되어야 합니다.</p>
    </form>
    <div class="modal-close-btn" style="margin-top:115px"><button class="btn btn-black btn-small btn-stop-reg">등록</button> <button class="btn btn-default btn-small" onclick="$('#dialogOut').dialog('close')">닫기</button></div>
</div>
<div id="dialogEnd" class="dialog" style="padding:5px">
    <div class="modal_search">
        <ul>
            <li >
                서비스 해지
            </li>

        </ul>
    </div>
    <form id="stopForm">

        <div class="modal-field" style="margin-top:20px">
            <div class="modal-field-input">
                <div class="label"><div>서비스 해지일</div></div>
                <div class="input">
                    <input type="text" name="sv_service_end" id="sv_service_end" value="<?=date("Y-m-d")?>" class="datepicker3">
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full">
                <div class="label"><div>서비스 해지 사유</div></div>
                <div class="input">
                    <select name="sv_service_end_msg" id="sv_service_end_msg">
                        <option value="서비스 축소">서비스 축소</option>
                        <option value="서비스 종료">서비스 종료</option>
                        <option value="사업자 폐업">사업자 폐업</option>
                        <option value="서비스 교체">서비스 교체</option>
                        <option value="타사 이전">타사 이전</option>
                        <option value="서비스 불만">서비스 불만</option>
                        <option value="기타">기타</option>
                    </select>
                    <input type="text" name="sv_service_end_msg_etc" id="sv_service_end_msg_etc" style="display:none" value="<?=$info["sv_service_stop_msg"]?>">
                </div>
            </div>
        </div>
        <p> 서비스 해지는 <span style="color:red">서비스 해지 신청 서류</span> 접수 확인 및 <span style="color:red">미납 요금</span>이 없을 경우 처리해야 합니다.</p>
    </form>
    <div class="modal-close-btn" style="margin-top:115px"><button class="btn btn-black btn-small btn-end-reg">등록</button> <button class="btn btn-default btn-small" onclick="$('#dialogOut').dialog('close')">닫기</button></div>
</div>
<div id="dialogForceEnd" class="dialog" style="padding:5px">
    <div class="modal_search">
        <ul>
            <li >
                직권 해지
            </li>

        </ul>
    </div>
    <form id="stopForm">

        <div class="modal-field" style="margin-top:20px">
            <div class="modal-field-input">
                <div class="label"><div>직권 해지일</div></div>
                <div class="input">
                    <input type="text" name="sv_service_force_end" id="sv_service_force_end" value="<?=date("Y-m-d")?>" class="datepicker3">
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full">
                <div class="label"><div>서비스 해지 사유</div></div>
                <div class="input">
                    <select name="sv_service_force_end_msg" id="sv_service_force_end_msg">
                        <option value="요금 체납">요금 체납</option>
                        <option value="기타">기타</option>
                    </select>
                    <input type="text" name="sv_service_force_end_msg_etc" id="sv_service_force_end_msg_etc" style="display:none" value="<?=$info["sv_service_stop_msg"]?>">
                </div>
            </div>
        </div>

    </form>
    <div class="modal-close-btn" style="margin-top:115px"><button class="btn btn-black btn-small btn-forceend-reg">등록</button> <button class="btn btn-default btn-small" onclick="$('#dialogOut').dialog('close')">닫기</button></div>
</div>
<input type="hidden" id="memo_start" value=1>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
<script type="text/javascript" src="/assets/js/serviceView.js"></script>