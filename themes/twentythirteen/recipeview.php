<?php
/*
Template Name: recipeview
*/

get_header(); ?>


<?php

// ------------------ decimal to fraction function --------------			

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

	// printf("%s\n", dectofrac(0.3333333)); # 200/3



// ------------------ Begining of send recipe to the pdf file --------------

$instructionarray=array();
$ingredientnarray=array();

	if (isset($_POST['submit'])){

		
		// $content = $_POST['pdftextarea'];
		$pdfrecipename = $_POST['recipename'];
		$pdfrecipeyield = $_POST['recipeyield'];
		$pdfrecipenotes = $_POST['recipenotes'];
		$pdfrecipeimage = $_POST['recipeimage'];
		$pdfrecipedescription = $_POST['recipedescription'];
		$pdfimagepath = $_SERVER['DOCUMENT_ROOT'];

		$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_name LIKE '$pdfrecipename'"); 
		while($row = mysql_fetch_array($result)){
			$id=$row['recipe_id'];
		}

		$result= mysql_query("SELECT * FROM `recipe_instructions` WHERE recipe_id LIKE '$id' ORDER BY step ASC"); 
			while($row = mysql_fetch_array($result)){
			$test=$row['step_description'];
			array_push($instructionarray, $test);


		}


		$result= mysql_query("SELECT * FROM `recipe_recipeingredients` WHERE recipe_id LIKE '$id'"); 
		while($row = mysql_fetch_array($result)){
		$ingredientid[]=$row['ingredient_id'];
		$ingredientunit[]=$row['unittype'];
		$ingredientamt[]=$row['amount'];
		$ingredientaction[]=$row['actioninfo'];
		}	

		$counter=0;
		foreach ($ingredientid as $value) {
		$result= mysql_query("SELECT * FROM `recipe_ingredients` WHERE ingredient_id LIKE '$value'"); 
			while($row = mysql_fetch_array($result)){
			
			$result = (dectofrac($ingredientamt[$counter])).' '.$ingredientunit[$counter].$row['unittype'].' '.$row['ingredient_name'];
				
			}
			
			if (empty($ingredientaction[$counter]))  //this if statement will add brackets to the ingredient action if its not empty
				{

					$result = $result.$ingredientaction[$counter].'</td></tr>';
					array_push($ingredientnarray, $result);
				} else
				{
					$result = $result.' (<strong>'.$ingredientaction[$counter].'</strong>)</td></tr>';
					array_push($ingredientnarray, $result);
				}
			$counter++;
		}





		$content = 'sdf';
		$seperated_ingredientarray = implode("<br>", $ingredientnarray);
		$comma_separated = implode("<br>", $instructionarray);





		$error = 'You mist enter content';


		if (empty($content)){
			$error = 'Please enter content';
			
		}

		else {


			require_once ("$pdfimagepath/wp-content/themes/twentythirteen/dompdf/dompdf_config.inc.php"); 
			spl_autoload_register('DOMPDF_autoload'); 
			$dompdf = new Dompdf();
			$html_body="<!DOCTYPE html>
					<html>
					<body>


					<h2>$pdfrecipename</h2>
					$pdfrecipedescription
					<br><br>
					<img  width='175px'  src='$pdfimagepath/wp-content/themes/twentythirteen/recipeimages/big/$pdfrecipeimage' /> 



					
					<br>
					<p>Recipe serving size: $pdfrecipeyield</p>
					
					$seperated_ingredientarray
					<br><br>	
					$comma_separated
					<br><br>	
					$pdfrecipenotes

					


					</body>
					</html>";

					
        
			$dompdf->load_html($html_body);//body -> html content which needs to be converted as pdf..
       		

       		ob_end_clean();
			$dompdf->render();
 			 $dompdf->stream("$pdfrecipename.pdf",array('Attachment'=>1));




		}
	}


?>

