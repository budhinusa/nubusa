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
        <li><a href="#tab_2" data-toggle="tab" id="tab_files" style="display: none;"><?php print lang("Gambar")?></a></li>
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
                        print $this->form_eksternal->form_input('id_m_widget', "", 'id="id-m-widget" v-model="id_m_widget" style="display: none"');
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
                        <label><?php print lang("Note")?></label>
                        <?php 
                        print $this->form_eksternal->form_textarea('note', "", 'id="note" v-model="note" class="form-control input-sm" placeholder="'.lang("Note").'"');
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
        </div><!-- /.tab-pane -->
				<div class="tab-pane" id="tab_2">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php print lang("Picture")?></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="nav-tabs-custom">
                    <div class="tab-content">
                      <div class="box box-solid">
                        <?php print $this->global_format->html_grid($grid2)?>
                        <style>
                          #tempat-upload{
                              width:100%;
                              height:300px;
                              line-height:100px;
                              border:5px dashed #CCC;

                              font-family:Verdana;
                              text-align:center;
                          }
                        </style>
                        <div class="form-group" id="tempat-upload">
                          <?php print lang("Drop File Here");?>
                        </div>
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