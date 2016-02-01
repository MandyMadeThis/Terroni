<?php
/**
 * @package WordPress
 * @subpackage WP-Bootstrap
 */
?>
<?php

	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		This post is password protected. Enter the password to view comments.
	<?php
		return;
	}
?>

	<h2 id="comments">Comments</h2>

<?php if ( have_comments() ) : ?>
	<?php
		// get all comments
		$args = 	array(
								'status' => 'approve',
								'post_id' => $post->ID
					);
	
		$comments = get_comments($args);
		$commentHTML = '';
		$commentTmpHTML = '';
		$commentCounter = 0;
		$commentMaxRow = 3;
		$commentPage = 1;
		
		foreach($comments as $comment) // show the comments
		{
			if($commentCounter % $commentMaxRow == 0 && $commentCounter != 0) // create the page
			{
				$commentHTML .=	sprintf(
													'<div class="content-page full-width clearfix%s">%s</div>',
													($commentPage != 1) ? ' hide' : '',
													$commentTmpHTML
										);
				
				$commentPage++;
				$commentTmpHTML = '';
			} // if
			
			$commentTmpHTML .= 	sprintf(
													'
													<p><strong>%s</strong><br />%s</p>
													',
													date('M j, Y', strtotime($comment->comment_date)) . ' by ' . $comment->comment_author,
													strip_tags($comment->comment_content)
										);
			
			$commentCounter++;
		} // foreach
		
		$commentHTML .=	sprintf(
											'<div class="content-page full-width clearfix%s">%s</div>',
											($commentPage != 1) ? ' hide' : '',
											$commentTmpHTML
								);
		
		
		echo '<div class="content-container full-width clearfix">' . $commentHTML . '</div>';
	?>

	<div class="navigation full-width clearfix" data-count="<?php echo $commentPage;?>">
		<div class="navigation-inner">
			<div class="navigation-previous pull-left">
				<a href="javascript:void(0);" title="Previous">&laquo; Previous</a>
			</div>
			<div class="navigation-pagination pull-left">
				<div class="navigation-pagination-inner">
					<?php
						$paginationMax = 3;
						$paginationHTML = '';
						
						$paginationCount = 	($commentPage >= $paginationMax)
													? $paginationMax
													: $commentPage;
						
						for($i=1;$i<=$paginationCount;$i++) // create the pagination
						{
							$paginationHTML .=	sprintf(
																HTML_TEMPLATE_LIST,
																' data-id="'.$i.'"' . (($i==1) ? ' class="active"' : ''),
																sprintf(
																			HTML_TEMPLATE_ANCHOR,
																			'javascript:void(0);',
																			'Go to Page:' . $i,
																			'',
																			$i
																)
													);
						} // for
						
						if($commentPage > $paginationMax) // need to add the ... and last page
						{
							$paginationHTML .=	sprintf(
																	HTML_TEMPLATE_LIST,
																	'',
																	'...'
														) .
														sprintf(
																	HTML_TEMPLATE_LIST,
																	' data-id="'.$commentPage.'"',
																	sprintf(
																				HTML_TEMPLATE_ANCHOR,
																				'javascript:void(0);',
																				'Go to Page:' . $commentPage,
																				'',
																				$commentPage
																	)
														);
						} // if
						
					?>
					<ul><?php echo $paginationHTML;?></ul>
				</div>
			</div>
			<div class="navigation-next pull-left">
				<a href="javascript:void(0);" title="Next">Next &raquo;</a>
			</div>
		</div>
	</div>
	
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<p>Comments are closed.</p>

	<?php endif; ?>
	
<?php endif; ?>

<?php if ( comments_open() ) : ?>

<div class="clearfix separator"></div>
<div id="respond">

	<div class="hr"></div>
	
	<h2 class="separator">Comments</h2>
	
	<p><span class="red">*</span> Mandatory Field</p>

	<div class="cancel-comment-reply">
		<?php cancel_comment_reply_link(); ?>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

		<?php if ( is_user_logged_in() ) : ?>

			<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>

		<?php else : ?>

			<div class="control-group">
				<div class="controls">
					<label for="author" class="control-label">Name: <?php if ($req) echo '<span class="red">*</span>'; ?></label>
					<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
					<span class="help-inline hide">Name is required</span>
				</div>
			</div>

			<div class="hide">
				<input type="text" name="email" id="email" value="guestbook@paynefuneralhome.com" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
				<label for="email">Mail (will not be published) <?php if ($req) echo "(required)"; ?></label>
			</div>

			<div class="hide">
				<input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
				<label for="url">Website</label>
			</div>

		<?php endif; ?>

		<!--<p>You can use these tags: <code><?php echo allowed_tags(); ?></code></p>-->

		<div class="control-group">
			<div class="controls">
				<label for="comment" class="control-label">Comment: <?php if ($req) echo '<span class="red">*</span>'; ?></label>
				<textarea name="comment" id="comment" cols="58" rows="10" tabindex="4"></textarea>
				<span class="help-inline hide">Comment is required</span>
			</div>
		</div>

		<div>
			<a href="javascript:void(0);" id="submit" name="submit" class="btn-casted pull-left" tabindex="5">Submit Comment</a>
			<div class="loader"></div>
			<?php comment_id_fields(); ?>
		</div>
		
		<?php do_action('comment_form', $post->ID); ?>

	</form>

	<?php endif; // If registration required and not logged in ?>
	
</div>

<?php endif; ?>
