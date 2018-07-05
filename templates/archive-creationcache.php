<?php
/**
 * Template Name: creationcache
 
 * This is the template to display a creation cache archive
 
 * @author 		Paul Taylor
 * @package 	ocws-creationcache
 * @version     0.5
 
 **/
?>

<?php get_header(); ?>

 
 
 <!-- HTML for the structure -->
 <div id="ocwscc_mainsection">
<?php 
echo "<h1>List of ".CCNAME_PL."</h1>\n";

if(have_posts()) : while(have_posts()) : the_post();
			 ocwscc_get_template_part( 'content', 'archive', $post ); 
	endwhile; endif;
?>
</div><!-- end mainsection -->

 


<?php get_footer(); ?>