<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package woafun
 */

get_header(); ?>
	
<div id="primary" class="content-area container">
	<div class="row">
		<div class="col-md-9">
			<main id="main" class="site-main" role="main">
				<div class="row" style="margin:10px 0;">
				<?php
				if ( have_posts() ) : ?>

					<header class="page-header">
						<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="archive-description">', '</div>' );
						?>
					</header><!-- .page-header -->
					
					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();
					$link = get_permalink($post);
					?>
						<div class="col-sm-4">
							<div class="item-news">
								<div class="avatar-item-news" ><a href="<?php echo $link?>"><?php echo get_the_post_thumbnail($post,'medium')?></a></div>
								<div class="tags-item"></div>
								<div class="title-item-news"><a href="<?php echo $link?>"><?php echo ($post->post_title)?></a></div>
								<div class="summary-item-news"><?php echo $post->post_excerpt?></div>
							</div>						
						</div>
					<?php 
// 					if(($i+1)%3==0 && $i>0){
// 						echo "<div class='clearfix'></div>";
// 					}
					endwhile;

					the_posts_navigation();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
				</div>

			</main><!-- #main -->
		</div>
		<div class="col-md-3">
			<?php get_sidebar();?>
		</div>
	</div>
	
</div><!-- #primary -->
<?php
get_footer();
