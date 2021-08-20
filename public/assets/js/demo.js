$(document).ready(function() {
    $('#clothing-sort').sortable({
			update: function(event, ui) {
				var speciesInput = $("#species").val();
        		var skinInput = $("#skin").val();
        		var eyesInput = $("#eyes").val();
        		var backgroundInput = $("#background").val();
        
        		if(speciesInput && skinInput && eyesInput)
        		{
        			var itemInputs = [];
        
        			$('.wearInput').each(function(){
        	            itemInputs.push($(this).val());
        	        });
                    
        			$.post( "/demo-generate", { "_token": $('meta[name=_token]').attr('content'), species: speciesInput, skin: skinInput, eyes: eyesInput, clothes: itemInputs, background: backgroundInput } ).done(function(data) {
        				$("#demo-img").html('<img src="'+data['image']+'" width="500px" height="500px" />');
        			});
        		}
			}
		});
    $('#clothing-sort').disableSelection();
	$("#species").change(function(){
		var speciesInput = $("#species").val();
		var skinInput = $("#skin").val();
		var eyesInput = $("#eyes").val();
        
		$.post( "/demo-clothes", { "_token": $('meta[name=_token]').attr('content'), species: speciesInput } ).done(function(data) {

			$("#head").html('<option>Head</option>');
			$("#accessory").html('<option>Accessory</option>');
			$("#top").html('<option>Top</option>');
			$("#bottom").html('<option>Bottom</option>');
			$("#horns").html('');


			$.each( data['head'], function( key, value ) {
				$("#head").append('<option value="'+key+'">'+value+'</option>');
			});

			$.each( data['accessory'], function( key, value ) {
				$("#accessory").append('<option value="'+key+'">'+value+'</option>');
			});

			$.each( data['top'], function( key, value ) {
				$("#top").append('<option value="'+key+'">'+value+'</option>');
			});

			$.each( data['bottom'], function( key, value ) {
				$("#bottom").append('<option value="'+key+'">'+value+'</option>');
			});
			
			if(data['horns'])
			{
			    $("#horns").html('');
			    $.each( data['horns'], function( key, value ) {
    				$("#horns").append('<option value="'+key+'">'+value+'</option>');
    			});
			
			    $("#hornSection").css("display", "");
			}
			else
			{
			    $("#horns").html('<option value=""></opton>');
			    $("#hornSection").css("display", "none");
			}
			
			$(".demo-equipped").html('');
		});
		
		
		
		var itemInputs = [];
		
		$.post( "/demo-generate", { "_token": $('meta[name=_token]').attr('content'), species: speciesInput, skin: skinInput, eyes: eyesInput, clothes: itemInputs } ).done(function(data) {
				$("#demo-img").html('<img src="'+data['image']+'" width="500px" height="500px" />');
		});
	});

	$("#skin, #eyes, #horns, #background").change(function(){
		var speciesInput = $("#species").val();
		var skinInput = $("#skin").val();
		var eyesInput = $("#eyes").val();
		var hornsInput = $("#horns").val();
		var backgroundInput = $("#background").val();

		if(speciesInput && skinInput && eyesInput)
		{
			var itemInputs = [];

			$('.wearInput').each(function(){
	            itemInputs.push($(this).val());
	        });

			$.post( "/demo-generate", { "_token": $('meta[name=_token]').attr('content'), species: speciesInput, skin: skinInput, eyes: eyesInput, horns: hornsInput, clothes: itemInputs, background: backgroundInput } ).done(function(data) {
				$("#demo-img").html('<img src="'+data['image']+'" width="500px" height="500px" />');
			});
		}
		else
		{
			$("#demo-img").html('<span style="color: #ff0000;">All base data is required!</span>');
		}
	});

	$(document).on('change', '#head, #accessory, #top, #bottom', function() {
		var i = $('#pos-counter').val();
    	i++;

		if($(this).val())
		{
			$(".demo-equipped").prepend('<div id="'+$(this).val()+'" class="col-md-2 align-center ui-state-default" style="margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 120px;"><input class="wearInput" id="wear-'+$(this).val()+'" type="hidden" name="wear['+i+']" value="'+$(this).val()+'" /><img class="order-img" src="/assets/images/clothing/'+$(this).attr('id')+'/'+$(this).val()+'" /><br /> <span class="remove" data-id="'+$(this).val()+'" data-type="'+$(this).attr('id')+'" data-name="'+$("#"+$(this).attr('id')+" option:selected").text()+'">Remove</span></div>');
			$("#"+$(this).attr('id')+" option[value='"+$(this).val()+"']").remove();
		}
		
		var speciesInput = $("#species").val();
		var skinInput = $("#skin").val();
		var eyesInput = $("#eyes").val();
		var hornsInput = $("#horns").val();
		var backgroundInput = $("#background").val();

		if(speciesInput && skinInput && eyesInput)
		{
			var itemInputs = [];

			$('.wearInput').each(function(){
	            itemInputs.push($(this).val());
	        });
            
			$.post( "/demo-generate", { "_token": $('meta[name=_token]').attr('content'), species: speciesInput, skin: skinInput, eyes: eyesInput, horns: hornsInput, clothes: itemInputs, background: backgroundInput } ).done(function(data) {
				$("#demo-img").html('<img src="'+data['image']+'" width="500px" height="500px" />');
			});
		}
	});

	$('#save-img').click(function(){
     	var link = document.createElement('a');
        link.href = $("#demo-img img").attr('src');  // use realtive url 
        link.download = 'demo.png';
        document.body.appendChild(link);
        link.click();     
    });

	$(document).on('click', '.remove', function() {
		var itemVal = $(this).data('id');
		var itemType = $(this).data('type');
        var itemName = $(this).data('name');
        
		$("#"+itemType).append('<option value="'+itemVal+'">'+itemName+'</option>');
		$(this).parent().remove();
		
		var speciesInput = $("#species").val();
		var skinInput = $("#skin").val();
		var eyesInput = $("#eyes").val();
		var hornsInput = $("#horns").val();
		var backgroundInput = $("#background").val();

		if(speciesInput && skinInput && eyesInput)
		{
			var itemInputs = [];

			$('.wearInput').each(function(){
	            itemInputs.push($(this).val());
	        });

			$.post( "/demo-generate", { "_token": $('meta[name=_token]').attr('content'), species: speciesInput, skin: skinInput, eyes: eyesInput, horns: hornsInput, clothes: itemInputs, background: backgroundInput } ).done(function(data) {
				$("#demo-img").html('<img src="'+data['image']+'" width="500px" height="500px" />');
			});
		}
		else
		{
			$("#demo-img").html('<span style="color: #ff0000;">All base data is required!</span>');
		}
	});
	
	$(document).on('click', '.species-create', function() {

        var species = $(this).html().toLowerCase();
        var desc = $(this).data('blood');
        
        $("#blood-desc").html(desc);
        
		$("#create-img").attr('src', '/assets/images/bloodlines/create/'+species+'_create.png');
		
		$("#next-link").attr('href', '/create/customize/'+species);
	});
});