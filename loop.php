<?php 
/**
 * @package WordPress
 * @subpackage WP-Bootstrap
 */
?>

	 <div class="container">
		<div class="row">
		  <span class="span8">
			 <?php while ( have_posts() ) : the_post(); ?> <!--  the Loop -->
			 
			 <article id="post-<?php the_ID(); ?>">
				<div class="title">            
				  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title('<h3>', '</h3>'); ?></a>  <!--Post titles-->
				</div>
				<?php the_content("Continue reading " . the_title('', '', false)); ?> <!--The Content-->
			 </article>
			 
			 <div class="clearfix hr"></div>
			 
			 <?php endwhile; ?><!--  End the Loop -->				
		  </span>
		</div>
	 </div>