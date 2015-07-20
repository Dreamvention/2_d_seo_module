<?php
/*
 *	location: admin/controller
 */

class ControllerModuleDSeo extends Controller {
	private $id = 'd_seo';
	private $route = 'module/d_seo';
	private $lite = array('lite', 'light', 'free');
	private $mbooth = '';
	private $prefix = '';
	private $error = array(); 

	public function __construct($registry) {
		parent:: __construct($registry);
		$this->addDirMain();
		$this->mbooth = $this->getMboothFile();
	}
 
  
	public function index(){

		$this->load->language($this->route);
		$this->load->model($this->route);
		$this->load->model('setting/setting');

		// Multistore
		if (isset($this->request->get['store_id'])) { 
			$store_id = $this->request->get['store_id']; 
		}else{  
			$store_id = 0;
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting($this->id, $this->request->post, $store_id);
			
			$this->settingsSeoUrl($this->request->post);  
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			//$this->model_setting_setting->editSetting('config', $this->request->post['config_seo_url']);
			
		
			//$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			
		}
	
		//$global_settings  = $this->model_setting_setting->getSetting('config',$store_id);
		//$data['config_seo_url'] = $global_settings['config_seo_url'];
		
		
		// Shopunity (requred)
		$this->document->addStyle('view/stylesheet/shopunity/default.css');
 

		$url = '';
		
		if(isset($this->response->get['store_id'])){
			$url +=  '&store_id='.$store_id;
		}

		if(isset($this->response->get['config'])){
			$url +=  '&config='.$this->response->get['config'];
		}

		// Heading
		$this->document->setTitle($this->language->get('heading_title_main'));
		$data['heading_title'] = $this->language->get('heading_title_main');
		$data['text_edit'] = $this->language->get('text_edit');
		
		// Variable
		$data['id'] = $this->id;
		$data['route'] = $this->route;
		$data['store_id'] = $store_id;
		$data['stores'] = $this->getStores();
		$data['mbooth'] = $this->mbooth;
		$data['config'] = $this->getConfigFile();
		$data['version'] = $this->getVersion($data['mbooth']);
		$data['token'] =  $this->session->data['token'];

		// Action
		$data['module_link'] = $this->url->link($this->route, 'token=' . $this->session->data['token'], 'SSL');
		$data['action'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		// Tab
		$data['text_seo'] = $this->language->get('text_seo');
		$data['text_snippet'] = $this->language->get('text_snippet');
		$data['text_setting'] = $this->language->get('text_setting');
		$data['text_instruction'] = $this->language->get('text_instruction');

		// Button
		$data['button_save'] = $this->language->get('button_save');
		$data['button_save_and_stay'] = $this->language->get('button_save_and_stay');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_version'] = $this->language->get('button_version');
		$data['button_update'] = $this->language->get('button_update');

		// Entry
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_config_files'] = $this->language->get('entry_config_files');

		// Help
		$data['help_status'] = $this->language->get('help_status');

		// Text
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');


		// Notification
        if (isset($this->error['warning'])) {
			$data['warning'] = $this->error['warning'];
		} elseif (isset($this->session->data['warning'] )) {
			$data['warning'] = $this->session->data['warning'] ;
			unset($this->session->data['warning']);
		} else {
			$data['warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error'] = '';
		} 

		// Breadcrumbs
		$data['breadcrumbs'] = array(); 
   		$data['breadcrumbs'][] = array(
       		'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
   		);

        $data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$data['breadcrumbs'][] = array(
       		'text' => $this->language->get('heading_title_main'),
			'href' => $this->url->link($this->route, 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);

   		$data['modules'] = array();
   		if (isset($this->request->post[$this->id.'_module'])) {
			$data['modules'] = $this->request->post[$this->id.'_module'];
		} elseif ($this->model_setting_setting->getSetting($this->id, $store_id)) { 
			$data['modules'] = $this->model_setting_setting->getSetting($this->id, $store_id);
			$data['modules'] = (isset($data['modules'][$this->id.'_module'])) ? $data['modules'][$this->id.'_module'] : array();
		}

			$data['setting'] = array();
		if (isset($this->request->post[$this->id.'_setting'])) {
			$data['setting'] = $this->request->post[$this->id.'_setting'];
		} elseif ($this->model_setting_setting->getSetting($this->id, $store_id)) { 
			$data  = array_merge($data, $this->model_setting_setting->getSetting($this->id, $store_id));
			//$data['setting'] = (isset($data['setting'][$this->id.'_setting'])) ? $data['setting'][$this->id.'_setting'] : array();
		} else {
			if($data['config']){
				$this->config->load($data['config']);
				$data['setting'] = ($this->config->get($this->id.'_setting')) ? $this->config->get($this->id.'_setting') : array();
			}
		}
		if(!isset($data['d_seo_snipet']['separator'])) {
			$data['d_seo_snipet']['separator'] = "- ".$this->config->get('config_name');
		}
		//echo "<pre>"; print_r($data ); echo "</pre>";
		//if (isset($this->request->post[$this->id.'_status'])) {
		//	$data[$this->id.'_status'] = $this->request->post[$this->id.'_status'];
		//} else {
		//	$data[$this->id.'_status'] = $this->config->get($this->id.'_status');
		//}

		//get config 
		$data['backup_files'] = $this->getHtaceessBackups();
		$data['token'] = $this->session->data['token']; 

   		/**

   		 Add code here 

   		 **/
		$global_settings  = $this->model_setting_setting->getSetting('config',$store_id);
		if(isset($global_settings['config_seo_url'])){
			$data['config_seo_url'] = $global_settings['config_seo_url'];
		}else{
			$data['config_seo_url'] = 0;
		}
		$data['type_seo_url'] = $this->typeURL();
		$data['htaccess_content']= $this->getHtaccess();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		//echo "<pre>"; print_r($global_settings ); echo "</pre>";
		$this->response->setOutput($this->load->view($this->route.'.tpl', $data));
	}

   	/**

	Add Assisting functions here 

	 **/

	private function getConfigFile(){
		
		if(isset($this->response->get['config'])){
			return $this->response->get['config'];
		}

		$full = DIR_SYSTEM . 'config/'. $this->id . '.php';
		if (file_exists($full)) {
			return $this->id;
		} 

		foreach ($this->lite as $file){
			if (file_exists(DIR_SYSTEM . 'config/'. $this->id . '_' . $file . '.php')) {
				return $this->id . '_' . $file;
			}
		}
		
		return false;
	}

	private function getConfigFiles(){
		$files = array();
		$results = glob(DIR_SYSTEM . 'config/'. $this->id .'*');
		foreach($results as $result){
			$files[] = str_replace(DIR_SYSTEM . 'config/', '', $result);
		}
		return $files;
	}

	private function getMboothFile(){
		$full = DIR_SYSTEM . 'mbooth/xml/mbooth_'. $this->id .'.xml';
		if (file_exists($full)) {
			return 'mbooth_'. $this->id . '.xml';
		} else{
			foreach ($this->lite as $file){
				if (file_exists(DIR_SYSTEM . 'mbooth/xml/mbooth_'. $this->id . '_' . $file . '.php')) {
					$this->prefix = '_' . $file;
					return $this->id . '_' . $file;
				}
			}
		}

		
		return false;
	}

	
	private function validate($permission = 'modify') {
		$this->language->load($this->route);
		
		if (!$this->user->hasPermission($permission, $this->route)) {
            $this->error['warning'] = $this->language->get('error_permission');
            return false;
		}

		return true;
	}

	public function install() {
		//  vqmod install
		  $off = str_replace("system", "vqmod/xml", DIR_SYSTEM) . "a_vqmod_d_module.xml_"; 
		  $on = str_replace("system", "vqmod/xml", DIR_SYSTEM) . "a_vqmod_d_module.xml";
		  if (file_exists($off)) rename($off, $on);
			$rows = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description ");
			if(!array_key_exists('robots', $rows->row )){
				$this->db->query("ALTER TABLE " . DB_PREFIX . "product_description  ADD robots TEXT");
			}
		$this->getUpdate(1);	  
	}
		 
	public function uninstall() {
			//vqmod uninstall
		  $on = str_replace("system", "vqmod/xml", DIR_SYSTEM) . "a_vqmod_d_module.xml"; 
		  $off = str_replace("system", "vqmod/xml", DIR_SYSTEM) . "a_vqmod_d_module.xml_";
		  if (file_exists($on)) rename($on, $off);

		$this->getUpdate(0);	  
	}

	private function getStores(){
		$this->load->model('setting/store');
		$stores = $this->model_setting_store->getStores();
		$result = array();
		if($stores){
			$result[] = array(
				'store_id' => 0, 
				'name' => $this->config->get('config_name')
			);
			foreach ($stores as $store) {
				$result[] = array(
					'store_id' => $store['store_id'],
					'name' => $store['name']	
				);
			}	
		}
		return $result;
	}

	private function getVersion($mbooth){
		if(file_exists(DIR_SYSTEM . 'mbooth/xml/'. $mbooth)){
			//$xml = new SimpleXMLElement(file_get_contents(DIR_SYSTEM . 'mbooth/xml/'. $mbooth));
			//return $xml->version;
		}else{
			return false;
		}
	}
	private function isInstalled($code) {
		$extension_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `code` = '" . $this->db->escape($code) . "'");
		if($query->row) {
			return true;
		}else{
			return false;
		}	
	}
	public function getUpdate($status = 1){
		$json = array();
		$this->load->language($this->route);
		$this->mboot_script_dir = DIR_SYSTEM . 'mbooth/xml/';

		$xml = new SimpleXMLElement(file_get_contents($this->mboot_script_dir . $this->mbooth));
		$current_version = $xml->version ;

		if (isset($this->request->get['mbooth'])) { 
			$mbooth = $this->request->get['mbooth']; 
		} else { 
			$mbooth = $this->mbooth; 
		}

		$customer_url = HTTP_SERVER;
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE language_id = " . (int)$this->config->get('config_language_id') ); 
		$language_code = $query->row['code'];
		$ip = $this->request->server['REMOTE_ADDR'];

		$check_version_url = 'http://opencart.dreamvention.com/api/1/index.php?route=extension/check&mbooth=' . $mbooth . '&store_url=' . $customer_url . '&module_version=' . $current_version . '&language_code=' . $language_code . '&opencart_version=' . VERSION . '&ip='.$ip . '&status=' .$status;

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $check_version_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$return_data = curl_exec($curl);
		$return_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		if ($return_code == 200) {
			$data = simplexml_load_string($return_data);

			if ((string) $data->version == (string) $current_version || (string) $data->version <= (string) $current_version) {
				$json['success']   = $this->language->get('text_no_update') ;
			} elseif ((string) $data->version > (string) $current_version) {
				$json['attention']   = $this->language->get('text_new_update');

				foreach($data->updates->update as $update){
					if((string) $update->attributes()->version > (string)$current_version){
						$version = (string)$update->attributes()->version;
						$json['update'][$version] = (string) $update[0];
					}
				}
			} else {
				$json['error']   = $this->language->get('text_error_update');
			}
		} else { 
			$json['error']   =  $this->language->get('text_error_failed');
		}

		$this->response->setOutput(json_encode($json));
   }
	private function enable_rewrite(){
		$filename  = DIR_MAIN.".htaccess";
		   if(file_exists($filename)){
			   if($this->checkDreamHtaccess($filename)){
				 //  echo "file exsist all is okey";
			   }else{
				   /* Проверка на реврайтинг */
				  // echo "file exsist but it  is not our file";
				   $this->createHtaccessBackup();
				   $this->createDreamHtaccess();
			   }
		   }else{
			   $this->createDreamHtaccess();
		   }
	  
	}
	private function addDirMain(){
	 
		$patterns[0] = '/system\// '; 
 
	    $dir =  preg_replace(  $patterns  , '',  DIR_SYSTEM);			 
		   
		define('DIR_MAIN', $dir  );
	}
	private function checkDreamHtaccess($filename){
		 $htaccess = file($filename);
		 if(strpos($htaccess[0] , "Dreamvention")){
			 return true;
		 }else{
			 return false;
		 }
	}
	private function createDreamHtaccess(){
		
		$filename  = DIR_MAIN.".htaccess";
		$filename_new  =   DIR_MAIN."htaccess_dream.txt";
	   
	    $htaccess_new = file($filename_new);
	   				 
		$patterns[0] = '/(http|https):\/\/'.$_SERVER['HTTP_HOST'].'/'; 
	   
		$text = preg_replace(  $patterns  , '',  HTTP_CATALOG);
		
		$htaccess_new[22] = sprintf($htaccess_new[22] , $text);
		
		$htaccess = fopen( $filename , "c+");
				
		foreach ($htaccess_new as $line_num => $line) {
			fputs($htaccess,$line );				
		}
		
		fclose($htaccess);
	   
	}
	private function createNote($file, $openfile) {
		
		$handle = fopen($openfile, 'w');
		foreach ($file as $filestring) {
			fwrite($handle, $filestring);
		}
		fclose($handle);
	}
	public function createHtaccessBackup( ) {
		$dirname = DIR_MAIN."htaccess_backup";
		$filename = DIR_MAIN.".htaccess";
		
		$file = file($filename);
			
		$backupfile = $dirname . '/.htaccess_' . date('Y-m-d-H-i-s');
			
		if (is_dir($dirname)) {
			$this->createNote($file, $backupfile);
		} else {
			mkdir($dirname);
			$this->createNote($file, $backupfile);
		}	
		
	}
	public function restoreHtaceessBackup($backupname) {
			$backupname = $this->request->post['backupname'];
		 
        $backupfile = file( DIR_MAIN."htaccess_backup/".$backupname);
	 
		$filename   = DIR_MAIN.".htaccess";
        $this->createNote($backupfile, $filename);
		
    }
    
    private function getHtaceessBackups() {
        $files = array();
        $results = glob(DIR_MAIN . 'htaccess_backup/.htaccess*');
        foreach ($results as $result) {
            $files[] = str_replace(DIR_MAIN . 'htaccess_backup/', '', $result);
        }
        return $files;
    }
	private function getHtaccess(){
		$file = file(DIR_MAIN.".htaccess");
		return $file;
	}
	
	private function settingsSeoUrl($settings){
		if (isset($settings['config_seo_url'])) {
		 
			$global_settings  = $this->model_setting_setting->getSetting('config',0);
			
		 
				$this->enable_rewrite();
		 
			
			 $global_settings['config_seo_url'] = $this->request->post['config_seo_url'];
			 $this->model_setting_setting->editSetting('config', $global_settings);
		}
		
		if(isset($settings['type_seo_url'])){
			if($settings['type_seo_url'] == "modified" ){
				$this->enableModificationUrl();
			}else{
				$this->disableModificationUrl();
			}
		}
	}
	
	private function enableModificationUrl() {
		  $from = str_replace("system", "vqmod/xml", DIR_SYSTEM) . "a_vqmod_mod_seo_url.xml_"; 
		  $to = str_replace("system", "vqmod/xml", DIR_SYSTEM) . "a_vqmod_mod_seo_url.xml";
		  if (file_exists($from)) rename($from, $to);
	}
		 
	public function disableModificationUrl() {
		  $from = str_replace("system", "vqmod/xml", DIR_SYSTEM) . "a_vqmod_mod_seo_url.xml"; 
		  $to = str_replace("system", "vqmod/xml", DIR_SYSTEM) . "a_vqmod_mod_seo_url.xml_";
		  if (file_exists($from)) rename($from, $to);	  
	}
	
	function typeURL(){
		 $from = str_replace("system", "vqmod/xml", DIR_SYSTEM) . "a_vqmod_mod_seo_url.xml"; 
		 if (file_exists($from)){
			 return "modified";
		 }else{
			 return "canonical";
		 }
	}
}
?>