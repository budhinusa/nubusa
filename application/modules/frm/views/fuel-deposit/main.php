<div class="row">
  <div class="col-md-4">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Vehicle")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid_vehicle)?>
    </div>
  </div>
  <div class="col-md-8" id="form-utama">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form In")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Tanggal")?></label>
              <datetimesingle type="text" v-model="tanggal" class="form-control input-sm">
              </datetimesingle>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Nominal")?></label>
              <?php 
              print $this->form_eksternal->form_input('', "", 'v-model="nominal" class="form-control input-sm" placeholder="'.lang("Nominal").'"');
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Note")?></label>
              <?php 
              print $this->form_eksternal->form_textarea('', "", 'v-model="note" class="form-control input-sm" placeholder="'.lang("Note").'"');
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
      </div>
      <div class="overlay" id="page-loading-post" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print $title?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid)?>
    </div>
  </div>
</div>
<?php
print $this->global_format->standart_component_theme();
?>

<div id="modal-fuel-deposit-confirm" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php print lang("Confirm for Fuel Deposit")?></h4>
      </div>
      <div class="modal-body">
        <div class="box-body">
          <div class="form-group">
            <div class="row">
              <div class="col-xs-6">
                <label><?php print lang("Number")?></label>
                <?php 
                print $this->form_eksternal->form_input('', "", 'v-model="number" class="form-control input-sm" placeholder="'.lang("Number").'"');
                ?>
              </div>
              <div class="col-xs-6">
                <label><?php print lang("Km")?></label>
                <?php 
                print $this->form_eksternal->form_input('', "", 'v-model="endkm" class="form-control input-sm" placeholder="'.lang("Km").'"');
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <label><?php print lang("Note")?></label>
                <?php 
                print $this->form_eksternal->form_textarea('', "", 'v-model="note" class="form-control input-sm" placeholder="'.lang("Note").'"');
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" v-on:click="add_new"><?php print lang("Submit")?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php print lang("Close")?></button>
      </div>
    </div>
  </div>
</div>