<?php
/*
Template Name: recipeadmin
*/

get_header(); 
?>

<script src="/wp-content/themes/twentythirteen/js/jquery-1.8.3.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.autocomplete.min.js"></script>
<link rel="stylesheet" href="/wp-content/themes/twentythirteen/js/autocompletestyle.css" type="text/css" />

<script src="/wp-content/themes/twentythirteen/js/showHide.js"></script>



	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">

			
	<?php
		if ( post_password_required( $post ) ) {
		echo get_the_password_form();    
		} else {
		?>			
		


		<div id="titlediv">

			<h2 style="margin-bottom:-15px;">Recipe Admin Panel</h2>
				<h3 >Click on one of the recipe options below.</h3>
			
		<hr />



				<a href="/recipeadd">Add Recipe</a><br>
				<a href="/recipemodify">Edit Recipe</a><br>
				<a href="recipedelete">Delete Recipe</a><br>
				<!-- <a href="/recipeviewall">View all Recipes</a><br> -->
				<a href="/recipesearch">Search Recipes</a><br>
				<a href="/recipemealplan">Create Meal Plan</a><br>
				<a href="/mealplanviewall">View Meal plans</a>


		</div> <!-- titlediv-->


			
			
<?php
} //this is the closing bracket for the password protect if
?>



		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->




<?php get_footer(); ?>

