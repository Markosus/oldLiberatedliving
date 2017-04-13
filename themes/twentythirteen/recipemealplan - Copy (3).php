<?php
/*
Template Name: recipemealplan
*/

get_header(); 
?>

<script src="/wp-content/themes/twentythirteen/js/jquery.min.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery-ui.js"></script>
<script src="/wp-content/themes/twentythirteen/js/showHide.js"></script>
<link rel="stylesheet" href="/wp-content/themes/twentythirteen/css/recipe.css" type="text/css" />



  <script type="text/javascript">

	$(document).ready(function() {


	    $('form.ajax').on('submit',function(event){
	    	

	    	var that=$(this),
	    	url=that.attr('action'),
	    	type=that.attr('method'),
	    	data={};

	    	var datastring = $("#lets_search").serialize();

	    	$.ajax({
	    		url: url,
	    		type: type,
	    		data: datastring,
	    		success: function(response){
	    			console.log(response);
	    			// document.getElementById('results').innerHTML += response; 
	    			 
	    			 $("#ajaxresults").html(response);
                     


	    		}
	    	});



	        return false;

	    });

});
 </script>



 <script type="text/javascript">

	$(document).ready(function() {

			 $("#saveitems").on('click',function()
					           {


					           	  if($("#mealplansidebar").find('.item').length + $("#mealplansidebarright").find('.item').length >= 28){
							  		
							        var name = $.trim($('.mealplanname').val());
							        var clientname = $.trim($('.clientname').val());
											    // Check if empty of not
											    if ( (name  === '') || (clientname  === '') ) {
											        alert('Text-field is empty.');
											        return false;
											    }

					           	var postDataMon = $('#mondaysortable').sortable('serialize');
		  						var postDataTues = $('#tuesdaysortable').sortable('serialize');
		  						var postDataWed = $('#wednesdaysortable').sortable('serialize');		
								var postDataThurs = $('#thursdaysortable').sortable('serialize');
								var postDataFri = $('#fridaysortable').sortable('serialize');
								var postDataSat = $('#saturdaysortable').sortable('serialize');	
								var postDataSun = $('#sundaysortable').sortable('serialize');	
								var formdata = $("#savemealpan").serialize();
											  		console.log(postDataMon,postDataTues,postDataWed,postDataThurs,postDataFri,postDataSat,postDataSun,formdata);	
											  		
											  		$.post( "/mealplansave", { mon: postDataMon,tues:postDataTues,wed:postDataWed,thurs: postDataThurs,fri:postDataFri,sat:postDataSat,sund:postDataSun,form:formdata }, function( o ) {

														  // console.log( o ); 
														  $('#savemealpan').trigger('submit');
														});
									
									

									} //end if 	

										  		

					           }
					      );

		

	});
 </script>


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<div class="container">
				<div class="mealplan">

			
	<?php
		if ( post_password_required( $post ) ) {
		echo get_the_password_form();    
		} else {
		?>		


<h2 style="margin-bottom:-15px;">Create Meal Plan</h2><br>	
<a href="/recipeadmin">Go to the Recipe Admin Panel</a><br>

<p>This is the create meal plan page.  To create a meal plan first search for 
the desired recipe in the search box below on the left. Once the results are
shown,simply drag a recipe over to the corresponding day in the right panel.
Also note it is posible to change the meal order by dragging up or down. You must
also enter in a client name and meal plan name for it to save. </p>			

<br><hr>		
	<div class="row" >	
		
		<div class="col-lg-3">	
<form id="savemealpan" action="/recipeadmin" method="POST"> 
					<label>Enter client name: </label><input type="text" class="clientname" name="clientname" placeholder="Client name" maxlength="150">	
		
		</div> <!-- end col		 -->	 
		<div class="col-lg-3">			
					<label>Enter meal plan name: </label><input type="text" class="mealplanname" name="mealplanname" placeholder="Meal plan name" maxlength="150">		 		
		</div> <!-- end col		 -->	 
	</div> <!-- end row -->
</form>

			 
<input type="submit" id="saveitems" name="saveitems" value="Save">		 
<br><hr>		
<div class="row" >		
 


		  <form id="lets_search" action="/ajaxtest" method="POST" class="ajax"> 
				<!-- <form action="/test/" method="POST"> --> 

					<div class="col-lg-3">			
					 <input type="text" class="recipesearch" id="autocomplete" name="search" placeholder="search" maxlength="150" style="line-height: 40px;" >
					 <input type="submit" value="Find" name="send" id="send">

					</div> <!-- end col	 -->


				

							<div class="col-lg-2">
							<?php 
											$query = "SELECT * FROM recipe_coursecategory";
											$result = mysql_query($query);
											
											?>
											
											<div id="maincategorysearch">			
											<br>	
											<select id='category' name="maincategory">

												<option value="">Main Category</option>
										<?php
												while($row = mysql_fetch_array($result)){
													echo '<option value="AND recipe_category LIKE \''.$row['coursename'].'\'">'.$row['coursename'].'</option>';
												}
										?>
											</select>
											</div>	<!-- end maincategorysearch -->	
							</div> <!-- end col	 -->				

									<div class="col-lg-2">		

											<?php
											$query = "SELECT *  FROM recipe_mainingredient";
											$result = mysql_query($query);
											?>
												<br>
												<div id="mainingredientsearch" >
												<select id="mainingredient" name="mainingredient">
												<option value="">Main Ingredient</option>
											<?php
													while($row = mysql_fetch_array($result)){
														echo '<option value="AND recipe_main_ingredient LIKE \''.$row['mainingredientname'].'\'">'.$row['mainingredientname'].'</option>';
															
													}
											?>
											</select>
											</div>

									</div> <!-- end col	 -->

							<div class="col-lg-2" >

							
											<?php
											$query = "SELECT *  FROM recipe_dishtypesubcategory";
											$result = mysql_query($query);
											?>
											<div id="subcategorysearch">
											<br>	
											<select id="subcategory" name="subcategory">
											<option value="">Dish Subcategory</option>
										<?php
												while($row = mysql_fetch_array($result)){
													echo '<option value="AND recipe_subcategory LIKE \''.$row['subcategoryname'].'\'">'.$row['subcategoryname'].'</option>';
												}
										?>
											</select>
											</div><br>

											

							</div> <!-- end col	 -->


					




											
											




										<br>

											<!-- this is the main healthform loop -->

										
									<div class="col-lg-2">	

											<button type="button" id="searchhealthbutton"  data-toggle='modal' data-target='#modal1'>Health Concerns</button>
										    


										   

													<div id="modal1" class="modal fade" tabindex="-1" role="dialog">
											        <div class="modal-dialog modal-md">
											            <div class="modal-content">
											                <div class="modal-header">
											                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											                    <h4 class="modal-title"><legend>Select your health concerns:</legend></h4>
											                </div>
											                <div class="modal-body" width="500px">

											                	 <?php
																	$query = "SELECT *  FROM recipe_healthattribute";
																	$result = mysql_query($query);
																	
																	?>
																										
																	<table class="mealplanhealthtable">
														 			<tr>
																<?php
																		$i=0;
																		while($row = mysql_fetch_array($result)){

																					
																				echo '<td colspan="4"><input id="'.$row['healthattributename'].'" type="checkbox" name="healthconcerns[]" value="'.$row['health_id'].'">';
																				echo '<label for="'.$row['healthattributename'].'">'.$row['healthattributename'].'</label></td>';
																				$i++; 
																				if($i % 4 == 0){ echo "<tr>";}
																		}
																?></tr>
															</table><br><br>
											                </div>
											                <div class="modal-footer">
											                    
											                </div>
											            </div>
											        </div>
											    </div>
											</div><!--  end modal -->
										    	




								</div> <!-- end col	 -->		    
							</div>	<!-- end row	 -->			    



				</form>


				 

  			
			<div id='mealplansidebar'> 

					     <h4>Mondays Meals</h4>
						 <div id="mondaymealplancontainter">
						 	<div id="labelcontainer">
								<div id="label">Breakfast</div>
								<div id="label">Lunch</div>
								<div id="label">Dinner</div>
								<div id="labellast">Snack</div>
							</div>	
							<div id="mondaysortable">
								

							</div>		

						 </div>

						 <h4>Tuesdays Meals</h4>
						 <div id="tuesdaymealplancontainter">
						 	<div id="labelcontainer">
								<div id="label">Breakfast</div>
								<div id="label">Lunch</div>
								<div id="label">Dinner</div>
								<div id="labellast">Snack</div>
							</div>	
							<div id="tuesdaysortable">
							

							</div>		

						 </div>

						 <h4>Wednesday Meals</h4>
						 <div id="wednesdaymealplancontainter">
						 	<div id="labelcontainer">
								<div id="label">Breakfast</div>
								<div id="label">Lunch</div>
								<div id="label">Dinner</div>
								<div id="labellast">Snack</div>
							</div>	
							<div id="wednesdaysortable">
							

							</div>		

						 </div>

						 <h4>Thursdays Meals</h4>
						 <div id="thursdaymealplancontainter">
						 	<div id="labelcontainer">
								<div id="label">Breakfast</div>
								<div id="label">Lunch</div>
								<div id="label">Dinner</div>
								<div id="labellast">Snack</div>
							</div>	
							<div id="thursdaysortable">
							

							</div>		

						 </div>



		</div>	 <!-- mealplansidebar div -->			 


			<div id='mealplansidebarright'> 
			

						 <h4>Fridays Meals</h4>
						 <div id="fridaymealplancontainter">
						 	
							<div id="fridaysortable">
							

							</div>		

						 </div>

						 <h4>Saturday Meals</h4>
						 <div id="saturdaymealplancontainter">
						 	
							<div id="saturdaysortable">
							

							</div>		

						 </div>

						 <h4>Sunday Meals</h4>
						 <div id="sundaymealplancontainter">
						 	
							<div id="sundaysortable">
							

							</div>		

						 </div>


			</div><!-- mealplansidebar div -->		





<div class="searchresultscontainer">
					<div id="ajaxresults">
					</div>
</div>

		 </div>	



		<br>


		
		

		

		

	

		


		





      		







			
			
<?php


} //this is the closing bracket for the password protect if
?>


			</div>	<!-- #mealplan -->
		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->


