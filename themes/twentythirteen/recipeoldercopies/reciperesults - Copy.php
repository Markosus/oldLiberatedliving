<?php


get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">

			

		

		

		<?php
		

		if (!empty($_POST['search']))
		{
			$searchname = $_POST['search'];
			$mainingredient = $_POST['mainingredient'];
			$maincategory = $_POST['maincategory'];
			$subcategory = $_POST['subcategory'];

			$searchboxtext .= $_POST['search'];
				
			

			// $searchname = preg_replace("#[^0-9a-z]#i", "", $searchname);
			
			// only one of the categories are selected

			$maincategory = stripcslashes($maincategory);
			$mainingredient = stripcslashes($mainingredient);
			$subcategory = stripcslashes($subcategory);
			
			if (!empty($_POST['healthconcerns'])){
				foreach ($_POST['healthconcerns'] as $value) {
					
					// $heathlist[$key] = stripslashes($value);
					$healthlist .= ($value).',';

					
					}
				$healthlist = rtrim($healthlist, ', ');
				$healthlist = "HAVING concatcolumn LIKE '%$healthlist%'";
				
				$result = mysql_query("SELECT recipes.*,GROUP_CONCAT(health_id ORDER BY health_id) AS concatcolumn
										FROM recipes
										LEFT JOIN recipe_recipetohealth ON recipes.recipe_id = recipe_recipetohealth.recipe_id
										WHERE recipe_name LIKE '%$searchname%' $maincategory $mainingredient $subcategory
										GROUP BY recipe_id
										$healthlist") or die("The search could be fulfilled"); 	
				$count =  mysql_num_rows($result);	



			}else{

				$result = mysql_query("SELECT * FROM `recipes` WHERE recipe_name LIKE '%$searchname%' $maincategory $mainingredient $subcategory") or die("The search could be fulfilled"); 	
				$count =  mysql_num_rows($result);	
			}	

			
			
			
			

			if ($count == 0){
				echo "there were no results found";
			}else{	

				while($row = mysql_fetch_array($result))
				{
				$recipename = $row['recipe_name'];
				$output[] .= $recipename;


				}
			}	




				// if the search box is empty but the submenu is selected	
		}elseif ((isset($_POST['search']))&& (empty($_POST['search']))&& (!empty($_POST['mainingredient'])) || (!empty($_POST['maincategory'])) || (!empty($_POST['subcategory']))|| (!empty($_POST['healthconcerns']))) {
				

		
			$mainingredient = $_POST['mainingredient'];
			$maincategory = $_POST['maincategory'];
			$subcategory = $_POST['subcategory'];

			$maincategory = stripcslashes($maincategory);
			$mainingredient = stripcslashes($mainingredient);
			$subcategory = stripcslashes($subcategory);

			if (!empty($_POST['healthconcerns'])){
				foreach ($_POST['healthconcerns'] as $value) {
						$healthlist .= ($value).',';
						}
				$healthlist = rtrim($healthlist, ', ');
				$healthlist = "HAVING concatcolumn LIKE '%$healthlist%'";


				$result = mysql_query("SELECT recipes.*,GROUP_CONCAT(health_id ORDER BY health_id) AS concatcolumn
											FROM recipes
											LEFT JOIN recipe_recipetohealth ON recipes.recipe_id = recipe_recipetohealth.recipe_id
											WHERE recipes.recipe_id > 0 $maincategory $mainingredient $subcategory
											GROUP BY recipe_id
											$healthlist") or die("The search could be fulfilled"); 	
				$count =  mysql_num_rows($result);

			}else{
				
				$result = mysql_query("SELECT * FROM `recipes` WHERE recipe_id > 0 $maincategory $mainingredient $subcategory") or die("The search could be fulfilled"); 	
				$count =  mysql_num_rows($result);			
			}


			if ($count == 0){
				echo "there were no results found";
			}else{
				while($row = mysql_fetch_array($result))
				{
				$recipename = $row['recipe_name'];
				$output[] .=$recipename;
				}

			}	


		}else{

			header("Location:/recipesearch");
		}


		




		?>


<div class="recipesearchresultsdiv">

<br>

	<form action="<?php the_permalink(); ?>" method="POST"> 
	 	<input type="text" name="search" placeholder="Search Results" maxlength="150" value="<?php echo $searchboxtext; ?>">
		
	</form>

<hr>
<br>
	<?php 
	
		
	if (isset($output)){
		foreach ($output as $value) { 

			$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_name LIKE '$value'");
			$row = mysql_fetch_array($result);
			$recipeid = $row['recipe_id'];
			$recipedate = $row['date_added'];

			$result= mysql_query("SELECT * FROM `recipe_description` WHERE recipe_id  LIKE '$recipeid'");
			$row = mysql_fetch_array($result);
			$recipedescription = $row['description'];
			$smalldescription = substr($recipedescription, 0, 30);
			preg_match('/^(?>\S+\s*){1,9}/', $recipedescription, $firstfewwords);
			$firstfewwords = rtrim($firstfewwords[0]);
			$firstfewwords .= ' ...';
			
			$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$recipeid'");
			$row = mysql_fetch_array($result);
			$recipeimagename = $row['image_name'];

			if (empty($recipeimagename)) {
				$recipeimagename = "defaultimage.png";
			}
			
			echo '<div class="reciperesult">';
			echo '<a href="/recipeview?page='.$value.'">';
			echo '<img id="searchresultimg"  width="215px" height="215px" src="/wp-content/themes/twentythirteen/recipeimages/big/'.$recipeimagename.'"></a>';
			echo '<br>'.$value.' <strong>'.$recipedate.'</strong>';
			echo '<p>'.$firstfewwords.'</p>';
			echo '</div></a>';
		}	



	}else{


	}	

	?>

<div style="clear:both"></div>
		


</div>








































				
			</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>

