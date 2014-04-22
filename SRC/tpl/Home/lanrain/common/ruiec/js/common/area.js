var Area = {
    value: 0,
    returnValue: 0,
    mychosen: 0,
    getContent: function (succeeFunction, parentId, parentLevel) {
        if (parentId == undefined) parentId = "";
        $.ajax(
        {
            type: "GET",
            url: "/commons/area.ashx",
            data: "cityId=" + parentId + "&level=" + parentLevel,
            cache: true,
            async: true,
            dataType: "html",
            success: succeeFunction,
            error: function (data) { window.alert(data.responseText); }
        });
    },
    nextLevel: function (parentId, parentLevel) {

        if (parentId == "") parentId = 0;
        Area.getContent(function (data) {


            if (parentLevel == 1) {
                if (data.length > 0) {
                    $("#citySecond").attr("disabled", "");
                    $("#citySecond").empty();


                    $(data).appendTo("#citySecond");

                    $("#cityThird").empty();
                    $("<option value='0'>--请选择--</option>").appendTo("#cityThird");
                    $("#cityThird").attr("disabled", "disabled");

                    $("#citySecond").removeClass("chzn-done");
                    $("#cityThird").removeClass("chzn-done");
                    $("#citySecond_chzn").remove();
                    $("#cityThird_chzn").remove();


                }
                else {
                    $("#citySecond").empty();
                    $("#cityThird").empty();

                    if (parentId == 0) {
                        $("<option value='0'>--请选择--</option>").appendTo("#citySecond");
                        $("<option value='0'>--请选择--</option>").appendTo("#cityThird");
                        Area.value = parentId;
                    }
                    else {
                        $("<option>--无下级数据--</option>").appendTo("#citySecond");
                        $("<option>--无下级数据--</option>").appendTo("#cityThird");
                        Area.value = parentId;
                    }
                    $("#citySecond").attr("disabled", "disabled");
                    $("#cityThird").attr("disabled", "disabled");

                    $("#citySecond").removeClass("chzn-done");
                    $("#cityThird").removeClass("chzn-done");
                    $("#citySecond_chzn").remove();
                    $("#cityThird_chzn").remove();
                }

            }
            if (parentLevel == 2) {
                if (data.length > 0) {
                    $("#cityThird").attr("disabled", "");
                    $("#cityThird").empty();
                    $(data).appendTo("#cityThird");


                    $("#cityThird").removeClass("chzn-done");
                    $("#cityThird_chzn").remove();
                }
                else {
                    $("#cityThird").empty();

                    if (parentId == 0) {
                        $("<option value='0'>--请选择--</option>").appendTo("#cityThird");
                    }
                    else {
                        $("<option>--无下级数据--</option>").appendTo("#cityThird");
                        Area.value = parentId;
                    }
                    $("#cityThird").attr("disabled", "disabled");


                    $("#cityThird").removeClass("chzn-done");
                    $("#cityThird_chzn").remove();
                }
            }
            $(".chosen").chosen();
        },
        parentId, parentLevel);
    },
    dochosen: function () {
        if (Area.mychosen == 0) {
            $("#citySecond").removeClass("chzn-done");
            $("#cityThird").removeClass("chzn-done");
            $("#cityFrist").removeClass("chzn-done");
            $("#citySecond_chzn").remove();
            $("#cityThird_chzn").remove();
            $("#cityFrist_chzn").remove();
            $(".chosen").chosen();
            Area.mychosen++;
        }
    },
    init: function () {
        if ($("#areacontainer").html() == null) return;
        Area.getContent(function (data) {
            $("#areacontainer").html(data);
            $(".chosen").chosen();
            $("select").change(function () {
                Area.value = 0;
                if (this.id == "cityFrist" || this.id == "citySecond" || this.id == "cityThird") {
                    var selectValue = $("select[id='" + this.id + "'] option:selected").val();
                    if (selectValue != "" || selectValue != 0) Area.returnValue = selectValue;
                    if (this.id == "cityFrist") {
                        if (selectValue == "" || selectValue == 0) Area.returnValue = 0;
                        Area.nextLevel(selectValue, 1);
                        Area.value = selectValue;
                        return;
                    }
                    if (this.id == "citySecond") {
                        if (selectValue == "" || selectValue == 0)
                            Area.returnValue = $("#cityFrist").val();
                        Area.nextLevel(selectValue, 2);
                        Area.value = selectValue;
                        return;
                    }
                    if (this.id == "cityThird") {
                        if (selectValue == "" || selectValue == 0)
                            Area.returnValue = $("#citySecond").val();
                        Area.value = selectValue;
                    }
                }
            });
        });
    }
}


$(document).ready(function () {
    //Area.init();
});
        