<?php
class ControllerModuleDSEOModule extends Controller {
	private $id = 'd_seo_module';
	private $route = 'module/d_seo_module';
	private $mbooth = '';
	private $config_file = '';
	private $prefix = '';
	private $sub_versions = array();
	private $error = array(); 
	
	public function __construct($registry) {
		parent::__construct($registry);
		$this->load->model($this->route);

		$this->mbooth = $this->{'model_module_' . $this->id}->getMboothFile($this->id, $this->sub_versions);
		$this->config_file = $this->{'model_module_' . $this->id}->getConfigFile($this->id, $this->sub_versions);
	}

	public function index() {
		$this->load->language($this->route);
		
		$this->load->model($this->route);
		$this->load->model('setting/setting');
		$this->load->model('localisation/language');

		// styles and scripts
		$this->document->addLink('//fonts.googleapis.com/css?family=PT+Sans:400,700,700italic,400italic&subset=latin,cyrillic-ext,latin-ext,cyrillic', "stylesheet");
		$this->document->addStyle('view/stylesheet/shopunity/bootstrap.css');
				
		// Heading
		$this->document->setTitle($this->language->get('heading_title_main'));
		$data['heading_title'] = $this->language->get('heading_title_main');
		
		// Variable
		$data['id'] = $this->id;
		$data['route'] = $this->route;
		$data['mbooth'] = $this->mbooth;
		$data['config'] = $this->config_file;
		$data['token'] =  $this->session->data['token'];
		$data['stores'] = $this->{'model_module_' . $this->id}->getStores();
		$data['languages'] = $this->{'model_module_' . $this->id}->getLanguages();
		$data['version'] = $this->{'model_module_' . $this->id}->getVersion($data['mbooth']);
				
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$data['server'] = HTTPS_SERVER;
			$data['catalog'] = HTTPS_CATALOG;
		} else {
			$data['server'] = HTTP_SERVER;
			$data['catalog'] = HTTP_CATALOG;
		}
				
		// Action
		$data['module_link'] = $this->url->link($this->route, 'token=' . $this->session->data['token'], 'SSL');
		$data['action'] = $this->url->link($this->route . '/save', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['get_cancel'] = str_replace('&amp;', '&', $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		$data['get_update'] = str_replace('&amp;', '&', $this->url->link($this->route.'/getUpdate', 'token=' . $this->session->data['token'], 'SSL'));
		
		// Tab
		$data['text_settings'] = $this->language->get('text_settings');
		$data['text_instructions'] = $this->language->get('text_instructions');
		$data['text_instructions_full'] = $this->language->get('text_instructions_full');
		
		// Button
		$data['button_save'] = $this->language->get('button_save');
		$data['button_save_and_stay'] = $this->language->get('button_save_and_stay');
		$data['button_cancel'] = $this->language->get('button_cancel');	
		$data['button_get_update'] = $this->language->get('button_get_update');
				
		// Entry
		$data['entry_get_update'] = sprintf($this->language->get('entry_get_update'), $data['version']);
		$data['entry_status'] = $this->language->get('entry_status');
				
		// Text
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_module'] = $this->language->get('text_module');
				
		// Notification		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		// Breadcrumbs
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_modules'),
			'href' => $this->url->link('extension/modules', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_main'),
			'href' => $this->url->link($this->route, 'token=' . $this->session->data['token'], 'SSL')
		);

		if (isset($this->request->post[$this->id . '_status'])) {
			$data[$this->id . '_status'] = $this->request->post[$this->id . '_status'];
		} else {
			$data[$this->id . '_status'] = $this->config->get($this->id . '_status');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->route . '.tpl', $data));
	}
	
	public function save() {
		$this->load->language($this->route);
		
		$this->load->model($this->route);
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting($this->id, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
		}
						
		$data['error'] = $this->error;
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		$this->response->setOutput(json_encode($data));
	}
	
	public function menu_after($route, $data, &$output) {
		$this->load->language($this->route);
		
		$this->load->model($this->route);
		
		require_once(DIR_SYSTEM . 'library/simple_html_dom.php');
		$html_dom = new simple_html_dom();
		$html_dom->load($output, $lowercase=true, $stripRN=false, $defaultBRText=DEFAULT_BR_TEXT);
		
		$html_menu = '<li id="d_seo"><a class="parent"><i class="fa fa-signal fa-fw"></i> <span>' . $this->language->get('text_seo') . '</span></a><ul>';
		
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
		
		foreach ($seo_extensions as $seo_extension) {
			$html_menu .= $this->load->controller('module/' . $seo_extension . '/menu');
		}
		
		$html_menu .= '</ul></li>';
		
		if ($html_menu) {
			$html_dom->find('#dashboard', 0)->outertext .= $html_menu;
		}
		
		$output = $html_dom;
	}
	
