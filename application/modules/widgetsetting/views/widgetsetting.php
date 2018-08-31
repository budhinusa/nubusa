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
    <div class="nav-tabs-custom" id="tab_files" style="display: none;">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab"><?php print lang("Select Widget")?></a></li>
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
												<input type="text" v-bind:id="id_users" v-bind:name="id_users" v-bind:value="id_users" style="display: none">
                      </div>
                    </div>
										<div class="row">
												<div class="col-xs-2" v-for="(widget, index) in widgets">
													<div class="box box-info box-solid">
														<div class="box-header with-border">
															<center>
															<div style="margin-bottom:5px;"><center>{{widget.title}}</center></div>
															<a v-bind:href="widget.title_file_link" target='_blank'>
															<img v-bind:src="widget.title_file" height="120px" width="130px"></img></a></br>
															<!--
															<input type="checkbox" v-bind:value="widget.id_m_widget" v-bind:name="widget.class" class="id_m_widget" :checked="widget.id_m_widget == widget.id_m_widget_val"
															v-model="id_widgets">
															
															<input type="checkbox" v-bind:value="widget.id_m_widget" name="id_m_widget" v-bind:id="widget.class" class="id_m_widget" v-if="widget.id_m_widget != widget.id_m_widget_val"
															@click="merge(widget.id_m_widget)">
															<input type="checkbox" v-bind:value="widget.id_m_widget" name="id_m_widget" v-bind:id="widget.class" class="id_m_widget" v-if="widget.id_m_widget == widget.id_m_widget_val" checked="checked" 
															@click="merge(widget.id_m_widget)">
															-->
															<input type="checkbox" v-bind:value="widget.id_m_widget" v-bind:name="widget.class" v-bind:id="widget.class" class="id_m_widget" :checked="widget.id_m_widget == widget.id_m_widget_val"
															@click="merge(widget.id_m_widget)" style="margin-top:10px">
															</center>
														</div>
												
													</div>
												</div>
                    </div>
                  </div>
                </div>
                <div class="box-footer">
                  <button type="button" v-on:click="update" class="btn btn-primary btn-sm"><?php print lang("Instal")?></button>
                </div>
                <div class="overlay" id="page-loading-post" style="display: none">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.tab-pane -->
      </div>
    </div>
  </div>
</div>
<script src="<?php print $url?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php print $url?>plugins/jQueryUI/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	// Array.prototype.unique = function() {
			// var a = this.concat();
			// for(var i=0; i<a.length; ++i) {
					// for(var j=i+1; j<a.length; ++j) {
							// if(a[i] === a[j])
									// a.splice(j--, 1);
					// }
			// }

			// return a;
	// };
	// var array1 = ["Vijendra","Singh"];
	// var array2 = ["Singh", "Shakya"];
	Merges both arrays and gets unique items
	// var array3 = array1.concat(array2).unique(); 
	
	// console.log(array3);
});
</script>