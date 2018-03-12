<?php 
get_header();
/*
$args = array(
		'numberposts' => 4,
		'offset' => 0,
		'category' => 0,
		'orderby' => 'ID',
		'order' => 'DESC',
		'post_type' => 'post',
		'post_status' => 'publish',
		'suppress_filters' => true
);

$recent_posts = wp_get_recent_posts( $args, ARRAY_A );
*/

?>



<?php if ( is_active_sidebar( 'home-main-sidebar' ) ) { ?>
    <aside id="sidebar-home-page"><?php dynamic_sidebar( 'home-main-sidebar' ); ?>
	</aside>
<?php }?>
<div id="home-page">
	
</div>
<?php get_footer();