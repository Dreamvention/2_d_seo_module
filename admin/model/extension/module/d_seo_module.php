<?php
class ModelExtensionModuleDSEOModule extends Model {
	private $codename = 'd_seo_module';
	
	/*
	*	Save File Manager.
	*/
	public function saveFileData($file, $data) {
		$dir = str_replace("system/", "", DIR_SYSTEM);
		
		if ($file == 'htaccess') {
			$file_on = $dir . '.htaccess';
			$file_off = $dir . '.htaccess.txt'; 
		}
		
		if ($file == 'robots') {
			$file_on = $dir . 'robots.txt';
			$file_off = $dir . '_robots.txt'; 
		}
		
		if ($data['status']) {
			if (file_exists($file_off)) unlink($file_off);
			$fh = fopen($file_on, "w");
			fwrite($fh, html_entity_decode($data['text']));
			fclose($fh);
		} else {
			if (file_exists($file_on)) unlink($file_on);
			$fh = fopen($file_off, "w");
			fwrite($fh, html_entity_decode($data['text']));
			fclose($fh);
		}
	}
	
	/*
	*	Return htaccess.
	*/
	public function getFileData($file) {
		$dir = str_replace("system/", "", DIR_SYSTEM);
		
		if ($file == 'htaccess') {
			$file_on = $dir . '.htaccess';
			$file_off = $dir . '.htaccess.txt'; 
		}
		
		if ($file == 'robots') {
			$file_on = $dir . 'robots.txt';
			$file_off = $dir . '_robots.txt'; 
		}
		
		$data = array();
		
		if (file_exists($file_on)) { 
			$data['status'] = true;
			$fh = fopen($file_on, "r");
			$data['text'] = fread($fh, filesize($file_on)+1);
			fclose($fh);
		} else {
			if (file_exists($file_off)) {
				$data['status'] = false;
				$fh = fopen($file_off, "r");
				$data['text'] = fread($fh, filesize($file_off)+1);
				fclose($fh);
			} else {
				$data['status'] = false;
				$data['text'] = '';
			}
		}
				
		return $data;
	}
	
