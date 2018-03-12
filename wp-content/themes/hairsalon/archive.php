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
		<div class="col-md-8">
			<main id="main" class="site-main" role="main">
				<div id="breadcum" class="">
					<?php
						hb_breadcrumbs();
					?>
				</div>
					
				<div id="list-post">
				<?php
				if ( have_posts() ) : $i=0;?>
					
					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();
					?>
					<div class="row item-cat <?php echo $i==0 ? 'first' : '';?>">
						<div class="item">
							<a class="item-avatar" href="<?php echo the_permalink()?>"><?php the_post_thumbnail('medium')?></a>
							<span class="item-content">
								<a class="text-green" href="<?php echo the_permalink()?>"><?php the_title()?></a>
								<p><?php the_date()?></p>
								<?php the_excerpt()?>
							</span>						
						</div>	
					</div>
					<?php 
// 					if(($i+1)%3==0 && $i>0){
// 						echo "<div class='clearfix'></div>";
// 					}
					$i++;
					endwhile;

					the_posts_navigation();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
				</div>

			</main><!-- #main -->
		</div>
		<div class="col-md-4">
			<?php get_sidebar();?>
		</div>
	</div>
	
</div><!-- #primary -->
<?php
get_footer();
