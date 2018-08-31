<div class="row">
  <div class="col-md-6">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Users")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid_detail)?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Users")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid_lokal)?>
      <div id="form-detail">
        <div class="box-footer">
          <div class="form-group">
            <div class="row">
              <div class="col-xs-12">
                <label><?php print lang("ID")?></label>
                <?php 
                print $this->form_eksternal->form_input('', "", 'v-model="id_users_partner" class="form-control input-sm" placeholder="'.lang("ID").'"');
                ?>
              </div>
            </div>
          </div>
          <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
        </div>
        <div class="overlay" id="page-loading-detail" style="display: none">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Users")?> <small><?php print site_url()?></small></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid_users)?>
      
    </div>
  </div>
</div>

