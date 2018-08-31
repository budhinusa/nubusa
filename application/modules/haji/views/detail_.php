<div class="section-title-detailed">
    <!-- Single Carousel-->
    <div id="single-carousel">
        <div class="img-hover">
            <div class="overlay"> <a href="<?php print $haji[0]->file?>" class="fancybox" rel="gallery"></a></div>
            <img src="<?php print $haji[0]->file?>" alt="" class="img-responsive">
        </div>
    </div>
    <!-- End Single Carousel-->

    <!-- Section Title-->
    <div class="title-detailed">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <h2><?php print $haji[0]->title?>
                        <span><?php print $haji[0]->sub_title?></span>
                    </h2>
                </div>

                <div class="col-md-3">

                </div>
            </div>
        </div>
    </div>
    <!-- End Section Title-->
</div>   
<!-- End Section Title-->

<!--Content Central -->
<div class="content-central">
    <!-- Shadow Semiboxed -->
    <div class="semiboxshadow text-center">
        <img src="<?php print $url?>img/img-theme/shp.png" class="img-responsive" alt="">
    </div>
    <!-- End Shadow Semiboxed -->

    <!-- End content info - Features-->
    <div class="content_info skin_base no-overflow">
        <div class="container wow fadeInUp">
            <div class="row">
                <!-- Services Items -->
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="item-service-line" style="padding-top: 25px">
                      <div class="img-hover">
                        <div class="overlay" style="background: rgba(0,0,0,0.2);">
                          <a href="<?php print $haji[0]->thumb?>" class="fancybox" style="padding-top: 15%">
                            <i class="fa fa-plus-circle"></i>
                          </a>
                        </div>
                        <img src="<?php print $haji[0]->thumb?>" alt="" class="img-responsive" style="width: 100%">
                      </div>
                    </div>
                  </div> 
                </div> 
                <!-- End Services Items --> 

                <!-- Form Detailed -->
                <div class="col-md-5">
                    <div class="form-detailed">
                        <div class="header-detailed">
                            <div class="frequency-detailed">
                              Daftar
                            </div>
                        </div>
                        <?php print $this->form_eksternal->form_open()?>
                          <div class="col-md-12">
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
                          </div>
                          <div class="col-md-6">
                            <label>Nama</label>
                            <input type="text" required="required" name="nama" placeholder="Nama" class="input"><br />
                            <label>Email</label>
                            <input type="text" required="required" name="email" placeholder="Email" class="input"><br />
                            <label>Telp</label>
                            <input type="text" required="required" name="telp" placeholder="Telp" class="input"><br />
                          </div>
                          <div class="col-md-6">
                            <label>Note</label>
                            <textarea style="width: 100%; height: 190px" name="note"></textarea>
                          </div>
                          <div class="col-md-12">
                            <br />
                            <input type="submit" value="Daftar">
                          </div>
                        </form>
                    </div>
                </div>   
                <!-- End Form Detailed --> 
            </div>
        </div>
    </div>   
    <!-- End content info - Features--> 

    <!-- End content info - Grey Section-->
    <div class="content_info">
        <!-- Info Resalt-->
        <div class="content_resalt paddings-mini tabs-detailed">
            <div class="container wow fadeInUp">
                <div class="row">
                  <style>
                    body{
                      color: black;
                      font-weight: normal;
                    }
                    td{
                      padding: 5px;
                    }
                    th{
                      text-align: center;
                    }
                  </style>
                    <div class="col-md-9">
                      <h2>Description</h2>
                        <!-- Nav Tabs-->
                        <ul class="nav nav-tabs" id="myTab">
                           <li class="active">
                                <a href="#def" data-toggle="tab"><?php print date("d M y", strtotime($haji[0]->depart))?></a>
                            </li>
                            <?php
                            foreach($schedule AS $key => $sch){
                              print "<li>"
                                . "<a href='#def-{$key}' data-toggle='tab'>".date("d M y", strtotime($sch->depart))."</a>"
                              . "</li>";
                              $det .= "<div class='tab-pane' id='def-{$key}'>"
                                . "<table width='100%' border='1'>"
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
                                      . "<td style='text-align: right'>IDR ".number_format($sch->double)."</td>"
                                    . "</tr>"
                                    . "<tr>"
                                      . "<td>Triple</td>"
                                      . "<td style='text-align: right'>IDR ".number_format($sch->triple)."</td>"
                                    . "</tr>"
                                    . "<tr>"
                                      . "<td>Quad</td>"
                                      . "<td style='text-align: right'>IDR ".number_format($sch->quad)."</td>"
                                    . "</tr>"
                                  . "</tbody>"
                                . "</table>"
                                . " *Harga berlaku untuk minimal 15 orang per keberangkatan, Tanpa mengurangi nilai Ibadah, "
                                . " harga dan Program sewaktu-waktu dapat berubah disesuaikan dengan kondisi Penerbangan, visa dan akomodasi."
                                . "<hr />"
                                . "{$haji[0]->detail}"
                              . "</div>";
                            }
                            ?>
                            <li>
                              <a href="#other" data-toggle="tab">Other</a>
                            </li>
