<?php print $this->form_eksternal->form_open_multipart("", 'role="form"', 
      array("id_detail" => $detail[0]->id_front_banner))?>
    <div class="form-group">
      <div class="col-xs-6">
        <label class="control-label">Title</label>
      <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control input-sm" placeholder="Title"')?>
      </div>
      <div class="col-xs-6">
          <label class="control-label">Link</label>
      <?php print $this->form_eksternal->form_input('url', $detail[0]->url, 'class="form-control input-sm" placeholder="Link"')?>
      </div>
    </div>
    <div class="form-group">
      <div class="col-xs-4">
        <label class="control-label">Note 1</label>
        <?php print $this->form_eksternal->form_input('note1', $detail[0]->note1, 'class="form-control input-sm" placeholder="Note 1"')?>
      </div>
      <div class="col-xs-4">
          <label class="control-label">Note 2</label>
      <?php print $this->form_eksternal->form_input('note2', $detail[0]->note2, 'class="form-control input-sm" placeholder="Note 2"')?>
      </div>
      <div class="col-xs-4">
          <label class="control-label">Note 3</label>
      <?php print $this->form_eksternal->form_input('note3', $detail[0]->note3, 'class="form-control input-sm" placeholder="Note 3"')?>
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
          print "<br /><img src='".base_url()."files/umroh/banner/{$detail[0]->file}' width='100' />";
        else
          print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
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