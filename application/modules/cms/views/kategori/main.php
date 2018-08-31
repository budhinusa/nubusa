<main role="main" class="body">
	<div id="page-info" data-name="inner order information" data-active-page="0" data-menu-target="#top-nav"></div>
	<section class="clearfix main-content m-t-30 mt-sm-0">
		<div class="container">
		<?php
			if(!empty($data)){
		?>
			<div class="row">
				<div class="col-md-9">
					<div class="panel panel-primary">
						<div class="panel-body">
							<section id="ticket-form" class="ticket-form">
								<div class="row">
									<div class="col-md-12">
										<?php
											if(!empty($data->file)){
										?>
										<img alt="Banner" src="<?php echo site_url('file/index/cms_page/' . $data->id_cms_page) ?>" style="width:100%;height: 230px;"/>
										<?php
										}
										?>
									</div>
								</div>
								<br>
								<h3><b><center><?php echo isset($data->title) ? $data->title : '' ?></center></b></h3>
								</br>
								<div class="row">
									<div class="col-md-12">
										<?php 
											echo htmlspecialchars_decode($data->note);
										
										?>

									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="panel-title">Contact Us</h4>
						</div>
						<div class="panel-body">
								<div class="flight-journey-body">
									<div class="row">
										<div class="col-md-12">
										<h5>Jl. Melawai Raya No 116-B, Jakarta 12160
										</h5>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<h5 style="color:#1a6ea5"><span class="fa fa-phone"> +62 21 723 0215 </span></h5> 
											<h5><span class="fa fa-envelope">  umroh@antavaya.com </span></h5>
										</div>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		<?php
			}else{
				echo "<h4>TIDAK ADA PAGE</h4>";
			}
		?>
		</div>
	</section>
</main>