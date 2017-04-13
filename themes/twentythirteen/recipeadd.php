<?php
/*
Template Name: recipeadd
*/

session_start();
get_header(); ?>




<script src="/wp-content/themes/twentythirteen/js/jquery-1.8.3.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.autocomplete.min.js"></script>
<script src="/wp-content/themes/twentythirteen/js/recipe.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.validate.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.ui.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.asmselect.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" href="/wp-content/themes/twentythirteen/js/jquery.Jcrop.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="/wp-content/themes/twentythirteen/js/jquery.asmselect.css" />
<link rel="stylesheet" href="/wp-content/themes/twentythirteen/js/autocompletestyle.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="/wp-content/themes/twentythirteen/css/recipe.css" />

<script type="text/javascript">
	$(document).ready(function(){
		$("#entirecategoryform").validate()
</script>



<script type="text/javascript">
	$(document).on('click','.addrecipeamount',function(){

		$('.addrecipeamount').keyup(function () {
	    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
        this.value = this.value.replace(/[^0-9\s/\.]/g, '');
        }
		});

	});

$(document).on('click','.numbersonly',function(){
	$('.numbersonly').keyup(function () {
	    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
      	 this.value = this.value.replace(/[^0-9\.]/g, '');
   		 }

		});
});
</script>




<script type="text/javascript">

		$(document).ready(function() {
			$("select[multiple]").asmSelect({
				addItemTarget: 'bottom',
				animate: true,
				highlight: true,
				sortable: true
			});
			
		}); 

</script>

<script type="text/javascript">


	  $(document).on('click','.autocomplete',function(){
  var ingredientverb = [
    	<?php  

    	$result= mysql_query("SELECT * FROM `recipe_ingredientinfoverb`"); 
			while($row = mysql_fetch_array($result)){
			echo "{ value: '".$row['ingredientinfo_verb']."' },";
			}
    	 ?>
  ];
  
  // setup autocomplete function pulling from currencies[] array
  $('.autocomplete').autocomplete({
    lookup: ingredientverb
 });
  

});
</script>	

<script type="text/javascript">

  $(document).on('click','.autocompleteingredient',function(){
  
		
		  var ingredientverb = [
		    	<?php  

		    	$result= mysql_query("SELECT * FROM `recipe_ingredients`"); 
					while($row = mysql_fetch_array($result)){
					echo "{ value: '".$row['ingredient_name']."' },";
					}
		    	 ?>
		  ];
		  
		  // setup autocomplete function pulling from currencies[] array
		  $('.autocompleteingredient').autocomplete({
		    lookup: ingredientverb
		  });
		  

		
  
});
</script>



<?php
function fractodec($fraction) {


preg_match_all('/\d+\d+|\d+/', $fraction, $match);
global $decimalnumber;



$doesithaveaspace=(preg_match('/\s/',$fraction));
if ($doesithaveaspace>=1){
	$wholenumber = $match[0][0];
	$numerator = $match[0][1];
	$denominator = $match[0][2];
}else{
	$numerator = $match[0][0];
	$denominator = $match[0][1];
}

$isitafraction=(preg_match('/\//',$fraction));  //checks if the number is a fraction before doing the math and setting it
if ($isitafraction){
	$decimalnumber = $numerator/$denominator;
	$decimalnumber = round($decimalnumber, 7, PHP_ROUND_HALF_DOWN);
	$decimalnumber = $decimalnumber + $wholenumber;	
}else{
	$decimalnumber=$fraction;
}

}


