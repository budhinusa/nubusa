<main role="main" class="body">
	<div id="page-info" data-name="inner order information" data-active-page="0" data-menu-target="#top-nav"></div>
	<section class="clearfix main-content m-t-30 mt-sm-0">
		<div class="container">
			<div class="row">
				<section class="col-md-8 content-left">
					<section id="info-ticket" class="element-item info-ticket ">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4 class="panel-title">Send us a Message</h4>
							</div>
							<div class="panel-body">
								<form id="contact_us" action="#" method="post">
									<section id="ticket-form" class="ticket-form">
										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<div class="label-wrap">
														<label><?php print lang("Nama")?></label>
													</div>
													<input type="text" class="form-control name ticket-form-name value-check" name="name" id="name" value="" required>
												</div>
												<div class="col-md-6">
													<div class="label-wrap">
														<label><?php print lang("Alamat Email")?></label>
													</div>
													<input type="email" class="form-control name value-check" name="email" id="email" value="" required>
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-12">
													<div class="label-wrap">
														<label><?php print lang("SUBJECT")?></label>
													</div>
													<input type="subject" class="form-control name value-check" name="subject" id="subject" value="" required>
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-12">
													<div class="label-wrap">
														<label><?php print lang("YOUR MESSAGE")?></label>
													</div>
													<textarea class="form-control name ticket-form-name value-check" name="note" id="note" value=""></textarea>
												</div>
											</div>
										</div>
									</section>
									<input type="Submit" value="KIRIM" class="btn btn-danger">
								</form>
							</div>
						</div>
					</section>
				</section>
				<section class="col-md-4 content-right visible-md-block visible-lg-block">
					<section id="info-depart" class="element-item info-depart">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4 class="panel-title">Contact Us</h4>
							</div>
							<div class="panel-body">
									<div class="flight-journey-body">
										<div class="row">
											<div class="col-md-12">
											<h5>AntaVaya Building,
													Jl. Batutulis Raya No. 38,
													Jakarta 10120 Indonesia
											</h5>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<h5>Sales & Account Management Division</h5>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<h5 style="color:#1a6ea5">+6221 380 0202</h5> 
												<h5>sam@antavaya.com</h5>
											</div>
										</div>
									</div>
							</div>
						</div>
					</section>
				</section>
			</div>
		</div>
	</section>
</main>
<script>
$("#contact_us").on("submit", function (e) {

		var name = $('#name').val();
		var email = $('#email').val();
		var subject = $('#subject').val();
		var note = $('#note').val();
		$.post("contact/send_message", { email: email, name: name, subject: subject, note: note }, function (data) {
				alert(data);
				$('#email').val("");
		});


		e.preventDefault();
})

</script>