	public function menu() {
		$this->load->language($this->route);
		
		$data['name'] = $this->language->get('heading_title_main');
		
		$data['link'] = $this->url->link($this->route, 'token=' . $this->session->data['token'], true);
		
		return $this->load->view($this->route . '/menu.tpl', $data);
	}
	
	public function setting_after($route, $data, &$output) {
		$this->load->language($this->route);
		
		$this->load->model($this->route);
		
		require_once(DIR_SYSTEM . 'library/simple_html_dom.php');
		$html_dom = new simple_html_dom();
		$html_dom->load($output, $lowercase=true, $stripRN=false, $defaultBRText=DEFAULT_BR_TEXT);
		
		$html_tab_general = '';
		$html_tab_general_language = array();
		$html_tab_store = '';
		$html_tab_local = '';
		$html_tab_option = '';
		$html_tab_seo = '';
		$html_style = '';
		$html_script = '';
		
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
		$languages = $this->{'model_module_' . $this->id}->getLanguages();
		
		foreach ($seo_extensions as $seo_extension) {
			$html_tab_general .= $this->load->controller('module/' . $seo_extension . '/setting_tab_general');
			foreach ($languages as $language) {
				if (!isset($html_tab_general_language[$language['language_id']])) $html_tab_general_language[$language['language_id']] = '';
				$html_tab_general_language[$language['language_id']] .= $this->load->controller('module/' . $seo_extension . '/setting_tab_general_language', $language['language_id']);
			}
			$html_tab_store .= $this->load->controller('module/' . $seo_extension . '/setting_tab_store');
			$html_tab_local .= $this->load->controller('module/' . $seo_extension . '/setting_tab_local');
			$html_tab_option .= $this->load->controller('module/' . $seo_extension . '/setting_tab_option');
			$html_tab_seo .= $this->load->controller('module/' . $seo_extension . '/setting_tab_seo');
			$html_style .= $this->load->controller('module/' . $seo_extension . '/setting_style');
			$html_script .= $this->load->controller('module/' . $seo_extension . '/setting_script');
		}	
		
		if ($html_tab_general) {
			$html_dom->find('#tab-general', 0)->innertext .= $html_tab_general;
		}
		if (reset($html_tab_general_language)) {
			$html_languages = '<ul class="nav nav-tabs" id="language">';
			foreach ($languages as $language) {
				$html_languages .= '<li' . (($language==reset($languages)) ? ' class="active"' : '') . '><a href="#language' . $language['language_id'] . '" data-toggle="tab"><img src="language/' . $language['code'] . '/' . $language['code'] . '.png" title="' . $language['name'] . '" /> ' . $language['name'] . '</a></li>';
            }
            $html_languages .= '</ul>';
			$html_languages .= '<div class="tab-language tab-content">';
			foreach ($languages as $language) {
				$html_languages .= '<div class="tab-pane' . (($language==reset($languages)) ? ' active' : '') . '" id="language' . $language['language_id'] . '"></div>';
            }
			$html_languages .= '</div>';
						
			$html_dom->find('#tab-general', 0)->innertext = $html_languages . $html_dom->find('#tab-general', 0)->innertext;
			$html_dom->load((string)$html_dom, $lowercase=true, $stripRN=false, $defaultBRText=DEFAULT_BR_TEXT);
			
			foreach ($languages as $language) {
				$html_dom->find('#tab-general #language' . $language['language_id'], 0)->innertext .= $html_tab_general_language[$language['language_id']];
			}
		}
		if ($html_tab_store) {
			$html_dom->find('#tab-store', 0)->innertext .= $html_tab_store;
		}
		if ($html_tab_local) {
			$html_dom->find('#tab-local', 0)->innertext .= $html_tab_local;
		}
		if ($html_tab_option) {
			$html_dom->find('#tab-option', 0)->innertext .= $html_tab_option;
		}
		if ($html_tab_seo) {
			$html_dom->find('[href="#tab-server"]', 0)->innertext .= '<li><a href="#tab-seo" data-toggle="tab">' . $this->language->get('text_seo') . '</a></li>';
			$html_dom->find('#tab-server', 0)->outertext .= '<div class="tab-pane" id="tab-seo">' . $html_tab_seo . '</div>';
		}
		if ($html_style) {
			$html_dom->find('#content', 0)->innertext .= '<style type="text/css">' . $html_style . '</style>';	
		}
		if ($html_script) {
			$html_dom->find('#footer', 0)->outertext .= '<script type="text/javascript">' . $html_script . '</script>';	
		}
		
		$output = $html_dom;
	}
	
