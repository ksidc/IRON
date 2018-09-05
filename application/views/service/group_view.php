<div style="background:#fff;width:100%;overflow-x:hidden">
    <div class="popup_title" style="padding:10px">

        상세 계약 정보

    </div>
    <div style="padding:5px">
        <form name="registerForm" id="registerForm" method="post" action="/api/serviceRegister">
            <div class="modal-title">
                <div class="modal-title-text">기본 정보</div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label padd"><div>상호/이름</div></div>
                    <div class="input padd" >
                        <?=$list[0]["mb_name"]?>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label padd"><div>End User</div></div>
                    <div class="input">
                        <?php if(!$same): ?>
                            데이터가 일치하지 않습니다.
                        <?php else: ?>
                            <?=$list[0]["eu_name"]?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label padd" ><div>계약 담당자 정보</div></div>
                    <div class="input padd">
                         <?=$list[0]["mb_contract_name"]?> / <?=$list[0]["mb_contract_email"]?> / <?=$list[0]["mb_contract_phone"]?>
                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label padd"><div>업체 분류</div></div>
                    <div class="input">
                        <?php if(!$same): ?>
                            데이터가 일치하지 않습니다.
                        <?php else: ?>
                            <?=$list[0]["ct_name"]?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label padd"><div>계약 번호</div></div>
                    <div class="input">
                        <?=$sv_code?>

                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label padd"><div>사내 담당자</div></div>
                    <div class="input">
                        <?php if(!$same): ?>
                            데이터가 일치하지 않습니다.
                        <?php else: ?>
                        <select name="sv_part" class="select2" style="width:110px">
                            <option value="">기술팀</option>
                            <option value=""></option>
                        </select>
                        <select name="sv_charger" class="select2" style="width:110px">
                            <option value="">노성민</option>
                            <option value=""></option>
                        </select>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-field">
                <div class="modal-field-input">
                    <div class="label padd"><div>계약 기간</div></div>
                    <div class="input">
                        <?php if(!$same): ?>
                            데이터가 일치하지 않습니다.
                        <?php else: ?>
                            <?=$list[0]["sv_contract_start"]?> ~ <?=$list[0]["sv_contract_end"]?>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="modal-field-input">
                    <div class="label padd"><div>자동 계약 연장 단위</div></div>
                    <div class="input">
                        <?php if(!$same): ?>
                            데이터가 일치하지 않습니다.
                        <?php else: ?>
                            <input type="text" style="width:50px" name="sv_auto_extension_month" value="<?=$list[0]["sv_auto_extenstion_month"]?>">개월 <input type="checkbox" name="sv_auto_extenstion" <?=($list[0]["sv_auto_extenstion"] == "1" ? "":"checked")?> >
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </form>
        <div style="text-align:center;padding:10px 0px">
            <button class="btn btn-default btn-edit" type="button">수정</button>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">서비스 내역</div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>계약번호</th>
                    <th>서비스 상태</th>
                    <th>서비스 종류</th>
                    <th>상품명</th>
                    <th>소분류</th>
                    <th>초기 일회성</th>
                    <th>월(기준)요금</th>
                </tr>
                </thead>
                <tbody>
                    <?php $totalprice1 = 0;?>
                    <?php $totalprice2 = 0;?>
                    <?php foreach($list as $row): ?>
                    <tr>
                        <td><?=$row["sv_code"]?></td>
                        <td><?=$row["sv_status"]?></td>
                        <td><?=$row["pc_name"]?></td>
                        <td><?=$row["pr_name"]?></td>
                        <td><?=$row["ps_name"]?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4">합계</td>
                        <td><?=number_format($totalprice1)?></td>
                        <td><?=number_format($totalprice2)?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-title">
            <div class="modal-title-text">계약 변경 내역</div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>계약 구분</th>
                    <th>처리일</th>
                    <th>계약 기간</th>
                    <th>자동 연장</th>
                    <th>관련 서류 링크</th>
                    <th>수정/삭제</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div>
            <div style="display:inline-block">
                <select name="" class="select2">
                    <option value="">선택</option>
                    <option value="1">변경 계약</option>
                    <option value="2">수동 연장</option>
                    <option value="3">계약 해지</option>
                </select>
            </div>
            <div style="display:inline-block">
                계약 기간
                <input type="text" name=""> ~ <input type="text" name="">
            </div>
            <div style="display:inline-block">
                <i></i><input type="text"><button class="btn btn-small">등록</button>
            </div>
        </div>
        <div class="modal-title" style="clear:both">
            <div class="modal-title-text"><div>메모</div></div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>입력시간</th>
                    <th>내용</th>
                    <th>작성자</th>
                    <th>수정</th>
                    <th>삭제</th>
                </tr>
                </thead>
                <tbody id="memoList">
                </tbody>
            </table>
        </div>
        <div>
            <div id="memoPaging"></div>
        </div>
        <div>
            <div style="display:inline-block">
                메모
            </div>
            <div style="display:inline-block">
                <i></i><input type="text"><button class="btn btn-small">등록</button>
            </div>
        </div>
    </div>
</div>
<script>
$(function(){

})
</script>