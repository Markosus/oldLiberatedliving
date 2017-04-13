<?php
/*
Template Name: nutritionquiz
*/

get_header(); ?>

<style type="text/css">
	#phase2 {
		display: none;
	}

</style>

<!-- <script src="/wp-content/themes/twentythirteen/js/jquery.min.js"></script> -->
<!-- <script src="/wp-content/themes/twentythirteen/js/ZeroClipboard.min.js"></script> -->
<!-- <link rel="stylesheet" href="/wp-content/themes/twentythirteen/css/recipe.css" type="text/css" /> -->
<script src="/wp-content/themes/twentythirteen/js/jquery.validate.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery-1.8.3.js"></script>



	<div id="primary" class="content-area">
		<div id="content" class="nutritioncontent" role="main">

		<div class="container">



<?php




if ( is_user_logged_in() ) {


	// echo 'Hello youre currently signed in as '.$current_user->display_name;
?>

<script type="text/javascript">


	
	var test1, question2, question3, validate;


	function _(x){ 
			return document.getElementById(x);
	}

	function processphase1(){
			// test1 = _("poquestion1").value;
			
			// var selectedOption = $("input:radio[name=question3]:checked").val()
	 		//  alert (question1.getElementsByTagName('input:checked').length);
	 		totalquestions = (phase1.getElementsByTagName('input').length);	
	 		questionsperinput	= (question1.getElementsByTagName('input').length);
	 		numberofquestions = totalquestions/questionsperinput;
	 		var validate = $('input:radio:checked').length;	

	 	

	 

	  // alert(validate);

			// validate = $('input:radio:checked').length;
			if (validate >= numberofquestions){

				_("phase1").style.display = "none";
				// _("phase2").style.display = "block";
				$("#phase2").fadeIn(800);
				
					
			}else{
				alert ("Please fill in all the fields.");
			}

	

	}

	function submitForm(){
		_("nutritionform").method = "post";
		_("nutritionform").action = "/nutrition-quiz-results";
		_("nutritionform").submit();
	}

</script>

<h2 style="margin-bottom:-15px;">Liberated Living Health Assessment</h2>
<h3 >Your answers are kept confidential and secure.</h3>
<hr />

<div class="nutritionformcontainer">
<h2>PHYSICAL WELLNESS:</h2>

<form id="nutritionform" onsubmit="return false">
<div id="phase1">
<?php
	$questionnumber = 0;

	$query = mysql_query("SELECT * FROM `nutritionquestions`");

	while($row = mysql_fetch_array($query)){
	$questionnumber ++;	
	?>

	
			<div id="<?php echo 'question'.$questionnumber; ?>">	
			<h2><?php echo $row['question']; ?></h2>
			<ul>
		  <li>
		    <input type="radio" id="<?php echo 'poquestion'.$questionnumber; ?>" name="<?php echo 'question'.$questionnumber; ?>" value="10" required>
		   <label for="<?php echo 'poquestion'.$questionnumber; ?>">Poor</label>
		    
		    <div class="check"></div>
		  </li>
		  
		  <li>
		    <input type="radio" id="<?php echo 'flquestion'.$questionnumber; ?>" name="<?php echo 'question'.$questionnumber; ?>" value="20" required>
		    <label for="<?php echo 'flquestion'.$questionnumber; ?>">Flucuating</label>
		    
		    <div class="check"><div class="inside"></div></div>
		  </li>
		  
		  <li>
		    <input type="radio" id="<?php echo 'faquestion'.$questionnumber; ?>" name="<?php echo 'question'.$questionnumber; ?>" value="30" required>
		    <label for="<?php echo 'faquestion'.$questionnumber; ?>">Fair</label>
		    
		    <div class="check"><div class="inside"></div></div>
		  </li>

		  <li>
		    <input type="radio" id="<?php echo 'goquestion'.$questionnumber; ?>" name="<?php echo 'question'.$questionnumber; ?>" value="40" required>
		    <label for="<?php echo 'goquestion'.$questionnumber; ?>">Good</label>
		    
		    <div class="check"><div class="inside"></div></div>
		  </li>

		  <li>
		    <input type="radio" id="<?php echo 'exquestion'.$questionnumber; ?>" name="<?php echo 'question'.$questionnumber; ?>" value="50" required>
		    <label for="<?php echo 'exquestion'.$questionnumber; ?>">Excellent</label>
		    
		    <div class="check"><div class="inside"></div></div>
		  </li>
		</ul>
		</div> <!-- end question number	 -->

	<?php
	}

?>


<br><br><br><br>

<button id="btn" onclick="processphase1()">Continue</button>
</div> <!-- end phase1 -->

<div id="phase2">
		<h2>Test phase two</h2>
			<ul>
		  <li>
		    <input type="radio" id="fluc" name="questionphase2" value="10">
		   <label for="fluc">Flucuating</label>
		    
		    <div class="check"></div>
		  </li>
		  
		  <li>
		    <input type="radio" id="good" name="questionphase2" value="20">
		    <label for="good">Flucuating</label>
		    
		    <div class="check"><div class="inside"></div></div>
		  </li>
		  <button onclick="submitForm()">Submit Data</button>
</div> <!-- end phase2 -->

</form>



</div><!--  end nutrition container -->


<?php

	} else {
		wp_redirect('/my-account-2');
	    die();
} //end user logged in if


?>






		
<?php
get_footer(); ?>

