<style>
.basic {display:none;}
.payment {display:none;}
.payment-basic {
    display:none;
}
.modal-field-input {
    height:25px;
}

.claim_payment {display:none;}
</style>

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
                                <input type="text" class="width-button" name="c_code" id="c_code" readonly><button class="btn btn-brown " type="button" >거래처 등록</button>
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
                            <div class="label">업태</div>
                            <div class="input">
                                <input type="text" class="width-button" name="mb_uptae" id="mb_uptae" value="">
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
                                <select name="mb_level" id="mb_level" class="select2" style="width:90%">
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
                            <div class="label">종목</div>
                            <div class="input">
                                <input type="text" class="width-button" name="mb_jongmok" id="mb_jongmok" value="">
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
                            <input type="text" class="width-button" name="mb_bank2" id="mb_bank2">
                        </div>
                    </div>
                    <div class="modal-field-input">
                        <div class="label">예금주</div>
                        <div class="input" style="width:59%">
                            <input type="text" class="width-button" name="mb_bank_name2" id="mb_bank_name2" readonly>
                        </div>
                    </div>

                </div>
                <div class="modal-field">
                    <div class="modal-field-input full">
                        <div class="label">계좌번호(-포함)</div>
                        <div class="input">
                            <input type="text" class="width-button" name="mb_bank_input_number2" id="mb_bank_input_number2" readonly>
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
            <div class="table-list" style="margin-top:0px">
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
                        <?php foreach($service_list as $row): ?>
                            <?php
                            // $num = parseInt(response.total) - ((start-1)*end) - i;
                            $startdate = $row["sv_contract_start"];
                            $enddate = $row["sv_contract_end"];
                            // $diff = Date.getFormattedDateDiff(startdate, enddate);
                            if($row["sv_rental"] == "N"){
                                $sr_rental = "구매";
                            }else{
                                if($row["sv_rental_type"] == "1"){
                                    $sr_rental = "영구임대";
                                }else{
                                    $sr_rental = "소유권이전";
                                }
                            }
                            if($row["sv_auto_extension"] == "1"){
                                $sr_auto = $row["sv_auto_extension_month"];
                                // $sr_auto_end = moment($row["sv_contract_end"]).add(sr_auto,'months').subtract(1, "days").format("YYYY-MM-DD")
                            }else{
                                $sr_auto = "-";
                                $sr_auto_end = $row["sv_contract_end"];
                            }
                            $priceinfo = explode("|",$row["priceinfo"]);
                            $firstPrice = $priceinfo[0];
                            $monthPrice = $priceinfo[1]-$priceinfo[2]-$priceinfo[3];
                            ?>
                            <tr>
                                <td><input type="checkbox" class="listCheck" name="sr_seq[]" value="<?=$row["sv_seq"]?>"></td>
                                <td></td>
                                <td><?=$row["mb_name"]?></td>
                                <td><?=$row["sv_charger"]?></td>
                                <td class="basic"><?=$row["eu_name"]?></td>
                                <td><?=$row["sv_code"]?></td>
                                <td><?=$row["sv_contract_start"]?></td>
                                <td class="basic"><?=$row["sv_contract_end"]?></td>
                                <td></td>
                                <td class="basic"><?=$sr_auto?></td>
                                <td class="basic"><?=$sr_auto_end?></td>
                                <td><?=$row["pc_name"]?></td>
                                <td><?=$row["pi_name"]?></td>
                                <td class="option_extend" data-seq="<?=$row["sv_seq"]?>" style="width:30px;height:30px;background:#414860;font-size:16px;color:#fff;margin:2px"> + </td>
                                <td><?=$row["pr_name"]?></td>
                                <td class="basic"><?=$row["pd_name"]?></td>
                                <td><?=$row["ps_name"]?></td>
                                <td><?=$sr_rental?></td>
                                <td><?=$row["sv_number"]?></td>
                                <td class="payment"><?=$row["sv_claim_name"]?></td>
                                <td class="payment oneprice" data-oneprice="<?=$row["svp_first_price"]?>" data-allprice="<?=$firstPrice?>"><?=$firstPrice?></td>
                                <td class="payment monthprice" data-oneprice="<?=$row["svp_month_price"]-$row["svp_month_dis_price"]-$row["svp_discount_price"]?>" data-allprice="<?=$monthPrice?>"><?=$monthPrice?></td>
                                <td class="payment"><?=$row["sv_payment_period"]?>개월</td>
                                <td class="payment"><?=$row["sv_input_price"]?></td>
                                <td class="payment"></td>
                                <td class="payment"><?=$row["c_name"]?></td>
                                <td><?=$row["sv_regdate"]?><br></td>
                                <td><?=($row["sv_status"] == 0 ? "<span class='statusEdit' style='cursor:pointer;color:#0070C0' data-seq='".$row["sv_seq"]."'>등록</span>":"<span style='color:#FF0000'>신청완료</span>")?></td>
                                <td class="basic"></td>
                                <td><?=$row["sv_account_start"]?><br><?=$row["sv_account_end"]?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr style="border-bottom:0px;display:none" id="child_add_<?=$row["sv_seq"]?>">
                                <td colspan=9 class="addcol"></td>
                                <th style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9;" colspan=2>부가항목명</th>
                                <th class="basic" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9"></th>
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9"></td>
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9"></td>
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">서비스번호</td>
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">청구명</td>
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">초기일회성</td>
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">월(기준)요금</td>
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">결제주기</td>
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">매입가</td>
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">매입 단위</td>
                                <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">매입처</td>
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">서비스신청일<br>서비스개시일</td>
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9" class="basic">제품출고일</td>
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">서비스상태</td>
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">과금시작일<br>과금만료일</td>
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">결제상태</td>
                                <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">문서</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </form>
                <div class="pagination-html">

                </div>
            </div>

        </div>
    </div>
    <div style="clear:both;border:1px solid #eee;background:#fff;border-radius:6px;height:300px;margin-top:40px">
        <div class="header-title" style="padding:10px;background:#ddd;height:25px">
            <div style="float:left">요금 정보</div>
            <div style="float:right">
                <input type="checkbox" id="service_display" > 서비스 요금 0원 숨기기
                <button class="btn btn-black btn-add btn-payment-setting" onclick="openPopup()" type="button">계산서 설정</button>


            </div>
        </div>
        <div class="view-body" style="clear:both;width:100%">
            <div class="table-list" style="margin-top:0px">
                <form id="listForm" method="POST" action="/api/estimateExport">
                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="all_payment"></th>
                            <th>No</th>
                            <th>회원명</th>
                            <th>계약번호</th>
                            <th>서비스 종류</th>
                            <th>상품명</th>
                            <th>소분류</th>
                            <th>서비스 번호</th>
                            <th>납부방법</th>
                            <th>개월수</th>
                            <th class="payment-basic">일회성 요금</th>
                            <th class="payment-basic">일회성 할인</th>
                            <th>일회성 요금 합계</th>
                            <th class="payment-basic">서비스 요금</th>
                            <th class="payment-basic">서비스 할인</th>
                            <th class="payment-basic">결제방법할인</th>
                            <th>서비스 요금 합계</th>
                            <th>부가세</th>
                            <th>총 서비스 요금 합계</th>
                            <th>청구일</th>
                            <th>결제일<br>(청구일로부터)</th>
                            <th>선/후불</th>
                            <th>계산서</th>
                            <th>TaxCode</th>
                            <th>상세보기</th>
                            <th onclick="viewAll()"><</th>
                        </tr>
                    </thead>
                    <tbody id="payment-tbody-list">
                    <?php foreach($payment_list as $row): ?>
                        <?php $once_price = ($row["svp_once_price"]-$row["svp_once_dis_price"]) ?>
                        <?php $price = ($row["svp_month_price"]-$row["svp_month_dis_price"]-$row["svp_discount_price"]); ?>
                        <?php $price2 = (($row["svp_month_price"]-$row["svp_month_dis_price"]-$row["svp_discount_price"])*1.1)-($row["svp_month_price"]-$row["svp_month_dis_price"]-$row["svp_discount_price"]); ?>
                        <tr class="payment_tr" data-price="<?=$price?>">
                            <td><input type="checkbox" class="payment_check" value="<?=$row["sv_seq"]?>" data-price1="<?=$row["svp_once_price"]?>" data-price2="<?=$row["svp_once_dis_price"]?>" data-price3="<?=$once_price?>" data-price4="<?=$row["svp_month_price"]?>" data-price5="<?=$row["svp_month_dis_price"]?>" data-price6="<?=$row["svp_discount_price"]?>" data-price7="<?=$price?>" data-price8="<?=$price2?>" data-price9="<?=($once_price+$price+$price2)?>"></td>
                            <td>1</td>
                            <td><?=$row["mb_name"]?></td>
                            <td class="once_number"><?=$row["sv_code"]?></td>
                            <td class="once_service"><?=($row["sva_seq"] == "" ? $row["pc_name"]:"부가항목")?></td>
                            <td class="once_product"><?=($row["sva_seq"] == "" ? $row["pr_name"]:$row["sva_name"])?></td>
                            <td><?=($row["sva_seq"] == "" ? $row["ps_name"]:"")?></td>
                            <td class="once_service_number"><?=$row["sv_number"]?></td>
                            <td>
                                <?php if($row["sv_payment_type"] == "1"): ?>
                                무통장
                                <?php elseif($row["sv_payment_type"] == "2"): ?>
                                카드
                                <?php else: ?>
                                CMS
                                <?php endif; ?>
                            </td>
                            <td><?=($row["sva_seq"] == "" ? $row["sv_payment_period"]:$row["sva_pay_day"])?>개월</td>
                            <td class="payment-basic"><?=$row["svp_once_price"]?></td>
                            <td class="payment-basic"><?=$row["svp_once_dis_price"]?></td>

                            <td><?=number_format($once_price)?></td>
                            <td class="payment-basic"><?=$row["svp_month_price"]?></td>
                            <td class="payment-basic"><?=$row["svp_month_dis_price"]?></td>
                            <td class="payment-basic"><?=$row["svp_discount_price"]?></td>

                            <td><?=number_format($price)?></td>
                            <td>
                                <?=number_format($price2)?>
                            </td>
                            <td><?=number_format($once_price+$price+$price2)?></td>
                            <td>
                                <?php if($row["sv_pay_type"] == "0"): ?>
                                    전월
                                <?php elseif($row["sv_pay_type"] == "1"): ?>
                                    당월
                                <?php elseif($row["sv_pay_type"] == "2"): ?>
                                    익월
                                <?php endif; ?>
                                <?=$row["sv_pay_day"]?>일
                            </td>
                            <td>
                                <?=$row["sv_payment_day"]?>일 이내
                            </td>
                            <td>
                                <?php if($row["sv_pay_type"] == "0"): ?>
                                    <?php $cal1 = -1; ?>
                                <?php elseif($row["sv_pay_type"] == "1"): ?>
                                    <?php $cal1 = 0; ?>
                                <?php elseif($row["sv_pay_type"] == "2"): ?>
                                    <?php $cal1 = 1; ?>
                                <?php endif; ?>
                                <?php $cal = $cal1+($row["sv_pay_day"]/30) + ($row["sv_payment_day"]/30)?>
                                <?php if($cal <= 0.3): ?>
                                    선불
                                <?php elseif($cal > 0.3 && $cal <= 1.3): ?>
                                    후불
                                <?php elseif($cal > 1.3 && $cal <= 2.3): ?>
                                    후후불
                                <?php elseif($cal > 2.3 && $cal <= 3.3): ?>
                                    후후후불
                                <?php elseif($cal > 3.3 ): ?>
                                    조정필요
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($row["sv_pay_publish_type"] == 0): ?>
                                    영수발행
                                <?php else: ?>
                                    청구발행
                                <?php endif; ?>
                            </td>
                            <td>Default</td>
                            <td><i class="fas fa-edit detailView" data-seq="<?=$row["svp_seq"]?>"></i></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </form>

            </div>
            <div style="float:right;margin-top:20px">
                <table class="table">
                    <tr>
                        <td class="payment-basic" style="background:#ddd;">일회성 요금</td>
                        <td class="payment-basic" style="background:#ddd;">일회성 할인</td>
                        <td style="background:#ddd;width:100px">일회성 요금 합계</td>
                        <td class="payment-basic" style="background:#ddd;">서비스 요금(월)</td>
                        <td class="payment-basic" style="background:#ddd;">서비스 할인(월)</td>
                        <td class="payment-basic" style="background:#ddd;">결제방법할인(월)</td>
                        <td style="background:#ddd;width:100px">월 요금 합계</td>
                        <td style="background:#ddd;width:100px">부가세</td>
                        <td style="background:#ddd;width:100px">총 월 요금 합계</td>
                    </tr>
                    <tr>
                        <td class="payment-basic payment_price1"></td>
                        <td class="payment-basic payment_price2" ></td>
                        <td class="payment_price3"></td>
                        <td class="payment-basic payment_price4"></td>
                        <td class="payment-basic payment_price5"></td>
                        <td class="payment-basic payment_price6"></td>
                        <td class="payment_price7"></td>
                        <td class="payment_price8"></td>
                        <td class="payment_price9"></td>
                    </tr>
                </table>
            </div>
            <div style="clear:both;text-align:center;padding-top:20px">
                <button class="btn btn-default" type="button" onclick="servicePayment()">서비스 비용 청구</button>
                <button class="btn btn-default" type="button" onclick='oncePayment()'>일회성 청구</button>
            </div>
        </div>
    </div>
    <div style="clear:both;border:1px solid #eee;background:#fff;border-radius:6px;height:300px;margin-top:40px">
        <div class="header-title" style="padding:10px;background:#ddd;height:25px">
            <div style="float:left">청구 내역</div>
            <div style="float:right">
                <input type="checkbox" name=""> 서비스 비용 자동 청구
                <input type="checkbox" name=""> 메일 자동 발송
                <input type="checkbox" name=""> 연체 수수료 부과

            </div>
        </div>
        <div class="view-body" style="clear:both;width:100%">
            <div class="table-list" style="margin-top:0px">
                <form id="listForm" method="POST" action="/api/estimateExport">
                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="claim_all"></th>
                            <th>No</th>
                            <th>구분</th>
                            <th>청구 번호</th>
                            <th>청구일</th>
                            <th>서비스 기간</th>
                            <th>서비스 종류</th>
                            <th>상품명</th>
                            <th>소분류</th>
                            <th>서비스 번호</th>
                            <th>납부방법</th>
                            <th>개월수</th>
                            <th class="claim_payment">청구명</th>
                            <th class="claim_payment">일회성 요금</th>
                            <th class="claim_payment">일회성 할인</th>
                            <th class="claim_payment">일회성 청구 합계</th>
                            <th class="claim_payment">초기 일할 요금</th>
                            <th class="claim_payment">서비스 요금</th>
                            <th class="claim_payment">서비스 할인</th>
                            <th class="claim_payment">결제 방법 할인</th>
                            <th class="claim_payment">서비스 청구 합계</th>
                            <th class="claim_payment">연체 수수료</th>
                            <th>청구 합계</th>
                            <th>부가세</th>
                            <th>총 청구 합계</th>
                            <th>결제 기한</th>
                            <th>결제 상태</th>
                            <th>거래명세서</th>
                            <th>세금계산서</th>
                            <th>수정</th>
                            <th onclick="viewAll2()"><</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-list">
                        <?php foreach($claim_list as $row): ?>
                        <tr>
                            <td><input type="checkbox" class="claim_check" value="<?=$row["pm_seq"]?>" data-price1="<?=$row["pm_once_price"]?>" data-price2="<?=$row["pm_once_dis_price"]?>" data-price3="<?=$row["pm_once_price"]-$row["pm_once_dis_price"]?>" data-price4="<?=$row["pm_first_price"]?>" data-price5="<?=$row["pm_service_price"]?>" data-price6="<?=$row["pm_service_dis_price"]?>" data-price7="<?=$row["pm_payment_dis_price"]?>" data-price8="" data-price9="<?=$row["pm_delay_price"]?>" data-price10="<?=$row["pm_total_price"]?>" data-price11="<?=$row["pm_surtax_price"]?>" data-price12="<?=$row["pm_total_price"]+$row["pm_surtax_price"]?>"></td>
                            <td>1</td>
                            <td><?=($row["pm_type"] == "1" ? "서비스비용":"일회성비용")?></td>
                            <td><?=$row["pm_code"]?></td>
                            <td>
                                <?=$row["pm_date"]?>
                            </td>
                            <td>
                                <?=$row["pm_service_start"]?> ~ <?=$row["pm_service_end"]?>
                            </td>
                            <td><?=$row["pc_name"]?></td>
                            <td><?=$row["pr_name"]?></td>
                            <td><?=$row["ps_name"]?></td>
                            <td><?=$row["sv_number"]?></td>
                            <td>
                                <?php if($row["sv_payment_type"] == "1"): ?>
                                    무통장
                                <?php elseif($row["sv_payment_type"] == "2"): ?>
                                    카드
                                <?php else: ?>
                                    CMS
                                <?php endif; ?>
                            </td>
                            <td><?=$row["pm_pay_period"]?>개월</td>
                            <td class="claim_payment">청구명</td>
                            <td class="claim_payment"><?=$row["pm_once_price"]?></td>
                            <td class="claim_payment"><?=$row["pm_once_dis_price"]?></td>
                            <td class="claim_payment"><?=$row["pm_once_price"]-$row["pm_once_dis_price"]?></td>
                            <td class="claim_payment"><?=$row["pm_first_price"]?></td>
                            <td class="claim_payment"><?=$row["pm_service_price"]?></td>
                            <td class="claim_payment"><?=$row["pm_service_dis_price"]?></td>
                            <td class="claim_payment"><?=$row["pm_payment_dis_price"]?></td>
                            <td class="claim_payment">서비스 청구 합계</td>
                            <td class="claim_payment"><?=$row["pm_delay_price"]?></td>
                            <td><?=$row["pm_total_price"]?></td>
                            <td><?=$row["pm_surtax_price"]?></td>
                            <td><?=$row["pm_total_price"]+$row["pm_surtax_price"]?></td>
                            <td><?=$row["pm_end_date"]?></td>
                            <td><?=($row["pm_end_date"] >= date("Y-m-d") ? "청구":"미납")?></td>
                            <td><i class="fas fa-edit claimView" data-seq="<?=$row["pm_seq"]?>"></i></td>
                            <td class="billView" data-seq="<?=$row["pm_seq"]?>">
                                <?php if($row["pm_payment_publish_type"] == "0"):?>
                                    영수발행
                                <?php else: ?>
                                    청구발행
                                <?php endif; ?>
                            </td>
                            <td><i class="fas fa-edit detailPView" data-seq="<?=$row["pm_seq"]?>"></i></td>
                            <td></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </form>
                <div class="pagination-html">

                </div>
            </div>
            <div style="float:right;margin-top:20px">
                <table class="table">
                    <tr>
                        <td style="background:#ddd" class="claim_payment">일회성 요금</td>
                        <td style="background:#ddd" class="claim_payment">일회성 할인</td>
                        <td style="background:#ddd" class="claim_payment">일회성 청구 합계</td>
                        <td style="background:#ddd" class="claim_payment">초기 일할 요금</td>
                        <td style="background:#ddd" class="claim_payment">서비스 요금</td>
                        <td style="background:#ddd" class="claim_payment">서비스 할인</td>
                        <td style="background:#ddd" class="claim_payment">결제 방법 할인</td>
                        <td style="background:#ddd" class="claim_payment">서비스 청구 합계</td>
                        <td style="background:#ddd" class="claim_payment">연체 수수료</td>
                        <td style="background:#ddd;width:150px">청구 합계</td>
                        <td style="background:#ddd;width:150px">부가세</td>
                        <td style="background:#ddd;width:150px">총 청구 합계</td>
                    </tr>
                    <tr>
                        <td class="claim_price1 claim_payment"></td>
                        <td class="claim_price2 claim_payment"></td>
                        <td class="claim_price3 claim_payment"></td>
                        <td class="claim_price4 claim_payment"></td>
                        <td class="claim_price5 claim_payment"></td>
                        <td class="claim_price6 claim_payment"></td>
                        <td class="claim_price7 claim_payment"></td>
                        <td class="claim_price8 claim_payment"></td>
                        <td class="claim_price9 claim_payment"></td>
                        <td class="claim_price10"></td>
                        <td class="claim_price11"></td>
                        <td class="claim_price12"></td>
                    </tr>
                </table>
            </div>
            <div style="clear:both;text-align:center;padding-top:20px">
                <button class="btn btn-default btn-com" type="button">가결제 처리</button>
                <button class="btn btn-default btn-check-delete" type="button">선택 삭제</button>
                <button class="btn btn-default btn-com-pay" type="button">완납 처리</button>
                <button class="btn btn-default" type="button">청구 메일 발송</button>
            </div>
        </div>
    </div>
