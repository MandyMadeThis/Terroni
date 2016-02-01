<?php
/**
 * Template Name: Book An Event Template
 * Description: This needs a special template
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 */
?>
<?php
get_header(); 
get_template_part( 'menu', 'index' ); //the  menu + logo/site title

	wp_enqueue_script( 'tl-wp-masked-input', get_template_directory_uri().'/scripts/libs/jquery.maskedinputs.min.js', array( 'jquery' ), '1.3.1', true );
	
	wp_enqueue_style( 'tl-wp-jquery-ui', get_template_directory_uri().'/packages/jquery-ui/jquery-ui.min.css' );
	wp_enqueue_script( 'tl-wp-jquery-ui-js', get_template_directory_uri().'/packages/jquery-ui/jquery-ui.min.js', array( 'jquery' ), '1.11.4', true );

?>

<?php the_post(); ?>
	<div class="clearfix" data-section="book-an-event">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<h3 class="text-center">Book An Event</h3>
				</div>
			</div>
		</div>
		<?php echo TL_WP_Book_An_Event_Carousel();?>
		<div class="container">
			<div class="row">
				<div id="one-column-offset" class="col-sm-6 col-sm-offset-3">
					<?php echo do_shortcode(get_the_content()); ?>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<?php
						// additional information
						$footerText = get_field('event_additional_info');
					
						if(strlen($footerText)>0)
							$footerText = '<div id="book-an-event-footer" class="clearfix separator text-center"><h3>Additional Info</h3><p>'.$footerText.'</p></div>';
							
						echo $footerText;
					?>	
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>