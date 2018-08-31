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
</div>
<?php
print $this->global_format->standart_component_theme();
$this->load->view("customer-master/achild/company/modal");
?>