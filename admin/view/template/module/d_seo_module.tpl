<?php
/*
*	location: admin/view
*/
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right  form-inline" >
                <?php if($stores){ ?>
                <select class="form-control" onChange="location = '<?php echo $module_link; ?>&store_id=' + $(this).val();">
                    <?php foreach($stores as $store){ ?>
                    <?php if($store['store_id'] == $store_id){ ?>
                    <option value="<?php echo $store['store_id']; ?>" selected="selected" ><?php echo $store['name']; ?></option>
                    <?php }else{ ?>
                    <option value="<?php echo $store['store_id']; ?>" ><?php echo $store['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select><?php } ?>
                <button onClick="saveAndStay();" data-toggle="tooltip" title="<?php echo $button_save_and_stay; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>
                <button type="submit" form="form-bestseller" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?>  <?php echo $version; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id='form-module' class="form-horizontal">
                    <ul  class="nav nav-tabs">
                        <li class="active"><a href="#setting" data-toggle="tab">
                                <span class="fa fa-cog"></span> 
                                <?php echo $text_setting; ?>
                            </a></li>
                        <li><a href="#module" data-toggle="tab">
                                <span class="fa fa-bars"></span> 
                                <?php echo $text_snippet; ?>
                            </a></li>
                        <li><a href="#block" data-toggle="tab">
                                <span class="fa fa-link"></span> 
                                <?php echo $text_seo; ?>
                            </a></li>
                        <li><a href="#sitemap" data-toggle="tab">
                                <span class="fa fa-sitemap"></span> 
                                <?php  echo $text_sitemap ; ?> 
                            </a></li>
                        <li><a href="#microformat" data-toggle="tab">
                                <span class="fa fa-list-alt"></span> 
                                <?php // echo $text_microformat; ?> microformat
                            </a></li>
                        <li><a href="#instruction" data-toggle="tab">
                                <span class="fa fa-graduation-cap"></span> 
                                <?php echo $text_instruction; ?>
                            </a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="setting" >
                            <div class="tab-body">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-status">Status</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="d_seo_status" value="0" />
                                            <input type="checkbox" id="input_debug" name="d_seo_status" <?php echo ($d_seo_status)? 'checked="checked"':'';?> value="1" />
                                      
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-robots">Robots</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="d_seo_robots" value="0" />
                                            <input type="checkbox" id="input_debug" name="d_seo_robots" <?php echo ($d_seo_robots)? 'checked="checked"':'';?> value="1" />
                                      
                                        </div>
                                    </div>

                                </div>
                                


                            </div>
                        </div>
                        <div class="tab-pane " id="block" >
                            <div class="tab-body">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="input-catalog-limit">
                                            <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_seo_url_status; ?>">
                                                <?php echo $text_seo_switch ?>             
                                            </span>
                                        </label>
                                        <div class="col-sm-8">
                                            
                                                <label>
                                                    <input type="hidden" value="0" name="config_seo_url"> 
                                                    <input type="checkbox" value="1" name="config_seo_url" id="checkout_enable"  <?php echo ($config_seo_url) ? 'checked="checked"' : '' ?>  >
                                                 
                                                </label>
                                            
                                        </div>
                                    </div>


                                </div> 
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="input-catalog-limit">
                                            <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_seo_url_type; ?>">
                                                <?php echo $text_seo_type ?>              
                                            </span>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="radio">
                                                <?php if( isset($d_seo_url_type) && $d_seo_url_type == 1 ) {?>  
                                                                    <label for="url_type_canonical" class="">
                                                                  <input type="radio" value="0" name="d_seo_url_type"    id="url_type_canonical">
                                                                  <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_button_canonical; ?>">    
                                                                     <?php echo $button_canonical; ?> 
                                                                  </span>
                                                                </label>

                                                                 <label for="url_type_modified" class="">
                                                                  <input type="radio" value="1" name="d_seo_url_type"  checked="checked"  id="url_type_modified">
                                                                     <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_button_modified; ?>">    
                                                                        <?php echo $button_modified; ?> 		
                                                                      </span>
                                                                 </label>

                                                            

                                                               
                                                <?php } else { ?>
                                                                <label for="url_type_canonical" class="">
                                                                    <input type="radio" value="0" name="d_seo_url_type" checked="checked"  id="url_type_canonical">
                                                                    <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_button_canonical; ?>">    
                                                                         <?php echo $button_canonical; ?> 
                                                                    </span>
                                                                </label>
                                                                <label for="url_type_modified" class="">
                                                                    <input type="radio" value="1" name="d_seo_url_type"  id="url_type_modified">
                                                                    <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_button_modified; ?>">    
                                                                        <?php echo $button_modified; ?> 		
                                                                      </span>					
                                                                </label>
                                                                

                                                              
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="input-catalog-limit">
                                            <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_htacess_backup; ?>">
                                                <?php echo $text_create_backup; ?>             
                                            </span>
                                        </label>
                                        <div class="col-sm-3">
                                            <a id="do_backup" class="btn btn-primary btn-block"><?php echo $button_create;  ?> </a>
                                        </div>
                                        <div class="col-sm-5">
                                            <div id="version_result"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <?php if ($backup_files) { ?>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="input-status"> 
                                            <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_htacess_restore; ?>">
                                                <?php echo $text_restore_backup ?>  
                                            </span>
                                        </label>
                                        <div class="col-sm-5">
                                            <select name="d_seo_htacess[backup]" id="input_backup_file" class="form-control">
                                                <?php foreach ($backup_files as $backup_file) { ?>
                                                <option value="<?php echo $backup_file; ?>"><?php echo $backup_file; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <a id="restore_backup" class="btn btn-primary btn-block"> <?php echo $button_restore;  ?> </a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="input-catalog-limit">
                                            <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_htacess_start; ?>">
                                                <?php echo $text_modification ?> 
                                            </span>
                                        </label>
                                        <div class="col-sm-3">
                                            <a id="htacess_change" class="btn btn-primary btn-block"> <?php echo $button_start;  ?> </a>
                                            <script>
                                                        $("#htacess_change").on("click", function(){

                                                $("#htaccees_textarea").fadeIn("slow", function() {

                                                });
                                                });                                            </script>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="version_result"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <div id="htaccees_textarea" class="col-sm-offset-2 col-sm-10  " style="display:none;">
                                    <textarea name="d_seo_htacess[htaccess]" id="htaccess-input" class="form-control" rows="20"><?php foreach ($htaccess_content as $line)
											echo $line;
							?></textarea>

                                    <div class="col-sm-1" style="margin-top: 10px;">
                                        <div class="row">
                                          <a id="save_htacess" class="btn btn-primary btn-block"> <?php echo $button_save;  ?> </a>
                                         </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="tab-pane" id="module" >
                            <ul class="nav nav-tabs" id="language">
                                <?php foreach ($languages as $language) { ?>
                                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $language) { ?>
                                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                                    <div class="tab-body">

                                        <div class="form-group ">
                                            <label class="col-sm-2 control-label" for="input-meta-title1">
                                                <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_snippet_preview; ?>">
                                                    <?php echo $text_snippet_preview; ?></label>
                                                </span>
                                            <div class="col-sm-10">
                                                <div id="wpseosnippet-<?php echo $language['language_id']; ?>">
                                                    <span class="title" id="wpseosnippet_title-<?php echo $language['language_id']; ?>" >Page Title  <span><?php echo isset($d_seo_snipet[$language['language_id']]['separator']) ? $d_seo_snipet[$language['language_id']]['separator'] : $d_seo_snipet['separator']; ?></span></span>
                                                    <span class="url"><?php  echo $_SERVER['HTTP_HOST']; ?>/url-of-page</span>
                                                    <p class="desc"><span class="autogen"></span>
                                                        <span class="content">
                                                            <?php echo $text_metadescription ?>
                                                        </span>		
                                                    </p>
                                                </div>
                                            </div>
                                            <script>

                                            </script>
                                            <style>
                                                #wpseosnippet-<?php echo $language['language_id']; ?> {
                                                    width: auto;
                                                    max-width: 520px;
                                                    margin: 0 0 10px;
                                                    padding: 0 5px;
                                                    font-family: Arial,Helvetica,sans-serif;
                                                    font-style: normal;
                                                }
                                                #wpseosnippet-<?php echo $language['language_id']; ?> .title {
                                                    display: block;
                                                    overflow: hidden;
                                                    width: 512px;
                                                    color: #1e0fbe;
                                                    font-size: 18px!important;
                                                    line-height: 1.2;
                                                    white-space: nowrap;
                                                    text-overflow: ellipsis;
                                                }
                                                #wpseosnippet-<?php echo $language['language_id']; ?> .url {
                                                    color: #006621;
                                                    font-size: 13px;
                                                    line-height: 16px;
                                                }
                                                #wpseosnippet-<?php echo $language['language_id']; ?> .desc {
                                                    font-size: small;
                                                    line-height: 1.4;
                                                    word-wrap: break-word;
                                                }
                                            </style>
                                        </div>
                                        <div class= "col-sm-6">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="input-snipet-separator-<?php echo $language['language_id']; ?>">
                                                    <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_separator; ?>">
                                                        <?php echo $text_separator; ?></label>
                                                    </span>
                                                <div class="col-sm-8">
                                                    <input type="text" name="d_seo_snipet[<?php echo $language['language_id']; ?>][separator]" maxlength="" value="<?php echo isset($d_seo_snipet[$language['language_id']]['separator']) ? $d_seo_snipet[$language['language_id']]['separator'] : $d_seo_snipet['separator']; ?>" placeholder="Separator" id="input-snipet-separator-<?php echo $language['language_id']; ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                                    $('#input-snipet-separator-<?php echo $language['language_id']; ?>').on("keyup", function(){
                                            $("#wpseosnippet_title-<?php echo $language['language_id']; ?> span").text($(this).val());
                                            });                                        </script>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>


                        <div class="tab-pane" id="sitemap" >
                            <div class="tab-body">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="input-catalog-limit">
                                            <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_sitemap_status; ?>"><?php echo $text_sitemap_switch; ?></span>
                                        </label>
                                        <div class="col-sm-8">
                                                <label>
                                                    <input type="hidden" value="0" name="google_sitemap_status"> 
                                                    <input type="checkbox" value="1" name="google_sitemap_status" id="checkout_enable" <?php  echo ($google_sitemap_status) ? 'checked="checked"' : ''; ?> >
                                                    
                                                </label>
                                        </div>
                                    </div>   
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="input-data-feed"> <?php echo $text_sitemap_link; ?> </label>
                                        <div class="col-sm-8  checkbox">
                                            <span id="input-data-feed"  > <a href="<?php echo $data_feed; ?>" target="_blank" ><?php echo $data_feed; ?></a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-12">
                                        <ul class="nav nav-tabs" id="sitemap-default">
                                            <li ><a href="#product-tab" data-toggle="tab" aria-expanded="true">Product</a></li>
                                            <li ><a href="#category-tab" data-toggle="tab" aria-expanded="true">Category</a></li>
                                            <li ><a href="#manufacture-tab" data-toggle="tab" aria-expanded="true">Manufacture</a></li>
                                            <li ><a href="#information-tab" data-toggle="tab" aria-expanded="true">Information</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane " id="product-tab">
                                                <div class="tab-body">
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                 <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_sitemap_changefreq; ?>"><?php echo $text_changefreq; ?></span>
                                                             </label>
                                                             <div class="col-sm-8">
                                                                <select name="d_seo_sitemap[product][changefreq]" class="form-control">
                          
                                                                <?php if($d_seo_sitemap['product']['changefreq'] == "always" ) {?>
                                                                    <option value="always" selected="selected" >always</option>
                                                                <?php } else { ?>
                                                                    <option value="always" >always</option>
                                                                <?php }   ?>
                                                   
                                                                <?php if($d_seo_sitemap['product']['changefreq'] == "hourly") {?>
                                                                    <option value="hourly" selected="selected">hourly</option>
                                                                <?php } else { ?>
                                                                    <option value="hourly" >hourly</option>
                                                                <?php } ?>
                                                                
                                                                <?php if(($d_seo_sitemap['product']['changefreq'] == "daily") ||  empty($d_seo_sitemap['product']['changefreq'])){ ?>
                                                                   <option value="daily" selected="selected" >daily</option>
                                                                <?php } else { ?>
                                                                    <option value="daily"  >daily</option>
                                                                <?php } ?>
                                                             
                                                                <?php if($d_seo_sitemap['product']['changefreq'] == "weekly") { ?>
                                                                    <option value="weekly" selected="selected">weekly</option>
                                                                <?php } else { ?>
                                                                    <option value="weekly" >weekly</option>
                                                                <?php } ?>
                                                           
                                                                <?php if($d_seo_sitemap['product']['changefreq'] == "monthly") { ?>
                                                                     <option value="monthly" selected="selected" >monthly</option>
                                                                <?php } else { ?>
                                                                      <option value="monthly" >monthly</option>
                                                                <?php } ?>
                                                    									
                                                                <?php if($d_seo_sitemap['product']['changefreq'] == "yearly") { ?>
                                                                      <option value="yearly" selected="selected">yearly</option>
                                                                <?php } else { ?>
                                                                      <option value="yearly" >yearly</option>
                                                                <?php } ?>
                                                                
                                                                <?php if($d_seo_sitemap['product']['changefreq'] == "never") {?>
                                                                    		<option value="never" selected="selected" >never</option>
                                                            		 	<?php } else { ?>
                                                                     <option value="never" >never</option>
                                                                <?php } ?>
                                                                </select>
                                                             </div>
                                                        </div>
                                                                     
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_sitemap_priority; ?>"><?php echo $text_priority; ?></span>
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <select name="d_seo_sitemap[product][priority]" class="form-control">
                                                            
                                                                <?php if($d_seo_sitemap['product']['priority'] == 1.0 ||  empty($d_seo_sitemap['product']['priority'])) {?>
                                                                    <option value="1.0" selected="selected" >1.0</option>
                                                                <?php } else { ?>
                                                                     <option value="1.0"  >1.0</option>
                                                                 <?php } ?>
                                                                
                                                                <?php if($d_seo_sitemap['product']['priority'] == 0.75) {?>
                                                                    <option value="0.75" selected="selected" >0.75</option>
                                                            				<?php } else { ?>
                                                                    <option value="0.75" >0.75</option>
                                                                <?php } ?>
                                                    
                                                                <?php if($d_seo_sitemap['product']['priority'] == 0.5) {?>
                                                                    <option value="0.5" selected="selected" >0.5</option>
                                                                <?php } else { ?>
                                                                    <option value="0.5" >0.5</option>
                                                                <?php } ?>
                                                 
                                                                <?php if($d_seo_sitemap['product']['priority'] == 0.25) {?>
                                                                    <option value="0.25" selected="selected" >0.25</option>
                                                                <?php } else { ?>
                                                                    <option value="0.25" >0.25</option>
                                                                <?php } ?>
                                                                
                                                                <?php if($d_seo_sitemap['product']['priority'] == 0.1 ) {?>
                                                                		 	<option value="0.1" selected="selected" >0.1</option>
                                                                <?php } else { ?>
                                                                    <option value="0.1" >0.1</option>
                                                                <?php } ?>
                                                
                                                               </select>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="tab-pane " id="category-tab">
                                                <div class="tab-body">
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                 <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_sitemap_changefreq; ?>"><?php echo $text_changefreq; ?></span>
                                                             </label>
                                                             <div class="col-sm-8">
                                                                <select name="d_seo_sitemap[category][changefreq]" class="form-control">
                          
                                                                <?php if($d_seo_sitemap['category']['changefreq'] == "always" ) {?>
                                                                    <option value="always" selected="selected" >always</option>
                                                                <?php } else { ?>
                                                                    <option value="always" >always</option>
                                                                <?php }   ?>
                                                   
                                                                <?php if($d_seo_sitemap['category']['changefreq'] == "hourly") {?>
                                                                    <option value="hourly" selected="selected">hourly</option>
                                                                <?php } else { ?>
                                                                    <option value="hourly" >hourly</option>
                                                                <?php } ?>
                                                                
                                                                <?php if(($d_seo_sitemap['category']['changefreq'] == "daily") ||  empty($d_seo_sitemap['category']['changefreq'])){ ?>
                                                                   <option value="daily" selected="selected" >daily</option>
                                                                <?php } else { ?>
                                                                    <option value="daily"  >daily</option>
                                                                <?php } ?>
                                                             
                                                                <?php if($d_seo_sitemap['category']['changefreq'] == "weekly") { ?>
                                                                    <option value="weekly" selected="selected">weekly</option>
                                                                <?php } else { ?>
                                                                    <option value="weekly" >weekly</option>
                                                                <?php } ?>
                                                           
                                                                <?php if($d_seo_sitemap['category']['changefreq'] == "monthly") { ?>
                                                                     <option value="monthly" selected="selected" >monthly</option>
                                                                <?php } else { ?>
                                                                      <option value="monthly" >monthly</option>
                                                                <?php } ?>
                                                    									
                                                                <?php if($d_seo_sitemap['category']['changefreq'] == "yearly") { ?>
                                                                      <option value="yearly" selected="selected">yearly</option>
                                                                <?php } else { ?>
                                                                      <option value="yearly" >yearly</option>
                                                                <?php } ?>
                                                                
                                                                <?php if($d_seo_sitemap['category']['changefreq'] == "never") {?>
                                                                    		<option value="never" selected="selected" >never</option>
                                                            		 	<?php } else { ?>
                                                                     <option value="never" >never</option>
                                                                <?php } ?>
                                                                </select>
                                                             </div>
                                                        </div>
                                                                     
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_sitemap_priority; ?>"><?php echo $text_priority; ?></span>
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <select name="d_seo_sitemap[category][priority]" class="form-control">
                                                            
                                                                <?php if($d_seo_sitemap['category']['priority'] == 1.0 ||  empty($d_seo_sitemap['category']['priority'])) {?>
                                                                    <option value="1.0" selected="selected" >1.0</option>
                                                                <?php } else { ?>
                                                                     <option value="1.0"  >1.0</option>
                                                                 <?php } ?>
                                                                
                                                                <?php if($d_seo_sitemap['category']['priority'] == 0.75) {?>
                                                                    <option value="0.75" selected="selected" >0.75</option>
                                                            				<?php } else { ?>
                                                                    <option value="0.75" >0.75</option>
                                                                <?php } ?>
                                                    
                                                                <?php if($d_seo_sitemap['category']['priority'] == 0.5) {?>
                                                                    <option value="0.5" selected="selected" >0.5</option>
                                                                <?php } else { ?>
                                                                    <option value="0.5" >0.5</option>
                                                                <?php } ?>
                                                 
                                                                <?php if($d_seo_sitemap['category']['priority'] == 0.25) {?>
                                                                    <option value="0.25" selected="selected" >0.25</option>
                                                                <?php } else { ?>
                                                                    <option value="0.25" >0.25</option>
                                                                <?php } ?>
                                                                
                                                                <?php if($d_seo_sitemap['category']['priority'] == 0.1 ) {?>
                                                                		 	<option value="0.1" selected="selected" >0.1</option>
                                                                <?php } else { ?>
                                                                    <option value="0.1" >0.1</option>
                                                                <?php } ?>
                                                
                                                               </select>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="tab-pane " id="manufacture-tab">
                                                <div class="tab-body">
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                 <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_sitemap_changefreq; ?>"><?php echo $text_changefreq; ?></span>
                                                             </label>
                                                             <div class="col-sm-8">
                                                                <select name="d_seo_sitemap[manufacture][changefreq]" class="form-control">
                          
                                                                <?php if($d_seo_sitemap['manufacture']['changefreq'] == "always" ) {?>
                                                                    <option value="always" selected="selected" >always</option>
                                                                <?php } else { ?>
                                                                    <option value="always" >always</option>
                                                                <?php }   ?>
                                                   
                                                                <?php if($d_seo_sitemap['manufacture']['changefreq'] == "hourly") {?>
                                                                    <option value="hourly" selected="selected">hourly</option>
                                                                <?php } else { ?>
                                                                    <option value="hourly" >hourly</option>
                                                                <?php } ?>
                                                                
                                                                <?php if(($d_seo_sitemap['manufacture']['changefreq'] == "daily") ||  empty($d_seo_sitemap['manufacture']['changefreq'])){ ?>
                                                                   <option value="daily" selected="selected" >daily</option>
                                                                <?php } else { ?>
                                                                    <option value="daily"  >daily</option>
                                                                <?php } ?>
                                                             
                                                                <?php if($d_seo_sitemap['manufacture']['changefreq'] == "weekly") { ?>
                                                                    <option value="weekly" selected="selected">weekly</option>
                                                                <?php } else { ?>
                                                                    <option value="weekly" >weekly</option>
                                                                <?php } ?>
                                                           
                                                                <?php if($d_seo_sitemap['manufacture']['changefreq'] == "monthly") { ?>
                                                                     <option value="monthly" selected="selected" >monthly</option>
                                                                <?php } else { ?>
                                                                      <option value="monthly" >monthly</option>
                                                                <?php } ?>
                                                    									
                                                                <?php if($d_seo_sitemap['manufacture']['changefreq'] == "yearly") { ?>
                                                                      <option value="yearly" selected="selected">yearly</option>
                                                                <?php } else { ?>
                                                                      <option value="yearly" >yearly</option>
                                                                <?php } ?>
                                                                
                                                                <?php if($d_seo_sitemap['manufacture']['changefreq'] == "never") {?>
                                                                    		<option value="never" selected="selected" >never</option>
                                                            		 	<?php } else { ?>
                                                                     <option value="never" >never</option>
                                                                <?php } ?>
                                                                </select>
                                                             </div>
                                                        </div>
                                                                     
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_sitemap_priority; ?>"><?php echo $text_priority; ?></span>
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <select name="d_seo_sitemap[manufacture][priority]" class="form-control">
                                                            
                                                                <?php if($d_seo_sitemap['manufacture']['priority'] == 1.0 ||  empty($d_seo_sitemap['manufacture']['priority'])) {?>
                                                                    <option value="1.0" selected="selected" >1.0</option>
                                                                <?php } else { ?>
                                                                     <option value="1.0"  >1.0</option>
                                                                 <?php } ?>
                                                                
                                                                <?php if($d_seo_sitemap['manufacture']['priority'] == 0.75) {?>
                                                                    <option value="0.75" selected="selected" >0.75</option>
                                                            				<?php } else { ?>
                                                                    <option value="0.75" >0.75</option>
                                                                <?php } ?>
                                                    
                                                                <?php if($d_seo_sitemap['manufacture']['priority'] == 0.5) {?>
                                                                    <option value="0.5" selected="selected" >0.5</option>
                                                                <?php } else { ?>
                                                                    <option value="0.5" >0.5</option>
                                                                <?php } ?>
                                                 
                                                                <?php if($d_seo_sitemap['manufacture']['priority'] == 0.25) {?>
                                                                    <option value="0.25" selected="selected" >0.25</option>
                                                                <?php } else { ?>
                                                                    <option value="0.25" >0.25</option>
                                                                <?php } ?>
                                                                
                                                                <?php if($d_seo_sitemap['manufacture']['priority'] == 0.1 ) {?>
                                                                		 	<option value="0.1" selected="selected" >0.1</option>
                                                                <?php } else { ?>
                                                                    <option value="0.1" >0.1</option>
                                                                <?php } ?>
                                                
                                                               </select>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                              <div class="tab-pane " id="information-tab">
                                                <div class="tab-body">
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                 <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_sitemap_changefreq; ?>"><?php echo $text_changefreq; ?></span>
                                                             </label>
                                                             <div class="col-sm-8">
                                                                <select name="d_seo_sitemap[manufacture][changefreq]" class="form-control">
                          
                                                                <?php if($d_seo_sitemap['manufacture']['changefreq'] == "always" ) {?>
                                                                    <option value="always" selected="selected" >always</option>
                                                                <?php } else { ?>
                                                                    <option value="always" >always</option>
                                                                <?php }   ?>
                                                   
                                                                <?php if($d_seo_sitemap['manufacture']['changefreq'] == "hourly") {?>
                                                                    <option value="hourly" selected="selected">hourly</option>
                                                                <?php } else { ?>
                                                                    <option value="hourly" >hourly</option>
                                                                <?php } ?>
                                                                
                                                                <?php if(($d_seo_sitemap['manufacture']['changefreq'] == "daily") ||  empty($d_seo_sitemap['manufacture']['changefreq'])){ ?>
                                                                   <option value="daily" selected="selected" >daily</option>
                                                                <?php } else { ?>
                                                                    <option value="daily"  >daily</option>
                                                                <?php } ?>
                                                             
                                                                <?php if($d_seo_sitemap['manufacture']['changefreq'] == "weekly") { ?>
                                                                    <option value="weekly" selected="selected">weekly</option>
                                                                <?php } else { ?>
                                                                    <option value="weekly" >weekly</option>
                                                                <?php } ?>
                                                           
                                                                <?php if($d_seo_sitemap['manufacture']['changefreq'] == "monthly") { ?>
                                                                     <option value="monthly" selected="selected" >monthly</option>
                                                                <?php } else { ?>
                                                                      <option value="monthly" >monthly</option>
                                                                <?php } ?>
                                                    									
                                                                <?php if($d_seo_sitemap['manufacture']['changefreq'] == "yearly") { ?>
                                                                      <option value="yearly" selected="selected">yearly</option>
                                                                <?php } else { ?>
                                                                      <option value="yearly" >yearly</option>
                                                                <?php } ?>
                                                                
                                                                <?php if($d_seo_sitemap['manufacture']['changefreq'] == "never") {?>
                                                                    		<option value="never" selected="selected" >never</option>
                                                            		 	<?php } else { ?>
                                                                     <option value="never" >never</option>
                                                                <?php } ?>
                                                                </select>
                                                             </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                                <span data-toggle="tooltip" title="" data-original-title="<?php echo $help_sitemap_priority; ?>"><?php echo $text_priority; ?></span>
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <select name="d_seo_sitemap[manufacture][priority]" class="form-control">
                                                            
                                                                <?php if($d_seo_sitemap['manufacture']['priority'] == 1.0 ||  empty($d_seo_sitemap['manufacture']['priority'])) {?>
                                                                    <option value="1.0" selected="selected" >1.0</option>
                                                                <?php } else { ?>
                                                                     <option value="1.0"  >1.0</option>
                                                                 <?php } ?>
                                                                
                                                                <?php if($d_seo_sitemap['manufacture']['priority'] == 0.75) {?>
                                                                    <option value="0.75" selected="selected" >0.75</option>
                                                            				<?php } else { ?>
                                                                    <option value="0.75" >0.75</option>
                                                                <?php } ?>
                                                    
                                                                <?php if($d_seo_sitemap['manufacture']['priority'] == 0.5) {?>
                                                                    <option value="0.5" selected="selected" >0.5</option>
                                                                <?php } else { ?>
                                                                    <option value="0.5" >0.5</option>
                                                                <?php } ?>
                                                 
                                                                <?php if($d_seo_sitemap['manufacture']['priority'] == 0.25) {?>
                                                                    <option value="0.25" selected="selected" >0.25</option>
                                                                <?php } else { ?>
                                                                    <option value="0.25" >0.25</option>
                                                                <?php } ?>
                                                                
                                                                <?php if($d_seo_sitemap['manufacture']['priority'] == 0.1 ) {?>
                                                                		 	<option value="0.1" selected="selected" >0.1</option>
                                                                <?php } else { ?>
                                                                    <option value="0.1" >0.1</option>
                                                                <?php } ?>
                                                
                                                               </select>
                                                            </div>
                                                        </div>
                                   
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                     
                                </div>
                              
                               
                             
                               
                            </div>
                        </div>
                        <div class="tab-pane" id="microformat" >
                            <div class="tab-body"> 
                                <div class="bs-callout bs-callout-warning"><h4>In Development</h4>
                                    <p>Please feel free to send us feedback on the functionality you would like to see in the next updates via <a href="http://dreamvention.com/support">support</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="instruction" >
                            <div class="tab-body"> 
                                <div class="bs-callout bs-callout-warning"><h4>In Development</h4>
                                    <p>Please feel free to send us feedback on the functionality you would like to see in the next updates via <a href="http://dreamvention.com/support">support</a></p>
                                </div>

                            </div>
                        </div>


                    </div>




                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript"><!--
        function saveAndStay(){
                $.ajax({
                type: "POST",
                        url: 'index.php?route=module/d_seo_module&token=<?php echo $token; ?>&save',
                        data: $('#form-module').serialize(),
                        beforeSend: function() {
                        $('#form-module').fadeTo('slow', 0.5);
                        },
                        complete: function() {
                        $('#form-module').fadeTo('slow', 1);
                        },
                        success: function(response) {
                        console.log(response);
                        }
                });
                }
        $("#do_backup").on("click", function(){
               $.ajax({
                url: 'index.php?route=module/d_seo_module/createHtaccessBackup&token=<?php echo $token; ?>',
                type: 'post',
                data:'',
                dataType: 'json',
                success: function(json) {
                     HTML =   '<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ';
                     HTML +=  json['success']; 
                     HTML +=   '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                     if($('.alert').length){
                         $('.alert').replaceWith(HTML);
                    }else{
                         $('.page-header .container-fluid').append(HTML);
                     }
                      
                },
                error: function(json) {
                     HTML =   '<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ';
                     HTML +=  json['error']; 
                     HTML +=   '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                       if($('.alert').length){
                         $('.alert').replaceWith(HTML);
                      }else{
                         $('.page-header .container-fluid').append(HTML);
                     }
                }
               });
             
        });
         $("#restore_backup").on("click", function(){
        $.ajax({
        url: 'index.php?route=module/d_seo_module/restoreHtaceessBackup&token=<?php echo $token; ?>',
                type: 'post',
                data: $('select#input_backup_file'),
                dataType: 'json',
                success: function(json) {
                     HTML =   '<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ';
                     HTML +=  json['success']; 
                     HTML +=   '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                     if($('.alert').length){
                         $('.alert').replaceWith(HTML);
                    }else{
                         $('.page-header .container-fluid').append(HTML);
                     }
                },
                error: function(json) {
                    HTML =   '<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ';
                    HTML +=  json['error']; 
                    HTML +=   '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                     if($('.alert').length){
                         $('.alert').replaceWith(HTML);
                    }else{
                         $('.page-header .container-fluid').append(HTML);
                     }
                }
        });
        });
         $("#save_htacess").on("click", function(){
             
                 htaccess = $('textarea#htaccess-input').val().replace('\r', '').split('\n');
                    $.post("index.php?route=module/d_seo_module/editHtaceessBackup&token=<?php echo $token; ?>", {'data': JSON.stringify($('textarea#htaccess-input').val() ) });
                    HTML =   '<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> ';
                    HTML +=  '<?php echo $save_htaccess; ?>'; 
                    HTML +=   '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                     if($('.alert').length){
                         $('.alert').replaceWith(HTML);
                    }else{
                         $('.page-header .container-fluid').append(HTML);
                     }
                     $('body,html').animate({ scrollTop: 0}, 400);
                    $("#htaccees_textarea").fadeOut("slow", function() { });
                      //setTimeout(function(){
                    //   $('.alert').remove();
                    //  }, 3000);
                    
                    

        });
                //--></script>
    <script type="text/javascript"><!--
        $('#language a:first').tab('show');
        $('#sitemap-default a:first').tab('show');
        $('#option a:first').tab('show');
        $("[type='checkbox']").bootstrapSwitch({
            'onColor': 'success',
            'onText': 'YES',
            'offText': 'NO',
        });
                
//--></script>
</div>
<?php echo $footer; ?>