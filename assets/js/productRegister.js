$(function(){
    // getList();
    getItemList();

    $("#all").click(function(){
        // console.log($(this).is(":checked"));
        if($(this).is(":checked")){
            $(".listCheck").prop("checked",true);
        }else{
            $(".listCheck").prop("checked",false);
        }
    });

    $("body").on("click",".content-tab-item",function(){
        if($(this).hasClass("add")){

            var url = "/api/productCategoryList";
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    var html = "";
                    for(var i =0;i< response.length;i++){
                        html += '<table class="table"><tr>\
                        <td class="dragged" width="50px">'+response[i].pc_sort+'<input type="hidden" name="pc_seq[]" value="'+response[i].pc_seq+'"></td>\
                        <td width="100px">'+response[i].pc_code+'</td>\
                        <td >'+response[i].pc_name+'</td>\
                        <td width="70px"></td>\
                        <td width="50px" class="editCategory" data-seq="'+response[i].pc_seq+'" data-name="'+response[i].pc_name+'"><i class="fas fa-edit"></i></td>';
                        if(response[i].pc_modify == "1"){
                            html += '<td width="50px" class="deleteCategory" data-seq="'+response[i].pc_seq+'"><i class="fas fa-trash"></i></td>';
                        }else{
                            html += '<td width="50px"></td>';
                        }
                        html += '</tr></table>';
                    }
                    $("#modal_category_list").html(html);

                    $('#dialogCategory').dialog({
                        title: '',
                        modal: true,
                        width: '600px',
                        draggable: true
                    });
                    $("#modal_category_list").sortable({
                        appendTo: "parent",
                        draggedClass : "dragged"
                    });
                    $("#dialogCategory").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
                }
            });
        }else{
            $(".content-tab-item").removeClass("active");
            $(this).addClass("active");
            $("#pc_seq").val($(this).data("pcseq"));
            getList();
            getItemList();
        }
    })
    $("#categoryAdd").submit(function(){
        if($("#pc_code").val() == ""){
            alert("코드를 입력해 주시기 바랍니다.");
            return false;
        }

        if($("#pc_name").val() == ""){
            alert("상품탭 명을 입력해 주시기 바랍니다.");
            return false;
        }

        var url = "/api/productCategoryRegister";
        var datas = $("#categoryAdd").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                if(!response.result){
                    alert(response.msg);
                }else{
                    $('#dialogCategory').dialog('close');
                    getTabInfo();
                }

            }
        });
        return false;
    })


    $(".btn-category-save").click(function(){
        var url = "/api/productCategorySort";
        var datas = $("#categoryList").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                $('#dialogCategory').dialog('close');
                getTabInfo();
                // getList();
            },
            error:function(error){
                console.log(error);
            }
        });
    })

    $("body").on("click",".deleteCategory",function(){
        if(confirm("삭제하시겠습니까?")){
            var that = $(this);
            var url = "/api/productCategoryDelete/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    // $('#dialogCategory').dialog('close');
                    that.parent().remove();
                    getTabInfo();
                }
            });
        }
    });

    $("body").on("click",".editCategory",function(){
        // console.log($(this).parent().children("td").eq(1).children("input").length);
        if($(this).parent().children("td").eq(2).children("input").length > 0){
            if($(this).data("name") != $(this).parent().children("td").eq(2).children("input").first().val()){
                alert("변경된 값으로 저장하려면 아래의 저장 버튼을 클릭하세요.");
                return false;
            }else{
                $(this).parent().children("td").eq(2).html($(this).data("name"));
            }

        }else{
            $(this).parent().children("td").eq(2).html("<input type='text' name='m_pc_name[]' value='"+$(this).data("name")+"'><input type='hidden' name='m_pc_seq[]' value='"+$(this).data("seq")+"'>");
        }

    });

    $(".btn-div").click(function(){
        var url = "/api/productDivList/"+$("#pc_seq").val();
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                var html = "";
                for(var i =0;i< response.length;i++){
                    html += '<table class="table">';
                    html += '<tr id="parent_div_'+response[i].pd_seq+'">\
                    <td style="width:50px">'+response[i].pd_sort+'<input type="hidden" name="pd_seq[]" value="'+response[i].pd_seq+'"></td>\
                    <td style="text-align:left;padding-left:10px"><i class="fas fa-caret-down fa-2x viewSubDiv" style="vertical-align:middle" data-pdseq="'+response[i].pd_seq+'" data-clicktype="1"></i> (대분류) <span id="input_'+response[i].pd_seq+'">'+response[i].pd_name+'</span></td>\
                    <td style="width:10%"><i class="fas fa-plus addSubDiv" data-pdseq="'+response[i].pd_seq+'" title="소분류 추가"></i></td>\
                    <td style="width:10%" class="editDiv" data-seq="'+response[i].pd_seq+'" data-name="'+response[i].pd_name+'"><i class="fas fa-edit"></i></td>\
                    <td style="width:10%" class="deleteDiv" data-seq="'+response[i].pd_seq+'"><i class="fas fa-trash"></i></td>\
                    </tr>';
                    html += '</table>';
                }
                $("#modal_div_list").html(html);
                $("#currentCategory").html($(".content-tab-item.active").html());
                $('#dialogDiv').dialog({
                    title: '',
                    modal: true,
                    width: '600px',
                    draggable: true
                });
                $("#modal_div_list").sortable({
                    appendTo: "parent",
                    draggedClass : "dragged"
                });
                $("#dialogDiv").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
            }
        });
    });
    $("#divAdd").submit(function(){
        if($("#pd_name").val() == ""){
            alert("대분류를 입력해주시기 바랍니다.");
            return false;
        }
        var url = "/api/productDivRegister/"+$("#pc_seq").val();
        var datas = $("#divAdd").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                console.log(response);
                if(response.result == true){
                    alert("추가 되었습니다.");

                    $("#dialogDiv").dialog("close")
                }else{
                    alert(response.msg);
                }
                // $('#dialogDiv').dialog('close');
                // getTabInfo();
            }
        });
        return false;
    });


    $("body").on("click",".deleteDiv",function(){
        if(confirm("삭제하시겠습니까?")){
            var that = $(this);
            var url = "/api/productDivDelete/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    // $('#dialogCategory').dialog('close');
                    that.parent().remove();
                    // getTabInfo();
                }
            });
        }
    });

    $("body").on("click",".editDiv",function(){
        // console.log($(this).parent().children("td").eq(1).children("input").length);
        if($(this).parent().children("td").eq(1).children("span").children("input").length > 0){

            if($(this).data("name") != $(this).parent().children("td").eq(1).children("span").children("input").first().val()){
                alert("변경된 값으로 저장하려면 아래의 저장 버튼을 클릭하세요.");
                return false;
            }else{
                $(this).parent().children("td").eq(1).children("span").html($(this).data("name"));
            }
        }else{
            $(this).parent().children("td").eq(1).children("span").html("<input type='text' name='m_pd_name[]' value='"+$(this).data("name")+"'><input type='hidden' name='m_pd_seq[]' value='"+$(this).data("seq")+"'>");
        }

    });

    $("body").on("click",".viewSubDiv",function(){
        var pd_seq = $(this).data("pdseq");
        if($(this).data("clicktype") == "1"){
            $(this).removeClass("fa-caret-down");
            $(this).addClass("fa-caret-up");

        }else{
            $(this).addClass("fa-caret-down");
            $(this).removeClass("fa-caret-up");

        }
        var that = $(this);
        if($(this).data("clicktype") == "1"){
            var url = "/api/productDivSubList/"+$(this).data("pdseq");
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    // $('#dialogCategory').dialog('close');
                    // that.parent().remove();
                    // getTabInfo();
                    var html = "";
                    for(var i =0;i< response.length;i++){
                        html += '<tr class="children_div_'+response[i].ps_pd_seq+' " >\
                        <td></td>\
                        <td style="text-align:left;padding-left:30px">ㄴ (소분류) <span id="input_childred_'+response[i].ps_seq+'">'+response[i].ps_name+'</span></td>\
                        <td></td>\
                        <td class="editDivSub" data-seq="'+response[i].ps_seq+'" data-name="'+response[i].ps_name+'"><i class="fas fa-edit"></i></td>\
                        <td class="deleteDivSub" data-seq="'+response[i].ps_seq+'"><i class="fas fa-trash"></i></td>\
                        </tr>';
                    }
                    $("#parent_div_"+pd_seq).after(html);
                    that.data("clicktype","2");
                }
            });
        }else{
            that.data("clicktype","1");
            $(".children_div_"+pd_seq).remove();
        }
    });

    $("body").on("click",".addSubDiv",function(){
        var $viewSub = $(this).parent().parent().children("td").eq(1).children("i");

        if($(".children_div_"+$(this).data("pdseq")).length == 0)
            $viewSub.trigger("click");

        var pd_seq = $(this).data("pdseq");
        var html = '<tr>\
        <td></td>\
        <td style="text-align:left;padding-left:30px">ㄴ <span class="clearable"><input type="text" name="add_ps_name[]" placeholder="소분류 명을 입력하세요"><i class="clearable__clear">&times;</i></span></td>\
        <td></td>\
        <td></td>\
        <td></td>\
        <input type="hidden" name="add_ps_pd_seq[]" value="'+pd_seq+'">\
        </tr>';
        if($(".children_div_"+$(this).data("pdseq")).length == 0)
            $("#parent_div_"+pd_seq).after(html);
        else
            $(".children_div_"+pd_seq).last().after(html);
    })

    $(".btn-div-sub-save").click(function(){
        var url = "/api/productDivSubRegister";
        var datas = $("#divSortSub").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                // console.log(response);
                if(response.result == true){
                    alert("저장되었습니다.");
                    $('#dialogDiv').dialog('close');
                }
                // $('#dialogDiv').dialog('close');
                // getTabInfo();
            },
            error : function(error){
                console.log(error);
            }
        });
        return false;
    });

    $("body").on("click",".deleteDivSub",function(){
        if(confirm("삭제하시겠습니까?")){
            var that = $(this);
            var url = "/api/productDivSubDelete/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    // $('#dialogCategory').dialog('close');
                    that.parent().remove();
                    // getTabInfo();
                }
            });
        }
    });

    $("body").on("click",".editDivSub",function(){
        // console.log($(this).parent().children("td").eq(1).children("input").length);
        if($(this).parent().children("td").eq(1).children("span").children("input").length > 0){

             if($(this).data("name") != $(this).parent().children("td").eq(1).children("span").children("input").first().val()){
                alert("변경된 값으로 저장하려면 아래의 저장 버튼을 클릭하세요.");
                return false;
            }else{
                $(this).parent().children("td").eq(1).children("span").html($(this).data("name"));
            }
            // $(this).parent().children("td").eq(1).html($(this).data("name"));
        }else{
            $(this).parent().children("td").eq(1).children("span").html("<input type='text' name='m_ps_name[]' value='"+$(this).data("name")+"'><input type='hidden' name='m_ps_seq[]' value='"+$(this).data("seq")+"'>");
        }

    });

    $(".btn-item-register").click(function(){
        var specs = "left=10,top=10,width=1000,height=600";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=no";
        window.open("/product/item/"+$("#pc_seq").val(), 'item', specs);
    });

    $(".btn-product-register").click(function(){
        var specs = "left=10,top=10,width=1000,height=600";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=no";
        window.open("/product/make/"+$("#pc_seq").val(), 'make', specs);
    })

    $("body").on("click",".btn-modify",function(){
        var specs = "left=10,top=10,width=1000,height=600";
        specs += ",toolbar=no,menubar=no,status=no,scrollbars=no,resizable=no";
        window.open("/product/make/"+$("#pc_seq").val()+"/"+$(this).data("seq"), 'make', specs);
    })

    $("body").on("click",".btn-delete",function(){
        if(confirm("정말 삭제 하시겠습니까?")){
            var url = "/api/productDelete";
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                data : "pr_seq="+$(this).data("seq"),
                success:function(response){
                    alert("삭제되었습니다.");
                    getList();
                }
            });
        }
    })

    $("body").on("click","#pi_seq0",function(){
        if($(this).is(":checked")){
            $(".pi_seq").prop("checked",true);
        }else{
            $(".pi_seq").prop("checked",false);
        }
    });



    $(".btn-copy").click(function(){
        var checkCount = 0;
        var checkSeq = [];
        $(".listCheck").each(function(){
            if($(this).is(":checked")){
                checkCount++;
                checkSeq.push($(this).val());
            }
        });
        if(checkCount == 0){
            alert("상품을 선택해 주시기 바랍니다.");
            return false;
        }
        if(confirm("해당 상품 내용과 동일하게 복사하겠습니까?")){
            var url = "/api/productCopy";
            var datas = $("#listForm").serialize();
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : datas,
                success:function(response){
                    console.log(response);
                    alert("복사 완료");
                    getList();
                }
            });
        }
    });

    $("#searchWord").autocomplete({
        source : function (request, response) {
            if($("#searchType").val() == "pr_name"){
                var url = "/api/productSearch/"+$("#pc_seq").val();
            }else if($("#searchType").val() == "pi_name"){
                var url = "/api/productItemSearch/"+$("#pc_seq").val();
            }else if($("#searchType").val() == "c_name"){
                var url = "/api/clientSearchList";
            }
            // $.post('http://'+$('#apiHost').val()+':'+$('#apiPort').val()+'/products/_search/1/limit/20', request, response);
            $.ajax( {
                method : "GET",
                url: url,
                dataType: "json",
                data: {
                    searchType : $("#searchType").val(),
                    searchWord: request.term
                },
                success: function( data ) {

                    response( data );
                }
            });
        },
        minLength: 1,
        focus: function( event, ui ) {
            $( "#searchWord" ).val( ui.item.name );
            return false;
        },
        select : function(event,ui){
            $( "#searchWord" ).val( ui.item.name );
            return false;
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
            .append( item.name )
            .appendTo( ul );
    };

    $(".btn-check-excel").click(function(){
        var down = false;
        $(".listCheck").each( function(){

            if($(this).is(":checked")){
                down = true;
            }
        });
        if(down){
            $("#listForm").submit();
        }
        else
            alert("다운 받으실 상품을 선택해 주시기 바랍니다.");

    });
    getTabInfo();
});

