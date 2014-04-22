// JavaScript Document

$(document).ready(function () {
    //001首页——通用滚动图片效果调用
    wzh_ty_scollImg(".scollImg .scroll-left", ".scollImg .scroll-center", ".scollImg .scroll-right");
    setInterval(function () {
        $(".scollImg .scroll-left img").trigger("click");
    }, 4000);
    //002微智创7大保障
    $(".box img").hover(function () {
        $(this).stop().animate({ "margin-left": "137px", "width": "0px" }, 100, function () {
            $(this).siblings("img").stop().animate({ "margin-left": "0px", "width": "275px" });
        });
    });
    //003首页barner图效果
    var oLi = $(".barImg .b_cont ul li");
    oLi.eq(0).show();
    var oSize = oLi.size();
    for (var i = 0; i < oSize; i++) {
        var oColor = oLi.eq(i).attr("btnColor");
        $(".b_btn ul").append("<li></li>");
        $(".b_btn ul li").eq(i).css({ "background": oColor });
    };
    $(".b_btn ul li").click(function () {
        var oIndex = $(this).index();
        $(".barImg .b_cont ul li").hide().eq(oIndex).fadeIn("slow");
        var oColor2 = $(".b_cont ul li").eq(oIndex).attr("btnColor");
        $(this).parents("#barner").css({ "background": oColor2 });
    });
    //004首页手型应用效果
    wzh_hand_ani();

    //005首页功能介绍效果
    $(".box_fun .ty_cont ul li").hover(function () {
        $(this).children("dl").stop().fadeIn(600);
    }, function () {
        $(this).children("dl").stop().fadeOut(600);
    });
    var oLi = $(".box_fun .ty_cont ul li");
    var oSize = oLi.size();
    var oNum;
    for (var i = 0; i <= oSize; i++) {
        if (i != 0 && i % 5 == 0) {
            oNum = i - 1;
            oLi.eq(oNum).addClass("last");
        };
    };

    //006招商页招财树效果
    setInterval(function () {
        $(".zsBox5 .ty_cont .c_right").append($(".zsBox5 .ty_cont .c_right ul:first").clone());
        var oRandom = parseInt(Math.random() * 100);
        $(".zsBox5 .ty_cont .c_right ul:last").children("li").animate({ "top": "460px", "left": '+=' + oRandom + '' }, 8000);
    }, 6000);

    //007招商统计图效果
    var i = 5;
    wzh_bus_statistics(i);

    //008云朵效果
    wzh_moveCloud(".imgcloud ul", "-1", 10, 0.2);
    var oWindowWidth = $(window).width();           //屏幕宽度	
    var oWindowHeight = $(window).height(); 	  //屏幕高度
    var oHalfWidth = parseInt(oWindowWidth / 2);
    var oHalfHeight = parseInt(oWindowHeight / 2);
    var oDiv = $(".barner_zs .zs_barnerCenter");  //中间随屏幕移动的文字
    var oDivMarginLeft = parseInt(oDiv.css("marginLeft"));
    var oDivMarginTop = parseInt(oDiv.css("marginTop"));
    $(".barner_zs").mousemove(function (e) {
        var oX = e.offsetX;
        var oY = e.offsetY;
        var oLeft = parseInt((oX - oHalfWidth) / 40);
        var oTop = parseInt((oY - oHalfHeight) / 40);
        var oMarginLeft = oDivMarginLeft + oLeft;
        var oMarginTop = oDivMarginTop + oTop;
        oDiv.css({ "marginLeft": oMarginLeft, "marginTop": oMarginTop });
    });

    //009关于微智创锚点效果
    if ($(".aboutBox").size() > 0) {
        $(".aboutBox ul li a").click(function () {
            $(this).parents("ul").children("li").removeClass("select");
            $(this).parent("li").addClass("select");
            var oLink = $(this).attr("href");
            var oSize = $(".c_box").size();
            for (var i = 0; i < oSize; i++) {
                if ($(".c_box").eq(i).attr("md") == oLink) {
                    var oTop = $(".c_box").eq(i).offset().top;
                    $("html,body").animate({ "scrollTop": oTop }, 600);
                    $(".c_box").removeClass("select").eq(i).addClass("select");
                };
            };
        });
        var oNavDiv = $(".aboutBox .about_left ul");
        var oNavTop = oNavDiv.offset().top;
        $(window).scroll(function () {
            var oWscrllTop = $(window).scrollTop();
            var i = 0;
            var oRbox = $(".c_box");
            var oBsize = oRbox.size();
            for (i = 0; i < oBsize; i++) {
                if (oRbox.eq(i).offset().top - 200 < oWscrllTop) {
                    oRbox.removeClass("select").eq(i).addClass("select");
                    oNavDiv.children("li").removeClass("select").eq(i).addClass("select");
                };
            };
            if (oWscrllTop >= oNavTop) {
                oNavDiv.css({ "position": "fixed", "top": "0px" });
            }
            else {
                oNavDiv.css({ "position": "relative", "top": "0px" });
            };
        });

    };

    //10支付页面tab切换
    $(".payCont .c_tit a").click(function () {
        var oIndex = $(this).index();
        $(this).parent().children("a").removeClass("select");
        $(this).addClass("select");
        $(this).parents(".payCont").find(".tabBox").hide().eq(oIndex).show();
    });

    //11产品介绍页按钮ios效果
    var oSdiv = $("#iosLink");
    var oWidth = oSdiv.width() + 130;
    var oMargin = -parseInt(oWidth / 2);
    oSdiv.css({ "marginLeft": oMargin });
    $("#iosLink ul li img").hover(function () {
        $(this).stop().animate({ "height": "110px", "width": "110px", "marginTop": "-55px", "marginLeft": "-55px" });
        $(this).siblings(".f_text").show();

    }, function () {
        $(this).stop().animate({ "height": "50px", "width": "50px", "marginTop": "0px", "marginLeft": "-25px" });
        $(this).siblings(".f_text").hide();
    });
    var oMsize = $(".pBox").size();
    for (var i = 0; i < oMsize; i++) {
        var oMove = "link" + (i + 1);
        $(".pBox").eq(i).attr("oMove", oMove);
    };
    $("#iosLink ul li a").click(function () {
        var oIndex = $(this).parent("li").index() + 1;
        var oLink = "link" + oIndex;
        var oDiv = ".pBox[oMove=" + oLink + "]";
        var oDtop = $(".pBox").eq(oIndex - 1).offset().top;
        $("html,body").stop().animate({ "scrollTop": oDtop }, 800);
    });

    //12首页二维码效果
    $(".loginbox .lcor .pc").click(function () {
        $(".loginbox .lbox").fadeOut().eq(1).fadeIn();
        $(".loginbox .lcor a").hide();
        $(".loginbox .lcor .phone").show();
    });
    $(".loginbox .lcor .phone").click(function () {
        $(".loginbox .lbox").fadeOut().eq(0).fadeIn();
        $(".loginbox .lcor a").hide();
        $(".loginbox .lcor .pc").show();
    });

    //13会员页背景
    if ($(".user").size() > 0) {
        $("body").css({ "background": "#f1f1f1" });
        $(".user .u_left .u_navBox .n_cont dl dt").click(function () {
            $(".user .u_left .u_navBox .n_cont dl dd").stop().slideUp();
            $(this).siblings("dd").stop().slideDown();
        });
    };
    //会员验表单证是否为空效果
    var oTsize = $(".table2").size();
    var oTdiv = '<span class="Prompt_wrong"><i></i>不能为空，请重新输入</span>'
    if (oTsize > 0) {
        $(".table2 .ty_text").blur(function () {
            if ($(this).val() == '' && $(this).siblings(".Prompt_wrong").size() == 0) {
                $(this).parent().append(oTdiv);
            } else {
                $(this).siblings(".Prompt_wrong").remove();
            };
        });
    };

});

