<?php
/**
 * @package WordPress
 * @subpackage WP-Bootstrap
 */

get_header(); 
get_template_part( 'menu', 'index' ); //the  menu + logo/site title ?>

	<div class="container">
		<div class="row">
			<div class="span12">
				<?php the_post(); ?>
				<h2 class="page-title author"><?php printf( __( 'Author Archives: <span class="vcard">%s</span>', 'WP-Bootstrap' ), "<a class='author' href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a>" ); ?></h2>
				
				<?php rewind_posts(); ?>
				<?php get_template_part( 'loop', 'author' ); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>