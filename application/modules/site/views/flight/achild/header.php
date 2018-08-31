<div id="page-info" data-name="inner flight" data-active-page="0" data-menu-target="#top-nav">
  
</div>
<div class="well blue mobile-flight-selected">
  <div class="container">
    <div class="row">
      <div class="col-sm-10 col-xs-9">
        <div class="media">
          <div class="media-left">
            <h4>PERGI</h4>
          </div>
          <div class="media-body">     
            <p>
              <small>
                <?php
                print "{$info['departure']['city']} ({$info['departure']['code']}) - {$info['arrival']['city']} ({$info['arrival']['code']})";
                ?>
              </small>
            </p>
          </div>
        </div>
      </div>
      <div class="col-sm-2 col-xs-3">
        <a href="#" class="btn btn-round btn-xs btn-red">
          <span class="v-align">UBAH</span>
        </a>
      </div>
    </div>
  </div>
</div>
<section class="clearfix header-mobile">
  <div class="container">
    <div class="row">
      <section class="navbar-left">
        <button type="button" data-target="#top-nav" id="toggle-menu" class="navbar-toggle pull-right"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      </section>
      <section class="navbar-brand double">
        <h3>TENTUKAN PENERBANGAN PERGI</h3>
        <p>
          <?php 
        print "{$info['departure']['city']} ({$info['departure']['code']}) - {$info['arrival']['city']} ({$info['arrival']['code']})"
        . " | {$hari[$days['code']]}, {$days['string']}";
        ?>
        </p>
      </section>
      <section class="navbar-right">
        <a href="#form-flight-sm" class="btn btn-round btn-xs btn-white btn-edit mobile-opt-toggle">
          <span class="v-align">UBAH</span>
        </a>
      </section>
    </div>
  </div>
