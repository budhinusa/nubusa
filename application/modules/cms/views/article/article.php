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
				<li><a href="#tab_2" data-toggle="tab" id="tab_comment" style="display: none;"><?php print lang("Comment")?></a></li>
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
                      <div class="col-xs-6">
                        <label><?php print lang("Kategori")?></label>
                        <?php 
                        print $this->form_eksternal->form_dropdown('id_cms_kategori', $kategori, array(), 'id="id_cms_kategori" v-model="id_cms_kategori" class="form-control input-sm"');
                        ?>
                      </div>
											<div class="col-xs-6">
                        <label><?php print lang("Type")?></label>
                        <?php 
												$type = $this->global_variable->cms_article_type();
                        print $this->form_eksternal->form_dropdown('type', $type, array(), 'id="type" v-model="type" class="form-control input-sm"');
                        ?>
                      </div>
                    </div>
										<div class="row">
											<div class="col-xs-12">
												<label><?php print lang("Note")?></label><br />
												<ckeditor v-model="note" class="form-control input-sm" id="note1">
												</ckeditor>
											</div>
										</div>
                  </div>
                </div>
                <div class="box-footer">
                  <button type="button" v-on:click="add_new" class="btn btn-info btn-sm button_click"><?php print lang("Add New")?></button>
                  <button type="button" v-on:click="update" class="btn btn-primary btn-sm button_click"><?php print lang("Update")?></button>
                </div>
                <div class="overlay" id="page-loading-post" style="display: none">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
				<div class="tab-pane" id="tab_2">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php print lang("Comment")?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="nav-tabs-custom">
                    <div class="tab-content">
                      <div class="box box-solid">
                        <?php print $this->global_format->html_grid($grid2)?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="overlay" id="loading-form-picture" style="display: none">
                  <i class="fa fa-refresh fa-spin"></i>
                  <input type="file" id="file-manual" style="display: none" />
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.tab-pane -->
      </div>
    </div>
  </div>
</div>
<script type="text/x-template" id="ckeditor-template">
  <textarea>
  </textarea>
</script>