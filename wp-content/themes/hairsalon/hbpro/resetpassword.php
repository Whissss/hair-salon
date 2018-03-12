<title>Thông báo</title>
<?php
/**
 * The template for displaying notice to user
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package woafun
 */

get_header(); ?>

	<div id="primary" class="content-area container" style="min-height:200px">
		<main id="main" class="site-main" role="main" style="width:50%;margin: 10px auto;">
			<form action="index.php?hbaction=user&task=sendResetPasswordMail" method="post" class="well well-small" >
				<div class="">
					<div class="form-group row">
						<label class="col-xs-4 col-form-label">Email của bạn</label>
						<div class="col-xs-8">
							<input class="form-control input-medium required name" type="email" required type="text" id="mail"
								name="user_mail" maxlength="50" />
						</div>
					</div>
				</div>
				<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
				<center><button type="submit" class="btn btn-primary btn-lg">Gửi email reset mật khẩu</button></center>
			</form>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
