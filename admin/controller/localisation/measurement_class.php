<?php
class ControllerLocalisationMeasurementClass extends Controller {
	private $error = array();  
 
	public function index() {
		$this->load->language('localisation/measurement_class');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('localisation/measurement_class');
		
		$this->getList();
	}

	public function insert() {
		$this->load->language('localisation/measurement_class');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('localisation/measurement_class');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_measurement_class->addMeasurementClass($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('localisation/measurement_class' . $url));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('localisation/measurement_class');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('localisation/measurement_class');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_measurement_class->editMeasurementClass($this->request->get['measurement_class_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('localisation/measurement_class' . $url));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('localisation/measurement_class');

		$this->document->title = $this->language->get('heading_title');
 		
		$this->load->model('localisation/measurement_class');
		
		if (isset($this->request->post['delete']) && $this->validateDelete()) {
			foreach ($this->request->post['delete'] as $measurement_class_id) {
				$this->model_localisation_measurement_class->deleteMeasurementClass($measurement_class_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->https('localisation/measurement_class' . $url));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'title';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
	
		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('localisation/measurement_class' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->https('localisation/measurement_class/insert' . $url);
		$this->data['delete'] = $this->url->https('localisation/measurement_class/delete' . $url);
		 
		$this->data['measurement_classes'] = array();
		
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * 10,
			'limit' => 10
		);
		
		$measurement_class_total = $this->model_localisation_measurement_class->getTotalMeasurementClasses();
		
		$results = $this->model_localisation_measurement_class->getMeasurementClasses($data);
		
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('localisation/measurement_class/update&measurement_class_id=' . $result['measurement_class_id'] . $url)
			);

			$this->data['measurement_classes'][] = array(
				'measurement_class_id' => $result['measurement_class_id'],
				'title'                => $result['title'] . (($result['measurement_class_id'] == $this->config->get('config_measurement_class_id')) ? $this->language->get('text_default') : NULL),
				'unit'                 => $result['unit'],
				'delete'               => isset($this->request->post['delete']) && in_array($result['measurement_class_id'], $this->request->post['delete']),
				'action'               => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_unit'] = $this->language->get('column_unit');
		$this->data['column_action'] = $this->language->get('column_action');	

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
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

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=' .  'DESC';
		} else {
			$url .= '&order=' .  'ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_title'] = $this->url->https('localisation/measurement_class&sort=title' . $url);
		$this->data['sort_unit'] = $this->url->https('localisation/measurement_class&sort=unit' . $url);
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $measurement_class_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->https('localisation/measurement_class' . $url . '&page=%s');

		$this->data['pagination'] = $pagination->render();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->id       = 'content';
		$this->template = 'localisation/measurement_class_list.tpl';
		$this->layout   = 'common/layout';
				
		$this->render();
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_unit'] = $this->language->get('entry_unit');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}

 		if (isset($this->error['unitg'])) {
			$this->data['error_unit'] = $this->error['unit'];
		} else {
			$this->data['error_unit'] = '';
		}
		
		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('localisation/measurement_class' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['measurement_class_id'])) {
			$this->data['action'] = $this->url->https('localisation/measurement_class/insert' . $url);
		} else {
			$this->data['action'] = $this->url->https('localisation/measurement_class/update&measurement_class_id=' . $this->request->get['measurement_class_id'] . $url);
		}

		$this->data['cancel'] = $this->url->https('localisation/measurement_class' . $url);
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['measurement_class'])) {
			$this->data['measurement_class'] = $this->request->post['measurement_class'];
		} elseif (isset($this->request->get['measurement_class_id'])) {
			$this->data['measurement_class'] = $this->model_localisation_measurement_class->getMeasurementCLassDescriptions($this->request->get['measurement_class_id']);
		} else {
			$this->data['measurement_class'] = array();
		}	
		
		if (isset($this->request->get['measurement_class_id'])) {
			$this->data['measurement_tos'] = $this->model_localisation_measurement_class->getMeasurementTo($this->request->get['measurement_class_id']);
		} else {
			$this->data['measurement_tos'] = $this->model_localisation_measurement_class->getMeasurementTo(0);
		}
		
		if (isset($this->request->post['weight_rule'])) {
			$this->data['measurement_rule'] = $this->request->post['weight_rule'];
		} elseif (isset($this->request->get['measurement_class_id'])) {
			$this->data['measurement_rule'] = $this->model_localisation_measurement_class->getMeasurementRules($this->request->get['measurement_class_id']);
		} else {
			$this->data['measurement_rule'] = array();
		}				
		
		$this->id       = 'content';
		$this->template = 'localisation/measurement_class_form.tpl';
		$this->layout   = 'common/layout';
		
		$this->render();
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'localisation/measurement_class')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['measurement_class'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['title'])) < 3) || (strlen(utf8_decode($value['title'])) > 32)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if ((!$value['unit']) || (strlen(utf8_decode($value['unit'])) > 4)) {
				$this->error['unit'][$language_id] = $this->language->get('error_unit');
			}
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localisation/measurement_class')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$this->load->model('catalog/product');
		
		foreach ($this->request->post['delete'] as $measurement_class_id) {
			if ($this->config->get('config_measurement_class_id') == $measurement_class_id) {
				$this->error['warning'] = $this->language->get('error_default');
			}
		
			$product_total = $this->model_catalog_product->getTotalProductsByMeasurementClassId($measurement_class_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
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