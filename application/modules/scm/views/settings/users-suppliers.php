<div class="row">
  <div class="col-md-12" id="pesan">
  </div>
  <div class="col-md-12">
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
              <th><?php print lang("Avatar")?></th>
              <th><?php print lang("Name")?></th>
              <th><?php print lang("Contact")?></th>
              <th><?php print lang("Suppliers")?></th>
              <th><?php print lang("Users")?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-success box-solid">
      <?php
      print $this->form_eksternal->form_open_multipart();
      ?>
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Biodata")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#biodata" data-toggle="tab" aria-expanded="true"><?php print lang("Information")?></a></li>
              <li class=""><a href="#users" data-toggle="tab" aria-expanded="false"><?php print lang("Users")?></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="biodata">
                <div class="box box-solid">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-6">
                        <label><?php print lang("Avatar")?></label>
                        <?php 
                        print $this->form_eksternal->form_upload('avatar', "", 'id="avatar" class="form-control input-sm"');
                        ?>
                        <div id="field-avatar"></div>
                      </div>
                      <div class="col-xs-6">
                        <label><?php print lang("Suppliers")?></label>
                        <?php 
                        $suppliers = $this->global_models->get_dropdown("scm_procurement_suppliers", "id_scm_procurement_suppliers", "title", false);
                        print $this->form_eksternal->form_dropdown('id_scm_procurement_suppliers', $suppliers, array(), 'id="id-scm-procurement-suppliers" class="form-control input-sm select2"');
                        ?>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-xs-6">
                        <label><?php print lang("First Name")?></label>
                        <?php 
                        print $this->form_eksternal->form_input('first_name', "", 'id="first-name" class="form-control input-sm" placeholder="'.lang("First Name").'"');
                        print $this->form_eksternal->form_input('id_scm_suppliers_biodata', "", 'id="id-scm-suppliers-biodata" style="display: none"');
                        ?>
                      </div>
                      <div class="col-xs-6">
                        <label><?php print lang("Last Name")?></label>
                        <?php print $this->form_eksternal->form_input('last_name', "", 'id="last-name" class="form-control input-sm" placeholder="'.lang("Last Name").'"');?>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-xs-6">
                        <label><?php print lang("Telp")?></label>
                        <?php 
                        print $this->form_eksternal->form_input('telp', "", 'id="telp" class="form-control input-sm harga"');
                        ?>
                      </div>
                      <div class="col-xs-6">
                        <label><?php print lang("Email")?></label>
                        <?php 
                        print $this->form_eksternal->form_input('email', "", 'id="email" class="form-control input-sm"');?>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-12">
                        <label><?php print lang("Note")?></label>
                        <?php print $this->form_eksternal->form_textarea('note', "", 'id="note" class="form-control input-sm" placeholder="'.lang("Note").'"');?>
                      </div>
                    </div>
                  </div>
                  <div class="overlay" id="biodata-loading" style="display: none">
                    <i class="fa fa-refresh fa-spin"></i>
                  </div>
                </div>
              </div>
              
              <div class="tab-pane" id="users">
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6">
                      <label><?php print lang("Name")?></label>
                      <?php 
                      print $this->form_eksternal->form_input('user_name', "", 'id="user-name" class="form-control input-sm" placeholder="'.lang("Name").'"');
                      print $this->form_eksternal->form_input('id_users', "", 'id="id-users" style="display: none"');
                      ?>
                    </div>
                    <div class="col-xs-6">
                      <label><?php print lang("Email")?></label>
                      <?php print $this->form_eksternal->form_input('user_email', "", 'id="user-email" class="form-control input-sm" placeholder="'.lang("Email").'"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label><?php print lang("Status")?></label>
                      <?php 
                      $status = $this->global_variable->status();
                      print $this->form_eksternal->form_dropdown('user_status', $status, array(), 'id="user-status" class="form-control input-sm"');
                      ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-6">
                      <label><?php print lang("Password")?></label>
                      <?php 
                      print $this->form_eksternal->form_password('user_pass', "", 'class="form-control input-sm" placeholder="'.lang("Password").'"');
                      ?>
                    </div>
                    <div class="col-xs-6">
                      <label><?php print lang("Re-Password")?></label>
                      <?php 
                      print $this->form_eksternal->form_password('user_repass', "", 'class="form-control input-sm" placeholder="'.lang("Password").'"');
                      ?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <button name="users" value="users" type="submit" id="users-update" style="display: none" class="btn btn-success">Update</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="box-footer">
        <button type="submit" id="new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
        <button type="button" id="update" class="btn btn-primary btn-sm"><?php print lang("Update")?></button>
      </div>
      <?php
      print $this->form_eksternal->form_close();
      ?>
    </div>
  </div>
</div>