<div class="row">
  <div class="col-md-6">
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
  <div class="col-md-6" id="form-deposit" style="display: none;">
    <div class="box box-warning box-solid" id="form-utama">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Type")?></label>
              <?php
              print $this->form_eksternal->form_dropdown("status", array(1 => lang("In"), 11 => lang("Out")), array(), 'v-model="status" class="form-control input-sm"');
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("deposit")?></label>
              <input type="number" v-model="deposit" class="form-control input-sm" />
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Note")?></label>
              <?php
              print $this->form_eksternal->form_textarea("note", "", 'v-model="note" class="form-control input-sm"');
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
      </div>
      <div class="overlay" id="page-loading-post" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12" id="list-log-deposit" style="display: none;">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#form-quotation" data-toggle="tab"><?php print lang("Log")?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="form-quotation">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php print lang("Log")?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <?php print $this->global_format->html_grid($grid_log)?>
              </div>
            </div>
          </div>
        </div><!-- /.tab-pane -->
      </div>
    </div>
  </div>
</div>



<!--template-->
<script type="text/x-template" id="select2-template">
  <select>
    <slot></slot>
  </select>
</script>

<script type="text/x-template" id="ckeditor-template">
  <textarea>
  </textarea>
</script>

<script type="text/x-template" id="daterangepicker-template">
  <input>
    <slot></slot>
  </input>
</script>