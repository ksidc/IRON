$(function(){


    getList();
    $("#topItemAdd").submit(function(){
        if($("#top_pi_name").val() == ""){
            alert("제품군 명을 입력하시기 바랍니다.");
            return false;
        }
        // var item_name = $(this).parent().children(".pi_name").val();
        var url = "/api/productItemRegister/"+$("#pc_seq").val();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : "pi_name="+$("#top_pi_name").val(),
            success:function(response){
                if(response.result == true){
                    alert("추가 되었습니다.");
                    getList();
                }else{
                    alert(response.msg);
                }
                // $('#dialogDiv').dialog('close');
                // getTabInfo();
            }
        });
        return false;
    })

    $("#footerItemAdd").submit(function(){
        if($("#footer_pi_name").val() == ""){
            alert("제품군 명을 입력하시기 바랍니다.");
            return false;
        }
        // var item_name = $(this).parent().children(".pi_name").val();
        var url = "/api/productItemRegister/"+$("#pc_seq").val();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : "pi_name="+$("#footer_pi_name").val(),
            success:function(response){
                if(response.result == true){
                    alert("추가 되었습니다.");
                    getList();
                }else{
                    alert(response.msg);
                }
                // $('#dialogDiv').dialog('close');
                // getTabInfo();
            }
        });
        return false;
    })

    $("body").on("click",".addSubItem",function(){
        var that = $(this);
        $.ajax({
            url : "/api/clientSearchList",
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                var client_html = "";
                // console.log(response);


                client_html = '<select id="pis_c_select_'+that.data("piseq")+'_'+$(".subitemlist").length+'" name="add_pis_c_seq[]" class="subitemlist select2" style="width:90%">';
                client_html += '<option value="" selected>매입처 선택</option>';
                for(var i = 0; i< response.length;i++){
                    client_html += '<option value="'+response[i].c_seq+'">'+response[i].c_name+'</option>';
                }
                client_html += '</select>';

                var pi_seq = that.data("piseq");
                var target = that.parent().parent().children("td").eq(2);
                var nexttarget = that.parent().parent().children("td").eq(3);

                if(target.html() == ""){
                    target.html('<div class="div_'+(target.children("div").length+1)+'"><span class="clearable"><input type="text" name="add_pis_name[]" class="subItemName" placeholder="부가 항목을 입력하세요"><i class="clearable__clear" data-type="item">&times;</i></span><input type="hidden" name="add_pis_pi_seq[]" value="'+pi_seq+'"></div>');

                    nexttarget.html('<div class="div_'+(target.children("div").length)+'">'+client_html+'</div>');
                }else{
                    target.append('<div class="div_'+(target.children("div").length+1)+'"><span class="clearable"><input type="text" name="add_pis_name[]" class="subItemName" placeholder="부가 항목을 입력하세요"><i class="clearable__clear" data-type="item">&times;</i></span><input type="hidden" name="add_pis_pi_seq[]" value="'+pi_seq+'"></div>');
                    nexttarget.append('<div class="div_'+(target.children("div").length)+'">'+client_html+"</div>");
                }
                $(".select2").select2();
            }
        });

    })

    $(".btn-item-sub-save").click(function(){
        var register = true;
        $(".subItemName").each(function(){
            if($(this).val() == ""){
                alert("부가항목을 입력하시기 바랍니다.");
                $(this).focus();
                register =false;
                return false;
            }
        })
        if(!register){
            return false;
        }
        $(".subitemlist").each(function(){
            if($(this).val() == ""){
                alert("부가항목 매입처를 선택하시기 바랍니다.");
                $(this).focus();
                register =false;
                return false;
            }
        })
        if(!register){
            return false;
        }

        var datas = $("#listForm").serialize();
        // console.log(datas);
        // return false;
        $.ajax({
            url : "/api/productItemSubRegister",
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                if(response.result){
                    alert("수정 완료");
                    document.location.reload();
                }
            },
            error : function(error){
                console.log(error);
            }
        });
    });

    // 삭제
    $("body").on("click",".btn-delete",function(){
        if(confirm("정말 삭제하시겠습니까?")){
            var pi_seq = $(this).data("seq");
            var url = "/api/productItemDelete/"+pi_seq;
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    // console.log(response);
                    if(response.result == true){
                        alert("삭제 되었습니다.");
                        getList();
                    }else{
                        alert("오류가 발생했습니다.");
                        return false;
                    }
                }
            });
        }
    });

    $("body").on("click",".btn-modify",function(){
        var pi_seq = $(this).data("seq");
        if($(this).parent().children("td").eq(1).children("input").length > 0){

            var editYn = false;
            var subitem = $(this).parent().children("td").eq(2).children("div");
            var subclient = $(this).parent().children("td").eq(3).children("div");

            if($(this).parent().children("td").eq(1).data("name") != $(this).parent().children("td").eq(1).children("input").first().val()){
                editYn = true;
            }

            subitem.each(function(){
                console.log($(this).data("name")+"::"+$(this).children("input").first().val());
                if($(this).data("name") != $(this).children("input").first().val()){
                    editYn = true;
                }
            });

            subclient.each(function(){
                // console.log($(this).children("select"))
                // console.log($(this).data("cseq")+"::"+$(this).children("div").children("select").first().val());
                if($(this).data("cseq") != $(this).children("select").first().val()){
                    editYn = true;
                }
            });

            if(!editYn){
                $(this).parent().children("td").eq(1).html($(this).parent().children("td").eq(1).data("name"));
                subitem.each(function(){
                    $(this).html($(this).data("name"));
                });

                subclient.each(function(){
                    $(this).html($(this).data("name"));
                });
            }else{
                alert("변경된 값으로 저장하려면 아래의 저장 버튼을 클릭하세요.");
                return false;
            }
        }else{
            $(this).parent().children("td").eq(1).html("<input type='text' name='m_pi_name[]' value='"+$(this).parent().children("td").eq(1).data("name")+"' style='width:90%'><input type='hidden' name='m_pi_seq[]' value='"+pi_seq+"'>");
            var subitem = $(this).parent().children("td").eq(2).children("div");
            subitem.each(function(){
                $(this).html("<input type='text' name='m_pis_name[]' value='"+$(this).data("name")+"' style='width:90%' class='subItemName'><input type='hidden' name='m_pis_seq[]' value='"+$(this).data("pisseq")+"' style='width:90%'>");
            });
            var that = $(this);
            $.ajax({
                url : "/api/clientSearchList",
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    // console.log(response);
                    var subclient = that.parent().children("td").eq(3).children("div");
                    // console.log(subclient.length);
                    subclient.each(function(i){


                        var html = '<select id="pis_c_select_'+pi_seq+'_'+($(".subitemlist").length+i)+'" name="m_pis_c_seq[]" class="select2 subitemlist" style="width:90%">';
                        html += '<option value="" selected>매입처 선택</option>';
                        for(var i = 0; i< response.length;i++){
                            if($(this).data("name") == response[i].c_name){
                                html += '<option value="'+response[i].c_seq+'" selected>'+response[i].c_name+'</option>';
                            }else{
                                html += '<option value="'+response[i].c_seq+'">'+response[i].c_name+'</option>';
                            }
                        }
                        html += '</select>';
                        html += '<i class="fas fa-trash subpisdel" data-seq="'+$(this).data("pisseq")+'"></i>';
                        $(this).html(html);
                        $(".select2").select2();
                    });

                }
            });

        }
    });

    $("body").on("click",".subpisdel",function(){
        if(confirm("정말 삭제하시겠습니까?")){
            var pis_seq = $(this).data("seq");
            var url = "/api/productItemSubDelete/"+pis_seq;
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    // console.log(response);
                    if(response.result == true){
                        alert("삭제 되었습니다.");
                        getList();
                    }else{
                        alert("오류가 발생했습니다.");
                        return false;
                    }
                }
            });
        }
    })
})

function getList(){
    // var start = $("#start").val();
    // var end = 10;
    var url = "/api/productItemList/"+$("#pc_seq").val();
    // console.log(url);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){

            $("#tbody_list").html(response.list);

            $("#tbody_list").sortable({
                appendTo: "parent",
                draggedClass : "dragged"
            });
        }
    });
}