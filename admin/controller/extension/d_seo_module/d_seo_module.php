<?php
class ControllerExtensionDSEOModuleDSEOModule extends Controller {
	private $codename = 'd_seo_module';
	private $route = 'extension/d_seo_module/d_seo_module';
	private $config_file = 'd_seo_module';
	private $error = array();
		
	/*
	*	Functions for SEO Module.
	*/
	public function menu() {
		$_language = new Language();
		$_language->load($this->route);
		
		$url_token = '';
		
		if (isset($this->session->data['token'])) {
			$url_token .= 'token=' . $this->session->data['token'];
		}
		
		if (isset($this->session->data['user_token'])) {
			$url_token .= 'user_token=' . $this->session->data['user_token'];
		}
		
		$menu = array();

		if ($this->user->hasPermission('access', 'extension/module/' . $this->codename)) {
			$menu[] = array(
				'name'	   		=> $_language->get('heading_title_main'),
				'href'     		=> $this->url->link('extension/module/' . $this->codename, $url_token, true),
				'sort_order' 	=> 1,
				'children' 		=> array()
			);
		}

		return $menu;
	}
	
	public function dashboard() {
		$dashboards = array();
		
		if ($this->user->hasPermission('access', 'extension/dashboard/d_seo_module_target_keyword')) {
			$dashboards[] = array(
				'html' 			=> $this->load->controller('extension/dashboard/d_seo_module_target_keyword/dashboard'),
				'width' 		=> 12,
				'sort_order' 	=> 20
			);
		}

		return $dashboards;
	}
	
	public function language_add_language($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->addLanguage($data);
	}
		
	public function language_delete_language($data) {
		$this->load->model($this->route);

		$this->{'model_extension_d_seo_module_' . $this->codename}->deleteLanguage($data);
	}
	
	public function setting_tab_general_language() {
		$this->load->model($this->route);
		$this->load->model('extension/module/' . $this->codename);
		
		$languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
		
		$field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');
		
		if (isset($field_info['sheet']['home']['field'])) {
			$data['fields'] = $field_info['sheet']['home']['field'];
		} else {
			$data['fields'] = array();
		}
							
		if (isset($this->request->post['target_keyword'])) {
			$data['target_keyword'] = $this->request->post['target_keyword'];
		} else {
			$data['target_keyword'] = $this->{'model_extension_d_seo_module_' . $this->codename}->getHomeTargetKeyword();
		}
				
		$html_tab_general_language = array();
						
		foreach ($languages as $language) {
			$data['language_id'] = $language['language_id'];
			
			if (isset($data['target_keyword'][$data['language_id']])) {
				foreach ($data['target_keyword'][$data['language_id']] as $sort_order => $keyword) {
					$field_data = array(
						'field_code' => 'target_keyword',
						'filter' => array(
							'store_id' => 0,
							'keyword' => $keyword
						)
					);
			
					$target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
					
					if ($target_keywords) {
						$store_target_keywords = reset($target_keywords);
							
						if ((count($target_keywords) > 1) || (count(reset($store_target_keywords)) > 1)) {
							$data['target_keyword_duplicate'][$data['language_id']][$sort_order] = 1;
						}
					}
				}				
			}
		
			$html_tab_general_language[$data['language_id']] = $this->load->view($this->route . '/setting_tab_general_language', $data);
		}
		
		return $html_tab_general_language;
	}
	
	public function setting_style() {		
		return $this->load->view($this->route . '/setting_style');
	}
	
	public function setting_script() {			
		$url_token = '';
		
		if (isset($this->session->data['token'])) {
			$url_token .= 'token=' . $this->session->data['token'];
		}
		
		if (isset($this->session->data['user_token'])) {
			$url_token .= 'user_token=' . $this->session->data['user_token'];
		}
		
		$data['route'] = $this->route;
		$data['url_token'] = $url_token;
		$data['store_id'] = 0;
		
		return $this->load->view($this->route . '/setting_script', $data);
	}
	
	public function setting_edit_setting($data) {
		$this->load->model($this->route);
				
		$this->{'model_extension_d_seo_module_' . $this->codename}->saveHomeTargetKeyword($data);
	}
	
