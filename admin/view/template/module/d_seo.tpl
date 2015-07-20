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
	        <li class="active"><a href="#setting" data-toggle="tab">
	        	<span class="fa fa-puzzle-piece"></span> 
	        	<?php echo $text_setting; ?>
	        </a></li>
	        <li><a href="#module" data-toggle="tab">
	        	<span class="fa fa-bars"></span> 
	        	<?php echo $text_snippet; ?>
	        </a></li>
	        <li><a href="#block" data-toggle="tab">
	        	<span class="fa fa-cog"></span> 
	        	<?php echo $text_seo; ?>
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
								 <select name="d_seo_status" id="input-status" class="form-control">
								 <?php if( $d_seo_status  ) {?>   
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0" ><?php echo $text_disabled; ?></option>
								 <?php }else{?>
										<option value="1" ><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected" ><?php echo $text_disabled; ?></option>
								 <?php } ?>
								</select>
							</div>
						  </div>
			            
			        </div>
			      
			           
	      		</div>
	      	</div>
	      	<div class="tab-pane " id="block" >
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
										<?php if( $type_seo_url == "canonical" ) {?>   
												<label for="url_type_canonical" class="">
												  <input type="radio" value="canonical" name="type_seo_url" checked="checked" id="url_type_canonical">
													canonical 
												</label>

												<label for="url_type_modified" class="">
												  <input type="radio" value="modified" name="type_seo_url" id="url_type_modified">
													modified					
												 </label>
										<?php } else { ?>
												<label for="url_type_canonical" class="">
												  <input type="radio" value="canonical" name="type_seo_url" id="url_type_canonical">
													canonical 
												</label>

												<label for="url_type_modified" class="">
												  <input type="radio" value="modified" name="type_seo_url" checked="checked"  id="url_type_modified">
													modified					
												 </label>
										<?php } ?>

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
						  <?php if ($backup_files) { ?>
						<div class="form-group">
							<label class="col-sm-6 control-label" for="input-status"> 
							<span data-toggle="tooltip" title="" data-original-title="When there is a new version available, you can download it from the location you have purchased the module.">
							  Restore .htaccess backup:   
							</span>
							</label>
							<div class="col-sm-4">
							  <select name="d_seo_htacess[backup]" id="input_backup_file" class="form-control">
								<?php foreach ($backup_files as $backup_file) { ?>
								<option value="<?php echo $backup_file; ?>"><?php echo $backup_file; ?></option>
								<?php } ?>
							  </select>
							</div>
							<div class="col-sm-2">
								<a id="restore_backup" class="btn btn-primary"> restore </a>
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
							<a id="htacess_change" class="btn btn-primary"> start</a>
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
						<textarea name="d_seo_htacess[htaccess]" id="design_custom_style" class="form-control" rows="20"><?php foreach ($htaccess_content as $line)
											echo $line;
							?></textarea>
						 
							<div class="col-sm-2" style="margin-top: 10px;">
								<a id="do_backup" class="btn btn-primary"> create </a>
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
									<label class="col-sm-3 control-label" for="input-meta-title1">Snippet Preview</label>
									<div class="col-sm-9">
										  <div id="wpseosnippet">
											<span class="title" id="wpseosnippet_title" >Page Title  <span><?php echo isset($d_seo_snipet[$language['language_id']]['separator']) ? $d_seo_snipet[$language['language_id']]['separator'] : $d_seo_snipet['separator']; ?></span></span>
											<span class="url"><?php  echo $_SERVER['HTTP_HOST']; ?>/url-of-page</span>
											<p class="desc"><span class="autogen"></span>
											<span class="content">
											Here You can see your meta description.  
											Which include 160 symbols from product or page description or 
											custom text which You insert in field "meta description"!</span></p>
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
							<div class="form-group">
								<label class="col-sm-6 control-label" for="input-snipet-separator">Separator</label>
								<div class="col-sm-6">
									<input type="text" name="d_seo_snipet[<?php echo $language['language_id']; ?>][separator]" maxlength="" value="<?php echo isset($d_seo_snipet[$language['language_id']]['separator']) ? $d_seo_snipet[$language['language_id']]['separator'] : $d_seo_snipet['separator']; ?>" placeholder="Separator" id="input-snipet-separator" class="form-control">
                                </div>
							</div>
						</div>
					     </div>
					<?php } ?>
						</div>
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
	$("#do_backup").on("click", function(){
		$.ajax({
			url: 'index.php?route=module/d_module/createHtaccessBackup&token=<?php echo $token; ?>',
			type: 'post',
			dataType: 'json',
			success: function( ) {
				 
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	})
	$("#restore_backup").on("click", function(){
		$.ajax({
			url: 'index.php?route=module/d_module/restoreHtaceessBackup&token=<?php echo $token; ?>',
			type: 'post',
			data: $('select#input_backup_file'),
			dataType: 'json',
			success: function( ) {
				 
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	})
	$('#input-snipet-separator').on("keyup", function(){
		$("#wpseosnippet_title span").text($(this).val());
	})
//--></script>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
$('#option a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>