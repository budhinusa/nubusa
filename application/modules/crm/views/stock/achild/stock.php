<div class="row">
  <div class="col-md-6">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Stock")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid_log_inventory)?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Stock History")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid_inventory)?>
    </div>
  </div>
</div>