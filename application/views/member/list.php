
<script src="/assets/js/memberList.js?date=<?=time()?>"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<div class="content">
    <h2 class="title">
        <i class="fa fa-file"></i> 회원 관리
    </h2>
    <div class="search">
        <form name="searchForm" id="searchForm" onsubmit="return getList();">
            <div class="search1">
                <div class="form-group">
                    <input type="checkbox" name="serviceYn" id="serviceYn" value="Y"> 서비스 이용 중인 회원만 표시
                </div>
                <div class="form-group">
                    <select id="searchSelect" name="searchSelect" class="select2" style="width:150px">
                        <option value="0" selected>서비스 전체</option>
                    </select>
                </div>
            </div>
            <div class="search2">
                <div class="form-group">
                    <label>등록일</label>
                    <input type="text" style="width:80px" name="startDate" id="startDate" class="datepicker" value="2012-01-01"> ~ <input type="text" name="endDate" id="endDate" style="width:80px" class="datepicker" value="<?=date('Y-m-d')?>">
                </div>
                <div class="form-group ml15" style="text-align:left">

                    <select id="searchType" name="searchType" class="select2" style="width:120px;">
                        <option value="mb_name" selected>회원명</option>
                        <option value="mb_id">회원아이디</option>
                        <option value="mb_ceo">대표자</option>
                        <option value="mb_charger">사내담당자</option>
                        <option value="mb_tel">대표전화</option>
                        <option value="mb_email">이메일</option>
                        <option value="mb_contract_name">계약담당자</option>
                        <option value="mb_payment_name">요금담당자</option>
                        <option value="mb_number">사업자번호</option>
                    </select>

                    <input type="text" name="searchWord" id="searchWord">
                    <button class="btn btn-search btn-form-search" type="submit">검색</button>
                </div>
            </div>
        </form>
    </div>
    <div class="list">
        <div class="top-button-group">
            <div class="btn-left">
                <button class="btn btn-default btn-check-delete" type="button">선택 삭제</button>
                <button class="btn btn-default ml5 btn-check-excel" type="button">Excel</button>
            </div>
            <div class="btn-right">
                <button class="btn btn-black btn-add" type="button">회원 등록</button>
            </div>
        </div>
        <div class="table-list">
            <form id="listForm" method="POST" action="/api/memberExport">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="all"></th>
                        <th>No</th>
                        <th>아이디</th>
                        <th>회원명</th>
                        <th>사내담당자</th>
                        <th>대표전화</th>
                        <th>계약담당자</th>
                        <th>요금담당자</th>
                        <th>등록일</th>
                        <th>서비스</th>
                        <th>수정</th>
                        <th>삭제</th>
                    </tr>
                </thead>
                <tbody id="tbody-list">

                </tbody>
            </table>
            </form>
            <div class="pagination-html">

            </div>
        </div>
        <div class="bottom-button-group">
            <div class="btn-left">
                <button class="btn btn-default btn-check-delete" type="button">선택 삭제</button>
                <button class="btn btn-default ml5 btn-check-excel" type="button">Excel</button>
            </div>
            <div class="btn-right">
                <button class="btn btn-black btn-add" type="button">회원 등록</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="start" value=1>