function dectofrac($n, $tolerance = 1.e-6) {
    $h1=1; $h2=0;
    $k1=0; $k2=1;
    $b = 1/$n;
    do {
        $b = 1/$b;
        $a = floor($b);
        $aux = $h1; $h1 = $a*$h1+$h2; $h2 = $aux;
        $aux = $k1; $k1 = $a*$k1+$k2; $k2 = $aux;
        $b = $b-$a;
    } while (abs($n-$h1/$k1) > $n*$tolerance);


    $y=$h1;
	$x=$k1;

	$whole = (int) ($y / $x);
	$remainder = $y % $x ;
	if ($remainder == 0) {
		return "$whole";
	}

	if ($whole == 0) {
		return "$remainder/$x";
	}
	
	return "$whole $remainder/$x";

    // return "$h1/$k1";

   

}



	unset($_SESSION['instructionsarray']);
	unset($_SESSION['stepcount']);
	unset($_SESSION['count']);
	unset($_SESSION['ingredientsarray']);

	if (isset($_POST['upload'])) {
		$query = mysql_query("SELECT * from recipes WHERE recipe_name = '{$_POST['rname']}'");



		if (mysql_num_rows($query)>0){
			$errorvalue = 'Please choose another recipe name. One of that name already exists.';
			?>
			<style>
			.addrecipeerror{
			display: block;
			}
			</style>
			<?php
		}else if (in_array(0, $_POST['ingredientamount'])) {
			$errorvalue = 'Ingredient amounts have to be greater than 0';
			?>
			<style>
			.addrecipeerror{
			display: block;
			}
			</style>
			<?php

		}else{

			// --------------------start the upload code ----------------//
			$name  = $_POST['rname'];
			$servingsize = $_POST['servingsize'];
			$recipelink = $_POST['linkedrecipe'];
			$maincat       = $_POST['maincategory'];
			$subcat    = $_POST['subcategory'];
			$mainingredient = $_POST['mainingredient']; 
			$description = $_POST['recipedescription'];
			$extranotes = $_POST['extranotes'];
			$healthattributes = $_POST['health'];


			foreach($_POST['ingredientamount'] as $value){
					
				    fractodec($value);
					$ingredientamount[] = $decimalnumber;
				 }
			

			// $ingredientamount = $_POST['ingredientamount'];
			$ingredientunit = $_POST['ingredientunit'];
			$ingredientname = $_POST['ingredientname'];
			$ingredientaction = $_POST['ingredientaction'];



			// inserts recipe name
			if (isset($_POST['rname'])){	

				$query = "INSERT INTO recipes (recipe_name, linked_recipe_id,recipe_category, recipe_subcategory, recipe_main_ingredient,serving_size,meal_plan, date_added)
				          VALUES('{$_POST['rname']}','{$_POST['linkedrecipe']}','{$_POST['maincategory']}','{$_POST['subcategory']}','{$_POST['mainingredient']}','{$_POST['servingsize']}','{$_POST['mealplan']}',NOW())";

				mysql_query($query);
				$rec_id = mysql_insert_id(); //this is the recipe id
				$_SESSION['rec_id'] = $rec_id;
				

			// ----------------------------   this is the loop to save the instructions into the session variable ----------------	
				$i=1;
			foreach($_POST['instruction'] as $value)
					{
						if (!empty($value)){ 
						$_SESSION['instruct'][$i] =$value;
						$i++;
						}
					}
			$i=$i-1;

	
			// inserts and associates step, step instruction to the recipe id.


			if (isset($_SESSION['instruct'])){

				 $stepcounter=1;
				 foreach($_SESSION['instruct'] as $value){
					


					$query4 = "INSERT INTO recipe_instructions (recipe_id,step,step_description)
          			VALUES('$rec_id','$stepcounter','$value')";
          			
					mysql_query($query4);
				    $stepcounter++; 
				 
				 }
			}

			// --------------------  end the update instructions code-------------------------------------------
			// --------------------  start the health attribute  code-------------------------------------------
			
							
				if (isset($_POST['health'])){
				$counter2=0;
				 		
				 		foreach ($_POST['health'] as $value){	

						$result2= mysql_query("SELECT health_id FROM `recipe_healthattribute` WHERE healthattributename  LIKE '$value'"); 
						while($row = mysql_fetch_array($result2)){
						$healthid[]= $row['health_id'];

						}

						
		 	
					$query5 = "INSERT INTO recipe_recipetohealth (recipe_id,health_id)
          			VALUES('$rec_id','$healthid[$counter2]')";
       				mysql_query($query5);

				    	$counter2++; 

				 
						 }
				}	

			// --------------------  end the health attribute code-------------------------------------------
			// --------------------  start the ingredient code-------------------------------------------	

						$in=1;
					foreach($_POST['ingredientname'] as $value)
							{
								if (!empty($value)){ 
								$_SESSION['ingredientsarray'][$in] =$value;
								$in++;
								}
							}
					$in=$in-1;	


			// if the ingredient doesnt exist in the database then add it to the database
								


								foreach($_SESSION['ingredientsarray'] as $value)
								{
									
									$result = mysql_query("SELECT * FROM `recipe_ingredients` WHERE ingredient_name = '$value'");
									$num_rows = mysql_num_rows($result);
										if($num_rows > 0)
										{
										 
										}else
										{
										    $query6 = "INSERT IGNORE INTO recipe_ingredients (ingredient_name)
						          			VALUES('$value')";
											mysql_query($query6);

											
										}					
									
								}

							// add to the ingredients			

							$counter =0; 
							foreach($_SESSION['ingredientsarray'] as $value)
								{
									$result= mysql_query("SELECT ingredient_id FROM `recipe_ingredients` WHERE ingredient_name LIKE '$value'"); 
									while($row = mysql_fetch_array($result)){
									$ingredient_id= $row['ingredient_id'];
									}

									$amount=$ingredientamount[$counter];
									$unit=$ingredientunit[$counter];
									$action=$ingredientaction[$counter];

									$query7 = "INSERT INTO recipe_recipeingredients (recipe_id,ingredient_id,amount,unittype,actioninfo)
						          	VALUES('$rec_id','$ingredient_id','$amount','$unit','$action')";
									mysql_query($query7);
									$counter++;


								}	

					// --------------------  end ingredient code-------------------------------------------
					// inserts the extra notes to the recipe if it exists

				 if (!empty($_POST['extranotes'])){	
				
						$query6 = "INSERT INTO recipe_extranotes (recipe_id,extra_notes)
		          		VALUES('$rec_id','{$_POST['extranotes']}')";
		          		mysql_query($query6);
						     

					}

					// inserts the recipe description to the recipe if it exists

				 if (!empty($_POST['recipedescription'])){	
				
						$querydescription = "INSERT INTO recipe_description (recipe_id,description)
		          		VALUES('$rec_id','{$_POST['recipedescription']}')";
		          		mysql_query($querydescription);
						     

					 }						



			header("Location:/recipeupload");		 





			} //if rname isset

			
		} // else for the is there a username

	} // isset upload


	

			
			

						
			

			

