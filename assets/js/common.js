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

});

function pad(n, width) {
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
}