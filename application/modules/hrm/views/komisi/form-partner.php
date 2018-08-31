    <div class="row"> 
<div class="col-md-12">
    <div class="box box-warning box-solid" id="form-partner">
<!--      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Driver & Helper")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>-->
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-4">
              <label><?php print lang("Jalan")?></label>
              <?php 
              print $this->form_eksternal->form_input('jalan', "", 'v-model="jalan" class="form-control harga input-sm" placeholder="'.lang("Jalan").'"');
              ?>
            </div>
            <div class="col-xs-4">
              <label><?php print lang("Masuk")?></label>
              <?php 
              print $this->form_eksternal->form_input('masuk', "", 'v-model="masuk" class="form-control harga input-sm" placeholder="'.lang("Masuk").'"');
              ?>
            </div>
             <div class="col-xs-4">
              <label><?php print lang("Off")?></label>
              <?php 
              print $this->form_eksternal->form_input('npwp', "", 'v-model="off" class="form-control harga input-sm" placeholder="'.lang("Off").'"');
              ?>
            </div>  
          </div>
					
        </div>
      </div>
      <div class="box-footer">
        <button type="button" v-on:click="update" class="btn btn-primary btn-sm"><?php print lang("Update")?></button>
        <button type="button" v-on:click="posting" class="btn btn-success btn-sm pull-right"><?php print lang("Post")?></button>
      </div>
      <div class="overlay" id="page-loading-post-form-partner" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>    