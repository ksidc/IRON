$(function(){
    getEndUserNextNumber();
    var url = "/api/companyTypeList";
    var typeSearchForm = $("#typeSearchForm").serialize();
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : typeSearchForm,
        success:function(response){
            var html ="";
            if(response.list.length == 0){
                html += "<tr><td colspan=4 align=center>검색결과가 없습니다.</td></tr>";
            }else{
                for(var i = 0; i < response.list.length;i++){
                    html += '<tr>\
                                <td><a href="javascript:void(0)" class="clickType" data-seq="'+response.list[i].ct_seq+'" data-name="'+response.list[i].ct_name+'">'+response.list[i].ct_code+'</a></td>\
                                <td>'+response.list[i].ct_name+'</td>\
                                <td class="editType" data-name="'+response.list[i].ct_name+'" data-seq="'+response.list[i].ct_seq+'"><i class="fas fa-edit"></i></td>\
                                <td class="deleteType" data-seq="'+response.list[i].ct_seq+'"><i class="fas fa-trash"></i></td>\
                            </tr>\
                    ';
                }
            }
            $("#modalSearchType").html(html);
            $("#addType").val(pad(response.nextCode,3));
            $("#ct_name").val("");
        }
    });

    var url = "/api/endUserList";
    var endSearchForm = $("#endSearchForm").serialize();
    // console.log(userSearchForm);
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        data : endSearchForm,
        success:function(response){
            // console.log(response);
            var html ="";
            if(response.length == 0){
                html += "<tr><td colspan=4 align=center>검색결과가 없습니다.</td></tr>";
            }else{
                for(var i = 0; i < response.list.length;i++){
                    html += '<tr>\
                                <td><a href="javascript:void(0)" class="clickEnd" data-name="'+response.list[i].eu_name+'" data-seq="'+response.list[i].eu_seq+'">'+response.list[i].eu_code+'</a></td>\
                                <td>'+response.list[i].eu_name+'</td>\
                                <td class="editEnd" data-name="'+response.list[i].eu_name+'" data-seq="'+response.list[i].eu_seq+'"><i class="fas fa-edit"></i></td>\
                                <td class="deleteEnd" data-seq="'+response.list[i].eu_seq+'"><i class="fas fa-trash"></i></td>\
                            </tr>\
                    ';
                }
            }
            $("#modalSearchEnd").html(html);
        }
    });

    $("body").on("click",".editEnd",function(){
        // console.log($(this).parent().children("td").eq(1).children("input").length);
        if($(this).parent().children("td").eq(1).children("input").length > 0){
            var url = "/api/endUserUpdate/"+$(this).data("seq");
            var editname = $(this).parent().children("td").eq(1).children("input").val();
            var that = $(this);
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "eu_name="+editname,
                success:function(response){
                    // typeGetList();
                    alert("수정되었습니다.");
                    that.parent().children("td").eq(0).children("a").data("name",editname);
                    that.parent().children("td").eq(1).html(editname);
                    that.parent().children("td").eq(2).data("name",editname);
                }
            });
        }else{
            $(this).parent().children("td").eq(1).html("<input type='text' name='end_mode_name' value='"+$(this).data("name")+"'>");
        }

    });

    $("body").on("click",".deleteEnd",function(){
        if(confirm("삭제하시겠습니까?")){
            var that = $(this);
            var url = "/api/endUserDelete/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    // typeGetList();
                    alert("삭제되었습니다.");
                    that.parent().remove();
                }
            });
        }
    });

    $("#endAdd").submit(function(){
        if($("#addEnd").val() == ""){
            alert("코드를 입력해 주시기 바랍니다.");
            return false;
        }
        if($("#add_eu_name").val() == ""){
            alert("End User를 입력해 주시기 바랍니다.");
            return false;
        }
        var url = "/api/endUserAdd";
        var datas = $("#endAdd").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                // typeGetList();
                if(response.result){
                    alert("등록되었습니다.");
                    getEndUserNextNumber();
                    $("#endSearchForm").submit();
                }else{
                    alert(response.msg);
                }
            }
        });
        return false;
    });

    $("body").on("click",".editType",function(){
        // console.log($(this).parent().children("td").eq(1).children("input").length);
        if($(this).parent().children("td").eq(1).children("input").length > 0){
            var url = "/api/companyTypeUpdate/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'POST',
                dataType : 'JSON',
                data : "ct_name="+$(this).parent().children("td").eq(1).children("input").val(),
                success:function(response){
                    alert("수정되었습니다.");
                    typeGetList();
                }
            });
        }else{
            $(this).parent().children("td").eq(1).html("<input type='text' name='mode_name' value='"+$(this).data("name")+"'>");
        }

    });

    $("body").on("click",".deleteType",function(){
        if(confirm("삭제하시겠습니까?")){
            var url = "/api/companyTypeDelete/"+$(this).data("seq");
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success:function(response){
                    typeGetList();
                }
            });
        }
    });

    $("#typeAdd").submit(function(){
        if($("#addType").val() == ""){
            alert("코드를 입력해 주세요");
            return false;
        }

        if($("#add_ct_name").val() == ""){
            alert("분류명을 입력해 주세요");
            return false;
        }
        var url = "/api/companyTypeAdd";
        var datas = $("#typeAdd").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                // console.log(response);
                if(response.result){
                    alert("저장되었습니다.");
                    typeGetList();
                }else{
                    alert(response.msg);

                }

            }
        });
        return false;
    });

    $("#endSearchWord").autocomplete({
        source : function (request, response) {
            // $.post('http://'+$('#apiHost').val()+':'+$('#apiPort').val()+'/products/_search/1/limit/20', request, response);
            $.ajax( {
                method : "GET",
                url: '/api/endUserList',
                dataType: "json",
                data: {
                    endSearchWord: request.term
                },
                success: function( data ) {
                    response( data.list );
                }
            });
        },
        minLength: 1,
        focus: function( event, ui ) {
            $( "#endSearchWord" ).val( ui.item.eu_name );
            return false;
        },
        select : function(event,ui){
            $( "#endSearchWord" ).val( ui.item.eu_name );
            return false;
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        console.log(ul);
        return $( "<li>" )
            .append( item.eu_name )
            .appendTo( ul );
    };

    $("#typeSearchWord").autocomplete({
        source : function (request, response) {
            // $.post('http://'+$('#apiHost').val()+':'+$('#apiPort').val()+'/products/_search/1/limit/20', request, response);
            $.ajax( {
                method : "GET",
                url: '/api/companyTypeList',
                dataType: "json",
                data: {
                    typeSearchWord: request.term
                },
                success: function( data ) {
                    response( data.list );
                }
            });
        },
        minLength: 1,
        focus: function( event, ui ) {
            $( "#typeSearchWord" ).val( ui.item.ct_name );
            return false;
        },
        select : function(event,ui){
            $( "#typeSearchWord" ).val( ui.item.ct_name );
            return false;
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
            .append( item.ct_name )
            .appendTo( ul );
    };
})
var getEndUserNextNumber = function(){
    var url = "/api/endUserNextCode";
    $.ajax({
        url : url,
        type : 'GET',
        dataType : 'JSON',
        success:function(response){

            $("#addEnd").val(response);
            $("#eu_name").val("");
        }
    });
}