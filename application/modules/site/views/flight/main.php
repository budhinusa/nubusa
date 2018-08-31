<?php
$this->load->view("achild/header");
?>
<section class="clearfix main-content m-t-30 mt-sm-0">
  <input type="text" name="depart-flight-plan" id="depart-flight-plan" class="hidden input-flight-plan">
  <input type="text" name="return-flight-plan" id="return-flight-plan" class="hidden input-flight-plan">
  <div class="container">
    <div class="row flight-result">
      <section class="col-md-12 flight-depart active filter-parent flight-departOnly">
        <div id="filter-display" class="hidden"></div>
        <div class="flight-filter-group visible-md visible-lg">
          <div class="well blue m-b-5">
            <h4>TENTUKAN PENERBANGAN PERGI</h4>
            <p>
              <?php 
                print "{$info['departure']['city']} ({$info['departure']['code']}) - {$info['arrival']['city']} ({$info['arrival']['code']})";
              ?>   |   
              <?php
                print "{$hari[$days['code']]}, {$days['string']}";
              ?>
            </p>
          </div>
          <div class="flight-sort-filter">
            <div class="well dark filter m-b-5 filter-tab">
              <div class="btn-group btn-group-justified">
                <a href="#tab-filter-time" class="btn">
                  WAKTU  <span class="fa fa-caret-up"></span>
                </a>
                <a href="#tab-filter-airline" class="btn">
                  MASKAPAI  <span class="fa fa-caret-up"></span>
                </a>
                <a href="#tab-filter-transit" class="btn">
                  TRANSIT  <span class="fa fa-caret-up"></span>
                </a>
              </div>
            </div>
            <div class="well grey filter-body m-b-5">
              <section id="tab-filter-time" class="collapse">
                <div data-group="brand" class="form-inline p-ver-15 option-set">
                  <div class="row">
                    <div class="col-md-6 filter-left">
                      <p class="p-l-15">Pilih rentang waktu berangkat</p>
                      <div class="row m-0">
                        <div class="col-md-6 p-r-0">
                          <div class="form-group">
                            <div class="checkbox checkbox-danger">
                              <input type="checkbox" value=".filter-depart-takeoff-morning" id="filter-id-morning-depart-Berangkat">
                              <label for="filter-id-morning-depart-Berangkat">Pagi (04:00 - 11:00)</label>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="checkbox checkbox-danger">
                              <input type="checkbox" value=".filter-depart-takeoff-day" id="filter-id-day-depart-Berangkat">
                              <label for="filter-id-day-depart-Berangkat">Siang (11:00 - 15:00)</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6 p-r-0">
                          <div class="form-group m-t-10">
                            <div class="checkbox checkbox-danger">
                              <input type="checkbox" value=".filter-depart-takeoff-noon" id="filter-id-noon-depart-Berangkat">
                              <label for="filter-id-noon-depart-Berangkat">Sore (15:00-18:30)</label>
                            </div>
                          </div>
                          <div class="form-group m-t-10">
                            <div class="checkbox checkbox-danger">
                              <input type="checkbox" value=".filter-depart-takeoff-night" id="filter-id-night-depart-Berangkat">
                              <label for="filter-id-night-depart-Berangkat">Malam (18:30-04:00)</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 filter-right">
                      <p class="p-l-15">Pilih rentang waktu tiba</p>
                      <div class="row m-0">
                        <div class="col-md-6 p-l-0">
                          <div class="form-group">
                            <div class="checkbox checkbox-danger">
                              <input type="checkbox" value=".filter-depart-landing-morning" id="filter-id-morning-depart-Tiba">
                              <label for="filter-id-morning-depart-Tiba">Pagi (04:00-11:00)</label>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="checkbox checkbox-danger">
                              <input type="checkbox" value=".filter-depart-landing-day" id="filter-id-day-depart-Tiba">
                              <label for="filter-id-day-depart-Tiba">Siang (11:00-15:00)</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6 p-l-0">
                          <div class="form-group m-t-10">
                            <div class="checkbox checkbox-danger">
                              <input type="checkbox" value=".filter-depart-landing-noon" id="filter-id-noon-depart-Tiba">
                              <label for="filter-id-noon-depart-Tiba">Sore (15:00 - 18:30)</label>
                            </div>
                          </div>
                          <div class="form-group m-t-10">
                            <div class="checkbox checkbox-danger">
                              <input type="checkbox" value=".filter-depart-landing-night" id="filter-id-night-depart-Tiba">
                              <label for="filter-id-night-depart-Tiba">Malam (18:30 - 04:00)</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <section id="tab-filter-airline" class="collapse">
                <div data-group="airplane" class="form-inline p-ver-15 option-set">
                  <div class="row">
                    <div class="col-md-12" id="block-filter-depart">
                    </div>
                  </div>
                </div>
              </section>
              <section id="tab-filter-transit" class="collapse">
                <div data-group="transit-name" class="form-inline p-ver-15 option-set">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="checkbox checkbox-danger">
                          <input type="checkbox" value=".filter-transit-depart-0" id="filter-id-langsung">
                          <label for="filter-id-langsung">Langsung</label>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="checkbox checkbox-danger">
                          <input type="checkbox" value=".filter-transit-depart-1" id="filter-id-transit">
                          <label for="filter-id-transit">1 Transit</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
            <div class="well grey filter-sort p-0">
              <div class="btn-group sort-by-button-group md">
                <a href="javascript:void(0)" id="urutberangkat" class="btn btn-link">
                  <?php print lang("BERANGKAT")?>  <span class="fa fa-unsorted"></span>
                </a>
                <a href="javascript:void(0)" id="uruttiba" class="btn btn-link">
                  <?php print lang("TIBA")?>  <span class="fa fa-unsorted"></span>
                </a>
                <a href="javascript:void(0)" id="urutharga" class="btn btn-link">
                  HARGA PER ORANG  <span class="fa fa-unsorted"></span>
                </a>
                <a href="javascript:void(0)" id="urutdurasi" class="btn btn-link">
                  <?php print lang("DURASI")?>  <span class="fa fa-unsorted"></span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="flight-filter-mobile">
          <ol class="nav nav-pills nav-justified">
            <li><a href="#filter-depart-sm" class="mobile-opt-toggle">FILTER</a></li>
            <li><a href="#sort-depart-sm" class="mobile-opt-toggle">URUTKAN</a></li>
          </ol>
        </div>
        <div id="filter-depart-sm" class="mobile-opt">
          <div class="well red well-sm">
            <h4>FILTER</h4>
            <div class="btn close"><span class="fa fa-close"></span></div>
          </div>
          <div class="container">
            <section class="form filter-sort-sm">
              <fieldset>
                <legend>WAKTU</legend>
                <div class="row">
                  <div class="col-md-6 filter-left">
                    <p class="p-l-15">Pilih rentang waktu berangkat</p>
                    <div class="row m-0">
                      <div class="col-md-6 p-r-0">
                        <div class="form-group">
                          <div class="checkbox checkbox-danger">
                            <input type="checkbox" value=".filter-depart-takeoff-morning" id="filter-id-morning-sm-Berangkat">
                            <label for="filter-id-morning-sm-Berangkat">Pagi (04:00 - 11:00)</label>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="checkbox checkbox-danger">
                            <input type="checkbox" value=".filter-depart-takeoff-day" id="filter-id-day-sm-Berangkat">
                            <label for="filter-id-day-sm-Berangkat">Siang (11:00 - 15:00)</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 p-r-0">
                        <div class="form-group m-t-10">
                          <div class="checkbox checkbox-danger">
                            <input type="checkbox" value=".filter-depart-takeoff-noon" id="filter-id-noon-sm-Berangkat">
                            <label for="filter-id-noon-sm-Berangkat">Sore (15:00-18:30)</label>
                          </div>
                        </div>
                        <div class="form-group m-t-10">
                          <div class="checkbox checkbox-danger">
                            <input type="checkbox" value=".filter-depart-takeoff-night" id="filter-id-night-sm-Berangkat">
                            <label for="filter-id-night-sm-Berangkat">Malam (18:30-04:00)</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 filter-right">
                    <p class="p-l-15">Pilih rentang waktu tiba</p>
                    <div class="row m-0">
                      <div class="col-md-6 p-l-0">
                        <div class="form-group">
                          <div class="checkbox checkbox-danger">
                            <input type="checkbox" value=".filter-depart-landing-morning" id="filter-id-morning-sm-Tiba">
                            <label for="filter-id-morning-sm-Tiba">Pagi (04:00-11:00)</label>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="checkbox checkbox-danger">
                            <input type="checkbox" value=".filter-depart-landing-day" id="filter-id-day-sm-Tiba">
                            <label for="filter-id-day-sm-Tiba">Siang (11:00-15:00)</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 p-l-0">
                        <div class="form-group m-t-10">
                          <div class="checkbox checkbox-danger">
                            <input type="checkbox" value=".filter-depart-landing-noon" id="filter-id-noon-sm-Tiba">
                            <label for="filter-id-noon-sm-Tiba">Sore (15:00 - 18:30)</label>
                          </div>
                        </div>
                        <div class="form-group m-t-10">
                          <div class="checkbox checkbox-danger">
                            <input type="checkbox" value=".filter-depart-landing-night" id="filter-id-night-sm-Tiba">
                            <label for="filter-id-night-sm-Tiba">Malam (18:30 - 04:00)</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>MASKAPAI</legend>
                <div class="row">
                  <div class="col-md-12" id="block-filter-depart-mobile">
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>JUMLAH TRANSIT</legend>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="checkbox checkbox-danger">
                        <input type="checkbox" value=".filter-transit-depart-0" id="filter-id-langsung-sm">
                        <label for="filter-id-langsung-sm">Langsung</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="checkbox checkbox-danger">
                        <input type="checkbox" value=".filter-transit-depart-1" id="filter-id-transit-sm">
                        <label for="filter-id-transit-sm">1 Transit</label>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </section>
          </div>
        </div>
        <div id="sort-depart-sm" class="mobile-opt">
          <div class="well red well-sm">
            <h4>URUTKAN</h4>
            <div class="btn close"><span class="fa fa-close"></span></div>
          </div>
          <div class="container">
            <section class="sort-by-button-group filter-sort-sm">
              <a href="#" data-sort-by="sortDepart" class="btn btn-block asc">KEDATANGAN - TERAWAL</a>
              <a href="#" data-sort-by="sortDepart" class="btn btn-block">KEDATANGAN - TERAKHIR</a>
              <a href="#" data-sort-by="sortReturn" class="btn btn-block asc">KEBERANGKATAN - TERAWAL</a>
              <a href="#" data-sort-by="sortReturn" class="btn btn-block">KEBERANGKATAN - TERAKHIR</a>
              <a href="#" data-sort-by="sortPrice" class="btn btn-block asc">HARGA - TERMURAH</a>
              <a href="#" data-sort-by="sortPrice" class="btn btn-block">HARGA - TERMAHAL</a>
            </section>
          </div>
        </div>
        <div id="pergi" class="flight-list isotope-container">
          <div class="box-body" id="table-utama">
            <div class="grid-table">
              <transition-group name="fade" tag="div" class="grid-body">
                <div v-for="n in page.limit"
                 v-bind:key="n"
                 v-if="items_live[(n - 1 + page.start)]"
                 v-on:click="select((n - 1 + page.start))"
                 v-bind:class="{'selected': items_live[(n - 1 + page.start)].select}"
                 class="grid-tr">
                  <div v-for="sub in items_live[(n - 1 + page.start)].data" v-html="sub.view" v-bind:class="sub.class">
                  </div>
                </div>
              </transition-group>
            </div>
          </div>
        </div>
        <div class="panel panel-white panel-flight hidden flight-not-found">
          <div class="panel-body">
            <div class="text-center p-30">
              <h3 class="m-t-0">Mohon maaf, penerbangan tidak tersedia</h3>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</section>
