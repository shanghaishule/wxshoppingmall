

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>
	找回密码
</title><meta property="qc:admins" content="02502774076251536654" /><link rel="stylesheet" type="text/css" href="/css/style.css" />
    <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/js/myself.js"></script>
    <meta name="Keywords" content="微信营销|微智创|微信公众平台" /><meta name="Description" content="微智创是源中瑞实验室自主研发的旗下品牌，微智创是中国领先的微信解决方案提供商，国内领先的基于微信公众平台的营销工具，已服务数万家企业，最早被认可的、最信赖的优质微信解决方案提供商。因为对企业移动互联网布局的突出贡献，微智创已获得了包括中国互联网协会、中国互联网数据中心、等官方权威行业协会的认可，并已达成战略合作伙伴关系" />
    <link href="/css/validate.css" rel="stylesheet" type="text/css" />
    <link href="/css/retrievepwd.css" rel="stylesheet" type="text/css" />
    <script src="/js/common/jquery.validator.js" type="text/javascript"></script>
    <script src="/js/common/formValidatorRegex.js" type="text/javascript"></script>
    <script src="/js/common/Jquery.Cookie.js" type="text/javascript"></script>
    <script src="/js/common/base.js" type="text/javascript"></script>
</head>
<body>
    <form method="post" action="retrievepwd.aspx" id="form1">
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUKMjExNjYwODM4M2Rk" />

    <!--header头部-->
    <div id="header">
        <!--快捷导航块-->
        <div class="shorcutbox">
            <div class="resize">
                <div class="s_left">
                    <p>
                        
                        您好， 欢迎您!&nbsp;<a href="/login.aspx">登录</a>&nbsp; | &nbsp;<a href="/register.aspx#reg">注册</a>
                        
                    </p>
                </div>
                <div class="s_right">
                    <p>
                        <a href="/About.html">微智创</a>|<a href="/product.html">微网站</a>|<a href="/product.html">微信商城</a><span
                            class="tel">0755-33581131</span>
                    </p>
                </div>
            </div>
        </div>
        <!--导航块-->
        <div class="navbox">
            <div class="resize over_v">
                <!--logo-->
                <div class="logo">
                    <a href="#">
                        <img src="/images/logo.jpg" width="280" height="58" /></a>
                </div>
                <!--导航-->
                <div class="nav">
                    <ul>
                        <li><a class="select" href="/">首页</a></li>
                        <li><a href="/About.html">走进微智创</a> </li>
                        <li><a href="/product.html">产品与服务</a> </li>
                        <li><a href="/InfoCenter.aspx">微智创学院 </a></li>
                        <li><a href="/canvass.aspx">渠道代理</a></li>
                        <li><a href="/contact.html">联系我们</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--barner-->
    
    <div id="firstDiv" class="ln-md">
        <div class="repasstop lft" style="display: none;">
            <div class="pssnavli pzi pcolors ">
                1. 输入用户名
            </div>
            <div class="pssnavli pzi pcolorthr">
                2. 选择找回方式
            </div>
            <div class="pssnavli pzi pcolorthr">
                3. 确认验证信息
            </div>
        </div>
        <div class="lo_box margintop lft">
            <div class="libcons marptits2 lft">
                <table cellpadding="0" cellspacing="10" border="0" width="700px">
                    <tr>
                        <td colspan="3" align="left">
                            <span class="lotitlesrd marptits">找回密码</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="18%" style="text-align: right;">
                            用户名：
                        </td>
                        <td width="35%" align="left">
                            <input name="ctl00$ContentPlaceHolder1$tbxAccountName" type="text" maxlength="30" id="ContentPlaceHolder1_tbxAccountName" class="loinput" />
                        </td>
                        <td width="50%">
                            <div class="tipText">
                                <span class="lef">&nbsp;</span><span class="cent" id="ContentPlaceHolder1_tbxAccountNameTip"></span><span
                                    class="rig">&nbsp;</span></div>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            验证码：
                        </td>
                        <td>
                            <input name="ctl00$ContentPlaceHolder1$tbxValidateCode" type="text" maxlength="5" id="ContentPlaceHolder1_tbxValidateCode" class="loinput lft" style="width: 120px;" />
                            <span class="codepg ">
                                <img id="createCode" width="100"  alt="看不清楚？点击换一张" title="看不清楚？点击换一张" onclick="ChangeValidateCode();" /></span>
                        </td>
                        <td>
                            <div class="tipText">
                                <span class="lef">&nbsp;</span><span class="cent" id="ContentPlaceHolder1_tbxValidateCodeTip"></span><span
                                    class="rig">&nbsp;</span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <div class="lotwo">
                                <input id="firstBtn" type="button" class="okinfos-butyess" value="下一步" /></div>
                        </td>
                        <td>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="clear">
            </div>
        </div>
    </div>
    <div id="selectType" class="ln-md lft" style="display: none;">
        <div class="repasstop2 lft" style="display: none;">
            <div class="pssnavli pzi pcolortwo ">
                1. 输入用户名
            </div>
            <div class="pssnavli pzi pcolors">
                2. 选择找回方式
            </div>
            <div class="pssnavli pzi pcolorthr">
                3. 确认验证信息
            </div>
        </div>
        <div class="lo_box margintop lft">
            <div class="clear">
            </div>
            <div class="libcons marptits2 lft">
                <div class="clear">
                </div>
                <ul id="ulSelectType">
                    <li><span class="lotitlesrd marptits">找回密码</span></li>
                    <li>
                        <div class="loone">
                            <span class="pasin ">
                                <input name="rpwType" type="radio" value="0" /></span></div>
                        <div class="lotwo">
                            <span class="pafint14">通过邮箱找回</span><br />
                            您的邮箱<span id="selectTypeEmailSpan" class="pdsz"></span>将收到验证邮件，通过邮件中的找回链接完成密码重置。</div>
                    </li>
                    <li style="display: none;">
                        <div class="loone">
                            <span class="pasin ">
                                <input name="rpwType" type="radio" value="1" /></span></div>
                        <div class="lotwo">
                            <span class="pafint14">通过手机号码找回</span><br />
                            您的手机<span class="pdsz"><a href="#">135*****983</a></span>将收到验证码，通过输入手机收到的验证码完成密码重置，本服务完全免费。</div>
                    </li>
                    <li>
                        <div class="loone">
                            &nbsp;</div>
                        <div class="lotwo">
                            <input id="selectTypeBtn" type="button" class="okinfos-butyess" value="下一步" />
                            <span id="errprSecondSpan"></span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="clear">
            </div>
        </div>
    </div>
    <div id="confrimSuccessDiv" class="ln-md lft" style="display: none;">
        <div class="repasstop3 lft" style="display: none;">
            <div class="pssnavli pzi pcolortwo ">
                1. 输入用户名
            </div>
            <div class="pssnavli pzi pcolortwo">
                2. 选择找回方式
            </div>
            <div class="pssnavli pzi pcolors">
                3. 确认验证信息
            </div>
        </div>
        <div class="lo_box margintop lft">
            <div class="clear">
            </div>
            <div class="libcons marptits2 lft">
                <div class="clear">
                </div>
                <ul>
                    <li><span class="lotitlesrd marptits">找回密码</span></li>
                    <li>
                        <div class="loone">
                            &nbsp;</div>
                        <div class="lotwo" id="returnInfoDiv">
                        </div>
                    </li>
                </ul>
            </div>
            <div class="clear">
            </div>
        </div>
    </div>
    <script type="text/javascript">

        $(document).ready(function () {
            $("#createCode").attr("src", "/commons/RpwValidateCode.aspx?" + Math.random());
        });

        function ChangeValidateCode() {
            $("#createCode").attr("src", "/commons/RpwValidateCode.aspx?" + Math.random());
        }
 
    </script>
    <script type="text/javascript">
        var _fv = undefined;
        function formV() {
            _fv = $('#form1').FromValidate();

            $("#ContentPlaceHolder1_tbxAccountName").InitValidate({
                fv: _fv,
                TipText: "请输入您注册的账号。",
                Correct: "输入正确"
            }).requireValidator({
                errorText: "不能为空，请重新输入"
            }).regexValidator({
                regex: regexEnum.username,
                errorText: "仅由英文、数字、下划线组成"
            }).lenValidator({
                min: 4,
                max: 18,
                errorText: "账号长度为4-12位"
            }).ajaxValidator({
                url: "/commons/retrievePwd.ashx?name={0}",
                succFn: function (s) { return s == "true"; },
                doingText: "正在验证中",
                errorText: "账号不存在，请重新输入！"
            });

            $("#ContentPlaceHolder1_tbxValidateCode").InitValidate({
                fv: _fv,
                TipText: "请输入左边的验证码",
                Correct: "输入正确"
            }).requireValidator({
                errorText: "不能为空，请重新输入"
            }).lenValidator({
            min: 4,
            max: 4,
                errorText: "输入错误，请重新输入"
            }).ajaxValidator({
                url: "/commons/retrievePwd.ashx?regCode={0}",
                succFn: function (s) { return s == "true"; },
                doingText: "正在验证中",
                errorText: "验证码输入错误，请重新输入！"
            });

        }

        $(function () {
            formV();
        });

        $("#firstBtn").click(function () {
            if ($.FromValidate(_fv)) {
                var name = $.trim($("#ContentPlaceHolder1_tbxAccountName").val());
                var params = "accountname=" + name + "&type=returnEmail";
                Base.AjaxForHTML("retrievepwd.aspx", "get", params, function (data) {
                    setBtnStyle("firstDiv", false);
                    setBtnStyle("selectType", true);
                    switch (data) {
                        case "nullEmail": $("#ulSelectType").html("<li><span class=\"lotitlesrd marptits\">对不起您的账号还未设置邮箱，请联系我们的客户人员。</span></li>"); break;
                        case "n":
                            setBtnStyle("firstDiv", true);
                            setBtnStyle("selectType", false);
                            break;
                        default:
                            if (data.indexOf("@") >= 0)
                                $("#selectTypeEmailSpan").html("<a href=\"javascript:void(0);\">" + data + "</a>");
                            else
                                alert("参数错误，请刷新页面后再试...");
                            break;
                    }
                });
            }
        });

        $("#selectTypeBtn").click(function () {
            var success = $.FromValidate(_fv);
            if (!success) {
                setBtnStyle("firstDiv", true);
                setBtnStyle("selectType", false);
                return;
            }

            var name = $.trim($("#ContentPlaceHolder1_tbxAccountName").val());
            var code = $.trim($("#ContentPlaceHolder1_tbxValidateCode").val());
            if (name == "" || code == "") {
                setBtnStyle("firstDiv", true);
                setBtnStyle("selectType", false);
                setBtnStyle("confrimSuccessDiv", false);
                return;
            }

            var rdoObj = $("input[name='rpwType']:checked");
            var rdoVal = rdoObj.val();
            if (rdoVal == undefined || rdoVal == null) { alert("请选择找回方式！"); return; }
            var params = "accountname=" + name + "&sendType=" + rdoVal + "&rpwcode=" + code;
            $(this).hide(); $("#errprSecondSpan").html("正在提交您的请求，请稍后...");
            Base.AjaxForHTML("retrievepwd.aspx", "get", params, function (data) {
                switch (data) {
                    case "codeError":
                    case "userNull":
                    case "userDisable":
                    case "emailNull":
                        alert("您的账号有错误，无法发送邮件，请联系我们的客服人员。");
                        setBtnStyle("firstDiv", true);
                        setBtnStyle("selectType", false);
                        setBtnStyle("confrimSuccessDiv", false);
                        break;
                    case "error":
                    case "sendError":
                        alert("发送重置密码邮件失败，请稍后再试！");
                        setBtnStyle("firstDiv", true);
                        setBtnStyle("selectType", false);
                        setBtnStyle("confrimSuccessDiv", false);
                        break;
                    case "sendEmailNumber":
                        $("#returnInfoDiv").html("对不起，您已用完每天限发重置密码邮件次数！");
                        setBtnStyle("firstDiv", false);
                        setBtnStyle("selectType", false);
                        setBtnStyle("confrimSuccessDiv", true);
                        break;
                    default:
                        if (data.indexOf("success") >= 0) {
                            var dataArray = data.split('|');
                            if (null != dataArray && dataArray.length == 4) {
                                if (dataArray.length == 4) {
                                    var html = "<p class=\"tishitext\">请登录您的邮箱查收重置密码邮件，该邮件24小时内有效。若没有收到，您可以 "
                                                + "<input id=\"iptResendEmailBtn\" type=\"button\" value=\"点击重发验证邮件\" class=\"fsyzm\" onclick=\"ResendEmail();\"/><span id=\"resendSendSpan\"></span> "
                                                + " 。每天限发送五封重置密码邮件。</p>"
                                                + "<p class=\"f-14 email\"> 接收邮箱:<strong id=\"strongEmail\" mail=\"" + dataArray[3] + "\">" + dataArray[1] + "</strong></p>"
                                                + "<p><input id=\"openEmailBtn\" type=\"button\" class=\"okinfos-butyess\" value=\"GO 邮箱\" onclick=\"GoEmail();\"/></p>";

                                    $("#returnInfoDiv").html(html);
                                    $("#errprSecondSpan").html("");
                                    setBtnStyle("firstDiv", false);
                                    setBtnStyle("selectType", false);
                                    setBtnStyle("confrimSuccessDiv", true);
                                }
                            }
                            else {
                                alert("操作异常，请刷新页面后再试");
                                location.reload();
                            }
                        }
                        else {
                            alert("操作异常，请刷新页面后再试");
                            location.reload();
                        }
                        break;
                }
            });
        });

        function ResendEmail(obj) {
            var obj = $("#iptResendEmailBtn");

            var name = $.trim($("#ContentPlaceHolder1_tbxAccountName").val());
            var code = $.trim($("#ContentPlaceHolder1_tbxValidateCode").val());
            if (name == "" || code == "") {
                setBtnStyle("firstDiv", true);
                setBtnStyle("selectType", false);
                setBtnStyle("confrimSuccessDiv", false);
            }

            var params = "accountname=" + name + "&sendType=0&rpwcode=" + code;
            obj.hide(); $("#resendSendSpan").html("发送中，请稍后...");
            Base.AjaxForHTML("retrievepwd.aspx", "get", params, function (data) {
                switch (data) {
                    case "codeError":
                    case "userNull":
                    case "userDisable":
                    case "emailNull":
                        alert("您的账号有错误，无法发送邮件，请联系我们的客服人员。");
                        setBtnStyle("firstDiv", true);
                        setBtnStyle("selectType", false);
                        setBtnStyle("confrimSuccessDiv", false);
                        break;
                    case "error":
                    case "sendError":
                        alert("发送重置密码邮件失败，请稍后再试！");
                        setBtnStyle("firstDiv", true);
                        setBtnStyle("selectType", false);
                        setBtnStyle("confrimSuccessDiv", false);
                        break;
                    case "sendEmailNumber":
                        $("#returnInfoDiv").html("对不起，您已用完每天限发重置密码邮件次数！");
                        setBtnStyle("firstDiv", false);
                        setBtnStyle("selectType", false);
                        setBtnStyle("confrimSuccessDiv", true);
                        break;
                    default:
                        if (data.indexOf("success") >= 0) {
                            var dataArray = data.split('|');
                            if (null != dataArray && dataArray.length == 4) {
                                if (dataArray.length == 4) {
                                    alert("重发验证信息成功！您今天已申请发送了 " + dataArray[2] + " 封重置密码邮件。");
                                    obj.show(); $("#resendSendSpan").html("");
                                }
                            }
                            else {
                                alert("操作异常，请刷新页面后再试");
                                location.reload();
                            }
                        }
                        else {
                            alert("操作异常，请刷新页面后再试");
                            location.reload();
                        }
                        break;
                }
            });

        }

        function GoEmail() {
            var mailUrl = $("#strongEmail").attr("mail");
            location.href = "http://mail." + mailUrl;
        }

        function setBtnStyle(objId, isTrue) {
            var obj = $("#" + objId);
            if (isTrue) { obj.show(); } else { obj.hide(); }
        }
        
    </script>
    <div class="clear">
    </div>

    <!--footer底部-->
    <div id="footer">
        <div class="resize">
            <div class="f_left">
                <a href="#">
                    <img src="/images/wzc_img_78.jpg" width="279" height="58" /></a>
            </div>
            <div class="f_center">
                <p>
                    <a class="first" href="/About.html">走进微智创</a>| <a href="/product.html">产品与服务</a>|
                    <a href="/InfoCenter.aspx">微智创学院</a>| <a href="/canvass.aspx">渠道代理</a>| <a href="/contact.html">
                        联系我们</a>
                </p>
                <p>
                    微智创 微信公众平台营销源码 帮助您快速搭建属于自己的营销平台,构建自己的客户群体。<br />
                    大转盘、刮刮卡，会员卡,优惠卷,订餐,订房等营销模块,客户易用,易懂,易营销（Ruicms-3易服务理念）。<br />
                    微智创 多用户微信营销系统(c)2013 Ruicms版权所有 <a href="http://www.miitbeian.gov.cn" target="_blank">
                        粤ICP备11077838号-2</a><script type="text/javascript">                                                var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://"); document.write(unescape("%3Cspan id='cnzz_stat_icon_5821628'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s23.cnzz.com/stat.php%3Fid%3D5821628%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
</p>
            </div>
            <div class="f_right">
                <dl>
                    <dt>
                        <img src="/images/wzc_2wm.jpg" width="110" height="110" /></dt>
                    <dd>
                        扫二维码关注我们</dd>
                </dl>
            </div>
        </div>
    </div>
    </form>
</body>
</html>
