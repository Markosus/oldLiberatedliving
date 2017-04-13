<html>

	<head>
		<title>

		<?php wp_title(); ?>
					

		</title>

		<link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">

	</head>


	<body>


		
		<header id="topheader">

			<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</a>
			
			
		</header>	

<div id="menuwrap">
		<nav id="nav3">

			<ul>
				<?php wp_list_pages('title_li='); ?>

			</ul>
			

		</nav>
</div> <!-- end menuwrap -->

	</br></br>


	<div id="main">         

		<div id="content">                 
			             
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>  <h1><?php the_title(); ?></h1> <?php the_content(); ?>  <?php endwhile; endif; ?><!--/ #content --> 


<div class="row">

				<div class="col-xs-4">

					<p>
						Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
						when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing 
					</p>

					<p><a class="btn" href="landscape-design.php">learn more</a></p>

				</div> <!-- end span4-->

				<div class="col-xs-4">
					<p>
						Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
						when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing 
					</p>

					<p><a class="btn" href="landscape-design.php">learn more</a></p>

				</div> <!-- end span4 -->

				<div class="col-xs-4">
					<p>
						Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
						when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing 
					</p>

					<p><a class="btn" href="landscape-design.php">learn more</a></p>

				</div> <!-- end span4 -->




			</div> <!-- end row -->


		</div> <!-- end content -->

	</div><!--  end main		 -->	



  <footer>
    	<nav>
        	<ul>
            	<li><a href="">foot</a></li>
                <li><a href="">foot</a></li>
                <li><a href="">foot</a></li>
                <li><a href="">foot</a></li>
            </ul>
        </nav>
   </footer>



	</body>











</html>