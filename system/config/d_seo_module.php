<?php 
$_['d_seo_module_setting'] = array(
	'list_limit' => '20',
	'default_custom_pages' => array(
		'common/home' => array('webshop'),
		'product/manufacturer' => array('brand'),
		'product/special' => array('special'),
		'information/contact' => array('contact')
	)
);
$_['d_seo_module_field_setting'] = array(
	'sheet' => array(
		'category' => array(
			'code' => 'category',
			'name' => 'text_category',
			'sort_order' => '1',
			'field' => array(
				'target_keyword' => array(
					'code' => 'target_keyword',
					'name' => 'text_target_keyword',
					'description' => 'help_target_keyword',
					'type' => 'textarea',
					'sort_order' => '20',
					'multi_store' => true,
					'multi_language' => true,
					'multi_store_status' => false,
					'required' => false
				)
			)
		),
		'product' => array(
			'code' => 'product',
			'name' => 'text_product',
			'sort_order' => '2',
			'field' => array(
				'target_keyword' => array(
					'code' => 'target_keyword',
					'name' => 'text_target_keyword',
					'description' => 'help_target_keyword',
					'type' => 'textarea',
					'sort_order' => '20',
					'multi_store' => true,
					'multi_language' => true,
					'multi_store_status' => false,
					'required' => false
				)
			)
		),
		'manufacturer' => array(
			'code' => 'manufacturer',
			'name' => 'text_manufacturer',
			'sort_order' => '3',
			'field' => array(
				'target_keyword' => array(
					'code' => 'target_keyword',
					'name' => 'text_target_keyword',
					'description' => 'help_target_keyword',
					'type' => 'textarea',
					'sort_order' => '20',
					'multi_store' => true,
					'multi_language' => true,
					'multi_store_status' => false,
					'required' => false
				)
			)
		),
		'information' => array(
			'code' => 'information',
			'name' => 'text_information',
			'sort_order' => '4',
			'field' => array(
				'target_keyword' => array(
					'code' => 'target_keyword',
					'name' => 'text_target_keyword',
					'description' => 'help_target_keyword',
					'type' => 'textarea',
					'sort_order' => '20',
					'multi_store' => true,
					'multi_language' => true,
					'multi_store_status' => false,
					'required' => false
				)
			)
		),
		'home' => array(
			'code' => 'home',
			'name' => 'text_home',
			'sort_order' => '10',
			'field' => array(
				'target_keyword' => array(
					'code' => 'target_keyword',
					'name' => 'text_target_keyword',
					'description' => 'help_target_keyword',
					'type' => 'textarea',
					'sort_order' => '20',
					'multi_store' => true,
					'multi_language' => true,
					'required' => false
				)
			)
		)
	)
);
$_['d_seo_module_manager'] = array(
	'sheet' => array(
		'category' => array(
			'field' => array(
				'target_keyword' => array(
					'code' => 'target_keyword',
					'name' => 'text_target_keyword',
					'type' => 'textarea',
					'sort_order' => '20',
					'multi_store' => true,
					'multi_language' => true,
					'list_status' => true,
					'export_status' => true,
					'required' => false
				)
			)
		),
		'product' => array(
			'field' => array(
				'target_keyword' => array(
					'code' => 'target_keyword',
					'name' => 'text_target_keyword',
					'type' => 'textarea',
					'sort_order' => '20',
					'multi_store' => true,
					'multi_language' => true,
					'list_status' => true,
					'export_status' => true,
					'required' => false
				)
			)
		),
		'manufacturer' => array(
			'field' => array(
				'target_keyword' => array(
					'code' => 'target_keyword',
					'name' => 'text_target_keyword',
					'type' => 'textarea',
					'sort_order' => '20',
					'multi_store' => true,
					'multi_language' => true,
					'list_status' => true,
					'export_status' => true,
					'required' => false
				)
			)
		),
		'information' => array(
			'field' => array(
				'target_keyword' => array(
					'code' => 'target_keyword',
					'name' => 'text_target_keyword',
					'type' => 'textarea',
					'sort_order' => '20',
					'multi_store' => true,
					'multi_language' => true,
					'list_status' => true,
					'export_status' => true,
					'required' => false
				)
			)
		)
	)
);
?>