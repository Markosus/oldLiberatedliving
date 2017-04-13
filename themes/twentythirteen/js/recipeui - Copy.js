$(document).ready(function(){

	$('.images').draggable({ 

		containment:'body',
		 tolerance: "pointer",
		// helper:'clone',
		revert:true,
		start:function(){
			contents=$(this).find('.name').text();
			recipeid=$(this).find('.id').text();
			// contents=$('.name').text();


		}

	}); 



$('#tuesdaymealplancontainter').droppable({			
		hoverClass:'border',
		accept:'.images',
		drop:function(event,ui){

				var $this = $(this);
			// Check number of elements already in
		        if($this.find('.item').length >3){
		            // Cancel drag operation (make it always revert)
		            ui.draggable.draggable('option','revert',true);
		            return;
		        }
			// $('#breadfastmealplan').append('<div class="test" id="items">'+contents+'<br></div>');
			// $('#breadfastmealplan').append('<li class="default">'+contents+'</li>');
			$('#tuesdaysortable').append('<div class="item" id=tuesday_'+recipeid+'>'+contents+'</div>');
			// var droppedItem = $(ui.draggable).clone();
			// $(this).append(droppedItem);

				
		 }

	});	





	$('#mondaymealplancontainter').droppable({			
		hoverClass:'border',
		accept:'.images',
		drop:function(event,ui){

				var $this = $(this);
			// Check number of elements already in
		        if($this.find('.item').length >3){
		            // Cancel drag operation (make it always revert)
		            ui.draggable.draggable('option','revert',true);
		            return;
		        }
		
			// if($("#mondaymealplancontainter").find('.item').length == 3){
				$('#mondaysortable').append('<div class="item" id=monday_'+recipeid+'>'+contents+'</div>');
			// }else{
			// 	$('#mondaysortable').append('<div class="item" id=monday_'+recipeid+'>'+contents+'</div>');	
			// }
			
			
				  				

		 }

	});	

$('#wednesdaymealplancontainter').droppable({			
		hoverClass:'border',
		accept:'.images',
		drop:function(event,ui){

				var $this = $(this);
			// Check number of elements already in
		        if($this.find('.item').length >3){
		            // Cancel drag operation (make it always revert)
		            ui.draggable.draggable('option','revert',true);
		            return;
		        }
			// $('#breadfastmealplan').append('<div class="test" id="items">'+contents+'<br></div>');
			// $('#breadfastmealplan').append('<li class="default">'+contents+'</li>');
			$('#wednesdaysortable').append('<div class="item" id=wednesday_'+recipeid+'>'+contents+'</div>');
			// var droppedItem = $(ui.draggable).clone();
			// $(this).append(droppedItem);

				
		 }

	});		

	$('#thursdaymealplancontainter').droppable({			
		hoverClass:'border',
		accept:'.images',
		drop:function(event,ui){

				var $this = $(this);
			// Check number of elements already in
		        if($this.find('.item').length >3){
		            // Cancel drag operation (make it always revert)
		            ui.draggable.draggable('option','revert',true);
		            return;
		        }
		
				$('#thursdaysortable').append('<div class="item" id=thursday_'+recipeid+'>'+contents+'</div>');
		
	  				

		 }

	});	

		$('#fridaymealplancontainter').droppable({			
		hoverClass:'border',
		accept:'.images',
		drop:function(event,ui){

				var $this = $(this);
			// Check number of elements already in
		        if($this.find('.item').length >3){
		            // Cancel drag operation (make it always revert)
		            ui.draggable.draggable('option','revert',true);
		            return;
		        }
		
				$('#fridaysortable').append('<div class="item" id=friday_'+recipeid+'>'+contents+'</div>');
		
	  				

		 }

	});	

		$('#saturdaymealplancontainter').droppable({			
		hoverClass:'border',
		accept:'.images',
		drop:function(event,ui){

				var $this = $(this);
			// Check number of elements already in
		        if($this.find('.item').length >3){
		            // Cancel drag operation (make it always revert)
		            ui.draggable.draggable('option','revert',true);
		            return;
		        }
		
				$('#saturdaysortable').append('<div class="item" id=saturday_'+recipeid+'>'+contents+'</div>');
		
	  				

		 }

	});	

	$('#sundaymealplancontainter').droppable({			
		hoverClass:'border',
		accept:'.images',
		drop:function(event,ui){

				var $this = $(this);
			// Check number of elements already in
		        if($this.find('.item').length >3){
		            // Cancel drag operation (make it always revert)
		            ui.draggable.draggable('option','revert',true);
		            return;
		        }
		
				$('#sundaysortable').append('<div class="item" id=sunday_'+recipeid+'>'+contents+'</div>');
		
	  				

		 }

	});		

 

  $('form.ajax').on('submit', function() {


  	return false;

  });

// $.post('/wp-content/themes/twentythirteen/save.php',{list:postData},function(o){
// 					console.log(o);	
// 		  		},'json');

var removeIntent = false;
         $('#mondaysortable,#tuesdaysortable,#wednesdaysortable,#thursdaysortable,#fridaysortable,#saturdaysortable,#sundaysortable').sortable({
	      
		  appendTo: 'body',
	      tolerance: 'pointer',
		  helper: 'clone',

		  
		  	update: function() {  		
	 		

		  	},
		  	over: function () {
                removeIntent = false;
            },
            out: function () {
                removeIntent = true;
            },
            beforeStop: function (event, ui) {
                if(removeIntent == true){
                    ui.item.remove();   
                }
            }

		});






         $("#saveitems").on('click',function()
					           {


					           	  if($("#mealplansidebar").find('.item').length + $("#mealplansidebarright").find('.item').length >= 28){
							          
							        

					           	var postDataMon = $('#mondaysortable').sortable('serialize');
		  						var postDataTues = $('#tuesdaysortable').sortable('serialize');
		  						var postDataWed = $('#wednesdaysortable').sortable('serialize');		
								var postDataThurs = $('#thursdaysortable').sortable('serialize');
								var postDataFri = $('#fridaysortable').sortable('serialize');
								var postDataSat = $('#saturdaysortable').sortable('serialize');	
								var postDataSun = $('#sundaysortable').sortable('serialize');	
											  		console.log(postDataMon,postDataTues,postDataWed,postDataThurs,postDataFri,postDataSat,postDataSun);	
											  		
											  		$.post( "/mealplansave", { mon: postDataMon,tues:postDataTues,wed:postDataWed,thurs: postDataThurs,fri:postDataFri,sat:postDataSat,sund:postDataSun }, function( o ) {

														  // console.log( o ); 

														}, "json");
									} //end if 		  		

					           }
					      );






});