$(function () {
    "use strict";


    $('.login-page h2 span').click(function () {
            $(this).addClass('selected').siblings().removeClass('selected');
            $('.login-page form').hide();
            $('.'+$(this).data('class')).show();
    });


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





    $('.edit_com .live-name').keyup(function () {
            var v = $(this).val();
            $('.live-preview .figure-caption h3').text(v);
            if(v == "" || v == undefined){
                $('.live-preview .figure-caption h3').text("Name");
            }
    });
    $('.edit_com .live-desc').keyup(function () {
        var vc = $(this).val();
        $('.live-preview .figure-caption p').text(vc);
        if(vc == "" || vc == undefined){
            $('.live-preview .figure-caption p').text("desc");
        }
    });


    $('.edit_com .Price').keyup(function () {
        var vcc = $(this).val();
        $('.live-preview .figure-caption span').text(vcc);
        if(vcc == "" || vcc == undefined){
            $('.live-preview .figure-caption span').text("Price$");
        }
    });


});