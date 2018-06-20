
<!-- uniform 최신 jquery 오류 처리 include 파일 -->
<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="//dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<link rel='stylesheet' href="/assets/css/uniform.default.css">
<script src="/assets/js/jquery.uniform.js"></script>
<script src="/assets/js/serviceRegister.js?date=<?=time()?>"></script>
<div class="content">
    <h2 class="title">
        <i class="fa fa-file"></i> 서비스 등록
    </h2>
    <div class="search">
        <form name="searchForm" id="searchForm" onsubmit="return getList();">
            <div class="search1">

                <div class="form-group">
                    <input type="checkbox" name="es_status[]" id="es_status1" value="0"> 등록
                </div>
                <div class="form-group">
                    <input type="checkbox" name="es_status[]" id="es_status2" value="1"> 신청완료
                </div>
            </div>
            <div class="search2">
                <div class="form-group">
                    <label>등록일</label>
                    <input type="text" style="width:80px" name="startDate" id="startDate" class="datepicker" value="2012-01-01"> ~ <input type="text" name="endDate" id="endDate" style="width:80px" class="datepicker" value="<?=date('Y-m-d')?>">
                </div>
                <div class="form-group ml15">
                    <div class="selectbox">
                        <label for="searchType">회원명</label>
                        <select id="searchType" name="searchType">
                            <option value="es_name" selected>회원명</option>
                            <option value="es_number">회원아이디</option>
                            <option value="es_mb_id">End User</option>
                            <option value="es_charger">계약번호</option>
                            <option value="es_tel">상품명</option>
                            <option value="es_phone">사내담당자</option>

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
                <button class="btn btn-default btn-apply" type="button">서비스 신청</button>
                <button class="btn btn-default ml5 btn-basic-price" type="button">기본 요금 체계 등록</button>
                <button class="btn btn-default ml5 btn-copy" type="button">서비스 복사</button>
                <button class="btn btn-default ml5 btn-re-copy" type="button">서비스 복사 (동일 계약 건)</button>
                <button class="btn btn-default ml5 btn-make" type="button">계약서 생성</button>
            </div>
            <div class="btn-right">
                <button class="btn btn-black btn-add" type="button">서비스 등록</button>
            </div>
        </div>
        <div class="table-list">
            <form id="listForm" method="POST" action="/api/estimateExport">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="all"></th>
                        <th>No</th>
                        <th>회원명</th>
                        <th>End User</th>
                        <th>계약번호</th>
                        <th>계약시작일</th>
                        <th>계약기간</th>
                        <th>서비스 종류</th>
                        <th>상품명</th>
                        <th>소분류</th>
                        <th>서비스 등록일</th>
                        <th>과금 시작일</th>
                        <th>결제주기</th>
                        <th>담당자</th>
                        <th>상태</th>
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
                <button class="btn btn-default btn-apply" type="button">서비스 신청</button>
                <button class="btn btn-default ml5 btn-basic-price" type="button">기본 요금 체계 등록</button>
                <button class="btn btn-default ml5 btn-copy" type="button">서비스 복사</button>
                <button class="btn btn-default ml5 btn-re-copy" type="button">서비스 복사 (동일 계약 건)</button>
                <button class="btn btn-default ml5 btn-make" type="button">계약서 생성</button>
            </div>
            <div class="btn-right">
                <button class="btn btn-black btn-add" type="button">서비스 등록</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="start" value=1>



