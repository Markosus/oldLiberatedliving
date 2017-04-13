<?php
/*
Template Name: recipeupload
*/

get_header(); ?>


<script src="/wp-content/themes/twentythirteen/js/jquery.min.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" href="/wp-content/themes/twentythirteen/js/jquery.Jcrop.css" type="text/css" />


<!-- #jcrop_target -->






	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">
<!-- // this is the if for the password protected content -->
<?php
if ( post_password_required( $post ) ) {
echo get_the_password_form();    
} else {
?>


<?php
	session_start();

// clears all the session variables

// unset($_SESSION['recipename']);

// unset($_SESSION['rec_id']);					 


?>


<?php
if (!isset($_SESSION['rec_id'])){


	header("Location:/recipeadmin");	


}

	// this is going to add another check to make sure the recipe
	// exists in the database before allowing the upload picture to proceed.
	$id=$_SESSION['rec_id'];
	$result = mysql_query("SELECT * FROM `recipes` WHERE recipe_id  = '$id'");
	$addpictureboolean = mysql_num_rows($result);

	// if ($addpictureboolean == 0) {

	// 	unset($_SESSION['rec_id']);
	// 	header("Location:/recipeupload");	
	// }


	// if the cancelpicture botton is pressed is will delete the id from the session and reload page
	if (isset($_POST['noimage'])) {
		unset($_SESSION['rec_id']);
		header("Location:/recipeupload");		
	}


?>

	

<?php
if (isset($_SESSION['rec_id'])&&($addpictureboolean == 1)){

?>

<div id="titlediv">

	<h2 style="margin-bottom:-15px;">Youre almost complete!</h2>
		<h3 >You just need to upload a picture.</h3>
	
<hr />


	
</div> <!-- titlediv-->




<form action="<?php the_permalink(); ?>" method="post"  enctype="multipart/form-data">

<p>You still need to choose an image for the last recipe you added to the database.</p>

<div id="formExample">
<label for="file">Browse Files:</label>
<input type="file" name="file" id="file" /> 
<br>
<input type="submit" value="submit" name='uploadtrue'  />
<input type="submit" value="Use a default Image Instead" name='noimage'  />
</form>
</div> <!-- Form-->  

<?php
}
?>

<?php




	
	$ImageName = $_FILES['file']['name'];
	$ImageSize = $_FILES['file']['size'];
	$ImageTempName = $_FILES['file']['tmp_name'];
	//Get File Ext   
	$ImageType = @explode('/', $_FILES['file']['type']);
$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/twentythirteen/recipeimages/recipethumb/';	
$uploaddirbig = $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/twentythirteen/recipeimages/big/';
$newimagename = 'recipeimage_'.$_SESSION['rec_id'];
$newimagenamethumb = 'recipeimage_'.$_SESSION['rec_id'].'_thumb';

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

				$query = "INSERT INTO recipe_images (recipe_id, image_name,image_name_thumb)
	          	VALUES('{$_SESSION['rec_id']}','$fullfile_name2','$fullfile_namethumb')";

				mysql_query($query);
				unset($_SESSION['rec_id']);	
				// header('location:'.the_permalink());
				header("Location:/recipeadmin");
	}


				

} //this is the closing bracket for the password protect if
  ?>












		
		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>