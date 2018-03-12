<div class="bg-green" style="padding: 35px 0 55px 0;display:block;color:white">
	<div class="heading">Đăng kí nhận thông tin dự án và bảng giá các phòng</div>
	<div class="container">
		<div class="form-inline">			
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-5 col-xs-8"> <input type="email" class="form-control pull-right" required id="input_register_email"  placeholder="Email của bạn" style="width:100%; height:40px;line-height:19px;font-size:19px;"></div>
				<div class="col-md-1 col-xs-4"><button type="button" id="register_email" class="btn btn-lg btn-primary">Đăng kí</button></div>
				<div class="col-md-3"></div>
			</div>
		</div>
	</div>
</div>
<script> 
	jQuery(document).ready(function($){
		$('#register_email').click(function(){
			var email = $('#input_register_email').val();
			if(email.match(/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i)){
				$.ajax({
					url: '<?php echo site_url('index.php?hbaction=user&task=ajax_register_email&hb_meta_nonce='.wp_create_nonce( 'hb_meta_nonce' ).'&email=');?>'+email,
					type: "GET",
					dataType: "json",
					beforeSend: function(){
						$('body').append('<img id="loading" style="position: fixed;top:50%;left: 50%;margin-left: -100px;margin-top: -100px;width:200px;height:200px;" src="'+siteURL+'/wp-content/themes/estate/images/loading.gif"/>');
					},
					success : function(result) {
						jAlert('Cám ơn bạn đã đăng kí chúng tôi sẽ gọi cho bạn sớm nhất có thể!');
						$('#loading').remove();
					},
					error: function(jqXHR, textStatus, errorThrown) {
					  jAlert('Xin lỗi bạn, đã có lỗi xảy ra vui lòng thử lại hoặc sử dụng số điện thoại để đăng kí hoặc gọi cho chúng tôi để được tư vấn ngay!');
					  $('#loading').remove();
					}
				 });
			}else{
				$('#register_email').focus();
				jtrigger_error('Email không hợp lệ','');				
			}
		});
	});
</script>