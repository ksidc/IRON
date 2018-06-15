
<!-- uniform 최신 jquery 오류 처리 include 파일 -->
<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="//dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<link rel='stylesheet' href="/assets/css/uniform.default.css">
<script src="/assets/js/jquery.uniform.js"></script>
<script src="/assets/js/productItem.js?date=<?=time()?>"></script>
<div style="background:#fff;width:100%;padding:0px">
    <div class="modal_search">
        <ul>
            <li>
                제품군 등록 - <span id="currentCategory"><?=$pc_name["pc_name"]?></span> (드래그 앤 드롭으로 순서 변경)
            </li>

        </ul>
    </div>
    <div class="list" style="padding:0px 10px">
        <form id="topItemAdd">
        <div class="div-add" style="margin-top:10px;margin-left:3px">

            <div class="type-add-right">
                <div style="display:inline-block"><input type="text" class="pi_name" name="pi_name" id="top_pi_name" style="vertical-align:top"><button class="btn btn-brown btn-small btn-item-add" type="submit" style="padding:5.5px 7px;margin-bottom:3px">제품군 추가</button></div>
            </div>
        </div>
        </form>
        <div class="table-list" style="height:400px">
            <form id="listForm" method="POST" >
            <table class="table" >
                <thead>
                    <tr>
                        <th style="width:50px">순서</th>
                        <th >제품군 명</th>
                        <th style="width:15%">부가항목</th>
                        <th style="width:15%">부가항목 매입처</th>
                        <th style="width:5%"></th>
                        <th style="width:10%">수정</th>
                        <th style="width:10%">삭제</th>
                    </tr>
                </thead>
                <tbody id="tbody-list">

                </tbody>
            </table>
            </form>
            <div class="pagination-html">

            </div>
        </div>
        <form id="footerItemAdd">
        <div class="div-add" style="margin-top:10px;margin-left:3px;padding-bottom:10px">

            <div class="type-add-right">
                <div style="display:inline-block"><input type="text" class="pi_name" name="pi_name" id="footer_pi_name" style="vertical-align:top"><button class="btn btn-brown btn-small btn-item-add" type="submit" style="padding:5.5px 7px;margin-bottom:3px">제품군 추가</button></div>
            </div>
        </div>
    </form>
    </div>
</div>
<div style="text-align:center;margin:15px auto 5px auto"><button class="btn btn-black btn-item-sub-save" type="button">저장</button> <button class="btn btn-default" onclick="self.close()">닫기</button></div>
<input type="hidden" id="start" value=1>
<input type="hidden" id="pc_seq" value="<?=$pc_seq?>">

