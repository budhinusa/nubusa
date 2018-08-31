<div class="row">
  <div class="col-md-12">
    <div class="box box-warning box-solid" id="form-company-grouping">
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12">
              <label><?php print lang("Company Grouping")?></label>
              <select2 :options="options_company_grouping" v-model="company_grouping" class="form-control input-sm">
              </select2>
            </div>
          </div>
                                         
        </div>
      </div>
      <div class="box-footer">
        <button type="button" v-on:click="update" class="btn btn-primary btn-sm"><?php print lang("Update")?></button>
      </div>
      <div class="overlay" id="page-loading-form-company-grouping" style="display: none">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    </div>
  </div>
</div>

<!--template-->
<script type="text/x-template" id="select2-template">
  <select>
    <slot></slot>
  </select>
</script>