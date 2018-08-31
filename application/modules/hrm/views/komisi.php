<div class="row"> 
<div class="col-md-12">
    <div class="box box-primary box-solid" id="form-utama">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Komisi")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Tahun")?></label>
             
              <?php
              $tahun1 = date('Y')-1;
              $tahun2 = date('Y');
              $arrtahun = array("{$tahun1}"=> "{$tahun1}",
                              "{$tahun2}" => "{$tahun2}");
             print $this->form_eksternal->form_dropdown('tahun', $arrtahun, "", 'v-model="tahun" id="tahun" class="form-control input-sm"');
             ?>
            </div>
              <div class="col-xs-6">
              <label><?php print lang("Bulan")?></label>
             <?php
             print $this->form_eksternal->form_dropdown('bulan', $this->global_variable->bulan(), "", 'v-model="bulan" id="bulan" class="form-control input-sm"');
                
             ?>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="button" v-on:click="search" class="btn btn-info btn-sm"><?php print lang("Search")?></button>
        <button type="button" v-on:click="add_new" class="btn pull-right btn-primary btn-sm"><?php print lang("Generate")?></button>
      </div>
      <div class="overlay" id="page-loading-post-utama" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view("komisi/bulanan");?>
<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#form-partner" data-toggle="tab"><?php print lang("Form Driver & Helper")?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="form-partner">
          <?php
          $this->load->view("komisi/form-partner");
          ?>
        </div>
      </div>
    </div>
  </div>
</div>