	/*
	*	Create Default Custom Pages.
	*/
	public function createDefaultCustomPages($default_custom_pages, $store_id = 0) {
		$languages = $this->getLanguages();
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route LIKE '%/%' AND store_id = '" . (int)$store_id . "'");
		
		foreach ($languages as $language) {
			$implode = array();
						
			foreach ($default_custom_pages as $route => $target_keyword) {
				$sort_order = 1;
				
				foreach ($target_keyword as $keyword) {
					$implode[] = "('" . $route . "', '" . (int)$store_id . "', '" . (int)$language['language_id'] . "', '" . $sort_order . "', '" . $keyword . "')";
					
					$sort_order++;
				}
			}
			
			if ($implode) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword (route, store_id, language_id, sort_order, keyword) VALUES " . implode(', ', $implode));
			}
		}
	}
	
	/*
	*	Save Custom Pages.
	*/
	public function saveCustomPages($custom_pages, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route LIKE '%/%' AND store_id = '" . (int)$store_id . "'");
		
		foreach ($custom_pages as $custom_page) {
			foreach ($custom_page['target_keyword'] as $language_id => $target_keyword) {
				preg_match_all('/\[[^]]+\]/', $target_keyword, $keywords);
				
				$sort_order = 1;
				
				foreach ($keywords[0] as $keyword) {
					$keyword = substr($keyword, 1, strlen($keyword)-2);
					$this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword SET route = '" . $this->db->escape($custom_page['route']) . "', store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', sort_order = '" . $sort_order . "', keyword = '" .  $this->db->escape($keyword) . "'");
					
					$sort_order++;
				}
			}
		}
	}
			
	/*
	*	Add Custom Page.
	*/
	public function addCustomPage($data, $store_id = 0) {
		foreach ($data['target_keyword'] as $language_id => $target_keyword) {
			preg_match_all('/\[[^]]+\]/', $target_keyword, $keywords);
				
			$sort_order = 1;
				
			foreach ($keywords[0] as $keyword) {
				$keyword = substr($keyword, 1, strlen($keyword)-2);
				$this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword SET route = '" . $this->db->escape($data['route']) . "', store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', sort_order = '" . $sort_order . "', keyword = '" .  $this->db->escape($keyword) . "'");
					
				$sort_order++;
			}
		}
	}
	
	/*
	*	Edit Custom Page.
	*/
	public function editCustomPage($data, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = '" . $this->db->escape($data['route']) . "' AND store_id = '" . (int)$store_id . "' AND language_id = '" . (int)$data['language_id'] . "'");
				
		preg_match_all('/\[[^]]+\]/', $data['target_keyword'], $keywords);
				
		$sort_order = 1;
		
		foreach ($keywords[0] as $keyword) {
			$keyword = substr($keyword, 1, strlen($keyword)-2);
			$this->db->query("INSERT INTO " . DB_PREFIX . "d_target_keyword SET route = '" . $this->db->escape($data['route']) . "', store_id = '" . (int)$store_id . "', language_id = '" . (int)$data['language_id'] . "', sort_order = '" . $sort_order . "', keyword = '" .  $this->db->escape($keyword) . "'");
					
			$sort_order++;
		}
	}
	
	/*
	*	Delete Custom Page.
	*/
	public function deleteCustomPage($route, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "d_target_keyword WHERE route = '" . $this->db->escape($route) . "' AND store_id = '" . (int)$store_id . "'");
	}
	
	/*
	*	Return Custom Pages.
	*/
	public function getCustomPages($data = array()) {
		$custom_pages = array();
		
		$languages = $this->getLanguages();
		
		$sql = "SELECT * FROM " . DB_PREFIX . "d_target_keyword WHERE route LIKE '%/%'";
		
		$implode = array();
		
		if (!empty($data['filter_route'])) {
			$implode[] = "route = '" . $this->db->escape($data['filter_route']) . "'";
		}
		
		if (isset($data['filter_store_id']) && $data['filter_store_id'] !== '') {
			$implode[] = "store_id = '" .(int)$data['filter_store_id'] . "'";
		}
			
		if (!empty($data['filter_language_id']) && $data['filter_language_id'] !== '') {
			$implode[] = "language_id = '" .(int)$data['filter_language_id'] . "'";
		}
		
		if (!empty($data['filter_sort_order'])) {
			$implode[] = "sort_order = '" . (int)$data['filter_sort_order'] . "'";
		}
		
		if (!empty($data['filter_keyword'])) {
			$implode[] = "keyword = '" . $this->db->escape($data['filter_keyword']) . "'";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(' AND ', $implode);
		}
		
		$sql .= " ORDER BY route, sort_order";
		
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) {
			$custom_pages[$result['route']]['route'] = $result['route'];
			$custom_pages[$result['route']]['target_keyword'][$result['store_id']][$result['language_id']][$result['sort_order']] = $result['keyword'];
		}
			
		return $custom_pages;
	}
				
	/*
	*	Save SEO extensions.
	*/
	public function saveSEOExtensions($seo_extensions) {
		$this->load->model('setting/setting');
		
		$setting['d_seo_extension_install'] = $seo_extensions;
		
		$this->model_setting_setting->editSetting('d_seo_extension', $setting);
	}
	
	/*
	*	Return list of SEO extensions.
	*/
	public function getSEOExtensions() {
		$this->load->model('setting/setting');
				
		$installed_extensions = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension ORDER BY code");
		
		foreach ($query->rows as $result) {
			$installed_extensions[] = $result['code'];
		}
		
		$installed_seo_extensions = $this->model_setting_setting->getSetting('d_seo_extension');
		$installed_seo_extensions = isset($installed_seo_extensions['d_seo_extension_install']) ? $installed_seo_extensions['d_seo_extension_install'] : array();
		
		$seo_extensions = array();
		
		$files = glob(DIR_APPLICATION . 'controller/extension/' . $this->codename . '/*.php');
		
		if ($files) {
			foreach ($files as $file) {
				$seo_extension = basename($file, '.php');
				
				if (in_array($seo_extension, $installed_extensions) && in_array($seo_extension, $installed_seo_extensions)) {
					$seo_extensions[] = $seo_extension;
				}
			}
		}
		
		return $seo_extensions;
	}
		
	/*
	*	Return list of languages.
	*/
	public function getLanguages() {
		$this->load->model('localisation/language');
		
		$languages = $this->model_localisation_language->getLanguages();
		
		foreach ($languages as $key => $language) {
            if (VERSION >= '2.2.0.0') {
                $languages[$key]['flag'] = 'language/' . $language['code'] . '/' . $language['code'] . '.png';
            } else {
                $languages[$key]['flag'] = 'view/image/flags/' . $language['image'];
            }
        }
				
		return $languages;
	}
	
	/*
	*	Return list of stores.
	*/
	public function getStores() {
		$this->load->model('setting/store');
		
		$result = array();
		
		$result[] = array(
			'store_id' => 0, 
			'name' => $this->config->get('config_name')
		);
		
		$stores = $this->model_setting_store->getStores();
		
		if ($stores) {
			foreach ($stores as $store) {
				$result[] = array(
					'store_id' => $store['store_id'],
					'name' => $store['name']	
				);
			}	
		}
		
		return $result;
	}
	
	/*
	*	Return store.
	*/
	public function getStore($store_id) {
		$this->load->model('setting/store');
		
		$result = array();
		
		if ($store_id == 0) {
			$result = array(
				'store_id' => 0, 
				'name' => $this->config->get('config_name'),
				'url' => HTTP_CATALOG,
				'ssl' => HTTPS_CATALOG
			);
		} else {
			$store = $this->model_setting_store->getStore($store_id);
			
			$result = array(
				'store_id' => $store['store_id'],
				'name' => $store['name'],
				'url' => $store['url'],
				'ssl' => $store['ssl']
			);
		}
				
		return $result;
	}
	
	/*
	*	Return Group ID.
	*/
	public function getGroupId() {
        $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . $this->user->getId() . "'");
        
		$user_group_id = (int)$user_query->row['user_group_id'];
        
        return $user_group_id;
    }
	
	/*
	*	Sort Array By Column.
	*/
	public function sortArrayByColumn($arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		$sort_key = array();
		
		foreach ($arr as $key => $row) {
			$sort_key[$key] = $key;
			
			if (isset($row[$col])) {
				$sort_col[$key] = $row[$col];
			} else {
				$sort_col[$key] = '';
			}
		}
		
		array_multisort($sort_col, $dir, $sort_key, SORT_ASC, $arr);
		
		return $arr;
	}
				
	/*
	*	Install.
	*/		
	public function installModule() {
		if (VERSION < '3.0.0.0') {
			$this->db->query("ALTER TABLE " . DB_PREFIX . "setting MODIFY code VARCHAR(128) NOT NULL");
		}
		
		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "d_target_keyword");
		
		$this->db->query("CREATE TABLE " . DB_PREFIX . "d_target_keyword (route VARCHAR(255) NOT NULL, store_id INT(11) NOT NULL, language_id INT(11) NOT NULL, sort_order INT(3) NOT NULL, keyword VARCHAR(255) NOT NULL, PRIMARY KEY (route, store_id, language_id, sort_order), KEY keyword (keyword)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
	}
	
	/*
	*	Uninstall.
	*/		
	public function uninstallModule() {
		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "d_target_keyword");
		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "d_meta_data");
		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "d_url_keyword");
	}
}
?>