<!--  ------------------ End of send recipe to the pdf file -------------- -->


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">

			<div class="viewrecipecontainer">



		
		

		<?php

		$getrecipename = $_GET['page'];
		// echo "Recipe Name: $getrecipename <br>";

		$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_name LIKE '$getrecipename'"); 
		while($row = mysql_fetch_array($result)){
		
		// echo 'ID: '.$row['recipe_id'].'<br> Main Category:'.$row['recipe_category'];
			$id=$row['recipe_id'];
			$recname=$row['recipe_name'];
			$servingsize= $row['serving_size'];
			$dateadded= $row['date_added'];
			$year = date('Y', strtotime($dateadded));
			$month = date('F', strtotime($dateadded));
			$maincategory = $row['recipe_category'];
			$subcategory = $row['recipe_subcategory'];
			$linkedrecipe = $row['linked_recipe_id'];

		}

		// this will convert the linked recipe id to a name	
			$queryl = mysql_query("SELECT * FROM recipes WHERE recipe_id LIKE '$linkedrecipe'");

			while($row = mysql_fetch_array($queryl))
				{
				$linkedrecipename=($row['recipe_name']);
				}
		// end


		$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$id'"); 
			while($row = mysql_fetch_array($result)){
				$imagename=$row['image_name'];
			}

		$result= mysql_query("SELECT * FROM `recipe_description` WHERE recipe_id LIKE '$id'"); 
			while($row = mysql_fetch_array($result)){
				$desrciption=$row['description'];
			}

		if (!isset($imagename)){
		$imagename='defaultimage.png';
		}


if (!isset($id)){         // ------------------ this checks to see if there is a recipe id or not --------------
	echo '<h2>Sorry...no valid recipe has been selected.</h2>';
} else {




			



			// ------------------ Begining of related recipe random generator --------------

			$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_category LIKE \"$maincategory\""); 
			while($row = mysql_fetch_array($result)){
			$relatedrecipes[]=$row['recipe_id'];
			}
				
				$relatedrecipescount2 = count($relatedrecipes);

					if ($relatedrecipescount2 == 2) {	
						$relatedrecipes = array_flip($relatedrecipes);
						unset($relatedrecipes["$id"]);
						$relatedrecipes = array_flip($relatedrecipes);
							
						$relatedid = $relatedrecipes[0];
						$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$relatedid'");
						$row = mysql_fetch_array($result);
						$randrecipe1url = $row['image_name'];
						$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$relatedid'");
						$row = mysql_fetch_array($result);
						$randrecipe1name = $row['recipe_name'];


					}

				if ($relatedrecipescount2 > 2) {	

					$relatedrecipes = array_flip($relatedrecipes);
					unset($relatedrecipes["$id"]);
					$relatedrecipes = array_flip($relatedrecipes);

					$relatedrecipescount = count($relatedrecipes);
						if ($relatedrecipescount > 3) {	
							$relatedrecipescount = 3;
						}
				
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



					$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$randrecipe2'");
					$row = mysql_fetch_array($result);
					$randrecipe2url = $row['image_name'];
					$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$randrecipe2'");
					$row = mysql_fetch_array($result);
					$randrecipe2name = $row['recipe_name'];

					$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$randrecipe3'");
					$row = mysql_fetch_array($result);
					$randrecipe3url = $row['image_name'];
					$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$randrecipe3'");
					$row = mysql_fetch_array($result);
					$randrecipe3name = $row['recipe_name'];
				}


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



		
		
		<div id="leftimageheader">

			<img class="recipeimage"  src="/wp-content/themes/twentythirteen/recipeimages/big/<?php echo $imagename; ?>">

			
			
					
		</div>

		<div id="rightheader">	
				
			<?php 
			$getrecipename = $_GET['page'];
			$nutritionlabal = array('Calories: N/A', 'Protein: N/A', 'Total Fat: N/A' );
			
			echo "<h2> $getrecipename</h2>";
			



	