<a href="#flight-target-mobile" id="btn-flight-target-mobile" class="hidden mobile-opt-toggle"></a>
<section id="flight-target-mobile" class="clearfix mobile-opt flight-target-mobile">
  <div class="well red well-sm m-b-0">
    <h4>RINCIAN PENERBANGAN PERGI</h4>
    <div class="btn close"><span class="fa fa-close"></span></div>
  </div>
  <div class="container">
    <div class="clearfix plan-depart">
      <div class="well blue">
        <div class="row">
          <div class="col-sm-10 col-xs-9">
            <h4>PENERBANGAN PERGI</h4>
            <p> 
              <small><?php
              print "{$info['departure']['city']} ({$info['departure']['code']}) | {$info['arrival']['city']} ({$info['arrival']['code']}) | {$hari[$days['code']]}, {$days['string']}";
              ?> </small>
            </p>
          </div>
          <div class="col-sm-2 col-xs-3">
            <a href="#" id="btn-chg-depart-mobile" class="btn btn-round btn-xs btn-red"><span class="v-align">UBAH</span></a>
          </div>
        </div>
      </div>
      <div class="lists">
        <ol class="undefined list-inline popup-depart-fitur">
          <li>
            <div data-toggle="tooltip" data-placement="top" title="Tiket kelas Ekonomi">
              Ekonomi
            </div>
          </li>
          <li>
            <div data-toggle="tooltip" data-placement="top" title="1x Pemberhentian di Surabaya">
              1 Transit
            </div>
          </li>
          <li>
            <div data-toggle="tooltip" data-placement="top" title="Durasi 1 jam 30 menit">
              1h 30m
            </div>
          </li>
          <li>
            <div data-toggle="tooltip" data-placement="top" title="Harga barang sudah termasuk bagasi 15KG">
              <span class="fa fa-suitcase"></span> 20KG
            </div>
          </li>
          <li>
            <div data-toggle="tooltip" data-placement="top" title="Harga sudah termasuk makan">
              <span class="fa fa-cutlery"></span>
            </div>
          </li>
          <li>
            <div data-toggle="tooltip" data-placement="top" title="Penerbangan overnight">
              <span class="fa fa-moon-o"></span>
            </div>
          </li>
        </ol>
      </div>
      <div class="clearfix journey popup-mobile-depart-flightdetail">
        <div class="m-ver-15">
          <div class="col-md-4 flight-journey-airline">
            <div class="flight-logo"><img src="<?php print $url?>assets/images/icons/tiger-air-sm.png" alt=""></div>
          </div>
          <div class="col-md-8 flight-journey-route">
            <section class="origin">
              <div class="flight-time">
                <h4>18:00</h4>
                <p class="small help-block">Kam, 22 Des</p>
              </div>
              <div class="flight-dots">
                <div class="dot-border">
                  <div class="dot-circle"></div>
                </div>
              </div>
              <div class="flight-route">
                <h4>Jakarta (CGK)</h4>
                <p class="small help-block">Soekarno Hatta Intl Airport</p>
              </div>
            </section>
            <section class="hidden-section">
              <div class="flight-dots-transit">
                <div class="dot-none"></div>
              </div>
              <div class="hidden-transit"></div>
            </section>
            <section class="destination">
              <div class="flight-time">
                <h4>20:50</h4>
                <p class="small help-block">Kam, 22 Des</p>
              </div>
              <div class="flight-dots dots-none">
                <div class="dot-border">
                  <div class="dot-circle"></div>
                </div>
              </div>
              <div class="flight-route">
                <h4>Bali / Denpasar (DPS)</h4>
                <p class="small help-block">Ngurah Rai Int'l</p>
              </div>
            </section>
          </div>
        </div>
        <div class="m-ver-15">
          <div class="col-md-4 flight-journey-airline">
            <div class="flight-logo">
              <img src="<?php print $url?>assets/images/icons/tiger-air-sm.png" alt="">
            </div>
          </div>
          <div class="col-md-8 flight-journey-route">
            <section class="origin">
              <div class="flight-time">
                <h4>18:00</h4>
                <p class="small help-block">Kam, 22 Des</p>
              </div>
              <div class="flight-dots">
                <div class="dot-border">
                  <div class="dot-circle"></div>
                </div>
              </div>
              <div class="flight-route">
                <h4>Jakarta (CGK)</h4>
                <p class="small help-block">Soekarno Hatta Intl Airport</p>
              </div>
            </section>
            <section class="hidden-section">
              <div class="flight-dots-transit">
                <div class="dot-none"></div>
              </div>
              <div class="hidden-transit"></div>
            </section>
            <section class="destination">
              <div class="flight-time">
                <h4>20:50</h4>
                <p class="small help-block">Kam, 22 Des</p>
              </div>
              <div class="flight-dots dots-none">
                <div class="dot-border">
                  <div class="dot-circle"></div>
                </div>
              </div>
              <div class="flight-route">
                <h4>Bali / Denpasar (DPS)</h4>
                <p class="small help-block">Ngurah Rai Int'l</p>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix plan-prices">
      <div class="col-sm-6 col-xs-5">
        <section class="price-total">
          <h6 class="m-0">Total Harga</h6>
          <h3 class="popup-harga-final-d">IDR 1,436,000</h3>
          <p class="text-muted"><small><em>Termasuk semua pajak &amp; biaya penerbangan</em></small></p>
        </section>
      </div>
      <div class="col-sm-6 col-xs-7">
        <section class="card m-b-20">
          <div class="media">
            <div class="media-left media-middle">
              <img src="<?php print $url?>assets/images/repository/card-cc-bankMega-sm.png" alt="">
            </div>
            <div class="media-body media-middle">
              <small>Harga Khusus <br /> Kartu Kredit Bank Mega</small>
            </div>
          </div>
          <h4 class="popup-harga-final-dm">1,336,000  <br><small class="text-danger">Anda hemat 100.000</small></h4>
        </section>
        <section class="card">
          <div class="media">
            <div class="media-left media-middle">
              <img src="<?php print $url?>assets/images/repository/card-bank-bankMega-infinite-sm.png" alt="">
            </div>
            <div class="media-body media-middle">
              <small>Harga Khusus <br /> Mega Infinite</small>
            </div>
          </div>
          <h4 class="popup-harga-final-dmi">1,306,000  <br><small class="text-danger">Anda hemat 130.000</small></h4>
        </section>
      </div>
    </div>
    <div class="clearfix text-center plan-submit">
      <form method="POST" action="http://antavaya.com/Flight/Passenger">
        <input type="hidden" class="ajax-depart-flightidrsv" value="" name="depart-flightidrsv" />
        <input type="hidden" class="ajax-depart-ismulticlass" value="" name="depart-ismulticlass" />
        <input type="hidden" class="ajax-depart-classId" value="" name="depart-classId" />
        <input type="hidden" class="ajax-depart-airline" value="" name="depart-airline" />
        <input type="hidden" class="ajax-depart-flightId" value="" name="depart-flightId" />
        <input type="hidden" class="ajax-depart-fare" value="" name="depart-fare" />
        <input type="hidden" class="ajax-depart-tax" value="" name="depart-tax" />
        <input type="hidden" class="ajax-depart-flightNumber" value="" name="depart-flightNumber" />
        <input type="hidden" class="ajax-depart-seat" value="" name="depart-seat" />
        <input type="hidden" class="ajax-depart-allorigin" value="" name="depart-allorigin" />
        <input type="hidden" class="ajax-depart-alldestination" value="" name="depart-alldestination" />
        <input type="hidden" class="ajax-depart-departDate" value="" name="depart-departDate" />
        <input type="hidden" class="ajax-depart-departTime" value="" name="depart-departTime" />
        <input type="hidden" class="ajax-depart-arriveDate" value="" name="depart-arriveDate" />
        <input type="hidden" class="ajax-depart-arriveTime" value="" name="depart-arriveTime" />
        <input type="hidden" class="ajax-depart-classCode" value="" name="depart-classCode" />
        <input type="hidden" class="ajax-depart-classType" value="" name="depart-classType" />
        <input type="submit" value="PESAN" id="submit-flight-mobile" class="btn btn-round btn-red btn-sm">
      </form>
    </div>
  </div>
