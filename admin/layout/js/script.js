$(function () {
    "use strict";


//    hide placholder on from focus
    $('[placeholder]').focus(function () {
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
    }).blur(function () {
        $(this).attr('placeholder',$(this).attr('data-text'))
    });
//add astrix
    $('input').each(function () {
        if($(this).attr('required') =='required'){
            $(this).after("<span class='astrix'>*</span>")
        }
    });
        var password = $('.password');
    $(".show-class").hover(function () {
        password.attr('type', 'text');
    },function () {
        password.attr('type', 'password');
    });

    $(".confirm").click(function () {
       return  confirm("are you shor delete  dddddddddd item");
    });

    $('.toggle-info').click(function () {
        $(this).toggleClass('selector').parent().next('.card-body').fadeToggle('100');
        if($(this).hasClass('selector')){
            $(this).html("<i class='fa fa-minus'></i>");
        }else {
            $(this).html("<i class='fa fa-plus'></i>");
        }
    });

});