<!--                            <li>
                                <a href="#preferences" data-toggle="tab"><i class="fa fa-camera"></i> Preferences</a>
                            </li>
                           <li>
                                <a href="#faq" data-toggle="tab"><i class="fa fa-check"></i>FAQ QUESTIONS</a>
                            </li>-->
                        </ul>
                        <!-- End Nav Tabs-->

                        <div class="tab-content">
                            <!-- Tab One - Hotel -->
                            <div class="tab-pane active" id="def">
                              <table width='100%' border='1'>
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
                                      <td style='text-align: right'>IDR <?php print number_format($haji[0]->double)?></td>
                                    </tr>
                                    <tr>
                                      <td>Triple</td>
                                      <td style='text-align: right'>IDR <?php print number_format($haji[0]->triple)?></td>
                                    </tr>
                                    <tr>
                                      <td>Quad</td>
                                      <td style='text-align: right'>IDR <?php print number_format($haji[0]->quad)?></td>
                                    </tr>
                                  </tbody>
                                </table>
                                *Harga berlaku untuk minimal 15 orang per keberangkatan, Tanpa mengurangi nilai Ibadah,
                                harga dan Program sewaktu-waktu dapat berubah disesuaikan dengan kondisi Penerbangan, visa dan akomodasi.
                                <hr />
                              <?php print $haji[0]->detail?>
                            </div>
                            <?php print $det;?>
                            <div class="tab-pane" id="other">
                              <p>
                                Schedule : <?php print $this->form_eksternal->form_dropdown("sch", $tanggal, array(), "id='change-schedule' class='input'")?>
                              </p>
                            </div>
                            <!-- end Tab One - Hotel -->

                            <!-- Tab Two - Preferences -->
<!--                            <div class="tab-pane" id="preferences">
                                <p>The Aqua Hotel Onabrava is located in Santa Susanna, in the beautiful Costa Brava, a few steps from the beach.The 350 rooms are equipped with air conditioning and heating, telephone, private bathroom with hairdryer and minibar. They also have flat-screen TVs and balconies.</p>

                                <h3>Hotel facilities </h3>

                                <ul class="services-lines full-services">
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-bicycle"></i>
                                            <h5>Special Activities</h5>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-plane"></i>
                                            <h5>Travel Arrangements</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-user"></i>
                                            <h5>Private Guide</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-search-plus"></i>
                                            <h5>Location Manager</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-map-marker"></i>
                                            <h5>Handpicked Hotels</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-money"></i>
                                            <h5>Best Price Guarantee</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-bank"></i>
                                            <h5>Trust &amp; Safety</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-line-chart"></i>
                                            <h5>Best Travel Agent</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-bed"></i>
                                            <h5>Great Beds</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-automobile"></i>
                                            <h5>Automobile</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-fax"></i>
                                            <h5>Fax Service</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-soccer-ball-o"></i>
                                            <h5> Sports</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-taxi"></i>
                                            <h5>taxi Service</h5>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="item-service-line">
                                            <i class="fa fa-credit-card"></i>
                                            <h5>Credit Card</h5>
                                        </div>
                                    </li>
                                </ul>

                                <h3>Rom facilities </h3>

                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="list-styles">
                                            <li><i class="fa fa-check"></i> Climate control</li>
                                            <li><i class="fa fa-check"></i> Air conditioning</li>
                                            <li><i class="fa fa-check"></i> Direct-dial phone</li>
                                            <li><i class="fa fa-check"></i> Minibar</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="list-styles">
                                            <li><i class="fa fa-check"></i> Wake-up calls</li>
                                            <li><i class="fa fa-check"></i> Daily housekeeping</li>
                                            <li><i class="fa fa-check"></i> Private bathroom</li>
                                            <li><i class="fa fa-check"></i> Hair dryer</li> 
                                        </ul>                                   
                                    </div>  
                                    <div class="col-md-4">
                                        <ul class="list-styles">                              
                                            <li><i class="fa fa-check"></i> Makeup/shaving mirror</li>
                                            <li><i class="fa fa-check"></i> Shower/tub combination</li>
                                            <li><i class="fa fa-check"></i> Satellite TV service</li>
                                            <li><i class="fa fa-check"></i> Electronic/magnetic keys</li>   
                                        </ul>                                   
                                    </div>                                  
                                </div>
                            </div>-->
                            <!-- end Tab Two - Preferences -->

                            <!-- Tab Theree - faq -->
