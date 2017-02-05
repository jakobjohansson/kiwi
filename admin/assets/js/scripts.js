$(document).ready(function() {
    $(".content").load("lib/overview.php");

    $(".loader li").click(function() {
        $(".content").load("lib/" + $(this).data("page") + ".php");
        $(".loader li").removeClass("active");
        $(this).addClass("active");
    });

    $(document).on("click", ".editor", function(e) {
        e.preventDefault();
        $(".content").load("lib/edit.php?id=" + $(this).data("id"));
    });

    $(document).on("click", ".clicker", function() {
        $(this).parent().children(".reveal").slideToggle();
        $(this).children("h4").children("i").toggleClass("fa-arrow-down fa-arrow-right");
    });

    $(document).on("submit", "form", function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            data: form.serialize(),
            success: function(data) {
                $("#response").html(data).css("opacity", "1");
            }
        });
    });

    $(document).on("click", ".post-deleter", function(e) {
        var node = this;
        e.preventDefault();
        $.get($(this).attr("href"), null, function(success) {
            $(node).siblings(".delete-response").html(success).css("opacity", 1);
        });
    });
    
});
