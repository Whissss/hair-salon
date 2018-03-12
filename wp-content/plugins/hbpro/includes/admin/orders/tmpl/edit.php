<?php $item = reset($this->items) ?>

<h1>Quản lí đơn <a href="<?php echo admin_url('admin.php?page=hb_booking')?>" class="page-title-action" >Quay lại</a></h1>

<div id="primary" class="container">
	<form action="<?php echo admin_url('admin-post.php?action=hbaction&hbaction=orders&task=save')?>" method="post">
        <input type="hidden" value="<?php echo $this->input->get('id')?>" name="id"/>
			<div class="row">
                <div class="col-md-5">Họ tên</div>
				<div class="col-md-7"><input type="text" value="<?php echo $item->fullname ?>" name="data[fullname]" class="regular-text ltr"></div>
			</div>
			
			<div class="row">
                <div class="col-md-5">Người lớn</div>
				<div class="col-md-7"><input type="number" value="<?php echo $item->adult ?>" name="data[adult]" class="regular-text ltr"></div>
			</div>
			
			<div class="row">
                <div class="col-md-5">Trẻ em</div>
				<div class="col-md-7"><input type="number" value="<?php echo $item->children ?>" name="data[children]" class="regular-text ltr"></div>
			</div>
			
			<div class="row">
                <div class="col-md-5">Số điện thoại</div>
				<div class="col-md-7"><input type="text" value="<?php echo $item->mobile ?>" name="data[mobile]" class="regular-text ltr"></div>
			</div>
			
			<div class="row">
                <div class="col-md-5">Email</div>
				<div class="col-md-7"><input type="text" value="<?php echo $item->email ?>" name="data[email]" class="regular-text ltr"></div>
			</div>
			
			<div class="row">
                <div class="col-md-5">Lưu ý</div>
				<div class="col-md-7"><textarea type="text" name="data[notes]" class="regular-text ltr"><?php echo $item->notes ?></textarea></div>
			</div>
			
            <div class="row">
                <div class="col-md-12">
                    <Button id="Edit" class="button action">Lưu</Button>
                </div>
            </div>


		<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
		<center><button type="submit" class="btn btn-primary btn-lg">Lưu</button></center>
	</form>
	
</div><!-- #primary -->
