<?php
class ControllerSettingSetting extends Controller {
	private $error = array();
 
	public function index() { 
		$this->load->language('setting/setting'); 

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$data = array();
			
			if (is_uploaded_file($this->request->files['config_logo']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
				move_uploaded_file($this->request->files['config_logo']['tmp_name'], DIR_IMAGE . $this->request->files['config_logo']['name']);
				
				if (file_exists(DIR_IMAGE . $this->request->files['config_logo']['name'])) {
					$data['config_logo'] = $this->request->files['config_logo']['name'];
				}				
			}

			if (is_uploaded_file($this->request->files['config_icon']['tmp_name']) && is_writable(DIR_IMAGE) && is_writable(DIR_IMAGE . 'cache/')) {
				move_uploaded_file($this->request->files['config_icon']['tmp_name'], DIR_IMAGE . $this->request->files['config_icon']['name']);

				if (file_exists(DIR_IMAGE . $this->request->files['config_icon']['name'])) {
					$data['config_icon'] = $this->request->files['config_icon']['name'];
				}	
			}
			
			$this->model_setting_setting->editSetting('config', array_merge($this->request->post, $data));

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->https('setting/setting'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_mail'] = $this->language->get('text_mail');
		$this->data['text_smtp'] = $this->language->get('text_smtp');
		
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_welcome'] = $this->language->get('entry_welcome');
		$this->data['entry_owner'] = $this->language->get('entry_owner');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_template'] = $this->language->get('entry_template');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_language'] = $this->language->get('entry_language');
		$this->data['entry_admin_language'] = $this->language->get('entry_admin_language');
		$this->data['entry_currency'] = $this->language->get('entry_currency');
		$this->data['entry_currency_auto'] = $this->language->get('entry_currency_auto');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_weight'] = $this->language->get('entry_weight');
		$this->data['entry_measurement'] = $this->language->get('entry_measurement');
		$this->data['entry_alert_mail'] = $this->language->get('entry_alert_mail');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_customer_price'] = $this->language->get('entry_customer_price');
		$this->data['entry_customer_approval'] = $this->language->get('entry_customer_approval');
		$this->data['entry_account'] = $this->language->get('entry_account');
		$this->data['entry_checkout'] = $this->language->get('entry_checkout');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_stock_display'] = $this->language->get('entry_stock_display');
		$this->data['entry_stock_check'] = $this->language->get('entry_stock_check');
		$this->data['entry_stock_checkout'] = $this->language->get('entry_stock_checkout');
		$this->data['entry_stock_subtract'] = $this->language->get('entry_stock_subtract');
		$this->data['entry_stock_status'] = $this->language->get('entry_stock_status');
		$this->data['entry_download'] = $this->language->get('entry_download');
		$this->data['entry_download_status'] = $this->language->get('entry_download_status');
		$this->data['entry_logo'] = $this->language->get('entry_logo');
		$this->data['entry_icon'] = $this->language->get('entry_icon');
		$this->data['entry_image_thumb'] = $this->language->get('entry_image_thumb');
		$this->data['entry_image_popup'] = $this->language->get('entry_image_popup');
		$this->data['entry_image_category'] = $this->language->get('entry_image_category');
		$this->data['entry_image_product'] = $this->language->get('entry_image_product');
		$this->data['entry_image_additional'] = $this->language->get('entry_image_additional');
		$this->data['entry_image_related'] = $this->language->get('entry_image_related');
		$this->data['entry_image_cart'] = $this->language->get('entry_image_cart');
		$this->data['entry_mail_protocol'] = $this->language->get('entry_mail_protocol');
		$this->data['entry_smtp_host'] = $this->language->get('entry_smtp_host');
		$this->data['entry_smtp_username'] = $this->language->get('entry_smtp_username');
		$this->data['entry_smtp_password'] = $this->language->get('entry_smtp_password');
		$this->data['entry_smtp_port'] = $this->language->get('entry_smtp_port');
		$this->data['entry_smtp_timeout'] = $this->language->get('entry_smtp_timeout');
		$this->data['entry_ssl'] = $this->language->get('entry_ssl');
		$this->data['entry_encryption'] = $this->language->get('entry_encryption');
		$this->data['entry_seo_url'] = $this->language->get('entry_seo_url');
		$this->data['entry_compression'] = $this->language->get('entry_compression');
		$this->data['entry_error_display'] = $this->language->get('entry_error_display');
		$this->data['entry_error_log'] = $this->language->get('entry_error_log');
		$this->data['entry_error_filename'] = $this->language->get('entry_error_filename');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_shop'] = $this->language->get('tab_shop');
		$this->data['tab_local'] = $this->language->get('tab_local');
		$this->data['tab_option'] = $this->language->get('tab_option');
		$this->data['tab_image'] = $this->language->get('tab_image');
		$this->data['tab_mail'] = $this->language->get('tab_mail');
		$this->data['tab_server'] = $this->language->get('tab_server');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['store'])) {
			$this->data['error_store'] = $this->error['store'];
		} else {
			$this->data['error_store'] = '';
		}
		
