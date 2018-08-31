<div class="row">
  <div class="col-md-6">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Group")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid)?>
    </div>
  </div>
  <div class="col-md-6" id="form-utama">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Code")?></label>
              <?php 
              print $this->form_eksternal->form_input('', "", 'v-model="code" class="form-control input-sm" placeholder="'.lang("Code").'"');
              ?>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Title")?></label>
              <?php 
              print $this->form_eksternal->form_input('', "", 'v-model="title" class="form-control input-sm" placeholder="'.lang("Title").'"');
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
        <button type="button" v-on:click="update" class="btn btn-primary btn-sm"><?php print lang("Update")?></button>
      </div>
      <div class="overlay" id="page-loading-post" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-teams" data-toggle="tab" class="tab-files" ><?php print lang("Teams")?></a></li>
        <li><a href="#tab-approval" data-toggle="tab" class="tab-files" ><?php print lang("Approval")?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane" id="tab-approval">
          <?php
          $this->load->view("achild/approval");
          ?>
        </div>
        <div class="tab-pane active" id="tab-teams">
          <?php
          $this->load->view("achild/teams");
          ?>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
print $this->global_format->standart_component_theme();
?>