	public function store_form_tab_general_language() {		
		$this->load->model($this->route);
		$this->load->model('extension/module/' . $this->codename);
		
		$languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
		
		$field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');
		
		if (isset($field_info['sheet']['home']['field'])) {
			$data['fields'] = $field_info['sheet']['home']['field'];
		} else {
			$data['fields'] = array();
		}
									
		if (isset($this->request->post['target_keyword'])) {
			$data['target_keyword'] = $this->request->post['target_keyword'];
		} elseif (isset($this->request->get['store_id'])) {
			$data['target_keyword'] = $this->{'model_extension_d_seo_module_' . $this->codename}->getHomeTargetKeyword($this->request->get['store_id']);
		} else {
			$data['target_keyword'] = array();
		}
							
		$html_tab_general_language = array();
								
		foreach ($languages as $language) {
			$data['language_id'] = $language['language_id'];
			
			if (isset($data['target_keyword'][$data['language_id']]) && isset($this->request->get['store_id'])) {
				foreach ($data['target_keyword'][$data['language_id']] as $sort_order => $keyword) {
					$field_data = array(
						'field_code' => 'target_keyword',
						'filter' => array(
							'store_id' => $this->request->get['store_id'],
							'keyword' => $keyword
						)
					);
			
					$target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
					
					if ($target_keywords) {
						$store_target_keywords = reset($target_keywords);
							
						if ((count($target_keywords) > 1) || (count(reset($store_target_keywords)) > 1)) {
							$data['target_keyword_duplicate'][$data['language_id']][$sort_order] = 1;
						}
					}
				}				
			}
		
			$html_tab_general_language[$data['language_id']] = $this->load->view($this->route . '/store_form_tab_general_language', $data);
		}
		
		return $html_tab_general_language;
	}
	
	public function store_form_style() {		
		return $this->load->view($this->route . '/store_form_style');
	}
	
	public function store_form_script() {	
		$url_token = '';
		
		if (isset($this->session->data['token'])) {
			$url_token .= 'token=' . $this->session->data['token'];
		}
		
		if (isset($this->session->data['user_token'])) {
			$url_token .= 'user_token=' . $this->session->data['user_token'];
		}
		
		$data['route'] = $this->route;
		$data['url_token'] = $url_token;
		
		if (isset($this->request->get['store_id'])) {
			$data['store_id'] = $this->request->get['store_id'];
		} else {
			$data['store_id'] = -1;
		}
		
		return $this->load->view($this->route . '/store_form_script', $data);
	}
	
	public function store_add_store($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->saveHomeTargetKeyword($data);
	}
	
	public function store_edit_store($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->saveHomeTargetKeyword($data);
	}
	
	public function store_delete_store($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->deleteStore($data);
	}
	
	public function category_form_tab_general_language() {		
		$this->load->model($this->route);
		$this->load->model('extension/module/' . $this->codename);
		
		$languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
		
		$field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');
						
		if (isset($field_info['sheet']['category']['field'])) {
			$data['fields'] = $field_info['sheet']['category']['field'];
		} else {
			$data['fields'] = array();
		}
						
		if (isset($this->request->post['target_keyword'])) {
			$data['target_keyword'] = $this->request->post['target_keyword'];
		} elseif (isset($this->request->get['category_id'])) {	
			$data['target_keyword'] = $this->{'model_extension_d_seo_module_' . $this->codename}->getCategoryTargetKeyword($this->request->get['category_id']);
		} else {
			$data['target_keyword'] = array();
		}
		
		$data['store_id'] = 0;
				
		$html_tab_general_language = array();
				
		foreach ($languages as $language) {
			$data['language_id'] = $language['language_id'];
			
			if (isset($data['target_keyword'][$data['store_id']][$data['language_id']])) {
				foreach ($data['target_keyword'][$data['store_id']][$data['language_id']] as $sort_order => $keyword) {
					$field_data = array(
						'field_code' => 'target_keyword',
						'filter' => array(
							'store_id' => $data['store_id'],
							'keyword' => $keyword
						)
					);
			
					$target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
					
					if ($target_keywords) {
						$store_target_keywords = reset($target_keywords);
							
						if ((count($target_keywords) > 1) || (count(reset($store_target_keywords)) > 1)) {
							$data['target_keyword_duplicate'][$data['store_id']][$data['language_id']][$sort_order] = 1;
						}
					}
				}				
			}
			
			$html_tab_general_language[$data['language_id']] = $this->load->view($this->route . '/category_form_tab_general_language', $data);
		}
				
		return $html_tab_general_language;
	}
	
