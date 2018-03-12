<?php


class HBAdminViewOrders extends HBAdminView{
	public $items;
	
	public function display($tpl=null){
		global $wpdb;
		$this->items = $this->get('Items');
		if(!empty($wpdb->last_error)){
			debug($wpdb->last_error);
			return;
		}
// 		$this->state = $this->get('State');
// 		$this->pagination = $this->get('Pagination');
		parent::display($tpl);
	}
	
}

$view = new HBAdminViewOrders();
$view->display();
?>
