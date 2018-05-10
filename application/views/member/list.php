<div class="content">
    <h2 class="title">
        <i class="fa fa-file"></i> 회원 관리
    </h2>
    <div class="search">
        <div class="search1">
            <div class="form-group">
                <input type="checkbox" name=""> 서비스 이용 중인 회원만 표시
            </div>
            <div class="form-group">
                <div class="selectbox">
                    <label for="select2">서비스 전체</label>
                    <select id="select2">
                        <option selected>서비스 전체</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="search2">
            <div class="form-group">
                <label>등록일</label>
                <input type="text" style="width:80px" class="datepicker"> ~ <input type="text" style="width:80px" class="datepicker">
            </div>
            <div class="form-group ml15">
                <div class="selectbox">
                    <label for="select">회원명</label>
                    <select id="select">
                        <option selected>회원명</option>
                        <option>회원아이디</option>
                        <option>대표자</option>
                        <option>사내담당자</option>
                        <option>대표전화</option>
                        <option>계약담당자</option>
                        <option>요금담당자</option>
                        <option>사업자번호</option>
                    </select>
                </div>
                <input type="text">
                <button class="btn btn-search" type="button">검색</button>
            </div>
        </div>
    </div>
    <div class="list">
        <div class="top-button-group">
            <div class="btn-left">
                <button class="btn btn-default" type="button">선택 삭제</button>
                <button class="btn btn-default ml5" type="button">Excel</button>
            </div>
            <div class="btn-right">
                <button class="btn btn-black btn-add" type="button">회원 등록</button>
            </div>
        </div>
        <div class="table-list">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>No</th>
                        <th>아이디</th>
                        <th>회원명</th>
                        <th>사내담당자</th>
                        <th>대표전화</th>
                        <th>계약담당자</th>
                        <th>요금담당자</th>
                        <th>등록일</th>
                        <th>서비스</th>
                        <th>수정</th>
                        <th>삭제</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>1</td>
                        <td><a>3</a></td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td>7</td>
                        <td>8</td>
                        <td>9</td>
                        <td>0</td>
                        <td>1</td>
                        <td>2</td>
                    </tr>
                </tbody>
            </table>
            <div class="pagination">
                <ul>
                    <li class="first"> < </li>
                    <li><a href="#" class="num active">1</a></li>
                    <li><a href="#" class="num">2</a></li>
                    <li><a href="#" class="num">3</a></li>
                    <li><a href="#" class="num">4</a></li>
                    <li><a href="#" class="num">5</a></li>
                    <li><a href="#" class="num">6</a></li>
                    <li><a href="#" class="num">7</a></li>
                    <li><a href="#" class="num">8</a></li>
                    <li><a href="#" class="num">9</a></li>
                    <li><a href="#" class="num">10</a></li>
                    <li class="last"> > </li>
                </ul>
            </div>
        </div>
        <div class="bottom-button-group">
            <div class="btn-left">
                <button class="btn btn-default" type="button">선택 삭제</button>
                <button class="btn btn-default ml5" type="button">Excel</button>
            </div>
            <div class="btn-right">
                <button class="btn btn-black btn-add" type="button">회원 등록</button>
            </div>
        </div>
    </div>
