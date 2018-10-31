<style>
  .ui-tooltip, .arrow:after {
    background: black;

  }
  .ui-tooltip {
    padding: 10px 20px;
    color: white;
    border-radius: 2px;
    font-size:11px;
    text-transform: uppercase;
    box-shadow: 0 0 0px black;
    width:auto;
    background-color:rgba(0,0,0,0.8);
  }
  .arrow {
    width: 60px;
    height: 16px;
    overflow: hidden;
    position: absolute;
    left: 50%;
    margin-left: -28px;
    bottom: -16px;
  }
  .arrow.top {
    top: -16px;
    bottom: auto;
  }
  .arrow.left {
    left: 20%;
  }
  .arrow:after {
    content: "";
    position: absolute;
    left: 20px;
    top: -20px;
    width: 25px;
    height: 25px;
    box-shadow: 6px 5px 9px -9px black;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }
  .arrow.top:after {
    bottom: -20px;
    top: auto;
  }
  </style>
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

        서비스 수정

    </div>
    <div style="padding:0px">
        <form name="registerForm" id="registerForm" method="post" action="/api/serviceRegister">
            <input type="hidden" name="sr_seq" id="sr_seq" value="<?=$service["sr_seq"]?>">
            <input type="hidden" name="sr_mb_seq" id="sr_mb_seq" value="<?=$service["sr_mb_seq"]?>">
            <input type="hidden" name="sr_eu_seq" id="sr_eu_seq" value="<?=$service["sr_eu_seq"]?>">
            <input type="hidden" name="sr_ct_seq" id="sr_ct_seq" value="<?=$service["sr_ct_seq"]?>">
            <input type="hidden" name="sr_account_type" id="sr_account_type" value="<?=$service["sr_account_type"]?>">
            <input type="hidden" name="sr_account_policy" id="sr_account_policy" value="<?=$service["sr_account_policy"]?>">
            <input type="hidden" name="sr_account_start_day" id="sr_account_start_day" value="<?=$service["sr_account_start_day"]?>">
            <input type="hidden" name="sr_account_format" id="sr_account_format" value="<?=$service["sr_account_format"]?>">
            <input type="hidden" name="sr_account_format_policy" id="sr_account_format_policy" value="<?=$service["sr_account_format_policy"]?>">
            <input type="hidden" name="sr_c_seq" id="sr_c_seq" value="<?=$service["sr_c_seq"]?>">
            <input type="hidden" name="dupleNumberYn" id="dupleNumberYn" value="N">
            <input type="hidden" id="b_sr_code" value="<?=$service["sr_code"]?>">
            <div class="modal-title">
                <div class="modal-title-text"><div>신청 회원 정보</div></div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label"><div>상호/이름(*)</div></div>
                    <div class="input">
                        <input type="text" class="width-button" name="mb_name" id="mb_name" value="<?=$service["mb_name"]?>" readonly><button class="btn btn-brown btn-small" type="button" onclick='$( "#dialogUserSearch" ).dialog("open");$("#dialogUserSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label"><div>회원아이디</div></div>
                    <div class="input">
                        <input type="text" name="mb_id" id="mb_id" readonly value="<?=$service["mb_id"]?>">
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label"><div>End User(*)</div></div>
                    <div class="input">
                        <input type="text" class="width-button" name="eu_name" id="eu_name" value="<?=$service["eu_name"]?>" readonly><button class="btn btn-brown btn-small" type="button" onclick='getEndUserNextNumber();$( "#dialogEndSearch" ).dialog("open");$("#dialogEndSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label"><div>업체 분류</div></div>
                    <div class="input">
                        <input type="text" class="width-button" name="ct_name" id="ct_name" value="<?=$service["ct_name"]?>" readonly><button class="btn btn-brown btn-small" type="button" onclick='typeGetList();$( "#dialogTypeSearch" ).dialog("open");$("#dialogTypeSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                    </div>
                </div>
            </div>
            <?php
            $sr_code = explode("-",$service["sr_code"]);
            ?>

            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block;width:17%"><div>계약 정보</div></div>
                <div style="display:inline-block;width:77%">
                    <div class="label" style="display:inline-block;background:#dddddd">계약 번호(*)</div>
                    <div class="input" style="display:inline-block"><input type="text" name="sr_code1" id="sr_code1" style="width:30%;border:1px solid #ddd;height:22px" value="<?=$sr_code[0]?>"> - <input type="text" name="sr_code2" id="sr_code2" style="width:20%;border:1px solid #ddd;height:22px" value="<?=$sr_code[1]?>"> <button class="btn btn-brown btn-small btn-number-duple" type="button">중복확인</button></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label"><div>부서</div></div>
                    <div class="input">

                            <select id="sr_part" name="sr_part" class="select2" style="width:140px">
                                <option value="영업팀" <?=($service["sr_part"] == "영업팀" ? "selected":"")?>>영업팀</option>
                                <option value="기술팀" <?=($service["sr_part"] == "기술팀" ? "selected":"")?>>기술팀</option>
                            </select>

                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label"><div>사내담당자</div></div>
                    <div class="input">

                            <select id="sr_charger" name="sr_charger" class="select2" style="width:140px">
                                <option value="김지훈" <?=($service["sr_charger"] == "김지훈" ? "selected":"")?>>김지훈</option>
                                <option value="노성민" <?=($service["sr_charger"] == "노성민" ? "selected":"")?>>노성민</option>
                            </select>

                    </div>
                </div>
            </div>
              <div class="modal-field">
                <div class="modal-field-input" style="vertical-align:top">
                    <div class="label" style="vertical-align:top;padding-top:17px"><div>계약(약정)기간</div></div>
                    <div class="input">
                        <ul style="list-style:none;padding:0;margin:0">
                            <li><input type="radio" name="sr_contract_type" class="sr_contract_type" value="1" <?=($service["sr_contract_type"] == "1" ? "checked":"")?> > 약정 <input type="radio" class="sr_contract_type" name="sr_contract_type" value="2" <?=($service["sr_contract_type"] == "2" ? "checked":"")?>> 무약정</li>
                            <li><input type="text" name="sr_contract_start" id="sr_contract_start" style="width:70px;font-size:11px" class="datepicker" value="<?=$service["sr_contract_start"]?>"> ~ <input type="text" name="sr_contract_end" id="sr_contract_end" style="width:70px;font-size:11px" class="datepicker" value="<?=$service["sr_contract_end"]?>"> <span id="contractinfo" >(00개월 00일)</span>
                        </ul>
                    </div>
                </div>
                <div class="modal-field-input" style="vertical-align:top">
                    <div class="label" style="vertical-align:top;padding-top:17px"><div>계약 만료 후 자동 계약 연장 여부</div></div>
                    <div class="input">
                        <ul style="list-style:none;padding:0;margin:0">
                            <li style="display:inline-block"><input type="radio" name="sr_auto_extension" value="1" <?=($service["sr_auto_extension"] == "1" ? "checked":"")?> > 자동 계약 연장 </li>
                            <li style="display:inline-block;padding-left:10px">단위 : <input type="text" style="width:30px" name="sr_auto_extension_month" value="<?=$service["sr_auto_extension_month"]?>"> 개월</li>
                        </ul>
                        <ul style="list-style:none;padding:0;margin:0">
                            <li><input type="radio" name="sr_auto_extension" value="2" <?=($service["sr_auto_extension"] == "2" ? "checked":"")?> > 재 계약 필요 </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block"><div>기본 결제 조건 </div></div>
                
                    <!-- <div style="text-align:right"><span class="btn btn-brown btn-small" style="cursor:default">등록 할인율 (변경 가능)</span><input type="text" name="sr_register_discount" id="sr_register_discount" style="width:40px;border:1px solid #ddd;height:22px" value="<?=$service["sr_register_discount"]?>" class="price_cal">% </div> -->
                    <input type="hidden" name="sr_register_discount" id="sr_register_discount" value="<?=$service["sr_register_discount"]?>" class="price_cal">
                
            </div>
            <div class="modal-field depth-area">
                <div class="depth-item">
                    <div class="modal-field-input">
                        <div class="label"><div>요금 납부 방법</div></div>
                        <div class="input">
                            <input type="radio" name="sr_payment_type" value="1" <?=($service["sr_payment_type"] == "1" ? "checked":"")?> class="sr_payment_type"> 무통장 <input type="radio" name="sr_payment_type" value="2" <?=($service["sr_payment_type"] == "2" ? "checked":"")?> class="sr_payment_type"> 카드 <input type="radio" name="sr_payment_type" value="3" <?=($service["sr_payment_type"] == "3" ? "checked":"")?> class="sr_payment_type"> CMS
                        </div>
                    </div>
                    <div class="modal-field-input">
                        <div class="label"><div>결제 주기(*)</div></div>
                        <div class="input">
                            <input type="text" name="sr_payment_period" id="sr_payment_period" style="width:70px" class="price_cal price_cal3" value="<?=$service["sr_payment_period"]?>"> 개월
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label"><div>청구 기준</div></div>
                    <div class="input">
                        서비스 이용 월의

                            <select name="sr_pay_type" id="sr_pay_type" class="select2" style="width:80px">
                                <option value="0" <?=($service["sr_pay_type"] == "0" ? "selected":"")?>>전월</option>
                                <option value="1" <?=($service["sr_pay_type"] == "1" ? "selected":"")?>>당월</option>
                                <option value="2" <?=($service["sr_pay_type"] == "2" ? "selected":"")?>>익월</option>
                            </select>
                      청구
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label"><div>자동 청구일(*)</div></div>

                    <div class="input">
                        <input type="text" name="sr_pay_day" id="sr_pay_day" style="width:70px" value="<?=($service["sr_pay_day"] == "28" ? "말":$service["sr_pay_day"])?>"> 일
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label"><div>계산서 발행</div></div>
                    <div class="input">

                            <select  name="sr_pay_publish" id="sr_pay_publish" class="select2" style="width:40%">
                                <option value="0" <?=($service["sr_pay_publish"] == "0" ? "selected":"")?>>발행</option>
                                <option value="1" <?=($service["sr_pay_publish"] == "1" ? "selected":"")?>>미발행</option>

                            </select>


                            <select name="sr_pay_publish_type" id="sr_pay_publish_type" class="select2" style="width:40%;<?=($service["sr_pay_publish"] == "1" ? "display:none":"")?>">
                                <option value="0" <?=($service["sr_pay_publish_type"] == "0" ? "selected":"")?>>영수 발행</option>
                                <option value="1" <?=($service["sr_pay_publish_type"] == "1" ? "selected":"")?>>청구 발행</option>

                            </select>

                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label"><div>결제일(*)</div></div>
                    <div class="input">
                        청구일로부터
                         <input type="text" style="width:15%" name="sr_payment_day" id="sr_payment_day" value="<?=$service["sr_payment_day"]?>"> 일 후
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label"><div>과금 시작일(*)</div></div>
                    <div class="input"><input type="text"  name="sr_account_start" id="sr_account_start" class="datepicker2" style="width:120px" value="<?=$service["sr_account_start"]?>"></div>
                </div>
                <div class="modal-field-input">
                    <div class="label"><div>과금 만료일(자동)</div></div>
                    <div class="input"><input type="text"  name="sr_account_end" id="sr_account_end" style="width:120px" readonly value="<?=$service["sr_account_end"]?>"></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label" style="width:19.13%;"><div>초기 일할 청구</div></div>
                    <?php if($service["sr_account_format"] == "1"): ?>
                        <?php $text_format = "1의 자리"; ?>
                    <?php elseif($service["sr_account_format"] == "2"): ?>
                        <?php $text_format = "10의 자리"; ?>
                    <?php elseif($service["sr_account_format"] == "3"): ?>
                        <?php $text_format = "100의 자리"; ?>
                    <?php elseif($service["sr_account_format"] == "4"): ?>
                        <?php $text_format = "1000의 자리"; ?>
                    <?php endif; ?>

                    <?php if($service["sr_account_format_policy"] == "1"): ?>
                        <?php $text_format2 = "내림"; ?>
                    <?php elseif($service["sr_account_format_policy"] == "2"): ?>
                        <?php $text_format2 = "올림"; ?>
                    <?php elseif($service["sr_account_format_policy"] == "3"): ?>
                        <?php $text_format2 = "반올림"; ?>
                    <?php endif; ?>

                    <?php if($service["sr_account_type"] == "1"): ?>
                        <?php if($service["sr_account_policy"] == "1"):?>
                            <?php $text = "당월분 일할 계산"; ?>
                        <?php else: ?>
                            <?php $text = $service["sr_account_start_day"]."일(과금시작) 이후 건 익월분 통합"; ?>
                        <?php endif; ?>
                    <div class="input"><span id="policy_text"><span id="policy_text1"><?=$text?></span> (<span id="policy_text2"><?=$text_format?> <?=$text_format2?></span>)</span> <span id="policy_text_2" style="display:none"></span> <button class="btn btn-brown btn-small" type="button" onclick='$( "#dialogFirstSetting" ).dialog("open");$("#dialogFirstSetting").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>변경</button></div>
                    <?php else: ?>
                    <div class="input"><span id="policy_text" style="display:none"><span id="policy_text1">당월분 일할 계산</span> (<span id="policy_text2"><?=$text_format?> <?=$text_format2?></span>)</span> <span id="policy_text_2">과금 시작일 기준 결제 주기로 처리</span> <button class="btn btn-brown btn-small" type="button" onclick='$( "#dialogFirstSetting" ).dialog("open");$("#dialogFirstSetting").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>변경</button></div>
                    <?php endif; ?>
                </div>
                <input type="hidden" name="sp_first_price" id="sp_first_price" value=0>
                <input type="hidden" name="sp_first_start" id="sp_first_start">
                <input type="hidden" name="sp_first_end" id="sp_first_end">
                <input type="hidden" name="sp_first_month_price" id="sp_first_month_price" value=0>
                <input type="hidden" name="sp_first_month_start" id="sp_first_month_start">
                <input type="hidden" name="sp_first_month_end" id="sp_first_month_end">
                <input type="hidden" name="sp_first_month_period" id="sp_first_month_period">
            </div>
            <div class="modal-title">
                <div class="modal-title-text"><div>기본 서비스 정보</div> </div>
                <div style="position:absolute;top:408px;right:9px;"><button class="btn btn-brown btn-small" type="button" onclick='getAllProduct();$( "#dialogAllProduct" ).dialog("open");$("#dialogAllProduct").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>전체 상품 카테고리 보기</button></div>
            </div>
            <div class="modal-title" style="background:#eee">
                <div class="modal-title-text" style="display:inline-block;background:#eee;font-size:12px;font-weight:normal">서비스 정보</div>
            </div>
            <div class="modal-field" style="padding-bottom:0px;padding-top:5px;text-align:right">
                <div style="width:100%">
                    <ul style="text-align:right;padding-right:2px">
                        <li class="dib">서비스 종류(*) <i class="fas fa-info-circle" title="상품 등록 > 최상위 탭으로 분류된 서비스" rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 10px;text-align:left">

                                <select id="sr_pc_seq" name="sr_pc_seq" class="select2" style="width:162px">
                                    <option value="">선택</option>
                                    <?php foreach($product_category as $row): ?>
                                    <option value="<?=$row["pc_seq"]?>" <?=($row["pc_seq"] == $service["sr_pc_seq"] ? "selected":"")?> ><?=$row["pc_name"]?></option>
                                    <?php endforeach; ?>
                                </select>

                        </li>
                        <li class="dib">제품군(*) <i class="fas fa-info-circle" title="서비스로 등록할 상품의 제조사(IDC 제외)" rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 10px;text-align:left">

                                <select id="sr_pi_seq" name="sr_pi_seq" class="select2" style="width:162px">
                                    <option value="" selected>선택</option>
                                </select>

                        </li>
                        <li class="dib">상품명(*) <i class="fas fa-info-circle" title="선택한 제품군 내에 등록된 상품" rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 0px 0px 10px;text-align:left">

                                <select id="sr_pr_seq" name="sr_pr_seq" class="select2" style="width:260px">
                                    <option value="" selected>선택</option>
                                </select>

                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px">
                        <li class="dib">대분류(*) <i class="fas fa-info-circle" title="선택한 상품에 등록된 대분류" rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 10px;text-align:left">

                                <select id="sr_pd_seq" name="sr_pd_seq" class="select2" style="width:162px">
                                    <option value="" selected>선택</option>
                                </select>

                        </li>
                        <li class="dib">소분류(*) <i class="fas fa-info-circle" title="상품 > 대분류에 등록된 소분류" rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 10px;text-align:left">

                                <select id="sr_ps_seq" name="sr_ps_seq" class="select2" style="width:162px">
                                    <option value="" selected>선택</option>
                                </select>

                        </li>
                        <li class="dib">청구명(*) <i class="fas fa-info-circle" title="이메일 요금 청구서 상에 표시할 청구명을 입력하세요." rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 0px 0px 10px">
                            <input type="text" style="width:246px" name="sr_claim_name" id="sr_claim_name" value="<?=$service["sr_claim_name"]?>">
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">임대 여부 <i class="fas fa-info-circle" title="임대 상품일 경우 Y로 선택하세요." rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 10px;text-align:left">

                                <select id="sr_rental" name="sr_rental" class="select2" style="width:162px">
                                    <option value="N" <?=($service["sr_rental"] == "N" ? "selected":"")?>>N</option>
                                    <option value="Y" <?=($service["sr_rental"] == "Y" ? "selected":"")?>>Y</option>
                                </select>

                        </li>

                        <li class="dib" style="padding-left:215px">계산서 품목명(*) <i class="fas fa-info-circle" title="세금계산서 상에 표시할 품목명을 입력하세요." rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 0px 0px 10px">
                            <input type="text" style="width:246px" name="sr_bill_name" id="sr_bill_name" value="<?=$service["sr_bill_name"]?>">
                        </li>
                    </ul>
                </div>
            </div>

            <div class="modal-title" style="background:#eee">
                <div class="modal-title-text" style="display:inline-block;background:#eee;font-size:12px;font-weight:normal">요금 정보</div>
            </div>
            <div class="modal-field" style="padding-bottom:0px;padding-top:5px;text-align:right">
                <div style="width:100%">

                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">일회성 요금(*) <i class="fas fa-info-circle" title="선택한 상품에 대한 초기 1회 청구 금액을 입력하세요." rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="text" style="width:146px" name="sr_once_price" id="sr_once_price" value="<?=number_format($service_price["sp_once_price"])?>" class="right" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)"> 원
                        </li>

                        <li class="dib" style="padding-left:232px">월 요금(*) <i class="fas fa-info-circle" title="선택한 상품에 대한 월 단위 청구 금액을 입력하세요." rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 56px 0px 10px">
                            <input type="text" style="width:180px" name="sr_month_price" id="sr_month_price" class="price_cal right" value="<?=number_format($service["sr_month_price"])?>" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)"><span>원</span>
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px;<?=($service["sr_rental"] == "N" ? "display:none":"")?>" class="rental_yn">
                        <li class="dib">임대 형태(*) <i class="fas fa-info-circle" title="소유권 이전형 임대이면, 소유권 이전에 체크하고 소유권 이전이 되는 개월 수를 입력하세요." rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="radio" name="sr_rental_type" value="1" <?=($service["sr_rental_type"] == "1" ? "checked":"")?>> 영구임대 <input type="radio" name="sr_rental_type" value="2" <?=($service["sr_rental_type"] == "2" ? "checked":"")?>> 소유권 이전 &nbsp;&nbsp;&nbsp;&nbsp; <input type="text" style="width:30px;<?=($service["sr_rental_type"] == "1" ? "opacity:0":"")?>" name="sr_rental_date" id="sr_rental_date" value="<?=$service["sr_rental_date"]?>" class="rentaltype2"> <span class="rentaltype2" style="<?=($service["sr_rental_type"] == "1" ? "opacity:0":"")?>">개월</span>
                        </li>

                        <li class="dib rentaltype2" style="padding-left:96px;<?=($service["sr_rental_type"] == "1" ? "opacity:0":"")?>">소유권 이전 후 월 요금(*) <i class="fas fa-info-circle" title="소유권 이전이 완료된 후 변경할 월 단위 청구 금액을 입력하세요." rel="tooltip"></i></li>
                        <li class="dib rentaltype2" style="padding:0px 40px 0px 10px;<?=($service["sr_rental_type"] == "1" ? "opacity:0":"")?>">
                            <input type="text" style="width:180px" name="sr_after_price" id="sr_after_price" value="<?=number_format($service["sr_after_price"])?>" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)" class="right"><span id="sr_after_price_str">원/월</span>
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">상품 매입처 <i class="fas fa-info-circle" title="상품 선택 시 등록된 매입처를 자동으로 불러옵니다. (수정 가능)<br>재고 사용이면 '재고' 선택, 나중에 입력하려면 공란으로 두세요." rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="text" style="width:146px" name="sr_c_seq_str" id="sr_c_seq_str" value="<?=$service["c_name"]?>"><button class="btn btn-brown btn-small" type="button" onclick='$("#searchSeq").val("");$( "#dialogClientSearch" ).dialog("open");$("#dialogClientSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                        </li>

                        <li class="dib" style="padding-left:203px">상품 매입가 <i class="fas fa-info-circle" title="상품 선택 시 등록된 매입가를 자동으로 불러옵니다. (수정 가능)<br>재고 사용이면 '0' 입력, 나중에 입력하려면 공란으로 두세요." rel="tooltip"></i></li>
                        <li class="dib" style="padding:0px 40px 0px 10px">
                            <input type="text" style="width:180px" name="sr_input_price" id="sr_input_price" value="<?=number_format($service["sr_input_price"])?>" class="right" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)"><span id="sr_input_price_text">원<span style='color:transparent'>/월</span></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block"><div>부가 항목 정보</div></div>

            </div>
            <!-- loop -->
            <div class="addoption">

            </div>
            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block"><div>상세 요금 정보</div></div>

            </div>
            <div class="detail-price">
                <div style="width:10%;float:left;vertical-align:top; ">
                    <div class="price-label"><div style="text-align:center;border-right:1px solid #fff;">구분</div></div>
                    <p style="text-align:center;padding-top:100px">기본 서비스</p>
                </div>
                <div style="width:90%;float:left;">
                    <div style="width:38%;float:left;vertical-align:top">
                        <div class="price-label" style="text-align:right"><div style="padding-right:20px;border-right:1px solid #fff;">서비스명</div></div>
                        <ul style="text-align:right;border-left:1px solid #ddd">
                            <li style="line-height:35px;padding-right:20px"><span id="sr_pr_name"><?=$service["pr_name"]?></span> - <span id="sr_ps_name"><?=$service["ps_name"]?></span></li>
                            <li style="line-height:35px;padding-right:20px;color:red">할인 금액</li>
                            <li style="line-height:35px;padding-right:20px">할인 사유</li>
                            <li style="line-height:35px;padding-right:20px;color:red">요금 납부 방법 및 결제 주기에 따른 할인 금액</li>
                            <li style="line-height:35px;background:#eee;padding-right:20px;border-bottom:1px solid #ddd">소계</li>
                        </ul>
                    </div>
                    <div style="width:30%;float:left;vertical-align:top ">
                        <div class="price-label"><div style="padding-left:10px;border-right:1px solid #fff;">일회성 요금 (신청 시 1회 청구)</div></div>
                        <ul style="list-style:none;padding:0;margin:0">
                            <li style="line-height:35px;padding-left:5px;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:160px" name="sp_once_price" id="sp_once_price" value="<?=number_format($service_price["sp_once_price"])?>" class="price_cal2 right" readonly> 원</li>
                            <li style="line-height:35px;padding-left:5px;color:red;border-left:1px solid #ddd"> - <input type="text" style="width:160px" name="sp_once_dis_price" id="sp_once_dis_price" value="<?=number_format($service_price["sp_once_dis_price"])?>" class="price_cal2 right" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)"> 원</li>
                            <li style="line-height:35px;padding-left:5px;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:160px" name="sp_once_dis_msg" value="<?=$service_price["sp_once_dis_msg"]?>"></li>
                            <li style="line-height:35px;font-size:11px;padding-left:12px"><input type="checkbox" name="sp_discount_yn" id="sp_discount_yn" value="Y" <?=($service_price["sp_discount_yn"] == "Y" ? "checked":"")?>> 할인적용(<span id="sr_register_discount_str"><?=$service["sr_register_discount"]?></span>%)</li>
                            <li style="line-height:35px;background:#eee;padding-left:5px;border-bottom:1px solid #ddd;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:160px" name="sp_once_total_price" id="sp_once_total_price" class="price_cal4 right" readonly> 원</li>
                        </ul>
                    </div>
                    <div style="width:32%;float:left;vertical-align:top; ">
                        <div class="price-label"><div style="padding-left:10px">월 요금(<span class="auto_payment_str"><?=$service["sr_pay_day"]?></span>일 청구)</div></div>
                        <ul style="list-style:none;padding:0;margin:0">
                            <li style="line-height:35px;padding-left:5px;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:180px" name="sp_month_price" id="sp_month_price" value="<?=number_format($service["sr_month_price"]*$service["sr_payment_period"])?>" class="price_cal3 right" readonly> 원 / <span class="sp_payment_str"><?=$service["sr_payment_period"]?>개월</span></li>
                            <li style="line-height:35px;padding-left:5px;color:red;border-left:1px solid #ddd"> - <input type="text" style="width:180px" name="sp_month_dis_price" id="sp_month_dis_price" value="<?=number_format($service_price["sp_month_dis_price"])?>" class="price_cal price_cal3 right" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)"><span style=";color:red"> 원 / 월</span></li>
                            <li style="line-height:35px;padding-left:4px;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:180px" name="sp_month_dis_msg" value="<?=$service_price["sp_month_dis_msg"]?>"></li>
                            <li style="line-height:35px;padding-left:5px;color:red"> - <input type="text" style="width:180px" name="sp_discount_price" id="sp_discount_price" class="price_cal3 right" readonly> 원 / <span class="sp_payment_str" ><?=$service["sr_payment_period"]?>개월</span></li>
                            <li style="line-height:35px;background:#eee;padding-left:4px;border-bottom:1px solid #ddd;border-left:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:180px" name="sp_month_total_price" id="sp_month_total_price" class="price_cal4 right" readonly> 원 / <span class="sp_payment_str"><?=$service["sr_payment_period"]?>개월</span></li>
                        </ul>
                    </div>
                    <div style="clear:both;width:100%;background-color:#EBE9E4;height:50px;border-left:1px solid #ddd">
                        <div style="width:10%;float:left">
                            <div style="line-height:50px;padding-left:10px">초기 청구 요금</div>
                        </div>
                        <div style="width:90%;float:left">
                            <ul style="padding-top:10px;padding-right:5px">
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
                <button class="btn btn-black btn-register" type="submit">수정</button>
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
                    <option value="mb_id">아이디</option>
                    <option value="mb_number">사업자번호/생년월일</option>
                    <option value="mb_phone">연락처</option>
                    <option value="mb_email">이메일</option>
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
    <div class="modal_search_list" style="height:230px;overflow:auto">
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
            <div style="display:inline-block"><input type="text" name="eu_name" id="add_eu_name" style="vertical-align:top"><button class="btn btn-brown btn-small btn-end-add" type="submit" style="padding:5.5px 7px;margin-bottom:3px">신규 등록</button></div>
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
    <div class="modal_search_list" style="height:230px;overflow:auto">
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
            <div style="display:inline-block"><input type="text" name="ct_name" id="add_ct_name" style="vertical-align:top"><button class="btn btn-brown btn-small btn-type-add" type="submit" style="padding:5.5px 7px;margin-bottom:3px">신규 등록</button></div>
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
                            <li style="display:inline-block;width:30%"><input type="radio" name="sp_basic_type" id="sp_basic_type_1" value="1" <?=($service["sr_account_type"] == "1" ? "checked":"")?> class="sp_basic_type">일할 계산</li>
                            <li style="display:inline-block"><input type="radio" name="sp_basic_type" id="sp_basic_type_2" value="2" <?=($service["sr_account_type"] == "2" ? "checked":"")?> class="sp_basic_type">과금 시작일 기준 결제 주기로 처리</li>
                        </ul>
                        <ul class="service-type type-hidden">
                            <li style="display:inline-block;width:30%"><input type="radio" name="sp_policy" id="sp_policy_1" value="1" <?=($service["sr_account_policy"] == "1" ? "checked":"")?> >당월분 일할 계산</li>
                            <li style="display:inline-block"><input type="radio" name="sp_policy" id="sp_policy_2" value="2" <?=($service["sr_account_policy"] == "2" ? "checked":"")?>>

                                    <select id="sp_pay_start_day" name="sp_pay_start_day" class="select2" style="width:70px">
                                        <?php for($i = 1; $i < 32;$i++): ?>
                                        <option value="<?=$i?>" <?=($i == $service["sr_account_start_day"] ? "selected":"")?>><?=$i?>일</option>
                                        <?php endfor; ?>
                                    </select>

                                일 (과금 시작) 이후 건 익월분 통합
                            </li>
                        </ul>
                        <ul class="service-type type-hidden">
                            <li style="display:inline-block;width:70%">

                                <select id="sp_pay_format" name="sp_pay_format" class="select2" style="width:150px">
                                    <option value="1" <?=($service["sr_account_format"] == "1" ? "selected":"")?>>1의 자리</option>
                                    <option value="2" <?=($service["sr_account_format"] == "2" ? "selected":"")?>>10의 자리</option>
                                    <option value="3" <?=($service["sr_account_format"] == "3" ? "selected":"")?>>100의 자리</option>
                                    <option value="4" <?=($service["sr_account_format"] == "4" ? "selected":"")?>>1000의 자리</option>
                                </select>


                                <select id="sp_pay_format_policy" name="sp_pay_format_policy" class="select2" style="width:70px">
                                    <option value="1" <?=($service["sr_account_format_policy"] == "1" ? "selected":"")?>>버림</option>
                                    <option value="2" <?=($service["sr_account_format_policy"] == "2" ? "selected":"")?>>올림</option>
                                    <option value="3" <?=($service["sr_account_format_policy"] == "3" ? "selected":"")?>>반올림</option>
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
<div id="dialogAllProduct" class="dialog" style="padding:5px">
    <div class="modal_search">
        <ul>
            <li >
                전체 상품 카테고리
            </li>

        </ul>
    </div>
    <div style="padding-top:10px;overflow:auto;height:415px">
        <table cellpadding=0 cellspacing=0 border=0 style="width:100%;font-size:12px;">
            <thead>
                <tr style="background:#eee">
                    <td style="width:145px;border-top:1px solid #ddd;height:30px">&nbsp;&nbsp;&nbsp;&nbsp;서비스 종류</td>
                    <td style="width:197px;border-top:1px solid #ddd;height:30px;border-left:1px solid #ddd">&nbsp;&nbsp;&nbsp;&nbsp;제품군</td>
                    <td style="border-top:1px solid #ddd;height:30px;border-left:1px solid #ddd">&nbsp;&nbsp;&nbsp;&nbsp;상품명</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="allProduct" colspan=3 style=";border-top:1px solid #ddd"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-close-btn"><button class="btn btn-default btn-small" onclick="$('#dialogAllProduct').dialog('close')">닫기</button></div>