	public function category_form_tab_general_store_language() {
		$this->load->model($this->route);
		$this->load->model('extension/module/' . $this->codename);
		
		$stores = $this->{'model_extension_module_' . $this->codename}->getStores();
		$languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
				
		$field_info = $this->load->controller('extension/module/' . $this->codename . '/getFieldInfo');
		
		if (isset($field_info['sheet']['category']['field'])) {
			$data['fields'] = $field_info['sheet']['category']['field'];
		} else {
			$data['fields'] = array();
		}
		
		if (isset($this->request->post['target_keyword'])) {
			$data['target_keyword'] = $this->request->post['target_keyword'];
		} elseif (isset($this->request->get['category_id'])) {	
			$data['target_keyword'] = $this->{'model_extension_d_seo_module_' . $this->codename}->getCategoryTargetKeyword($this->request->get['category_id']);
		} else {
			$data['target_keyword'] = array();
		}
		
		$html_tab_general_store_language = array();
		
		foreach ($stores as $store) {
			$data['store_id'] = $store['store_id'];
			
			foreach ($languages as $language) {
				$data['language_id'] = $language['language_id'];
			
				if (isset($data['target_keyword'][$data['store_id']][$data['language_id']])) {
					foreach ($data['target_keyword'][$data['store_id']][$data['language_id']] as $sort_order => $keyword) {
						$field_data = array(
							'field_code' => 'target_keyword',
							'filter' => array(
								'store_id' => $data['store_id'],
								'keyword' => $keyword
							)
						);
			
						$target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
						
						if ($target_keywords) {
							$store_target_keywords = reset($target_keywords);
							
							if ((count($target_keywords) > 1) || (count(reset($store_target_keywords)) > 1)) {
								$data['target_keyword_duplicate'][$data['store_id']][$data['language_id']][$sort_order] = 1;
							}
						}
					}				
				}
				
				$html_tab_general_store_language[$data['store_id']][$data['language_id']] = $this->load->view($this->route . '/category_form_tab_general_store_language', $data);
			}
		}
				
		return $html_tab_general_store_language;
	}
	
	public function category_form_style() {		
		return $this->load->view($this->route . '/category_form_style');
	}
	
	public function category_form_script() {			
		$url_token = '';
		
		if (isset($this->session->data['token'])) {
			$url_token .= 'token=' . $this->session->data['token'];
		}
		
		if (isset($this->session->data['user_token'])) {
			$url_token .= 'user_token=' . $this->session->data['user_token'];
		}
		
		$data['route'] = $this->route;
		$data['url_token'] = $url_token;
		
		return $this->load->view($this->route . '/category_form_script', $data);
	}
	
	public function category_add_category($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->saveCategoryTargetKeyword($data);
	}
	
	public function category_edit_category($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->saveCategoryTargetKeyword($data);
	}
	
	public function category_delete_category($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->deleteCategoryTargetKeyword($data);
	}
	
	public function product_form_tab_general_language() {		
		$this->load->model($this->route);
		$this->load->model('extension/module/' . $this->codename);
		
		$languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
		
		$field_info = $this->load->controller('extension/module/' . $this->codename . '/getFieldInfo');
		
		if (isset($field_info['sheet']['product']['field'])) {
			$data['fields'] = $field_info['sheet']['product']['field'];
		} else {
			$data['fields'] = array();
		}
		
		if (isset($this->request->post['target_keyword'])) {
			$data['target_keyword'] = $this->request->post['target_keyword'];
		} elseif (isset($this->request->get['product_id'])) {	
			$data['target_keyword'] = $this->{'model_extension_d_seo_module_' . $this->codename}->getProductTargetKeyword($this->request->get['product_id']);
		} else {
			$data['target_keyword'] = array();
		}
		
		$data['store_id'] = 0;
		
		$html_tab_general_language = array();
				
		foreach ($languages as $language) {
			$data['language_id'] = $language['language_id'];
			
			if (isset($data['target_keyword'][$data['store_id']][$data['language_id']])) {
				foreach ($data['target_keyword'][$data['store_id']][$data['language_id']] as $sort_order => $keyword) {
					$field_data = array(
						'field_code' => 'target_keyword',
						'filter' => array(
							'store_id' => $data['store_id'],
							'keyword' => $keyword
						)
					);
			
					$target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
					
					if ($target_keywords) {
						$store_target_keywords = reset($target_keywords);
							
						if ((count($target_keywords) > 1) || (count(reset($store_target_keywords)) > 1)) {
							$data['target_keyword_duplicate'][$data['store_id']][$data['language_id']][$sort_order] = 1;
						}
					}
				}				
			}
					
			$html_tab_general_language[$data['language_id']] = $this->load->view($this->route . '/product_form_tab_general_language', $data);
		}
				
		return $html_tab_general_language;
	}
	
