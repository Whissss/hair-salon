<?php 
$url = urlencode('http://facebook.com/woafun/');
$user = wp_get_current_user();
?>					
					
<div id="maia-main">	
	<a href="<?php echo site_url('dang-ki')?>" class="btn btn-danger register-btn btn-lg" >Đăng kí học</a>
	<?php if($user->ID){?>
		<a href="<?php echo wp_logout_url('index.php');?>" class="btn btn-primary register-btn btn-lg " >Đăng xuất</a>
	<?php }else{?>
		<a href="<?php echo site_url('dang-nhap')?>" class="btn btn-primary register-btn btn-lg " >Đăng nhập</a>
	<?php }?>
</div>