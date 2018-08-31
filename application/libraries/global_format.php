<?php
class Global_format{
  function __construct(){
      
  }
  function standart_head($data){
    foreach($data AS $key => $dt){
      $head[] = array(
        "title"       => lang($dt),
        "id"          => $key,
        "asc"         => false,
        "desc"        => false,
      );
    }
    return $head;
  }
  
  /**
   * @author NBS
   * @param array $form [(string)variable, (string)id, (string)loading]
   * @param array $param [(array)data form]
   * @param array $kirim [(string)update, (string)insert]
   * @param string $url string post
   * @param array $grid data grid table
   * @param string $watch watch form vue
   */
  
  function standart_form($form, $param, $kirim, $url, $grid, $watch = ""){
    $data = json_encode($param);
    $form['else_update'] = ($form['else_update'] ? $form['else_update'] : $form['else']);
    $html = ""
      . "var {$form['variable']} = new Vue({"
        . "el: '#{$form['id']}',"
        . "data: {$data},"
        . "watch: {"
          . $watch
        . "},"
        . "methods: {"
          . "{$form['methods']}"
          . "update: function(){"
            . "$('#{$form['loading']}').show();"
            . "{$kirim['before_update']}"
            . "$.post('{$url}', {$kirim['update']}, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "if(hasil.status == 10001){"
                . "$('#negative-response-title').html('".lang("Access")."');"
                . "$('#negative-response-body').html('".lang("You can not access this function")."');"
                . "$('#negative-response').modal('show');"
              . "}"
              . "else if(hasil.status == 3){"
                . "$('#negative-response-title').html('".lang("Function")."');"
                . "$('#negative-response-body').html(hasil.note);"
                . "$('#negative-response').modal('show');"
              . "}"
              . "else if(hasil.status == 2 || hasil.status == '2'){"
                . "{$grid['variable']}.replace_items(hasil.data, hasil.data.id);"
                . "{$grid['variable']}.items_live[{$grid['variable']}.page.select[0]] = hasil.data;"
                . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
                . "{$grid['variable']}.{$grid['cari']} = hasil.data.number;"
                . "{$grid['variable']}.cari(hasil.data.number);"
             . "}"
              . "else{"
                . "{$form['else_update']}"
              . "}"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
              . "$('#{$form['loading']}').hide();"
            . "});"
          . "},"
          . "add_new: function(){"
            . "$('#{$form['loading']}').show();"
            . "{$kirim['before_insert']}"
            . "$.post('{$url}', {$kirim['insert']}, function(data){"
              . "var hasil = $.parseJSON(data);"
//              . "console.log(hasil);"
              . "if(hasil.status == 10001){"
                . "$('#negative-response-title').html('".lang("Access")."');"
                . "$('#negative-response-body').html('".lang("You can not access this function")."');"
                . "$('#negative-response').modal('show');"
              . "}"
              . "else if(hasil.status == 3){"
                . "$('#negative-response-title').html('".lang("Function")."');"
                . "$('#negative-response-body').html(hasil.note);"
                . "$('#negative-response').modal('show');"
              . "}"
              . "else if(hasil.status == 2 || hasil.status == '2'){"
//                . "console.log(hasil.data);"
                . "{$grid['variable']}.page.select = [];"
                . "{$grid['variable']}.page.select_value = '';"
                . "{$grid['variable']}.reselect();"
                
                . ($form['id_set'] ? "{$form['variable']}.{$form['id_set']} = hasil.data.id;" : "")
                . $this->js_grid_add($grid, "hasil.data")
                . "{$grid['variable']}.{$grid['cari']} = hasil.data.number;"
//                . "{$grid['variable']}.cari(hasil.data.number);"
//                . "{$grid['variable']}.cari();"
              . "}"
              . "else{"
                . "{$form['else']}"
              . "}"
            . "})"
            . ".done(function(){"
            . "})"
            . ".fail(function(){"
              . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
            . "})"
            . ".always(function(){"
              . "$('#{$form['loading']}').hide();"
            . "});"
          . "}"
        . "}"
      . "});"
      . "";
    return $html;
  }
  
  function standart_component(){
    $html = ""
      . "Vue.component('checktoggle', {"
        . "props: ['value'],"
        . "template: '#checktoggle-template',"
        . "mounted: function () {"
          . "var vm = this;"
          . '$(vm.$el).prop("checked", vm.value).change();'
          . '$(vm.$el).change(function() {'
            . 'vm.$emit("input", $(vm.$el).prop("checked"));'
          . "});"
        . "},"
        . "watch: {"
          . "value: function (value) {"
            . '$(this.$el).prop("checked", value).change();'
          . "},"
        . "},"
        . "destroyed: function () {"
        . "}"
      . "});"
      
      . "Vue.component('number', {"
        . "props: ['value'],"
        . "template: '#number-template',"
        . "mounted: function () {"
          . "var vm = this;"
          . '$(vm.$el).priceFormat({'
            . "prefix: '',"
            . "centsLimit: 0"
          . "});"
          . '$(vm.$el).on("change", function() {'
            . 'vm.$emit("input", $(this).val());'
          . '});'
          . '$(vm.$el).val(this.value);'
        . "},"
        . "watch: {"
          . "value: function (value) {"
            . '$(this.$el).val(value);'
          . "},"
        . "},"
        . "destroyed: function () {"
        . "}"
      . "});"
      
      . "Vue.component('select2', {"
        . "props: ['options', 'value'],"
        . "template: '#select2-template',"
        . "mounted: function () {"
          . "var vm = this;"
          . '$(this.$el).select2();'
          . '$(this.$el).select2({ data: this.options });'
          . '$(this.$el).select2("val", this.value);'
          . '$(this.$el).on("change", function () {'
            . 'vm.$emit("input", this.value);'
          . '});'
        . "},"
        . "watch: {"
          . "value: function (value) {"
            . '$(this.$el).select2("val", value);'
          . "},"
          . "options: function (options) {"
            . '$(this.$el).select2({ data: this.options });'
          . "}"
        . "},"
        . "destroyed: function () {"
          . '$(this.$el).off().select2("destroy");'
        . "}"
      . "});"
      
      . "Vue.component('ckeditor', {"
        . "props: ['value'],"
        . "template: '#ckeditor-template',"
        . "methods: {"
          . "isi: function (id, value) {"
            . "$('#'+id).val(value);"
          . "}"
        . "},"
        . "mounted: function () {"
          . "var vm = this;"
          . 'CKEDITOR.replace($(vm.$el).attr("id"));'
          . 'CKEDITOR.instances[$(vm.$el).attr("id")].on("change", function() {'
            . 'vm.isi($(vm.$el).attr("id"), CKEDITOR.instances[$(vm.$el).attr("id")].document.getBody().getHtml());'
          . '});'
          . 'CKEDITOR.instances[$(vm.$el).attr("id")].setData(this.value);'
          . '$(vm.$el).val(this.value);'
        . "},"
        . "watch: {"
          . "value: function (value) {"
            . 'CKEDITOR.instances[$(this.$el).attr("id")].setData(value);'
            . '$(this.$el).val(value);'
          . "},"
        . "},"
        . "destroyed: function () {"
        . "}"
      . "});"
      
      . "Vue.component('datetimesingle', {"
        . "props: ['value'],"
        . "template: '#daterangepicker-template',"
        . "mounted: function () {"
          . "var vm = this;"
          . '$(this.$el).daterangepicker({'
            . "showDropdowns: true,"
            . "timePicker: true,"
            . "singleDatePicker: true,"
            . "timePicker24Hour: true,"
            . "timePickerIncrement: 5,"
            . "format: 'YYYY-MM-DD HH:mm'"
          . "}, function(start, end, label) {"
            . '$(vm.$el).val(start.format("YYYY-MM-DD HH:mm"));'
            . 'vm.$emit("input", start.format("YYYY-MM-DD HH:mm"));'
          . "});"
          . '$(this.$el).val(this.value);'
        . "},"
        . "watch: {"
          . "value: function (value) {"
            . '$(this.$el).data("daterangepicker").setStartDate(value);'
            . '$(this.$el).data("daterangepicker").setEndDate(value);'
          . "},"
        . "},"
        . "destroyed: function () {"
        . "}"
      . "});"
      
      . "Vue.component('datesingle', {"
        . "props: ['value'],"
        . "template: '#daterangepicker-template',"
        . "mounted: function () {"
          . "var vm = this;"
          . '$(this.$el).daterangepicker({'
            . "timePicker: false,"
            . "singleDatePicker: true,"
            . "showDropdowns: true,"
            . "format: 'YYYY-MM-DD'"
          . "}, function(start, end, label) {"
            . '$(vm.$el).val(start.format("YYYY-MM-DD"));'
            . 'vm.$emit("input", start.format("YYYY-MM-DD"));'
          . "});"
          . '$(this.$el).val(this.value);'
        . "},"
        . "watch: {"
          . "value: function (value) {"
            . '$(this.$el).data("daterangepicker").setStartDate(value);'
            . '$(this.$el).data("daterangepicker").setEndDate(value);'
          . "},"
        . "},"
        . "destroyed: function () {"
        . "}"
      . "});"
      
      . "";
    
    return $html;
  }
  
  function standart_get_all($fungsi, $url, $kirim, $grid){
    $html = ""
      . "function {$fungsi}(){"
        . "$.post('{$url}', {$kirim}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
          . '}'
          . 'else{'
          . '}'
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . "";
    return $html;
  }
  
  function standart_number_format(){
    $html = ""
      . "function number_format(number, decimals, dec_point, thousands_sep){"
        . "number = (number + '').replace(/[^0-9+\-Ee.]/g, '');"
        . "var n = !isFinite(+number) ? 0 : +number"
          . ", prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)"
          . ", sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep"
          . ", dec = (typeof dec_point === 'undefined') ? '.' : dec_point"
          . ", s = ''"
          . ", toFixedFix = function (n, prec){"
              . "var k = Math.pow(10, prec);"
              . "return '' + (Math.round(n * k) / k).toFixed(prec);"
            . "};"
        . "s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');"
        . "if(s[0].length > 3){"
          . "s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);"
        . "}"
        . "if((s[1] || '').length < prec){"
          . "s[1] = s[1] || '';"
          . "s[1] += new Array(prec - s[1].length + 1).join('0');"
        . "}"
        . "return s.join(dec);"
      . "}"
      . "";
    return $html;
  }
  
  function standart_str_replace(){
    $html = ""
      . "function str_replace(search, replace, subject, count){"
        . "var i = 0, j = 0, temp = '', repl = '', sl = 0, fl = 0, f = [].concat(search), r = [].concat(replace)"
          . ", s = subject, ra = Object.prototype.toString.call(r) === '[object Array]'"
          . ", sa = Object.prototype.toString.call(r) === '[object Array]'"
          . ";"
        . "s = [].concat(s);"
        . "if(count){"
          . "this.window[count] = 0;"
        . "}"
        . "for(i = 0, sl = s.length; i < sl; i++){"
          . "if(s[i] === ''){"
            . "continue;"
          . "}"
          . "for(j = 0, fl = f.length; j < fl; j++){"
            . "temp = s[i] + '';"
            . "repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];"
            . "s[i] = (temp)"
              . ".split(f[j])"
              . ".join(repl);"
            . "if(count && s[i] !== temp){"
              . "this.window[count] += (temp.length - s[i].length) / f[j].lenght;"
            . "}"
          . "}"
        . "}"
        . "return sa ? s[0] : s[0];"
      . "}"
      . "";
    return $html;
  }
  
  function standart_get($fungsi, $url, $kirim, $grid, $tambahan = array()){
    $html = ""
      . "function {$fungsi}(mulai){"
        . "$.post('{$url}', {$kirim}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'if(hasil.data){'
              . "for(ind = 0; ind < hasil.data.length; ++ind){"
                . $this->js_grid_add($grid, "hasil.data[ind]")
              . "}"
            . "}"
            . "{$fungsi}(hasil.start);"
          . '}'
          . 'else{'
            . "{$tambahan['selesai']}"
          . '}'
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
        . "});"
      . "}"
      . "";
    return $html;
  }
  
  /**
   * @author NBS
   */
  function framework(){
    return ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/plugins/vue/vue.min.js'></script>"
    . "";
  }
  
  /**
   * @author NBS
   */
  function js_grid_add($grid, $variable){
    return ""
      . "if(Array.isArray({$grid['variable']}.items)){"
        . "{$grid['variable']}.items.push({$variable});"
        . "{$grid['variable']}.items_live.push({$variable});"
      . "}"
      . "else{"
        . "{$grid['variable']}.items = {$grid['variable']}.items_live = [{$variable}];"
      . "}"
      . "{$grid['variable']}.cari($('#{$grid['cari']}').val());"
    . "";
  }
  
  /**
   * @author NBS
   */
  function html_grid($grid){
    $html = ""
      . '<div class="box-body" id="'.$grid['id'].'">'
        . '<div class="grid-page">'
          . '<div class="grid-head">'
            . '<div class="grid-tr">'
              . '<div class="pull-right">'
                . '<input type="text"'
                . ' v-on:keyup="cari($event.target.value)"'
                . ' v-model="'.$grid['cari'].'"'
                . ' class="form-control input-sm"'
                . ' style="width: auto !important"'
                . ' id="'.$grid['cari'].'" />'
              . '</div>'
            . '</div>'
          . '</div>'
        . '</div>'
        . '<div class="grid-table">'
          . '<div class="grid-head">'
            . '<div class="grid-tr">'
            . '<div v-for="(kepala, index) in head"'
            . ' v-bind:key="kepala.id"'
            . ' class="grid-th"'
            . ' v-bind:class="{'."'asc'".': kepala.asc, '."'desc'".': kepala.desc}"'
            . ' v-on:click="sort_data(index)">'
              . '{{kepala.title}}'
            . '</div>'
          . '</div>'
        . '</div>'
        . '<transition-group name="fade" tag="div" class="grid-body">'
          . '<div v-for="n in page.limit"'
          . ' v-bind:key="n"'
          . ' v-if="items_live[(n - 1 + page.start)]"'
          . ' v-on:click="select((n - 1 + page.start))"'
          . ' v-bind:class="{'."'selected'".': items_live[(n - 1 + page.start)].select}"'
          . ' class="grid-tr">'
            . '<div v-for="sub in items_live[(n - 1 + page.start)].data" v-html="sub.view" v-bind:class="sub.class">'
            . '</div>'
          . '</div>'
        . '</transition-group>'
      . '</div>'
      . '<div class="grid-page">'
        . '<div class="grid-head">'
          . '<div class="grid-tr">'
            . '<div>'
              . '<ul class="pagination pagination-sm no-margin pull-right">'
                . '<li v-on:click="goto(0, 1)">'
                  . '<a href="javascript:void(0)">«</a>'
                . '</li>'
                . '<li v-for="p in page.m3" v-on:click="goto((((page.hlm - p) * page.limit) - page.limit), (page.hlm - p))">'
                  . '<a href="javascript:void(0)" v-if="(page.hlm - p) > 0">{{(page.hlm - p)}}</a>'
                . '</li>'
                . '<li v-on:click="goto(((page.hlm * page.limit) - page.limit), page.hlm)">'
                  . '<a href="javascript:void(0)" style="background-color: blue; color: white;">{{page.hlm}}</a>'
                . '</li>'
                . '<li v-for="p in page.p3" v-on:click="goto((((p + page.hlm) * page.limit) - page.limit), (p + page.hlm))">'
                  . '<a href="javascript:void(0)" v-if="(p + page.hlm) <= page.jml_page">{{(p + page.hlm)}}</a>'
                . '</li>'
                . '<li v-on:click="goto(((page.jml_page * page.limit) - page.limit),page.jml_page)">'
                  . '<a href="javascript:void(0)">»</a>'
                . '</li>'
              . '</ul>'
            . '</div>'
          . '</div>'
        . '</div>'
      . '</div>'
    . '</div>'
      . "";
    return $html;
  }
  function html_grid_down($grid){
    $html = ""
      . '<div class="box-body" id="'.$grid['id'].'">'
        . '<div class="grid-page">'
          . '<div class="grid-head">'
            . '<div class="grid-tr">'
//              . '<div class="pull-right">'
//                . '<input type="text"'
//                . ' v-on:keyup="cari($event.target.value)"'
//                . ' v-model="'.$grid['cari'].'"'
//                . ' class="form-control input-sm"'
//                . ' style="width: auto !important"'
//                . ' id="'.$grid['cari'].'" />'
//              . '</div>'
            . '</div>'
          . '</div>'
        . '</div>'
        . '<div class="grid-table">'
          . '<div class="grid-head">'
            . '<div class="grid-tr">'
            . '<div v-for="(kepala, index) in head"'
            . ' v-bind:key="kepala.id"'
            . ' class="grid-th"'
            . ' v-bind:class="{'."'asc'".': kepala.asc, '."'desc'".': kepala.desc}"'
            . ' v-on:click="sort_data(index)">'
              . '{{kepala.title}}'
            . '</div>'
          . '</div>'
        . '</div>'
        . '<transition-group name="fade" tag="div" class="grid-body">'
          . '<div v-for="n in page.limit"'
          . ' v-bind:key="n"'
          . ' v-if="items_live[(n - 1 + page.start)]"'
          . ' v-on:click="select((n - 1 + page.start))"'
          . ' v-bind:class="{'."'selected'".': items_live[(n - 1 + page.start)].select}"'
          . ' class="grid-tr">'
            . '<div v-for="sub in items_live[(n - 1 + page.start)].data" v-html="sub.view" v-bind:class="sub.class">'
            . '</div>'
          . '</div>'
        . '</transition-group>'
      . '</div>'
      
    . '</div>'
      . "";
    return $html;
  }
  
  /**
   * @author NBS
   */
  function css_grid(){
    $css = ""
      . ".grid-table{"
        . "display: table;"
        . "width: 100%;"
      . "}"
      . ".grid-page{"
        . "display: table;"
        . "width: 100%;"
        . "margin-bottom: 5px;"
        . "margin-top: 5px;"
      . "}"
      . ".grid-head{"
        . "display: table-row-group;"
      . "}"
      . ".grid-body{"
        . "display: table-row-group;"
      . "}"
      . ".grid-foot{"
        . "display: table-row-group;"
      . "}"
      . ".grid-table .grid-tr:hover{"
        . "background-color:lightgray;"
      . "}"
      . ".grid-table .grid-tr{"
        . "display: table-row;width: 100%;"
      . "}"
      . ".grid-table .grid-tr .grid-colspan{"
        . "flex: 2;"
      . "}"
      . ".grid-table .grid-tr .asc{"
        . "background-image: url('".site_url()."themes/".DEFAULTTHEMES."/nubusa/images/asc.png');"
        . "background-position: right center;"
        . "background-repeat: no-repeat;"
      . "}"
      . ".grid-table .grid-tr .desc{"
        . "background-image: url('".site_url()."themes/".DEFAULTTHEMES."/nubusa/images/desc.png');"
        . "background-position: right center;"
        . "background-repeat: no-repeat;"
      . "}"
      . ".grid-table .grid-tr .grid-th:hover{"
        . "cursor:pointer;"
      . "}"
      . ".grid-table .grid-tr .grid-th{"
        . "display: table-cell;"
        . "width: auto;"
        . "font-weight: bold;"
        . "padding: 5px;"
        . "background-size: 15px 15px;"
        . "background-color: #c0c0c0;"
      . "}"
      . ".grid-table .grid-tr div{"
        . "display: table-cell;"
        . "width: auto;"
        . "padding: 5px;"
        . "border-style: solid;"
        . "border-width: 1px;"
        . "border-color: #c0c0c0;"
        . "border-top: none;"
        . "border-right: none;"
        . "border-left: none;"
      . "}"
      . ".grid-table .grid-tr .grid-tf{"
        . "display: table-cell;"
        . "width: auto;padding: 5px;"
      . "}"
      . ".fade-move, .fade-enter-active, .fade-leave-active {"
        . "transition: all .5s cubic-bezier(.55,0,.1,1);"
      . "}"
      . ".fade-enter, .fade-leave-to {"
        . "opacity: 0;"
        . "transform: scaleY(0.01) translate(30px, 0);"
      . "}"
      . ".fade-leave-active {"
        . "position: absolute;"
      . "}"
      . "";
    return $css;
  }
  
  /**
   * @author NBS
   */
  function js_grid_table($data, $header, $grid){
    $items = json_encode($data);
    $kepala = json_encode($header);
    $hlm = ceil(count($data) / $grid['limit']);
    
    $script = ""
      . "var {$grid['variable']} = new Vue({"
        . "el: '#{$grid['id']}',"
        . "data: {"
          . "{$grid['cari']}: '{$grid['search']}',"
          . "head: {$kepala},"
          . "items: {$items},"
          . "items_live: {$items},"
          . "page: {"
            . "start: 0,"
            . "limit: {$grid['limit']},"
            . "before: 0,"
            . "selected: 'selected',"
            . "select: [],"
            . "select_value: '',"
            . "hlm: 1,"
            . "jml_page: {$hlm},"
            . "p3: [1,2,3],"
            . "m3: [3,2,1]"
          . "}},"
        . "watch: {"
          . "items : function(val){"
            . "{$grid['watch']['items']}"
          . "}"
        . "},"
        . "computed:{"
          . "{$grid['computed']}"
        . "},"
        . "methods: {"
          . "goto(start, hlm){"
            . "this.page.start = start;"
            . "this.page.hlm = hlm;"
          . "},"
          . "sort_data(index){"
            . "if(this.head[index].asc == true){"
              . "this.set_false();"
              . "this.head[index].asc = false;"
              . "this.head[index].desc = true;"
              . "this.bubblesort_desc(this.items_live, index);"
            . "}"
            . "else{"
              . "this.set_false();"
              . "this.head[index].asc = true;"
              . "this.head[index].desc = false;"
              . "this.bubblesort_asc(this.items_live, index);"
            . "}"
          . "},"
          . "bubblesort_asc(a, index){"
            . "var swapped;"
            . "do {"
              . "swapped = false;"
              . "for (var i=0; i < a.length-1; i++) {"
                . "var aa = a[i].data[index].value;"
                . "var bb = a[i+1].data[index].value;"
                . "if(isNaN(parseInt(aa)) || isNaN(parseInt(bb))){"
                  . "aa = aa;"
                  . "bb = bb;"
                . "}"
                . "else{"
                  . "aa = parseInt(aa);"
                  . "bb = parseInt(bb);"
                . "}"
                . "if (aa > bb) {"
                  . "var temp = a[i];"
                  . "a[i] = a[i+1];"
                  . "a[i+1] = temp;"
                  . "swapped = true;"
                . "}"
              . "}"
            . "} "
            . "while (swapped);"
          . "},"
          . "bubblesort_desc(a, index){"
            . "var swapped;"
            . "do {"
              . "swapped = false;"
              . "for (var i=0; i < a.length-1; i++) {"
                . "var aa = a[i].data[index].value;"
                . "var bb = a[i+1].data[index].value;"
                . "if(isNaN(parseInt(aa)) || isNaN(parseInt(bb))){"
                  . "aa = aa;"
                  . "bb = bb;"
                . "}"
                . "else{"
                  . "aa = parseInt(aa);"
                  . "bb = parseInt(bb);"
                . "}"
                . "if (aa < bb) {"
                  . "var temp = a[i];"
                  . "a[i] = a[i+1];"
                  . "a[i+1] = temp;"
                  . "swapped = true;"
                . "}"
              . "}"
            . "} while (swapped);"
          . "},"
          . "set_false(){"
            . "for(var g = 0 ; g < this.head.lenght ; g++){"
              . "this.head[g].asc = false;"
              . "this.head[g].desc = false;"
            . "}"
          . "},"
          . "cari(query){"
            . "var articles_array = this.items, searchString = query;"
//            . "if(!searchString){"
//              . "this.items_live = articles_array;"
//            . "}"
//            . "else{"
            . "if (typeof(searchString) != 'undefined'){"
              . "searchString = searchString.toString();"
              . "searchString = searchString.trim().toLowerCase();"
              . "articles_array = articles_array.filter(function(item){"
                . "if(item != null){"
                  . "for(var g = 0 ; g < item.data.length ; g++){"
                    . "if(item.data[g].view != null){"
                      . "if (item.data[g].view === parseInt(item.data[g].view, 10)){"
                        . "item.data[g].view = item.data[g].view.toString();"
                      . "}"
                      . "if(item.data[g].view.toLowerCase().indexOf(searchString) !== -1){"
                        . "return item.data[g];break;"
                      . "}"
                    . "}"
                  . "}"
                . "}"
              . "});"
              . "this.items_live = articles_array;"
            . "}"
            . "else{"
              . "this.items_live = articles_array;"
            . "}"
//            . "}"
            . "this.page.jml_page = Math.ceil(this.items_live.length / this.page.limit);"
          . "},"
          . "get_jml_page(){"
            . "this.page.jml_page = Math.ceil(this.items_live.length / this.page.limit);"
          . "},"
          . "select(index){"
            . "var a = this.page.select.indexOf(index);"
            . "if(a == -1){"
              . "";
if($grid['multi_select']){
  $script     .= "this.page.select.push(index);"
              . "this.page.select_value = this.items_live[index].id;"
              . "{$grid['onselect']}"
              . "";
}
else{
  $script     .= "this.page.select = [index];"
              . "this.page.select_value = this.items_live[index].id;"
              . "{$grid['onselect']}";
}
  $script   .= "}"
            . "else{";
if($grid['multi_select']){
  $script   .= "for(var g = 0 ; g < this.page.select.length ; g++){"
                . "if(index == this.page.select[g]){"
                  . "this.page.select[g] = -100;"
                . "}"
              . "}"
            . "{$grid['on_unselect']}";
}
else{
  $script   .= "this.page.select = [];"
            . "{$grid['on_unselect']}";
}
  $script   .= "{$grid['unselect']}"
            . "}"
            . "this.reselect();"
          . "},"
          . "cari_id(id){"
            . "for(var g = 0 ; g < this.items.length ; g++){"
              . "if(this.items[g] != null){"
                . "if(this.items[g].id == id){"
                  . "return g;"
                  . "break;"
                . "}"
              . "}"
            . "}"
          . "},"
          . "delete_items(id){"
            . "var index = this.cari_id(id);"
            . "this.items = removeKey(this.items,index);"
          . "},"
          . "replace_items(data, id){"
            . "var index = this.cari_id(id);"
            . "this.items[index] = data;"
          . "},"
          . "select_set(id){"
            . "for(var g = 0 ; g < this.items_live.length ; g++){"
              . "this.items_live[g].select = false;"
              . "if(id == this.items_live[g].id){"
                . "this.items_live[g].select = true;"
              . "}"
            . "}"
          . "},"
          . "reselect(){"
            . "for(var g = 0 ; g < this.items_live.length ; g++){"
              . "var a = this.page.select.indexOf(g);"
              . "if(a == -1){"
                . "this.items_live[g].select = false;"
              . "}"
              . "else{"
                . "this.items_live[g].select = true;"
              . "}"
            . "}"
          . "},"
          . "clear(){"
            . "this.items = this.items_live = '';"
          . "}"
        . "}"
      . "});"
      . ($grid['search'] ? "{$grid['variable']}.cari('{$grid['search']}');":"")
      . ""
      . "function removeKey(arrayName,key){"
        . "var x;"
        . "var tmpArray = new Array();"
        . "var r = 0;"
        . "for(x in arrayName){"
          . "if(x!=key) {"
            . "tmpArray[r] = arrayName[x];"
            . "r++;"
          . "}"
        . "}"
        . "return tmpArray;"
      . "}"
      . "";
    return $script;
  }
  
  function js_grid_table2($data, $header, $grid){
    $items = json_encode($data);
    $kepala = json_encode($header);
    $hlm = ceil(count($data) / $grid['limit']);
    
    $script = ""
      . "var {$grid['variable']} = new Vue({"
        . "el: '#{$grid['id']}',"
        . "data: {"
          . "{$grid['cari']}: '{$grid['search']}',"
          . "head: {$kepala},"
          . "items: {$items},"
          . "items_live: {$items},"
          . "page: {"
            . "start: 0,"
            . "limit: {$grid['limit']},"
            . "before: 0,"
            . "selected: 'selected',"
            . "select: [],"
            . "select_value: '',"
            . "hlm: 1,"
            . "isi: [],"
            . "jml_page: {$hlm},"
            . "p3: [1,2,3],"
            . "m3: [3,2,1]"
          . "}},"
        . "methods: {"
          . "goto(start, hlm){"
            . "this.page.start = start;"
            . "this.page.hlm = hlm;"
          . "},"
          . "sort_data(index){"
            . "if(this.head[index].asc == true){"
              . "this.set_false();"
              . "this.head[index].asc = false;"
              . "this.head[index].desc = true;"
              . "this.bubblesort_desc(this.items_live, index);"
            . "}"
            . "else{"
              . "this.set_false();"
              . "this.head[index].asc = true;"
              . "this.head[index].desc = false;"
              . "this.bubblesort_asc(this.items_live, index);"
            . "}"
          . "},"
          . "sort_data_always_asc(index){"
            . "this.set_false();"
            . "this.head[index].asc = true;"
            . "this.head[index].desc = false;"
            . "this.bubblesort_asc(this.items_live, index);"
          . "},"
          . "bubblesort_asc(a, index){"
            . "var swapped;"
            . "do {"
              . "swapped = false;"
              . "for (var i=0; i < a.length-1; i++) {"
                . "var aa = a[i].data[index].value;"
                . "var bb = a[i+1].data[index].value;"
                . "if(isNaN(parseInt(aa)) || isNaN(parseInt(bb))){"
                  . "aa = aa;"
                  . "bb = bb;"
                . "}"
                . "else{"
                  . "aa = parseInt(aa);"
                  . "bb = parseInt(bb);"
                . "}"
                . "if (aa > bb) {"
                  . "var temp = a[i];"
                  . "a[i] = a[i+1];"
                  . "a[i+1] = temp;"
                  . "swapped = true;"
                . "}"
              . "}"
            . "} "
            . "while (swapped);"
          . "},"
          . "bubblesort_desc(a, index){"
            . "var swapped;"
            . "do {"
              . "swapped = false;"
              . "for (var i=0; i < a.length-1; i++) {"
                . "var aa = a[i].data[index].value;"
                . "var bb = a[i+1].data[index].value;"
                . "if(isNaN(parseInt(aa)) || isNaN(parseInt(bb))){"
                  . "aa = aa;"
                  . "bb = bb;"
                . "}"
                . "else{"
                  . "aa = parseInt(aa);"
                  . "bb = parseInt(bb);"
                . "}"
                . "if (aa < bb) {"
                  . "var temp = a[i];"
                  . "a[i] = a[i+1];"
                  . "a[i+1] = temp;"
                  . "swapped = true;"
                . "}"
              . "}"
            . "} while (swapped);"
          . "},"
          . "set_false(){"
            . "for(var g = 0 ; g < this.head.lenght ; g++){"
              . "this.head[g].asc = false;"
              . "this.head[g].desc = false;"
            . "}"
          . "},"
          . "cari(query){"
//            . "var articles_array = this.items, searchString = query;"
//            . "if(!searchString){"
//              . "this.items_live = articles_array;"
//            . "}"
//            . "searchString = searchString.toString();"
//            . "searchString = searchString.trim().toLowerCase();"
//            . "articles_array = articles_array.filter(function(item){"
//              . "if(item != null){"
//                . "for(var g = 1 ; g < item.data.length ; g++){"
//                  . "if(item.data[g].view != null){"
//                    . "if (item.data[g].view === parseInt(item.data[g].view, 10)){"
//                      . "item.data[g].view = item.data[g].view.toString();"
//                    . "}"
//                    . "if(item.data[g].view.toLowerCase().indexOf(searchString) !== -1){"
//                      . "return item.data[g];break;"
//                    . "}"
//                  . "}"
//                . "}"
//              . "}"
//            . "});"
//            . "this.items_live = articles_array;"
//            . "this.page.jml_page = Math.ceil(this.items_live.length / this.page.limit);"
          . "},"
          . "get_jml_page(){"
            . "this.page.jml_page = Math.ceil(this.items_live.length / this.page.limit);"
          . "},"
          . "select(index){"
            . "var a = this.page.select.indexOf(index);"
            . "if(a == -1){"
              . "";
if($grid['multi_select']){
  $script     .= "this.page.select.push(index);"
              . "this.page.select_value = this.items_live[index].id;"
              . "{$grid['onselect']}"
              . "";
}
else{
  $script     .= "this.page.select = [index];"
              . "this.page.select_value = this.items_live[index].id;"
              . "{$grid['onselect']}";
}
  $script   .= "}"
            . "else{";
if($grid['multi_select']){
  $script   .= "for(var g = 0 ; g < this.page.select.length ; g++){"
                . "if(index == this.page.select[g]){"
                  . "this.page.select[g] = -100;"
                . "}"
              . "}";
}
else{
  $script   .= "this.page.select = [];";
}
  $script   .= "{$grid['unselect']}"
            . "}"
            . "this.reselect();"
          . "},"
          . "cari_id(id){"
            . "for(var g = 0 ; g < this.items.length ; g++){"
              . "if(this.items[g] != null){"
                . "if(this.items[g].id == id){"
                  . "return g;"
                  . "break;"
                . "}"
              . "}"
            . "}"
          . "},"
          . "delete_items(id){"
            . "var index = this.cari_id(id);"
            . "this.items[index] = null;"
          . "},"
          . "replace_items(data, id){"
            . "var index = this.cari_id(id);"
            . "this.items[index] = data;"
          . "},"
          . "reselect(){"
            . "for(var g = 0 ; g < this.items_live.length ; g++){"
              . "var a = this.page.select.indexOf(g);"
              . "if(a == -1){"
                . "this.items_live[g].select = false;"
              . "}"
              . "else{"
                . "this.items_live[g].select = true;"
              . "}"
            . "}"
          . "},"
          . "clear(){"
            . "this.items = this.items_live = '';"
          . "}"
        . "}"
      . "});"
      . ($grid['search'] ? "{$grid['variable']}.cari('{$grid['search']}');":"")
      . "";
    return $script;
  }
  
  function standart_component_theme(){
    $html = ""
      . '<script type="text/x-template" id="select2-template">
  <select>
    <slot></slot>
  </select>
</script>

<script type="text/x-template" id="ckeditor-template">
  <textarea>
  </textarea>
</script>

<script type="text/x-template" id="daterangepicker-template">
  <input readonly="readonly" style="background-color: white;">
    <slot></slot>
  </input>
</script>

<script type="text/x-template" id="number-template">
  <input>
    <slot></slot>
  </input>
</script>

<script type="text/x-template" id="checktoggle-template">
  <input type="checkbox">
  </input>
</script>'
      . "";
    return $html;
  }
  
}
?>
