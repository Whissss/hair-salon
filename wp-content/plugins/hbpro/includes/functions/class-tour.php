<?php
/**
 * @package 	Bookpro
 * @author 		Joombooking
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('ABSPATH') or die('Restricted access');

class HBActionTour extends HBAction{
	
	function book(){ 
// 		debug($_REQUEST);
		$result = array(
				'status' => 0,
				'error' => array(
						'code' => '',
						'msg' => 'Error'
				)
		);
		//check nonce
		if ( empty( $_REQUEST['hb_meta_nonce'] ) || ! wp_verify_nonce( $_REQUEST['hb_meta_nonce'], 'hb_meta_nonce' ) ) {
			$result['error']['msg'] = __('Session expired');
			return $this->ajax_process_order($result);
		}
		global $wpdb;
		
		
		$requires = array('tour_id','fullname','email','mobile');
		foreach($requires as $key){
			if(!isset($_REQUEST[$key]) || empty($_REQUEST[$key])){
				$result['error']['msg'] = __('Please input').' '.__($key);
				return $this->ajax_process_order($result);
			}
		}
		
		$fields = array('tour_id','fullname','email','mobile','notes','pay_method','adult','children');
		$data = array();
		foreach($fields as $field){
			$data[$field] = $_REQUEST[$field];
		}
		
		HBImporter::libraries('model');
		$model = new HbModel('#__orders','id');	
		
		$tour=ThemexTour::getTour($_REQUEST['tour_id'], true);		
// 		debug($tour);die;
		$data['total'] = $tour['total']*$data['adult'] + $tour['total']*0.7*$data['children'];
		$data['pay_status']="PENDING";
		$data['order_status']="PENDING";
		$data['order_number'] = HBHelper::random_string(5);
		$data['type'] = 'TOUR';
		$data['currency'] = 'VND';
		$data['created']= (new DateTime())->format('Y-m-d H:i:s');
		//debug($data);
		$check = $model->save($data);
		if($check){
// 			debug($data);die;
			$payment_plugin = 'hbpayment_'.$data['pay_method'];
			HBImporter::corePaymentPlugin();
			$order_id = $model->id;
			$payment = new $payment_plugin();
			$payment->config = HBFactory::getConfig();
			$payment->return_url = site_url("index.php?hbaction=payment&task=confirm&method={$data['pay_method']}&paction=display_message&order_id=$order_id");
			$payment->cancel_url = site_url("index.php?hbaction=payment&task=confirm&method={$data['pay_method']}&paction=cancel&order_id=$order_id");
			$payment->notify_url = site_url("index.php?hbaction=payment&task=confirm&method={$data['pay_method']}&paction=process&order_id=$order_id");
			$payment->order = $model;
			$result = $payment->_prePayment();
		}else{
			$result = array(
					'status' => 0,
					'error' => array(
							'code' => '',
							'msg' => $wpdb->last_error
					)
			);
		}
		
		return $this->ajax_process_order($result);
		exit;
	}
	
	function book_hotel(){ 
// 		debug($_REQUEST);
		$result = array(
				'status' => 0,
				'error' => array(
						'code' => '',
						'msg' => 'Error'
				)
		);
		//check nonce
		if ( empty( $_REQUEST['hb_meta_nonce'] ) || ! wp_verify_nonce( $_REQUEST['hb_meta_nonce'], 'hb_meta_nonce' ) ) {
			$result['error']['msg'] = __('Session expired');
			return $this->ajax_process_order($result);
		}
		global $wpdb;
		
		
		$requires = array('tour_id','fullname','email','mobile','checkin');
		foreach($requires as $key){
			if(!isset($_REQUEST[$key]) || empty($_REQUEST[$key])){
				$result['error']['msg'] = __('Please input').' '.__($key);
				return $this->ajax_process_order($result);
			}
		}
		
		$fields = array('tour_id','fullname','email','mobile','notes','adult','children','checkin');
		$data = array();
		foreach($fields as $field){
			$data[$field] = $_REQUEST[$field];
		}
		
		HBImporter::libraries('model');
		$model = new HbModel('#__orders','id');	
		
		$hotel = ThemexTour::get_hotel($_REQUEST['tour_id'], true);		
// 		debug($tour);die;
		//$data['total'] = $tour['total']*$data['adult'] + $tour['total']*0.7*$data['children'];
		$data['pay_status']="PENDING";
		$data['order_status']="PENDING";
		$data['order_number'] = HBHelper::random_string(5);
		$data['currency'] = 'VND';
		$data['type'] = 'HOTEL';
		$data['checkin'] = (new DateTime($data['checkin']))->format('Y-m-d');
		$data['created']= (new DateTime())->format('Y-m-d H:i:s');
		//debug($data);
		$check = $model->save($data);
		//var_dump($data);die;
		if($check){
// 			debug($data);die;
			//send mail
			HBImporter::model('orders');
			HBImporter::helper('currency');
			
			$data =(new HBModelOrders())->getItem($model->id);
			$html = HBHelper::renderLayout('client-order-hotel-confirm', (object)$data,'emails');
	 		//echo $html;die;
			HBHelper::sendMail($data->email, 'Xác nhận đăng kí từ quangbinhtravel', $html);
			$result = array(
					'status' => 1,
					'url' => HBHelper::get_order_link((object)$data)
			);
		}else{
			$result = array(
					'status' => 0,
					'error' => array(
							'code' => '',
							'msg' => $wpdb->last_error
					)
			);
		}
		
		return $this->ajax_process_order($result);
		exit;
	}
	
}