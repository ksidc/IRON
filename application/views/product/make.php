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
<!-- uniform 최신 jquery 오류 처리 include 파일 -->
<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="//dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<link rel='stylesheet' href="/assets/css/uniform.default.css">
<script src="/assets/js/jquery.uniform.js"></script>
<script src="/assets/js/product.js?date=<?=time()?>"></script>
<div style="background:#fff;width:100%;overflow-x:hidden">
    <div class="popup_title" style="padding:10px">

        <?php if($info["pr_seq"] == ""): ?>
        상품등록 - <span id="currentCategory"><?=$pc_name?></span>
        <?php else: ?>
        상품수정 - <span id="currentCategory"><?=$pc_name?></span>
        <?php endif; ?>

    </div>
    <div style="padding:5px">
        <form id="registerForm" method="post" action="/api/productUpdate/<?=$info["pr_seq"]?>">
            <input type="hidden" name="pr_seq" id="pr_seq" value="<?=$info["pr_seq"]?>">
            <input type="hidden" name="pr_pi_seq" id="pr_pi_seq" value="<?=$info["pr_pi_seq"]?>">
            <input type="hidden" name="pr_c_seq" id="pr_c_seq" value="<?=$info["pr_c_seq"]?>">
            <input type="hidden" name="pr_pc_seq" id="pc_seq" value="<?=$pc_seq?>">

            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block;width:20%">기본 정보</div>
                <div style="display:inline-block;backround:#fff;width:77%">
                    <div class="label padd" style="display:inline-block"><div>상품 코드</div></div>
                    <div class="input padd"  style="display:inline-block;"><input type="text" name="pr_code" id="pr_code" style="border:1px solid #ddd" value="<?=$info["pr_code"]?>"></div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label padd"><div>제품군</div></div>
                    <div class="input padd"><input type="text" class="width-button" name="pr_pi_seq_str" id="pr_pi_seq_str" value="<?=$info["pi_name"]?>"><button class="btn btn-brown btn-small btn-item-search" type="button" >검색</button></div>
                </div>
                <div class="modal-field-input">
                    <div class="label padd"><div>기본 매입처</div></div>
                    <div class="input padd"><input type="text" class="width-button" name="pr_c_seq_str" id="pr_c_seq_str" value="<?=$info["c_name"]?>"><button class="btn btn-brown btn-small btn-client-search" type="button" >검색</button></div>
                </div>
            </div>
              <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label padd"><div>부가항목</div></div>
                    <div class="input padd" id="addOption">제품군을 선택하면 제품군 등록 시 설정한 부가항목이 표시됩니다. 부가항목은 서비스 등록 시 옵션으로 설정할 수 있습니다.</div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    <div class="label padd"><div>상품명</div></div>
                    <div class="input padd"><input type="text" name="pr_name" id="pr_name" style="width:20%" value="<?=$info["pr_name"]?>"> <b style="color:red">중복 등록 방지</b>를 위해 이미 등록된 유사한 상품이 있는 지 확인 후 등록하세요</div>
                </div>

            </div>
            <div class="modal-field">
                <div class="modal-field-input full">
                    상품명 등록 예시 : FortiGate 100E, WAPPLES 1000, DeepFinder, DeepFinder 관제, Dell R640
                </div>
                <div class="modal-field-input full" style="padding-top:3px">
                    상품명 등록 시 주의사항 : 상품별 통계를 위해 대표 Full Name으로 설정 (등록할 상품명 규칙 사전 정의 후 작성)
                </div>
            </div>
            <div class="modal-title">
                <div class="modal-title-text" style="display:inline-block">분류 정보</div>
                <div style="float:right;padding-top:5px;padding-right:5px">

                    VAT 별도
                </div>
            </div>
            <div class="modal-title" style="height:318px;background:#fff">
                <table class="table">
                <thead>
                    <tr>
                        <th>구분</th>
                        <th>분류 명</th>
                        <th>기본 매입가 <i class="fas fa-info-circle" title="등록 상품에 대한 기본 매입가이며 서비스 등록 시 기본으로 불러옵니다.<br>서비스 등록 시 서비스 건 별로 수정할 수 있습니다." rel="tooltip"></i></th>
                        <th>매입 단위 <i class="fas fa-info-circle" title="등록 상품에 대한 기본 매입단위이며 서비스 등록 시 기본으로 불러옵니다.<br>서비스 등록 시 서비스 건 별로 수정할 수 있습니다." rel="tooltip"></i></th>
                        <th>일회성 요금 <i class="fas fa-info-circle" title="등록 상품에 대한 분류별 초기 청구 요금(구매, 설치비 등)입니다.<br>서비스 등록 시 서비스 건 별로 수정할 수 있습니다." rel="tooltip"></i></th>
                        <th>월 요금 <i class="fas fa-info-circle" title="등록 상품에 대한 분류별 월 청구 요금입니다.<br>서비스 등록 시 서비스 건 별로 수정할 수 있습니다." rel="tooltip"></i></th>
                        <th>사용 구분 <i class="fas fa-info-circle" title="분류 등록으로 등록된 소분류 항목에 대해서<br>등록 상품에 적용할 지 여부를 선택할 수 있습니다." rel="tooltip"></i></th>
                        <th>비고 </th>
                    </tr>
                </thead>
                <tbody>
                    <?=$table_data?>
                </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
<div style="text-align:center;margin:10px auto"><button class="btn btn-black btn-product-save"><?=$btn_name?></button> <button class="btn btn-default" onclick="self.close()">닫기</button></div>
<div id="dialogItemSearch" class="dialog">
    <form name="itemSearchForm" id="itemSearchForm" method="get">
        <input type="hidden" name="searchType" value="pi_name">
    <div class="modal_search">
        <ul>
            <li>
                제품군 명
            </li>
            <li >
                <input type="text" name="searchWord" id="itemSearchWord" style="vertical-align:top"><button class="btn btn-brown btn-small btn-search-item" type="submit" style="padding:5.5px 7px;margin-bottom:3px">검색</button>
            </li>
        </ul>
    </div>
    </form>
    <div class="modal_search_list" style="height:200px;overflow:auto">
        <table class="table">
            <thead>
            <tr>
                <th>제품군명</th>

            </tr>
            </thead>
            <tbody style="height:200px" id="modalSearchItem">

            </tbody>
        </table>
    </div>

    <div style="text-align:center"><button class="btn btn-black" onclick="$('#dialogItemSearch').dialog('close')">닫기</button></div>
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
    <div class="modal_search_list" style="height:200px;overflow:auto">
        <table class="table">
            <thead>
            <tr>
                <th>코드</th>
                <th>매입처 명</th>
            </tr>
            </thead>
            <tbody style="height:200px" id="modalSearchClient">

            </tbody>
        </table>
    </div>

    <div style="text-align:center"><button class="btn btn-black" onclick="$('#dialogClientSearch').dialog('close')">닫기</button></div>
</div>
<input type="hidden" id="start" value=1>


