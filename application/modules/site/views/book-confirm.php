<main role="main" class="body">
  <div id="page-info" data-name="inner order review" data-active-page="0" data-menu-target="#top-nav"></div>
  <section class="clearfix header-mobile">
    <div class="container">
      <div class="row">
        <section class="navbar-left">
          <button type="button" data-target="#top-nav" id="toggle-menu" class="navbar-toggle pull-right"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </section>
        <section class="navbar-brand double">
					<h3>ULASAN</h3>
          <p><?php print lang("Nomor Pesanan").": {$paket['bookers']['number']}"?></p>
        </section>
        <section class="navbar-right"></section>
      </div>
    </div>
  </section>
  <section class="clearfix notification mb-sm-20">
    <div class="container">
      <div class="row">
        <section class="col-md-12" id="progress-flight">
          <div class="flight-src-progress" v-bind:class='tampil'>
              <div class="container">
                  <div class="progress">
                    <div role="progressbar" v-bind:style="{width: progresspersen + '%' }" class="progress-bar"></div>
                    <!--<div role="progressbar" style="width: 30%" class="progress-bar"></div>-->
                  </div><small class="text-primary">
                  Sedang melakukan pemesanan <span class="progress-bar-percent">({{progresspersen}}%)</span></small>
                  <!--Sedang melakukan pemesanan <span class="progress-bar-percent">(30%)</span></small>-->
              </div>
          </div>
          <div class="well white" style="display: none">
            <div class="media">
              <div class="media-body media-middle">
                <p>Silakan periksa kembali pesanan Anda, lalu klik tombol LANJUT untuk pembayaran.</p>
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
          <section>
            <div class="panel panel-primary">
              <div class="panel-heading visible-lg-min">
                <h4 class="panel-title">Data Pemesanan dan Pengiriman Tiket</h4>
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
                        <p class="m-0">
                          <small>
                            <?php
                            $info['departure'] = $this->m_site->bandara_info($paket['book']->departure);
                            $info['arrival'] = $this->m_site->bandara_info($paket['book']->arrival);
                            
                            $hari = $this->global_variable->hari17();
                            $info['departuredate']['time'] = strtotime($paket['book']->departuredate);
                            if($paket['book']->returndate){
                              $info['returndate']['time'] = strtotime($paket['book']->returndate);
                            }
                            $days = array(
                              'code'    => date("N", $info['departuredate']['time']),
                              'string'  => date("d F Y", $info['departuredate']['time'])
                            );
                            print "{$info['departure']['city']} ({$info['departure']['code']}) - {$info['arrival']['city']} ({$info['arrival']['code']}) |"
                            . " {$hari[$days['code']]}, {$days['string']}";
                            ?>
                          </small>
                        </p>
											</section>                      
                      <section>
                        <?php
                        $rincian = "";
                        $airline_default = $this->global_variable->site_ticket_airline();
                        foreach($paket['flight'][0] AS $key => $flight){
//                          if($key == 0){
//                            $rincian .= ""
//                              . "<tr>"
//                                . "<td><p><b>GA {$flight->flightnumber}</b></p></td>"
//                                . "<td><p></p></td>"
//                                . "<td class='text-right'></td>"
//                              . "</tr>"
//                              . "";
//                            $fare_detail = json_decode($flight->rincian);
//                            foreach ($fare_detail AS $fd){
//                              $rincian .= ""
//                                . "<tr>"
//                                  . "<td><p>{$fd->Text}</p></td>"
//                                  . "<td><p>:</p></td>"
//                                  . "<td class='text-right'>".number_format($fd->Amount)."</td>"
//                                . "</tr>"
//                                . "";
//                              $grand_total += $fd->Amount;
//                            }
//                          }
                        ?>
												<div class="row">
													<div class="col-sm-5 pull-right flight-journey-airline">
														<section class="media">
															<div class="media-image">
																<div class="img"><img src="<?php print site_url().$airline_default[$flight['airline']]['image2']?>" style="width:100px" alt=""></div>
															</div>
                              <div class="media-body">
																<p><?php print $airline_default[$flight['airline']]['name']?></p>
                                <p><?php print $flight['number']." ({$flight['class']})";?></p>
															</div>
														</section>
                          </div>
                          <div class="col-sm-7 flight-journey-route">
														<div class="m-l-5">
															<section class="origin">
																<div class="flight-dots">
																	<div class="dot-border">
																		<div class="dot-circle"></div>
																	</div>
																</div>
																<div class="flight-time">
																	<h4><?php
                                  $info['flightdeparture'] = $this->m_site->bandara_info($flight['origin']);
                                  $info['flightarrival'] = $this->m_site->bandara_info($flight['destination']);
                                  
                                  $departuredate = strtotime($flight['departdate']);
                                  print date("H:i", $departuredate);
                                  ?></h4>
																	<p class="small help-block"><?php print date("Y-m-d", $departuredate)?></p>
																</div>
																<div class="flight-route">
																	<h4><?php print $info['flightdeparture']['city']." ({$info['flightdeparture']['code']})";?></h4>
																	<!--<p class="small help-block">Soekarno Hatta</p>-->
																</div>
															</section>
                              <section class="hidden-section">
																<div class="flight-dots-transit">
																	<div class="dot-none"></div>
                                </div>
                                <div class="hidden-transit"></div>
                              </section>
                              <section class="destination">
																<div class="flight-dots dots-none">
																	<div class="dot-border">
																		<div class="dot-circle"></div>
																	</div>
																</div>
                                <div class="flight-time">
																	<h4><?php
                                  $arrivaldate = strtotime($flight['arrivaldate']);
                                  print date("H:i", $arrivaldate);
                                  ?></h4>
                                  <p class="small help-block"><?php print date("Y-m-d", $arrivaldate)?></p>
                                </div>
                                <div class="flight-route">
																	<h4><?php print $info['flightarrival']['city']." ({$info['flightarrival']['code']})";?></h4>
                                  <!--<p class="small help-block">Ngurah Rai (Bali)</p>-->
                                </div>
                              </section>
                            </div>
                          </div>
                        </div>
                        <?php
                        }
                        ?>
                      </section>
                      <?php if($paket['flight'][1]){?>
                      <section class="visible-lg-min">
												<div class="title">
													<h4><span class="fa fa-plane m-r-5"></span> Penerbangan Kembali</h4>
												</div>
											</section>
											<section class="panel-heading nesting visible-md-max">
												<h3 class="panel-title">PENERBANGAN KEMBALI</h3>
                        <p class="m-0">
                          <small>
                            <?php
                            $info['departure'] = $this->m_site->bandara_info($paket['book']->departure);
                            $info['arrival'] = $this->m_site->bandara_info($paket['book']->arrival);
                            
                            $hari = $this->global_variable->hari17();
                            $info['departuredate']['time'] = strtotime($paket['book']->departuredate);
                            if($paket['book']->returndate){
                              $info['returndate']['time'] = strtotime($paket['book']->returndate);
                            }
                            $days = array(
                              'code'    => date("N", $info['departuredate']['time']),
                              'string'  => date("d F Y", $info['departuredate']['time'])
                            );
                            print "{$info['departure']['city']} ({$info['departure']['code']}) - {$info['arrival']['city']} ({$info['arrival']['code']}) |"
                            . " {$hari[$days['code']]}, {$days['string']}";
                            ?>
                          </small>
                        </p>
											</section>                      
                      <section>
                        <?php
                        $rincian = "";
                        $airline_default = $this->global_variable->site_ticket_airline();
                        foreach($paket['flight'][1] AS $key => $flight){
//                          if($key == 0){
//                            $rincian .= ""
//                              . "<tr>"
//                                . "<td><p><b>GA {$flight->flightnumber}</b></p></td>"
//                                . "<td><p></p></td>"
//                                . "<td class='text-right'></td>"
//                              . "</tr>"
//                              . "";
//                            $fare_detail = json_decode($flight->rincian);
//                            foreach ($fare_detail AS $fd){
//                              $rincian .= ""
//                                . "<tr>"
//                                  . "<td><p>{$fd->Text}</p></td>"
//                                  . "<td><p>:</p></td>"
//                                  . "<td class='text-right'>".number_format($fd->Amount)."</td>"
//                                . "</tr>"
//                                . "";
//                              $grand_total += $fd->Amount;
//                            }
//                          }
                        ?>
												<div class="row">
													<div class="col-sm-5 pull-right flight-journey-airline">
														<section class="media">
															<div class="media-image">
																<div class="img"><img src="<?php print site_url().$airline_default[$flight['airline']]['image2']?>" style="width:100px" alt=""></div>
															</div>
                              <div class="media-body">
																<p><?php print $airline_default[$flight['airline']]['name']?></p>
                                <p><?php print $flight['number']." ({$flight['class']})";?></p>
															</div>
														</section>
                          </div>
                          <div class="col-sm-7 flight-journey-route">
														<div class="m-l-5">
															<section class="origin">
																<div class="flight-dots">
																	<div class="dot-border">
																		<div class="dot-circle"></div>
																	</div>
																</div>
																<div class="flight-time">
																	<h4><?php
                                  $info['flightdeparture'] = $this->m_site->bandara_info($flight['origin']);
                                  $info['flightarrival'] = $this->m_site->bandara_info($flight['destination']);
                                  
                                  $departuredate = strtotime($flight['departdate']);
                                  print date("H:i", $departuredate);
                                  ?></h4>
																	<p class="small help-block"><?php print date("Y-m-d", $departuredate)?></p>
																</div>
																<div class="flight-route">
																	<h4><?php print $info['flightdeparture']['city']." ({$info['flightdeparture']['code']})";?></h4>
																	<!--<p class="small help-block">Soekarno Hatta</p>-->
																</div>
															</section>
                              <section class="hidden-section">
																<div class="flight-dots-transit">
																	<div class="dot-none"></div>
                                </div>
                                <div class="hidden-transit"></div>
                              </section>
                              <section class="destination">
																<div class="flight-dots dots-none">
																	<div class="dot-border">
																		<div class="dot-circle"></div>
																	</div>
																</div>
                                <div class="flight-time">
																	<h4><?php
                                  $arrivaldate = strtotime($flight['arrivaldate']);
                                  print date("H:i", $arrivaldate);
                                  ?></h4>
                                  <p class="small help-block"><?php print date("Y-m-d", $arrivaldate)?></p>
                                </div>
                                <div class="flight-route">
																	<h4><?php print $info['flightarrival']['city']." ({$info['flightarrival']['code']})";?></h4>
                                  <!--<p class="small help-block">Ngurah Rai (Bali)</p>-->
                                </div>
                              </section>
                            </div>
                          </div>
                        </div>
                        <?php
                        }
                        ?>
                      </section>
                      <?php }?>
										</div>
									</div>
								</section>
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
                  foreach ($paket['pax'] AS $pax){
                    print "<li>{$pax['title']} {$pax['firstname']} {$pax['lastname']}";
                    if($pax['type'] == 1)
                      print "<small class='pull-right'>(Dewasa)</small></li>";
                    else if($pax['type'] == 2)
                      print "<small class='pull-right'>(Anak : {$pax['birthdate']})</small></li>";
                    else
                      print "<small class='pull-right'>(Bayi : {$pax['birthdate']} : Assoc({$pax['urut_assoc']}))</small></li>";
                  }
                  ?>
                </ol>
              </div>
            </div>
          </section>
          <section id="info-price" class="element-item info-price active visible-md-block visible-lg-block">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4 class="panel-title">Rincian Harga</h4>
								<p class="m-0">Maskapai tetap dapat meng-update harga. Harga final Anda akan ditampilkan setelah Proses Pemesanan</p>
              </div>
              <div class="panel-body">
								<section class="element-item">
									<table class="table table-transparent">
										<colgroup>
											<col width="35%">
											<col width="5%">
											<col width="60%">
										</colgroup>
                    <tbody>
											<?php
                      foreach ($paket['flight'] AS $flg){
                        if($flg[0]['detail']){
                          $fl_detail = json_decode($flg[0]['detail']);
                          foreach ($fl_detail AS $fld){
                            if($fld->amount > 0){
                              print "<tr>"
                                . "<td>{$fld->title}</td>"
                                . "<td>:</td>"
                                . "<td style='text-align: right'>IDR ".  number_format($fld->amount)."</td>"
                              . "</tr>";
                            }
                          }
                          $total += $flg[0]['total'];
                        }
                        else{
                          foreach ($flg AS $fl){
                            print "<tr>"
                              . "<td>{$fl['number']}</td>"
                              . "<td>:</td>"
                              . "<td style='text-align: right'>IDR ".  number_format($fl['price'])."</td>"
                            . "</tr>";
                            $total += $fl['price'];
                          }
                        }
                        if(in_array($paket['bookers']['type'], array(1,2)))
                          break;
                      }
                      ?>
										</tbody>
									</table>
								</section>
								<section class="element-item">
									<table class="table table-transparent">
										<colgroup>
											<col width="35%">
											<col width="5%">
											<col width="60%">
										</colgroup>
										<tbody>
											<tr style="display:none;">
												<td>
													<form method="POST" action="<?php print site_url("site/asuransi")?>">
																											<!--input type="checkbox"  name="tripInsurance" id="MegaInsurance" class=""-->

														<input type="checkbox" name="tripInsurance" id="MegaInsurance" class="">
														<label for="tripInsurance">Asuransi Perjalanan</label>
													</form>
													<a data-fancybox-type="iframe" class="m-l-25 popup-iframe" href="/Content/Asuransi/?link=1">Pelajari lebih lanjut </a>
												</td>
												<td>:</td>
												<td class="text-right">
													<p>IDR 0</p>
												</td>
											</tr>
										</tbody>
									</table>
								</section>
								<section class="element-item">
									<table class="table table-transparent">
										<colgroup>
											<col width="35%">
											<col width="5%">
											<col width="60%">
										</colgroup>
										<tbody>
											<tr>
												<td>
													<p>Harga Total</p>
												</td>
												<td>:</td>
												<td class="text-right">
                          <h3 class="h1 m-0"><strong>IDR <?php print number_format($total)?></strong></h3>
													<p><em>Termasuk semua pajak &amp; biaya penerbangan</em></p>
												</td>
											</tr>
										</tbody>
									</table>
								</section>
							</div>
							<div class="panel-footer">
								<div class="row">
									<div class="col-md-9">
										<table style="width:initial;" class="table-transparent">
											<tbody>
												<tr>
                          <?php
                          $harga_tampil = $total;
                          $pst['whitelist'] = $whitelist;
                          if($discount_depan['status'] == 2){
                            foreach ($discount_depan['data']['discount'] AS $disc){
                              if($disc['is_payment_channel'] == 2){
                                $price['normal'] = number_format($harga_tampil - ($disc['type'] == 1 ? $harga_tampil * $disc['nilai'] / 100 : $disc['nilai']));
                              }
                              else{
                                foreach ($disc['payment_channel'] AS $dpc){
                                  if($pst['whitelist'][$dpc['id']]){
                                    $reguler = $this->global_fungsi->diskon($disc['nilai'], $total);
                                    print  ""
                                      . "<td>"
                                        . "<div class='media m-b-5'>"
                                          . "<div class='media-left'>"
                                            . "<img src='{$whitelist[$dpc['id']]['image']}' style='width: 40px' alt=''>"
                                          . "</div>"
                                          . "<div class='media-body small'>"
                                            . "{$dpc['title']}"
                                          . "</div>"
                                        . "</div>"
                                        . "<h4 class='m-0'>IDR ".number_format($reguler['result'])."</h4>"
                                        . "<p class='text-danger small'>Anda hemat IDR ".number_format($reguler['diskon'])."</p>"
                                      . "</td>"
                                      . "";
                                    unset($pst['whitelist'][$dpc['id']]);
                                  }
                                }
                              }
                            }
                          }
                          ?>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</section>
					<section id="info-price-mobile" class="element-item info-price info-price-mobile active p-15 visible-xs-block visible-sm-block">
						<section class="summary-price">
							<p>Total Harga</p>
							<h3>IDR 514,008</h3>
						</section>
						<section>
							<div class="media">
								<div class="media-left"><img src="<?php print $url?>assets/images/repository/card-cc-bankMega-sm.png" alt=""></div>
								<div class="media-body small">Potongan Harga Kartu Kredit Bank Mega</div>
							</div>
							<h4>IDR 508,816</h4>
							<p class="text-danger small">Anda hemat IDR 10,384</p>
						</section>
							<section>
								<div class="media">
									<div class="media-left"><img src="<?php print $url?>assets/images/repository/card-bank-bankMega-infinite-sm.png" alt=""></div>
									<div class="media-body small">Potongan Harga Kartu Kredit Mega Infinite</div>
								</div>
								<h4>IDR 503,728</h4>
								<p class="text-danger small">Anda hemat IDR 15,472</p>
							</section>
					</section>
				</section>
				<section class="col-md-4 content-right">
					<div class="review-sattelite" style="top: 0px;">
						<section class="visible-md-block visible-lg-block">
							<div class="panel panel-grey panel-full">
								<div class="panel-heading">
									<h4 class="panel-title">Nomor Pemesanan</h4>
								</div>
								<div class="panel-body">
									<h4><?php print $paket['bookers']['number']?></h4>
								</div>
							</div>
						</section>
						<section class="text-center visible-md-block visible-lg-block">
							<p>Dengan meng-klik tombol LANJUT, Anda menyetujui <a data-fancybox-type="iframe" class="popup-iframe" href="/Content/Terms/?link=1">Syarat &amp; Ketentuan </a>dan <a class="popup-iframe" data-fancybox-type="iframe" href="/Content/Privacy/?link=1">Kebijakan Privasi </a>Antavaya.com</p>
						</section>
						<section class="text-center mb-sm-30">
              <a href="<?php print site_url("site/book-cancel/{$paket['bookers']['number']}")?>" class="sprites">CANCEL</a>
              <a href="<?php print site_url("site/book-result/{$paket['bookers']['number']}")?>" class="sprites sprites-btn-lanjut-lg btn-process">LANJUT</a>
						</section>
					</div>
				</section>
			</div>
		</div>
	</section>
<!--	<a href="#redirect" style="display:none;" class="popup-redirect">run-redirect</a>
	<div id="redirect" style="display:none;">
		<div class="text-center">
			<figure><img src="<?php print $url?>assets/images/icons/antavaya-dark-sm.png" alt=""></figure>
			<p class="h5 m-b-0">Maaf, waktu Anda untuk <em>booking</em>  telah habis.</p>
			<p class="h5 m-t-0 m-b-30">Anda dapat melakukan pencarian baru.</p>
			<input type="button" value="Tutup" id="btn-redirect-now" class="btn btn-danger p-hor-40">
		</div>
	</div>-->
</main>
