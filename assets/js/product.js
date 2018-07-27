$(function(){
    $(".btn-product-save").click(function(){
        if($("#pr_seq").val() != ""){
            var url = "/api/productUpdate/"+$("#pr_seq").val();
        }else{
            var url = "/api/productAdd";
        }
        $(".prs_use_type_str").each(function(i){
            if($(this).prop("checked") == true){
                $(".prs_use_type").eq(i).val("1");
            }else{
                $(".prs_use_type").eq(i).val("0");
            }
        })
        var datas = $("#registerForm").serialize();
        $.ajax({
            url : url,
            type : 'POST',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                console.log(response);
                if($("#pr_seq").val() != ""){
                    alert("수정되었습니다.");
                }else{
                    alert("등록되었습니다.");
                }
                opener.document.location.reload();
                self.close();
                // console.log(response);
            },
            error:function(error){
                console.log(error);
            }
        });
        // $("#registerForm").submit();
    });

    $(".btn-item-search").click(function(){
        var url = "/api/productItemSearch/"+$("#pc_seq").val();
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                var html = "";
                for(var i =0 ; i < response.length;i++){
                    html += '<tr>\
                    <td class="pi_click" data-seq="'+response[i].pi_seq+'" data-name="'+response[i].pi_name+'" style="cursor:pointer;text-decoration:underline;text-align:left;padding-left:10px">'+response[i].pi_name+'</td>\
                    </tr>;'
                };
                $("#modalSearchItem").html(html);
                $('#dialogItemSearch').dialog({
                    title: '',
                    modal: true,
                    width: '300px',
                    draggable: true
                });

                $("#dialogItemSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
            }
        });
    })

    $("#itemSearchForm").submit(function(){

        var url = "/api/productItemSearch/"+$("#pc_seq").val();
        var datas = $("#itemSearchForm").serialize();
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                var html = "";
                for(var i =0 ; i < response.length;i++){
                    html = '<tr>\
                    <td class="pi_click" data-seq="'+response[i].pi_seq+'" data-name="'+response[i].pi_name+'">'+response[i].pi_name+'</td>\
                    </tr>;'
                };
                $("#modalSearchItem").html(html);
            }
        });
        return false;
    })

    $(".btn-client-search").click(function(){
        $('#dialogClientSearch').dialog({
            title: '',
            modal: true,
            width: '300px',
            draggable: true
        });
        $("#dialogClientSearch").dialog().parents(".ui-dialog").find(".ui-dialog-titlebar").remove();
    })
    $("#clientSearchForm").submit(function(){
        // if($("#clientSearchWord").val() == ""){
        //     alert("매입처 명을 입력해 주시기 바랍니다.");
        //     return false;
        // }
        var url = "/api/clientSearchList";
        var datas = $("#clientSearchForm").serialize();
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            data : datas,
            success:function(response){
                var html = "";
                for(var i =0 ; i < response.length;i++){
                    html += '<tr>\
                    <td class="c_click" data-seq="'+response[i].c_seq+'" data-name="'+response[i].c_name+'" style="cursor:pointer;text-decoration:underline">'+response[i].c_id+'</td>\
                    <td>'+response[i].c_name+'</td>\
                    </tr>;'
                };
                $("#modalSearchClient").html(html);
            }
        });
        return false;
    })

    $("body").on("click",".c_click",function(){
        $("#pr_c_seq").val($(this).data("seq"));
        $("#pr_c_seq_str").val($(this).data("name"));
        $('#dialogClientSearch').dialog('close');
    });

    $("body").on("click",".pi_click",function(){
        var url = "/api/productItemSubList/"+$(this).data("seq");
        var seq = $(this).data("seq");
        var name = $(this).data("name");
        $.ajax({
            url : url,
            type : 'GET',
            dataType : 'JSON',
            success:function(response){
                $("#pr_pi_seq").val(seq);
                $("#pr_pi_seq_str").val(name);
                var html = "";
                for(var i = 0; i< response.length;i++){
                    html += '<div>'+response[i].pis_name+'</div>';
                }
                $("#addOption").html(html);
                $('#dialogItemSearch').dialog('close');
            }
        });
    });
    $.widget("ui.tooltip", $.ui.tooltip, {
         options: {
             content: function () {
                 return $(this).prop('title');
             }
         }
     });
    $( '[rel=tooltip]' ).tooltip({
        position: {
            my: "center bottom-20",
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

function onlyNumDecimalInput(obj){
    var code = window.event.keyCode;

    if ((code >= 48 && code <= 57)  || code == 190 || code == 8 || code == 9 || code == 13 || code == 46 || code == 44){
        // console.log(code);
        window.event.returnValue = true;
        return;
    }
    // alert(code);
    window.event.returnValue = false;
}

function fn_press_han(obj){
    console.log(event.keyCode);
    if(event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 32 || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 190) return;
    obj.value = obj.value.replace(/[\ㄱ-ㅎㅏ-ㅣ가-힣]/g, '');
    obj.value = obj.value.replace(/\D/g, '')
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    // console.log(obj.value);
}
