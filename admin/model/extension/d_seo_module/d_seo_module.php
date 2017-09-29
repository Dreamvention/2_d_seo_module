<?php
class ModelExtensionDSEOModuleDSEOModule extends Model {
	private $codename = 'd_seo_module';
	
	/*
	*	Add Language.
	*/
	public function addLanguage($data) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "d_target_keyword WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
								
		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword SET route = '" . $this->db->escape($result['route']) . "', store_id = '" . (int)$result['store_id'] . "', language_id = '" . (int)$data['language_id'] . "', sort_order = '" . $this->db->escape($result['sort_order']) . "', keyword = '" . $this->db->escape($result['keyword']) . "'");				
		}
	}
	
	/*
	*	Delete Language.
	*/
	public function deleteLanguage($data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE language_id = '" . (int)$data['language_id'] . "'");
	}
	
	/*
	*	Delete Store.
	*/
	public function deleteStore($data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE store_id = '" . (int)$data['store_id'] . "'");
	}
	
	/*
	*	Save Home Target Keyword.
	*/
	public function saveHomeTargetKeyword($data) {						
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'common/home' AND store_id = '" . (int)$data['store_id'] . "'");
		
		if (isset($data['target_keyword'])) {
			foreach ($data['target_keyword'] as $language_id => $keywords) {
				$sort_order = 1;
				
				foreach ($keywords as $keyword) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword SET route = 'common/home', store_id = '" . (int)$data['store_id'] . "', language_id = '" . (int)$language_id . "', sort_order = '" . $sort_order . "', keyword = '" .  $this->db->escape($keyword) . "'");
					
					$sort_order++;
				}
			}
		}
	}
		
	/*
	*	Save Category Target Keyword.
	*/
	public function saveCategoryTargetKeyword($data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'category_id=" . (int)$data['category_id'] . "'");
						
		if (isset($data['target_keyword'])) {
			foreach ($data['target_keyword'] as $store_id => $language_target_keyword) {
				foreach ($language_target_keyword as $language_id => $keywords) {
					$sort_order = 1;
				
					foreach ($keywords as $keyword) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword SET route = 'category_id=" . (int)$data['category_id'] . "', store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', sort_order = '" . $sort_order . "', keyword = '" .  $this->db->escape($keyword) . "'");
					
						$sort_order++;
					}
				}
			}
		}
	}
	
	/*
	*	Save Product Target Keyword.
	*/
	public function saveProductTargetKeyword($data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'product_id=" . (int)$data['product_id'] . "'");
						
		if (isset($data['target_keyword'])) {
			foreach ($data['target_keyword'] as $store_id => $language_target_keyword) {
				foreach ($language_target_keyword as $language_id => $keywords) {
					$sort_order = 1;
				
					foreach ($keywords as $keyword) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword SET route = 'product_id=" . (int)$data['product_id'] . "', store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', sort_order = '" . $sort_order . "', keyword = '" .  $this->db->escape($keyword) . "'");
					
						$sort_order++;
					}
				}
			}
		}
	}
	
	/*
	*	Save Manufacturer Target Keyword.
	*/
	public function saveManufacturerTargetKeyword($data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'manufacturer_id=" . (int)$data['manufacturer_id'] . "'");
						
		if (isset($data['target_keyword'])) {
			foreach ($data['target_keyword'] as $store_id => $language_target_keyword) {
				foreach ($language_target_keyword as $language_id => $keywords) {
					$sort_order = 1;
				
					foreach ($keywords as $keyword) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword SET route = 'manufacturer_id=" . (int)$data['manufacturer_id'] . "', store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', sort_order = '" . $sort_order . "', keyword = '" .  $this->db->escape($keyword) . "'");
					
						$sort_order++;
					}
				}
			}
		}
	}
	
	/*
	*	Save Information Target Keyword.
	*/
	public function saveInformationTargetKeyword($data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'information_id=" . (int)$data['information_id'] . "'");
						
		if (isset($data['target_keyword'])) {
			foreach ($data['target_keyword'] as $store_id => $language_target_keyword) {
				foreach ($language_target_keyword as $language_id => $keywords) {
					$sort_order = 1;
				
					foreach ($keywords as $keyword) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword SET route = 'information_id=" . (int)$data['information_id'] . "', store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', sort_order = '" . $sort_order . "', keyword = '" .  $this->db->escape($keyword) . "'");
					
						$sort_order++;
					}
				}
			}
		}
	}
	
	/*
	*	Delete Category Target Keyword.
	*/
	public function deleteCategoryTargetKeyword($data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'category_id=" . (int)$data['category_id'] . "'");
	}
	
	/*
	*	Delete Product Target Keyword.
	*/
	public function deleteProductTargetKeyword($data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'product_id=" . (int)$data['product_id'] . "'");
	}
	
	/*
	*	Delete Manufacturer Target Keyword.
	*/
	public function deleteManufacturerTargetKeyword($data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'manufacturer_id=" . (int)$data['manufacturer_id'] . "'");
	}
	
	/*
	*	Delete Information Target Keyword.
	*/
	public function deleteInformationTargetKeyword($data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'information_id=" . (int)$data['information_id'] . "'");
	}

	/*
	*	Return Home Target Keyword.
	*/
	public function getHomeTargetKeyword($store_id = 0) {
		$target_keyword = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'common/home' AND store_id = '" . (int)$store_id . "' ORDER BY sort_order");
		
		foreach($query->rows as $result) {
			$target_keyword[$result['language_id']][$result['sort_order']] = $result['keyword'];
		}
		
		return $target_keyword;
	}	
		
	/*
	*	Return Category Target Keyword.
	*/
	public function getCategoryTargetKeyword($category_id) {
		$target_keyword = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'category_id=" . (int)$category_id . "' ORDER BY sort_order");
		
		foreach($query->rows as $result) {
			$target_keyword[$result['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
		}
		
		return $target_keyword;
	}
	
	/*
	*	Return Product Target Keyword.
	*/
	public function getProductTargetKeyword($product_id) {
		$target_keyword = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'product_id=" . (int)$product_id . "' ORDER BY sort_order");
		
		foreach($query->rows as $result) {
			$target_keyword[$result['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
		}
		
		return $target_keyword;
	}
	
	/*
	*	Return Manufacturer Target Keyword.
	*/
	public function getManufacturerTargetKeyword($manufacturer_id) {
		$target_keyword = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'manufacturer_id=" . (int)$manufacturer_id . "' ORDER BY sort_order");
		
		foreach($query->rows as $result) {
			$target_keyword[$result['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
		}
		
		return $target_keyword;
	}
	
	/*
	*	Return Information Target Keyword.
	*/
	public function getInformationTargetKeyword($information_id) {
		$target_keyword = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "d_target_keyword WHERE route = 'information_id=" . (int)$information_id . "' ORDER BY sort_order");
		
		foreach($query->rows as $result) {
			$target_keyword[$result['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
		}
		
		return $target_keyword;
	}
	
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
?>