</div>


<div id="dialogMemo" class="dialog" style="padding:5px">
    <div class="modal_search">
        <ul>
            <li >
                전화상담/메모
            </li>

        </ul>
    </div>
    <form id="firstSettingForm">

        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">회원명</div>
                <div class="input">

                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">요금 담당자</div>

                <div class="input"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">입금예정일</div>
                <div class="input">

                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">메모</div>
                <div class="input">

                </div>
            </div>
        </div>
    </form>

    <div class="modal-close-btn" style="margin-top:115px"><button class="btn btn-black btn-small btn-memo-reg">등록</button> <button class="btn btn-default btn-small" onclick="$('#dialogMemo').dialog('close')">닫기</button></div>
    <div class="table-list">
        <table class="table">
            <thead>
                <tr>

                    <th>No</th>
                    <th>내용</th>
                    <th>입력시간</th>
                    <th>입금 예정일</th>
                    <th>작성자</th>
                    <th>수정/삭제</th>
                </tr>
            </thead>
            <tbody id="memo-list">

            </tbody>
        </table>
    </div>
</div>

<div id="dialogOnce" class="dialog" style="padding:5px">
    <div class="modal_search">
        <ul>
            <li >
                일회성 청구 등록
            </li>

        </ul>
    </div>
    <div style="font-size:12px;padding:5px 5px 20px 5px">요금 납부 방법 및 계산서 발행, 결제 기한은 체크한 서비스와 동일하게 불러옵니다.</div>
    <form id="onceInput">
        <input type="hidden" name="pm_type" value="2">
        <input type="hidden" name="pm_mb_seq" value="<?=$info["mb_seq"]?>">
        <input type="hidden" name="pm_sv_seq" id="pm_sv_seq" value="">
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">서비스 종류</div>
                <div class="input" id="once_service">

                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">계약번호</div>

                <div class="input" id="once_number"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">상품명</div>
                <div class="input" id="once_product">

                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">서비스 번호</div>

                <div class="input" id="once_service_number"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">일회성 청구명</div>
                <div class="input">
                    <input type="text" name="pm_claim_name" id="pm_claim_name">
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">계산서 품목명</div>

                <div class="input"><input type="text" name="pm_bill_name" id="pm_bill_name"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">요금 납부 방법</div>
                <div class="input">
                    <select name="pm_com_type" class="select2">
                        <option value="1">무통장</option>
                        <option value="2">카드</option>
                        <option value="3">CMS</option>
                    </select>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">계산서 발행</div>

                <div class="input">
                    <select  name="pm_payment_publish" id="pm_payment_publish" class="select2" style="width:40%">
                        <option  value="0">발행</option>
                        <option value="1">미발행</option>

                    </select>


                    <select name="pm_payment_publish_type" id="pm_payment_publish_type" class="select2" style="width:40%">
                        <option selected value="0">영수 발행</option>
                        <option value="1">청구 발행</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">청구 금액</div>
                <div class="input">
                    <input type="text" name="pm_service_price" id="pm_service_price">
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">일회성 청구 합계</div>

                <div class="input" id="once_price_info">원</div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">할인 금액</div>
                <div class="input">
                    <input type="text" name="pm_service_dis_price" id="pm_service_dis_price">
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">부가세 포함 여부</div>

                <div class="input">
                    <select name="pm_surtax_type" id="pm_surtax_type" class="select2" style="width:40%">
                        <option selected value="0">포함</option>
                        <option value="1">불포함</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">할인 사유</div>
                <div class="input">
                    <input type="text" name="pm_dis_msg" id="pm_dis_msg">
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">부가세</div>

                <div class="input" id="once_surtax_info"></div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label">결제기한</div>
                <div class="input">
                    <input type="text" name="pm_end_date" id="pm_end_date">
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label">총 청구 합계</div>

                <div class="input" id="once_total_price"></div>
            </div>
        </div>
    </form>

    <div class="modal-close-btn" style="margin-top:35px"><button class="btn btn-black btn-small btn-once-reg" type="button">등록</button> <button class="btn btn-default btn-small" onclick="$('#dialogOnce').dialog('close')" type="button">닫기</button></div>

