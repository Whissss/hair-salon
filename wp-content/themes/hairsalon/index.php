<?php
get_header ();
$color = array('blue','red','orange','green');

HBImporter::helper('post');
wp_enqueue_script( 'wf-slideshow', get_template_directory_uri() . '/js/wf_slideshow.js', array(), '1', true );
?>
<?php do_action('slideshow_deploy', '8'); ?>

<!--HOC-SINH TOA SANG-->
<?php $posts = HBPostHelper::getPostByCategory('hoc-sinh');
?>
<script>
	jQuery(document).ready(function($){
		$('#team-member').wfslideshow({
			url: '<?php echo site_url('index.php?hbaction=ajax&task=getPostByCategory&category_name=team');?>', 
			classItem: 'item-opacity cl-white item-student',
			color: ['blue','red','orange','green'],
			classActive: 'active',
			classAvatar: 'avatar-item-student',
			classTitle: 'title-item-student',
			classDesc: '',
			classMore: '',
			itemPhone: 2,
			itemDesktop: 4,
			itemTablet: 3,
			data: <?php echo json_encode($posts)?>
		});
	});
</script>
<div class="container  home-student" >
	<div class="heading">
		<a href="<?php echo site_url('team')?>" class="btn btn-primary btn-lg">Thành viên</a>			
		<span>"Các thành viên!"</span>
	</div>	
	
	<div class="row wf_slideshow_container" id="team-member">		
	</div>
	<div class="heading">
		<a href="<?php echo site_url('dang-ki')?>" class="btn btn-primary btn-lg">Tham gia học ngay</a>
	</div>
</div>


<!--DOI NGU WOAFUN-->
<div class="bg-gray">
<?php
$posts = get_posts ( array (
		'numberposts' => 8,
		'category_name' => 'team' 
) );?>

	<div class="container teacher-slide ">	
	<div class="row">
		<div class="heading">
			<a href="<?php echo site_url('giang-vien')?>" class="btn btn-primary btn-lg">Thành viên</a>				
			<span></span>
		</div>
	<div class="wf_slideshow_button wf_slideshow_previous"></div>
	<div class="wf_slideshow_button wf_slideshow_next"></div>
	<?php 
	foreach ( $posts as $i => $post ) {
		$link = wp_get_canonical_url ( $post );
		?>
		<div class="col-md-3 col-xs-6">
			<div class="item-teacher bottom-<?php echo $color[$i]?>">
				<div class="avatar-item-teacher">
					<a href="<?php echo $link?>"><?php echo get_the_post_thumbnail($post,'medium',array('class'=>'avatar-item-teacher-img border-'.$color[$i]))?></a>
				</div>
				<div class="title-item-teacher">
					<div class="title-item-two-line">
						<a href="<?php echo $link?>" class="text-<?php echo $color[$i]?>"><?php echo ($post->post_title)?></a>
					</div>
				</div>
			</div>
		</div>
		<?php
			}?>
			</div>
	</div>
</div>



<!--HOAT DONG NGOAI KHOA-->
<div class="outside-action">
<?php

$posts = get_posts ( array (
		'numberposts' => 10,
		'category_name' => 'hoat-dong-ngoai-khoa' 
) );
if (count ( $posts ) == 4) {?>
	<div class="container woafun-slide" style="padding-top:10px;positoin:relative;">	
		<div class="row">
			<div class="heading">
				<a href="<?php echo site_url('hoat-dong-ngoai-khoa')?>" class="btn btn-primary btn-lg">Hoạt động ngoại khóa</a>
					
				<span>"Cùng nhau chúng tôi tạo ra những điều vĩ đại cho xã hội"</span>
			</div>
		<div class="wf_slideshow_button wf_slideshow_previous"></div>
		<div class="wf_slideshow_button wf_slideshow_next"></div>
		<?php 
		foreach ( $posts as $i => $post ) {
			$link = wp_get_canonical_url ( $post );
			?>
			<div class="col-md-3 col-xs-6">
				<div class="item-outside">
					<div class="avatar-item-outside bottom-<?php echo $color[$i]?>-md">
						<a href="<?php echo $link?>"><?php echo get_the_post_thumbnail($post,'medium')?></a>
					</div>
					<div class="title-item-outside">
						<div class="title-item-two-line">
						<a href="<?php echo $link?>"><?php echo ($post->post_title)?></a>
						</div>
					</div>
				</div>
			</div>
			<?php
				}
				?>
		</div>
		<div class="footing">
			<a href="<?php echo site_url('dang-ki')?>" class="btn btn-primary btn-lg">Tham gia học ngay</a>
		</div>
		
	</div>
	
	<?php 
	
}
?>
</div>

<?php include 'template-parts/footer-register-coupon.php';?>

<?php
get_footer();
