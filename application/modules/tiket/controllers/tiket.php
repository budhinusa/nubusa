<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiket extends MX_Controller {
    
  function __construct() {
    // $this->menu = $this->cek();
  }
  
  /**
   * @author NBS, Wowo
   * @abstract penentuan gambar atau file
   * @param string $module Title dari global_variable->file_path
   * @param string|int $id ID record gambar
   */
  public function index($jlkota = "JAKARTA-DENPASAR", $jlcode_kota = "CGK-DPS"){
		/* $slide = $this->global_models->get_query("SELECT * FROM website_slideshow WHERE status = 1 ORDER BY sort ASC");
    $promosi = $this->global_models->get_query("SELECT * FROM website_promosi WHERE status = 2 ORDER BY price ASC LIMIT 0, 4");
//    $group = $this->global_models->get_query("SELECT * FROM website_group_tour WHERE status = 2 ORDER BY price ASC LIMIT 0, 4");
    $hajj = $this->global_models->get_query("SELECT * FROM website_haji WHERE status = 1 ORDER BY RAND() ASC LIMIT 0, 4");
   // $news = $this->global_models->get_query("SELECT * FROM website_news WHERE status = 1 ORDER BY id_website_news DESC LIMIT 0, 2");
    $fit = $this->global_models->get_query("SELECT * FROM website_promosi WHERE status = 2 ORDER BY RAND() LIMIT 0, 2"); */
		
		$jlcode_kota1 = $this->global_models->array_kota("CGK");
		$jlcode_kota2 = $this->global_models->array_kota("DPS");
		$one_code = explode("_", $jlcode_kota);
		if(count($one_code) > 1){
			$jlcode_kota1_temp = $this->global_models->array_kota($one_code[0]);
			$jlcode_kota2_temp = $this->global_models->array_kota($one_code[1]);
			if($jlcode_kota1_temp AND $jlcode_kota2_temp){
				$jlcode_kota1 = $jlcode_kota1_temp;
				$jlcode_kota2 = $jlcode_kota2_temp;
			}
		}
		
    $this->template
      ->set_layout('default')
      ->build('main', array(
        'url'         => base_url()."themes/antavaya2/",
        'menu'        => "home",
				'theme2nd'    => 'antavaya',
        'title'       => lang("Dashboard"),
        'slide'       => $slide,
				'promosi'     => $promosi,
				'fit'         => $fit,
				'key'         => $key,
				'foot2'       => $foot,
				'group'       => $group,
				'hajj'       => $hajj,
				'jlkota'     => $jlkota,
				'jlcode_kota1' => $jlcode_kota1,
				'jlcode_kota2' => $jlcode_kota2,
				'data_tour'   => $data_array->data,
				'bawahan'     => 2,
      ));
    $this->template
      ->set_layout('default')
      ->set_heads($head)
      ->build("main");
	}
	
	public function flight_list(){
		$pst = $this->input->post();
		
		$view = ($pst['rdotrip'] ? "flight-list-pp" : "flight-list");
    
    $this->template->build($view, 
      array(
        'url'         => base_url()."themes/antavaya2/",
        'theme2nd'    => 'antavaya',
        'data'        => $data,
        'sort'        => $sort,
        'type'        => $type,
        'foot2'       => $foot,
        'css'         => $css,
        'pst'         => $pst,
        'diskon'      => $diskon_array,
      ));

    $this->template
      ->set_layout('default')
      ->build($view);
	}
	
	function ajax_flight_get($maskapai='')
	{
		if($maskapai == 'QG')
		{
			$flight = array(
									array('img'=>'http://www.antavaya.com/themes/antavaya/maskapai/image/QG.jpg','flight'=>'QG001','departure'=>'08:00','arrive'=>'18:00','price'=>'1200000'),
									array('img'=>'http://www.antavaya.com/themes/antavaya/maskapai/image/QG.jpg','flight'=>'QG002','departure'=>'02:00','arrive'=>'12:00','price'=>'2200000'),
									array('img'=>'http://www.antavaya.com/themes/antavaya/maskapai/image/QG.jpg','flight'=>'QG003','departure'=>'05:00','arrive'=>'15:00','price'=>'1800000')
								);
		}elseif($maskapai == 'LI')
		{
			$flight = array(
									array('img'=>'http://www.antavaya.com/themes/antavaya/maskapai/image/JT.gif','flight'=>'LI001','departure'=>'01:00','arrive'=>'11:00','price'=>'3200000'),
									array('img'=>'http://www.antavaya.com/themes/antavaya/maskapai/image/JT.gif','flight'=>'LI002','departure'=>'03:00','arrive'=>'16:00','price'=>'1200000'),
									array('img'=>'http://www.antavaya.com/themes/antavaya/maskapai/image/JT.gif','flight'=>'LI003','departure'=>'05:00','arrive'=>'12:00','price'=>'3800000')
								);
		}
		
		$html = '';
		
		foreach($flight as $idx => $val)
		{
			// -- List Large --
			$html .= '<article id="flight_box" class="box flight_box">';
			$html .= '	<figure class="col-xs-3 col-sm-2">';
			$html .= '		<span><img alt="" src='.  $val['img'] .'></span>';
			$html .= '	</figure>';
			$html .= '	<div class="details col-xs-9 col-sm-10">';
			$html .= '		<div class="details-wrapper">';
			$html .= '			<div class="first-row">';
			$html .= '				<div class="time">';
			$html .= '					<div class="total-time col-sm-2">';
			$html .= '						<div class="icon"><i class="soap-icon-plane yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= 									$val['flight'];
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="landing col-sm-2">';
			$html .= '						<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= 									$val['departure'];
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="take-off col-sm-2">';
			$html .= '						<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= 									$val['arrive'];
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="take-off col-sm-2">';
			$html .= '						<div class="icon"><i class="soap-icon-businessbag yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="take-off col-sm-2">';
			$html .= '						<div class="icon"><i class="soap-icon-recommend yellow-color"></i></div>';
			$html .= '						<div class="price_val">';
			$html .= 									$val['price'];
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="take-off col-sm-2">';
			$html .= '						<div class="price_val">';
			$html .= '							<a href="flight-detailed.html" class="button btn-small full-width">SELECT NOW</a>';
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '				</div>';
			$html .= '			</div>';
			$html .= '		</div>';
			$html .= '	</div>';
			$html .= '</article>';
			
			$html .= '	<article id="flight_box_hidden" class="box flight_box_hidden">';
			$html .= '	<figure class="col-xs-3 col-sm-3">';
			$html .= '		<span><img alt="" src='.  $val['img'] .'></span>';
			$html .= '	</figure>';
			$html .= '	<div class="details col-xs-9 col-sm-9">';
			$html .= '		<div class="details-wrapper">';
			$html .= '			<div class="first-row">';
			$html .= '				<div class="time">';
			$html .= '					<div class="total-time col-sm-4">';
			$html .= '						<div class="icon"><i class="soap-icon-plane yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= '									<span class="skin-color">FLIGHT NO</span> </br> '.$val['flight'].'';
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="landing col-sm-4">';
			$html .= '						<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= '							<span class="skin-color">TAKE OFF</span> </br> '.  $val['departure'] .'';
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="take-off col-sm-4">';
			$html .= '						<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= '							<span class="skin-color">LANDING</span> </br> '.  $val['arrive'] .'';
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '				</div>';
			$html .= '			</div>';
			$html .= '		</div>';
			$html .= '	</div>';
			$html .= '	</article>';
			
			// -- List Medium --
			$html .= '<article id="flight_box_fake" class="box flight_box_fake" data-toggle="collapse" data-target="#'.$val['flight'].'_'.$idx.'" >';
			$html .= '		<figure class="col-xs-3 col-sm-2">';
			$html .= '				<span><img alt="" src='.  $val['img'] .'></span>';
			$html .= '		</figure>';
			$html .= '		<div class="details col-xs-9 col-sm-10">';
			$html .= '				<div class="details-wrapper">';
			$html .= '						<div class="first-row">';
			$html .= '								<div class="time">';
			$html .= '										<div class="take-off col-sm-4">';
			$html .= '												<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '												<div>';
			$html .= 																$val['departure'];
			$html .= '														<br />';
			$html .= '														<br />';
			$html .= '														<span class="skin-color" style="cursor: pointer;">Detail Information</span>';
			$html .= '												</div>';
			$html .= '										</div>';
			$html .= '										<div class="landing col-sm-3">';
			$html .= '												<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '												<div>';
			$html .= 																$val['arrive'];
			$html .= '												</div>';
			$html .= '										</div>';
			$html .= '										<div class="landing col-sm-3">';
			$html .= '												<div class="icon"><i class="soap-icon-recommend yellow-color"></i></div>';
			$html .= '												<div class="price_val">';
			$html .= 																$val['price'];
			$html .= '												</div>';
			$html .= '										</div>';
			$html .= '										<div class="col-sm-2">';
			$html .= '												<div class="price_val">';
			$html .= '										<a href="flight-detailed.html" class="button btn-small full-width">SELECT NOW</a>';
			$html .= '												</div>';
			$html .= '										</div>';
			$html .= '								</div>';
			$html .= '						</div>';
			$html .= '				</div>';
			$html .= '		</div>';
			$html .= '</article>';
			
			
			$html .= '<div id="'.$val['flight'].'_'.$idx.'" class="tab-container style1 collapse" style="background: #e2eff5; padding: 0px 10px 10px 10px; width: 100%;">';
			$html .= '	<ul class="tabs">';
			$html .= '			<li class="active"><a href="#tab-detail-flight_'.$idx.'" data-toggle="tab">Detail Penerbangan</a></li>';
			$html .= '			<li><a href="#tab-rinciang-pembayaran_'.$idx.'" data-toggle="tab">Rincian Harga</a></li>';
			$html .= '	</ul>';
			$html .= '	<div class="tab-content">';
			$html .= '			<div class="tab-pane fade in active" id="tab-detail-flight_'.$idx.'">';
			$html .= '					<div class="row">';
			$html .= '							<div class="col-xs-2">';
			$html .= '									<img class="full-width" src='.  $val['img'] .' alt="" width="63" height="63" />';
			$html .= '							</div>';
			$html .= '							<div class="col-xs-8">';
			$html .= '									<h5 class="box-title">Warwick Hotel<small>New york, usa</small></h5></br></br>';
			$html .= '									<p class="no-margin">Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar massa idporta nequetiam.</p>';
			$html .= '							</div>';
			$html .= '							<div class="col-xs-2">';
			$html .= '									<span class="price"><small>avg/night</small>$115</span>';
			$html .= '							</div>';
			$html .= '					</div>';
			$html .= '					<div class="row">';
			$html .= '							<div class="take-off col-xs-2">';
			$html .= '									<div class="icon"><i class="soap-icon-plane yellow-color"></i></div>';
			$html .= '									<span class="skin-color">FLIGHT NO</span> </br> GA 117';
			$html .= '							</div>';
			$html .= '							<div class="take-off col-xs-2">';
			$html .= '									<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '									<span class="skin-color">TAKE OFF</span> </br> 2017-01-10 18:10	';
			$html .= '							</div>';
			$html .= '							<div class="landing col-xs-2">';
			$html .= '									<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '									<span class="skin-color">LANDING</span> </br> 2017-01-10 19:20	';
			$html .= '							</div>';
			$html .= '					</div>';
			$html .= '			</div>';
			$html .= '			<div class="tab-pane fade" id="tab-rinciang-pembayaran_'.$idx.'">';
			$html .= '					<div class="row">';
			$html .= '							<div class="take-off col-xs-2">';
			$html .= '									<div class="icon"><i class="soap-icon-plane yellow-color"></i></div>';
			$html .= '									<span class="skin-color">FLIGHT NO</span> </br> GA 117';
			$html .= '							</div>';
			$html .= '							<div class="take-off col-xs-2">';
			$html .= '									<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '									<span class="skin-color">TAKE OFF</span> </br> 2017-01-10 18:10	';
			$html .= '							</div>';
			$html .= '							<div class="landing col-xs-2">';
			$html .= '									<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '									<span class="skin-color">LANDING</span> </br> 2017-01-10 19:20	';
			$html .= '							</div>';
			$html .= '					</div>';
			$html .= '			</div>';
			$html .= '	</div>';
			$html .= '</div>';
		}
		
		$result['data'] = $flight;
		$result['html'] = $html;
		print json_encode($result);
		die();
	}
	
	function ajax_flight_get_pp($maskapai='')
	{
		if($maskapai == 'QG')
		{
			$flight = array(
									array('img'=>'http://www.antavaya.com/themes/antavaya/maskapai/image/QG.jpg','flight'=>'QG001','departure'=>'08:00','arrive'=>'18:00','price'=>'1200000'),
									array('img'=>'http://www.antavaya.com/themes/antavaya/maskapai/image/QG.jpg','flight'=>'QG002','departure'=>'02:00','arrive'=>'12:00','price'=>'2200000'),
									array('img'=>'http://www.antavaya.com/themes/antavaya/maskapai/image/QG.jpg','flight'=>'QG003','departure'=>'05:00','arrive'=>'15:00','price'=>'1800000')
								);
		}elseif($maskapai == 'LI')
		{
			$flight = array(
									array('img'=>'http://www.antavaya.com/themes/antavaya/maskapai/image/JT.gif','flight'=>'LI001','departure'=>'01:00','arrive'=>'11:00','price'=>'3200000'),
									array('img'=>'http://www.antavaya.com/themes/antavaya/maskapai/image/JT.gif','flight'=>'LI002','departure'=>'03:00','arrive'=>'16:00','price'=>'1200000'),
									array('img'=>'http://www.antavaya.com/themes/antavaya/maskapai/image/JT.gif','flight'=>'LI003','departure'=>'05:00','arrive'=>'12:00','price'=>'3800000')
								);
		}
		
		$html = '';
		
		foreach($flight as $idx => $val)
		{
			// -- List Large --
			$html .= '<article id="flight_box_right" class="box flight_box_right">';
			$html .= '	<figure class="col-xs-3 col-sm-2">';
			$html .= '		<span><img alt="" src='.  $val['img'] .'></span>';
			$html .= '	</figure>';
			$html .= '	<div class="details col-xs-9 col-sm-10">';
			$html .= '		<div class="details-wrapper">';
			$html .= '			<div class="first-row">';
			$html .= '				<div class="time">';
			$html .= '					<div class="total-time col-sm-2">';
			$html .= '						<div class="icon"><i class="soap-icon-plane yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= 									$val['flight'];
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="landing col-sm-2">';
			$html .= '						<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= 									$val['departure'];
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="take-off col-sm-2">';
			$html .= '						<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= 									$val['arrive'];
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="take-off col-sm-2">';
			$html .= '						<div class="icon"><i class="soap-icon-businessbag yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="take-off col-sm-2">';
			$html .= '						<div class="icon"><i class="soap-icon-recommend yellow-color"></i></div>';
			$html .= '						<div class="price_val">';
			$html .= 									$val['price'];
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="take-off col-sm-2">';
			$html .= '						<div class="price_val">';
			$html .= '							<a href="flight-detailed.html" class="button btn-small full-width">SELECT NOW</a>';
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '				</div>';
			$html .= '			</div>';
			$html .= '		</div>';
			$html .= '	</div>';
			$html .= '</article>';
			
			$html .= '	<article id="flight_box_right_hidden" class="box flight_box_right_hidden">';
			$html .= '	<figure class="col-xs-3 col-sm-3">';
			$html .= '		<span><img alt="" src='.  $val['img'] .'></span>';
			$html .= '	</figure>';
			$html .= '	<div class="details col-xs-9 col-sm-9">';
			$html .= '		<div class="details-wrapper">';
			$html .= '			<div class="first-row">';
			$html .= '				<div class="time">';
			$html .= '					<div class="total-time col-sm-4">';
			$html .= '						<div class="icon"><i class="soap-icon-plane yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= '									<span class="skin-color">FLIGHT NO</span> </br> '.$val['flight'].'';
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="landing col-sm-4">';
			$html .= '						<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= '							<span class="skin-color">TAKE OFF</span> </br> '.  $val['departure'] .'';
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '					<div class="take-off col-sm-4">';
			$html .= '						<div class="icon"><i class="soap-icon-plane-right yellow-color"></i></div>';
			$html .= '						<div>';
			$html .= '							<span class="skin-color">LANDING</span> </br> '.  $val['arrive'] .'';
			$html .= '						</div>';
			$html .= '					</div>';
			$html .= '				</div>';
			$html .= '			</div>';
			$html .= '		</div>';
			$html .= '	</div>';
			$html .= '	</article>';
		}
		
		$result['data'] = $flight;
		$result['html'] = $html;
		print json_encode($result);
		die();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */