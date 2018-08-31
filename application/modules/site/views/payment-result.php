<main role="main" class="body">
    <div id="page-info" data-name="inner order delivery" data-active-page="0" data-menu-target="#top-nav"></div>
    <section class="clearfix header-mobile">
        <div class="container">
            <div class="row">
                <section class="navbar-left">
                    <button type="button" data-target="#top-nav" id="toggle-menu" class="navbar-toggle pull-right"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </section>
                <section class="navbar-brand double">
                    <h3>PENGIRIMAN TIKET</h3>
                    <p>Email: <?php print $data[0]->buyer->email?></p>
                </section>
                <section class="navbar-right"></section>
            </div>
        </div>
    </section>
    <section class="clearfix notification mb-sm-20">
        <div class="container">
            <div class="row">
                <section class="col-md-12">
                    <div class="well white">
                        <div class="media">
                            <div class="media-left">
                                <div class="ic-success">
                                    <div class="fa fa-check"></div>
                                </div>
                            </div>
                            <div class="media-body media-middle">
                                <p>Transaksi berhasil. Terima Kasih telah bertransaksi <strong>di Antavaya.com</strong></p>
                                <p>Tiket dikirimkan ke e-mail terdaftar Anda <strong><?php print $data[0]->buyer->email?></strong></p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <section class="clearfix main-content m-t-30 mt-sm-0">
        <div class="container">
            <div class="row">
                <section class="col-md-8 content-left">
                    <section id="" class="element-item  ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Nomor Pemesanan</h4>
                            </div>
                            <div class="panel-body">
                                <h4><?php print $code?></h4>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="panel panel-primary">
                            <div class="panel-heading visible-lg-min">
                                <h4 class="panel-title">Data Penerbangan</h4>
                            </div>
                            <div class="panel-body">

                                <section class="clearfix element-item">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <section class="visible-lg-min">
                                                <div class="title">
                                                    <h4><span class="fa fa-plane m-r-5"></span> Penerbangan Pergi</h4>
                                                </div>
                                            </section>

                                            <section class="panel-heading nesting visible-md-max">
                                                <h3 class="panel-title">PENERBANGAN PERGI</h3>
                                                
                                            </section>
                                            <section class="visible-md-max">
                                                
                                            </section>
                                          
<?php
$detail_flight = "";
foreach ($data[0]->flight AS $flight){
  $departuretime  = strtotime($flight->departuredate." ".$flight->departuretime);
  $arrivaltime    = strtotime($flight->arrivaldate." ".$flight->arrivaltime);
  $departure = $this->m_site->bandara_info($flight->departure);
  $arrival = $this->m_site->bandara_info($flight->arrival);
  $gt->flightnumber .= " GA-".$flight->number." ({$flight->class})";
  $detail_flight .= ""
    . "<div class='col-sm-7 flight-journey-route'>"
      . "<div class='m-l-5'>"
        . "<section class='origin'>"
          . "<div class='flight-dots'>"
            . "<div class='dot-border'>"
              . "<div class='dot-circle'></div>"
            . "</div>"
          . "</div>"
          . "<div class='flight-time'>"
            . "<h4>".date('H:i', $departuretime)."</h4>"
            . "<p class='small help-block'>"
              . date('Y-m-d', $departuretime)
            . "</p>"
          . "</div>"
          . "<div class='flight-route'>"
            . "<h4>{$departure['city']} ({$departure['code']})</h4>"
            . "<p class='small help-block'>{$departure['title']}</p>"
          . "</div>"
        . "</section>"
        . "<section class='hidden-section'>"
          . "<div class='flight-dots-transit'>"
            . "<div class='dot-none'></div>"
          . "</div>"
          . "<div class='hidden-transit'></div>"
        . "</section>"
        . "<section class='destination'>"
          . "<div class='flight-dots dots-none'>"
            . "<div class='dot-border'>"
              . "<div class='dot-circle'></div>"
            . "</div>"
          . "</div>"
          . "<div class='flight-time'>"
            . "<h4>".date('H:i', $arrivaltime)."</h4>"
            . "<p class='small help-block'>".date('Y-m-d', $arrivaltime)."</p>"
          . "</div>"
          . "<div class='flight-route'>"
            . "<h4>{$arrival['city']} ({$arrival['code']})</h4>"
            . "<p class='small help-block'>{$arrival['title']}</p></div></section></div></div>"
    . "";
}
?>

                                            <section>
                                                <div class="row">
                                                            <div class="col-sm-5 pull-right flight-journey-airline">
                                                                <section class="media">
                                                                    <div class="media-image">
                                                                        <div class="img"><img src="<?php print $url?>assets/images/icons/airline-md-7-GA.png" alt=""></div>
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <p>Garuda Indonesia</p>
                                                                        <p><?php 
                                                                        print $gt->flightnumber;
                                                                        ?></p>
                                                                    </div>
                                                                </section>
                                                                <section class="visible-lg-min">
                                                                    <ol class="detail-descript list-inline">
                                                                        <li>
                                                                            <div data-toggle="tooltip" data-placement="top" title="Tiket kelas EKONOMI">EKONOMI</div>
                                                                        </li>