	public function category_form($route, $data, &$output) {
		$this->load->language($this->route);
		
		$this->load->model($this->route);
		
		require_once(DIR_SYSTEM . 'library/simple_html_dom.php');
		$html_dom = new simple_html_dom();
		$html_dom->load($output, $lowercase=true, $stripRN=false, $defaultBRText=DEFAULT_BR_TEXT);
		
		$html_tab_general = '';
		$html_tab_general_language = array();
		$html_tab_data = '';
		$html_tab_seo = '';
		$html_style = '';
		$html_script = '';
		
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
		$languages = $this->{'model_module_' . $this->id}->getLanguages();
		
		foreach ($seo_extensions as $seo_extension) {
			$html_tab_general .= $this->load->controller('module/' . $seo_extension . '/category_form_tab_general');
			foreach ($languages as $language) {
				if (!isset($html_tab_general_language[$language['language_id']])) $html_tab_general_language[$language['language_id']] = '';
				$html_tab_general_language[$language['language_id']] .= $this->load->controller('module/' . $seo_extension . '/category_form_tab_general_language', $language['language_id']);
			}
			$html_tab_data .= $this->load->controller('module/' . $seo_extension . '/category_form_tab_data');
			$html_tab_seo .= $this->load->controller('module/' . $seo_extension . '/category_form_tab_seo');
			$html_style .= $this->load->controller('module/' . $seo_extension . '/category_form_style');
			$html_script .= $this->load->controller('module/' . $seo_extension . '/category_form_script');
		}	
		if ($html_tab_general) {
			$html_dom->find('#tab-general', 0)->innertext .= $html_tab_general;
		}
		if (reset($html_tab_general_language)) {
			foreach ($languages as $language) {
				$html_dom->find('#tab-general #language' . $language['language_id'], 0)->innertext .= $html_tab_general_language[$language['language_id']];
			}
		}
		if ($html_tab_data) {
			$html_dom->find('#tab-data', 0)->innertext .= $html_tab_data;
		}
		if ($html_tab_seo) {
			$html_dom->find('[href="#tab-design"]', 0)->innertext .= '<li><a href="#tab-seo" data-toggle="tab">' . $this->language->get('text_seo') . '</a></li>';
			$html_dom->find('#tab-design', 0)->outertext .= '<div class="tab-pane" id="tab-seo">' . $html_tab_seo . '</div>';
		}
		if ($html_style) {
			$html_dom->find('#content', 0)->innertext .= '<style type="text/css">' . $html_style . '</style>';	
		}
		if ($html_script) {
			$html_dom->find('#footer', 0)->outertext .= '<script type="text/javascript">' . $html_script . '</script>';	
		}
		
		$output = $html_dom;
	}
	
	public function category_add($route, $output, $data) {
		$this->load->model($this->route);
		
		$data['category_id'] = $output;
				
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
				
		foreach ($seo_extensions as $seo_extension) {
			$this->load->controller('module/' . $seo_extension . '/category_form_save', $data);
		}
	}
	
	public function category_edit($route, $output, $category_id, $data) {
		$this->load->model($this->route);
		
		$data['category_id'] = $category_id;
				
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
				
		foreach ($seo_extensions as $seo_extension) {
			$this->load->controller('module/' . $seo_extension . '/category_form_save', $data);
		}
	}
	
