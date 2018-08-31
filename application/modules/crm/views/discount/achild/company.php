<div class="row">
  <div class="col-md-8">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Group Customer")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid_group_customer)?>
    </div>
  </div>
  <div class="col-md-4" id="form-group-customer">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Group Customer")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <div class="row">
             <div class="col-xs-12">
              <label><?php print lang("Channel Type")?></label>
              <select2 :options="options_channel" id="select-channel" v-model="parent" class="form-control input-sm">
              </select2>
            </div>
           
          </div>
          <div class="row">
             <div class="col-xs-12">
            <label><?php print lang("Group Customer")?></label>
              <select2 :options="options_customer" id="select-customer" v-model="id_crm_customer_company" class="form-control input-sm">
              </select2>
            </div>
          
          </div>
         
        </div>
      </div>
      <div class="box-footer">
        
        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
        <!--<button type="button" v-on:click="update" class="btn btn-success btn-sm"><i class="fa fa-fw fa-check"></i> <?php print lang("Commit")?></button>-->
        
      </div>
      <div class="overlay" id="page-loading-group-customer" style="display: none">
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