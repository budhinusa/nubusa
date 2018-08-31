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

<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-notifications" data-toggle="tab"><?php print lang("Form")?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab-notifications">
          <?php
          $this->load->view("achild/form");
          ?>
        </div>
      </div>
    </div>
  </div>
</div>