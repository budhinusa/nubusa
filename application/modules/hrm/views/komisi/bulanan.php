<div class="row">
  <div class="col-md-4">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Bulan")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid_bulanan)?>
        <div class="overlay" id="page-loading-post-bulanan" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
      
  </div>
    <div class="col-md-8">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Driver & Helper")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid_crew)?>
      <div class="overlay" id="page-loading-post-driver-helper" style="display: none">
      <i class="fa fa-refresh fa-spin"></i>
    </div>
  </div>
</div>