function getTabInfo(){
    var url = "/api/productCategoryList";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){
            var html = '<ul>';
            var current_seq = "1";
            for(var i =0;i<response.length;i++){
                if(i == 0){
                    var addClass = "active";
                    current_seq = response[i].pc_seq;
                }else{
                    var addClass = "";
                }
                html += '<li class="content-tab-item '+addClass+'" data-pcseq="'+response[i].pc_seq+'">'+response[i].pc_name+'</li>';
            }

            html += '<li class="content-tab-item add"><i class="fa fa-cog" aria-hidden="true"></i> 탭 설정</li>\
            </ul>';
            $(".content-tab").html(html);
            $("#pc_seq").val(current_seq);
            getList();
        }
    });
}
// 리스트에 db호출이 여러번 생겨 php에서 html 생성으로 변경
function getList(){

    var start = $("#start").val();
    var end = 5;
    var url = "/api/productList/"+$("#pc_seq").val()+"/"+start+"/"+end;
    var searchForm = $("#searchForm").serialize();
    // console.log(searchForm);
    // console.log(url);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : searchForm,
        success:function(response){
            // console.log(response);
            var html = "";
            if(response.list.length > 0){
                // for(var i = 0; i < response.list.length;i++){
                //     var num = response.total - ((start-1)*end) - i;


                //     html += '<tr>\
                //                 <td><input type="checkbox" class="listCheck" name="pr_seq[]" value="'+response.list[i].pr_seq+'"></td>\
                //                 <td>'+num+'</td>\
                //                 <td>'+response.list[i].pr_code+'</td>\
                //                 <td></td>\
                //                 <td>'+response.list[i].pr_name+'</td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td></td>\
                //                 <td class="btn-modify" data-seq="'+response.list[i].pr_seq+'" style="cursor:pointer"><i class="fas fa-edit"></i></td>\
                //                 <td class="btn-delete" data-seq="'+response.list[i].pr_seq+'" style="cursor:pointer"><i class="fas fa-trash"></i></td>\
                //             </tr>';
                // }
                html = response.list;
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
                html += '<tr><td colspan="13" style="text-align:center">상품이 없습니다.</td></tr>';
                $(".pagination-html").html("");
            }
            $("#tbody-list").html(html);
        }
    });
    return false;
}

function getItemList(){
    // console.log($("pc_seq").val());
    var url = "/api/productItemSearch/"+$("#pc_seq").val();
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){
            var html = '<div class="form-group">\
                            <input type="checkbox" id="pi_seq0" value=""> 전체\
                        </div>';
            if(response.length > 0){
                for(var i = 0; i < response.length;i++){
                    html += '<div class="form-group">\
                                <input type="checkbox" name="pi_seq[]" id="pi_seq'+(i+1)+'" class="pi_seq" value="'+response[i].pi_seq+'"> '+response[i].pi_name+'\
                            </div>';
                }

            }
            $(".search1_detail").html(html);

        }
    });
}