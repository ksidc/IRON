<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<link rel='stylesheet' href="/assets/css/uniform.default.css">
<script src="/assets/js/jquery.uniform.js"></script>
<script src="/assets/js/moment.js"></script>
<script src="/assets/js/serviceMake.js?date=<?=time()?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
<div style="background:#fff;width:100%;overflow-x:hidden">
    <div class="popup_title" style="padding:10px">

        서비스 등록

    </div>
    <div style="padding:5px">
        <form name="registerForm" id="registerForm" method="post" action="/api/serviceRegister">
            <input type="hidden" name="sr_seq" id="sr_seq">
            <input type="hidden" name="sr_mb_seq" id="sr_mb_seq">
            <input type="hidden" name="sr_eu_seq" id="sr_eu_seq">
            <input type="hidden" name="sr_ct_seq" id="sr_ct_seq">
            <input type="hidden" name="sr_account_type" id="sr_account_type" value="<?=$basic_policy["sp_basic_type"]?>">
            <input type="hidden" name="sr_account_policy" id="sr_account_policy" value="<?=$basic_policy["sp_policy"]?>">
            <input type="hidden" name="sr_account_start_day" id="sr_account_start_day" value="<?=$basic_policy["sp_pay_start_day"]?>">
            <input type="hidden" name="sr_account_format" id="sr_account_format" value="<?=$basic_policy["sp_pay_format"]?>">
            <input type="hidden" name="sr_account_format_policy" id="sr_account_format_policy" value="<?=$basic_policy["sp_pay_format_policy"]?>">
            <input type="hidden" name="sr_c_seq" id="sr_c_seq">
            <input type="hidden" name="dupleNumberYn" id="dupleNumberYn" value="N">
            <div class="modal-title">
                <div class="modal-title-text">신청 회원 정보</div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">상호/이름(*)</div>
                    <div class="input">
                        <input type="text" class="width-button" name="mb_name" id="mb_name" readonly><button class="btn btn-brown " type="button" onclick='$( "#dialogUserSearch" ).dialog("open");$("#dialogUserSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label">회원아이디</div>
                    <div class="input">
                        <input type="text" name="mb_id" id="mb_id" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">End User(*)</div>
                    <div class="input">
                        <input type="text" class="width-button" name="eu_name" id="eu_name" readonly><button class="btn btn-brown " type="button" onclick='getEndUserNextNumber();$( "#dialogEndSearch" ).dialog("open");$("#dialogEndSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label">업체 분류</div>
                    <div class="input">
                        <input type="text" class="width-button" name="ct_name" id="ct_name" readonly><button class="btn btn-brown " type="button" onclick='typeGetList();$( "#dialogTypeSearch" ).dialog("open");$("#dialogTypeSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                    </div>
                </div>
            </div>
            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block">계약 정보</div>
                <div style="display:inline-block">
                    <div class="label" style="display:inline-block">계약 번호(*)</div>
                    <div class="input" style="display:inline-block"><input type="text" name="sr_code1" id="sr_code1" style="width:30%;border:1px solid #ddd;height:22px" value="<?=$code1?>"> - <input type="text" name="sr_code2" id="sr_code2" style="width:20%;border:1px solid #ddd;height:22px" value="<?=$code2?>"> <button class="btn btn-brown btn-small btn-number-duple" type="button">중복확인</button></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">부서</div>
                    <div class="input">

                            <select id="sr_part" name="sr_part" class="select2" style="width:140px">
                                <option value="영업팀" selected>영업팀</option>
                                <option value="기술팀">기술팀</option>
                            </select>

                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label">사내담당자</div>
                    <div class="input">

                            <select id="sr_charger" name="sr_charger" class="select2" style="width:140px">
                                <option value="김지훈" selected>김지훈</option>
                                <option value="노성민">노성민</option>
                            </select>

                    </div>
                </div>
            </div>
              <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label" style="vertical-align:top;padding-top:7px">계약(약정)기간</div>
                    <div class="input">
                        <ul style="list-style:none;padding:0;margin:0">
                            <li><input type="radio" name="sr_contract_type" value="1" class="sr_contract_type" checked> 약정 <input type="radio" name="sr_contract_type" class="sr_contract_type" value="2"> 무약정</li>
                            <li><input type="text" name="sr_contract_start" id="sr_contract_start" style="width:70px;font-size:11px" class="datepicker"> ~ <input type="text" name="sr_contract_end" id="sr_contract_end" style="width:70px;font-size:11px" class="datepicker"> <span id="contractinfo" >(00개월 00일)</span>
                        </ul>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label" style="vertical-align:top;padding-top:7px">계약 만료 후 자동 계약 연장 여부</div>
                    <div class="input">
                        <ul style="list-style:none;padding:0;margin:0">
                            <li style="display:inline-block"><input type="radio" name="sr_auto_extension" value="1" checked> 자동 계약 연장 </li>
                            <li style="display:inline-block;padding-left:10px">단위 : <input type="text" style="width:30px" name="sr_auto_extension_month"> 개월</li>
                        </ul>
                        <ul style="list-style:none;padding:0;margin:0">
                            <li><input type="radio" name="sr_auto_extension" value="2"> 재 계약 필요 </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block">기본 결제 조건 </div>
                <div style="display:inline-block;text-align:right;width:78%">
                    <!-- <div style="text-align:right"><span class="btn btn-brown btn-small " style="cursor:default">등록 할인율 (변경 가능)</span>% </div> -->
                    <input type="hidden" name="sr_register_discount" id="sr_register_discount" value="0" class="price_cal">
                </div>
            </div>
            <div class="modal-field depth-area">
                <div class="depth-item">
                    <div class="modal-field-input">
                        <div class="label">요금 납부 방법</div>
                        <div class="input">
                            <input type="radio" name="sr_payment_type" value="1" checked> 무통장 <input type="radio" name="sr_payment_type" value="2"> 카드 <input type="radio" name="sr_payment_type" value="3"> CMS
                        </div>
                    </div>
                    <div class="modal-field-input">
                        <div class="label">결제 주기(*)</div>
                        <div class="input">
                            <input type="text" name="sr_payment_period" id="sr_payment_period" style="width:70px" class="price_cal price_cal3"> 개월
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">청구 기준</div>
                    <div class="input">
                        서비스 이용 월의

                            <select name="sr_pay_type" id="sr_pay_type" class="select2" style="width:80px">
                                <option selected value="0">전월</option>
                                <option value="1">당월</option>
                                <option value="2">익월</option>
                            </select>
                      청구
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label">자동 청구일(*)</div>

                    <div class="input">
                        <select name="sr_pay_day" id="sr_pay_day" class="select2" style="width:180px">
                            <option value="">자동 청구일을 선택하세요</option>
                            <?php for($i = 0; $i < 28;$i++): ?>
                            <option value="<?=($i+1)?>"><?=($i+1)?>일</option>
                            <?php endfor; ?>
                            <option value="말일">말일</option>
                        </select>
                        <!-- <input type="text" name="sr_pay_day" id="sr_pay_day" style="width:70px"> 일 -->
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">계산서 발행</div>
                    <div class="input">

                            <select  name="sr_pay_publish" id="sr_pay_publish" class="select2" style="width:40%">
                                <option selected value="0">발행</option>
                                <option value="1">미발행</option>

                            </select>


                            <select name="sr_pay_publish_type" id="sr_pay_publish_type" class="select2" style="width:40%">
                                <option selected value="0">영수 발행</option>
                                <option value="1">청구 발행</option>

                            </select>

                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label">결제일(*)</div>
                    <div class="input">
                        청구일로부터
                         <input type="text" style="width:15%" name="sr_payment_day" id="sr_payment_day"> 일 후
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">과금 시작일(*)</div>
                    <div class="input"><input type="text"  name="sr_account_start" id="sr_account_start" class="datepicker2" style="width:120px"></div>
                </div>
                <div class="modal-field-input">
                    <div class="label">과금 만료일(자동)</div>
                    <div class="input"><input type="text"  name="sr_account_end" id="sr_account_end" style="width:120px" readonly></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label">초기 일할 청구</div>
                    <?php if($basic_policy["sp_pay_format"] == "1"): ?>
                        <?php $text_format = "1의 자리"; ?>
                    <?php elseif($basic_policy["sp_pay_format"] == "2"): ?>
                        <?php $text_format = "10의 자리"; ?>
                    <?php elseif($basic_policy["sp_pay_format"] == "3"): ?>
                        <?php $text_format = "100의 자리"; ?>
                    <?php elseif($basic_policy["sp_pay_format"] == "4"): ?>
                        <?php $text_format = "1000의 자리"; ?>
                    <?php endif; ?>

                    <?php if($basic_policy["sp_pay_format_policy"] == "1"): ?>
                        <?php $text_format2 = "내림"; ?>
                    <?php elseif($basic_policy["sp_pay_format_policy"] == "2"): ?>
                        <?php $text_format2 = "올림"; ?>
                    <?php elseif($basic_policy["sp_pay_format_policy"] == "3"): ?>
                        <?php $text_format2 = "반올림"; ?>
                    <?php endif; ?>

                    <?php if($basic_policy["sp_basic_type"] == "1"): ?>
                        <?php if($basic_policy["sp_policy"] == "1"):?>
                            <?php $text = "당월분 일할 계산"; ?>
                        <?php else: ?>
                            <?php $text = $basic_policy["sp_pay_start_day"]."일(과금시작) 이후 건 익월분 통합"; ?>
                        <?php endif; ?>
                    <div class="input"><span id="policy_text"><span id="policy_text1"><?=$text?></span> (<span id="policy_text2"><?=$text_format?> <?=$text_format2?></span>)</span> <span id="policy_text_2" style="display:none"></span> <button class="btn btn-brown" type="button" onclick='$( "#dialogFirstSetting" ).dialog("open");$("#dialogFirstSetting").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>변경</button></div>
                    <?php else: ?>
                    <div class="input"><span id="policy_text" style="display:none"><span id="policy_text1">당월분 일할 계산</span> (<span id="policy_text2"><?=$text_format?> <?=$text_format2?></span>)</span> <span id="policy_text_2">과금 시작일 기준 결제 주기로 처리</span> <button class="btn btn-brown" type="button" onclick='$( "#dialogFirstSetting" ).dialog("open");$("#dialogFirstSetting").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>변경</button></div>
                    <?php endif; ?>
                </div>
                <input type="hidden" name="sp_first_price" id="sp_first_price" value=0>
                <input type="hidden" name="sp_first_start" id="sp_first_start">
                <input type="hidden" name="sp_first_end" id="sp_first_end">
            </div>
            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block">기본 서비스 정보 </div>

            </div>
            <div class="modal-title" style="background:#ddd">
                <div class="modal-title-text" style="display:inline-block;background:#ddd;font-size:12px;font-weight:normal">서비스 정보</div>
            </div>
            <div class="modal-field" style="padding-bottom:0px;padding-top:5px;text-align:right">
                <div style="width:100%">
                    <ul style="text-align:right;padding-right:2px">
                        <li class="dib">서비스 종류(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px;text-align:left">

                                <select id="sr_pc_seq" name="sr_pc_seq" class="select2" style="width:162px">
                                    <option value="" selected>선택</option>
                                    <?php foreach($product_category as $row): ?>
                                    <option value="<?=$row["pc_seq"]?>"><?=$row["pc_name"]?></option>
                                    <?php endforeach; ?>
                                </select>

                        </li>
                        <li class="dib">제품군(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px;text-align:left">

                                <select id="sr_pi_seq" name="sr_pi_seq" class="select2" style="width:162px">
                                    <option value="" selected>선택</option>
                                </select>

                        </li>
                        <li class="dib">상품명(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 0px 0px 10px;text-align:left">

                                <select id="sr_pr_seq" name="sr_pr_seq" class="select2" style="width:262px">
                                    <option value="" selected>선택</option>
                                </select>

                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px">
                        <li class="dib">대분류(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 8px;text-align:left">

                                <select id="sr_pd_seq" name="sr_pd_seq" class="select2" style="width:162px">
                                    <option value="" selected>선택</option>
                                </select>

                        </li>
                        <li class="dib">소분류(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 12px;text-align:left">

                                <select id="sr_ps_seq" name="sr_ps_seq" class="select2" style="width:162px">
                                    <option value="" selected>선택</option>
                                </select>

                        </li>
                        <li class="dib">청구명(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 0px 0px 10px">
                            <input type="text" style="width:246px" name="sr_claim_name" id="sr_claim_name">
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">임대 여부 <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px;text-align:left">

                                <select id="sr_rental" name="sr_rental" class="select2" style="width:162px">
                                    <option value="N" selected>N</option>
                                    <option value="Y">Y</option>
                                </select>

                        </li>

                        <li class="dib" style="padding-left:217px">계산서 품목명(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 0px 0px 10px">
                            <input type="text" style="width:246px" name="sr_bill_name" id="sr_bill_name">
                        </li>
                    </ul>
                </div>
            </div>

            <div class="modal-title" style="background:#ddd">
                <div class="modal-title-text" style="display:inline-block;background:#ddd;font-size:12px;font-weight:normal">요금 정보</div>
            </div>
            <div class="modal-field" style="padding-bottom:0px;padding-top:5px;text-align:right">
                <div style="width:100%">

                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">일회성 요금(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="text" style="width:146px" name="sr_once_price" id="sr_once_price" class="right"> 원
                        </li>

                        <li class="dib" style="padding-left:235px">월 요금(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 40px 0px 10px">
                            <input type="text" style="width:180px" name="sr_month_price" id="sr_month_price" class="price_cal right"><span id="sr_month_price_str">원/월</span>
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px;display:none" class="rental_yn">
                        <li class="dib">임대 형태(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="radio" name="sr_rental_type" value="1" checked> 영구임대 <input type="radio" name="sr_rental_type" value="2"> 소유권 이전 &nbsp;&nbsp;&nbsp;&nbsp; <input type="text" style="width:30px" name="sr_rental_date" id="sr_rental_date"> 개월
                        </li>

                        <li class="dib" style="padding-left:96px">소유권 이전 후 월 요금(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 40px 0px 10px">
                            <input type="text" style="width:180px" name="sr_after_price" id="sr_after_price" class="right"><span id="sr_after_price_str">원/월</span>
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">상품 매입처 <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="text" style="width:146px" name="sr_c_seq_str" id="sr_c_seq_str" readonly><button class="btn btn-brown" type="button" onclick='$("#searchSeq").val("");$( "#dialogClientSearch" ).dialog("open");$("#dialogClientSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                        </li>

                        <li class="dib" style="padding-left:194px">상품 매입가 <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 40px 0px 10px">
                            <input type="text" style="width:180px" name="sr_input_price" id="sr_input_price" class="right"><span id="sr_input_price_text">원<span style='color:transparent'>/월</span></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block">부가 항목 정보 </div>

            </div>
            <!-- loop -->
            <div class="addoption">

            </div>
            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block">상세 요금 정보 </div>

            </div>
            <div class="detail-price">
                <div style="width:10%;float:left;vertical-align:top; ">
                    <div class="price-label"><div style="padding-left:10px">구분</div></div>
                    <p style="text-align:center;padding-top:100px">기본 서비스</p>
                </div>
                <div style="width:90%;float:left;">
                    <div style="width:38%;float:left;vertical-align:top">
                        <div class="price-label" style="text-align:right"><div style="padding-right:20px">서비스명</div></div>
                        <ul style="text-align:right;border-left:1px solid #ddd">
                            <li style="line-height:35px;padding-right:20px"><span id="sr_pr_name">상품명</span> - <span id="sr_ps_name">소분류</span></li>
                            <li style="line-height:35px;padding-right:20px;color:red">할인 금액</li>
                            <li style="line-height:35px;padding-right:20px">할인 사유</li>
                            <li style="line-height:35px;padding-right:20px;color:red">요금 납부 방법 및 결제 주기에 따른 할인 금액</li>
                            <li style="line-height:35px;background:#eee;padding-right:20px;border-bottom:1px solid #ddd">소계</li>
                        </ul>
                    </div>
                    <div style="width:30%;float:left;vertical-align:top ">
                        <div class="price-label"><div style="padding-left:10px">일회성 요금 (신청 시 1회 청구)</div></div>
                        <ul style="list-style:none;padding:0;margin:0">
                            <li style="line-height:35px;padding-left:5px;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:160px" name="sp_once_price" id="sp_once_price" class="price_cal2 right" readonly> 원</li>
                            <li style="line-height:35px;padding-left:5px;border-left:1px solid #ddd;color:red"> - <input type="text" style="width:160px" name="sp_once_dis_price" id="sp_once_dis_price" class="price_cal2 right"> 원</li>
                            <li style="line-height:35px;padding-left:5px;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:160px" name="sp_once_dis_msg"></li>
                            <li style="line-height:35px;font-size:11px;padding-left:12px"><input type="checkbox" name="sp_discount_yn" id="sp_discount_yn" value="Y"> 할인적용(<span id="sr_register_discount_str">0</span>%)</li>
                            <li style="line-height:35px;background:#eee;padding-left:5px;border-bottom:1px solid #ddd;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:160px" name="sp_once_total_price" id="sp_once_total_price" class="price_cal4 right" readonly> 원</li>
                        </ul>
                    </div>
                    <div style="width:32%;float:left;vertical-align:top; ">
                        <div class="price-label"><div style="padding-left:10px">월 요금(<span class="auto_payment_str">[[자동 청구일]]</span>일 청구)</div></div>
                        <ul style="list-style:none;padding:0;margin:0">
                            <li style="line-height:35px;padding-left:5px;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:180px" name="sp_month_price" id="sp_month_price" class="price_cal3 right" readonly> 원 / <span class="sp_payment_str">결주</span></li>
                            <li style="line-height:35px;padding-left:5px;color:red;border-left:1px solid #ddd"> - <input type="text" style="width:180px" name="sp_month_dis_price" id="sp_month_dis_price" value="0" class="price_cal price_cal3 right"><span style=";color:red"> 원 / 월</span></li>
                            <li style="line-height:35px;padding-left:4px;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:180px" name="sp_month_dis_msg"></li>
                            <li style="line-height:35px;padding-left:5px;color:red"> - <input type="text" style="width:180px" name="sp_discount_price" id="sp_discount_price" class="price_cal3 right" readonly> 원 / <span class="sp_payment_str" >[[결제]]</span></li>
                            <li style="line-height:35px;background:#eee;padding-left:4px;border-bottom:1px solid #ddd;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:180px" name="sp_month_total_price" id="sp_month_total_price" class="price_cal4 right" readonly> 원 / <span class="sp_payment_str">[[결제]]</span></li>
                        </ul>
                    </div>
                    <div style="clear:both;width:100%;background-color:#EBE9E4;height:50px;border-left:1px solid #ddd">
                        <div style="width:10%;float:left">
                            <div style="line-height:50px;padding-left:10px">초기 청구 요금</div>
                        </div>
                        <div style="width:90%;float:left">
                            <ul style="padding-top:10px;padding-right:5px;letter-spacing:-1">
                                <li style="text-align:right;font-size:11px">일회성 요금 (<span style=";color:red" id="one_price_str0">0</span>) + <span id="start_date_str_0_1">0000년 00월 00일</span> ~ <span id="end_date_str_0_1">0000년 00월 00일</span> 이용료 (<span style=";color:red" id="use_price_str_0_1">0</span>) <span id="view_add" style="display:none">+ <span id="start_date_str_0_2">0000년 00월 00일</span> ~ <span id="end_date_str_0_2">0000년 00월 00일</span> 이용료 (<span style=";color:red" id="use_price_str_0_2">0</span>)</span></li>
                                <li style=";text-align:right;padding-top:3px"> = 합계 (<span style=";color:red" id="total_str0" class="total-cal-price" data-price=0>0</span>)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="addoptionprice_html">

                </div>
                <div style="width:44.5%;float:left;background:#ddd;line-height:35px;text-align:right;">
                    <div style="padding-right:20px;;border-top:1px solid #ddd">합계 (소계의 합)</div>
                </div>
                <div style="width:26.5%;float:left;background:#ddd;line-height:35px;">
                     <div style=";border-top:1px solid #ddd;border-left:1px solid #ddd;padding-left:5px">&nbsp;&nbsp; <input type="text" style="width:160px" id="show_once_total" class="right" readonly> 원</div>
                </div>
                <div style="width:29%;float:left;background:#ddd;line-height:35px;">
                    <div style=";border-top:1px solid #ddd;border-left:1px solid #ddd;padding-left:5px">&nbsp;&nbsp; <input type="text" style="width:180px" id="show_month_total" class="right" readonly> 원 (단위 : 월)</div>
                </div>
                <div style="clear:both;width:44.5%;float:left;background:#EBE9E4;line-height:35px;text-align:right;">
                    <ul style="padding-right:20px;border-top:1px solid #ddd;border-left:1px solid #ddd">
                        <li style="display:inline-block">합계(초기 청구 요금의 합)</li>
                        <li style="display:inline-block"><input type="text" style="width:160px" id="show_all_total" class="right" readonly> 원 </li>
                    </ul>
                </div>
                <div style="width:26.5%;float:left;background:#EBE9E4;line-height:35px;">
                    <div style=";border-top:1px solid #ddd;border-left:1px solid #ddd;padding-left:5px"> &nbsp;&nbsp; <input type="text" style="width:160px" id="show_all_once_total" class="right" readonly> 원</div>
                </div>
                <div style="width:29%;float:left;background:#EBE9E4;line-height:35px;">
                    <div style=";border-top:1px solid #ddd;border-left:1px solid #ddd;padding-left:5px"> &nbsp;&nbsp; <input type="text" style="width:180px" id="show_all_month_total" class="right" readonly> 원</div>
                </div>
            </div>
            <div class="modal-button" style="clear:both">
                <button class="btn btn-black btn-register" type="submit">등록</button>
            </div>
        </form>

    </div>
</div>
<div id="dialogUserSearch" class="dialog" style="padding:5px">
    <form name="userSearchForm" id="userSearchForm" method="get">
    <div class="modal_search">
        <ul>
            <li>

                <select name="memberSearchType" class="select2" style="width:100px">
                    <option value="mb_name" selected>회원명</option>

                </select>

            </li>
            <li >
                <input type="text" name="memberSearchWord" id="memberSearchWord" style="vertical-align:top"><button class="btn btn-brown btn-small btn-search-member" type="submit" style="padding:5.5px 7px;margin-bottom:3px">검색</button>
            </li>
        </ul>
    </div>
    </form>
    <div class="modal_search_list" style="height:300px">
        <table class="table">
            <thead>
            <tr>
                <th>상호/이름(ID)</th>
                <th>담당자</th>
                <th>사업자번호/생년월일</th>
                <th>연락처</th>
                <th>이메일</th>
            </tr>
            </thead>
            <tbody style="height:300px" id="modalSearchMember">

            </tbody>
        </table>
    </div>
    <div class="modal-close-btn"><button class="btn btn-black btn-small" onclick="$('#dialogUserSearch').dialog('close')">닫기</button></div>
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
<div id="dialogClientSearch" class="dialog">
    <form name="clientSearchForm" id="clientSearchForm" method="get">
        <input type="hidden" name="searchType" value="c_name">
        <input type="hidden" id="searchSeq">
    <div class="modal_search">
        <ul>
            <li>
                매입처 명
            </li>
            <li >
                <input type="text" name="searchWord" id="clientSearchWord" style="vertical-align:top"><button class="btn btn-brown btn-small btn-search-client" type="submit" style="padding:5.5px 7px;margin-bottom:3px">검색</button>
            </li>
        </ul>
    </div>
    </form>
    <div class="modal_search_list" style="height:150px">
        <table class="table">
            <thead>
            <tr>
                <th>코드</th>
                <th>매입처 명</th>
            </tr>
            </thead>
            <tbody style="height:150px" id="modalSearchClient">

            </tbody>
        </table>
    </div>

    <div style="text-align:center"><button class="btn btn-black" onclick="$('#dialogClientSearch').dialog('close')">닫기</button></div>
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
                            <li style="display:inline-block;width:30%"><input type="radio" name="sp_basic_type" id="sp_basic_type_1" value="1" <?=($basic_policy["sp_basic_type"] == "1" ? "checked":"")?> class="sp_basic_type">일할 계산</li>
                            <li style="display:inline-block"><input type="radio" name="sp_basic_type" id="sp_basic_type_2" value="2" <?=($basic_policy["sp_basic_type"] == "2" ? "checked":"")?> class="sp_basic_type">과금 시작일 기준 결제 주기로 처리</li>
                        </ul>
                        <ul class="service-type type-hidden">
                            <li style="display:inline-block;width:30%"><input type="radio" name="sp_policy" id="sp_policy_1" value="1" <?=($basic_policy["sp_policy"] == "1" ? "checked":"")?> >당월분 일할 계산</li>
                            <li style="display:inline-block"><input type="radio" name="sp_policy" id="sp_policy_2" value="2" <?=($basic_policy["sp_policy"] == "2" ? "checked":"")?>>

                                    <select id="sp_pay_start_day" name="sp_pay_start_day" class="select2" style="width:70px">
                                        <?php for($i = 1; $i < 32;$i++): ?>
                                        <option value="<?=$i?>" <?=($i == $basic_policy["sp_pay_start_day"] ? "selected":"")?>><?=$i?>일</option>
                                        <?php endfor; ?>
                                    </select>

                                일 (과금 시작) 이후 건 익월분 통합
                            </li>
                        </ul>
                        <ul class="service-type type-hidden">
                            <li style="display:inline-block;width:70%">

                                    <select id="sp_pay_format" name="sp_pay_format" class="select2" style="width:150px">
                                        <option value="1" <?=($basic_policy["sp_pay_format"] == "1" ? "selected":"")?>>1의 자리</option>
                                        <option value="2" <?=($basic_policy["sp_pay_format"] == "2" ? "selected":"")?>>10의 자리</option>
                                        <option value="3" <?=($basic_policy["sp_pay_format"] == "3" ? "selected":"")?>>100의 자리</option>
                                        <option value="4" <?=($basic_policy["sp_pay_format"] == "4" ? "selected":"")?>>1000의 자리</option>
                                    </select>


                                    <select id="sp_pay_format_policy" name="sp_pay_format_policy" class="select2" style="width:70px">
                                        <option value="1" <?=($basic_policy["sp_pay_format_policy"] == "1" ? "selected":"")?>>버림</option>
                                        <option value="2" <?=($basic_policy["sp_pay_format_policy"] == "2" ? "selected":"")?>>올림</option>
                                        <option value="3" <?=($basic_policy["sp_pay_format_policy"] == "3" ? "selected":"")?>>반올림</option>
                                    </select>

                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

    </form>

    <div class="modal-close-btn"><button class="btn btn-black btn-small btn-price-policy">적용</button> <button class="btn btn-default btn-small" onclick="$('#dialogFirstSetting').dialog('close')">닫기</button></div>
</div>