<!--                            <div class="tab-pane" id="faq">
                                <div class="accrodation">
                                     section 1 
                                    <span class="acc-trigger"><a href="#">Mision</a></span>
                                    <div class="acc-container">
                                        <div class="content">
                                            Book cheap hotels and make payment facilities, free cancellation when the hotel so provides, compare prices and find all the options for your vacation.
                                        </div>
                                    </div>

                                     section 2 
                                    <span class="acc-trigger"><a href="#">Vision</a></span>
                                    <div class="acc-container">
                                        <div class="content">
                                            You can choose your favorite destination and start planning your long-awaited vacation. We offer thousands of destinations and have a wide variety of hotels so that you can host and enjoy your stay without problems. Book now your trip travelia.com.
                                        </div>
                                    </div>

                                     section 3 
                                    <span class="acc-trigger"><a href="#">What we offer?</a></span>
                                    <div class="acc-container">
                                        <div class="content">
                                            Find a wide variety of airline tickets and cheap flights, hotels, tour packages, car rentals, cruises and more in travelia.com.You can choose your favorite destination and start planning your long-awaited vacation.
                                        </div>
                                    </div>

                                     section 4 
                                    <span class="acc-trigger active"><a href="#">Our services</a></span>
                                    <div class="acc-container">
                                        <div class="content">
                                            You can also check availability of flights and hotels quickly and easily, in order to find the option that best suits your needs.Book cheap hotels and make payment facilities, free cancellation when the hotel so provides, compare prices and find all the options for your vacation.
                                        </div>
                                    </div>
                                </div> 
                                 End accrodation 
                            </div>-->
                            <!-- Tend ab Theree - faq -->
                        </div>  
                    </div>                 
                </div>
            </div>
        </div>
        <!-- End Info Resalt-->
    </div>   
    <!-- End content info - Grey Section--> 

    <!-- content info - testimonials-->
<!--    <div class="content_info">
         Parallax Background 
        <div class="bg_parallax image_02_parallax"></div>
         Parallax Background 

        <div class="opacy_bg_02">
             Testimonial Propertie
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-testimonial">
                           <ul id="testimonials">
                                <li>
                                    <p><i class="fa fa-quote-left"></i>The hotel is stunning, super recommended. And the treatment of its people in very good, are always attentive to the little things.<i class="fa fa-quote-right"></i></p>

                                    <div class="image-testimonials">
                                        <img src="img/testimonials/1.jpg" alt="">                        
                                    </div>   
                                    <h4>Jeniffer Martinez</h4>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </li>

                                <li>
                                    <p><i class="fa fa-quote-left"></i>Spectacular, excellent personal, restaurants and very good drinks, highly recommended.<i class="fa fa-quote-right"></i></p>

                                    <div class="image-testimonials">
                                        <img src="img/testimonials/2.jpg" alt="">                        
                                    </div>   
                                    <h4>Juan Rendon</h4>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                </li>

                                <li>
                                    <p><i class="fa fa-quote-left"></i>The hotel is stunning, super recommended. And the treatment of its people in very good, are always attentive to the little things.<i class="fa fa-quote-right"></i></p>

                                    <div class="image-testimonials">
                                        <img src="img/testimonials/3.jpg" alt="">                        
                                    </div>   
                                    <h4>Federick Gordon</h4>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                </li>
                           </ul>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="testimonial-info">
                            <h2>TESTIMONIALS</h2>
                            <P>You can choose your favorite destination and start planning your long-awaited vacation. We offer thousands of destinations and have a wide variety of hotels so that you can host and enjoy your stay without problems. Book now your trip travelia.com.</P>
                            <a href="#" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
             End Testimonial Propertie
        </div>
    </div>-->
    <!-- End content info - testimonials-->
</div>