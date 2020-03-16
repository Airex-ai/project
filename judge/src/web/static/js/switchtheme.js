(function () {
    // add wcc
    function setCookie(name, value) {
        var exp = new Date();
        exp.setTime(exp.getTime() +  24 * 60 * 60 * 1000);
        document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
    }

    $(document).ready(function(){
        $("#girlpink").click(function () {
            setCookie("colortheme", "girlpink");
            window.location.reload();
        });
        $("#default").click(function () {
            setCookie("colortheme", "default");
            window.location.reload();
        });
        
        $(".lan_select").change(function () {
            if ($(".lan_select").val() === "English") {
                setCookie("language", 'English');
                window.location.reload();
            } else {
                setCookie("language", 'Chinese');
            }
            window.location.reload();
        });
    });
})();