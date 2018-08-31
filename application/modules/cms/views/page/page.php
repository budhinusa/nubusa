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
        <li class="active"><a href="#tab_1" data-toggle="tab"><?php print lang("Form")?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning box-solid">
                <div class="box-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12">
                        <label><?php print lang("Title")?></label>
                        <?php 
                        print $this->form_eksternal->form_input('title', "", 'id="title" v-model="title" class="form-control input-sm" placeholder="'.lang("Title").'"');
                        print $this->form_eksternal->form_input('id_cms_page', "", 'id="id_cms_page" v-model="id_cms_page" style="display: none"');
                        print $this->form_eksternal->form_input('title_file', "", 'id="title-file" v-model="title_file" style="display: none"');
												?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <label><?php print lang("Link")?></label>
                        <?php 
                        print $this->form_eksternal->form_input('link', "", 'id="link" v-model="link" class="form-control input-sm" placeholder="'.lang("Link").'"');
                        ?>
                      </div>
                    </div>
										<div class="row">
                      <div class="col-xs-12">
                        <label><?php print lang("File")?></label>
                        <?php print $this->form_eksternal->form_upload('file', "", "class='form-control input-sm'  @change='onGambarChange'");
												?>
												<img :src='title_file' width='100' />
                      </div>
                    </div>
										<div class="row">
                      <div class="col-xs-12">
                        <label><?php print lang("Status")?></label>
                        <?php 
												$status = array(1=>"Tidak Aktif", 2=>"Aktif");
                        print $this->form_eksternal->form_dropdown('status', $status, array(), 'id="status" v-model="status" class="form-control input-sm"');
                        ?>
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
      </div>
    </div>
  </div>
</div>
<script type="text/x-template" id="ckeditor-template">
  <textarea>
  </textarea>
</script>