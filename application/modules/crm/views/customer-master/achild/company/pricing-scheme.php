<div class="row">
  <div class="col-md-12">
    <div class="box box-warning box-solid" id="form-pricing-scheme">
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-6">
              <label><?php
              print lang("Market Price");
              ?></label><br />
              <checktoggle v-model="type" data-toggle="toggle" data-onstyle="success" data-offstyle="info" data-size="mini">
              </checktoggle>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Margin")?> <small><?php print lang("Percentage")?></small></label>
              <input type="number" name="margin" v-model="margin" value="" placeholder="<?php print lang("Margin")?>" class="form-control input-sm">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Management Fee")?> <small><?php print lang("Percentage")?></small></label>
              <input type="number" name="fee" v-model="fee" value="" placeholder="<?php print lang("Management Fee")?>" class="form-control input-sm">
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Set")?></button>
      </div>
      <div class="overlay" id="page-loading-post" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>