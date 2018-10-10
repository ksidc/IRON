$(function(){
    $(".btn-product-save").click(function(){
        if($("#pr_pi_seq").val() == ""){
            alert("제품군을 선택해 주세요");
            return false;
        }

        if($("#pr_c_seq").val() == ""){
            alert("기본매입처를 선택해 주세요");
            return false;
        }
        if($("#pr_name").val() == ""){
            alert("상품명을 입력해 주세요");
            return false;
        }
        $(".prs_div_check").each(function(){
            if($(this).prop("checked")){
                $(".prs_div_"+$(this).data("in")).val($(this).val());
            }
        })
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
        // $("#registerForm").submit();
        var datas = $("#registerForm").serialize();
        // console.log(datas);
        // return false;
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
                opener.getList();
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
                    html += '<tr>\
                    <td class="pi_click" data-seq="'+response[i].pi_seq+'" data-name="'+response[i].pi_name+'" style="cursor:pointer;text-decoration:underline;text-align:left;padding-left:10px">'+response[i].pi_name+'</td>\
                    </tr>;'
                };
                $("#modalSearchItem").html(html);
            }
        });
        return false;
    })

    $(".btn-client-search").click(function(){
        $(".btn-search-client").trigger("click");
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

    $(".prs_one_type").click(function(){
        if($(this).val() == "1"){
            $(this).parent().next().children("input").attr("readonly",true);
            var price = $(this).parent().prev().children("input").val().replace(/,/gi, "");
            var percent = $(this).next().val();
            var dis_price = price*(percent/100);
            dis_price = Math.floor(dis_price/100)*100;

            $(this).parent().next().children("input").val($.number(dis_price));
            $(this).parent().next().next().children("input").val($.number(price-dis_price));
        }else{
            $(this).parent().next().children("input").attr("readonly",false);
        }
    })

    $(".prs_month_type").click(function(){
        if($(this).val() == "1"){
            $(this).parent().next().children("input").attr("readonly",true);
            var price = $(this).parent().prev().children("input").val().replace(/,/gi, "");
            var percent = $(this).next().val();
            var dis_price = price*(percent/100);
            dis_price = Math.floor(dis_price/100)*100;

            $(this).parent().next().children("input").val($.number(dis_price));
        }else{
            $(this).parent().next().children("input").attr("readonly",false);
        }
    })

    $(".prs_one_percent").keyup(function(){
        if($(this).prev().prop("checked") == true){
            var price = $(this).parent().prev().children("input").val().replace(/,/gi, "");
            var percent = $(this).val();
            var dis_price = price*(percent/100);
            dis_price = Math.floor(dis_price/100)*100;

            $(this).parent().next().children("input").val($.number(dis_price));
            $(this).parent().next().next().children("input").val($.number(price-dis_price));
        }
    })

    $(".prs_month_percent").keyup(function(){
        if($(this).prev().prop("checked") == true){
            var price = $(this).parent().prev().children("input").val().replace(/,/gi, "");
            var percent = $(this).val();
            var dis_price = price*(percent/100);
            dis_price = Math.floor(dis_price/100)*100;

            $(this).parent().next().children("input").val($.number(dis_price));
            $(this).parent().next().next().children("input").val($.number(price-dis_price));
        }
    })

    $(".prs_one_dis_price").keyup(function(){
        var price = $(this).parent().prev().prev().children("input").val().replace(/,/gi, "");
        var dis_price = $(this).val().replace(/,/gi, "");

        $(this).parent().next().children("input").val($.number(price-dis_price));
    })

    $(".prs_month_dis_price").keyup(function(){
        var price = $(this).parent().prev().prev().children("input").val().replace(/,/gi, "");
        var dis_price = $(this).val().replace(/,/gi, "");

        $(this).parent().next().children("input").val($.number(price-dis_price));
    })

    $(".prs_one_price").keyup(function(){
        var dis_price = $(this).parent().next().next().children("input").val().replace(/,/gi, "");
        var price = $(this).val().replace(/,/gi, "");

        $(this).parent().next().next().next().children("input").val($.number(price-dis_price));
    })

    $(".prs_month_price").keyup(function(){
        var dis_price = $(this).parent().next().next().children("input").val().replace(/,/gi, "");
        var price = $(this).val().replace(/,/gi, "");

        $(this).parent().next().next().next().children("input").val($.number(price-dis_price));
    })
})

