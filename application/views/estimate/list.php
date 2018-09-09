<script>
var category = '<?=json_encode($category)?>';
</script>
<!-- uniform 최신 jquery 오류 처리 include 파일 -->
<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="//dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<link rel='stylesheet' href="/assets/css/uniform.default.css">
<script src="/assets/js/jquery.uniform.js"></script>
<script src="/assets/js/estimateList.js?date=<?=time()?>"></script>
<div class="content">
    <h2 class="title">
        <i class="fa fa-file"></i> 견적 관리
    </h2>
    <div class="search">
        <form name="searchForm" id="searchForm" onsubmit="return getList();">
            <div class="search1">
                <div class="form-group">

                        <select id="searchDepth1" name="searchDepth1" class="select2" style="width:140px">
                            <option value="" selected>서비스 종류 선택</option>
                            <?php foreach($category as $row): ?>
                            <option value="<?=$row["pc_seq"]?>"><?=$row["pc_name"]?></option>
                            <?php endforeach; ?>
                        </select>

                </div>
                <div class="form-group">

                    <select id="searchDepth2" name="searchDepth2" class="select2" style="width:140px">
                        <option value="">상품명 선택</option>
                    </select>

                </div>
                <div class="form-group">
                    <input type="checkbox" name="es_status[]" id="es_status1" value="0"> <span style="color:#0070C0">등록</span>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="es_status[]" id="es_status2" value="1"> <span style="color:#FF0000">신청완료</span>
                </div>
            </div>
            <div class="search2">
                <div class="form-group">
                    <label>등록일</label>
                    <input type="text" style="width:80px" name="startDate" id="startDate" class="datepicker" value="2012-01-01"> ~ <input type="text" name="endDate" id="endDate" style="width:80px" class="datepicker" value="<?=date('Y-m-d')?>">
                </div>
                <div class="form-group ml15" style="text-align:left">

                    <select id="searchType" name="searchType" class="select2" style="width:140px">
                        <option value="es_name" selected>상호/이름</option>
                        <option value="es_number">견적번호</option>
                        <option value="es_mb_id">회원아이디</option>
                        <option value="es_charger">담당자</option>
                        <option value="es_tel">전화번호</option>
                        <option value="es_phone">휴대폰번호</option>
                        <option value="es_email">이메일</option>
                        <option value="es_register">등록자</option>
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
                <button class="btn btn-default btn-basic-setting" type="button">기본 첨부 파일 설정</button>
                <button class="btn btn-default ml5 btn-send-mail" type="button">견적 메일 발송</button>
                <button class="btn btn-default ml5 btn-copy" type="button">견적 복사</button>
                <button class="btn btn-default ml5 btn-re-copy" type="button">재견적 복사</button>
                <button class="btn btn-default ml5 btn-success-register" type="button">신청 성공 등록</button>
                <button class="btn btn-default ml5 btn-check-excel" type="button">Excel</button>
            </div>
            <div class="btn-right">
                <button class="btn btn-black btn-add" type="button">견적 등록</button>
            </div>
        </div>
        <div class="table-list">
            <form id="listForm" method="POST" action="/api/estimateExport">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="all"></th>
                        <th>No</th>
                        <th>견적번호</th>
                        <th>상호/이름(ID)</th>
                        <th>서비스 종류</th>
                        <th>상품명</th>
                        <th>견적요약</th>
                        <th>담당자</th>
                        <th>연락처</th>
                        <th>이메일</th>
                        <th>등록자</th>
                        <th>등록일</th>
                        <th>상태</th>
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
                <button class="btn btn-default btn-basic-setting" type="button">기본 첨부 파일 설정</button>
                <button class="btn btn-default ml5 btn-send-mail" type="button">견적 메일 발송</button>
                <button class="btn btn-default ml5 btn-copy" type="button">견적 복사</button>
                <button class="btn btn-default ml5 btn-re-copy" type="button">재견적 복사</button>
                <button class="btn btn-default ml5 btn-success-register" type="button">신청 성공 등록</button>
                <button class="btn btn-default ml5 btn-check-excel" type="button">Excel</button>
            </div>
            <div class="btn-right">
                <button class="btn btn-black btn-add" type="button">견적 등록</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="start" value=1>

