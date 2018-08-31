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
        <h3 class="box-title"><?php print lang("Form Specification")?></h3>
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
              print $this->form_eksternal->form_input('title', "", 'id="title" v-model="title" class="form-control input-sm" placeholder="'.lang("Title").'"');
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

<div class="row" id="details" style="display: none">
  <div class="col-md-6">
    <div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Specification Details")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid2)?>
    </div>
  </div>
  <div class="col-md-6" id="form-details">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Specification Details")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Title")?></label>
              <?php 
              print $this->form_eksternal->form_input('title2', "", 'id="title2" v-model="title" class="form-control input-sm" placeholder="'.lang("Title").'"');
              ?>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Code")?></label>
              <?php 
              print $this->form_eksternal->form_input('code', "", 'id="code" v-model="code" class="form-control input-sm" placeholder="'.lang("Code").'"');
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-4">
              <label><?php print lang("Sort")?></label>
              <?php 
              print $this->form_eksternal->form_input('sort', "", 'id="sort" v-model="sort" class="form-control input-sm" placeholder="'.lang("Sort").'"');
              ?>
            </div>
            <div class="col-xs-8">
              <label><?php print lang("Type")?></label>
              <?php 
              $type = $this->global_variable->crm_pos_products_specification_type();
              print $this->form_eksternal->form_dropdown('type', $type, array(), 'id="type" v-model="type" class="form-control input-sm"');
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
        <button type="button" v-on:click="update" class="btn btn-primary btn-sm"><?php print lang("Update")?></button>
      </div>
      <div class="overlay" id="page-loading-post2" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>