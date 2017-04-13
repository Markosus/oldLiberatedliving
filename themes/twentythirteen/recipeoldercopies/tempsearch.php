<?php


get_header(); 
?>

<script src="/wp-content/themes/twentythirteen/js/jquery-1.8.3.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.autocomplete.min.js"></script>
<link rel="stylesheet" href="/wp-content/themes/twentythirteen/js/autocompletestyle.css" type="text/css" />

<link rel="stylesheet" href="/wp-content/themes/twentythirteen/js/bootstrap.min.css">
 <link rel="stylesheet" href="/wp-content/themes/twentythirteen/js/bootstrap-select.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="/wp-content/themes/twentythirteen/js/bootstrap-select.js"></script>

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

				<form action="<?php the_permalink(); ?>" method="POST"> 


								
					 <input type="text" class="recipesearch" id="autocomplete" name="search" placeholder="search" maxlength="150" >
					 <input  type="submit"  class="recipesearchbutton" name="submit" value="Search">

					<br>

											<?php 
											$query = "SELECT * FROM recipe_coursecategory";
											$result = mysql_query($query);
											
											?>

											<div id="maincategorysearch">			
											<br>	
											<select id='category' name="maincategory">

												<option value="">maincategory</option>
										<?php
												while($row = mysql_fetch_array($result)){
													echo '<option value="AND recipe_category LIKE \''.$row['coursename'].'\'">'.$row['coursename'].'</option>';
												}
										?>
											</select>
											</div>		




											<?php
											$query = "SELECT *  FROM recipe_mainingredient";
											$result = mysql_query($query);
											?>
												<br>
												<div id="mainingredientsearch" >
												<select id="mainingredient" name="mainingredient">
												<option value="">Main ingredient</option>
											<?php
													while($row = mysql_fetch_array($result)){
														echo '<option value="AND recipe_main_ingredient LIKE \''.$row['mainingredientname'].'\'">'.$row['mainingredientname'].'</option>';
															
													}
											?>
											</select>
											</div>
											<br>




											<?php
											$query = "SELECT *  FROM recipe_dishtypesubcategory";
											$result = mysql_query($query);
											?>
											<div id="subcategorysearch">
											<br>	
											<select id="subcategory" name="subcategory">
											<option value="">Dish Type subcategory</option>
										<?php
												while($row = mysql_fetch_array($result)){
													echo '<option value="AND recipe_subcategory LIKE \''.$row['subcategoryname'].'\'">'.$row['subcategoryname'].'</option>';
												}
										?>
											</select>
											</div>



				</form>
					



			</div>



<?php

		if (!empty($_POST['search']))
		{
			$searchname = $_POST['search'];
			$mainingredient = $_POST['mainingredient'];
			$maincategory = $_POST['maincategory'];
			$subcategory = $_POST['subcategory'];

			// $searchname = preg_replace("#[^0-9a-z]#i", "", $searchname);
			
			// only one of the categories are selected

			$maincategory = stripcslashes($maincategory);
			$mainingredient = stripcslashes($mainingredient);
			$subcategory = stripcslashes($subcategory);

			$result = mysql_query("SELECT * FROM `recipes` WHERE recipe_name LIKE '%$searchname%' $maincategory $mainingredient $subcategory") or die("The search could be fulfilled"); 	
			$count =  mysql_num_rows($result);

			if ($count == 0){
				echo "there were no results found";
			}else{	

				while($row = mysql_fetch_array($result))
				{
				$recipename = $row['recipe_name'];
				$output .='<div>'.$recipename.'</div>';
				}
			}	




				// if the search box is empty but the submenu is selected	
		}elseif ((empty($_POST['search']))&& (!empty($_POST['mainingredient']))) {
				echo 'main ingredient set with out the search';
		}


		




		?>


	<?php 

		print("$output");

	?>


		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->





<?php get_footer(); ?>

