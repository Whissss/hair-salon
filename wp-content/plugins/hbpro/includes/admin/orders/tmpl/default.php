<?php
/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id$
 **/
// die('ddfdf');
defined('ABSPATH') or die('Restricted access');
global $wpdb;
$count = $wpdb->get_results("SELECT count(*) AS count FROM {$wpdb->prefix}orders");
$total = reset($count)->count;
$cash_count = reset($wpdb->get_results("SELECT count(*) AS count FROM {$wpdb->prefix}orders WHERE pay_method='cash'"))->count;
$onepay_count = reset($wpdb->get_results("SELECT count(*) AS count FROM {$wpdb->prefix}orders WHERE pay_method='onepay'"))->count;
$paid_count = reset($wpdb->get_results("SELECT count(*) AS count FROM {$wpdb->prefix}orders WHERE pay_status = 'SUCCESS'"))->count;
$unpaid_count = reset($wpdb->get_results("SELECT count(*) AS count FROM {$wpdb->prefix}orders WHERE pay_status = 'PENDING'"))->count;

$cash_active = null; $onepay_active = null;
$all_active = null;
if ($_GET['method'] == 'cash'){
    $cash_active = 'class="current"';
}
if ($_GET['method'] == 'onepay'){
    $onepay_active = 'class="current"';
}
$paid_active = null;
$unpaid_active = null;

if ($_GET['pay'] == 'success'){
    $paid_active = 'class="current"';
}
if ($_GET['pay'] == 'pending'){
    $unpaid_active = 'class="current"';
}

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($actual_link);
if ($parts['query'] == 'page=hb_booking'){
    $all_active = 'class="current"';
}

?>
<h1>Tour đã đặt</h1>

<div class="tablenav top">

    <ul class="subsubsub">
        <li class="all"><a href="admin.php?page=hb_booking" <?php echo $all_active ?> aria-current="page">Tất cả <span class="count">(<?php echo $total ?>)</span></a> |</li>
        <li class="active"><a href="admin.php?page=hb_booking&method=cash" <?php echo $cash_active ?> >Tiền mặt <span class="count">(<?php echo $cash_count ?>)</span></a> |</li>
        <li class="active"><a href="admin.php?page=hb_booking&method=onepay" <?php echo $onepay_active ?>>OnePay <span class="count">(<?php echo $onepay_count ?>)</span></a> |</li>
        <li class="active"><a href="admin.php?page=hb_booking&pay=success" <?php echo $paid_active ?>>Đã thanh toán <span class="count">(<?php echo $paid_count ?>)</span></a> |</li>
        <li class="active"><a href="admin.php?page=hb_booking&pay=pending" <?php echo $unpaid_active ?>>Chưa thanh toán <span class="count">(<?php echo $unpaid_count ?>)</span></a> |</li>
    </ul>

    <br>
    <br>

	<div class="alignleft actions bulkactions">
        <label for="bulk-action-selector-top" class="screen-reader-text">Lựa chọn thao tác hàng loạt</label>
        <select name="action" id="bulk-action-selector-top">
            <option>Tác vụ</option>
            <option value="edit" class="hide-if-no-js">Chỉnh sửa</option>
            <option value="trash">Xóa</option>
        </select>
        <input id="doaction" class="button action" value="Áp dụng" type="submit" onclick="deletes()">
    </div>
    <div class="alignleft actions">
			<label for="filter-by-date" class="screen-reader-text">Lọc theo ngày</label>
            <?php
                $date = $_GET['date'];
            ?>
        <?php echo HBHtml::calendar($date, 'filter[date]','date','yy-mm-dd','class="form-control input-medium required name" required placeholder="Chọn ngày"',array('changeMonth'=>true,'changeYear'=>true,'maxDate'=>"(new Date()).getDate()"))?>
            <Button class="button action" onclick="return filterDate()">Lọc</Button>

        <input type="text" id="info_custom" placeholder="Mã, Tên, Mobile, Email" value="<?php if ($_GET['information']) echo $_GET['information'] ?>" >
        <span><Button class="button action" onclick="return filterInfo()">Tìm</Button></span>
        <span><Button class="button action" onclick="window.location='admin.php?page=hb_booking'">X</Button></span>

    </div>


    <div class="tablenav-pages one-page"><span class="displaying-num"><?php echo count($this->items); ?> mục</span>
	<span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
	<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
	<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Trang hiện tại</label><input class="current-page" id="current-page-selector" name="paged" value="1" size="1" aria-describedby="table-paging" type="text"><span class="tablenav-paging-text"> trên <span class="total-pages">1</span></span></span>
	<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
	<span class="tablenav-pages-navspan" aria-hidden="true">»</span></span></div>
		<br class="clear">
</div>


