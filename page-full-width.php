<?php
/**
 * Template Name: Full-width, no sidebar
 * Description: A full-width template with no sidebar
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

<?php
$content = apply_filters ("the_content", $post->post_content);
?>

<div class="container">
	<div class="row">
		<div id="full-width-content" class="col-sm-12">
			<?php echo do_shortcode($content); ?>
			<?php echo TL_WP_Our_Story_Footer();?>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<?php get_footer(); ?>