	public function product_form_tab_general_store_language() {		
		$this->load->model($this->route);
		$this->load->model('extension/module/' . $this->codename);
		
		$stores = $this->{'model_extension_module_' . $this->codename}->getStores();
		$languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
				
		$field_info = $this->load->controller('extension/module/' . $this->codename . '/getFieldInfo');
		
		if (isset($field_info['sheet']['product']['field'])) {
			$data['fields'] = $field_info['sheet']['product']['field'];
		} else {
			$data['fields'] = array();
		}
		
		if (isset($this->request->post['target_keyword'])) {
			$data['target_keyword'] = $this->request->post['target_keyword'];
		} elseif (isset($this->request->get['product_id'])) {	
			$data['target_keyword'] = $this->{'model_extension_d_seo_module_' . $this->codename}->getProductTargetKeyword($this->request->get['product_id']);
		} else {
			$data['target_keyword'] = array();
		}
		
		$html_tab_general_store_language = array();
		
		foreach ($stores as $store) {
			$data['store_id'] = $store['store_id'];
			
			foreach ($languages as $language) {
				$data['language_id'] = $language['language_id'];
			
				if (isset($data['target_keyword'][$data['store_id']][$data['language_id']])) {
					foreach ($data['target_keyword'][$data['store_id']][$data['language_id']] as $sort_order => $keyword) {
						$field_data = array(
							'field_code' => 'target_keyword',
							'filter' => array(
								'store_id' => $data['store_id'],
								'keyword' => $keyword
							)
						);
			
						$target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
						
						if ($target_keywords) {
							$store_target_keywords = reset($target_keywords);
							
							if ((count($target_keywords) > 1) || (count(reset($store_target_keywords)) > 1)) {
								$data['target_keyword_duplicate'][$data['store_id']][$data['language_id']][$sort_order] = 1;
							}
						}
					}				
				}
				
				$html_tab_general_store_language[$data['store_id']][$data['language_id']] = $this->load->view($this->route . '/product_form_tab_general_store_language', $data);
			}
		}
				
		return $html_tab_general_store_language;
	}
	
	public function product_form_style() {		
		return $this->load->view($this->route . '/product_form_style');
	}
	
	public function product_form_script() {	
		$_language = new Language();
		$_language->load($this->route);
		
		$url_token = '';
		
		if (isset($this->session->data['token'])) {
			$url_token .= 'token=' . $this->session->data['token'];
		}
		
		if (isset($this->session->data['user_token'])) {
			$url_token .= 'user_token=' . $this->session->data['user_token'];
		}
		
		$data['route'] = $this->route;
		$data['url_token'] = $url_token;
		$data['text_none'] = $_language->get('text_none');
		
		return $this->load->view($this->route . '/product_form_script', $data);
	}
	
	public function product_add_product($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->saveProductTargetKeyword($data);
	}
	
	public function product_edit_product($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->saveProductTargetKeyword($data);
	}
	
	public function product_delete_product($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->deleteProductTargetKeyword($data);
	}
	
	public function manufacturer_form_tab_general_language() {		
		$this->load->model($this->route);
		$this->load->model('extension/module/' . $this->codename);
		
		$languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
		
		$field_info = $this->load->controller('extension/module/' . $this->codename . '/getFieldInfo');
		
		if (isset($field_info['sheet']['manufacturer']['field'])) {
			$data['fields'] = $field_info['sheet']['manufacturer']['field'];
		} else {
			$data['fields'] = array();
		}
		
		if (isset($this->request->post['target_keyword'])) {
			$data['target_keyword'] = $this->request->post['target_keyword'];
		} elseif (isset($this->request->get['manufacturer_id'])) {
			$data['target_keyword'] = $this->{'model_extension_d_seo_module_' . $this->codename}->getManufacturerTargetKeyword($this->request->get['manufacturer_id']);
		} else {
			$data['target_keyword'] = array();
		}
		
		$data['store_id'] = 0;
				
		$html_tab_general_language = array();
				
		foreach ($languages as $language) {
			$data['language_id'] = $language['language_id'];
			
			if (isset($data['target_keyword'][$data['store_id']][$data['language_id']])) {
				foreach ($data['target_keyword'][$data['store_id']][$data['language_id']] as $sort_order => $keyword) {
					$field_data = array(
						'field_code' => 'target_keyword',
						'filter' => array(
							'store_id' => $data['store_id'],
							'keyword' => $keyword
						)
					);
			
					$target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
					
					if ($target_keywords) {
						$store_target_keywords = reset($target_keywords);
							
						if ((count($target_keywords) > 1) || (count(reset($store_target_keywords)) > 1)) {
							$data['target_keyword_duplicate'][$data['store_id']][$data['language_id']][$sort_order] = 1;
						}
					}
				}				
			}
			
			$html_tab_general_language[$data['language_id']] = $this->load->view($this->route . '/manufacturer_form_tab_general_language', $data);
		}
				
		return $html_tab_general_language;
	}
	
