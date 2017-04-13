<?php
/*
Template Name: nutritionquizresults
*/

get_header(); ?>

<!-- <script src="/wp-content/themes/twentythirteen/js/jquery.min.js"></script> -->
<!-- <script src="/wp-content/themes/twentythirteen/js/ZeroClipboard.min.js"></script> -->
<!-- <link rel="stylesheet" href="/wp-content/themes/twentythirteen/css/recipe.css" type="text/css" /> -->
<script src="/wp-content/themes/twentythirteen/js/jquery.validate.js"></script>




	<div id="primary" class="content-area">
		<div id="content" class="nutritioncontent" role="main">

		<div class="container">



<?php



if ( is_user_logged_in() ) {

	// echo 'Hello youre currently signed in as '.$current_user->display_name;
?>

<h2 style="margin-bottom:-15px;">Youre Health Self-Assessment Quiz Results</h2>
<h3 >Your answers are kept confidential and secure.</h3>
<hr />



<h2>Your Results:</h2>

<?php

echo $_POST['question1'].' '.$_POST['question2'].' '.$_POST['question3'];






?>













<?php

  } else {
    wp_redirect('/my-account-2');
      die();
} //end user logged in if


?>






		
<?php
get_footer(); ?>

