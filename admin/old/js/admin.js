$(document).ready(function() {

	$("#login").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		$.ajax({
			url: form.attr("action"),
			type: form.attr("method"),
			data: form.serialize(),
			success: function(data) {
				$("#response").html(data).css("opacity", "1");
				if(data == "Success!") {
					$("#response").html(data).css("opacity", "1");
					location.reload();
				}
			}
		});
	});

	$("nav > ul > li").hover(function() {
		$(this).siblings("li").children("ul").hide();
		$(this).children("ul").toggle();
	});

	$("#change").submit(function(e) {
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

});
