<?php
/*
Template Name: recipesearch
*/

get_header(); 
?>

<script src="/wp-content/themes/twentythirteen/js/jquery-1.8.3.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.autocomplete.min.js"></script>
<link rel="stylesheet" href="/wp-content/themes/twentythirteen/js/autocompletestyle.css" type="text/css" />

<script src="/wp-content/themes/twentythirteen/js/showHide.js"></script>

<script type="text/javascript">
	$(function(){
  var ingredientverb = [
    	<?php  

    	$result= mysql_query("SELECT * FROM `recipes`"); 
			while($row = mysql_fetch_array($result)){
			echo "{ value: '".$row['recipe_name']."' },";
			}
    	 ?>
  ];
  
  // setup autocomplete function pulling from currencies[] array
  $('#autocomplete').autocomplete({
    lookup: ingredientverb,
    onSelect: function (suggestion) {
      var thehtml = '<strong>Ingredient Action/Info:</strong> ' + suggestion.value;
      $('#outputcontent').html(thehtml);
    }
  });
  

});
</script>	


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">

			

		





			<div class="recipesearchdiv">

				<h1>Recipe Search</h1>



				<form action="/reciperesults/" method="POST"> 
				<!-- <form action="/test/" method="POST"> --> 

								
					 <input type="text" class="recipesearch" id="autocomplete" name="search" placeholder="search" maxlength="150" style="line-height: 40px;" >
					 <input type="submit"  class="recipesearchbutton" name="submit" value="Search">

					


				<div class="row" id="rowcontainer">

							<div class="col-lg-6" id="healthcolumnleft">
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

							<div class="col-lg-6" id="healthcolumnright">

							
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

											<button type="button" id="searchhealthbutton" class="show_hide" rel="#slidingDiv">Health Concerns</button>

							</div> <!-- end col	 -->


					</div>	<!-- end row	 -->




											
											




										<br>

											<!-- this is the main healthform loop -->

										

											
										    <div id="slidingDiv" style="padding-bottom:100px;">


										    <?php
											$query = "SELECT *  FROM recipe_healthattribute";
											$result = mysql_query($query);
											
											?>
																				
											
								 				<legend>Select your health concerns:</legend>
										<?php
												while($row = mysql_fetch_array($result)){

														echo '<div id="hideshowdiv" >';	
														echo '<input id="'.$row['healthattributename'].'" type="checkbox" name="healthconcerns[]" value="'.$row['health_id'].'">';
														echo '<label for="'.$row['healthattributename'].'">'.$row['healthattributename'].'</label>';
														echo '</div>';
												}
										?>
											
											

  

  



										    </div>





				</form>


	
    
    									
<!-- SELECT recipes.*,GROUP_CONCAT(health_id) AS test
FROM recipes
LEFT JOIN recipe_recipetohealth ON recipes.recipe_id = recipe_recipetohealth.recipe_id
WHERE recipe_recipetohealth.health_id IN (1,2)
GROUP BY recipe_id -->

<!-- SELECT recipes.*,GROUP_CONCAT(health_id) AS test
FROM recipes
LEFT JOIN recipe_recipetohealth ON recipes.recipe_id = recipe_recipetohealth.recipe_id
GROUP BY recipe_id
HAVING test LIKE '1,2' -->
    
    

</div>
	<!-- 	SELECT * FROM `recipes` LEFT JOIN recipe_recipetohealth
 ON recipes.recipe_id = recipe_recipetohealth.recipe_id		 -->	
			




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

<script type="text/javascript">

$(document).ready(function(){


   $('.show_hide').showHide({			 
		speed: 1000,  // speed you want the toggle to happen	
		easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
		changeText: 1, // if you dont want the button text to change, set this to 0
		showText: 'Health Concerns',// the button text to show when a div is closed
		hideText: 'Close' // the button text to show when a div is open
					 
	}); 


});

</script>

<?php get_footer(); ?>

