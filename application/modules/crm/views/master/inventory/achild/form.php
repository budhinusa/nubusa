
  <div class="col-md-6" id="form-utama">
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
            <div class="col-xs-6">
              <label><?php print lang("Code")?></label>
              <?php 
              print $this->form_eksternal->form_input('', "", 'v-model="code" class="form-control input-sm" placeholder="'.lang("Code").'"');
              ?>
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
              <label><?php print lang("Groups")?></label>
              <select2 :options="options_groups" v-model="id_crm_inventory_groups" class="form-control input-sm">
              </select2>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Satuan Groups")?></label>
              <select2 :options="options_satuan" v-model="id_crm_satuan_groups" class="form-control input-sm">
              </select2>
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
        <button type="button" v-on:click="update" class="btn btn-primary btn-sm"><?php print lang("Update")?></button>
      </div>
      <div class="overlay" id="form-loading" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>