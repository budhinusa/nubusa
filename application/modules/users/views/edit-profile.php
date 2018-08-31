<div id="main-content">
  <div class="container-fluid">
    <div class="row-fluid">
			<div class=".span12 ">
				<div class="nonboxy-widget">
					<div class="widget-head">
						<h5><?php print $title?></h5>
					</div>
					<div class="widget-content">
						<div class="widget-box">
							<?php print $this->form_eksternal->form_open("", 'class=" form-horizontal well ucase"', 
                      array("id_detail" => $detail[0]->id_users, "id_relasi" => $id_relasi[0]))?>
								<fieldset>
									<legend>User Form</legend>
                  <?php
                  if($detail[0]->id_users > 0)
                    print '<fieldset id="addressa-form">';
                  else
                    print '<fieldset id="address-form">';
                  ?>
										<div class="control-group row">
											<div class="controls col-md-6">
											<label class="control-label">Email</label>
                        <?php print $this->form_eksternal->form_input('email', $detail[0]->email, 'class="form-control input-xlarge"')?>
											</div>
										</div>
										<div class="control-group row">
											<div class="controls col-md-6">
											<label class="control-label">Password</label>
                        <?php print $this->form_eksternal->form_password('pass', '', 'class="form-control input-xlarge"')?>
											</div>
										</div>
										<div class="control-group row">
											<div class="controls col-md-6">
											<label class="control-label">Re-Password</label>
                        <?php print $this->form_eksternal->form_password('repass', '', 'class="form-control input-xlarge"')?>
											</div>
										</div>
									</fieldset>
								</fieldset>
								<!--<span class="extend-bar"><a id="minus2" href="#" class="remove-element" title="Remove">Remove</a><a id="plus2" href="#" class="add-element" title="Add">Add</a></span>-->
								<br>
								<div class="form-actions">
									<button type="submit" class="btn btn-info">Save changes</button>
									<a class="btn btn-success" href="<?php print site_url("home")?>" class="btn"><?php print lang("cancel")?></a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
    </div>
  </div>
</div>