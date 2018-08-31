<div class="row">
  <div class="col-md-6">
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
  <div class="col-md-6" id="form-utama">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form COA")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Code")?></label>
              <input min="1" max="9" type="number" v-model="code" class="form-control input-sm">
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Title")?></label>
              <?php 
              print $this->form_eksternal->form_input('title', "", 'v-model="title" class="form-control input-sm" placeholder="'.lang("Title").'"');
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Position")?></label>
              <?php 
              $position = $this->lokal_variable->frm_account_position();
              print $this->form_eksternal->form_dropdown('position', $position, array(), 'v-model="position" class="form-control input-sm"');
              ?>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Pos")?></label>
              <?php 
              $pos = $this->lokal_variable->frm_account_pos();
              print $this->form_eksternal->form_dropdown('pos', $pos, array(), 'v-model="pos" class="form-control input-sm"');
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
        <button type="button" v-on:click="update" class="btn btn-primary btn-sm"><?php print lang("Update")?></button>
      </div>
      <div class="overlay" id="page-loading-post" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>

<?php
print $this->global_format->standart_component_theme();
?>