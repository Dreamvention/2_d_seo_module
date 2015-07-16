<?php
/*
 *	location: admin/view
 */
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      	<?php if($stores){ ?>
	    <select class="form-control" onChange="location='<?php echo $module_link; ?>&store_id='+$(this).val()">
	     <?php foreach($stores as $store){ ?>
	     <?php if($store['store_id'] == $store_id){ ?>
	     <option value="<?php echo $store['store_id']; ?>" selected="selected" ><?php echo $store['name']; ?></option>
	     <?php }else{ ?>
	     <option value="<?php echo $store['store_id']; ?>" ><?php echo $store['name']; ?></option>
	     <?php } ?>
	     <?php } ?>
	    </select><?php } ?>
	    <button onClick="saveAndStay()" data-toggle="tooltip" title="<?php echo $button_save_and_stay; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>
        <button type="submit" form="form-bestseller" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-bestseller" class="form-horizontal">
          <ul  class="nav nav-tabs">
	        <li class="active"><a href="#block" data-toggle="tab">
	        	<span class="fa fa-puzzle-piece"></span> 
	        	<?php echo $text_seo; ?>
	        </a></li>
	        <li><a href="#module" data-toggle="tab">
	        	<span class="fa fa-bars"></span> 
	        	<?php echo $text_snippet; ?>
	        </a></li>
	        <li><a href="#setting" data-toggle="tab">
	        	<span class="fa fa-cog"></span> 
	        	<?php echo $text_setting; ?>
	        </a></li>
	        <li><a href="#instruction" data-toggle="tab">
	        	<span class="fa fa-graduation-cap"></span> 
	        	<?php echo $text_instruction; ?>
	        </a></li>
	      </ul>

	      <div class="tab-content">
	      	<div class="tab-pane active" id="block" >
	      		<div class="tab-body">
					 <div class="col-sm-6">
						<div class="form-group">
							<label class="col-sm-6 control-label" for="input-catalog-limit">
								<span data-toggle="tooltip" title="" data-original-title="Enable SEO URL for your site.">
										Enable/Disable SEO url:              
								</span>
							</label>
							<div class="col-sm-6">
								<div class="checkbox">
									<label>
											<input type="hidden" value="0" name="config_seo_url"> 
										<?php if ($config_seo_url) { ?>
											<input type="checkbox" value="1" name="config_seo_url" id="checkout_enable" checked="checked"><?php echo $text_enabled; ?>
										<?php } else{ ?>
											<input type="checkbox" value="1" name="config_seo_url" id="checkout_enable"><?php echo $text_enabled; ?>
										<?php } ?>
									</label>
								</div>
							</div>
						</div>
			          
			            
			        </div> 
					<div class="clearfix"></div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-sm-6 control-label" for="input-catalog-limit">
								<span data-toggle="tooltip" title="" data-original-title="Change type of SEO url.">
										Type of SEO url:              
								</span>
							</label>
							<div class="col-sm-6">
								<div class="radio">
                  
												<label for="url_type_canonical" class="">
												  <input type="radio" value="canonical" name="d_seo[url][type]" checked="checked" id="url_type_canonical">
													canonical 
												</label>

												<label for="url_type_modified" class="">
												  <input type="radio" value="modified" name="d_seo[url][type]" id="url_type_modified">
													modified					
												 </label>

                                 </div>
							</div>
						</div>
			        </div> 
					<div class="clearfix"></div>
					<div class="col-sm-6">
						<div class="form-group">
						  <label class="col-sm-6 control-label" for="input-catalog-limit">
						   <span data-toggle="tooltip" title="" data-original-title="Do backup of .htaccess before do modification of .htaccess.">
								Create .htaccess backup:             
							</span>
						  </label>
						  <div class="col-sm-2">
							<a id="do_backup" class="btn btn-primary"> create </a>
						  </div>
						  <div class="col-sm-4">
							<div id="version_result"></div>
						  </div>
						 </div>
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-6">
						  <?php if ($config_files) { ?>
						<div class="form-group">
							<label class="col-sm-6 control-label" for="input-status"> 
							<span data-toggle="tooltip" title="" data-original-title="When there is a new version available, you can download it from the location you have purchased the module.">
							  Restore .htaccess backup:   
							</span>
							</label>
							<div class="col-sm-4">
							  <select name="d_seo[config]" id="input_config_file" class="form-control">
								<?php foreach ($config_files as $config_file) { ?>
								<option value="<?php echo $config_file; ?>"><?php echo $config_file; ?></option>
								<?php } ?>
							  </select>
							</div>
							<div class="col-sm-2">
								<a id="version_check" class="btn btn-primary"> restore </a>
							</div>
						</div>
			        <?php } ?>
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-6">
						<div class="form-group">
						  <label class="col-sm-6 control-label" for="input-catalog-limit">
						   <span data-toggle="tooltip" title="" data-original-title="When there is a new version available, you can download it from the location you have purchased the module.">
							Modification .htaccess : </span>
						  </label>
						  <div class="col-sm-2">
							<a id="htacess_change" class="btn btn-primary"> Start </a>
							<script>
								$("#htacess_change").on("click",function(){
									 
									$("#htaccees_textarea").fadeIn( "slow", function() {
									
									 });
								})
							</script>
						  </div>
						  <div class="col-sm-4">
							<div id="version_result"></div>
						  </div>
						 </div>
					</div>
					<div class="clearfix"></div>
					<div id="htaccees_textarea" class="col-sm-offset-3 col-sm-9  " style="display:none;">
						<textarea name="d_seo[htaccess]" id="design_custom_style" class="form-control" rows="5"></textarea>
					</div>
				</div>
	      	</div>
	      	<div class="tab-pane" id="module" >
		      	<div class="tab-body">
				
						<div class="form-group ">
									<label class="col-sm-2 control-label" for="input-meta-title1">Snippet Preview</label>
									<div class="col-sm-10">
										  <div id="wpseosnippet">
											<span class="title" id="wpseosnippet_title" >Apple Cinema 30"  - STORE NAME</span>
											<span class="url">anton.dreamvention.com</span>
											<p class="desc"><span class="autogen"></span><span class="content">sdgggggggggggggggggggggggggghsrrrrrthvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvb</span></p>
										</div>
									</div>
									<script> 
									
									</script>
									<style>
										#wpseosnippet {
										  width: auto;
										  max-width: 520px;
										  margin: 0 0 10px;
										  padding: 0 5px;
										  font-family: Arial,Helvetica,sans-serif;
										  font-style: normal;
										}
										#wpseosnippet .title {
										  display: block;
										  overflow: hidden;
										  width: 512px;
										  color: #1e0fbe;
										  font-size: 18px!important;
										  line-height: 1.2;
										  white-space: nowrap;
										  text-overflow: ellipsis;
										}
										#wpseosnippet .url {
										  color: #006621;
										  font-size: 13px;
										  line-height: 16px;
										}
										#wpseosnippet .desc {
										  font-size: small;
										  line-height: 1.4;
										  word-wrap: break-word;
										}
									</style>
						</div>
						<div class= "col-sm-6">
							<div class="form-group             ">
								<label class="col-sm-2 control-label" for="input-meta-title1">Meta Tag Title</label>
								<div class="col-sm-10">
									<input type="text" name="product_description[1][meta_title]" value="" placeholder="Meta Tag Title" id="input-meta-title1" class="form-control">
                                          </div>
							</div>
						</div>
		      	</div>
		      </div>
	      	<div class="tab-pane" id="setting" >
	      		<div class="tab-body">
			          
			      
			           
	      		</div>
	      	</div>
	      	<div class="tab-pane" id="instruction" >
	      		<div class="tab-body">instruction</div>
	      	</div>


	      </div>


              
          
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
function addModule() {
	var token = Math.random().toString(36).substr(2);
	
	html  = '<tr id="module-row' + token + '">';
	html += '  <td class="text-right">' + ($('tbody tr').length + 1) + '</td>';
	html += '  <td class="text-left"><input type="text" name="<?php echo $id;?>_module[' + token + '][limit]" value="5" placeholder="<?php echo $entry_limit; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><input type="text" name="<?php echo $id;?>_module[' + token + '][width]" value="200" placeholder="<?php echo $entry_width; ?>" class="form-control" /> <input type="text" name="<?php echo $id;?>_module[' + token + '][height]" value="200" placeholder="<?php echo $entry_height; ?>" class="form-control" /></td>'; 
	html += '  <td class="text-left"><button type="button" onclick="$(\'#module_row_' + token + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';
	
	$('#module tbody').append(html);
}
//--></script></div>
<?php echo $footer; ?>