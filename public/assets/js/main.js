$(document).ready(function() {    
    $("#character-select").change(function(){
		var uCharacter = $("#character-select").val();

		$.post( "/char-change", { "_token": $('meta[name=_token]').attr('content'), character: uCharacter } ).done(function(data) {
				location.reload(true);
		});
	});

});