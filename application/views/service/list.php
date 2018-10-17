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
<script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
<script src="/assets/js/service.js?date=<?=time()?>"></script>
<style>
.basic {display:none;}
.payment {display:none;}
</style>
<div class="content">
    <h2 class="title">
        <i class="fa fa-file"></i> 서비스 관리
    </h2>
    <div class="search">
        <form name="searchForm" id="searchForm" onsubmit="return getList();">

            <div style="position:relative">
                <ul>
                    <li style="float:left;border:1px solid #ddd;padding:7px 20px;cursor:pointer" onclick="$('#detailSearchView').toggle();">
                        서비스 검색 <i class="fa fa-caret-down" aria-hidden="true"></i>
                    </li>
                    <li style="float:left;padding:7px 0px 0px 10px"><input type="checkbox" name="detailcheck" value="Y" id="detailcheck"> 상세검색</li>
                </ul>


                <div id="detailSearchView" style="position:absolute;top:30px;background:#fff;width:800px;display:none">
                    <div style="border:1px solid #ddd;padding:10px" >
                        <div><input type="text" name="searchword" style="width:90%" onkeyup="search(this.value)"></div>
                        <div style="height:600px;overflow:auto;">
                            <div style="padding-top:10px;font-weight:900" id="yesresult">
                                <input type="checkbox" id="allcheck"> <전체선택>
                            </div>
                            <div style="padding-top:10px;display:none" id="noresult">
                                검색결과가 없습니다
                            </div>
                            <div id="detailSearch">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear:both;padding:5px 0px">
                서비스 상태
                <input type="checkbox" name="sv_status_all" id="sv_status_all" value="Y"> 전체 <input type="checkbox" name="sv_status[]" value='0' class="sv_status"> <span style="color:#9E0000">입금대기중</span> <input type="checkbox" name="sv_status[]" value='1' class="sv_status"> <span style="color:#0070C0">서비스준비중</span> <input type="checkbox" name="sv_status[]" value='2' class="sv_status"> <span style="color:#548235">서비스작업중</span> <input type="checkbox" name="sv_status[]" value='3' class="sv_status"> <span style="color:#000000">서비스중</span> <input type="checkbox" name="sv_status[]" value='4' class="sv_status"> <span style="color:#FF0000">서비스중지</span> <input type="checkbox" name="sv_status[]" value='5' class="sv_status"> <span style="color:#808080">서비스해지</span> <input type="checkbox" name="sv_status[]" value='6' class="sv_status"> <span style="color:#FF0000">직권중지</span> <input type="checkbox" name="sv_status[]" value='7' class="sv_status"> <span style="color:#808080">직권해지</span>
            </div>
            <div style="padding-bottom:5px">
                날짜 검색
                <input type="checkbox" name="sv_date_all" id="sv_date_all" value="Y"> 전체 <input type="checkbox" name="sv_date[]" value="sv_regdate" class="sv_date"> 서비스신청일 <input type="checkbox" name="sv_date[]" value="sv_service_start" class="sv_date"> 서비스개시일 <input type="checkbox" name="sv_date[]" value="sv_account_start" class="sv_date"> 과금시작일 <input type="checkbox" name="sv_date[]" value="sv_account_end" class="sv_date"> 과금만료일 <input type="checkbox" name="" class="sv_date"> 최종 결제일 <input type="checkbox" name="sv_date[]" value="sv_contract_start" class="sv_date"> 계약 시작일 <input type="checkbox" name="sv_date[]" value="sv_contract_end" class="sv_date"> 계약 만료일 <input type="checkbox" name="sv_date[]" value="sv_service_end" class="sv_date"> 계약 해지일 <input type="checkbox" name="sv_date[]" value="sv_service_stop" class="sv_date"> 직권 중지일 <input type="checkbox" name="sv_date[]" value="sv_service_end" class="sv_date"> 직권 해지일
            </div>
            <div style="text-align:right;padding:5px 10px 5px 0px;border-top:1px solid #ddd">
                <div class="form-group">
                    <input type="text" style="width:80px" name="startDate" id="startDate" class="datepicker3" value="2012-01-01"> ~ <input type="text" name="endDate" id="endDate" style="width:80px" class="datepicker3" value="<?=date('Y-m-d')?>">
                </div>
                <div class="form-group ml15" style="text-align:left">
                    <select id="searchType" name="searchType" class="select2" style="width:140px">
                        <option value="mb_name" selected>상호/이름</option>
                        <option value="mb_id">회원아이디</option>
                        <option value="sv_charger">사내담당자</option>
                        <option value="sv_code">계약번호</option>
                        <option value="sv_number">서비스번호</option>
                        <option value="pr_name">상품명</option>
                        <option value="es_phone">전화번호</option>
                        <option value="es_phone">휴대폰번호</option>
                        <option value="es_phone">이메일</option>
                        <option value="es_phone">계약담당자</option>
                        <option value="es_phone">요금담당자</option>
                        <option value="es_phone">사업자번호</option>
                    </select>

                    <input type="text" name="searchWord" id="searchWord">
                    <button class="btn btn-search btn-form-search" type="submit">검색</button>
                    <select class="select2" name="end" style="width:90px">
                        <option value="10">10라인</option>
                        <option value="20">20라인</option>
                        <option value="50">50라인</option>
                        <option value="100">100라인</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="list">
        <div class="top-button-group">
            <div class="btn-left">
                <button class="btn btn-default btn-apply" type="button">EXCEL</button>
            </div>
            <div class="btn-right">
                <button class="btn btn-black btn-add btn-basic-view" type="button">확장하기(기본)</button>
                <button class="btn btn-black btn-add btn-payment-view" type="button">확장하기(요금)</button>

            </div>
        </div>
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
                        <th style="cursor:pointer" class="allView" data-allview='N' title="부가 항목 보이기" rel="tooltip"><i class="fa fa-plus" ></i></th>
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
        <div class="bottom-button-group">
            <div class="btn-left">
                <button class="btn btn-default btn-apply" type="button">EXCEL</button>

            </div>

        </div>
    </div>
