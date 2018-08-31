
<div id="page-info" data-name="home" data-active-page="0" data-menu-target="#top-nav"></div>
<section class="clearfix home-jumbotron">
<!--    <div class="container">
        <div class="col-md-12 wrap" style="top: 40px !important;">
          <div class="home-jumbotron-form" style="min-height: 0px !important;">
                <div class="middle">
                    <figure class="logo"><img src="<?php print $url?>assets/images/icons/home-antavaya-lg.png" alt="AntaVaya"></figure>
                    <div class="well matchHeight">
                        <span id="messageBox"></span>
                        <div id="form-field-clone" class="item col-md-10">
                            <fieldset class="form-inline form-field">
                                <div class="form-group from">
                                    <div class="label-wrap">
                                        <label><?php print lang("Dari")?></label>
                                    </div>
                                    <div class="input-wrap">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <div class="fa fa-plane"></div>
                                            </span>
                                            <div class="selectCity-wrap">
                                                <input type="text" name="selectCity" value="Jakarta (CGK)" data-flight-type="origin" class="input-from form-control selectCity">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group switch">
                                    <div class="input-wrap"><a href="#right" class="btn btn-link btn-switch switch-to-right"><span class="fa fa-caret-right"></span></a><a href="#left" class="btn btn-link btn-switch switch-to-left"><span class="fa fa-caret-left"></span></a></div>
                                </div>
                                <div class="form-group to">
                                    <div class="label-wrap">
                                        <label>Ke</label>
                                    </div>
                                    <div class="input-wrap">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <div class="fa fa-plane fa-rotate-90"></div>
                                            </span>
                                            <div class="selectCity-wrap">
                                                <input type="text" name="selectCity" value="Denpasar-Bali (DPS)" data-flight-type="destination" class="input-to form-control selectCity">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group depart">
                                    <div class="label-wrap">
                                        <label>Pergi</label>
                                    </div>
                                    <div class="input-wrap">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <div class="fa fa-calendar"></div>
                                            </span>
                                          <input type="text" value="<?php print date("Y-m-d", strtotime("+1 day"))?>" name="depart" class="form-control datepicker-multi from datepicker-from date-depart-desktop">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group return">
                                    <div class="label-wrap">
                                        <div class="checkbox checkbox-danger">
                                            <input type="checkbox" checked name="return-check" id="form-group-return" class="return-checkbox is-return-desktop">
                                            <label for="form-group-return">Pulang</label>
                                        </div>
                                    </div>
                                    <div class="input-wrap">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <div class="fa fa-calendar"></div>
                                            </span>
                                            <input type="text" value="<?php print date("Y-m-d", strtotime("+2 days"))?>" name="return" class="form-control datepicker-multi to datepicker-to date-return-desktop">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group passenger">
                                    <div class="label-wrap">
                                        <label>Penumpang</label>
                                    </div>
                                    <div class="input-wrap">
                                        <div data-toggle="dropdown" class="dropdown spinner-dropdown">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <div class="fa fa-user"></div>
                                                </span>
                                                <input type="text" name="passenger-total" value="1" class="form-control spinner-dropdown-total">
                                            </div>
                                            <div class="dropdown-menu passenger-dd-spinner">
                                                <div class="form-inline">
                                                    <div class="form-group">
                                                        <label>Dewasa <small>(12+ tahun)</small></label>
                                                        <input type="number" value="1" min="1" name="passenger-adult" readonly class="ui-spinner adult psgr-adult-desktop">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Anak <small>(2-12 tahun)</small></label>
                                                        <input type="number" value="0" min="0" name="passenger-kids" readonly class="ui-spinner kids psgr-child-desktop">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bayi <small>(&lt; 2 tahun)</small></label>
                                                        <input type="number" value="0" min="0" name="passenger-baby" readonly class="ui-spinner babies psgr-infant-desktop">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-inline form-opt">
                                <div class="form-group">
                                    <div class="checkbox checkbox-danger">
                                        <input type="radio" checked value="EKONOMI" name="flight-type" id="form-opt-economy" class="flightType">
                                        <label for="form-opt-economy">Ekonomi</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox checkbox-danger">
                                        <input type="radio" value="BISNIS" name="flight-type" id="form-opt-business" class="flightType">
                                        <label for="form-opt-business">Bisnis</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="cari-tiket-clone" class="item col-md-2 text-right cari-tiket">
                            <input type="hidden" id="ajax-journey-origin" value="CGK" />
                            <input type="hidden" id="ajax-journey-destination" value="DPS" />
                            <input type="hidden" id="ajax-is-return" value="0" />
                            <input type="hidden" id="ajax-date-depart" value="2017-1-12" />
                            <input type="hidden" id="ajax-date-return" value="2017-1-13" />
                            <input type="hidden" id="ajax-psgr-adult" value="1" />
                            <input type="hidden" id="ajax-psgr-child" value="0" />
                            <input type="hidden" id="ajax-psgr-infant" value="0" />
                            <form method="GET" action="<?php print site_url("site/flight")?>">
                                <input type="hidden" id="ajax-journey" value="CGK.DPS" name="journey" />
                                <input type="hidden" id="ajax-date" value="2017-01-29" name="date" />
                                <input type="hidden" id="ajax-psgr" value="1.0.0" name="psgr" />
                                <input type="hidden" id="ajax-flight-type" value="EKONOMI" name="ct" />
                                <input type="image" src="<?php print $url?>assets/images/icons/btn-cari-tiket.png" alt="Cari Tiket" value="ticket-src" class="btn btn-lg btn-cari-tiket">
                            </form>
                        </div>
                    </div>
                    <div class="text-right photo-location"><small>Antavaya.com</small></div>
                </div>
            </div>
        </div>
    </div>-->
