<?php 
/**
 * @package WordPress
 * @subpackage WP-Bootstrap
 */
?>

<?php
   if($post->post_parent > 0) // get the parent
   {
      $post = get_post($post->post_parent);
      $parentPost = ' data-parent="'.$post->post_name.'"';
      wp_reset_postdata();
   }
   else
      $parentPost = '';
      
?>
<header class="hidden-xs full-width"<?php echo $parentPost;?>>
   <?php
      $mobileClass = '';
      $mobileTitle = '';
      $mobileUrl = '';
      
      // get the page template as we might need to change the menu
      $pageTemplate = str_replace('.php', '', basename(get_page_template()));
      
      if(is_single()) // manually make this a blog menu
         $pageTemplate = 'page-blog';
      
      switch($pageTemplate) // switch the nav
      {
         case 'page-blog':
            $mobileClass = ' blog';
            $mobileTitle = 'Terroni Talks';
            $mobileUrl = home_url('terroni-talks');
            wp_nav_menu( array( 'theme_location' => 'terroni-talk', 'container' => 'nav', 'container_id' => 'nav-primary-blog', 'container_class' => 'nav-header-container', 'menu_class' => 'nav-header', 'walker' => new wp_bootstrap_navwalker() ) );
            break;
         
         default:
            $mobileClass = '';
            $mobileTitle = 'Terroni';
            $mobileUrl = home_url('');
            wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'container_id' => 'nav-primary', 'container_class' => 'nav-header-container', 'menu_class' => 'nav-header', 'walker' => new wp_bootstrap_navwalker() ) );
            break;
      } // switch
   ?>
</header>
<div class="visible-xs-block">
   <nav class="navbar navbar-default navbar-fixed-top<?php echo $mobileClass;?>"<?php echo $parentPost;?>>
      <div class="container">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
         </div>
         <div id="navbar" class="navbar-collapse collapse">
         <?php
            switch($pageTemplate) // switch the nav
            {
               case 'page-blog':
                  wp_nav_menu( array( 'theme_location' => 'terroni-talk', 'container' => false, 'menu_id' => 'menu-primary-mobile', 'menu_class' => 'nav navbar-nav menu-header', 'walker' => new wp_bootstrap_navwalker() ) );
                  //wp_nav_menu( array( 'theme_location' => 'terroni-talk', 'container_class' => 'header-nav', 'menu_class' => 'nav', 'walker' => new wp_bootstrap_navwalker() ) );
                  //wp_nav_menu( array( 'theme_location' => 'terroni-talk', 'container' => 'nav', 'container_id' => 'nav-primary-blog-mobile', 'container_class' => 'nav-header-container', 'menu_class' => 'nav-header', 'walker' => new wp_bootstrap_navwalker() ) );
                  break;
               
               default:
                  wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_id' => 'menu-primary-mobile', 'menu_class' => 'nav navbar-nav menu-header', 'walker' => new wp_bootstrap_navwalker() ) );
                  //wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'container_id' => 'nav-primary-mobile', 'container_class' => 'nav-header-container', 'menu_class' => 'nav-header', 'walker' => new wp_bootstrap_navwalker() ) );
                  break;
            } // switch
         ?>
         </div><!--/.nav-collapse -->
      </div>
   </nav>
</div>   
<!-- <div class="clearfix"></div> -->
<section id="body">