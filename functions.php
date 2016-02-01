<?php 
/**
 * @package WordPress
 * @subpackage WP-Bootstrap
 */

// Register classes
require_once('class/GlobalVariables.php');
require_once('class/GlobalFunctions.class.php');
require_once('class/wp_bootstrap_navwalker.php');

// drag and drop menu support
register_nav_menu( 'primary', 'Primary Menu' );
register_nav_menu( 'footer-left', 'Footer Left Menu' );
register_nav_menu( 'footer-middle', 'Footer Middle Menu' );
register_nav_menu( 'footer-right', 'Footer Right Menu' );
register_nav_menu( 'terroni-talk', 'Terroni Talks Header Menu' );


//widget support for a right sidebar
register_sidebar(array(
  'name' => 'Open Table',
  'id' => 'open-table',
  'description' => 'Widget for Open Table',
  'before_widget' => '<div id="%1$s">',
  'after_widget'  => '</div>',  
  'before_title' => '<h3>',
  'after_title' => '</h3>'
));

//widget support for the footer
/*
register_sidebar(array(
  'name' => 'Footer SideBar',
  'id' => 'footer-sidebar',
  'description' => 'Widgets in this area will be shown in the footer.',
  'before_widget' => '<div id="%1$s">',
  'after_widget'  => '</div>',
  'before_title' => '<h3>',
  'after_title' => '</h3>'
));
*/

//This theme uses post thumbnails
add_theme_support( 'post-thumbnails' );


//Apply do_shortcode() to widgets so that shortcodes will be executed in widgets
add_filter('widget_text', 'do_shortcode');

// add session in init.
add_action('init', 'tl_wp_init', 1);

// init function
function tl_wp_init()
{
	myStartSession();
	do_output_buffer();
} // tl_wp_init

function myStartSession()
{
	if(!session_id()) {
		session_start();
	}
}

function do_output_buffer()
{
	ob_start();
}	


/**
 * MANAGE REMOVING OR ADDING STUFF (aka Function Snippets)
 * comment in or out what you want
 */

// remove stuff,  uncomment to enable
//require_once( get_template_directory() . '/snippets/remove-stuff.php' );

// add stuff
//require_once( get_template_directory() . '/snippets/add-stuff.php' );
//
//


/* TL WP Functions
============================================================================= */

/* Global Variable Definitions
======================================== */

	define('HTML_TEMPLATE_ANCHOR', '<a href="%s" title="%s"%s>%s</a>');
	define('HTML_TEMPLATE_UNORDERED_LIST', '<ul%s>%s</ul>');
	define('HTML_TEMPLATE_LIST', '<li%s>%s</li>');
	define('HTML_TEMPLATE_NAV', '<nav id="%s"%s>%s</nav>');
	define('HTML_TEMPLATE_IMAGE', '<img src="%1$s" alt="%2$s" title="%2$s"%3$s />');
	define('HTML_TEMPLATE_AREA', '<area shape="rect" coords="%1$s" alt="%2$s" title="%2$s" href="%3$s" target="_blank" />');
	

/* AJAX Functions
======================================== */

