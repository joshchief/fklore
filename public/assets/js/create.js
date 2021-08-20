$(document).ready(function() {    
    $("#skin, #eyes, #horns, #horn_color").change(function(){
		var speciesInput = $("#species").val();
		var skinInput = $("#skin").val();
		var eyesInput = $("#eyes").val();
		var hornsInput = $("#horns").val();
		var hornColorInput = $("#horn_color").val();

		if(speciesInput && skinInput && eyesInput)
		{
			$.post( "/create-generate", { "_token": $('meta[name=_token]').attr('content'), species: speciesInput, skin: skinInput, eyes: eyesInput, horns: hornsInput, horn_color: hornColorInput } ).done(function(data) {
				$("#create-img").attr('src', data['image']);
			});
		}
		else
		{
			$("#demo-img").html('<span style="color: #63e2f5;">All base data is required!</span>');
		}
	});
	
	$("#fire").click(function(){
		$("#element-stats").html('Fire is a favorite among hard-hitting physical fighters, or close range magic users. This versatile element will leave your foes with lasting burns and provide resistance to ice and specter attacks.');
		$("#elementval").attr('value', '1');
	});
	
	$("#ice").click(function(){
		$("#element-stats").html('Ice will freeze your opponents in their tracks! It is best used with strong, magic attacks at close range and do high damage to water, earth, and specter opponents.');
		$("#elementval").attr('value', '2');
	});
	
	$("#water").click(function(){
		$("#element-stats").html('While water attacks may not be as hard hitting for physical fighters, its capability with magic is endless! Perfect for both close and ranged magic attacks, especially against fire or earth opponents.');
		$("#elementval").attr('value', '3');
	});
	
	$("#earth").click(function(){
		$("#element-stats").html('Earth is a favorite among magic based races for its healing capabilities. But it can also be incredibly powerful for close-ranger physical attacks. Wind and light opponents are especially weak against earth attacks.');
		$("#elementval").attr('value', '4');
	});
	
	$("#light").click(function(){
		$("#element-stats").html('Light is a powerful magical element that can be used for both close and ranged attacks. Although it has weaknesses, when used properly a a Light-based fighter can be among some of the most powerful opponents, especially up aginst specter or ice foes.');
		$("#elementval").attr('value', '5');
	});
	
	$("#specter").click(function(){
		$("#element-stats").html('Specter based fighters harness moonlight into powerful attacks for themselves and their teammates. Its favored among Lycans, and does massive damage to earth and other specter based foes.');
		$("#elementval").attr('value', '6');
	});
	
	$("#wind").click(function(){
		$("#element-stats").html('Wind based fighters rely on speed and range to pull off their more powerful attacks. Attacks from Wind elements can be made in rapid succession and greatly damage fire and water based opponents.');
		$("#elementval").attr('value', '7');
	});
});