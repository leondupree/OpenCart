<?php
class ControllerTotalCoupon extends Controller {
	private $error = array(); 
	 
	public function index() { 
		$this->load->language('total/coupon');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('coupon', $this->request->post);
		
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->https('extension/total'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
					
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
 
		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

   		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('extension/total'),
       		'text'      => $this->language->get('text_total'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('total/coupon'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->https('total/coupon');
		
		$this->data['cancel'] = $this->url->https('extension/total');

		if (isset($this->request->post['coupon_status'])) {
			$this->data['coupon_status'] = $this->request->post['coupon_status'];
		} else {
			$this->data['coupon_status'] = $this->config->get('coupon_status');
		}

		if (isset($this->request->post['coupon_sort_order'])) {
			$this->data['coupon_sort_order'] = $this->request->post['coupon_sort_order'];
		} else {
			$this->data['coupon_sort_order'] = $this->config->get('coupon_sort_order');
		}
																				
		$this->id       = 'content';
		$this->template = 'total/coupon.tpl';
		$this->layout   = 'common/layout';
		
 		$this->render();
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'total/coupon')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>