/* Shortcode Functions
======================================== */
	add_shortcode('tl_wp_stackable', 'TL_WP_Shortcode_Stackable');
	add_shortcode('tl_wp_book_an_event', 'TL_WP_Shortcode_Book_An_Event');
	add_shortcode('tl_wp_blog', 'TL_WP_Shortcode_Blog');

	/*
	 *  This function will get the stackable ACF and output the HTML
	 *
	 *  @author     Trusty Logic Inc
	 *  @copyright  2015 02 24
	 *
	 *  @param      $_atts          Attributes array
	 *  @param      $_content       content
	 *
	 *  @return     HTML of the stackable HTML
	 */	
	function TL_WP_Shortcode_Stackable( $_atts, $_content = null )
	{
		global $post;

		shortcode_atts(
								array(
									'amount' => ''
								),
								$_atts
							);
		
		return TL_WP_Get_Stackable();
	} // TL_WP_Shortcode_Stackable
	
	/*
	 *  This function will create the form to book an event
	 *
	 *  @author     Trusty Logic Inc
	 *  @copyright  2015 02 24
	 *
	 *  @param      $_atts          Attributes array
	 *  @param      $_content       content
	 *
	 *  @return     HTML of the event booking
	 */	
	function TL_WP_Shortcode_Book_An_Event( $_atts, $_content = null )
	{
		global $post;

		shortcode_atts(
								array(
									'amount' => ''
								),
								$_atts
							);
		
		$m_return = TL_WP_Create_Book_An_Event_Form();
		
		return $m_return;
	} // TL_WP_Shortcode_Book_An_Event
	
	/*
	 *  This funciton will get the blog posts for Terroni Talk
	 *
	 *  @author     Trusty Logic Inc
	 *  @copyright  2015 05 23
	 *
	 *  @param      $_atts          Attributes array
	 *  @param      $_content       content
	 *
	 *  @return     HTML for the blogs
	 */	
	function TL_WP_Shortcode_Blog( $_atts, $_content = null )
	{
		global $post;

		shortcode_atts(
								array(
									'amount' => ''
								),
								$_atts
							);
		
		$m_return = '';
		
		return $m_return;
	} // TL_WP_Shortcode_Blog
	
	/*
	 *  This will get all the blog posts and create the view
	 *
	 *  @author     	Trusty Logic Inc
	 *  @copyright  	2015 05 24
	 *
	 *  @return     	HTML of the 
	 */	
	function TL_WP_Blog_Landing()
	{
		global $post;
		
		$m_return = array();
		
		$args = 	array(
						'posts_per_page'   => -1,
						'category_name'    => 'blog',
						'orderby'          => 'date',
						'order'            => 'DESC',
					);
		
		$posts_array = get_posts( $args );
		
		$m_template = 	'<div class="blog-landing-header"%s>%s</div>';
		
		foreach($posts_array as $post) // get them posts
		{
			$subTitle = get_field('blog_sub_title');
			$videoPoster = get_field('blog_video_poster');
			$videoUrl = get_field('blog_video_url');
			$image = get_field('blog_image');
			
			$m_tmp = '';
			$m_tmpBody = '';
			
			// first, check to see what exists?
			if(strlen($videoUrl)>0)
			{
				// add autoplay
				$videoUrl .=	(strpos($videoUrl, '?') !== FALSE)
									? '&'
									: '?';
								
				$videoUrl .= 'autoplay=1';					
				
				// need to create the container with the video
				$m_tmp =	sprintf(
								$m_template,
								'',
								sprintf(
									HTML_TEMPLATE_ANCHOR,
									'javascript:void(0);',
									'Click to play video',
									' class="vertical"',
									sprintf(
										HTML_TEMPLATE_IMAGE,
										get_template_directory_uri() . '/images/icons/icn-video-play.png',
										'',
										''
									)
								) .
								'<div class="embed-responsive hideObj"><iframe class="embed-responsive-item" src="'.$videoUrl.'"></iframe></div>'
							);
			}
			elseif($image)
			{
				$m_tmp =	sprintf(
								$m_template,
								' style="background-image:url('.$image['url'].');"',
								'&nbsp;'
							);
			} // if
			
			$m_tmpBody =	sprintf(
									'<h1>%s</h1>%s%s',
									$post->post_title,
									((strlen($subTitle = get_field('blog_sub_title'))>0) ? '<h2>'.$subTitle.'</h2>' : ''),
									sprintf(
										HTML_TEMPLATE_ANCHOR,
										get_permalink($post->ID),
										'Click to view article',
										'',
										'Read Article'
									)
								);
			
			$m_return[] = array('header' => $m_tmp, 'body' => $m_tmpBody);
		} // foreach
		
		$m_return =	sprintf(
							'<script type="text/javascript">tlwp.blogLanding = %s;</script>',
							json_encode($m_return)
						);
		
		return $m_return;		
	} // TL_WP_Blog_Landing
	
	/*
	 *  This will get the three latest blog posts
	 *
	 *  @author     	Trusty Logic Inc
	 *  @copyright  	2015 05 20
	 *
	 *  @param			$_numPosts -	number of posts to retrieve from blog
	 *
	 *  @return     	HTML of the event booking
	 */	
	function TL_WP_Latest_Blog_Posts($_numPosts = 3)
	{
		global $post;
		
		$m_return = '';
		
		// retrieve x posts and show them as thumbnails
		$numCols = 12 / $_numPosts;
	
		$args = 	array(
						'posts_per_page'   => $_numPosts,
						'category_name'    => 'blog',
						'orderby'          => 'date',
						'order'            => 'DESC',
					);
		
		$posts_array = get_posts( $args );
		
		foreach($posts_array as $post) // get them posts
		{
			$image = get_field('blog_image');
			$title = $post->post_title;
			$id = $post->ID;
			
			$imageUrl =	($image)
							? $image['url']
							: ''; // put a default here
							
			$m_return .=	sprintf(
									'<div class="col-sm-%s"><div class="full-width blog-latest-article"><p>%s</p><p><strong>%s</strong></p><p>%s</p></div></div>',
									$numCols,
									sprintf(
										HTML_TEMPLATE_IMAGE,
										$imageUrl,
										'',
										' class="img-responsive"'
									),
									$title,
									sprintf(
										HTML_TEMPLATE_ANCHOR,
										get_permalink($id),
										'Click here to read article',
										' class="btn-read-article"',
										'Read Article'
									)
								);
		} // foreach
		
		wp_reset_postdata();
		
		return '<div id="blog-latest" class="container"><div class="row">'.$m_return.'</div></div>';
	} // TL_WP_Latest_Blog_Posts
	
	/*
	 *  This will create the open table reservation form
	 *
	 *  @author     Trusty Logic Inc
	 *  @copyright  2015 05 20
	 *
	 *  @param			$_standAlone - different container 
	 *
	 *  @return     HTML of the event booking
	 */	
	function TL_WP_Create_Reservation_Form($_standAlone = false)
	{
		wp_enqueue_style( 'tl-wp-jquery-ui', get_template_directory_uri().'/packages/jquery-ui/jquery-ui.min.css' );
		wp_enqueue_script( 'tl-wp-jquery-ui-js', get_template_directory_uri().'/packages/jquery-ui/jquery-ui.min.js', array( 'jquery' ), '1.11.4', true );
		
		global $post;
		
		$m_return = '';
		$templateLocation = '';
		
		// need to create stuff based on standAlone param
		if(!$_standAlone)
		{
			$reservationId = get_field('open_table_reservation_id');
		}
		else // need to create 
		{
			$reservationId = -1;
			
			// retrieve all locations
			$m_arrTitles = array('terroni-toronto' => 'TERRONI Toronto', 'terroni-los-angeles' => 'TERRONI Los Angeles');

			foreach($m_arrTitles as $key => $item) // get the locations
			{
				$m_tmpLocations = '';
				
				$post = get_page_by_path($key);
				
				$args = 	array(
						'post_parent' => $post->ID,
						'post_type' => 'page',
						'posts_per_page' => -1,
						'orderby' => 'menu_order',
						'order' => 'ASC'
					);
				
				$locations = get_children($args);
				
				foreach($locations as $post) // get the location
				{
					// get the reservation id
					$tmpReservationId = get_field('open_table_reservation_id');
					
					if(strlen($tmpReservationId)>0) // add it
						$m_tmpLocations .=	sprintf(
														'<option value="%s">%s</option>',
														$tmpReservationId,
														$post->post_title
													);
				} // foreach
				
				if(strlen($m_tmpLocations)>0)
					$templateLocation .=	sprintf(
													'<optgroup label="%s">%s</optgroup>',
													$item,
													$m_tmpLocations
												);
			} // foreach
			
			$templateLocation =	sprintf(
											'
											<div class="field people">
												<span><img src="%1$s/icn-people.png" alt="Select A Location" /></span>
												<select name="Location" id="Location">%2$s</select>
												<i><img src="%1$s/icn-arrow-down.png" alt="Select A Location" /></i>
											</div>
											',
											get_template_directory_uri() . '/images/icons',
											$templateLocation
										);
			
			wp_reset_postdata();
		} // if
		
		if(strlen($reservationId)>0)
		{
			$m_return = sprintf(
										'
										<div class="menu">
											<h2><span>Reservations</span></h2>
											<form id="openTableForm" action="http://www.opentable.com/restaurant-search.aspx" target="_blank" method="get">
												%4$s
												<div class="field calendar">
													<span><img src="%1$s/icn-calendar.png" alt="Select a Date" /></span>
													<input id="datepicker" type="text" value="%2$s" readonly name="StartDate" /> 
													<i><img src="%1$s/icn-arrow-down.png" alt="Select a Date" /></i>
												</div>
												<div class="field time">
													<span><img src="%1$s/icn-time.png" alt="Select A Time" /></span>
													<select id="ResTime" name="ResTime">
														<option value="12:00 AM">12:00 AM</option>
														<option value="12:30 AM">12:30 AM</option>
														<option value="1:00 AM">1:00 AM</option>
														<option value="1:30 AM">1:30 AM</option>
														<option value="2:00 AM">2:00 AM</option>
														<option value="2:30 AM">2:30 AM</option>
														<option value="3:00 AM">3:00 AM</option>
														<option value="3:30 AM">3:30 AM</option>
														<option value="4:00 AM">4:00 AM</option>
														<option value="4:30 AM">4:30 AM</option>
														<option value="5:00 AM">5:00 AM</option>
														<option value="5:30 AM">5:30 AM</option>
														<option value="6:00 AM">6:00 AM</option>
														<option value="6:30 AM">6:30 AM</option>
														<option value="7:00 AM">7:00 AM</option>
														<option value="7:30 AM">7:30 AM</option>
														<option value="8:00 AM">8:00 AM</option>
														<option value="8:30 AM">8:30 AM</option>
														<option value="9:00 AM">9:00 AM</option>
														<option value="9:30 AM">9:30 AM</option>
														<option value="10:00 AM">10:00 AM</option>
														<option value="10:30 AM">10:30 AM</option>
														<option value="11:00 AM">11:00 AM</option>
														<option value="11:30 AM">11:30 AM</option>
														<option value="12:00 PM">12:00 PM</option>
														<option value="12:30 PM">12:30 PM</option>
														<option value="1:00 PM">1:00 PM</option>
														<option value="1:30 PM">1:30 PM</option>
														<option value="2:00 PM">2:00 PM</option>
														<option value="2:30 PM">2:30 PM</option>
														<option value="3:00 PM">3:00 PM</option>
														<option value="3:30 PM">3:30 PM</option>
														<option value="4:00 PM">4:00 PM</option>
														<option value="4:30 PM">4:30 PM</option>
														<option value="5:00 PM">5:00 PM</option>
														<option value="5:30 PM">5:30 PM</option>
														<option selected="selected" value="6:00 PM">6:00 PM</option>
														<option value="6:30 PM">6:30 PM</option>
														<option value="7:00 PM">7:00 PM</option>
														<option value="7:30 PM">7:30 PM</option>
														<option value="8:00 PM">8:00 PM</option>
														<option value="8:30 PM">8:30 PM</option>
														<option value="9:00 PM">9:00 PM</option>
														<option value="9:30 PM">9:30 PM</option>
														<option value="10:00 PM">10:00 PM</option>
														<option value="10:30 PM">10:30 PM</option>
														<option value="11:00 PM">11:00 PM</option>
														<option value="11:30 PM">11:30 PM</option>
													</select>
													<i><img src="%1$s/icn-arrow-down.png" alt="Select A Time" /></i>
												</div>
												<div class="field people">
													<span><img src="%1$s/icn-people.png" alt="Select The Number Of People" /></span>
													<select name="PartySize" id="PartySize">
														<option value="1">1 person</option>
														<option selected="selected" value="2">2 people</option>
														<option value="3">3 people</option>
														<option value="4">4 people</option>
														<option value="5">5 people</option>
														<option value="6">6 people</option>
														<option value="7">7 people</option>
														<option value="8">8 people</option>
														<option value="9">9 people</option>
														<option value="10">10 people</option>
														<option value="11">11 people</option>
														<option value="12">12 people</option>
														<option value="13">13 people</option>
														<option value="14">14 people</option>
														<option value="15">15 people</option>
														<option value="16">16 people</option>
														<option value="17">17 people</option>
														<option value="18">18 people</option>
														<option value="19">19 people</option>
														<option value="20">20 people</option>
													</select>
													<i><img src="%1$s/icn-arrow-down.png" alt="Select The Number Of People" /></i>
												</div>
												<hr>
												<a class="button" id="submitOpenTableForm" href="javascript:void(0);">Book a Table</a>
												<input type="hidden" name="RestaurantID" id="RestaurantID" value="%3$s">
												<input type="hidden" name="rid" id="rid" value="%3$s">
												<input type="hidden" name="GeoID" id="GeoID" value="74">
												<input type="hidden" name="txtDateFormat" id="txtDateFormat" value="dd\/MM\/yyyy">
												<input type="hidden" name="RestaurantReferralID" id="RestaurantReferralID" value="%3$s">
												<input type="hidden" name="hover" id="hover" value="true">
												<input type="hidden" name="wt" id="wt" value="true">
												<input type="hidden" name="KeepThis" id="KeepThis" value="true">
											</form>
										</div>
										',
										get_template_directory_uri() . '/images/icons',
										date('d/m/Y'),
										$reservationId,
										$templateLocation
									);
					
			$m_container =	($_standAlone)
								? 	'<section class="reservations-stand-alone reservations">%s</section>'
								: 	'
									<section class="overlay reservations">
										<div class="overlayContainer">
											<div class="close-container"><a href="javascript:void(0);" title="close"><img src="'.get_template_directory_uri() . '/images/icons/icn-close.png" alt="close" /></a></div>
											%s
										</div>
									</section>
									';
									
			$m_return = sprintf($m_container, $m_return);
		} // if
		
		return $m_return;
	} // TL_WP_Create_Reservation_Form
	
	/*
	 *  This will create the carousels for the book an event
	 *
	 *  @author     Trusty Logic Inc
	 *  @copyright  2015 05 20
	 *
	 *  @return     HTML of the event booking
	 */	
	function TL_WP_Book_An_Event_Carousel()
	{
		global $post;
		
		$m_return = '';
		
		// carousel container
		$carousel =	'
						<div class="master-carousel-container full-width">
							<div class="container">
								<div class="row">
									<div class="col-sm-12 text-center"><div class="inline-block">%s</div></div>
								</div>
							</div>
							
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12"><div class="all-carousel-container">%s</div></div>
								</div>
							</div>
							
							<div class="container">
								<div class="row" data-section="carousel-description">
									<div class="col-sm-6 col-sm-offset-3 text-center"><div class="inline-block"></div></div>
								</div>
							</div>
						</div>
						';
		
		$m_arrTitles = array('terroni-toronto' => 'Toronto', 'terroni-los-angeles' => 'Los Angeles');
		$m_finalLocations = '';
		$m_finalLocationsMobile = '';
		$m_finalLocationsMain = '';
		$m_finalLocationsMainMobile = '';
		$m_tmpCarouselHTML = '';
		$m_counter = 0;

		foreach($m_arrTitles as $key => $item) // get the locations
		{
			$m_tmpLocations = '';
			$m_tmpLocationsMobile = '';
			
			$post = get_page_by_path($key);
			
			$args = 	array(
					'post_parent' => $post->ID,
					'post_type' => 'page',
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC'
				);
			
			$locations = get_children($args);
			
			$m_counterSub = 0;
			
			foreach($locations as $post) // get the location
			{
				$tmpPostId = $post->ID;
				$locationTextTop = get_field('location_text_top');
				$locationTextBottom = get_field('location_text_bottom');
				
				$finalText = (strlen($locationTextTop)>0) ? '<span class="text-top">'.$locationTextTop.'</span>' : '';
				$finalText .= (strlen($locationTextBottom)>0) ? (strlen($finalText)>0 ? '<br />' : '') . '<span class="text-bottom">'.$locationTextBottom.'</span>' : '';
				
				$finalText = 	sprintf(
										HTML_TEMPLATE_ANCHOR,
										'javascript:void(0);',
										'Show rooms from this location',
										' class="btn-location'.(($m_counterSub==0) ? ' active' : '').'" data-id="'.$tmpPostId.'"',
										$finalText
									);
				
				if(strlen($carouselHtml = TL_WP_Create_Carousel($tmpPostId, $m_counterSub+$m_counter))>0) // carousel is available
				{
					$m_tmpLocations .= $finalText;
					$m_tmpCarouselHTML .= $carouselHtml;
					
					$finalTextMobile = (strlen($locationTextTop)>0) ? $locationTextTop : '';
					$finalTextMobile .= (strlen($locationTextBottom)>0) ? ' ' . $locationTextBottom : '';
					
					$m_tmpLocationsMobile .=	sprintf(
															'<option value="%s">%s</option>',
															$tmpPostId,
															$finalTextMobile
														);
				} // if
				
				$m_counterSub++;
			} // foreach
			
			// create some HTML views
			if(strlen($m_tmpLocations)>0)
			{
				$m_finalLocations .=	sprintf(
												'<div class="location-links%s" data-location="%s">%s</div>',
												(($m_counter == 0) ? ' active' : ''),
												$key,
												$m_tmpLocations
											);
				
				$m_finalLocationsMobile .=	sprintf(
														'<select data-location="%s"%s>%s</select>',
														$key,
														(($m_counter == 0) ? ' class="active"' : ''),
														$m_tmpLocationsMobile
													);
				
				$m_finalLocationsMain .=	sprintf(
														HTML_TEMPLATE_ANCHOR,
														'javascript:void(0);',
														'Locations in ' . $item,
														' class="btn-location-main'.(($m_counter==0) ? ' active' : '').'" data-key="'.$key.'"',
														$item
													);
				
				$m_finalLocationsMainMobile .=	sprintf(
																'<option value="%s">%s</option>',
																$key,
																$item
															);
			} // if
			
			$m_counter++;
		} // foreach
		
		if(strlen($m_finalLocationsMain)>0) // create the outer container
			$m_finalLocationsMain = sprintf(
												'<div class="location-main-container clearfix">%s%s</div>',
												'<div class="hidden-xs">'.$m_finalLocationsMain.'</div>',
												'<div class="visible-xs-block"><select>'.$m_finalLocationsMainMobile.'</select></div>'
											);

		if(strlen($m_finalLocations)>0) // create the outer container
			$m_finalLocations = 	sprintf(
											'<div class="location-sub-container clearfix">%s%s</div>',
											'<div class="hidden-xs">'.$m_finalLocations.'</div>',
											'<div class="visible-xs-block">'.$m_finalLocationsMobile.'</div>'
										);
		
		$m_return = 	sprintf(
								$carousel,
								$m_finalLocationsMain . $m_finalLocations,
								$m_tmpCarouselHTML
							);
		
		wp_reset_postdata();
		
		return $m_return;
	} // TL_WP_Book_An_Event_Carousel

