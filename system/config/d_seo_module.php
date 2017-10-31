<?php 
$_['d_seo_module_setting'] = array(
	'list_limit' => '20',
	'default_custom_pages' => array(
		'common/home' => array('webshop'),
		'product/manufacturer' => array('brand'),
		'product/special' => array('special'),
		'information/contact' => array('contact')
	),
	'default_htaccess' => <<<TEXT
# 1.To use URL Alias you need to be running apache with mod_rewrite enabled.

# 2. In your opencart directory rename htaccess.txt to .htaccess.

# For any support issues please visit: http://www.opencart.com

Options +SymLinksIfOwnerMatch

# Prevent Directoy listing
Options -Indexes

# Prevent Direct Access to files
<FilesMatch "(?i)((\.tpl|.twig|\.ini|\.log|(?<!robots)\.txt))">
 Require all denied
## For apache 2.2 and older, replace "Require all denied" with these two lines :
# Order deny,allow
# Deny from all
</FilesMatch>

# SEO URL Settings
RewriteEngine On
# If your opencart installation does not run on the main web folder make sure you folder it does run in ie. / becomes /shop/

RewriteBase [catalog_url_path]
RewriteRule ^sitemap.xml$ index.php?route=extension/feed/google_sitemap [L]
RewriteRule ^googlebase.xml$ index.php?route=extension/feed/google_base [L]
RewriteRule ^system/storage/(.*) index.php?route=error/not_found [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_URI} !.*\.(ico|gif|jpg|jpeg|png|js|css)
RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]

### Additional Settings that may need to be enabled for some servers
### Uncomment the commands by removing the # sign in front of it.
### If you get an "Internal Server Error 500" after enabling any of the following settings, restore the # as this means your host doesn't allow that.

# 1. If your cart only allows you to add one item at a time, it is possible register_globals is on. This may work to disable it:
# php_flag register_globals off

# 2. If your cart has magic quotes enabled, This may work to disable it:
# php_flag magic_quotes_gpc Off

# 3. Set max upload file size. Most hosts will limit this and not allow it to be overridden but you can try
# php_value upload_max_filesize 999M

# 4. set max post size. uncomment this line if you have a lot of product options or are getting errors where forms are not saving all fields
# php_value post_max_size 999M

# 5. set max time script can take. uncomment this line if you have a lot of product options or are getting errors where forms are not saving all fields
# php_value max_execution_time 200

# 6. set max time for input to be recieved. Uncomment this line if you have a lot of product options or are getting errors where forms are not saving all fields
# php_value max_input_time 200

# 7. disable open_basedir limitations
# php_admin_value open_basedir none

TEXT
	,
	'default_robots' => <<<TEXT
User-agent: *
Disallow: /*route=account/
Disallow: /*route=affiliate/
Disallow: /*route=checkout/
Disallow: /*route=product/search
Disallow: /index.php?route=product/product*&manufacturer_id=
Disallow: /admin
Disallow: /catalog
Disallow: /system
Disallow: /*?sort=
Disallow: /*&sort=
Disallow: /*?order=
Disallow: /*&order=
Disallow: /*?limit=
Disallow: /*&limit=
Disallow: /*?format=
Disallow: /*&format=
Disallow: /*?tracking=
Disallow: /*&tracking=
Disallow: /*?page=
Disallow: /*&page=
Disallow: /*?filter=
Disallow: /*&filter=
Disallow: /*?filter_name=
Disallow: /*&filter_name=
Disallow: /*?filter_sub_category=
Disallow: /*&filter_sub_category=
Disallow: /*?filter_description=
Disallow: /*&filter_description=

Sitemap: [catalog_url]sitemap.xml
Host: [catalog_url_host]

TEXT
);
$_['d_seo_module_field_setting'] = array(
	'sheet' => array(
		'home' => array(
			'code' => 'home',
			'name' => 'text_home',
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
					'required' => false
				)
			)
		),
		'category' => array(
			'code' => 'category',
			'name' => 'text_category',
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
		'product' => array(
			'code' => 'product',
			'name' => 'text_product',
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
		'manufacturer' => array(
			'code' => 'manufacturer',
			'name' => 'text_manufacturer',
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
		'information' => array(
			'code' => 'information',
			'name' => 'text_information',
			'sort_order' => '5',
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
		)
	)
);
$_['d_seo_module_manager_setting'] = array(
	'sheet' => array(
		'category' => array(
			'code' => 'category',
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
			'code' => 'product',
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
			'code' => 'manufacturer',
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
			'code' => 'information',
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