<?php
/*
Template Name: recipemealplantest
*/

session_start();
?>

<script src="/wp-content/themes/twentythirteen/js/jquery.min.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.autocomplete.min.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery-ui.js"></script>
<script src="/wp-content/themes/twentythirteen/js/recipeui.js"></script>
<link rel="stylesheet" href="/wp-content/themes/twentythirteen/js/autocompletestyle.css" type="text/css" />
<link rel="stylesheet" href="/wp-content/themes/twentythirteen/css/recipe.css" type="text/css" />



<?php

if ( post_password_required( $post ) ) {
		echo "You shouldnt be here.";  
		} else {
				

	if (!empty($_POST['search']))
		{	
			$_SESSION['output']=array();
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
				$noresults = "There were no results found. Try a different search.";
			}else{	

				while($row = mysql_fetch_array($result))
				{
				$recipename = $row['recipe_name'];
				$output[] .= $recipename;
				array_push($_SESSION['output'], $recipename);
				}
			}	




				// if the search box is empty but the submenu is selected	
		}elseif ((isset($_POST['search']))&& (empty($_POST['search']))&& (!empty($_POST['mainingredient'])) || (!empty($_POST['maincategory'])) || (!empty($_POST['subcategory']))|| (!empty($_POST['healthconcerns']))) {
				

			$_SESSION['output']=array();
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
				$noresults = "There were no results found. Try a different search.";
			}else{
				while($row = mysql_fetch_array($result))
				{
				$recipename = $row['recipe_name'];
				$output[] .=$recipename;
				array_push($_SESSION['output'], $recipename);
				}

			}	


		}elseif (!isset($_GET['pagenum'])){
				
		// unset($_SESSION['output']);	
		
			
		}


		



$length = strlen($searchboxtext); 
		?>



<?php 

if (isset($noresults)){
	echo $noresults;
}

$result= mysql_query("SELECT * FROM `recipe_images` ORDER BY recipe_id DESC LIMIT 2");




	?>


<?php
  // Include the pagination class
  include 'pagination.class.php';
  // Create the pagination object
  $pagination = new pagination;
 

 

  // If we have an array with items
  if (count($_SESSION['output'])) {
    // Parse through the pagination class
    $productPages = $pagination->generate($_SESSION['output'],3);
    // If we have items 
    if (count($productPages) != 0) {
      // Create the page numbers
      $pageNumbers = '<div class="numbers">'.$pagination->links().'</div>';
      // Loop through all the items in the array
      foreach ($productPages as $value) {
        // Show the information about the item




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
			$recipeimagename = $row['image_name_thumb'];

			if (empty($recipeimagename)) {
				$recipeimagename = "defaultimage_thumb.png";
			}
			
			echo '<div class="images" id="reciperesult">';
			echo '<a href="/recipeview?page='.$value.'" target="window">';
			echo '<img id="searchresultimg" src="/wp-content/themes/twentythirteen/recipeimages/recipethumb/'.$recipeimagename.'"></a>';
			echo '<div class="name">'.$value.'</div>';
			echo '<br><span class="id">'.$recipeid.'</span>';
			// echo '<p>'.$firstfewwords.'</p>';
			echo '</div></a>';


      }
      echo '<div style="clear:both"></div><br>';
      // print out the page numbers beneath the results
      echo '<div class="centerpagenum">'.$pageNumbers.'</div>';
    }
  }


} // closing bracket for the password protect

?>
