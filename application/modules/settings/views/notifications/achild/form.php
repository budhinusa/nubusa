<div class="row">
  <div class="col-md-12">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body" id='form-utama'>
        <div class="form-group">
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Tanggal")?></label>
              <datetimesingle v-model="tanggal" class="form-control input-sm">
              </datetimesingle>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Users")?></label>
              <select2 :options="options_users" id="select-users" v-model="id_users" class="form-control input-sm">
              </select2>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Link")?></label>
              <input type="text" v-model="link" class="form-control input-sm" />
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Code")?></label>
              <input type="text" v-model="code" class="form-control input-sm" />
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Title")?></label>
              <input type="text" v-model="title" class="form-control input-sm" />
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Note")?></label>
              <input type="text" v-model="note" class="form-control input-sm" />
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
          <button type="button" v-on:click="update" class="btn btn-warning btn-sm"><?php print lang("Update")?></button>
        </div>
        <div class="overlay" id="page-loading-post" style="display: none">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
print $this->global_format->standart_component_theme();
?>