<!--    <div class="home-jumbotron-foot">
        <section class="clearfix header-ceil">
            <div class="container">
                <div class="row matchHeight">
                    <div class="col-sm-4 logo item">
                        <button type="button" data-target="#top-nav" id="toggle-menu" class="navbar-toggle pull-right"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                        <a href="index.html" class="navbar-brand"><img src="<?php print $url?>assets/images/icons/home-antavaya-sm-clean.png" alt="AntaVaya"></a>
                    </div>
                    <div class="col-sm-8 text-right main-nav item">
                        <ol class="list-inline">
                            <li class="flight"><a href="#"><span class="fa fa-plane"></span></a></li>
                            <li class="hotel"><a href="#"><span class="fa fa-building"></span></a></li>
                            <li class="order"><a href="<?php print site_url("site/cek-pesanan")?>">CEK PESANAN</a></li>
                            <li class="language">
                                <div class="dropdown">
                                    <div data-toggle="dropdown">BHS  <span class="caret"></span></div>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php print site_url("site/change-lang/id")?>">Bahasa</a></li>
                                        <li><a href="<?php print site_url("site/change-lang/en")?>">English</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="currency">
                                <div class="dropdown">
                                    <div data-toggle="dropdown">IDR  <span class="caret"></span></div>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">IDR</a></li>
                                        <li><a class="disabled" href="#">USD</a></li>
                                    </ul>
                                </div>
                            </li>
                                <li class="login"><a href="Member/Login650d.html?ReturnUrl=%2F" class="sprites sprites-btn-login-white"></a></li>
                          <li class="order"><a href="http://antavaya-leisure.com/">TOUR/LEISURE</a></li>
                          <li class="order"><a href="http://antaumroh.com/">UMROH</a></li>
                          <li class="order"><a href="#">CORPORATE</a></li>
                          <li class="order"><a href="http://antavaya-destination.com">DESTINATION</a></li>
                          <li class="order"><a href="http://antavaya-transportation.com/">TRANSPORTATION</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </section>
    </div>-->
