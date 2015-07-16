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
	        	<?php echo $text_block; ?>
	        </a></li>
	        <li><a href="#module" data-toggle="tab">
	        	<span class="fa fa-bars"></span> 
	        	<?php echo $text_module; ?>
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
								<span data-toggle="tooltip" title="" data-original-title="Enable SEO URL for your site.">
										Type of SEO url:              
								</span>
							</label>
							<div class="col-sm-6">
								<div class="radio">
                  
												<label for="shipping_method_input_style_radio" class="">
												  <input type="radio" value="radio" name="d_quickcheckout[step][shipping_method][input_style]" checked="checked" id="shipping_method_input_style_radio">
													canonical 
												</label>

												<label for="shipping_method_input_style_select" class="">
												  <input type="radio" value="select" name="d_quickcheckout[step][shipping_method][input_style]" id="shipping_method_input_style_select">
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
						   <span data-toggle="tooltip" title="" data-original-title="When there is a new version available, you can download it from the location you have purchased the module.">
							Do htaccess backup:               </span>
						  </label>
						  <div class="col-sm-2">
							<a id="version_check" class="btn btn-primary"> backup </a>
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
							<?php echo $entry_config_files; ?> 
							</span>
							</label>
							<div class="col-sm-4">
							  <select name="<?php echo $id;?>_setting[config]" id="input_config_file" class="form-control">
								<?php foreach ($config_files as $config_file) { ?>
								<option value="<?php echo $config_file; ?>"><?php echo $config_file; ?></option>
								<?php } ?>
							  </select>
							</div>
							<div class="col-sm-2">
								<a id="version_check" class="btn btn-primary"> re backup </a>
							</div>
						</div>
			        <?php } ?>
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-6">
						<div class="form-group">
						  <label class="col-sm-6 control-label" for="input-catalog-limit">
						   <span data-toggle="tooltip" title="" data-original-title="When there is a new version available, you can download it from the location you have purchased the module.">
							Change htaccess:               </span>
						  </label>
						  <div class="col-sm-2">
							<a id="htacess_change" class="btn btn-primary"> Change </a>
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
						<textarea name="d_quickcheckout[design][custom_style]" id="design_custom_style" class="form-control" rows="5"></textarea>
					</div>
				</div>
	      	</div>
	      	<div class="tab-pane" id="module" >
		      	<div class="tab-body">
		      		<table id="module" class="table table-striped table-bordered table-hover">
			            <thead>
			              <tr>
			                <td class="text-right">#</td>
			                <td class="text-left"><?php echo $entry_limit; ?></td>
			                <td class="text-left"><?php echo $entry_image; ?></td>
			                <td></td>
			              </tr>
			            </thead>
			            <tbody>
			              <?php $module_row = 1; ?>
			              <?php foreach ($modules as $module) { ?>
			              <tr id="module_row_<?php echo $module['key']; ?>">
			                <td class="text-right">
			                	<?php echo $module_row; ?>
			                </td>
			                <td class="text-left">
			                	<input type="text" name="<?php echo $id;?>_module[<?php echo $module['key']; ?>][limit]" value="<?php echo $module['limit']; ?>" placeholder="<?php echo $entry_limit; ?>" class="form-control" />
			                </td>
			                <td class="text-left">
			                	<input type="text" name="<?php echo $id;?>_module[<?php echo $module['key']; ?>][width]" value="<?php echo $module['width']; ?>" placeholder="<?php echo $entry_width; ?>" class="form-control" />
			                	<input type="text" name="<?php echo $id;?>_module[<?php echo $module['key']; ?>][height]" value="<?php echo $module['height']; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
			                </td>
			                <td class="text-left"><button type="button" onclick="$('#module_row_<?php echo $module['key']; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
			              </tr>
			              <?php $module_row++; ?>
			              <?php } ?>
			            </tbody>
			            <tfoot>
			              <tr>
			                <td colspan="3"></td>
			                <td class="text-left"><button type="button" onclick="addModule();" data-toggle="tooltip" title="<?php echo $button_module_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
			              </tr>
			            </tfoot>
			        </table>
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