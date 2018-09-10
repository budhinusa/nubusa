<div class="row">
  <div class="col-md-6">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Inventory")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid_inventory)?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12">
              <div class="grid-table">
                <div class="grid-head">
                  <div class="grid-tr">
                    <div class="grid-th"><?php print lang("Inventory")?></div>
                    <div class="grid-th"><?php print lang("Qty")?></div>
                    <div class="grid-th"><?php print lang("HPP")?></div>
                    <div class="grid-th"></div>
                  </div>
                </div>
                <div class="grid-body" id="tempat-hpp">
                  <div id="setelah-hpp"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <?php 
        print $this->form_eksternal->form_input('', "", 'style="display: block" id="id_crm_storage"');
        ?>
        <button type="button" class="btn btn-info btn-sm" id="rg-create"><?php print lang("Add New")?></button>
        <button type="button" class="btn btn-primary btn-sm" id="rg-update"><?php print lang("Update")?></button>
      </div>
      <div class="overlay" id="rg-form-loading" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>