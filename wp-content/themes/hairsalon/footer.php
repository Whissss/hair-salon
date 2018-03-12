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
$config = HBFactory::getConfig();
$app_id= (string)$config->facebook_app_id;
$site = site_url();
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.7&appId=<?php echo $app_id?>";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer " role="contentinfo">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<h4 class="bottom-green">Thông tin liên hệ</h4>
					<p><b>Địa chỉ:</b> Lê Quý Đôn, Hà Nội</p>
					<p><b>Điện thoại:</b> 0966 058 530</p>
					<p><b>Email:</b> <a href="mailto:lienhe.woafun@gmail.com">lienhe.woafun@gmail.com</a></p>
					
				</div>
				
				<div class="col-md-4" >
					<h4 class="bottom-red">Chính sách và điều khoản</h4>
					<p><a href="<?php echo $site ?>/chinh-sach-va-dieu-khoan">Chính sách và điều khoản của Woafun</a></p>
					<p><a href="<?php echo $site ?>/dieu-khoan-su-dung-website">Điều khoản sử dụng website</a></p>
					<p><a href="<?php echo $site ?>/quyen-rieng-tu">Quyền riêng tư</a></p>
				</div>
				
				<div class="col-md-4">
					<h4 class="bottom-orange">Fanpage</h4>
<!--					<iframe frameborder="0" allowtransparency="true" style="overflow: hidden; width: 100%; border: medium none;-->
<!--					height: 100%;" scrolling="no" src="http://www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/woafun/?rc=p&colorscheme=light&show_faces=true&header=false&stream=false&show_border=false"></iframe>-->

					<div class="fb-page" data-href="https://www.facebook.com/woafun/" data-tabs="timeline" data-width="461" data-height="150" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/woafun/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/woafun/">Woafun</a></blockquote></div>
				</div>

			</div>
			<center style="margin: 20px 0;">
				<a href="https://www.facebook.com/woafun"><img src="https://cdn1.iconfinder.com/data/icons/logotypes/32/square-facebook-512.png" width="40px" height="40px;"/></a>
				<a href="https://plus.google.com/u/0/"><img src="https://cdn1.iconfinder.com/data/icons/logotypes/32/square-google-plus-128.png" width="40px" /></a>
				<a href="https://goo.gl/0LUuFU"><img src="https://cdn2.iconfinder.com/data/icons/micon-social-pack/512/youtube2-128.png" width="40px" /></a>
			</center>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
