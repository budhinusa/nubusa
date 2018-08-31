 <style>
 
.gallery-title
{
		font-family : 'Source Sans Pro', sans-serif;
		font-weight : 900;
		color : #222222;
		text-transform : uppercase;
		font-size : 36px;
		letter-spacing : .25px;
		line-height : 24px;
		padding-bottom : 50px;
    text-align: center;
		padding-top : 20px;
}
.gallery-title:after {
    content: "";
    position: absolute;
    width: 7.5%;
    left: 46.5%;
    height: 45px;
}

/* add a little bottom space under the images */

@media (max-width: 767px) {
    .portfolio>.clear:nth-child(6n)::before {
      content: '';
      display: table;
      clear: both;
    }
}
@media (min-width: 768px) and (max-width: 1199px) {
    .portfolio>.clear:nth-child(8n)::before {
      content: '';
      display: table;
      clear: both;
    }
}
@media (min-width: 1200px) {
    .portfolio>.clear:nth-child(12n)::before {  
      content: '';
      display: table;
      clear: both;
    }
}
  
	
	
	
	/* this is the bit that gives the border color */
	div.list-category h3.title
	{
	display: block;
	padding: 14px 0 15px 0;
	font-size: 20px;
	font-weight: 100;
	margin-bottom: 0px;
	border-bottom: 1px solid;
	}

	div.list-category span.list-footer
	{
	display: block;
	padding: 14px 0 15px 0;
	font-size: 20px;
	font-weight: 100;
	margin-bottom: 0px;
	border-bottom: 1px solid;
	}

	/* removes the border at the top of the list so it doesnt cover up the border above */
	div.list-category a.list-group-item:first-child
	{
	border-top: 0;
	}

	div.list-category .list-footer
	{
	margin-top:-15px;
	}

	div.list-category a.list-group-item  
	{
	border-left: 0;
	border-right: 0;
	border-radius: 0;
	border-bottom: 1px solid #E0E4E9;
	color: #4c4c4c; 
	text-decoration: none;
	padding-left: 0;
	padding-right: 0;
	overflow: hidden;
	}

	.truncate 
	{
	width: 80%;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
	}
 </style>
 <br>
 <div class="container">
				<!--
        <div class="row">
					<div class="gallery col-xs-12">
							<h1 class="gallery-title">Kategori</h1>
					</div>

					<div class="row text-center portfolio">
						
						<div class="col-lg-2 col-sm-3 col-xs-4">
								<div class="panel panel-default">
										<div class="panel-body">
												<a class="filter-button" data-filter="all">
														<img src="<?php echo site_url('file/index/cms_gallery/' . $kategori[0]->id_cms_gallery) ?>" class="img-thumbnail img-responsive">
												</a>
										</div>
										<div class="panel-footer">
												<a class="filter-button" data-filter="all"><h4><b>Semua</b></h4></a>
										</div>  
								</div> 
						</div>
						<?php
							foreach($kategori as $idxx=>$valxx){
						?>
							<div class="col-lg-2 col-sm-3 col-xs-4">
									<div class="panel panel-default">
											<div class="panel-body">
													<a class="filter-button" data-filter="<?php echo $valxx->id_cms_kategori ?>">
															<img src="<?php echo site_url('file/index/cms_gallery/' . $valxx->id_cms_gallery) ?>" class="img-thumbnail img-responsive">
													</a>
											</div>
											<div class="panel-footer">
													<a class="filter-button" data-filter="<?php echo $valxx->id_cms_kategori ?>">
													<h4><b><?php echo isset($valxx->kategori) ? $valxx->kategori : '' ?></b></h4>
													</a>
											</div>  
									</div> 
							</div>
						<?php
							}
						?>
					</div>
				</div>
				-->
				
				<div class="row">
					<div class="gallery col-md-9">
							<h1 class="gallery-title">Gallery</h1>
					</div>
					<div class="row text-center portfolio">
						<div class="col-md-9">
						<?php
							foreach($data as $idx => $val){
						?>
						
								<div class="col-lg-4 col-sm-4 col-xs-4 filter <?php echo $val->id_cms_kategori ?>">
										<div class="panel panel-default">
												<div class="panel-body">
														<a target="_blank" class="popup-link" href="<?php echo site_url('file/index/cms_gallery/' . $val->id_cms_gallery) ?>">
																<img src="<?php echo site_url('file/index/cms_gallery/' . $val->id_cms_gallery) ?>" class="img-thumbnail img-responsive">
														</a>
												</div>
												<div class="panel-footer">
														<?php echo isset($val->title) ? $val->title : '' ?>
												</div>  
										</div> 
								</div>
						<?php
							}
						?>
						</div>
						<div class="col-md-3">
							<div class="row"> 	

								<div class="col-md-12 list-category text-danger">
								
									<h3 class="title">
									    Category
									</h3>
							 
									<div class="list-group">
										<?php
											foreach($kategori as $idxx=>$valxx){
										?>
											<a data-filter="<?php echo $valxx->id_cms_kategori ?>" class="list-group-item filter-button"><div class="truncate pull-left">
												<i class="fa fa fa-photo"></i>
												<?php echo isset($valxx->kategori) ? $valxx->kategori : '' ?>
											</div></a>
										<?php
											}
										?>
									</div>
									
                  <span class="list-footer">
										<a href="#" class="btn btn-sm btn-danger filter-button" data-filter="all">View All</a>
                  </span>

								</div>
								
							</div>
						</div>
					</div>
				</div>
    </div>
</section>
