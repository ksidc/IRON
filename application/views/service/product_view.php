<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size:9pt;
    }
</style>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<div class="content" style="width:99.5%;padding:0px;">
    <div class="popup_title" style="padding:10px">

        상품/기술/관제 정보

    </div>
    <form id="edit">
    <input type="hidden" name="sv_seq" id="sv_seq" value="<?=$info["sv_seq"]?>">
    <input type="hidden" id="b_sv_pi_seq" value="<?=$info["sv_pi_seq"]?>">

    <input type="hidden" name="pc_name" id="pc_name" value="<?=$info["pc_name"]?>">
    <input type="hidden" name="pi_name" id="pi_name" value="<?=$info["pi_name"]?>">
    <input type="hidden" name="pr_name" id="pr_name" value="<?=$info["pr_name"]?>">
    <input type="hidden" name="pd_name" id="pd_name" value="<?=$info["pd_name"]?>">
    <input type="hidden" name="ps_name" id="ps_name" value="<?=$info["ps_name"]?>">
    
    <div style="border:1px solid #eee;background:#fff;border-radius:6px;margin-top:0px;width:100%">
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
                        <option value="<?=$row["pc_seq"]?>" <?=($row["pc_seq"] == $info["sv_pc_seq"] ? "selected":"")?>><?=$row["pc_name"]?></option>
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
                    <select id="sv_pd_seq" name="sv_pd_seq" class="select2" style="width:49%">
                        <option value="" selected>선택</option>
                    </select>
                    <select id="sv_ps_seq" name="sv_ps_seq" class="select2" style="width:50%">
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
                    <?php if($info["sv_engineer_part"] == "1"): ?>
                        기술팀
                    <?php else: ?>
                        - 
                    <?php endif; ?>
                    /
                    <?php if($info["sv_engineer_charger"] == "1"): ?>
                        노성민
                    <?php else: ?>
                        - 
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="modal-title">
            <div class="modal-title-text"><div>설치 / 관제 정보</div></div>
        </div>
        <div style="width:49.3%;float:left">
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
                        <input type="text" name="sv_out_serial" id="sv_out_serial" value="<?=$info["sv_out_serial"]?>">
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
        <div style="width:50.7%;float:left">
            <div class="modal-field" style="width:100%">
                <div class="modal-field-input" style="width:100%;display:flex;">
                    <div class="label padd" style="width:37.7%;height:86px;overflow:hidden;"><div>관제 IP / URL</div></div>
                    <div class="input padd">
                        <input type="text" name="addUrl" id="addUrl" style="width:70%;margin:4px;"><button class="btn btn-brown btn-small" type="button" onclick="addServiceUrl()">등록</button>
                        <div class="urlList" style="padding:10px 0px 0px 5px;overflow:auto;height:41px;">

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-field">
            <div class="modal-field-input">
                <div class="label padd"><div>설치 담당자</div></div>
                <div class="input padd" style="width:23.2%">
                    <input type="text" name="sv_install_charger" id="sv_install_charger" value="<?=$info["sv_install_charger"]?>" style="width:88%">
                </div>
                <div class="label padd" style="width:12%"><div>설치일</div></div>
                <div class="input padd" style="width:20%">
                    <input type="text" name="sv_install_date" id="sv_install_date" value="<?=$info["sv_install_date"]?>" class="datepicker3">
                </div>
            </div>
            <div class="modal-field-input">
                <div class="label padd"><div>관제 레벨</div></div>
                <div class="input padd">
                    <select name="sv_security_level" id="sv_security_level" class="select2" style="width:162px">
                        <option value="0" <?=($info["sv_security_level"] == "0" ? "selected":"")?>>없음</option>
                        <option value="1" <?=($info["sv_security_level"] == "1" ? "selected":"")?>>1레벨</option>  
                        <option value="2" <?=($info["sv_security_level"] == "2" ? "selected":"")?>>2레벨</option>
                        <option value="3" <?=($info["sv_security_level"] == "3" ? "selected":"")?>>3레벨</option>
                        <option value="4" <?=($info["sv_security_level"] == "4" ? "selected":"")?>>4레벨</option>
                    </select>

                </div>
            </div>
        </div>
        <div style="text-align:center;padding:10px 0px">
            <!-- <button class="btn btn-default" type="button" onclick="document.location.href='/service/list'">목록</button> -->
            <button class="btn btn-default btn-edit" type="button">수정</button>
            <button class="btn btn-default" type="button" onclick="reset2()">취소</button>
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
                    <th class="text-center">No</th>
                    <th class="text-center">라이선스명</th>
                    <th class="text-center">기간</th>
                    <th class="text-center">계약 등록 코드</th>
                    <th class="text-center" style="width:10%;">수정/삭제</th>
             
                </tr>
                </thead>
                <tbody id="licenseList">
                </tbody>
                <tfoot>
                <tr>
                    <td style="height:30px;"></td>
                    <td class="text-center"><input type="text" name="sl_license_name" id="sl_license_name" style="font-size:9pt;color:#7f7f7f;width:100%;"></td>
                    <td class="text-center"><input type="text" name="sl_start_date" class="datepicker3" id="sl_start_date" style="font-size:9pt;color:#7f7f7f;width:80px;"> ~ <input type="text" name="sl_end_date" id="sl_end_date" class="datepicker3" style="font-size:9pt;color:#7f7f7f;width:80px;"></td>
                    <td class="text-center"><input type="text" name="sl_contract_number" id="sl_contract_number" style="font-size:9pt;color:#7f7f7f;width:100%"></td>
                    <td class="text-center"><button class="btn licenseAdd btn-brown" type="button">등록</button></td>
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
                    <th class="text-center">No</th>
                    <th class="text-center">모듈명</th>
                    <th class="text-center">수량</th>
                    <th class="text-center">분류</th>
                    <th class="text-center">추가 장착일</th>
                    <th class="text-center" style="width:10%;">수정/삭제</th>
                </tr>
                </thead>
                <tbody id="moduleList">
                </tbody>
                <tfoot>
                <tr>
                    <td style="height:30px;"></td>
                    <td class="text-center"><input type="text" name="sm_name" id="sm_name" style="font-size:9pt;color:#7f7f7f;width:100%;"></td>
                    <td class="text-center">
                        <select name="sm_cnt" id="sm_cnt" class="select2" style="width:70px;font-size:9pt;color:#7f7f7f;">
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
                    <td class="text-center">
                        <select name="sm_div" id="sm_div" class="select2" style="font-size:9pt;color:#7f7f7f;width:120px;">
                            <option value="1">임대</option>
                            <option value="2">판매</option>
                            <option value="3">고객 구매</option>
                        </select>
                    </td>
                    <td class="text-center"><input type="text" name="sm_date" id="sm_date" class="datepicker3" style="font-size:9pt;color:#7f7f7f;width:80px;"></td>
                    <td class="text-center"><button class="btn moduleAdd btn-brown" type="button">등록</button></td>
                </tr>
                </tfoot>
            </table>
        </div>

        <div class="modal-title">
            <div class="modal-title-text"><div>변경 로그</div></div>
        </div>
        <div style="float:right;font-size:12px;padding:5px 0px">
            <ul style="list-style:none;padding:0;margin:0">
                <li style="float:left;padding-top:5px">구분 </li>
                <li style="float:left;padding-left:3px">
                    <select name="log_type" class="select2" style="width:100px">
                        <option value="">전체 로그</option>
                    </select>
                </li>
                <li style="float:left;padding-top:5px;padding-left:10px">항목</li>
                <li style="float:left;padding-left:3px">
                    <select name="log_type" class="select2" style="width:100px">
                        <option value="">전체 로그</option>
                    </select>
                </li>
                <li style="float:left;padding-top:5px;padding-left:10px">날짜</li>
                <li style="float:left;padding-left:3px">
                    <input type="text" name="start_date" class="datepicker3"> ~ <input type="text" name="end_date" class="datepicker3">
                </li>
            </ul>
            <ul style="clear:both;list-style:none;padding:10px 0px 0px 0px;margin:0">
                <li style="float:left;padding-top:5px">작업자 구분 : </li>
                <li style="float:left;padding-top:3px;padding-left:10px">
                    ADMIN <input type="checkbox"> SYSTEM <input type="checkbox"> USER <input type="checkbox">
                </li>
                <li style="float:left">
                    <select name="" class="select2" style="width:120px">
                        <option value="">작업자 이름</option>
                        <option value="">작업자 ID</option>
                        <option value="">접속 IP</option>
                    </select>
                </li>
                <li style="float:left">
                    <input type="text" name=""><button class="btn btn-brown btn-small" type="button">검색</button>
                </li>

            </ul>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>날짜</th>
                    <th>구분</th>
                    <th>항목</th>
                    <th>변경 전</th>
                    <th>변경 후</th>
                    <th>작업자 구분</th>
                    <th>작업자</th>
                    <th>접속 IP</th>
                </tr>
                </thead>
                <tbody id="log-list">
                
                </tbody>
            </table>
        </div>
        <div>
            <div id="logPaging"></div>
        </div>
    </form>
    </div>


