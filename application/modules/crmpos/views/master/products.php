<div class="row">
  <div class="col-md-6">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print $title?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <?php 
      print $this->global_format->html_grid($grid);
      ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-warning box-solid" id="form-utama">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print lang("Form Inventory")?></h3>
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
              <label><?php print lang("Categories")?></label>
              <select2 :options="options_status" v-model="id_crm_pos_products_categories" class="form-control input-sm">
              </select2>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Description")?></label>
              <?php 
              print $this->form_eksternal->form_textarea('description', "", 'v-model="description" class="form-control input-sm" placeholder="'.lang("Description").'"');
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
                      <div class="col-xs-2">
                        <label><?php print lang("Add on")?></label><br />
                        <checktoggle v-model="tambahan" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini">
                        </checktoggle>
                      </div>
                      <div class="col-xs-10">
                        <label><?php print lang("Title")?></label>
                        <?php 
                        print $this->form_eksternal->form_input('title', "", 'v-model="title" class="form-control input-sm" placeholder="'.lang("Title").'"');
                        ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-2">
                        <label><?php print lang("Editable")?></label><br />
                        <checktoggle v-model="editable" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini">
                        </checktoggle>
                      </div>
                      <div class="col-xs-10">
                        <label><?php print lang("Price")?></label>
                        <input type="number" v-model="harga" name="harga" value="" placeholder="<?php print lang("Price")?>" class="form-control input-sm">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-2">
                        <label><?php print lang("Limit")?></label><br />
                        <checktoggle v-model="type" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini">
                        </checktoggle>
                      </div>
                      <div class="col-xs-10">
                        <label><?php print lang("Qty")?></label>
                        <input type="number" v-model="qty" name="qty" value="" placeholder="<?php print lang("Qty")?>" class="form-control input-sm">
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

<script type="text/x-template" id="checktoggle-template">
  <input type="checkbox">
  </input>
</script>