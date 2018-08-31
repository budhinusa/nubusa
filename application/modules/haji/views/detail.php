<!--====== BANNER ==========-->
<section>
		<div class="rows inner_banner">
				<div class="container">
						<ul><li><a href="#inner-page-title">Home</a></li><li><i class="fa fa-angle-right" aria-hidden="true"></i> </li><li><a href="#inner-page-title" class="bread-acti">Detail Book</a></li></ul>
				</div>
		</div>
</section>
<!--====== TOUR DETAILS - BOOKING ==========-->
<section>
		<div class="rows banner_book" id="inner-page-title">
				<div class="container">
						<div class="banner_book_1">
								<ul>
										<li class="dl1">Location</li>
										<li class="dl1"><?php print $haji[0]->destination ?></li>
										<li class="dl2">Depart : <?php print date("d M y", strtotime($haji[0]->tanggal)) ?></li>
										<li class="dl3"><a href="<?php echo site_url("haji/book_detail/" . $id . "/" . $id_sc) ?>">Book Now</a>
										</li>
								</ul>
						</div>
				</div>
		</div>
</section>
<!--====== TOUR DETAILS ==========-->
<?php
	if($this->session->flashdata('success')){
		echo "<h2 class='alert alert-success'>".$this->session->flashdata('success')."</h2> ";
	}
	if($this->session->flashdata('notice')){
		echo "<h2 class='alert alert-warning'>".$this->session->flashdata('notice')."</h2>";
	}
?>

