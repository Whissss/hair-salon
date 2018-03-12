<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package woafun
 */
// $config = HBFactory::getConfig();
// $app_id= (string)$config->facebook_app_id;
$site = site_url();
?>

	</div><!-- #content -->
	
	
<?php if(!isset($_GET['raw'])){?>
	<footer id="footer" class="site-footer" role="contentinfo">
		<?php if ( is_active_sidebar( 'sidebar-footer' ) ) { ?>
		    <aside id="sidebar-footer"><?php dynamic_sidebar( 'sidebar-footer' ); ?>
			</aside>
		<?php }?>	
	</footer><!-- #colophon -->
</div><!-- #page -->

<div id="back-top" onclick="jQuery('html, body').animate({scrollTop: 0}, 1000);">
	<span></span>
	Lên đầu
</div>

<div id="hbproweb-dev-promo">@Copyright <a target="_blank" href="http://hbproweb.com/">hbproweb.com</a></div>
<?php }?>
<?php wp_footer(); ?>

</body>
</html>
