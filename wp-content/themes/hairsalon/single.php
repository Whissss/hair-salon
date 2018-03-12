<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package estate
 */

get_header(); ?>

	<div id="primary" class="content-area container">
		<div class="row">
			<div class="col-md-8">
				<main id="main" class="site-main" role="main">
					<?php
					while ( have_posts() ) : the_post();
						hb_set_post_view(get_the_ID());
						get_template_part( 'template-parts/content', get_post_format() );
						
						the_post_navigation();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>

				</main><!-- #main -->
			</div>
			<?php if(!isset($_GET['raw'])){?>
			<div class="col-md-4">
				<?php get_sidebar();?>
			</div>
			<?php }?>
			</div>
	</div><!-- #primary -->

<?php
get_footer();