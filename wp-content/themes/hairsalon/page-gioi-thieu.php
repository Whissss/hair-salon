<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package woafun
 */
wp_head();
$site = get_template_directory_uri();
$post = get_post();
$except = sanitize_text_field($post->post_content);
$except = substr($except,0,443);
?>
<style>
	.icon-wf-home:hover{
		color: white;
		background: green;
	}
	.icon-wf-home{
		color:green;
		width:60px;
		height:60px;
		font-size:28px;
		padding-top: 14px;
	}
</style>
<div id="content">
	<div class="clearfix" style="height:140px;padding:20px;">
		<a href="<?php echo site_url()?>" class="icon-wf-home btn btn-circle"><i class="glyphicon glyphicon-home"></i></a>
	</div>
	<div id="primary" class="content-area container container-smaller">
		
		<div class="row" style='font-family: "CircularStd-Book";font-size: 19px;'>
			<div class="col-xs-8">
				<img src="<?php echo $site ?>/images/thong-diep-woafun/w-logo-w.png" width="100px" style="box-shadow: 8px 14px 36px 3px #3B3B3B;margin-bottom:80px;"/>
				
				<div id="except-content">
				<?php echo $except;?>...
				<a href="javascript:void(0)" style="color:red;" onclick="jQuery('#except-content').hide();jQuery('#full-content').show();"><i class="glyphicon glyphicon-play-circle"></i> Xem chi tiết</a>
				</div>
				<div id="full-content" style="display:none">
					<?php echo $post->post_content; ?>
					<a href="javascript:void(0)" style="color:red;" onclick="jQuery('#except-content').show();jQuery('#full-content').hide();"><i class="glyphicon glyphicon-arrow-left"></i> Thu gọn</a>
				</div>
			</div>
			<div class="col-xs-4" style="height:530px;background: url(<?php echo $site ?>/images/thong-diep-woafun/background.png) no-repeat;background-size: 354px 542px;">
			<!--<img src="<?php echo $site ?>/images/thong-diep-woafun/background.png"/>--></div>
		</div>
		<div class="heading">
			<a href="<?php echo site_url('dang-ki')?>" class="btn btn-primary btn-lg">Tham gia học ngay</a>
		</div>
	</div><!-- #primary -->

<?php

get_footer();