?>



	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">


		<?php
		if ( post_password_required( $post ) ) {
		echo get_the_password_form();    
		} else {
		?>	



		<!-- <img style="display: block;margin-left: auto; margin-right: auto;" src="/liberatedliving/wp-content/themes/twentythirteen/images/healthy.png">
 -->
		<h2 style="margin-bottom:-15px;">Add Recipe</h2>
		<h3 >Fill in the form below to add your recipe to the database</h3>
		<a href="/recipeadmin">Go to the Recipe Admin Panel</a><br><br>	
		<hr />

				<div class="recipeadd">


				



						<form id="entirecategoryform" action="<?php the_permalink(); ?>" method="post"> 

									<div class="addrecipeerror" >Error: <?php echo $errorvalue; ?></div>

								     <label>Enter the recipe name. </label>  
								     <br>
								     <input type="text" class="recipename" name="rname" maxlength="500" size="50" required/>
								     <br><br>
								    
									<label>Enter the recipe description.</label>  
									<br>
									<textarea rows="4" cols="50" class="recipedescription"  name="recipedescription" required></textarea>
									 <br>
								     
									 <br>
								    
									<label>Enter the serving size.</label>  
									<br>
									<input type="text" name="servingsize" maxlength="2" size="4" class="numbersonly" required/>
									 <br>
								    <br>
									
									
											<label>Link this recipe to another recipe. (Not required)</label>
											<br>
											<select id="linkedrecipe" name="linkedrecipe">
											<option value="0">Link to recipe </option>
										<?php
												$result = mysql_query("SELECT * FROM `recipes`");
													while($row = mysql_fetch_array($result)){
														echo '<option value="'.$row['recipe_id'].'">'.$row['recipe_name'].'</option>';
													}
													
										?>
											</select>

										<br><br><br>	
											<input type="checkbox" value="1" id="mealplan" name="mealplan" />
											<label for="mealplan">Is this part of a meal plan?</label>
										<br><br><br>

									<!-- add ingredient -->		

									<div class="ingredient">
								   	<?php
									$counter=0;
									?>
										Examples of accepted values.	
										 <table class="recipeexample">
										 <tr>
										 <td class="column1">3/4</td>
										 <td class="column2">Cups</td>
										 <td class="column3">Carrots</td>
										 <td class="column4">Shredded</td>
										 </tr>
										 <tr>
										 <td class="addrecipeamount">1.5</td>
										 <td class="recipeunit">Liters</td>
										 <td class="autocompleteingredient">Chicken</td>
										 <td class="autocomplete">Finely Diced</td>
										 </tr>	
										 </table>			
										 <p class="text-boxi"><label for="box1i">#  <span class="box-numberi"><?php echo $counter + 1; ?></span></label> 
										
										 <input type="text" class="addrecipeamount" maxlength="6" name="ingredientamount[]" placeholder="Amt" value="" required>
								    	 <input type="text" name="ingredientunit[]" class="recipeunit" placeholder="Unit" maxlength="500" size="10"  value="">
								    	 <input type="text" name="ingredientname[]" placeholder="Ingredient Name" maxlength="500" class="autocompleteingredient" size="20"  value="" required>
								    	 <input type="text" name="ingredientaction[]" placeholder="Info/Action" class="autocomplete" size="14" value="">
								    	 <?php 
									   	  if ($counter > 0) {
									   	  	echo '<a href="#" class="remove-boxi">Remove</a></p>';
									   	  	} else {
									   	  		echo '<a class="add-boxi" href="#">Add</a></p>';
									   	  	}

									   	  
									   	  ?>
								    	 <br>
								    	 <?php
								    $counter++;	 
									?>
									</div>

							

			

									<!-- this is the add step -->

									<div class="my-form">
								
									<?php
								   

									
										$stepcounter++;
										?>

																			
										<div style="clear:both"></div>

									   	 <p class="text-box"><label for="box' + n + '">Step <span class="box-number"> <?php echo $stepcounter; ?></span></label>
									   	  <textarea rows="4" cols="35" name="instruction[]" required></textarea>  
									   	  <?php 
									   	  if ($stepcounter > 1) {
									   	  	echo '<a href="#" class="remove-box">Remove</a></p>';
									   	  	} else {
									   	  		echo '<a class="add-box" href="#">Add Another Step</a></p>';
									   	  	}

									   	  
									   	  ?>

									   	<br>
									   	
									
								</div>		
								


								<!-- this is the maincategory loop -->

										<?php
										
											
											$query = "SELECT * FROM recipe_coursecategory";
											$result = mysql_query($query);
										?>


									
									


											<div id="maincategorydivshow">			
											<label for="health">Select Course Type</label>
											<br>	
											<select id='category' name="maincategory">

												<option value="0">Select Course Type</option>
										<?php
												while($row = mysql_fetch_array($result)){
														echo '<option value="'.$row['coursename'].'">'.$row['coursename'].'</option>';
														
												}
										?>
											</select>
											</div>	



									<!-- 	this is the sub category loop -->

										<br><br>
										<?php
											$query = "SELECT *  FROM recipe_dishtypesubcategory";
											$result = mysql_query($query);
											
										?>
											<div id="subcategoryshow" style="display:none;">
											<label>Select Dish Type</label>
											<br>	
											<select id="subcategory" name="subcategory">
											<option value="0">Select Dish Type</option>
										<?php
												while($row = mysql_fetch_array($result)){
														echo '<option value="'.$row['subcategoryname'].'">'.$row['subcategoryname'].'</option>';
														
												}
										?>
											</select>
											</div>

										<!-- this is the main ingredient loop -->

										<br>

										<?php
											$query = "SELECT *  FROM recipe_mainingredient";
											$result = mysql_query($query);
											
										?>
											<div id="mainingredientshow" style="display:none;">
											<label>Whats the main ingredient in your recipe?</label>
											<br>
											<select id="mainingredient" name="mainingredient">
											<option value="0">Choose the main ingredient.</option>
										<?php
												while($row = mysql_fetch_array($result)){
														echo '<option value="'.$row['mainingredientname'].'">'.$row['mainingredientname'].'</option>';
														
												}
										?>
											</select>
											</div>

										<br>


										<!-- this is the main healthform loop -->

										<?php
											$query = "SELECT *  FROM recipe_healthattribute";
											$result = mysql_query($query);
											
										?>
											<!-- <form id="healthform"action="./example_results.php" method="post" style="display:none;"> -->
											<div id="healthform" style="display:none;">
											<label for="health">Enter in the health benefits. (Not Required)</label>
											<select id="health" multiple="multiple" name="health[]" title="Click to Select a health consideration">
								 
										<?php
												while($row = mysql_fetch_array($result)){
														echo '<option value="'.$row['healthattributename'].'">'.$row['healthattributename'].'</option>';
														
												}
										?>
											</select>
											</div>

										
																						
									
											<div id="notes" style="display:none;">
											<label>Enter in any addition recipe notes. (Not Required)</label>  
											<br>
											<textarea rows="4" cols="35" name="extranotes"></textarea> 
											<br><br>

											</p>Note: Attach Image to Recipe after adding to database.</p>
											<input type="submit" name="upload" value="Add to Database">									
											</div>			

								
								    
											

								</form>





<?php
} //this is the closing bracket for the password protect if
?>







			</div>						
		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->			

