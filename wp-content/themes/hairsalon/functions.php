<?php
/**
 * hbpro functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hbpro
 */

if ( ! function_exists( 'hbpro_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hbpro_setup() {
	/*Translate
	 */
	load_theme_textdomain( 'hbpro', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'hbpro' ),
// 		'second' => esc_html__( 'Second', 'hbpro' ),
	) );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	add_theme_support( 'custom-background', apply_filters( 'hbpro_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'hbpro_setup' );



/**
 * Enqueue scripts and styles.
 */
function hbpro_scripts() {
	$root = get_template_directory_uri();
	
	wp_enqueue_script( 'bootstrap', $root.'/js/bootstrap.min.js',array('jquery'));
	wp_enqueue_style( 'bootstrap', $root.'/css/bootstrap.min.css');
	
	
	wp_enqueue_style( 'hbpro-style-utilites', $root.'/css/utilities.css','','1.0.0');
	wp_enqueue_script( 'hbpro-js', $root. '/js/customizer.js', array(), '1.0.0', true );
	wp_enqueue_style( 'hbpro-style', $root.'/style.css','','1.0.0');
	
// 	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
// 		wp_enqueue_script( 'comment-reply' );
// 	}
}


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hbpro_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hbpro_content_width', 640 );
}
add_action( 'after_setup_theme', 'hbpro_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hbpro_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Header', 'hbpro' ),
		'id'            => 'sidebar-header',
		'description'   => esc_html__( 'Add widgets here.', 'hbpro' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
	) );
	register_sidebar( array(
			'name'          => esc_html__( 'Home page', 'hbpro' ),
			'id'            => 'home-main-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'hbpro' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'hbpro' ),
		'id'            => 'sidebar-footer',
		'description'   => esc_html__( 'Add widgets here.', 'hbpro' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
	) );
}
add_action( 'widgets_init', 'hbpro_widgets_init' );

add_action( 'wp_enqueue_scripts', 'hbpro_scripts' );

function wf_login_logo() { 
	$custom_logo_id = get_theme_mod( 'custom_logo' );
?>

    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo wp_get_attachment_image_url($custom_logo_id,'large'); ?>);
    background-size: 200px auto;
    height: 200px;
            width: 100%;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'wf_login_logo' );
add_filter( 'login_headerurl', function(){return '#';} );
add_filter( 'login_headertitle', function(){return 'hbpro';} );


$config = HBFactory::getConfig();
if(isset($config->login_page)){
	add_filter( 'login_url', function(){return site_url($config->login_page);} );
}
if(isset($config->register_page)){
	add_filter( 'register_url', function(){return site_url($config->register_page);} );
}



require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/customizer.php';





// Breadcrumbs
function hb_breadcrumbs() {

	// Settings
	$separator          = '&gt;';
	$breadcrums_id      = 'breadcrumbs';
	$breadcrums_class   = 'breadcrumbs';
	$home_title         = 'Trang chủ';

	// If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
	$custom_taxonomy    = 'product_cat';

	// Get the query & post information
	global $post,$wp_query;

	// Do not display on the homepage
	if ( !is_front_page() ) {
			
		// Build the breadcrums
			
		// Home page
		echo '<a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a>';
		echo ' ' . $separator . ' ';
			
		if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

			echo '<strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong>';

		} else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

			// If post is a custom post type
			$post_type = get_post_type();

			// If it is a custom post type display name and link
			if($post_type != 'post') {

				$post_type_object = get_post_type_object($post_type);
				$post_type_archive = get_post_type_archive_link($post_type);

				echo '<a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a>';
				echo $separator ;

			}

			$custom_tax_name = get_queried_object()->name;
			echo '<strong class="bread-current bread-archive">' . $custom_tax_name . '</strong>';

		} else if ( is_single() ) {

			// If post is a custom post type
			$post_type = get_post_type();

			// If it is a custom post type display name and link
			if($post_type != 'post') {

				$post_type_object = get_post_type_object($post_type);
				$post_type_archive = get_post_type_archive_link($post_type);

				echo '<a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a>';
				echo  $separator;

			}

			// Get post category info
			$category = get_the_category();

			if(!empty($category)) {

				// Get last category post is in
				$last_category = end(array_values($category));

				// Get parent any categories and create array
				$get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
				$cat_parents = explode(',',$get_cat_parents);

				// Loop through parent categories and store in variable $cat_display
				$cat_display = '';
				foreach($cat_parents as $parents) {
					$cat_display .= ''.$parents.'';
					$cat_display .= '' . $separator . '';
				}
					
			}

			// If it's a custom post type within a custom taxonomy
			$taxonomy_exists = taxonomy_exists($custom_taxonomy);
			if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
					
				$taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
				$cat_id         = $taxonomy_terms[0]->term_id;
				$cat_nicename   = $taxonomy_terms[0]->slug;
				$cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
				$cat_name       = $taxonomy_terms[0]->name;
					
			}

			// Check if the post is in a category
			if(!empty($last_category)) {
				echo $cat_display;
				echo '<strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong>';

				// Else if post is in a custom taxonomy
			} else if(!empty($cat_id)) {

				echo '<a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a>';
				echo $separator ;
				echo '<strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong>';

			} else {

				echo '><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong>';

			}

		} else if ( is_category() ) {

			// Category page
			echo '<strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong>';

		} else if ( is_page() ) {

			// Standard page
			if( $post->post_parent ){
					
				// If child page, get parents
				$anc = get_post_ancestors( $post->ID );
					
				// Get parents in the right order
				$anc = array_reverse($anc);
					
				// Parent page loop
				if ( !isset( $parents ) ) $parents = null;
				foreach ( $anc as $ancestor ) {
					$parents .= '<a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a>';
					$parents .= '' . $separator . '';
				}
					
				// Display parent pages
				echo $parents;
					
				// Current page
				echo '<strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong>';
					
			} else {
					
				// Just display current page if not parents
				echo '<strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong>';
					
			}

		} else if ( is_tag() ) {

			// Tag page

			// Get tag information
			$term_id        = get_query_var('tag_id');
			$taxonomy       = 'post_tag';
			$args           = 'include=' . $term_id;
			$terms          = get_terms( $taxonomy, $args );
			$get_term_id    = $terms[0]->term_id;
			$get_term_slug  = $terms[0]->slug;
			$get_term_name  = $terms[0]->name;

			// Display the tag name
			echo '<strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong>';

		} elseif ( is_day() ) {

			// Day archive

			// Year link
			echo '<a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a>';
			echo '' . $separator . '';

			// Month link
			echo '<a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a>';
			echo '' . $separator . '';

			// Day display
			echo '<strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong>';

		} else if ( is_month() ) {

			// Month Archive

			// Year link
			echo '<a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a>';
			echo '' . $separator . '';

			// Month display
			echo '<strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong>';

		} else if ( is_year() ) {

			// Display year archive
			echo '<strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong>';

		} else if ( is_author() ) {

			// Auhor archive

			// Get the author information
			global $author;
			$userdata = get_userdata( $author );

			// Display author name
			echo '<strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong>';

		} else if ( get_query_var('paged') ) {

			// Paginated archives
			echo '<strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong>';

		} else if ( is_search() ) {

			// Search results page
			echo '<strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong>';

		} elseif ( is_404() ) {

			// 404 page
			echo '' . 'Error 404' . '';
		}
			
			
	}

}