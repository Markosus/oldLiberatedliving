<?php
/*
Template Name: recipeviewall
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">



		This are the results<br>

		<?php

		$result= mysql_query("SELECT * FROM `recipes`"); 
		while($row = mysql_fetch_array($result)){
		
		echo '<a href="/recipeview?page='.$row['recipe_name'].'">'.$row['recipe_name'].'</a><br>';
		}




		?>

		

		









































		
		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>

