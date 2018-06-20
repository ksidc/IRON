<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<link rel='stylesheet' href="/assets/css/uniform.default.css">
<script src="/assets/js/jquery.uniform.js"></script>
<script src="/assets/js/serviceMake.js?date=<?=time()?>"></script>
<div style="background:#fff;width:100%;overflow-x:hidden">
    <div class="popup_title" style="padding:10px">

        서비스 등록

    </div>
    <div style="padding:5px">
        <form name="registerForm" id="registerForm" method="post" action="/api/estimateAdd">
            <input type="hidden" name="es_seq" id="es_seq">
            <div class="modal-title">
                <div class="modal-title-text">신청 회원 정보</div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">상호/이름(*)</div>
                    <div class="input">
                        <input type="text" class="width-button" name="es_name" id="es_name"><button class="btn btn-brown btn-small btn-number-duple" type="button" onclick='$( "#dialogUserSearch" ).dialog("open");$("#dialogUserSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label">회원아이디</div>
                    <div class="input">
                        <input type="text" name="es_name" id="es_name">
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">End User(*)</div>
                    <div class="input">
                        <input type="text" class="width-button" name="es_name" id="es_name"><button class="btn btn-brown btn-small btn-number-duple" type="button" onclick='$( "#dialogUserSearch" ).dialog("open");$("#dialogUserSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label">업체 분류</div>
                    <div class="input">
                        <input type="text" class="width-button" name="es_name" id="es_name"><button class="btn btn-brown btn-small btn-number-duple" type="button" onclick='$( "#dialogUserSearch" ).dialog("open");$("#dialogUserSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button>
                    </div>
                </div>
            </div>
            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block">계약 정보</div>
                <div style="display:inline-block">
                    <div class="label" style="display:inline-block">계약 번호(*)</div>
                    <div class="input" style="display:inline-block"><input type="text" name="es_number1" id="es_number1" style="width:30%;border:1px solid #ddd;height:15px"> - <input type="text" name="es_number2" id="es_number2" style="width:20%;border:1px solid #ddd;height:15px"> <button class="btn btn-brown btn-small btn-number-duple" type="button">중복확인</button></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">부서</div>
                    <div class="input">
                        <div class="selectbox">
                            <label for="es_type" id="es_type_str" style="top:1.5px;padding:.1em .5em">영업팀</label>
                            <select id="es_type" name="es_type" style="padding:.2em .5em">
                                <option value="영업팀" selected>영업팀</option>
                                <option value="기술팀">기술팀</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label">사내담당자</div>
                    <div class="input">
                        <div class="selectbox">
                            <label for="es_type" id="es_type_str" style="top:1.5px;padding:.1em .5em">영업팀</label>
                            <select id="es_type" name="es_type" style="padding:.2em .5em">
                                <option value="영업팀" selected>영업팀</option>
                                <option value="기술팀">기술팀</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
              <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">계약(약정)기간</div>
                    <div class="input"><input type="radio" name=""> 약정 <input type="radio" name=""> 무약정</div>
                </div>
                <div class="modal-field-input">
                    <div class="label">계약 만료 후 자동 계약 연장 여부</div>
                    <div class="input">
                        <ul style="list-style:none;padding:0;margin:0">
                            <li style="display:inline-block"><input type="radio" name=""> 자동 계약 연장 </li>
                            <li style="display:inline-block;padding-left:10px">단위 : <input type="text" style="width:30px"> 개월</li>
                        </ul>
                        <ul style="list-style:none;padding:0;margin:0">
                            <li><input type="radio" name=""> 재 계약 필요 </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block">기본 결제 조건 </div>
                <div style="display:inline-block;text-align:right;width:78%">
                    <div style="text-align:right"><button class="btn btn-brown btn-small btn-number-duple" type="button" style="cursor:normal;" onclick="return false;">등록 할인율 (변경 가능)</button><input type="text" name="es_number2" id="es_number2" style="width:40px;border:1px solid #ddd;height:17px">% </div>
                </div>
            </div>
            <div class="modal-field depth-area">
                <div class="depth-item">
                    <div class="modal-field-input">
                        <div class="label">요금 납부 방법</div>
                        <div class="input">
                            <input type="radio" name=""> 무통장 <input type="radio" name=""> 카드 <input type="radio" name=""> CMS
                        </div>
                    </div>
                    <div class="modal-field-input">
                        <div class="label">결제 주기(*)</div>
                        <div class="input">
                            <input type="text" name="" style="width:70px"> 개월
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">청구 기준</div>
                    <div class="input">
                        서비스 이용 월의
                        <div class="selectbox" style="width:40%">
                            <label for="mb_payment_type" style="top:1.5px;padding:.1em .5em">전월</label>
                            <select name="mb_payment_type" id="mb_payment_type" style="padding:.2em .5em">
                                <option selected value="0">전월</option>
                                <option value="1">당월</option>
                                <option value="2">익월</option>
                            </select>
                        </div> 청구
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label">자동 청구일(*)</div>

                    <div class="input">
                        <div class="selectbox" style="width:60%">
                            <label for="mb_auto_payment" style="top:1.5px;padding:.1em .5em">25일</label>
                            <select name="mb_auto_payment" id="mb_auto_payment" style="padding:.2em .5em">
                                <?php for($i = 1; $i < 32; $i++): ?>
                                    <?php if($i == 25): ?>
                                        <option selected value="<?=$i?>"><?=$i?>일</option>
                                    <?php else: ?>
                                        <option value="<?=$i?>"><?=$i?>일</option>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <option value="32">말일</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">계산서 발행</div>
                    <div class="input">
                        <div class="selectbox" style="width:40%">
                            <label for="mb_payment_publish" style="top:1.5px;padding:.1em .5em">발행</label>
                            <select  name="mb_payment_publish" id="mb_payment_publish" style="padding:.2em .5em">
                                <option selected value="0">발행</option>
                                <option value="1">미발행</option>

                            </select>
                        </div>
                        <div class="selectbox" style="width:40%">
                            <label for="mb_payment_publish_type" style="top:1.5px;padding:.1em .5em">영수 발행</label>
                            <select name="mb_payment_publish_type" id="mb_payment_publish_type" style="padding:.2em .5em">
                                <option selected value="0">영수 발행</option>
                                <option value="1">청구 발행</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label">결제일(*)</div>
                    <div class="input">
                        청구일로부터
                        <div class="selectbox" style="width:30%">
                            <label for="select" style="top:1.5px;padding:.1em .5em">입력</label>
                            <select name="mb_payment_day_select" id="mb_payment_day_select" style="padding:.2em .5em">
                                <option selected value="etc">입력</option>
                                <option value="30">30</option>
                                <option value="60">60</option>
                                <option value="90">90</option>
                            </select>
                        </div> <input type="text" style="width:15%" name="mb_payment_day" id="mb_payment_day"> 일 후
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label">과금 시작일(*)</div>
                    <div class="input"><input type="text"  name="es_shot" id="es_shot"></div>
                </div>
                <div class="modal-field-input">
                    <div class="label">과금 만료일(자동)</div>
                    <div class="input"><input type="text"  name="es_shot" id="es_shot"></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label">초기 일할 청구</div>
                    <div class="input">당월분 일할 계산 (100의 자리 내림) <button class="btn btn-brown" type="button">변경</button></div>
                </div>

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
                        <li class="dib" style="padding:0px 10px">
                            <div class="selectbox" >
                                <label for="es_type" id="es_type_str" style="top:1.5px;padding:.1em .5em">영업팀</label>
                                <select id="es_type" name="es_type" style="padding:.2em .5em">
                                    <option value="영업팀" selected>영업팀</option>
                                    <option value="기술팀">기술팀</option>
                                </select>
                            </div>
                        </li>
                        <li class="dib">제품군(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <div class="selectbox" >
                                <label for="es_type" id="es_type_str" style="top:1.5px;padding:.1em .5em">영업팀</label>
                                <select id="es_type" name="es_type" style="padding:.2em .5em">
                                    <option value="영업팀" selected>영업팀</option>
                                    <option value="기술팀">기술팀</option>
                                </select>
                            </div>
                        </li>
                        <li class="dib">상품명(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 0px 0px 10px">
                            <div class="selectbox" style="width:250px">
                                <label for="es_type" id="es_type_str" style="top:1.5px;padding:.1em .5em">영업팀</label>
                                <select id="es_type" name="es_type" style="padding:.2em .5em">
                                    <option value="영업팀" selected>영업팀</option>
                                    <option value="기술팀">기술팀</option>
                                </select>
                            </div>
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px">
                        <li class="dib">대분류(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <div class="selectbox" >
                                <label for="es_type" id="es_type_str" style="top:1.5px;padding:.1em .5em">영업팀</label>
                                <select id="es_type" name="es_type" style="padding:.2em .5em">
                                    <option value="영업팀" selected>영업팀</option>
                                    <option value="기술팀">기술팀</option>
                                </select>
                            </div>
                        </li>
                        <li class="dib">소분류(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <div class="selectbox" >
                                <label for="es_type" id="es_type_str" style="top:1.5px;padding:.1em .5em">영업팀</label>
                                <select id="es_type" name="es_type" style="padding:.2em .5em">
                                    <option value="영업팀" selected>영업팀</option>
                                    <option value="기술팀">기술팀</option>
                                </select>
                            </div>
                        </li>
                        <li class="dib">청구명(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 0px 0px 10px">
                            <input type="text" style="width:246px">
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">임대 여부 <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <div class="selectbox" >
                                <label for="es_type" id="es_type_str" style="top:1.5px;padding:.1em .5em">영업팀</label>
                                <select id="es_type" name="es_type" style="padding:.2em .5em">
                                    <option value="영업팀" selected>영업팀</option>
                                    <option value="기술팀">기술팀</option>
                                </select>
                            </div>
                        </li>

                        <li class="dib" style="padding-left:206px">계산서 품목명(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 0px 0px 10px">
                            <input type="text" style="width:246px">
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
                            <input type="text" style="width:146px"> 원
                        </li>

                        <li class="dib" style="padding-left:225px">월 요금(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 40px 0px 10px">
                            <input type="text" style="width:180px">원/월
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">임대 형태(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="radio" name=""> 영구임대 <input type="radio" name=""> 소유권 이전 &nbsp;&nbsp;&nbsp;&nbsp; <input type="text" style="width:30px"> 개월
                        </li>

                        <li class="dib" style="padding-left:96px">소유권 이전 후 월 요금(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 40px 0px 10px">
                            <input type="text" style="width:180px">원/월
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">상품 매입처 <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="text" style="width:146px">
                        </li>

                        <li class="dib" style="padding-left:233px">상품 매입가 <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 56px 0px 10px">
                            <input type="text" style="width:180px">원
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block">부가 항목 정보 </div>

            </div>
            <!-- loop -->
            <div class="modal-title" style="background:#ddd">
                <div class="modal-title-text" style="display:inline-block;background:#ddd;font-size:12px;font-weight:normal">부가 항목 01</div>
                <div style="display:inline-block"><input type="checkbox"> 사용</div>
            </div>
            <div class="modal-field" style="padding-bottom:0px;padding-top:5px;text-align:right">
                <div style="width:100%">

                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">부가 항목명 <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="text" style="width:552px">
                        </li>
                        <li class="dib" style="padding-right:50px"><input type="checkbox"> 계산서 품목 분류 <i class="fas fa-info-circle"></i></li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">청구명(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="text" style="width:286px">
                        </li>

                        <li class="dib" style="padding-left:30px">계산서 품목명(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 0px 0px 10px">
                            <input type="text" style="width:285px">
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">일회성 요금(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="text" style="width:80px"> 원
                        </li>
                        <li class="dib" style="padding-left:48px">월 요금(*) <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="text" style="width:80px"> 원/월
                        </li>
                        <li class="dib" style="padding-left:48px">결제주기 <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 172px 0px 10px">
                            <input type="text" style="width:50px"> 개월
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">부가 항목 매입처 <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="text" style="width:146px">
                        </li>

                        <li class="dib" style="padding-left:211px">부가 항목 매입가 <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 56px 0px 10px">
                            <input type="text" style="width:180px">원
                        </li>
                    </ul>
                    <ul style="text-align:right;padding-right:2px;padding-top:5px;padding-bottom:5px">
                        <li class="dib">부가 항목 매입 단위 <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 10px">
                            <input type="text" style="width:146px"> 개월
                        </li>

                        <li class="dib" style="padding-left:164px">부가 항목 매입 시작일 <i class="fas fa-info-circle"></i></li>
                        <li class="dib" style="padding:0px 66px 0px 10px">
                            <input type="text" style="width:180px">
                        </li>
                    </ul>
                </div>
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
                    <div style="width:42%;float:left;vertical-align:top">
                        <div class="price-label" style="text-align:right"><div style="padding-right:20px">서비스명</div></div>
                        <ul style="text-align:right;border-left:1px solid #ddd">
                            <li style="line-height:35px;padding-right:20px">[[상품명]] - [[소분류]]</li>
                            <li style="line-height:35px;padding-right:20px;color:red">할인 금액</li>
                            <li style="line-height:35px;padding-right:20px">할인 사유</li>
                            <li style="line-height:35px;padding-right:20px;color:red">요금 납부 방법 및 결제 주기에 따른 할인 금액</li>
                            <li style="line-height:35px;background:#eee;padding-right:20px;border-bottom:1px solid #ddd">소계</li>
                        </ul>
                    </div>
                    <div style="width:27%;float:left;vertical-align:top ">
                        <div class="price-label"><div style="padding-left:10px">일회성 요금 (신청 시 1회 청구)</div></div>
                        <ul style="list-style:none;padding:0;margin:0;border-left:1px solid #ddd">
                            <li style="line-height:35px;padding-left:5px"> &nbsp;&nbsp; <input type="text" style="width:160px"> 원</li>
                            <li style="line-height:35px;padding-left:5px;color:red"> - <input type="text" style="width:160px"> 원</li>
                            <li style="line-height:35px;padding-left:5px"> &nbsp;&nbsp; <input type="text" style="width:160px"></li>
                            <li style="line-height:35px;font-size:11px;text-align:center">요금 납부 방법 및 결제 주기에 따른 할인 금액</li>
                            <li style="line-height:35px;background:#eee;padding-left:5px;border-bottom:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:160px"> 원</li>
                        </ul>
                    </div>
                    <div style="width:31%;float:left;vertical-align:top; ">
                        <div class="price-label"><div style="padding-left:10px">월 요금([[자동 청구일]]일 청구)</div></div>
                        <ul style="list-style:none;padding:0;margin:0;border-left:1px solid #ddd">
                            <li style="line-height:35px;padding-left:5px"> &nbsp;&nbsp; <input type="text" style="width:180px"> 원 / 결주</li>
                            <li style="line-height:35px;padding-left:5px;color:red"> - <input type="text" style="width:180px"><span style=";color:red"> 원 / 월</span></li>
                            <li style="line-height:35px;padding-left:4px"> &nbsp;&nbsp; <input type="text" style="width:180px"></li>
                            <li style="line-height:35px;padding-left:5px;color:red"> - <input type="text" style="width:180px"> 원 / [[결제]]</li>
                            <li style="line-height:35px;background:#eee;padding-left:4px;border-bottom:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:180px"> 원 / [[결제]]</li>
                        </ul>
                    </div>
                    <div style="clear:both;width:100%;background-color:#EBE9E4;height:50px;border-left:1px solid #ddd">
                        <div style="width:12%;float:left">
                            <div style="line-height:50px;padding-left:30px">초기 청구 요금</div>
                        </div>
                        <div style="width:88%;float:left">
                            <ul style="padding-top:10px;padding-right:5px">
                                <li style="text-align:right">일회성 요금 (<span style=";color:red">100,000</span>) + 2018년 05월 16일 ~ 2018년 05월 31일 이용료 (<span style=";color:red">51,000</span>) + 2018년 06월 01월 ~ 2018년 06월 30일 이용료 (<span style=";color:red">100,000</span>)</li>
                                <li style=";text-align:right;padding-top:3px"> = 합계 (<span style=";color:red">100,000</span>)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div style="clear:both;width:100%;border-top:1px solid #ddd">
                    <div style="width:10%;float:left;vertical-align:top; ">

                        <p style="text-align:center;padding-top:100px">부가01</p>
                    </div>
                    <div style="width:90%;float:left;">
                        <div style="width:42%;float:left;vertical-align:top">

                            <ul style="text-align:right;border-left:1px solid #ddd">
                                <li style="line-height:35px;padding-right:20px">[[상품명]] - [[소분류]]</li>
                                <li style="line-height:35px;padding-right:20px;color:red">할인 금액</li>
                                <li style="line-height:35px;padding-right:20px">할인 사유</li>
                                <li style="line-height:35px;padding-right:20px;color:red">요금 납부 방법 및 결제 주기에 따른 할인 금액</li>
                                <li style="line-height:35px;background:#eee;padding-right:20px;border-bottom:1px solid #ddd">소계</li>
                            </ul>
                        </div>
                        <div style="width:27%;float:left;vertical-align:top ">

                            <ul style="list-style:none;padding:0;margin:0;border-left:1px solid #ddd">
                                <li style="line-height:35px;padding-left:5px"> &nbsp;&nbsp; <input type="text" style="width:160px"> 원</li>
                                <li style="line-height:35px;padding-left:5px;color:red"> - <input type="text" style="width:160px"> 원</li>
                                <li style="line-height:35px;padding-left:5px"> &nbsp;&nbsp; <input type="text" style="width:160px"></li>
                                <li style="line-height:35px;font-size:11px;text-align:center">요금 납부 방법 및 결제 주기에 따른 할인 금액</li>
                                <li style="line-height:35px;background:#eee;padding-left:5px;border-bottom:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:160px"> 원</li>
                            </ul>
                        </div>
                        <div style="width:31%;float:left;vertical-align:top; ">

                            <ul style="list-style:none;padding:0;margin:0;border-left:1px solid #ddd">
                                <li style="line-height:35px;padding-left:5px"> &nbsp;&nbsp; <input type="text" style="width:180px"> 원 / 결주</li>
                                <li style="line-height:35px;padding-left:5px;color:red"> - <input type="text" style="width:180px"><span style=";color:red"> 원 / 월</span></li>
                                <li style="line-height:35px;padding-left:4px"> &nbsp;&nbsp; <input type="text" style="width:180px"></li>
                                <li style="line-height:35px;padding-left:5px;color:red"> - <input type="text" style="width:180px"> 원 / [[결제]]</li>
                                <li style="line-height:35px;background:#eee;padding-left:4px;border-bottom:1px solid #ddd"> &nbsp;&nbsp; <input type="text" style="width:180px"> 원 / [[결제]]</li>
                            </ul>
                        </div>
                        <div style="clear:both;width:100%;background-color:#EBE9E4;height:50px;border-left:1px solid #ddd">
                            <div style="width:12%;float:left">
                                <div style="line-height:50px;padding-left:30px">초기 청구 요금</div>
                            </div>
                            <div style="width:88%;float:left">
                                <ul style="padding-top:10px;padding-right:5px">
                                    <li style="text-align:right">일회성 요금 (<span style=";color:red">100,000</span>) + 2018년 05월 16일 ~ 2018년 05월 31일 이용료 (<span style=";color:red">51,000</span>) + 2018년 06월 01월 ~ 2018년 06월 30일 이용료 (<span style=";color:red">100,000</span>)</li>
                                    <li style=";text-align:right;padding-top:3px"> = 합계 (<span style=";color:red">100,000</span>)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="width:47.5%;float:left;background:#ddd;line-height:35px;text-align:right;">
                    <div style="padding-right:20px;;border-top:1px solid #ddd">합계 (소계의 합)</div>
                </div>
                <div style="width:24.5%;float:left;background:#ddd;line-height:35px;">
                     <div style=";border-top:1px solid #ddd;border-left:1px solid #ddd;padding-left:5px">&nbsp;&nbsp; <input type="text" style="width:160px"> 원</div>
                </div>
                <div style="width:28%;float:left;background:#ddd;line-height:35px;">
                    <div style=";border-top:1px solid #ddd;border-left:1px solid #ddd;padding-left:5px">&nbsp;&nbsp; <input type="text" style="width:180px"> 원 (단위 : 월)</div>
                </div>
                <div style="clear:both;width:47.5%;float:left;background:#EBE9E4;line-height:35px;text-align:right;">
                    <ul style="padding-right:20px;border-top:1px solid #ddd;border-left:1px solid #ddd">
                        <li style="display:inline-block">합계(초기 청구 요금의 합)</li>
                        <li style="display:inline-block"><input type="text" style="width:160px"> 원 </li>
                    </ul>
                </div>
                <div style="width:24.5%;float:left;background:#EBE9E4;line-height:35px;">
                    <div style=";border-top:1px solid #ddd;border-left:1px solid #ddd;padding-left:5px"> &nbsp;&nbsp; <input type="text" style="width:160px"> 원</div>
                </div>
                <div style="width:28%;float:left;background:#EBE9E4;line-height:35px;">
                    <div style=";border-top:1px solid #ddd;border-left:1px solid #ddd;padding-left:5px"> &nbsp;&nbsp; <input type="text" style="width:180px"> 원</div>
                </div>
            </div>
            <div class="modal-button" style="clear:both">
                <button class="btn btn-black btn-register" type="submit">등록</button>
            </div>
        </form>
        <form name="fileTmpUpload" id="fileTmpUpload" method="post">
            <input type="hidden" name="ef_es_code" id="ef_es_code">
            <input type="file" name="es_file[]" id="es_file" style="border:0;display:none;width:0;height:0" multiple visbility="hidden">
        </form>
    </div>
</div>
<div id="dialogUserSearch" class="dialog" style="padding:5px">
    <form name="userSearchForm" id="userSearchForm" method="get">
    <div class="modal_search">
        <ul>
            <li>
                <div class="selectbox" style="background:#fff;width:100px">
                    <label for="memberSearchType" style="top:1.5px;padding:.52em .5em .3em .5em;font-size:12px">회원명</label>
                    <select name="memberSearchType" style="padding:.52em .5em .3em .5em;font-size:12px">
                        <option value="mb_name" selected>회원명</option>

                    </select>
                </div>
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
        <div>
            <div class="modal-field-input full" >
                <div class="label service" >일할 계산 여부</div>
                <div class="input service" >
                    <div class="modal-service-left" style="border-bottom:0px">
                        <ul class="service-type">
                            <li style="display:inline-block;width:30%"><input type="radio" name="sp_basic_type" id="sp_basic_type_1" value="1">일할 계산</li>
                            <li style="display:inline-block"><input type="radio" name="sp_basic_type" id="sp_basic_type_2" value="2">과금 시작일 기준 결제 주기로 처리</li>
                        </ul>
                        <ul class="service-type">
                            <li style="display:inline-block;width:30%"><input type="radio" name="sp_policy" id="sp_policy_1" value="1">당월분 일할 계산</li>
                            <li style="display:inline-block"><input type="radio" name="sp_policy" id="sp_policy_2" value="2">
                                <div class="selectbox" style="width:70px">
                                    <label for="sp_pay_start_day" id="sp_pay_start_day_str" style="top:1.5px;padding:.1em .5em">15일</label>
                                    <select id="sp_pay_start_day" name="sp_pay_start_day" style="padding:.2em .5em">
                                        <?php for($i = 1; $i < 32;$i++): ?>
                                        <option value="<?=$i?>" <?=($i == 15 ? "selected":"")?>><?=$i?>일</option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                일 (과금 시작) 이후 건 익월분 통합
                            </li>
                        </ul>
                        <ul class="service-type">
                            <li style="display:inline-block;width:70%">
                                <div class="selectbox" style="width:150px">
                                    <label for="sp_pay_format" id="sp_pay_format_str" style="top:1.5px;padding:.1em .5em">10의 자리</label>
                                    <select id="sp_pay_format" name="sp_pay_format" style="padding:.2em .5em">
                                        <option value="1">1의 자리</option>
                                        <option value="2" selected>10의 자리</option>
                                        <option value="3">100의 자리</option>
                                        <option value="4">1000의 자리</option>
                                    </select>
                                </div>
                                <div class="selectbox" style="width:80px">
                                    <label for="sp_pay_format_policy" id="sp_pay_format_policy_str" style="top:1.5px;padding:.1em .5em">버림</label>
                                    <select id="sp_pay_format_policy" name="sp_pay_format_policy" style="padding:.2em .5em">
                                        <option value="1" selected>버림</option>
                                        <option value="2">올림</option>
                                        <option value="3">반올림</option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

    </form>

    <div class="modal-close-btn"><button class="btn btn-black btn-small" onclick="$('#dialogTypeSearch').dialog('close')">닫기</button></div>
</div>