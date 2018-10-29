<div style="background:#fff;width:100%;overflow-x:hidden">
    <div class="popup_title" style="padding:10px">
         결제 상세
    </div>
    <div style="padding:0px">
        <form name="payForm" id="payForm">
        <input type="hidden" name="pm_seq" id="p_pm_seq" value="<?=$info["pm_seq"]?>">
        <div class="modal-title">
            <div class="modal-title-text"><div>서비스 기본 정보</div></div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>서비스 종류</div></div>
                <div class="input" id="p_pm_pc_name">
                    <?=$info["pc_name"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>계약번호</div></div>

                <div class="input" id="p_pm_sv_code"><?=$info["sv_code"]?></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label "><div>상품명</div></div>

                <div class="input" id="p_pm_pr_name"><?=$info["pr_name"]?></div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>서비스 번호</div></div>
                <div class="input" id="p_pm_sv_number"><?=$info["sv_number"]?></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>청구명</div></div>
                <div class="input" id="p_pm_claim_name"><?=$info["pm_claim_name"]?></div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>소분류</div></div>
                <div class="input" id="p_pm_ps_name"><?=$info["ps_name"]?></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>계산서 품목명</div></div>
                <div class="input" id="p_pm_bill_name"><?=$info["pm_bill_name"]?></div>
            </div>
            <div class="modal-field-input">
                
            </div>
        </div>

        <div class="modal-title">
            <div class="modal-title-text"><div>서비스 결제 조건</div></div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>요금 납부 방법</div></div>
                <div class="input">
                    <select name="pm_pay_type" id="p_pm_pay_type" class="select2" style="width:90px">
                        <option value="1" <?=($info["pm_pay_type"] == "1" ? "selected":"")?> >무통장</option>
                        <option value="2" <?=($info["pm_pay_type"] == "2" ? "selected":"")?>>카드</option>
                        <option value="3" <?=($info["pm_pay_type"] == "3" ? "selected":"")?>>CMS</option>
                    </select>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>결제 주기</div></div>
                <div class="input" id="p_pm_payment_period">일회성</div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>청구일</div></div>
                <div class="input"><span id="p_pm_pay_day"><?=$info["pm_date"]?></span>
                    
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>서비스 기간</div></div>
                <div class="input">
                   
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>계산서 발행</div></div>
                <div class="input" id="p_pm_payment_publish">
                    <?php if($info["pm_payment_publish"] == "0"): ?>
                        <?php if($info["pm_payment_publish_type"] == "0"): ?>
                            영수발행
                        <?php else: ?>
                            청구발행
                        <?php endif; ?>
                    <?php else: ?>
                        미발행
                    <?php endif;?>
                    
                    
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>결제일</div></div>
                <div class="input" id="p_pm_com_date">
                    <input type="text" name="pm_com_date" value="<?=substr($info["pm_com_date"],0,10) ?>" class="datepicker3">
                </div>
            </div>
        </div>

        <div style="float:left;width:49.5%;background:#fff">
            <div class="modal-title">
                <div class="modal-title-text"><div>일회성 요금</div></div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:38%"><div>일회성 항목명</div></div>
                    <div class="input" id="p_pm_first_bill_name" style="width:48%"><?=($info["svp_first_claim_name"] == "" ? $info["pm_claim_name"]:$info["svp_first_claim_name"])?></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:38%"><div>일회성 요금</div></div>
                    <div class="input" style="width:45%;padding-left:9px;"><input type="text" name="pm_once_price" class="border-no right" value="<?=number_format($info["pm_once_price"])?>" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')" > </div>
                    <div style="display:inline-block">원</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%;color:#fa0000;">
                    <div class="label" style="width:38%"><div>할인 금액</div></div>
                    <div class="input" style="width:45%"> - <input type="text" name="pm_once_dis_price" class="border-no right" style="color:#fa0000;" value="<?=number_format($info["pm_once_dis_price"])?>" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')" > </div>
                    <div style="display:inline-block;padding-left:9px;">원</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:38%"><div>할인 사유</div></div>
                    <div class="input" style="width:45%;padding-left:9px;"><input type="text" name="pm_once_dis_msg" class="border-no" value="<?=$info["pm_once_dis_msg"]?>" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%;font-weight:bold;">
                    <div class="label" style="width:38%"><div>일회성 청구 합계</div></div>
                    <div class="input right" id="p_pm_once_total" style="width:49.8%"><?=number_format($info["pm_once_price"]-$info["pm_once_dis_price"])?> <span style="padding-left:15px;">원</span></div>
                </div>
            </div>
            
        </div>

        

        <div class="modal-title" style="clear:both;">
            <div class="modal-title-text"><div>청구 합계</div></div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>일회성 청구 합계</div></div>
                <div class="modal-field-input right" id="p_pm_total_price1"><?=number_format($info["pm_once_price"]-$info["pm_once_dis_price"])?> 원</div>
            </div>

            <div class="modal-field-input" style="color:#0070C0;font-weight:bold;">
                <div class="label"><div>청구 합계</div></div>
                
                <div class="modal-field-input right" id="p_pm_total_price2"><?=number_format($info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_first_day_price"])?> 원</div>
                
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>&nbsp;</div></div>
                <div class="modal-field-input right" id="p_pm_total_price3"></div>
            </div>

            <div class="modal-field-input">
                <div class="label"><div>부가세</div></div>
                <?php if($info["pm_surtax_type"] == "0"): ?>
                <div class="modal-field-input right" id="p_pm_total_price4">
                    <?=number_format(($info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_first_day_price"])*0.1)?> 원
                </div>
                <?php else: ?>
                <div class="modal-field-input right" id="p_pm_total_price4">
                    0 원
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>&nbsp;</div></div>
                <div class="modal-field-input right" id="p_pm_total_price5"></div>
            </div>

            <div class="modal-field-input" style="font-weight:bold;">
                <div class="label"><div>총 청구 합계</div></div>
                <?php if($info["pm_surtax_type"] == "0"): ?>
                <div class="modal-field-input right" id="p_pm_total_price6">
                    <?=number_format(($info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_first_day_price"])*1.1)?> 원
                </div>
                <?php else: ?>
                <div class="modal-field-input right" id="p_pm_total_price6">
                    <?=number_format(($info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_first_day_price"]))?> 원
                </div>
                <?php endif;?>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text"><div>관리자 메모</div></div>
        </div>
        <div class="modal-field border-bottom-0">
            <div class="modal-field-input" style="width:100%">
                <textarea name="pm_memo" style="width:99.4%;height:100px;background-color:#fafafa;"><?=$info["pm_memo"]?></textarea>
            </div>
        </div>
        <div class="modal-button">
            <button class="btn btn-black btn-paycom-modify" type="button">수정</button>
        </div>
    </form>
    </div>

</div>
<script src="/assets/js/memberClaimView.js?date=<?=time()?>"></script>