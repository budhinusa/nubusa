<div class="row">
  <div class="col-md-12">
    <div class="box box-warning box-solid" id="form-utama">
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Code")?></label>
              <?php 
              print $this->form_eksternal->form_input('kode', "", 'id="kode" v-model="kode" class="form-control input-sm" placeholder="'.lang("Code").'"');
              ?>
            </div>
            <div class="col-xs-6">
              <label><?php 
			  
			  if(empty($parent)){
				$title = 'Channel Type';
				print lang($title); 
			  }else
			  {
				$title = 'Customer Name';  
				print lang($title); 
			  }
			  
			  ?></label>
              <?php 
              print $this->form_eksternal->form_input('title', "", 'id="title" v-model="title" class="form-control input-sm" placeholder="'.lang($title).'"');
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Address")?></label>
              <?php 
              print $this->form_eksternal->form_input('location', "", 'v-model="location" class="form-control input-sm" placeholder="'.lang("Address").'"');
              ?>
            </div>
            <div class="col-xs-6">
              <label><?php
              print lang("Utama");
              ?></label><br />
              <checktoggle v-model="utama" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini">
              </checktoggle>
            </div>
          </div>
        <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Telp")?></label>
              <?php 
              print $this->form_eksternal->form_input('telp', "", 'v-model="telp" class="form-control input-sm" placeholder="'.lang("Telp").'"');
              ?>
            </div>
            <?php if($parent){?> 
            <div class="col-xs-6">
              <label><?php print lang("Telp 2")?></label>
              <?php 
              print $this->form_eksternal->form_input('telp2', "", 'v-model="telp2" class="form-control input-sm" placeholder="'.lang("Telp2").'"');
              ?>
            </div>
             <?php } ?>
           <?php if(empty($parent)){?>                                 
            <div class="col-xs-6">
              <label><?php print lang("Category")?></label>
              <select2 :options="options_type" v-model="type" class="form-control input-sm">
              </select2>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Company Grouping")?></label>
              <select2 :options="options_company_grouping" v-model="company_grouping" class="form-control input-sm">
              </select2>
            </div>
           <?php } ?>                                  
          </div>
		  <?php if(($parent)){?>   
		  <div class="row">
		  <div class="col-xs-6">
              <label><?php print lang("Email")?></label>
              <?php 
              print $this->form_eksternal->form_input('email', "", 'v-model="email" class="form-control input-sm" placeholder="'.lang("Email").'"');
              ?>
            </div>
          </div>
		  <?php } ?>                                  
        </div>
      </div>
      <div class="box-footer">
        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
        <button type="button" v-on:click="update" class="btn btn-primary btn-sm"><?php print lang("Update")?></button>
      </div>
      <div class="overlay" id="page-loading-form-channel-type" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
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