	public function product_form($route, $data, &$output) {
		$this->load->language($this->route);
		
		$this->load->model($this->route);
		
		require_once(DIR_SYSTEM . 'library/simple_html_dom.php');
		$html_dom = new simple_html_dom();
		$html_dom->load($output, $lowercase=true, $stripRN=false, $defaultBRText=DEFAULT_BR_TEXT);
		
		$html_tab_general = '';
		$html_tab_general_language = array();
		$html_tab_data = '';
		$html_tab_links = '';
		$html_tab_seo = '';
		$html_style = '';
		$html_script = '';
		
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
		$languages = $this->{'model_module_' . $this->id}->getLanguages();
		
		foreach ($seo_extensions as $seo_extension) {
			$html_tab_general .= $this->load->controller('module/' . $seo_extension . '/product_form_tab_general');
			foreach ($languages as $language) {
				if (!isset($html_tab_general_language[$language['language_id']])) $html_tab_general_language[$language['language_id']] = '';
				$html_tab_general_language[$language['language_id']] .= $this->load->controller('module/' . $seo_extension . '/product_form_tab_general_language', $language['language_id']);
			}
			$html_tab_data .= $this->load->controller('module/' . $seo_extension . '/product_form_tab_data');
			$html_tab_links .= $this->load->controller('module/' . $seo_extension . '/product_form_tab_links');
			$html_tab_seo .= $this->load->controller('module/' . $seo_extension . '/product_form_tab_seo');
			$html_style .= $this->load->controller('module/' . $seo_extension . '/product_form_style');
			$html_script .= $this->load->controller('module/' . $seo_extension . '/product_form_script');
		}	
		if ($html_tab_general) {
			$html_dom->find('#tab-general', 0)->innertext .= $html_tab_general;
		}
		if (reset($html_tab_general_language)) {
			foreach ($languages as $language) {
				$html_dom->find('#tab-general #language' . $language['language_id'], 0)->innertext .= $html_tab_general_language[$language['language_id']];
			}
		}
		if ($html_tab_data) {
			$html_dom->find('#tab-data', 0)->innertext .= $html_tab_data;
		}
		if ($html_tab_links) {
			$html_dom->find('#tab-links', 0)->innertext .= $html_tab_links;
		}
		if ($html_tab_seo) {
			$html_dom->find('[href="#tab-design"]', 0)->innertext .= '<li><a href="#tab-seo" data-toggle="tab">' . $this->language->get('text_seo') . '</a></li>';
			$html_dom->find('#tab-design', 0)->outertext .= '<div class="tab-pane" id="tab-seo">' . $html_tab_seo . '</div>';
		}
		if ($html_style) {
			$html_dom->find('#content', 0)->innertext .= '<style type="text/css">' . $html_style . '</style>';	
		}
		if ($html_script) {
			$html_dom->find('#footer', 0)->outertext .= '<script type="text/javascript">' . $html_script . '</script>';	
		}
		
		$output = $html_dom;
	}
	
	public function product_add($route, $output, $data) {
		$this->load->model($this->route);
		
		$data['product_id'] = $output;
				
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
				
		foreach ($seo_extensions as $seo_extension) {
			$this->load->controller('module/' . $seo_extension . '/product_form_save', $data);
		}
	}
	
	public function product_edit($route, $output, $product_id, $data) {
		$this->load->model($this->route);
		
		$data['product_id'] = $product_id;
				
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
				
		foreach ($seo_extensions as $seo_extension) {
			$this->load->controller('module/' . $seo_extension . '/product_form_save', $data);
		}
	}
	
