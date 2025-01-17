<?php  
class ControllerCheckoutPayment extends Controller {
	private $error = array();
	
  	public function index() {
    	if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->https('checkout/shipping');
			
	  		$this->redirect($this->url->https('account/login'));
    	} 
 
    	if (!$this->cart->hasProducts() || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
      		$this->redirect($this->url->https('checkout/cart'));
    	}
			
    	if ($this->cart->hasShipping()) {
			if (!isset($this->session->data['shipping_method'])) {
	  			$this->redirect($this->url->https('checkout/shipping'));
			}

			if (!$this->customer->hasAddress($this->session->data['shipping_address_id'])) {
	  			$this->redirect($this->url->https('checkout/address/shipping'));
    		}
		} else {
			unset($this->session->data['shipping_address_id']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}
		
		if (!isset($this->session->data['payment_address_id'])) {
			$this->session->data['payment_address_id'] = 0;
		}
		
    	if (!$this->customer->hasAddress($this->session->data['payment_address_id']) && isset($this->session->data['shipping_address_id'])) {
      		$this->session->data['payment_address_id'] = $this->session->data['shipping_address_id'];
    	}
	
    	if (!$this->customer->hasAddress($this->session->data['payment_address_id'])) {
	  		$this->session->data['payment_address_id'] = $this->customer->getAddressId();
    	}

    	if (!isset($this->session->data['payment_address_id'])) {
	  		$this->redirect($this->url->https('checkout/address/payment'));
    	}

		$this->load->model('checkout/extension');
		
		$method_data = array();
		
		$results = $this->model_checkout_extension->getExtensions('payment');

		foreach ($results as $result) {
			$this->load->model('payment/' . $result['key']);
			
			$method = $this->{'model_payment_' . $result['key']}->getMethod(); 
			 
			if ($method) {
				$method_data[$result['key']] = $method;
			}
		}
					 
		$sort_order = array(); 
	  
		foreach ($method_data as $key => $value) {
      		$sort_order[$key] = $value['sort_order'];
    	}

    	array_multisort($sort_order, SORT_ASC, $method_data);			
		
		$this->session->data['payment_methods'] = $method_data;
		
		$this->language->load('checkout/payment');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment']];
		  
	  	  	$this->session->data['comment'] = strip_tags($this->request->post['comment']);
		  
	  		$this->redirect($this->url->https('checkout/confirm'));
    	}

    	$this->document->title = $this->language->get('heading_title'); 
		
		$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->url->http('common/home'),
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
      	); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->url->http('checkout/cart'),
        	'text'      => $this->language->get('text_basket'),
        	'separator' => $this->language->get('text_separator')
      	);

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->url->http('checkout/shipping'),
        	'text'      => $this->language->get('text_shipping'),
        	'separator' => $this->language->get('text_separator')
      	);

      	$this->document->breadcrumbs[] = array(
        	'href'      => $this->url->http('checkout/payment'),
        	'text'      => $this->language->get('text_payment'),
        	'separator' => $this->language->get('text_separator')
      	); 
				
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_payment_to'] = $this->language->get('text_payment_to');
    	$this->data['text_payment_address'] = $this->language->get('text_payment_address');
    	$this->data['text_payment_method'] = $this->language->get('text_payment_method');
    	$this->data['text_payment_methods'] = $this->language->get('text_payment_methods');
    	$this->data['text_comments'] = $this->language->get('text_comments');

    	$this->data['button_change_address'] = $this->language->get('button_change_address');
    	$this->data['button_continue'] = $this->language->get('button_continue');
    	$this->data['button_back'] = $this->language->get('button_back');

		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];
			
			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
    		$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
    	$this->data['action'] = $this->url->https('checkout/payment');
    
		$address = $this->customer->getAddress($this->session->data['payment_address_id']);
    	
		if ($address['address_format']) {
      		$format = $address['address_format'];
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
	  		'firstname' => $address['firstname'],
	  		'lastname'  => $address['lastname'],
	  		'company'   => $address['company'],
      		'address_1' => $address['address_1'],
      		'address_2' => $address['address_2'],
      		'city'      => $address['city'],
      		'postcode'  => $address['postcode'],
      		'zone'      => $address['zone'],
      		'country'   => $address['country']  
		);
	
		$this->data['address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
		
		$this->data['change_address'] = $this->url->https('checkout/address/payment');
		
		$this->data['methods'] = $this->session->data['payment_methods'];

		if (isset($this->request->post['payment'])) {
			$this->data['default'] = $this->request->post['payment'];
		} elseif (isset($this->session->data['payment_method']['id'])) {
    		$this->data['default'] = $this->session->data['payment_method']['id'];
		} else {
			$this->data['default'] = '';
		}
		
		if (isset($this->session->data['comment'])) {
    		$this->data['comment'] = $this->session->data['comment'];
		} else {
			$this->data['comment'] = '';
		}
		
		if ($this->config->get('config_checkout')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout'));
			
			if ($information_info) {
				$this->data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->http('information/information&information_id=' . $this->config->get('config_checkout')), $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} else {
			$this->data['text_agree'] = '';
		}
		
		if (isset($this->request->post['agree'])) { 
      		$this->data['agree'] = $this->request->post['agree'];
		} else {
			$this->data['agree'] = '';
		}
		
    	if ($this->cart->hasShipping()) {
      		$this->data['back'] = $this->url->https('checkout/shipping');
    	} else {
      		$this->data['back'] = $this->url->https('checkout/cart');
    	}
	
		$this->id       = 'content';
		$this->template = $this->config->get('config_template') . 'checkout/payment.tpl';
		$this->layout   = 'common/layout';
		
		$this->render();	
  	}
  
  	private function validate() {
    	if (!isset($this->request->post['payment'])) {
	  		$this->error['warning'] = $this->language->get('error_payment');
		} else {
			if (!isset($this->session->data['payment_methods'][$this->request->post['payment']])) {
				$this->error['warning'] = $this->language->get('error_payment');
			}
		}
		
		if ($this->config->get('config_checkout')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout'));
			
			if ($information_info) {
    			if (!isset($this->request->post['agree'])) {
      				$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
    			}
			}
		}
		
		if (!$this->error) {
	  		return TRUE;
		} else {
	  		return FALSE;
		}
  	}  
}
?>
