<?php
/**
 * Template Name: Full-width, Blog
 * Description: A full-width template for the blog
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

<div id="blog-landing-container" data-pos="0">
	<div class="container-fluid">
		<div class="row no-gutter">
			<div id="blog-landing-header" class="col-sm-12 stackable-column"></div>
		</div>
	</div>
	<div class="container">
		<div class="row rel">
			<div id="blog-landing-content" class="col-sm-8 col-sm-offset-2"></div>
			<a href="javascript:void(0);" title="Previous Article" class="btn-blog btn-blog-previous deactivated">
				<img src="<?php echo get_template_directory_uri() . '/images/icons/icn-arrow-left.png';?>" alt="Previous Article" />
			</a>
			<a href="javascript:void(0);" title="Next Article" class="btn-blog btn-blog-next">
				<img src="<?php echo get_template_directory_uri() . '/images/icons/icn-arrow-right.png';?>" alt="Next Article" />
			</a>
		</div>
		<?php echo TL_WP_Latest_Blog_Posts();?>
	</div>
	<?php echo TL_WP_Blog_Landing();?>
</div>

<?php get_footer(); ?>