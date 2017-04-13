<?php
/*
Template Name: events
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<div class="container">
			<div class="eventcontainer">
		
		

		



	



<?php
$counter = 0;

// $query = "SELECT * FROM wp_eme_events ORDER BY  event_start_date ASC"; 

// $result = mysql_query($query);

//This checks to see if there is a page number. If not, it will set it to page 1

 // if (!(isset($pagenum))) 
 // { 
 // $pagenum = 1; 
 // } 


if (isset($_GET['pagenum'])) {// Determine where in the database to start returning results.
	$pagenum = $_GET['pagenum'];
} else {
	$pagenum = 1;
}

 //Here we count the number of results 
 //Edit $data to be your query 

 $data = mysql_query("SELECT * FROM wp_eme_events") or die(mysql_error()); 
 $rows = mysql_num_rows($data); 



//This is the number of results displayed per page 
 $page_rows = 6; 

 //This tells us the page number of our last page 
 $last = ceil($rows/$page_rows); 

  //this makes sure the page number isn't below one, or more than our maximum pages 
 if ($pagenum < 1) 
 { 
 $pagenum = 1; 
 } 
 elseif ($pagenum > $last) 
 { 
 $pagenum = $last; 
 } 
 
 //This sets the range to display in our query 
 $max = 'limit ' .($pagenum - 1) * $page_rows .',' .$page_rows; 


 // This shows the user what page they are on, and the total number of pages
 echo " --Page $pagenum of $last-- <p>";
 
 // First we check if we are on page one. If we are then we don't need a link to the previous page or the first page so we do nothing. If we aren't then we generate links to the first page, and to the previous page.
 if ($pagenum == 1) 
 {
 } 
 else 
 {
 echo " <a href='".get_permalink( $post->ID )."?pagenum=1'> <<-First</a> ";
 echo " ";
 $previous = $pagenum-1;
 echo " <a href='".get_permalink( $post->ID )."?pagenum=$previous'> <-Previous</a> ";
 } 

 //just a spacer
 echo " ---- ";

 //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
 if ($pagenum == $last) 
 {
 } 
 else {
 $next = $pagenum+1;


echo "<a href='".get_permalink( $post->ID )."?pagenum=$next'>Next -></a> "; 
 echo " <a href='".get_permalink( $post->ID )."?pagenum=$last'>Last ->></a> ";

 } 


//This is your query again, the same one... the only difference is we add $max into it
 $data_p = ("SELECT * FROM wp_eme_events  ORDER BY event_start_date ASC $max") or die(mysql_error()); 
 $result = mysql_query($data_p);
 //This is where you display your query results

echo '<h2>Check Out These Upcoming Events </h2>';

 while($row = mysql_fetch_array($result)){   //Creates a loop to loop through results



$eventname = $row['event_name'];
$eventdate = $row['event_start_date'];
$eventdatelong = date('D F d Y', strtotime($eventdate));
$eventdescript = $row['event_notes'];
$shortdescript = implode(' ', array_slice(explode(' ', $eventdescript), 0, 17)).' ...';
$imageurl = $row['event_image_url'];

// colorpicker
$eventboxcolor = '#641e1e';

$counter++;

switch ($counter)
{
    case $counter == '1' : $eventboxcolor = '#864d19';break;
    case $counter == '2'  : $eventboxcolor = '#748145';break;
    case $counter == '3'  : $eventboxcolor = '#641e1e';break;
    case $counter == '4'  : $eventboxcolor = '#122923';break;
    case $counter == '5'  : $eventboxcolor = '#469485';break;
    case $counter == '6'  : $eventboxcolor = '#3f291c'; $counter = '0'; break;
    break;
}




if (empty($imageurl)) {
	$imageurl = "/wp-content/themes/twentythirteen/images/test-events.jpg";
	 } else {
		$imageurl = $row['event_image_url'];
	}


?>


		
	<?php echo '<div class="eventbox" style="background-color:'.$eventboxcolor.';"> '; ?>
						<div>
							<img width='350' height='250' src=<?php echo $imageurl; ?>>
							<?php echo '<span class="glyphicon glyphicon-play" style="color:'.$eventboxcolor.';"></span>'; ?>
						</div>
						<div class="eventheader">
							<h3><?php echo $eventname; ?></h3>
							<h4><?php echo $eventdatelong; ?></h4>
							<p><?php echo $shortdescript; ?></p>
						</div>

	</div> <!-- end eventbox -->


<?php
}
 

























				


?>








		
			</div>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

