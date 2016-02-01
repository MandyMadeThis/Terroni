<?php
	// Add any variables here that can be called at any time.
	
	define( 'TLWP_MAX_COLS', 12 );

// settings for different servers
	if(strpos($_SERVER['SERVER_NAME'],'dev')!==false) // dev
	{
		define('WP_ENV', 'dev');
		define('WP_HOST_HEADER', '//wp-terroni.usful.dev');
		
		define('TLWP_BOOKANEVENT_SUBJECT', '(DEV) Terroni - Book An Event');
		define('TLWP_BOOKANDEVENT_FROM', 'info@terroni.com');
		define('TLWP_BOOKANDEVENT_TO', 'info@trustylogic.com');
	} 
	elseif(strpos($_SERVER['SERVER_NAME'],'trustylogic')!==false) // stg
	{
		define('WP_ENV', 'stg');
		define('WP_HOST_HEADER', '//terroni.trustylogic.com');
		
		define('TLWP_BOOKANEVENT_SUBJECT', '(STG) Terroni - Book An Event');
		define('TLWP_BOOKANDEVENT_FROM', 'info@terroni.com');
		define('TLWP_BOOKANDEVENT_TO', 'info@trustylogic.com');
	}
	else // prod
	{
		define('WP_ENV', 'prod');
		define('WP_HOST_HEADER', '//www.terroni.com');
		
		define('TLWP_BOOKANEVENT_SUBJECT', 'Terroni - Book An Event');
		define('TLWP_BOOKANDEVENT_FROM', 'info@terroni.ca');
		define('TLWP_BOOKANDEVENT_TO', 'info@terroni.ca');
	} // if
?>