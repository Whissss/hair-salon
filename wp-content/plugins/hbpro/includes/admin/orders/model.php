<?php
class HBModelOrders{
	public function getItems(){
		global $wpdb;
		$date = $_GET['date'];
		$info = $_GET['information'];
		$method = $_GET['method'];
		$payment = $_GET['pay'];
        $where = array();
        $condition = null;

        if ($date){
            $where[] = "DATE(o.created) = '$date' ";
        }
        if ($info){
            $where[] = "(o.order_number LIKE '%$info%' OR o.fullname LIKE '%$info%' OR o.mobile LIKE '%$info%' OR o.email LIKE '%$info%')";
        }
        if ($method){
            $where[] = "o.pay_method = '$method'";
        }
        if ($payment){
            $where[] = "o.pay_status = '$payment'";
        }

        if(!empty($where)){
            $condition .= ' WHERE '.implode(' AND ', $where).'';
        }

		return $wpdb->get_results("
				Select o.*,t.post_title as tour_name from {$wpdb->prefix}orders as o
				LEFT JOIN {$wpdb->prefix}posts as t ON t.ID=o.tour_id ".$condition."
				order by created DESC");
	}
	
	public function getItem($id){
		global $wpdb;
		$query = "Select o.*,t.post_title as tour_name from #__orders as o
				LEFT JOIN #__posts as t ON t.ID=o.tour_id 
				WHERE o.id=".(int)$id;
		
		$query = str_replace('#__', $wpdb->prefix, $query);
		
		$order = $wpdb->get_row($query);
		return $order;
	}
}