<?php 
class ControllerToolErrorLog extends Controller { 
	private $error = array();
	
	public function index() {		
		$this->load->language('tool/error_log');

		$this->document->title = $this->language->get('heading_title');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		 
		$this->data['button_clear'] = $this->language->get('button_clear');
		
		$this->data['tab_general'] = $this->language->get('tab_general');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('tool/error_log'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['clear'] = $this->url->https('tool/error_log/clear');
		
		$file = DIR_LOGS . $this->config->get('config_error_filename');
		
		if (file_exists($file)) {
			$this->data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, NULL);
		} else {
			$this->data['log'] = '';
		}
		
		$this->id       = 'content'; 
		$this->template = 'tool/error_log.tpl';
		$this->layout   = 'common/layout';
		
		$this->render();
	}
	
	public function clear() {
		$this->load->language('tool/error_log');
		
		$file = DIR_LOGS . $this->config->get('config_error_filename');
		
		$handle = fopen($file, 'w+'); 
				
		fclose($handle); 			
		
		$this->session->data['success'] = $this->language->get('text_success');
		
		$this->redirect($this->url->https('tool/error_log'));		
	}
}
?>