</div>
<div id="dialog">
    <div class="modal-title">
        <div class="modal-title-text">로그인 정보</div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">회원 아이디(코드)</div>
            <div class="input"><input type="text" name="mb_id" id="mb_id" class="width-button"><button class="btn btn-brown btn-small" type="button">중복확인</button></div>
        </div>
    </div>
    <div class="modal-title">
        <div class="modal-title-text">회원 정보</div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">회원구분</div>
            <div class="input">
                <div class="selectbox" style="width:92%">
                    <label for="select" style="top:1.5px;padding:.1em .5em">사업자</label>
                    <select id="select" name="mb_type" id="mb_type" style="padding:.2em .5em">
                        <option selected>사업자</option>
                        <option>개인</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="modal-field-input">
            <div class="label">상호명</div>
            <div class="input"><input type="text" name="mb_name" id="mb_name"></div>
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">사업자등록번호(-포함)</div>
            <div class="input"><input type="text" class="width-button" name="mb_number" id="mb_number"><button class="btn btn-brown btn-small" type="button">중복확인</button></div>
        </div>
        <div class="modal-field-input">
            <div class="label">대표자</div>
            <div class="input"><input type="text" name="mb_ceo" id="mb_ceo"></div>
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input full">
            <div class="label">주소</div>
            <div class="input" style="width:78%"><input type="text" style="width:17%" name="mb_zipcode" id="mb_zipcode"> <input type="text" style="width:50%" name="mb_address" id="mb_address"> <input type="text" style="width:27%" name="mb_detail_address" id="mb_detail_address"></div>
        </div>

    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">전화번호(-포함)</div>
            <div class="input"><input type="text" name="mb_tel" id="mb_tel"></div>
        </div>
        <div class="modal-field-input">
            <div class="label">휴대폰번호(-포함)</div>
            <div class="input"><input type="text" name="mb_phone" id="mb_phone"></div>
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">이메일</div>
            <div class="input"><input type="text" name="mb_email" id="mb_email"></div>
        </div>
        <div class="modal-field-input">
            <div class="label">팩스(-포함)</div>
            <div class="input"><input type="text" name="mb_fax" id="mb_fax"></div>
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">업태</div>
            <div class="input"><input type="text" name="mb_business_conditions" id="mb_business_conditions"></div>
        </div>
        <div class="modal-field-input">
            <div class="label">종목</div>
            <div class="input"><input type="text" name="mb_business_type" id="mb_business_type"></div>
        </div>
    </div>
    <div class="modal-title">
        <div class="modal-title-text">계약 담당자 정보</div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">담당자명</div>
            <div class="input"><input type="text" name="mb_contract_name" id="mb_contract_name"></div>
        </div>
        <div class="modal-field-input">
            <div class="label">이메일</div>
            <div class="input"><input type="text" name="mb_contract_email" id="mb_contract_email"></div>
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">전화번호(-포함)</div>
            <div class="input"><input type="text" name="mb_contract_tel" id="mb_contract_tel"></div>
        </div>
        <div class="modal-field-input">
            <div class="label">휴대푠번호(-포함)</div>
            <div class="input"><input type="text" name="mb_contract_phone" id="mb_contract_phone"></div>
        </div>
    </div>
    <div class="modal-title">
        <div class="modal-title-text">요금 담당자 정보</div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">담당자명</div>
            <div class="input"><input type="text" name="mb_payment_name" id="mb_payment_name"></div>
        </div>
        <div class="modal-field-input">
            <div class="label">이메일</div>
            <div class="input"><input type="text" name="mb_payment_email" id="mb_payment_email"></div>
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">전화번호(-포함)</div>
            <div class="input"><input type="text" name="mb_payment_tel" id="mb_payment_tel"></div>
        </div>
        <div class="modal-field-input">
            <div class="label">휴대푠번호(-포함)</div>
            <div class="input"><input type="text" name="mb_payment_phone" id="mb_payment_phone"></div>
        </div>
    </div>
    <div class="modal-title">
        <div class="modal-title-text">회원 계좌 정보</div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">은행명</div>
            <div class="input"><input type="text" name="mb_bank" id="mb_bank"></div>
        </div>
        <div class="modal-field-input">
            <div class="label">계좌번호(-포함)</div>
            <div class="input"><input type="text" name="mb_bank_input_number" id="mb_bank_input_number"></div>
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">예금주</div>
            <div class="input"><input type="text" style="width:38.7%" name="mb_bank_name" id="mb_bank_name">&nbsp;&nbsp;&nbsp;&nbsp;관계 <input type="text" style="width:30%" name="mb_bank_name_relationship" id="mb_bank_name_relationship"> </div>
        </div>
        <div class="modal-field-input">
            <div class="label">사업자번호/생년월일</div>
            <div class="input"><input type="text" name="mb_bank_number" id="mb_bank_number"></div>
        </div>
    </div>
    <div class="modal-title">
        <div class="modal-title-text">기본 결제 조건</div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">청구 기준</div>
            <div class="input">이용 월의
                <div class="selectbox" style="width:40%">
                    <label for="select" style="top:1.5px;padding:.1em .5em">전월</label>
                    <select id="select" name="mb_payment_type" id="mb_payment_type" style="padding:.2em .5em">
                        <option selected>전월</option>
                        <option>당월</option>
                        <option>익월</option>
                    </select>
                </div> 청구
            </div>
        </div>
        <div class="modal-field-input">
            <div class="label">자동 청구일</div>
            <div class="input">
                <div class="selectbox" style="width:60%">
                    <label for="select" style="top:1.5px;padding:.1em .5em">1일</label>
                    <select id="select" name="mb_auto_payment" id="mb_auto_payment" style="padding:.2em .5em">
                        <?php for($i = 1; $i < 32; $i++): ?>
                            <?php if($i == 1): ?>
                                <option selected><?=$i?>일</option>
                            <?php else: ?>
                                <option><?=$i?>일</option>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <option>말일</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-field">
        <div class="modal-field-input">
            <div class="label">계산서 발행</div>
            <div class="input">
                <div class="selectbox" style="width:40%">
                    <label for="select" style="top:1.5px;padding:.1em .5em">발행</label>
                    <select id="select" name="mb_payment_publish" id="mb_payment_publish" style="padding:.2em .5em">
                        <option selected>발행</option>
                        <option>미발행</option>

                    </select>
                </div>
                <div class="selectbox" style="width:40%">
                    <label for="select" style="top:1.5px;padding:.1em .5em">영수 발행</label>
                    <select id="select" name="mb_payment_publish_type" id="mb_payment_publish_type" style="padding:.2em .5em">
                        <option selected>영수 발행</option>
                        <option>청구 발행</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="modal-field-input">
            <div class="label">결제일</div>
            <div class="input">청구일로부터
                <div class="selectbox" style="width:30%">
                    <label for="select" style="top:1.5px;padding:.1em .5em">입력</label>
                    <select id="select" name="mb_payment_day" id="mb_payment_day" style="padding:.2em .5em">
                        <option selected>입력</option>
                        <option>30</option>
                        <option>60</option>
                        <option>90</option>
                    </select>
                </div> <input type="text" style="width:15%" name="mb_payment_day_text" id="mb_payment_day_text"> 일 후
            </div>
        </div>
    </div>
    <div class="modal-button">
        <button class="btn btn-black btn-register" type="button">등록</button>
    </div>
</div>