	public function manufacturer_form_tab_general_store_language() {		
		$this->load->model($this->route);
		$this->load->model('extension/module/' . $this->codename);
		
		$stores = $this->{'model_extension_module_' . $this->codename}->getStores();
		$languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
				
		$field_info = $this->load->controller('extension/module/' . $this->codename . '/getFieldInfo');
		
		if (isset($field_info['sheet']['manufacturer']['field'])) {
			$data['fields'] = $field_info['sheet']['manufacturer']['field'];
		} else {
			$data['fields'] = array();
		}
		
		if (isset($this->request->post['target_keyword'])) {
			$data['target_keyword'] = $this->request->post['target_keyword'];
		} elseif (isset($this->request->get['manufacturer_id'])) {	
			$data['target_keyword'] = $this->{'model_extension_d_seo_module_' . $this->codename}->getManufacturerTargetKeyword($this->request->get['manufacturer_id']);
		} else {
			$data['target_keyword'] = array();
		}
		
		$html_tab_general_store_language = array();
		
		foreach ($stores as $store) {
			$data['store_id'] = $store['store_id'];
			
			foreach ($languages as $language) {
				$data['language_id'] = $language['language_id'];
			
				if (isset($data['target_keyword'][$data['store_id']][$data['language_id']])) {
					foreach ($data['target_keyword'][$data['store_id']][$data['language_id']] as $sort_order => $keyword) {
						$field_data = array(
							'field_code' => 'target_keyword',
							'filter' => array(
								'store_id' => $data['store_id'],
								'keyword' => $keyword
							)
						);
			
						$target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
						
						if ($target_keywords) {
							$store_target_keywords = reset($target_keywords);
							
							if ((count($target_keywords) > 1) || (count(reset($store_target_keywords)) > 1)) {
								$data['target_keyword_duplicate'][$data['store_id']][$data['language_id']][$sort_order] = 1;
							}
						}
					}				
				}
				
				$html_tab_general_store_language[$data['store_id']][$data['language_id']] = $this->load->view($this->route . '/manufacturer_form_tab_general_store_language', $data);
			}
		}
				
		return $html_tab_general_store_language;
	}
	
	public function manufacturer_form_style() {		
		return $this->load->view($this->route . '/manufacturer_form_style');
	}
	
	public function manufacturer_form_script() {	
		$url_token = '';
		
		if (isset($this->session->data['token'])) {
			$url_token .= 'token=' . $this->session->data['token'];
		}
		
		if (isset($this->session->data['user_token'])) {
			$url_token .= 'user_token=' . $this->session->data['user_token'];
		}
		
		$data['route'] = $this->route;
		$data['url_token'] = $url_token;
		
		return $this->load->view($this->route . '/manufacturer_form_script', $data);
	}
	
	public function manufacturer_add_manufacturer($data) {
		$this->load->model($this->route);

		$this->{'model_extension_d_seo_module_' . $this->codename}->saveManufacturerTargetKeyword($data);
	}
	
	public function manufacturer_edit_manufacturer($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->saveManufacturerTargetKeyword($data);
	}
	
	public function manufacturer_delete_manufacturer($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->deleteManufacturerTargetKeyword($data);
	}
	