<div id="dialog" class="dialog">
    <form name="registerForm" id="registerForm">
        <input type="hidden" name="mb_seq" id="mb_seq">
        <input type="hidden" name="dupleIdYn" id="dupleIdYn" value="N">
        <input type="hidden" name="dupleNumberYn" id="dupleNumberYn" value="N">
        <div class="modal-title">
            <div class="modal-title-text">로그인 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">회원 아이디(코드)</div>
                <div class="input write"><input type="text" name="mb_id" id="mb_id" class="width-button"><button class="btn btn-brown btn-small btn-id-duple" type="button">중복확인</button></div>
                <div class="input edit md-id-str"></div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">회원 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">회원구분</div>
                <div class="input">

                    <select name="mb_type" id="mb_type" class="select2" style="width:90%">
                        <option value="0" selected>사업자</option>
                        <option value="1">개인</option>

                    </select>

                </div>
            </div>
            <div class="modal-field-input">
                <div class="label company">상호명</div>
                <div class="label user">이름</div>
                <div class="input"><input type="text" name="mb_name" id="mb_name"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label company">사업자등록번호(-포함)</div>
                <div class="label user">생년월일(1900-01-01)</div>
                <div class="input"><input type="text" class="width-button" name="mb_number" id="mb_number"><button class="btn btn-brown btn-small btn-number-duple company" type="button">중복확인</button></div>
            </div>
            <div class="modal-field-input">
                <div class="label">대표자</div>
                <div class="input"><input type="text" name="mb_ceo" id="mb_ceo"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full">
                <div class="label">주소</div>
                <div class="input" style="width:78%"><input type="text" style="width:17%" name="mb_zipcode" id="mb_zipcode" readonly onclick="daumApi()"> <input type="text" style="width:50%" name="mb_address" id="mb_address" readonly onclick="daumApi()"> <input type="text" style="width:27%" name="mb_detail_address" id="mb_detail_address"></div>
            </div>

        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">전화번호(-포함)</div>
                <div class="input"><input type="text" name="mb_tel" id="mb_tel"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">휴대폰번호(-포함)</div>
                <div class="input"><input type="text" name="mb_phone" id="mb_phone"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">이메일</div>
                <div class="input"><input type="text" name="mb_email" id="mb_email" ></div>
            </div>
            <div class="modal-field-input">
                <div class="label">팩스(-포함)</div>
                <div class="input"><input type="text" name="mb_fax" id="mb_fax"></div>
            </div>
        </div>
        <div class="modal-field company">
            <div class="modal-field-input">
                <div class="label">업태</div>
                <div class="input"><input type="text" name="mb_business_conditions" id="mb_business_conditions"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">종목</div>
                <div class="input"><input type="text" name="mb_business_type" id="mb_business_type"></div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">계약 담당자 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">담당자명</div>
                <div class="input"><input type="text" name="mb_contract_name" id="mb_contract_name"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">이메일</div>
                <div class="input"><input type="text" name="mb_contract_email" id="mb_contract_email"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">전화번호(-포함)</div>
                <div class="input"><input type="text" name="mb_contract_tel" id="mb_contract_tel"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">휴대폰번호(-포함)</div>
                <div class="input"><input type="text" name="mb_contract_phone" id="mb_contract_phone"></div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">요금 담당자 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">담당자명</div>
                <div class="input"><input type="text" name="mb_payment_name" id="mb_payment_name"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">이메일</div>
                <div class="input"><input type="text" name="mb_payment_email" id="mb_payment_email"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">전화번호(-포함)</div>
                <div class="input"><input type="text" name="mb_payment_tel" id="mb_payment_tel"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">휴대폰번호(-포함)</div>
                <div class="input"><input type="text" name="mb_payment_phone" id="mb_payment_phone"></div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">회원 계좌 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">은행명</div>
                <div class="input"><input type="text" name="mb_bank" id="mb_bank"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">계좌번호(-포함)</div>
                <div class="input"><input type="text" name="mb_bank_input_number" id="mb_bank_input_number"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">예금주</div>
                <div class="input"><input type="text" style="width:38.7%" name="mb_bank_name" id="mb_bank_name">&nbsp;&nbsp;&nbsp;&nbsp;관계 <input type="text" style="width:30%" name="mb_bank_name_relationship" id="mb_bank_name_relationship"> </div>
            </div>
            <div class="modal-field-input">
                <div class="label">사업자번호/생년월일</div>
                <div class="input"><input type="text" name="mb_bank_number" id="mb_bank_number"></div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">기본 결제 조건</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">청구 기준</div>
                <div class="input">이용 월의

                    <select name="mb_payment_type" id="mb_payment_type" class="select2" style="width:40%">
                        <option selected value="0">전월</option>
                        <option value="1">당월</option>
                        <option value="2">익월</option>
                    </select>
                     청구
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">자동 청구일</div>
                <div class="input">

                    <select name="mb_auto_payment" id="mb_auto_payment" class="select2" style="width:90%">
                        <?php for($i = 1; $i < 29; $i++): ?>
                            <?php if($i == 25): ?>
                                <option selected value="<?=$i?>"><?=$i?>일</option>
                            <?php else: ?>
                                <option value="<?=$i?>"><?=$i?>일</option>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <option value="29">말일</option>
                    </select>

                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">계산서 발행</div>
                <div class="input">

                    <select  name="mb_payment_publish" id="mb_payment_publish" class="select2" style="width:30%">
                        <option selected value="0">발행</option>
                        <option value="1">미발행</option>

                    </select>


                    <select name="mb_payment_publish_type" id="mb_payment_publish_type" class="select2" style="width:40%">
                        <option selected value="0">영수 발행</option>
                        <option value="1">청구 발행</option>

                    </select>

                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">결제일</div>
                <div class="input">청구일로부터

                        <select name="mb_payment_day_select" id="mb_payment_day_select" class="select2" style="width:30%">
                            <option selected value="etc">입력</option>
                            <option value="30">30</option>
                            <option value="60">60</option>
                            <option value="90">90</option>
                        </select>
                     <input type="text" style="width:15%" name="mb_payment_day" id="mb_payment_day"> 일 후
                </div>
            </div>
        </div>
        <div class="modal-button">
            <button class="btn btn-black btn-register" type="submit">등록</button>
        </div>
    </form>
</div>