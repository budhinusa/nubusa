<div class="row">
  <div class="col-md-12" id="pesan">
  </div>
  <div class="col-md-6">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Satuan Group")?></h3>
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
        <h3 class="box-title"><?php print lang("Form Satuan Group")?></h3>
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
                print $this->form_eksternal->form_input('id_scm_satuan_group', "", 'id="id-scm-satuan-group" style="display: none"');
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <label><?php print lang("Note")?></label>
                <?php 
                print $this->form_eksternal->form_textarea('note', "", 'id="note" class="form-control input-sm" placeholder="'.lang("Note").'"');
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

<div class="row" id="view-satuan" style="display: none">
  <div class="col-md-6">
    <div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print $title?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <table id="tableboxy-satuan" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><?php print lang("Level")?></th>
              <th><?php print lang("Title")?></th>
              <th><?php print lang("Nilai")?></th>
              <th><?php print lang("Option")?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <button type="button" id="new-satuan" class="btn btn-info">Add New</button>
      </div>
<!--      <div class="overlay" id="page-loading" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>-->
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-warning box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Satuan")?></h3>
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
                print $this->form_eksternal->form_input('satuan_title', "", 'id="satuan-title" class="form-control input-sm" placeholder="'.lang("Title").'"');
                print $this->form_eksternal->form_input('id_scm_satuan', "", 'id="id-scm-satuan" style="display: none"');
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <label><?php print lang("Level")?></label>
                <?php 
                print $this->form_eksternal->form_input('satuan_level', "", 'id="satuan-level" class="form-control input-sm" placeholder="'.lang("Level").'"');
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <label><?php print lang("Nilai")?></label>
                <?php 
                print $this->form_eksternal->form_input('satuan_nilai', "", 'id="satuan-nilai" class="form-control input-sm harga" placeholder="'.lang("Nilai").'"');
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <label><?php print lang("Note")?></label>
                <?php 
                print $this->form_eksternal->form_textarea('satuan_note', "", 'id="satuan-note" class="form-control input-sm" placeholder="'.lang("Note").'"');
                ?>
              </div>
            </div>
          </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
          <button type="button" id="simpan-satuan" class="btn btn-primary">Submit</button>
        </div>
      </div>
      <div class="overlay" id="form-loading-satuan" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>