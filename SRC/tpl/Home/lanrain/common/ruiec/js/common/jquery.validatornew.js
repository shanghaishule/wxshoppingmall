(function($)
{
    var v_status = {
        Error: 0,
        Success: 1,
        Doing: 2,
        Ready: 3
    };

    $.FromValidate = function(f)
    {
        var vl = {};
        try
        {
            vl = f.data("vl");
        } catch (e)
        {
            vl = $(f).data("vl");
        }
        var allV = true;
        $.each(vl, function(i, t)
        {
            var state = $("#" + t, f).data("v_state");
            if (state == v_status.Ready)
            {
                $("#" + t, f)
                        .removeClass("g-ipt-active")
                        .validate();
            }
            if ($("#" + t, f).data("v_state") != v_status.Success)
            {
                allV = false;

            }

        });
        return allV;
    }

    $.fn.FromValidate = function()
    {

        return this.each(function()
        {
            $(this).data("vl", new Array());

            $(this).bind("submit", function()
            {
                return $.FromValidate(this);
            })

        });


    }

    $.fn.InitValidate = function(cfg)
    {
        var fv = cfg.fv;
        return this.each(function()
        {
            var idl = {
                correct: cfg.Correct,
                tipText: cfg.TipText,
                withOutBlur: cfg.withOutBlur,
                rl: new Array(),
                ar: {
                    rl: new Array()
                }
            };

            fv.data("vl").push(this.id);

            $(this).data("idl", idl);

            var tip = $("#" + this.id + "Tip").html("");
            var tippar = tip.addClass("tipText")
                        .removeClass("tipSucc")
                        .removeClass("tipWait")
                        .removeClass("tipErr");
            $(this)

                .focus(function()
                {
                    tip.html("");
                    tip.addClass("tipText")
                        .removeClass("tipSucc")
                        .removeClass("tipWait")
                        .removeClass("tipErr");
                    ;

                })
                .blur(function()
                {
                    if (!idl.withOutBlur) $(this).validate();
                });
        });
    }
    $.BaseValidator = function($this, cfg, fn)
    {

        $this.data("v_state", v_status.Ready);
        var irl = $this.data("idl").rl;
        var ir = {
            errorText: cfg.errorText,
            fn: fn
        };
        irl.push(ir);
        return ir;
    };
    $.AsyncBaseValidator = function($this, cfg, fn)
    {

        $this.data("v_state", v_status.Ready);
        var airl = $this.data("idl").ar.rl;
        var air = {
            errorText: cfg.errorText,
            doingText: cfg.doingText,
            //succFn: cfg.succFn,
            fn: fn
        };

        airl.push(air);

        return air;
    }
    $.fn.validate = function()
    {




        return this.each(function()
        {

            var $this = $(this);
            var idl = $this.data("idl");

            var tip = $("#" + this.id + "Tip");
            var tippar = $("#" + this.id + "Tip").parent();
            asyncV = function(airl, index, succFn)
            {

                if (airl.length > 0 && airl.length > index)
                {
                    var air = airl[index];
                    $this.data("v_state", v_status.Doing);
                    air.fn(function()
                    {

                        asyncV(airl, ++index, succFn);
                    }, function(msg)
                    {
                        tip
                        .html("");
                        tip.addClass("tipErr")
                        .removeClass("tipSucc")
                        .removeClass("tipWait")
                        .removeClass("tipText");

                        $this.addClass("g-ipt-err");
                        $this.data("v_state", v_status.Error);
                    });
                } else
                {
                    succFn();
                    $this.data("v_state", v_status.Success);
                }
            };





            var isV = true;
            $.each(idl.rl, function(index, item)
            {
                if (!item.fn())
                {
                    tip
                        .html("");
                    tip.addClass("tipErr")
                        .removeClass("tipSucc")
                        .removeClass("tipWait")
                        .removeClass("tipText");

                    $this.addClass("g-ipt-err");
                    $this.data("v_state", v_status.Error);
                    isV = false;
                    return false;
                }
            })
            if (isV)//pass?
            {

                asyncV(idl.ar.rl, 0, function()
                {
                    tip
                    .html("");
                    tip.addClass("tipSucc")
                    .removeClass("tipErr")
                    .removeClass("tipWait")
                    .removeClass("tipText");
                    $(this).removeClass("g-ipt-err");
                });
            }
        });
    };


    //区域验证控件
    $.fn.rangeValidator = function(cfg)
    {
        var min = cfg.min;
        var max = cfg.max;

        return this.each(function()
        {
            var $this = $(this);
            $.BaseValidator($this, cfg, function()
            {
                var inpVal = parseInt($this.val());
                if (inpVal >= min && inpVal <= max)
                    return true;
                else
                    return false;
            });

        });
    }
    //必填验证控件
    $.fn.requireValidator = function(cfg)
    {
        return this.each(function()
        {
            var $this = $(this);
            $.BaseValidator($this, cfg, function()
            {
                var inpVal = $this.val();
                return inpVal != null && inpVal != "";

            });
        })
    }
    //输入长度验证控件
    $.fn.lenValidator = function(cfg)
    {
        var min = cfg.min;
        var max = cfg.max;
        return this.each(function()
        {
            var $this = $(this);
            $.BaseValidator($this, cfg, function()
            {
                var inpVal = $this.val();
                if (inpVal.length >= min && inpVal.length <= max)
                {
                    return true;
                } else
                {
                    return false;
                }

            });
        })
    }
    $.fn.compareValidator = function(cfg)
    {
        return this.each(function()
        {
            var $this = $(this);
            $.BaseValidator($this, cfg, function()
            {
                return $("#" + cfg.compareTo).val() == $this.val();
            });
        })
    }
    $.fn.regexValidator = function(cfg)
    {
        return this.each(function()
        {
            var $this = $(this);
            $.BaseValidator($this, cfg, function()
            {
                var regex = new RegExp(cfg.regex);

                return regex.test($this.val());
            });
        });
    }
    $.fn.customValidator = function(cfg)
    {
        return this.each(function()
        {
            var $this = $(this);
            $.BaseValidator($this, cfg, function()
            {
                return cfg.fun($this.val());
            });
        });
    }
    $.fn.certificateValidator = function(cfg)
    {
        return this.each(function()
        {
            var $this = $(this);
            $.BaseValidator($this, cfg, function()
            {
                var flag = false;
                if ($this.val() != "") flag = true;
                $.each(cfg.inputIDs, function()
                {
                    if ($("#" + this.id).val() != "") flag = true;
                });
                return flag;
            });
        });
    }
    $.fn.ajaxValidator = function(cfg)
    {

        return this.each(function()
        {
            var $this = $(this);
            var air = $.AsyncBaseValidator($this, cfg, function(succ, err)
            {
                var url = cfg.url.replace("{0}", $this.val());
                $.ajax({
                    url: url,
                    cache: false,
                    success: function(r)
                    {
                        if (cfg.succFn(r))
                        {
                            succ();
                        } else
                        {
                            err(cfg.errorText);
                        }
                    },
                    error: function(r)
                    {
                        err(r.ResponseText);
                    }
                });
            });
        });
    }
    $.fn.directValidator = function(cfg)
    {
        return this.each(function()
        {
            var $this = $(this);
            var air = $.AsyncBaseValidator($this, cfg, function(succ, err)
            {
                var succFn = function(r)
                {
                    if (r)
                        succ();
                    else
                        err(cfg.errorText);
                }
                var errFn = function(r)
                {
                    err(r);
                }
                var fn = cfg.fn + "('" + $this.val() + "',succFn,errFn)";
                eval(fn);
            });
        });
    }
})(jQuery)