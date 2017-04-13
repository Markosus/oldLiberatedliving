$(document).ready(function(){
	$('#category').change(function(){
		var catvalue=$(this).val();

		if(catvalue==0){
			$('#subcategoryshow').hide();
			$('#healthform').hide();
			$('#mainingredientshow').hide();
			$('#notes').hide();
			document.getElementById('subcategory').value=0;
			document.getElementById('healthform').value=0;
			document.getElementById('mainingredient').value=0;
			document.getElementById('notes').value=0;
		} else {
			$('#subcategoryshow').show();


		}

	});



$('#mainingredient').change(function(){
		var mainingredient=$(this).val();
		//var catvalue=document.getElementById('category').value 
		if(mainingredient==0){
			$('#healthform').hide();
			$('#notes').hide();
			document.getElementById('healthform').value=0;
			document.getElementById('notes').value=0;
		} else {
			$('#healthform').show();
			$('#notes').show();

		}

	});


$('#subcategory').change(function(){
		var subcatvalue=$(this).val();
		//var catvalue=document.getElementById('category').value 
		if(subcatvalue==0){
			$('#healthform').hide();
			$('#mainingredientshow').hide();
			$('#notes').hide();
			document.getElementById('healthform').value=0;
			document.getElementById('mainingredient').value=0;
			document.getElementById('notes').value=0;
		} else {
			$('#mainingredientshow').show();

		}

	});






});