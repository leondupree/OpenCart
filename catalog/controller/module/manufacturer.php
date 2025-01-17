<?php  
class ControllerModuleManufacturer extends Controller {
	protected function index() {
		$this->language->load('module/manufacturer');	
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_select'] = $this->language->get('text_select');
		
		if (isset($this->request->get['manufacturer_id'])) {
			$this->data['manufacturer_id'] = $this->request->get['manufacturer_id'];
		} else {
			$this->data['manufacturer_id'] = 0;
		}
		
		$this->load->model('catalog/manufacturer');
		 
		$this->data['manufacturers'] = array();
		
		$results = $this->model_catalog_manufacturer->getManufacturers();
		
		foreach ($results as $result) {
			$this->data['manufacturers'][] = array(
				'manufacturer_id' => $result['manufacturer_id'],
				'name'            => $result['name'],
				'href'            => $this->model_tool_seo_url->rewrite($this->url->http('product/manufacturer&manufacturer_id=' . $result['manufacturer_id']))
			);
		}
		
		$this->id       = 'manufacturer';
		$this->template = $this->config->get('config_template') . 'module/manufacturer.tpl';
		
		$this->render(); 
	}
}
?>