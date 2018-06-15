<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<link rel='stylesheet' href="/assets/css/uniform.default.css">
<script src="/assets/js/jquery.uniform.js"></script>
<script src="/assets/js/clientList.js?date=<?=time()?>"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<div class="content">
    <h2 class="title">
        <i class="fa fa-file"></i> 매입처 등록
    </h2>
    <div class="search">
        <form name="searchForm" id="searchForm" onsubmit="return getList();">

            <div class="search2">
                <div class="form-group">
                    <label>등록일</label>
                    <input type="text" style="width:80px" name="startDate" id="startDate" class="datepicker" value="2012-01-01"> ~ <input type="text" name="endDate" id="endDate" style="width:80px" class="datepicker" value="<?=date('Y-m-d')?>">
                </div>
                <div class="form-group ml15">
                    <div class="selectbox">
                        <label for="searchType">매입처명</label>
                        <select id="searchType" name="searchType">
                            <option value="c_name" selected>매입처명</option>
                            <option value="c_ceo">대표자</option>
                            <option value="c_contract_name">기본담당자</option>
                            <option value="c_payment_name">요금담당자</option>
                            <option value="c_contract_tel">전화번호</option>
                            <option value="c_contract_phone">휴대폰번호</option>
                            <option value="c_number">사업자번호</option>
                        </select>
                    </div>
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
                <button class="btn btn-black btn-add" type="button">매입처 등록</button>
            </div>
        </div>
        <div class="table-list">
            <form id="listForm" method="POST" action="/api/clientExport">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="all"></th>
                        <th>No</th>
                        <th>아이디</th>
                        <th>매입처명</th>
                        <th>사업자등록번호</th>
                        <th>담당자</th>
                        <th>이메일</th>
                        <th>전화번호</th>
                        <th>휴대폰번호</th>
                        <th>대표 품목</th>
                        <th>지급조건</th>
                        <th>파일</th>
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
                <button class="btn btn-black btn-add" type="button">매입처 등록</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="start" value=1>

<div id="dialog" class="dialog">
    <form name="registerForm" id="registerForm" method="post">
        <input type="hidden" name="c_seq" id="c_seq">
        <input type="hidden" name="dupleIdYn" id="dupleIdYn" value="N">
        <input type="hidden" name="dupleNumberYn" id="dupleNumberYn" value="N">
        <input type="hidden" name="c_payment_type" id="c_payment_type" value="1">
        <div class="modal-title">
            <div class="modal-title-text">로그인 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">매입처 아이디(코드)</div>
                <div class="input write"><input type="text" name="c_id" id="c_id" class="width-button"><button class="btn btn-brown btn-small btn-id-duple" type="button">중복확인</button></div>
                <div class="input edit c-id-str"></div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">매입처 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">상호명</div>
                <div class="input"><input type="text" name="c_name" id="c_name"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">대표 품목</div>
                <div class="input"><input type="text" name="c_item" id="c_item"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">사업자등록번호(-포함)</div>
                <div class="input"><input type="text" class="width-button" name="c_number" id="c_number"><button class="btn btn-brown btn-small btn-number-duple company" type="button">중복확인</button></div>
            </div>
            <div class="modal-field-input">
                <div class="label">대표자</div>
                <div class="input"><input type="text" name="c_ceo" id="c_ceo"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full">
                <div class="label">주소</div>
                <div class="input" style="width:78%"><input type="text" style="width:17%" name="c_zipcode" id="c_zipcode" readonly onclick="daumApi()"> <input type="text" style="width:50%" name="c_address" id="c_address" readonly onclick="daumApi()"> <input type="text" style="width:27%" name="c_detail_address" id="c_detail_address"></div>
            </div>

        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">이메일</div>
                <div class="input"><input type="text" name="c_email" id="c_email" class="emailCheck"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">팩스(-포함)</div>
                <div class="input"><input type="text" name="c_fax" id="c_fax"></div>
            </div>
        </div>
        <div class="modal-field company">
            <div class="modal-field-input">
                <div class="label">업태</div>
                <div class="input"><input type="text" name="c_business_conditions" id="c_business_conditions"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">종목</div>
                <div class="input"><input type="text" name="c_business_type" id="c_business_type"></div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">계약 담당자 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">담당자명</div>
                <div class="input"><input type="text" name="c_contract_name" id="c_contract_name"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">이메일</div>
                <div class="input"><input type="text" name="c_contract_email" id="c_contract_email"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">전화번호(-포함)</div>
                <div class="input"><input type="text" name="c_contract_tel" id="c_contract_tel"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">휴대폰번호(-포함)</div>
                <div class="input"><input type="text" name="c_contract_phone" id="c_contract_phone"></div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">요금 담당자 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">담당자명</div>
                <div class="input"><input type="text" name="c_payment_name" id="c_payment_name"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">이메일</div>
                <div class="input"><input type="text" name="c_payment_email" id="c_payment_email"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">전화번호(-포함)</div>
                <div class="input"><input type="text" name="c_payment_tel" id="c_payment_tel"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">휴대폰번호(-포함)</div>
                <div class="input"><input type="text" name="c_payment_phone" id="c_payment_phone"></div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">매입처 계좌 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">은행명</div>
                <div class="input"><input type="text" name="c_bank" id="c_bank"></div>
            </div>
            <div class="modal-field-input">
                <div class="label">계좌번호(-포함)</div>
                <div class="input"><input type="text" name="c_bank_input_number" id="c_bank_input_number"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">예금주</div>
                <div class="input"><input type="text" style="width:38.7%" name="c_bank_name" id="c_bank_name">&nbsp;&nbsp;&nbsp;&nbsp;관계 <input type="text" style="width:30%" name="c_bank_name_relationship" id="c_bank_name_relationship"> </div>
            </div>
            <div class="modal-field-input">
                <div class="label">사업자번호/생년월일</div>
                <div class="input"><input type="text" name="c_bank_number" id="c_bank_number"></div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">기본 지급 조건</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">지급 기준</div>
                <div class="input">계산서 발행 후
                    <div class="selectbox" style="width:40%">
                        <label for="c_payment_type_select" style="top:1.5px;padding:.1em .5em" id="c_payment_type_select_str">당월</label>
                        <select name="c_payment_type_select" id="c_payment_type_select" style="padding:.2em .5em">
                            <option selected value="1">당월</option>
                            <option value="2">익월</option>
                            <option value="3">익익월</option>
                            <option value="4">기타</option>
                        </select>
                    </div> 지급
                </div>
            </div>

        </div>
        <div class="modal-title">
            <div class="modal-title-text">파일 조건</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">사업자등록증 사본</div>
                <div class="input"><input type="file" name="file1" class="basic_file fileform"></div>
            </div>
            <div class="modal-field-input">
                <div class="file_name1"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">통장 사본</div>
                <div class="input"><input type="file" name="file2" class="basic_file fileform"></div>
            </div>
            <div class="modal-field-input">
                <div class="file_name2"></div>
            </div>
        </div>
        <div class="modal-button">
            <button class="btn btn-black btn-register" type="submit">등록</button>
        </div>
    </form>
</div>