<!--    <div id="home-banner-slide" class="home-banner">
        <figure style="background-image:url(<?php print site_url("file/index/cms-banner-promo/{$bg[0]->id_cms_banner_promo}")?>)" class="slide"></figure>
    </div>-->
    <div id="home-slide-sect2">
    <?php
    foreach ($banner AS $ban){
      print ""
      . "<a href='".($ban->link ? $ban->link : "antavaya.com")."' class='yellow slide'>"
        . "<img data-adaptive-background src='".site_url("file/index/cms-banner-promo/{$ban->id_cms_banner_promo}")."' alt=''>"
      . "</a>"
      . "";
    }
    foreach ($banner2 AS $ban){
      print ""
      . "<a href='".($ban->link ? $ban->link : "antavaya.com")."' class='yellow slide'>"
        . "<img data-adaptive-background src='".site_url("file/index/cms-banner-promo/{$ban->id_cms_banner_promo}")."' alt=''>"
      . "</a>"
      . "";
    }
    ?>
    </div>
    <!--div class="img-info">Foto: Pulau Tidung - Indonesia</div-->
</section>

<!--<section style="background-image:url(//antavaya-leisure.com/themes/antavaya/img/rawpixel-com-191102.jpg)" class="clearfix hidden-sm hidden-xs home-ticket-board bg-cover">-->
<section class="services-1 pt-120 pb-120">
  <div class="container pl-xs-15 pr-xs-15 pl-0 pr-0">
    <div class="section-head center">
      <h1 class="header-text center" style="text-align: center">hot deals</h1>
    </div>
    <div class="services-1-content">
      
    <?php
    $r = 0;
    $b = 0;
    foreach ($tour->data AS $tr){
      if($r < 3){
        $baris[$b][] = $tr;
        $r++;
      }
      else{
        $r = 0;
        $b++;
        $baris[$b][] = $tr;
      }
    }
    
    foreach ($cadangan->data AS $tr){
      if($r < 3){
        $baris[$b][] = $tr;
        $r++;
      }
      else{
        $r = 0;
        $b++;
        $baris[$b][] = $tr;
      }
    }
    
//    print "<pre>";
//    print_r($baris);
//    print "</pre>";
    print "<div class='row'>";
    foreach ($baris[0] AS $tr){
      print ""
      . "<div class='services-1-content-item pt-xs-30 pl-xs-0 pr-xs-0 col-md-4 col-sm-6 pt-sm-50 pl-0 pr-0'>"
        . "<div class='services-1-content-1st-col ml-sm-30 ml-xs-70 mr-xs-15 mr-sm-30 ml-xs-70 ml-xxs-30 mr-xxs-0 mr-xs-15 pl-80 pl-xs-60 pr-25 pr-xs-10 pos-r'>"
          . "<h2 class='section-sub-head' style='line-height: unset; padding-top: unset; padding-bottom: unset; position: unset;'>{$tr->title}</h2>"
          . "<p class='text'>{$tr->destination}</p>"
          . "<i>".($tr->file_thumb ? "<img src='{$tr->file_thumb}' width='100%' />" : "<img src='".site_url()."/files/avatar.png' width='100%' />")."</i>"
        . "</div>"
      . "</div>"
      . "";
    }
    print "</div>";
    print "<div class='row'>";
    foreach ($baris[1] AS $tr){
      print ""
      . "<div class='services-1-content-item pt-xs-30 pl-xs-0 pr-xs-0 col-md-4 col-sm-6 pt-sm-50 pl-0 pr-0'>"
        . "<div class='services-1-content-1st-col ml-sm-30 ml-xs-70 mr-xs-15 mr-sm-30 ml-xs-70 ml-xxs-30 mr-xxs-0 mr-xs-15 pl-80 pl-xs-60 pr-25 pr-xs-10 pos-r'>"
          . "<h2 class='section-sub-head' style='line-height: unset; padding-top: unset; padding-bottom: unset; position: unset;'>{$tr->title}</h2>"
          . "<p class='text'>{$tr->destination}</p>"
          . "<i>".($tr->file_thumb ? "<img src='{$tr->file_thumb}' width='100%' />" : "<img src='".site_url()."/files/avatar.png' width='100%' />")."</i>"
        . "</div>"
      . "</div>"
      . "";
    }
    print "</div>";
    ?>
    </div>
  </div>
