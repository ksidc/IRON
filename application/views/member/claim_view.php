<div style="background:#fff;width:100%;overflow-x:hidden">
    <div class="popup_title" style="padding:10px">
         청구 정보
    </div>
    <div style="padding:5px">
        <form name="payForm" id="payForm">
        <input type="hidden" name="pm_seq" id="p_pm_seq">
        <div class="modal-title">
            <div class="modal-title-text">서비스 기본 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">서비스 종류</div>
                <div class="input" id="p_pm_pc_name">
                    <?=$info["pc_name"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">계약번호</div>

                <div class="input" id="p_pm_sv_code"><?=$info["sv_code"]?></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label ">상품명</div>

                <div class="input" id="p_pm_pr_name"><?=$info["pr_name"]?></div>
            </div>
            <div class="modal-field-input">
                <div class="label">서비스 번호</div>
                <div class="input" id="p_pm_sv_number"><?=$info["sv_number"]?></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">청구명</div>
                <div class="input" id="p_pm_claim_name"><?=$info["sv_claim_name"]?></div>
            </div>
            <div class="modal-field-input">
                <div class="label">소분류</div>
                <div class="input" id="p_pm_ps_name"><?=$info["ps_name"]?></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">계산서 품목명</div>
                <div class="input" id="p_pm_bill_name"><?=$info["sv_bill_name"]?></div>
            </div>
            <div class="modal-field-input">
                <div class="label">임대 형태</div>
                <div class="input" id="p_pm_rental"></div>
            </div>
        </div>

        <div class="modal-title">
            <div class="modal-title-text">서비스 결제 조건</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">요금 납부 방법</div>
                <div class="input">
                    <select name="pm_pay_type" id="p_pm_pay_type" class="select2" style="width:90px">
                        <option value="1" <?=($info["sv_payment_type"] == "1" ? "selected":"")?> >무통장</option>
                        <option value="2" <?=($info["sv_payment_type"] == "2" ? "selected":"")?>>카드</option>
                        <option value="3" <?=($info["sv_payment_type"] == "3" ? "selected":"")?>>CMS</option>
                    </select> 선택시 바로 적용됩니다.
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">결제 주기</div>
                <div class="input" id="p_pm_payment_period"><?=$info["sv_payment_period"]?> 개월</div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">청구일</div>
                <div class="input"><span id="p_pm_pay_day"><?=$info["sv_pay_day"]?></span></div>
            </div>
            <div class="modal-field-input">
                <div class="label">서비스 기간</div>
                <div class="input">
                    <input type="text" name="pm_payment_start" id="p_pm_payment_start" class="border-no" style="width:40%;display:inline-block" value="<?=$info["pm_service_start"]?>"> ~ <input type="text" name="pm_payment_end" id="p_pm_payment_end" class="border-no" style="width:40%;display:inline-block" value="<?=$info["pm_service_end"]?>">
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">계산서 발행</div>
                <div class="input" id="p_pm_payment_publish">
                    <?php if($info["pm_payment_publish"] == "0"): ?>
                        영수발행
                    <?php else: ?>
                        청구발행
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">결제 기한</div>
                <div class="input" id="p_pm_end_date">
                    <?=$info["pm_end_date"] ?>
                </div>
            </div>
        </div>

        <div style="float:left;width:50%;background:#fff">
            <div class="modal-title">
                <div class="modal-title-text">일회성 요금</div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">일회성 항목명</div>
                    <div class="input" id="p_pm_first_bill_name" style="width:45%"><?=$info["pm_once_price"]?></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">일회성 요금</div>
                    <div class="input" style="width:45%"><?=$info["pm_once_price"]?></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">할인 금액</div>
                    <div class="input" style="width:45%"><?=$info["pm_once_dis_price"]?></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">할인 사유</div>
                    <div class="input" style="width:45%"><?=$info["svp_once_dis_msg"]?></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">일회성 청구 합계</div>
                    <div class="input" id="p_pm_once_total" style="width:45%"><?=$info["pm_once_price"]-$info["pm_once_dis_price"]?></div>
                </div>
            </div>
            <div class="modal-title">
                <div class="modal-title-text" style="font-size:12px">초기 일할 요금</div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">초기 일할 기간</div>
                    <div class="input" id="p_pm_first_term"></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label">초기 일할 요금</div>
                    <div class="input" id="p_pm_first_price1"></div>
                </div>
            </div>
        </div>
        <div style="float:right;width:50%;background:#fff">
            <div class="modal-title">
                <div class="modal-title-text">월 청구 요금</div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">서비스 월 요금</div>
                    <div class="input" style="width:45%"><?=$info["pm_service_price"]?></div>
                    <div style="display:inline-block">원 / 월</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">할인 금액</div>
                    <div class="input" style="width:45%"><?=$info["pm_service_dis_price"]?></div>
                    <div style="display:inline-block">원 / 월</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">할인 사유</div>
                    <div class="input" style="width:45%"><?=$info["svp_month_dis_msg"]?></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">소계(월 요금 + 할인)</div>
                    <div class="input" id="p_month_price1" style="text-align:right;width:45%"><?=$info["pm_service_price"]-$info["pm_service_dis_price"]?></div>
                    <div style="display:inline-block">원 / 월</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">일할 외 청구기간</div>
                    <div class="input" id="p_month_date" style="text-align:right;width:45%"><?=$info["pm_service_service_start"]?> ~ <?=$info["pm_service_service_end"]?> (<?=$info["pm_pay_period"]?>개월)</div>

                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">일할 외 청구기간 합계</div>
                    <div class="input" id="p_month_price2" style="text-align:right;width:45%"><?=$info["pm_service_price"]-$info["pm_service_dis_price"]?></div>
                    <div style="display:inline-block">원 / <span class="total_contract"></span>개월</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">결제 방법 할인</div>
                    <div class="input" id="p_month_price3" style="text-align:right;width:45%"><?=$info["pm_payment_dis_price"]?></div>
                    <div style="display:inline-block">원</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input" style="width:100%">
                    <div class="label" style="width:35%">서비스 요금 합계</div>
                    <div class="input" id="p_month_price4" style="text-align:right;width:45%"><?=$info["pm_total_price"]?></div>
                    <div style="display:inline-block">원 / <span class="total_contract"></span>개월</div>
                </div>
            </div>

        </div>

        <div class="modal-title" style="clear:both;">
            <div class="modal-title-text">청구 합계</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">일회성 청구 합계</div>
                <div class="input" id="p_pm_total_price1"><?=$info["pm_once_price"]-$info["pm_once_dis_price"]?></div>
            </div>

            <div class="modal-field-input">
                <div class="label">청구 합계</div>
                <div class="input" id="p_pm_total_price2"><?=$info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_service_price"]-$info["pm_service_dis_price"]?></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">초기 일할 요금</div>
                <div class="input" id="p_pm_total_price3"></div>
            </div>

            <div class="modal-field-input">
                <div class="label">부가세</div>
                <div class="input" id="p_pm_total_price4">
                    <?=($info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_service_price"]-$info["pm_service_dis_price"])*0.1?>
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">서비스 청구 합계</div>
                <div class="input" id="p_pm_total_price5"><?=$info["pm_service_price"]-$info["pm_service_dis_price"]?></div>
            </div>

            <div class="modal-field-input">
                <div class="label">총 청구 합계</div>
                <div class="input" id="p_pm_total_price6">
                    <?=($info["pm_once_price"]-$info["pm_once_dis_price"]+$info["pm_service_price"]-$info["pm_service_dis_price"])*1.1?>
                </div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">관리자 메모</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input" style="width:100%">
                <textarea name="" style="width:98%;height:150px"></textarea>
            </div>
        </div>
        <div class="modal-button">
            <button class="btn btn-black btn-payment_modify" type="button">수정</button>
        </div>
    </form>
    </div>

</div>