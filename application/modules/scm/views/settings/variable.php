<div class="row">
  <div class="col-md-12" id="form-utama">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Variable")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Alter Function After PO Confirm")?></label>
              <?php 
              print $this->form_eksternal->form_input('', "", 'v-model="scm_alter_po_confirm" class="form-control input-sm" placeholder="'.lang("Alter Function After PO Confirm").'"');
              ?>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("A/P Asset Account")?></label>
              <?php 
              print $this->form_eksternal->form_input('', "", 'v-model="site_transport_ap_po_account" class="form-control input-sm" placeholder="'.lang("A/P Asset Account").'"');
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("A/P Suppliers")?></label>
              <?php 
              print $this->form_eksternal->form_input('', "", 'v-model="site_transport_ap_suppliers" class="form-control input-sm" placeholder="'.lang("A/P Suppliers").'"');
              ?>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Satuan Fuel")?></label>
              <select2 :options="options_satuan" v-model="id_scm_satuan_fuel" class="form-control input-sm">
                <option disabled value=""><?php print lang("- Pilih -")?></option>
              </select2>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Save")?></button>
      </div>
      <div class="overlay" id="page-loading-post" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>
<script type="text/x-template" id="select2-template">
  <select>
    <slot></slot>
  </select>
</script>