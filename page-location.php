<?php
/**
 * Template Name: Location Parent, Full Width
 * Description: A full-width template for the location
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

<?php echo TL_WP_Location_Parent(); ?>

<?php get_footer(); ?>