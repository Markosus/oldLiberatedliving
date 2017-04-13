<?php
/*
Template Name: recipemodify
*/

get_header(); 
session_start();

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



?>



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
										$_SESSION['updateid'] = $id;
										$recname=$row['recipe_name'];
										$_SESSION['recipe_name'] = $recname;
										$servingsize= $row['serving_size'];
										$maincategory = $row['recipe_category'];
										$subcategory = $row['recipe_subcategory'];
										$recipemainingredient = $row['recipe_main_ingredient'];
										$linkedrecipe = $row['linked_recipe_id'];
										$mealplan = $row['meal_plan'];

									}

									if ($mealplan == 1) {
										$mealplan ='Checked';

									}else{
										$mealplan='';
									}

									// this will convert the linked recipe id to a name	
									$queryl = mysql_query("SELECT * FROM recipes WHERE recipe_id LIKE '$linkedrecipe'");

										while($row = mysql_fetch_array($queryl))
										{
										$linkedrecipename=($row['recipe_name']);
										
										}
									if (!isset($linkedrecipename))
										{
											$linkedrecipename = "-- No link --";
											$linkedrecipe = 0;
										}
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
																								
											$counter++;
											}
										}
									}


									// ------------------ Grabs extra notes--------------

										$result= mysql_query("SELECT * FROM `recipe_extranotes` WHERE recipe_id LIKE '$id'"); 
										$row = mysql_fetch_array($result);
										$extranotes = $row['extra_notes'];


										// this grabs the ingredients
											$result= mysql_query("SELECT * FROM `recipe_recipeingredients` WHERE recipe_id LIKE '$id'"); 
											while($row = mysql_fetch_array($result)){
											$ingredientid[]=$row['ingredient_id'];
											$ingredientunit[]=$row['unittype'];
											$ingredientamt[]=$row['amount'];
											$ingredientaction[]=$row['actioninfo'];

											}


										// this grabs the description
									$result= mysql_query("SELECT * FROM `recipe_description` WHERE recipe_id LIKE '$id'"); 
										while($row = mysql_fetch_array($result)){
											$desrciption=$row['description'];
										}



			if ((!isset($id))&&(!isset($_POST['modifysubmit']))){         // ------------------ this checks to see if there is a recipe id or not --------------
									// echo '<h2>Sorry...no valid recipe has been selected.</h2>';
								
								// this prints a the list of recipes to the page and provides a link
								$result= mysql_query("SELECT * FROM `recipes`"); 

								echo '<a href="/recipeupload">Go to the Recipe Admin Panel</a><br><br>	';
								echo '<h2>Edit or modify a recipe below</h2>';	


								while($row = mysql_fetch_array($result)){
									echo '<a href="/recipemodify?page='.$row['recipe_name'].'">'.$row['recipe_name'].'</a><br>';
								}

			}


				// $_SESSION['ingredientsarray'] = array();	
				$numberofinstructionsinarray = count($_POST["instruction"]);
				$numberofingredientsinarray = count($_POST["ingredientname"]);

				


	// ------------------ this will update the recipe to the updated values --------------

			
					
					unset($_SESSION['instructionsarray']);
					unset($_SESSION['stepcount']);
					unset($_SESSION['count']);
					unset($_SESSION['ingredientsarray']);
					




	if (isset($_POST['modifysubmit'])) {


					
			

			$updateid  = $_POST['id'];	
			$name  = $_POST['rname'];
			
			$servingsize = $_POST['servingsize'];
			$recipelink = $_POST['linkedrecipe'];
			$maincat       = $_POST['maincategory'];
			$subcat    = $_POST['subcategory'];
			$mainingredient = $_POST['mainingredient']; 
			$description = $_POST['recipedescription'];
			$extranotes = $_POST['extranotes'];
			$healthattributes = $_POST['health'];
			$mealplan = $_POST['mealplan'];
			unset($_SESSION['errorvalue']);

			foreach($_POST['ingredientamount'] as $value){
					
				    fractodec($value);
					$ingredientamount[] = $decimalnumber;
				 }
			

			// $ingredientamount = $_POST['ingredientamount'];
			$ingredientunit = $_POST['ingredientunit'];
			$ingredientname = $_POST['ingredientname'];
			$ingredientaction = $_POST['ingredientaction'];

			

			

			$query = "UPDATE recipes SET recipe_name='$name',linked_recipe_id ='$recipelink', recipe_category='$maincat', recipe_subcategory='$subcat', recipe_main_ingredient='$mainingredient',serving_size='$servingsize',meal_plan ='$mealplan' WHERE recipe_id = '$updateid'";
			mysql_query($query);
			
			

			$query2 = "UPDATE recipe_description SET description ='$description' WHERE recipe_id = '$updateid'";
			mysql_query($query2);

			$query3 = "UPDATE recipe_extranotes SET extra_notes ='$extranotes' WHERE recipe_id = '$updateid'";
			mysql_query($query3);


			

			// ----------------------------   this is the loop to save the instructions into the session variable ----------------
			$i=1;
			foreach($_POST['instruction'] as $value)
					{
						if (!empty($value)){ 
						$_SESSION['instructionsarray'][$i] =$value;
						$i++;
						}
					}
			$i=$i-1;

			if ($_POST['stepcounter'] == $numberofinstructionsinarray) {
			 // echo 'they match';  update
			

					$stepcounter=1;
					foreach($_SESSION['instructionsarray'] as $value)
					{
							
					 	$instruction = $value;

						 $query4 = "UPDATE recipe_instructions SET step_description ='$instruction' WHERE recipe_id = '$updateid' AND step = '$stepcounter'";
						 mysql_query($query4);
					     $stepcounter++; 
					}

			}else{
			
			// echo 'they dont match'; delete and insert
			
					// for( $idel= 0 ; $idel <= $i ; $idel++ )
					// {
					$query4del = "DELETE FROM recipe_instructions WHERE recipe_id = '$updateid'";
					 mysql_query($query4del);
					//}


						$stepcounter=1;
						 foreach($_SESSION['instructionsarray'] as $value)
						 {
							$query4 = "INSERT INTO recipe_instructions (recipe_id,step,step_description)
		          			VALUES('$updateid','$stepcounter','$value')";
		        			mysql_query($query4);
						    $stepcounter++; 
						}


			}
			
			// --------------------  end the update instructions code-------------------------------------------
			// --------------------  start the health attribute  code-------------------------------------------
			
				$query5del = "DELETE FROM recipe_recipetohealth WHERE recipe_id = '$updateid'";
				mysql_query($query5del);
	
		
				
				if (isset($_POST['health'])){
				$counter2=0;
				 		
				 		foreach ($_POST['health'] as $value){	

						$result2= mysql_query("SELECT health_id FROM `recipe_healthattribute` WHERE healthattributename  LIKE '$value'"); 
						while($row = mysql_fetch_array($result2)){
						$healthid[]= $row['health_id'];

						}

						
						
				 	
					$query5 = "INSERT INTO recipe_recipetohealth (recipe_id,health_id)
          			VALUES('$updateid','$healthid[$counter2]')";
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


	
							// deletes the entries and reinserts whats there
							foreach($_SESSION['ingredientsarray'] as $value)
								{
									$query6del = "DELETE FROM recipe_recipeingredients WHERE recipe_id = '$updateid'";
									mysql_query($query6del);

								}	

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
						          	VALUES('$updateid','$ingredient_id','$amount','$unit','$action')";
									mysql_query($query7);
									$counter++;


								}	



									



									





			// --------------------  end the recipe ingredients  code-------------------------------------------	
				
			
			header("Location:/recipemodify");
		

	}





				 
			



	// ------------------ need to perform another update for the description, ingredients, health benefits  --------------











			if (!isset($id)){         // ------------------ this checks to see if there is a recipe id or not --------------
				// echo '<h2>Sorry...no valid recipe has been selected.</h2>';
				
			} else {					



								?>
					<a href="/recipemodify">Go Back to Modify Recipe List</a>	
					
					<br><br>		
						
						<?php
if (isset($id)){         // ------------------ this checks to see if there is a recipe id or not --------------


	// this saves the imagethumbnaik name to a variable
	$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$id'"); 
	while($row = mysql_fetch_array($result)){
	$imagename=$row['image_name_thumb'];
	}
	

	if (!isset($imagename)){
		$imagename='defaultimage_thumb.png';
		}
		
	?>


 <!--  this is part of this recipe image update form  -->



<div id="leftimageheaderthumb">
<img class="recipeimage"  src="/wp-content/themes/twentythirteen/recipeimages/recipethumb/<?php echo $imagename; ?>">
</div>
<hr />

<form action="<?php the_permalink(); ?>" method="post"  enctype="multipart/form-data">

<p>Update the image for the recipe. This will delete the old image. (Optional)</p>

<div id="formExample">
<label for="file">Browse Files:</label>
<input type="file" name="file" id="file" /> 
<br>
<input type="submit" value="Upload Image" name='uploadtrue'  />
</form>
</div> <!-- Form-->  
<br><br>
						

<!--  this is part of this recipe data update form  -->

						<form id="modifyrecipe" name="modifyrecipe" action="<?php the_permalink(); ?>" method="post" >

							
					    			<label for="rname">Recipe name. </label>  
								     <br>
								     <input name="rname" maxlength="500" value="<?php echo $recname ?>" size="24" required/>
								     <br><br>
								    
									<label for="recipedescription">Recipe description.</label>  
									<br>
									<textarea rows="6" cols="60" name="recipedescription" required><?php echo $desrciption  ?></textarea>
									 <br>
								     <br>
								    
									<label for="recipeservingsize">Serving size.</label>  
									<br>
									<input type="text" name="servingsize" maxlength="2" size="4" value="<?php echo $servingsize ?>" class="numbersonly">
									 <br>
								    <br>

								    	<label>Link to another recipe. (Not required)</label>
											<br>
											<select id="linkedrecipe" name="linkedrecipe">
											<option value="<?php echo $linkedrecipe; ?>"><?php echo $linkedrecipename; ?>  </option>
											<?php 
											if ($linkedrecipe>0){echo'<option value="0">-- No link --  </option>';}
											?>
											
										<?php
												$result = mysql_query("SELECT * FROM `recipes`");
													while($row = mysql_fetch_array($result)){
														if ($linkedrecipename != $row['recipe_name']){
														echo '<option value="'.$row['recipe_id'].'">'.$row['recipe_name'].'</option>';
														}
													}
													
										?>
											</select>
											<br><br><br>	
											<input type="checkbox" value="1" id="mealplan" name="mealplan" <?php echo $mealplan; ?>  />
											<label for="mealplan">Is this part of a meal plan?</label>
											<br><br><br>



								<div class="ingredient">
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
								   	<?php
									$counter=0;
									foreach ($ingredientid as $value) {
									$result= mysql_query("SELECT * FROM `recipe_ingredients` WHERE ingredient_id LIKE '$value'"); 
									while($row = mysql_fetch_array($result)){
										
										?>

										  <p class="text-boxi"><label for="box1i">#  <span class="box-numberi"><?php echo $counter + 1; ?></span></label> 
										  <input type="text" class="addrecipeamount" id="recipeamount"  name="ingredientamount[]" placeholder="Amt" maxlength="30" size="15" value="<?php echo (dectofrac($ingredientamt[$counter])) ?>" required>
								    	 <input type="text" name="ingredientunit[]" class="recipeunit" placeholder="Unit" maxlength="500" size="10"  value="<?php echo ($ingredientunit[$counter]) ?>">
								    	  <input type="text" name="ingredientname[]" placeholder="Ingredient Name" maxlength="500" size="20"  value="<?php echo ($row['ingredient_name']) ?>" class="autocompleteingredient" required>
								    	 <input type="text" name="ingredientaction[]" placeholder="Info/Action" class="autocomplete" id="autocomplete" size="14"   value="<?php echo ($ingredientaction[$counter]) ?>" >
								    	 <?php 
									   	  if ($counter > 0) {
									   	  	echo '<a href="#" class="remove-boxi">Remove</a></p>';
									   	  	} else {
									   	  		echo '<a class="add-boxi" href="#">Add Ingredient</a></p>';
									   	  	}

									   	  
									   	  ?>
								    	 <br>
								    	 <?php
								    $counter++;	 
									}
									
								}

									?>
								</div>

			
                    
                
                
       
  


								 
									<br>

								<div class="my-form">
								
									<?php
								    $result= mysql_query("SELECT * FROM `recipe_instructions` WHERE recipe_id LIKE '$id' ORDER BY step ASC"); 
									while($row = mysql_fetch_array($result)){

									
										$stepcounter++;
										?>

										<div style="clear:both"></div>									

									   	 <p class="text-box"><label for="box' + n + '">Step <span class="box-number"> <?php echo $stepcounter; ?></span></label>
									   	  <textarea rows="4" cols="35" name="instruction[]" ><?php echo $row['step_description'] ?></textarea>  
									   	  <?php 
									   	  if ($stepcounter > 1) {
									   	  	echo '<a href="#" class="remove-box">Remove</a></p>';
									   	  	} else {
									   	  		echo '<a class="add-box" href="#">Add Another Step</a>';
									   	  	}

									   	  
									   	  ?>

									   	<br><br> 
									   	
									<?php }
										?>
 								
								</div>
											
    



								   <?php
										
											
											$query = "SELECT * FROM recipe_coursecategory";
											$result = mysql_query($query);
										?>


																							


											<div id="maincategorydivshow">			
											<label for="health">Select Course Type</label>
											<br>	
											<select id='category' name="maincategory">

												<option value="<?php echo $maincategory ?>" selected><?php echo $maincategory ?></option>
										<?php
												while($row = mysql_fetch_array($result)){

														if ($row['coursename'] != $maincategory){;
														echo '<option value="'.$row['coursename'].'">'.$row['coursename'].'</option>';
														}
												}
										?>
											</select>
											</div>	



									<!-- 	this is the sub category loop -->

										<br>
										<?php
											$query = "SELECT *  FROM recipe_dishtypesubcategory";
											$result = mysql_query($query);
											
										?>
											<div id="subcategoryshow">
											<label>Select Dish Type</label>
											<br>	
											<select id="subcategory" name="subcategory">
											<option value="<?php echo $subcategory ?>" selected><?php echo $subcategory ?></option>
										<?php
												while($row = mysql_fetch_array($result)){
													if ($row['subcategoryname'] != $subcategory){;
														echo '<option value="'.$row['subcategoryname'].'">'.$row['subcategoryname'].'</option>';
													}	
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
											<div id="mainingredientshow" >
											<label>Whats the main ingredient in your recipe?</label>
											<br>
											<select id="mainingredient" name="mainingredient">
											<option value="<?php echo $recipemainingredient ?>" selected><?php echo $recipemainingredient ?></option>
										<?php
												while($row = mysql_fetch_array($result)){
														if ($row['mainingredientname'] != $recipemainingredient){;
														echo '<option value="'.$row['mainingredientname'].'">'.$row['mainingredientname'].'</option>';
														}
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
											
											<label for="health">Enter in the health benefits. (Not Required)</label>
											<select id="health" multiple="multiple" name="health[]" title="Click to Select a health consideration">
								 
										<?php
												while($row = mysql_fetch_array($result)){
														echo '<option ';

													if (isset($healthattributename))	{
														foreach($healthattributename as $value){
															if ($row['healthattributename'] == $value){;
															echo 'selected';
															}

														}	
													}


														echo ' value="'.$row['healthattributename'].'">'.$row['healthattributename'].'</option>';
														
												}
										?>
											</select>


												

												<br>	
												<label>Enter in any addition recipe notes. (Not Required)</label>  
												<br>
												<textarea rows="4" cols="35" name="extranotes"><?php echo $extranotes ?></textarea> 
												<br><br>
												<input type="hidden" name="stepcounter" value="<?php echo $stepcounter ?>">
												<input type="hidden" name="ingredientstepcounter" value="<?php echo $counter?>">
												<input type="hidden" name="id" value="<?php echo $id ?>">
												<input type="submit" name="modifysubmit" value="Update Recipe">
												<br>

								</form>

							

										
<?php 
}
?>




















<?php
}
?>

<?php


// this is where things get real and the image code starts

	
	$ImageName = $_FILES['file']['name'];
	$ImageSize = $_FILES['file']['size'];
	$ImageTempName = $_FILES['file']['tmp_name'];
	//Get File Ext   
	$ImageType = @explode('/', $_FILES['file']['type']);
	$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/twentythirteen/recipeimages/recipethumb/';	
	$uploaddirbig = $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/twentythirteen/recipeimages/big/';
	$newimagename = 'recipeimage_'.$_SESSION['updateid'];
	$newimagenamethumb = 'recipeimage_'.$_SESSION['updateid'].'_thumb';

	$type = $_POST['type']; //file type	
	$type2 = $ImageType[1];
//Set File name	
			$file_temp_name = $profile_id.'_original.'.md5(time()).'n'.$type; //the temp file name
			$fullpath = "$uploaddir/".$file_temp_name; // the temp file path
			$fullfile_name = "$newimagename.$type"; //$profile_id.'_temp.'.$type; // for the final resized image
			$fullpath_2 = "$uploaddir/".$file_name; //for the final resized image




if (isset($_POST['uploadtrue']))  {


	$oldfilename = $_FILES["file"]["tmp_name"];
	$oldsize = getimagesize($oldfilename);
	$oldimage_width = $oldsize[0];
	$oldimage_height = $oldsize[1];
	$type = $ImageType[1]; //file type
	$fullfile_name = "$newimagename.$type"; //$profile_id.'_temp.'.$type; // for the final resized image
	$newimagenamethumb = 'recipeimage_'.$_SESSION['updateid'].'_thumb';		

// echo "Upload: " . $_FILES["file"]["tmp_name"] . "<br />";
// echo "Upload: " . $_FILES["file"]["name"] . "<br />";
// echo "Type: " . $_FILES["file"]["type"] . "<br />";echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";



if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpng")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 25000000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }

if (file_exists("$uploaddir" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . "<br /> <h2>File already exists.</h2> ";
      }

      if (($oldimage_width < 340)||($oldimage_height < 389))
      {
         echo "<br /> <h2>The image is too small. Try a bigger image with larger dimensions.</h2> ";
      }
    else {
		//this part copies the image to the big image dir
		// move_uploaded_file($_FILES["file"]["tmp_name"],"$uploaddir" . $_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"],"$uploaddir" . "$fullfile_name");
		// echo "Stored in: " . "images Folder " . $_FILES["file"]["name"];
		// echo '<br />Upload Success';


		 //this takes the image from the big dir reizes it 
	  include('SimpleImage.php');

	 
	
 	 $imagebig = new SimpleImage();
  	 $imagebig->load("$uploaddir". "$fullfile_name");
	 //$imagebig->resize(500);

  	 	if ($oldimage_width > $oldimage_height)
  	 	{
  	 			$imagebig->resizeToHeight(400);
  	 			
  	 	} else
  	 	{
  	 			$imagebig->resizeToWidth(365);	
  	 			
  	 	}

  	 
  	 $imagebig->save("$uploaddirbig". "$fullfile_name");

  	 $imgSrc = '/wp-content/themes/twentythirteen/recipeimages/big/'. "$fullfile_name"; //this is the path and filename to the large image

	$formimagesize = getimagesize($_SERVER['DOCUMENT_ROOT']. $imgSrc);
	$formimagesize_width = $formimagesize[0];
	$formimagesize_height = $formimagesize[1];

	 

  	 ?>

  	 <?php 
  	 

  	 if($imgSrc){ //if an image has been uploaded display cropping area?>
    <script>
    	$('#Overlay').show();
		$('#formExample').hide();
		$('#titlediv').hide();
		
    </script>

    <div id="Overlay" style=" width:100%; height:100%; background-color:rgba(0,0,0,.4); border:0px #990000 solid; position:absolute; top:0px; left:0px; z-index:2000;"></div>
	

    <div id="CroppingContainer" style="width:<?php echo $formimagesize_width+80; ?>px; max-height:100%; background-color:#FFF; position:relative; overflow:hidden; border:2px #666 solid; margin:50px auto; z-index:2001; padding-bottom:40px;">  
    
        <div id="CroppingArea" style="width:<?php echo $formimagesize_width; ?>px; position:relative; overflow:hidden; margin:40px 40px 40px 40px; border:2px #666 solid;">	
            <img src="<?php echo $imgSrc; ?>" border="0" id="jcrop_target" style="border:0px #990000 solid; position:relative; margin:0px 0px 0px 0px; padding:0px; " />
        </div> 

        <div id="InfoArea" style="width:180px; height:150px; position:relative; overflow:hidden; margin:40px 0px 0px 40px; border:0px #666 solid; float:left;">	
           <p style="margin:0px; padding:0px; color:#444; font-size:18px;">          
                <b>Crop Recipe Image</b><br /><br />
                <span style="font-size:14px;">
                    Using this tool crop / resize your uploaded recipe image. <br />
                    Once you are happy with your recipe image then please click save.
                </span>
           </p>
        </div>  

        <br />
            <div id="CropImageForm" >  


               <form action="<?php the_permalink();?>" method="post" class="coords"
    onsubmit="return true;">
                 	<input type="hidden" id="x1" name="x1" /></label>
				    <input type="hidden" id="y1" name="y1" /></label>
				    <input type="hidden" id="x2" name="x2" /></label>
				    <input type="hidden" id="y2" name="y2" /></label>
                  	<input type="hidden" id="w1" name="w1" /></label>
    				<input type="hidden" id="h1" name="h1" /></label>
    				<input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="hidden" value="<?php echo $type; ?>" name="type" />  
                    <input type="hidden" value="<?php echo $imgSrc; ?>" name="src" />
                    <input type="submit" value="Crop Image" name='crop'   />
                    <input type="submit" value="Cancel" name="cancelimageupload"  />
                </form>



		
                
            </div>
            <!-- <div id="CropImageForm2" >  
                 <form action="<?php the_permalink();?>" method="post" onsubmit="return cancelCrop();">
                    <input type="submit" value="Cancel Crop" name="cancelimageupload"  />
                </form>


            </div>   -->      

          
    
            
    </div><!-- CroppingContainer -->
    <?php } ?>
















<?php
}
}

else
  {
  echo '<br />Invalid file';
  }


 
 }


if (isset($_POST['cancelimageupload']))  { //this will delete image if the user hits cancel

@unlink($uploaddirbig.$fullfile_name);
@unlink($uploaddir.$fullfile_name);


}

if ($_POST['x1']){

}


															
	




  
?>
<!-- #jcrop_target -->
<script type="text/javascript">

  jQuery(function($){

    var jcrop_api;
    

    $('#jcrop_target').Jcrop({
      onChange:   showCoords,
      onSelect:   showCoords,
      onRelease:  clearCoords,
      aspectRatio: 340/389, //keep aspect ratio
      setSelect: [0,0,340,389 ],
      allowSelect: false,
      allowMove: true,
    allowResize: false,
    },function(){
      jcrop_api = this;
    });

    $('#coords').on('change','input',function(e){



      var x1 = $('#x1').val(),
          x2 = $('#x2').val(),
          y1 = $('#y1').val(),
          y2 = $('#y2').val();
         
      jcrop_api.setSelect([x1,y1,x2,y2]);
    });

  });

 
  // Simple event handler, called from onChange and onSelect
  // event handlers, as per the Jcrop invocation above
  function showCoords(c)
  {
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#x2').val(c.x2);
    $('#y2').val(c.y2);
    $('#w1').val(c.w);
    $('#h1').val(c.h);


  };

  function clearCoords()
  {
    $('#coords input').val('');
  };



</script>





<?php
if (isset($_POST['crop']))  {



	//the file type posted
			$type = $_POST['type'];	
		//the image src
			$src = $uploaddirbig.$fullfile_name;	
			$finalname = $fullfile_name;	
			$fullfile_name2 = "$newimagename.$type";
			$fullfile_namethumb = "$newimagenamethumb.$type";

			// $oldimage_size = getimagesize($src);
						// $oldimage_width = $oldimage_size[0];
		 //    $oldimage_height = $oldimage_size[1];

				 $targ_w = $_POST['w1'];
				 $targ_h = $_POST['h1'];
			//quality of the output
				$jpeg_quality = 90;
			//create a cropped copy of the image
				$img_r = imagecreatefromjpeg($src); //old image
				$dst_r = imagecreatetruecolor( $targ_w, $targ_h ); //new image with needed dimensions
				
				imagecopyresampled($dst_r,$img_r,0,0,$_POST['x1'],$_POST['y1'],
				$targ_w,$targ_h,$_POST['w1'],$_POST['h1']);

				imagejpeg($dst_r, "$uploaddirbig".$fullfile_name2, 90);


				include('SimpleImage.php'); //this will create a thumbnail for the cropped picture and delete original files
				$thumb = new SimpleImage();
  	 			$thumb->load("$uploaddirbig".$newimagename.".$type");
				$thumb->resizeToWidth(100);
  	 			$thumb->save("$uploaddir". $newimagename."_thumb.$type");


  	 			// @unlink($uploaddirbig.$fullfile_name);
				@unlink($uploaddir.$fullfile_name);

				// this is related to the modify page...if it doesnt exist in the database add to the database
					$id=$_SESSION['updateid'];
					$result = mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id  = '$id'");
					$addtodatabaseboolean = mysql_num_rows($result);


					if ($addtodatabaseboolean == 0) {


						$query = "INSERT INTO recipe_images (recipe_id, image_name,image_name_thumb)
			          	VALUES('{$_SESSION['updateid']}','$fullfile_name2','$fullfile_namethumb')";
						mysql_query($query);

					}	

				unset($_SESSION['updateid']);	
				// header('location:'.the_permalink());
				header('Location:/recipemodify/?page='.$_SESSION['recipe_name']);
	}				
				

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
        var box_html = $('<p class="text-boxi"><label for="box' + n + '"># <span class="box-numberi">' + n + '</span></label> <input type="text" class="addrecipeamount" name="ingredientamount[]" placeholder="Amt" maxlength="30" size="15" value="" required><input type="text" name="ingredientunit[]" placeholder="Unit" maxlength="500" size="10"  value=""><input type="text" name="ingredientname[]" placeholder="Ingredient Name" maxlength="500" class="autocompleteingredient" size="20"  value="" required><input type="text" name="ingredientaction[]" class="autocomplete" placeholder="Info/Action"  size="14" value=""> <a href="#" class="remove-boxi">Remove</a></p>');
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

