
<!-- uniform 최신 jquery 오류 처리 include 파일 -->
<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="//dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<link rel='stylesheet' href="/assets/css/uniform.default.css">
<script src="/assets/js/jquery.uniform.js"></script>
<script src="/assets/js/productRegister.js?date=<?=time()?>"></script>
<div class="content">
    <h2 class="title">
        <i class="fa fa-folder-open"></i> 상품 등록
    </h2>
    <div class="content-tab">

    </div>
    <div class="search" style="margin-top:10px">
        <form name="searchForm" id="searchForm" onsubmit="return getList();">
            <div class="search1" style="width:60%">
                <label>제품군 : </label>
                <div class="search1_detail" style="display:inline-block"></div>
            </div>
            <div class="search2" style="width:39%">

                <div class="form-group ml15" style="text-align:left">

                    <select id="searchType" name="searchType" class="select2" style="width:140px">
                        <option value="pr_name" selected>상품명</option>
                        <option value="pi_name">제품군</option>
                        <option value="c_name">매입처</option>
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
                <button class="btn btn-default btn-div" type="button">분류 등록</button>
                <button class="btn btn-default ml5 btn-copy" type="button">상품 복사</button>
                <button class="btn btn-default ml5 btn-check-excel" type="button">Excel</button>
            </div>
            <div class="btn-right">
                <button class="btn btn-black btn-add btn-item-register" type="button">제품군 등록</button>
                <button class="btn btn-black btn-add btn-product-register" type="button">상품 등록</button>
            </div>
        </div>
        <div class="table-list">
            <form id="listForm" method="POST" action="/api/productExport">
            <table class="table">
                <col width="10px">
                <col width="20px">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="10%">
                <col width="50px">
                <col width="50px">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="all"></th>
                        <th>No</th>
                        <th>상품코드</th>
                        <th>제품군</th>
                        <th>상품명</th>
                        <th>대분류</th>
                        <th>소분류</th>
                        <th>기본 매입처</th>
                        <th style=";text-align:right">기본 매입가</th>
                        <th style=";text-align:right">일회성 요금</th>
                        <th style=";text-align:right">월 요금</th>
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
                <button class="btn btn-default btn-div" type="button">분류 등록</button>
                <button class="btn btn-default ml5 btn-copy" type="button">상품 복사</button>
                <button class="btn btn-default ml5 btn-check-excel" type="button">Excel</button>
            </div>
            <div class="btn-right">
                <button class="btn btn-black btn-item-register" type="button">제품군 등록</button>
                <button class="btn btn-black btn-product-register" type="button">상품 등록</button>
            </div>
        </div>
    </div>
</div>
<div id="dialogCategory" class="dialog">

    <div class="modal_search">
        <ul>
            <li>
                상품탭 설정(드래그 앤 드롭으로 순서 변경)
            </li>

        </ul>
    </div>
    <form id="categoryList">
    <div class="modal_search_list">
        <table class="table">
            <thead>
            <tr>
                <th width="50px">순서</th>
                <th width="100px">코드</th>
                <th>상품탭 명</th>
                <th width="70px">등록수</th>
                <th width="50px">수정</th>
                <th width="50px">삭제</th>
            </tr>
            </thead>
        </table>
        <div style="height:200px;overflow:auto" id="modal_category_list">

        </div>
    </div>
    </form>
    <form id="categoryAdd">
    <div class="type-add" style="margin-top:20px;margin-left:10px">
        <div class="type-add-left">
            <div style="display:inline-block">코드</div>
            <div style="display:inline-block"><input type="text" name="pc_code" id="pc_code"></div>
        </div>
        <div class="type-add-right">
            <div style="display:inline-block">상품탭 명</div>
            <div style="display:inline-block"><input type="text" name="pc_name" id="pc_name" style="vertical-align:top"><button class="btn btn-brown btn-small btn-category-add" type="submit" style="padding:5.5px 7px;margin-bottom:3px">신규 등록</button></div>
        </div>
    </div>
     </form>
    <div style="text-align:center;margin:10px auto"><button class="btn btn-black btn-category-save" type="button">저장</button> <button class="btn btn-default" onclick="$('#dialogCategory').dialog('close')" type="button">닫기</button></div>

</div>

<div id="dialogDiv" class="dialog">

    <div class="modal_search">
        <ul>
            <li>
                분류등록 - <span id="currentCategory"></span> (드래그 앤 드롭으로 순서 변경)
            </li>

        </ul>
    </div>
    <form id="divSortSub">
    <div class="modal_search_list">
        <table class="table">
            <thead>
            <tr>
                <th style="width:50px">순서</th>
                <th >분류명</th>
                <th style="width:10%"></th>
                <th style="width:10%">수정</th>
                <th style="width:10%">삭제</th>
            </tr>
            </thead>
        </table>
    </div>
    <div id="modal_div_list" style="height:200px;overflow:auto" >

    </div>
    </form>
    <form id="divAdd" method="post">
    <div class="div-add" style="margin-top:20px;margin-left:10px">

        <div class="type-add-right">
            <div style="display:inline-block"><input type="text" name="pd_name" id="pd_name" style="vertical-align:top"><button class="btn btn-brown btn-small btn-div-add" type="submit">대분류 추가</button></div>
        </div>
    </div>
    </form>
    <div style="text-align:center;margin:10px auto"><button class="btn btn-black btn-div-sub-save" type="button">저장</button> <button class="btn btn-default" onclick="$('#dialogDiv').dialog('close')">닫기</button></div>
</div>
<input type="hidden" id="start" value=1>
<input type="hidden" id="pc_seq" value="1">

