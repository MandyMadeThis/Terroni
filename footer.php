<?php
/**
 * @package WordPress
 * @subpackage WP-Bootstrap
 */
?>
				<div class="clearfix"></div>
			</section>
			<section id="social-media-container" class="clearfix">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 text-center">
							<div class="inline-block">
								<?php if ( function_exists( 'ot_get_option' ) && strlen($otFacebook = ot_get_option('general_facebook')) > 0 ): ?>
								<a href="<?php echo $otFacebook;?>" title="Follow Us On Facebook" target="_blank" data-social="facebook"><i class="fa fa-facebook"></i></a>
								<?php endif ?>
								<?php if ( function_exists( 'ot_get_option' ) && strlen($otTwitter = ot_get_option('general_twitter')) > 0 ): ?>
								<a href="<?php echo $otTwitter;?>" title="Follow Us On Twitter" target="_blank" data-social="twitter"><i class="fa fa-twitter"></i></a>
								<?php endif ?>
								<?php if ( function_exists( 'ot_get_option' ) && strlen($otInstagram = ot_get_option('general_instagram')) > 0 ): ?>
								<a href="<?php echo $otInstagram;?>" title="Follow Us On Instagram" target="_blank" data-social="instagram"><i class="fa fa-instagram"></i></a>
								<?php endif ?>
								<a href="http://issuu.com/terroni" title="Read Terroni Magazine" target="_blank"><i class="fa fa-book"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</section>
		</div>
    <footer class="full-width">
			<div id="footer-container" class="clearfix">
				<div class="container">
					<div class="row">
						<div class="form-group col-md-9 col-md-offset-2">
							<?php echo do_shortcode('[mc4wp_form]'); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-md-offset-2">
							<?php wp_nav_menu( array( 'theme_location' => 'footer-left', 'container' => 'nav', 'container_id' => 'nav-footer-left', 'container_class' => '', 'menu_class' => '', 'walker' => new wp_bootstrap_navwalker() ) ); ?>
						</div>
						<div class="col-md-3">
							<?php wp_nav_menu( array( 'theme_location' => 'footer-middle', 'container' => 'nav', 'container_id' => 'nav-footer-middle', 'container_class' => '', 'menu_class' => '', 'walker' => new wp_bootstrap_navwalker() ) ); ?>
						</div>
						<div class="col-md-3">
							<?php wp_nav_menu( array( 'theme_location' => 'footer-right', 'container' => 'nav', 'container_id' => 'nav-footer-right', 'container_class' => '', 'menu_class' => '', 'walker' => new wp_bootstrap_navwalker() ) ); ?>
						</div>
					</div>
				</div>
			</div>
		</footer>
		
		<?php wp_footer(); ?>
		
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/globalFunctions.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/master.js"></script>
	</body>
</html>