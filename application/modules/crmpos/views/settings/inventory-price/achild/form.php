
  <div class="col-md-6">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Price")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid_price)?>
      <div class="box-body" id="form-utama">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Price")?></label>
              <number type="text" v-model="nominal" class="form-control input-sm">
              </number>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <br />
              <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Submit")?></button>
            </div>
          </div>
        </div>
      </div>
      <div class="overlay" id="form-loading" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>