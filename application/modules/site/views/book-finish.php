<?php
//$total = 0;
//$info_flight = $info_pax = "";
//foreach($data->data AS $dt){
//  $total += $dt->monetary->total;
//  $departuredate = strtotime($dt->flight[0]->departuredate);
//  $hari = $this->global_variable->hari17();
//  $title = $this->global_variable->title();
//  foreach($dt->flight AS $df){
//    $info['departure'] = $this->m_site->bandara_info($df->departure);
//    $info['arrival'] = $this->m_site->bandara_info($df->arrival);
//    $info_flight .= ""
//      . "<figure class='m-t-30'>"
//        . "<ol class='list-inline m-b-15'>"
//          . "<li><img src='{$url}assets/images/icons/airline-7-GA.png' alt=''></li>"
//        . "</ol>"
//        . "<figcaption>"
//          . "<h4 class='m-t-0'>{$info['departure']['city']} ({$info['departure']['code']}) - {$info['arrival']['city']} ({$info['arrival']['code']})</h4>"
//          . "<p>"
//            . "<small>{$hari[date("N", $departuredate)]}, ".date("d F Y", $departuredate)." </small><br>"
//            . "<small>{$df->departuretime} - {$df->arrivaltime}</small>"
//          . "</p>"
//        . "</figcaption>"
//      . "</figure>"
//      . "";
//  }
//}
//
//foreach ($pax AS $px){
//  $info_pax .= "<p>{$title[$px->title]} {$px->firstname} {$px->lastname}</p>";
//}

?>
<main role="main" class="body">
    <div id="page-info" data-name="inner payment" data-active-page="0" data-menu-target="#top-nav"></div>
    <script>
        var transferTime = "2017/03/12 17:53:08"
    </script>
    <section class="clearfix header-mobile">
        <div class="container">
            <div class="row">
                <section class="navbar-left">
                    <button type="button" data-target="#top-nav" id="toggle-menu" class="navbar-toggle pull-right"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </section>
                <section class="navbar-brand double">
                    <h3>PEMBAYARAN PEMESANAN</h3>
                    <p>Sisa Waktu Pembayaran: <span class="transfer-coundown"> </span></p>
                </section>
                <section class="navbar-right">
                    <a href="/Member/Login" class="btn btn-round btn-xs btn-white btn-detail"> <span class="v-align">LOGIN</span></a>
                </section>
            </div>
        </div>
    </section>
            <section class="clearfix notification mb-sm-20">
                <div class="container">
                    <div class="row">
                        <section class="col-md-12">
                            <div class="well white">
                                <div class="media">
                                    <div class="media-body media-middle">
                                        <p>Selamat! Tiket Anda telah berhasil dipesan. Mohon selesaikan pembayaran untuk menghindari pembatalan oleh maskapai terpilih.</p>
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
                        <section class="col-md-8 content-left pull-md-right">

                                <div class="panel panel-primary panel-method-payment">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">PILIH METODE PEMBAYARAN</h4>
                                    </div>
                                    <div class="panel-body">
                                      <?php
                                      $code_payment = ($code_payment ? $code_payment : $payment_channel['data'][0]['id']);
                                      foreach ($payment_channel['data'] AS $pc){
                                        $active = ($pc['id'] == $code_payment ? 'active' : '');
                                        print "<div class='btn-group matchHeight-nowrap'>"
                                          . "<a href='".site_url("erp/site/book-result/{$kode}/{$pc['id']}")."' class='{$active} btn item'>"
                                            . "<span>{$pc['title']}</span>"
                                          . "</a>"
                                        . "</div>";
                                      }
                                      ?>
                                    </div>
                                </div>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">TOTAL PEMBAYARAN</h4>
                                    </div>
                                    <div class="panel-body">
                                    <a data-toggle="collapse" data-target="#form-diskon" class="collapsed"><small class="text-primary">Punya kode promo atau kode voucher Antavaya.com?</small></a>
                                <div id="form-diskon" class="collapse coupon-code m-t-15">
                                    <div class="form-inline">
                                        <form action="/Booking/validateVoucher" method="POST">
                                            <div class="form-group coupon-input">
                                                <input type="hidden" name="ordernum" value="170312155253">
                                                <input type="text" name="voucher" placeholder="Masukan kode disini" class="form-control">
                                            </div>
                                            <div class="form-group coupon-submit m-l-15">
                                                <input type="submit" value="VALIDASI" class="btn btn-round btn-red btn-sm">
                                            </div>
                                        </form>
                                    </div>
                                </div>



                                        <hgroup>
                                                    <h5><s>IDR <?php print number_format($total);
                                                    $diskon = $this->global_fungsi->diskon(2, $total);
                                                    ?></s></h5>
                                            <h6>Total Harga</h6>
                                            <h3><strong>IDR <?php print number_format($diskon['result'])?></strong></h3>
                                                                                    </hgroup>
                                    </div>
                                </div>

                                <div class="text-center m-t-20 p-sm-hor-15">
                                    <p><small class="text-muted">Dengan meng-klik tombol BAYAR, Anda menyetujui  <a data-fancybox-type="iframe" class="popup-iframe" href="/Content/Terms/?link=1">Syarat &amp; Ketentuan  </a> dan  <a data-fancybox-type="iframe" class="popup-iframe" href="/Content/Privacy/?link=1">Kebijakan Privasi  </a> Antavaya.com</small></p>
                                    <form method="POST" action="<?php print site_url("site/book-payment")?>">
                                        <input type="text" name="pnrid" value="<?php print $kode?>" style="display: none">
                                        <input type="text" name="id_crm_payment_channel" value="<?php print $code_payment?>" style="display: none">
                                        <input type="submit" value="BAYAR" class="btn btn-round btn-red btn-lg m-15">
                                    </form>
                                </div>

                        </section>

                <section class="col-md-4 content-right visible-md-block visible-lg-block">
                    <div class="panel panel-grey panel-full">
                        <div class="panel-heading">
                            <h4 class="panel-title">NOMOR PESANAN</h4>
                        </div>
                        <div class="panel-body">

                            <p><?php print $kode?></p>
                        </div>
                    </div>
                    <div class="panel panel-grey panel-full">
                        <div class="panel-heading">
                            <h4 class="panel-title">HARGA TOTAL</h4>
                        </div>
                        <div class="panel-body">
                            <p>IDR <?php
                            print number_format($total);
                            ?></p>
                        </div>
                    </div>
                        <div class="panel panel-grey panel-full">
                            <div class="panel-heading">
                                <h4 class="panel-title">DETAIL PENERBANGAN</h4>
                            </div>
                            <div class="panel-body">
                              <?php print $info_flight;?>
                            </div>
                        </div>

                    <div class="panel panel-grey panel-full">
                        <div class="panel-heading">
                            <h4 class="panel-title">PENUMPANG</h4>
                        </div>
                        <div class="panel-body">
                          <?php print $info_pax?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</main>