<?php
class Global_format{
  function __construct(){
      
  }
  
  /**
   * @author NBS
   * @param array $display informasi table dan css [width, info, title, table_id]
   * @param array $thead informasi header table
   * @param string $page_loading default NULL. digunakan untuk id html loading table, jika NULL maka tidak ada halaman loading
   */
  function table_view($display, $thead, $page_loading = NULL){
    $th = "";
    foreach($thead AS $thd){
      $th .= "<th>{$thd}</th>";
    }
    $html = ""
      . "<div class='col-md-{$display['width']}'>"
        . "<div class='box box-{$display['info']} box-solid'>"
          . "<div class='box-header with-border'>"
            . "<h3 class='box-title'>{$display['title']}</h3>"
            . "<div class='box-tools pull-right'>"
              . "<button class='btn btn-box-tool' data-widget='collapse'>"
                . "<i class='fa fa-minus'></i>"
              . "</button>"
            . "</div>"
          . "</div>"
          . "<div class='box-body'>"
            . "<table id='{$display['table_id']}' class='table table-bordered table-striped'>"
              . "<thead>"
                . "<tr>"
                  . "{$th}"
                . "</tr>"
              . "</thead>"
              . "<tbody></tbody>"
            . "</table>"
          . "</div>"
          . ($page_loading ? "<div class='overlay' id='{$page_loading}' style='display: none'><i class='fa fa-refresh fa-spin'></i></div>" : "")
        . "</div>"
      . "</div>"
      . "";
    return $html;
  }
  
  
  /**
   * @author NBS
   * @param array $datatables ['fungsi','variable','id_table','attr','page_loading','url']
   * @param array $form ['page_loading','url','table_database','detail_field','onfinish','button']
   * @return array javascript->datatables : format datatables
   * javascript->ajax->get : get data ke datatables
   * javascript->ajax->detail : detail dari record
   * javascript->ajax->button : button set
   * javascript->ajax->button_proses : proses dari button
   */
  function datatables($datatables, $form){
    $return = array(
      "javascript"    => array(
        "datatables"    => $this->format_datatables($datatables['variable'], $datatables["id_table"], $datatables["attr"]),
        "ajax"          => array(
          "get"           => $this->format_get_ajax($datatables['fungsi'], $datatables['variable'], $datatables['url'], $datatables['page_loading']),
          "detail"        => $this->format_detail_ajax($datatables["id_table"], $datatables['variable'], $form['page_loading'], $form['url'], $form['table_database'], $form['detail_field'], $form['onfinish']),
        ),
      ),
      "html"          => array(
        "list"          => "",
        "form"          => $this->html_form(),
      )
    );
    foreach($form["button"] AS $key => $button){
      $return["javascript"]["ajax"][$key]                     = $this->format_button_ajax($key, $button['fungsi_proses'], $button['detail_kirim'], $button['jenis']);
      $return["javascript"]["ajax"][$button['detail_kirim']]  = $this->format_button_proses_ajax($button['fungsi_proses'], $form['page_loading'], $form['url'], $datatables['variable'], $button['onfinish']);
    }
    return $return;
  }
  
  /**
   * @author NBS
   * @param string $variable informasi variable
   * @param string $id_table informasi ID table
   * @param array $attr key merupakan parameter datatables. isi merupakan isi dari datatables
   */
  function format_datatables($variable, $id_table, $attr){
    $data = "";
    foreach ($attr AS $key => $at){
      $data .= "'{$key}': {$at},";
    }
    
    $html = ""
      . "var {$variable} = "
        . "$('#{$id_table}').DataTable({"
          . trim($data, ",")
        . "});"
      . "";
    return $html;
  }
  
