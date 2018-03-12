<?php include 'header.php';?>
<table style="width:100%">
	<tr>
		<td><?php echo __('Order number')?></td>
		<td><?php echo $displayData->order_number?></td>
	</tr>
	<tr>
		<td>Họ tên</td>
		<td><?php echo $displayData->firstname.' '.$displayData->lastname?></td>
	</tr>
	<tr>
		<td>Sđt</td>
		<td><?php echo $displayData->mobile?></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><?php echo $displayData->email?></td>
	</tr>
	<tr>
		<td>Địa chỉ</td>
		<td><?php echo $displayData->address?></td>
	</tr>
	<tr>
		<td>Nội dung</td>
		<td><?php echo $displayData->notes?></td>
	</tr>
	<tr>
		<td>Thông tin chi tiết</td>
		<td><?php echo HBHelper::get_order_link((object)$displayData)?></td>
	</tr>
	<tr>
		<td>Tour</td>
		<td><?php echo $displayData->tour_name?></td>
	</tr>
	<tr>
		<td>Thanh toán</td>
		<td><?php echo HBCurrencyHelper::displayPrice($displayData->total,$displayData->currency)?></td>
	</tr>
</table> 
<?php include 'footer.php';?>