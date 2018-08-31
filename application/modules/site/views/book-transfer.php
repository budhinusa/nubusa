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
                                        <div class="btn-group matchHeight-nowrap"><a href="/Payment/170312155253/MegaCreditCard" class=" btn item"><span>KARTU KREDIT<br>BANK MEGA</span></a></div>
                                        <div class="btn-group matchHeight-nowrap"><a href="/Payment/170312155253/MegaInfiniteCard" class=" btn item"><span>KARTU KREDIT<br>MEGA INFINITE</span></a></div>
                                        <div class="btn-group matchHeight-nowrap"><a href="/Payment/170312155253/RegularCreditCard" class=" btn item"><span>KARTU KREDIT<br><small>VISA</small></span></a></div>
                                        <div class="btn-group matchHeight-nowrap"><a href="/Payment/170312155253/Transfer" class="active btn item"><span>TRANSFER</span></a></div>
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
                                            <h6>Total Harga</h6>
                                            <h3><strong>IDR 2.675.408</strong></h3>
                                                                                            <br>
                                                <small style="color:#C52B36!important">*Silakan meng-klik tombol BAYAR terlebih dahulu sebelum melakukan transfer</small>
                                        </hgroup>
                                    </div>
                                </div>

                                <div class="text-center m-t-20 p-sm-hor-15">
                                    <p><small class="text-muted">Dengan meng-klik tombol BAYAR, Anda menyetujui  <a data-fancybox-type="iframe" class="popup-iframe" href="/Content/Terms/?link=1">Syarat &amp; Ketentuan  </a> dan  <a data-fancybox-type="iframe" class="popup-iframe" href="/Content/Privacy/?link=1">Kebijakan Privasi  </a> Antavaya.com</small></p>
                                    <form method="POST" action="/Booking/MegaInternetPaymentGateway">
                                        <input type="submit" value="BAYAR" class="btn btn-round btn-red btn-lg m-15">
                                    </form>
                                </div>

                        </section>

                <section class="col-md-4 content-right visible-md-block visible-lg-block">
                        <div class="panel panel-grey panel-full flight-time-left">
                            <div class="panel-body">
                                <div class="text-center">
                                    <h2 class="clock-icon">
                                        <div class="sprites sprites-clock-lg"></div>
                                    </h2><small class="text-primary">Sisa Waktu Pembayaran</small>
                                    <h3 class="m-t-0 transfer-coundown">1 jam 59 menit 15 detik</h3>
                                </div>
                            </div>
                        </div>
                    <div class="panel panel-grey panel-full">
                        <div class="panel-heading">
                            <h4 class="panel-title">NOMOR PESANAN</h4>
                        </div>
                        <div class="panel-body">

                            <p>170312155253</p>
                        </div>
                    </div>
                    <div class="panel panel-grey panel-full">
                        <div class="panel-heading">
                            <h4 class="panel-title">HARGA TOTAL</h4>
                        </div>
                        <div class="panel-body">
                            <p>IDR 2.675.408</p>
                        </div>
                    </div>
                        <div class="panel panel-grey panel-full">
                            <div class="panel-heading">
                                <h4 class="panel-title">DETAIL PENERBANGAN</h4>
                            </div>
                            <div class="panel-body">
                                        <figure class="m-t-30">
                                            <ol class="list-inline m-b-15">
                                                <li><img src="/assets/images/icons/airline-4-QG.png" alt=""></li>
                                            </ol>
                                            <figcaption>
                                                <h4 class="m-t-0">JAKARTA (CGK) - SURABAYA (SUB)</h4>
                                                <p><small>Rabu, 19  April 2017 </small><br><small>04:10 - 05:35</small></p>
                                            </figcaption>
                                        </figure>
                                        <figure class="m-t-30">
                                            <ol class="list-inline m-b-15">
                                                <li><img src="/assets/images/icons/airline-4-QG.png" alt=""></li>
                                            </ol>
                                            <figcaption>
                                                <h4 class="m-t-0">SURABAYA (SUB) - Denpasar (DPS)</h4>
                                                <p><small>Rabu, 19  April 2017 </small><br><small>07:30 - 09:30</small></p>
                                            </figcaption>
                                        </figure>
                            </div>
                        </div>

                    <div class="panel panel-grey panel-full">
                        <div class="panel-heading">
                            <h4 class="panel-title">PENUMPANG</h4>
                        </div>
                        <div class="panel-body">
                                    <p>Tuan budhi nusa</p>
                                    <p>Tuan Anjai </p>
                                    <p>Tuan Umar </p>
                                    <p>Tuan Diaz </p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</main>