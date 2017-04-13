<?php
/*
Template Name: add Recipe
*/

session_start();



get_header(); ?>




<!-- <script src="/wp-content/themes/twentythirteen/js/jquery-2.1.1.js"></script>  -->
<!-- <script src="/wp-content/themes/twentythirteen/js/jquery.js"></script> -->
<script src="/wp-content/themes/twentythirteen/js/jquery-1.8.3.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.autocomplete.min.js"></script>
<script src="/wp-content/themes/twentythirteen/js/recipe.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.ui.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.asmselect.js"></script>
<link rel="stylesheet" href="/wp-content/themes/twentythirteen/js/autocompletestyle.css" type="text/css" />

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
	$(function(){
  var ingredientverb = [
    	<?php  

    	$result= mysql_query("SELECT * FROM `recipe_ingredientinfoverb`"); 
			while($row = mysql_fetch_array($result)){
			echo "{ value: '".$row['ingredientinfo_verb']."' },";
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


<!-- this script disables the next step button if nothing is entered -->
<script type="text/javascript">



function checkifempty(){
if ((document.addingredient.iname.value=='')||(document.addingredient.amount.value==''))
document.addingredient.addingredsubmit.disabled=true
else
document.addingredient.addingredsubmit.disabled=false
}
if (document.all || document.getElementById)
setInterval("checkifempty()",100)
</script>

<!-- this script disables the next step button if nothing is entered -->
<script type="text/javascript">
function checkifempty2(){
if (document.addstep.instruction.value=='')
document.addstep.addstepbutton.disabled=true
else
document.addstep.addstepbutton.disabled=false
}
if (document.all || document.getElementById)
setInterval("checkifempty2()",100)
</script>

<script type="text/javascript">
function checkifempty3(){
if ((document.formnamedescripsize.rname.value=='')||(document.formnamedescripsize.recipedescription.value=='')||(document.formnamedescripsize.servingsize.value==''))
document.formnamedescripsize.buttonnamedescripsize.disabled=true
else
document.formnamedescripsize.buttonnamedescripsize.disabled=false
}
if (document.all || document.getElementById)
setInterval("checkifempty3()",100)
</script>


<link rel="stylesheet" type="text/css" href="/wp-content/themes/twentythirteen/js/jquery.asmselect.css" />

<?php



// function dectofrac($n, $tolerance = 1.e-6) {
//     $h1=1; $h2=0;
//     $k1=0; $k2=1;
//     $b = 1/$n;
//     do {
//         $b = 1/$b;
//         $a = floor($b);
//         $aux = $h1; $h1 = $a*$h1+$h2; $h2 = $aux;
//         $aux = $k1; $k1 = $a*$k1+$k2; $k2 = $aux;
//         $b = $b-$a;
//     } while (abs($n-$h1/$k1) > $n*$tolerance);

//     return "$h1/$k1";
// }

// printf("%s\n", dectofrac(1.333333)); # 200/3


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



// fractodec('1 2/3');



// \d+\/\d+ will grab the fraction
// [a-zA-Z]+  will grab the word
// \d+.\d+ any decimal number 
// \d+.\d+|[a-zA-Z]+|\d+\/\d+|\d+
// \d+.\d+\/\d+
//\d+\d+|\d+ breaks up a fraction

// $string="5.5552Cups";

function splitamount($amountstring) {
preg_match_all('/\d+.\d+\/\d+|\d+.+\d+|[a-zA-Z]+|\d+\/\d+|\d+/', $amountstring, $match);
global $unit;
global $num;
$unit = $match[0][1];
$num = $match[0][0];
}



if (!isset($_SESSION['recipename'])){       //if the session recipe variable is not set, then set it to the submit button value
$_SESSION['recipename']= $_POST['rname'];
$recipename=$_SESSION['recipename'];

$_SESSION['servingsize']= $_POST['servingsize'];
$_SESSION['recipedescription']= $_POST['recipedescription'];
}

if (empty($_SESSION['recipename'])){  //if the session recipe name is blank then unset it
unset($_SESSION['recipename']);
}

if (empty($_SESSION['linkedrecipe'])){  //if the session recipe name is blank then unset it
unset($_SESSION['linkedrecipe']);
}


if (isset($_POST['cancel'])){   //if the user hits start over, unset the session
unset($_SESSION['recipename']);
unset($_SESSION['recipedescription']);	
unset($_SESSION['servingsize']);	
unset($_SESSION['name']);
unset($_SESSION['amt']);
unset($_SESSION['ingredandamount']);
unset($_SESSION['instruct']);
unset($_SESSION['viewtextareabool']);
unset($_SESSION['ingredandamount']);
unset($_SESSION['instruct']);
unset($_SESSION['viewtextareabool']);
unset($_SESSION['extranotes']);
unset($_SESSION['maincategory']);
unset($_SESSION['subcategory']);
unset($_SESSION['mainingredient']);
unset($_SESSION['healthattributes']);
unset($_SESSION['finishedinstructionsbool']);
unset($_SESSION['decimalamt']);	

unset($_SESSION['ingredientaction']);	
// unset($_SESSION['amtingredientaction']);
unset($_SESSION['linkedrecipe']);

unset($_SESSION['ingredienamttaction']);
}







if (!isset($_SESSION['name'])){   //if the session ingredient session array doesnt exist then set it
$_SESSION['name']=array();
}

// if (!isset($_SESSION['linkedrecipe'])){   //if the session ingredient session array doesnt exist then set it
// $_SESSION['linkedrecipe']=array();
// }

$amount= $_POST['amount']; //set the amount vaiable to the user ingredient input
$ingredient= $_POST['iname']; //set the ingredient vaiable to the user ingredient input
$ingredientaction = $_POST['ingredientaction'];

if (!isset($_SESSION['amt'])){   //if the session amount session array doesnt exist then set it
$_SESSION['amt']=array();
$_SESSION['decimalamt']=array();
$_SESSION['amountunit']=array();

$_SESSION['ingredientaction']=array();
$_SESSION['amtingredientaction']=array();
$_SESSION['ingredienamttaction']=array();
}



if ((!empty($amount))&&(!empty($ingredient))){

	$_SESSION['ingredandamount'][$amount] = $ingredient; //this will add it to array with a key/value
	array_push($_SESSION['amt'], $amount);  //if amount is not empty add to array
	splitamount($amount); //$unit/num..This function seperates the amount into the number and the unit into two variables
	fractodec($num); //outputs the decimal to the variable $decimalnumber
	array_push($_SESSION['decimalamt'], $decimalnumber); //decimal array
	array_push($_SESSION['amountunit'], $unit);
	array_push($_SESSION['name'], $ingredient);

	array_push($_SESSION['ingredientaction'], $ingredientaction);
 	// $_SESSION['amtingredientaction'][$amount] = array($ingredient => $ingredientaction ); 
 	$_SESSION['ingredienamttaction'][$ingredient] = array($amount => $ingredientaction ); 
	 header('location:'.the_permalink()); //this reloads the page the the POST Data gets cleared so a page refresh wont resend data
}

$instruction = $_POST['instruction']; //set the instruction vaiable to the user ingredient input

if (!isset($_SESSION['instruct'])){   //if the session instruct session array doesnt exist then set it
$_SESSION['instruct']=array();
}


if (!empty($instruction)){ 
array_push($_SESSION['instruct'], $instruction);  //if instruction is not empty add to array
header('location:'.the_permalink());
}




if (isset($_POST['next'])){  //this is a boolean for whether to make the text area visiable or not
	$_SESSION['viewtextareabool']=1;
}

if (isset($_POST['finishedinstructions'])){  //this is a boolean for whether to make the text area visiable or not
	$_SESSION['finishedinstructionsbool']=1;
}

if (!empty($_SESSION['instruct'])){  //this will enable the disabled next step but for the add instructions
	$_SESSION['enablebutton']='';
	} else {
	$_SESSION['enablebutton']='disabled';
}

if (!empty($_SESSION['ingredandamount'])){  //this will enable the disabled next step but for the add instructions
	$_SESSION['enablebutton2']='';
	} else {
	$_SESSION['enablebutton2']='disabled';
}


$_SESSION['maincategory']=$_POST['maincategory'];
$_SESSION['subcategory']=$_POST['subcategory'];
$_SESSION['mainingredient']=$_POST['mainingredient'];
$_SESSION['extranotes']=$_POST['extranotes'];
$_SESSION['healthattributes']=$_POST['health'];

if (isset($_POST['linkedrecipe'])){
$_SESSION['linkedrecipe']=$_POST['linkedrecipe'];
}
// foreach($_SESSION['healthattributes'] as $city) {

// 	// exclude any items with chars we don't want, just in case someone is playing
// 	if(!preg_match('/^[-A-Z0-9\., ]+$/iD', $city)) continue; 

// 	// print the city
// 	echo htmlspecialchars($city);
// }		
		
	
		




get_header(); ?>

	<div id="primary" class="content-area">
		<div  role="main">



		<div class="container" id="addrecipepage">

		<!-- // this is the if for the password protection -->	
		<?php
		if ( post_password_required( $post ) ) {
		echo get_the_password_form();    
		} else {
		?>	



		<!-- <img style="display: block;margin-left: auto; margin-right: auto;" src="/liberatedliving/wp-content/themes/twentythirteen/images/healthy.png">
 -->
		<h2 style="margin-bottom:-15px;">Add Recipe</h2>
		<h3 >Fill in the form below to add your recipe to the database</h3>
		<a href="/recipeupload">Go to the Recipe Admin Panel</a><br><br>	
		<h2>Edit or modify a recipe below</h2>	
	
<hr />




		<div class="row">

				<div class="col-lg-7">
					
				
						<?php
							
							if (empty($_SESSION['recipename'])){
						?>
								<form action="<?php the_permalink(); ?>" method="POST" name="formnamedescripsize">

								     <label>Enter the recipe name. </label>  
								     <br>
								     <input type="text" name="rname" maxlength="500" size="50"/>
								     <br><br>
								    
									<label>Enter the recipe description.</label>  
									<br>
									<textarea rows="4" cols="50" name="recipedescription"></textarea>
									 <br>
								     
									 <br>
								    
									<label>Enter the serving size.</label>  
									<br>
									<input type="text" name="servingsize" maxlength="2" size="4"/>
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
											<br><br>




								    <input type="submit" value="Next" name="buttonnamedescripsize">



								</form>


						<?php
							}
						?>
							
						<?php
							
							if ((!empty($_SESSION['recipename']))&&(!isset($_POST['next']))){
								if (!isset($_SESSION['viewtextareabool'])){

						?>
								<form action="<?php the_permalink(); ?>" name="addingredient" method="POST"> 

									<input type="text" class="addrecipeamount" name="amount" placeholder="Amt" maxlength="15" size="4">
								     <input type="text" name="iname" placeholder="Ingredient Name" maxlength="500" size="14" />
								     <input type="text" name="ingredientaction" placeholder="Info/Action" class="biginput" id="autocomplete" size="14" >
								    <input type="submit" value="Add Ingredient" name="addingredsubmit">
								    <input type="submit" name="next" value="Next" <?php echo $_SESSION['enablebutton2'];?> >
								   <br><br> <hr />
								 </form>

						<?php
							}}
						?>

						
						<?php
							
							if ((isset($_POST['next']))||(isset($_POST['addstepbutton']))||(isset($_SESSION['viewtextareabool']))&&(!isset($_SESSION['finishedinstructionsbool']))){
							
						?>

								<form action="<?php the_permalink(); ?>" method="POST" name="addstep">    
								     <textarea rows="4" cols="35" name="instruction"></textarea> 
								    <input type="submit" name="addstepbutton" value="Add Step">
								    <input type="submit" name="finishedinstructions" value="Next Step" <?php echo $_SESSION['enablebutton'];?> >
								   <br><br> <hr />
								 </form>

						<?php
							}
						?>

						<?php
							 // start of category code
							if (isset($_POST['finishedinstructions'])){
						?>		

									<!-- this is the maincategory loop -->

										<?php
										
											
											$query = "SELECT * FROM recipe_coursecategory";
											$result = mysql_query($query);
										?>


											<form id="entirecategoryform" action="<?php the_permalink(); ?>" method="post"> 

												


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

										<!-- </form> -->
										


														
									
														<div id="notes" style="display:none;">
														<label>Enter in any addition recipe notes. (Not Required)</label>  
														<br>
														<textarea rows="4" cols="35" name="extranotes"></textarea> 
														<br><br>
														<input type="submit" name="submitcategoryinfo" value="Next Step">
														<br>
														</div>





													</form> <!-- end of category code -->


						<?php
								}	


						?>







						<?php
							
							if (!empty($_SESSION['recipename'])){
						?>
								<form action="<?php the_permalink(); ?>" method="POST">    
								
								    
								    <input type="submit" name="cancel"value="Start Over">
								</form>

						<?php
							}
						?>

						<?php
							
							if (!empty($_SESSION['maincategory'])){
						?>
								<br>
								<form action="/recipeupload" method="POST">    
												    
								    <input type="submit" name="upload"value="Upload to Database">
								</form>

						<?php
							}
						?>



				</div> <!-- end span4-->

			

				<div class="col-lg-5">

				<?php
$queryl = mysql_query("SELECT * FROM recipes WHERE recipe_id LIKE '{$_SESSION['linkedrecipe']}'");

	while($row = mysql_fetch_array($queryl))
	{
	$linkedrecipename=($row['recipe_name']);
	}





echo '<strong>Recipe Name: </strong>'. $_SESSION['recipename'].'<br> ';
echo '<strong>Serving Size: </strong>'. $_SESSION['servingsize'].'<br>';
echo '<strong>Description: </strong>'. $_SESSION['recipedescription'].'<br><br> ';
echo '<strong>Linked Recipe: </strong>'. $linkedrecipename.'<br><br>';







// echo '<strong>Ingredient List: </strong> <br> ';
// foreach($_SESSION['amtingredientaction'] as $key => $val){
//   echo "$key ";
//   	foreach($val as $amt => $value){
//   		echo "$amt ( $value )<br/>\n";

  
  
// 	}
  
// }


foreach($_SESSION['ingredienamttaction'] as $key => $val){
  $test = $key;
  	foreach($val as $amt => $value){
  		echo "$amt $test ( $value )<br/>\n";

  
  
	}
  
}


		
		
		if (isset($_SESSION['instruct'])){
			echo '<br><strong>Procedure: </strong>';
		// print_r($_SESSION['ingredandamount']);
			$counter=0;
			echo'<br>';
				foreach($_SESSION['instruct'] as $value){
					$counter++;
				     echo "Step $counter. $value <br/>\n";

				 }
		}


		if (isset($_POST['submitcategoryinfo'])){
		echo "<br />";
		echo '<strong>Main Category: </strong> '. $_SESSION['maincategory'];
		echo "<br />".'<strong>Dish Type:</strong> '. $_SESSION['subcategory'];
		echo "<br />".'<strong>Main Ingredient:</strong> '. $_SESSION['mainingredient'];

			if (isset($_SESSION['healthattributes'])){
				echo "<br /><br> <strong>Selected Health information:</strong>";
					foreach($_SESSION['healthattributes'] as $healthconcern) {

					// exclude any items with chars we don't want, just in case someone is playing
					if(!preg_match('/^[-A-Z0-9\., ]+$/iD', $healthconcern)) continue; 

					// print the city
					echo "\n\t<li>" . htmlspecialchars($healthconcern) . "</li>";
					}
			}

			if (!empty($_SESSION['extranotes'])){	
				echo "<br />".'<strong>Additional Notes:</strong> '. $_SESSION['extranotes'];
			}
		  }  










} //this is the closing bracket for the password protect if
?>
					










				</div> <!-- end span4 -->





		</div> <!-- end row -->
















		</div>	<!-- #container -->
		</div><!-- #content -->
		</div><!-- #primary -->



			
<?php get_footer(); ?>

