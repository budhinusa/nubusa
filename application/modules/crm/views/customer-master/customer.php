<div class="row">
  <div class="col-md-12">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print $title?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php print $this->global_format->html_grid($grid)?>
    </div>
  </div>
  <div class="col-md-12">
    <div class="box box-warning box-solid" id="form-utama">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Customer")?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
        <?php 
        $dflg = "";
        $dno = 12;
        if($this->session->userdata("id") == 1){
            $dflg = 1;
            $dno = 6;
        }?>
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-<?php print $dno; ?>">
              <label><?php print lang("Company")?></label>
              <select2 :options="options_status" v-model="id_crm_customer_company" class="form-control input-sm">
              </select2>
            </div>
            <?php if($dflg == 1){?>  
            <div class="col-xs-6">
              <label><?php print lang("Users")?></label>
              <select2 :options="options_users" v-model="id_users" class="form-control input-sm">
              </select2>
            </div>
            <?php } ?>  
          </div>
          <div class="row">
            <div class="col-xs-3">
              <label><?php print lang("Title")?></label>
              <select2 :options="options_title" v-model="title" class="form-control input-sm">
              </select2>
            </div>
            <div class="col-xs-5">
              <label><?php print lang("Name")?></label>
              <?php 
              print $this->form_eksternal->form_input('name', "", 'v-model="name" class="form-control input-sm" placeholder="'.lang("Name").'"');
              ?>
            </div>
            <div class="col-xs-4">
              <label><?php print lang("Division")?></label>
              <?php 
              print $this->form_eksternal->form_input('division', "", 'v-model="division" class="form-control input-sm" placeholder="'.lang("Division").'"');
              ?>
            </div>  
          </div>
          <div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Telp")?></label>
              <?php 
              print $this->form_eksternal->form_input('telp', "", 'v-model="telp" class="form-control input-sm" placeholder="'.lang("Telp").'"');
              ?>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Email")?></label>
              <?php 
              print $this->form_eksternal->form_input('email', "", 'v-model="email" class="form-control input-sm" placeholder="'.lang("Email").'"');
              ?>
            </div>
          </div>
					<div class="row">
            <div class="col-xs-6">
              <label><?php print lang("Handphone")?></label>
              <?php 
              print $this->form_eksternal->form_input('handphone', "", 'v-model="handphone" class="form-control input-sm" placeholder="'.lang("handphone").'"');
              ?>
            </div>
            <div class="col-xs-6">
              <label><?php print lang("Fax")?></label>
              <?php 
              print $this->form_eksternal->form_input('fax', "", 'v-model="fax" class="form-control input-sm" placeholder="'.lang("fax").'"');
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Note")?></label>
              <?php 
              print $this->form_eksternal->form_textarea('note', "", 'v-model="note" class="form-control input-sm" placeholder="'.lang("Note").'"');
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
        <button type="button" v-on:click="update" class="btn btn-primary btn-sm"><?php print lang("Update")?></button>
      </div>
      <div class="overlay" id="page-loading-post" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>

<div class="row" id="inventory-detail" style="display: none">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#spec" data-toggle="tab"><?php print lang("Specification")?></a></li>
        <li><a href="#tab_2" data-toggle="tab" class="tab-files" ><?php print lang("Quantity")?></a></li>
        <li><a href="#tab_3" data-toggle="tab" class="tab-files" ><?php print lang("Package")?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="spec">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-warning box-solid">
                <div class="box-body" id="specification">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-6">
                        <label><?php print lang("Specification")?></label>
                        <select2 :options="options_status" v-model="id_crm_pos_products_specification" class="form-control input-sm">
                        </select2>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        <br />
                        <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Save")?></button>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <hr />
                  <div class="box-body">
                    <div class="form-group" id="form-specification">
                      
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="button" id="simpan-specification" class="btn btn-info btn-sm"><?php print lang("Save")?></button>
                  </div>
                </div>
                <div class="overlay" id="page-loading-post-specification" style="display: none">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
          <div class="row">
            <div class="col-md-6">
              <div class="box box-info box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php print lang("Quantity")?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <?php print $this->global_format->html_grid($grid_quantity)?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-warning box-solid" id="form-quantity">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php print lang("Form Quantity")?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-6">
                        <label><?php print lang("No Polisi")?></label>
                        <?php 
                        print $this->form_eksternal->form_input('title', "", 'v-model="title" class="form-control input-sm" placeholder="'.lang("No Polisi").'"');
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="box-footer">
                  <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
                  <button type="button" v-on:click="update" class="btn btn-primary btn-sm"><?php print lang("Update")?></button>
                </div>
                <div class="overlay" id="page-loading-quantity" style="display: none">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="tab_3">
          <div class="row">
            <div class="col-md-6">
              <div class="box box-info box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php print lang("Package")?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <?php print $this->global_format->html_grid($grid_merchandise)?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-warning box-solid" id="form-merchandise">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php print lang("Form Package")?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12">
                        <label><?php print lang("Title")?></label>
                        <?php 
                        print $this->form_eksternal->form_input('title', "", 'v-model="title" class="form-control input-sm" placeholder="'.lang("Title").'"');
                        ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <label><?php print lang("Price")?></label>
                        <input type="number" v-model="price" name="price" value="" placeholder="<?php print lang("Price")?>" class="form-control input-sm">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        <label><?php print lang("Interval")?></label>
                        <input type="number" v-model="interval" name="interval" value="" placeholder="<?php print lang("Interval")?>" class="form-control input-sm">
                      </div>
                      <div class="col-xs-6">
                        <label><?php print lang("Type")?></label>
                        <?php 
                        $type = $this->global_variable->crmpos_products_merchandise_type();
                        $type_transport = $this->global_variable->crmtrans_products_merchandise_type();
                        $status_website = $this->global_variable->crmtrans_products_merchandise_status();
                        print $this->form_eksternal->form_dropdown('type_transport', $type_transport, array(), 'v-model="type_transport" class="form-control input-sm"');
                        ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        <label><?php print lang("Qty")?></label>
                        <input type="number" v-model="qty" name="qty" value="" placeholder="<?php print lang("Qty")?>" class="form-control input-sm">
                      </div>
                      <div class="col-xs-6">
                        <label><?php print lang("Limit")?></label>
                        <?php 
                        print $this->form_eksternal->form_dropdown('type', $type, array(2), 'v-model="type" class="form-control input-sm"');
                        ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        <label><?php print lang("Publish")?></label>
                        <?php 
                        print $this->form_eksternal->form_dropdown('status_website', $status_website, array(), 'v-model="status_website" class="form-control input-sm"');
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="box-footer">
                  <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
                  <button type="button" v-on:click="update" class="btn btn-primary btn-sm"><?php print lang("Update")?></button>
                </div>
                <div class="overlay" id="page-loading-merchandise" style="display: none">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
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