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
        <h3 class="box-title"><?php print lang("Form Master Outlet")?></h3>
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
                print $this->form_eksternal->form_input('id_scm_outlet', "", 'id="id-scm-outlet" style="display: none"');
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <label><?php print lang("Alamat")?></label>
                <?php 
                print $this->form_eksternal->form_textarea('alamat', "", 'id="alamat" class="form-control input-sm" placeholder="'.lang("Alamat").'"');
                ?>
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

<div class="row" id="view-storage" style="display: none">
  <div class="col-md-6">
    <div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Storage")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <table id="tableboxy-storage" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><?php print lang("Title")?></th>
              <th><?php print lang("Type")?></th>
              <th><?php print lang("Option")?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <button type="button" id="new-storage" class="btn btn-info">Add New</button>
      </div>
<!--      <div class="overlay" id="page-loading" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>-->
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Storage")?></h3>
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
                print $this->form_eksternal->form_input('storage_title', "", 'id="storage-title" class="form-control input-sm" placeholder="'.lang("Title").'"');
                print $this->form_eksternal->form_input('id_scm_outlet_storage', "", 'id="id-scm-outlet-storage" style="display: none"');
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <label><?php print lang("Type")?></label>
                <?php 
                print $this->form_eksternal->form_dropdown('type', $this->global_variable->scm_storage_type(), array(), 'id="storage-type" class="form-control input-sm"');
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <label><?php print lang("Note")?></label>
                <?php 
                print $this->form_eksternal->form_textarea('note', "", 'id="storage-note" class="form-control input-sm" placeholder="'.lang("Note").'"');
                ?>
              </div>
            </div>
          </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
          <button type="button" id="simpan-storage" class="btn btn-primary">Submit</button>
        </div>
      </div>
      <div class="overlay" id="form-loading-storage" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>