<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hbpro
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
<script type="text/javascript">
	
   if(window.innerWidth <= 800 && window.innerHeight <= 600) {
	var is_mobile = true;
   } else {
	   var is_mobile = false;
   }   
  
   var siteURL = '<?php echo site_url()?>';
</script>

</head>

<body <?php body_class(); ?>>


<div id="page" class="site">
	<?php if(!isset($_GET['raw'])){?>	
	<div id="main-menu">
		<div id="main-header">		
			<div class="container">
				<div class="hbpro-logo">
					<a href="<?php echo home_url(); ?>">
					<?php 
						$custom_logo_id = get_theme_mod( 'custom_logo' );
						$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
						echo "<img src='{$image[0]}' style='width:100%;'/>";
					?>
					</a>
					
					<?php if ( is_active_sidebar( 'sidebar-header' ) ) { ?>
					    <aside id="sidebar-header"><?php dynamic_sidebar( 'sidebar-header' ); ?>
						</aside>
					<?php }?>					
				</div>
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
					<span class="sr-only">Mở menu</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div id="masthead" class="navbar navbar-inverse bs-docs-nav" role="banner">
					<div class="navbar-header">
						
					</div>
					<?php wp_nav_menu( array(
						'theme_location'    => 'primary',
						'depth'             =>  2,
						'container'         => 'nav',
						'container_class'   => 'collapse navbar-collapse bs-navbar-collapse',
						'menu_id' 			=> 'primary-menu',
						'menu_class'        => 'nav navbar-nav',
						'walker'            => new hbpro_bootstrap_navwalker()
						));
					?>
				</div>
				
			</div>
		</div>
		<div class="clearfix" id="header-breacum"></div>
	</div>
	<?php }?>
	<div id="content" class="site-content">