//008通用滚动图片效果wzh_ty_scollImg(oLeft,oCenter,oRight)，参数oLeft,oCenter,oRight分别代表滚动图片左中右div
function wzh_ty_scollImg(oLeft, oCenter, oRight) {
    var oSLBox = $(oLeft); 	  //滚动图片左侧
    var oSCBox = $(oCenter);  //滚动图片中间
    var oSRBox = $(oRight);   //滚动图片右侧
    var oSBtnLeft = oSLBox.children("img"); 		//左按钮
    var oSBtnRight = oSRBox.children("img"); 	//右按钮
    var oSUl = oSCBox.children("ul");
    var oSLi = oSUl.children("li");
    oSUl.append(oSLi.clone()); 				//复制li数量追加到ul上
    oSLi = oSUl.children("li");
    oSsize = oSLi.size();
    var oSLiWidth = oSLi.width();
    var oSLiMargin = parseInt(oSLi.css("marginRight"));
    oSLiRWidth = oSLiWidth + oSLiMargin;          			//计算后单个li的宽度
    oSUl.css({ "width": oSLiRWidth * oSsize });    		 	//计算后单个ul的宽度
    oSUlRWidth = oSUl.width();
    //点击左侧按钮
    oSBtnLeft.click(function () {
        var oMove = parseInt(oSUl.css("left"));        		//每次点击前判断一下left值
        oMove = oMove - oSLiRWidth;
        if (oMove < -oSUlRWidth / 2) {
            oSUl.css({ "left": "0px" });
            oSUl.stop().animate({ "left": -oSLiRWidth });
        }
        else {
            oSUl.stop().animate({ "left": oMove });
        };
    });
    //点击右侧按钮
    oSBtnRight.click(function () {
        var oMove = parseInt(oSUl.css("left"));
        oMove = oMove + oSLiRWidth;
        if (oMove > 0) {
            oSUl.css({ "left": -oSUlRWidth / 2 });
            oSUl.stop().animate({ "left": (-oSUlRWidth / 2 + oSLiRWidth) });
        }
        else {
            oSUl.stop().animate({ "left": oMove });
        };
    });
}