	public function manufacturer_form($route, $data, &$output) {
		$this->load->language($this->route);
		
		$this->load->model($this->route);
		
		require_once(DIR_SYSTEM . 'library/simple_html_dom.php');
						
		$html_tab_general = '';
		$html_tab_general_language = array();
		$html_tab_data = '';
		$html_tab_seo = '';
		$html_style = '';
		$html_script = '';
		
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
		$languages = $this->{'model_module_' . $this->id}->getLanguages();
				
		foreach ($seo_extensions as $seo_extension) {
			$html_tab_general .= $this->load->controller('module/' . $seo_extension . '/manufacturer_form_tab_general');
			foreach ($languages as $language) {
				if (!isset($html_tab_general_language[$language['language_id']])) $html_tab_general_language[$language['language_id']] = '';
				$html_tab_general_language[$language['language_id']] .= $this->load->controller('module/' . $seo_extension . '/manufacturer_form_tab_general_language', $language['language_id']);
			}
			$html_tab_data .= $this->load->controller('module/' . $seo_extension . '/manufacturer_form_tab_data');
			$html_tab_seo .= $this->load->controller('module/' . $seo_extension . '/manufacturer_form_tab_seo');
			$html_style .= $this->load->controller('module/' . $seo_extension . '/manufacturer_form_style');
			$html_script .= $this->load->controller('module/' . $seo_extension . '/manufacturer_form_script');
		}	
		
		$html_dom = new simple_html_dom();
		$html_dom->load($output, $lowercase=true, $stripRN=false, $defaultBRText=DEFAULT_BR_TEXT);
		$html_manufacturer_name = $html_dom->find('#form-manufacturer .form-group', 0)->outertext;
		$html_dom->find('#form-manufacturer .form-group', 0)->outertext = '';
		$html_manufacturer_data = $html_dom->find('#form-manufacturer', 0)->innertext;
		$html_dom->find('#form-manufacturer', 0)->innertext = '<ul class="nav nav-tabs"><li class="active"><a href="#tab-general" data-toggle="tab">' . $this->language->get('text_general') . '</a></li><li><a href="#tab-data" data-toggle="tab">' . $this->language->get('text_data') . '</a></li></ul><div class="tab-main tab-content"><div class="tab-pane active" id="tab-general">' . $html_manufacturer_name . '</div><div class="tab-pane" id="tab-data">' . $html_manufacturer_data . '</div></div>';
		$html_dom->load((string)$html_dom, $lowercase=true, $stripRN=false, $defaultBRText=DEFAULT_BR_TEXT);
		
		if ($html_tab_general) {
			$html_dom->find('#tab-general', 0)->innertext .= $html_tab_general;
		}
		if (reset($html_tab_general_language)) {
			$html_languages = '<ul class="nav nav-tabs" id="language">';
			foreach ($languages as $language) {
				$html_languages .= '<li' . (($language==reset($languages)) ? ' class="active"' : '') . '><a href="#language' . $language['language_id'] . '" data-toggle="tab"><img src="language/' . $language['code'] . '/' . $language['code'] . '.png" title="' . $language['name'] . '" /> ' . $language['name'] . '</a></li>';
            }
            $html_languages .= '</ul>';
			$html_languages .= '<div class="tab-language tab-content">';
			foreach ($languages as $language) {
				$html_languages .= '<div class="tab-pane' . (($language==reset($languages)) ? ' active' : '') . '" id="language' . $language['language_id'] . '"></div>';
            }
			$html_languages .= '</div>';
						
			$html_dom->find('#tab-general', 0)->innertext .= $html_languages;
			$html_dom->load((string)$html_dom, $lowercase=true, $stripRN=false, $defaultBRText=DEFAULT_BR_TEXT);
			
			foreach ($languages as $language) {
				$html_dom->find('#tab-general #language' . $language['language_id'], 0)->innertext .= $html_tab_general_language[$language['language_id']];
			}
		}
		if ($html_tab_data) {
			$html_dom->find('#tab-data', 0)->innertext .= $html_tab_data;
		}
		if ($html_tab_seo) {
			$html_dom->find('[href="#tab-data"]', 0)->innertext .= '<li><a href="#tab-seo" data-toggle="tab">' . $this->language->get('text_seo') . '</a></li>';
			$html_dom->find('#tab-data', 0)->outertext .= '<div class="tab-pane" id="tab-seo">' . $html_tab_seo . '</div>';
		}
		if ($html_style) {
			$html_dom->find('#content', 0)->innertext .= '<style type="text/css">' . $html_style . '</style>';	
		}
		if ($html_script) {
			$html_dom->find('#footer', 0)->outertext .= '<script type="text/javascript">' . $html_script . '</script>';	
		}
		
		$output = $html_dom;
	}
	
	public function manufacturer_add($route, $output, $data) {
		$this->load->model($this->route);
		
		$data['manufacturer_id'] = $output;
				
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
				
		foreach ($seo_extensions as $seo_extension) {
			$this->load->controller('module/' . $seo_extension . '/manufacturer_form_save', $data);
		}
	}
	
	public function manufacturer_edit($route, $output, $manufacturer_id, $data) {
		$this->load->model($this->route);
		
		$data['manufacturer_id'] = $manufacturer_id;
				
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
				
		foreach ($seo_extensions as $seo_extension) {
			$this->load->controller('module/' . $seo_extension . '/manufacturer_form_save', $data);
		}
	}
				
