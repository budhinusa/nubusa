<?php print $this->form_eksternal->form_open_multipart("", 'role="form"', 
      array("id_detail" => $detail[0]->id_front_banner_promosi))?>
    <div class="form-group">
      <div class="col-xs-6">
        <label class="control-label">Title</label>
      <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control input-sm" placeholder="Title"')?>
      </div>
      <div class="col-xs-6">
          <label class="control-label">Sub Title</label>
      <?php print $this->form_eksternal->form_input('sub_title', $detail[0]->sub_title, 'class="form-control input-sm" placeholder="Sub Title"')?>
      </div>
    </div>
    
    <div class="form-group">
      <div class="col-xs-6">
        <label class="control-label">Mulai</label>
      <?php print $this->form_eksternal->form_input('mulai', $detail[0]->mulai, 'class="form-control tanggal input-sm" placeholder="Mulai"')?>
      </div>
      <div class="col-xs-6">
          <label class="control-label">Akhir</label>
      <?php print $this->form_eksternal->form_input('akhir', $detail[0]->akhir, 'class="form-control tanggal input-sm" placeholder="Akhir"')?>
      </div>
    </div>
    <div class="form-group">
      <div class="col-xs-6">
        <label class="control-label">Sort</label>
      <?php print $this->form_eksternal->form_input('sort', $detail[0]->sort, 'class="form-control input-sm" placeholder="Sort"')?>
      </div>
      <div class="col-xs-6">
          <label class="control-label">Status</label>
      <?php print $this->form_eksternal->form_dropdown('status', array(1 => "Reguler", 2 => "Selalu Ada", 3 => "Cadangan", 4 => "Draft"), array($detail[0]->status), 'class="form-control input-sm"')?>
      </div>
    </div>
    <div class="form-group">
      <div class="col-xs-12">
        <label class="control-label">Gambar</label>
        <?php print $this->form_eksternal->form_upload('file', $detail[0]->file, "class='form-control input-sm'");
        if($detail[0]->file)
          print "<br /><img src='".base_url()."files/umroh/slide2/{$detail[0]->file}' width='100' />";
        else
          print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
        ?>
      </div>
    </div>
    <div class="form-group">
      <div class="col-xs-12">
        <label class="control-label">Note</label>
        <?php 
        print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control input-sm" placeholder="Note" id="editor2"');
        ?>
      </div>
    </div>
    <div class="form-group">
      <div class="col-xs-6">
        <hr />
        <button class="btn btn-primary" type="submit">Save changes</button>
        <a href="<?php print site_url("front/banner")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
      </div>
    </div>
</form>