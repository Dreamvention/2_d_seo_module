<?php
class ModelExtensionDSEOModuleDSEOModule extends Model {
	private $codename = 'd_seo_module';
	
	/*
	*	Return Field Elements.
	*/
	public function getFieldElements($data) {				
		if ($data['field_code'] == 'target_keyword') {
			$this->load->model('extension/module/' . $this->codename);
		
			$stores = $this->{'model_extension_module_' . $this->codename}->getStores();
		
			$field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');
			$custom_page_exception_routes = $this->load->controller('extension/module/d_seo_module/getCustomPageExceptionRoutes');
			
			$field_elements = array();
					
			$sql = "SELECT * FROM " . DB_PREFIX . "d_target_keyword";
			
			$implode = array();
				
			foreach ($data['filter'] as $filter_code => $filter) {
				if (!empty($filter)) {
					if ($filter_code == 'route') {
						if (strpos($filter, '%') !== false) {
							$implode[] = "route LIKE '" . $this->db->escape($filter) . "'";
						} else {
							$implode[] = "route = '" . $this->db->escape($filter) . "'";
						}
					}
													
					if ($filter_code == 'language_id' ) {
						$implode[] = "language_id = '" . (int)$filter . "'";
					}
						
					if ($filter_code == 'sort_order') {
						$implode[] = "sort_order = '" . (int)$filter . "'";
					}
						
					if ($filter_code == 'keyword') {
						$implode[] = "keyword = '" . $this->db->escape($filter) . "'";
					}
				}
			}
		
			if ($implode) {
				$sql .= " WHERE " . implode(' AND ', $implode);
			}
		
			$sql .= " ORDER BY sort_order";
				
			$query = $this->db->query($sql);
										
			foreach ($query->rows as $result) {
				if (strpos($result['route'], 'category_id') !== false) {
					if (isset($field_info['sheet']['category']['field']['target_keyword']['multi_store']) && $field_info['sheet']['category']['field']['target_keyword']['multi_store'] && isset($field_info['sheet']['category']['field']['target_keyword']['multi_store_status']) && $field_info['sheet']['category']['field']['target_keyword']['multi_store_status']) {
						if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
							$field_elements[$result['route']][$result['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
						}
					} elseif ($result['store_id'] == 0) {
						foreach ($stores as $store) {
							if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
								$field_elements[$result['route']][$store['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
							}
						}
					}
				}
					
				if (strpos($result['route'], 'product_id') !== false) {
					if (isset($field_info['sheet']['product']['field']['target_keyword']['multi_store']) && $field_info['sheet']['product']['field']['target_keyword']['multi_store'] && isset($field_info['sheet']['product']['field']['target_keyword']['multi_store_status']) && $field_info['sheet']['product']['field']['target_keyword']['multi_store_status']) {
						if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
							$field_elements[$result['route']][$result['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
						}
					} elseif ($result['store_id'] == 0) {
						foreach ($stores as $store) {
							if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
								$field_elements[$result['route']][$store['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
							}
						}
					}
				}
					
				if (strpos($result['route'], 'manufacturer_id') !== false) {
					if (isset($field_info['sheet']['manufacturer']['field']['target_keyword']['multi_store']) && $field_info['sheet']['manufacturer']['field']['target_keyword']['multi_store'] && isset($field_info['sheet']['manufacturer']['field']['target_keyword']['multi_store_status']) && $field_info['sheet']['manufacturer']['field']['target_keyword']['multi_store_status']) {
						if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
							$field_elements[$result['route']][$result['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
						}
					} elseif ($result['store_id'] == 0) {
						foreach ($stores as $store) {
							if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
								$field_elements[$result['route']][$store['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
							}
						}
					}
				}
					
				if (strpos($result['route'], 'information_id') !== false) {
					if (isset($field_info['sheet']['information']['field']['target_keyword']['multi_store']) && $field_info['sheet']['information']['field']['target_keyword']['multi_store'] && isset($field_info['sheet']['information']['field']['target_keyword']['multi_store_status']) && $field_info['sheet']['information']['field']['target_keyword']['multi_store_status']) {
						if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
							$field_elements[$result['route']][$result['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
						}
					} elseif ($result['store_id'] == 0) {
						foreach ($stores as $store) {
							if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
								$field_elements[$result['route']][$store['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
							}
						}
					}
				}
					
				if (preg_match('/[A-Za-z0-9]+\/[A-Za-z0-9]+/i', $result['route']) && !($custom_page_exception_routes && in_array($result['route'], $custom_page_exception_routes))) {
					if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
						$field_elements[$result['route']][$result['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
					}
				}
			}
				
			return $field_elements;
		}
		
		if ($data['field_code'] == 'url_keyword') {
			$this->load->model('extension/module/' . $this->codename);
		
			$stores = $this->{'model_extension_module_' . $this->codename}->getStores();
			$languages = $this->{'model_extension_module_' . $this->codename}->getLanguages();
		
			$field_info = $this->load->controller('extension/module/d_seo_module/getFieldInfo');
			$custom_page_exception_routes = $this->load->controller('extension/module/d_seo_module/getCustomPageExceptionRoutes');
			
			if (!(isset($field_info['sheet']['category']['field']['url_keyword']['multi_store']) && $field_info['sheet']['category']['field']['url_keyword']['multi_store'] && isset($field_info['sheet']['product']['field']['url_keyword']['multi_store']) && $field_info['sheet']['product']['field']['url_keyword']['multi_store']) && isset($field_info['sheet']['manufacturer']['field']['url_keyword']['multi_store']) && $field_info['sheet']['manufacturer']['field']['url_keyword']['multi_store'] && isset($field_info['sheet']['information']['field']['url_keyword']['multi_store']) && $field_info['sheet']['information']['field']['url_keyword']['multi_store']) {
				if (VERSION >= '3.0.0.0') {
					$sql = "SELECT * FROM " . DB_PREFIX . "seo_url";
				} else {
					$sql = "SELECT * FROM " . DB_PREFIX . "url_alias";
				}
				
				$implode = array();
				
				foreach ($data['filter'] as $filter_code => $filter) {
					if (!empty($filter)) {
						if ($filter_code == 'route') {
							if (strpos($filter, '%') !== false) {
								$implode[] = "query LIKE '" . $this->db->escape($filter) . "'";
							} else {
								$implode[] = "query = '" . $this->db->escape($filter) . "'";
							}
						}
												
						if (VERSION >= '3.0.0.0') {						
							if ($filter_code == 'language_id' ) {
								$implode[] = "language_id = '" . (int)$filter . "'";
							}
						}
												
						if ($filter_code == 'keyword') {
							$implode[] = "keyword = '" . $this->db->escape($filter) . "'";
						}
					}
				}
		
				if ($implode) {
					$sql .= " WHERE " . implode(' AND ', $implode);
				}
							
				$query = $this->db->query($sql);
										
				foreach ($query->rows as $result) {
					$result['route'] = $result['query'];
				
					if ((strpos($result['route'], 'category_id') !== false) || (strpos($result['route'], 'product_id') !== false) || (strpos($result['route'], 'manufacturer_id') !== false) || (strpos($result['route'], 'information_id') !== false) || (preg_match('/[A-Za-z0-9]+\/[A-Za-z0-9]+/i', $result['route']) && !($custom_page_exception_routes && in_array($result['route'], $custom_page_exception_routes)))) {	
						if (VERSION >= '3.0.0.0') {	
							if ((isset($data['filter']['store_id']) && ($result['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
								$field_elements[$result['route']][$result['store_id']][$result['language_id']] = $result['keyword'];
							}
						} else {
							foreach ($stores as $store) {
								foreach ($languages as $language) {
									if ((isset($data['filter']['store_id']) && ($store['store_id'] == $data['filter']['store_id'])) || !isset($data['filter']['store_id'])) {
										$field_elements[$result['route']][$store['store_id']][$language['language_id']] = $result['keyword'];
									}
								}
							}
						}
					}
				}				
				
				return $field_elements;
			}
		}
		
		return false;
	}
}