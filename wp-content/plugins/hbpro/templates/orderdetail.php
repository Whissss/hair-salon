
<?php get_header();?>
<?php 
HBImporter::helper('currency');
$order_number = $_GET['order_number'];
$email = $_GET['email'];
global $wpdb;
$query = "select * from #__orders where email LIKE \"{$email}\" AND order_number LIKE \"{$order_number}\";";
// debug('');
// debug($query);
$query = str_replace('#__', $wpdb->prefix, $query);
$order = $wpdb->get_row($query);

// debug($wpdb->last_error);
// debug($order);die; 
if($order->type='HOTEL'=='HOTEL'){
	include 'orderdetail-hotel.php';
}else{
	include 'orderdetail-tour.php';
}
?>


<?php get_footer(); ?>