<!--                                                                        <li>
                                                                            <div data-toggle="tooltip" data-placement="top" title="">0 Transit</div>
                                                                        </li>                                                                        -->
<!--                                                                        <li>
                                                                            <div data-toggle="tooltip" data-placement="top" title="Durasi 2 jam 25 menit">2h 25m</div>
                                                                        </li>-->
                                                                        <li>
                                                                            <div data-toggle="tooltip" data-placement="top" title="Harga barang sudah termasuk bagasi 20 Kg"><span class="fa fa-suitcase"></span> 20 Kg</div>
                                                                        </li>
                                                                                <li>
                                                                                    <div data-toggle="tooltip" data-placement="top" title="Harga sudah termasuk makan"><span class="fa fa-cutlery"></span></div>
                                                                                </li>

                                                                    </ol>
                                                                </section>
                                                            </div>
                                                  <?php
                                                  print $detail_flight;
                                                  ?>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </section>

                            </div>
                        </div>
                    </section>
                    <section id="info-buyer" class="element-item info-buyer ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Data Pemesan</h4>
                            </div>
                            <div class="panel-body">
                                <!--<h4>JENNY </h4>-->
                                <p><?php print $data[0]->buyer->telp?></p>
                                <p><?php print $data[0]->buyer->email?></p>
                            </div>
                        </div>
                    </section>
                    <section id="info-passenger" class="element-item info-passenger ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Data Penumpang</h4>
                            </div>
                            <div class="panel-body">
                                <ol>
                                  <?php
                                  foreach($data[0]->pax AS $pax){
                                    if($pax->pax->type == "ADT")
                                      $info_tambahan = "Dewasa";
                                    if($pax->pax->type == "CHD")
                                      $info_tambahan = "Anak";
                                    if($pax->pax->type == "INF")
                                      $info_tambahan = "Bayi";
                                      
                                    print "<li>{$pax->pax->firstname} {$pax->pax->lastname} <small class='pull-right'>{$pax->pax->number} | {$info_tambahan}</small></li>";
                                  }
                                  ?>
                                </ol>
                            </div>
                        </div>
                    </section>
                    <section id="info-price" class="element-item info-price active">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">Rincian Harga</h4>
                            </div>
                            <div class="panel-body">
                                <section class="element-item">
                                    <table class="table table-transparent">
                                        <colgroup width="65%"></colgroup>
                                        <colgroup width="5%"></colgroup>
                                        <colgroup width="30%"></colgroup>
                                        <tbody>
                                          <tr>
                                            <td><?php print lang("Order")." ".$code?></td>
                                            <td>:</td>
                                            <td class="text-right">IDR <?php print number_format($pay[0]->nominal)?></td>
                                          </tr>
                                          <tr>
                                            <td><?php print lang("Potongan")?></td>
                                            <td>:</td>
                                            <td class="text-right">IDR <?php print number_format($pay[0]->potongan)?></td>
                                          </tr>
                                          <tr>
                                            <td><?php print lang("Tambahan")?></td>
                                            <td>:</td>
                                            <td class="text-right">IDR <?php print number_format($pay[0]->tambahan)?></td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </section>

                            </div>
                            <div class="panel-footer">
                                <section class="element-item">
                                    <table class="table table-transparent">
                                        <colgroup width="50%"></colgroup>
                                        <colgroup width="50%"></colgroup>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p>Total Harga</p>
                                                </td>
                                                <td>
                                                    <h3 class="text-right">IDR <?php print number_format($pay[0]->total)?></h3>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </section>
                            </div>
                        </div>
                    </section>
                    <section class="banner-promo"><a target="_blank" href="https://www.bankmega.com/applynow/"><img src="<?php print $url?>assets/images/repository/banner-promo-left.jpg" alt=""></a></section>
                </section>
                <section class="col-md-4 content-right">
                    <section class="banner-promo visible-md-block visible-lg-block"><a target="_blank" href="https://www.bankmega.com/applynow/"><img src="<?php print $url?>assets/images/repository/banner-promo-right.jpg" alt=""></a></section>
                </section>
            </div>
        </div>
    </section>
</main>