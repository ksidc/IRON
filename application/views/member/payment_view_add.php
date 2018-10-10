<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
<div style="background:#fff;width:100%;overflow-x:hidden">
    <div class="popup_title" style="padding:10px">
         요금 정보
    </div>
    <div style="padding:5px">
    <form name="serviceAddUpdate" id="serviceAddUpdate">
        <input type="hidden" name="mb_seq" id="mb_seq" value="<?=$info["mb_seq"]?>">
        <input type="hidden" name="sv_seq" class="sv_seq" value="<?=$info["sv_seq"]?>">
        <input type="hidden" name="svp_seq" class="svp_seq" value="<?=$info["svp_seq"]?>">
        <input type="hidden" name="sv_account_type" id="sv_account_type" value="<?=$info["sv_account_type"]?>">
        <input type="hidden" name="sv_account_policy" id="sv_account_policy" value="<?=$info["sv_account_policy"]?>">
        <input type="hidden" name="sv_account_start_day" id="sv_account_start_day" value="<?=$info["sv_account_start_day"]?>">
        <input type="hidden" name="sv_account_format" id="sv_account_format" value="<?=$info["sv_account_format"]?>">
        <input type="hidden" name="sv_account_format_policy" id="sv_account_format_policy" value="<?=$info["sv_account_format_policy"]?>">
        <input type="hidden" name="svp_first_day_price" id="svp_first_day_price" value="<?=$info["svp_first_day_price"]?>">
        <input type="hidden" name="svp_first_day_start" id="svp_first_day_start" value="<?=$info["svp_first_day_start"]?>">
        <input type="hidden" name="svp_first_day_end" id="svp_first_day_end" value="<?=$info["svp_first_day_end"]?>">
        <input type="hidden" name="svp_first_month_price" id="svp_first_month_price" value="<?=$info["svp_first_month_price"]?>">
        <input type="hidden" name="svp_first_month_start" id="svp_first_month_start" value="<?=$info["svp_first_month_start"]?>">
        <input type="hidden" name="svp_first_month_end" id="svp_first_month_end" value="<?=$info["svp_first_month_end"]?>">
        <div class="modal-title">
            <div class="modal-title-text">서비스 기본 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>서비스 종류</div></div>
                <div class="input" id="pc_name">
                    <?=$info["pc_name"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>계약번호</div></div>

                <div class="input" id="sv_code"><?=$info["sv_code"]?></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label "><div>상품명</div></div>

                <div class="input" id="pr_name"><?=$info["sva_name"]?></div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>대표 서비스 번호</div></div>
                <div class="input" id="sv_number"><?=$info["sv_number"]?></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>청구명</div></div>
                <div class="input"><input type="text" name="sva_claim_name" id="sva_claim_name" value="<?=$info["sva_claim_name"]?>"></div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>부가 항목 서비스 번호</div></div>
                <div class="input" id="ps_name"><?=$info["sva_number"]?></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>계산서 품목명</div></div>
                <div class="input"><input type="text" name="sva_bill_name" id="sva_bill_name" value="<?=$info["sva_bill_name"]?>"></div>
            </div>
            <div class="modal-field-input">
                <div class="label"><div>계산서 품목 분류</div></div>
                <div class="input">
                    <select name="sva_claim_type" id="s" class="select2" style="width:120px">
                        <option value="0" <?=($info["sva_claim_type"] == 0 ? "selected":"")?>>분류</option>
                        <option value="1" <?=($info["sva_claim_type"] == 1 ? "selected":"")?>>미분류</option>
                    </select>
                </div>
            </div>
        </div>
        <div <?=($info["sva_claim_type"] == 1 ? "style='display:none'":"")?> class="notshow">
            <div class="modal-title ">
                <div class="modal-title-text">서비스 결제 조건</div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label"><div>요금 납부 방법</div></div>
                    <div class="input">
                        <select name="sv_payment_type" id="sv_payment_type" class="select2" style="width:120px">
                            <option value="1" <?=($info["sv_payment_type"] == "1" ? "selected":"")?>>무통장</option>
                            <option value="2" <?=($info["sv_payment_type"] == "2" ? "selected":"")?>>카드</option>
                            <option value="3" <?=($info["sv_payment_type"] == "3" ? "selected":"")?>>CMS</option>
                        </select>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label"><div>결제 주기</div></div>
                    <div class="input"><input type="text" name="svp_payment_period" id="svp_payment_period" style="width:70px" value="<?=$info["svp_payment_period"]?>"> 개월</div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label"><div>청구 기준</div></div>
                    <div class="input">서비스 이용 월의 <select name="sv_pay_type" id="sv_pay_type" class="select2" style="width:80px">
                                    <option value="0" <?=($info["sv_pay_type"] == "0" ? "selected":"")?>>전월</option>
                                    <option value="1" <?=($info["sv_pay_type"] == "1" ? "selected":"")?>>당월</option>
                                    <option value="2" <?=($info["sv_pay_type"] == "2" ? "selected":"")?>>익월</option>
                                </select> 청구 </div>
                </div>
                <div class="modal-field-input">
                    <div class="label"><div>자동 청구일</div></div>
                    <div class="input">
                        <select name="sv_pay_day" id="sv_pay_day" class="select2" style="width:180px">
                            <option value="">자동 청구일을 선택하세요</option>
                            <?php for($i = 1; $i < 28;$i++): ?>
                            <option value="<?=($i)?>" <?=($info["sv_pay_day"] == $i ? "selected":"")?>><?=($i)?>일</option>
                            <?php endfor; ?>
                            <option value="말일" <?=($info["sv_pay_day"] > "28" ? "selected":"")?>>말일</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label"><div>계산서 발행</div></div>
                    <div class="input">
                        <select  name="sv_pay_publish" id="sv_pay_publish" class="select2" style="width:40%">
                            <option  value="0" <?=($info["sv_pay_publish"] == "0" ? "selected":"")?>>발행</option>
                            <option value="1" <?=($info["sv_pay_publish"] == "1" ? "selected":"")?>>미발행</option>

                        </select>


                        <select name="sv_pay_publish_type" id="sv_pay_publish_type" class="select2" style="width:40%">
                            <option value="0" <?=($info["sv_pay_publish_type"] == "0" ? "selected":"")?>>영수 발행</option>
                            <option value="1" <?=($info["sv_pay_publish_type"] == "1" ? "selected":"")?>>청구 발행</option>

                        </select>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label"><div>결제일</div></div>
                    <div class="input">
                        청구일로부터
                             <input type="text" style="width:15%" name="sv_payment_day" id="sv_payment_day" value="<?=$info["sv_payment_day"]?>"> 일 후
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label"><div>최초 과금 시작일</div></div>
                    <div class="input"><input type="text" style="width:38.7%" name="sv_account_start" id="sv_account_start" value="<?=$info["sv_account_start"]?>" class="datepicker4"> </div>
                </div>
                <div class="modal-field-input">
                    <div class="label"><div>최초 과금 만료일</div></div>
                    <div class="input"><input type="text" name="sv_account_end" id="sv_account_end" readonly value="<?=$info["sv_account_end"]?>"></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label"><div>초기 일할 청구</div></div>
                    <div class="input" id="policy">
                        <?php if($info["sv_account_format"] == "1"): ?>
                            <?php $text_format = "1의 자리"; ?>
                        <?php elseif($info["sv_account_format"] == "2"): ?>
                            <?php $text_format = "10의 자리"; ?>
                        <?php elseif($info["sv_account_format"] == "3"): ?>
                            <?php $text_format = "100의 자리"; ?>
                        <?php elseif($info["sv_account_format"] == "4"): ?>
                            <?php $text_format = "1000의 자리"; ?>
                        <?php endif; ?>

                        <?php if($info["sv_account_format_policy"] == "1"): ?>
                            <?php $text_format2 = "내림"; ?>
                        <?php elseif($info["sv_account_format_policy"] == "2"): ?>
                            <?php $text_format2 = "올림"; ?>
                        <?php elseif($info["sv_account_format_policy"] == "3"): ?>
                            <?php $text_format2 = "반올림"; ?>
                        <?php endif; ?>

                        <?php if($info["sv_account_type"] == "1"): ?>
                            <?php if($info["sv_account_policy"] == "1"):?>
                                <?php $text = "당월분 일할 계산"; ?>
                            <?php else: ?>
                                <?php $text = $info["sv_account_start_day"]."일(과금시작) 이후 건 익월분 통합"; ?>
                            <?php endif; ?>
                        <div class="input" style="font-size:11px"><span id="policy_text"><span id="policy_text1"><?=$text?></span> (<span id="policy_text2"><?=$text_format?> <?=$text_format2?></span>)</span> <span id="policy_text_2" style="display:none"></span> <button class="btn btn-brown btn-small" type="button" onclick='$( "#dialogFirstSetting" ).dialog("open");$("#dialogFirstSetting").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>변경</button></div>
                        <?php else: ?>
                        <div class="input" style="font-size:11px"><span id="policy_text" style="display:none"><span id="policy_text1">당월분 일할 계산</span> (<span id="policy_text2"><?=$text_format?> <?=$text_format2?></span>)</span> <span id="policy_text_2">과금 시작일 기준 결제 주기로 처리</span> <button class="btn btn-brown btn-small" type="button" onclick='$( "#dialogFirstSetting" ).dialog("open");$("#dialogFirstSetting").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>변경</button></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label"><div>등록할인율</div></div>
                    <div class="input"><input type="text" name="svp_register_discount" id="svp_register_discount" value="<?=$info["svp_register_discount"]?>" style="width:50%"> <input type="checkbox" id="defaultRegister">기본값으로 변경</div>
                </div>
            </div>
            <div style="float:left;width:50%">
                <div class="modal-title">
                    <div class="modal-title-text">일회성 요금</div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>초기 청구 항목명</div></div>
                        <div class="input" style="width:45%"><input type="text" name="svp_first_claim_name" id="svp_first_claim_name" value="<?=$info["svp_first_claim_name"]?>"> </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>초기 청구 요금</div></div>
                        <div class="input" style="width:45%"><input type="text" name="svp_once_price" id="svp_once_price" style="text-align:right" value="<?=$info["svp_once_price"]?>"></div>
                        <div style="display:inline-block">원</div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>할인 금액</div></div>
                        <div class="input" style="width:45%"><input type="text" name="svp_once_dis_price" id="svp_once_dis_price" style="text-align:right" value="<?=$info["svp_once_dis_price"]?>"> </div>
                        <div style="display:inline-block">원</div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>할인 사유</div></div>
                        <div class="input" style="width:45%"><input type="text" name="svp_once_dis_msg" id="svp_once_dis_msg" value="<?=$info["svp_once_dis_msg"]?>"></div>
                    </div>
                </div>
                <?php $once_price = $info["svp_once_price"]-$info["svp_once_dis_price"];?>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>합계</div></div>
                        <div class="input" id="first_sum" style="text-align:right;width:43%;padding-right:10px"><?=number_format($once_price)?></div>
                        <div style="display:inline-block">원</div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>부가세</div></div>
                        <div class="input" id="first_surtax" style="text-align:right;;width:43%;padding-right:10px"><?=number_format($once_price*0.1)?></div>
                        <div style="display:inline-block">원</div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>총계</div></div>
                        <div class="input" id="first_total" style="text-align:right;width:43%;padding-right:10px"><?=number_format($once_price*1.1)?></div>
                        <div style="display:inline-block">원</div>
                    </div>
                </div>
            </div>
            <div style="float:right;width:50%">
                <div class="modal-title">
                    <div class="modal-title-text">월 요금</div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>서비스 월 요금</div></div>
                        <div class="input" style="width:45%"><input type="text" name="svp_month_price" id="svp_month_price" style="text-align:right" value="<?=$info["svp_month_price"]?>"> </div>
                        <div style="display:inline-block">원 / 월</div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>할인 금액</div></div>
                        <div class="input" style="width:45%"><input type="text" name="svp_month_dis_price" id="svp_month_dis_price" style="text-align:right" value="<?=$info["svp_month_dis_price"]?>"></div>
                        <div style="display:inline-block">원 / 월</div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>할인 사유</div></div>
                        <div class="input" style="width:45%"><input type="text" name="svp_month_dis_msg" id="svp_month_dis_msg" value="<?=$info["svp_month_dis_msg"]?>"> </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>소계(월 요금 + 할인)</div></div>
                        <div class="input" id="month_price1" style="text-align:right;width:43%;padding-right:10px"><?=number_format($info["svp_month_price"]-$info["svp_month_dis_price"])?></div>
                        <div style="display:inline-block">원 / 월</div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>결제 기간 합계</div></div>
                        <div class="input" id="month_price2" style="text-align:right;width:43%;padding-right:10px"><?=number_format(($info["svp_month_price"]-$info["svp_month_dis_price"])*$info["sv_payment_period"])?></div>
                        <div style="display:inline-block">원 / <span class="total_contract"></span>개월</div>
                    </div>
                </div>
                <?php
                $month_price = ($info["svp_month_price"]-$info["svp_month_dis_price"])*$info["sv_payment_period"]-$info["svp_register_discount"];
                ?>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>결제 방법 할인(<input type="checkbox" name="svp_discount_yn" id="svp_discount_yn" value="Y" <?=($info["svp_discount_yn"] == "Y" ? "checked":"")?>> 작용)</div></div>
                        <div class="input" id="month_price3" style="text-align:right;width:43%;padding-right:10px"><?=number_format($info["svp_discount_price"])?></div>
                        <div style="display:inline-block">원</div>
                        <input type="hidden" name="svp_discount_price" id="svp_discount_price" value="<?=$info["svp_discount_price"]?>">
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>서비스 요금 합계</div></div>
                        <div class="input" id="month_price4" style="text-align:right;width:43%;padding-right:10px"><?=number_format($month_price)?></div>
                        <div style="display:inline-block">원 / <span class="total_contract"></span>개월</div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>부가세</div></div>
                        <div class="input" id="month_price5" style="text-align:right;width:43%;padding-right:10px"><?=number_format($month_price*0.1)?></div>
                        <div style="display:inline-block">원</div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input" style="width:100%">
                        <div class="label" style="width:35%"><div>총계</div></div>
                        <div class="input" id="month_price_total" style="text-align:right;width:43%;padding-right:10px"><?=number_format($month_price*1.1)?></div>
                        <div style="display:inline-block">원</div>
                    </div>
                </div>
            </div>
            <div style="clear:both;width:100%;font-size:12px">
                <div style="height:50px;border-top:1px solid #ddd;border-bottom:1px solid #ddd">
                    <div style="display:inline-block;width:15%;padding:10px 0px 0px 20px">초기청구 요금<br>(VAT별도)</div>
                    <div style="display:inline-block;text-align:right;width:80%;">
                        <ul style="padding-top:10px;padding-right:5px;letter-spacing:-1">
                            <li style="text-align:right;font-size:11px">일회성 요금 (<span style=";color:red" id="one_price_str0">0</span>) + <span id="start_date_str_0_1">0000년 00월 00일</span> ~ <span id="end_date_str_0_1">0000년 00월 00일</span> 이용료 (<span style=";color:red" id="use_price_str_0_1">0</span>) <span id="view_add" style="display:none">+ <span id="start_date_str_0_2">0000년 00월 00일</span> ~ <span id="end_date_str_0_2">0000년 00월 00일</span> 이용료 (<span style=";color:red" id="use_price_str_0_2">0</span>)</span></li>
                            <li style=";text-align:right;padding-top:3px"> = 합계 (<span style=";color:red" id="total_str0" class="total-cal-price" data-price=0>0</span>)</li>
                        </ul>
                    </div>
                </div>
            </div>
            <input type="hidden" id="sv_once_total_price" value="<?=($once_price*1.1)?>">
            <input type="hidden" id="sv_month_total_price" value="<?=($month_price*1.1)?>">
        </div>
        <div class="modal-title">
            <div class="modal-title-text">매입 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>매입처</div></div>
                <div class="input"><input type="text" name="sva_c_name" id="sva_c_name" class="width-button" value="<?=$info["c_name"]?>"><button class="btn btn-brown " type="button">검색</button></div>
            </div>

            <div class="modal-field-input">
                <div class="label"><div>매입가</div></div>
                <div class="input"><input type="text" name="sva_input_price" id="sva_input_price" value="<?=$info["sv_input_price"]?>"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><div>매입 시작일</div></div>
                <div class="input"><input type="text" name="sva_input_start" id="sva_input_start" value="<?=$info["sv_input_start"]?>"></div>
            </div>

            <div class="modal-field-input">
                <div class="label"><div>매입 단위</div></div>
                <div class="input">
                    <input type="text" name="sva_input_unit" id="sva_input_unit" value="<?=$info["sva_input_unit"]?>" style="width:50%"> 개월
                </div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">관리자 메모</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input" style="width:100%">
                <textarea name="admin_msg" style="width:98%;height:150px"></textarea>
            </div>
        </div>
        <div class="modal-button">
            <button class="btn btn-black btn-payment-modify" type="button">수정</button>
        </div>
    </form>
    </div>
</div>
<div id="dialogFirstSetting" class="dialog" style="padding:5px">
    <div class="modal_search">
        <ul>
            <li >
                초기 일할 청구 설정
            </li>

        </ul>
    </div>
    <form id="firstSettingForm">
        <div style="font-size:12px">
            <div class="modal-field-input full" >
                <div class="label service"><div style="padding:10px 0px 0px 10px">일할 계산 여부</div></div>
                <div class="input service" style="margin-top:10px">
                    <div class="modal-service-left" style="border-bottom:0px">
                        <ul class="service-type">
                            <li style="display:inline-block;width:30%"><input type="radio" name="p_sv_account_type" id="p_sv_account_type_1" value="1" <?=($info["sv_account_type"] == "1" ? "checked":"")?> class="sv_account_type">일할 계산</li>
                            <li style="display:inline-block"><input type="radio" name="p_sv_account_type" id="p_sv_account_type_2" value="2" <?=($info["sv_account_type"] == "2" ? "checked":"")?> class="sv_account_type">과금 시작일 기준 결제 주기로 처리</li>
                        </ul>
                        <ul class="service-type type-hidden">
                            <li style="display:inline-block;width:30%"><input type="radio" name="p_sv_account_policy" id="sv_account_policy_1" value="1" <?=($info["sv_account_policy"] == "1" ? "checked":"")?> >당월분 일할 계산</li>
                            <li style="display:inline-block"><input type="radio" name="p_sv_account_policy" id="sv_account_policy_2" value="2" <?=($info["sv_account_policy"] == "2" ? "checked":"")?>>

                                    <select id="p_sv_account_start_day" name="p_sv_account_start_day" class="select2" style="width:70px">
                                        <?php for($i = 1; $i < 32;$i++): ?>
                                        <option value="<?=$i?>" <?=($i == $info["sv_account_start_day"] ? "selected":"")?>><?=$i?>일</option>
                                        <?php endfor; ?>
                                    </select>

                                일 (과금 시작) 이후 건 익월분 통합
                            </li>
                        </ul>
                        <ul class="service-type type-hidden">
                            <li style="display:inline-block;width:70%">

                                    <select id="p_sv_account_format" name="p_sv_account_format" class="select2" style="width:150px">
                                        <option value="1" <?=($info["sv_account_format"] == "1" ? "selected":"")?>>1의 자리</option>
                                        <option value="2" <?=($info["sv_account_format"] == "2" ? "selected":"")?>>10의 자리</option>
                                        <option value="3" <?=($info["sv_account_format"] == "3" ? "selected":"")?>>100의 자리</option>
                                        <option value="4" <?=($info["sv_account_format"] == "4" ? "selected":"")?>>1000의 자리</option>
                                    </select>


                                    <select id="p_sv_account_format_policy" name="p_sv_account_format_policy" class="select2" style="width:70px">
                                        <option value="1" <?=($info["sv_account_format_policy"] == "1" ? "selected":"")?>>버림</option>
                                        <option value="2" <?=($info["sv_account_format_policy"] == "2" ? "selected":"")?>>올림</option>
                                        <option value="3" <?=($info["sv_account_format_policy"] == "3" ? "selected":"")?>>반올림</option>
                                    </select>

                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

    </form>

    <div class="modal-close-btn" style="margin-top:14px"><button class="btn btn-black btn-small btn-price-policy">적용</button> <button class="btn btn-default btn-small" onclick="$('#dialogFirstSetting').dialog('close')">닫기</button></div>
</div>
<script src="/assets/js/memberPaymentView.js?date=<?=time()?>"></script>
