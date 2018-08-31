
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Transaction")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid_detail)?>
      <div id="form-utama">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <div class="row">
                <div class="col-xs-4">
                  <label><?php print lang("Account")?> <i style="display: none" id="account-loading" class="fa fa-refresh fa-spin"></i></label>
                  <select2 :options="options_account" v-model="id_frm_account" class="form-control input-sm">
                  </select2>
                </div>
                <div class="col-xs-2">
                  <label><?php print lang("Pos")?></label>
                  <?php
                  $pos = $this->lokal_variable->frm_account_pos();
                  ?><br />
                  <checktoggle v-model="pos" data-toggle="toggle" data-onstyle="primary" data-offstyle="success" data-size="mini" data-on="<?php print $pos[1]?>" data-off="<?php print $pos[2]?>">
                  </checktoggle>
                </div>
                <div class="col-xs-4">
                  <label><?php print lang("Nominal")?></label>
                  <number type="text" v-model="nominal" class="form-control input-sm">
                  </number>
                </div>
                <div class="col-xs-2">
                  <label>&nbsp;</label><br />
                  <button type="button" v-on:click="tambah" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6">
                  <label><?php print lang("Title")?></label>
                  <?php 
                  print $this->form_eksternal->form_input('title', "", 'v-model="title" class="form-control input-sm" placeholder="'.lang("Title").'"');
                  ?>
                </div>
                <div class="col-xs-6">
                  <label><?php print lang("Date")?></label>
                  <datetimesingle type="text" v-model="tanggal" class="form-control input-sm">
                  </datetimesingle>
                </div>
                <div class="col-xs-12">
                  <label><?php print lang("Note")?></label>
                  <ckeditor v-model="note" class="form-control input-sm" id="note1">
                  </ckeditor>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
        </div>
        <div class="overlay" id="transaksi-form-loading" style="display: none">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
      </div>
    </div>
  </div>
</div>