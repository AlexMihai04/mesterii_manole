$( document ).ready(function() {
    $("#main").hide();
    $("#main").fadeIn(400);
    $("#search_meserias").click(function(){
        $("#main").fadeOut(400);
        setTimeout(() => {
            window.location.href = get_domeniu() + "/search.php";
        }, 360);
    });
});