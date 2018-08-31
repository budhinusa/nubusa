<?php print $this->form_eksternal->form_open("", 'class=" form-horizontal well ucase"', array("id_detail" => $id))?>
<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab"><?php print lang("Module")?></a></li>
        <li><a href="#tab_2" data-toggle="tab" id="tab_files"><?php print lang("Menu")?></a></li>
        <li><a href="#tab_3" data-toggle="tab" id="tab_files"><?php print lang("Costume")?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="row">
            <div class="col-md-12">
							<!-- Primary box -->
							<div class="box box-solid box-primary collapsed-box">
									<div class="box-header">
											<h3 class="box-title">Module</h3>
											<div class="box-tools pull-right">
													<span class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-plus"></i></span>
											</div>
									</div>
									<div class="box-body" style="display: none;">
											<h4><input type="checkbox" class="simple" onclick="toggleChecked(this.checked, 'privilege_module')" /> Check / Uncheck All </h4>
											<fieldset id="privilege_menu">
														<?php
														if(is_array($detail[0])){
															foreach($detail[0] as $key => $dt){
				//                        print_r($privilege_module[0]);
																if($privilege_module[$key] == $dt->id_module)
																	$checklist = $this->form_eksternal->form_checkbox($dt->name, $dt->id_module, TRUE, 'class="simple privilege_module_input"');
																else
																	$checklist = $this->form_eksternal->form_checkbox($dt->name, $dt->id_module, FALSE, 'class="simple privilege_module_input"');
																echo "
																		<div class='col-md-6'>
																		<div class='box box-solid box-success collapsed-box'>
																			<div class='box-header'>
																					<h3 class='box-title'>{$dt->desc}</h3>
																					<div class='box-tools pull-right'>
																							<span class='btn btn-success btn-sm' data-widget='collapse'><i class='fa fa-plus'></i></span>
																					</div>
																			</div>
																			<div class='box-body' style='display: none;'>
																			<div class='col-md-12'><h4>{$checklist} Access </h4></div>";
																			
																			foreach($detail_controller[0] as $key2 => $dt2){
																				if($dt->id_module == $dt2->id_module){
															?>
																			<div class="col-md-6">
																				<!-- Info box -->
																				<div class="box box-solid box-danger collapsed-box">
																						<div class="box-header">
																								<h3 class="box-title"><?php print $dt2->name?></h3>
																								<div class="box-tools pull-right">
																										<span class="btn btn-danger btn-sm" data-widget="collapse"><i class="fa fa-plus"></i></span>
																										<!--<button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>-->
																								</div>
																						</div>
																						<div class="box-body" style="display: none;">
																								<input type="checkbox" class="simple" onclick="toggleChecked(this.checked, 'privilege_page<?php print $dt2->id_controller?>')" /> <b>Check / Uncheck All</b>
																								<fieldset id="privilege_menu">
																											<?php
																											foreach($detail_page[$dt2->id_controller] as $ky => $dp){
																												if($privilege_page[$dt2->id_controller][$ky] == $dp->id_page)
																													$checklist = $this->form_eksternal->form_checkbox("page_pv[]", $dp->id_page, TRUE, 'class="simple privilege_page'.$dt2->id_controller.'_input"');
																												else
																													$checklist = $this->form_eksternal->form_checkbox("page_pv[]", $dp->id_page, FALSE, 'class="simple privilege_page'.$dt2->id_controller.'_input"');
																											 print "{$checklist} {$dp->link} <br />";
																											}
																											?>
																								</fieldset>
																						</div>
																				</div>
																			</div>
																		
																		
																		
															<?php	
																				}
																			}
																echo	"
																					</div>
																				</div>
																			</div>";
															}
														}
														?>
											</fieldset>
									</div>
							</div>
            </div>
          </div>
        </div><!-- /.tab-pane -->
				<div class="tab-pane" id="tab_2">
          <div class="row">
            <div class="col-md-12">
							<!-- Info box -->
							<div class="box box-solid box-info collapsed-box">
									<div class="box-header">
											<h3 class="box-title">Menu</h3>
											<div class="box-tools pull-right">
													<span class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-plus"></i></span>
											</div>
									</div>
									<div class="box-body" style="display: none;">
											<input type="checkbox" class="simple" onclick="toggleChecked(this.checked, 'privilege_menu')" /> Check / Uncheck All
											<fieldset id="privilege_menu">
														<?php
														if(is_array($detail_menu[0])){
															foreach($detail_menu[0] as $key => $dt){
																if($privilege_menu[$key] == $dt->id_menu)
																	$checklist = $this->form_eksternal->form_checkbox("menu_pv[]", $dt->id_menu, TRUE, 'class="simple privilege_menu_input"');
																else
																	$checklist = $this->form_eksternal->form_checkbox("menu_pv[]", $dt->id_menu, FALSE, 'class="simple privilege_menu_input"');
																print "
															<h4>{$dt->name}</h4>
															{$checklist} Access Self <b>{$dt->id_menu}</b> Parent {$dt->parent} <br />";
															}
														}
														?>
											</fieldset>
									</div><!-- /.box-body -->
							</div><!-- /.box -->
            </div>
          </div>
        </div><!-- /.tab-pane -->
				<div class="tab-pane" id="tab_3">
          <div class="row">
            <div class="col-md-12">
								<!-- Info box -->
								<div class="box box-solid box-success collapsed-box">
										<div class="box-header">
												<h3 class="box-title">Costume</h3>
												<div class="box-tools pull-right">
														<span class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-plus"></i></span>
														<!--<button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>-->
												</div>
										</div>
										<div class="box-body" style="display: none;">
												<fieldset id="privilege_menu">
													<input type="checkbox" onclick="toggleChecked(this.checked, 'privilege_form')" class="simple" /> <b>Check / Uncheck All</b>
													<?php
														if(is_array($detail_form[0])){
															foreach($detail_form[0] as $key => $dt){
					//                        print_r($privilege_module[0]);
																if($privilege_form[$key] == $dt->id_form){
																	$checklist = $this->form_eksternal->form_checkbox($dt->name, $dt->id_form, TRUE, 'class="simple privilege_form_input"');
																}
																else{
																	$checklist = $this->form_eksternal->form_checkbox($dt->name, $dt->id_form, FALSE, 'class="simple privilege_form_input"');
																}
																if($privilege_form_add[$key] == $dt->id_form){
																	$checklist_add = $this->form_eksternal->form_checkbox($dt->name."_add", $dt->id_form, TRUE, 'class="simple privilege_form_input"');
																}
																else{
																	$checklist_add = $this->form_eksternal->form_checkbox($dt->name."_add", $dt->id_form, FALSE, 'class="simple privilege_form_input"');
																}
																print "
															<h4>{$dt->nicename}</h4>
																{$checklist} Access Edit <br>
																{$checklist_add} Access Add";
															}
														}
														?>
												</fieldset>
										</div><!-- /.box-body -->
								</div><!-- /.box -->
            </div>
          </div>
        </div><!-- /.tab-pane -->
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <button class="btn btn-primary" type="submit">Save changes</button>
    <a href="<?php print site_url("privilege")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
  </div>
</div>

</form>