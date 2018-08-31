<div id="slideshow">
		<div class="fullwidthbanner-container">
				<div class="revolution-slider" style="height: 0; overflow: hidden;">
						<ul>    <!-- SLIDE  -->
								<!-- Slide1 -->
								<li data-transition="zoomin" data-slotamount="7" data-masterspeed="1500">
										<!-- MAIN IMAGE -->
										<img src="http://placehold.it/2080x646" alt="">
								</li>
								
								<!-- Slide2 -->
								<li data-transition="zoomout" data-slotamount="7" data-masterspeed="1500">
										<!-- MAIN IMAGE -->
										<img src="http://placehold.it/2080x646" alt="">
								</li>
								
								<!-- Slide3 -->
								<li data-transition="slidedown" data-slotamount="7" data-masterspeed="1500">
										<!-- MAIN IMAGE -->
										<img src="http://placehold.it/2080x646" alt="">
								</li>
						</ul>
				</div>
		</div>
</div>
<section id="content">
<!-- TAB -->
	<div class="search-box-wrapper">
			<div class="search-box container">
					<ul class="search-tabs clearfix">
							<li class="active"><a href="#flights-tab" data-toggle="tab">TIKET PESAWAT</a></li>
							<li><a href="#tour-tab" data-toggle="tab">PAKET TOUR</a></li>
					</ul>
					<div class="visible-mobile">
							<ul id="mobile-search-tabs" class="search-tabs clearfix">
									<li class="active"><a href="#flights-tab">TIKET PESAWAT</a></li>
									<li><a href="#tour-tab">PAKET TOUR</a></li>
							</ul>
					</div>
					
					<div class="search-tab-content">
							<div class="tab-pane fade active in" id="flights-tab">
									<form name="form_search" method="post" onsubmit="return validasi()" action="<?php print site_url("tiket/flight-list")?>">
										<div class="row">
												<div class="col-md-2">
														<!--<h4 class="title">Where</h4>-->
														<div class="form-group">    
														<label>Dari</label>
																<?php
																print $this->form_eksternal->form_input("tdr", $jlcode_kota1, 'id="tdr" class="drdr input-text full-width space2" placeholder="city, district or specific airport"');
																print $this->form_eksternal->form_input("id_tdr", $jlcode_kota1, 'id="id_tdr" style="display: none"');
																?>
														</div>
														<div class="form-group">
																<label>Ke</label>
																<?php
																print $this->form_eksternal->form_input("tke", $jlcode_kota2, 'id="tke" class="keke input-text full-width space2" placeholder="city, district or specific airport"');
																print $this->form_eksternal->form_input("id_tke", $jlcode_kota2, 'id="id_tke" style="display: none"');
																?>
														</div>
												</div>
												
												<div class="col-md-3">
														<!--<h4 class="title">When</h4>-->
														<label>Pergi</label>
														<div class="form-group row">
																<div class="col-xs-6" style="width: 100%">
																		<div class="datepicker-wrap">
																				<input value="<?php print date("d F Y", strtotime("+1 days"))?>" type="text" id="tgl" name="tgl" class="input-text full-width" placeholder="dd MM YY" />
																		</div>
																		<input type="hidden" name="tnow" id="tnow" value="<?php print $key?>">
																		<input type="hidden" name="agen" id="agen" value="testya">
																</div>
																<!--<div class="col-xs-6">
																		<div class="selector">
																				<select class="full-width">
																						<option value="1">anytime</option>
																						<option value="2">morning</option>
																				</select>
																		</div>
																</div>-->
														</div>
														<label><input value="Round trip" id="rdotrip" name="rdotrip" type="checkbox" checked="true" > Pulang</label>
														<div class="form-group row">
																<div class="col-xs-6" style="width: 100%">
																		<div class="datepicker-wrap" id="tanggal_back">
																				<input value="<?php print date("d F Y",strtotime("+2 days"))?>" type="text" id="tglr" name="tglr" class="input-text full-width" placeholder="dd MM YY" />
																		</div>
																</div>
																<!--<div class="col-xs-6">
																		<div class="selector">
																				<select class="full-width">
																						<option value="1">anytime</option>
																						<option value="2">morning</option>
																				</select>
																		</div>
																</div>-->
														</div>
												</div>
												
												<div class="col-md-3">
														<!--<h4 class="title">Who</h4>-->
														<div class="form-group row">
																<div class="col-xs-3">
																		<label>Dewasa</label>
																		<div class="selector adl">
																				<select name="adl" id="adl" class="full-width">
																						<!--<option value="0">00</option>-->
																						<option value="1">01</option>
																						<option value="2">02</option>
																						<option value="3">03</option>
																						<option value="4">04</option>
																						<option value="5">05</option>
																						<option value="6">06</option>
																						<option value="7">07</option>
																				</select>
																		</div>
																</div>
																<div class="col-xs-3">
																		<label>Anak</label>
																		<div class="selector chd">
																				<select name="chd" id="chd" class="full-width">
																						<option value="0">00</option>
																						<option value="1">01</option>
																						<option value="2">02</option>
																						<option value="3">03</option>
																				</select>
																		</div>
																</div>
																<div class="col-xs-3">
																		<label>Bayi</label>
																		<div class="selector inf">
																				<select name="inf" id="inf" class="full-width">
																						<option value="0">00</option>
																						<option value="1">01</option>
																						<option value="2">02</option>
																						<option value="3">03</option>
																				</select>
																		</div>
																</div>
																<!--<div class="col-xs-6">
																		<label>Promo Code</label>
																		<input type="text" class="input-text full-width" placeholder="type here" />
																</div>-->
														</div>
														<div class="form-group row">
																<div class="col-xs-9">
																		<button id="cari" class="full-width icon-check judul" style="height: 63px; font-size: 18px" >
																				CARI TIKET
																		</button>
