<?php
class ControllerDashboardDSEOModuleURLTarget extends Controller {
	private $codename = 'd_seo_module_url_target';
	private $main_codename = 'd_seo_module';
	private $route = 'dashboard/d_seo_module_url_target';
	private $config_file = 'd_seo_module_url_target';
	private $extension = array();
	private $error = array(); 
		
	public function index() {
		$this->load->language($this->route);
		
		$this->load->model($this->route);
		$this->load->model('setting/setting');
		$this->load->model('localisation/language');
		
		// Heading
		$data['heading_title'] = $this->language->get('heading_title_main');
		
		// Variable
		$data['codename'] = $this->codename;
		$data['route'] = $this->route;
		$data['token'] =  $this->session->data['token'];
		$data['stores'] = $this->{'model_dashboard_' . $this->codename}->getStores();
		$data['languages'] = $this->{'model_dashboard_' . $this->codename}->getLanguages();
		
		// Column
		$data['column_route'] = $this->language->get('column_route');
		$data['column_target_keyword'] = $this->language->get('column_target_keyword');
		
		// Text
		$data['text_no_results'] = $this->language->get('text_no_results');
		
		// Setting
		$this->config->load($this->config_file);
		$config_setting = ($this->config->get($this->codename)) ? $this->config->get($this->codename) : array();
				
		$setting = $config_setting;
		
		$seo_url_target_extensions = $this->{'model_dashboard_' . $this->codename}->getSEOURLTargetExtensions();
		
		$targets = array();
		$implode = array();
				
		if ($setting['duplicate_status']) {
			$duplicate_targets = array();
			
			foreach ($seo_url_target_extensions as $seo_url_target_extension) {
				$info = $this->load->controller($this->codename . '/' . $seo_url_target_extension . '/duplicate_targets');
				if ($info) $duplicate_targets = array_replace_recursive($duplicate_targets, $info);
			}
			
			if ($duplicate_targets) $targets = array_replace_recursive($targets, $duplicate_targets);
						
			$implode[] = sprintf($this->language->get('text_heading_info_duplicate'), count($duplicate_targets));
		}
		
		if ($setting['empty_status']) {
			$empty_targets = array();
			
			foreach ($seo_url_target_extensions as $seo_url_target_extension) {
				$info = $this->load->controller($this->codename . '/' . $seo_url_target_extension . '/empty_targets');
				if ($info) $empty_targets = array_replace_recursive($empty_targets, $info);
			}
			
			if ($empty_targets) $targets = array_replace_recursive($targets, $empty_targets);
						
			$implode[] = sprintf($this->language->get('text_heading_info_empty'), count($empty_targets));
		}
		
		if ($implode) {
			$data['heading_title'] .= ' ' . $this->language->get('text_found') . ' ' . implode(' ' . $this->language->get('text_and') . ' ', $implode);
		}
						
		$data['targets'] = array();
		
		$i = 0;
		
		foreach ($targets as $target) {
			$data['targets'][] = $target;
			$i++;
			if ($i == $setting['list_limit']) break;
		}
		
		foreach ($seo_url_target_extensions as $seo_url_target_extension) {
			$targets = $this->load->controller($this->codename . '/' . $seo_url_target_extension . '/targets_links', $data['targets']);
			if ($targets) $data['targets'] = $targets;
		}

		return $this->load->view($this->route . '.tpl', $data);
	}
	
	public function refresh() {
		$this->response->setOutput($this->index());
	}
	
	public function editTarget() {
		$this->load->language($this->route);
		
		$this->load->model($this->route);
		
		if (isset($this->request->post['route']) && isset($this->request->post['language_id']) && isset($this->request->post['target_keyword']) && $this->validate()) {
			$target_data = array(
				'route'				=> $this->request->post['route'],
				'language_id'		=> $this->request->post['language_id'],
				'target_keyword'	=> $this->request->post['target_keyword']
			);
		
			$this->{'model_dashboard_' . $this->codename}->editTarget($target_data);
		}
			
		$data['error'] = $this->error;
		
		$this->response->setOutput(json_encode($data));
	}
	
	/*
	*	Validator Functions.
	*/		
	private function validate($permission = 'modify') {
		if (isset($this->request->post['config'])) {
			return false;
		}
				
		if (!$this->user->hasPermission($permission, $this->route)) {
			$this->error['warning'] = $this->language->get('error_permission');
			return false;
		}
		
		return true;
	}
}
