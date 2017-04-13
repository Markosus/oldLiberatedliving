<?php
/*
Template Name: recipeindex
*/

get_header(); ?>

<script src="/wp-content/themes/twentythirteen/js/jquery-1.9.1.min.js"></script>
<script src="/wp-content/themes/twentythirteen/js/jquery.autocomplete.min.js"></script>


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">



<script type="text/javascript">
	$(function(){
  var ingredientverb = [
    	<?php  

    	$result= mysql_query("SELECT * FROM `recipe_ingredientinfoverb`"); 
			while($row = mysql_fetch_array($result)){
			echo "{ value: '".$row['ingredientinfo_verb']."' },";
			}


    	 ?>
  ];
  
  // setup autocomplete function pulling from currencies[] array
  $('#autocomplete').autocomplete({
    lookup: ingredientverb,
    onSelect: function (suggestion) {
      var thehtml = '<strong>Ingredient Action/Info:</strong> ' + suggestion.value;
      $('#outputcontent').html(thehtml);
    }
  });
  

});







</script>



	
        <form action="<?php the_permalink(); ?>" method="POST" name="test">
        <input type="text" name="ingredientaction" class="biginput" id="autocomplete" >
        </form>
      </div><!-- @end #searchfield -->
      
     


<?php
$test = $_POST['ingredientaction'];
echo $test;
?>














































		
		</div>	<!-- #container -->
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>

