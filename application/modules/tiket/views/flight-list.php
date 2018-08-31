<script type="text/javascript" src="<?php print $url?>js/jquery-1.11.1.min.js"></script>
<div class="page-title-container">
			<div class="container">
					<div class="page-title pull-left">
							<h2 class="entry-title">Flight Search Results</h2>
					</div>
					<ul class="breadcrumbs pull-right">
							<li><a href="#">HOME</a></li>
							<li class="active">Flight Search Results</li>
					</ul>
			</div>
	</div>
	
	<section id="content">
			<div class="container">
					<div id="main">
							<div class="row">
									<div class="col-sm-12 col-md-12">
											<div class="sort-by-section clearfix">
													<h4 class="sort-by-title block-sm">Sort Flight by :</h4>
													<ul class="sort-bar clearfix block-sm">
															<li class="sort-by-name"><a class="sort-by-container" href="#"><span>name</span></a></li>
															<li class="sort-by-price" id="price_sort" value="1"><a class="sort-by-container" href="#"><span>Harga</span></a></li>
															<li class="sort-by-rating active"><a class="sort-by-container" href="#"><span>duration</span></a></li>
													</ul>
											</div>
											<div class="c-list listing-style3 car">
													<!-- List Menu -->
													<article class="box" id="box_header">
															<figure class="col-xs-3 col-sm-2">
																	<span></span>
															</figure>
															<div class="details col-xs-9 col-sm-10">
																	<div class="details-wrapper">
																			<div class="first-row">
																					<div class="time">
																							<div class="total-time col-sm-2">
																									<div class="icon"><i class="soap-icon-plane yellow-color"></i></div>
																									<div>
																											<span class="skin-color">flight no</span>
																									</div>
																							</div>
																							<div class="take-off col-sm-2">
																									<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>
																									<div>
																											<span class="skin-color">Take off</span>
																									</div>
																							</div>
																							<div class="landing col-sm-2">
																									<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>
																									<div>
																											<span class="skin-color">landing</span>
																									</div>
																							</div>
																							<div class="take-off col-sm-2">
																									<div class="icon"><i class="soap-icon-businessbag yellow-color"></i></div>
																									<div>
																											<span class="skin-color">fasilitas</span>
																									</div>
																							</div>
																							<div class="landing col-sm-2">
																									<div class="icon"><i class="soap-icon-recommend yellow-color"></i></div>
																									<div>
																											<span class="skin-color">harga</span>
																									</div>
																							</div>
																					</div>
																					<figure id="figure_head" style="width:75px">
																							<span></span>
																					</figure>
																			</div>
																	</div>
															</div>
													</article>
													<script type="text/javascript">
														$(function() {

															// set the offset pixels automatically on how much the sidebar height is.
															// plus the top margin or header height
															var offsetPixels = $('#box_header').outerHeight() + 200;
															var w = window.innerWidth;

															$(window).scroll(function() {
																if ( $(window).scrollTop() > offsetPixels ) {
																	$('#box_header').css({
																		'position': 'fixed',
																		'top': '45px',
																		'z-index': '1'
																	});
																	$('#figure_head').css({
																		'width': '265px'
																	});
																	
																	if(w > 1032 && w < 1150){
																		$('#figure_head').css({
																			'width': '200px'
																		});
																	} else if(w < 1032){
																		$('#figure_head').css({
																			'width': '100px'
																		});
																	}
																} else {
																	$('#box_header').css({
																		'position': 'static'
																	});
																	$('#figure_head').css({
																		'width': '75px'
																	});
																}
															});
														});
													</script>
													<article class="box" id="box_header_fake">
															<figure class="col-xs-3 col-sm-2">
																	<span></span>
															</figure>
															<div class="details col-xs-9 col-sm-10">
																	<div class="details-wrapper">
																			<div class="first-row">
																					<div class="time">
																							<div class="take-off col-sm-4">
																									<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>
																									<div>
																											<span class="skin-color">Take off</span>
																									</div>
																							</div>
																							<div class="landing col-sm-3">
																									<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>
																									<div>
																											<span class="skin-color">landing</span>
																									</div>
																							</div>
																							<div class="landing col-sm-3">
																									<div class="icon"><i class="soap-icon-recommend yellow-color"></i></div>
																									<div>
																											<span class="skin-color">harga</span>
																									</div>
																							</div>
																					</div>
																					<figure class="col-xs-2 col-sm-2">
																							<span></span>
																					</figure>
																			</div>
																	</div>
															</div>
													</article>
													<script type="text/javascript">
														$(function() {

															// set the offset pixels automatically on how much the sidebar height is.
															// plus the top margin or header height
															var offsetPixels = $('#box_header_fake').outerHeight() + 300;

															$(window).scroll(function() {
																if ( $(window).scrollTop() > offsetPixels ) {
																	$('#box_header_fake').css({
																		'position': 'fixed',
																		'top': '0px',
																		'z-index': '1'
																	});
																} else {
																	$('#box_header_fake').css({
																		'position': 'static'
																	});
																}
															});
														});
													</script>
													
													<!-- List Large -->
													<div id="container_flight_box">
													</div>
													
											</div>
									</div>
							</div>
					</div>
			</div>
			
	</section>
	
	<script type="text/javascript" src="<?php print $url?>js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('themes/antavaya2/js/vue.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('themes/antavaya2/js/lodash.js') ?>"></script>
	<script type="text/javascript">
	jQuery(document).ready(function(){
			// klik sorting price
			jQuery('#price_sort').on('click', function(event) 
			{  
					var price = jQuery('#price_sort').val();
					var $divs = $(".flight_box");
					var $divs_fake = $(".flight_box_fake");
					console.log($divs);
					console.log($divs_fake);
					if(price == 1){
						var OrderedDivs = $divs.sort(function (a, b) {
								return $(a).find(".price_val").text() > $(b).find(".price_val").text();
						});
						var OrderedDivsFake = $divs_fake.sort(function (a, b) {
								return $(a).find(".price_val").text() > $(b).find(".price_val").text();
						});
						var DivMerge = $.merge(OrderedDivs, OrderedDivsFake);
						$("#container_flight_box").html(DivMerge);
						jQuery('#price_sort').val("0");
					} 
					if(price == 0){
						var OrderedDivs = $divs.sort(function (a, b) {
								return $(a).find(".price_val").text() < $(b).find(".price_val").text();
						});
						var OrderedDivsFake = $divs_fake.sort(function (a, b) {
								return $(a).find(".price_val").text() < $(b).find(".price_val").text();
						});
						var DivMerge = $.merge(OrderedDivs, OrderedDivsFake);
						$("#container_flight_box").html(DivMerge);
						jQuery('#price_sort').val("1");
					}
			});
			
			//load flight
			flight_get("QG");
			flight_get("LI");
			
			
	});
	
	function flight_get(maskapai){
		$.ajax({ url: "<?php echo site_url('tiket/ajax_flight_get') ?>" + "/" + maskapai,
			context: document.body,
			success: function(data) {
				var hasil = $.parseJSON(data);
				$("#container_flight_box").append(hasil.html);
				// console.log(hasil.html);
				// console.log(hasil);
			}});
	}
	</script>
	
	<script type="text/javascript">
		var demo = new Vue({
			el: '#main',
			data: {
					searchString: "",

					// The data model. These items would normally be requested via AJAX,
					// but are hardcoded here for simplicity.

					/* articles: <?php echo $data['json_flight'] ?> */
					articles: [
											{id: 1,  message: 'first', harga:'5000', id_flag_detail:'#flag_detail_11', flag_detail:'flag_detail_11'},
											{id: 2, message: 'second', harga:'4000', id_flag_detail:'#flag_detail_12', flag_detail:'flag_detail_12'},
											{id: 3,  message: 'third', harga:'3000', id_flag_detail:'#flag_detail_13', flag_detail:'flag_detail_13'}
										]
			},
			computed: {
					// A computed property that holds only those articles that match the searchString.
					filteredArticles: function () {
							var articles_array = this.articles,
									searchString = this.searchString;

							if(!searchString){
									return articles_array;
							}
							
							if(searchString == 'max'){
								articles_array = _.orderBy(this.articles, 'harga_tampil','desc');
							}
							if(searchString == 'min'){
								articles_array = _.orderBy(this.articles, 'harga_tampil','asc');
							}
							

							// Return an array with the filtered data.
							return articles_array;;
					}
			}
	});
</script>