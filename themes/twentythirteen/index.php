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

			// ------------------ Begining of related recipe random generator --------------



			$result= mysql_query("SELECT * FROM `recipes`"); 
			while($row = mysql_fetch_array($result)){
			$relatedrecipes[]=$row['recipe_id'];
			}
				
				$relatedrecipescount2 = 3;
				$relatedrecipescount = 3;
				
				
					$rand_keys = array_rand($relatedrecipes, $relatedrecipescount);
					$randrecipe1 = $relatedrecipes[$rand_keys[0]];
					$randrecipe2 = $relatedrecipes[$rand_keys[1]];
					$randrecipe3 = $relatedrecipes[$rand_keys[2]];	



					$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$randrecipe1'");
					$row = mysql_fetch_array($result);
					$randrecipe1url = $row['image_name'];
					$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$randrecipe1'");
					$row = mysql_fetch_array($result);
					$randrecipe1name = $row['recipe_name'];
					$result= mysql_query("SELECT * FROM `recipe_description` WHERE recipe_id LIKE '$randrecipe1'");
					$row = mysql_fetch_array($result);
					$randrecipe1description = $row['description'];


					$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$randrecipe2'");
					$row = mysql_fetch_array($result);
					$randrecipe2url = $row['image_name'];
					$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$randrecipe2'");
					$row = mysql_fetch_array($result);
					$randrecipe2name = $row['recipe_name'];
					$result= mysql_query("SELECT * FROM `recipe_description` WHERE recipe_id LIKE '$randrecipe2'");
					$row = mysql_fetch_array($result);
					$randrecipe2description = $row['description'];

					$result= mysql_query("SELECT * FROM `recipe_images` WHERE recipe_id LIKE '$randrecipe3'");
					$row = mysql_fetch_array($result);
					$randrecipe3url = $row['image_name'];
					$result= mysql_query("SELECT * FROM `recipes` WHERE recipe_id LIKE '$randrecipe3'");
					$row = mysql_fetch_array($result);
					$randrecipe3name = $row['recipe_name'];
					$result= mysql_query("SELECT * FROM `recipe_description` WHERE recipe_id LIKE '$randrecipe3'");
					$row = mysql_fetch_array($result);
					$randrecipe3description = $row['description'];
				


				if (empty($randrecipe1url)) {
					  $randrecipe1url = "defaultimage.png";
				}

				if (empty($randrecipe2url)) {
					  $randrecipe2url = "defaultimage.png";
				}

				if (empty($randrecipe3url)) {
					  $randrecipe3url = "defaultimage.png";
				}

				// ------------------ End of related recipe random generator --------------

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

	
			
		<frameset rows="100%">
  <frameset cols="100%">
    <frame src="http://us7.campaign-archive1.com/?u=d2b3969cfcfb8355ef46a41e5&id=6d74e004be" frameborder="0" scrolling="yes">
  </frameset>
</frameset>

		</br> 
		
		<hr style="margin-top: -25px; text-align:center;"/ >
		
		<!-- Welcome to Liberated Living. LIVING as a means to HELP OTHERS learn to help themselves to FIND LIBERATION from whatever ails them.-->

			<div class="row">

				<div class="col-lg-3" id="eventhover">

					<a href="/services/eventsclasses/">
					<img style="display: block;margin-left: auto; margin-right: auto;" src="/wp-content/themes/twentythirteen/images/events-calendar-icon.png">
					<h2 style="color:#154f6d;" >Events & Classes</h2>
					<!-- <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal1">
							  Register
					</button></br></br> -->		
					</a>	
					

				</div> <!-- end span4-->

			

				<div class="col-lg-3" id="supplimentshover">
					<a href="/buy-supplements-on-its-way/">
					<img style="display: block;margin-left: auto; margin-right: auto;" src="/wp-content/themes/twentythirteen/images/suppliments.png">
					<h2 style="color:#691618;">Buy Suppliments</h2>
					</a>

				</div> <!-- end span4 -->







					<div class="col-lg-3" id="oneononehover" >
					<a href="/services/one-on-one/">	
					<img style="display: block;margin-left: auto; margin-right: auto;" src="/wp-content/themes/twentythirteen/images/oneonone.png">
					<h2 style="color:#166441;">One On One</h2>
					</a>

				</div> <!-- end span4 -->


				<div class="col-lg-3" id="rateshover">
				<a href="/services/services/">
				<img style="display: block;margin-left: auto; margin-right: auto;" src="/wp-content/themes/twentythirteen/images/gear.png">
				<h2 style="color:#a27509;">Rates & Services</h2>
				</a>	

				</div> <!-- end span4 -->


		</div> <!-- end row -->

		<hr />


	


		

			
				
			