<div id="dialog" class="dialog">
    <form name="registerForm" id="registerForm" method="post" action="/api/estimateAdd">
        <input type="hidden" name="es_seq" id="es_seq">
        <input type="hidden" name="es_mb_seq" id="es_mb_seq">
        <input type="hidden" name="dupleNumberYn" id="dupleNumberYn" value="">
        <input type="hidden" name="b_es_number" id="b_es_number">
        <div class="modal-title">
            <div class="modal-title-text">등록자 정보</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>부서</div></div>
                <div class="input padd">
                    <select id="es_part" name="es_part" class="select2" style="width:140px">
                        <option value="영업팀" selected>영업팀</option>
                        <option value="기술팀">기술팀</option>
                    </select>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>등록자</div></div>
                <div class="input padd">
                    <select id="es_register" name="es_register" class="select2" style="width:140px">
                        <option value="김지훈" selected>김지훈</option>
                        <option value="노성민">노성민</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>상태</div></div>
                <div class="input padd">
                    <select id="es_status" name="es_status" class="select2" style="width:140px">
                        <option value="0" selected>등록</option>
                        <option value="1">신청완료</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="modal-title">
            <div class="modal-title-text" style="display:inline-block;width:20%">고객 정보</div>
            <div style="display:inline-block;background:#fff;width:77%">
                <div class="label padd" style="display:inline-block"><div>회원 아이디</div></div>
                <div class="input padd"  style="display:inline-block;"><input type="text" name="mb_id" id="mb_id" style="border:1px solid #ddd;" readonly></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>상호/이름</div></div>
                <div class="input padd"><input type="text" class="width-button" name="es_name" id="es_name"><button class="btn btn-brown btn-small" type="button" onclick='$( "#dialogUserSearch" ).dialog("open");$("#dialogUserSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button></div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>담당자</div></div>
                <div class="input padd"><input type="text" name="es_charger" id="es_charger"></div>
            </div>
        </div>
          <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>전화번호(-포함)</div></div>
                <div class="input padd"><input type="text" name="es_tel" id="es_tel"></div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>휴대폰번호(-포함)</div></div>
                <div class="input padd"><input type="text" name="es_phone" id="es_phone"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>이메일</div></div>
                <div class="input padd"><input type="text" name="es_email" id="es_email" class="emailCheck"></div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>팩스(-포함)</div></div>
                <div class="input padd"><input type="text" name="es_fax" id="es_fax"></div>
            </div>
        </div>
        <div class="modal-field company">
            <div class="modal-field-input">
                <div class="label padd"><div>신규/기존</div></div>
                <div class="input padd">
                    <select id="es_type" name="es_type" class="select2" style="width:140px">
                        <option value="0" selected>신규</option>
                        <option value="1">기존</option>
                    </select>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>업체 분류</div></div>
                <input type="hidden" name="es_company_type" id="es_company_type">
                <div class="input padd"><input type="text" class="width-button" name="es_company_type_name" id="es_company_type_name" readonly><button class="btn btn-brown btn-small" type="button" onclick='typeGetList();$( "#dialogTypeSearch" ).dialog("open");$("#dialogTypeSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button></div>
            </div>
        </div>
        <div class="modal-title">
            <div class="modal-title-text" style="display:inline-block;width:20%">견적정보</div>
            <div style="display:inline-block;width:77%;background:#fff">
                <div class="label padd" style="display:inline-block"><div>견적번호</div></div>
                <div class="input padd" style="display:inline-block"><input type="text" name="es_number1" id="es_number1" style="width:30%;border:1px solid #ddd;"> - <input type="text" name="es_number2" id="es_number2" style="width:20%;border:1px solid #ddd;"> <button class="btn btn-brown btn-small btn-number-duple" type="button">중복확인</button></div>
            </div>
        </div>
        <div class="modal-field depth-area">
            <div class="depth-item">
                <div class="modal-field-input">
                    <div class="label padd"><div>서비스 종류</div></div>
                    <div class="input padd">
                        <input type="hidden" name="ed_seq[]" value="">

                        <select id="es_depth1_1" name="es_depth1[]" class="es_depth1 select2" data-index="1" data-childvalue="" style="width:140px">
                            <option value="" selected>서비스 종류 선택</option>
                            <?php foreach($category as $row): ?>
                            <option value="<?=$row["pc_seq"]?>"><?=$row["pc_name"]?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label padd"><div>상품명</div></div>
                    <div class="input padd">

                        <select id="es_depth2_1" name="es_depth2[]" class="select2" style="width:140px">
                            <option value="" selected>상품명 선택</option>

                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label"><img src="/assets/images/up.png" class="depthAdd"> <img src="/assets/images/down.png" class="depthMinus"></div>

            </div>

        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>견적요약</div></div>
                <div class="input padd"><input type="text"  name="es_shot" id="es_shot"></div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>END User</div></div>
                <input type="hidden" name="es_end_user" id="es_end_user">
                <div class="input padd"><input type="text" name="es_end_user_name" id="es_end_user_name" class="width-button" readonly><button class="btn btn-brown btn-small" type="button" onclick='getEndUserNextNumber();$( "#dialogEndSearch" ).dialog("open");$("#dialogEndSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();'>검색</button></div>
            </div>
        </div>

        <div class="modal-field">
            <div class="modal-field-input full">
                <div class="label padd" style="vertical-align:top"><div>메모</div></div>
                <div class="input padd" style="width:75%"><textarea name="es_memo" id="es_memo" style="width:100%;height:100px"></textarea></div>
            </div>

        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>건적서 첨부</div></div>
                <div class="input padd"><button class="btn btn-black" type="button" onclick="$('#es_file').trigger('click')">찾아보기</button></div>

            </div>
        </div>
        <div class="upload-item">

        </div>
        <div class="modal-button">
            <button class="btn btn-black btn-register" type="submit">등록</button>
        </div>
    </form>
    <form name="fileTmpUpload" id="fileTmpUpload" method="post">
        <input type="hidden" name="ef_es_code" id="ef_es_code">
        <input type="hidden" name="ef_sessionkey" id="ef_sessionkey" value="<?=session_id()?>">
        <input type="file" name="es_file[]" id="es_file" style="border:0;display:none;width:0;height:0" multiple visbility="hidden">
    </form>
