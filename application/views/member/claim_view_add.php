<div style="background:#fff;width:100%;overflow-x:hidden">
    <div class="popup_title" style="padding:10px">
         청구 상세
    </div>
    <div style="padding:0px">
        <form name="payForm" id="payForm">
        <input type="hidden" name="pm_seq" id="p_pm_seq" value="<?=$info["pm_seq"]?>">
        <input type="hidden" id="pm_pay_period" value="<?=$info["pm_pay_period"]?>">
        <input type="hidden" id="pm_register_discount" value="<?=$info["svp_register_discount"]?>">
        <input type="hidden" name="pm_end_date" id="pm_end_date" value="<?=$info["pm_end_date"]?>">
        <input type="hidden" id="sv_payment_day" value="<?=$info["sv_payment_day"]?>">
        <input type="hidden" id="pm_first_day_price" value="<?=$info["pm_first_day_price"]?>">
        <input type="hidden" id="pm_payment_dis_price" name="pm_payment_dis_price" value="<?=$info["pm_payment_dis_price"]?>">
        <div class="modal-title">
            <div class="modal-title-text"><div>서비스 기본 정보</div></div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>서비스 종류</div></div>
                <div class="input" id="p_pm_pc_name">
                    <?=$info["pi_name"]?> - 부가항목
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

                <div class="input" id="p_pm_pr_name"><?=$info["sva_name"]?></div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>대표 서비스 번호</div></div>
                <div class="input" id="p_pm_sv_number"><?=$info["sv_number"]?></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>청구명</div></div>
                <div class="input" id="p_pm_claim_name"><?=$info["sva_claim_name"]?></div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>부가항목 서비스 번호</div></div>
                <div class="input" id="p_pm_ps_name"><?=$info["sva_number"]?></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>계산서 품목명</div></div>
                <div class="input" id="p_pm_bill_name"><?=$info["sva_bill_name"]?></div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>&nbsp;</div></div>
                <div class="input" id="p_pm_rental">
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="modal-title">
            <div class="modal-title-text"><div>서비스 결제 조건</div></div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>요금 납부 방법</div></div>
                <div class="input">
                    <select name="pm_pay_type" id="pm_pay_type" class="select2" style="width:90px">
                        <option value="1" <?=($info["pm_pay_type"] == "1" ? "selected":"")?> >무통장</option>
                        <option value="2" <?=($info["pm_pay_type"] == "2" ? "selected":"")?>>카드</option>
                        <option value="3" <?=($info["pm_pay_type"] == "3" ? "selected":"")?>>CMS</option>
                    </select>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>결제 주기</div></div>
                <div class="input" id="pm_payment_period"><?=$info["pm_pay_period"]?> 개월</div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>청구일</div></div>
                <div class="input"><span id="p_pm_pay_day"><input type="text" name="pm_date" value="<?=$info["pm_date"]?>" class="datepicker2"></span>
                    <?php if($info["sv_pay_type"] == "0"): ?>
                        전월 <?=$info["sv_pay_day"]?>일
                    <?php elseif($info["sv_pay_type"] == "1"):?>
                        당월 <?=$info["sv_pay_day"]?>일
                    <?php elseif($info["sv_pay_type"] == "2"):?>
                        익월 <?=$info["sv_pay_day"]?>일
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>서비스 기간</div></div>
                <div class="input">
                    <input type="text" name="pm_service_start" id="p_pm_payment_start" class="border-no" style="width:40%;display:inline-block" value="<?=$info["pm_service_start"]?>" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"> ~ <input type="text" name="pm_service_end" id="p_pm_payment_end" class="border-no" style="width:40%;display:inline-block" value="<?=$info["pm_service_end"]?>" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')">
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
                <div class="label"><div>결제 기한</div></div>
                <div class="input" id="p_pm_end_date">
                    <?=$info["pm_end_date"] ?>
                </div>
            </div>
        </div>

        <div style="float:left;width:49.2%;background:#fff">
            <div class="modal-title">
                <div class="modal-title-text"><div>일회성 요금</div></div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:38%"><div>일회성 항목명</div></div>
                    <div class="input right" id="pm_first_bill_name" style="width:48%"><?=($info["pm_claim_type"] == "0" ? $info["svp_first_claim_name"]:"")?></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:38%"><div>일회성 요금</div></div>
                    <div class="input" style="width:45%;padding-left:10px;"><input type="text" name="pm_once_price" id="pm_once_price" class="border-no right" value="<?=number_format($info["pm_once_price"])?>" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)"> </div>
                    <div style="display:inline-block">원</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%;color:#fa0000;">
                    <div class="label" style="width:38%"><div>할인 금액</div></div>
                    <div class="input" style="width:45%"> - <input type="text" name="pm_once_dis_price" id="pm_once_dis_price" class="border-no right" value="<?=number_format($info["pm_once_dis_price"])?>" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)"> </div>
                    <div style="display:inline-block;padding-left:9px;">원</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:38%"><div>할인 사유</div></div>
                    <div class="input" style="width:45%;padding-left:10px;"><input type="text" name="pm_once_dis_msg" class="border-no" value="<?=$info["pm_once_dis_msg"]?>" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%;font-weight:bold;">
                    <div class="label" style="width:38%;"><div>일회성 청구 합계</div></div>
                    <div class="input right" id="p_pm_once_total" style="width:49.8%"><?=number_format($info["pm_once_price"]-$info["pm_once_dis_price"])?> <span style="padding-left:15px;">원</span></div>
                </div>
            </div>
            <?php if($info["pm_claim_type"] == "0"): ?>
            <div class="modal-title">
                <div class="modal-title-text"><div>초기 일할 요금</div></div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:38%"><div>초기 일할 기간</div></div>
                    <?php if($info["pm_first_day_start"] != ""): ?>
                    <div class="input" id="p_pm_first_term"><?=$info["pm_first_day_start"]?> ~ <?=$info["pm_first_day_end"]?></div>
                    <?php else: ?>
                    <div class="input" id="p_pm_first_term"></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%;font-weight:bold;">
                    <div class="label" style="width:38%"><div>초기 일할 요금</div></div>
                    <div class="input right" id="p_pm_first_price1" style="width:49.8%"><?=number_format($info["pm_first_day_price"])?> <span style="padding-left:15px;">원</span></div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div style="float:right;width:50.8%;background:#fff">
            <div class="modal-title">
                <div class="modal-title-text"><div>월 청구 요금</div></div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:38%"><div>서비스 월 요금</div></div>
                    <div class="input" style="width:45%;padding-left:10px;"><input type="text" name="pm_service_price" id="pm_service_price" class="border-no right" value="<?=number_format($info["pm_service_price"])?>" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)"></div>
                    <div style="display:inline-block">원 / 월</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%;color:#fa0000;">
                    <div class="label" style="width:38%"><div>할인 금액</div></div>
                    <div class="input" style="width:45%"> - <input type="text" name="pm_service_dis_price" id="pm_service_dis_price" class="border-no right" value="<?=number_format($info["pm_service_dis_price"])?>" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)"></div>
                    <div style="display:inline-block;padding-left:9px;">원 / 월</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:38%"><div>할인 사유</div></div>
                    <div class="input" style="width:45%;padding-left:10px;"><input type="text" name="pm_service_dis_msg" class="border-no" value="<?=$info["pm_service_dis_msg"]?>" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:38%"><div>소계(월 요금 + 할인)</div></div>
                    <div class="input" id="p_month_price1" style="text-align:right;width:44%"><?=number_format($info["pm_service_price"]-$info["pm_service_dis_price"])?></div>
                    <div style="display:inline-block;padding-left:14px;">원 / 월</div>
                </div>
            </div>
            <?php if($info["pm_claim_type"] == "0"): ?>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:38%"><div>일할 외 청구기간</div></div>
                    <?php if($info["pm_first_month_start"] == "" || $info["pm_first_month_start"] == "0000-00-00"): ?>
                        <?php
                        $month = 0; 
                        ?>
                        <div class="input" id="p_month_date" style="text-align:right;width:45%">(0 개월)</div>
                    <?php else: ?>
                        <?php 
                        $date1 = date('Y-m-d', strtotime($info["pm_first_month_end"] . ' +1 day'));

                        $date1 = new DateTime($date1);
                        $date2 = new DateTime($info["pm_first_month_start"]);

                        $diff = $date1->diff($date2);
                        // print_r($diff);
                        if($diff->format("%d") > 27){
                            $month = (($diff->format('%y') * 12) + $diff->format('%m'))+1;
                        }else{
                            $month = (($diff->format('%y') * 12) + $diff->format('%m'));
                        }
                        if($month == 0){
                            $month = 1;
                        }
                        ?>
                        <div class="input" id="p_month_date" style="text-align:right;width:45%"><?=$info["pm_first_month_start"]?> ~ <?=$info["pm_first_month_end"]?> (<?=$month?>개월)</div>
                    <?php endif; ?>


                </div>
            </div><input type="hidden" id="month" value="<?=$month?>">
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:38%"><div>일할 외 청구기간 합계</div></div>
                    <div class="input" id="p_month_price2" style="text-align:right;width:44%"><?=number_format(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month)?></div>
                    <div style="display:inline-block;padding-left:14px;">원 / <span class="total_contract"><?=$month?></span>개월</div>
                </div>
            </div>
            <?php else: ?>
                <?php $month = $info["pm_pay_period"]; ?>
                <input type="hidden" id="month" value="<?=$info["pm_pay_period"]?>">
            <?php endif; ?>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%;color:#fa0000;">
                    <div class="label" style="width:38%"><div>결제 방법 할인</div></div>
                    <?php if($info["pm_payment_dis_price"] > 0): ?>
                    <div class="input" id="p_month_price3" style="text-align:right;width:44%"> - <?=number_format(($info["pm_payment_dis_price"]/$info["pm_pay_period"])*$month)?></div>
                    <?php else: ?>
                    <div class="input" id="p_month_price3" style="text-align:right;width:44%"> - 0</div>
                    <?php endif; ?>
                    <div style="display:inline-block;padding-left:14px;">원</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%;font-weight:bold;">
                    <div class="label" style="width:38%"><div>서비스 청구 합계</div></div>
                    <?php if($info["pm_payment_dis_price"] > 0): ?>
                    <div class="input" id="p_month_price4" style="text-align:right;width:44%"><?=number_format(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month-($info["pm_payment_dis_price"]/$info["pm_pay_period"])*$month)?></div>
                    <?php else: ?>
                    <div class="input" id="p_month_price4" style="text-align:right;width:44%"><?=number_format(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month)?></div>
                    <?php endif; ?>
                    <div style="display:inline-block;padding-left:14px;">원 / <span class="total_contract"><?=$month?></span>개월</div>
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
                <?php if($info["pm_payment_dis_price"] > 0): ?>
                <div class="modal-field-input right" id="p_pm_total_price2"><?=number_format($info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_first_day_price"]+(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month)-($info["pm_payment_dis_price"]/$info["pm_pay_period"])*$month)?> 원</div>
                <?php else: ?>
                <div class="modal-field-input right" id="p_pm_total_price2"><?=number_format($info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_first_day_price"]+(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month))?> 원</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="modal-field">
            <?php if($info["pm_claim_type"] == "0"): ?>
            <div class="modal-field-input">
                <div class="label"><div>초기 일할 요금</div></div>
                <div class="modal-field-input right" id="p_pm_total_price3"><?=number_format($info["pm_first_day_price"])?> 원</div>
            </div>
            <?php else:?>
            <div class="modal-field-input">
                <div class="label"><div>서비스 청구 합계</div></div>
                <?php if($info["pm_payment_dis_price"] > 0): ?>
                <div class="modal-field-input right" id="p_pm_total_price5"><?=number_format(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month-($info["pm_payment_dis_price"]/$info["pm_pay_period"])*$month)?> 원</div>
                <?php else: ?>
                <div class="modal-field-input right" id="p_pm_total_price5"><?=number_format(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month)?> 원</div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="modal-field-input">
                <div class="label"><div>부가세</div></div>
                <?php if($info["pm_payment_dis_price"] > 0): ?>
                <div class="modal-field-input right" id="p_pm_total_price4">
                    <?=number_format(($info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_first_day_price"]+(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month)-($info["pm_payment_dis_price"]/$info["pm_pay_period"])*$month)*0.1)?> 원
                </div>
                <?php else: ?>
                <div class="modal-field-input right" id="p_pm_total_price4">
                    <?=number_format(($info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_first_day_price"]+(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month))*0.1)?> 원
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="modal-field">
            <?php if($info["pm_claim_type"] == "0"): ?>
            <div class="modal-field-input">
                <div class="label"><div>서비스 청구 합계</div></div>
                <?php if($info["pm_payment_dis_price"] > 0): ?>
                <div class="modal-field-input right" id="p_pm_total_price5"><?=number_format(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month-($info["pm_payment_dis_price"]/$info["pm_pay_period"])*$month)?> 원</div>
                <?php else: ?>
                <div class="modal-field-input right" id="p_pm_total_price5"><?=number_format(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month)?> 원</div>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div class="modal-field-input">
                <div class="label"><div>&nbsp;</div></div>
                <div class="input right"></div>
            </div>
            <?php endif; ?>
            <div class="modal-field-input" style="font-weight:bold;">
                <div class="label"><div>총 청구 합계</div></div>
                <?php if($info["pm_payment_dis_price"] > 0): ?>
                <div class="modal-field-input right" id="p_pm_total_price6">
                    <?=number_format(($info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_first_day_price"]+(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month)-($info["pm_payment_dis_price"]/$info["pm_pay_period"])*$month)*1.1)?> 원
                </div>
                <?php else: ?>
                <div class="modal-field-input right" id="p_pm_total_price6">
                    <?=number_format(($info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_first_day_price"]+(($info["pm_service_price"]-$info["pm_service_dis_price"])*$month))*1.1)?> 원
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
            <button class="btn btn-black btn-claim-modify" type="button">수정</button>
        </div>
    </form>
    </div>

</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
<script src="/assets/js/memberClaimView.js?date=<?=time()?>"></script>