// ------------------ Begining of health list and the popup information associated --------------

					// this grabs the health Benefits
					$result= mysql_query("SELECT * FROM `recipe_recipetohealth` WHERE recipe_id LIKE '$id'"); 
					while($row = mysql_fetch_array($result)){
					$healthid[]=$row['health_id'];
					
							}

					if 	(isset($healthid)){
						$counter=0;
						foreach ($healthid as $value) {
						$result= mysql_query("SELECT * FROM `recipe_healthattribute` WHERE health_id LIKE '$value'"); 
							while($row = mysql_fetch_array($result)){
								$healthattributename[]=$row['healthattributename'];
								$healthattributedescription[]=$row['healthdescription'];
								
							$counter++;
							}
						}
					}

					$counter=0;

					

					echo '
							<p>'.$desrciption.'</p>
							<table>
		 					<tr>
						     <th><h3>Dietary Benefits:</h3></th>
						     <th><h3>Nutrition Per Serving:</h3></th>
						  	 </tr>
							';
						//if no health benefits are listed then supply blank ones so the nutrition array still prints 
						if (empty($healthattributename[2])){
							$healthattributename[2]='';
						}  if (empty($healthattributename[1])){
							$healthattributename[1]='';
							$healthattributename[2]='';

						}  if (empty($healthattributename[0])){
							$healthattributename[o]='';
							$healthattributename[1]='';
							$healthattributename[2]='';
						}


					foreach($healthattributename as $value){

					 					
					echo "<tr><td><strong><a href='' data-toggle='modal' data-target='#modal$counter'>$value</a></strong></td>";
					echo '<td><strong>'.$nutritionlabal[$counter].'</strong></td></tr>';

// this is the modal for the pop up					
?>
<div id="<?php echo "modal$counter"; ?>" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"><?php echo "$value"; ?></h4>
                </div>
                <div class="modal-body" width="500px">

                	<?php echo $healthattributedescription[$counter]; ?>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
</div>	
<?php
					$counter++;
 					}
					echo '</table>';

	
	


			// ------------------ end of health list and the popup information associated --------------		
			

			?>



			
	<?php
	$result= mysql_query("SELECT * FROM `recipe_extranotes` WHERE recipe_id LIKE '$id'"); 
	$row = mysql_fetch_array($result);
	$extranotes = $row['extra_notes'];

	?>			
				


			
	<form action="<?php the_permalink(); ?>" name="savetopdf" method="POST">
	<input type="hidden" name="recipeimage" id="recipeimage" value="<?php echo $imagename; ?>">	
	<input type="hidden" name="recipeyield" id="recipeyield" value="<?php echo $servingsize; ?>">	
	<input type="hidden" name="recipedescription" id="recipedescription" value="<?php echo $desrciption; ?>">		
	<input type="hidden" name="recipenotes" id="recipenotes" value="<?php echo $extranotes; ?>">		
	<input type="hidden" name="recipename" id="recipename" value="<?php echo $recname; ?>">	
	<button style="margin-top:50px;" type="submit" type="button" name="submit" id="submit" class="btn btn-primary" id="pdfbutton">Save to PDF/Print </button>
	
	</form>		

	<form action="/recipesearch">
    <button style="margin-top:10px;" type="submit" type="button" name="submit" id="submit" class="btn btn-primary" id="search">Search recipes </button>
	</form>
	



		</div>


		

		
	 

			

						

		


		<div id="bottomheader">
			<img src="/wp-content/themes/twentythirteen/recipeimages/elegant-line-divider2.png">

			<!-- <h2>Serving Size: <?php echo $servingsize; ?></h2> -->
		</div>


	<div id="recipeinfocontainer" >

			<h2 style='text-align:left;'>Ingredients: </h2>
			<table>
				

	<?php
		// this grabs the ingredients
		$result= mysql_query("SELECT * FROM `recipe_recipeingredients` WHERE recipe_id LIKE '$id'"); 
		while($row = mysql_fetch_array($result)){
		$ingredientid[]=$row['ingredient_id'];
		$ingredientunit[]=$row['unittype'];
		$ingredientamt[]=$row['amount'];
		$ingredientaction[]=$row['actioninfo'];


		
		// array_push($ingredientarray, $test);

		}

		$counter=0;
		foreach ($ingredientid as $value) {
		$result= mysql_query("SELECT * FROM `recipe_ingredients` WHERE ingredient_id LIKE '$value'"); 
			while($row = mysql_fetch_array($result)){
			
			echo '<tr><td>'.(dectofrac($ingredientamt[$counter])).' '.$ingredientunit[$counter].$row['unittype'].' '.$row['ingredient_name'];
			
			}
			if (empty($ingredientaction[$counter]))  //this if statement will add brackets to the ingredient action if its not empty
				{
					echo ''.$ingredientaction[$counter].'</td></tr>';
				} else
				{
					echo ' (<strong>'.$ingredientaction[$counter].'</strong>)</td></tr>';
				}

			$counter++;
		}
			echo '</table> <br>';



		echo '<h2>Instructions:    </h2>  <table>';
		$result= mysql_query("SELECT * FROM `recipe_instructions` WHERE recipe_id LIKE '$id' ORDER BY step ASC"); 
		while($row = mysql_fetch_array($result)){
		echo '<tr><td> Step '.$row['step'].'. '.$row['step_description'].'</td></tr>';
		}	
		echo '</table> <br>';


		if (isset($extranotes))
		{
		echo '<h2>Extra Notes:</h2>  <table>';
		echo '<tr><td>'.$extranotes.'</td></tr>';
		echo '</table> <br>';
		}
		
			
