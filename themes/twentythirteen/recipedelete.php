<?php
/*
Template Name: recipedelete
*/

get_header(); 
session_start();

?>



<script src="/wp-content/themes/twentythirteen/js/jquery-1.8.3.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.autocomplete.min.js"></script>
<script src="/wp-content/themes/twentythirteen/js/recipe.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.ui.js"></script>








	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">

			<div class="viewrecipecontainer">


								<?php

									// this is the if for the password protected content -->
									
									if ( post_password_required( $post ) ) {
									echo get_the_password_form();    
									} else {
									

									$getrecipename = $_GET['page'];
									// echo "Recipe Name: $getrecipename <br>";

									$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_name LIKE '$getrecipename'"); 
									while($row = mysql_fetch_array($result)){
									
									// echo 'ID: '.$row['recipe_id'].'<br> Main Category:'.$row['recipe_category'];
										$id=$row['recipe_id'];
										$recname=$row['recipe_name'];
										


									}

								

										// this grabs the description
									$result= mysql_query("SELECT * FROM `recipe_description` WHERE recipe_id LIKE '$id'"); 
										while($row = mysql_fetch_array($result)){
											$desrciption=$row['description'];
										}



			if ((!isset($id))&&(!isset($_POST['deleterecipe']))){         // ------------------ this checks to see if there is a recipe id or not --------------
									// echo '<h2>Sorry...no valid recipe has been selected.</h2>';
								
								// this prints a the list of recipes to the page and provides a link
								$result= mysql_query("SELECT * FROM `recipes`"); 

								echo '<a href="/recipeupload">Go to the Recipe Admin Panel</a><br><br>	';
								echo '<h2>Click on a recipe below to delete</h2>';


								while($row = mysql_fetch_array($result)){
									echo '<a href="/recipedelete?page='.$row['recipe_name'].'">'.$row['recipe_name'].'</a><br>';
									
								}

			}


				// $_SESSION['ingredientsarray'] = array();	
				$numberofinstructionsinarray = count($_POST["instruction"]);
				$numberofingredientsinarray = count($_POST["ingredientname"]);

				


	// ------------------ this will update the recipe to the updated values --------------

			
					
										
					


	if (isset($_POST['deleterecipe'])) {

			
			

			$updateid  = $_POST['id'];				
			$name  = $_POST['rname'];
			

			


			// this will remove the physical assosiated pic from the directory 
			$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/twentythirteen/recipeimages/recipethumb/';	
			$uploaddirbig = $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/twentythirteen/recipeimages/big/';
			

			$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$updateid'"); 
			while($row = mysql_fetch_array($result)){
				$imagename=$row['image_name'];
				$thumbimagename=$row['image_name_thumb'];
			}

			
			$tables = array("recipes","recipe_description","recipe_extranotes","recipe_images");
			foreach($tables as $table) {
 			 $query = "DELETE FROM $table WHERE recipe_id='$updateid' LIMIT 1";
 			 mysql_query($query);
			}

			$tables = array("recipe_instructions","recipe_recipeingredients","recipe_recipetohealth");
			foreach($tables as $table) {
 			 $query = "DELETE FROM $table WHERE recipe_id='$updateid'";
 			 mysql_query($query);
			}

			


			@unlink($uploaddirbig.$imagename);
			@unlink($uploaddir.$thumbimagename);

			

			header("Location:/recipedelete");

			

	}

	if (isset($_POST['cancel'])) {
		header("Location:/recipedelete");		
	}



				 
			



	// ------------------ need to perform another update for the description, ingredients, health benefits  --------------











			if (!isset($id)){         // ------------------ this checks to see if there is a recipe id or not --------------
				
				
			} else {					



								?>
					<a href="/recipedelete">Go Back to the Delete Recipe List</a>	
					
					<br><br>		
						






						

<!--  this is part of this recipe data update form  -->

						<form id="deleterecipe" name="deleterecipe" action="<?php the_permalink(); ?>" method="post">


					    			<label>Recipe name : <b><?php echo $recname ?> </b></label>  
								     
								    <br>
									<label>Recipe description : <b><?php echo $desrciption  ?></b> </label>  
									
								     
								<br>	<br> 
								<input type="hidden" name="id" value="<?php echo $id ?>">
								<input type="submit" name="deleterecipe" value="Delete Recipe"> 
								<input type="submit" name="Cancel" value="Cancel"> 

						</form>

							

										
<?php 
}
} //this is the closing bracket for the password protect if
?>



























		</div>
		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->





<?php get_footer(); ?>