</div>
<input type="hidden" id="log_start" value=1>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
<script type="text/javascript" src="/assets/js/serviceProductView.js?date=<?=time()?>"></script>
<script>
$(function(){
    getPi();
    getPr();
    getPd();
    getPs();

});
function getPi(){
    var url = "/api/productItemSearch/<?=$info["sv_pc_seq"]?>";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){
            $('select[name="sv_pi_seq"]').empty().append('<option value="">선택</option>');
            $("#sv_pi_seq_str").html("선택");
            for(var i =0; i < response.length;i++){
                if(response[i].pi_seq == '<?=$info["sv_pi_seq"]?>'){
                    var selected = "selected";
                }else{
                    var selected = "";
                }
                $('select[name="sv_pi_seq"]').append('<option value="'+response[i].pi_seq+'" '+selected+'>'+response[i].pi_name+'</option>');
            }
        }

    });
}

function getPr(){
    var url = "/api/productSearch/<?=$info["sv_pc_seq"]?>";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data:"pi_seq=<?=$info["sv_pi_seq"]?>",
        success:function(response){
            $('select[name="sv_pr_seq"]').empty().append('<option value="">선택</option>');
            $("#sv_pr_seq_str").html("선택");
            for(var i = 0 ;i < response.length;i++){
                if(response[i].pr_seq == '<?=$info["sv_pr_seq"]?>'){
                    var selected = "selected";
                }else{
                    var selected = "";
                }

                $('select[name="sv_pr_seq"]').append('<option value="'+response[i].pr_seq+'" '+selected+'>'+response[i].pr_name+'</option>');
            }
        }

    });

    // var addoption = "";
    
}