</section>

<!--<section class="clearfix form-field-sm">
    <div class="container">
        <div class="item">
            <fieldset class="form-inline form-field">
                <div class="form-group from">
                    <div class="label-wrap">
                        <label>Dari</label>
                    </div>
                    <div class="input-wrap">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div class="fa fa-plane"></div>
                            </span>
                            <div class="selectCity-wrap">
                                <input type="text" name="selectCity" value="Jakarta (CGK)" data-flight-type="origin" class="form-control selectCity-mobile input-from">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group switch">
                    <div class="input-wrap"><a href="#right" class="btn btn-link btn-switch switch-to-right"><span class="fa fa-caret-right"></span></a><a href="#left" class="btn btn-link btn-switch switch-to-left"><span class="fa fa-caret-left"></span></a></div>
                </div>
                <div class="form-group to">
                    <div class="label-wrap">
                        <label>Ke</label>
                    </div>
                    <div class="input-wrap">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div class="fa fa-plane fa-rotate-90"></div>
                            </span>
                            <div class="selectCity-wrap">
                                <input type="text" name="selectCity" value="Bali (DPS)" data-flight-type="destination" class="form-control selectCity-mobile input-to">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group depart">
                    <div class="label-wrap">
                        <label><?php print lang("Pergi")?></label>
                    </div>
                    <div class="input-wrap">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div class="fa fa-calendar"></div>
                            </span>
                          <input type="text" value="<?php print date("d-m-Y")?>" name="depart" class="form-control datepicker-from-mobile date-depart-mobile">
                        </div>
                    </div>
                </div>
                <div class="form-group return">
                    <div class="label-wrap">
                        <div class="checkbox checkbox-danger">
                            <input type="checkbox" checked name="return-check" id="form-group-return-sm" class="return-checkbox is-return-mobile">
                            <label for="form-group-return-sm">Pulang</label>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <div class="fa fa-calendar"></div>
                            </span>
                            <input type="text" value="<?php print date("d-m-Y", strtotime("+1 day"))?>" name="return" class="form-control datepicker-to-mobile date-return-mobile">
                        </div>
                    </div>
                </div>
                <div class="form-group passenger spinner-dropdown">
                    <input type="text" name="passenger-total" hidden class="spinner-dropdown-total">
                    <div class="passenger-dd-spinner">
                        <div class="form-inline">
                            <div class="form-group">
                                <label>Dewasa <small>(12+ tahun)</small></label>
                                <input type="number" value="1" min="1" name="passenger-adult" readonly class="ui-spinner adult psgr-adult-mobile">
                            </div>
                            <div class="form-group">
                                <label>Anak <small>(2-12 tahun)</small></label>
                                <input type="number" value="0" min="0" name="passenger-kids" readonly class="ui-spinner kids psgr-child-mobile">
                            </div>
                            <div class="form-group">
                                <label>Bayi <small>(&lt; 2 tahun)</small></label>
                                <input type="number" value="0" min="0" name="passenger-baby" readonly class="ui-spinner babies psgr-infant-mobile">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="form-inline form-opt">
                <div class="form-group">
                    <div class="checkbox checkbox-danger">
                        <input type="radio" checked value="EKONOMI" name="flight-type-mobile" id="form-opt-economy-sm" class="flightTypeMobile">
                        <label for="form-opt-economy-sm">Ekonomi</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox checkbox-danger">
                        <input type="radio" value="BISNIS" name="flight-type-mobile" id="form-opt-business-sm" class="flightTypeMobile">
                        <label for="form-opt-business-sm">Bisnis</label>
                    </div>
                </div>

            </div>
            <span id="messageBox"></span>
        </div>
        <div class="item text-right cari-tiket">
            <input type="hidden" id="ajax-mobile-journey-origin" value="CGK" />
            <input type="hidden" id="ajax-mobile-journey-destination" value="DPS" />
            <input type="hidden" id="ajax-mobile-is-return" value="0" />
            <input type="hidden" id="ajax-mobile-date-depart" value="2017-1-12" />
            <input type="hidden" id="ajax-mobile-date-return" value="2017-1-13" />
            <input type="hidden" id="ajax-mobile-psgr-adult" value="1" />
            <input type="hidden" id="ajax-mobile-psgr-child" value="0" />
            <input type="hidden" id="ajax-mobile-psgr-infant" value="0" />
            <form method="GET" action="<?php print site_url("site/flight")?>">
                <input type="hidden" id="ajax-mobile-journey" value="CGK.DPS" name="journey" />
                <input type="hidden" id="ajax-mobile-date" value="2017-01-29" name="date" />
                <input type="hidden" id="ajax-mobile-psgr" value="1.0.0" name="psgr" />
                <input type="hidden" id="ajax-mobile-flight-type" value="EKONOMI" name="ct" />
                <input type="submit" value="Cari Tiket" class="btn btn-round btn-red btn-lg btn-cari-tiket">
            </form>
        </div>
    </div>
