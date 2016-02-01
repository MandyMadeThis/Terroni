<?php
/**
 * Template Name: Location Single
 * Description: A template for a single location
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 */
?>
<?php the_post(); ?>
<?php
get_header(); 
get_template_part( 'menu', 'index' ); //the  menu + logo/site title
?>
<?php
	$featureImage =  wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
	$openTableId = get_field('open_table_reservation_id');
?>

	<div class="clearfix" data-section="location-single" data-parent="<?php echo $parentPost;?>">
		<div class="container-fluid">
			<div class="row">
				<div class="location-header"<?php if(strlen($featureImage)>0):?> style="background-image:url(<?php echo $featureImage;?>);"<?php endif?>>
					<?php echo TL_WP_Create_Reservation_Form();?>
					<div class="location-header-content-container">
						<div class="location-header-name clearfix">
							<span class="text-top"><?php echo $textTop = get_field('location_text_top');?></span>
							<?php if(strlen($textBottom = get_field('location_text_bottom'))>0):?><div class="clearfix"></div><span class="text-bottom"><?php echo $textBottom;?></span><?php endif?>
						</div>
						<div class="location-header-reservation clearfix" data-open-table="<?php echo (strlen($openTableId)>0) ? 'yes' : 'no';?>">
							<address class="location-reservation-address">
								<?php
									$city = trim(get_field('location_info_city'));
									$address = trim(get_field('location_info_address'));
									
									$finalAddress = ((strlen($city)>0) ? $city : '');
									
									if(strlen($finalAddress)>0)
									{
										if(strlen($address)>0) // final look
											$finalAddress .= ' / ' . $address;
									}
									else
										if(strlen($address)>0) // final look
											$finalAddress = $address;
											
									echo $finalAddress;
								?>
							</address>
							<?php if(strlen($telephone = get_field('location_info_telephone'))>0):?>
							<?php echo sprintf(HTML_TEMPLATE_ANCHOR, 'tel:'.$telephone, 'Click here to call us at' . $telephone, ' class="location-reservation-telephone"', GlobalFunctions::FormatPhone($telephone));?>
							<?php endif ?>
							<div class="clearfix"></div>
							<?php if(strlen($openTableId) > 0):?>
							<a href="javascript:void(0);" title="Make a Reservation at <?php echo $textTop . ' ' . $textBottom;?>" class="btn-reservations">Reservations</a>
							<?php endif ?>
							<?php if(is_page(2196)):?>
								<button class="food-booking-button" data-glf-cuid="4994b967-5280-462f-aef1-eb1e0ccc5486" data-glf-ruid="c43025de-4a2b-4922-9c7c-37ccc1f21b92">Place a pick-up order</button>
								<script src="https://www.foodbooking.com/widget/js/ewm2.js" defer async ></script>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<div class="container">
			<div class="row" data-section="content">
				<div class="col-sm-6">
					<div class="clearfix" data-align="left">
						<?php echo html_entity_decode(get_field('location_content_left'));?>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="clearfix" data-align="right">
						<?php echo html_entity_decode(get_field('location_content_right'));?>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row" data-section="menu">
				<div class="col-sm-12">
					<?php echo TL_WP_Location_Menu();?>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row" data-section="location">
				<div class="col-sm-12">
					<div class="inline-block">
						<?php
							$moreInfo = get_field('location_content_more_info');
							
							if(strlen($moreInfo)>0):
						?>
						<h3>Location</h3>
						<p><?php echo $moreInfo;?></p>
						<?php endif?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12"><?php echo TL_WP_Create_Carousel();?></div>
		</div>
	</div>
	
	<div class="container">
		<div class="row" data-section="carousel-description">
			<div class="col-sm-6 col-sm-offset-3 text-center"><div class="inline-block"></div></div>
		</div>
	</div>

<?php get_footer(); ?>