/*!
* index
* Author: 姚金良
* Date: 2013-12-12
*/
var Base = {
    AjaxForHTML: function (url, type, data, successfn, errorfn) {
        $.ajax({
            url: url, type: type, cache: false,
            dataType: "html", data: data,
            success: successfn != undefined ? successfn : function (o) {
                alert(o);
            },
            error: errorfn != undefined ? errorfn : function (XMLHttpRequest, textStatus, errorThrown) { alert(XMLHttpRequest.responseText); }
        });
    }
}
function GetWenxin() {
    art.dialog({
        padding: 0,
        title: '公众号二维码',
        content: '<img src="/images/258.jpg" width="258" height="258" />',
        lock: true
    });
}


// 客户案例
function showCode(elem, show) {
    var $elem = $(elem),
		$code = $elem.prev('.code');
    if (show) {
        $code.show().css({
            'opacity': 0
        }).stop().animate({
            'margin-top': 78,
            'opacity': 1
        }, function () {
            $code.show();
        });
    } else {
        $code.css({
            'opacity': $code.css('opacity')
        }).stop().animate({
            'margin-top': 98,
            'opacity': 0
        }, function () {
            $code.hide();
        });
    }
}

$(function () {
    $('#Nav li.fl').hover(
		function () {
		    $(this).addClass("con");
		    $(this).find("span.down").show();
		},
		function () {
		    $(this).removeClass("con");
		    $(this).find("span.down").hide();
		}
	);
    var url = window.location.href;
    $('#Nav li.fl').each(function (i, val) {
        if ($(this).find("a").attr("href") != "/") {
            if (url.indexOf($(this).find("a").attr("href")) > 0)
                $(this).addClass("fcon");
        }
    });

    $('.block_case .circle').hover(
		function () {
		    showCode(this, true);
		},
		function () {
		    showCode(this, false);
		}
	);
    $('#send').click(function () {

        art.dialog({
            padding: 0,
            title: '用户登录',
            content: document.getElementById('send-form'),
            lock: true
        });

        $("#tbxName")[0].focus();
        ChangeValidateCode();
    });
    $('#send2').click(function () {

        art.dialog({
            padding: 0,
            title: '用户登录',
            content: document.getElementById('send-form'),
            lock: true
        });
        $("#tbxName")[0].focus();
        ChangeValidateCode();
    });
});

function CheckUser() {
    
    var nameObj = $("#tbxName"), nameVal = $.trim(nameObj.val());
    if (nameVal == "") {
        setErrorSpan("请输入用户名！");
        nameObj[0].focus();
        return false;
    }
    if (nameVal.length < 4) {
        setErrorSpan("格式错误！");
        nameObj[0].select();
        return false;
    }


    var pwdObj = $("#tbxPwd"), pwdVal = $.trim(pwdObj.val());
    if (pwdVal == "") {
        setErrorSpan("请输入密码！");
        pwdObj[0].focus();
        return false;
    }
    if (pwdVal.length < 5) {
        setErrorSpan("请输入正确的密码！");
        pwdObj[0].select();
        return false;
    }


    var codeObj = $("#tbxValidateCode"), codeVal = $.trim(codeObj.val());
    if (codeVal == "") {
        setErrorSpan("请输入验证码！");
        codeObj[0].focus();
        return false;
    }
    if (codeVal.length != 4) {
        setErrorSpan("请输入正确的验证码！");
        codeObj[0].select();
        return false;
    }
    var param = "name=" + nameVal + "&pwd=" + pwdVal + "&code=" + codeVal;

    Base.AjaxForHTML("/UserLogin.aspx", "get", param, function (data) {

        if (data == "success") {

            location.href = "/user/main.aspx";
        } else {

            var msg = "";
            
            switch (data) {
                case "getCodeNull": msg = "获取验证码失败，请刷新页面后再试！"; break;
                case "codeNull": msg = "请输入验证码！"; codeObj.focus(); break;
                case "codeError": msg = "验证码输入错误！"; codeObj.select(); break;
                case "nameNull": msg = "请输入用户名！"; nameObj.focus(); break;
                case "pwdNull": msg = "请输入密码"; pwdObj.focus(); break;
                case "serviceError": msg = "服务器响应超时，请稍后再试！"; break;
                case "logins": msg = "您好，因为您连续的错误密码尝试。账户已被冻结，请稍后再试。"; break;
                case "inputError": msg = "用户名或密码错误，请重新输入后再试！"; nameObj.focus(); break;
                case "userDisabled": msg = "您的账号已被禁用，如需登录，请联系管理员！"; break;
                default: msg = "登录失败，请稍后再试!"; break;
            }
            setErrorSpan(msg);
        }
    });
}
function CheckUserIndex() {

    var nameObj = $("#tbxName"), nameVal = $.trim(nameObj.val());
    if (nameVal == "") {
        setErrorSpan("请输入用户名！");
        nameObj[0].focus();
        return false;
    }

    var pwdObj = $("#tbxPwd"), pwdVal = $.trim(pwdObj.val());
    if (pwdVal == "") {
        setErrorSpan("请输入密码！");
        pwdObj[0].focus();
        return false;
    }


    return true;
/*
    var param = "name=" + nameVal + "&pwd=" + pwdVal + "&code=ruicms";

    Base.AjaxForHTML("/UserLogin.aspx", "get", param, function (data) {

        if (data == "success") {

            location.href = "/user/main.aspx";
        } else {

            var msg = "";

            switch (data) {
                case "getCodeNull": msg = "获取验证码失败，请刷新页面后再试！"; break;
                case "codeNull": msg = "请输入验证码！"; codeObj.focus(); break;
                case "codeError": msg = "验证码输入错误！"; codeObj.select(); break;
                case "nameNull": msg = "请输入用户名！"; nameObj.focus(); break;
                case "pwdNull": msg = "请输入密码"; pwdObj.focus(); break;
                case "serviceError": msg = "服务器响应超时，请稍后再试！"; break;
                case "logins": msg = "您好，因为您连续的错误密码尝试。账户已被冻结，请稍后再试。"; break;
                case "inputError": msg = "用户名或密码错误，请重新输入！"; nameObj.focus(); break;
                case "userDisabled": msg = "您的账号已被禁用，如需登录，请联系管理员！"; break;
                default: msg = "登录失败，请稍后再试!"; break;
            }
            setErrorSpan(msg);
        }
    });
*/
}
function setErrorSpan(txt) {
    $("#errtitle").html(txt);
}

function ChangeValidateCode() {
    $("#createCode").attr("src", "/commons/loginCode.aspx?" + Math.random());
}

/*绑定选项卡
*所用参数:
*main - 主体对象
*item - 单例对象
*itemClass - 选中状态下添加的Class名称
*showArea - 展示区对象
*actionName - 绑定事件处理函数名称，例如 click ，mouseover等
*fun - 选项卡切换时，执行的方法
*/
function TabBar(main, items, item, itemClass, showArea, actionName, fun) {
    $(main).each(function (i) {
        var ob = $(this);
        ob.find(items).on(actionName, function () {
            var t = $(this).parent().children(item).index($(this).parent().find("." + itemClass));
            var j = $(this).parent().children(item).index($(this));
            if (t != j) {
                $(this).parent().find("." + itemClass).removeClass(itemClass);
                $(this).addClass(itemClass);
                ob.find(showArea).slice(t, t + 1).hide();
                ob.find(showArea).slice(j, j + 1).show();
                
                if (fun != undefined)
                    fun(ob,t,j);
            }
        });
    });
}