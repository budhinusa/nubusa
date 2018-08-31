<!--====== BOOKING ==========-->
<section>
		<div class="form form_booking rows form-spac">
				<div class="container">
						<!-- TITLE & DESCRIPTION -->
						<div class="spe-title col-md-12">
								<h2>Daftar <span>Booking</span></h2>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form_1 form_book wow fadeInLeft" data-wow-duration="1s">
								<!--====== SUCCESS MESSAGE ==========-->
								<div class="succ_mess">Thank you for Booking with us we will get back to you soon.</div>
								<!--====== BOOKING FORM ==========-->
								 <?php print $this->form_eksternal->form_open('haji/book/' . $id . "/" . $id_sc)?>
								 <?php echo validation_errors("<label>", "</label>");
									if($this->session->flashdata('success')){
									?>
									<div class="alert alert-success alert-dismissable">
											<i class="fa fa-check"></i>
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
											<b>Success!</b> <?php print $this->session->flashdata('success')?>.
									</div>
									<?php
									}
									if($this->session->flashdata('notice')){
									?>
									<div class="alert alert-danger alert-dismissable">
											<i class="fa fa-ban"></i>
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
											<b>Filed!</b> <?php print $this->session->flashdata('notice')?>.
									</div>
									<?php
									}
									?>
									<hr />
									<ul>
											<li>
													<input type="text" name="first_name" value="" id="first_name" placeholder="First Name" required>
											</li>
											<li>
													<input type="text" name="last_name" value="" id="last_name" placeholder="Last Name" required>
											</li>
											<li>
													<input type="tel" name="no_telp" value="" id="no_telp" placeholder="Mobile" required>
											</li>
											<li>
													<input type="email" name="email" value="" id="email" placeholder="Email id" required>
											</li>
											<li>
													<textarea name="address" cols="40" rows="3" id="address" placeholder="Address"></textarea>
											</li>
											<li>
													<textarea name="note" cols="40" rows="3" id="note" placeholder="Enter your message"></textarea>
											</li>
											<li>
													<input type="submit" value="Daftar" id="Daftar">
											</li>
									</ul>
						</div>
						
				</div>
		</div>
</section>