</section>-->
<!--<section style="background-image:url(<?php print $url?>img/29%5ebanner-promo.jpg)" class="clearfix hidden-sm hidden-xs home-ticket-board bg-cover">
    <div class="container">
        <div class="panel panel-dark">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="panel-title"><img src="<?php print $url?>assets/images/icons/home-ticket-board-plane.png" alt=""> Tiket Pesawat Murah</h1>
                    </div>
                    <div class="col-md-6 text-right">
                        <fieldset>
                            <ul class="list-inline cheap-ticket">
                                <li>
                                    <div class="selectCity-wrap">
                                        <input type="text" value="Jakarta (CGK)" data-airport-code="CGK" data-flight-type="origin" id="cheapFlightFrom" class="input-from form-control selectPopularCity">
                                    </div>
                                </li>
                                <li>
                                    <div class="selectCity-wrap">
                                        <input type="text" value="Denpasar (DPS)" data-airport-code="DPS" data-flight-type="destination" id="cheapFlightTo" class="input-to form-control selectPopularCity">
                                    </div>
                                </li>
                            </ul>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-ticket-board">
                    <thead>
                        <tr>
                            <th width="150">Tanggal</th>
                            <th width="110">Maskapai</th>
                            <th>Dari</th>
                            <th>Ke</th>
                            <th width="200">Harga</th>
                            <th width="50">Sebar</th>
                        </tr>
                    </thead>
                    <tbody id="cheapFlightBlock">

                                <tr>
                                    <td><small class="th-on-sm">Tanggal</small><span><a href="Flight3ee9.html?journey=CGK.DPS&amp;date=09-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI">09 Maret 2017</a></span></td>
                                    <td><small class="th-on-sm">Maskapai</small><span><a href="Flight3ee9.html?journey=CGK.DPS&amp;date=09-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI"><img src="<?php print $url?>assets/images/icons/airline-3.png" alt=""></a></span></td>
                                    <td><small class="th-on-sm">Kota Asal</small><span>JAKARTA (CGK)</span></td>
                                    <td><small class="th-on-sm">Kota Tujuan</small><span>Denpasar (DPS)</span></td>
                                    <td><small class="th-on-sm">Harga</small><span>MULAI DARI RP 555.000</span></td>
                                    <td>
                                        <small class="th-on-sm">Sebar</small><span>
                                            <div class="socmed-toggle">
                                                <div class="btn-group dropup">
                                                    <div data-toggle="dropdown" class="btn dropdown-toggle"><span class="fa fa-share-alt"></span></div>
                                                    <div class="dropdown-menu">
                                                        <ol class="socmed-rounded-sm list-inline">
                                                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-facebook-small"></i></a></li>
                                                            <li><a href="http://twitter.com/home?status=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-twitter-small"></i></a></li>
                                                            <li><a href="https://plus.google.com/share?url=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-google-plus-small"></i></a></li>
                                                            <li><a href="#" onclick=""><i class="sprites sprites-email-small"></i></a></li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><small class="th-on-sm">Tanggal</small><span><a href="Flight78ca.html?journey=CGK.DPS&amp;date=10-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI">10 Maret 2017</a></span></td>
                                    <td><small class="th-on-sm">Maskapai</small><span><a href="Flight78ca.html?journey=CGK.DPS&amp;date=10-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI"><img src="<?php print $url?>assets/images/icons/airline-4.png" alt=""></a></span></td>
                                    <td><small class="th-on-sm">Kota Asal</small><span>JAKARTA (CGK)</span></td>
                                    <td><small class="th-on-sm">Kota Tujuan</small><span>Denpasar (DPS)</span></td>
                                    <td><small class="th-on-sm">Harga</small><span>MULAI DARI RP 702.350</span></td>
                                    <td>
                                        <small class="th-on-sm">Sebar</small><span>
                                            <div class="socmed-toggle">
                                                <div class="btn-group dropup">
                                                    <div data-toggle="dropdown" class="btn dropdown-toggle"><span class="fa fa-share-alt"></span></div>
                                                    <div class="dropdown-menu">
                                                        <ol class="socmed-rounded-sm list-inline">
                                                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-facebook-small"></i></a></li>
                                                            <li><a href="http://twitter.com/home?status=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-twitter-small"></i></a></li>
                                                            <li><a href="https://plus.google.com/share?url=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-google-plus-small"></i></a></li>
                                                            <li><a href="#" onclick=""><i class="sprites sprites-email-small"></i></a></li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><small class="th-on-sm">Tanggal</small><span><a href="Flightd6b9.html?journey=CGK.DPS&amp;date=11-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI">11 Maret 2017</a></span></td>
                                    <td><small class="th-on-sm">Maskapai</small><span><a href="Flightd6b9.html?journey=CGK.DPS&amp;date=11-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI"><img src="<?php print $url?>assets/images/icons/airline-4.png" alt=""></a></span></td>
                                    <td><small class="th-on-sm">Kota Asal</small><span>JAKARTA (CGK)</span></td>
                                    <td><small class="th-on-sm">Kota Tujuan</small><span>Denpasar (DPS)</span></td>
                                    <td><small class="th-on-sm">Harga</small><span>MULAI DARI RP 465.000</span></td>
                                    <td>
                                        <small class="th-on-sm">Sebar</small><span>
                                            <div class="socmed-toggle">
                                                <div class="btn-group dropup">
                                                    <div data-toggle="dropdown" class="btn dropdown-toggle"><span class="fa fa-share-alt"></span></div>
                                                    <div class="dropdown-menu">
                                                        <ol class="socmed-rounded-sm list-inline">
                                                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-facebook-small"></i></a></li>
                                                            <li><a href="http://twitter.com/home?status=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-twitter-small"></i></a></li>
                                                            <li><a href="https://plus.google.com/share?url=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-google-plus-small"></i></a></li>
                                                            <li><a href="#" onclick=""><i class="sprites sprites-email-small"></i></a></li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><small class="th-on-sm">Tanggal</small><span><a href="Flighta8dc.html?journey=CGK.DPS&amp;date=12-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI">12 Maret 2017</a></span></td>
                                    <td><small class="th-on-sm">Maskapai</small><span><a href="Flighta8dc.html?journey=CGK.DPS&amp;date=12-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI"><img src="<?php print $url?>assets/images/icons/airline-4.png" alt=""></a></span></td>
                                    <td><small class="th-on-sm">Kota Asal</small><span>JAKARTA (CGK)</span></td>
                                    <td><small class="th-on-sm">Kota Tujuan</small><span>Denpasar (DPS)</span></td>
                                    <td><small class="th-on-sm">Harga</small><span>MULAI DARI RP 351.000</span></td>
                                    <td>
                                        <small class="th-on-sm">Sebar</small><span>
                                            <div class="socmed-toggle">
                                                <div class="btn-group dropup">
                                                    <div data-toggle="dropdown" class="btn dropdown-toggle"><span class="fa fa-share-alt"></span></div>
                                                    <div class="dropdown-menu">
                                                        <ol class="socmed-rounded-sm list-inline">
                                                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-facebook-small"></i></a></li>
                                                            <li><a href="http://twitter.com/home?status=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-twitter-small"></i></a></li>
                                                            <li><a href="https://plus.google.com/share?url=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-google-plus-small"></i></a></li>
                                                            <li><a href="#" onclick=""><i class="sprites sprites-email-small"></i></a></li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><small class="th-on-sm">Tanggal</small><span><a href="Flightae46.html?journey=CGK.DPS&amp;date=13-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI">13 Maret 2017</a></span></td>
                                    <td><small class="th-on-sm">Maskapai</small><span><a href="Flightae46.html?journey=CGK.DPS&amp;date=13-03-2017&amp;psgr=1.0.0&amp;ct=EKONOMI"><img src="<?php print $url?>assets/images/icons/airline-4.png" alt=""></a></span></td>
                                    <td><small class="th-on-sm">Kota Asal</small><span>JAKARTA (CGK)</span></td>
                                    <td><small class="th-on-sm">Kota Tujuan</small><span>Denpasar (DPS)</span></td>
                                    <td><small class="th-on-sm">Harga</small><span>MULAI DARI RP 351.000</span></td>
                                    <td>
                                        <small class="th-on-sm">Sebar</small><span>
                                            <div class="socmed-toggle">
                                                <div class="btn-group dropup">
                                                    <div data-toggle="dropdown" class="btn dropdown-toggle"><span class="fa fa-share-alt"></span></div>
                                                    <div class="dropdown-menu">
                                                        <ol class="socmed-rounded-sm list-inline">
                                                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-facebook-small"></i></a></li>
                                                            <li><a href="http://twitter.com/home?status=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-twitter-small"></i></a></li>
                                                            <li><a href="https://plus.google.com/share?url=http://antavaya.com/?journey=CGK.DPS&amp;date=01-03-2017.17-03-2017&amp;psgr=1.0.0&amp;x=45&amp;y=49" onclick="window.open(this.href, 'targetWindow', 'left=20,top=20,width=800,height=600,left=0,top=0,toolbar=0,resizable= 1'); return false;"><i class="sprites sprites-google-plus-small"></i></a></li>
                                                            <li><a href="#" onclick=""><i class="sprites sprites-email-small"></i></a></li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </td>
                                </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>-->
