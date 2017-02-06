$(document).ready(function() {
    $(".content").load("lib/overview.php");

    $(".login form").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            data: form.serialize(),
            success: function(data) {
                $("#response").html(data).css("opacity", "1");
                if(data == "Success!") {
                    location.reload();
                }
            }
        });
    });

    $(".loader li").click(function() {
        if ($(this).data("page") === "site") {
            location.href = "../";
        } else if ($(this).data("page") === "logout") {
            location.href = "?page=logout";
        } else {
            $(".content").load("lib/" + $(this).data("page") + ".php");
            $(".loader li").removeClass("active");
            $(this).addClass("active");
        }
    });

    $(document).on("click touchstart", ".responsive-menu-button i", function() {
        $(".sidebar").slideDown(250);
        $(this).parent().hide();
        $(".responsive-menu-button-close").show();
    });

    $(document).on("click touchstart", ".responsive-menu-button-close i", function() {
        $(".sidebar").slideUp(250);
        $(this).parent().hide();
        $(".responsive-menu-button").show("slow");
    });

    $(document).on("click touchstart", ".clicker", function() {
        $(this).parent().children(".reveal").slideToggle();
        $(this).children("h4").children("i").toggleClass("fa-arrow-down fa-arrow-right");
    });

    $(document).on("click touchstart", ".editor", function(e) {
        e.preventDefault();
        $(".content").load("lib/edit.php?id=" + $(this).data("id"));
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

    $(document).on("click touchstart", ".post-deleter", function(e) {
        var node = this;
        e.preventDefault();
        $.get($(this).attr("href"), null, function(success) {
            $(node).parent(".links").parent("article").slideUp();
        });
    });
    
});