</div>
<script>
$(function(){
    getPi();
    getPr();
    getPd();
    getPs();

});

function getPi(){
    var url = "/api/productItemSearch/<?=$service["sr_pc_seq"]?>";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){
            $('select[name="sr_pi_seq"]').empty().append('<option value="">선택</option>');
            $("#sr_pi_seq_str").html("선택");
            for(var i =0; i < response.length;i++){
                if(response[i].pi_seq == '<?=$service["sr_pi_seq"]?>'){
                    var selected = "selected";
                }else{
                    var selected = "";
                }
                $('select[name="sr_pi_seq"]').append('<option value="'+response[i].pi_seq+'" '+selected+'>'+response[i].pi_name+'</option>');
            }
        }

    });
}

function getPr(){
    var url = "/api/productSearch/<?=$service["sr_pc_seq"]?>";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data:"pi_seq=<?=$service["sr_pi_seq"]?>",
        success:function(response){
            $('select[name="sr_pr_seq"]').empty().append('<option value="">선택</option>');
            $("#sr_pr_seq_str").html("선택");
            for(var i = 0 ;i < response.length;i++){
                if(response[i].pr_seq == '<?=$service["sr_pr_seq"]?>'){
                    var selected = "selected";
                }else{
                    var selected = "";
                }

                $('select[name="sr_pr_seq"]').append('<option value="'+response[i].pr_seq+'" '+selected+'>'+response[i].pr_name+'</option>');
            }
        }

    });

    var addoption = "";
    var url = "/api/productItemSub/<?=$service["sr_pi_seq"]?>";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){
            for(var i = 0; i < response.length;i++){
                addoption += '<input type="hidden" name="sa_c_seq[]" id="sa_c_seq_'+response[i].pis_seq+'" value="'+response[i].c_seq+'"><div class="modal-title" style="background:#eee">\
                                <div class="modal-title-text" style="display:inline-block;background:#eee;font-size:12px;font-weight:normal">부가 항목 '+(i+1)+'</div>\
                                <div style="display:inline-block"><input type="checkbox" data-seq="'+response[i].pis_seq+'" class="pis_yn pis_yn_'+response[i].pis_seq+'" name="pis_yn[]" value="'+response[i].pis_seq+'"> 사용</div>\
                                <div style="display:inline-block;padding-left:552px"></div>\
                            </div>\
                            <input type="hidden" name="sa_seq[]" id="sa_seq_'+response[i].pis_seq+'">\
                            <div class="modal-field" style="padding-bottom:0px;padding-top:5px;text-align:right;display:none" id="addoption_view_'+response[i].pis_seq+'">\
                                <div style="width:100%">\
                                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">\
                                        <li class="dib">부가 항목명 <i class="fas fa-info-circle" title="선택한 제품군에 등록된 부가 항목" rel="tooltip"></i></li>\
                                        <li class="dib" style="padding:0px 10px">\
                                            <input type="text" style="width:570px" name="sa_name[]" id="sa_name_'+response[i].pis_seq+'" value="'+response[i].pis_name+'">\
                                        </li>\
                                        <li class="dib" style="padding-right:50px"><input type="checkbox" data-num="'+(i+1)+'" data-seq="'+response[i].pis_seq+'" data-name="'+response[i].pis_name+'" data-piname="'+response[i].pi_name+'" class="etc_yn etc_yn_'+response[i].pis_seq+'" name="etc_yn[]" id="etc_yn_'+response[i].pis_seq+'"> 계산서 품목 분류 <i class="fas fa-info-circle" title="부가 항목을 세금계산서 내에 별도 품목으로 분류하려면 체크하세요." rel="tooltip"></i></li>\
                                    </ul>\
                                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px;display:none" class="more_view_'+response[i].pis_seq+'">\
                                        <li class="dib">청구명(*) <i class="fas fa-info-circle" title="부가 항목을 세금계산서 내에 별도 품목으로 분류하려면 체크하세요." rel="tooltip"></i></li>\
                                        <li class="dib" style="padding:0px 10px">\
                                            <input type="text" style="width:286px" name="sa_claim_name[]" id="sa_claim_name_'+response[i].pis_seq+'">\
                                        </li>\
                                        <li class="dib" style="padding-left:42px">계산서 품목명(*) <i class="fas fa-info-circle" title="부가 항목을 세금계산서 내에 별도 품목으로 분류하려면 체크하세요." rel="tooltip"></i></li>\
                                        <li class="dib" style="padding:0px 0px 0px 10px">\
                                            <input type="text" style="width:285px" name="sa_bill_name[]" id="sa_bill_name_'+response[i].pis_seq+'" >\
                                        </li>\
                                    </ul>\
                                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px;display:none" class="more_view_'+response[i].pis_seq+'">\
                                        <li class="dib">일회성 요금(*) <i class="fas fa-info-circle" title="부가 항목에 대한 초기 1회 청구 금액을 입력하세요." rel="tooltip"></i></li>\
                                        <li class="dib" style="padding:0px 10px">\
                                            <input type="text" style="width:80px" name="sa_once_price[]" id="sa_once_price_'+response[i].pis_seq+'" class="sa_once_price right" data-seq="'+response[i].pis_seq+'" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)"> 원\
                                        </li>\
                                        <li class="dib" style="padding-left:50px">월 요금(*) <i class="fas fa-info-circle" title="부가 항목에 대한 월 단위 청구 금액을 입력하세요." rel="tooltip"></i></li>\
                                        <li class="dib" style="padding:0px 10px">\
                                            <input type="text" style="width:80px" name="sa_month_price[]" id="sa_month_price_'+response[i].pis_seq+'" class="sa_month_price right" data-seq="'+response[i].pis_seq+'" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)"> 원/월\
                                        </li>\
                                        <li class="dib" style="padding-left:48px">결제주기 <i class="fas fa-info-circle" title="부가 항목에 대한 결제 주기를 개월 단위로 입력하세요." rel="tooltip"></i></li>\
                                        <li class="dib" style="padding:0px 173px 0px 10px">\
                                            <input type="text" style="width:50px" name="sa_pay_day[]" id="sa_pay_day_'+response[i].pis_seq+'" class="sa_pay_day" data-seq="'+response[i].pis_seq+'"> 개월\
                                        </li>\
                                    </ul>\
                                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">\
                                        <li class="dib">부가 항목 매입처 <i class="fas fa-info-circle" title="부가 항목에 등록된 매입처를 자동으로 불러옵니다. (수정 가능)<br>나중에 입력하려면 공란으로 두세요." rel="tooltip"></i></li>\
                                        <li class="dib" style="padding:0px 10px">\
                                            <input type="text" style="width:146px" name="sa_c_name[]" id="sa_c_name_'+response[i].pis_seq+'"><button class="btn btn-brown btn-small" type="button" onclick=\'$("#searchSeq").val("'+response[i].pis_seq+'");$( "#dialogClientSearch" ).dialog("open");$("#dialogClientSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();\'>검색</button>\
                                        </li>\
                                        <li class="dib" style="padding-left:186px">부가 항목 매입가 <i class="fas fa-info-circle" title="부가 항목에 대한 매입가를 입력하세요.<br>예) 12개월 주기로 1,000,000원 씩 매입이면 1,000,000 입력<br>나중에 입력하려면 공란으로 두세요." rel="tooltip"></i></li>\
                                        <li class="dib" style="padding:0px 56px 0px 10px">\
                                            <input type="text" style="width:180px" name="sa_input_price[]" id="sa_input_price_'+response[i].pis_seq+'" class="right" onkeypress="return onlyNumDecimalInput(this);" onkeyup="fn_press_han(this)">원\
                                        </li>\
                                    </ul>\
                                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">\
                                        <li class="dib">부가 항목 매입 단위 <i class="fas fa-info-circle" title="부가 항목 매입가에 대한 매입 단위를 개월 단위로 입력하세요.<br>예) 12개월 주기로 1,000,000원 씩 매입이면 12 입력<br>나중에 입력하려면 공란으로 두세요." rel="tooltip"></i></li>\
                                        <li class="dib" style="padding:0px 10px">\
                                            <input type="text" style="width:146px" name="sa_input_unit[]" id="sa_input_unit_'+response[i].pis_seq+'"> 개월\
                                        </li>\
                                        <li class="dib" style="padding-left:174px">부가 항목 매입 시작일 <i class="fas fa-info-circle" title="부가 항목에 대한 시작일(매입 기준)을 입력하세요.<br>나중에 입력하려면 공란으로 두세요." rel="tooltip"></i></li>\
                                        <li class="dib" style="padding:0px 67px 0px 10px">\
                                            <input type="text" style="width:180px" name="sa_input_date[]" class="datepicker3" id="sa_input_date_'+response[i].pis_seq+'">\
                                        </li>\
                                    </ul>\
                                </div>\
                            </div>';

            }
            $(".addoption").html(addoption);
            $( ".datepicker3" ).datepicker({
                "dateFormat" : "yy-mm-dd"
            });
            <?php foreach($service_option as $row): ?>
                $(".pis_yn_<?=$row["sa_pis_seq"]?>").trigger("click");
                $("#sa_claim_name_<?=$row["sa_pis_seq"]?>").val('<?=$row["sa_claim_name"]?>');
                $("#sa_bill_name_<?=$row["sa_pis_seq"]?>").val('<?=$row["sa_bill_name"]?>');
                $("#sa_once_price_<?=$row["sa_pis_seq"]?>").val('<?=number_format($row["sa_once_price"])?>');
                $("#sa_month_price_<?=$row["sa_pis_seq"]?>").val('<?=number_format($row["sa_month_price"])?>');
                $("#sa_pay_day_<?=$row["sa_pis_seq"]?>").val('<?=$row["sa_pay_day"]?>');

                $("#sa_c_name_<?=$row["sa_pis_seq"]?>").val('<?=$row["c_name"]?>');
                $("#sa_input_price_<?=$row["sa_pis_seq"]?>").val('<?=number_format($row["sa_input_price"])?>');
                $("#sa_input_unit_<?=$row["sa_pis_seq"]?>").val('<?=$row["sa_input_unit"]?>');
                $("#sa_input_date_<?=$row["sa_pis_seq"]?>").val('<?=$row["sa_input_date"]?>');
                $("#sa_c_seq_<?=$row["sa_pis_seq"]?>").val('<?=$row["sa_c_seq"]?>');
                $("#sa_seq_<?=$row["sa_pis_seq"]?>").val('<?=$row["sa_seq"]?>');

                <?php if($row["sap_seq"] != ""): ?>
                    // console.log("<?=$row["sa_pis_seq"]?>");
                    $(".etc_yn_<?=$row["sa_pis_seq"]?>").trigger("click");
                    $("#etc_yn_v_<?=$row["sa_pis_seq"]?>").val("Y");
                    $(".sa_payment_str_<?=$row["sa_pis_seq"]?>").html('<?=$row["sa_pay_day"]?>개월');
                    $("#sp_once_price_add_<?=$row["sa_pis_seq"]?>").val('<?=number_format($row["sap_once_price"])?>');
                    $("#sp_once_dis_price_add<?=$row["sa_pis_seq"]?>").val('<?=number_format($row["sap_once_dis_price"])?>');
                    $("#sp_once_dis_msg_add<?=$row["sa_pis_seq"]?>").val('<?=$row["sap_once_dis_msg"]?>');
                    $("#sp_month_price_add<?=$row["sa_pis_seq"]?>").val('<?=number_format($row["sap_month_price"])?>');
                    $("#sp_month_dis_price_add<?=$row["sa_pis_seq"]?>").val('<?=number_format($row["sap_month_dis_price"])?>');
                    $("#sp_month_dis_msg_add<?=$row["sa_pis_seq"]?>").val('<?=$row["sap_month_dis_msg"]?>');
                    $("#sap_seq_<?=$row["sa_pis_seq"]?>").val('<?=$row["sap_seq"]?>');
                    $("#sp_discount_yn_add<?=$row["sa_pis_seq"]?>").val('<?=$row["sap_discount_yn"]?>');
                    $("#sr_register_discount_<?=$row["sa_pis_seq"]?>").val('<?=number_format($row["sap_register_discount"])?>');
                    $("#sr_register_discount_str_<?=$row["sa_pis_seq"]?>").html('<?=number_format($row["sap_register_discount"])?>');
                    $("#sa_month_price_<?=$row["sa_pis_seq"]?>").trigger("change");
                    $("#sa_once_price_<?=$row["sa_pis_seq"]?>").trigger("change");
                    $("#sa_pay_day_<?=$row["sa_pis_seq"]?>").trigger("change");
                    <?php if($row["sap_discount_yn"] == "Y"): ?>
                        $("#sp_discount_yn_add_check<?=$row["sa_pis_seq"]?>").attr("checked",true);

                    <?php endif; ?>
                    calculateAddPrice('<?=$row["sa_pis_seq"]?>');
                    priceInfoDateAdd('<?=$row["sa_pis_seq"]?>');
                <?php endif; ?>
            <?php endforeach; ?>
            calculatePrice();
            priceInfoDate();
            contractPriceDateInfo();
            calculateTotalPrice();
            $("#sr_pay_publish").trigger("change");
            $.widget("ui.tooltip", $.ui.tooltip, {
                 options: {
                     content: function () {
                         return $(this).prop('title');
                     }
                 }
             });
            $( '[rel=tooltip]' ).tooltip({
                position: {
                    my: "center bottom-20",
                    at: "center top",
                    using: function( position, feedback ) {
                        console.log(this);
                        $( this ).css( position );
                        $( "<div>" )
                            .addClass( "arrow" )
                            .addClass( feedback.vertical )
                            .addClass( feedback.horizontal )
                            .appendTo( this );
                    }
                }
            });
        }

    });
}