</section>
<section class="clearfix visible-lg">
  <div id="schedule-head-group" class="collapse in">
    <div class="schedule-note">
      <div class="container">
        <div class="row matchHeight">
          <div class="col-md-10 item">
            <h3 class="title"><?php
            print "{$info['departure']['city']} ({$info['departure']['code']}) - {$info['arrival']['city']} ({$info['arrival']['code']})";
            ?></h3>
            <p>                                
              <?php
              print "{$hari[$days['code']]}, {$days['string']} | "
                . "{$pax[0]} ".lang("Dewasa")." {$pax[1]} ".lang("Anak")." {$pax[2]} ".lang("Bayi");

              ?>
               |
              Ekonomi
            </p>
          </div>
          <div class="col-md-2 ubah item">
            <div class="v-align">
              <a href="#change-flight" data-toggle="collapse" id="btn-change-flight" class="sprites sprites-btn-ubah-lg collapsed"> </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="change-flight" class="change-flight collapse">
      <div class="container p-t-30 p-b-30">
        <div class="row">
          <div id="" class="item col-md-10">
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
                      <input type="text" name="selectCity" value="<?php print "{$info['departure']['city']} ({$info['departure']['code']})"?>" data-flight-type="origin" class="input-from form-control selectCity">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group switch">
                <div class="input-wrap">
                  <a href="#right" class="btn btn-link btn-switch switch-to-right">
                    <span class="fa fa-caret-right"></span>
                  </a>
                  <a href="#left" class="btn btn-link btn-switch switch-to-left">
                    <span class="fa fa-caret-left"></span>
                  </a>
                </div>
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
                      <input type="text" name="selectCity" value="<?php print "{$info['arrival']['city']} ({$info['arrival']['code']})"?>" data-flight-type="destination" class="input-to form-control selectCity">
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
                    <input type="text" name="depart" value="<?php print $tgl[0]?>" class="form-control datepicker-multi from datepicker-from date-depart-desktop">
                  </div>
                </div>
              </div>
              <div class="form-group return">
                <div class="label-wrap">
                  <div class="checkbox checkbox-danger">
                    <input type="checkbox"  name="return-check" id="form-group-return" class="return-checkbox is-return-desktop">
                    <label for="form-group-return">Pulang</label>
                  </div>
                </div>
                <div class="input-wrap">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <div class="fa fa-calendar"></div>
                    </span>
                    <input type="text" name="return" disabled value="<?php print $tgl[1]?>" class="form-control datepicker-multi to datepicker-to date-return-desktop">
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
                      <input type="text" name="passenger-total" value="<?php print $pax[0]+$pax[1]+$pax[2]?>" class="form-control spinner-dropdown-total">
                    </div>
                    <div class="dropdown-menu passenger-dd-spinner">
                      <div class="form-inline">
                        <div class="form-group">
                          <label>Dewasa <small>(12+ tahun)</small></label>
                          <input type="number" value="<?php print $pax[0]?>" min="1" name="passenger-adult" readonly class="ui-spinner adult psgr-adult-desktop">
                        </div>
                        <div class="form-group">
                          <label>Anak <small>(2-12 tahun)</small></label>
                          <input type="number" value="<?php print $pax[1]?>" min="0" name="passenger-kids" readonly class="ui-spinner kids psgr-child-desktop">
                        </div>
                        <div class="form-group">
                          <label>Bayi <small>(&lt; 2 tahun)</small></label>
                          <input type="number" value="<?php print $pax[2]?>" min="0" name="passenger-baby" readonly class="ui-spinner babies psgr-infant-desktop">
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
                  <input type="radio"  value="BISNIS" name="flight-type" id="form-opt-business" class="flightType">
                  <label for="form-opt-business">Bisnis</label>
                </div>
              </div>
            </div>
          </div>
          <div id="cari-tiket-clone" class="item col-md-2 text-right cari-tiket">
            <input type="hidden" id="ajax-journey-origin" value="<?php print $rute[0]?>" />
            <input type="hidden" id="ajax-journey-destination" value="<?php print $rute[1]?>" />
            <input type="hidden" id="ajax-is-return" value="0" />
            <input type="hidden" id="ajax-date-depart" value="<?php print $tgl[0]?>" />
            <input type="hidden" id="ajax-date-return" value="" />
            <input type="hidden" id="ajax-psgr-adult" value="<?php print $pax[0]?>" />
            <input type="hidden" id="ajax-psgr-child" value="<?php print $pax[1]?>" />
            <input type="hidden" id="ajax-psgr-infant" value="<?php print $pax[2]?>" />
            <form method="GET" action="<?php print site_url("site/flight")?>">
              <input type="hidden" id="ajax-journey" value="<?php print "{$rute[0]}.{$rute[1]}"?>" name="journey" />
              <input type="hidden" id="ajax-date" value="<?php print $tgl[0]?>" name="date" />
              <input type="hidden" id="ajax-psgr" value="<?php print "{$pax[0]}.{$pax[1]}.$pax[2]"?>" name="psgr" />
              <input type="hidden" id="ajax-flight-type" value="EKONOMI" name="ct" />
              <input type="image" src="<?php print $url?>assets/images/icons/btn-cari-tiket-white.png" alt="Cari Tiket" value="ticket-src" class="btn btn-lg btn-cari-tiket">
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="flight-src-progress ">
      <div class="container">
        <div class="progress">
          <div role="progressbar" style="width: 0%;" class="progress-bar"></div>
        </div>
        <small class="text-primary">Sedang mencari penerbangan <span class="progress-bar-percent">(0%)</span></small>
      </div>
    </div>
  </div>
  <div class="header-flight-toggle">
    <div class="container">
      <h5 class="title">                    
        <?php
        print "{$info['departure']['city']} ({$info['departure']['code']}) - {$info['arrival']['city']} ({$info['arrival']['code']})";
        ?>   

        | <?php
        print "{$hari[$days['code']]}, {$days['string']}"
        . "| {$pax[0]} ".lang("Dewasa")." {$pax[1]} ".lang("Anak")." {$pax[2]} ".lang("Bayi");?>
      </h5>
      <a href="#schedule-head-group" data-toggle="collapse" aria-expanded="false" id="toggle-head-group" class="btn btn-link collapsed">
      <span class="close-flight">Tutup  <i class="fa fa-caret-up"></i></span>
      <span class="open-flight">Ubah  <i class="fa fa-caret-down"></i></span></a>
    </div>
  </div>
  <div class="booking-steps">
    <span class="left active"></span><span class="right"></span>
    <div class="container">
      <div class="btn-group btn-group-justified">
        <a href="#" class="btn active">CARI PENERBANGAN</a>
        <a href="#" class="btn">INFORMASI PENUMPANG</a>
        <a href="#" class="btn">ULASAN PEMESANAN</a>
        <a href="#" class="btn">PEMBAYARAN PEMESANAN</a>
        <a href="#" class="btn">PENGIRIMAN TIKET</a>
      </div>
    </div>
  </div>
</section>
<div class="flight-src-progress progress-mobile hidden-md hidden-lg">
  <div class="container">
    <div class="progress">
      <div role="progressbar" style="width: 0%;" class="progress-bar"></div>
    </div>
    <small class="text-primary">Sedang mencari penerbangan <span class="progress-bar-percent">(0%)</span></small>
  </div>
</div>