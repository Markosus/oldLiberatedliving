<?php

/*
Template Name: singleeventpage
*/

  //response generation function

  





get_header(); ?>

  <div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

    <div class="container">
<div class="singleeventcontainer">


<?php
$yourAddress = "162 Hyde Park Ave. Hamilton Ontario"
?>                  
                  
<!-- <div class="iframe-outer">
    <div class="iframe-inner">
    <iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo $yourAddress; ?> &output=embed"></iframe>

    </div>
</div>   -->        


<?php

if (isset($_GET['event_id'])) {// Determine where in the database to start returning results.
  $eventid = $_GET['event_id'];
} else {
  $eventid = 'No Event' ;
}

if (empty($imageurl)) {
  $imageurl = "/wp-content/themes/twentythirteen/images/test-events.jpg";
   } else {
    $imageurl = $row['event_image_url'];
  }


$query = "SELECT * FROM `wp_eme_events` WHERE event_id = ".$eventid." ";
$result = mysql_query($query);




while($row = mysql_fetch_array( $result )) {
$eventurl = $row['event_url'];
$eventname = $row['event_name'];
$eventdescript = $row['event_notes'];
$eventdate = $row['event_start_date'];
$imageurl = $row['event_image_url'];



if (empty($imageurl)) {
  $imageurl = "/wp-content/themes/twentythirteen/images/test-events.jpg";
   } else {
    $imageurl = $row['event_image_url'];
  }

}
?>





<h3 class="singleeventh3"><?php echo $eventname; ?></h3>
<img class="singleeventimage" width='350' height='250' src=<?php echo $imageurl; ?>>



<?php

// this will check to see if there is an external url in the database 
if (empty($eventurl)) {
 }
else {
$homepage = @file_get_contents($eventurl);

}


// ---------this checks the 2 different formats of mailchimp and if it finds the following snippet will display the page. --------
$croppedcontent = strstr($homepage, '<!-- BEGIN BODY // -->');
$croppedcontent2 = strstr($homepage, '<!-- // Begin Template Body ');
echo $croppedcontent;


if (empty($croppedcontent)) {
  echo $croppedcontent2;
   } 
 // ---------Ends the check for the 2 layouts--------  

if  ((empty($croppedcontent)) && (empty($croppedcontent)) || (empty($eventurl))) {

  echo '<div class="singleeventdefaultlayout"> ';
  echo $eventdescript;

    ?>

<div class="row">
                
    <div class="col-md-4" >






    </div>

    <div class="col-md-8 test" style="text-align:left;" >


            
                            
    </div>

</div>  <!-- end row -->

</div>
    











    <?php
   } 


?> 


        </div>
       </div> <!-- end container -->

    </div><!-- #content -->
  </div><!-- #primary -->

<?php get_footer(); ?>

