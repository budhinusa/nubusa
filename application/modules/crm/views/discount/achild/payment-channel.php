<div class="row">
  <div class="col-md-8">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Payment Channel")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php 
      print $this->global_format->html_grid($grid_payment_channel)
        ?>
    </div>
  </div>
  <div class="col-md-4" id="form-payment-channel">
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
              <label><?php print lang("Payment Channel")?></label>
              <?php
              $payment_channel = $this->global_models->get_dropdown("crm_payment_channel", "id_crm_payment_channel", "title", array("status" => 1));
              print $this->form_eksternal->form_dropdown('', $payment_channel, array(), 'v-model="id_crm_payment_channel" class="form-control input-sm"');
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        
        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
        <!--<button type="button" v-on:click="update" class="btn btn-success btn-sm"><i class="fa fa-fw fa-check"></i> <?php print lang("Commit")?></button>-->
        
      </div>
      <div class="overlay" id="page-loading-payment-channel" style="display: none">
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