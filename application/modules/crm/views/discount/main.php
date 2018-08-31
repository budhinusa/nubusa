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
</div>

<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#form-discount" data-toggle="tab"><?php print lang("Form")?></a></li>
        <li class="need-approve"><a href="#form-approve" data-toggle="tab"><?php print lang("Approve")?></a></li>
        <li class="need-merchandise"><a href="#form-merchandise" data-toggle="tab"><?php print lang("Merchandise")?></a></li>
        <li class="need-block-date"><a href="#tab-block-date" data-toggle="tab"><?php print lang("Block Date")?></a></li>
        <li class="need-company"><a href="#form-company" data-toggle="tab"><?php print lang("Company")?></a></li>
        <li class="need-payment-channel" style="display: none"><a href="#tab-payment-channel" data-toggle="tab"><?php print lang("Payment Channel")?></a></li>
        <li class="need-voucher" style="display: none"><a href="#tab-voucher" data-toggle="tab"><?php print lang("Vouchers")?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="form-discount">
          <div class="row">
            <div class="col-md-12" id="form-utama">
              <div class="box box-warning box-solid">
                <div class="box-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-6">
                        <label><?php print lang("Name")?></label>
                        <?php 
                        print $this->form_eksternal->form_input('title', "", 'v-model="title" class="form-control input-sm" placeholder="'.lang("Title").'"');
                        ?>
                      </div>
                      <div class="col-xs-6">
                        <label><?php print lang("Code")?></label>
                        <?php 
                        print $this->form_eksternal->form_input('code', "", 'v-model="code" class="form-control input-sm" placeholder="'.lang("Code").'"');
                        ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        <label><?php print lang("Name in Print")?></label>
                        <?php 
                        print $this->form_eksternal->form_input('nameinprint', "", 'v-model="nameinprint" class="form-control input-sm" placeholder="'.lang("Name in print").'"');
                        ?>
                      </div>
					</div>
					<div class="row">  
					  <div class="col-xs-6">
                        <label><?php print lang("Date Range")?></label><br />
                        <checktoggle v-model="bataswaktu" data-toggle="toggle" data-size="mini">
                        </checktoggle>
                        <br />
                        <br />
                        <datetime type="text" v-model="tanggal" class="form-control input-sm" v-bind:class="[bataswaktu ? '' : 'tutupi']">
                        </datetime>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        <label><?php print lang("Editable")?></label><br />
                        <?php
                        $status = $this->global_variable->status();
                        $option = $this->global_variable->option();
                        ?>
                        <checktoggle v-model="editable" data-toggle="toggle" data-on="<?php print $status[1]?>" data-off="<?php print $status[2]?>" data-onstyle="success" data-offstyle="danger" data-size="mini">
                        </checktoggle>
                      </div>
                      <div class="col-xs-4">
                        <label><?php print lang("Type")?></label><br />
                        <?php
                        $type = $this->global_variable->crmpos_discount_type();
                        ?>
                        <checktoggle v-model="type" data-toggle="toggle" data-on="<?php print $type[1]?>" data-off="<?php print $type[2]?>" data-onstyle="info" data-offstyle="success" data-size="mini">
                        </checktoggle>
                      </div>
                      <div class="col-xs-4">
                        <label><?php print lang("Value")?></label>
                        <input type="number" name="nilai" v-model="nilai" value="" placeholder="<?php print lang("Nilai")?>" class="form-control input-sm">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        <label><?php print lang("Approve")?></label><br />
                        <checktoggle v-model="approve" data-toggle="toggle" data-on="<?php print $status[1]?>" data-off="<?php print $status[2]?>" data-onstyle="success" data-offstyle="danger" data-size="mini">
                        </checktoggle>
                      </div>
                      <div class="col-xs-4">
                        <label><?php print lang("Gradual")?></label><br />
                        <checktoggle v-model="gradual" class="form-control input-sm" data-toggle="toggle" data-on="<?php print $status[1]?>" data-off="<?php print $status[2]?>" data-onstyle="success" data-offstyle="danger" data-size="mini">
                        </checktoggle>
                      </div>
                      <div class="col-xs-4">
                        <label><?php print lang("Sort")?></label>
                        <input type="number" name="sort" v-model="sort" value="" placeholder="<?php print lang("Sort")?>" class="form-control input-sm">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        <label><?php print lang("Merchandise")?></label><br />
                        <checktoggle v-model="merchandise" data-toggle="toggle" data-on="<?php print $status[1]?>" data-off="<?php print $status[2]?>" data-onstyle="success" data-offstyle="danger" data-size="mini">
                        </checktoggle>
                      </div>
                      <div class="col-xs-4">
                        <label><?php print lang("Cash Back")?></label><br />
                        <checktoggle v-model="cashback" data-toggle="toggle" data-on="<?php print $status[1]?>" data-off="<?php print $status[2]?>" data-onstyle="success" data-offstyle="danger" data-size="mini">
                        </checktoggle>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        <label><?php print lang("Is Company")?></label><br />
                        <checktoggle v-model="is_company" data-toggle="toggle" data-on="<?php print $option[1]?>" data-off="<?php print $option[2]?>" data-onstyle="success" data-offstyle="danger" data-size="mini">
                        </checktoggle>
                      </div>
                      <div class="col-xs-4">
                        <label><?php print lang("Is Payment Channel")?></label><br />
                        <checktoggle v-model="is_payment_channel" data-toggle="toggle" data-on="<?php print $status[1]?>" data-off="<?php print $status[2]?>" data-onstyle="success" data-offstyle="danger" data-size="mini">
                        </checktoggle>
                      </div>
                      <div class="col-xs-4">
                        <label><?php print lang("Is Voucher")?></label><br />
                        <checktoggle v-model="is_voucher" data-toggle="toggle" data-on="<?php print $status[1]?>" data-off="<?php print $status[2]?>" data-onstyle="success" data-offstyle="danger" data-size="mini">
                        </checktoggle>
                      </div>
                      <div class="col-xs-4">
                        <label><?php print lang("Minimum")?></label>
                        <input type="number" v-model="minimum" value="" placeholder="<?php print lang("Minimum")?>" class="form-control input-sm">
                      </div>
                      <div class="col-xs-4">
                        <label><?php print lang("Maximum")?></label>
                        <input type="number" v-model="maximum" value="" placeholder="<?php print lang("Maximum")?>" class="form-control input-sm">
                      </div>
                    </div>  
					<div class="row">
                      <div class="col-xs-12">
					     <br />						 
						 <br />
					  </div>
					</div> 
                    <div class="row">
                      <div class="col-xs-12">
                        <label><?php print lang("Note")?></label><br />
                        <ckeditor v-model="note" class="form-control input-sm" id="note1">
                        </ckeditor>
                        <?php
          //              print $this->form_eksternal->form_textarea('note', "", 'id="test-data" class="form-control input-sm"');
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
        </div>
        <div class="tab-pane" id="form-approve">
          <div class="row">
            <div class="col-md-6">
              <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php print lang("Privilege")?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <?php print $this->global_format->html_grid($grid_privilege)?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-warning box-solid" id="form-privilege">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php print lang("Form Privilege")?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12">
                        <label><?php print lang("Approval Settings")?></label>
                        <select v-model="id_crm_pos_approval_settings" class="form-control input-sm">
                          <option v-for="op in options_approval" v-bind:value="op.id">{{op.text}}</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <label><?php print lang("Nilai")?> <small>lebih kecil atau sama dengan</small></label>
                        <input type="number" name="nilai" v-model="nilai" value="" placeholder="<?php print lang("Nilai")?>" class="form-control input-sm">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="box-footer">
                  <button type="button" v-on:click="add_new" class="btn btn-info btn-sm"><?php print lang("Add New")?></button>
                </div>
                <div class="overlay" id="page-loading-post" style="display: none">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="form-merchandise">
          <div class="row">
            <div class="col-md-6">
              <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php print lang("Effect")?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
				
                </div>
                <?php print $this->global_format->html_grid($grid_merchandise_hasil)?>
				<div class="box-footer">
					<button type="button" v-on:click="removed_all" class="btn btn-danger btn-sm removed_all"><?php print lang("Removed All")?></button>
				</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-info box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php print lang("Merchandise")?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
				    
                  
                <?php print $this->global_format->html_grid($grid_merchandise)?>
				<div class="box-footer">
					<button type="button" v-on:click="add_all" class="btn btn-success btn-sm add_all"><?php print lang("Add All")?></button>
				</div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="tab-block-date">
          <?php
          $this->load->view("achild/block-date");
          ?>
        </div>
        <div class="tab-pane" id="form-company">
          <?php
          $this->load->view("achild/company");
          ?>
        </div>
        <div class="tab-pane" id="tab-payment-channel">
          <?php
          $this->load->view("achild/payment-channel");
          ?>
        </div>
        <div class="tab-pane" id="tab-voucher">
          <?php
          $this->load->view("achild/voucher");
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!--template-->
<script type="text/x-template" id="detapicker-template">
  <input>
    <slot></slot>
  </input>
</script>
<script type="text/x-template" id="ckeditor-template">
  <textarea>
  </textarea>
</script>
<script type="text/x-template" id="checktoggle-template">
  <input type="checkbox">
  </input>
</script>
<script type="text/x-template" id="select2-template">
  <select>
    <slot></slot>
  </select>
</script>

<?php
print $this->global_format->standart_component_theme();
?>