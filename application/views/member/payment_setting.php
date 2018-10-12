<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<link rel='stylesheet' href="/assets/css/uniform.default.css">
<script src="/assets/js/jquery.uniform.js"></script>
<script src="/assets/js/moment.js"></script>
<script src="/assets/js/serviceMake.js?date=<?=time()?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>

<div style="background:#fff;width:100%;overflow-x:hidden">
    <div class="popup_title" style="padding:10px">

       세금계산서 설정

   </div>
   <div style="padding:5px">
        <div style="width:45%;display:inline-block;vertical-align:top">
            <div class="modal-title">
                <div class="modal-title-text">신청 회원 정보</div>
            </div>
            <div class="table-list" style="height:250px;overflow:auto">
                <table class="table">
                    <thead>
                        <tr>

                            <th>서비스번호</th>
                            <th>납부방법</th>
                            <th>개월수</th>
                            <th>청구일</th>
                            <th>결제일</th>
                            <th>계산서</th>
                            <th>계산서 품목명</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="before-list">
                    <?php foreach($payment_list as $key => $row): ?>
                        <tr class="noclaim" data-svpseq="<?=$row["svp_seq"]?>">
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
                            <td><?=($row["sva_seq"] == "" ? $row["sv_payment_period"]:$row["sva_pay_day"])?>개월</td>
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
                            <td><?=$row["sv_payment_day"]?>일 이내</td>
                            <td>
                                <?php if($row["sv_pay_publish_type"] == 0): ?>
                                    영수발행
                                <?php else: ?>
                                    청구발행
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($row["sva_seq"] == ""): ?>
                                    <?=$row["sv_bill_name"]?>
                                <?php else: ?>
                                    <?=$row["sva_bill_name"]?>
                                <?php endif; ?>
                            </td>
                            <td class="btn-add-bill" data-index="<?=$key?>" data-view='<?=json_encode($row)?>' data-clcode="<?=$row["cl_code"]?>"><i class="fa fa-caret-down fa-2x" aria-hidden="true"></i></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-list" style="height:250px;overflow:auto">
                <input type="hidden" name="active_payment" id="active_payment" value="0">

                <?php if(count($claim_list) > 0): ?>
                    <input type="hidden" id="cl_seq" value="<?=$claim_list[0]["cl_seq"]?>">
                <?php foreach($claim_list as $key=>$row ): ?>
                <form id="addClaim<?=$key?>">
                
                <table class="table table_claim" id="table<?=$key?>" <?=($key != "0" ? "style='display:none'":"")?>>
                    <thead>
                        <tr>
                            <th>서비스번호</th>
                            <th>납부방법</th>
                            <th>청구일</th>
                            <th>TaxCode</th>
                            <th>품목번호</th>
                            <th>품목대표</th>
                            <th>계약서 품목명</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="after-list<?=$key?>">

                    </tbody>
                </table>
                </form>
                <?php endforeach?>
                <?php else: ?>
                    <input type="hidden" id="cl_seq" value="">
                <form id="addClaim0">
                
                <table class="table table_claim" id="table0" >
                    <thead>
                        <tr>
                            <th>서비스번호</th>
                            <th>납부방법</th>
                            <th>청구일</th>
                            <th>TaxCode</th>
                            <th>품목번호</th>
                            <th>품목대표</th>
                            <th>계약서 품목명</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="after-list0">

                    </tbody>
                </table>
                </form>
                <?php endif; ?>
            </div>
        </div>

        <div style="width:45%;display:inline-block">
            <div class="add-tab content-tab" style="width:87%;margin:0 auto">
                <ul class="addtab">
                    <?php if(count($claim_list) > 0): ?>
                    <?php foreach($claim_list as $key=>$row ): ?>
                        <?php if($key == 0): ?>
                        <li class="content-tab-item active" data-index="<?=$key?>" data-clseq="<?=$row["cl_seq"]?>">계산서<?=$row["cl_code"]?></li>
                        <?php else: ?>
                        <li class="content-tab-item" data-index="<?=$key?>" data-clseq="<?=$row["cl_seq"]?>">계산서<?=$row["cl_code"]?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <li class="content-tab-item add">+</li>
                    <?php else: ?>
                    <li class="content-tab-item active" data-index="1" data-clseq="">계산서1</li>
                    <li class="content-tab-item add">+</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div id="payment">
                <?php if(count($claim_list) > 0): ?>
                <?php foreach($claim_list as $key=>$row ): ?>
                <table width='700' cellpadding='0' cellspacing='0' align='center' class='border_all payment_claim' data-seq="<?=$row["cl_seq"]?>" id="payment<?=$key?>" <?=($key != "0" ? "style='display:none'":"")?>>
                    <tr>
                        <td width='100%'>
                            <table cellpadding='0' cellspacing='0' height='65' width='100%'>
                                <tr>
                                    <td rowspan='2' align='center' width='360' class='border_tit'><font size='6'><b>세 금 계 산 서</b></font></td>
                                    <td rowspan='2' width='5' align='center' class='border_tit'><font size='4'><b>[</b></font></td>
                                    <td rowspan='2' width='70' align='center' class='border_tit'>공급받는자&nbsp;<br>보 &nbsp;관 &nbsp;용&nbsp;</td>
                                    <td rowspan='2' width='5' align='center' class='border_tit'><font size='4'><b>]</b></font></td>
                                    <td align='right' width='85' class='border_tit'>책 번 호&nbsp;&nbsp;</td>
                                    <td colspan='3' align='right' class='border_both'>권 &nbsp;</td>
                                    <td colspan='4' align='right' class='border_tit'>호 &nbsp;</td>
                                </tr>
                                <tr>
                                    <td width='85' align='right' class='border_tit'>일련번호&nbsp;</td>
                                    <td colspan='1' class='border_back ' width='25'>&nbsp;</td>
                                    <td colspan='1' class='border_up' width='25'>&nbsp;</td>
                                    <td colspan='1' class='border_up' width='25'>&nbsp;</td>
                                    <td colspan='1' class='border_up' width='25'>&nbsp;</td>
                                    <td colspan='1' class='border_up' width='25'>&nbsp;</td>
                                    <td colspan='1' class='border_up' width='25'>&nbsp;</td>
                                    <td colspan='1' class='border_top' width='25'>&nbsp;</td>  <!-- 책,권 -->
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding='0' cellspacing='0' width='700'>
                                <tr>
                                    <td class='border_up' align='center' width='17' rowspan='7'>공<br><br><br>급<br><br><br>자</td>
                                    <td class='border_up' align='center' width='55' height='33'>등록번호</td>
                                    <td class='border_up' align='center' width='278' colspan='5'>&nbsp;</td>
                                    <td class='border_up' align='center' width='17' rowspan='7'>공<br>급<br>받<br>는<br>자</td>
                                    <td class='border_up' align='center' width='55'>등록번호</td>
                                    <td class='border_top' align='center' width='278' colspan='5'><?=$member_view["mb_number"]?></td>
                                </tr>
                                <tr>
                                    <td class='border_up' align='center' width='55' height='33'>상 호<br>(법인명)</td>
                                    <td class='border_up' align='center' width='160' colspan='3'>&nbsp;</td>
                                    <td class='border_up' align='center' width='12' colspan='1'>성<br>명</td>
                                    <td class='border_up' align='right' width='94' colspan='1'>(인)</td>
                                    <td class='border_up' align='center' width='55'>상 호<br>(법인명)</td>
                                    <td class='border_up' align='center' width='160' colspan='3'><?=$member_view["mb_name"]?></td>
                                    <td class='border_up' align='center' width='12' colspan='1'>성<br>명</td>
                                    <td class='border_top' align='right' width='94' colspan='1'><?=$member_view["mb_ceo"]?> (인)</td>
                                </tr>
                                <tr>
                                    <td class='border_up' align='center' width='55' height='33'>사업장<br>주  소</td>
                                    <td class='border_up' align='center' width='278' colspan='5'>&nbsp;</td>
                                    <td class='border_up' align='center' width='55'>사업장<br>주  소</td>
                                    <td class='border_top' align='center' width='278' colspan='5'><?=$member_view["mb_address"]?> <?=$member_view["mb_detail_address"]?></td>
                                </tr>
                                <tr>
                                    <td class='border_up' align='center' width='55' height='33'>업  태</td>
                                    <td class='border_up' align='center' width='148' colspan='1'>&nbsp;</td>
                                    <td class='border_up' align='center' width='12' colspan='1'>종<br>목</td>
                                    <td class='border_up' align='center' width='106' colspan='3'>&nbsp;</td>
                                    <td class='border_up' align='center' width='55'>업 &nbsp; 태</td>
                                    <td class='border_up' align='center' width='148' colspan='1'><?=$member_view["mb_business_conditions"]?></td>
                                    <td class='border_up' align='center' width='12' colspan='1'>종<br>목</td>
                                    <td class='border_top' align='center' width='106' colspan='3'><?=$member_view["mb_business_type"]?></td>
                                </tr>
                                <tr>
                                    <td class='border_up' align='center' width='55' height='33'>담당부서</td>
                                    <td class='border_up' align='center' width='148' colspan='1'>&nbsp;</td>
                                    <td class='border_up' align='center' width='12' colspan='1'>성명</td>
                                    <td class='border_up' align='center' width='106' colspan='3'>&nbsp;</td>
                                    <td class='border_up' align='center' width='55'>담당부서</td>
                                    <td class='border_up' align='center' width='148' colspan='1'><?=$member_view["mb_payment_team"]?></td>
                                    <td class='border_up' align='center' width='12' colspan='1'>성명</td>
                                    <td class='border_top' align='center' width='106' colspan='3'><?=$member_view["mb_payment_name"]?></td>
                                </tr>
                                <tr>
                                    <td class='border_up' align='center' width='55' height='53' rowspan=2>이메일</td>
                                    <td class='border_up' align='center' width='266' colspan='5' rowspan=2>&nbsp;</td>
                                    <td class='border_up' align='center' width='55'>이메일</td>
                                    <td class='border_up' align='center' width='266' colspan='5'><?=$member_view["mb_payment_email"]?></td>
                                </tr>
                                <tr>

                                    <td class='border_up' align='center' width='55'>이메일</td>
                                    <td class='border_up' align='center' width='266' colspan='5'></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width='100%'>
                            <table cellpadding='0' cellspacing='0' width='700'>
                                <tr>
                                    <td class='border_up' align='center' width='85' height='21'>작 &nbsp; 성</td>
                                    <td class='border_up' colspan='12' width='250' align='center'>공 &nbsp; 급 &nbsp; 가 &nbsp; 액</td>
                                    <td class='border_up' rowspan='3' align='center' width='4' height='15'>&nbsp;</td>
                                    <td class='border_up' colspan='10' align='center' width='190' height='15'>세 &nbsp; 액</td>
                                    <td class='border_top' align='center' width='156'>비 &nbsp; 고</td>
                                </tr>
                                <tr>
                                    <td class='border_up' align='center' width='85' height='21'>년 &nbsp; 월 &nbsp; 일</td>
                                    <td class='border_up' align='center' width='35'><font size='1'>공란수</font></td>
                                    <td class='border_up' align='center' width='20'>백</td>
                                    <td class='border_up' align='center' width='20'>십</td>
                                    <td class='border_up' align='center' width='20'>억</td>
                                    <td class='border_up' align='center' width='20'>천</td>
                                    <td class='border_up' align='center' width='20'>백</td>
                                    <td class='border_up' align='center' width='20'>십</td>
                                    <td class='border_up' align='center' width='20'>만</td>
                                    <td class='border_up' align='center' width='20'>천</td>
                                    <td class='border_up' align='center' width='20'>백</td>
                                    <td class='border_up' align='center' width='20'>십</td>
                                    <td class='border_up' align='center' width='20'>일</td>

                                    <td class='border_up' align='center' width='20'>십</td>
                                    <td class='border_up' align='center' width='20'>억</td>
                                    <td class='border_up' align='center' width='20'>천</td>
                                    <td class='border_up' align='center' width='20'>백</td>
                                    <td class='border_up' align='center' width='20'>십</td>
                                    <td class='border_up' align='center' width='20'>만</td>
                                    <td class='border_up' align='center' width='20'>천</td>
                                    <td class='border_up' align='center' width='20'>백</td>
                                    <td class='border_up' align='center' width='20'>십</td>
                                    <td class='border_up' align='center' width='20'>일</td>
                                    <td class='border_top reset' align='center' width='156' rowspan='2'>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class='border_up reset' align='center' width='85' height='25' id="date<?=$key?>"> &nbsp; </td>
                                    <td class='border_up reset' align='center' width='35' id="number<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price<?=$key?>_11">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price<?=$key?>_10">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price<?=$key?>_9">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price<?=$key?>_8">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price<?=$key?>_7">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price<?=$key?>_6">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price<?=$key?>_5">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price<?=$key?>_4">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price<?=$key?>_3">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price<?=$key?>_2">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price<?=$key?>_1">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice<?=$key?>_10">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice<?=$key?>_9">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice<?=$key?>_8">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice<?=$key?>_7">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice<?=$key?>_6">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice<?=$key?>_5">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice<?=$key?>_4">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice<?=$key?>_3">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice<?=$key?>_2">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice<?=$key?>_1">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width='100%'>
                            <table cellpadding='0' cellspacing='0' width='700'>
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
                                    <td class='border_up reset' align='center' width='50' height='25' id="item_date1_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='195' id="item_name1_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='42' id="item_etc1_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='65' id="item_cnt1_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='55' id="item_price1_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='150' id="item_oprice1_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='83' id="item_sprice1_<?=$key?>">&nbsp;</td>
                                    <td class='border_top reset' align='center' width='60' id="item_msg1_<?=$key?>">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class='border_up reset' align='center' width='50' height='25' id="item_date2_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='195' id="item_name2_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='42' id="item_etc2_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='65' id="item_cnt2_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='55' id="item_price2_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='150' id="item_oprice2_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='83' id="item_sprice2_<?=$key?>">&nbsp;</td>
                                    <td class='border_top reset' align='center' width='60' id="item_msg2_<?=$key?>">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class='border_up reset' align='center' width='50' height='25' id="item_date3_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='195' id="item_name3_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='42' id="item_etc3_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='65' id="item_cnt3_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='55' id="item_price3_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='150' id="item_oprice3_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='83' id="item_sprice3_<?=$key?>">&nbsp;</td>
                                    <td class='border_top reset' align='center' width='60' id="item_msg3_<?=$key?>">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class='border_up reset' align='center' width='50' height='25' id="item_date4_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='195' id="item_name4_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='42' id="item_etc4_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='65' id="item_cnt4_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='55' id="item_price4_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='150' id="item_oprice4_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='83' id="item_sprice4_<?=$key?>">&nbsp;</td>
                                    <td class='border_top reset' align='center' width='60' id="item_msg4_<?=$key?>">&nbsp;</td>
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
                                    <td class='border_top' rowspan='2' align='center' width='143'>이 금액을 <span id="paytype<?=$key?>">&nbsp;  &nbsp; &nbsp; &nbsp;</span>함</td>
                                </tr>
                                <tr>
                                    <td class='border_up reset' align='center' width='122' height='25' id="totalprice<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='108' id="totalprice2_<?=$key?>">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='108'>&nbsp;</td>
                                    <td class='border_up reset' align='center' width='108'>&nbsp;</td>
                                    <td class='border_up reset' align='center' width='108'>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            <?php endforeach; ?>
            <?php else: ?>
                <table width='700' cellpadding='0' cellspacing='0' align='center' class='border_all payment_claim' data-seq="" id="payment0" >
                    <tr>
                        <td width='100%'>
                            <table cellpadding='0' cellspacing='0' height='65' width='100%'>
                                <tr>
                                    <td rowspan='2' align='center' width='360' class='border_tit'><font size='6'><b>세 금 계 산 서</b></font></td>
                                    <td rowspan='2' width='5' align='center' class='border_tit'><font size='4'><b>[</b></font></td>
                                    <td rowspan='2' width='70' align='center' class='border_tit'>공급받는자&nbsp;<br>보 &nbsp;관 &nbsp;용&nbsp;</td>
                                    <td rowspan='2' width='5' align='center' class='border_tit'><font size='4'><b>]</b></font></td>
                                    <td align='right' width='85' class='border_tit'>책 번 호&nbsp;&nbsp;</td>
                                    <td colspan='3' align='right' class='border_both'>권 &nbsp;</td>
                                    <td colspan='4' align='right' class='border_tit'>호 &nbsp;</td>
                                </tr>
                                <tr>
                                    <td width='85' align='right' class='border_tit'>일련번호&nbsp;</td>
                                    <td colspan='1' class='border_back ' width='25'>&nbsp;</td>
                                    <td colspan='1' class='border_up' width='25'>&nbsp;</td>
                                    <td colspan='1' class='border_up' width='25'>&nbsp;</td>
                                    <td colspan='1' class='border_up' width='25'>&nbsp;</td>
                                    <td colspan='1' class='border_up' width='25'>&nbsp;</td>
                                    <td colspan='1' class='border_up' width='25'>&nbsp;</td>
                                    <td colspan='1' class='border_top' width='25'>&nbsp;</td>  <!-- 책,권 -->
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding='0' cellspacing='0' width='700'>
                                <tr>
                                    <td class='border_up' align='center' width='17' rowspan='7'>공<br><br><br>급<br><br><br>자</td>
                                    <td class='border_up' align='center' width='55' height='33'>등록번호</td>
                                    <td class='border_up' align='center' width='278' colspan='5'>&nbsp;</td>
                                    <td class='border_up' align='center' width='17' rowspan='7'>공<br>급<br>받<br>는<br>자</td>
                                    <td class='border_up' align='center' width='55'>등록번호</td>
                                    <td class='border_top' align='center' width='278' colspan='5'><?=$member_view["mb_number"]?></td>
                                </tr>
                                <tr>
                                    <td class='border_up' align='center' width='55' height='33'>상 호<br>(법인명)</td>
                                    <td class='border_up' align='center' width='160' colspan='3'>&nbsp;</td>
                                    <td class='border_up' align='center' width='12' colspan='1'>성<br>명</td>
                                    <td class='border_up' align='right' width='94' colspan='1'>(인)</td>
                                    <td class='border_up' align='center' width='55'>상 호<br>(법인명)</td>
                                    <td class='border_up' align='center' width='160' colspan='3'><?=$member_view["mb_name"]?></td>
                                    <td class='border_up' align='center' width='12' colspan='1'>성<br>명</td>
                                    <td class='border_top' align='right' width='94' colspan='1'><?=$member_view["mb_ceo"]?> (인)</td>
                                </tr>
                                <tr>
                                    <td class='border_up' align='center' width='55' height='33'>사업장<br>주  소</td>
                                    <td class='border_up' align='center' width='278' colspan='5'>&nbsp;</td>
                                    <td class='border_up' align='center' width='55'>사업장<br>주  소</td>
                                    <td class='border_top' align='center' width='278' colspan='5'><?=$member_view["mb_address"]?> <?=$member_view["mb_detail_address"]?></td>
                                </tr>
                                <tr>
                                    <td class='border_up' align='center' width='55' height='33'>업  태</td>
                                    <td class='border_up' align='center' width='148' colspan='1'>&nbsp;</td>
                                    <td class='border_up' align='center' width='12' colspan='1'>종<br>목</td>
                                    <td class='border_up' align='center' width='106' colspan='3'>&nbsp;</td>
                                    <td class='border_up' align='center' width='55'>업 &nbsp; 태</td>
                                    <td class='border_up' align='center' width='148' colspan='1'><?=$member_view["mb_business_conditions"]?></td>
                                    <td class='border_up' align='center' width='12' colspan='1'>종<br>목</td>
                                    <td class='border_top' align='center' width='106' colspan='3'><?=$member_view["mb_business_type"]?></td>
                                </tr>
                                <tr>
                                    <td class='border_up' align='center' width='55' height='33'>담당부서</td>
                                    <td class='border_up' align='center' width='148' colspan='1'>&nbsp;</td>
                                    <td class='border_up' align='center' width='12' colspan='1'>성명</td>
                                    <td class='border_up' align='center' width='106' colspan='3'>&nbsp;</td>
                                    <td class='border_up' align='center' width='55'>담당부서</td>
                                    <td class='border_up' align='center' width='148' colspan='1'><?=$member_view["mb_payment_team"]?></td>
                                    <td class='border_up' align='center' width='12' colspan='1'>성명</td>
                                    <td class='border_top' align='center' width='106' colspan='3'><?=$member_view["mb_payment_name"]?></td>
                                </tr>
                                <tr>
                                    <td class='border_up' align='center' width='55' height='53' rowspan=2>이메일</td>
                                    <td class='border_up' align='center' width='266' colspan='5' rowspan=2>&nbsp;</td>
                                    <td class='border_up' align='center' width='55'>이메일</td>
                                    <td class='border_up' align='center' width='266' colspan='5'><?=$member_view["mb_payment_email"]?></td>
                                </tr>
                                <tr>

                                    <td class='border_up' align='center' width='55'>이메일</td>
                                    <td class='border_up' align='center' width='266' colspan='5'></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width='100%'>
                            <table cellpadding='0' cellspacing='0' width='700'>
                                <tr>
                                    <td class='border_up' align='center' width='85' height='21'>작 &nbsp; 성</td>
                                    <td class='border_up' colspan='12' width='250' align='center'>공 &nbsp; 급 &nbsp; 가 &nbsp; 액</td>
                                    <td class='border_up' rowspan='3' align='center' width='4' height='15'>&nbsp;</td>
                                    <td class='border_up' colspan='10' align='center' width='190' height='15'>세 &nbsp; 액</td>
                                    <td class='border_top' align='center' width='156'>비 &nbsp; 고</td>
                                </tr>
                                <tr>
                                    <td class='border_up' align='center' width='85' height='21'>년 &nbsp; 월 &nbsp; 일</td>
                                    <td class='border_up' align='center' width='35'><font size='1'>공란수</font></td>
                                    <td class='border_up' align='center' width='20'>백</td>
                                    <td class='border_up' align='center' width='20'>십</td>
                                    <td class='border_up' align='center' width='20'>억</td>
                                    <td class='border_up' align='center' width='20'>천</td>
                                    <td class='border_up' align='center' width='20'>백</td>
                                    <td class='border_up' align='center' width='20'>십</td>
                                    <td class='border_up' align='center' width='20'>만</td>
                                    <td class='border_up' align='center' width='20'>천</td>
                                    <td class='border_up' align='center' width='20'>백</td>
                                    <td class='border_up' align='center' width='20'>십</td>
                                    <td class='border_up' align='center' width='20'>일</td>

                                    <td class='border_up' align='center' width='20'>십</td>
                                    <td class='border_up' align='center' width='20'>억</td>
                                    <td class='border_up' align='center' width='20'>천</td>
                                    <td class='border_up' align='center' width='20'>백</td>
                                    <td class='border_up' align='center' width='20'>십</td>
                                    <td class='border_up' align='center' width='20'>만</td>
                                    <td class='border_up' align='center' width='20'>천</td>
                                    <td class='border_up' align='center' width='20'>백</td>
                                    <td class='border_up' align='center' width='20'>십</td>
                                    <td class='border_up' align='center' width='20'>일</td>
                                    <td class='border_top reset' align='center' width='156' rowspan='2'>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class='border_up reset' align='center' width='85' height='25' id="date0"> &nbsp; </td>
                                    <td class='border_up reset' align='center' width='35' id="number0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price0_11">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price0_10">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price0_9">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price0_8">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price0_7">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price0_6">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price0_5">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price0_4">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price0_3">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price0_2">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="price0_1">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice0_10">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice0_9">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice0_8">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice0_7">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice0_6">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice0_5">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice0_4">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice0_3">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice0_2">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='20' id="sprice0_1">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width='100%'>
                            <table cellpadding='0' cellspacing='0' width='700'>
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
                                    <td class='border_up reset' align='center' width='50' height='25' id="item_date1_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='195' id="item_name1_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='42' id="item_etc1_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='65' id="item_cnt1_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='55' id="item_price1_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='150' id="item_oprice1_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='83' id="item_sprice1_0">&nbsp;</td>
                                    <td class='border_top reset' align='center' width='60' id="item_msg1_0">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class='border_up reset' align='center' width='50' height='25' id="item_date2_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='195' id="item_name2_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='42' id="item_etc2_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='65' id="item_cnt2_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='55' id="item_price2_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='150' id="item_oprice2_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='83' id="item_sprice2_0">&nbsp;</td>
                                    <td class='border_top reset' align='center' width='60' id="item_msg2_0">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class='border_up reset' align='center' width='50' height='25' id="item_date3_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='195' id="item_name3_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='42' id="item_etc3_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='65' id="item_cnt3_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='55' id="item_price3_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='150' id="item_oprice3_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='83' id="item_sprice3_0">&nbsp;</td>
                                    <td class='border_top reset' align='center' width='60' id="item_msg3_0">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class='border_up reset' align='center' width='50' height='25' id="item_date4_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='195' id="item_name4_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='42' id="item_etc4_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='65' id="item_cnt4_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='55' id="item_price4_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='150' id="item_oprice4_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='83' id="item_sprice4_0">&nbsp;</td>
                                    <td class='border_top reset' align='center' width='60' id="item_msg4_0">&nbsp;</td>
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
                                    <td class='border_top' rowspan='2' align='center' width='143'>이 금액을 <span id="paytype0">&nbsp;  &nbsp; &nbsp; &nbsp;</span>함</td>
                                </tr>
                                <tr>
                                    <td class='border_up reset' align='center' width='122' height='25' id="totalprice0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='108' id="totalprice2_0">&nbsp;</td>
                                    <td class='border_up reset' align='center' width='108'>&nbsp;</td>
                                    <td class='border_up reset' align='center' width='108'>&nbsp;</td>
                                    <td class='border_up reset' align='center' width='108'>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>
            </div>
            <div class="register" style="text-align:center;margin-top:20px">
                <button class="btn btn-black btn-save" type="button" data-mbseq="<?=$mb_seq?>">저장</button>
                <button class="btn btn-default btn-delete" type="button">삭제</button>
            </div>
        </div>

    </div>
</div>

<script src="/assets/js/paymentView.js?date=<?=time()?>"></script>
<script>
$(function(){
    // $(".btn-add-bill").each(function(){
    //     if($(this).data("clcode") != ""){
    //         if($("#active_payment").val() == $(this).data("clcode")){
    //             // console.log($("#date"+$(this).data("clcode")).html());
    //             if($("#price"+$(this).data("clcode")+"_1").html() == "&nbsp;"){
    //                 $(this).trigger("click");
    //             }

    //         }else{
    //             $(this).hide();
    //         }
    //     }
    // })
    <?php foreach($claim_list as $key=>$row ): ?>
        getClaimDetail('<?=$row["cl_seq"]?>','<?=$key?>');
    <?php endforeach; ?>
})
</script>
