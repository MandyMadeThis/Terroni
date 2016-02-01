<?php
/**
 * @package WordPress
 * @subpackage WP-Bootstrap
 */
?>
<?php
get_header(); 
get_template_part( 'menu', 'index' ); //the  menu + logo/site title
?>

<?php the_post(); ?>

<?php
$content = apply_filters ("the_content", $post->post_content);
?>


	<div class="container">
		<div class="row">
			<div id="full-width-content" class="col-sm-8 col-sm-offset-2" data-section="blog-single">
				<h1><?php echo get_the_title();?></h1>
				<?php
					if(strlen($subTitle = get_field('blog_sub_title'))>0)
						echo '<h2>'.$subTitle.'</h2>';
				?>
				<div class="clearfix separator"></div>
				<?php if(strlen($video = get_field('blog_video_url'))>0):?>
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" src="<?php echo $video;?>"></iframe>
				</div>
				<?php elseif($image = get_field('blog_image')): ?>
				<div class="full-width">
					<img src="<?php echo $image['url'];?>" alt="" title="" class="img-responsive" />
				</div>
				<?php endif ?>
				<div class="clearfix separator"><?php echo $content;?></div>
			</div>
		</div>
		<?php echo TL_WP_Latest_Blog_Posts();?>
	</div>
		
<?php get_footer(); ?>