</div>
<div id="dialogInput" class="dialog" style="padding:5px">
    <div class="modal_search">
        <ul>
            <li >
                입금 예정일 입력
            </li>

        </ul>
    </div>
    <form id="pmInputForm">
        <input type="hidden" name="pm_seq" id="input_pm_seq">
        <div class="modal-field">
            <div class="modal-field-input full">
                <div class="label">입금 예정일</div>
                <div class="input">
                    <input type="text" name="pm_input_date" id="pm_input_date">
                </div>
            </div>

        </div>

    </form>

    <div class="modal-close-btn" style="margin-top:115px"><button class="btn btn-black btn-small btn-input-date">등록</button> <button class="btn btn-default btn-small" onclick="$('#dialogMemo').dialog('close')">닫기</button></div>

</div>
<div id="dialogClaim" class="dialog" style="padding:5px">
    <div class="modal_search">
        <ul>
            <li >
                거래명세서
            </li>

        </ul>
    </div>
    <div>
        <form id="claimEdit" method="post">
            <input type="hidden" name="ca_seq" id="ca_seq">
        <table width='700px' cellpadding='0' cellspacing='0' align='center' class='border_all payment_claim' id="payment1" >
            <tr>
                <td width='100%'>
                    <table cellpadding='0' cellspacing='0' height='65' width='100%'>
                        <tr>
                            <td rowspan='2' align='center' width='100%' class='border_tit'><font size='6'><b>거래명세서</b></font></td>


                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellpadding='0' cellspacing='0' width='700px'>
                        <tr>
                            <td class='border_up' align='center' width='17px' rowspan='7'>공<br><br><br>급<br><br><br>자</td>
                            <td class='border_up' align='center' width='55px' height='33'>등록번호</td>
                            <td class='border_up' align='center' width='278px' colspan='5'><input type="text" name="ca_from_number" id="ca_from_number" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='17px' rowspan='7'>공<br>급<br>받<br>는<br>자</td>
                            <td class='border_up' align='center' width='55px'>등록번호</td>
                            <td class='border_top' align='center' width='278px' colspan='5'><input type="text" name="ca_to_number" id="ca_to_number" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='55' height='33'>상 호<br>(법인명)</td>
                            <td class='border_up' align='center' width='160' colspan='3'><input type="text" name="ca_from_name" id="ca_from_name" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='12' colspan='1'>성<br>명</td>
                            <td class='border_up' align='left' width='94' colspan='1'><input type="text" name="ca_from_ceo" id="ca_from_ceo" value="" class="border-no width90" style="width:65px;padding:0" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"> (인)</td>
                            <td class='border_up' align='center' width='55'>상 호<br>(법인명)</td>
                            <td class='border_up' align='center' width='160' colspan='3'><input type="text" name="ca_to_name" id="ca_to_name" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='12' colspan='1'>성<br>명</td>
                            <td class='border_top' align='left' width='94' colspan='1'><input type="text" name="ca_to_ceo" id="ca_to_ceo" value="" class="border-no width90" style="width:65px;padding:0" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"> (인)</td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='55' height='33'>사업장<br>주  소</td>
                            <td class='border_up' align='center' width='278' colspan='5'><input type="text" name="ca_from_address" id="ca_from_address" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='55'>사업장<br>주  소</td>
                            <td class='border_top' align='center' width='278' colspan='5'><input type="text" name="ca_to_address" id="ca_to_address" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='55' height='33'>업  태</td>
                            <td class='border_up' align='center' width='148' colspan='1'><input type="text" name="ca_from_condition" id="ca_from_condition" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='12' colspan='1'>종<br>목</td>
                            <td class='border_up' align='center' width='106' colspan='3'><input type="text" name="ca_from_type" id="ca_from_type" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='55'>업 &nbsp; 태</td>
                            <td class='border_up' align='center' width='148' colspan='1'><input type="text" name="ca_to_condition" id="ca_to_condition" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='12' colspan='1'>종<br>목</td>
                            <td class='border_top' align='center' width='106' colspan='3'><input type="text" name="ca_to_type" id="ca_to_type" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='55' height='33'>담당부서</td>
                            <td class='border_up' align='center' width='148' colspan='1'><input type="text" name="ca_from_team" id="ca_from_team" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='12' colspan='1'>성명</td>
                            <td class='border_up' align='center' width='106' colspan='3'><input type="text" name="ca_from_charger" id="ca_from_charger" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='55'>담당부서</td>
                            <td class='border_up' align='center' width='148' colspan='1'><input type="text" name="ca_to_team" id="ca_to_team" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='12' colspan='1'>성명</td>
                            <td class='border_top' align='center' width='106' colspan='3'><input type="text" name="ca_to_charger" id="ca_to_charger" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='55' height='33' >연락처</td>
                            <td class='border_up' align='center' width='266' colspan='5' ><input type="text" name="ca_from_tel" id="ca_from_tel" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='55'>연락처</td>
                            <td class='border_up' align='center' width='266' colspan='5'><input type="text" name="ca_to_tel" id="ca_to_tel" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='55'>이메일</td>
                            <td class='border_up' align='center' width='266' colspan='5'><input type="text" name="ca_from_email" id="ca_from_email" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='55'>이메일</td>
                            <td class='border_up' align='center' width='266' colspan='5'><input type="text" name="ca_to_email" id="ca_to_email" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width='700px'>
                    <table cellpadding='0' cellspacing='0' width='700px'>
                        <tr>
                            <td class='border_up' align='center' width='85' height='21'>작 &nbsp; 성</td>
                            <td class='border_up'  width='250' align='center'>공 &nbsp; 급 &nbsp; 가 &nbsp; 액</td>
                            <td class='border_up'  align='center' width='4' height='15'>&nbsp;</td>
                            <td class='border_up' align='center' width='190' height='15'>세 &nbsp; 액</td>
                            <td class='border_top' align='center' width='156'>합계금액</td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='85' height='21'><input type="text" name="ca_date" id="ca_date" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' ><input type="text" name="ca_price" id="ca_price" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' ></td>
                            <td class='border_up' align='center' ><input type="text" name="ca_surtax" id="ca_surtax" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_top' align='center' width='156' ><input type="text" name="ca_total_price" id="ca_total_price" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td width='700px'>
                    <table cellpadding='0' cellspacing='0' width='700px'>
                        <tr>
                            <td class='border_up' align='center' width='50' height='21'>월 일</td>
                            <td class='border_up' align='center' width='195'>품 &nbsp; &nbsp; &nbsp; 목</td>
                            <td class='border_up' align='center' width='42'>규 격</td>
                            <td class='border_up' align='center' width='65'>수 량</td>
                            <td class='border_up' align='center' width='55'>단 가</td>
                            <td class='border_up' align='center' width='150'>공급가액</td>
                            <td class='border_up' align='center' width='83'>세 액</td>
                            <td class='border_top' align='center' width='60'>비고</td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='50' height='30' ><input type="text" name="ca_item_date1" id="ca_item_date1" value="" class="border-no width90" style="width:40px;padding:0px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='195' ><input type="text" name="ca_item_name1" id="ca_item_name1" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='42' >&nbsp;</td>
                            <td class='border_up' align='center' width='65'>&nbsp;</td>
                            <td class='border_up' align='center' width='55'>&nbsp;</td>
                            <td class='border_up' align='center' width='150' ><input type="text" name="ca_item_price1" id="ca_item_price1" value="" class="border-no width90"  onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='83' ><input type="text" name="ca_item_surtax1" id="ca_item_surtax1" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_top' align='center' width='60' ><input type="text" name="ca_item_msg1" id="ca_item_msg1" value="" class="border-no width90" style="width:50px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='50' height='30' ><input type="text" name="ca_item_date2" id="ca_item_date2" value="" class="border-no width90" style="width:40px;padding:0px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='195' ><input type="text" name="ca_item_name2" id="ca_item_name2" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='42' >&nbsp;</td>
                            <td class='border_up' align='center' width='65'>&nbsp;</td>
                            <td class='border_up' align='center' width='55'>&nbsp;</td>
                            <td class='border_up' align='center' width='150' ><input type="text" name="ca_item_price2" id="ca_item_price2" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='83' ><input type="text" name="ca_item_surtax2" id="ca_item_surtax2" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_top' align='center' width='60' ><input type="text" name="ca_item_msg2" id="ca_item_msg2" value="" class="border-no width90" style="width:50px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='50' height='30' ><input type="text" name="ca_item_date3" id="ca_item_date3" value="" class="border-no width90" style="width:40px;padding:0px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='195' ><input type="text" name="ca_item_name3" id="ca_item_name3" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='42' >&nbsp;</td>
                            <td class='border_up' align='center' width='65'>&nbsp;</td>
                            <td class='border_up' align='center' width='55'>&nbsp;</td>
                            <td class='border_up' align='center' width='150' ><input type="text" name="ca_item_price3" id="ca_item_price3" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='83' ><input type="text" name="ca_item_surtax3" id="ca_item_surtax3" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_top' align='center' width='60' ><input type="text" name="ca_item_msg3" id="ca_item_msg3" value="" class="border-no width90" style="width:50px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='50' height='30' ><input type="text" name="ca_item_date4" id="ca_item_date4" value="" class="border-no width90" style="width:40px;padding:0px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='195' ><input type="text" name="ca_item_name4" id="ca_item_name4" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='42' >&nbsp;</td>
                            <td class='border_up' align='center' width='65'>&nbsp;</td>
                            <td class='border_up' align='center' width='55'>&nbsp;</td>
                            <td class='border_up' align='center' width='150' ><input type="text" name="ca_item_price4" id="ca_item_price4" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='83' ><input type="text" name="ca_item_surtax4" id="ca_item_surtax4" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_top' align='center' width='60' ><input type="text" name="ca_item_msg4" id="ca_item_msg4" value="" class="border-no width90" style="width:50px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
        </form>
    </div>
    <div class="modal-close-btn" style="margin-top:5px"><button class="btn btn-black btn-small btn-claim-reg">수정</button> <button class="btn btn-default btn-small" onclick="$('#dialogClaim').dialog('close')">닫기</button></div>
