<?php
	/**
		* Created by PhpStorm.
		* User: Giangdo
		* Date: 26-Sep-16
		* Time: 16:49
	*/
	
	
	get_header();
	$config = HbFactory::getConfig();
?>

<div id="primary" class="content-area container">
	<!-- Tin moi -->
	
	<div class="row">
		
		<div class="col-md-4">
			<h1 class="bottom-green">Thông tin liên hệ</h1>
			<p>Nếu bạn cần tư vấn vui lòng để lại số điện thoại hoặc email chúng tôi sẽ gọi cho bạn. Bạn cũng có thể gọi vào số điện thoại bên dưới để nhận được tư vấn một cách nhanh nhất!</p>
			<p>Cảm ơn bạn rất nhiều!</p>
			
			<p><b>Điện thoại:</b> <a href="callto:<?php echo str_replace(' ','',$config->phone)?>"><?php echo $config->phone?></a></p>
			<p><b>Email:</b> <a href="mailto:<?php echo $config->email?>"><?php echo $config->email?></a></p>
		</div>
		<div class="col-md-8">
			<div class="heading">Đăng kí nhận thông tin dự án và bảng giá các phòng<br>
			Bạn có thể đăng kí bằng số điện thoại hoặc Email
			</div>
			<div class="form-horizontal">	
				<div class="form-group row">
					<label class="col-md-4 col-form-label">Email của bạn</label>
					<div class="col-md-8">
						<input type="email" class="form-control" required id="input_contact_email"  placeholder="Email">
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-md-4 col-form-label">Số điện thoại của bạn</label>
					<div class="col-md-8">
						<input type="email" class="form-control" required id="input_contact_phone"  placeholder="Số điện thoại">
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-md-4 col-form-label">Bạn có câu hỏi nào không, nếu không có vui lòng bỏ trống</label>
					<div class="col-md-8">
						<textarea type="email" rows="5" class="form-control" required id="input_contact_notes"  placeholder="Tôi có yêu cầu"></textarea>
					</div>
				</div>
				
				<center><button type="button" id="register_email" class="btn btn-lg btn-primary">Đăng kí</button></center>
			</div>
			
			
		</div>
	</div>
	
	
</div><!-- #primary -->

<script> 
	jQuery(document).ready(function($){
		$('#register_email').click(function(){
			var email = $('#input_contact_email').val();
			var phone = $('#input_contact_phone').val();
			var notes = $('#input_contact_notes').val();
			var check=false;
			var valid = false;
			if(email.match(/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i)){
				check = true;
			}else{
				valid = 'email';
			}		
			if(phone.match(/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{3,6}$/)){
				check=true;
			}else{
				valid = 'số điện thoại';
			}
			
			if(check){
				$.ajax({
					url: '<?php echo site_url('index.php?hbaction=user&task=ajax_register&hb_meta_nonce='.wp_create_nonce( 'hb_meta_nonce' ));?>&email='+email+'&phone='+phone+'&notes='+notes,
					type: "GET",
					dataType: "json",
					beforeSend: function(){
						$('body').append('<img id="loading" style="position: fixed;top:50%;left: 50%;margin-left: -100px;margin-top: -100px;width:200px;height:200px;" src="'+siteURL+'/wp-content/themes/estate/images/loading.gif"/>');
					},
					success : function(result) {
						jAlert('Cám ơn bạn đã đăng kí chúng tôi sẽ gọi cho bạn sớm nhất có thể!<br>Chúc bạn một ngày tốt lành!');
						$('#loading').remove();
					},
					error: function(jqXHR, textStatus, errorThrown) {
						jAlert('Xin lỗi bạn, đã có lỗi xảy ra vui lòng thử lại hoặc gọi cho chúng tôi để được tư vấn ngay!');
						$('#loading').remove();
					}
				});
			}else{
				$('#input_contact_phones').focus();
				if(phone == '' && email==''){
					jtrigger_error('Bạn vui lòng nhập số điện thoại hoặc email','');
				}else{
					jtrigger_error('Số điện thoại hoặc email không đúng. Bạn vui lòng nhập lại nhé!','');
				}
				
			}
		});
	});
</script>
<?php
	get_footer();
