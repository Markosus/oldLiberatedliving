<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">


		<?php

		$howmanyquotes = 0;

  			$result = mysql_query("SELECT * FROM ma_indexquotes");
			$num_rows = mysql_num_rows($result);

			$howmanyquotes = $num_rows -1;
			$randomnumber = rand(0, $howmanyquotes);

		?>





		<!-- <img style="display: block;margin-left: auto; margin-right: auto;" src="/liberatedliving/wp-content/themes/twentythirteen/images/healthy.png">
 -->
		<h2 class="homeh2" style="font-family:TalkingToTheMoon; font-size:30px; text-align:center;" >
			<?php

			$query = "SELECT * FROM ma_indexquotes ORDER BY id LIMIT $randomnumber, 1";
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
					echo $row['quote'];
			}

			?>
			
			
			<br/><a href="#"></a>
			<?php

			$query = "SELECT * FROM ma_indexquotes ORDER BY id LIMIT $randomnumber, 1";
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
					echo $row['series'];
			}

			?>
			</a>
		</h2>

		 <span class="pull-right"  style="font-size: 100%; color:#aaa; margin-top: -25px;" ><em>
		  - 
		  	<?php

			$query = "SELECT * FROM ma_indexquotes ORDER BY id LIMIT $randomnumber, 1";
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)){
					echo $row['author'];
			}

			?>

		  
		  </em></span>


	<!-- 	<h2 style=" font-size:30px; text-align:center;">
		</h2> -->

	
			
		

		</br> 
		<hr style="margin-top: -25px;"/ >
		
		<!-- Welcome to Liberated Living. LIVING as a means to HELP OTHERS learn to help themselves to FIND LIBERATION from whatever ails them.-->

			<div class="row">

				<div class="col-lg-4">

					<img style="display: block;margin-left: auto; margin-right: auto;" src="/liberatedliving/wp-content/themes/twentythirteen/images/events-calendar-icon.png">
					<h2 style="color:#154f6d;" >Events & Classes</h2>
					<!-- <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal1">
							  Register
					</button></br></br> -->		

					


				</div> <!-- end span4-->

			

				<div class="col-lg-4">
					<img style="display: block;margin-left: auto; margin-right: auto;" src="/liberatedliving/wp-content/themes/twentythirteen/images/suppliments.png">
					<h2 style="color:#691618;">Buy Suppliments</h2>
					

				</div> <!-- end span4 -->







					<div class="col-lg-4">

					<img style="display: block;margin-left: auto; margin-right: auto;" src="/liberatedliving/wp-content/themes/twentythirteen/images/oneonone.png">
					<h2 style="color:#166441;">One On One</h2>
					

				</div> <!-- end span4 -->
		</div> <!-- end row -->

		<hr />


		<div class="row">

				<div class="col-lg-6">


				<section >
				<video controls preload >
				
				<source  src="/liberatedliving/wp-content/themes/twentythirteen/images/flowers.mp4" type="video/mp4" >
				<!-- <source src="/liberatedliving/wp-content/themes/twentythirteen/images/vid.ogv" type="video/ogg">
				<source src="/liberatedliving/wp-content/themes/twentythirteen/images/vid.webm" type="video/webm"> -->
				
				</video>
				</section>





				</div> <!-- end span4-->


			
				<div class="col-lg-6">
				<h3>About Liberated Living</h3>
				

				<p>worried. We spoke to 3 different doctors about his symptoms, but no one wanted to
 
do blood work. Susan has literally been a lifelong friend, but we have never seen her professionally.  I finally thought of her - maybe she could analyze Jake's blood and give us some sort of clue what was going on.
Susan has always been one of the most proactive people I knowt, get</p>

					

				</div> <!-- end span4 -->


		</div> <!-- end row -->














				</br></br></br></br></br></br></br>









		</div> <!-- end container -->






 	<!-- 			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
 
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>


  <div class="carousel-inner">
        <div class="item active">
          <img style="display: block;margin-left: auto; margin-right: auto;" src="/liberatedliving/wp-content/themes/twentythirteen/images/healthy.png">
        </div>
        

        <div class="item">
          <img style="display: block;margin-left: auto; margin-right: auto;" src="/liberatedliving/wp-content/themes/twentythirteen/images/scream.png">
        </div>
       
      </div>


  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div> -->






		

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>

