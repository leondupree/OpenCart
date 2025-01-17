<?php 
class ControllerCatalogCategory extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->language('catalog/category');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/category');
		 
		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/category');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = array();
			
			if (is_uploaded_file($this->request->files['image']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
				move_uploaded_file($this->request->files['image']['tmp_name'], DIR_IMAGE . $this->request->files['image']['name']);
				
				if (file_exists(DIR_IMAGE . $this->request->files['image']['name'])) {
					$data['image'] = $this->request->files['image']['name'];
				}
			}
			
			$this->model_catalog_category->addCategory(array_merge($this->request->post, $data));

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->https('catalog/category')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/category');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = array();
			
			if (is_uploaded_file($this->request->files['image']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
				move_uploaded_file($this->request->files['image']['tmp_name'], DIR_IMAGE . $this->request->files['image']['name']);
				
				if (file_exists(DIR_IMAGE . $this->request->files['image']['name'])) {
					$data['image'] = $this->request->files['image']['name'];
				}
			}

			$this->model_catalog_category->editCategory($this->request->get['category_id'], array_merge($this->request->post, $data));
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->https('catalog/category'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/category');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('catalog/category');
		
		if (isset($this->request->post['delete']) && $this->validateDelete()) {
			foreach ($this->request->post['delete'] as $category_id) {
				$this->model_catalog_category->deleteCategory($category_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->https('catalog/category'));
		}

		$this->getList();
	}

	private function getList() {
   		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('catalog/category'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->https('catalog/category/insert');
		$this->data['delete'] = $this->url->https('catalog/category/delete');
		
		$this->data['categories'] = array();
		
		$results = $this->model_catalog_category->getCategories(0);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->https('catalog/category/update&category_id=' . $result['category_id'])
			);
					
			$this->data['categories'][] = array(
				'category_id' => $result['category_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				'delete'      => isset($this->request->post['delete']) && in_array($result['category_id'], $this->request->post['delete']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
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
		
		$this->id       = 'content';
		$this->template = 'catalog/category_list.tpl';
		$this->layout   = 'common/layout';
				
		$this->render();
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_image'] = $this->language->get('entry_image');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_data'] = $this->language->get('tab_data');

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

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('catalog/category'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['category_id'])) {
			$this->data['action'] = $this->url->https('catalog/category/insert');
		} else {
			$this->data['action'] = $this->url->https('catalog/category/update&category_id=' . $this->request->get['category_id']);
		}
		
		$this->data['cancel'] = $this->url->https('catalog/category');

		if (isset($this->request->get['category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$category_info = $this->model_catalog_category->getCategory($this->request->get['category_id']);
    	}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['category_description'])) {
			$this->data['category_description'] = $this->request->post['category_description'];
		} elseif (isset($category_info)) {
			$this->data['category_description'] = $this->model_catalog_category->getCategoryDescriptions($this->request->get['category_id']);
		} else {
			$this->data['category_description'] = array();
		}

		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($category_info)) {
			$this->data['keyword'] = $category_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);

		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (isset($category_info)) {
			$this->data['parent_id'] = $category_info['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}

		$this->load->helper('image');

		if (isset($category_info) && $category_info['image'] && file_exists(DIR_IMAGE . $category_info['image'])) {
			$this->data['preview'] = image_resize($category_info['image'], 100, 100);
		} else {
			$this->data['preview'] = image_resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($category_info)) {
			$this->data['sort_order'] = $category_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}
		
		$this->id       = 'content';
		$this->template = 'catalog/category_form.tpl';
		$this->layout   = 'common/layout';
		
 		$this->render();
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['category_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['name'])) < 2) || (strlen(utf8_decode($value['name'])) > 32)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
   
  		if ($this->request->files['image']['name']) {
	  		if ((strlen(utf8_decode($this->request->files['image']['name'])) < 3) || (strlen(utf8_decode($this->request->files['image']['name'])) > 255)) {
        		$this->error['warning'] = $this->language->get('error_filename');
	  		}

		    $allowed = array(
		    	'image/jpeg',
		    	'image/pjpeg',
				'image/png',
				'image/x-png',
				'image/gif'
		    );
				
			if (!in_array($this->request->files['image']['type'], $allowed)) {
				$this->error['warning'] = $this->language->get('error_filetype');
			}
			
			if (!is_writable(DIR_IMAGE)) {
				$this->error['warning'] = $this->language->get('error_writable_image');
			}
			
			if (!is_writable(DIR_IMAGE . 'cache/')) {
				$this->error['warning'] = $this->language->get('error_writable_image_cache');
			}
			
			if ($this->request->files['image']['error'] != UPLOAD_ERR_OK) { 
				$this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['image']['error']);
			}
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
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