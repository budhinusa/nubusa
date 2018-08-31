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
  <div class="col-md-12" id="form-utama">
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
              <label><?php print lang("File")?></label>
              <input type="file" name="file" id="file" class="form-control input-sm" /><br />
              <span v-html="gambar">
                
              </span>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Link")?></label>
              <?php 
              print $this->form_eksternal->form_input('', "", 'v-model="link" class="form-control input-sm" placeholder="'.lang("Link").'"');
              ?>
            </div>
          </div>
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
              <label><?php print lang("Type")?></label>
              <?php
              $type = $this->global_variable->cms_banner_promo_type();
              ?><br />
              <checktoggle v-model="type" data-toggle="toggle" data-onstyle="success" data-offstyle="info" data-size="mini" data-on="<?php print $type[1]?>" data-off="<?php print $type[2]?>">
              </checktoggle>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Sort")?></label>
              <input type="number" v-model="sort" class="form-control input-sm">
            </div>
           </div>
           <div class="row" v-bind:class="editable">
            <div class="col-xs-6">
              <label><?php print lang("Start Date")?></label>
              <datetimesingle type="text" v-model="startdate" class="form-control input-sm">
              </datetimesingle>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("End Date")?></label>
              <datetimesingle type="text" v-model="enddate" class="form-control input-sm">
              </datetimesingle>
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
      <div class="overlay" id="page-loading-post" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>
<?php
print $this->global_format->standart_component_theme();
?>