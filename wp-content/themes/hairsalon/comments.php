<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package woafun
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$config = HBFactory::getConfig();
$app_id= (string)$config->facebook_app_id;

?>

<div id="comments" class="comments-area">
	<?php if($config->comment_facebook){?>
	<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.7&appId=<?php echo $app_id?>";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		<div class="fb-comments" data-href="<?php echo 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";?>" data-width="100%" data-order-by="social"></div>
	<?php }else{?>
	
		<?php if ( have_comments() ) : ?>
			<h2 class="comments-title">
				<?php
					$comments_number = get_comments_number();
					if ( 1 === $comments_number ) {
						/* translators: %s: post title */
						printf( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'twentysixteen' ), get_the_title() );
					} else {
						printf(
							/* translators: 1: number of comments, 2: post title */
							_nx(
								'%1$s thought on &ldquo;%2$s&rdquo;',
								'%1$s thoughts on &ldquo;%2$s&rdquo;',
								$comments_number,
								'comments title',
								'twentysixteen'
							),
							number_format_i18n( $comments_number ),
							get_the_title()
						);
					}
				?>
			</h2>

			<?php the_comments_navigation(); ?>

			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 42,
					) );
				?>
			</ol><!-- .comment-list -->

			<?php the_comments_navigation(); ?>

		<?php endif; // Check for have_comments(). ?>

		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="no-comments"><?php _e( 'Comments are closed.', 'twentysixteen' ); ?></p>
		<?php endif; ?>

		<?php
			comment_form( array(
				'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
				'title_reply_after'  => '</h2>',
			) );
		?>

	<?php }?>
</div><!-- #comments -->

