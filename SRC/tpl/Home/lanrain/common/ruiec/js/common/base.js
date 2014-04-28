
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
    },
    AjaxForJson: function (url, type, data, successfn, errorfn) {
        $.ajax({
            contentType: "application/json",
            url: url, type: type, cache: false,
            dataType: "json", data: data,
            success: successfn != undefined ? successfn : function (o) {
                alert(o.d.toString());
            },
            error: errorfn != undefined ? errorfn : function (XMLHttpRequest, textStatus, errorThrown) { alert(XMLHttpRequest.responseText); }
        });
    },
    GetQuery: function (paramName, strHref) {
        var intPos = strHref.indexOf("?");

        var strRight = strHref.substr(intPos + 1);

        var arrTmp = strRight.split("&");

        for (var i = 0; i < arrTmp.length; i++) {
            var arrTemp = arrTmp[i].split("=");

            if (arrTemp[0].toUpperCase() == paramName.toUpperCase()) return arrTemp[1];
        }

        return "";
    },
    DialogDiv: function (dialogName, dialogTitle, iframeSrc, isScrolling, srcParams, iframeWidth, iframeHeight, isOk, isExit, isDrag) {
        JqueryDialog.OpenDialog(dialogName, dialogTitle, iframeSrc, isScrolling, srcParams, iframeWidth, iframeHeight, isOk, isExit, isDrag);
    },
    MainDialogCloseHide: function () {
        $("#jd_dialog_m_h_r").hide();
    },
    AddHomePage: function (obj, vrl) {
        try {
            obj.style.behavior = 'url(#default#homepage)'; obj.setHomePage(vrl);
        }
        catch (e) {
            if (window.netscape) {
                try {
                    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                }
                catch (e) {
                    alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");
                }
                var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
                prefs.setCharPref('browser.startup.homepage', vrl);
            }
        }
    },
    AddFavorite: function (sURL, sTitle) {

        try {
            window.external.addFavorite(sURL, sTitle);
        }
        catch (e) {
            try {
                window.sidebar.addPanel(sTitle, sURL, "");
            }
            catch (e) {
                alert("加入收藏失败，请使用Ctrl+D进行添加");
            }
        }
    },
    SetWindowScrollTop: function (height) {
        $("body,html", window.parent.document).animate({ scrollTop: height }, 1000);
    },
    ChooseAllCbx: function () {  //全选
        $("input[name='cbx']").attr("checked", $("#allCbx").attr("checked"));
    },
    ChooseOneCbx: function () {  //验证只能选择一个复选框
        if ($("input[@type=checkbox]:checked").size() == 0) {
            window.alert("请选择要操作的选项！");
            return false;
        }
        if ($("input[@type=checkbox]:checked").size() == 1) {
            if ($("input[@type=checkbox]:checked").attr('id') == "allCbx") {
                window.alert("请选择要操作的选项！");
                return false;
            }
        }
        if ($("input[@type=checkbox]:checked").size() == 2) {
            if ($("input[@type=checkbox]:checked").attr('id') != "allCbx") {
                window.alert("对不起！不能同时选择多项进行此操作！");
                return false;
            }
        }
        if ($("input[@type=checkbox]:checked").size() > 2) {
            window.alert("对不起！不能同时选择多项进行此操作！");
            return false;
        }
        return true;
    },
    ChooseManyCbx: function () { //验证是否选择了一个或多个
        if ($("input[@type=checkbox]:checked").size() == 0) {
            alert("请选择要操作的选项！");
            return false;
        }
        if ($("input[@type=checkbox]:checked").size() == 1) {
            if ($("input[@type=checkbox]:checked").attr('id') == "allCbx") {
                alert("请选择要操作的选项！");
                return false;
            }
        }
        return true;
    },
    ChooseManyCbxConfirm: function () { //验证是否选择了一个或多个

        if ($("input[@type=checkbox]:checked").size() == 0) {
            return false;
        }

        if ($("input[@type=checkbox]:checked").size() == 1) {
            if ($("input[@type=checkbox]:checked").attr('id') == "allCbx") {
                return false;
            }
        }

        return true;
    },
    TableChange: function () {
        if ($(".right_content table[name='list']")) {
            $(".right_content table[name='list'] tr").bind("mouseover", function () {
                $(this).css("background-color", "rgb(255, 255, 204)")
            });
            $(".right_content table[name='list'] tr").bind("mouseout", function () {
                $(this).css("background-color", "rgb(255, 255, 255)")
            });
        }
    },
    InitSearchQueryDefaultValue: function () {
        var obj = $("#searchTable :text");
        if (obj.size() <= 0) return;
        obj.each(function () {
            var dftxt = $(this).attr("df");
            if (dftxt == undefined) return;
            var val = $.trim($(this).val());
            if (val == "" || val == dftxt) { $(this).val(dftxt).addClass('grayca'); }
            $(this).focus(function () { $(this).removeClass('grayca'); if ($.trim($(this).val()) == dftxt) { $(this).val(''); } })
                   .blur(function () { if ($.trim($(this).val()) == "" || $.trim($(this).val()) == dftxt) { $(this).val(dftxt).addClass('grayca'); } else { $(this).removeClass('grayca'); } });
        });
    },
    ClearTextDefaultValue: function () {
        var obj = $("#searchTable :text");
        if (obj.size() <= 0) return;
        obj.each(function () {
            var dftxt = $(this).attr("df");
            if (dftxt == undefined) return;
            if ($.trim($(this).val()) == dftxt) { $(this).val(''); }
        });
    },
    ClearSearchQuery: function () {
        var txtSize = $("#searchTable :text").size();
        if (txtSize > 0) {
            $("#searchTable :text").each(function () {
                var dftxt = $(this).attr("df");
                if (dftxt == undefined) return;
                $(this).val(dftxt).addClass('grayca');
            });
        }

        var hiddenSize = $("#searchTable .input-search :hidden").size();
        if (hiddenSize > 0) {
            $("#searchTable .input-search :hidden").each(function () { $(this).val(''); });
        }

        var selectSize = $("#searchTable select").size();
        if (selectSize > 0) {
            $("#searchTable select").each(function () {
                var id = $(this).attr("id");
                if ($(this).val() == "-1") return;
                $(this).val("-1");
                $(this).removeClass("chzn-done");
                $("#" + id + "_chzn").remove();

            });
            $(".chosen").chosen();
        }
    }
}
$(function () {
    Base.TableChange();
});
