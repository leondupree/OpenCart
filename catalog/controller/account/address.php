<?php 
class ControllerAccountAddress extends Controller {
	private $error = array();
	  
  	public function index() {
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->https('account/address');

	  		$this->redirect($this->url->https('account/login')); 
    	}
	
    	$this->language->load('account/address');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('account/address');
		
		$this->getList();
  	}

  	public function insert() {
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->https('account/address');

	  		$this->redirect($this->url->https('account/login')); 
    	} 

    	$this->language->load('account/address');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('account/address');
			
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_account_address->addAddress($this->request->post);
			
      		$this->session->data['success'] = $this->language->get('text_insert');

	  		$this->redirect($this->url->https('account/address'));
    	} 
	  	
		$this->getForm();
  	}

  	public function update() {
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->https('account/address');

	  		$this->redirect($this->url->https('account/login')); 
    	} 
		
    	$this->language->load('account/address');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('account/address');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
       		$this->model_account_address->editAddress($this->request->get['address_id'], $this->request->post);
	  		
			if (isset($this->session->data['shipping_address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address_id'])) {
	  			unset($this->session->data['shipping_methods']);
				unset($this->session->data['shipping_method']);				
			}

			if (isset($this->session->data['payment_address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address_id'])) {
	  			unset($this->session->data['payment_methods']);
				unset($this->session->data['payment_method']);				
			}
			
			$this->session->data['success'] = $this->language->get('text_update');
	  
	  		$this->redirect($this->url->https('account/address'));
    	} 
	  	
		$this->getForm();
  	}

  	public function delete() {
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->https('account/address');

	  		$this->redirect($this->url->https('account/login')); 
    	} 
			
    	$this->language->load('account/address');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('account/address');
		
    	if (isset($this->request->get['address_id']) && $this->validateDelete()) {
			$this->model_account_address->deleteAddress($this->request->get['address_id']);	
												
			$this->session->data['success'] = $this->language->get('text_delete');
	  
	  		$this->redirect($this->url->https('account/address'));
    	}
	
		$this->getList();	
  	}

  	private function getList() {
      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->url->http('common/home'),
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->url->http('account/account'),
        	'text'      => $this->language->get('text_account'),
        	'separator' => $this->language->get('text_separator')
      	);

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->url->http('account/address'),
        	'text'      => $this->language->get('heading_title'),
        	'separator' => $this->language->get('text_separator')
      	);
			
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_address_book'] = $this->language->get('text_address_book');
   
    	$this->data['button_new_address'] = $this->language->get('button_new_address');
    	$this->data['button_edit'] = $this->language->get('button_edit');
    	$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['warning'])) {
    		$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
    		unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
    	$this->data['addresses'] = array();
		
		$results = $this->model_account_address->getAddresses();

    	foreach ($results as $result) {
			if ($result['address_format']) {
      			$format = $result['address_format'];
    		} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
		
    		$find = array(
	  			'{firstname}',
	  			'{lastname}',
	  			'{company}',
      			'{address_1}',
      			'{address_2}',
     			'{city}',
      			'{postcode}',
      			'{zone}',
      			'{country}'
			);
	
			$replace = array(
	  			'firstname' => $result['firstname'],
	  			'lastname'  => $result['lastname'],
	  			'company'   => $result['company'],
      			'address_1' => $result['address_1'],
      			'address_2' => $result['address_2'],
      			'city'      => $result['city'],
      			'postcode'  => $result['postcode'],
      			'zone'      => $result['zone'],
      			'country'   => $result['country']  
			);

      		$this->data['addresses'][] = array(
        		'address_id' => $result['address_id'],
        		'address'    => str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format)))),
        		'update'     => $this->url->https('account/address/update&address_id=' . $result['address_id']),
				'delete'     => $this->url->https('account/address/delete&address_id=' . $result['address_id'])
      		);
    	}

    	$this->data['insert'] = $this->url->https('account/address/insert');
		$this->data['back'] = $this->url->https('account/account');
		
		$this->id       = 'content';
		$this->template = $this->config->get('config_template') . 'account/addresses.tpl';
		$this->layout   = 'common/layout';
		
		$this->render();		
  	}

  	private function getForm() {
      	$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->url->http('common/home'),
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->url->http('account/account'),
        	'text'      => $this->language->get('text_account'),
        	'separator' => $this->language->get('text_separator')
      	);

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->url->http('account/address'),
        	'text'      => $this->language->get('heading_title'),
        	'separator' => $this->language->get('text_separator')
      	);
		
		if (!isset($this->request->get['address_id'])) {
      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->url->http('account/address/insert'),
        		'text'      => $this->language->get('text_edit_address'),
        		'separator' => $this->language->get('text_separator')
      		);
		} else {
      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->url->http('account/address/update&address_id=' . $this->request->get['address_id']),
        		'text'      => $this->language->get('text_edit_address'),
        		'separator' => $this->language->get('text_separator')
      		);
		}
						
    	$this->data['heading_title'] = $this->language->get('heading_title');
    	
		$this->data['text_edit_address'] = $this->language->get('text_edit_address');
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
		
    	$this->data['entry_firstname'] = $this->language->get('entry_firstname');
    	$this->data['entry_lastname'] = $this->language->get('entry_lastname');
    	$this->data['entry_company'] = $this->language->get('entry_company');
    	$this->data['entry_address_1'] = $this->language->get('entry_address_1');
    	$this->data['entry_address_2'] = $this->language->get('entry_address_2');
    	$this->data['entry_postcode'] = $this->language->get('entry_postcode');
    	$this->data['entry_city'] = $this->language->get('entry_city');
    	$this->data['entry_country'] = $this->language->get('entry_country');
    	$this->data['entry_zone'] = $this->language->get('entry_zone');
    	$this->data['entry_default'] = $this->language->get('entry_default');

    	$this->data['button_continue'] = $this->language->get('button_continue');
    	$this->data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['firstname'])) {
    		$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}
		
		if (isset($this->error['lastname'])) {
    		$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}
		
		if (isset($this->error['address_1'])) {
    		$this->data['error_address_1'] = $this->error['address_1'];
		} else {
			$this->data['error_address_1'] = '';
		}
		
		if (isset($this->error['city'])) {
    		$this->data['error_city'] = $this->error['city'];
		} else {
			$this->data['error_city'] = '';
		}		
		
		if (!isset($this->request->get['address_id'])) {
    		$this->data['action'] = $this->url->https('account/address/insert');
		} else {
    		$this->data['action'] = $this->url->https('account/address/update&address_id=' . $this->request->get['address_id']);
		}
		
    	if (isset($this->request->get['address_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$address_info = $this->model_account_address->getAddress($this->request->get['address_id']);
		}
	
    	if (isset($this->request->post['firstname'])) {
      		$this->data['firstname'] = $this->request->post['firstname'];
    	} elseif (isset($address_info)) {
      		$this->data['firstname'] = $address_info['firstname'];
    	} else {
			$this->data['firstname'] = '';
		}

    	if (isset($this->request->post['lastname'])) {
      		$this->data['lastname'] = $this->request->post['lastname'];
    	} elseif (isset($address_info)) {
      		$this->data['lastname'] = $address_info['lastname'];
    	} else {
			$this->data['lastname'] = '';
		}

    	if (isset($this->request->post['company'])) {
      		$this->data['company'] = $this->request->post['company'];
    	} elseif (isset($address_info)) {
			$this->data['company'] = $address_info['company'];
		} else {
      		$this->data['company'] = '';
    	}

    	if (isset($this->request->post['address_1'])) {
      		$this->data['address_1'] = $this->request->post['address_1'];
    	} elseif (isset($address_info)) {
			$this->data['address_1'] = $address_info['address_1'];
		} else {
      		$this->data['address_1'] = '';
    	}

    	if (isset($this->request->post['address_2'])) {
      		$this->data['address_2'] = $this->request->post['address_2'];
    	} elseif (isset($address_info)) {
			$this->data['address_2'] = $address_info['address_2'];
		} else {
      		$this->data['address_2'] = '';
    	}	

    	if (isset($this->request->post['postcode'])) {
      		$this->data['postcode'] = $this->request->post['postcode'];
    	} elseif (isset($address_info)) {
			$this->data['postcode'] = $address_info['postcode'];
		} else {
      		$this->data['postcode'] = '';
    	}

    	if (isset($this->request->post['city'])) {
      		$this->data['city'] = $this->request->post['city'];
    	} elseif (isset($address_info)) {
			$this->data['city'] = $address_info['city'];
		} else {
      		$this->data['city'] = '';
    	}

    	if (isset($this->request->post['country_id'])) {
      		$this->data['country_id'] = $this->request->post['country_id'];
    	}  elseif (isset($address_info)) {
      		$this->data['country_id'] = $address_info['country_id'];
    	} else {
      		$this->data['country_id'] = $this->config->get('config_country_id');
    	}

    	if (isset($this->request->post['zone_id'])) {
      		$this->data['zone_id'] = $this->request->post['zone_id'];
    	}  elseif (isset($address_info)) {
      		$this->data['zone_id'] = $address_info['zone_id'];
    	} else {
      		$this->data['zone_id'] = 0;
    	}
		
		$this->load->model('localisation/country');
		
    	$this->data['countries'] = $this->model_localisation_country->getCountries();

    	if (isset($this->request->post['default'])) {
      		$this->data['default'] = $this->request->post['default'];
    	} elseif (isset($this->request->get['address_id'])) {
      		$this->data['default'] = $this->customer->getAddressId() == $this->request->get['address_id'];
    	} else {
			$this->data['default'] = FALSE;
		}

    	$this->data['back'] = $this->url->https('account/address');
		
		$this->id       = 'content';
		$this->template = $this->config->get('config_template') . 'account/address.tpl';
		$this->layout   = 'common/layout';
		
		$this->render();		
  	}
	
  	private function validateForm() {
    	if ((strlen(utf8_decode($this->request->post['firstname'])) < 3) || (strlen(utf8_decode($this->request->post['firstname'])) > 32)) {
      		$this->error['firstname'] = $this->language->get('error_firstname');
    	}

    	if ((strlen(utf8_decode($this->request->post['lastname'])) < 3) || (strlen(utf8_decode($this->request->post['lastname'])) > 32)) {
      		$this->error['lastname'] = $this->language->get('error_lastname');
    	}

    	if ((strlen(utf8_decode($this->request->post['address_1'])) < 3) || (strlen(utf8_decode($this->request->post['address_1'])) > 128)) {
      		$this->error['address_1'] = $this->language->get('error_address_1');
    	}

    	if ((strlen(utf8_decode($this->request->post['city'])) < 3) || (strlen(utf8_decode($this->request->post['city'])) > 128)) {
      		$this->error['city'] = $this->language->get('error_city');
    	}

    	if (!$this->error) {
      		return TRUE;
		} else {
      		return FALSE;
    	}
  	}

  	private function validateDelete() {
    	if ($this->model_account_address->getTotalAddresses() == 1) {
      		$this->error['warning'] = $this->language->get('error_delete');
    	}

    	if ($this->customer->getAddressId() == $this->request->get['address_id']) {
      		$this->error['warning'] = $this->language->get('error_default');
    	}

    	if (!$this->error) {
      		return TRUE;
    	} else {
      		return FALSE;
    	}
  	}
	
  	public function zone() {	
    	$output = '<select name="zone_id">';

		$this->load->model('localisation/zone');

    	$results = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);
        
      	foreach ($results as $result) {
        	$output .= '<option value="' . $result['zone_id'] . '"';
	
	    	if (isset($this->request->get['zone_id']) && ($this->request->get['zone_id'] == $result['zone_id'])) {
	      		$output .= ' selected="selected"';
	    	}
	
	    	$output .= '>' . $result['name'] . '</option>';
    	} 
		
		if (!$results) {
		  	$output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
    	}

    	$output .= '</select>';
	
		$this->response->setOutput($output);
  	}  
}
?>