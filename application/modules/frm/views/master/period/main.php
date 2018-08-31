<div class="row">
  <div class="col-md-12">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print $title?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" id="add-new-period"><i class="fa fa-plus"></i></button>
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid)?>
      <div class="overlay" id="list-loading-period" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>

<div id="form-add-new-period" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php print lang("Journal Period")?></h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Title")?></label>
              <input type="text" id="period-title" class="form-control input-sm" />
            </div>
          </div>
<!--          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Code")?></label>
              <input type="text" id="period-code" class="form-control input-sm" />
            </div>
          </div>-->
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Bulan")?></label>
              <?php 
              $bulan = $this->global_variable->bulan();
              print $this->form_eksternal->form_dropdown('', $bulan, array(date("m")), 'id="period-bulan" class="form-control input-sm"');
              ?>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Tahun")?></label>
              <input type="number" id="period-tahun" class="form-control input-sm" />
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="add-new-period-submit"><?php print lang("Submit")?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php print lang("Close")?></button>
      </div>
    </div>
  </div>
</div>

<?php
print $this->global_format->standart_component_theme();
?>