<?php


get_header(); 

// ------------------ Begining of related recipe random generator --------------



			$result= mysql_query("SELECT * FROM `recipes`"); 
			while($row = mysql_fetch_array($result)){
			$relatedrecipes[]=$row['recipe_id'];
			}
				
				$relatedrecipescount2 = 3;
				$relatedrecipescount = 3;
				
				
					$rand_keys = array_rand($relatedrecipes, $relatedrecipescount);
					$randrecipe1 = $relatedrecipes[$rand_keys[0]];
					$randrecipe2 = $relatedrecipes[$rand_keys[1]];
					$randrecipe3 = $relatedrecipes[$rand_keys[2]];	
					


					$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$randrecipe1'");
					$row = mysql_fetch_array($result);
					$randrecipe1url = $row['image_name'];
					$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$randrecipe1'");
					$row = mysql_fetch_array($result);
					$randrecipe1name = $row['recipe_name'];
					$result= mysql_query("SELECT * FROM `recipe_description` WHERE recipe_id LIKE '$randrecipe1'");
					$row = mysql_fetch_array($result);
					$randrecipe1description = $row['description'];


					$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$randrecipe2'");
					$row = mysql_fetch_array($result);
					$randrecipe2url = $row['image_name'];
					$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$randrecipe2'");
					$row = mysql_fetch_array($result);
					$randrecipe2name = $row['recipe_name'];
					$result= mysql_query("SELECT * FROM `recipe_description` WHERE recipe_id LIKE '$randrecipe2'");
					$row = mysql_fetch_array($result);
					$randrecipe2description = $row['description'];

					$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$randrecipe3'");
					$row = mysql_fetch_array($result);
					$randrecipe3url = $row['image_name'];
					$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$randrecipe3'");
					$row = mysql_fetch_array($result);
					$randrecipe3name = $row['recipe_name'];
					$result= mysql_query("SELECT * FROM `recipe_description` WHERE recipe_id LIKE '$randrecipe3'");
					$row = mysql_fetch_array($result);
					$randrecipe3description = $row['description'];
				


				if (empty($randrecipe1url)) {
					  $randrecipe1url = "defaultimage.png";
				}

				if (empty($randrecipe2url)) {
					  $randrecipe2url = "defaultimage.png";
				}

				if (empty($randrecipe3url)) {
					  $randrecipe3url = "defaultimage.png";
				}

				// ------------------ End of related recipe random generator --------------

		?>






	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">

			<div class="frontrecipecontainer">


					<h2>Check out some of our healthy recipes!</h2>
		
					<div class="row" >
                		<a href="/recipeview/?page=<?php echo $randrecipe1name; ?>">
					    <div class="col-md-4 test" style="text-align:left;">
					    	 <img id="recipestyleleft" width='250' height='250' src="/wp-content/themes/twentythirteen/recipeimages/big/<?php echo $randrecipe1url; ?>"></a>         
					    	<h3 style="color: #e14e6d;"><?php echo $randrecipe1name; ?></h3>
					    	<p><?php echo $randrecipe1description; ?></p>
					    </div>
						</a>

						<a href="/recipeview/?page=<?php echo $randrecipe2name; ?>">
					   <div class="col-md-4 test" style="text-align:left;">
					   <img id="recipestylemiddle" width='250' height='250' src="/wp-content/themes/twentythirteen/recipeimages/big/<?php echo $randrecipe2url; ?>"></a>         
					   <h3 style="color: #1981bc;"><?php echo $randrecipe2name; ?></h3>
					   <p><?php echo $randrecipe2description; ?></p>
					   </div>
					   </a>

					   	<a href="/recipeview/?page=<?php echo $randrecipe3name; ?>">
					    <div class="col-md-4 test" style="text-align:left;">
					    <img id="recipestyleright" width='250' height='250' src="/wp-content/themes/twentythirteen/recipeimages/big/<?php echo $randrecipe3url; ?>"></a>         
					    <h3 style="color: #0faa3b;"><?php echo $randrecipe3name; ?></h3>
					    	<p><?php echo $randrecipe3description; ?></p>
					    </div>
					    </a>

					</div>  <!-- end row -->

		
				</div><!-- end frontrecipecontainer -->
		

		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->





<?php get_footer(); ?>

