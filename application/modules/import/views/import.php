

<div class="row">
  <div class="col-md-12">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Import</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
			<form id="form_store" action="<?php echo site_url('import/import_excel'); ?>" method="post" enctype='multipart/form-data'>
				<div class="box-body">
					<div class="form-group">
						<div class="row">
							<div class="col-xs-6">
								<label><?php print lang("First Row In Excel")?></label>
								<input type="number" class="form-control input-sm" name="first_row" id="first_row" />
							</div>
							<div class="col-xs-6">
								<label><?php print lang("File")?></label>
								<input type="file" class="form-control input-sm" name="file" id="file" />
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<input type="Submit" value="Submit" class="btn btn-info">
				</div>
			</form>
			<div class="overlay" id="page-loading-post" style="display: none">
				<i class="fa fa-refresh fa-spin"></i>
			</div>
    </div>
  </div>
</div>