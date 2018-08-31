<div class="row">
  <div class="col-md-6">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Employee")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <table id="tableboxy" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><?php print lang("Name")?></th>
              <th><?php print lang("Sruktural")?></th>
              <th><?php print lang("Fungsional")?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
<!--      <div class="overlay" id="page-loading" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>-->
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Struktural")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <table id="tableboxy-struktural" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><?php print lang("Code")?></th>
              <th><?php print lang("Sruktural")?></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
<!--      <div class="overlay" id="page-loading" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>-->
    </div>
  </div>
</div>

<?php print $this->form_eksternal->form_input("id_hrm_biodata", "", "style='display: none' id='id-hrm-biodata'")?>