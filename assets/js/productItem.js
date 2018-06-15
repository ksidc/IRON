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
                client_html = '<div class="selectbox" style="width:90%">';
                client_html += '<label for="pis_c_select_'+$(".selectbox").length+'" style="top:1.5px;padding:.1em .5em">매입처선택</label>';
                client_html += '<select id="pis_c_select_'+$(".selectbox").length+'" name="add_pis_c_seq[]" style="padding:.2em .5em">';
                client_html += '<option value="" selected>매입처 선택</option>';
                for(var i = 0; i< response.length;i++){
                    client_html += '<option value="'+response[i].c_seq+'">'+response[i].c_name+'</option>';
                }
                client_html += '</select>';
                client_html += '</div>';

                var pi_seq = that.data("piseq");
                var target = that.parent().parent().children("td").eq(2);
                var nexttarget = that.parent().parent().children("td").eq(3);

                if(target.html() == ""){
                    target.html('<div class="div_'+(target.children("div").length+1)+'"><span class="clearable"><input type="text" name="add_pis_name[]" class="subItemName"><i class="clearable__clear" data-type="item">&times;</i></span><input type="hidden" name="add_pis_pi_seq[]" value="'+pi_seq+'"></div>');

                    nexttarget.html('<div class="div_'+(target.children("div").length)+'">'+client_html+'</div>');
                }else{
                    target.append('<div class="div_'+(target.children("div").length+1)+'"><span class="clearable"><input type="text" name="add_pis_name[]" class="subItemName"><i class="clearable__clear" data-type="item">&times;</i></span><input type="hidden" name="add_pis_pi_seq[]" value="'+pi_seq+'"></div>');
                    nexttarget.append('<div class="div_'+(target.children("div").length)+'">'+client_html+"</div>");
                }
            }
        });

    })

    $(".btn-item-sub-save").click(function(){
        $(".subItemName").each(function(){
            if($(this).val() == ""){
                alert("부가항목을 입력하시기 바랍니다.");
                $(this).focus();
                return false;
            }
        })
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
            // var query = {};
            // query.pi_seq = pi_seq;
            // query.pi_name = $(this).parent().children("td").eq(1).children("input").val();
            // var sub = $(this).parent().children("td").eq(2).children("div");
            // query.sub = [];
            // sub.each(function(){
            //     var pis_c_seq = $(this).parent().parent().children("td").eq(3).children("div").children("div").children("select").val();

            //     var subitem = {
            //         pis_name : $(this).children("input").val(),
            //         pis_c_seq : pis_c_seq,
            //         pis_seq : $(this).data("pisseq")
            //     }
            //     query.sub.push(subitem);
            // })

            // $.ajax({
            //     url : "/api/productItemUpdate",
            //     type : 'POST',
            //     dataType : 'JSON',
            //     data : query,
            //     success:function(response){
            //         if(response.result == true){
            //             alert("수정 되었습니다.");
            //             document.location.reload();
            //         }
            //     },error: function(error){
            //         console.log(error);
            //     }
            // });
            $(this).parent().children("td").eq(1).html($(this).parent().children("td").eq(1).data("name"));
            var subitem = $(this).parent().children("td").eq(2).children("div");
            subitem.each(function(){
                $(this).html($(this).data("name"));
            });
            var subclient = $(this).parent().children("td").eq(3).children("div");
            subclient.each(function(){
                $(this).html($(this).data("name"));
            });
        }else{
            $(this).parent().children("td").eq(1).html("<input type='text' name='m_pi_name[]' value='"+$(this).parent().children("td").eq(1).data("name")+"' style='width:90%'><input type='hidden' name='m_pi_seq[]' value='"+pi_seq+"'>");
            var subitem = $(this).parent().children("td").eq(2).children("div");
            subitem.each(function(){
                $(this).html("<input type='text' name='m_pis_name[]' value='"+$(this).data("name")+"' style='width:90%'><input type='hidden' name='m_pis_seq[]' value='"+$(this).data("pisseq")+"' style='width:90%'>");
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
                    subclient.each(function(){
                        var html = '<div class="selectbox" style="width:90%">';
                        html += '<label for="pis_c_select_'+$(".selectbox").length+'" style="top:1.5px;padding:.1em .5em">'+$(this).data("name")+'</label>';
                        html += '<select id="pis_c_select_'+$(".selectbox").length+'" name="m_pis_c_seq[]" style="padding:.2em .5em">';
                        html += '<option value="" selected>매입처 선택</option>';
                        for(var i = 0; i< response.length;i++){
                            if($(this).data("name") == response[i].c_name){
                                html += '<option value="'+response[i].c_seq+'" selected>'+response[i].c_name+'</option>';
                            }else{
                                html += '<option value="'+response[i].c_seq+'">'+response[i].c_name+'</option>';
                            }

                        }
                        html += '</select>';
                        html += '</div>';
                        $(this).html(html);
                    });
                }
            });

        }
    })
})

function getList(){
    var start = $("#start").val();
    var end = 5;
    var url = "/api/productItemList/"+$("#pc_seq").val()+"/"+start+"/"+end;
    console.log(url);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){
            console.log(response);
            // var html = "";
            // for(var i = 0; i < response.list.length;i++){
            //     if(response.list[i].sub_item !== null){
            //         var subItem = response.list[i].sub_item.split("|");
            //         subItemName = subItem[0].split(",");
            //         subItemClient = subItem[1].split(",");
            //     }else{
            //         subItemName = [];
            //         subItemClient = [];
            //     }
            //     var subItemHtml = "";
            //     var subItemClientHtml = "";
            //     subItemName.forEach(function(one){
            //         subItemHtml += '<div class="subItem_'+response.list[i].pi_seq+'" data-name="'+one+'">'+one+'</div>';
            //     });
            //     subItemClient.forEach(function(one){
            //         subItemClientHtml += '<div class="subItem_'+response.list[i].pi_seq+'" data-name="'+one+'">'+one+'</div>';
            //     });
            //     html += '<tr>\
            //                 <td>'+(i+1)+'</td>\
            //                 <td class="item_'+response.list[i].pi_seq+'" data-name="'+response.list[i].pi_name+'">'+response.list[i].pi_name+'</td>\
            //                 <td style="line-height:28px">'+subItemHtml+'</td>\
            //                 <td style="line-height:28px">'+subItemClientHtml+'</td>\
            //                 <td><i class="fas fa-plus addSubItem" data-piseq="'+response.list[i].pi_seq+'"></i></td>\
            //                 <td class="btn-modify" data-seq="'+response.list[i].pi_seq+'" style="cursor:pointer"><i class="fas fa-edit"></i></td>\
            //                 <td class="btn-delete" data-seq="'+response.list[i].pi_seq+'" style="cursor:pointer"><i class="fas fa-trash"></i></td>\
            //             </tr>';
            // }
            $("#tbody-list").html(response.list);
        }
    });
}