	public function information_form($route, $data, &$output) {
		$this->load->language($this->route);
		
		$this->load->model($this->route);
		
		require_once(DIR_SYSTEM . 'library/simple_html_dom.php');
		$html_dom = new simple_html_dom();
		$html_dom->load($output, $lowercase=true, $stripRN=false, $defaultBRText=DEFAULT_BR_TEXT);
		
		$html_tab_general = '';
		$html_tab_general_language = array();
		$html_tab_data = '';
		$html_tab_seo = '';
		$html_style = '';
		$html_script = '';
		
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
		$languages = $this->{'model_module_' . $this->id}->getLanguages();
		
		foreach ($seo_extensions as $seo_extension) {
			$html_tab_general .= $this->load->controller('module/' . $seo_extension . '/information_form_tab_general');
			foreach ($languages as $language) {
				if (!isset($html_tab_general_language[$language['language_id']])) $html_tab_general_language[$language['language_id']] = '';
				$html_tab_general_language[$language['language_id']] .= $this->load->controller('module/' . $seo_extension . '/information_form_tab_general_language', $language['language_id']);
			}
			$html_tab_data .= $this->load->controller('module/' . $seo_extension . '/information_form_tab_data');
			$html_tab_seo .= $this->load->controller('module/' . $seo_extension . '/information_form_tab_seo');
			$html_style .= $this->load->controller('module/' . $seo_extension . '/information_form_style');
			$html_script .= $this->load->controller('module/' . $seo_extension . '/information_form_script');
		}	
		if ($html_tab_general) {
			$html_dom->find('#tab-general', 0)->innertext .= $html_tab_general;
		}
		if (reset($html_tab_general_language)) {
			foreach ($languages as $language) {
				$html_dom->find('#tab-general #language' . $language['language_id'], 0)->innertext .= $html_tab_general_language[$language['language_id']];
			}
		}
		if ($html_tab_data) {
			$html_dom->find('#tab-data', 0)->innertext .= $html_tab_data;
		}
		if ($html_tab_seo) {
			$html_dom->find('[href="#tab-design"]', 0)->innertext .= '<li><a href="#tab-seo" data-toggle="tab">' . $this->language->get('text_seo') . '</a></li>';
			$html_dom->find('#tab-design', 0)->outertext .= '<div class="tab-pane" id="tab-seo">' . $html_tab_seo . '</div>';
		}
		if ($html_style) {
			$html_dom->find('#content', 0)->innertext .= '<style type="text/css">' . $html_style . '</style>';	
		}
		if ($html_script) {
			$html_dom->find('#footer', 0)->outertext .= '<script type="text/javascript">' . $html_script . '</script>';		
		}
		
		$output = $html_dom;
	}
	
	public function information_add($route, $output, $data) {
		$this->load->model($this->route);
		
		$data['information_id'] = $output;
				
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
				
		foreach ($seo_extensions as $seo_extension) {
			$this->load->controller('module/' . $seo_extension . '/information_form_save', $data);
		}
	}
	
	public function information_edit($route, $output, $information_id, $data) {
		$this->load->model($this->route);
		
		$data['information_id'] = $information_id;
				
		$seo_extensions = $this->{'model_module_' . $this->id}->getSEOExtensions();
				
		foreach ($seo_extensions as $seo_extension) {
			$this->load->controller('module/' . $seo_extension . '/information_form_save', $data);
		}
	}
				
