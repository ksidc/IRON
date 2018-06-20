
<!-- uniform 최신 jquery 오류 처리 include 파일 -->
<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="//dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<link rel='stylesheet' href="/assets/css/uniform.default.css">
<script src="/assets/js/jquery.uniform.js"></script>
<script src="/assets/js/service.js?date=<?=time()?>"></script>
<div class="content">
    <h2 class="title">
        <i class="fa fa-file"></i> 서비스 관리
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