<!-- 	<div class="videoWrapper" >
		  	 
		   	 	</div> -->







				</br></br>









		</div> <!-- end container -->










		
		</div>	<!-- #container -->
		
		</div><!-- #content -->

	</div><!-- #primary -->





	<section class="indexabout">
				
				<h3 style="margin-top: 15px; font-family:TalkingToTheMoon; font-size:40px; text-align:center;">About Us</h3>
				

				<p>Liberated Living offers nutrition consultations, live blood cell microscopy, breakthrough coaching, reiki, Intuitive Counseling, raw food and vegetarian cooking 
				classes as well as seminars for individuals and businesses. <br><br> Susan, the Registered Holistic Nutritionist specializes in overcoming addictions, 
				negative recurrent patterns, depression and anxiety, teaching her clients to act from a place of love and 
				not fear. Susan is also a Certified Personal Trainer, competitive athlete and Boston Marathon qualifier, which enables her to design cardio, strength & training programs for a variety of individuals with diverse goals. 
</p>
			
	</section>




<div id="primary" class="content-area">
<div id="content" class="site-content" role="main">
<div class="container">


<br><br>
				<div class="frontrecipecontainer">


					<h2>Check out some of our healthy recipes!</h2>
		
					<div class="row" >
                		<a href="/recipeview/?page=<?php echo $randrecipe1name; ?>">
					    <div class="col-md-4 test" style="text-align:left;">
					    	 <img id="recipestyleleft" width='250' height='250' src="/wp-content/themes/twentythirteen/recipeimages/big/<?php echo $randrecipe1url; ?>"></a>         
					    	<h3 style="color: #154f6d;"><?php echo $randrecipe1name; ?></h3>
					    	<p><?php echo $randrecipe1description; ?></p>
					    </div>
						</a>

						<a href="/recipeview/?page=<?php echo $randrecipe2name; ?>">
					   <div class="col-md-4 test" style="text-align:left;">
					   <img id="recipestylemiddle" width='250' height='250' src="/wp-content/themes/twentythirteen/recipeimages/big/<?php echo $randrecipe2url; ?>"></a>         
					   <h3 style="color: #691618;"><?php echo $randrecipe2name; ?></h3>
					   <p><?php echo $randrecipe2description; ?></p>
					   </div>
					   </a>

					   	<a href="/recipeview/?page=<?php echo $randrecipe3name; ?>">
					    <div class="col-md-4 test" style="text-align:left;">
					    <img id="recipestyleright" width='250' height='250' src="/wp-content/themes/twentythirteen/recipeimages/big/<?php echo $randrecipe3url; ?>"></a>         
					    <h3 style="color: #166441;"><?php echo $randrecipe3name; ?></h3>
					    	<p><?php echo $randrecipe3description; ?></p>
					    </div>
					    </a>

					</div>  <!-- end row -->
					
		
				</div><!-- end frontrecipecontainer -->





				<div class="row">

					<div class="col-lg-12">


					<section>

					<br>

				<div onclick="thevid=document.getElementById('thevideo'); thevid.style.display='block'; this.style.display='none'">
				<img class="indexvideo"style="cursor: pointer;" alt="" src="/wp-content/themes/twentythirteen/images/indexvideo.png" width="100%" height="100%" />
				</div>
				<div id="thevideo" style="display: none;">
				<embed class="indexvideoembed" width="631" height="466" type="application/x-shockwave-flash" 
				src="https://www.youtube.com/v/nOr0pUhVHJI?version=3&amp;hl=en_US&amp;autoplay=0" allowFullScreen="true" allowscriptaccess="always" allowfullscreen="true" />
				</div>


					
					</iframe>
					
								
					</section>



					</div> <!-- end span4-->

				</div> <!-- end row -->












</div>	<!-- #container -->
</div><!-- #content -->
</div><!-- #primary -->


<?php get_footer(); ?>

