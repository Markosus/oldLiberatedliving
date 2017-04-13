<?php
/*
Template Name: mealplanview
*/

get_header(); ?>

<!-- <script src="/wp-content/themes/twentythirteen/js/jquery.min.js"></script> -->
<!-- <script src="/wp-content/themes/twentythirteen/js/ZeroClipboard.min.js"></script> -->
<link rel="stylesheet" href="/wp-content/themes/twentythirteen/css/recipe.css" type="text/css" />
<script src="/wp-content/themes/twentythirteen/js/jquery.validate.js"></script>




	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">





<style>
#exampleTextarea { display: block; width: 99%; }
.span-message { display: none; }
</style>



    
 



		<?php



if ( post_password_required( $post ) ) {
echo get_the_password_form();    
} else {
				

		
		$getmealplanid = $_GET['page'];
		$number = explode("_", $getmealplanid);
		$id = $number[1];
		
		$result= mysql_query("SELECT * FROM `recipe_mealplan` WHERE id LIKE '$id'"); 
		while($row = mysql_fetch_array($result)){

			$mondaystring= $row['monday'];
			$tuesdaystring= $row['tuesday'];
			$wednesdaystring= $row['wednesday'];
			$thursdaystring= $row['thursday'];
			$fridaystring= $row['friday'];
			$saturdaystring= $row['saturday'];
			$sundaystring= $row['sunday'];			
			$uniquekey= $row['unique_key'];
			$clientname = $row['client_name'];
			$mealplanname = $row['mealplan_name'];
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

if ((!isset($id)) && (!isset($_POST['submit']))) {
	echo "Sorry there is no valid mealplan selected. You will be redirected to the admin panel.";
	header("Location:/mealplanviewall");
}else{
		
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



// ------------------ Begining of send recipe to the pdf file --------------

$instructionarray=array();
$ingredientnarray=array();

	if (isset($_POST['submit'])){

		// print_r($pdfrecipenotes);
		$content = 'sdf';
		$seperated_ingredientarray = implode("<br>", $ingredientnarray);
		$comma_separated = implode("<br>", $instructionarray);
		$pdfpath = $_SERVER['DOCUMENT_ROOT'];	

		
		
		$id = $_POST['id'];
		
		
		$result= mysql_query("SELECT * FROM `recipe_mealplan` WHERE id LIKE '$id'"); 
		while($row = mysql_fetch_array($result)){

			$mondaystring= $row['monday'];
			$tuesdaystring= $row['tuesday'];
			$wednesdaystring= $row['wednesday'];
			$thursdaystring= $row['thursday'];
			$fridaystring= $row['friday'];
			$saturdaystring= $row['saturday'];
			$sundaystring= $row['sunday'];			

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
		

		

		
		


			require_once ("$pdfpath/wp-content/themes/twentythirteen/dompdf/dompdf_config.inc.php"); 
			spl_autoload_register('DOMPDF_autoload'); 
			$dompdf = new Dompdf();
			$html_body="<!DOCTYPE html>
					<html>

					<style>
					.tftable {
						font-size:15px;
						color:#333333;
						width:100%;
						border-width: 3px;
						border-color: #729ea5;
						border-collapse: collapse;
					}

						.tftable th {
						font-size:15px;
						background-color:#0c6f69;
						border-width: 3px;
						padding: 9px;
						border-style: solid;
						border-color: white;
						text-align:center;
						color: white;
						font-weight: bold;
						

					}

					.tftable tr {
						background-color:#8F8F8F;
						color:white;
						line-height: 15px;

					}

					.tftable td {
						font-size:13px;
						border-width: 3px;
						padding: 8px;
						border-style: solid;
						border-color: white;
						text-align: center;
					}

					</style>

					<body>


					<h2>test Name</h2>
					
					<table class='tftable'>
					<tr><th>Day</th><th>Breakfast</th><th>Lunch</th><th>Dinner</th><th>Snack</th></tr>
					<tr><th>Monday</th><td>$mondaylist[0]</td><td>$mondaylist[1]</td><td>$mondaylist[2]</td><td>$mondaylist[3]</td></tr>
					<tr><th>Tuesday</th><td>$tuesdaylist[1]</td><td>$tuesdaylist[1]</td><td>$tuesdaylist[2]</td><td>$tuesdaylist[3]</td></tr>
					<tr><th>Wednesday</th><td>$mondaylist[1]</td><td>$wednesdaylist[1]</td><td>$wednesdaylist[2]</td><td>$wednesdaylist[3]</td></tr>
					<tr><th>Thursday</th><td>$thursdaylist[1]</td><td>$thursdaylist[1]</td><td>$thursdaylist[2]</td><td>$thursdaylist[3]</td></tr>
					<tr><th>Friday</th><td>$fridaylist[1]</td><td>$fridaylist[1]</td><td>$fridaylist[2]</td><td>$fridaylist[3]</td></tr>
					<tr><th>Saturday</th><td>$saturdaylist[1]</td><td>$saturdaylist[1]</td><td>$saturdaylist[2]</td><td>$saturdaylist[3]</td></tr>
					<tr><th>Sunday</th><td>$mondaylist[1]</td><td>$sundaylist[1]</td><td>$sundaylist[2]</td><td>$sundaylist[3]</td></tr>
					</table>
					


					</body>
					</html>";

					
       		 
			$dompdf->load_html($html_body);//body -> html content which needs to be converted as pdf..
       		

       		ob_end_clean();
			$dompdf->render();
 			 $dompdf->stream("testfdsf.pdf",array('Attachment'=>1));




		
	}


?>

<!--  ------------------ End of send recipe to the pdf file -------------- -->


<form action="<?php the_permalink(); ?>" name="savetopdf" method="POST">
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">	
	<button style="margin-top:50px;" type="submit" type="button" name="submit" id="submit" class="btn btn-primary" id="pdfbutton">Save to PDF/Print </button>
</form>		


	<button style="margin-top:50px;" type="submit" type="button" name="viewurl"  data-toggle='modal' data-target='#modal1' id="submitemail" class="btn btn-primary" id="pdfbutton">Show Client Link</button>
	
	





<div id="modal1" class="modal fade" tabindex="-1" role="dialog">
											        <div class="modal-dialog modal-md" >
											            <div class="modal-content">
											                <div class="modal-header">
											                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											                    <h4 class="modal-title"><legend>Meal plan URL:</legend></h4>
											                </div>
											                <div class="modal-body" >


											                	<p id="linkurl"><?php echo get_site_url().'/customermealplanview/?key='.$uniquekey; ?></p>
																									
																
											                </div>
											                <div class="modal-footer">

											                <table class="emailtoclienttable">
											                	<tr>
											                		<td class="emailtoclienttd">
											                			<form name="emailtoclientform" id="emailtoclientform" action="" method="GET">
													                   	<input type="text" class="emailtoclientinput" name="emailtoclientinput" size="20">
													                   	<input type="hidden" name="page" id="authour"  value="id_<?php echo $id; ?>"/>
													                   	<input type="submit" class="emailtoclientsubmit" value="Email URL to client">
													                   </form>	

											                		</td>
											                		<td class="emailtoclientcopy">
											                		 <button type="button" class="btn-copy">Copy to Clipboard</button> <span class="span-message">Copied!</span>
 	
											                		</td>
											                	</tr>
											                </table>

											                   

											                 

											            	</div>
											        </div>
											    </div>
											</div><!--  end modal -->



 
											                </div>





<?php

	if (isset($_GET['emailtoclientinput'])){
		
		$EmailFrom = "mark2002david@hotmail.com";
		$EmailTo = $_GET['emailtoclientinput'];
		$mealplanurlkey = get_site_url().'/customermealplanview/?key='.$uniquekey;


		$Body .= "Hi, $clientname";
		$Body .= "\n";
		$Body .= "\n";
		$Body .= "This email is to provide you with a digital link to access your mealplan from Liberated Living.";
		$Body .= "\n";
		$Body .= "This online mealplan will provide you with links to your online recipes for your convenience.";
		$Body .= "\n";
		$Body .= "\n";
		$Body .= "Link URL: ";
		$Body .= "\n";
		$Body .= $mealplanurlkey;
		$Body .= "\n";
		$Body .= "\n";
		$Body .= "If you have trouble viewing the provided link please let me know or if you have recieved this email in error.";
		$Body .= "\n";
		$Body .= "\n";
		$Body .= "Thanks from Liberated Living";

		$subject = get_bloginfo('name')." ".$getsubject.'Mealplan URL Code' ;

		

		$sent = wp_mail($EmailTo, $subject, $Body, $headers = '', $attachments = array());
		$sent ='asfas';

		if (isset($sent)){
			
			header("Location:/mealplanview/?page=id_$id&success=true");
		}else{

		}
		
	}
	

if (($_GET['success']) =='true'){	
	echo 'asdf';
}
?>






















<?php
} // closing bracket for the password protect
?>

		
		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->

<script>
// Function for initializing ZeroClipboard
function zcInit() {
  var client = new ZeroClipboard(jQuery('.btn-copy'));
  
  client.on('ready', function(event) {
    client.on('copy', function(event) {
      // `this` === `client`
      // `event.target` === the element that was clicked

      // Get the text content of <input> or <textarea> that comes immediately before the clicked button
      var $prevEle = jQuery(event.target).prev();
      // var text = $prevEle.is('textarea') ? $prevEle.val().replace(/\n/g, '\r\n') : $prevEle.val();
      var text = jQuery('#linkurl').html();
      // If value of `text` is not empty, set the data to clipboard
      if (text) {
        event.clipboardData.setData('text/plain', text);
      }
    });

    // Show a message when the text is copied
    client.on('aftercopy', function(event) {
      if (event.data['text/plain']) {
        jQuery(event.target).next().finish().fadeIn(30).fadeOut(1000);

      }
    });
  });
  
  client.on('error', function(event) {
    ZeroClipboard.destroy();
  });
}

// Function for copying text using window.clipboardData
function addHandler_WinClipData() {
  jQuery('.btn-copy').click(function() {
    var $prevEle = jQuery(this).prev();
    // var text = $prevEle.is('textarea') ? $prevEle.val().replace(/\n/g, '\r\n') : $prevEle.val();
    var text = jQuery('#linkurl').html();
    // If value of `text` is not empty, set the data to clipboard
    if (text && window.clipboardData.setData('Text', text)) {
      // Show a message when the text is copied
      // jQuery(this).next().finish().fadeIn(30).fadeOut(1000);
      var test = jQuery('.btn-copy').html();
      jQuery('.btn-copy').html('Copied');
      window.setTimeout(function() {
        jQuery('.btn-copy').html('Copy to Clipboard');
    	}, 1000);
    }
  });
}

// Function for pop up a message and select text in <input> or <textarea>, in case window.Clipboard data and Flash are not available
function addHandler_AlertMsg() {
  jQuery('.btn-copy').click(function() {
    if (jQuery(this).prev().val()) {
      alert('No Flash installed. Please copy manually');
      jQuery(this).prev().focus().select();
    }
  });
}

// Function for checking Flash availability
function detectFlash() {
  var hasFlash = false, obj, types, type;
  try {
    obj = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
    if (obj) {
      hasFlash = true;
    }
  } catch(e) {
    types = navigator.mimeTypes;
    type = 'application/x-shockwave-flash';
    if (types && types[type] && types[type].enabledPlugin) {
      hasFlash = true;
    }
  }
  return hasFlash;
}

var hasWinClipData = !!(window.clipboardData && clipboardData.setData),
  hasFlash = detectFlash();

if (hasWinClipData) {   // Check if window.clipboardData is available
  addHandler_WinClipData();
} else if (hasFlash) {  // Check if Flash is available
  jQuery.ajax({
    type: 'GET',
    url: 'http://cdnjs.cloudflare.com/ajax/libs/zeroclipboard/2.2.0/ZeroClipboard.min.js',
    dataType: 'script',
    cache: true,
    success: zcInit,
    error: addHandler_AlertMsg
  });
} else {  // In case window.clipboardData and Flash are not available, bind a "click" event handler to the "copy buttons" to pop up a message when clicked
  addHandler_AlertMsg();
}
</script>	


<script type="text/javascript">

jQuery( "#emailtoclientform" ).validate({

  rules: {

    emailtoclientinput: {

      required: true,

      email: true

    }

  }

});



</script>



<?php 
} //this is the closing bracket for the check to see if id exists if

get_footer(); ?>

