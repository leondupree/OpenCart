<?php 
class ControllerAccountNewsletter extends Controller {  
	public function index() {
		if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->https('account/newsletter');
	  
	  		$this->redirect($this->url->https('account/login'));
    	} 
		
		$this->language->load('account/newsletter');
    	
		$this->document->title = $this->language->get('heading_title');
				
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load->model('account/customer');
			
			$this->model_account_customer->editNewsletter($this->request->post['newsletter']);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->http('account/account'));
		}

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
        	'href'      => $this->url->http('account/newsletter'),
        	'text'      => $this->language->get('text_newsletter'),
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
		
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

    	$this->data['action'] = $this->url->https('account/newsletter');
		
		$this->data['newsletter'] = $this->customer->getNewsletter();
		
		$this->data['back'] = $this->url->https('account/account');
		
		$this->id       = 'content';
		$this->template = $this->config->get('config_template') . 'account/newsletter.tpl';
		$this->layout   = 'common/layout';
		
		$this->render();			
  	}
}
?>