<div class="row">
  <div class="col-md-12" id="pesan">
  </div>
  <div class="col-md-6">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Outlet")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <table id="tableboxy" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><?php print lang("Title")?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Users")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <table id="tableboxy-users" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><?php print lang("Name")?></th>
              <th><?php print lang("Email")?></th>
              <th><?php print lang("Privilege")?></th>
              <th><?php print lang("Option")?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Users")?></label>
              <?php 
              print $this->form_eksternal->form_input('users', "", 'id="users" class="form-control input-sm" placeholder="'.lang("Title").'"');
              print $this->form_eksternal->form_input('id_scm_outlet', "", 'id="id-scm-outlet" style="display: none"');
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="overlay" id="form-loading" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>