//004首页手型效果调用
function wzh_hand_ani() {
    var oBox = $(".box_lose .loseAni");
    var oHand = oBox.children(".Ani_hand");
    var oIcon1 = oBox.children(".Ani_icon1");
    var oIcon2 = oBox.children(".Ani_icon2");
    var oIcon3 = oBox.children(".Ani_icon3");
    var oIcon4 = oBox.children(".Ani_icon4");
    var oIcon5 = oBox.children(".Ani_icon5");
    var oIcon6 = oBox.children(".Ani_icon6");
    var oIcon7 = oBox.children(".Ani_icon7");
    var oIcon8 = oBox.children(".Ani_icon8");
    var oIcon9 = oBox.children(".Ani_icon9");
    var oIcon10 = oBox.children(".Ani_icon10");
    var oIcon11 = oBox.children(".Ani_icon11");
    oHand.animate({ "left": "280px", "top": "0px", "opacity": "1" }, 1000, function () {
        oIcon1.animate({ "opacity": "1" }, 100, function () {
            oIcon2.animate({ "opacity": "1" }, 100, function () {
                oIcon3.animate({ "opacity": "1" }, 200, function () {
                    oIcon4.animate({ "opacity": "1" }, 200, function () {
                        oIcon5.animate({ "opacity": "1" }, 300, function () {
                            oIcon6.animate({ "opacity": "1" }, 400, function () {
                                oIcon7.animate({ "opacity": "1" }, 400, function () {
                                    oIcon8.animate({ "opacity": "1" }, 500, function () {
                                        oIcon9.animate({ "opacity": "1" }, 600, function () {
                                            oIcon10.animate({ "opacity": "1" }, 700, function () {
                                                oIcon11.animate({ "opacity": "1" }, 800);
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });
        });
    });
}

//007招商统计图效果
function wzh_bus_statistics(i) {
    $(".statistics img").eq(i).animate({ "height": "370px" }, 600, function () {
        i--;
        if (i < 0) {
            $(".statistics img").eq(6).animate({ "height": "370px" }, 1000);
        };
        wzh_bus_statistics(i);
    });
};

//008招商云朵效果
function wzh_moveCloud(obj, direction, speed, range) {
    var oMove2 = 0;
    var oUl = $(obj);
    var oLi = oUl.children("li");
    var oLiWidth = oLi.width();
    oUl.append(oLi.clone());
    var oLi = oUl.children("li");
    var oLiSize = oLi.size();
    var oUlWidth = oLiWidth * oLiSize;
    oUl.css({ "width": oUlWidth });
    if (direction == "1") {
        setInterval(function () {
            oMove2 = oMove2 + range;
            if (oMove2 > 0) {
                oMove2 = -oLiWidth;
            };
            $(obj).css({ "left": oMove2 });
        }, speed);
    }
    else if (direction = "-1") {
        setInterval(function () {
            oMove2 = oMove2 - range;
            if (oMove2 < -oUlWidth / 2) {
                oMove2 = 0;
            };
            $(obj).css({ "left": oMove2 });
        }, speed);
    };
};