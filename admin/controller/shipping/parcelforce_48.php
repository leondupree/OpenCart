<?php
class ControllerShippingParcelforce48 extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('shipping/parcelforce_48');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('parcelforce_48', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->https('extension/shipping'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['entry_rate'] = $this->language->get('entry_rate');
		$this->data['entry_display_weight'] = $this->language->get('entry_display_weight');
		$this->data['entry_display_insurance'] = $this->language->get('entry_display_insurance');
		$this->data['entry_display_time'] = $this->language->get('entry_display_time');
		$this->data['entry_compensation'] = $this->language->get('entry_compensation');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
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
       		'href'      => $this->url->https('extension/shipping'),
       		'text'      => $this->language->get('text_shipping'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('shipping/parcelforce_48'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->https('shipping/parcelforce_48');
		
		$this->data['cancel'] = $this->url->https('extension/shipping');

		if (isset($this->request->post['parcelforce_48_rate'])) {
			$this->data['parcelforce_48_rate'] = $this->request->post['parcelforce_48_rate'];
		} elseif ($this->config->get('parcelforce_48_rate')) {
			$this->data['parcelforce_48_rate'] = $this->config->get('parcelforce_48_rate');
		} else {
			$this->data['parcelforce_48_rate'] = '10:15.99,12:19.99,14:20.99,16:21.99,18:21.99,20:21.99,22:26.99,24:30.99,26:34.99,28:38.99,30:42.99,35:52.99,40:62.99,45:72.99,50:82.99,55:92.99,60:102.99,65:112.99,70:122.99,75:132.99,80:142.99,85:152.99,90:162.99,95:172.99,100:182.99';	
		}
						
		if (isset($this->request->post['parcelforce_48_display_weight'])) {
			$this->data['parcelforce_48_display_weight'] = $this->request->post['parcelforce_48_display_weight'];
		} else {
			$this->data['parcelforce_48_display_weight'] = $this->config->get('parcelforce_48_display_weight');
		}

		if (isset($this->request->post['parcelforce_48_display_insurance'])) {
			$this->data['parcelforce_48_display_insurance'] = $this->request->post['parcelforce_48_display_insurance'];
		} else {
			$this->data['parcelforce_48_display_insurance'] = $this->config->get('parcelforce_48_display_insurance');
		}

		if (isset($this->request->post['parcelforce_48_display_time'])) {
			$this->data['parcelforce_48_display_time'] = $this->request->post['parcelforce_48_display_time'];
		} else {
			$this->data['parcelforce_48_display_time'] = $this->config->get('parcelforce_48_display_time');
		}
		
		if (isset($this->request->post['parcelforce_48_compensation'])) {
			$this->data['parcelforce_48_compensation'] = $this->request->post['parcelforce_48_compensation'];
		} elseif ($this->config->get('parcelforce_48_compensation')) {
			$this->data['parcelforce_48_compensation'] = $this->config->get('parcelforce_48_compensation');
		} else {
			$this->data['parcelforce_48_compensation'] = '150:0,500:12,1000:24,1500:36,2000:48,2500:60';
		}
		
		if (isset($this->request->post['parcelforce_48_tax_class_id'])) {
			$this->data['parcelforce_48_tax_class_id'] = $this->request->post['parcelforce_48_tax_class_id'];
		} else {
			$this->data['parcelforce_48_tax_class_id'] = $this->config->get('parcelforce_48_tax_class_id');
		}

		if (isset($this->request->post['parcelforce_48_geo_zone_id'])) {
			$this->data['parcelforce_48_geo_zone_id'] = $this->request->post['parcelforce_48_geo_zone_id'];
		} else {
			$this->data['parcelforce_48_geo_zone_id'] = $this->config->get('parcelforce_48_geo_zone_id');
		}
		
		if (isset($this->request->post['parcelforce_48_status'])) {
			$this->data['parcelforce_48_status'] = $this->request->post['parcelforce_48_status'];
		} else {
			$this->data['parcelforce_48_status'] = $this->config->get('parcelforce_48_status');
		}
		
		if (isset($this->request->post['parcelforce_48_sort_order'])) {
			$this->data['parcelforce_48_sort_order'] = $this->request->post['parcelforce_48_sort_order'];
		} else {
			$this->data['parcelforce_48_sort_order'] = $this->config->get('parcelforce_48_sort_order');
		}				

		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
								
		$this->id       = 'content';
		$this->template = 'shipping/parcelforce_48.tpl';
		$this->layout   = 'common/layout';
		
 		$this->render();
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/parcelforce_48')) {
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