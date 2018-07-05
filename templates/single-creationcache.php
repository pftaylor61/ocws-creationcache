<?php
/**
 * Template Name: creationcache
 
 * This is the template to display a single creation cache
 
 * @author 		Paul Taylor
 * @package 	ocws-creationcache
 * @version     0.5
 
 **/
 get_header();
 
 ?>
 
 <!-- HTML for the structure -->
 <div id="ocwscc_mainsection">
 
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php ocwscc_get_template_part( 'content', 'single', $post ); ?>


			<?php endwhile; ?>
</div><!-- end mainsection -->
 
 
 <?php
 get_footer();
 ?>