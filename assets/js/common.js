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

    var selectTarget = $('.selectbox select');

    // focus 가 되었을 때와 focus 를 잃었을 때
    selectTarget.on({
        'focus': function() {
            $(this).parent().addClass('focus');
        },
        'blur': function() {
            $(this).parent().removeClass('focus');
        }
    });

    selectTarget.change(function() {
        var select_name = $(this).children('option:selected').text();
        $(this).siblings('label').text(select_name);
        $(this).parent().removeClass('focus');
    });

    $( ".datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd',
        showOn: "both",
        buttonText: "<i class='fa fa-calendar-alt'></i>"
    });

    $(".btn-add").click(function(){
        $('#dialog').dialog({
            title: '회원 등록',
            modal: true,
            width: '40%',
            draggable: false
        });
    })
})