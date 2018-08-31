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
              <th><?php print lang("Code")?></th>
              <th><?php print lang("Name")?></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($data AS $key => $dt){
              print "<tr isi='{$key}'>"
                . "<td>{$key}</td>"
                . "<td>{$dt->name}</td>"
              . "</tr>";
            }
            ?>
          </tbody>
        </table>
        <button type="button" id="new" class="btn btn-info btn-sm">Add New</button>
      </div>
<!--      <div class="overlay" id="page-loading" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>-->
    </div>
  </div>
  <div class="col-md-6">
    <?php
    print $this->form_eksternal->form_open();
    ?>
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Account")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="box-body">
          <div class="form-group">
            <div class="row">
              <div class="col-xs-12">
                <label><?php print lang("Code")?></label>
                <?php 
                print $this->form_eksternal->form_input('code', "", 'id="code" class="form-control input-sm" placeholder="'.lang("Code").'"');
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <label><?php print lang("Table")?></label>
                <?php 
                print $this->form_eksternal->form_input('table', "", 'id="table" class="form-control input-sm"');
                ?>
              </div>
              <div class="col-xs-6">
                <label><?php print lang("Title")?></label>
                <?php 
                print $this->form_eksternal->form_input('title', "", 'id="title" class="form-control input-sm"');
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <label><?php print lang("ID")?></label>
                <?php 
                print $this->form_eksternal->form_input('id', "", 'id="id" class="form-control input-sm"');
                ?>
              </div>
              <div class="col-xs-6">
                <label><?php print lang("Label ID")?></label>
                <?php 
                print $this->form_eksternal->form_input('label_id', "", 'id="label-id" class="form-control input-sm"');
                ?>
              </div>
            </div>
            
          </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" id="simpan" class="btn btn-primary btn-sm"><?php print lang("Submit")?></button>
        </div>
      </div>
      <div class="overlay" id="form-loading" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
    <?php
    print $this->form_eksternal->form_close();
    ?>
  </div>
</div>