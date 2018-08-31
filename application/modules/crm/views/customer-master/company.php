<div class="row">
  <div class="col-md-12">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print $title?></h3>
        <div class="box-tools pull-right">
					<!--- UNTUK FLAG PARENT --->
					<?php
						if(!empty($this->uri->segment(4))){
							$this->db->where('id_crm_customer_company', $this->uri->segment(4));
							$company = $this->db->get('crm_customer_company')->result();
					?>
						<label class="label label-success" style="font-size:12px;"><a href="<?php echo site_url('crm/customer-master/company/' . $company[0]->parent) ?>">Parent &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp; <?php echo $company[0]->title ?></a></label>
					<?php
						}else{
					?>
					<label class="label label-danger" style="font-size:12px;"><a href="<?php echo site_url('crm/customer-master/company') ?>">Parent &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp; Tidak Ada</a></label>
					<?php
						}
					?>
					<!--- UNTUK FLAG PARENT --->
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
        <li class="active"><a href="#form-company" data-toggle="tab"><?php print $form_company; ?></a></li>
        <li><a href="#pricing-scheme" data-toggle="tab" class="tab-files no-editable" ><?php print lang("Pricing Scheme")?></a></li>
    <?php if(empty($parent)){ ?><li><a href="#tab-discount" data-toggle="tab" class="tab-files" ><?php print lang("Discount")?></a></li>
        <!--<li><a href="#tab-company-grouping" data-toggle="tab" class="tab-files" ><?php print lang("Company Grouping")?></a></li> -->
            <?php }else{?>
    <li id="li-pic"><a href="#tab-pic" data-toggle="tab" class="tab-files" ><?php print lang("PIC")?></a></li> <?php } ?>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="form-company">
          <?php
          $this->load->view("customer-master/achild/company/form");
          ?>
        </div>
        
        <div class="tab-pane" id="pricing-scheme">
          <?php
          $this->load->view("customer-master/achild/company/pricing-scheme");
          ?>
        </div>
        <?php if(empty($parent)){?>
        <div class="tab-pane" id="tab-discount">
          <?php
          $this->load->view("customer-master/achild/company/discount");
          ?>
        </div>
<!--        <div class="tab-pane" id="tab-company-grouping">
          <?php
          $this->load->view("customer-master/achild/company/company-grouping");
          ?>
        </div>  -->
        <?php }else{ ?>
         <div class="tab-pane" id="tab-pic">
          <?php
          $this->load->view("customer-master/achild/company/pic");
          ?>
        </div> 
        <?php }?>  
      </div>
    </div>
  </div>
</div>
<?php
print $this->global_format->standart_component_theme();
$this->load->view("customer-master/achild/company/modal");
?>