<section>
		<div class="rows inn-page-bg com-colo">
				<div class="container inn-page-con-bg tb-space">
						<div class="col-md-9">
							<!--====== TOUR TITLE ==========-->
							<div class="tour_head">
									<h2><?php print $haji[0]->title?></h2>
									<span><?php print $haji[0]->sub_title?></span>
							</div>
							<!--====== TOUR DESCRIPTION ==========-->
							<div class="tour_head1">
									<h3>Description</h3>
									<div class="col-xs-12 b_packages">
											<div class="v_place_img" style="margin-bottom:24px;"><img src="<?php print site_url('file/index/siteumroh_product_pic/' . $haji[0]->id_site_umroh_products) ?>" alt="Foto" title="Foto" />
											</div>
									</div>
									<!-- Nav Tabs-->
									<ul class="nav nav-tabs" id="myTab">
										 <li class="active">
													<a href="#def" data-toggle="tab"><?php print date("d M y", strtotime($haji[0]->tanggal))?></a>
											</li>
											<?php
											foreach($schedule AS $key => $sch){
												if($sch->promo == 'Promo'){
													$promoflag = '<label class="label label-success" style="font-size:14px">'.$sch->promo.'</label>' ;
												}else{
													$promoflag = '<label class="label label-info" style="font-size:14px">'.$sch->promo.'</label>' ;
												}
												print "<li>"
													. "<a href='#def-{$key}' data-toggle='tab'>".date("d M y", strtotime($sch->tanggal))."</a>"
												. "</li>";
												$det .= "<div class='tab-pane' id='def-{$key}'>"
													. "<table width='100%' id='myTable' class='myTable'>"
														. "<thead>"
															. "<tr>"
																. "<th colspan='3'>Biaya Paket & Akomodasi</th>"
															. "</tr>"
															. "<tr>"
																. "<th>Hotel</th>"
																. "<th>Room</th>"
																. "<th>Biaya /org*</th>"
															. "</tr>"
														. "</thead>"
														. "<tbody>"
															. "<tr>"
																. "<td rowspan='3'>".nl2br($sch->hotel)."</td>"
																. "<td>Double</td>"
																. "<td style='text-align: right'>IDR ".number_format($sch->price_double)."</td>"
															. "</tr>"
															. "<tr>"
																. "<td>Triple</td>"
																. "<td style='text-align: right'>IDR ".number_format($sch->price_triple)."</td>"
															. "</tr>"
															. "<tr>"
																. "<td>Quad</td>"
																. "<td style='text-align: right'>IDR ".number_format($sch->price_quad)."</td>"
															. "</tr>"
														. "</tbody>"
													. "</table>"
													. " *Harga berlaku untuk minimal 15 orang per keberangkatan, Tanpa mengurangi nilai Ibadah, "
													. " harga dan Program sewaktu-waktu dapat berubah disesuaikan dengan kondisi Penerbangan, visa dan akomodasi."
													. "<hr />"
													. "<div class='row'>
															<div class='col-md-6'>
																<div class='featur'>
																		<h4>Tujuan</h4>
																		<h5>".$sch->destination."</h5>
																</div>
															</div>
															<div class='col-md-6'>
																<div class='featur'>
																		<h4>Maskapai</h4>
																		<h5>".$sch->maskapai."</h5>
																</div>
															</div>
															<div class='col-md-6'>
																<div class='featur'>
																		<h4>Ustad</h4>
																		<h5>".$sch->ustad."</h5>
																</div>
															</div>
															<div class='col-md-6'>
																<div class='featur'>
																		<h4>Type</h4>
																		<h5>".$promoflag."</h5>
																</div>
															</div>
														</div>"
													. "{$haji[0]->descriptions}"
												. "</div>";
											}
											?>
											<li>
												<a href="#other" data-toggle="tab">Other</a>
											</li>
									</ul>
									
									
									<div class="tab-content">
									<br>
											<!-- Tab One - Hotel -->
											<div class="tab-pane active" id="def">
												<table id="myTable">
													<thead>
														<tr>
															<th colspan='3'>Biaya Paket & Akomodasi</th>
														</tr>
														<tr>
															<th>Hotel</th>
															<th>Room</th>
															<th>Biaya /org*</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td rowspan='3'><?php print nl2br($haji[0]->hotel)?></td>
															<td>Double</td>
															<td style='text-align: right'>IDR <?php print number_format($haji[0]->price_double)?></td>
														</tr>
														<tr>
															<td>Triple</td>
															<td style='text-align: right'>IDR <?php print number_format($haji[0]->price_triple)?></td>
														</tr>
														<tr>
															<td>Quad</td>
															<td style='text-align: right'>IDR <?php print number_format($haji[0]->price_quad)?></td>
														</tr>
													</tbody>
												</table>
													*Harga berlaku untuk minimal 15 orang per keberangkatan, Tanpa mengurangi nilai Ibadah,
													harga dan Program sewaktu-waktu dapat berubah disesuaikan dengan kondisi Penerbangan, visa dan akomodasi.
													<hr />
													
												
												<!-- Slider -->
												<div class="row">
														<div class="col-sm-5" id="slider-thumbs">
															<div class="row">
																<?php
																	foreach($pictures as $idx => $val){
																?>
																<div class="col-sm-3">
																	<a class="thumbnail" id="carousel-selector-<?php echo $idx ?>">
																			<img src="<?php print site_url('file/index/crmumroh_inventory/' . $val->id_site_umroh_products_pictures) ?>">
																	</a>
																</div>
																<?php
																	}
																?>
															</div>
														</div>
														<div class="col-sm-7">
																<div class="col-xs-12" id="slider">
																		<!-- Top part of the slider -->
																		<div class="row">
																				<div class="col-sm-12" id="carousel-bounding-box">
																						<div class="carousel slide" id="myCarousel">
																								<!-- Carousel items -->
																								<div class="carousel-inner">
																										<?php
																											foreach($pictures as $idxc => $valc){
																										?>
																											<?php
																												if($idxc == 0){
																											?>
																												<div class="active item" data-slide-number="<?php echo $idxc ?>">
																														<img src="<?php print site_url('file/index/crmumroh_inventory/' . $valc->id_site_umroh_products_pictures) ?>">
																												</div>
																											<?php
																												}else{
																											?>
																												<div class="item" data-slide-number="<?php echo $idxc ?>">
																														<img src="<?php print site_url('file/index/crmumroh_inventory/' . $valc->id_site_umroh_products_pictures) ?>">
																												</div>
																											<?php
																												}
																											?>
																										<?php
																											}
																										?>
																								</div>
																								<!-- Carousel nav -->
																								<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
																										<span class="glyphicon glyphicon-chevron-left"></span>
																								</a>
																								<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
																										<span class="glyphicon glyphicon-chevron-right"></span>
																								</a>
																						</div>
																				</div>
																		</div>
																</div>
														</div>
												</div>
												
												<hr>
												
												<div class="row">
													<div class="col-md-6">
														<div class="featur">
																<h4>Tujuan</h4>
																<h5><?php echo $haji[0]->destination ?></h5>
														</div>
													</div>
													<div class="col-md-6">
														<div class="featur">
																<h4>Maskapai</h4>
																<h5><?php echo $haji[0]->maskapai ?></h5>
														</div>
													</div>
													<div class="col-md-6">
														<div class="featur">
																<h4>Ustad</h4>
																<h5><?php echo $haji[0]->ustad ?></h5>
														</div>
													</div>
													<div class="col-md-6">
														<div class="featur">
																<h4>Type</h4>
																<h5><?php 
																	if($haji[0]->promo == 'Promo'){
																		echo '<label class="label label-success" style="font-size:14px">'.$haji[0]->promo.'</label>' ;
																	}else{
																		echo '<label class="label label-info" style="font-size:14px">'.$haji[0]->promo.'</label>' ;
																	}
																	?></h5>
														</div>
													</div>
												</div>
												
												<?php print $haji[0]->descriptions?>
												<hr>
												<?php print $haji[0]->special_note?>
												<hr>
												<?php print $haji[0]->hotel_descriptions?>
											</div>
											<?php print $det;?>
											<div class="tab-pane" id="other">
												<p>
													Schedule : <?php print $this->form_eksternal->form_dropdown("sch", $tanggal, array(), "id='change-schedule' class='input'")?>
												</p>
											</div>
											<!-- end Tab One - Hotel -->
									</div>
							</div>
						</div>
						<div class="col-md-3 tour_r">
								<!--====== TRIP INFORMATION ==========-->
								<div class="tour_right tour_incl tour-ri-com">
										<h3>Trip Information</h3>
										<ul>
												<li>Location : <?php print $haji[0]->destination?></li>
												<li>Departure Date: <?php print date("d M y", strtotime($haji[0]->tanggal))?></li>
										</ul>
								</div>
								<!--====== HELP PACKAGE ==========-->
								<div class="tour_right head_right tour_help tour-ri-com">
										<h3>Help & Support</h3>
										<div class="tour_help_1">
												<h4 class="tour_help_1_call">Call Us Now</h4>
												<h4><i class="fa fa-phone" aria-hidden="true"></i> +62 21 723 0215 </h4>
										</div>
								</div>
						</div>
				</div>
		</div>
</section>