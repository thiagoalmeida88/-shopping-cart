$(document).ready(function() {

    var cssOn = {
        "border-bottom-left-radius": "0",
        "border-bottom-right-radius": "0",
        "border-color": "rgba(223,225,229,0)",
        "box-shadow": "0 1px 6px 0 rgba(32,33,36,0.28)"
    };

    var cssOff = {
        "border-bottom-left-radius": "",
        "border-bottom-right-radius": "",
        "border-color": "",
        "box-shadow": ""
    };

    $('.search').focus(function() {
        var id = '#' + $(this).attr("id");

        if($(id).val() != ""){
            $(id).css(cssOn);
        }else{
            $(id).css(cssOff);
        }

        if(id != '#optTermo') {

            $(id).blur(function () {
                $(id).css(cssOff);
            });

            $(id).keydown(function (e) {
                if ($.trim($(id).val()).length === 1 || $(id).val() == "") {
                    $(id).css(cssOff);
                }else{
                    if(e.keyCode == 8){
                        $(id).css(cssOn);
                    }
                }
            });

            $(id).keypress(function () {

                if ($.trim($(id).val()).length >= 0 || $(id).val() != "") {
                    $(id).css(cssOn);
                }
            });
        }
    });
});

