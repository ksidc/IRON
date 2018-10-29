<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<link rel='stylesheet' href="/assets/css/uniform.default.css">
<script src="/assets/js/jquery.uniform.js"></script>
<script src="/assets/js/moment.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>

<div style="background:#fff;width:100%;overflow-x:hidden">
    
   <div style="padding:5px">
        <div style="width:48%;float:left;vertical-align:top">
            <div class="modal-title">
                <div class="modal-title-text">세금 계산서 설정</div>
            </div>
            <div style="clear:both;font-size:12px;padding:10px 0px 5px 15px">
                <p>납부 방법, 개월수, 청구일, 결제일, 계산서 발행 방식이 같은 경우 계산서를 묶을 수 있습니다.</p>
                <p>설정 시, 기존 청구 등록된 항목에는 반영되지 않고 이후 청구 등록부터 반영됩니다.</p>
                <p>계산서가 영수발행인 경우, 청구 내역을 삭제하고 다시 청구하면 설정 내용으로 반영됩니다.</p>
            </div>
            <div style="font-size:12px;">▶ 1단계 - 계산서를 묶음 발행할 서비스를 선택</div>
            <div class="table-list" style="margin-top:5px;height:250px;overflow:auto">
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
                            <td><?=($row["sva_seq"] != "" ? $row["sva_number"]:$row["sv_number"])?></td>
                            <td>
                                <?php if($row["sv_payment_type"] == "1"): ?>
                                무통장
                                <?php elseif($row["sv_payment_type"] == "2"): ?>
                                카드
                                <?php else: ?>
                                CMS
                                <?php endif; ?>
                            </td>
                            <td><?=$row["svp_payment_period"]?>개월</td>
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
            <div style="font-size:12px;">▶ 2단계 - 계산서 품목 설정</div>
            <div class="table-list after-header-list" style="margin-top:5px;height:250px;overflow:auto">
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

        <div style="width:51%;display:inline-block;float:right;">
            <div class="modal-title">
                <div class="modal-title-text">설정 값 미리보기</div>
            </div>
            <div class="add-tab content-tab" style="width:87%;padding:5px 0px">
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
                    <li class="content-tab-item active" data-index="0" data-clseq="">계산서1</li>
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
                            <table cellpadding='0' cellspacing='0' height='35' width='100%'>
                                <tr>
                                    <td align='center' width='460' class='sur_border_bottom2' style="font-size:21px"><b>전자세금계산서</b></td>
                                    
                                    <td align='center' width='85' class='sur_border_bottom2 sur_border_left'>승인번호</td>
                                    <td  align='right' class='sur_border_bottom2 sur_border_left'></td>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding='0' cellspacing='0' width='700'>
                                <tr>
                                    <td class=' sur_border_bottom2' align='center' width='17' rowspan='7'>공<br><br><br>급<br><br><br>자</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>등록번호</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='278' colspan='5'><?=$eosec_view["mb_number"]?></td>
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='17' rowspan='7'>공<br>급<br>받<br>는<br>자</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>등록번호</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='278' colspan='5'><?=$member_view["mb_number"]?></td>
                                </tr>
                                <tr>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>상 호<br>(법인명)</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='160' colspan='3'><?=$eosec_view["mb_name"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>성<br>명</td>
                                    <td class='sur_border_left sur_border_bottom' align='right' width='94' colspan='1'><?=$eosec_view["mb_ceo"]?> (인)</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>상 호<br>(법인명)</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='160' colspan='3'><?=$member_view["mb_name"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>성<br>명</td>
                                    <td class='sur_border_left sur_border_bottom' align='right' width='94' colspan='1'><?=$member_view["mb_ceo"]?> (인)</td>
                                </tr>
                                <tr>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>사업장<br>주  소</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='278' colspan='5'><?=$eosec_view["mb_address"]?> <?=$eosec_view["mb_detail_address"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>사업장<br>주  소</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='278' colspan='5'><?=$member_view["mb_address"]?> <?=$member_view["mb_detail_address"]?></td>
                                </tr>
                                <tr>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>업  태</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='148' colspan='1'><?=$eosec_view["mb_business_conditions"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>종<br>목</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='106' colspan='3'><?=$eosec_view["mb_business_type"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>업 &nbsp; 태</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='148' colspan='1'><?=$member_view["mb_business_conditions"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>종<br>목</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='106' colspan='3'><?=$member_view["mb_business_type"]?></td>
                                </tr>
                                <tr>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>담당부서</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='148' colspan='1'><?=$eosec_view["mb_payment_team"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>성명</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='106' colspan='3'><?=$eosec_view["mb_payment_name"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>담당부서</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='148' colspan='1'><?=$member_view["mb_payment_team"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>성명</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='106' colspan='3'><?=$member_view["mb_payment_name"]?></td>
                                </tr>
                                <tr>
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='55' height='53' rowspan=2>이메일</td>
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='266' colspan='5' rowspan=2><?=$eosec_view["mb_payment_email"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>이메일</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='266' colspan='5'><?=$member_view["mb_payment_email"]?></td>
                                </tr>
                                <tr>

                                    <td class='sur_border_left sur_border_bottom2' align='center' width='55'>이메일</td>
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='266' colspan='5'></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width='100%'>
                            <table cellpadding='0' cellspacing='0' width='700'>
                                <tr>
                                    <td class='sur_border_bottom' align='center' width='120' height='21'>작성일자</td>
                                    <td class='sur_border_left sur_border_bottom'  width='70' align='center'>공란수</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='175' height='15'>공급가액</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='130' height='15'>세액</td>
                                    <td class='sur_border_left sur_border_bottom' align='center''>비고</td>
                                </tr>
                                <tr>
                                    <td class='sur_border_bottom2' align='center' height='21'><?=date("Y년 m월 d일")?></td>
                                    <td class='sur_border_left sur_border_bottom2' align='center' id="number<?=$key?>"></td>
                                    <td class='sur_border_left sur_border_bottom2 right' align='center' id="top_totalprice<?=$key?>"></td>
                                    <td class='sur_border_left sur_border_bottom2 right' align='center' id="top_surtax<?=$key?>"></td>
                                    
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' >&nbsp;</td>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width='100%'>
                            <table cellpadding='0' cellspacing='0' width='700'>
                                <tr>
                                    <td class='sur_border_bottom' align='center' width='25' height='21'>월</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='25'>일</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='230'>품 &nbsp; &nbsp; &nbsp; 목</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='42'>규 격</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='65'>수 량</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>단 가</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='150'>공급가액</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='83'>세 액</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='60'>비고</td>
                                </tr>
                                <tr>
                                    <td class=' sur_border_bottom reset' align='center' width='25' height='25' id="item_date1_1_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='25' height='25' id="item_date1_2_<?=$key?>"></td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='195' id="item_name1_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='42' id="item_etc1_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='65' id="item_cnt1_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='55' id="item_price1_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='150' id="item_oprice1_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='83' id="item_sprice1_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='60' id="item_msg1_<?=$key?>">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class=' sur_border_bottom reset' align='center' width='25' height='25' id="item_date2_1_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='25' height='25' id="item_date2_2_<?=$key?>"></td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='195' id="item_name2_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='42' id="item_etc2_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='65' id="item_cnt2_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='55' id="item_price2_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='150' id="item_oprice2_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='83' id="item_sprice2_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='60' id="item_msg2_<?=$key?>">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class=' sur_border_bottom reset' align='center' width='25' height='25' id="item_date3_1_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='25' height='25' id="item_date3_2_<?=$key?>"></td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='195' id="item_name3_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='42' id="item_etc3_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='65' id="item_cnt3_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='55' id="item_price3_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='150' id="item_oprice3_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='83' id="item_sprice3_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='60' id="item_msg3_<?=$key?>">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class=' sur_border_bottom2 reset' align='center' width='25' height='25' id="item_date4_1_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='25' height='25' id="item_date4_2_<?=$key?>"></td>
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='195' id="item_name4_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='42' id="item_etc4_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='65' id="item_cnt4_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='55' id="item_price4_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset right' align='center' width='150' id="item_oprice4_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset right' align='center' width='83' id="item_sprice4_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='60' id="item_msg4_<?=$key?>">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width='100%'>
                            <table cellpadding='0' cellspacing='0' width='700'>
                                <tr align='justify'>
                                    <td class='sur_border_bottom' align='center' width='137' height='2' >합계금액</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='108'>현 &nbsp; &nbsp; 금</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='108'>수 &nbsp; &nbsp; 표</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='108'>어 &nbsp; &nbsp; 음</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='108'>외상미수금</td>
                                    <td class='sur_border_left ' rowspan='2' align='center' width='139'>이 금액을 <span id="paytype<?=$key?>" style="font-size:15px">&nbsp;  &nbsp; &nbsp; &nbsp;</span>함</td>
                                </tr>
                                <tr>
                                    <td class='  reset right' align='center' width='122' height='25' id="totalprice1_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left  reset right' align='center' width='108' id="totalprice2_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left  reset right' align='center' width='108' id="totalprice3_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left  reset right' align='center' width='108' id="totalprice4_<?=$key?>">&nbsp;</td>
                                    <td class='sur_border_left  reset right' align='center' width='108' id="totalprice5_<?=$key?>">&nbsp;</td>
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
                            <table cellpadding='0' cellspacing='0' height='35' width='100%'>
                                <tr>
                                    <td align='center' width='460' class='sur_border_bottom2' style="font-size:21px"><b>전자세금계산서</b></td>
                                    
                                    <td align='center' width='85' class='sur_border_bottom2 sur_border_left'>승인번호</td>
                                    <td  align='right' class='sur_border_bottom2 sur_border_left'></td>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding='0' cellspacing='0' width='700'>
                                <tr>
                                    <td class=' sur_border_bottom2' align='center' width='17' rowspan='7'>공<br><br><br>급<br><br><br>자</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>등록번호</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='278' colspan='5'><?=$eosec_view["mb_number"]?></td>
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='17' rowspan='7'>공<br>급<br>받<br>는<br>자</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>등록번호</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='278' colspan='5'><?=$member_view["mb_number"]?></td>
                                </tr>
                                <tr>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>상 호<br>(법인명)</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='160' colspan='3'><?=$eosec_view["mb_name"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>성<br>명</td>
                                    <td class='sur_border_left sur_border_bottom' align='right' width='94' colspan='1'><?=$eosec_view["mb_ceo"]?> (인)</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>상 호<br>(법인명)</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='160' colspan='3'><?=$member_view["mb_name"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>성<br>명</td>
                                    <td class='sur_border_left sur_border_bottom' align='right' width='94' colspan='1'><?=$member_view["mb_ceo"]?> (인)</td>
                                </tr>
                                <tr>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>사업장<br>주  소</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='278' colspan='5'><?=$eosec_view["mb_address"]?> <?=$eosec_view["mb_detail_address"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>사업장<br>주  소</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='278' colspan='5'><?=$member_view["mb_address"]?> <?=$member_view["mb_detail_address"]?></td>
                                </tr>
                                <tr>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>업  태</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='148' colspan='1'><?=$eosec_view["mb_business_conditions"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>종<br>목</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='106' colspan='3'><?=$eosec_view["mb_business_type"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>업 &nbsp; 태</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='148' colspan='1'><?=$member_view["mb_business_conditions"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>종<br>목</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='106' colspan='3'><?=$member_view["mb_business_type"]?></td>
                                </tr>
                                <tr>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>담당부서</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='148' colspan='1'><?=$eosec_view["mb_payment_team"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>성명</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='106' colspan='3'><?=$eosec_view["mb_payment_name"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>담당부서</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='148' colspan='1'><?=$member_view["mb_payment_team"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>성명</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='106' colspan='3'><?=$member_view["mb_payment_name"]?></td>
                                </tr>
                                <tr>
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='55' height='53' rowspan=2>이메일</td>
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='266' colspan='5' rowspan=2><?=$eosec_view["mb_payment_email"]?></td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>이메일</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='266' colspan='5'><?=$member_view["mb_payment_email"]?></td>
                                </tr>
                                <tr>

                                    <td class='sur_border_left sur_border_bottom2' align='center' width='55'>이메일</td>
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='266' colspan='5'></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width='100%'>
                            <table cellpadding='0' cellspacing='0' width='700'>
                                <tr>
                                    <td class='sur_border_bottom' align='center' width='120' height='21'>작성일자</td>
                                    <td class='sur_border_left sur_border_bottom'  width='70' align='center'>공란수</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='175' height='15'>공급가액</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='130' height='15'>세액</td>
                                    <td class='sur_border_left sur_border_bottom' align='center''>비고</td>
                                </tr>
                                <tr>
                                    <td class='sur_border_bottom2' align='center' height='21'><?=date("Y년 m월 d일")?></td>
                                    <td class='sur_border_left sur_border_bottom2' align='center' id="number0"></td>
                                    <td class='sur_border_left sur_border_bottom2 right' align='center' id="top_totalprice0"></td>
                                    <td class='sur_border_left sur_border_bottom2 right' align='center' id="top_surtax0"></td>
                                    
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' >&nbsp;</td>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width='100%'>
                            <table cellpadding='0' cellspacing='0' width='700'>
                                <tr>
                                    <td class='sur_border_bottom' align='center' width='25' height='21'>월</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='25'>일</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='230'>품 &nbsp; &nbsp; &nbsp; 목</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='42'>규 격</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='65'>수 량</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>단 가</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='150'>공급가액</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='83'>세 액</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='60'>비고</td>
                                </tr>
                                <tr>
                                    <td class=' sur_border_bottom reset' align='center' width='25' height='25' id="item_date1_1_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='25' height='25' id="item_date1_2_0"></td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='195' id="item_name1_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='42' id="item_etc1_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='65' id="item_cnt1_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='55' id="item_price1_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='150' id="item_oprice1_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='83' id="item_sprice1_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='60' id="item_msg1_0">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class=' sur_border_bottom reset' align='center' width='25' height='25' id="item_date2_1_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='25' height='25' id="item_date2_2_0"></td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='195' id="item_name2_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='42' id="item_etc2_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='65' id="item_cnt2_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='55' id="item_price2_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='150' id="item_oprice2_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='83' id="item_sprice2_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='60' id="item_msg2_0">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class=' sur_border_bottom reset' align='center' width='25' height='25' id="item_date3_1_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='25' height='25' id="item_date3_2_0"></td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='195' id="item_name3_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='42' id="item_etc3_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='65' id="item_cnt3_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='55' id="item_price3_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='150' id="item_oprice3_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='83' id="item_sprice3_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='60' id="item_msg3_0">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class=' sur_border_bottom2 reset' align='center' width='25' height='25' id="item_date4_1_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='25' height='25' id="item_date4_2_0"></td>
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='195' id="item_name4_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='42' id="item_etc4_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='65' id="item_cnt4_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='55' id="item_price4_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset right' align='center' width='150' id="item_oprice4_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset right' align='center' width='83' id="item_sprice4_0">&nbsp;</td>
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='60' id="item_msg4_0">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width='100%'>
                            <table cellpadding='0' cellspacing='0' width='700'>
                                <tr align='justify'>
                                    <td class='sur_border_bottom' align='center' width='137' height='2' >합계금액</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='108'>현 &nbsp; &nbsp; 금</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='108'>수 &nbsp; &nbsp; 표</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='108'>어 &nbsp; &nbsp; 음</td>
                                    <td class='sur_border_left sur_border_bottom' align='center' width='108'>외상미수금</td>
                                    <td class='sur_border_left ' rowspan='2' align='center' width='139'>이 금액을 <span id="paytype0" style="font-size:15px">&nbsp;  &nbsp; &nbsp; &nbsp;</span>함</td>
                                </tr>
                                <tr>
                                    <td class='  reset right' align='center' width='122' height='25' id="totalprice1_0">&nbsp;</td>
                                    <td class='sur_border_left  reset right' align='center' width='108' id="totalprice2_0">&nbsp;</td>
                                    <td class='sur_border_left  reset right' align='center' width='108' id="totalprice3_0">&nbsp;</td>
                                    <td class='sur_border_left  reset right' align='center' width='108' id="totalprice4_0">&nbsp;</td>
                                    <td class='sur_border_left  reset right' align='center' width='108' id="totalprice5_0">&nbsp;</td>
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
<script>
    var addList = [];
    addList[0] = [];
</script>
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
        addList[<?=$key?>] = [];
        getClaimDetail('<?=$row["cl_seq"]?>','<?=$key?>');
    <?php endforeach; ?>

    $("body").on("click",".content-tab-item",function(){
        if($(this).hasClass("add")){
            $(".payment_claim").hide();
            var length = $(".payment_claim").length;
            addList[length] = [];
            var html = "<table width='700' cellpadding='0' cellspacing='0' align='center' class='border_all payment_claim' data-seq='' id='payment"+length+"' >\
                    <tr>\
                        <td width='100%'>\
                            <table cellpadding='0' cellspacing='0' height='35' width='100%'>\
                                <tr>\
                                    <td align='center' width='460' class='sur_border_bottom2' style='font-size:21px'><b>전자세금계산서</b></td>\
                                    <td align='center' width='85' class='sur_border_bottom2 sur_border_left'>승인번호</td>\
                                    <td  align='right' class='sur_border_bottom2 sur_border_left'></td>\
                                </tr>\
                            </table>\
                        </td>\
                    </tr>\
                    <tr>\
                        <td>\
                            <table cellpadding='0' cellspacing='0' width='700'>\
                                <tr>\
                                    <td class=' sur_border_bottom2' align='center' width='17' rowspan='7'>공<br><br><br>급<br><br><br>자</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>등록번호</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='278' colspan='5'><?=$eosec_view["mb_number"]?></td>\
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='17' rowspan='7'>공<br>급<br>받<br>는<br>자</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>등록번호</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='278' colspan='5'><?=$member_view["mb_number"]?></td>\
                                </tr>\
                                <tr>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>상 호<br>(법인명)</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='160' colspan='3'><?=$eosec_view["mb_name"]?></td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>성<br>명</td>\
                                    <td class='sur_border_left sur_border_bottom' align='right' width='94' colspan='1'><?=$eosec_view["mb_ceo"]?> (인)</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>상 호<br>(법인명)</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='160' colspan='3'><?=$member_view["mb_name"]?></td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>성<br>명</td>\
                                    <td class='sur_border_left sur_border_bottom' align='right' width='94' colspan='1'><?=$member_view["mb_ceo"]?> (인)</td>\
                                </tr>\
                                <tr>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>사업장<br>주  소</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='278' colspan='5'><?=$eosec_view["mb_address"]?> <?=$eosec_view["mb_detail_address"]?></td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>사업장<br>주  소</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='278' colspan='5'><?=$member_view["mb_address"]?> <?=$member_view["mb_detail_address"]?></td>\
                                </tr>\
                                <tr>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>업  태</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='148' colspan='1'><?=$eosec_view["mb_business_conditions"]?></td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>종<br>목</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='106' colspan='3'><?=$eosec_view["mb_business_type"]?></td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>업 &nbsp; 태</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='148' colspan='1'><?=$member_view["mb_business_conditions"]?></td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>종<br>목</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='106' colspan='3'><?=$member_view["mb_business_type"]?></td>\
                                </tr>\
                                <tr>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55' height='33'>담당부서</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='148' colspan='1'><?=$eosec_view["mb_payment_team"]?></td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>성명</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='106' colspan='3'><?=$eosec_view["mb_payment_name"]?></td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>담당부서</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='148' colspan='1'><?=$member_view["mb_payment_team"]?></td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='12' colspan='1'>성명</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='106' colspan='3'><?=$member_view["mb_payment_name"]?></td>\
                                </tr>\
                                <tr>\
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='55' height='53' rowspan=2>이메일</td>\
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='266' colspan='5' rowspan=2><?=$eosec_view["mb_payment_email"]?></td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>이메일</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='266' colspan='5'><?=$member_view["mb_payment_email"]?></td>\
                                </tr>\
                                <tr>\
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='55'>이메일</td>\
                                    <td class='sur_border_left sur_border_bottom2' align='center' width='266' colspan='5'></td>\
                                </tr>\
                            </table>\
                        </td>\
                    </tr>\
                    <tr>\
                        <td width='100%'>\
                            <table cellpadding='0' cellspacing='0' width='700'>\
                                <tr>\
                                    <td class='sur_border_bottom' align='center' width='120' height='21'>작성일자</td>\
                                    <td class='sur_border_left sur_border_bottom'  width='70' align='center'>공란수</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='175' height='15'>공급가액</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='130' height='15'>세액</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center''>비고</td>\
                                </tr>\
                                <tr>\
                                    <td class='sur_border_bottom2' align='center' height='21'><?=date("Y년 m월 d일")?></td>\
                                    <td class='sur_border_left sur_border_bottom2' align='center' id='number"+length+"'></td>\
                                    <td class='sur_border_left sur_border_bottom2 right' align='center' id='top_totalprice"+length+"'></td>\
                                    <td class='sur_border_left sur_border_bottom2 right' align='center' id='top_surtax"+length+"'></td>\
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' >&nbsp;</td>\
                                </tr>\
                            </table>\
                        </td>\
                    </tr>\
                    <tr>\
                        <td width='100%'>\
                            <table cellpadding='0' cellspacing='0' width='700'>\
                                <tr>\
                                    <td class='sur_border_bottom' align='center' width='25' height='21'>월</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='25'>일</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='230'>품 &nbsp; &nbsp; &nbsp; 목</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='42'>규 격</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='65'>수 량</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='55'>단 가</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='150'>공급가액</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='83'>세 액</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='60'>비고</td>\
                                </tr>\
                                <tr>\
                                    <td class=' sur_border_bottom reset' align='center' width='25' height='25' id='item_date1_1_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='25' height='25' id='item_date1_2_"+length+"'></td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='195' id='item_name1_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='42' id='item_etc1_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='65' id='item_cnt1_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='55' id='item_price1_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='150' id='item_oprice1_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='83' id='item_sprice1_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='60' id='item_msg1_"+length+"'>&nbsp;</td>\
                                </tr>\
                                <tr>\
                                    <td class=' sur_border_bottom reset' align='center' width='25' height='25' id='item_date2_1_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='25' height='25' id='item_date2_2_"+length+"'></td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='195' id='item_name2_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='42' id='item_etc2_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='65' id='item_cnt2_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='55' id='item_price2_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='150' id='item_oprice2_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='83' id='item_sprice2_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='60' id='item_msg2_"+length+"'>&nbsp;</td>\
                                </tr>\
                                <tr>\
                                    <td class=' sur_border_bottom reset' align='center' width='25' height='25' id='item_date3_1_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='25' height='25' id='item_date3_2_"+length+"'></td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='195' id='item_name3_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='42' id='item_etc3_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='65' id='item_cnt3_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='55' id='item_price3_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='150' id='item_oprice3_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset right' align='center' width='83' id='item_sprice3_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom reset' align='center' width='60' id='item_msg3_"+length+"'>&nbsp;</td>\
                                </tr>\
                                <tr>\
                                    <td class=' sur_border_bottom2 reset' align='center' width='25' height='25' id='item_date4_1_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='25' height='25' id='item_date4_2_"+length+"'></td>\
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='195' id='item_name4_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='42' id='item_etc4_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='65' id='item_cnt4_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='55' id='item_price4_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom2 reset right' align='center' width='150' id='item_oprice4_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom2 reset right' align='center' width='83' id='item_sprice4_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left sur_border_bottom2 reset' align='center' width='60' id='item_msg4_"+length+"'>&nbsp;</td>\
                                </tr>\
                            </table>\
                        </td>\
                    </tr>\
                    <tr>\
                        <td width='100%'>\
                            <table cellpadding='0' cellspacing='0' width='700'>\
                                <tr align='justify'>\
                                    <td class='sur_border_bottom' align='center' width='137' height='2' >합계금액</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='108'>현 &nbsp; &nbsp; 금</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='108'>수 &nbsp; &nbsp; 표</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='108'>어 &nbsp; &nbsp; 음</td>\
                                    <td class='sur_border_left sur_border_bottom' align='center' width='108'>외상미수금</td>\
                                    <td class='sur_border_left ' rowspan='2' align='center' width='139'>이 금액을 <span id='paytype"+length+"' style='font-size:15px'>&nbsp;  &nbsp; &nbsp; &nbsp;</span>함</td>\
                                </tr>\
                                <tr>\
                                    <td class='  reset right' align='center' width='122' height='25' id='totalprice1_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left  reset right' align='center' width='108' id='totalprice2_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left  reset right' align='center' width='108' id='totalprice3_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left  reset right' align='center' width='108' id='totalprice4_"+length+"'>&nbsp;</td>\
                                    <td class='sur_border_left  reset right' align='center' width='108' id='totalprice5_"+length+"'>&nbsp;</td>\
                                </tr>\
                            </table>\
                        </td>\
                    </tr>\
                </table>";


            $("#payment").append(html);
            var addhtml = '<form id="addClaim'+length+'">\
                <table class="table table_claim" id="table'+length+'" style="display:none">\
                    <thead>\
                        <tr>\
                            <th>서비스번호</th>\
                            <th>납부방법</th>\
                            <th>청구일</th>\
                            <th>TaxCode</th>\
                            <th>품목번호</th>\
                            <th>품목대표</th>\
                            <th>계약서 품목명</th>\
                            <th></th>\
                        </tr>\
                    </thead>\
                    <tbody id="after-list'+length+'">\
                    </tbody>\
                </table>\
                </form>\
            ';

            $(".after-header-list").append(addhtml);
            // $(".border_all").last().attr("id","payment"+length);
            // $(".border_all").last().addClass("payment_claim");
            $(this).before("<li class='content-tab-item' data-index='"+length+"'>계산서"+(length+1)+"</li>")
        }else{

            $(".content-tab-item").removeClass("active");
            $(this).addClass("active");
            var index = $(this).data("index");
            var clseq = $(this).data("clseq");
            console.log(index);
            $("#active_payment").val(index);
            $(".payment_claim").hide();
            $(".table_claim").hide();
            $("#payment"+index).show();
            $("#table"+index).show();
            $("#cl_seq").val(clseq);
            // $("#after-list").html("");
            // addList = [];
            // $(".btn-add-bill").each(function(){
            //     if($(this).data("clcode") != ""){
            //         // console.log($(this).data("clcode"));
            //         if($("#active_payment").val() == $(this).data("clcode")){
            //             // console.log("111>>>>>>>"+$("#active_payment").val());
            //             $("#payment"+$("#active_payment").val()).find(".reset").html("");
            //             // if($("#price"+$(this).data("clcode")+"_1").html() == "&nbsp;"){
            //             $(this).trigger("click");
            //             // }
            //         }else{
            //             $(this).hide();
            //         }
            //     }
            // })
            // $("#pc_seq").val($(this).data("pcseq"));
            // getList();
            // getItemList();
            setPayment();
        }
    })
})
</script>