function getPd(){
    var url = "/api/productSubDepth1Search/<?=$service["sr_pr_seq"]?>";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){
            $('select[name="sr_pd_seq"]').empty().append('<option value="">선택</option>');

            for(var i = 0; i < response.length;i++){
                if(response[i].pd_seq == '<?=$service["sr_pd_seq"]?>'){
                    var selected = "selected";
                }else{
                    var selected = "";
                }
                $('select[name="sr_pd_seq"]').append('<option value="'+response[i].pd_seq+'" '+selected+'>'+response[i].pd_name+'</option>');
            }
        }

    });
}

function getPs(){
    var url = "/api/productSubDepth2Search/<?=$service["sr_pr_seq"]?>/<?=$service["sr_pd_seq"]?>";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){
            // console.log(response);
            $('select[name="sr_ps_seq"]').empty().append('<option value="">선택</option>');
            // $("#sr_ps_seq_str").html("선택");
            for(var i = 0; i < response.length;i++){
                if(response[i].ps_seq == '<?=$service["sr_ps_seq"]?>'){
                    var selected = "selected";
                }else{
                    var selected = "";
                }
                $('select[name="sr_ps_seq"]').append('<option value="'+response[i].ps_seq+'" data-price="'+response[i].prs_price+'" data-prsoneprice="'+response[i].prs_one_price+'" data-prsmonthprice="'+response[i].prs_month_price+'" data-prsdiv="'+response[i].prs_div+'" '+selected+'>'+response[i].ps_name+'</option>');
            }
        }

    });
}
getEditDate();
</script>