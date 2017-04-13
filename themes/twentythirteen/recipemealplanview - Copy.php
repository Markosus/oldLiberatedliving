<?php
/*
Template Name: clientmealplanview
*/

get_header(); ?>

<link rel="stylesheet" href="/wp-content/themes/twentythirteen/css/recipe.css" type="text/css" />

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">



		






		<?php


	$getmealplankey = $_GET['key'];
				
		
		
		$result= mysql_query("SELECT * FROM `recipe_mealplan` WHERE unique_key LIKE '$getmealplankey'"); 
		while($row = mysql_fetch_array($result)){

			$mondaystring= $row['monday'];
			$tuesdaystring= $row['tuesday'];
			$wednesdaystring= $row['wednesday'];
			$thursdaystring= $row['thursday'];
			$fridaystring= $row['friday'];
			$saturdaystring= $row['saturday'];
			$sundaystring= $row['sunday'];			
			$uniquekey= $row['unique_key'];
		}	
	
		$mondayarray = explode(",", $mondaystring);
		$tuesdayarray = explode(",", $tuesdaystring);
		$wednesdayarray = explode(",", $wednesdaystring);
		$thursdayarray = explode(",", $thursdaystring);
		$fridayarray = explode(",", $fridaystring);
		$saturdayarray = explode(",", $saturdaystring);
		$sundayarray = explode(",", $sundaystring);

	 	$mondaylist=array();
	 	$tuesdaylist=array();
	 	$wednesdaylist=array();
	 	$thursdaylist=array();
	 	$fridaylist=array();
	 	$saturdaylist=array();
	 	$sundaylist=array();	
		
			
	foreach ($mondayarray as $value) {
			$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$value'");
			$row = mysql_fetch_array($result);
			$mondaylist[] = $row['recipe_name'];	

	}

		foreach ($tuesdayarray as $value) {
			$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$value'");
			$row = mysql_fetch_array($result);
			$tuesdaylist[] = $row['recipe_name'];	

	}

		foreach ($wednesdayarray as $value) {
			$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$value'");
			$row = mysql_fetch_array($result);
			$wednesdaylist[] = $row['recipe_name'];	

	}

		foreach ($thursdayarray as $value) {
			$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$value'");
			$row = mysql_fetch_array($result);
			$thursdaylist[] = $row['recipe_name'];	

	}

		foreach ($fridayarray as $value) {
			$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$value'");
			$row = mysql_fetch_array($result);
			$fridaylist[] = $row['recipe_name'];	

	}

		foreach ($saturdayarray as $value) {
			$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$value'");
			$row = mysql_fetch_array($result);
			$saturdaylist[] = $row['recipe_name'];	

	}

		foreach ($sundayarray as $value) {
			$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$value'");
			$row = mysql_fetch_array($result);
			$sundaylist[] = $row['recipe_name'];	

	}
		
		




// $character_array = array_merge(range(a, z), range(0, 9));
// $string = "";
//     for($i = 0; $i < 10; $i++) {
//         $string .= $character_array[rand(0, (count($character_array) - 1))];
//     }
// echo $string;
		
echo '<table class="tftable" border="1">';
echo '<tr><th>Day</th><th>Breakfast</th><th>Lunch</th><th>Dinner</th><th>Snack</th></tr>';
echo '<tr><th>Monday</th><td><a href="/recipeview?page='.$mondaylist[0].'" target="_blank">'.$mondaylist[0].'</a></td><td>'.$mondaylist[1].'</td><td>'.$mondaylist[2].'</td><td>'.$mondaylist[3].'</td></tr>';
echo '<tr><th>Tuesday</th><td><a href="/recipeview?page='.$tuesdaylist[0].'" target="window">'.$tuesdaylist[0].'</a></td><td>'.$tuesdaylist[1].'</td><td>'.$tuesdaylist[2].'</td><td>'.$tuesdaylist[3].'</td></tr>';
echo '<tr><th>Wednesday</th><td><a href="/recipeview?page='.$wednesdaylist[0].'" target="window">'.$wednesdaylist[0].'</a></td><td>'.$wednesdaylist[1].'</td><td>'.$wednesdaylist[2].'</td><td>'.$wednesdaylist[3].'</td></tr>';
echo '<tr><th>Thursday</th><td><a href="/recipeview?page='.$thursdaylist[0].'" target="window">'.$thursdaylist[0].'</a></td><td>'.$thursdaylist[1].'</td><td>'.$thursdaylist[2].'</td><td>'.$thursdaylist[3].'</td></tr>';
echo '<tr><th>Friday</th><td><a href="/recipeview?page='.$fridaylist[0].'" target="window">'.$fridaylist[0].'</a></td><td>'.$fridaylist[1].'</td><td>'.$fridaylist[2].'</td><td>'.$fridaylist[3].'</td></tr>';
echo '<tr><th>Saturday</th><td><a href="/recipeview?page='.$saturdaylist[0].'" target="window">'.$saturdaylist[0].'</a></td><td>'.$saturdaylist[1].'</td><td>'.$saturdaylist[2].'</td><td>'.$saturdaylist[3].'</td></tr>';
echo '<tr><th>Sunday</th><td><a href="/recipeview?page='.$sundaylist[0].'" target="window">'.$sundaylist[0].'</a></td><td>'.$sundaylist[1].'</td><td>'.$sundaylist[2].'</td><td>'.$sundaylist[3].'</td></tr>';
echo '</table>';
		

// echo '<a href="/recipeview?page='.$mondaylist[0].'" target="window">'.$mondaylist[0].'</a>';




?>
		
		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>

