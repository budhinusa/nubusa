<?php
class M_sitepameran_print extends CI_Model {

  function __construct(){
      parent::__construct();
  }
  
  function book_int_email($kirim){
    
    $isihtml = ""
      . "<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>"
      . "<html lang='en'>"
        . "<head>"
          . "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1'>"
          . "<!-- So that mobile will display zoomed in -->"
          . "<meta http-equiv='X-UA-Compatible' content='IE=edge'>"
          . "<!-- enable media queries for windows phone 8 -->"
          . "<meta name='format-detection' content='telephone=no'>"
          . "<!-- disable auto telephone linking in iOS -->"
          . "<title>Single Column</title>"
          . "<style type='text/css'>"
            . "body {"
              . "margin: 0;"
              . "padding: 0;"
              . "-ms-text-size-adjust: 100%;"
              . "-webkit-text-size-adjust: 100%;"
            . "}"
            . "table {"
              . "border-spacing: 0;"
            . "}"
            . "table td {"
              . "border-collapse: collapse;"
            . "}"
            . ".ExternalClass {"
              . "width: 100%;"
            . "}"
            . ".ExternalClass,"
            . ".ExternalClass p,"
            . ".ExternalClass span,"
            . ".ExternalClass font,"
            . ".ExternalClass td,"
            . ".ExternalClass div {"
              . "line-height: 100%;"
            . "}"
            . ".ReadMsgBody {"
              . "width: 100%;"
              . "background-color: #ebebeb;"
            . "}"
            . "hr {"
              . "color: #d9d9d9;"
              . "background-color: #d9d9d9;"
              . "height: 1px;"
              . "border: none;"
              . "display: block;"
              . "-webkit-margin-before: 0.5em;"
              . "-webkit-margin-after: 0.5em;"
              . "-webkit-margin-start: auto;"
              . "-webkit-margin-end: auto;"
            . "}"
            . "table {"
              . "mso-table-lspace: 0pt;"
              . "mso-table-rspace: 0pt;"
            . "}"
            . "img {"
              . "-ms-interpolation-mode: bicubic;"
              . "outline: none;"
              . "text-decoration: none;"
              . "-ms-interpolation-mode: bicubic;"
              . "width: auto;"
              . "max-width: 100%;"
              . "float: left;"
              . "clear: both;"
              . "display: block;"
            . "}"
            . ".yshortcuts a {"
              . "border-bottom: none !important;"
            . "}"
            . "@media screen and (max-width: 599px) {"
              . "table[class='force-row'],"
              . "table[class='container'] {"
                . "width: 100% !important;"
                . "max-width: 100% !important;"
              . "}"
            . "}"
            . "@media screen and (max-width: 400px) {"
              . "td[class*='container-padding'] {"
                . "padding-left: 12px !important;"
                . "padding-right: 12px !important;"
              . "}"
            . "}"
            . ".ios-footer a {"
              . "color: #aaaaaa !important;"
              . "text-decoration: underline;"
            . "}"
          . "</style>"
        . "</head>"
        . "<body style='margin:0; padding:0;' bgcolor='#ffffff' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>"
          . "<table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0' bgcolor='#F0F0F0'>"
            . "<tr>"
              . "<td align='center' valign='top' bgcolor='white' style='background-color: white;'>"
              . "<!-- 600px container (white background) -->"
                . "<table class='row header' style='background: white;  padding: 0px;width: 100%;position: relative;'>"
                  . "<tr>"
                    . "<td class='center' align='center'>"
                      . "<center>"
                        . "<table class='container' >"
                          . "<tr>"
                            . "<td class='wrapper last' style=' width: 580px; vertical-align: top;text-align: left; margin: 0 auto; padding-right: 0px;  padding: 10px 0px 0px 0px;position: relative;'>"
                              . "<table class='twelve columns' style='margin: 0 auto;'>"
                                . "<tr>"
                                  . "<td class='six sub-columns' style='font-weight: normal; margin: 0;text-align: left; padding-right: 10px; width: 80%;  padding: 0px 0px 10px;'>"
                                    . "<img src='".site_url()."/themes/lte/nubusa/images/logo.png'>"
                                  . "</td>"
                                  . "<td class='six sub-columns last' align='right' style='text-align:right; vertical-align:middle;'>"
                                    . "<span class='template-label'></span>"
                                  . "</td>"
                                  . "<td class='expander'>"
                                  . "</td>"
                                . "</tr>"
                              . "</table>"
                            . "</td>"
                          . "</tr>"
                        . "</table>"
                      . "</center>"
                    . "</td>"
                  . "</tr>"
                  . "<tr>"
                    . "<td class='center' align='center'>"
                      . "<center>"
                        . "<table class='container' >"
                          . "<tr>"
                            . "<td class='wrapper last' style='width: 580px; vertical-align: top;text-align: left; margin: 0 auto; padding-right: 0px;  padding: 10px 0px 0px 0px;position: relative;'>"
                              . "<table class='twelve columns' style='margin: 0 auto;'>"
                                . "<tr>"
                                  . "<td class='six sub-columns' style='font-weight: normal; margin: 0;text-align: left; padding-right: 10px; width: 80%;  padding: 0px 0px 10px;'>"
                                    . "<img src='".site_url()."/themes/antavaya/images/back-header.png' style='max-width:200%;'>"
                                  . "</td>"
                                  . "<td class='six sub-columns last' align='right' style='text-align:right; vertical-align:middle;'>"
                                    . "<span class='template-label'></span>"
                                  . "</td>"
                                  . "<td class='expander'>"
                                  . "</td>"
                                . "</tr>"
                              . "</table>"
                            . "</td>"
                          . "</tr>"
                        . "</table>"
                      . "</center>"
                    . "</td>"
                  . "</tr>"
                . "</table>"
                . "<table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0' bgcolor='#ffffff'>"
                  . "<tr>"
                    . "<td align='center' valign='top' bgcolor='#ffffff' style='background-color: #ffffff;'>"
                      . "<br>"
                      . "<table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px;height: 50px;'>"
                        . "<tr>"
                          . "<td class='container-padding header' align='left'>"
                            . "<span style='font-family:Helvetica, Arial, sans-serif;font-size:27px;font-weight:bold;padding-bottom:12px;color:#DF4726;padding-left:24px;padding-right:24px'>"
                              . "Selamat! Bookingan sedang kami proses"
                            . "</span>"
                            . "<br>"
                            . "<br>"
                            . "<b> Team kami akan menghubungi melalui email untuk selanjutnya.</b>"
                            . "<br>"
                            . "<br>"
                            . "<hr>"
                            . "<b>Detail Book</b>"
                            . "<br>"
                            . "<hr>"
                          . "</td>"
                        . "</tr>"
                      . "</table>"
                    . "</td>"
                  . "</tr>"
                  . "<tr>"
                    . "<td align='center' valign='top' bgcolor='#ffffff' style='background-color: #ffffff;'>"
                      . "<br>"
                      . "<table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px'>"
                        . "<tr>"
                          . "<td class='container-padding content' align='left' style='padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#b9e5ff;'>"
                            . "<table style='font-size:12px;FONT-FAMILY:sans-serif'>"
                              . "<tbody>"
                                . "<tr>"
                                  . "<td>"
                                    . "Kode Pemesanan "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b><a href='".site_url("sitepameran/pameran-umum/confirm-ticket-int-book/{$kirim[0]->id_site_pameran_ticket_int_book}")."' target='_blank'>{$kirim[0]->id_site_pameran_ticket_int_book}</a></b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Nama "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>{$kirim[0]->name}</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "No Telepon "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>{$kirim[0]->telp}</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Email "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>{$kirim[0]->email}</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Tanggal Keberangkatan "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>".date("d F Y", strtotime($kirim[0]->departure_date))."</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Tanggal Kembali "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>".date("d F Y", strtotime($kirim[0]->return_date))."</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Route "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>Jakarta - {$kirim[0]->title} - Jakarta</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Class "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>{$kirim[0]->title_class} ({$kirim[0]->code_class})</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Note "
                                  . "</td>"
                                  . "<td>"
                                    . ": ".nl2br($kirim[0]->catatan)
                                  . "</td>"
                                . "</tr>"
                              . "</tbody>"
                              . "<td>"
                              . "</td>"
                            . "</table>"
                          . "</td>"
                        . "</tr>"
                      . "</table>"
                    . "</td>"
                  . "</tr>"
                  . "<tr>"
                    . "<td align='center' valign='top' bgcolor='#ffffff' style='background-color: #ffffff;'>"
                      . "<table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px'>"
                        . "<tr>"
                          . "<td class='container-padding content' align='left' style='padding-left:24px;padding-top:10px;padding-right:24px;padding-bottom:12px;background-color:#F0F0F0;'>"
                            . "<br>"
                            . "<hr style='padding-left:100%'>"
                          . "</td>"
                          . "<td>"
                          . "</td>"
                        . "</tr>"
                        . "<tr>"
                          . "<td style='font-size:11px;color: #222222;font-family:Helvetica,Arial,sans-serif;font-weight: normal; padding: 0;margin: 0;text-align: left;'>"
                            . "<br><br>"
                          . "</td>"
                        . "</tr>"
                        . "<tr>"
                          . "<td>"
                            . "<img src='".site_url()."/themes/antavaya/images/rsz_back-foot.png' style='max-width: 100%;' />"
                          . "</td>"
                        . "</tr>"
                      . "</table>"
                    . "</td>"
                  . "</tr>"
                . "</table>"
                . "<!--/100% background wrapper-->"
              . "</td>"
            . "</tr>"
          . "</table>"
        . "</body>"
      . "</html>"
      . "";
      
      return $isihtml;
  }
  
