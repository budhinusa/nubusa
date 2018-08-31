<main role="main" class="body">
    <div id="page-info" data-name="inner article check-order" data-active-page="0" data-menu-target="#top-nav"></div>
    <section class="clearfix header-mobile">
        <div class="container">
            <div class="row">
                <section class="navbar-left">
                    <button type="button" data-target="#top-nav" id="toggle-menu" class="navbar-toggle pull-right"><span class="sr-only">
                        <?php print lang("Toggle navigation")?></span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </section>
                <section class="navbar-brand single">
                    <h3><?php print lang("CEK PESANAN")?></h3>
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
                                <div class="media-left"><a href="/Member/Login?ReturnUrl=%2FTrackingOrder" class="btn btn-round btn-sm btn-red btn-login"> <span class="v-align">LOGIN</span></a></div>
                                <div class="media-body media-middle">
                                    <p>Akses pesanan dengan mudah dari akun Anda</p>
                                    <p>Detail pesanan Anda dapat diakses kapan pun, dimana pun. <a href="/Member/Login?ReturnUrl=%2FTrackingOrder">Login </a>sekarang.</p>
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
                <section class="col-md-12 content-wrap">
                    <section id="info-order">
                        <div class="panel panel-primary">
                            <div class="panel-heading hidden-md-max">
                                <h4 class="panel-title">Cek Pesanan / Konfirmasi Pembayaran</h4>
                                <p class="m-0">Anda pun dapat melanjutkan transaksi yang belum usai, maks. 2 jam dari waktu awal pemesanan Anda.</p>
                            </div>
                            <div class="panel-body">
                                <div class="visible-md-max">
                                    <p>Anda pun dapat melanjutkan transaksi yang belum usai, maks. 2 jam dari waktu awal pemesanan Anda.</p>
                                </div>
                                <form action="" method="post">
                                    <div class="alert alert-danger hidden">
                                        Nomor pemesanan tidak ditemukan, pastikan Anda memasukan data dengan benar
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="label-wrap">
                                                    <label>Kode Pemesanan</label>
                                                </div>
                                                <input type="text" name="order" required class="form-control booking-numb"><small class="help-block">Masukan kode pemesanan yang telah Anda dapatkan di e-mail pemesan</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 btn-wrap">
                                        <input type="submit" value="Cek Pesanan" class="btn btn-round btn-red btn-md btn-check-order">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </section>
            </div>
        </div>
    </section>
</main>