</div>
<input type="hidden" id="start" value=1>
<script>
    $(function(){
        getList()
        $.ajax({
            url : "/service/allCategory",
            type : 'GET',
            dataType : 'HTML',
            success:function(response){
                $("#detailSearch").html(response);
                $(".searchStep3").hide();
                $(".searchStep4").hide();
            }
        });
        $("#detailcheck").click(function(){
            if($(this).is(":checked")){
                $(".searchStep3").show();
                $(".searchStep4").show();
            }else{
                $(".searchStep3").hide();
                $(".searchStep4").hide();
            }
        })
        $("#allcheck").click(function(){
            if($(this).is(":checked")){
                $("#detailSearch").find("input:checkbox").each(function(){
                    if($(this).parent().css("display") != "none"){
                        $(this).prop("checked",true);
                    }
                })
                // $("#detailSearch").find("input:checkbox").prop("checked",true);
            }else{
                $("#detailSearch").find("input:checkbox").prop("checked",false);
            }
            getList();
        })

        $("body").on("click",".pc_seq",function(){
            if($(this).is(":checked")){
                $(this).parent().parent().find("input:checkbox").each(function(){
                    if($(this).parent().css("display") != "none"){
                        $(this).prop("checked",true);
                    }
                })
                // $(this).parent().parent().find("input:checkbox").prop("checked",true);
            }else{
                $(this).parent().parent().find("input:checkbox").prop("checked",false);
            }
            getList();
        });

        $("body").on("click",".pi_seq",function(){
            if($(this).is(":checked")){
                $(this).parent().find("input:checkbox").each(function(){
                    if($(this).parent().css("display") != "none"){
                        $(this).prop("checked",true);
                    }
                })
                // $(this).parent().find("input:checkbox").prop("checked",true);
            }else{
                $(this).parent().find("input:checkbox").prop("checked",false);
            }
            getList();
        })

        $("body").on("click",".pd_seq",function(){
            if($(this).is(":checked")){
                $(this).parent().find("input:checkbox").each(function(){
                    if($(this).parent().css("display") != "none"){
                        $(this).prop("checked",true);
                    }
                })
                // $(this).parent().find("input:checkbox").prop("checked",true);
            }else{
                $(this).parent().find("input:checkbox").prop("checked",false);
            }
            getList();
        })

        $("body").on("click",".ps_seq",function(){
            
            getList();
        })

        $(".btn-basic-view").click(function(){
            // console.log($(".basic").css("display"));
            if($(".basic").css("display") != "none"){
                $(".basic").hide();
                $(".addcol").attr("colspan",9);
                $(".addcol2").attr("colspan",9);
                $(this).html("확장하기(기본)");
            }else{
               $(".basic").show();
                $(".addcol").attr("colspan",13);
                $(".addcol2").attr("colspan",13);
                $(this).html("축소하기(기본)");
            }

        })

        $(".btn-payment-view").click(function(){
            if($(".payment").css("display") != "none"){
                $(".payment").hide();
                $(this).html("확장하기(요금)");
            }else{
                $(".payment").show();
                $(this).html("축소하기(요금)");
            }
        });

        $("body").on("click",".option_extend",function(){
            var seq = $(this).data("seq");
            // console.log($(this).text());
            if($(this).text() == " + "){
                $("#child_add_"+seq).show();
                $(this).text(" - ");
                $(this).attr("title","부가 항목 숨기기");
                var oneprice = $(this).parent().find(".oneprice").data("oneprice");
                var monthprice = $(this).parent().find(".monthprice").data("oneprice");
                $(this).parent().find(".oneprice").html($.number(oneprice)+" 원");
                $(this).parent().find(".monthprice").html($.number(monthprice)+" 원");
                var url = "/api/serviceAddList/"+seq;
                if($(".child_add_content_"+seq).length > 0){
                    $(".child_add_content_"+seq).show();
                }else{
                    $.ajax({
                        url : url,
                        type : 'GET',
                        dataType : 'JSON',
                        success:function(response){
                            console.log(response);
                            var html = "";
                            if($(".basic").css("display") != "none"){
                                var col = "13";

                            }else{
                                var col = "9";

                            }
                            $(".child_add_content_"+seq).remove();

                            for(var i = 0; i < response.length;i++){
                                
                                if(response[i].sv_status == "0"){
                                    var sv_status = '<span style="color:#9E0000">입금대기중</span>';
                                }else if(response[i].sv_status == "1"){
                                    var sv_status = '<span style="color:#0070C0">서비스준비중</span>';
                                }else if(response[i].sv_status == "2"){
                                    var sv_status = '<span style="color:#548235">서비스작업중</span>';
                                }else if(response[i].sv_status == "3"){
                                    var sv_status = '<span style="color:#000000">서비스중</span>';
                                }else if(response[i].sv_status == "4"){
                                    var sv_status = '<span style="color:#FF0000">서비스중지</span>';
                                }else if(response[i].sv_status == "5"){
                                    var sv_status = '<span style="color:#808080">서비스해지</span>';
                                }else if(response[i].sv_status == "6"){
                                    var sv_status = '<span style="color:#FF0000">직권중지</span>';
                                }else if(response[i].sv_status == "7"){
                                    var sv_status = '<span style="color:#808080">직권해지</span>';
                                }
                                // console.log(response[i].paymentinfo);
                                if(response[i].paymentinfo !== null){
                                    var paymentinfo = response[i].paymentinfo.split("|");
                                }else{
                                    var paymentinfo = [];
                                }

                                var pm_status = paymentinfo[0];
                                var pm_pay_period = paymentinfo[1];
                                var pm_date = paymentinfo[2];
                                var pm_end_date = paymentinfo[3];
                                var pm_input_date = paymentinfo[4];

                                if(pm_status == "0"){
                                    if(pm_pay_period > 1){
                                        var custom_end_date = moment(pm_date).add(1,'months').format("YYYY-MM-DD");
                                        if(moment().format("YYYY-MM-DD") >= custom_end_date){
                                            var payment_status = "<span style='color:#FF0000'>연체</span>";
                                        }else{
                                            if(pm_end_date >= moment().format("YYYY-MM-DD")){
                                                var payment_status = "<span style='color:#0070C0'>청구("+pm_pay_period+"개월)</span>";
                                            }else{
                                                var payment_status = "<span style='color:#FF0000'>미납("+pm_pay_period+"개월)</span>";
                                            }
                                        }
                                    }else{
                                        // 연체 로직 추가
                                        if(pm_end_date >= moment().format("YYYY-MM-DD")){
                                            var payment_status = "<span style='color:#0070C0'>청구("+pm_pay_period+"개월)</span>";
                                        }else{
                                            var payment_status = "<span style='color:#FF0000'>미납("+pm_pay_period+"개월)</span>";
                                        }

                                    }
                                }else if(pm_status == "9"){
                                    var payment_status = "<span style='color:#548235'>가결제("+pm_pay_period+"개월) " +pm_input_date+"</span>";
                                }else if(pm_status == "1"){
                                    var payment_status = "완납";
                                }else{
                                    var payment_status = "청구내역없음";
                                }

                                html += '<tr class="child_add_content_'+seq+'" style="border:0px">\
                                            <td colspan='+col+' class="addcol2"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9;text-align:left;padding-left:30px;" colspan=2>'+response[i].sva_name+'</td>\
                                            <td class="basic" style="border-bottom: 1px solid #d9d9d9"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_number+'</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9" >'+response[i].sva_claim_name+'</td>\
                                            <td class="payment payment2 right" style="border-bottom: 1px solid #d9d9d9">'+$.number(response[i].svp_once_price-response[i].svp_once_dis_price)+' 원</td>\
                                            <td class="payment payment2 right" style="border-bottom: 1px solid #d9d9d9">'+$.number(response[i].svp_month_price-response[i].svp_month_dis_price-(response[i].svp_discount_price/response[i].svp_payment_period))+' 원</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].svp_payment_period+'개월</td>\
                                            <td class="payment payment2 right" style="border-bottom: 1px solid #d9d9d9">'+$.number(response[i].sva_input_price)+' 원</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+(response[i].sva_input_unit != "" ? response[i].sva_input_unit:"1")+'개월</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].c_name+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+moment(response[i].sv_regdate).format("YYYY-MM-DD")+'<br>'+(response[i].sv_service_start !== null ? response[i].sv_service_start.substring(0,10):'')+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9" class="basic">'+response[i].sva_input_date+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+sv_status+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+moment(response[i].sv_account_start).format("YYYY-MM-DD")+'<br>'+moment(response[i].sv_account_end).format("YYYY-MM-DD")+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+payment_status+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                        </tr>';
                            }
                            $("#child_add_"+seq).after(html);
                            if($(".payment1").css("display") != "none"){
                                $(".payment2").show();
                            }
                            if($(".basic").css("display") != "none"){
                                $(".basic").show();

                            }
                            // console.log($(".basic").css("display"));
                            
                                
                        }
                    });
                }
            }else{
                $("#child_add_"+seq).hide();
                $(".child_add_content_"+seq).hide();
                $(this).text(" + ");
                var oneprice = $(this).parent().find(".oneprice").data("allprice");
                var monthprice = $(this).parent().find(".monthprice").data("allprice");
                $(this).parent().find(".oneprice").html($.number(oneprice));
                $(this).parent().find(".monthprice").html($.number(monthprice));
            }


        })

        $("#sv_status_all").click(function(){
            if($(this).is(":checked")){
                $(".sv_status").prop("checked",true);
            }else{
                $(".sv_status").prop("checked",false);
            }
        })

        $("#sv_date_all").click(function(){
            if($(this).is(":checked")){
                $(".sv_date").prop("checked",true);
            }else{
                $(".sv_date").prop("checked",false);
            }
        });

        $(".allView").click(function(){
            if($(this).data("allview") == "N"){
                $(this).data("allview","Y");
                $(this).html('<i class="fa fa-minus" ></i>');
                $(this).attr("title","부가 항목 숨기기");
                $(".option_extend").each(function(){
                    $(this).trigger("click");
                })
            }else{
                $(this).data("allview","N");
                $(this).html('<i class="fa fa-plus" ></i>');
                $(this).attr("title","부가 항목 보이기");
                $(".option_extend").each(function(){
                    $(this).trigger("click");
                })
            }

        })
        $.widget("ui.tooltip", $.ui.tooltip, {
             options: {
                 content: function () {
                     return $(this).prop('title');
                 }
             }
         });
        $( '[rel=tooltip]' ).tooltip({
            position: {
                my: "center bottom-10",
                at: "center top",
                using: function( position, feedback ) {
                    console.log(this);
                    $( this ).css( position );
                    $( "<div>" )
                        .addClass( "arrow" )
                        .addClass( feedback.vertical )
                        .addClass( feedback.horizontal )
                        .appendTo( this );
                }
            }
        });
    })

    function search(q){
        // console.log(q);
        $(".searchStep1").hide();
        $(".searchStep2").hide();
        $(".searchStep3").hide();
        $(".searchStep4").hide();
        var searchYn = false;
        $(".searchStep4").each(function(){
            var str = $(this).data("tag");
            var parent1 = $(this).data("parent1");
            var parent2 = $(this).data("parent2");
            var parent3 = $(this).data("parent3");
            var parent4 = $(this).data("parent4");
            // console.log(str.indexOf(q));
            if(str.indexOf(q) > -1){
                searchYn = true;
                $("#yesresult").show();
                $("#noresult").hide();
                if($("#detailcheck").is(":checked")){
                    if(parent4.indexOf(q) > -1){
                        $(this).parent().parent().parent().show();
                        $(this).parent().parent().show();
                        $(this).parent().show();
                        $(this).show();
                    }else if(parent3.indexOf(q) > -1){
                        $(this).parent().parent().parent().show();
                        $(this).parent().parent().show();
                        $(this).parent().show();
                    }else if(parent2.indexOf(q) > -1){
                        $(this).parent().parent().parent().show();
                        $(this).parent().parent().show();
                    }else if(parent1.indexOf(q) > -1){
                        $(this).parent().parent().parent().show();
                    }
                }else{
                    if(parent2.indexOf(q) > -1){
                        $(this).parent().parent().parent().show();
                        $(this).parent().parent().show();
                    }else if(parent1.indexOf(q) > -1){
                        $(this).parent().parent().parent().show();
                    }
                }

            }
        })
        if(!searchYn){
            $("#yesresult").hide();
            $("#noresult").show();
        }
    }

    function openProductView(sv_seq){
        var specs = "left=10,top=10,width=1000,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/service/product_view/"+sv_seq, 'serviceProductView', specs);
    }
    function getList(){
        var start = $("#start").val();
        // console.log(start);
        var end = 5;
        var url = "/api/serviceList/"+start+"/"+end;
        var searchForm = $("#searchForm").serialize();
        // console.log(searchForm);
        // console.log(url);
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : searchForm,
            success:function(response){
                console.log(response);
                var html = "";
                if($(".basic").css("display") != "none"){
                    var basicView = true;
                }else{
                    var basicView = false;
                }
                if($(".payment").css("display") != "none"){
                    var paymentView = true;
                }else{
                    var paymentView = false;
                }

                if(response.list.length > 0){
                    for(var i = 0; i < response.list.length;i++){
                        // console.log(start);
                        var num = parseInt(response.total) - ((start-1)*end) - i;
                        var startdate = new Date(response.list[i].sv_contract_start);
                        var enddate = new Date(response.list[i].sv_contract_end);
                        var diffenddate = moment(enddate).add(2,'days').format('YYYY-MM-DD');
                        // console.log(diffenddate);
                        var diff = Date.getFormattedDateDiff(startdate, diffenddate);

                        if(response.list[i].sv_rental == "N"){
                            var sv_rental = "-";
                        }else{
                            if(response.list[i].sv_rental_type == "1"){
                                var sv_rental = "영구임대";
                            }else{
                                var sv_rental = "소유권이전<br>("+response.list[i].sv_rental_date+"개월)";
                            }
                        }
                        if(response.list[i].sv_auto_extension == "1"){
                            var sv_auto = response.list[i].sv_auto_extension_month+"개월";
                            // var sv_auto_end = moment(response.list[i].sv_contract_end).add(response.list[i].sv_auto_extension_month,'months').format("YYYY-MM-DD")
                        }else{
                            var sv_auto = "-";
                            // var sv_auto_end = response.list[i].sv_contract_end;
                        }
                        if(response.list[i].sv_contract_extension_end != "0000-00-00"){
                            var sv_auto_end = response.list[i].sv_contract_extension_end;
                        }else{
                            var sv_auto_end = "";
                        }
                        if(response.list[i].priceinfo !== null){
                            var priceinfo = response.list[i].priceinfo.split("|");
                        }else{
                            var priceinfo = [0,0,0,0,0];
                        }
                        var firstPrice = parseInt(priceinfo[0])-parseInt(priceinfo[1]);
                        var monthPrice = parseInt(priceinfo[2])-parseInt(priceinfo[3])-parseInt(priceinfo[4]);

                        if(response.list[i].sv_status == "0"){
                            var sv_status = '<span style="color:#9E0000">입금대기중</span>';
                        }else if(response.list[i].sv_status == "1"){
                            var sv_status = '<span style="color:#0070C0">서비스준비중</span>';
                        }else if(response.list[i].sv_status == "2"){
                            var sv_status = '<span style="color:#548235">서비스작업중</span>';
                        }else if(response.list[i].sv_status == "3"){
                            var sv_status = '<span style="color:#000000">서비스중</span>';
                        }else if(response.list[i].sv_status == "4"){
                            var sv_status = '<span style="color:#FF0000">서비스중지</span>';
                        }else if(response.list[i].sv_status == "5"){
                            var sv_status = '<span style="color:#808080">서비스해지</span>';
                        }else if(response.list[i].sv_status == "6"){
                            var sv_status = '<span style="color:#FF0000">직권중지</span>';
                        }else if(response.list[i].sv_status == "7"){
                            var sv_status = '<span style="color:#808080">직권해지</span>';
                        }
                        if(response.list[i].paymentinfo !== null){
                            var paymentinfo = response.list[i].paymentinfo.split("|");
                        }else{
                            var paymentinfo = [];
                        }
                        var pm_status = paymentinfo[0];
                        var pm_pay_period = paymentinfo[1];
                        var pm_date = paymentinfo[2];
                        var pm_end_date = paymentinfo[3];
                        var pm_input_date = paymentinfo[4];

                        if(pm_status == "0"){
                            if(pm_pay_period > 1){
                                var custom_end_date = moment(pm_date).add(1,'months').format("YYYY-MM-DD");
                                if(moment().format("YYYY-MM-DD") >= custom_end_date){
                                    var payment_status = "<span style='color:#FF0000'>연체</span>";
                                }else{
                                    if(pm_end_date >= moment().format("YYYY-MM-DD")){
                                        var payment_status = "<span style='color:#0070C0'>청구("+pm_pay_period+"개월)</span>";
                                    }else{
                                        var payment_status = "<span style='color:#FF0000'>미납("+pm_pay_period+"개월)</span>";
                                    }
                                }
                            }else{
                                // 연체 로직 추가
                                if(pm_end_date >= moment().format("YYYY-MM-DD")){
                                    var payment_status = "<span style='color:#0070C0'>청구("+pm_pay_period+"개월)</span>";
                                }else{
                                    var payment_status = "<span style='color:#FF0000'>미납("+pm_pay_period+"개월)</span>";
                                }

                            }
                        }else if(pm_status == "9"){
                            var payment_status = "<span style='color:#548235'>가결제("+pm_pay_period+"개월) " +pm_input_date+"</span>";
                        }else if(pm_status == "1"){
                            var payment_status = "완납";
                        }else{
                            var payment_status = "청구내역없음";
                        }

                        if(response.list[i].sv_input_unit == 0){
                            var sv_input_unit = "구매";
                        }else if(response.list[i].sv_input_unit == 1){
                            var sv_input_unit = "월";
                        }else{
                            var sv_input_unit = "";
                        }

                        var file_array = [];
                        if(response.list[i].file1 != ""){
                            file_array.push("A");
                        }
                        if(response.list[i].file2 != ""){
                            file_array.push("R");
                        }
                        if(response.list[i].file3 != ""){
                            file_array.push("T");
                        }
                        if(response.list[i].file4 != ""){
                            file_array.push("I");
                        }
                        if(response.list[i].file6 != ""){
                            file_array.push("C");
                        }
                        if(response.list[i].file8 != ""){
                            file_array.push("O");
                        }

                        console.log(response.list[i].sv_service_start );
                        html += '<tr>\
                                    <td><input type="checkbox" class="listCheck" name="sv_seq[]" value="'+response.list[i].sv_seq+'"></td>\
                                    <td>'+num+'</td>\
                                    <td><a href="/member/view/'+response.list[i].mb_seq+'">'+response.list[i].mb_name+'</a></td>\
                                    <td class="basic">'+response.list[i].eu_name+'</td>\
                                    <td>'+response.list[i].sv_charger+'</td>\
                                    <td><a href="javascript:void(0)" onclick="openGroupView(\''+response.list[i].sv_code+'\')">'+response.list[i].sv_code+'</a></td>\
                                    <td>'+response.list[i].sv_contract_start+'</td>\
                                    <td class="basic">'+response.list[i].sv_contract_end+'</td>\
                                    <td>'+diff[0]+"개월 "+diff[1]+"일"+'</td>\
                                    <td class="basic">'+sv_auto+'</td>\
                                    <td class="basic">'+sv_auto_end+'</td>\
                                    <td>'+response.list[i].pc_name+'</td>\
                                    <td>'+response.list[i].pi_name+'</td>\
                                    <td '+(response.list[i].addoptionTotal > 0 ? "class=\"option_extend\"":"")+'  data-seq="'+response.list[i].sv_seq+'" style="cursor:pointer;width:30px;height:30px;background:#516381;font-size:16px;color:#fff;margin:2px'+(response.list[i].addoptionTotal > 0 ? "":";opacity:0")+'" title="부가 항목 보이기" rel="tooltip"> + </td>\
                                    <td><a href="javascript:void(0)" onclick="openProductView('+response.list[i].sv_seq+')">'+response.list[i].pr_name+'</a></td>\
                                    <td class="basic">'+response.list[i].pd_name+'</td>\
                                    <td>'+response.list[i].ps_name+'</td>\
                                    <td>'+sv_rental+'</td>\
                                    <td><a href="/service/view/'+response.list[i].sv_seq+'">'+response.list[i].sv_number+'</a></td>\
                                    <td class="payment">'+response.list[i].sv_claim_name+'</td>\
                                    <td class="payment oneprice right" data-oneprice="'+(response.list[i].svp_once_price-response.list[i].svp_once_dis_price)+'" data-allprice="'+firstPrice+'">'+$.number(firstPrice)+' 원</td>\
                                    <td class="payment monthprice right" data-oneprice="'+(response.list[i].svp_month_price-response.list[i].svp_month_dis_price-response.list[i].svp_discount_price)+'" data-allprice="'+monthPrice+'">'+$.number(monthPrice)+' 원</td>\
                                    <td class="payment">'+response.list[i].svp_payment_period+'개월</td>\
                                    <td class="payment right">'+$.number(response.list[i].sv_input_price)+' 원</td>\
                                    <td class="payment">'+sv_input_unit+'</td>\
                                    <td class="payment">'+response.list[i].c_name+'</td>\
                                    <td>'+moment(response.list[i].sv_regdate).format("YYYY-MM-DD")+'<br>'+(response.list[i].sv_service_start !== null ? response.list[i].sv_service_start.substring(0,10):'')+'</td>\
                                    <td class="basic">'+response.list[i].sv_out_date.substring(0,10)+'</td>\
                                    <td>'+sv_status+'</td>\
                                    <td>'+moment(response.list[i].sv_account_start).format("YYYY-MM-DD")+'<br>'+moment(response.list[i].sv_account_end).format("YYYY-MM-DD")+'</td>\
                                    <td>'+payment_status+'</td>\
                                    <td>'+file_array.join(" ")+'</td>\
                                </tr>\
                                <tr style="border-bottom:0px;display:none" id="child_add_'+response.list[i].sv_seq+'">\
                                    <td colspan=9 class="addcol"></td>\
                                    <th style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9;text-align:left;padding-left:30px" colspan=2>부가항목명</th>\
                                    <th class="basic" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9"></th>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9"></td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9"></td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">서비스번호</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">청구명</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">초기일회성</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">월(기준)요금</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">결제주기</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">매입가</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">매입 단위</td>\
                                    <td class="payment payment1" style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">매입처</td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">서비스신청일<br>서비스개시일</td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9" class="basic">제품출고일</td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">서비스상태</td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">과금시작일<br>과금만료일</td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9">결제상태</td>\
                                    <td style="background:#516381;color:#fff;border-bottom: 1px solid #d9d9d9s">문서</td>\
                                </tr>\
                                ';
                    }

                    $(".pagination-html").bootpag({
                        total : Math.ceil(parseInt(response.total)/5), // 총페이지수 (총 Row / list노출개수)
                        page : $("#start").val(), // 현재 페이지 default = 1
                        maxVisible:5, // 페이지 숫자 노출 개수
                        wrapClass : "pagination",
                        next : ">",
                        prev : "<",
                        nextClass : "last",
                        prevClass : "first",
                        activeClass : "active"

                    }).on('page', function(event,num){ // 이벤트 액션
                        // document.location.href='/pageName/'+num; // 페이지 이동
                        $("#start").val(num);
                        getList();
                    })
                }else{
                    html += '<tr><td colspan="17" style="text-align:center">서비스가 없습니다.</td></tr>';
                }
                $("#tbody-list").html(html);

                if($(".allView").data("allview") == "Y"){
                    
                    $(".option_extend").each(function(){
                        $(this).trigger("click");
                    })
                }

                if(basicView)
                    $(".basic").show();

                if(paymentView)
                    $(".payment").show();

                $.widget("ui.tooltip", $.ui.tooltip, {
                     options: {
                         content: function () {
                             return $(this).prop('title');
                         }
                     }
                 });
                $( '[rel=tooltip]' ).tooltip({
                    position: {
                        my: "center bottom-10",
                        at: "center top",
                        using: function( position, feedback ) {
                            console.log(this);
                            $( this ).css( position );
                            $( "<div>" )
                                .addClass( "arrow" )
                                .addClass( feedback.vertical )
                                .addClass( feedback.horizontal )
                                .appendTo( this );
                        }
                    }
                });
            }
        });
        return false;
    }

    Date.getFormattedDateDiff = function(date1, date2) {
        var b = moment(date1),
            a = moment(date2),
            intervals = ['months','days'],
            out = [];

        for(var i=0; i<intervals.length; i++){
            var diff = a.diff(b, intervals[i]);
            // console.log(diff);
            b.add(diff, intervals[i]);
            out.push(diff);
        }
        return out;
    };

    function openGroupView(sv_code){

        var specs = "left=10,top=10,width=1000,height=700";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=0";
        window.open("/service/numberGroupView/"+sv_code, 'serviceProductView', specs);
    }
</script>