<div>
	<form id="mainform" method="POST" action="<?php echo admin_url('admin-post.php?action=hbaction')?>">
		<table class="wp-list-table widefat fixed striped posts">
			<thead>
				<tr>
                    <th id="cb" class="column-cb check-column">
                        <input id="cb-select-all-1" type="checkbox" onclick="toggle(this)">
                    </th>
					<th>Mã đơn</th>
					<th>Tour</th>
					<th>Họ tên</th>
					<th>Số lượng</th>
					<th>Pay status</th>
                    <th>Phương thức thanh toán</th>
                    <th>Order status</th>
					<th>Số điện thoại</th>
					<th>Email</th>
					<th>Ngày đặt</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->items as $item){?>
                    <?php
                        $color  = '';
                        if ($item->pay_status == 'PENDING'){
                            $color = 'style="color: #F0AD4E"';
                        }
                        if ($item->pay_status == 'SUCCESS'){
                            $color = 'style="color: #5CB85C"';
                        }

                        $order_color = '';
                        if ($item->order_status == 'PENDING'){
                            $order_color = 'style="color: #F0AD4E"';

                        }
                        if ($item->order_status == "CONFIRMED"){
                            $order_color = 'style="color: #5CB85C"';
                        }


                        ?>
					<tr>
                        <td>
                            <input id="cb-select-<?php echo $item->id; ?>" type="checkbox" name="id[]" value="<?php echo $item->id; ?>"></td>
						<td>
							<a target="_blank" href="<?php echo HBHelper::get_order_link($item)?>"><?php echo $item->order_number;?></a>
							<div class="clearfix"></div>
							<div class="row-actions">
								<span class="view"><a target="_blank" href="admin.php?page=hb_booking&layout=edit&id=<?php echo $item->id; ?>">Sửa</a></span>
								<span class="view"> | <a target="_blank" href="<?php echo HBHelper::get_order_link($item)?>">Xem</a></span>
                                <span class="trash"> | <a href="#" class="submitdelete" onclick="deleteItem(<?php echo $item->id ?>)">Xóa</a></span>
                            </div>
						</td>
                        <td><a href="<?php echo get_permalink($item->tour_id); ?>" target="_blank"><?php echo $item->tour_name;?></a></td>
						<td><?php echo $item->fullname;?></td>
						<td>Adult(<?php echo $item->adult;?>) Children(<?php echo $item->children;?>)</td>
						<td <?php echo $color; ?>>
                            <?php echo HBHelper::get_payment_status($item->pay_status);?>
                        </td>
                        <td><?php echo $item->pay_method?></td>
                        <td <?php echo $order_color; ?> >
                            <?php echo HBHelper::get_order_status($item->order_status);?>
                            <?php if ($item->order_status == 'PENDING'): ?>
                            <div class="clearfix"></div>
                            <div class="row-actions">
                                <span class="view"><a target="_blank" href="admin.php?page=hb_booking&layout=edit&id=<?php echo $item->id; ?>" title="Đánh dấu: 'đã xử lý'"><span style="font-size: 16px">✓</span></a></span>
                            </div>
                            <?php endif; ?>
                        </td>
						<td><a href="tel:<?php echo $item->mobile;?>"><?php echo $item->mobile;?></a></td>
						<td><?php echo $item->email;?></td>
						<td><?php echo $item->created;?></td>
					</tr>
				<?php }?>
			</tbody>
		</table>

        <?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
        <input type="hidden" name="hbaction" value="orders" />
        <input type="hidden" id="task" name="task" value="deleteitem" />
<!--        --><?php // submit_button()?>

        <input type="hidden" id="itemID" name="itemID" value="">

	</form>
</div>


<script>

    function deletes() {
        var value = document.getElementById("bulk-action-selector-top").value;
        if (value === 'trash'){
            if (confirm("Bạn chắc chắn muốn xóa?")){
                document.getElementById('task').value = 'deletes';
                document.getElementById("mainform").submit();
            }
        }
    }

    function toggle(source) {
        checkboxes = document.getElementsByName('id[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
    }
    
    function deleteItem(id) {
        if (confirm("Bạn có chắc chắn")){
            document.getElementById('itemID').value = id;
            document.getElementById('task').value = 'deleteitem';
            document.getElementById("mainform").submit();
        }
    }

    function filterDate() {
        if (document.getElementById("date").value === ''){
            alert("Vui lòng chọn ngày");
            return false;
        }
        var val = document.getElementById('date').value;
        var link = window.location.href;
        var pathname = window.location.pathname;
        var param = getJsonFromUrl();
        pathname = pathname + "?page=hb_booking";
        if (!param['date']){
            link = link + '&date=' + val;
        }else {
            for (var key in param) {
                if (key === 'page') continue;
                if (key === 'date'){
                    pathname = pathname + "&date=" + val;
                }else {
                    pathname = pathname + "&" + key + "=" + param[key];
                }
            }
            link = pathname;
        }
        window.location = link;
    }
    
    function filterInfo() {
        var value = document.getElementById("info_custom").value;
        if (!value){
            alert("Vui lòng nhập thông tin");
            return false;
        }
        var link = window.location.href;
        var pathname = window.location.pathname;
        var param = getJsonFromUrl();
        pathname = pathname + "?page=hb_booking";
        if (!param['information']){
            link = link + '&information=' + value;
        }else {
            for (var key in param) {
                if (key === 'page') continue;
                if (key === 'information'){
                    pathname = pathname + "&information=" + value;
                }else {
                    pathname = pathname + "&" + key + "=" + param[key];
                }
            }
            link = pathname;
        }
        window.location = link;
    }

    function getJsonFromUrl() {
        var query = location.search.substr(1);
        var result = {};
        query.split("&").forEach(function(part) {
            var item = part.split("=");
            result[item[0]] = decodeURIComponent(item[1]);
        });
        return result;
    }
</script>

<style>
    #cb-select-all-1{
        margin-top: 15px;
    }
</style>