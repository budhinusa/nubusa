<div id="negative-response" class="modal modal-danger fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="negative-response-title"></h4>
      </div>
      <div class="modal-body">
        <p id="negative-response-body"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div id="positif-response" class="modal modal-primary fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="positif-response-title"></h4>
      </div>
      <div class="modal-body">
        <p id="positif-response-body"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php print $url?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php print $url?>plugins/jQueryUI/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="<?php print $url?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php print $url?>dist/js/app.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" src="<?php print $url?>nubusa/js/simpletreemenu.js"></script>
<script type="text/javascript">

ddtreemenu.createTree("treemenu2", false);

function hilang(id){
  $("#anak_hilang_"+id).fadeToggle();
}

</script>
<?php print $foot;?>