<style>

</style>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<div class="content" style="width:98%">
    <form id="edit">
    <input type="hidden" name="sv_seq" id="sv_seq" value="<?=$info["sv_seq"]?>">
    <div style="border:1px solid #eee;background:#fff;border-radius:6px;margin-top:20px;width:100%">
        <div class="modal-title">
            <div class="modal-title-text"><div>기본 상품 정보</div></div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>상호/이름(아이디)</div></div>
                <div class="input padd" >
                    <?=$info["mb_name"]?>(<?=$info["mb_id"]?>)
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>서비스 종류</div></div>
                <div class="input">
                    <select id="sv_pc_seq" name="sv_pc_seq" class="select2" style="width:162px">
                        <option value="" selected>선택</option>
                        <?php foreach($product_category as $row): ?>
                        <option value="<?=$row["pc_seq"]?>"><?=$row["pc_name"]?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd" ><div>End User</div></div>
                <div class="input padd">
                    <?=$info["eu_name"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>제품군</div></div>
                <div class="input">
                    <select id="sv_pi_seq" name="sv_pi_seq" class="select2" style="width:162px">
                        <option value="" selected>선택</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd" ><div>서비스 번호</div></div>
                <div class="input padd">
                    <?=$info["sv_number"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>상품명</div></div>
                <div class="input">
                    <select id="sv_pr_seq" name="sv_pr_seq" class="select2" style="width:162px">
                        <option value="" selected>선택</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd" ><div>고객 담당자 정보</div></div>
                <div class="input padd">
                    <?=$info["mb_service_name"]?> <?=$info["mb_service_position"]?> / <?=$info["mb_service_email"]?> / <?=$info["mb_service_phone"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>대분류 / 소분류</div></div>
                <div class="input">
                    <select id="sv_pd_seq" name="sv_pd_seq" class="select2" style="width:122px">
                        <option value="" selected>선택</option>
                    </select>
                    <select id="sv_ps_seq" name="sv_ps_seq" class="select2" style="width:122px">
                        <option value="" selected>선택</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd" ><div>영업 담당자</div></div>
                <div class="input padd">
                    <?=$info["sv_charger"]?>
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>기술 담당자</div></div>
                <div class="input">

                </div>
            </div>
        </div>

    </form>
    <form id="installForm">
    <input type="hidden" name="sv_seq" value="<?=$info["sv_seq"]?>">
        <div class="modal-title">
            <div class="modal-title-text"><div>설치 / 관제 정보</div></div>
        </div>
        <div style="width:48.8%;float:left">
            <div class="modal-field" style="width:100%">
                <div class="modal-field-input" style="width:100%">
                    <div class="label padd" style="width:38.7%"><div>장비 위치</div></div>
                    <div class="input padd">
                        <input type="text" name="sv_position" id="sv_position" value="<?=$info["sv_position"]?>">
                    </div>
                </div>

            </div>
            <div class="modal-field" style="width:100%">
                <div class="modal-field-input" style="width:100%">
                    <div class="label padd" style="width:38.7%"><div>제품 시리얼 번호</div></div>
                    <div class="input padd">
                        <input type="text" name="sv_serial_number" id="sv_serial_number" value="<?=$info["sv_serial_number"]?>">
                    </div>
                </div>

            </div>
            <div class="modal-field" style="width:100%">
                <div class="modal-field-input" style="width:100%">
                    <div class="label padd" style="width:38.7%"><div>펌웨어 버전</div></div>
                    <div class="input padd">
                        <input type="text" name="sv_firmware" id="sv_firmware" value="<?=$info["sv_firmware"]?>">
                    </div>
                </div>

            </div>
        </div>
        <div style="width:51.2%;float:left">
            <div class="modal-field" style="width:100%">
                <div class="modal-field-input" style="width:100%">
                    <div class="label padd" style="width:36.8%;height:114px"><div>관제 IP / URL</div></div>
                    <div class="input padd">
                        <input type="text" name="addUrl" id="addUrl" style="width:70%"><button class="btn btn-black" type="button" onclick="addServiceUrl()">등록</button>
                        <div class="urlList" style="padding-top:10px">

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>설치 담당자</div></div>
                <div class="input padd" style="width:25%">
                    <input type="text" name="sv_install_charger" id="sv_install_charger" value="<?=$info["sv_install_charger"]?>" style="width:88%">
                </div>
                <div class="label padd" style="width:12%"><div>설치일</div></div>
                <div class="input padd" style="width:20%">
                    <input type="text" name="sv_install_date" id="sv_install_date" value="<?=$info["sv_install_date"]?>">
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>관제 레벨</div></div>
                <div class="input padd">
                    <select name="sv_security_level" class="select2" style="width:162px">
                        <option value="0">없음</option>
                        <option value="1">1레벨</option>
                        <option value="2">2레벨</option>
                        <option value="3">3레벨</option>
                        <option value="4">4레벨</option>
                    </select>

                </div>
            </div>
        </div>
        <div style="text-align:center;padding:10px 0px">
            <!-- <button class="btn btn-default" type="button" onclick="document.location.href='/service/list'">목록</button> -->
            <button class="btn btn-default btn-edit" type="button">수정</button>
            <button class="btn btn-default btn-delete" type="button">취소</button>
        </div>
    </form>
    <form id="licenseForm">
    <input type="hidden" name="sv_seq" value="<?=$info["sv_seq"]?>">
        <div class="modal-title" style="clear:both">
            <div class="modal-title-text"><div>라이선스 정보</div></div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>라이선스명</th>
                    <th>기간</th>
                    <th>계약 등록 코드</th>
                    <th>수정</th>
                    <th>삭제</th>
                </tr>
                </thead>
                <tbody id="licenseList">
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td><input type="text" name="sl_license_name"></td>
                    <td><input type="text" name="sl_start_date"> ~ <input type="text" name="sl_end_date"></td>
                    <td><input type="text" name="sl_contract_number"></td>
                    <td colspan=2><button class="btn licenseAdd" type="button">등록</button></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </form>
    <form id="moduleForm">
    <input type="hidden" name="sv_seq" value="<?=$info["sv_seq"]?>">
        <div class="modal-title" style="clear:both">
            <div class="modal-title-text"><div>추가 모듈 정보</div></div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>모듈명</th>
                    <th>수량</th>
                    <th>분류</th>
                    <th>추가 장착일</th>
                    <th>수정</th>
                    <th>삭제</th>
                </tr>
                </thead>
                <tbody id="moduleList">
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td><input type="text" name="sm_name" id="sm_name"></td>
                    <td>
                        <select name="sm_cnt" id="sm_cnt" class="select2" style="width:160px">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </td>
                    <td>
                        <select name="sm_div" id="sm_div" class="select2" style="width:160px">
                            <option value="1">임대</option>
                            <option value="2">판매</option>
                            <option value="3">고객 구매</option>
                        </select>
                    </td>
                    <td><input type="text" name="sm_date" id="sm_date"></td>
                    <td colspan=2><button class="btn moduleAdd" type="button">등록</button></td>
                </tr>
                </tfoot>
            </table>
        </div>

        <div class="modal-title">
            <div class="modal-title-text"><div>변경 로그</div></div>
        </div>
        <div>
            <table>
                <thead>
                <tr>
                    <th>No</th>
                    <th>입력시간</th>
                    <th>내용</th>
                    <th>작성자</th>
                    <th>수정/삭제</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </form>
    </div>


</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
<script type="text/javascript" src="/assets/js/serviceProductView.js?date=<?=time()?>"></script>
