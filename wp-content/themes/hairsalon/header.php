<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package woafun
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<style>

</style>
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<script>
//check admin menu bar exist
jQuery(document).ready(function($){
	/*
	if(jQuery('#wpadminbar').length){
		$('.navbar-fixed-top').css('top','32px');
	}
	var nav_height = $("#masthead").height();
	$('#content').css('margin-top',nav_height);
	*/
});
  
</script>
<div id="page" class="site">
	<div id="main-header">
		<div class="container">
			<div class="woafun-logo" style="position: relative;">
				<?php the_custom_logo(); ?>
				<?php //include 'template-parts/header-main-right-bar.php';?>
			</div>
			
		</div>
	</div>
	<header id="masthead" class="navbar navbar-inverse bs-docs-nav" role="banner">
		  <div class="container">
		    <div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
					<span class="sr-only">Mở menu</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
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
		</header><!-- #masthead -->
	<div id="content" class="site-content">
