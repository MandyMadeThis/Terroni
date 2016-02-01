<?php
/**
 * Template Name: Reservation Template
 * Description: A full-width template for the reservation as it will use the open table widget
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

<div id="reservations-container" class="full-width clearfix">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<?php echo TL_WP_Create_Reservation_Form(true);?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>