<div id="dialogPolicy" class="dialog">
    <form name="policyForm" id="policyForm">
        <div class="modal-title">
            <div class="modal-title-text w35">요금 납부 방법 / 결제 주기 할인율</div>
        </div>
        <div class="modal-field service">
            <div class="modal-field-input full" >
                <div class="label service">서비스 등록 시 기본값</div>
                <div class="input service">
                    <div class="modal-service-left">
                        <label class="service-label"> 무통장</label>
                        <ul class="sb_add">

                        </ul>
                        <div class="btn-service-label"><img src="/assets/images/up.png" class="sbAdd"> <img src="/assets/images/down.png" class="sbMinus"></div>
                    </div>
                    <div class="modal-service-left">
                        <label class="service-label"> 카드</label>
                        <ul class="sc_add">

                        </ul>
                        <div class="btn-service-label"><img src="/assets/images/up.png" class="scAdd"> <img src="/assets/images/down.png" class="scMinus"></div>
                    </div>
                    <div class="modal-service-left" style="border-bottom:0px;padding-bottom:10px">
                        <label class="service-label"> CMS</label>
                        <ul class="cms">
                            <li><input type="text" style="width:50px" name="discount" id="discount"> % 할인 (단위 : 월) </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text w35">초기 일할 청구 설정</div>
        </div>
        <div class="modal-field service">
            <div class="modal-field-input full" >
                <div class="label service" >서비스 등록 시 기본값</div>
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
        <div class="modal-title text-center" style="padding:5px 0px">
            <div style="display:inline-block"><button class="btn btn-black btn-mail-send" type="submit">변경</button></div>
        </div>
    </form>
    <form name="fileMailUpload" id="fileMailUpload" method="post">
        <input type="hidden" name="em_es_seq" id="em_es_seq">
        <input type="file" name="em_file[]" id="em_file" style="border:0;display:none;width:0;height:0" multiple visbility="hidden">
    </form>
</div>

<div id="dialogFile" class="dialog">
    <form name="fileForm" id="fileForm" method="post" action="/api/estimateBasicFileAdd" enctype="multipart/form-data">


    <div class="modal-field">
        <div class="modal-field-input" style="width:60%">
            <div class="label">첨부파일1</div>
            <div class="input"><input type="file" name="basic_file[]" class="basic_file fileform"></div>
            <input type="hidden" name="bf_sort[]" id="bf_sort1" value="1" class="bf_sort">
        </div>
        <div class="modal-field-input" style="width:38%">
            <div class="file_name1"></div>
            <input type="hidden" name="bf_seq[]" id="bf_seq1" value="" class="bf_seq">
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input" style="width:60%">
            <div class="label">첨부파일2</div>
            <div class="input"><input type="file" name="basic_file[]" class="basic_file fileform"></div>
            <input type="hidden" name="bf_sort[]" id="bf_sort2" value="2" class="bf_sort">
        </div>
        <div class="modal-field-input" style="width:38%">
            <div class="file_name2"></div>
            <input type="hidden" name="bf_seq[]" id="bf_seq2" value="" class="bf_seq">
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input" style="width:60%">
            <div class="label">첨부파일3</div>
            <div class="input"><input type="file" name="basic_file[]" class="basic_file fileform"></div>
            <input type="hidden" name="bf_sort[]" id="bf_sort3" value="3" class="bf_sort">
        </div>
        <div class="modal-field-input" style="width:38%">
            <div class="file_name3"></div>
            <input type="hidden" name="bf_seq[]" id="bf_seq3" value="" class="bf_seq">
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input" style="width:60%">
            <div class="label">첨부파일4</div>
            <div class="input"><input type="file" name="basic_file[]" class="basic_file fileform"></div>
            <input type="hidden" name="bf_sort[]" id="bf_sort4" value="4" class="bf_sort">
        </div>
        <div class="modal-field-input" style="width:38%">
            <div class="file_name3"></div>
            <input type="hidden" name="bf_seq[]" id="bf_seq4" value="" class="bf_seq">
        </div>
    </div>
    </form>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label"><img src="/assets/images/up.png" class="basicFileAdd"> <img src="/assets/images/down.png" class="basicFileMinus"></div>
        </div>
    </div>
    <div class="modal-button">
        <button class="btn btn-black btn-file-register" type="button">저장</button>
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

<div id="dialogMailPreview" class="dialog" style="padding:5px">

    <div class="modal_search">
        <ul>
            <li>
                Mail 미리보기
            </li>

        </ul>
    </div>

    <div id="preview_content">

    </div>
    <div class="modal-close-btn"><button class="btn btn-black btn-small" onclick="$('#dialogMailPreview').dialog('close')">닫기</button></div>
</div>