
<?php
/*
Template Name: tempcategory
*/

session_start();



get_header(); ?>
<script src="/wp-content/themes/twentythirteen/js/jquery.js"></script>
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

<link rel="stylesheet" type="text/css" href="/wp-content/themes/twentythirteen/js/jquery.asmselect.css" />



	<div id="primary" class="content-area">
	<div  role="main">
	<div class="container" id="addrecipepage">


		
	







		<!-- <img style="display: block;margin-left: auto; margin-right: auto;" src="/liberatedliving/wp-content/themes/twentythirteen/images/healthy.png">
 -->
		<h2 style="margin-bottom:-15px;">Add Recipe Category</h2>
		<h3 >Category Page</h3>

		
		<hr />

		<?php 
		
		$_SESSION['maincategory']=$_POST['maincategory'];
		$_SESSION['subcategory']=$_POST['subcategory'];
		$_SESSION['mainingredient']=$_POST['mainingredient'];
		$_SESSION['extranotes']=$_POST['extranotes'];
		$_SESSION['healthattributes']=$_POST['health'];

		// foreach($_SESSION['healthattributes'] as $city) {

		// 	// exclude any items with chars we don't want, just in case someone is playing
		// 	if(!preg_match('/^[-A-Z0-9\., ]+$/iD', $city)) continue; 

		// 	// print the city
		// 	echo htmlspecialchars($city);
		// }
		

		?>




		<!-- this is the maincategory loop -->

		<?php
		
			
			$query = "SELECT * FROM recipe_coursecategory";
			$result = mysql_query($query);
		?>

			<form id="entirecategoryform" action="<?php the_permalink(); ?>" method="post"> 



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
			<label for="health">Enter in your health considerations. (Not Required)</label>
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
						<label for="notes">Enter in any addition recipe notes. (Not Required)</label>  
						<br>
						<textarea rows="4" cols="35" name="extranotes"></textarea> 
						<br><br>
						<input type="submit" name="finishedinstructions" value="Upload Recipe">
						<br>
						</div>



					</form>
















		</div>	<!-- #container -->
		</div><!-- #content -->
		</div><!-- #primary -->

<script src="/wp-content/themes/twentythirteen/js/jquery.ui.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.asmselect.js"></script>
<script src="/wp-content/themes/twentythirteen/js/index.js"></script>	

<!-- <script type="text/javascript" src="jquery.js"></script> -->

<?php get_footer(); ?>

