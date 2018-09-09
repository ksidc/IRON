
<!-- uniform 최신 jquery 오류 처리 include 파일 -->
<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="//dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
<link rel='stylesheet' href="/assets/css/uniform.default.css">
<script src="/assets/js/jquery.uniform.js"></script>
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
                <select class="select2" name="" style="width:120px">
                    <option value="">서비스검색</option>
                </select>
                <input type="checkbox" name="detailcheck" value="Y" id="detailcheck"> 상세검색

                <div style="position:absolute;background:#fff;width:400px;height:300px;overflow:auto;display:none">
                    <div style="border:1px solid #ddd;padding:10px" >
                        <div><input type="text" name="searchword" style="width:90%" onkeyup="search(this.value)"></div>
                        <div style="padding-top:10px">
                            <input type="checkbox" id="allcheck"> <전체선택>
                        </div>
                        <div id="detailSearch">

                        </div>
                    </div>
                </div>
            </div>
            <div style="padding:5px 0px">
                서비스 상태
                <input type="checkbox" name=""> 전체 <input type="checkbox" name=""> 입금대기중 <input type="checkbox" name=""> 서비스준비중 <input type="checkbox" name=""> 서비스작업중 <input type="checkbox" name=""> 서비스중 <input type="checkbox" name=""> 서비스중지 <input type="checkbox" name=""> 서비스해지 <input type="checkbox" name=""> 직권중지 <input type="checkbox" name=""> 직권해지
            </div>
            <div style="padding-bottom:5px">
                날짜 검색
                <input type="checkbox" name=""> 전체 <input type="checkbox" name=""> 서비스신청일 <input type="checkbox" name=""> 서비스개시일 <input type="checkbox" name=""> 과금시작일 <input type="checkbox" name=""> 과금만료일 <input type="checkbox" name=""> 최종 결제일 <input type="checkbox" name=""> 계약 시작일 <input type="checkbox" name=""> 계약 만료일 <input type="checkbox" name=""> 계약 해지일 <input type="checkbox" name=""> 직권 중지일 <input type="checkbox" name=""> 직권 해지일
            </div>
            <div style="text-align:right;padding:5px 10px 5px 0px;border-top:1px solid #ddd">
                <div class="form-group">
                    <label>등록일</label>
                    <input type="text" style="width:80px" name="startDate" id="startDate" class="datepicker" value="2012-01-01"> ~ <input type="text" name="endDate" id="endDate" style="width:80px" class="datepicker" value="<?=date('Y-m-d')?>">
                </div>
                <div class="form-group ml15" style="text-align:left">
                    <select id="searchType" name="searchType" class="select2" style="width:140px">
                        <option value="es_name" selected>상호/이름</option>
                        <option value="es_number">사내담당자</option>
                        <option value="es_mb_id">회원아이디</option>
                        <option value="es_charger">사내담당자</option>
                        <option value="es_tel">계약번호</option>
                        <option value="es_phone">서비스번호</option>
                        <option value="es_phone">상품명</option>
                        <option value="es_phone">전화번호</option>
                        <option value="es_phone">휴대폰번호</option>
                        <option value="es_phone">이메일</option>
                        <option value="es_phone">계약담당자</option>
                        <option value="es_phone">요금담당자</option>
                        <option value="es_phone">사업자번호</option>
                    </select>

                    <input type="text" name="searchWord" id="searchWord">
                    <button class="btn btn-search btn-form-search" type="submit">검색</button>
                    <select class="select2" name="" style="width:90px">
                        <option value="50">50라인</option>
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
            }

        });

        $("#allcheck").click(function(){
            if($(this).is(":checked")){
                $("#detailSearch").find("input:checkbox").prop("checked",true);
            }else{
                $("#detailSearch").find("input:checkbox").prop("checked",false);
            }
        })

        $("body").on("click",".pc_seq",function(){
            if($(this).is(":checked")){
                $(this).parent().parent().find("input:checkbox").prop("checked",true);
            }else{
                $(this).parent().parent().find("input:checkbox").prop("checked",false);
            }

        });

        $("body").on("click",".pi_seq",function(){
            if($(this).is(":checked")){
                $(this).parent().find("input:checkbox").prop("checked",true);
            }else{
                $(this).parent().find("input:checkbox").prop("checked",false);
            }

        })

        $("body").on("click",".pd_seq",function(){
            if($(this).is(":checked")){
                $(this).parent().find("input:checkbox").prop("checked",true);
            }else{
                $(this).parent().find("input:checkbox").prop("checked",false);
            }

        })

        $(".btn-basic-view").click(function(){
            if($(".basic").css("display") == ""){
                $(".basic").hide();
                $(".addcol").attr("colspan",9);
                $(".addcol2").attr("colspan",10);
                $(this).html("확장하기(기본)");
            }else{
               $(".basic").show();
                $(".addcol").attr("colspan",13);
                $(".addcol2").attr("colspan",14);
                $(this).html("축소하기(기본)");
            }

        })

        $(".btn-payment-view").click(function(){
            if($(".payment").css("display") == ""){
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
                var oneprice = $(this).parent().find(".oneprice").data("oneprice");
                var monthprice = $(this).parent().find(".monthprice").data("oneprice");
                $(this).parent().find(".oneprice").html(oneprice);
                $(this).parent().find(".monthprice").html(monthprice);
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
                                var col = "14";

                            }else{
                                var col = "10";

                            }
                            for(var i = 0; i < response.length;i++){
                                html += '<tr class="child_add_content_'+seq+'" style="border:0px">\
                                            <td colspan='+col+' class="addcol2"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_name+'</td>\
                                            <td class="basic" style="border-bottom: 1px solid #d9d9d9"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_number+'</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9" >'+response[i].sva_claim_name+'</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].svp_first_price+'</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+(response[i].svp_month_price-response[i].svp_month_dis_price-response[i].svp_discount_price)+'</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_pay_day+'</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_input_price+'</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].sva_input_unit+'</td>\
                                            <td class="payment payment2" style="border-bottom: 1px solid #d9d9d9">'+response[i].c_name+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+moment(response[i].sv_regdate).format("YYYY-MM-DD")+'<br></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9" class="basic">'+response[i].sva_input_date+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">등록</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9">'+moment(response[i].sv_account_start).format("YYYY-MM-DD")+'<br>'+moment(response[i].sv_account_end).format("YYYY-MM-DD")+'</td>\
                                            <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                            <td style="border-bottom: 1px solid #d9d9d9"></td>\
                                        </tr>';
                            }
                            $("#child_add_"+seq).after(html);
                            if($(".payment1").css("display") != "none"){
                                $(".payment2").show();
                            }
                        }
                    });
                }
            }else{
                $("#child_add_"+seq).hide();
                $(".child_add_content_"+seq).hide();
                $(this).text(" + ");
                var oneprice = $(this).parent().find(".oneprice").data("allprice");
                var monthprice = $(this).parent().find(".monthprice").data("allprice");
                $(this).parent().find(".oneprice").html(oneprice);
                $(this).parent().find(".monthprice").html(monthprice);
            }


        })
    })

    function search(q){
        console.log(q);
    }

    function getList(){
        var start = $("#start").val();
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

                var html = "";
                if(response.list.length > 0){
                    for(var i = 0; i < response.list.length;i++){
                        // console.log(start);
                        var num = parseInt(response.total) - ((start-1)*end) - i;
                        var startdate = new Date(response.list[i].sv_contract_start);
                        var enddate = new Date(response.list[i].sv_contract_end);
                        var diff = Date.getFormattedDateDiff(startdate, enddate);
                        if(response.list[i].sr_rental == "N"){
                            var sr_rental = "구매";
                        }else{
                            if(response.list[i].sr_rental_type == "1"){
                                var sr_rental = "영구임대";
                            }else{
                                var sr_rental = "소유권이전";
                            }
                        }
                        if(response.list[i].sr_auto_extension == "1"){
                            var sr_auto = response.list[i].sv_auto_extension_month;
                            var sr_auto_end = moment(response.list[i].sv_contract_end).add(sr_auto,'months').subtract(1, "days").format("YYYY-MM-DD")
                        }else{
                            var sr_auto = "-";
                            var sr_auto_end = response.list[i].sv_contract_end;
                        }
                        var priceinfo = response.list[i].priceinfo.split("|");
                        var firstPrice = priceinfo[0];
                        var monthPrice = parseInt(priceinfo[1])-parseInt(priceinfo[2])-parseInt(priceinfo[3]);


                        html += '<tr>\
                                    <td><input type="checkbox" class="listCheck" name="sr_seq[]" value="'+response.list[i].sv_seq+'"></td>\
                                    <td>'+num+'</td>\
                                    <td>'+response.list[i].mb_name+'</td>\
                                    <td>'+response.list[i].sv_charger+'</td>\
                                    <td class="basic">'+response.list[i].eu_name+'</td>\
                                    <td>'+response.list[i].sv_code+'</td>\
                                    <td>'+response.list[i].sv_contract_start+'</td>\
                                    <td class="basic">'+response.list[i].sv_contract_end+'</td>\
                                    <td>'+diff[0]+"개월 "+diff[1]+"일"+'</td>\
                                    <td class="basic">'+sr_auto+'</td>\
                                    <td class="basic">'+sr_auto_end+'</td>\
                                    <td>'+response.list[i].pc_name+'</td>\
                                    <td>'+response.list[i].pi_name+'</td>\
                                    <td class="option_extend" data-seq="'+response.list[i].sv_seq+'" style="width:30px;height:30px;background:#414860;font-size:16px;color:#fff;margin:2px"> + </td>\
                                    <td>'+response.list[i].pr_name+'</td>\
                                    <td class="basic">'+response.list[i].pd_name+'</td>\
                                    <td>'+response.list[i].ps_name+'</td>\
                                    <td>'+sr_rental+'</td>\
                                    <td><a href="/service/view/'+response.list[i].sv_seq+'">'+response.list[i].sv_number+'</a></td>\
                                    <td class="payment">'+response.list[i].sv_claim_name+'</td>\
                                    <td class="payment oneprice" data-oneprice="'+response.list[i].svp_first_price+'" data-allprice="'+firstPrice+'">'+firstPrice+'</td>\
                                    <td class="payment monthprice" data-oneprice="'+(response.list[i].svp_month_price-response.list[i].svp_month_dis_price-response.list[i].svp_discount_price)+'" data-allprice="'+monthPrice+'">'+monthPrice+'</td>\
                                    <td class="payment">'+response.list[i].sv_payment_period+'개월</td>\
                                    <td class="payment">'+response.list[i].sv_input_price+'</td>\
                                    <td class="payment"></td>\
                                    <td class="payment">'+response.list[i].c_name+'</td>\
                                    <td>'+moment(response.list[i].sv_regdate).format("YYYY-MM-DD")+'<br></td>\
                                    <td>'+(response.list[i].sv_status == 0 ? "<span class='statusEdit' style='cursor:pointer;color:#0070C0' data-seq='"+response.list[i].sv_seq+"'>등록</span>":"<span style='color:#FF0000'>신청완료</span>")+'</td>\
                                    <td class="basic"></td>\
                                    <td>'+moment(response.list[i].sv_account_start).format("YYYY-MM-DD")+'<br>'+moment(response.list[i].sv_account_end).format("YYYY-MM-DD")+'</td>\
                                    <td></td>\
                                    <td></td>\
                                </tr>\
                                <tr style="border-bottom:0px;display:none" id="child_add_'+response.list[i].sv_seq+'">\
                                    <td colspan=9 class="addcol"></td>\
                                    <th style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9;" colspan=2>부가항목명</th>\
                                    <th class="basic" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9"></th>\
                                    <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9"></td>\
                                    <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9"></td>\
                                    <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">서비스번호</td>\
                                    <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">청구명</td>\
                                    <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">초기일회성</td>\
                                    <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">월(기준)요금</td>\
                                    <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">결제주기</td>\
                                    <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">매입가</td>\
                                    <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">매입 단위</td>\
                                    <td class="payment payment1" style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">매입처</td>\
                                    <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">서비스신청일<br>서비스개시일</td>\
                                    <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9" class="basic">제품출고일</td>\
                                    <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">서비스상태</td>\
                                    <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">과금시작일<br>과금만료일</td>\
                                    <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9">결제상태</td>\
                                    <td style="background:#111E6C;color:#fff;border-bottom: 1px solid #d9d9d9s">문서</td>\
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
</script>
