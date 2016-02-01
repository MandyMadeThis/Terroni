<?php
/**
 * @package WordPress
 * @subpackage WP-Bootstrap
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->    
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<title><?php wp_title('|',true,'right'); ?><?php bloginfo('name'); ?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	
	<!-- Mobile Specific Metas
	================================================== -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSS
	================================================== -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/packages/twitter-bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/packages/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" href= "<?php echo get_template_directory_uri(); ?>/style.css?v=6" />
	
	<!--[if gte IE 9]>
	<style type="text/css">
		header .right-header #header-login a {
			filter: none;
		}
	</style>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/favicon.ico?v=328" />
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon.png?v=328" />
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-57x57.png?v=328" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-72x72.png?v=328" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-114x114.png?v=328" />
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-144x144.png?v=328" />

	<?php wp_head(); ?>
	
	<!-- Javascript (non-enqueue)
	=================================================== -->
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   <!--[if lt IE 9]>
		<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->
	
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/packages/twitter-bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/libs/jquery.smooth-scroll.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/libs/jquery.waypoints.min.js"></script>
   <?php
		require_once 'class/mobileDetect.class.php';
		$detect = new Mobile_Detect;
		
		if($detect->isMobile()):
	?>
	<?php else:?>
	<?php endif ?>
	
	<script type="text/javascript">
		var tlwp = {};
		tlwp.mobile = <?php echo ($detect->isMobile()) ? 'true' : 'false';?>;
		tlwp.tablet = <?php echo ($detect->isTablet()) ? 'true' : 'false';?>;
		tlwp.url = '<?php echo get_site_url();?>';
		tlwp.uri = '<?php echo get_template_directory_uri(); ?>';
		
		tlwp.fontSize = {};
		tlwp.fontSize.originalWidth = 1024;
		tlwp.fontSize.originalFontSize = 16;
		tlwp.fontSize.curWidth = 1024;
		tlwp.fontSize.curFontSize = 16;
		tlwp.fontSize.minFontSize = 9;
		tlwp.fontSize.maxWidth = 1600;
	</script>	
	
	<?php if ( function_exists( 'ot_get_option' ) && strlen($gacode = ot_get_option('general_google_analytics')) > 0 ): ?>
	<!-- Google Analytics
	=================================================== -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', '<?php echo $gacode;?>', 'popvinyleh.com');
	  ga('send', 'pageview');
	
	</script>
	<?php endif ?>
</head>

	<body <?php body_class(); ?>><!-- the Body  -->
		<div id="init-loader" class="text-center hideObj">
			<div class="vertical">
				<div class="inline-block">
					<img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader-init.gif" alt="Loading..." title="Loading..." />
					<?php /*
					<div class="loading-content pull-left">LOADING...</div>
					<div class="loading-loader pull-left"></div>
					*/?>
				</div>
			</div>
		</div>
		<div id="wrapper">