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
  <div class="col-md-5" style="text-align: right">
    <div class="box box-info box-solid">
      <div class="box-body">
        <h3><?php print lang("Total")?></h3>
        <dl class="dl-horizontal">
          <dt><?php print lang("Debit")?></dt>
            <dd id="view-debit" style="font-weight: bold;"></dd>
          <dt><?php print lang("Credit")?></dt>
            <dd id="view-credit" style="font-weight: bold;"></dd>
          <hr />
          <dt><?php print lang("Saldo")?></dt>
          <dd id="view-total" style="font-weight: bold;"></dd>
        </dl>
      </div>
    </div>
  </div>
</div>
<?php
print $this->global_format->standart_component_theme();
?>