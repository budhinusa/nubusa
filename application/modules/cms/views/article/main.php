<?php
	$content_share = substr(strip_tags($data->note),0,100);
	$url_share = "http://antavaya-transport.com" . uri_string();
?>
<br>
<main role="main" class="body">
	<div id="page-info" data-name="inner order information" data-active-page="0" data-menu-target="#top-nav"></div>
	<section class="clearfix main-content m-t-30 mt-sm-0">
		<div class="container">
		<?php
			if(!empty($data)){
		?>
			<div class="row">
				<section class="col-md-9 content-left">
					<section id="info-ticket" class="element-item info-ticket ">
						<div class="panel panel-primary">
							<div class="panel-body">
								<section id="ticket-form" class="ticket-form">
									<div class="row">
										<div class="col-md-12">
											<?php
												print $this->form_eksternal->form_input('id_cms_article', $data->id_cms_article, 'id="id_cms_article" style="display: none"');
												if(!empty($data->file)){
											?>
											<img alt="Banner" src="<?php echo site_url('file/index/cms_article/' . $data->id_cms_article) ?>" style="width:100%;"/>
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
											<?php echo isset($data->note) ? $data->note : '' ?>

										</div>
									</div>
								</section>
							</div>
						</div>
					</section>
				</section>
				<div class="col-md-3">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="panel-title">SHARE THIS PACKAGE </h4>
						</div>
						<div class="panel-body">
							<div class="fb-share-button" data-href="<?php echo $url_share ?>" data-layout="box_count" data-size="small" data-mobile-iframe="true">
								<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"><i class="fa fa-facebook" aria-hidden="true"></i></a>
							</div>
							<a href="https://twitter.com/intent/tweet?text=<?php echo $content_share ?>" class="twitter-share-button tw1"><i class="fa fa-twitter" aria-hidden="true"></i></a>
							<div class="g-plus" data-action="share" data-href="<?php echo $url_share ?>" data-annotation="vertical-bubble"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<section class="col-md-9 content-left">
					<section id="info-ticket" class="element-item info-ticket ">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4 class="panel-title"><?php print lang("Tulis Komentar")?></h4>
							</div>
							<div class="panel-body">
								<section id="ticket-form" class="ticket-form">
									<div class="form-group">
										<div class="row">
											<div class="col-md-12">
												<div class="label-wrap">
													<label><?php print lang("Komentar")?></label>
												</div>
												<textarea class="form-control name ticket-form-name value-check" name="comment" id="comment" value="" required></textarea>
											</div>
										</div>
									</div>
								</section>
								<section class="text-center mb-sm-30">
									<input type="button" value="SUBMIT" id="btn-comment" class="btn btn-round btn-red btn-sm btn-next">
								</section>
							</div>
							<div class="panel-body">
								<section id="ticket-form" class="ticket-form">
									<div class="form-group">
										<?php
										if(!empty($comment)){
											foreach($comment as $idx => $val){
										?>
											<div class="col-md-8">
												<div class="label-wrap">
													<h4><label class="label label-primary"><?php echo isset($val->USER) ? strtoupper($val->USER) : '' ?></label>
												</div>
											</div>
											<div class="col-md-4" align="right">
												<div class="label-wrap">
													<h6><?php echo isset($val->create_date) ? $val->create_date : '' ?>
												</div>
											</div>
											<div class="col-md-12">
												<div class="label-wrap" style="font-size:18px; padding-top:10px; padding-bottom:10px;">
													<label><?php echo isset($val->note) ? $val->note : '' ?></label>
												</div>
											</div>
										<hr>
										<?php
											}
										}else{
											echo "<h4>TIDAK ADA KOMENTAR</h4>";
										}
										?>
									</div>
								</section>
							</div>
						</div>
					</section>
				</section>
			</div>
			<br>
			<div class="row">
				<section class="col-md-9 content-left">
					<section id="info-ticket" class="element-item info-ticket ">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4 class="panel-title"><?php print lang("Komentar Facebook")?></h4>
							</div>
							<div class="panel-body">
									<center>
									<div class="fb-comments" data-href="https://developers.facebook.com/docs/plugins/comments#<?php echo $url_share ?>" data-numposts="5" data-width="800"></div>
									</center>
							</div>
						</div>
					</section>
				</section>
			</div>
		<?php
			}else{
				echo "<h4>TIDAK ADA PAGE</h4>";
			}
		?>
		</div>
	</section>
</main>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script >
  window.___gcfg = {
    lang: 'id',
    parsetags: 'onload'
  };
</script>
<script>
// FACEBOOK
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.9&appId=1354009498008373";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// TWITTER
window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));
</script>