</div>
<div id="dialogBill" class="dialog" style="padding:5px">
    <div class="modal_search">
        <ul>
            <li >
                세금계산서
            </li>

        </ul>
    </div>
    <div>
        <form id="billEdit" method="post">
            <input type="hidden" name="ca_seq" id="ba_seq">
        <table width='700px' cellpadding='0' cellspacing='0' align='center' class='border_all payment_claim' id="payment1" >
            <tr>
                <td width='100%'>
                    <table cellpadding='0' cellspacing='0' height='65' width='100%'>
                        <tr>
                            <td rowspan='2' align='center' width='100%' class='border_tit'><font size='6'><b>세금계산서</b></font></td>


                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellpadding='0' cellspacing='0' width='700px'>
                        <tr>
                            <td class='border_up' align='center' width='17px' rowspan='7'>공<br><br><br>급<br><br><br>자</td>
                            <td class='border_up' align='center' width='55px' height='33'>등록번호</td>
                            <td class='border_up' align='center' width='278px' colspan='5'><input type="text" name="ca_from_number" id="ba_from_number" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='17px' rowspan='7'>공<br>급<br>받<br>는<br>자</td>
                            <td class='border_up' align='center' width='55px'>등록번호</td>
                            <td class='border_top' align='center' width='278px' colspan='5'><input type="text" name="ca_to_number" id="ba_to_number" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='55' height='33'>상 호<br>(법인명)</td>
                            <td class='border_up' align='center' width='160' colspan='3'><input type="text" name="ca_from_name" id="ba_from_name" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='12' colspan='1'>성<br>명</td>
                            <td class='border_up' align='left' width='94' colspan='1'><input type="text" name="ca_from_ceo" id="ba_from_ceo" value="" class="border-no width90" style="width:65px;padding:0" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"> (인)</td>
                            <td class='border_up' align='center' width='55'>상 호<br>(법인명)</td>
                            <td class='border_up' align='center' width='160' colspan='3'><input type="text" name="ca_to_name" id="ba_to_name" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='12' colspan='1'>성<br>명</td>
                            <td class='border_top' align='left' width='94' colspan='1'><input type="text" name="ca_to_ceo" id="ba_to_ceo" value="" class="border-no width90" style="width:65px;padding:0" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"> (인)</td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='55' height='33'>사업장<br>주  소</td>
                            <td class='border_up' align='center' width='278' colspan='5'><input type="text" name="ca_from_address" id="ba_from_address" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='55'>사업장<br>주  소</td>
                            <td class='border_top' align='center' width='278' colspan='5'><input type="text" name="ca_to_address" id="ba_to_address" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='55' height='33'>업  태</td>
                            <td class='border_up' align='center' width='148' colspan='1'><input type="text" name="ca_from_condition" id="ba_from_condition" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='12' colspan='1'>종<br>목</td>
                            <td class='border_up' align='center' width='106' colspan='3'><input type="text" name="ca_from_type" id="ba_from_type" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='55'>업 &nbsp; 태</td>
                            <td class='border_up' align='center' width='148' colspan='1'><input type="text" name="ca_to_condition" id="ba_to_condition" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='12' colspan='1'>종<br>목</td>
                            <td class='border_top' align='center' width='106' colspan='3'><input type="text" name="ca_to_type" id="ba_to_type" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='55' height='33'>담당부서</td>
                            <td class='border_up' align='center' width='148' colspan='1'><input type="text" name="ca_from_team" id="ba_from_team" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='12' colspan='1'>성명</td>
                            <td class='border_up' align='center' width='106' colspan='3'><input type="text" name="ca_from_charger" id="ba_from_charger" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='55'>담당부서</td>
                            <td class='border_up' align='center' width='148' colspan='1'><input type="text" name="ca_to_team" id="ba_to_team" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='12' colspan='1'>성명</td>
                            <td class='border_top' align='center' width='106' colspan='3'><input type="text" name="ca_to_charger" id="ba_to_charger" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='55' height='33' >연락처</td>
                            <td class='border_up' align='center' width='266' colspan='5' ><input type="text" name="ca_from_tel" id="ba_from_tel" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='55'>연락처</td>
                            <td class='border_up' align='center' width='266' colspan='5'><input type="text" name="ca_to_tel" id="ba_to_tel" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='55'>이메일</td>
                            <td class='border_up' align='center' width='266' colspan='5'><input type="text" name="ca_from_email" id="ba_from_email" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='55'>이메일</td>
                            <td class='border_up' align='center' width='266' colspan='5'><input type="text" name="ca_to_email" id="ba_to_email" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width='700px'>
                    <table cellpadding='0' cellspacing='0' width='700px'>
                        <tr>
                            <td class='border_up' align='center' width='85' height='21'>작 &nbsp; 성</td>
                            <td class='border_up' align='center' width='50'>공란수</td>
                            <td class='border_up'  width='200' align='center'>공 &nbsp; 급 &nbsp; 가 &nbsp; 액</td>
                            <td class='border_up'  align='center' width='4' height='15'>&nbsp;</td>
                            <td class='border_up' align='center' width='190' height='15'>세 &nbsp; 액</td>
                            <td class='border_top' align='center' width='156'>합계금액</td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='85' height='21'><input type="text" name="ca_date" id="ba_date" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='50'><input type="text" name="ca_empty_size" id="ba_empty_size" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' ><input type="text" name="ca_price" id="ba_price" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' ></td>
                            <td class='border_up' align='center' ><input type="text" name="ca_surtax" id="ba_surtax" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_top' align='center' width='156' ><input type="text" name="ca_total_price" id="ba_total_price" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td width='700px'>
                    <table cellpadding='0' cellspacing='0' width='700px'>
                        <tr>
                            <td class='border_up' align='center' width='50' height='21'>월 일</td>
                            <td class='border_up' align='center' width='195'>품 &nbsp; &nbsp; &nbsp; 목</td>
                            <td class='border_up' align='center' width='42'>규 격</td>
                            <td class='border_up' align='center' width='65'>수 량</td>
                            <td class='border_up' align='center' width='55'>단 가</td>
                            <td class='border_up' align='center' width='150'>공급가액</td>
                            <td class='border_up' align='center' width='83'>세 액</td>
                            <td class='border_top' align='center' width='60'>비고</td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='50' height='30' ><input type="text" name="ca_item_date1" id="ba_item_date1" value="" class="border-no width90" style="width:40px;padding:0px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='195' ><input type="text" name="ca_item_name1" id="ba_item_name1" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='42' >&nbsp;</td>
                            <td class='border_up' align='center' width='65'>&nbsp;</td>
                            <td class='border_up' align='center' width='55'>&nbsp;</td>
                            <td class='border_up' align='center' width='150' ><input type="text" name="ca_item_price1" id="ba_item_price1" value="" class="border-no width90"  onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='83' ><input type="text" name="ca_item_surtax1" id="ba_item_surtax1" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_top' align='center' width='60' ><input type="text" name="ca_item_msg1" id="ba_item_msg1" value="" class="border-no width90" style="width:50px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='50' height='30' ><input type="text" name="ca_item_date2" id="ba_item_date2" value="" class="border-no width90" style="width:40px;padding:0px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='195' ><input type="text" name="ca_item_name2" id="ba_item_name2" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='42' >&nbsp;</td>
                            <td class='border_up' align='center' width='65'>&nbsp;</td>
                            <td class='border_up' align='center' width='55'>&nbsp;</td>
                            <td class='border_up' align='center' width='150' ><input type="text" name="ca_item_price2" id="ba_item_price2" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='83' ><input type="text" name="ca_item_surtax2" id="ba_item_surtax2" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_top' align='center' width='60' ><input type="text" name="ca_item_msg2" id="ba_item_msg2" value="" class="border-no width90" style="width:50px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='50' height='30' ><input type="text" name="ba_item_date3" id="ca_item_date3" value="" class="border-no width90" style="width:40px;padding:0px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='195' ><input type="text" name="ca_item_name3" id="ba_item_name3" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='42' >&nbsp;</td>
                            <td class='border_up' align='center' width='65'>&nbsp;</td>
                            <td class='border_up' align='center' width='55'>&nbsp;</td>
                            <td class='border_up' align='center' width='150' ><input type="text" name="ca_item_price3" id="ba_item_price3" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='83' ><input type="text" name="ca_item_surtax3" id="ba_item_surtax3" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_top' align='center' width='60' ><input type="text" name="ca_item_msg3" id="ba_item_msg3" value="" class="border-no width90" style="width:50px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='50' height='30' ><input type="text" name="ba_item_date4" id="ca_item_date4" value="" class="border-no width90" style="width:40px;padding:0px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='195' ><input type="text" name="ca_item_name4" id="ba_item_name4" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='42' >&nbsp;</td>
                            <td class='border_up' align='center' width='65'>&nbsp;</td>
                            <td class='border_up' align='center' width='55'>&nbsp;</td>
                            <td class='border_up' align='center' width='150' ><input type="text" name="ca_item_price4" id="ba_item_price4" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='83' ><input type="text" name="ca_item_surtax4" id="ba_item_surtax4" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_top' align='center' width='60' ><input type="text" name="ca_item_msg4" id="ba_item_msg4" value="" class="border-no width90" style="width:50px" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width='100%'>
                    <table cellpadding='0' cellspacing='0' width='700'>
                        <tr align='justify'>
                            <td class='border_up' align='center' width='122' height='2' >합계금액</td>
                            <td class='border_up' align='center' width='108'>현 &nbsp; &nbsp; 금</td>
                            <td class='border_up' align='center' width='108'>수 &nbsp; &nbsp; 표</td>
                            <td class='border_up' align='center' width='108'>어 &nbsp; &nbsp; 음</td>
                            <td class='border_up' align='center' width='108'>외상미수금</td>
                            <td class='border_top' rowspan='2' align='center' width='143'>이 금액을 <span id="paytype1">&nbsp;  &nbsp; &nbsp; &nbsp;</span>함</td>
                        </tr>
                        <tr>
                            <td class='border_up' align='center' width='122' height='25'><input type="text" name="ca_price_info1" id="ba_price_info1" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='108'><input type="text" name="ca_price_info2" id="ba_price_info2" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='108'><input type="text" name="ca_price_info3" id="ba_price_info3" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='108'><input type="text" name="ca_price_info4" id="ba_price_info4" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                            <td class='border_up' align='center' width='108'><input type="text" name="ca_price_info5" id="ba_price_info5" value="" class="border-no width90" onfocus="$(this).removeClass('border-no')" onfocusout="$(this).addClass('border-no')"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </form>
    </div>
    <div class="modal-close-btn" style="margin-top:5px"><button class="btn btn-black btn-small btn-bill-reg">수정</button> <button class="btn btn-default btn-small" onclick="$('#dialogBill').dialog('close')">닫기</button></div>
</div>
<input type="hidden" id="start" value=1>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
<script type="text/javascript" src="/assets/js/memberView.js"></script>
