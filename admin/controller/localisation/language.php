<?php 
class ControllerLocalisationLanguage extends Controller {
	private $error = array();
  
	public function index() {
		$this->load->language('localisation/language');
		
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('localisation/language');
		
		$this->getList();
	}

	public function insert() {
		$this->load->language('localisation/language');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('localisation/language');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_language->addLanguage($this->request->post);
			
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
			
			$this->redirect($this->url->https('localisation/language' . $url));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('localisation/language');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('localisation/language');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_language->editLanguage($this->request->get['language_id'], $this->request->post);
			
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
					
			$this->redirect($this->url->https('localisation/language' . $url));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('localisation/language');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('localisation/language');
		
		if (isset($this->request->post['delete']) && $this->validateDelete()) {
			foreach ($this->request->post['delete'] as $language_id) {
				$this->model_localisation_language->deleteLanguage($language_id);
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

			$this->redirect($this->url->https('localisation/language' . $url));
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
			$sort = 'name';
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
       		'href'      => $this->url->https('localisation/language' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
	
		$this->data['insert'] = $this->url->https('localisation/language/insert' . $url);
		$this->data['delete'] = $this->url->https('localisation/language/delete' . $url);
	
		$this->data['languages'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * 10,
			'limit' => 10
		);
		
		$language_total = $this->model_localisation_language->getTotalLanguages();
		
		$results = $this->model_localisation_language->getLanguages($data);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('localisation/language/update&language_id=' . $result['language_id'] . $url)
			);
					
			$this->data['languages'][] = array(
				'language_id' => $result['language_id'],
				'name'        => $result['name'] . (($result['code'] == $this->config->get('config_language')) ? $this->language->get('text_default') : NULL),
				'code'        => $result['code'],
				'sort_order'  => $result['sort_order'],
				'delete'      => isset($this->request->post['delete']) && in_array($result['language_id'], $this->request->post['delete']),
				'action'      => $action	
			);		
		}
	
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
    	$this->data['column_code'] = $this->language->get('column_code');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
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
					
		$this->data['sort_name'] = $this->url->https('localisation/language&sort=name' . $url);
		$this->data['sort_code'] = $this->url->https('localisation/language&sort=code' . $url);
		$this->data['sort_sort_order'] = $this->url->https('localisation/language&sort=sort_order' . $url);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $language_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->https('localisation/language' . $url . '&page=%s');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->id       = 'content';
		$this->template = 'localisation/language_list.tpl';
		$this->layout   = 'common/layout';
				
		$this->render();
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_code'] = $this->language->get('entry_code');
		$this->data['entry_locale'] = $this->language->get('entry_locale');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_directory'] = $this->language->get('entry_directory');
		$this->data['entry_filename'] = $this->language->get('entry_filename');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

 		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}
		
 		if (isset($this->error['locale'])) {
			$this->data['error_locale'] = $this->error['locale'];
		} else {
			$this->data['error_locale'] = '';
		}		
		
 		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = '';
		}	
		
 		if (isset($this->error['directory'])) {
			$this->data['error_directory'] = $this->error['directory'];
		} else {
			$this->data['error_directory'] = '';
		}	
		
 		if (isset($this->error['filename'])) {
			$this->data['error_filename'] = $this->error['filename'];
		} else {
			$this->data['error_filename'] = '';
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
       		'href'      => $this->url->https('localisation/language' . $url),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['language_id'])) {
			$this->data['action'] = $this->url->https('localisation/language/insert' . $url);
		} else {
			$this->data['action'] = $this->url->https('localisation/language/update&language_id=' . $this->request->get['language_id'] . $url);
		}
		
		$this->data['cancel'] = $this->url->https('localisation/language' . $url);

		if (isset($this->request->get['language_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$language_info = $this->model_localisation_language->getLanguage($this->request->get['language_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (isset($language_info)) {
			$this->data['name'] = $language_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['code'])) {
			$this->data['code'] = $this->request->post['code'];
		} elseif (isset($language_info)) {
			$this->data['code'] = $language_info['code'];
		} else {
			$this->data['code'] = '';
		}

		if (isset($this->request->post['locale'])) {
			$this->data['locale'] = $this->request->post['locale'];
		} elseif (isset($language_info)) {
			$this->data['locale'] = $language_info['locale'];
		} else {
			$this->data['locale'] = '';
		}
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (isset($language_info)) {
			$this->data['image'] = $language_info['image'];
		} else {
			$this->data['image'] = '';
		}

		if (isset($this->request->post['directory'])) {
			$this->data['directory'] = $this->request->post['directory'];
		} elseif (isset($language_info)) {
			$this->data['directory'] = $language_info['directory'];
		} else {
			$this->data['directory'] = '';
		}

		if (isset($this->request->post['filename'])) {
			$this->data['filename'] = $this->request->post['filename'];
		} elseif (isset($language_info)) {
			$this->data['filename'] = $language_info['filename'];
		} else {
			$this->data['filename'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($language_info)) {
			$this->data['sort_order'] = $language_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}

    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (isset($language_info)) {
			$this->data['status'] = $language_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
		
		$this->id       = 'content';
		$this->template = 'localisation/language_form.tpl';
		$this->layout   = 'common/layout';
		
		$this->render();
	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'localisation/language')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (strlen(utf8_decode($this->request->post['code'])) < 2) {
			$this->error['code'] = $this->language->get('error_code');
		}

		if (!$this->request->post['locale']) {
			$this->error['locale'] = $this->language->get('error_locale');
		}
		
		if (!$this->request->post['directory']) { 
			$this->error['directory'] = $this->language->get('error_directory'); 
		}

		if (!$this->request->post['filename']) {
			$this->error['filename'] = $this->language->get('error_filename');
		}
		
		if ((strlen(utf8_decode($this->request->post['image'])) < 3) || (strlen(utf8_decode($this->request->post['image'])) > 32)) {
			$this->error['image'] = $this->language->get('error_image');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localisation/language')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} 
		
		$this->load->model('customer/order');
		
		foreach ($this->request->post['delete'] as $language_id) {
			$language_info = $this->model_localisation_language->getLanguage($language_id);

			if ($this->config->get('config_language') == @$language_info['code']) {
				$this->error['warning'] = $this->language->get('error_default');
			}
	
			if ($this->config->get('config_admin_language') == @$language_info['code']) {
				$this->error['warning'] = $this->language->get('error_admin');
			}
			
			$order_total = $this->model_customer_order->getTotalOrdersByLanguageId($language_id);

			if ($order_total) {
				$this->error['warning'] = sprintf($this->language->get('error_order'), $order_total);
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