<!--<div class="banner-mini-pop-2">
        <script>
            window.onload = function () {
                $('.banner-mini-pop-2').find('.btn').on('click', function () {
                    $(this).parents('.group').fadeOut();
                });
            };
        </script>
        <?php
        if($hot){
          print ""
          . "<div class='group'>"
            . "<a href='".($hot[0]->link ? $hot[0]->link : "antavaya.com")."' class='yellow slide'>"
              . "<img data-adaptive-background src='".site_url("file/index/cms-banner-promo/{$hot[0]->id_cms_banner_promo}")."' alt=''>"
            . "</a>"
            . "<button type='button' class='btn btn-clean'><i class='fa fa-close'></i></button>"
          . "</div>"
          . "";
        }
        ?>
		
        
        
        <div class="group hide">
            <a href="http://bit.ly/mdwebav" style="display:block"><img src="files/site/banner/mayday.jpg" alt=""></a>
            <button type="button" class="btn btn-clean"><i class="fa fa-close"></i></button>
        </div>
        <div class="group hide">
            <a href="http://bit.ly/mapopav" style="display:block"><img src="files/site/banner/antavaya-mudik.jpg" alt=""></a>
            <button type="button" class="btn btn-clean"><i class="fa fa-close"></i></button>
        </div>
    </div>-->