	private function validate() {
		if (!$this->user->hasPermission('modify', $this->route)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function install() {
		$this->load->model($this->route);
		$this->load->model('extension/event');
		
		$this->{'model_module_' . $this->id}->installModule();
		$this->{'model_module_' . $this->id}->installDependencies($this->mbooth);
		
		$this->model_extension_event->addEvent($this->id, 'admin/view/common/menu/after', 'module/d_seo_module/menu_after');	
		$this->model_extension_event->addEvent($this->id, 'admin/view/setting/setting/after', 'module/d_seo_module/setting_after');		
		$this->model_extension_event->addEvent($this->id, 'admin/view/setting/store_form/after', 'module/d_seo_module/setting_after');	
		$this->model_extension_event->addEvent($this->id, 'admin/view/catalog/category_form/after', 'module/d_seo_module/category_form');
		$this->model_extension_event->addEvent($this->id, 'admin/model/catalog/category/addCategory/after', 'module/d_seo_module/category_add');
		$this->model_extension_event->addEvent($this->id, 'admin/model/catalog/category/editCategory/after', 'module/d_seo_module/category_edit');
		$this->model_extension_event->addEvent($this->id, 'admin/view/catalog/product_form/after', 'module/d_seo_module/product_form');
		$this->model_extension_event->addEvent($this->id, 'admin/model/catalog/product/addProduct/after', 'module/d_seo_module/product_add');
		$this->model_extension_event->addEvent($this->id, 'admin/model/catalog/product/editProduct/after', 'module/d_seo_module/product_edit');
		$this->model_extension_event->addEvent($this->id, 'admin/view/catalog/manufacturer_form/after', 'module/d_seo_module/manufacturer_form');
		$this->model_extension_event->addEvent($this->id, 'admin/model/catalog/manufacturer/addManufacturer/after', 'module/d_seo_module/manufacturer_add');
		$this->model_extension_event->addEvent($this->id, 'admin/model/catalog/manufacturer/editManufacturer/after', 'module/d_seo_module/manufacturer_edit');
		$this->model_extension_event->addEvent($this->id, 'admin/view/catalog/information_form/after', 'module/d_seo_module/information_form');
		$this->model_extension_event->addEvent($this->id, 'admin/model/catalog/information/addInformation/after', 'module/d_seo_module/information_add');
		$this->model_extension_event->addEvent($this->id, 'admin/model/catalog/information/editInformation/after', 'module/d_seo_module/information_edit');
		$this->model_extension_event->addEvent($this->id, 'catalog/view/common/home/after', 'module/d_seo_module/home_before');
		$this->model_extension_event->addEvent($this->id, 'catalog/view/*/template/common/home/after', 'module/d_seo_module/home_after');
		$this->model_extension_event->addEvent($this->id, 'catalog/view/product/category/before', 'module/d_seo_module/category_before');
		$this->model_extension_event->addEvent($this->id, 'catalog/view/*/template/product/category/after', 'module/d_seo_module/category_after');
		$this->model_extension_event->addEvent($this->id, 'catalog/view/product/product/before', 'module/d_seo_module/product_before');
		$this->model_extension_event->addEvent($this->id, 'catalog/view/*/template/product/product/after', 'module/d_seo_module/product_after');
		$this->model_extension_event->addEvent($this->id, 'catalog/view/product/manufacturer_info/before', 'module/d_seo_module/manufacturer_info_before');
		$this->model_extension_event->addEvent($this->id, 'catalog/view/*/template/product/manufacturer_info/after', 'module/d_seo_module/manufacturer_info_after');
		$this->model_extension_event->addEvent($this->id, 'catalog/view/information/information/before', 'module/d_seo_module/information_before');
		$this->model_extension_event->addEvent($this->id, 'catalog/view/*/template/information/information/after', 'module/d_seo_module/information_after');
				
		//$this->{'model_module_' . $this->id}->setVqmod('a_vqmod_'.$this->id.'.xml', 1);
		$this->getUpdate(1);	  
	}
		 
	public function uninstall() {
		$this->load->model($this->route);
		$this->load->model('extension/event');
		
		$this->{'model_module_' . $this->id}->uninstallModule();
		
		$this->model_extension_event->deleteEvent($this->id);
		//$this->{'model_module_' . $this->id}->setVqmod('a_vqmod_'.$this->id.'.xml', 0);
		$this->getUpdate(0);	  
	}
	
	public function getUpdate($status = 1){
		if($status !== 0){	$status = 1; }

		$json = array();

		$this->load->language($this->route);
		$this->load->model($this->route);

		$current_version = $this->{'model_module_' . $this->id}->getVersion($this->mbooth);
		$info = $this->{'model_module_' . $this->id}->getUpdateInfo($this->mbooth, $status);
		
		if ($info['code'] == 200) {
			$data = simplexml_load_string($info['data']);

			if ((string) $data->version == (string) $current_version 
				|| (string) $data->version <= (string) $current_version) 
			{
				$json['success']   = $this->language->get('text_success_no_update') ;
			} 
			elseif ((string) $data->version > (string) $current_version) 
			{
				$json['warning']   = $this->language->get('text_warning_new_update');

				foreach($data->updates->update as $update)
				{
					if((string) $update->attributes()->version > (string)$current_version)
					{
						$version = (string)$update->attributes()->version;
						$json['update'][$version] = (string) $update[0];
					}
				}
			} 
			else 
			{
				$json['error']   = $this->language->get('text_error_update');
			}
		} 
		else 
		{ 
			$json['error']   =  $this->language->get('text_error_failed');
		}

		$this->response->setOutput(json_encode($json));
	}
}