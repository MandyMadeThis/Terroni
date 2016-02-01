<?php
/**
 * Template Name: One Column offset
 * Description: A one column template with an offset
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 */
?>
<?php
get_header(); 
get_template_part( 'menu', 'index' ); //the  menu + logo/site title
?>

<?php the_post(); ?>

	<div class="container">
		<div class="row">
			<div id="one-column-offset" class="col-sm-6 col-sm-offset-3">
				<?php echo do_shortcode(get_the_content()); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>