function getPd(){
    var url = "/api/productSubDepth1Search/<?=$info["sv_pr_seq"]?>";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){
            $('select[name="sv_pd_seq"]').empty().append('<option value="">선택</option>');

            for(var i = 0; i < response.length;i++){
                if(response[i].pd_seq == '<?=$info["sv_pd_seq"]?>'){
                    var selected = "selected";
                }else{
                    var selected = "";
                }
                $('select[name="sv_pd_seq"]').append('<option value="'+response[i].pd_seq+'" '+selected+'>'+response[i].pd_name+'</option>');
            }
        }

    });
}

function getPs(){
    var url = "/api/productSubDepth2Search/<?=$info["sv_pr_seq"]?>/<?=$info["sv_pd_seq"]?>";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){
            // console.log(response);
            $('select[name="sv_ps_seq"]').empty().append('<option value="">선택</option>');
            // $("#sr_ps_seq_str").html("선택");
            for(var i = 0; i < response.length;i++){
                if(response[i].ps_seq == '<?=$info["sv_ps_seq"]?>'){
                    var selected = "selected";
                }else{
                    var selected = "";
                }
                $('select[name="sv_ps_seq"]').append('<option value="'+response[i].ps_seq+'" data-price="'+response[i].prs_price+'" data-prsoneprice="'+response[i].prs_one_price+'" data-prsmonthprice="'+response[i].prs_month_price+'" data-prsdiv="'+response[i].prs_div+'" '+selected+'>'+response[i].ps_name+'</option>');
            }
        }

    });
}

function reset2(){
    $("#sv_pc_seq").val("<?=$info["sv_pc_seq"]?>").trigger("change");
    getPi();
    getPr();
    getPd();
    getPs();
    $("#sv_position").val("<?=$info["sv_position"]?>");
    $("#sv_out_serial").val("<?=$info["sv_out_serial"]?>");
    $("#sv_firmware").val("<?=$info["sv_firmware"]?>");
    $("#sv_install_charger").val("<?=$info["sv_install_charger"]?>");
    $("#sv_install_date").val("<?=$info["sv_install_date"]?>");
    $("#sv_security_level").val("<?=$info["sv_security_level"]?>").trigger("change");
}
</script>