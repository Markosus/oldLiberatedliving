<?php
/*
Template Name: testajactemp
*/

session_start();

?>

<script src="/wp-content/themes/twentythirteen/js/jquery.min.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery-ui.js"></script>
<script src="/wp-content/themes/twentythirteen/js/recipeui.js"></script>
<link rel="stylesheet" href="/wp-content/themes/twentythirteen/css/recipe.css" type="text/css" />



<?php

$browserwidth = $_SESSION['browserwidth'];
// unset($_SESSION['browserwidth']);

if ($browserwidth<400){
	$numberofitems = 4;
}elseif (($browserwidth>400)&&($browserwidth<=1069)){ 
	$numberofitems = 8;
}else {
	$numberofitems = 10;
}


  // Include the pagination class
  include 'pagination.class.php';
  // Create the pagination object
  $pagination = new pagination;
 

 

  // If we have an array with items
  if (count($_SESSION['output'])) {
    // Parse through the pagination class
    $productPages = $pagination->generate($_SESSION['output'], $numberofitems);
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
      // echo '<div style="clear:both"></div><br>';
      // print out the page numbers beneath the results
      echo '<div class="centerpagenum">'.$pageNumbers.'</div>';
    }
  }




?>