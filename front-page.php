<?php
/**
 * @package WordPress
 * @subpackage WP-Bootstrap
 */

get_header(); 
get_template_part( 'menu', 'index' ); //the  menu + logo/site title ?>

<div class="full-width clearfix" data-section="homepage">
  <?php echo TL_WP_Get_Stackable();?>
</div>

<?php get_footer(); ?>