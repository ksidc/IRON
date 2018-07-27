<style>
.basic {display:none;}
.payment {display:none;}
</style>
<script src="/assets/js/setting.js?date=<?=time()?>"></script>
<div class="content">
    <div style="border:1px solid #eee;background:#fff;border-radius:6px;height:450px;margin-top:20px">
        <form id="update1">
            <input type="hidden" name="mb_seq" value="<?=$info["mb_seq"]?>">
        <div class="header-title" style="padding:10px;background:#ddd;height:25px">
            <div style="float:left">회원정보</div>
            <div style="float:right"><i class="fa fa-edit" onclick="memberUpdate1()"></i> <i class=""></i></div>
        </div>
        <div class="view-body" style="clear:both;width:100%">
            <div style="width:33.3%;float:left;">
                <div style="width:100%">
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">회원구분</div>
                            <div class="input">
                                <select name="mb_type" id="mb_type" class="select2" style="width:90%">
                                    <option value="0" <?=($info["mb_type"] == "0" ? "selected":"")?>>사업자</option>
                                    <option value="1" <?=($info["mb_type"] == "1" ? "selected":"")?>>개인</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">상호/이름</div>
                            <div class="input">
                                <input type="text" name="mb_name" id="mb_name" class="width-button" value="<?=$info["mb_name"]?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">거래처 코드</div>
                            <div class="input">
                                <input type="text" class="width-button" name="" id="" readonly><button class="btn btn-brown " type="button" >거래처 등록</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">회원 아이디(코드)</div>
                            <div class="input">
                                <?=$info["mb_id"]?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">주소</div>
                            <div class="input">
                                <input type="text" class="width-button" name="mb_zipcode" id="mb_zipcode" readonly value="<?=$info["mb_zipcode"]?>"><button class="btn btn-brown " type="button" onclick="daumApi()">검색</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label"></div>
                            <div class="input">
                                <input type="text" class="width-button" name="mb_address" id="mb_address" readonly value="<?=$info["mb_address"]?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label"></div>
                            <div class="input">
                                <input type="text" class="width-button" name="mb_detail_address" id="mb_detail_address" value="<?=$info["mb_detail_address"]?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">전화번호</div>
                            <div class="input">
                                <input type="text" class="width-button" name="mb_tel" id="mb_tel" value="<?=$info["mb_tel"]?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">이메일</div>
                            <div class="input">
                                <input type="text" name="mb_email" id="mb_email" class="width-button" value="<?=$info["mb_email"]?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">수신동의</div>
                            <div class="input">
                                <input type="checkbox" name="emailYn" value="Y"> 이메일 <input type="checkbox" name="smsYn" value="N"> SMS
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="width:33.3%;float:left">
                <div style="width:100%">
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">등급</div>
                            <div class="input">
                                <select name="" id="" class="select2" style="width:90%">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">사업자번호/생년월일</div>
                            <div class="input">
                                <input type="text" class="width-button" name="mb_number" id="mb_number" value="<?=$info["mb_number"]?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">대표자</div>
                            <div class="input">
                                <input type="text" name="mb_ceo" id="mb_ceo" class="width-button" value="<?=$info["mb_ceo"]?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">패스워드</div>
                            <div class="input">
                                <button class="btn btn-brown " type="button" >임시 패스워드 발급</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">주소(영문)</div>
                            <div class="input">
                                <input type="text" class="width-button" name="zipcode_eng" id="zipcode_eng" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label"></div>
                            <div class="input">
                                <input type="text" class="width-button" name="mb_address_eng" id="mb_address_eng">
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label"></div>
                            <div class="input">
                                <input type="text" class="width-button" name="mb_detail_address_eng" id="mb_detail_address_eng" >
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">휴대폰번호</div>
                            <div class="input">
                                <input type="text" name="mb_phone" id="mb_phone" class="width-button" value="<?=$info["mb_phone"]?>"> <input type="checkbox">
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">팩스</div>
                            <div class="input">
                                <input type="text" name="mb_fax" id="mb_fax" class="width-button" value="<?=$info["mb_fax"]?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">알게된 경로</div>
                            <div class="input">
                                <select name="" id="" class="select2" style="width:90%">
                                    <option value="1" selected>주위소개</option>
                                    <option value="2">2</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="width:33.3%;float:left">
                <div style="width:100%">
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">회원가입일</div>
                            <div class="input">
                                <?=$info["mb_regdate"]?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">최근 접속일</div>
                            <div class="input">
                                0000-00-00 00:00:00
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">최근 접속 IP</div>
                            <div class="input">
                                111.111.111.111
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label">인증 구분</div>
                            <div class="input">
                                (향후연동)
                            </div>
                        </div>
                    </div>
                    <div class="modal-field">
                        <div class="modal-field-input full">
                            <div class="label" style="vertical-align:top">메모</div>
                            <div class="input">
                                <textarea name="memo" style="width:90%;height:200px"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </form>
    </div>
    <div style="width:66%;float:left;border:1px solid #eee;background:#fff;border-radius:6px;height:170px;margin-top:20px" >
        <form id="update3">
            <input type="hidden" name="mb_seq" value="<?=$info["mb_seq"]?>">
        <div class="header-title" style="padding:10px;background:#ddd;height:25px">
            <div style="float:left">회원 계좌 정보</div>
            <div style="float:right"><i class="fa fa-edit" onclick="memberUpdate2()"></i> <i class=""></i></div>
        </div>
        <div class="view-body" style="clear:both;width:100%">

            <div style="width:100%">
                <div class="modal-field">
                    <div class="modal-field-input" style="width:33%">
                        <div class="label">은행명</div>
                        <div class="input">
                            <input type="text" name="mb_bank" id="mb_bank" value="<?=$info["mb_bank"]?>">
                        </div>
                    </div>
                    <div class="modal-field-input" style="width:33%">
                        <div class="label">예금주</div>
                        <div class="input">
                            <input type="text" style="width:38.7%" name="mb_bank_name" id="mb_bank_name" value="<?=$info["mb_bank_name"]?>">
                        </div>
                    </div>
                    <div class="modal-field-input" style="width:33%">
                        <div class="label">예금주와의 관계</div>
                        <div class="input">
                            <input type="text" style="width:30%" name="mb_bank_name_relationship" id="mb_bank_name_relationship" value="<?=$info["mb_bank_name_relationship"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input">
                        <div class="label">계좌번호(-포함)</div>
                        <div class="input">
                            <input type="text" name="mb_bank_input_number" id="mb_bank_input_number" value="<?=$info["mb_bank_input_number"]?>">
                        </div>
                    </div>
                    <div class="modal-field-input">
                        <div class="label">사업자번호/생년월일</div>
                        <div class="input">
                            <input type="text" name="mb_bank_number" id="mb_bank_number" value="<?=$info["mb_bank_number"]?>">
                        </div>
                    </div>
                </div>

            </div>

        </div>
        </form>
    </div>
    <div style="width:33.3%;float:right;border:1px solid #eee;background:#fff;border-radius:6px;height:170px;margin-top:20px">
        <form id="update3">
            <input type="hidden" name="mb_seq" value="<?=$info["mb_seq"]?>">
        <div class="header-title" style="padding:10px;background:#ddd;height:25px">
            <div style="float:left">결제 계좌 정보</div>
            <div style="float:right"><i class="fa fa-edit" onclick="memberUpdate3()"></i> <i class=""></i></div>
        </div>
        <div class="view-body" style="clear:both;width:100%">

            <div style="width:100%">
                <div class="modal-field">
                    <div class="modal-field-input">
                        <div class="label">은행명</div>
                        <div class="input" style="width:59%">
                            <input type="text" class="width-button" name="mb_name" id="mb_name">
                        </div>
                    </div>
                    <div class="modal-field-input">
                        <div class="label">예금주</div>
                        <div class="input" style="width:59%">
                            <input type="text" class="width-button" name="mb_name" id="mb_name" readonly>
                        </div>
                    </div>

                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">계좌번호(-포함)</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_name" id="mb_name" readonly>
                        </div>
                    </div>

                </div>

            </div>

        </div>
        </form>
    </div>
    <div style="width:33.1%;float:left;border:1px solid #eee;background:#fff;border-radius:6px;height:300px;margin-top:20px">
        <form id="update4">
            <input type="hidden" name="mb_seq" value="<?=$info["mb_seq"]?>">
        <div class="header-title" style="padding:10px;background:#ddd;height:25px">
            <div style="float:left">계약 담당자</div>
            <div style="float:right"><i class="fa fa-edit" onclick="memberUpdate4()"></i> <i class=""></i></div>
        </div>
        <div class="view-body" style="clear:both;width:100%">

            <div style="width:100%">
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">이름</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_contract_name" id="mb_contract_name" value="<?=$info["mb_contract_name"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">이메일</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_contract_email" id="mb_contract_email" value="<?=$info["mb_contract_email"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">부서</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_contract_team" id="mb_contract_team" value="<?=$info["mb_contract_team"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">직위/직책</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_contract_position" id="mb_contract_position" value="<?=$info["mb_contract_position"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">휴대폰번호</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_contract_phone" id="mb_contract_phone" value="<?=$info["mb_contract_phone"]?>">
                        </div>
                    </div>
                </div>

                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">전화번호</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_contract_tel" id="mb_contract_tel" value="<?=$info["mb_contract_tel"]?>">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </form>
    </div>
    <div style="width:33.1%;float:left;border:1px solid #eee;background:#fff;border-radius:6px;height:300px;margin-top:20px">
        <form id="update5">
            <input type="hidden" name="mb_seq" value="<?=$info["mb_seq"]?>">
        <div class="header-title" style="padding:10px;background:#ddd;height:25px">
            <div style="float:left" >운영 담당자</div>
            <div style="float:right"><i class="fa fa-edit" onclick="memberUpdate5()"></i> <i class=""></i></div>
        </div>
        <div class="view-body" style="clear:both;width:100%">

            <div style="width:100%">
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">이름</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_service_name" id="mb_service_name" value="<?=$info["mb_service_name"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">이메일</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_service_email" id="mb_service_email" value="<?=$info["mb_service_email"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">부서</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_service_team" id="mb_service_team" value="<?=$info["mb_service_team"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">직위/직책</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_service_position" id="mb_service_position" value="<?=$info["mb_service_position"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">휴대폰번호</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_service_phone" id="mb_service_phone" value="<?=$info["mb_service_phone"]?>">
                        </div>
                    </div>
                </div>

                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">전화번호</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_service_tel" id="mb_service_tel" value="<?=$info["mb_service_tel"]?>">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </form>
    </div>
    <div style="width:33.1%;float:left;border:1px solid #eee;background:#fff;border-radius:6px;height:300px;margin-top:20px;margin-bottom:20px">
        <form id="update6">
            <input type="hidden" name="mb_seq" value="<?=$info["mb_seq"]?>">
        <div class="header-title" style="padding:10px;background:#ddd;height:25px">
            <div style="float:left;" >요금 담당자</div>
            <div style="float:right;"><i class="fa fa-edit"  onclick="memberUpdate6()"></i> <i class=""></i></div>
        </div>
        <div class="view-body" style="clear:both;width:100%">

            <div style="width:100%">
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">이름</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_payment_name" id="mb_payment_name" value="<?=$info["mb_payment_name"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">이메일</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_payment_email" id="mb_payment_email" value="<?=$info["mb_payment_email"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">부서</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_payment_team" id="mb_payment_team" value="<?=$info["mb_payment_team"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">직위/직책</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_payment_position" id="mb_payment_position" value="<?=$info["mb_payment_position"]?>">
                        </div>
                    </div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">휴대폰번호</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_payment_phone" id="mb_payment_phone" value="<?=$info["mb_payment_phone"]?>">
                        </div>
                    </div>
                </div>

                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">전화번호</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_payment_tel" id="mb_payment_tel" value="<?=$info["mb_payment_tel"]?>">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </form>
    </div>
    <div style="clear:both;border:1px solid #eee;background:#fff;border-radius:6px;height:300px;margin-top:40px">
        <div class="header-title" style="padding:10px;background:#ddd;height:25px">
            <div style="float:left">서비스 정보</div>
            <div style="float:right">
                <input type="checkbox" name=""> 서비스 해지 제외
                <button class="btn btn-black btn-add" type="button">확장하기(기본)</button>
                <button class="btn btn-black btn-add" type="button">확장하기(요금)</button>
                <select class="select2" name="" style="width:90px">
                    <option value="50">50라인</option>
                </select>
            </div>
        </div>
        <div class="view-body" style="clear:both;width:100%">
            <div class="table-list">
                <form id="listForm" method="POST" action="/api/estimateExport">
                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="all"></th>
                            <th>No</th>
                            <th>회원명</th>
                            <th class="basic">End User</th>
                            <th>담당자</th>
                            <th>계약번호</th>
                            <th>계약시작일</th>
                            <th class="basic">계약만료일</th>
                            <th>계약기간</th>
                            <th class="basic">연장단위</th>
                            <th class="basic">계약만료일(연장)</th>
                            <th>서비스 종류</th>
                            <th>제품군</th>
                            <th><i class="fa fa-plus"></i></th>
                            <th>상품명</th>
                            <th class="basic">대분류</th>
                            <th>소분류</th>
                            <th>임대형태</th>
                            <th>서비스번호</th>
                            <th class="payment">청구명</th>
                            <th class="payment">초기 일회성</th>
                            <th class="payment">월(기준)요금</th>
                            <th class="payment">결제주기</th>
                            <th class="payment">매입가</th>
                            <th class="payment">매입단위</th>
                            <th class="payment">매입처</th>
                            <th>서비스신청일<br>서비스개시일</th>
                            <th class="basic">제품출고일</th>
                            <th>서비스상태</th>
                            <th>과금시작일<br>과금만료일</th>
                            <th>결제상태</th>
                            <th>문서</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-list">

                    </tbody>
                </table>
                </form>
                <div class="pagination-html">

                </div>
            </div>

        </div>
    </div>
</div>
<input type="hidden" id="start" value=1>
<script>
function memberUpdate1(){
    var url = "/api/memberUpdate1/<?=$info["mb_seq"]?>";
    var datas = $("#update1").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            document.location.reload();
        }
    });
}

function memberUpdate2(){
    var url = "/api/memberUpdate2/<?=$info["mb_seq"]?>";
    var datas = $("#update2").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            document.location.reload();
        }
    });
}

function memberUpdate3(){
    var url = "/api/memberUpdate3/<?=$info["mb_seq"]?>";
    var datas = $("#update3").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            document.location.reload();
        }
    });
}

function memberUpdate4(){
    var url = "/api/memberUpdate4/<?=$info["mb_seq"]?>";
    var datas = $("#update4").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            document.location.reload();
        }
    });
}

function memberUpdate5(){
    var url = "/api/memberUpdate5/<?=$info["mb_seq"]?>";
    var datas = $("#update5").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            document.location.reload();
        }
    });
}

function memberUpdate6(){
    var url = "/api/memberUpdate6/<?=$info["mb_seq"]?>";
    var datas = $("#update6").serialize();
    $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : datas,
        success:function(response){
            document.location.reload();
        }
    });
}
</script>
