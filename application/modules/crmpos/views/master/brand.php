<div class="row">
  <div class="col-md-12" id="pesan">
  </div>
  <div class="col-md-6">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print $title?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <table id="tableboxy" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><?php print lang("Picture")?></th>
              <th><?php print lang("Title")?></th>
              <th><?php print lang("Option")?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <button type="button" id="new" class="btn btn-info">Add New</button>
      </div>
<!--      <div class="overlay" id="page-loading" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>-->
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Master Brand")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="box-body">
          <div class="form-group">
            <div class="row">
              <div class="col-xs-12">
                <label><?php print lang("Title")?></label>
                <?php 
                print $this->form_eksternal->form_input('title', "", 'id="title" class="form-control input-sm" placeholder="'.lang("Title").'"');
                print $this->form_eksternal->form_input('id_scm_inventory_brand', "", 'id="id-scm-inventory-brand" style="display: none"');
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <label><?php print lang("Picture")?></label>
                <div class="input-group input-group-sm">
                  <?php 
                  print $this->form_eksternal->form_upload('picture', "", 'id="picture" class="form-control input-sm"');
                  ?>
                  <span class="input-group-btn">
                    <button type="button" id="clear" class="btn btn-danger btn-flat"><?php print lang("Clear")?></i></button>
                  </span>
                </div>
                <div id="field-picture"></div>
              </div>
            </div>
          </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
          <button type="button" id="simpan" class="btn btn-primary">Submit</button>
        </div>
      </div>
      <div class="overlay" id="form-loading" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>