//---------------------------linked recipe if any -------------------------------
		if ($linkedrecipe>0)
		{
		echo '<div id="linkedrecipediv">';	
		echo '<h2>Instructions for '.$linkedrecipename.':</h2>';

		// this grabs the ingredients
		$result= mysql_query("SELECT * FROM `recipe_recipeingredients` WHERE recipe_id LIKE '$linkedrecipe'"); 
		while($row = mysql_fetch_array($result)){
		$linkedingredientid[]=$row['ingredient_id'];
		$linkedingredientunit[]=$row['unittype'];
		$linkedingredientamt[]=$row['amount'];
		$linkedingredientaction[]=$row['actioninfo'];


		
		// array_push($ingredientarray, $test);

		}

		$counter=0;
		foreach ($linkedingredientid as $value) {
		$result= mysql_query("SELECT * FROM `recipe_ingredients` WHERE ingredient_id LIKE '$value'"); 
			while($row = mysql_fetch_array($result)){
			
			echo '<tr><td>'.(dectofrac($linkedingredientamt[$counter])).' '.$linkedingredientunit[$counter].$row['unittype'].' '.$row['ingredient_name'];
			
			}
			if (empty($linkedingredientaction[$counter]))  //this if statement will add brackets to the ingredient action if its not empty
				{
					echo ''.$linkedingredientaction[$counter].'</td></tr>';
				} else
				{
					echo ' (<strong>'.$linkedingredientaction[$counter].'</strong>)</td></tr>';
				}

			$counter++;
		echo '<br>';	
		}


		
			
				
				$result= mysql_query("SELECT * FROM `recipe_instructions` WHERE recipe_id LIKE '$linkedrecipe' ORDER BY step ASC"); 
					while($row = mysql_fetch_array($result))
					{
					echo '<table><tr><td> Step '.$row['step'].'. '.$row['step_description'].'</td></tr>';
					}	
			echo '</table> <br>';
		}


	
	echo '</div>';	
	?>

	<br><br>
<br>







</div> <!-- recipe main content -->



<div id="recipesidebar">





	<div id="sidebarcontentbanner">
		<h3>More Information:</h3>
	</div>		

	<p><?php echo "<strong>Recipe Added:</strong><br> $month $year" ?></p>
	<p><?php echo "<strong>Recipe Yield:</strong> $servingsize" ?></p>


<?php if (!empty($randrecipe1name)){ ?>
	<div id="sidebarcontentbanner">
		<h3>Related Recipes:</h3>
	</div>	


	
	<a href="/recipeview/?page=<?php echo $randrecipe1name; ?>">
	<p><?php echo $randrecipe1name; ?></p>
	<img width="237px" src="/wp-content/themes/twentythirteen/recipeimages/big/<?php echo $randrecipe1url; ?>"></a>
	<br>

	<?php if (!empty($randrecipe2name)){ ?>	
	<a href="/recipeview/?page=<?php echo $randrecipe2name; ?>">
	<p><?php echo $randrecipe2name; ?></p>
	<img width="237px" src="/wp-content/themes/twentythirteen/recipeimages/big/<?php echo $randrecipe2url; ?>"></a>
	<br>
	<?php } ?>

	<?php if (!empty($randrecipe3name)){ ?>	
	<a href="/recipeview/?page=<?php echo $randrecipe3name; ?>">
	<p><?php echo $randrecipe3name; ?></p>
	<img width="237px" src="/wp-content/themes/twentythirteen/recipeimages/big/<?php echo $randrecipe3url; ?>"></a>
	<?php } ?>
</div>

<?php } ?>


<?php 

if (isset($error)){

	echo $error;
}




 } ?> <!-- this is the closing bracket to detect if there is a recipe -->


	









		</div>
		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->





<?php get_footer(); ?>