	public function information_form_tab_general_language() {		
		$this->load->model($this->route);
		$this->load->model('extension/module/' . $this->codename);
		
		$languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
		
		$field_info = $this->load->controller('extension/module/' . $this->codename . '/getFieldInfo');
		
		if (isset($field_info['sheet']['information']['field'])) {
			$data['fields'] = $field_info['sheet']['information']['field'];
		} else {
			$data['fields'] = array();
		}
		
		if (isset($this->request->post['target_keyword'])) {
			$data['target_keyword'] = $this->request->post['target_keyword'];
		} elseif (isset($this->request->get['information_id'])) {
			$data['target_keyword'] = $this->{'model_extension_d_seo_module_' . $this->codename}->getInformationTargetKeyword($this->request->get['information_id']);
		} else {
			$data['target_keyword'] = array();
		}
		
		$data['store_id'] = 0;
			
		$html_tab_general_language = array();
				
		foreach ($languages as $language) {
			$data['language_id'] = $language['language_id'];
			
			if (isset($data['target_keyword'][$data['store_id']][$data['language_id']])) {
				foreach ($data['target_keyword'][$data['store_id']][$data['language_id']] as $sort_order => $keyword) {
					$field_data = array(
						'field_code' => 'target_keyword',
						'filter' => array(
							'store_id' => $data['store_id'],
							'keyword' => $keyword
						)
					);
			
					$target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
					
					if ($target_keywords) {
						$store_target_keywords = reset($target_keywords);
							
						if ((count($target_keywords) > 1) || (count(reset($store_target_keywords)) > 1)) {
							$data['target_keyword_duplicate'][$data['store_id']][$data['language_id']][$sort_order] = 1;
						}
					}
				}				
			}
			
			$html_tab_general_language[$data['language_id']] = $this->load->view($this->route . '/information_form_tab_general_language', $data);
		}
				
		return $html_tab_general_language;
	}
	
	public function information_form_tab_general_store_language() {		
		$this->load->model($this->route);
		$this->load->model('extension/module/' . $this->codename);
		
		$stores = $this->{'model_extension_module_' . $this->codename}->getStores();
		$languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
				
		$field_info = $this->load->controller('extension/module/' . $this->codename . '/getFieldInfo');
		
		if (isset($field_info['sheet']['information']['field'])) {
			$data['fields'] = $field_info['sheet']['information']['field'];
		} else {
			$data['fields'] = array();
		}
		
		if (isset($this->request->post['target_keyword'])) {
			$data['target_keyword'] = $this->request->post['target_keyword'];
		} elseif (isset($this->request->get['information_id'])) {	
			$data['target_keyword'] = $this->{'model_extension_d_seo_module_' . $this->codename}->getInformationTargetKeyword($this->request->get['information_id']);
		} else {
			$data['target_keyword'] = array();
		}
		
		$html_tab_general_store_language = array();
		
		foreach ($stores as $store) {
			$data['store_id'] = $store['store_id'];
			
			foreach ($languages as $language) {
				$data['language_id'] = $language['language_id'];
			
				if (isset($data['target_keyword'][$data['store_id']][$data['language_id']])) {
					foreach ($data['target_keyword'][$data['store_id']][$data['language_id']] as $sort_order => $keyword) {
						$field_data = array(
							'field_code' => 'target_keyword',
							'filter' => array(
								'store_id' => $data['store_id'],
								'keyword' => $keyword
							)
						);
			
						$target_keywords = $this->load->controller('extension/module/d_seo_module/getFieldElements', $field_data);
						
						if ($target_keywords) {
							$store_target_keywords = reset($target_keywords);
							
							if ((count($target_keywords) > 1) || (count(reset($store_target_keywords)) > 1)) {
								$data['target_keyword_duplicate'][$data['store_id']][$data['language_id']][$sort_order] = 1;
							}
						}
					}				
				}
				
				$html_tab_general_store_language[$data['store_id']][$data['language_id']] = $this->load->view($this->route . '/information_form_tab_general_store_language', $data);
			}
		}
				
		return $html_tab_general_store_language;
	}
	
	public function information_form_style() {		
		return $this->load->view($this->route . '/information_form_style');
	}
	
	public function information_form_script() {	
		$url_token = '';
		
		if (isset($this->session->data['token'])) {
			$url_token .= 'token=' . $this->session->data['token'];
		}
		
		if (isset($this->session->data['user_token'])) {
			$url_token .= 'user_token=' . $this->session->data['user_token'];
		}
		
		$data['route'] = $this->route;
		$data['url_token'] = $url_token;
		
		return $this->load->view($this->route . '/information_form_script', $data);
	}
	
	public function information_add_information($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->saveInformationTargetKeyword($data);
	}
	
	public function information_edit_information($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->saveInformationTargetKeyword($data);
	}
	
	public function information_delete_information($data) {
		$this->load->model($this->route);
		
		$this->{'model_extension_d_seo_module_' . $this->codename}->deleteInformationTargetKeyword($data);
	}
	
	public function field_elements($filter_data) {
		$this->load->model($this->route);
		
		return $this->{'model_extension_d_seo_module_' . $this->codename}->getFieldElements($filter_data);
	}
}
