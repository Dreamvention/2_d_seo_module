<?php
class ControllerExtensionDSEOModuleDSEOModule extends Controller {
	private $codename = 'd_seo_module';
	private $route = 'extension/d_seo_module/d_seo_module';
	private $config_file = 'd_seo_module';
	
	/*
	*	Functions for SEO Module.
	*/	
	public function product_after($html) {
		$store_id = (int)$this->config->get('config_store_id');
								
		if (file_exists(DIR_SYSTEM . 'library/d_simple_html_dom.php')) {
			if (isset($this->request->get['product_id'])) {
				$product_id = (int)$this->request->get['product_id'];
			} else {
				$product_id = 0;
			}
					
			$this->load->controller('product/product/review');
		
			$review = $this->response->getOutput();
				
			$html_dom = new d_simple_html_dom();
			$html_dom->load((string)$html, $lowercase = true, $stripRN = false, $defaultBRText = DEFAULT_BR_TEXT);
		
			foreach ($html_dom->find('#review') as $element) {
				$element->innertext = $review;
			}
				
			return (string)$html_dom;
		}
		
		return $html;
	}
	
	public function search_before($data) {
		$this->load->model('setting/setting');
		
		$store_id = (int)$this->config->get('config_store_id');
				
		if (isset($this->request->get['tag']) && !$data['search']) {
			$this->load->language('product/search');
			
			$data['heading_title'] = $this->language->get('heading_title') .  ' - ' . $this->language->get('heading_tag') . $this->request->get['tag'];
			$data['search'] = $this->request->get['tag'];
		}
				
		return $data;
	}
	
	public function field_elements($filter_data) {
		$this->load->model($this->route);
		
		return $this->{'model_extension_d_seo_module_' . $this->codename}->getFieldElements($filter_data);
	}
}