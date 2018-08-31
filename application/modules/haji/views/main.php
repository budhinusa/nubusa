<!--====== BANNER ==========-->
<section>
		<div class="rows inner_banner">
				<div class="container">
						<h2><span>Product Umroh</span></h2><ul><li><a href="#inner-page-title">Home</a></li><li><i class="fa fa-angle-right" aria-hidden="true"></i> </li><li><a href="#inner-page-title" class="bread-acti">Umroh</a></li></ul>
				</div>
		</div>
</section>
<!--====== PLACES ==========-->
<section>
		<div class="rows inn-page-bg com-colo">
				<div class="container inn-page-con-bg tb-space pad-bot-redu-5" id="inner-page-title">
						<!-- TITLE & DESCRIPTION -->
						<div class="spe-title col-md-12">
								<h2>TOP <span>Product Umroh</span></h2>
								<div class="title-line">
										<div class="tl-1"></div>
										<div class="tl-2"></div>
										<div class="tl-3"></div>
								</div>
						</div>
						<!--===== PLACES ======-->
						<div class="rows p2_2">
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
										<center>
										<input type="text" id="akhir-data" value="0" style="display: none" />
										<input type="submit" value="LOAD MORE" id="load-more" class="hot-page2-alp-quot-btn">
										</center>
									</div>
								</div>
						</div>
						<!--===== PLACES END ======-->
						
				</div>
		</div>
    </section>