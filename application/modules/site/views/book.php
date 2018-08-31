<form method="POST" action="<?php print site_url("site/book-confirm-shadow")?>">
  <?php
  print $this->form_eksternal->form_input('adult', $pst['adult'], "style='display: none'");
  print $this->form_eksternal->form_input('child', $pst['child'], "style='display: none'");
  print $this->form_eksternal->form_input('infant', $pst['infant'], "style='display: none'");
  print $this->form_eksternal->form_input('awal_departure', $pst['awal_departure'], "style='display: none'");
  print $this->form_eksternal->form_input('awal_arrival', $pst['awal_arrival'], "style='display: none'");
  print $this->form_eksternal->form_input('awal_departuredate', $pst['awal_departuredate'], "style='display: none'");
  print $this->form_eksternal->form_input('awal_returndate', $pst['awal_returndate'], "style='display: none'");
  print $this->form_eksternal->form_input('type', $pst['type'], "style='display: none'");
  ?>
  <main role="main" class="body">
		<div id="page-info" data-name="inner order information" data-active-page="0" data-menu-target="#top-nav"></div>
		<section class="clearfix header-mobile">
			<div class="container">
				<div class="row">
					<section class="navbar-left">
						<button type="button" data-target="#top-nav" id="toggle-menu" class="navbar-toggle pull-right"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
					</section>
					<section class="navbar-brand double">
						<h3>PENUMPANG</h3>
						<p>Mohon isi data penumpang</p>
					</section>
					<section class="navbar-right">
						<a href="/Member/Login?ReturnUrl=%2FFlight%2FPassenger" class="btn btn-round btn-xs btn-white btn-detail"> <span class="v-align">LOGIN</span></a>
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
								<div class="media-left"><a href="/Member/Login?ReturnUrl=%2FFlight%2FPassenger" class="btn btn-round btn-sm btn-red btn-login"> <span class="v-align">LOGIN</span></a></div>
								<div class="media-body media-middle">
									<p>ke akun Antavaya.com Anda untuk proses pemesanan yang lebih mudah!</p>
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
						<section id="info-ticket" class="element-item info-ticket ">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h4 class="panel-title">Data Pemesanan dan Pengiriman Tiket</h4>
								</div>
								<div class="panel-body">
									<section id="ticket-form" class="ticket-form">
										<div class="form-group">
											<div class="label-wrap">
												<label>Nama Lengkap Kontak</label>
											</div>
											<input type="text" class="form-control name ticket-form-name value-check" name="name" value="" required>
                      <small class="help-block">Sesuai KTP/Paspor/SIM dan tanpa tanda baca atau gelar</small>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<div class="label-wrap">
														<label>No. Ponsel</label>
													</div>
													<div class="input-group selectpicker-group-addon">
														<div class="input-group-addon">
															<select data-width="fit" class="selectpicker" name="telparea" required>
																<option value="0">+62</option>
															</select>
														</div>
														<input type="number" class="form-control value-check phone-validate" name="telp" value="" required>
													</div><small class="help-block">Contoh: +62812345678, untuk kode negara (+62) dengan nomer ponsel 0812345678</small>
												</div>
												<div class="col-md-6">
													<div class="label-wrap">
														<label>Alamat Email Kontak</label>
													</div>
													<input type="email" class="form-control name value-check" name="email" value="" required>
                          <small class="help-block">Contoh: alamat@contoh.com</small>
												</div>
												<div class="col-md-12">
													<div id="check-same-order" class="checkbox checkbox-danger check-same-order">
														<input type="checkbox" id="same-passenger">
														<label for="same-passenger" class="m-l-5">Penumpang sama dengan pemesan</label>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
						</section>
            <?php
            $paxadult = "";
            for($a = 0 ; $a < $pst['adult'] ; $a++){
              $paxadult .= "<option value='".($a+1)."'>".($a+1)."</option>";
            ?>
						<section id="info-passenger" class="element-item info-passenger nonactive">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h4 class="panel-title">Data Penumpang Dewasa 1 (Di Atas 12 Tahun)</h4>
								</div>
								<div class="panel-body">
									<section id="passenger-form" class="passenger-form">
										<div class="form-group">
											<div class="label-wrap">
												<label>Nama Lengkap Penumpang</label>
											</div>
											<div class="input-group selectpicker-group-addon">
												<div class="input-group-addon">
													<select data-width="fit" class="selectpicker" name="adult_title[]" required>
														<option value="1">Tuan</option>
														<option value="2">Nyonya</option>
														<option value="3">Nona</option>
													</select>
												</div>
												<input type="text" disabled class="form-control passenger-form-name" pattern=".{3,}" title="minimal 3 karakter" name="adult_name[]" required>
											</div>
											<small class="help-block">Nama penumpang rute internasional harus sesuai dengan nama di paspor. Nama penumpang domestik harus sesuai dengan nama di KTP/SIM/paspor dan tanpa tanda baca atau gelar</small>
										</div>
									</section>
								</div>
							</div>
						</section>
            <?php
            }
            for($c = 0 ; $c < $pst['child'] ; $c++){
            ?>
						<section id="" class="element-item info-passenger nonactive">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h4 class="panel-title">Data Penumpang Anak (2 - 12 tahun)</h4>
								</div>
								<div class="panel-body">
									<section id="passenger-form" class="passenger-form">
										<div class="form-group">
											<div class="label-wrap">
												<label>Nama Lengkap Penumpang</label>
											</div>
											<div class="input-group selectpicker-group-addon">
												<div class="input-group-addon">
													<select data-width="fit" class="selectpicker" name="child_title[]" required>
														<option value="1">Tuan</option>
														<option value="3">Nona</option>
													</select>
												</div>
												<input type="text" disabled class="form-control" pattern=".{3,}" title="minimal 3 karakter" name="child_name[]" required>
											</div>
											<small class="help-block">Nama penumpang rute International harus sesuai dengan paspor. Nama Penumpang domestik sesuai KTP/Paspor/SIM dan tanpa tanda baca atau gelar</small>
											<div class="form-inline">
												<div class="label-wrap">
													<label>Tanggal Lahir</label>
												</div>
												<div class="input-group">
													<input type="text" readonly name="child_date[]" class="form-control dobChild" data-mindate="-12Y +13D" data-maxdate="-2Y +12D" required>
													<div class="input-group-addon btn-open-calendar">
														<button type="button"><i class="fa fa-calendar"></i></button>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
						</section>
            <?php
            }
            for($i = 0 ; $i < $pst['infant'] ; $i++){
            ?>
						<section id="" class="element-item info-passenger nonactive">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h4 class="panel-title">Data Penumpang Bayi (Di Bawah 2 Tahun)</h4>
								</div>
								<div class="panel-body">
									<section id="passenger-form" class="passenger-form">
										<div class="form-group">
											<div class="label-wrap">
												<label>Nama Lengkap Penumpang</label>
											</div>
											<div class="input-group selectpicker-group-addon">
												<div class="input-group-addon">
													<select data-width="fit" class="selectpicker" name="infant_title[]" required>
														<option value="1">Tuan</option>
														<option value="3">Nona</option>
													</select>
												</div>
												<input type="text" disabled class="form-control" pattern=".{3,}" title="minimal 3 karakter" name="infant_name[]" required>
											</div>
											<small class="help-block">Nama penumpang rute International harus sesuai dengan paspor. Nama Penumpang domestik sesuai KTP/Paspor/SIM dan tanpa tanda baca atau gelar</small>
										</div>
                    <div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<div class="label-wrap">
                            <label>Tanggal Lahir</label>
                          </div>
                          <div class="input-group">
                            <input type="text" readonly name="infant_date[]" class="form-control dobInfant" data-mindate="-2Y +13D" data-maxdate="-7D" required>
                            <div class="input-group-addon btn-open-calendar">
                              <button type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                          </div>
												</div>
												<div class="col-md-6">
													<div class="label-wrap">
														<label>Pax Assoc</label>
													</div>
													<div class="input-group selectpicker-group-addon">
                            <div class="input-group-addon">
                              <select data-width="fit" class="selectpicker" name="infant_assoc[]" required>
                                <?php
                                print $paxadult;
                                ?>
                              </select>
                            </div>
                          </div>
												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
						</section>
            <?php
            }
            $harga_normal = 0;
            ?>
						<section class="text-center mb-sm-30">
							<input type="submit" value="LANJUT" id="btn-next" class="btn btn-round btn-red btn-sm btn-next">
						</section>
					</section>
					<section class="col-md-4 content-right visible-md-block visible-lg-block">
						<section id="info-depart" class="element-item info-depart">
							<div class="panel panel-grey panel-full">
								<div class="panel-heading">
									<div class="fa fa-plane"></div>
									<h4 class="panel-title">Penerbangan Pergi</h4>
								</div>
								<div class="panel-body">
									<div class="flight-journey-body">
                    <?php
                    foreach ($pst['flightnumber'] AS $key => $flightnumber){
                      print $this->form_eksternal->form_input('dep_departure[]', $pst['departure'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('dep_arrival[]', $pst['arrival'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('dep_departuredate[]', $pst['departuredate'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('dep_arrivaldate[]', $pst['arrivaldate'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('seat[]', $pst['seat'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('dep_flightnumber[]', $flightnumber, "style='display: none'");
                      print $this->form_eksternal->form_input('dep_flightid[]', $pst['flightid'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('dep_classid[]', $pst['classid'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('dep_classcode[]', $pst['flightclass'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('dep_airline[]', $pst['flighttype'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('dep_fare[]', $pst['fare'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('dep_tax[]', $pst['tax'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('flighttype', $pst['flighttypegds'][$key], "style='display: none'");
                    ?>
										<div class="flight-journey-airline">
											<div class="media">
												<div class="media-left">
													<div class="img"><img src="<?php print $pst['flightimage'][$key]?>" style="width: 75px" alt=""></div>
												</div>
												<div class="media-body">
													<p><?php print $pst['flightname'][$key]?></p>
													<p><?php print $flightnumber?> (<?php print $pst['seat'][$key]?>)</p><span class="label label-default"><?php print $pst['classname'][$key]?></span>
												</div>
											</div>
										</div>
                    <div class="flight-journey-route" style="width: 100%">
											<section class="origin">
												<div class="flight-dots">
													<div class="dot-border">
														<div class="dot-circle"></div>
													</div>
												</div>
												<div class="flight-time">
													<h4><?php 
                          $info['departure'] = $this->m_site->bandara_info($pst['departure'][$key]);
                          $info['arrival'] = $this->m_site->bandara_info($pst['arrival'][$key]);
                            
                          $departuredate = strtotime($pst['departuredate'][$key]);
                          print date("H:i", $departuredate);
                          ?></h4>
													<p class="small help-block"><?php print date("Y-m-d", $departuredate);?></p>
												</div>
												<div class="flight-route">
													<h4><?php print $info['departure']['city']."<br />({$info['departure']['code']})"?></h4>
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
														<div class="dot-circle-full"></div>
													</div>
												</div>
												<div class="flight-time">
													<h4><?php 
                          $arrivaldate = strtotime($pst['arrivaldate'][$key]);
                          print date("H:i", $arrivaldate);
                          ?></h4>
													<p class="small help-block"><?php print date("Y-m-d", $arrivaldate);?></p>
												</div>
												<div class="flight-route">
													<h4><?php print $info['arrival']['city']."<br />({$info['arrival']['code']})"?></h4>
													<!--<p class="small help-block">Juanda Airport</p>-->
												</div>
											</section>
											<section class="price-total">
												<div class="flight-time">
													<span>Harga</span>
												</div>
                        <div class="flight-route" style="text-align: right">
                          <span class="price-total">IDR <?php
                          $harga_normal += ($pst['fare'][$key] + $pst['tax'][$key]);
                          print number_format($pst['fare'][$key] + $pst['tax'][$key]);?></span>
												</div>
											</section>
										</div>
                    <div class="transit-separator mb-25">
											<!--<p class="m-0">Transit selama 5 jam 25 menit di SURABAYA (SUB)</p>-->
										</div>
                    <?php
                    }
                    ?>
<!--										<div class="transit-separator mb-25">
											<p class="m-0">Transit selama 5 jam 25 menit di SURABAYA (SUB)</p>
										</div>-->
									</div>
								</div>
							</div>
						</section>
            <?php if($pst['type'] == 2){?>
						<section id="info-depart" class="element-item info-depart">
							<div class="panel panel-grey panel-full">
								<div class="panel-heading">
									<div class="fa fa-plane"></div>
									<h4 class="panel-title"><?php print lang("Penerbangan Pulang")?></h4>
								</div>
								<div class="panel-body">
									<div class="flight-journey-body">
                    <?php
                    foreach ($pst['flightnumber2'] AS $key => $flightnumber){
                      print $this->form_eksternal->form_input('arr_departure[]', $pst['departure2'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('arr_arrival[]', $pst['arrival2'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('arr_departuredate[]', $pst['departuredate2'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('arr_arrivaldate[]', $pst['arrivaldate2'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('arr_seat[]', $pst['seat2'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('arr_flightnumber[]', $flightnumber, "style='display: none'");
                      print $this->form_eksternal->form_input('arr_flightid[]', $pst['flightid2'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('arr_classid[]', $pst['classid2'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('arr_classcode[]', $pst['flightclass2'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('arr_airline[]', $pst['flighttype2'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('arr_fare[]', $pst['fare2'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('arr_tax[]', $pst['tax2'][$key], "style='display: none'");
                      print $this->form_eksternal->form_input('arr_flighttype', $pst['flighttypegds2'][$key], "style='display: none'");
                      
//                      print $this->form_eksternal->form_input('departure2[]', $pst['departure2'][$key], "style='display: none'");
//                      print $this->form_eksternal->form_input('arrival2[]', $pst['arrival2'][$key], "style='display: none'");
//                      print $this->form_eksternal->form_input('departuredate2[]', $pst['departuredate2'][$key], "style='display: none'");
//                      print $this->form_eksternal->form_input('arrivaldate2[]', $pst['arrivaldate2'][$key], "style='display: none'");
//                      print $this->form_eksternal->form_input('seat2[]', $pst['seat2'][$key], "style='display: none'");
//                      print $this->form_eksternal->form_input('flightnumber2[]', $flightnumber, "style='display: none'");
//                      print $this->form_eksternal->form_input('flightclass2[]', $pst['flightclass2'][$key], "style='display: none'");
                    ?>
										<div class="flight-journey-airline">
											<div class="media">
												<div class="media-left">
													<div class="img"><img src="<?php print $pst['flightimage2'][$key]?>" style="width: 75px" alt=""></div>
												</div>
												<div class="media-body">
													<p><?php print $pst['flightname2'][$key]?></p>
													<p><?php print $flightnumber?> (<?php print $pst['seat2'][$key]?>)</p><span class="label label-default"><?php print $pst['classname2'][$key]?></span>
												</div>
											</div>
										</div>
                    <div class="flight-journey-route" style="width: 100%">
											<section class="origin">
												<div class="flight-dots">
													<div class="dot-border">
														<div class="dot-circle"></div>
													</div>
												</div>
												<div class="flight-time">
													<h4><?php 
                          $info['departure2'] = $this->m_site->bandara_info($pst['departure2'][$key]);
                          $info['arrival2'] = $this->m_site->bandara_info($pst['arrival2'][$key]);
                            
                          $departuredate = strtotime($pst['departuredate2'][$key]);
                          print date("H:i", $departuredate);
                          ?></h4>
													<p class="small help-block"><?php print date("Y-m-d", $departuredate);?></p>
												</div>
												<div class="flight-route">
													<h4><?php print $info['departure2']['city']."<br />({$info['departure2']['code']})"?></h4>
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
														<div class="dot-circle-full"></div>
													</div>
												</div>
												<div class="flight-time">
													<h4><?php 
                          $arrivaldate = strtotime($pst['arrivaldate2'][$key]);
                          print date("H:i", $arrivaldate);
                          ?></h4>
													<p class="small help-block"><?php print date("Y-m-d", $arrivaldate);?></p>
												</div>
												<div class="flight-route">
													<h4><?php print $info['arrival2']['city']."<br />({$info['arrival2']['code']})"?></h4>
													<!--<p class="small help-block">Juanda Airport</p>-->
												</div>
											</section>
                      <section class="price-total">
												<div class="flight-time">
													<span>Harga</span>
												</div>
                        <div class="flight-route" style="text-align: right">
                          <span class="price-total">IDR <?php
                          $harga_normal += ($pst['fare2'][$key] + $pst['tax2'][$key]);
                          print number_format($pst['fare2'][$key] + $pst['tax2'][$key]);?></span>
												</div>
											</section>
										</div>
                    <div class="transit-separator mb-25">
											<!--<p class="m-0">Transit selama 5 jam 25 menit di SURABAYA (SUB)</p>-->
										</div>
                    <?php
                    }
                    ?>
<!--										<div class="transit-separator mb-25">
											<p class="m-0">Transit selama 5 jam 25 menit di SURABAYA (SUB)</p>
										</div>-->
									</div>
								</div>
							</div>
						</section>
            <?php }?>
            <section id="info-depart" class="element-item info-depart">
							<div class="panel panel-grey panel-full">
								<div class="panel-heading">
									<div class="fa fa-plane"></div>
									<h4 class="panel-title"><?php print lang("TOTAL")?></h4>
								</div>
								<div class="panel-body">
									<div class="flight-journey-body">
										<div class="flight-journey-route" style="width: 100%">
											<section class="price-total">
                        <div class='flight-time'>
                          <span>TOTAL</span>
                        </div>
                        <div class='flight-route' style='text-align: right'>
                          <h4>IDR <?php print number_format($harga_normal)?></h4>
                        </div>
											</section>
											<section class="price-total">
                      <?php
                      $harga_tampil = $harga_normal;
                      $pst['whitelist'][$key] = $whitelist;
                      if($discount_depan['status'] == 2){
                        foreach ($discount_depan['data']['discount'] AS $disc){
                          if($disc['is_payment_channel'] == 2){
                            $price['normal'] = number_format($harga_tampil - ($disc['type'] == 1 ? $harga_tampil * $disc['nilai'] / 100 : $disc['nilai']));
                          }
                          else{
                            foreach ($disc['payment_channel'] AS $dpc){
                              if($pst['whitelist'][$key][$dpc['id']]){
                                $harga_discount = ($disc['type'] == 1 ? $harga_tampil * $disc['nilai'] / 100 : $disc['nilai']);
                                $harga_temp = $harga_tampil - $harga_discount;
                                print  ""
                                  . "<div class='flight-time'>"
                                    . "<span>{$disc['title']}</span>"
                                  . "</div>"
                                  . "<div class='flight-route' style='text-align: right'>"
                                    . "<h4>IDR ".number_format($harga_temp)."</h4>"
                                  . "</div>"
                                  . "";
                                unset($pst['whitelist'][$key][$dpc['id']]);
                              }
                            }
                          }
                        }
                      }
                      ?>
                      </section>
										</div>
									</div>
								</div>
							</div>
						</section>
					</section>
				</div>
			</div>
		</section>
<!--		<a href="#redirect" style="display:none;" class="popup-redirect">run-redirect</a>
		<div id="redirect" style="display:none;">
			<div class="text-center">
				<figure><img src="<?php print $url?>assets/images/icons/antavaya-dark-sm.png" alt=""></figure>
				<p class="h5 m-b-0">Maaf, waktu Anda untuk <em>booking</em>  telah habis.</p>
				<p class="h5 m-t-0 m-b-30">Anda dapat melakukan pencarian baru.</p>
				<input type="button" value="Tutup" id="btn-redirect-now" class="btn btn-danger p-hor-40">
			</div>
		</div>-->
  </main>
</form>