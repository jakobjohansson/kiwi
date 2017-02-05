$(document).ready(function() {
    $(".content").load("lib/overview.html");

    $(".loader li").click(function() {
        $(".content").load("lib/" + $(this).data("page") + ".html");
        $(".loader li").removeClass("active");
        $(this).addClass("active");
    });

    $(document).on("click", ".clicker", function() {
        $(this).parent().children(".reveal").slideToggle();
    });
    
});