/* Admin
======================================= */
if(is_admin())
{
	wp_enqueue_script( 'tl-wp-admin', get_template_directory_uri().'/scripts/admin.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_style('tl-wp-admin', get_template_directory_uri().'/admin.css');
} // if


/* Site Functions
======================================== */

/*
 *		This is the front page logic
 *
 *		@author			Trusty Logic Inc.
 *		@version			2015-05-09
 *
 *		@return			homepage logic
 */
function TL_WP_Get_Stackable()
{
	global $post;
	
	$m_return = array();
	
	if(have_rows('stackable')) // check if this post has the stackable ACF
	{ 
		while(have_rows('stackable')) // get the information
		{
			the_row();
			
			$type = get_sub_field('stackable_column_type');
			$m_arrTmp = array();
			
			while(have_rows('stackable_columns')) // get the column info
			{
				the_row();
				
				$image = get_sub_field('stackable_image');
				$textTop = trim(get_sub_field('stackable_text_top'));
				$textBottom = trim(get_sub_field('stackable_text_bottom'));
				$link = get_sub_field('stackable_link');
				$outboundLink = get_sub_field('stackable_outbound_link');
				$active = get_sub_field('stackable_active');
				
				
				if($active) // need to add to the array
				{
					$m_arrTmp[] =	array(
											'image' => $image,
											'text-top' => $textTop,
											'text-bottom' => $textBottom,
											'link' => $link,
											'outbound-link' => $outboundLink
										);
				} // if
			} // while
			
			if(count($m_arrTmp)>0) // add it to the array
				$m_return[] = array('type' => $type, 'data' => $m_arrTmp);
		} // while
	} // if
	
	wp_reset_postdata();
	
	$m_return = TL_WP_ACF_Stackable($m_return);
	
	return $m_return;
} // TL_WP_Get_Stackable

/*
 *		This is the logic for the location parent, which will show a stackable view
 *
 *		@author			Trusty Logic Inc.
 *		@version			2015-05-10
 *
 *		@return			homepage logic
 */
function TL_WP_Location_Parent()
{
	global $post;
	
	// retrieve the children of the parents
	$args = 	array(
					'post_parent' => $post->ID,
					'post_type' => 'page',
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC'
				);
	
	$locations = get_children($args);
	
	foreach($locations as $post) // get the information
	{
		$type = 'regular';
		$m_arrTmp = array();
		
		$m_arrTmp[] =	array(
								'image' => get_field('location_image'),
								'text-top' => trim(get_field('location_text_top')),
								'text-bottom' => trim(get_field('location_text_bottom')),
								'link' => $post,
								'outbound-link' => ''
							);
		
		$m_return[] = array('type' => $type, 'data' => $m_arrTmp);
	} // foreach
	
	wp_reset_postdata();
	
	$m_return = TL_WP_ACF_Stackable($m_return);
	
	return $m_return;
} // TL_WP_Location_Parent

/*
 *		This will take the stackable ACF and create the HTML logic
 *
 *		@author			Trusty Logic Inc.
 *		@version			2015-05-09
 *
 *		@param			$_arrData - data for creating the stackable
 *
 *		@return			HTML of the stackable
 */
function TL_WP_ACF_Stackable($_arrData = array())
{	
	$m_return = '';
	
	foreach($_arrData as $item) // go through the data
	{
		$m_arrTmp = array();
		$m_tmp = '';
		
		foreach($item['data'] as $data) // loop through the data
		{
			$tooltip = $data['text-top'] . ((strlen($data['text-bottom'])>0) ? ' ' . $data['text-bottom'] : '');
			$imageHTML =	($data['image'])
								? ' style="background-image:url('.$data['image']['url'].');"'
								: '';
								
			$textFinal =	'<span class="text-top">'.$data['text-top'].'</span>' .
								(
									(strlen($data['text-bottom'])>0)
									? '<br /><span class="text-bottom">'.$data['text-bottom'].'</span>'
									: ''
								);
							
			$linkFinal = '#';
			$extraAttr = '';
				
			if($data['link']) // creat the proper link and extra attr
				$linkFinal = get_permalink($data['link']->ID);
			else
			{
				if(array_key_exists('outbound-link', $data)) // add this
				{
					$linkFinal = $data['outbound-link'];
					$extraAttr = ' target="_blank"';
				} // if
			} // if
			
			$m_arrTmp[] =	array(
									'html' =>	sprintf(
														HTML_TEMPLATE_ANCHOR,
														$linkFinal,
														$tooltip,
														' class="vertical stackable" data-type="'.$item['type'].'"' . $extraAttr,
														$textFinal
													),
									'image' => $imageHTML
								);
		} // foreach
		
		foreach($m_arrTmp as $itemTmp) // create the columns
		{
			$m_tmp .=	sprintf(
								'<div class="col-sm-%s stackable-column"%s>%s</div>',
								(TLWP_MAX_COLS / count($m_arrTmp)),
								$itemTmp['image'],
								$itemTmp['html']
							);
		} // foreach
			
		$m_return .=	sprintf(
								'<div class="row no-gutter" data-col="%s">%s</div>',
								((count($m_arrTmp)>1) ? 'two_col' : 'one_col'),
								$m_tmp
							);
	} // foreach
	
	if(strlen($m_return)>0) // finish it off
	{
		 $m_return =	sprintf(
								'<div class="container-fluid" data-type="stackable">%s</div>',
								$m_return
							);
	} // if
	
	return $m_return;
} // TL_WP_ACF_Stackable


/*
 *		This will create the menu look
 *
 *		@author			Trusty Logic Inc.
 *		@version			2015-05-11
 *
 *		@return			HTML of the menu
 */
function TL_WP_Location_Menu()
{
	global $post;
	
	$m_return = '';
	$m_menu = '';
	$m_menuTabs = '';
	$m_menuTabsMobile = '';
	$m_counter = 0;
	
	if(have_rows('location_menu'))
	{
		while(have_rows('location_menu')) // get the information
		{
			the_row();
			$m_tmp = '';
			
			$title = get_sub_field('location_menu_title');
			$slug = 'menu-'.GlobalFunctions::Slugify($title);
			
			$m_menuTabs .=	sprintf(
									HTML_TEMPLATE_ANCHOR,
									'javascript:void(0);',
									'Click here to view the ' . $title,
									(($m_counter == 0) ? ' class="active"' : '') .' data-table-id="'.$slug.'"',
									$title
								);
			
			$m_menuTabsMobile .=	sprintf(
											'<option value="%s"%s>%s</option>',
											$slug,
											(($m_counter == 0) ? ' selected="selected"' : ''),
											$title
										);
			
			while(have_rows('location_menu_Items')) // get the menu items
			{
				the_row();
				
				$name = trim(get_sub_field('location_menu_item_name'));
				$desc = trim(get_sub_field('location_menu_item_description'));
				$price = trim(get_sub_field('location_menu_item_price'));
				$active = get_sub_field('location_menu_item_active');
				
				if($active) // add to the menu
				{
					$m_tmp .=	sprintf(
										'<tr><td data-col="meal">%s%s</td><td data-col="price"><strong>%s</strong></td></tr>',
										((strlen($name)>0) ? '<strong>'.$name.'</strong><br />' : ''),
										((strlen($desc)>0) ? $desc : ''),
										$price
									);
				} // if
			} // while
			
			$m_menu .= 	sprintf(
								'<table id="%s" class="table table-condensed%s"><tbody>%s</tbody></table>',
								$slug,
								(($m_counter == 0) ? ' active' : ''),
								$m_tmp
							);
			
			$m_counter++;
		} // while
	} // if
	
	if(strlen($m_menuTabs)>0) // create a container for this
	{
		$m_menuTabs = '<div class="hidden-xs">'.$m_menuTabs.'</div>';
		$m_menuTabsMobile = '<div class="visible-xs-block"><select id="menu-tab-mobile" size="1">'.$m_menuTabsMobile.'</select></div>';
		
		$m_menuTabs =	sprintf(
								'<div class="menu-tabs-container clearfix">%s</div>',
								$m_menuTabs . $m_menuTabsMobile
							);
	} // if
	
	if(strlen($m_menu)>0) // create a container for this
	{
		$m_menu =	sprintf(
							'<div class="menu-table-container clearfix">%s</div>',
							$m_menu
						);
	} // if
	
	$m_return = sprintf(
						'<div class="menu-container"><h3>Menu</h3>%s%s</div><div class="clearfix"></div>',
						$m_menuTabs,
						$m_menu
					);
	
	return $m_return;
} // TL_WP_Location_Menu

/*
 *		This will create the book an event form
 *
 *		@author			Trusty Logic Inc.
 *		@version			2015-05-13
 *
 *		@return			HTML of the book an event form
 */
function TL_WP_Create_Book_An_Event_Form()
{
	wp_enqueue_script( 'tl-wp-masked-input', get_template_directory_uri().'/scripts/libs/jquery.maskedinputs.min.js', array( 'jquery' ), '1.3.1', true );
	
	wp_enqueue_style( 'tl-wp-jquery-ui', get_template_directory_uri().'/packages/jquery-ui/jquery-ui.min.css' );
	wp_enqueue_script( 'tl-wp-jquery-ui-js', get_template_directory_uri().'/packages/jquery-ui/jquery-ui.min.js', array( 'jquery' ), '1.11.4', true );
	
	wp_enqueue_script( 'tl-wp-jquery-validate', get_template_directory_uri().'/scripts/libs/jquery-validate/jquery.validate.min.js', array( 'jquery' ), '1.10.0', true );
	wp_enqueue_script( 'tl-wp-jquery-validate-additional-methods', get_template_directory_uri().'/scripts/libs/jquery-validate/additional-methods.js', array( 'jquery' ), '1.10.0', true );
	
	global $post;
	
	$m_arrValues = array();
	$m_return = '<div class="clearfix separator"><p class="red disclaimer">* - Mandatory Field</p></div><form id="frmBookAnEvent" name="frmBookAnEvent" action="%s" method="post">%s</form>';
	
	$postId = $post->ID;
	
	$m_contactTime = '';
	$m_serviceType = '';
	$m_venue = '';
	$m_status = 0;
	$m_sessionId = date('YmdHis');
	
	$valid = true;
	$errMsg = '';
	$fieldKey = 'field_555381cccfc6e';
	
	// check if there is a post
	if(count($_POST)>0)
	{
		// save the values and send an email
		$arrValues = array('fullName' => '', 'email' => '', 'phone' => '', 'contactTime' => '', 'eventDate' => '', 'venue' => '', 'guests' => '', 'serviceType' => '', 'comment' => '', 'bookSession' => '');
		
		$nonValid = array('comment', 'bookSession');
		
		// retrieve all the parameters
		foreach($arrValues as $key => $item)
		{
			$tmp = ($_REQUEST[$key] != NULL) ? $_REQUEST[$key] : '';
			$arrValues[$key] = GlobalFunctions::cleanParamData($tmp);
			
			if(strlen($tmp)==0 && !in_array($key, $nonValid))
				$valid = false;
		} // foreach
		
		if(!$valid) // show an error
		{
			$errMsg = 'There was some missing data. Please try again.';
		}
		else // save the user
		{
			if($_SESSION['bookSession'] != null && $arrValues['bookSession'] == $_SESSION['bookSession'])
			{
				// do nothing. Blocks postback
			}
			else // save and send email
			{
				$acfEvent = get_field('event');

				if(!$acfEvent) // make a blank array
					$acfEvent = array();
			
				$arrTmp =	array(
										'event_full_name' => $arrValues['fullName'],
										'event_email' => $arrValues['email'],
										'event_phone' => $arrValues['phone'],
										'event_time' => $arrValues['contactTime'],
										'event_date' => str_replace('-', '', $arrValues['eventDate']),
										'event_venue' => $arrValues['venue'],
										'event_guest_count' => $arrValues['guests'],
										'event_service_type' => $arrValues['serviceType'],
										'event_comments' => $arrValues['comment'],
										'event_active' => true,
										'event_create_date' => date('Ymd')
									);
					
				$acfEvent = array_merge(array($arrTmp), $acfEvent);
			
				update_field($fieldKey, $acfEvent, $postId);
				
				$_SESSION['bookSession'] = $arrValues['bookSession'];
				
				// send email
				$body =	'
							Hello %s,<br /><br />
							%s<br /><br />
							<strong>Full Name:</strong> %s<br />
							<strong>Email:</strong> %s<br />
							<strong>Phone:</strong> %s<br />
							<strong>Event Time:</strong> %s<br />
							<strong>Event Date:</strong> %s<br />
							<strong>Venue:</strong> %s<br />
							<strong>Number of Guests:</strong> %s<br />
							<strong>Type Of Service</strong> %s<br />
							<strong>Comments:</strong> %s<br /><br />
							=========================================<br /><br />
							Please do not reply back to this email.
							';
							
				$venuePage = get_page($arrValues['venue']);
							
				// send to the user
				$tmpBody =	sprintf(
									$body,
									$arrValues['fullName'],
									'Thank you for your event inquiry at one of our Terroni locations. We will get in touch with you as soon as possible to confirm your reservation.',
									$arrValues['fullName'],
									$arrValues['email'],
									$arrValues['phone'],
									$arrValues['contactTime'],
									$arrValues['eventDate'],
									$venuePage->post_title,
									$arrValues['guests'],
									$arrValues['serviceType'],
									$arrValues['comment']
								);
				
				wp_reset_postdata();
				
				send_email($arrValues['email'], TLWP_BOOKANEVENT_SUBJECT, $tmpBody, array(), array(), TLWP_BOOKANDEVENT_FROM);
				
				// send to admin
				$tmpBody =	sprintf(
									$body,
									'TERRONI Admin',
									'Someone has booked an event at one of your TERRONI locations. Here are the details below.',
									$arrValues['fullName'],
									$arrValues['email'],
									$arrValues['phone'],
									$arrValues['contactTime'],
									$arrValues['eventDate'],
									$venuePage->post_title,
									$arrValues['guests'],
									$arrValues['serviceType'],
									$arrValues['comment']
								);
				
				send_email(TLWP_BOOKANDEVENT_TO, TLWP_BOOKANEVENT_SUBJECT, $tmpBody, array(), array('info@trustylogic.com'), TLWP_BOOKANDEVENT_FROM);
			} // if
			
			$m_status = 1;
		} // if
	} // if
	
	if($m_status == 0) // create the form
	{
		$acf = get_field_object($fieldKey);
			
		foreach($acf['sub_fields'] as $item) // find province and occupation
		{
			if($item['name'] == 'event_time') // province
			{
				foreach($item['choices'] as $key => $item) // get all the choices
				{
					$m_contactTime .=	sprintf(
												'<option value="%s"%s>%s</option>',
												$key,
												(
													(array_key_exists('contactTime', $m_arrValues) && $m_arrValues['contactTime'] == $key)
													? ' selected="selected"'
													: ''
												),
												$item
											);
				} // foreach
			}
			elseif($item['name'] == 'event_service_type')
			{
				foreach($item['choices'] as $key => $item) // get all the choices
				{
					$m_serviceType .=	sprintf(
												'<option value="%s"%s>%s</option>',
												$key,
												(
													(array_key_exists('serviceType', $m_arrValues) && $m_arrValues['serviceType'] == $key)
													? ' selected="selected"'
													: ''
												),
												$item
											);
				} // foreach
			}
			elseif($item['name'] == 'event_venue') // we need to create the select based off some pages
			{
				$m_arrVenue = array();
				$m_arrTitles = array('terroni-toronto' => 'TERRONI Toronto', 'terroni-los-angeles' => 'TERRONI Los Angeles');
				$m_venue = '';
				
				foreach($m_arrTitles as $key => $title)
				{
					$post = get_page_by_path($key);
					$m_tmp = '';
				
					// retrieve the children of the parents
					$args = 	array(
									'post_parent' => $post->ID,
									'post_type' => 'page',
									'posts_per_page' => -1,
									'orderby' => 'menu_order',
									'order' => 'ASC'
								);
					
					$venues = get_children($args);
				
					foreach($venues as $item) // get the venues
					{
						$m_tmp .=	sprintf(
											'<option value="%s"%s>%s</option>',
											$item->ID,
											(
												(array_key_exists('venue', $m_arrValues) && $m_arrValues['venue'] == $item->ID)
												? ' selected="selected"'
												: ''
											),
											$item->post_title
										);
					} // foreach
					
					wp_reset_postdata();
					
					if(strlen($m_tmp)>0) // create the optgroup
						$m_venue .= '<optgroup label="'.$title.'">'.$m_tmp.'</optgroup>';
				} // foreach
				
				if(strlen($m_venue)>0) // add a blank
					$m_venue = '<option value="">Select</option>' . $m_venue;
			} // if
		} // foreach
		
		$m_tmpForm =	'
							<div id="error-book-an-event" class="alert alert-danger%s"><strong>%s</strong></div>
							<div class="form-group">
								<label for="fullName">Full Name: *</label>
								<input type="text" class="form-control" id="fullName" name="fullName" placeholder="" maxlength="100" tabindex="100" value="'.((array_key_exists('fullName', $m_arrValues)) ? $m_arrValues['fullName'] : '').'" />
							</div>
							<div class="form-group">
								<label for="email">Email: *</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="" maxlength="200" tabindex="200" value="'.((array_key_exists('email', $m_arrValues)) ? $m_arrValues['email'] : '').'" />
							</div>
							<div class="form-group">
								<label for="phone">Phone: *</label>
								<input type="text" class="form-control" id="phone" name="phone" placeholder="" maxlength="20" tabindex="300" value="'.((array_key_exists('phone', $m_arrValues)) ? $m_arrValues['phone'] : '').'" />
							</div>
							<div class="form-group">
								<label for="contactTime">Event Time: *</label>
								<select id="contactTime" name="contactTime" class="form-control" tabindex="400">'.$m_contactTime.'</select>
							</div>
							<div class="form-group">
								<label for="eventDate">Event Date: *</label>
								<input type="text" class="form-control" id="eventDate" name="eventDate" maxlength="20" tabindex="500" value="'.((array_key_exists('eventDate', $m_arrValues)) ? $m_arrValues['eventDate'] : '').'" />
							</div>
							<div class="form-group">
								<label for="venue">Venue: *</label>
								<select id="venue" name="venue" class="form-control" tabindex="600">'.$m_venue.'</select>
							</div>
							<div class="form-group">
								<label for="guests">Number Of Guests: *</label>
								<input type="text" class="form-control" id="guests" name="guests" placeholder="" maxlength="5" tabindex="700" value="'.((array_key_exists('guests', $m_arrValues)) ? $m_arrValues['guests'] : '').'" />
							</div>
							<div class="form-group">
								<label for="serviceType">Type Of Service: *</label>
								<select id="serviceType" name="serviceType" class="form-control" tabindex="800">'.$m_serviceType.'</select>
							</div>
							<div class="form-group">
								<label for="comment">Anything else we should know?:</label>
								<textarea id="comment" name="comment" tabindex="900" placeholder="">'.((array_key_exists('comment', $m_arrValues)) ? $m_arrValues['comment'] : '').'</textarea>
							</div>
							<div class="form-group">
								<div class="text-center">
									<a id="btn-book-an-event-submit" href="javascript:void(0);" title="Submit" class="btn-tl-wp">Submit</a>
									<img src="'.get_template_directory_uri().'/images/ajax-loader-init.gif" alt="Booking..." title="Booking..." class="loader" />
								</div>
							</div>
							<input type="hidden" id="bookSession" name="bookSession" value="%s" />
							';
		
		$m_return =	sprintf(
							$m_return,
							get_permalink($post->ID),
							sprintf(
								$m_tmpForm,
								((strlen($errMsg)>0) ? '' : ' hideObj'),
								$errMsg,
								$m_sessionId
							)
						);
	}
	else // create thank you view
	{
		$m_return =	'
						<div id="book-an-event-thanks-container" class="clearfix">
							<p>
								<strong class="uppercase">Thanks</strong><br />
								Your information has been Submitted.<br />You will hear from us shortly.
							</p>
							
						</div>
						';
	} // if
	
	return $m_return;
} // TL_WP_Create_Book_An_Event_Form

/*
 *		This function will create the carousel
 *
 *		@author			Trusty Logic Inc.
 *		@version			2015 05 19
 *
 *		@param			$_postId			Post ID
 *		@param			$_curPos			For active setting
 *
 *		@return			HTML of the carousel
 */
function TL_WP_Create_Carousel($_postId = -1, $_curPos = 0)
{
	global $post;
	
	$m_return = '';
	
	if($_postId > 0) // get the post
	{
		$postId = $_postId;
		$post = get_post($_postId);
	}
	else
		$postId = $post->ID;

	// retrieve the carousel ACF
	if(get_field('location_carousel'))
	{
		$arrCarousel = array();
		$counter = 0;
		$perCarousel = 2;
		
		$m_templateMobile =	'
									<div class="visible-xs-block">
										<div id="%1$s" class="carousel slide%3$s" data-ride="carousel" data-interval="false">
											<!-- Wrapper for slides -->
											<div class="carousel-inner" role="listbox">%2$s</div>
										 
											<!-- Controls -->
											<a class="left carousel-control" href="#%1$s" role="button" data-slide="prev">
											  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
											  <span class="sr-only">Previous</span>
											</a>
											<a class="right carousel-control" href="#%1$s" role="button" data-slide="next">
											  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
											  <span class="sr-only">Next</span>
											</a>
										</div>
									</div>
									';
									
		$m_tmpMobile = '';
		
		while(has_sub_field('location_carousel')) // get all the carousels
		{
			$image = get_sub_field('location_carousel_image');
			$title = get_sub_field('location_carousel_title');
			$metaData = get_sub_field('location_carousel_meta_data');
			$active = get_sub_field('location_carousel_active');
			
			$m_tmp = '';
			
			if($active) // save the item
			{
				$tmpTitle = ((strlen($title)>0) ? '<span class="text-top">'.$title.'</span><br />' : '');
				$tmpTitle .= ((strlen($metaData)>0) ? '<span class="text-bottom">'.$metaData.'</span>' : '');
				
				$m_tmp = sprintf(
								'<div class="carousel-item" data-id="%s"%s><div class="overlay"></div>%s<div class="description hideObj">%s</div></div>',
								$counter,
								'%s',
								(
									($image)
									?	sprintf(
											HTML_TEMPLATE_IMAGE,
											$image['url'],
											'',
											''
										)
									: ''
								),
								$tmpTitle
							);
				
				$m_tmpMobile .= 	sprintf(
											'<div class="item%s">%s<div class="description hideObj">%s</div></div>',
											(($counter == 0) ? ' active' : ''),
											(
												($image)
												?	sprintf(
														HTML_TEMPLATE_IMAGE,
														$image['url'],
														'',
														''
													)
												: ''
											),
											$tmpTitle
										);
				
				$arrCarousel[] = array('html' => $m_tmp, 'counter' => $counter);
			} // if
			
			$counter++;
		} // while
		
		// fill carousel
		if(count($arrCarousel)>1)
		{
			$arrBegin = array();
			$arrEnd = array();
			$arrTmp = array();
			
			if(count($arrCarousel) == 2) // we need to repeat 1 and 2
			{
				$arrBegin = $arrCarousel;
				$arrEnd = $arrCarousel;
			}
			else
			{
				$arrBegin = array_slice($arrCarousel, -2, $perCarousel);
				$arrEnd = array_slice($arrCarousel, 0, $perCarousel);
			} // if
			
			foreach($arrBegin as $item) // set the goto
			{
				$tmp = sprintf($item['html'], sprintf(' data-goto="%s"', $item['counter']+$perCarousel));
				$arrTmp[] = array('html' => $tmp, 'counter' => $item['counter']);
			} // foreach
			
			$arrBegin = $arrTmp;
			$arrTmp = array();
			
			foreach($arrEnd as $item) // set the goto
			{
				$tmp = sprintf($item['html'], sprintf(' data-goto="%s"', $item['counter']+$perCarousel));
				$arrTmp[] = array('html' => $tmp, 'counter' => $item['counter']);
			} // foreach
			
			$arrEnd = $arrTmp;
			$arrTmp = array();
		} // if
		
		foreach($arrCarousel as $item) // set the goto
		{
			$tmp = sprintf($item['html'], '');
			$arrTmp[] = array('html' => $tmp, 'counter' => $item['counter']);
		} // foreach
		
		$arrCarousel = array_merge($arrBegin, $arrTmp, $arrEnd);
		
		foreach($arrCarousel as $item) // create the html
			$m_return .= $item['html'];
			
		$m_return =	sprintf(
							'
							<div class="carousel-container hidden-xs%4$s" data-post-id="%3$s">
								<div class="carousel-inner">%1$s</div>
								<a href="javascript:void(0);" title="Previous" class="btn-carousel-arrow" data-arrow="left"><img src="%2$s/images/icons/icn-arrow-left.png" alt="Previous" /></a>
								<a href="javascript:void(0);" title="Next" class="btn-carousel-arrow" data-arrow="right"><img src="%2$s/images/icons/icn-arrow-right.png" alt="Next" /></a>
							</div>
							',
							$m_return,
							get_template_directory_uri(),
							$post->ID,
							(($_curPos==0) ? ' active' : '')
						) .
						sprintf(
							$m_templateMobile,
							'carousel-container-mobile-' . $postId,
							$m_tmpMobile,
							(($_curPos==0) ? ' active' : '')
						);
	} // if
	
	if($_postId > 0) // reset
		wp_reset_postdata();
	
	return $m_return;
} // TL_WP_Create_Carousel

/**
 *	This will check if there is a ACF for the footer
 *
 *	@author	Vincent Kwan
 *	@version	2015 07 13
 *
 *	@return	string	HTML if there is the ACF
 *
 */
function TL_WP_Our_Story_Footer()
{
	global $post;
	
	$m_return = '';
	
	// if this exists then create the string
	if(get_field('our_story_background_image'))
	{
		$bgImage = get_field('our_story_background_image');
		$text = get_field('our_story_text');
		$link = get_field('our_story_link');
		
		$m_return = sprintf('<div class="footer-banner" style="background-image:url(%s);">%s</div>',
			$bgImage['url'],
			sprintf(
				HTML_TEMPLATE_ANCHOR,
				$link,
				$text,
				'',
				$text
			)
		);
	} // if
	
	return $m_return;
} // TL_WP_Our_Story_Footer

/* Wordpress Global Functions
======================================== */

/*
 *		This function will send the email
 *
 *		@author			Trusty Logic Inc.
 *		@version			2015 04 26
 *
 *		@param			$_from		From who?
 *		@param			$_fromName	Name of the sender
 *		@param			$_to			To Email
 *		@param			$_subject	The email subject
 *		@param			$_body		The body copy
 *		@param			$_cc			CC anyone?
 *		@param			$_bcc			BCC anyone?
 *
 *		@return			Sends email using PHP-Mailer
 */
function send_email($_to = '', $_subject = '', $_body = '', $_cc = array(), $_bcc = array(), $_from = 'info@terroni.com', $_fromName = 'Terroni')
{
	require_once('class/PHPMailer/class.phpmailer.php');

	$m_return = true;
	
	if(!GlobalFunctions::CompareStrings(WP_ENV, 'dev')) // send the email
	{
		try // try to send the email
		{
			$email = new PHPMailer();
			$email->From = $_from;
			$email->FromName = $_fromName;
			$email->addAddress($_to);
			$email->Subject = $_subject;
			$email->Body =	$_body;
			$email->isHTML(true);
			
			// add CC
			foreach($_cc as $item)
				$email->addCC($item);
				
			// add BCC
			foreach($_bcc as $item)
				$email->addBCC($item);				
	
			if(!$email->send()) // problems
			{
				error_log(sprintf('Email: Could not send email for %s to %s', $_subject, $_to));
				$m_return = false;
			} // if
		}
		catch(Exception $e)
		{
			error_log(sprintf('Email: Error trying to send email for %s to %s. Msg: %s', $_subject, $_to, $e->getMessage()));
			$m_return = false;
		} // try/catch
	}
	else // print the body 
		echo $_body;
	
	return $m_return;
} // send_email

/*
 *		This will retrieve the first parent category
 *
 *		@author			Trusty Logic Inc.
 *		@version			2015-02-15
 *		@see				http://www.endreywalder.com/blog/get-the-first-parent-category-only-from-a-wordpress-post/
 *
 *		@param			$_id				ID of the category
 *		@param			$_secondLvl		Get the Second Level
 *
 *		@return			category object
 */
function get_the_first_parent_category_only($_id, $_secondLvl = false)
{
	$categories = get_the_category($_id);
	$parent_categories = array();
	$prevCat = null;
	
	if($categories) // do we have categories
	{
		foreach($categories as $category) // get all the categories
		{
			var_dump($category);
			
			if($category->parent == 0) // add
			{
				$parent_categories[] = ($_secondLvl) ? $prevCat : $category;
				break;
			} // if
			
			if($prevCat != $category) // catch the category
				$prevCat = $category;
		} // foreach
	} // if	

	return (isset($parent_categories[0])) ? $parent_categories[0] : false;
} // get_the_first_parent_category_only

/*
 *		This will add a class to the Mailchimp form
 *
 *		@author			Mandy Thomson 
 *		@version			2015-02-15
 *		@see				https://mc4wp.com/kb/add-css-class-to-form-element/
 *		@param			$classes			Array of classes to be added to form
 *		@return			$classes
 */

add_filter( 'mc4wp_form_css_classes', function( $classes ) { 
	$classes[] = 'form-inline clearfix';
	return $classes;
});

?>