 		if (isset($this->error['meta_description'])) {
			$this->data['error_meta_description'] = $this->error['meta_description'];
		} else {
			$this->data['error_meta_description'] = '';
		}	
		
 		if (isset($this->error['error_filename'])) {
			$this->data['error_error_filename'] = $this->error['error_filename'];
		} else {
			$this->data['error_error_filename'] = '';
		}		
		
		$this->load->model('localisation/language');
		
		$languages = $this->model_localisation_language->getLanguages();
		 
		foreach ($languages as $language) {
 			if (isset($this->error['welcome_' . $language['language_id']])) {
				$this->data['error_welcome_' . $language['language_id']] = $this->error['welcome_' . $language['language_id']];
			} else {
				$this->data['error_welcome_' . $language['language_id']] = '';
			}				
		}

 		if (isset($this->error['owner'])) {
			$this->data['error_owner'] = $this->error['owner'];
		} else {
			$this->data['error_owner'] = '';
		}

 		if (isset($this->error['address'])) {
			$this->data['error_address'] = $this->error['address'];
		} else {
			$this->data['error_address'] = '';
		}
		
 		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}
		
		if (isset($this->error['encryption'])) {
			$this->data['error_encryption'] = $this->error['encryption'];
		} else {
			$this->data['error_encryption'] = '';
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->https('setting/setting'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->data['action'] = $this->url->https('setting/setting');
		
		$this->data['cancel'] = $this->url->https('setting/setting');
		
		if (isset($this->request->post['config_store'])) {
			$this->data['config_store'] = $this->request->post['config_store'];
		} else {
			$this->data['config_store'] = $this->config->get('config_store');
		}

		if (isset($this->request->post['config_meta_description'])) {
			$this->data['config_meta_description'] = $this->request->post['config_meta_description'];
		} else {
			$this->data['config_meta_description'] = $this->config->get('config_meta_description');
		}
		
		$this->load->helper('image');
		
		$this->data['config_logo'] = $this->config->get('config_logo');

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
				$this->data['preview_logo'] = HTTPS_IMAGE . $this->config->get('config_logo');
			} else {
				$this->data['preview_logo'] = HTTP_IMAGE . $this->config->get('config_logo');
			}			
		} else {
			$this->data['preview_logo'] = image_resize('no_image.jpg', 100, 100);
		}
		
		$this->data['config_icon'] = $this->config->get('config_icon');		
		
		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			if ((isset($this->request->server['HTTPS'])) && ($this->request->server['HTTPS'] == 'on')) {
				$this->data['preview_icon'] = HTTPS_IMAGE . $this->config->get('config_icon');
			} else {
				$this->data['preview_icon'] = HTTP_IMAGE . $this->config->get('config_icon');
			}	
		} else {
			$this->data['preview_icon'] = image_resize('no_image.jpg', 100, 100);
		}
		
		foreach ($languages as $language) {
			if (isset($this->request->post['config_welcome_' . $language['language_id']])) {
				$this->data['config_welcome_' . $language['language_id']] = $this->request->post['config_welcome_' . $language['language_id']];
			} else {
				$this->data['config_welcome_' . $language['language_id']] = $this->config->get('config_welcome_' . $language['language_id']);
			}
		}

		if (isset($this->request->post['config_owner'])) {
			$this->data['config_owner'] = $this->request->post['config_owner'];
		} else {
			$this->data['config_owner'] = $this->config->get('config_owner');
		}

		if (isset($this->request->post['config_address'])) {
			$this->data['config_address'] = $this->request->post['config_address'];
		} else {
			$this->data['config_address'] = $this->config->get('config_address');
		}
		
		if (isset($this->request->post['config_email'])) {
			$this->data['config_email'] = $this->request->post['config_email'];
		} else {
			$this->data['config_email'] = $this->config->get('config_email');
		}
		
		if (isset($this->request->post['config_telephone'])) {
			$this->data['config_telephone'] = $this->request->post['config_telephone'];
		} else {
			$this->data['config_telephone'] = $this->config->get('config_telephone');
		}

		if (isset($this->request->post['config_fax'])) {
			$this->data['config_fax'] = $this->request->post['config_fax'];
		} else {
			$this->data['config_fax'] = $this->config->get('config_fax');
		}
		
		$this->data['templates'] = array();

		$directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);
		
		foreach ($directories as $directory) {
			$this->data['templates'][] = array(
				'name'  => basename($directory),
				'value' => basename($directory) . '/template/'
			);
		}
		
		if (isset($this->request->post['config_template'])) {
			$this->data['config_template'] = $this->request->post['config_template'];
		} else {
			$this->data['config_template'] = $this->config->get('config_template');
		}
		
		if (isset($this->request->post['config_country_id'])) {
			$this->data['config_country_id'] = $this->request->post['config_country_id'];
		} else {
			$this->data['config_country_id'] = $this->config->get('config_country_id');
		}
		
		$this->load->model('localisation/country');
		
		$this->data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['config_zone_id'])) {
			$this->data['config_zone_id'] = $this->request->post['config_zone_id'];
		} else {
			$this->data['config_zone_id'] = $this->config->get('config_zone_id');
		}

		if (isset($this->request->post['config_language'])) {
			$this->data['config_language'] = $this->request->post['config_language'];
		} else {
			$this->data['config_language'] = $this->config->get('config_language');
		}

		if (isset($this->request->post['config_admin_language'])) {
			$this->data['config_admin_language'] = $this->request->post['config_admin_language'];
		} else {
			$this->data['config_admin_language'] = $this->config->get('config_admin_language');
		}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['config_currency'])) {
			$this->data['config_currency'] = $this->request->post['config_currency'];
		} else {
			$this->data['config_currency'] = $this->config->get('config_currency');
		}

		if (isset($this->request->post['config_currency_auto'])) {
			$this->data['config_currency_auto'] = $this->request->post['config_currency_auto'];
		} else {
			$this->data['config_currency_auto'] = $this->config->get('config_currency_auto');
		}
		
		$this->load->model('localisation/currency');
		
		$this->data['currencies'] = $this->model_localisation_currency->getCurrencies();
		
		if (isset($this->request->post['config_tax'])) {
			$this->data['config_tax'] = $this->request->post['config_tax'];
		} else {
			$this->data['config_tax'] = $this->config->get('config_tax');
		}
		
		if (isset($this->request->post['config_weight_class_id'])) {
			$this->data['config_weight_class_id'] = $this->request->post['config_weight_class_id'];
		} else {
			$this->data['config_weight_class_id'] = $this->config->get('config_weight_class_id');
		}
		
		$this->load->model('localisation/weight_class');
		
		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
				
		if (isset($this->request->post['config_measurement_class_id'])) {
			$this->data['config_measurement_class_id'] = $this->request->post['config_measurement_class_id'];
		} else {
			$this->data['config_measurement_class_id'] = $this->config->get('config_measurement_class_id');
		}
		
		$this->load->model('localisation/measurement_class');
		
		$this->data['measurement_classes'] = $this->model_localisation_measurement_class->getMeasurementClasses();

		if (isset($this->request->post['config_alert_mail'])) {
			$this->data['config_alert_mail'] = $this->request->post['config_alert_mail'];
		} else {
			$this->data['config_alert_mail'] = $this->config->get('config_alert_mail');
		}

		$this->load->model('customer/customer_group');
		
		$this->data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		
		if (isset($this->request->post['config_customer_group_id'])) {
			$this->data['config_customer_group_id'] = $this->request->post['config_customer_group_id'];
		} else {
			$this->data['config_customer_group_id'] = $this->config->get('config_customer_group_id');
		}
		
		if (isset($this->request->post['config_customer_price'])) {
			$this->data['config_customer_price'] = $this->request->post['config_customer_price'];
		} else {
			$this->data['config_customer_price'] = $this->config->get('config_customer_price');
		}
		
		if (isset($this->request->post['config_customer_approval'])) {
			$this->data['config_customer_approval'] = $this->request->post['config_customer_approval'];
		} else {
			$this->data['config_customer_approval'] = $this->config->get('config_customer_approval');
		}
		
		if (isset($this->request->post['config_account'])) {
			$this->data['config_account'] = $this->request->post['config_account'];
		} else {
			$this->data['config_account'] = $this->config->get('config_account');
		}
		
		if (isset($this->request->post['config_checkout'])) {
			$this->data['config_checkout'] = $this->request->post['config_checkout'];
		} else {
			$this->data['config_checkout'] = $this->config->get('config_checkout');
		}

		$this->load->model('catalog/information');
		
		$this->data['informations'] = $this->model_catalog_information->getInformations();

		if (isset($this->request->post['config_stock_display'])) {
			$this->data['config_stock_display'] = $this->request->post['config_stock_display'];
		} else {
			$this->data['config_stock_display'] = $this->config->get('config_stock_display');
		}
		
		if (isset($this->request->post['config_stock_check'])) {
			$this->data['config_stock_check'] = $this->request->post['config_stock_check'];
		} else {
			$this->data['config_stock_check'] = $this->config->get('config_stock_check');
		}

		if (isset($this->request->post['config_stock_checkout'])) {
			$this->data['config_stock_checkout'] = $this->request->post['config_stock_checkout'];
		} else {
			$this->data['config_stock_checkout'] = $this->config->get('config_stock_checkout');
		}

		if (isset($this->request->post['config_stock_subtract'])) {
			$this->data['config_stock_subtract'] = $this->request->post['config_stock_subtract'];
		} else {
			$this->data['config_stock_subtract'] = $this->config->get('config_stock_subtract');
		}

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['config_order_status_id'])) {
			$this->data['config_order_status_id'] = $this->request->post['config_order_status_id'];
		} else {
			$this->data['config_order_status_id'] = $this->config->get('config_order_status_id');
		}
		
		$this->load->model('localisation/stock_status');
		
		$this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['config_stock_status_id'])) {
			$this->data['config_stock_status_id'] = $this->request->post['config_stock_status_id'];
		} else {
			$this->data['config_stock_status_id'] = $this->config->get('config_stock_status_id');
		}
		
		if (isset($this->request->post['config_download'])) {
			$this->data['config_download'] = $this->request->post['config_download'];
		} else {
			$this->data['config_download'] = $this->config->get('config_download');
		}

		if (isset($this->request->post['config_download_status'])) {
			$this->data['config_download_status'] = $this->request->post['config_download_status'];
		} else {
			$this->data['config_download_status'] = $this->config->get('config_download_status');
		}
		
		if (isset($this->request->post['config_image_thumb_width'])) {
			$this->data['config_image_thumb_width'] = $this->request->post['config_image_thumb_width'];
		} else {
			$this->data['config_image_thumb_width'] = $this->config->get('config_image_thumb_width');
		}
		
		if (isset($this->request->post['config_image_thumb_height'])) {
			$this->data['config_image_thumb_height'] = $this->request->post['config_image_thumb_height'];
		} else {
			$this->data['config_image_thumb_height'] = $this->config->get('config_image_thumb_height');
		}
		
		if (isset($this->request->post['config_image_popup_width'])) {
			$this->data['config_image_popup_width'] = $this->request->post['config_image_popup_width'];
		} else {
			$this->data['config_image_popup_width'] = $this->config->get('config_image_popup_width');
		}
		
		if (isset($this->request->post['config_image_popup_height'])) {
			$this->data['config_image_popup_height'] = $this->request->post['config_image_popup_height'];
		} else {
			$this->data['config_image_popup_height'] = $this->config->get('config_image_popup_height');
		}

		if (isset($this->request->post['config_image_category_width'])) {
			$this->data['config_image_category_width'] = $this->request->post['config_image_category_width'];
		} else {
			$this->data['config_image_category_width'] = $this->config->get('config_image_category_width');
		}
		
		if (isset($this->request->post['config_image_category_height'])) {
			$this->data['config_image_category_height'] = $this->request->post['config_image_category_height'];
		} else {
			$this->data['config_image_category_height'] = $this->config->get('config_image_category_height');
		}
		
		if (isset($this->request->post['config_image_product_width'])) {
			$this->data['config_image_product_width'] = $this->request->post['config_image_product_width'];
		} else {
			$this->data['config_image_product_width'] = $this->config->get('config_image_product_width');
		}
		
		if (isset($this->request->post['config_image_product_height'])) {
			$this->data['config_image_product_height'] = $this->request->post['config_image_product_height'];
		} else {
			$this->data['config_image_product_height'] = $this->config->get('config_image_product_height');
		}

		if (isset($this->request->post['config_image_additional_width'])) {
			$this->data['config_image_additional_width'] = $this->request->post['config_image_additional_width'];
		} else {
			$this->data['config_image_additional_width'] = $this->config->get('config_image_additional_width');
		}
		
		if (isset($this->request->post['config_image_additional_height'])) {
			$this->data['config_image_additional_height'] = $this->request->post['config_image_additional_height'];
		} else {
			$this->data['config_image_additional_height'] = $this->config->get('config_image_additional_height');
		}
		
		if (isset($this->request->post['config_image_related_width'])) {
			$this->data['config_image_related_width'] = $this->request->post['config_image_related_width'];
		} else {
			$this->data['config_image_related_width'] = $this->config->get('config_image_related_width');
		}
		
		if (isset($this->request->post['config_image_related_height'])) {
			$this->data['config_image_related_height'] = $this->request->post['config_image_related_height'];
		} else {
			$this->data['config_image_related_height'] = $this->config->get('config_image_related_height');
		}
		
		if (isset($this->request->post['config_image_cart_width'])) {
			$this->data['config_image_cart_width'] = $this->request->post['config_image_cart_width'];
		} else {
			$this->data['config_image_cart_width'] = $this->config->get('config_image_cart_width');
		}
		
		if (isset($this->request->post['config_image_cart_height'])) {
			$this->data['config_image_cart_height'] = $this->request->post['config_image_cart_height'];
		} else {
			$this->data['config_image_cart_height'] = $this->config->get('config_image_cart_height');
		}
		
		if (isset($this->request->post['config_mail_protocol'])) {
			$this->data['config_mail_protocol'] = $this->request->post['config_mail_protocol'];
		} else {
			$this->data['config_mail_protocol'] = $this->config->get('config_mail_protocol');
		}
		
		if (isset($this->request->post['config_smtp_host'])) {
			$this->data['config_smtp_host'] = $this->request->post['config_smtp_host'];
		} else {
			$this->data['config_smtp_host'] = $this->config->get('config_smtp_host');
		}		

		if (isset($this->request->post['config_smtp_username'])) {
			$this->data['config_smtp_username'] = $this->request->post['config_smtp_username'];
		} else {
			$this->data['config_smtp_username'] = $this->config->get('config_smtp_username');
		}	
		
		if (isset($this->request->post['config_smtp_password'])) {
			$this->data['config_smtp_password'] = $this->request->post['config_smtp_password'];
		} else {
			$this->data['config_smtp_password'] = $this->config->get('config_smtp_password');
		}	
		
		if (isset($this->request->post['config_smtp_port'])) {
			$this->data['config_smtp_port'] = $this->request->post['config_smtp_port'];
		} elseif ($this->config->get('config_smtp_port')) {
			$this->data['config_smtp_port'] = $this->config->get('config_smtp_port');
		} else {
			$this->data['config_smtp_port'] = 25;
		}	
		
		if (isset($this->request->post['config_smtp_timeout'])) {
			$this->data['config_smtp_timeout'] = $this->request->post['config_smtp_timeout'];
		} elseif ($this->config->get('config_smtp_timeout')) {
			$this->data['config_smtp_timeout'] = $this->config->get('config_smtp_timeout');
		} else {
			$this->data['config_smtp_timeout'] = 5;	
		}	
		
		if (isset($this->request->post['config_ssl'])) {
			$this->data['config_ssl'] = $this->request->post['config_ssl'];
		} else {
			$this->data['config_ssl'] = $this->config->get('config_ssl');
		}

		if (isset($this->request->post['config_encryption'])) {
			$this->data['config_encryption'] = $this->request->post['config_encryption'];
		} else {
			$this->data['config_encryption'] = $this->config->get('config_encryption');
		}
		
		if (isset($this->request->post['config_seo_url'])) {
			$this->data['config_seo_url'] = $this->request->post['config_seo_url'];
		} else {
			$this->data['config_seo_url'] = $this->config->get('config_seo_url');
		}
		
		if (isset($this->request->post['config_compression'])) {
			$this->data['config_compression'] = $this->request->post['config_compression']; 
		} else {
			$this->data['config_compression'] = $this->config->get('config_compression');
		}

		if (isset($this->request->post['config_error_display'])) {
			$this->data['config_error_display'] = $this->request->post['config_error_display']; 
		} else {
			$this->data['config_error_display'] = $this->config->get('config_error_display');
		}

		if (isset($this->request->post['config_error_log'])) {
			$this->data['config_error_log'] = $this->request->post['config_error_log']; 
		} else {
			$this->data['config_error_log'] = $this->config->get('config_error_log');
		}

		if (isset($this->request->post['config_error_filename'])) {
			$this->data['config_error_filename'] = $this->request->post['config_error_filename']; 
		} else {
			$this->data['config_error_filename'] = $this->config->get('config_error_filename');
		}
		
		$this->id       = 'content'; 
		$this->template = 'setting/setting.tpl';
		$this->layout   = 'common/layout';
				
		$this->render();
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'setting/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['config_store']) {
			$this->error['store'] = $this->language->get('error_store');
		}				

      	if (strlen(utf8_decode($this->request->post['config_meta_description'])) > 66) {
        	$this->error['meta_description'] = $this->language->get('error_meta_description');
      	}

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();
		
		foreach ($languages as $language) {
			if (!$this->request->post['config_welcome_' . $language['language_id']]) {
				$this->error['welcome_' . $language['language_id']] = $this->language->get('error_welcome');
			}	
		}

		if ((strlen(utf8_decode($this->request->post['config_owner'])) < 3) || (strlen(utf8_decode($this->request->post['config_owner'])) > 32)) {
			$this->error['owner'] = $this->language->get('error_owner');
		}

		if ((strlen(utf8_decode($this->request->post['config_address'])) < 3) || (strlen(utf8_decode($this->request->post['config_address'])) > 128)) {
			$this->error['address'] = $this->language->get('error_address');
		}
		
		$pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i';
		
    	if ((strlen(utf8_decode($this->request->post['config_email'])) > 32) || (!preg_match($pattern, $this->request->post['config_email']))) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if ((strlen(utf8_decode($this->request->post['config_telephone'])) < 3) || (strlen(utf8_decode($this->request->post['config_telephone'])) > 32)) {
      		$this->error['telephone'] = $this->language->get('error_telephone');
    	}

		if (!$this->request->post['config_encryption']) {
			$this->error['encryption'] = $this->language->get('error_encryption');
		}
		
		if (!$this->request->post['config_error_filename']) {
			$this->error['error_filename'] = $this->language->get('error_error_filename');
		}
		
  		if ($this->request->files['config_logo']['name']) {
	  		if ((strlen(utf8_decode($this->request->files['config_logo']['name'])) < 3) || (strlen(utf8_decode($this->request->files['config_logo']['name'])) > 255)) {
        		$this->error['warning'] = $this->language->get('error_filename');
	  		}

		    $allowed = array(
		    	'image/jpeg',
		    	'image/pjpeg',
				'image/png',
				'image/x-png',
				'image/gif'
		    );
				
			if (!in_array($this->request->files['config_logo']['type'], $allowed)) {
				$this->error['warning'] = $this->language->get('error_filetype');
			}
			
			if (!is_writable(DIR_IMAGE)) {
				$this->error['warning'] = $this->language->get('error_writable_image');
			}
			
			if (!is_writable(DIR_IMAGE . 'cache/')) {
				$this->error['warning'] = $this->language->get('error_writable_image_cache');
			}
			
			if ($this->request->files['config_logo']['error'] != UPLOAD_ERR_OK) { 
				$this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['config_logo']['error']);
			}
		}

  		if ($this->request->files['config_icon']['name']) {
	  		if ((strlen(utf8_decode($this->request->files['config_icon']['name'])) < 3) || (strlen(utf8_decode($this->request->files['config_icon']['name'])) > 255)) {
        		$this->error['warning'] = $this->language->get('error_filename');
	  		}

		    $allowed = array(
		    	'image/jpeg',
		    	'image/pjpeg',
				'image/png',
				'image/x-png',
				'image/gif'
		    );
				
			if (!in_array($this->request->files['config_icon']['type'], $allowed)) {
				$this->error['warning'] = $this->language->get('error_filetype');
			}
			
			if (!is_writable(DIR_IMAGE)) {
				$this->error['warning'] = $this->language->get('error_writable_image');
			}
			
			if (!is_writable(DIR_IMAGE . 'cache/')) {
				$this->error['warning'] = $this->language->get('error_writable_image_cache');
			}
			
			if ($this->request->files['config_icon']['error'] != UPLOAD_ERR_OK) { 
				$this->error['warning'] = $this->language->get('error_upload_' . $this->request->files['config_icon']['error']);
			}
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function zone() {
		$output = '';
		
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

		$this->response->setOutput($output);
	}
	
	public function template() {
		$template = str_replace('../', '', dirname($this->request->get['template']));
		
		if ((!isset($this->request->server['HTTPS'])) || ($this->request->server['HTTPS'] != 'on')) {
			$server = HTTP_IMAGE;
		} else {
			$server = HTTPS_IMAGE;
		}
		
		if (file_exists(DIR_IMAGE . 'templates/' . $template . '.png')) {
			$image = $server . 'templates/' . $template . '.png';
		} else {
			$image = $server . 'no_image.jpg';
		}
		
		$this->response->setOutput('<img src="' . $image . '" alt="" title="" style="border: 1px solid #EEEEEE;" />');
	}		
}
?>