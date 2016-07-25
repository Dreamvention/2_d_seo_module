<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
		<button id="save_and_stay" data-toggle="tooltip" title="<?php echo $button_save_and_stay; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>
        <button id="save_and_exit" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
	  </div>
      <h1><?php echo $heading_title; ?> <?php echo $version; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
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
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
			<ul  class="nav nav-tabs">
				<li class="active"><a href="#tab_setting" data-toggle="tab">
					<span class="fa fa-cog"></span> 
					<?php echo $text_settings; ?>
				</a></li>
				<li><a href="#tab_instruction" data-toggle="tab">
					<span class="fa fa-graduation-cap"></span> 
					<?php echo $text_instructions; ?>
				</a></li>
			</ul>
		
			<div class="tab-content">
				<div class="tab-pane active" id="tab_setting">
					<div class="tab-body">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
							<div class="col-sm-10">
								<select name="<?php echo $id; ?>_status" id="input_status" class="form-control">
								<?php if (${$id . '_status'}) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="button_update"><?php echo $entry_get_update; ?></label>
							<div class="col-sm-2">
								<a id="button_update" class="btn btn-primary btn-block"><i class="fa fa-refresh"></i> <?php echo $button_get_update; ?></a>
							</div>
							<div class="col-sm-8">
								<div id="notification_update"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_instruction">
					<div class="tab-body"><?php echo $text_instructions_full; ?></div>
				</div>
			</div>
		</form>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">

function showAlert(json) {
	$('.alert, .text-danger').remove();
	$('.form-group').removeClass('has-error');
						
	if (json['error']) {
		if (json['error']['warning']) {
			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
		}				
				
		for (i in json['error']) {
			var element = $('#input_' + i);
					
			if (element.parent().hasClass('input-group')) {
                $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
			} else {
				$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
			}
		}				
				
		$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
	}
			
	if (json['success']) {
		$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '  <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
	}
}
</script> 
<script type="text/javascript">

$('body').on('click', '#save_and_stay', function(){
    $.ajax( {
		type: 'post',
		url: $('#form').attr('action'),
		data: $('#form').serialize(),
		dataType: 'json',
		beforeSend: function() {
			$('#content').fadeTo('slow', 0.5);
		},
		complete: function() {
			$('#content').fadeTo('slow', 1);   
		},
		success: function(json) {
			showAlert(json);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
    });  
});
	
$('body').on('click', '#save_and_exit', function(){
    $.ajax( {
		type: 'post',
		url: $('#form').attr('action'),
		data: $('#form').serialize(),
		dataType: 'json',
		beforeSend: function() {
			$('#content').fadeTo('slow', 0.5);
		},
		complete: function() {
			$('#content').fadeTo('slow', 1);   
		},
		success: function(json) {
			showAlert(json);
			if (json['success']) location = '<?php echo $get_cancel; ?>';
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
    });  
});

$('body').on('click', '#button_update', function(){ 
    $.ajax({
		url: '<?php echo $get_update; ?>',
		type: 'post',
		dataType: 'json',

		beforeSend: function() {
			$('#button_update').find('.fa-refresh').addClass('fa-spin');
		},

		complete: function() {
			$('#button_update').find('.fa-refresh').removeClass('fa-spin');   
		},

		success: function(json) {
			console.log(json);

			if (json['error']){
				$('#notification_update').html('<div class="alert alert-danger m-b-none">' + json['error'] + '</div>')
			}

			if (json['warning']){
				$html = '';

				if (json['update']){
					$.each(json['update'] , function(k, v) {
						$html += '<div>Version: ' +k+ '</div><div>'+ v +'</div>';
					});
				}
				$('#notification_update').html('<div class="alert alert-warning alert-inline">' + json['warning'] + $html + '</div>')
			}

			if(json['success']){
				$('#notification_update').html('<div class="alert alert-success alert-inline">' + json['success'] + '</div>')
			} 
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
    })
});

</script>
<?php echo $footer; ?>