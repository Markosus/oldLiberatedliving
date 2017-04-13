<?php
/*
Template Name: mealplanviewall
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">



		This are the results<br>

		<?php

		$result= mysql_query("SELECT * FROM `recipe_mealplan`"); 
		while($row = mysql_fetch_array($result)){
		
		echo '<a href="/mealplanview?page=id_'.$row['id'].'">'.$row['client_name'].'->'.$row['mealplan_name'].'</a><br>';
		}




		?>

		

		









































		
		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>

