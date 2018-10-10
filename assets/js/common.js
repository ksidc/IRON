$(function(){
    $(".tab-wrap ul li").mouseenter(function(){
        $(".tab-content").hide();
        var target = $(this).data("tab");
        $(target).show();

    })

    $(".tab-wrap ul li").mouseleave(function(){
        $(".tab-content").hide();
    })

    $(".left-li").click( function(){
        if($(this).children(".sub-menu").css("display") != "none"){
            $(".sub-menu").hide();
            $(".left-li").removeClass("active");
            $(this).children(".left-icon").text("+");
        }else{
            $(".sub-menu").hide();
            $(".left-icon").text("+");
            $(".left-li").removeClass("active");
            $(this).children(".sub-menu").show();
            $(this).children(".left-icon").text("-");
            $(this).addClass("active");
        }
    })

    // var selectTarget = $('.selectbox select');

    // // focus 가 되었을 때와 focus 를 잃었을 때
    // selectTarget.on({
    //     'focus': function() {
    //         $(this).parent().addClass('focus');
    //     },
    //     'blur': function() {
    //         $(this).parent().removeClass('focus');
    //     }
    // });
    $(".select2").select2();

    $("body").on("change",".selectbox select",function(){
        var select_name = $(this).children('option:selected').text();
        $(this).siblings('label').text(select_name);
        $(this).parent().removeClass('focus');
    })

    $(".clearable").each(function() {

        var $inp = $(this).find("input:text"),
        $cle = $(this).find(".clearable__clear");

        $inp.on("input", function(){
            $cle.toggle(!!this.value);
        });


    });
    $("body").on("touchstart click",".clearable__clear", function(e) {
        // console.log(e);
        e.preventDefault();
        if($(this).data("type") == "item"){
            $(this).parent().parent().parent().next().children("div").last().remove();
            $(this).parent().parent().remove();
        }else{
            $(this).parent().parent().parent().remove();
        }

        // $inp.val("").trigger("input");
    });

    $(".sub-menu a").mouseenter(function(){
        $(this).children("p").addClass("active");
    })

    $(".sub-menu a").mouseout(function(){
        if(!$(this).hasClass("active")){
            $(this).children("p").removeClass("active");
        }

    })

    $( "#dialogTypeSearch" ).dialog({
        autoOpen: false,
        modal: true,
        width:'500px',
        height : 450
    });

    $( "#dialogEndSearch" ).dialog({
        autoOpen: false,
        modal: true,
        width:'500px',
        height : 450
    });

    $("#endSearchForm").submit(function(event){

        // if($("#endSearchWord").val() == ""){
        //     alert("검색어를 입력해주세요");
        //     return false;
        // }

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
        return false;
    });

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
                console.log(response);
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
    });
    $(".datepicker3").datepicker({
        "dateFormat" : "yy-mm-dd"
    })
});

function pad(n, width) {
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
}

var typeGetList = function(){
    // alert(1);
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
            // $("#ct_name").val("");
        }
    });
    return false;
}

function onlyNumDecimalInput(obj){
    var code = window.event.keyCode;
    // console.log(code);
    if ((code >= 48 && code <= 57) || (code >= 96 && code <= 105) || code == 190 || code == 8 || code == 9 || code == 13 || code == 46 || code == 44 || code == 45 || code == 35 || code == 40 || code == 34 || code == 37 || code == 12 || code == 39 || code == 36 || code == 38 || code == 33){
        // console.log(code);
        window.event.returnValue = true;
        return;
    }
    // alert(code);
    window.event.returnValue = false;
}

function fn_press_han(obj){
    // console.log(event.keyCode);
    if(event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 32 || event.keyCode == 190) return;
    obj.value = obj.value.replace(/[\ㄱ-ㅎㅏ-ㅣ가-힣]/g, '');
    obj.value = obj.value.replace(/\D/g, '')
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    // console.log(obj.value);
}
