
<script src="/assets/js/setting.js?date=<?=time()?>"></script>
<div class="content">
    <h2 class="title">
        <i class="fa fa-folder-open"></i> 분류 및 END User 관리
    </h2>
    <div style="float:left;background-color:#fff;border:1px solid #ddd;padding:5px">
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
    </div>
    <div style="float:left;background-color:#fff;border:1px solid #ddd;margin-left:10px;padding:5px">
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
    </div>
</div>
<input type="hidden" id="start" value=1>

