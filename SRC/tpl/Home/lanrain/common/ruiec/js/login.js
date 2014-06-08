// JavaScript Document
$(document).ready(function () {
    //001登录页手型效果
    $("#rlBox").animate({ "top": "50px" }, 1000);
    var oFtext = $(".contbox .cont_right .r_cont ul li .r_text");
    oFtext.each(function () {
        if ($(this).val() != '') {
            $(this).next("i").hide();
        }
    });
    oFtext.focus(function () {
        if ($(this).val() == '') {
            $(this).next("i").hide();
        }

    });
    oFtext.blur(function () {
        if ($(this).val() == '') {
            $(this).next("i").show();
        }
    });
    $(".contbox .cont_right .r_cont ul li  i").click(function () {

        if ($(this).prev(".r_text").val() == '') {
            $(this).hide();
            $(this).prev(".r_text").focus();
        }
    });
    /*var oWwidth=$(window).width();
    var oWheight=$(window).height();
    var oHleft=parseInt(oWwidth/2);   
    var oHtop=parseInt(oWheight/2);
    $(window).mousemove(function(e){
    var oLeft=e.offsetX;
    var oTop=e.offsetY;
    var oMleft=-800+parseInt((oLeft-oHleft)/40);
    var oMtop=-800+parseInt((oTop-oHtop)/40);
    $("#rlBox").stop().animate({"marginLeft":oMleft});
    });*/

    //002
    var oUl = $("#rlBox .contbox .textBox ul");
    var oLi = oUl.children("li");
    oUl.append(oLi.clone());
    oLi = oUl.children("li");
    var oSize = oLi.size();
    var oLiWidth = oLi.width();
    var oWidth = oLiWidth * oSize;
    oUl.width(oWidth);
    var i = 0;
    var oTimer = setInterval(function () {
        i = i + 1;
        if (i >= oSize / 2) {
            i = 0;
            oUl.css({ "marginLeft": "0px" });
        };
        oMleft = -oLiWidth * i;
        oUl.animate({ "marginLeft": oMleft }, 400);
    }, 4000);
    oLi.hover(function () {
        clearInterval(oTimer);
    }, function () {
        oTimer = setInterval(function () {
            i = i + 1;
            if (i >= oSize / 2) {
                i = 0;
                oUl.css({ "marginLeft": "0px" });
            };
            oMleft = -oLiWidth * i;
            oUl.animate({ "marginLeft": oMleft }, 400);
        }, 4000);
    });
});

 