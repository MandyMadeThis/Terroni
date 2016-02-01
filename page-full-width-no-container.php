<?php
/**
 * Template Name: Full Width no container
 * Description: A template with no twitter bootstrap container
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

<div class="full-width clearfix" data-section="stackable">
<?php echo do_shortcode(get_the_content()); ?>
</div>

<?php get_footer(); ?>