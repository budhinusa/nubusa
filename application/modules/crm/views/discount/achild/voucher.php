<div class="row">
  <div class="col-md-8">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Voucher")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php 
      print $this->global_format->html_grid($grid_voucher)
        ?>
    </div>
  </div>
  <div class="col-md-4" id="form-voucher">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Voucher")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Code")?></label>
              <?php 
              print $this->form_eksternal->form_input('title', "", 'v-model="title" class="form-control input-sm" placeholder="'.lang("Code").'"');
              ?>
            </div>
            <div class="col-xs-12">
              <label><?php print lang("Start Date")?></label><br />
              <datetimesingle type="text" v-model="startdate" class="form-control input-sm">
              </datetimesingle>
            </div>
            <div class="col-xs-12">
              <label><?php print lang("End Date")?></label><br />
              <datetimesingle type="text" v-model="enddate" class="form-control input-sm">
              </datetimesingle>
            </div>
            <div class="col-xs-12">
              <label><?php print lang("Type")?></label>
              <?php
              $type = $this->global_variable->crm_discount_voucher_type();
              print $this->form_eksternal->form_dropdown('', $type, array(), 'v-model="type" class="form-control input-sm"');
              ?>
            </div>
            <div class="col-xs-12">
              <label><?php print lang("Limit")?></label>
              <input type="number" v-model="batas" value="" placeholder="<?php print lang("Limit")?>" class="form-control input-sm">
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        
        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
        <!--<button type="button" v-on:click="update" class="btn btn-success btn-sm"><i class="fa fa-fw fa-check"></i> <?php print lang("Commit")?></button>-->
        
      </div>
      <div class="overlay" id="page-loading-voucher" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>

<!--<script type="text/x-template" id="select2-template">
  <select>
    <slot></slot>
  </select>
</script>-->
<?php
//print $this->global_format->standart_component_theme();

?>