<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package hbpro
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses hbpro_header_style()
 */
function hbpro_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'hbpro_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'hbpro_header_style',
	) ) );
	
	
}
add_action( 'after_setup_theme', 'hbpro_custom_header_setup' );

if ( ! function_exists( 'hbpro_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see hbpro_custom_header_setup().
 */
function hbpro_header_style() {
	$header_text_color = get_header_textcolor();
	/*
	 * If no custom options for text are set, let's bail.
	 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
	 */
	if ( HEADER_TEXTCOLOR === $header_text_color ) {
		return;
	}
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;



class hbpro_bootstrap_navwalker extends Walker_Nav_Menu
{
	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() )
	{
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul  class=\"sub-menu dropdown-menu\">\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}


	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
	{
		//debug( $item);
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		/**
		 * Dividers, Headers or Disabled
		 * =============================
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 */
		if( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 )
		{
			$output .= $indent . '<li role="presentation" class="divider">';
		}
		else if( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 )
		{
			$output .= $indent . '<li role="presentation" class="divider">';
		}
		else if( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 )
		{
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		}
		else if( strcasecmp($item->attr_title, 'disabled' ) == 0 )
		{
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		}
		else
		{
			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			if( $args->has_children )
			{
				$class_names .= ' dropdown';
			}
			if( in_array( 'current-menu-item', $classes ) )
			{
				$class_names .= ' active';
			}
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
			$output .= $indent . '<li' . $id . $value . $class_names .'>';
			$atts = array();
			$atts['title']  = ! empty( $item->title )	? $item->title	: '';
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
			// If item has_children add atts to a.
			if( $args->has_children && $depth === 0 )
			{
				$atts['href']   		= !empty( $item->url ) ? $item->url : '';
				//$atts['data-toggle']	= 'dropdown';
				$atts['class']			= 'dropdown-toggle';
				$atts['aria-haspopup']	= 'true';
			}
			else
			{
				$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			}
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
			$attributes = '';
			foreach ( $atts as $attr => $value )
			{
				if( !empty( $value ) )
				{
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}
			$item_output = $args->before;
			/*
			 * Glyphicons
			 * ===========
			 * Since the the menu item is NOT a Divider or Header we check the see
			 * if there is a value in the attr_title property. If the attr_title
			 * property is NOT null we apply it as the class name for the glyphicon.
			 */
			if( !empty( $item->attr_title ) )
			{
				$item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
			}
			else
			{
				$item_output .= '<a'. $attributes .'>';
			}
// 			debug($item);
/*
			if($item->post_name == 'trang-chu'){
				$custom_logo_id = get_theme_mod( 'custom_logo' );
				$logo = '<img src="'.wp_get_attachment_image_url($custom_logo_id,'Large').'" class=" hbpro-logo"  alt="Trang-chu" title="Trang chu" />';
				$item_output .= $args->link_before . $logo. $args->link_after.'</a>'.$args->after;				
				$output .= "<li class='visible-lg'>{$item_output}</li>";
// 				$output .= "<li class='hidden-lg'>{$item_output}</li>";
			}else{
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				$item_output .= '</a>';
				$item_output .= $args->after;
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}*/
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
//  			$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret visible-xs"></span></a>' : '</a>';
			$item_output .= '</a>';
			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			
			
			
		}
	}



	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_el()
	 * @since 2.5.0
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output )
	{
		if( !$element )
		{
			return;
		}
		$id_field = $this->db_fields['id'];
		// Display this element.
		if ( is_object( $args[0] ) )
		{
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

}

