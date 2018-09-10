<div class="row">
  <div class="col-md-4">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Storage")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid)?>
    </div>
  </div>
  <div class="col-md-8">
  <div class="box box-success box-solid">
    <div class="box-header with-border">
      <h3 class="box-title"><?php print lang("RG")?></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <?php print $this->global_format->html_grid($grid_rg)?>
  </div>
</div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-rg" data-toggle="tab"><?php print lang("RG")?></a></li>
        <li><a href="#tab-stock" data-toggle="tab"><?php print lang("Stock")?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab-rg">
          <?php
          $this->load->view("achild/rg");
          ?>
        </div>
        <div class="tab-pane" id="tab-stock">
          <?php
          $this->load->view("achild/stock");
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
print $this->global_format->standart_component_theme();
?>