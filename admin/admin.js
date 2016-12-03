$(document).ready(function() {

	$("#login").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		$.ajax({
			url: form.attr("action"),
			type: form.attr("method"),
			data: form.serialize(),
			success: function(data) {
				$("#response").html(data).show();
				if(data == "Success!") {
					location.reload();
				}
			}
		});
	});
});