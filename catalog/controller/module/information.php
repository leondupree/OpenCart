<?php  
class ControllerModuleInformation extends Controller {
	protected function index() {
		$this->language->load('module/information');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
    	
		$this->data['text_contact'] = $this->language->get('text_contact');
    	$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		
		$this->load->model('catalog/information');
		
		$this->data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
      		$this->data['informations'][] = array(
        		'title' => $result['title'],
	    		'href'  => $this->model_tool_seo_url->rewrite($this->url->http('information/information&information_id=' . $result['information_id']))
      		);
    	}

		$this->data['contact'] = $this->url->http('information/contact');
    	$this->data['sitemap'] = $this->url->http('information/sitemap');
		
		$this->id       = 'information';
		$this->template = $this->config->get('config_template') . 'module/information.tpl';
		
		$this->render();
	}
}
?>