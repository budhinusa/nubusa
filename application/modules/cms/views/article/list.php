<main role="main" class="">
	<div id="page-info" data-name="inner order information" data-active-page="0" data-menu-target="#top-nav"></div>
	<div class="well blue m-b-5">
			<h3><center><?php print lang($title)?></h3>
			<p>
			
			</p>
	</div>
	<section class="clearfix main-content m-t-30 mt-sm-0">
		<div class="container">
			<!--===== POSTS ======-->
			<div class="rows">
				<div class="col-md-12">
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
							<input type="submit" value="LOAD MORE" id="load-more" class="btn btn-round btn-red btn-md btn-next">
							</center>
						</div>
					</div>
				</div>
				
						
			</div>
			<!--===== POST END ======-->
		</div>
	</section>
</main>