</section>
<a href="#" id="btn-popup-flight" class="btn btn-link hidden">Flight Details</a>
<div id="form-flight-sm" class="mobile-opt form-field-sm">
  <div class="well red well-sm">
    <h4>UBAH PENCARIAN PEMESANAN</h4>
    <div class="btn close"><span class="fa fa-close"></span></div>
  </div>
  <div class="container">
    <section>
      <div class="form-inline">
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
                    <input type="text" name="selectCity" value="JAKARTA (CGK)" data-flight-type="origin" class="form-control selectCity-mobile input-from">
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
                    <input type="text" name="selectCity" value="Denpasar (DPS)" data-flight-type="destination" class="form-control selectCity-mobile input-to">
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
                  <input type="text" name="depart" value="09-03-2017" class="form-control datepicker-from-mobile date-depart-mobile">
                </div>
              </div>
            </div>
            <div class="form-group return">
              <div class="label-wrap">
                <div class="checkbox checkbox-danger">
                  <input type="checkbox"  name="return-check" id="form-group-return-sm" class="return-checkbox is-return-mobile">
                  <label for="form-group-return-sm">Pulang</label>
                </div>
              </div>
              <div class="input-wrap">
                <div class="input-group">
                  <span class="input-group-addon">
                    <div class="fa fa-calendar"></div>
                  </span>
                  <input type="text" name="return" disabled value="" class="form-control datepicker-to-mobile date-return-mobile">
                </div>
              </div>
            </div>
            <div class="form-group passenger spinner-dropdown">
              <input type="text" name="passenger-total" hidden value="1" class="spinner-dropdown-total">
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
                <input type="radio"  value="BISNIS" name="flight-type-mobile" id="form-opt-business-sm" class="flightTypeMobile">
                <label for="form-opt-business-sm">Bisnis</label>
              </div>
            </div>
          </div>
        </div>
        <div class="item text-right cari-tiket">
          <input type="hidden" id="ajax-mobile-journey-origin" value="CGK" />
          <input type="hidden" id="ajax-mobile-journey-destination" value="DPS" />
          <input type="hidden" id="ajax-mobile-is-return" value="0" />
          <input type="hidden" id="ajax-mobile-date-depart" value="2017-03-09" />
          <input type="hidden" id="ajax-mobile-date-return" value="" />
          <input type="hidden" id="ajax-mobile-psgr-adult" value="1" />
          <input type="hidden" id="ajax-mobile-psgr-child" value="0" />
          <input type="hidden" id="ajax-mobile-psgr-infant" value="0" />
          <form method="GET" action="<?php print site_url("site/flight")?>">
            <input type="hidden" id="ajax-mobile-journey" value="<?php print $rute[0].".".$rute[1]?>" name="journey" />
            <input type="hidden" id="ajax-mobile-date" value="<?php print $tgl[0].".".$tgl[1]?>" name="date" />
            <input type="hidden" id="ajax-mobile-psgr" value="<?php print "{$pax[0]}.{$pax[1]}.$pax[2]"?>" name="psgr" />
            <input type="hidden" id="ajax-mobile-flight-type" value="EKONOMI" name="ct" />
            <input type="submit" value="Cari Tiket" class="btn btn-round btn-red btn-lg btn-cari-tiket">
          </form>
        </div>
      </div>
    </section>
  </div>
</div>
<a href="#redirect" style="display:none;" class="popup-redirect">run-redirect</a>
    <!--<a href="#nbs-fancy" style="display:block;" id="fancy-nbs">run-nbs</a>-->
    <!--<input type="image" src="<?php print $url?>assets/images/icons/btn-pilih-pergi.png" alt="" class="btn-leave fancy-nbs">-->
<div id="redirect" style="display:none;">
  <div class="text-center">
    <figure><img src="<?php print $url?>assets/images/icons/antavaya-dark-sm.png" alt=""></figure>
    <p class="h5 m-b-0">Maaf, waktu Anda untuk <em>booking</em>  telah habis.</p>
    <p class="h5 m-t-0 m-b-30">Anda dapat melakukan pencarian baru.</p>
    <input type="button" value="Tutup" id="btn-redirect-now" class="btn btn-danger p-hor-40">
  </div>
</div>
    
<div style="display:none;" id="nbs-fancy" class="popup-flight-target">
  <div class="panel panel-white" id="hasil-popup">
  </div>
</div>
    