<!--                                                <button id="cari" onclick="testopen()" class="full-width icon-check judul" style="height: 63px; font-size: 18px" >
																				CARI TIKET
																		</button>-->
																</div>
														</div>
												</div>
			
			
												<div class="col-md-4" style="background-color: white; box-shadow: 0px 0px 15px #888888; padding-bottom: 10px; padding-top: 10px">
														<a id="book-now56" class="button" target="_blank" href="<?php print site_url("mega/umum/apply-new-mega")?>" style="padding: 0px">
														<!--<a class="button" href="javascript:void(0)" style="padding: 0px">-->
															<img style="padding: 0px" src="<?php print base_url()."files/antavaya/slideshow/antavaya-button.jpg"?>" width="100%"/>
					<!--<img style="padding: 0px" src="https://antavaya.com/files/antavaya/adsd/THR-B.png" width="100%"/>-->
														</a>
												</div>
												<!--<div class="col-md-4" style="background-color: white; box-shadow: 0px 0px 15px #888888; padding-bottom: 10px; padding-top: 10px">
														<!--<img src="<?php print base_url()."files/antavaya/ads/dua.png"?>" width="100%"/>
													<h4 style="color: #1a6ea5">SYARAT & KETENTUAN PROMO DISKON 10%</h4>
													<ul style="list-style: disc outside; font-size: 12px; margin-left: 25px; color: black; font-weight: bold">
															<li>Promo diskon 10% berlaku untuk semua jenis kartu kredit Bank Mega.</li>
															<li><span>Promo diskon 10% berlaku hanya pada pukul 19.00 – 24.00 setiap hari sampai dengan 8 Maret 2015.</span></li>
															<li>Periode terbang sampai dengan 31 Desember 2015.</li>
															<li>Perhitungan diskon 10% akan muncul pada kolom Penawaran Khusus Bank MEGA.</li>
															<li>Promo diskon 10% berlaku untuk seluruh maskapai dan tujuan domestik yang ada di <a href="<?php print site_url()?>" style="color: #1a6ea5">www.antavaya.com</a></li>
													</ul>
												</div>-->
			
										</div>
								</form>
							</div>
							<div class="tab-pane fade" id="tour-tab">
									<form name="form_search" method="post" action="<?php print site_url("antavaya/antavaya-tour/series-list")?>">
										<div class="row">
												<div class="col-md-6">
														<!--<h4 class="title">Where</h4>-->
														<div class="form-group row">
															<div class="col-xs-6">
																<label>Tujuan</label>
																<input value="<?php print $this->session->userdata("tour_series_destination")?>" name="tdr" type="text" class="drdr input-text full-width" placeholder="Tujuan" />
															</div>
															<div class="col-xs-6">
																<label>Region</label>
																<?php
																print $this->form_eksternal->form_dropdown("region", array(
																	NULL => "- Pilih -",
																	1 => "Europe",
																	2 => "Africa",
																	3 => "America",
																	4 => "Australia",
																	5 => "Asia",
																	6 => "China",
																	7 => "New Zealand",
																), array($this->session->userdata("tour_series_region")), 'class="drdr input-text full-width"');
																?>
															</div>
														</div>
														<div class="form-group row">
															<div class="col-xs-12">
																<label>Keberangkatan</label>
																<?php
																$drop[0] = "- Pilih -";
																for($bln = 0; $bln < 12 ; $bln++){
																	$bulan = date("m") + $bln;
																	$tahun = date("Y");
																	if($bulan > 11){
																		$bulan = $bulan - 12;
																		$tahun += 1;
																	}
																	$drop[$bulan."|".$tahun] = date("F Y", strtotime($tahun."-".$bulan."-01"));
																}
																print $this->form_eksternal->form_dropdown("bulan", $drop, array($this->session->userdata("tour_series_bulan")), 'class="drdr input-text full-width"');
																?>
															</div>
														</div>
												</div>
												
												<div class="col-md-2">
														<!--<h4 class="title">Who</h4>-->
														<label style="color: white">&nbsp;</label>
														<div class="form-group row">
																<div class="col-xs-9">
																		<button id="cari" class="full-width judul" style="height: 65px; font-size: 18px" >
																				CARI TOUR
																		</button>
