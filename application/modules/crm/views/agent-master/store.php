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
  <div class="col-md-12">
    <div class="box box-warning box-solid" id="form-utama">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Store")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Title")?></label>
              <?php 
              print $this->form_eksternal->form_input('title', "", 'v-model="title" class="form-control input-sm" placeholder="'.lang("Title").'"');
							print $this->form_eksternal->form_input('id_crm_agent_store', "", 'id="id_crm_agent_store" v-model="id_crm_agent_store" style="display: none"');
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Code")?></label>
              <?php 
              print $this->form_eksternal->form_input('code', "", 'v-model="code" class="form-control input-sm" placeholder="'.lang("Code").'"');
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Sort")?></label>
              <?php 
              print $this->form_eksternal->form_input('sort', "", 'v-model="sort" class="form-control input-sm" placeholder="'.lang("Sort").'"');
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Telp")?></label>
              <?php 
              print $this->form_eksternal->form_input('telp', "", 'v-model="telp" class="form-control input-sm" placeholder="'.lang("Telp").'"');
              ?>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Fax")?></label>
              <?php 
              print $this->form_eksternal->form_input('fax', "", 'v-model="fax" class="form-control input-sm" placeholder="'.lang("Fax").'"');
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Alamat")?></label>
              <?php 
              print $this->form_eksternal->form_textarea('address', "", 'v-model="address" class="form-control input-sm" placeholder="'.lang("Alamat").'"');
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
