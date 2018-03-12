<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package woafun
 */

$is_sigle = is_single();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( $is_sigle ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			if ( $is_sigle ) :
				the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Tiếp tục %s <span class="meta-nav">&rarr;</span>', 'woafun' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
						) );
				
				wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'woafun' ),
						'after'  => '</div>',
				) );
			else :
// 			wp_link_pages( array(
// 					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'woafun' ),
// 					'after'  => '</div>',
// 			) );
				//the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