<!--                                                <button id="cari" onclick="testopen()" class="full-width icon-check judul" style="height: 63px; font-size: 18px" >
																				CARI TIKET
																		</button>-->
																</div>
														</div>
												</div>
			
			
												<div class="col-md-4" style="background-color: white; box-shadow: 0px 0px 15px #888888; padding-bottom: 10px; padding-top: 10px">
													<a id="book-now56" class="button" href="<?php print site_url("mega/umum/apply-new-mega")?>" target="_blank" style="padding: 0px">
														<!--<a class="button" href="javascript:void(0)" style="padding: 0px">-->
															<img style="padding: 0px" src="<?php print base_url()."files/antavaya/slideshow/antavaya-button.jpg"?>" width="100%"/>
					<!--<img style="padding: 0px" src="https://antavaya.com/files/antavaya/adsd/THR-B.png" width="100%"/>-->
														</a>
												</div>
												<!--<div class="col-md-4" style="background-color: white; box-shadow: 0px 0px 15px #888888; padding-bottom: 10px; padding-top: 10px">
														<!--<img src="<?php print base_url()."files/antavaya/ads/dua.png"?>" width="100%"/>
													<h4 style="color: #1a6ea5">SYARAT & KETENTUAN PROMO DISKON 10%</h4>
													<ul style="list-style: disc outside; font-size: 12px; margin-left: 25px; color: black; font-weight: bold">
															<li>Promo diskon 10% berlaku untuk semua jenis kartu kredit Bank Mega.</li>
															<li><span>Promo diskon 10% berlaku hanya pada pukul 19.00 – 24.00 setiap hari sampai dengan 8 Maret 2015.</span></li>
															<li>Periode terbang sampai dengan 31 Desember 2015.</li>
															<li>Perhitungan diskon 10% akan muncul pada kolom Penawaran Khusus Bank MEGA.</li>
															<li>Promo diskon 10% berlaku untuk seluruh maskapai dan tujuan domestik yang ada di <a href="<?php print site_url()?>" style="color: #1a6ea5">www.antavaya.com</a></li>
													</ul>
												</div>-->
			
										</div>
								</form>
							</div>
					</div>
			</div>
	</div>
	<!-- TAB END -->
	<!-- DESTINATION -->
	<div class="section container">
		<h2>Popular Cruise Deals</h2>
			<div class="row image-box style3">
					<div class="col-sms-6 col-sm-6 col-md-3">
							<article class="box">
									<figure class="animated" data-animation-type="fadeInDown" data-animation-delay="0">
											<a href="ajax/cruise-slideshow-popup.html" class="hover-effect popup-gallery"><img width="270" height="160" alt="" src="http://placehold.it/270x160"></a>
									</figure>
									<div class="details text-center">
											<h4 class="box-title">Greece</h4>
											<p class="offers-content">(15 deal offers)</p>
											<div data-placement="bottom" data-toggle="tooltip" title="4 stars" class="five-stars-container">
													<span style="width: 80%;" class="five-stars"></span>
											</div>
											<p class="description">Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar.</p>
											<a class="button" href="cruise-detailed.html">SEE ALL</a>
									</div>
							</article>
					</div>
					<div class="col-sms-6 col-sm-6 col-md-3">
							<article class="box">
									<figure class="animated" data-animation-type="fadeInDown" data-animation-delay="0.4">
											<a href="ajax/cruise-slideshow-popup.html" class="hover-effect popup-gallery"><img width="270" height="160" alt="" src="http://placehold.it/270x160"></a>
									</figure>
									<div class="details text-center">
											<h4 class="box-title">Singapore</h4>
											<p class="offers-content">(15 deal offers)</p>
											<div data-placement="bottom" data-toggle="tooltip" title="4 stars" class="five-stars-container">
													<span style="width: 80%;" class="five-stars"></span>
											</div>
											<p class="description">Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar.</p>
											<a class="button" href="cruise-detailed.html">SEE ALL</a>
									</div>
							</article>
					</div>
					<div class="col-sms-6 col-sm-6 col-md-3">
							<article class="box">
									<figure class="animated" data-animation-type="fadeInDown" data-animation-delay="0.8">
											<a href="ajax/cruise-slideshow-popup.html" class="hover-effect popup-gallery"><img width="270" height="160" alt="" src="http://placehold.it/270x160"></a>
									</figure>
									<div class="details text-center">
											<h4 class="box-title">Malaysia</h4>
											<p class="offers-content">(15 deal offers)</p>
											<div data-placement="bottom" data-toggle="tooltip" title="4 stars" class="five-stars-container">
													<span style="width: 80%;" class="five-stars"></span>
											</div>
											<p class="description">Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar.</p>
											<a class="button" href="cruise-detailed.html">SEE ALL</a>
									</div>
							</article>
					</div>
					<div class="col-sms-6 col-sm-6 col-md-3">
							<article class="box">
									<figure class="animated" data-animation-type="fadeInDown" data-animation-delay="1.2">
											<a href="ajax/cruise-slideshow-popup.html" class="hover-effect popup-gallery"><img width="270" height="160" alt="" src="http://placehold.it/270x160"></a>
									</figure>
									<div class="details text-center">
											<h4 class="box-title">Europe</h4>
											<p class="offers-content">(15 deal offers)</p>
											<div data-placement="bottom" data-toggle="tooltip" title="4 stars" class="five-stars-container">
													<span style="width: 80%;" class="five-stars"></span>
											</div>
											<p class="description">Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar.</p>
											<a class="button" href="cruise-detailed.html">SEE ALL</a>
									</div>
							</article>
					</div>
			</div>
	</div>
	<!-- DESTINATION END -->
	<!-- RECOMENDED -->
	<div class="section global-map-area parallax" data-stellar-background-ratio="0.5">
			<div class="container">
					<div class="row">
							<div class="col-sm-4">
									<div class="icon-box style10">
											<i class="soap-icon-recommend"></i>
											<small>travel is</small>
											<h4 class="box-title">100% Original Theme</h4>
											<p class="description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
									</div>
							</div>
							<div class="col-sm-4">
									<div class="icon-box style10">
											<i class="soap-icon-insurance"></i>
											<small>We are providing you</small>
											<h4 class="box-title">Custom Travel Icons Pack</h4>
											<p class="description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
									</div>
							</div>
							<div class="col-sm-4">
									<div class="icon-box style10">
											<i class="soap-icon-flexible"></i>
											<small>Fully customizeable</small>
											<h4 class="box-title">Dashboard Included</h4>
											<p class="description">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
									</div>
							</div>
					</div>
			</div>
	</div>
	<!-- RECOMENDED END -->
</section>