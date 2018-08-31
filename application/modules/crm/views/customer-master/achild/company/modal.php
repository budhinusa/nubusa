<div id="modal-umum" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modal-umum-title"></h4>
      </div>
      <div class="modal-body">
        <p>
          <?php
          print $this->form_eksternal->form_textarea('note_umum', "", 'id="modal-umum-body" class="form-control input-sm"');
          print $this->form_eksternal->form_input('modal_umum_code', "", 'id="modal-umum-code" style="display: none"');
          print $this->form_eksternal->form_input('modal_umum_id', "", 'id="modal-umum-id" style="display: none"');
          print $this->form_eksternal->form_input('order_status', "", 'id="order-status" style="display: none"');
          ?>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="modal-umum-submit"><?php print lang("Submit")?></button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php print lang("Close")?></button>
      </div>
    </div>
  </div>
</div>