  /**
   * @author NBS
   * @param string $fungsi informasi fungsi datatables
   * @param string $variable informasi variable datatables
   * @param string $url
   * @param string $page_loading ID loading div
   */
  function format_get_ajax($fungsi, $variable, $url, $page_loading){
    $html = ""
      . "function {$fungsi}({$variable}, mulai){"
          . "$.post('{$url}', {start: mulai}, function(data){"
            . "var hasil = $.parseJSON(data);"
            . ($page_loading ? "$('#{$page_loading}').show();" : "")
            . "if(hasil.status == 2){"
              . "if(hasil.hasil){"
                . "for(ind = 0; ind < hasil.hasil.length; ++ind){"
                  . "var rowNode = {$variable}.row.add(hasil.hasil[ind]).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                . "}"
              . '}'
              . "{$fungsi}({$variable}, hasil.start);"
            . '}'
            . "else{"
              . ($page_loading ? "$('#{$page_loading}').hide();" : "")
            . "}"
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
   * @param string $id_table
   * @param string $variable
   * @param string $page_loading_form
   * @param string $url
   * @param string $table_database
   * @param array $detail_field dengan multi array [type: 1 normal, 2 ckeditor ; isi: field_database]
   * @param string $onfinish
   */
  function format_detail_ajax($id_table, $variable, $page_loading_form, $url, $table_database, $detail_field, $onfinish){
    $detail = "";
    foreach($detail_field AS $key => $df){
      $detail .= ""
        . ($df['type'] == 2 ? "$('#{$key}').val(CKEDITOR.instances.note.setData(hasil.{$df['isi']}));" : "$('#{$key}').val(hasil.{$df['isi']});")
        . "";
    }
    $html = ""
      . "$('#{$id_table} tbody').on( 'click', 'tr', function () {"
        . "var id = $(this).attr('isi');"
        . "if ( $(this).hasClass('selected') ) {"
        . "}"
        . "else {"
          . "{$variable}.$('tr.selected').removeClass('selected');"
          . "$(this).addClass('selected');"
        . "}"
        . "$('#{$page_loading_form}').show();"
        . "var post = $.post('{$url}', {id_{$table_database}: id}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "{$detail}"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
          . "$('#{$page_loading_form}').hide();"
        . "});"
        . "{$onfnish}"
      . "});"
      . "";
    return $html;
  }
  
  /**
   * @author NBS
   * @param string $id_button
   * @param string $fungsi_proses
   * @param array $detail_kirim dengan multi array [type: 1 normal, 2 ckeditor ; isi: field_database], key nya adalah id html
   */
  function format_button_ajax($id_button, $fungsi_proses, $detail_kirim, $jenis){
    foreach ($detail_kirim AS $key => $dk){
      $detail .= ($dk['type'] == 2 ? "{$dk['isi']}: CKEDITOR.instances.{$key}.getData()," : "{$dk['isi']}: $('#{$key}').val(),");
    }
    $html = ""
      . "$(document).on('click', '#{$id_button}', function(evt){"
        . "var kirim = {".trim($detail, ",")."};"
        . "{$fungsi_proses}(kirim, {$jenis});"
      . "});"
      . "";
    return $html;
  }
  
  /**
   * @author NBS
   * @param string $id_button
   * @param string $fungsi_proses
   * @param array $detail_kirim dengan multi array [type: 1 normal, 2 ckeditor ; isi: field_database], key nya adalah id html
   */
  function format_button_proses_ajax($fungsi_proses, $page_loading_form, $url, $variable, $onfinish){
    $html = ""
      . "function {$fungsi_proses}(kirim, jenis){"
        . "$('#{$page_loading_form}').show();"
        . "var post = $.post('{$url}', kirim, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 2){"
            . "if(jenis == 2){"
              . "{$variable}.row($('[isi|='+hasil.banding+']')).remove().draw();"
            . "}"
            . "{$variable}.$('tr.selected').removeClass('selected');"
            . "var rowNode = {$variable}.row.add(hasil.hasil).draw().node();"
            . "$( rowNode ).attr('isi',hasil.banding);"
            . "$( rowNode ).addClass('selected');"
            . "{$onfinish}"
          . "}"
        . "})"
        . ".fail(function(){"
          . "alert('".lang("Fail").": ".lang("Please check your internet connection")."');"
        . "})"
        . ".always(function(){"
          . "$('#{$page_loading_form}').hide();"
        . "});"
      . "}"
      . "";
    return $html;
  }
  
  /**
   * @author NBS
   * @param string $id_button
   * @param string $fungsi_proses
   * @param array $detail_kirim dengan multi array [type: 1 normal, 2 ckeditor ; isi: field_database], key nya adalah id html
   */
  function html_form(){
    $row = "<div class='row'>";
    foreach($detail_field AS $key => $df){
      $cari = strpos($df['set'], 5);
      if($cari !== FALSE){
        $row .= ""
          . "<div class='col-xs-{$df['width']}'>"
            . "<label>{$df['label']}</label>"
            . "{$form_field}"
          . "</div>"
          . "";
      }
    }
    $row .= "</div>";
    $html = ""
      . "<div class='box-body'>"
        . "<div class='form-group'>"
          
        . "</div>"
      . "</div>"
      . "<div class='box-footer'>"
        . "<button type='button' id='new' class='btn btn-info btn-sm'><?php print lang('Add New')?></button>"
        . "<button type='button' id='simpan' class='btn btn-primary btn-sm'><?php print lang('Update')?></button>"
      . "</div>"
      . "<div class='overlay' id='{$page_loading_form}' style='display: none'>"
        . "<i class='fa fa-refresh fa-spin'></i>"
      . "</div>"
      . "";
    return $html;
  }
  
}
?>
