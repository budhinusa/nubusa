<?php
if($this->session->flashdata('notice')){
?>
<section class="content-header">
  <div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> Filed!</h4>
    <?php print $this->session->flashdata('notice')?>.
  </div>
</section>
<?php
}
if($this->session->flashdata('success')){
?>
<section class="content-header">
  <div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>	<i class="icon fa fa-check"></i> Success!</h4>
    <?php print $this->session->flashdata('success')?>.
  </div>
</section>
<?php
}
if($this->session->flashdata('extent')){
?>
<section class="content-header">
  <div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-info"></i></h4>
    <?php print $this->session->flashdata('extent')?>.
  </div>
</section>
<?php
}
?>