<script type="text/javascript">

jQuery(document).ready(function($){
    $('.my-form .add-box').click(function(){
        var n = $('.text-box').length + 1;
        if( 15 < n ) {
            alert('Youve added too many. Notify admin.');
            return false;
        }
        var box_html = $('<p class="text-box"><label for="box' + n + '">Step <span class="box-number">' + n + '</span></label> <textarea rows="4" cols="35" name="instruction[]"" required></textarea>  <a href="#" class="remove-box">Remove</a></p>');
        box_html.hide();
        $('.my-form p.text-box:last').after(box_html);
        box_html.fadeIn('slow');
        return false;

       

    });
    $('.my-form').on('click', '.remove-box', function(){
        $(this).parent().css( 'background-color', '#FF6C6C' );
        $(this).parent().fadeOut("slow", function() {
            $(this).remove();
            $('.box-number').each(function(index){
                $(this).text( index + 1 );
            });
        });
        return false;
    });
});
</script>

<script type="text/javascript">

jQuery(document).ready(function($){
    $('.ingredient .add-boxi').click(function(){
        var n = $('.text-boxi').length + 1;
        if( 15 < n ) {
            alert('Youve added too many. Notify admin.');
            return false;
        }
        var box_html = $('<p class="text-boxi"><label for="box' + n + '"># <span class="box-numberi">' + n + '</span></label> <input type="text" class="addrecipeamount" name="ingredientamount[]" placeholder="Amt" class="recipeamount" maxlength="30" size="15" value="" required><input type="text" name="ingredientunit[]" placeholder="Unit" class="recipeunit" maxlength="500" size="10"  value=""><input type="text" name="ingredientname[]" placeholder="Ingredient Name" maxlength="500" class="autocompleteingredient" size="20"  value="" required><input type="text" name="ingredientaction[]" class="autocomplete" placeholder="Info/Action"  size="14" value=""> <a href="#" class="remove-boxi">Remove</a></p>');
        box_html.hide();

        $('.ingredient p.text-boxi:last').after(box_html);
        box_html.fadeIn('slow');
        return false;

       

    });
    $('.ingredient').on('click', '.remove-boxi', function(){
        $(this).parent().css( 'background-color', '#FF6C6C' );
        $(this).parent().fadeOut("slow", function() {
            $(this).remove();
            $('.box-numberi').each(function(index){
                $(this).text( index + 1 );
            });
        });
        return false;
    });
});
</script>

	<?php get_footer(); ?>