<script type="text/javascript">


	// if (($('select').attr('id'))=='category'){

	// Iterate over each select element
$('select').each(function () {

 if (($(this).attr('id')) != 'health') { //i add this if to exclude the health attribute
 
 

    // Cache the number of options
    var $this = $(this),
        numberOfOptions = $(this).children('option').length;

    // Hides the select element
    $this.addClass('s-hidden');

    // Wrap the select element in a div
    $this.wrap('<div class="select"></div>');

    // Insert a styled div to sit over the top of the hidden select element
    $this.after('<div class="styledSelect"></div>');

    // Cache the styled div
    var $styledSelect = $this.next('div.styledSelect');

    // Show the first select option in the styled div
    $styledSelect.text($this.children('option').eq(0).text());

    // Insert an unordered list after the styled div and also cache the list
    var $list = $('<ul />', {
        'class': 'options'
    }).insertAfter($styledSelect);

    // Insert a list item into the unordered list for each select option
    for (var i = 0; i < numberOfOptions; i++) {
        $('<li />', {
            text: $this.children('option').eq(i).text(),
            rel: $this.children('option').eq(i).val()
        }).appendTo($list);
    }

    // Cache the list items
    var $listItems = $list.children('li');

    // Show the unordered list when the styled div is clicked (also hides it if the div is clicked again)
    $styledSelect.click(function (e) {
        e.stopPropagation();
        $('div.styledSelect.active').each(function () {
            $(this).removeClass('active').next('ul.options').hide();
        });
        $(this).toggleClass('active').next('ul.options').toggle();
    });

    // Hides the unordered list when a list item is clicked and updates the styled div to show the selected list item
    // Updates the select element to have the value of the equivalent option
    $listItems.click(function (e) {
        e.stopPropagation();
        $styledSelect.text($(this).text()).removeClass('active');
        $this.val($(this).attr('rel'));
        $list.hide();
        /* alert($this.val()); Uncomment this for demonstration! */
    });

    // Hides the unordered list when clicking outside of it
    $(document).click(function () {
        $styledSelect.removeClass('active');
        $list.hide();
    });


} // close the health attribute if

});

    $("ul.options li").click(function () {

        

        console.log($(this).attr('rel'));

        

        if($(this).attr('rel') == '') {

            $(this).parent().prev().removeClass('selectedlink');

        }

        else {

            $(this).parent().prev().addClass('selectedlink');

        }

                     

    });

</script>



<?php get_footer(); ?>