  function book_email($kirim){
    
    $isihtml = ""
      . "<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>"
      . "<html lang='en'>"
        . "<head>"
          . "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1'>"
          . "<!-- So that mobile will display zoomed in -->"
          . "<meta http-equiv='X-UA-Compatible' content='IE=edge'>"
          . "<!-- enable media queries for windows phone 8 -->"
          . "<meta name='format-detection' content='telephone=no'>"
          . "<!-- disable auto telephone linking in iOS -->"
          . "<title>Single Column</title>"
          . "<style type='text/css'>"
            . "body {"
              . "margin: 0;"
              . "padding: 0;"
              . "-ms-text-size-adjust: 100%;"
              . "-webkit-text-size-adjust: 100%;"
            . "}"
            . "table {"
              . "border-spacing: 0;"
            . "}"
            . "table td {"
              . "border-collapse: collapse;"
            . "}"
            . ".ExternalClass {"
              . "width: 100%;"
            . "}"
            . ".ExternalClass,"
            . ".ExternalClass p,"
            . ".ExternalClass span,"
            . ".ExternalClass font,"
            . ".ExternalClass td,"
            . ".ExternalClass div {"
              . "line-height: 100%;"
            . "}"
            . ".ReadMsgBody {"
              . "width: 100%;"
              . "background-color: #ebebeb;"
            . "}"
            . "hr {"
              . "color: #d9d9d9;"
              . "background-color: #d9d9d9;"
              . "height: 1px;"
              . "border: none;"
              . "display: block;"
              . "-webkit-margin-before: 0.5em;"
              . "-webkit-margin-after: 0.5em;"
              . "-webkit-margin-start: auto;"
              . "-webkit-margin-end: auto;"
            . "}"
            . "table {"
              . "mso-table-lspace: 0pt;"
              . "mso-table-rspace: 0pt;"
            . "}"
            . "img {"
              . "-ms-interpolation-mode: bicubic;"
              . "outline: none;"
              . "text-decoration: none;"
              . "-ms-interpolation-mode: bicubic;"
              . "width: auto;"
              . "max-width: 100%;"
              . "float: left;"
              . "clear: both;"
              . "display: block;"
            . "}"
            . ".yshortcuts a {"
              . "border-bottom: none !important;"
            . "}"
            . "@media screen and (max-width: 599px) {"
              . "table[class='force-row'],"
              . "table[class='container'] {"
                . "width: 100% !important;"
                . "max-width: 100% !important;"
              . "}"
            . "}"
            . "@media screen and (max-width: 400px) {"
              . "td[class*='container-padding'] {"
                . "padding-left: 12px !important;"
                . "padding-right: 12px !important;"
              . "}"
            . "}"
            . ".ios-footer a {"
              . "color: #aaaaaa !important;"
              . "text-decoration: underline;"
            . "}"
          . "</style>"
        . "</head>"
        . "<body style='margin:0; padding:0;' bgcolor='#ffffff' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>"
          . "<table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0' bgcolor='#F0F0F0'>"
            . "<tr>"
              . "<td align='center' valign='top' bgcolor='white' style='background-color: white;'>"
              . "<!-- 600px container (white background) -->"
                . "<table class='row header' style='background: white;  padding: 0px;width: 100%;position: relative;'>"
                  . "<tr>"
                    . "<td class='center' align='center'>"
                      . "<center>"
                        . "<table class='container' >"
                          . "<tr>"
                            . "<td class='wrapper last' style=' width: 580px; vertical-align: top;text-align: left; margin: 0 auto; padding-right: 0px;  padding: 10px 0px 0px 0px;position: relative;'>"
                              . "<table class='twelve columns' style='margin: 0 auto;'>"
                                . "<tr>"
                                  . "<td class='six sub-columns' style='font-weight: normal; margin: 0;text-align: left; padding-right: 10px; width: 80%;  padding: 0px 0px 10px;'>"
                                    . "<img src='".site_url()."/themes/lte/nubusa/images/logo.png'>"
                                  . "</td>"
                                  . "<td class='six sub-columns last' align='right' style='text-align:right; vertical-align:middle;'>"
                                    . "<span class='template-label'></span>"
                                  . "</td>"
                                  . "<td class='expander'>"
                                  . "</td>"
                                . "</tr>"
                              . "</table>"
                            . "</td>"
                          . "</tr>"
                        . "</table>"
                      . "</center>"
                    . "</td>"
                  . "</tr>"
                  . "<tr>"
                    . "<td class='center' align='center'>"
                      . "<center>"
                        . "<table class='container' >"
                          . "<tr>"
                            . "<td class='wrapper last' style='width: 580px; vertical-align: top;text-align: left; margin: 0 auto; padding-right: 0px;  padding: 10px 0px 0px 0px;position: relative;'>"
                              . "<table class='twelve columns' style='margin: 0 auto;'>"
                                . "<tr>"
                                  . "<td class='six sub-columns' style='font-weight: normal; margin: 0;text-align: left; padding-right: 10px; width: 80%;  padding: 0px 0px 10px;'>"
                                    . "<img src='".site_url()."/themes/antavaya/images/back-header.png' style='max-width:200%;'>"
                                  . "</td>"
                                  . "<td class='six sub-columns last' align='right' style='text-align:right; vertical-align:middle;'>"
                                    . "<span class='template-label'></span>"
                                  . "</td>"
                                  . "<td class='expander'>"
                                  . "</td>"
                                . "</tr>"
                              . "</table>"
                            . "</td>"
                          . "</tr>"
                        . "</table>"
                      . "</center>"
                    . "</td>"
                  . "</tr>"
                . "</table>"
                . "<table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0' bgcolor='#ffffff'>"
                  . "<tr>"
                    . "<td align='center' valign='top' bgcolor='#ffffff' style='background-color: #ffffff;'>"
                      . "<br>"
                      . "<table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px;height: 50px;'>"
                        . "<tr>"
                          . "<td class='container-padding header' align='left'>"
                            . "<span style='font-family:Helvetica, Arial, sans-serif;font-size:27px;font-weight:bold;padding-bottom:12px;color:#DF4726;padding-left:24px;padding-right:24px'>"
                              . "Selamat! Bookingan sedang kami proses"
                            . "</span>"
                            . "<br>"
                            . "<br>"
                            . "<b> Team kami akan menghubungi melalui email untuk selanjutnya.</b>"
                            . "<br>"
                            . "<br>"
                            . "<hr>"
                            . "<b>Detail Book</b>"
                            . "<br>"
                            . "<hr>"
                          . "</td>"
                        . "</tr>"
                      . "</table>"
                    . "</td>"
                  . "</tr>"
                  . "<tr>"
                    . "<td align='center' valign='top' bgcolor='#ffffff' style='background-color: #ffffff;'>"
                      . "<br>"
                      . "<table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px'>"
                        . "<tr>"
                          . "<td class='container-padding content' align='left' style='padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#b9e5ff;'>"
                            . "<table style='font-size:12px;FONT-FAMILY:sans-serif'>"
                              . "<tbody>"
                                . "<tr>"
                                  . "<td>"
                                    . "Kode Pemesanan "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b><a href='".site_url("sitepameran/pameran-umum/confirm-ticket-book/{$kirim[0]->id_site_pameran_ticket_book}")."' target='_blank'>{$kirim[0]->id_site_pameran_ticket_book}</a></b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Nama "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>{$kirim[0]->name}</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "No Telepon "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>{$kirim[0]->telp}</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Email "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>{$kirim[0]->email}</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Title "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>{$kirim[0]->title}</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Tanggal Keberangkatan "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>".date("d F Y", strtotime($kirim[0]->departure_date))."</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Tanggal Kembali "
                                  . "</td>"
                                  . "<td>"
                                    . ": <b>".date("d F Y", strtotime($kirim[0]->return_date))."</b>"
                                  . "</td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "Note "
                                  . "</td>"
                                  . "<td>"
                                    . ": ".nl2br($kirim[0]->note)
                                  . "</td>"
                                . "</tr>"
                              . "</tbody>"
                              . "<td>"
                              . "</td>"
                            . "</table>"
                          . "</td>"
                        . "</tr>"
                      . "</table>"
                    . "</td>"
                  . "</tr>"
                  . "<tr>"
                    . "<td align='center' valign='top' bgcolor='#ffffff' style='background-color: #ffffff;'>"
                      . "<table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px'>"
                        . "<tr>"
                          . "<td class='container-padding content' align='left' style='padding-left:24px;padding-top:10px;padding-right:24px;padding-bottom:12px;background-color:#F0F0F0;'>"
                            . "<br>"
                            . "<hr style='padding-left:100%'>"
                          . "</td>"
                          . "<td>"
                          . "</td>"
                        . "</tr>"
                        . "<tr>"
                          . "<td style='font-size:11px;color: #222222;font-family:Helvetica,Arial,sans-serif;font-weight: normal; padding: 0;margin: 0;text-align: left;'>"
                            . "<br><br>"
                          . "</td>"
                        . "</tr>"
                        . "<tr>"
                          . "<td>"
                            . "<img src='".site_url()."/themes/antavaya/images/rsz_back-foot.png' style='max-width: 100%;' />"
                          . "</td>"
                        . "</tr>"
                      . "</table>"
                    . "</td>"
                  . "</tr>"
                . "</table>"
                . "<!--/100% background wrapper-->"
              . "</td>"
            . "</tr>"
          . "</table>"
        . "</body>"
      . "</html>"
      . "";
      
      return $isihtml;
  }
  
}