</div>

<div id="dialogEmail" class="dialog">
    <form name="emailForm" id="emailForm">
        <input type="hidden" name="content" id="content">
        <div class="modal-title text-center" style="padding:5px 0px">
            <div style="display:inline-block"><button class="btn btn-black btn-mail-send" type="submit">보내기</button></div>
            <div style="display:inline-block"><button class="btn btn-default btn-mail-view" type="button">미리보기</button></div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full">
                <div class="label padd"><div>보내는 사람</div></div>
                <div class="input padd"><input type="text" name="from" id="from"></div>
            </div>

        </div>
        <div class="modal-field">
            <div class="modal-field-input full" >
                <div class="label padd"><div>받는 사람</div></div>
                <div class="input padd"><input type="text" name="to" id="to"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full" >
                <div class="label padd"><div>휴대폰번호</div></div>
                <div class="input padd"><input type="text" name="phone" id="phone"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full" >
                <div class="label padd"><div><input type="checkbox" name="sms_yn" id="sms_yn" value="Y"> SMS 발송 | 내용</div></div>
                <div class="input padd"><input type="text" name="sms" id="sms" style="width:70%" > <span class="bytes">0</span>byte / 80byte</div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full" >
                <div class="label padd"><div>제목</div></div>
                <div class="input padd"><input type="text" name="subject" id="subject"></div>
            </div>
        </div>

        <div class="modal-title">
            <div class="modal-title-text">메일 내용</div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input full" style="width:99%">
                <!-- <textarea style="width:90%;height:200px" name="content" id="content"></textarea> -->
                <div id="summernote"></div>

            </div>

        </div>
        <div class="modal-title">
            <div class="modal-title-text" style="display:inline-block">첨부 파일</div>
            <div style="float:right;padding-top:5px;padding-right:5px">

                <div class="input">파일 <span id="attachedCnt"></span>개 | 용량 <span id="attachedSize"></span> / 20MB</div>
            </div>
        </div>
        <div class="modal-field" style="border-top:2px solid #ddd">
            <div class="modal-field-input full">
                <div class="label padd"><div>견적서</div></div>
                <div class="input es_file padd">

                </div>
            </div>
        </div>
        <div class="modal-field" style="border-top:2px solid #ddd">
            <div class="modal-field-input">
                <div class="label padd" style="vertical-align:top"><div>기본 첨부 파일 리스트</div></div>
                <div class="input es_basic_file padd">

                </div>
            </div>
        </div>
        <div class="modal-field" style="border-top:2px solid #ddd">
            <div class="modal-field-input full">
                <div class="label padd" style="vertical-align:top"><div>추가 첨부 파일</div></div>
                <div class="input padd">
                    <div>
                        <button class="btn btn-default" type="button" onclick="$('#em_file').trigger('click')">추가</button>
                        <button class="btn btn-default btn-addfile-delete" type="button">삭제</button>
                    </div>
                    <div id="mail_add_file" style="padding-left:53px;padding-top:10px">

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-title text-center" style="padding:5px 0px;margin-top:10px">
            <div style="display:inline-block"><button class="btn btn-black btn-mail-send" type="submit">보내기</button></div>
            <div style="display:inline-block"><button class="btn btn-default btn-mail-view" type="button">미리보기</button></div>
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
            <div class="label padd"><div>첨부파일1</div></div>
            <div class="input padd"><input type="file" name="basic_file[]" class="basic_file fileform"></div>
            <input type="hidden" name="bf_sort[]" id="bf_sort1" value="1" class="bf_sort">
        </div>
        <div class="modal-field-input" style="width:38%">
            <div class="file_name1"></div>
            <input type="hidden" name="bf_seq[]" id="bf_seq1" value="" class="bf_seq">
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input" style="width:60%">
            <div class="label padd"><div>첨부파일2</div></div>
            <div class="input padd"><input type="file" name="basic_file[]" class="basic_file fileform"></div>
            <input type="hidden" name="bf_sort[]" id="bf_sort2" value="2" class="bf_sort">
        </div>
        <div class="modal-field-input" style="width:38%">
            <div class="file_name2"></div>
            <input type="hidden" name="bf_seq[]" id="bf_seq2" value="" class="bf_seq">
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input" style="width:60%">
            <div class="label padd"><div>첨부파일3</div></div>
            <div class="input padd"><input type="file" name="basic_file[]" class="basic_file fileform"></div>
            <input type="hidden" name="bf_sort[]" id="bf_sort3" value="3" class="bf_sort">
        </div>
        <div class="modal-field-input" style="width:38%">
            <div class="file_name3"></div>
            <input type="hidden" name="bf_seq[]" id="bf_seq3" value="" class="bf_seq">
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input" style="width:60%">
            <div class="label padd"><div>첨부파일4</div></div>
            <div class="input padd"><input type="file" name="basic_file[]" class="basic_file fileform"></div>
            <input type="hidden" name="bf_sort[]" id="bf_sort4" value="4" class="bf_sort">
        </div>
        <div class="modal-field-input" style="width:38%">
            <div class="file_name4"></div>
            <input type="hidden" name="bf_seq[]" id="bf_seq4" value="" class="bf_seq">
        </div>
    </div>
    </form>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label padd"><div><img src="/assets/images/up.png" class="basicFileAdd"> <img src="/assets/images/down.png" class="basicFileMinus"></div></div>
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
    <div class="modal_search_list" style="height:300px;overflow:auto">
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