<?php
require_once 'system/core/Model.php';
class Global_models extends CI_Model{
  function __construct(){
      parent::__construct();
      $this->load->database();
  }
  
  function generate_id(&$id, $table, $key = NULL){
    $this->load->helper('string');
    $num = rand(5,20);
    $kode_data = random_string('alnum', $num);
    if($key !== NULL){
      $kode_data = substr_replace($kode_data, $key, 0, (($num - 1)*-1));
    }
    $id = strtoupper($kode_data);
    $cek = $this->get_field($table, "id_{$table}", array("id_{$table}" => $id));
    if($cek){
      $this->generate_id($id, $table, $key);
    }
  }
  
  private function nol_null(&$kirim){
//    $key = array_search("0", $kirim); // $key = 2;
//    if($key OR $key2){
//      $kirim[$key] = NULL;
//      $this->nol_null($kirim);
//    }
    return true;
  }
  function get_connect($database){
     $this->db = $this->load->database($database, false, true);
  }
  function insert($table, $kirim){
    $this->nol_null($kirim);
    $this->db->insert($table, $kirim);
    if($this->db->insert_id())
      return $this->db->insert_id();
    else
      return $kirim["id_{$table}"];
  }
  function insert_batch($table, $kirim){
    $this->db->insert_batch($table, $kirim);
    return 1;
  }
  function update_duplicate($table, $kirim, $else){
    $no = 0;
    foreach($kirim as $key => $krm){
      if($no > 0){
        $field .= ", ";
        $value .= ", ";
      }
      $field .= "`$key`";
      if($krm > 0 OR $krm)
        $value .= "'$krm'";
      else
        $value .= "NULL";
      $no++;
    }
    $no = 0;
    foreach($else as $ky => $el){
      $le= "";
      if($el > 0 OR $el)
        $le .= "'$el'";
      else
        $le .= "NULL";
      if($no > 0)
        $update .= ",";
      $update .= "`$ky` = $le";
      $no++;
    }
    $query = "
      INSERT INTO {$table} ({$field}) VALUES({$value}) ON DUPLICATE KEY UPDATE {$update};
      ";
//      print $query;die;
    $this->db->query($query);
    return $this->db->insert_id();
  }
  function delete($table, $where, $id_table = ""){
    $this->db->delete($table, $where);
    if($id_table){
      $data = $this->get_field($table, "max({$id_table})") + 1;
      $this->query("ALTER TABLE  {$table} AUTO_INCREMENT = {$data}");
    }
    return true;
  }
  function update($table, $where, $kirim){
    $this->nol_null($kirim);
    $this->db->where($where);
    return $this->db->update($table, $kirim);
  }
  function get_field($table, $field, $where = array()){
    $this->db->select($field." as a");
    if($where)
      $this->db->where($where);
    $w = $this->db->get($table)->row();
    if($w)
      return $w->a;
    else
      return false;
  }
  function get_dropdown($table, $key, $name, $pilih = TRUE, $where = array(), $field_not = "nbs", $not_in = array(), $tambahan = ""){
    if($pilih === TRUE)
      $data[0] = "- Pilih -";
    $rec = $this->get($table, $where, $field_not, $not_in);
    if(is_array($rec)){
      foreach ($rec as $value) {
        $data[$value->$key] = $value->$name;
        if($tambahan)
          $data[$value->$key] .= " - ".$value->$tambahan;
      }
    }
    return $data;
  }
  function get_dropdown_sort($table, $key, $name, $sort, $type, $where = "1=1", $pilih = TRUE){
    if($pilih === TRUE)
      $data[0] = "- Pilih -";
    
    $rec = $this->get_query("SELECT {$key}, {$name}"
    . " FROM {$table}"
    . " WHERE {$where}"
    . " ORDER BY {$sort} {$type}");
    if(is_array($rec)){
      foreach ($rec as $value) {
        $data[$value->$key] = $value->$name;
      }
    }
    return $data;
  }
  function get_query($query){
    return $this->db->query($query)->result();
  }
  function get($table, $where = array(), $field_not = "nbs", $not_in = array(), $select = "*", $limit = NULL, $start = NULL){
    if($field_not != "nbs" AND $not_in)
      $this->db->where_not_in($field_not, $not_in);
    if($where)
      $this->db->where($where);
    $this->db->select($select);
    $data = $this->db->get($table, $limit, $start)->result();
    if(is_array($data))
      return $data;
    else
      return array();
  }
  function get_array($field, $table, $where = array(), $field_not = "nbs", $not_in = array()){
    $temp = $this->get($table, $where, $field_not, $not_in);
    $return = array();
    if(is_array($temp)){
      foreach ($temp as $key => $value) {
        $return[] = $value->$field;
      }
    }
    return $return;
  }
  function get_user_outlet($id_outlet, $privilege){
    $query = "
      SELECT A.*
      FROM m_users AS A
      JOIN d_user_privilege AS B ON A.id_users = B.id_users
      JOIN m_privilege AS C ON B.id_privilege = C.id_privilege
      JOIN d_outlet_users AS D ON A.id_users = D.id_users AND D.id_outlet = {$id_outlet}
      WHERE C.name = '{$privilege}'
      ";
    return $this->get_query($query);
  }
  function get_outlet_user($id_users){
    $query = "
      SELECT A.*
      FROM m_outlet AS A
      JOIN d_outlet_users AS B ON A.id_outlet = B.id_outlet AND B.id_users = {$id_users}
      ";
    return $this->get_query($query);
  }
  function truncate($table = ''){
    return $this->db->truncate($table);
  }
  function ambildah(){
    return get_class_methods('Users');
  }
  function query($query){
    return $this->db->query($query);
  }
  function nicename($string, $table, $id){
    $string = str_replace(":", "", $string);
    $string = str_replace("/", "", $string);
    $string = str_replace("(", "", $string);
    $string = str_replace(")", "", $string);
    $hasil = urlencode(strtolower(str_replace(" ", "_", str_replace("-", "_", $string))));
    $cek = $this->get($table, array($id => $hasil));
    if($cek)
      $hasil .= rand(100, 9999);
    
    return $hasil;
  }
  function ganerate_so(){
    return rand();
  }
  function cek_po($id_po){
    $items = $this->get("d_po_items", array("id_po" => $id_po, "status > " => 0));
    $cek = "sudah";
    foreach($items as $inti){
      $qty = $this->get_field("d_rg_items", "sum(qty)", array("id_po_items" => $inti->id_po_items));
      $selisih = 0;
      if($qty){
        if($qty < $inti->qty){
          $cek = "belum";
          $selisih = $inti->qty - $qty;
        }
      }
      else{
        $cek = "belum";
        $selisih = $inti->qty;
      }
      $kekurangan[$inti->id_po_items] = $selisih;
    }
    if($cek == "sudah")
//      return $kekurangan;
      return "nbs";
    else
      return $kekurangan;
  }
  function cek_so($id_so){
    $items = $this->get("d_so_items", array("id_so" => $id_so, "status > " => 0));
    $cek = "sudah";
    foreach($items as $inti){
      $qty = $this->get_field("d_dn_items", "sum(qty)", array("id_so_items" => $inti->id_so_items));
      $selisih = 0;
      if($qty){
        if($qty < $inti->qty){
          $cek = "belum";
          $selisih = $inti->qty - $qty;
        }
      }
      else{
        $cek = "belum";
        $selisih = $inti->qty;
      }
      $kekurangan[$inti->id_so_items] = $selisih;
    }
    if($cek == "sudah")
//      return $kekurangan;
      return "nbs";
    else
      return $kekurangan;
  }
  function selisih_hari($start_date, $end_date){
    $startDate = strtotime($start_date);
    $endDate = strtotime($end_date);

    $interval = $endDate - $startDate;
    $days = ($interval / (60 * 60 * 24));
    return $days;
  }
  function get_month_array(){
    return array(
        1  => 'Januari',
        2  => 'Februari',
        3  => 'Maret',
        4  => 'April',
        5  => 'Mei',
        6  => 'Juni',
        7  => 'Juli',
        8  => 'Agustus',
        9  => 'September',
        10 => 'Oktober',
        11 => 'Nopember',
        12 => 'Desember',
    );
  }
  function sign_keuangan($sk, $y, $m, $type, $grand_total){
    $id_close_ab = $this->get("d_close_ab", array("akun" => $sk, "year" => $y, "month" => $m, "type" => $type));
    $pos = array(
        "pendapatan"          => 2,
        "beban_hpp"           => 1,
        "hutang_po"           => 2,
        "hutang_po_produksi"  => 2,
        "persediaan_product"  => 1,
        "prepaid_income"      => 2,
        "prepaid_inventory"   => 1,
        "hutang_affiliate"    => 2,
        "beban_affiliate"     => 1,
        "beban_kas"           => 1,
        "kas"                 => 1,
        "modal"               => 2,
        "piutang"             => 1,
    );
    if($id_close_ab[0]->id_close_ab > 0){
      $this->query("
        UPDATE d_close_ab
        SET price	= price + {$grand_total}, update_by_users = {$this->session->userdata("id")}
        WHERE id_close_ab = {$id_close_ab[0]->id_close_ab}
        ");
    }
    else{
      $kirim_close = array(
          "akun"            => $sk,
          "pos"             => $pos[$sk],
          "price"           => $grand_total,
          "year"            => $y,
          "month"           => $m,
          "type"            => $type,
          "create_by_users" => $this->session->userdata("id"),
          "create_date"     => date("Y-m-d")
      );
      $this->insert("d_close_ab", $kirim_close);
    }
  }
  function get_field_query($query,$field,$key,$pih){
    $data =  $this->db->query($query)->result();
    if($pih == ""){
     $return[0] = "- Pilih -";
    }
  
    if(is_array($data)){
      foreach ($data as $value) {
          $return[$value->$key] = $value->$field;
      }
    }
    return $return;
  }
  
  function string_to_number($string){
    $satu = explode(" ", $string);
    if($satu[1]){
      $dua = str_replace(".", "", $satu[1]);
    }
    else{
      $dua = str_replace(".", "", $satu[0]);
    }
    if(trim($dua) == "Rp")
      $dua = 0;
    return $dua;
  }
  
  function string_to_number_array($array){
    foreach ($array AS $k => $v){
      $array_hasil[$k] = $this->string_to_number($v);
    }
    return $array_hasil;
  }
  
  function trans_begin(){
    return $this->db->trans_begin();
  }
  
  function trans_status(){
    return $this->db->trans_status();
  }
  
  function trans_rollback(){
    return $this->db->trans_rollback();
  }
  
  function trans_commit(){
    $this->db->trans_commit();
  }
  
  function set_variable($code, $isi){
    $code_cek = $this->get_field("variable", "code", array("code" => $code));
    if($code_cek){
      $this->update("variable", array("code" => $code), array("isi" => $isi));
    }
    else{
      $this->insert("variable", array("code" => $code, "isi" => $isi));
    }
    return true;
  }
  
  function get_variable($code){
    $isi = $this->get_field("variable", "isi", array("code" => $code));
    return $isi;
  }
  
  function del_variable($code){
    $isi = $this->delete("variable", array("code" => $code));
    return true;
  }
  
  function informasi_promo(){
    $promo_terakhir = $this->get_query("SELECT A.*, B.title AS company"
      . " FROM portal_promo AS A"
      . " LEFT JOIN portal_company AS B ON A.id_portal_company = B.id_portal_company"
      . " WHERE A.status = 4 AND ('".date("Y-m-d")."' BETWEEN A.start_date AND A.end_date)"
      . " ORDER BY A.end_date DESC");
    for($p = 0 ; $p < 3 ; $p++){
      if($promo_terakhir[$p]->id_portal_promo){
        $hasil[] = array(
          "title"           => $promo_terakhir[$p]->title,
          "company"         => $promo_terakhir[$p]->company,
          "end_date"        => $promo_terakhir[$p]->end_date,
          "link"            => $promo_terakhir[$p]->link,
        );
      }
      else{
        $hasil[] = array(
          "title"           => "Tersedia",
          "company"         => "-",
          "end_date"        => date("Y-m-d"),
          "link"            => "portal/client-portal/add-promo",
        );
      }
    }
    return $hasil;
  }
  
  function alamat_contact_us($style = ""){
    if($style == 'leisure'){
      $html = "<div class='travelo-box contact-box'>"
        . "<h4 class='box-title'>Contact Us</h4>"
        . "<p>AntaVaya Hayam Wuruk,<br />Jl. Hayam Wuruk No. 88,"
        . "<br />Jakarta 11160, Indonesia </p>"
        . "<address class='contact-details'>"
        . "<span class='contact-phone' style='font-size: 14px'><i class='soap-icon-phone'></i> +6221 625 3919 </span>"
        . "<br />"
        . "<a href='mailto:tour@antavaya.com' target='_blank' style='font-size: 14px' >tour@antavaya.com</a>"
        . "</address>"
        . "</div>";
    }
    else if($style == 'destination'){
      $html = "<div class='travelo-box contact-box'>"
        . "<h4 class='box-title'>Contact Us</h4>"
        . "<p>AntaVaya Destination,<br />Jl. Bypass Ngurah Rai 143,"
        . "<br />Sanur 80228, Bali </p>"
        . "<address class='contact-details'>"
        . "<span class='contact-phone' style='font-size: 14px'><i class='soap-icon-phone'></i> +62361 300 9736 </span>"
        . "<br />"
        . "<a href='mailto:indonesia@antavaya.com' target='_blank' style='font-size: 14px' >indonesia@antavaya.com</a>"
        . "</address>"
        . "</div>";
    }
    else if($style == 'conference'){
      $html = "<div class='travelo-box contact-box'>"
        . "<h4 class='box-title'>Contact Us</h4>"
        . "<p>AntaVaya Hayam Wuruk,<br />Jl. Hayam Wuruk No. 88,"
        . "<br />Jakarta 11160, Indonesia </p>"
        . "<address class='contact-details'>"
        . "<span class='contact-phone' style='font-size: 14px'><i class='soap-icon-phone'></i> +6221 625 0478; "
        . "<br />+6221 6230 8288; "
        . "<br />+6221 6230 8282 </span>"
        . "<span class='contact-phone' style='font-size: 14px'></i> <br />Fax : +6221 625 0478 </span>"
        . "<br />"
        . "<a href='mailto:info@antavaya-convex.com' target='_blank' style='font-size: 14px' >info@antavaya-convex.com</a>"
        . "</address>"
        . "</div>";
    }
    else if($style == 'haji'){
      $html = "<div class='travelo-box contact-box'>"
        . "<h4 class='box-title'>Contact Us</h4>"
        . "<p>Jl. Melawai Raya No. 116 B"
        . "<br />Jakarta 12160 Indonesia</p>"
        . "<address class='contact-details'>"
        . "<span class='contact-phone' style='font-size: 14px'><i class='soap-icon-phone'></i> +62 21 7278 7935</span>"
        . "<br />"
        . "<a href='mailto:marketing@antavaya.com' target='_blank' style='font-size: 14px' >marketing@antavaya.com</a>"
        . "</address>"
        . "</div>";
    }
    else{
      $html = "<div class='travelo-box contact-box'>"
        . "<h4 class='box-title'>Contact Us</h4>"
        . "<p>AntaVaya Buliding,<br />Jl. Batutulis Raya No. 38,"
        . "<br />Jakarta 10120 Indonesia </p>"
        . "<address class='contact-details'>"
        . "<span class='contact-phone' style='font-size: 14px'><i class='soap-icon-phone'></i> +6221 2922 7999 </span>"
        . "<br />"
        . "<a href='mailto:customercare@antavaya.com' target='_blank' style='font-size: 14px' >customercare@antavaya.com</a>"
        . "</address>"
        . "</div>";
    }
    return $html;
  }
  
  function email_conf(){
      $config = Array(
         'useragent' => 'Hendri',
         'protocol' => 'smtp',
         'smtp_host' => '192.168.55.218',
//        'mailpath' => '/usr/sbin/sendmail',
         'smtp_port' => 25,
//        'smtp_crypto' => 'tls',
         'smtp_timeout' => 30,
         'mailtype'  => 'html',
         'smtp_user' => '@antavaya.com',
         'smtp_pass' => '',
     );
     return $config;
   }
  
  function array_kota($kode = ""){
    $hasil = array(
        'AMQ' => "Ambon(AMQ)",'ARD' => "Alor(ARD)",'AGD' => "Anggi(AGD)",'ARJ' => "Arso(ARJ)", 'ABU' => "Atambua(ABU)",
        'BXB'=>"Babo(BXB)",'DPS' => "Denpasar-Bali(DPS)",'BPN' => "Balikpapan(BPN)",'BTJ'=>"Banda Aceh(BTJ)",'TKG'=>"Bandar Lampung(TKG)",
        'BDO'=>"Bandung(BDO)",'DMK'=>"Bangkok(DMK)",'BDJ'=>"Banjarmasin(BDJ)",'BTH'=>"Batam(BTH)",'BJW'=>"Bajawa(BJW)",'BUW'=>"Bau-bau(BUW)",'WUB'=>"Buli(WUB)",
        'BKS'=>"Bengkulu(BKS)",'BEJ'=>"Berau(BEJ)",'BIK'=>"Biak(BIK)",'BMU'=>"Bima(BMU)",'NTI'=>"Bintuni(NTI)",
        'UOL'=>"Buol(UOL)",'DQJ'=>"Banyuwangi(DQJ)",
        'CBN'=>"Cirebon(CBN)",'CXP'=>"Cilacap(CXP)",'CGK'=>"Cengkareng(CGK)", 'NSW'=>"Ciamis(NSW)",
        'SQI'=>"Dabo Singkep(SQI)", 'DJB'=>"Djambi(DJB)", 'DJJ'=>"Djayapura(DJJ)", 'DIL'=>"Dili(DIL)",
        'EWI'=>"Enarotali(EWI)",'ENE'=>"Ende(ENE)",
        'FKQ'=>"Fakfak(FKQ)",
        'GLX'=>"Galela(GLX)",'GBE'=>"Gebe(GBE)",'GTO'=>"Gorontalo(GTO)",'GNS'=>"Gunung Sitoli(GNS)",
        'HLP'=>"Halim(HLP)",'HDY'=>"Hat Yai(HDY)",'SGN'=>"Ho Chi Minh City(SGN)",
        'INX'=>"Inanwatan(INX)",
        'CGK'=>"Jakarta(CGK)",'HLP'=>"Jakarta(HalimPerdanaKusuma)(HLP)","DJB" => "Jambi(DJB)","Jayapura(DJJ)","JOG"=>"Jogjakarta(JOG)","JohorBaru(JHB)",
        'KNG'=>"Kaimana(KNG)","KWB"=>"Karimunjawa(KWB)",'KDI'=>"Kendari(KDI)",'KRC'=>"Kerinci(KRC)",
        'KTG'=>"Ketapang(KTG)",'KUL'=>"Kualalumpur(KUL)",'KOE'=>"Kupang(KOE)",'KBX'=>"Kambuaya(KBX)", 'KEQ'=>"Kebar(KEQ)", 'KEI'=>"Kepi(KEI)", 'KMM'=>"Kiman(KMM)", 'KBU'=>"Kotabaru(KBU)",
        'LBJ'=>"Labuhan Bajo(LBJ)",'LKA'=>"Larantuka(LKA)",'LOW'=>"Lewoleba(LOW)",'LLG'=>"Lubuklinggau(LLG)",'LUW'=>"Luwuk(LUW)",
        'LHE'=>"Lahore(LHE)",'TKG'=>"Lampung(TKG)",'LUV'=>"Langgur(LUV)", 'LGK'=>"Langkawi(LGK)",'LCA'=>"Larnaca(LCA)", 'LHI'=>"Lereh(LHI)",
        'LSW'=>"Lhokseumawe(LSW)",'LOP'=>"Lombok(LOP)", 'LYK'=>"Luyuk(LYK)",
        'MLG'=>"Malang(MLG)",'UPG'=>"Makasar(UPG)",'MJU'=>"Mamuju(MJU)","MDC" => "Manado(MDC)",'MKW'=>"Manokwari(MKW)",'MXB'=>"Masamba(MXB)",
        'AMI'=>"Mataram(AMI)",'MKZ'=>"Malaka(MKZ)",
        'MOF'=>"Maumere(MOF)",'KNO'=>"Medan(KNO)",'MNA'=>"Melonguane(MNA)",'MKQ'=>"Merauke(MKQ)",'MAL'=>"Mangole(MAL)", 'OTI'=>"Morotai(OTI)",'MWK'=>"Matak(MWK)",
        'NTX'=>"Natuna(NTX)",'NNX'=>"Nunukan(NNX)",'NBX'=>"Nabire(NBX)",'NAM'=>"Namlea(NAM)",'NRE'=>"Namrole(NRE)","Numfor Timur",'GNS'=>"Nias(GNS)",
        'OKQ'=>"Okaba(OKQ)", 'OKL'=>"Oksibil(OKL)",
        "PDG"=>"Padang(PDG)",'PKY'=>"Palangka Raya(PKY)",'PLW'=>"Palu(PLW)",'PKN'=>"Pangkalan Bun(PKN)",'PGK'=>"Pangkalpinang(PGK)",'PLM'=>"Palembang(PLM)",
        'PKU'=>"Pekanbaru(PKU)",'PEN'=>"Penang(PEN)",'FLZ'=>"Pinangsori(FLZ)",
        'PUM'=>"Pomalaa(PUM)",'PNK'=>"Pontianak(PNK)",'PSJ'=>"Poso(PSJ)", 'NSW'=>"Pangandaran(NSW)",'DJJ'=>"Papua(DJJ)",'PWL'=>"Purwokerto(PWL)",
        'RAQ'=>"Raha(RAQ)",'RTI'=>"Rote(RTI)",'RTG'=>"Ruteng(RTG)",'RGT'=>"Rengat(RGT)",
        'SRI'=>"Samarinda(SRI)",'SMQ'=>"Sampit(SMQ)",'SQN'=>"Sanana(SQN)",'ZRM'=>"Sarmi(ZRM)",'SXK'=>"Saumlaki(SXK)",'SRG'=>"Semarang(SRG)",'ZRI'=>"Serui(ZRI)",
        'AEG'=>"Sibolga(AEG)",'DTB'=>"Silangit(DTB)",'SIN'=>"Singapore(SIN)",'SIQ'=>"Singkep(SIQ)",'SOC'=>"Solo(SOC)",'SOQ'=>"Sorong(SOQ)",'SWQ'=>"Sumbawa(SWQ)",'SUB'=>"Surabaya(SUB)",
        'SAU'=>"Sawu(SAU)",'NKD'=>"Sinak(NKD)",
        'NAH'=>"Tahuna(NAH)",'TAX'=>"Taliabu(TAX)",'TMH'=>"Tanah Merah(TMH)",'TJQ'=>"Tanjung Pandan(TJQ)",'TNJ'=>"Tanjung Pinang(TNJ)",
        'TKG'=>"Tanjung Karang(TKG)", 'TWU'=>"Tawau(TWU)",
        'TRK'=>"Tarakan(TRK)",'TTE'=>"Ternate(TTE)",'KAZ'=>"Tobelo(KAZ)",'TLI'=>"Tolitoli(TLI)",'TMC'=>"Tambolaka(TMC)", 'TMC'=>"Tambulaka(TMC)",
        'TIM'=>"Timika(TIM)", 'LUV'=>"Tual(LUV)", 'TMY'=>"Tiom(TMY)", 'TBH'=>"Tembilahan(TBH)",
        'UPG'=>"Ujungpandang(UPG)", 'WMX'=>"Wamena(WMX)",'WGI'=>"Wangi-wangi(WGI)",'WGP'=>"Waingapu(WGP)",'WNI'=>"Wakatobi(WNI)",'WSR'=>"Wasior(WSR)",
        "JOG"=>"Yogyakarta(JOG)"
      );
    if($kode)
      return $hasil[$kode];
    else
      return $hasil;
  }
  
  function diskon($code, $price, $total = 1){
    $diskon = $this->get_query("SELECT nilai, type"
      . " FROM tiket_discount_maskapai"
      . " WHERE ('".date("Y-m-d")."' BETWEEN mulai AND akhir) AND status = 1 AND maskapai = '{$code}'");
//    $disk = array(
//      "SJ"    => 0.02,
//      "JT"    => 0.01,
//      "QG"    => 0.01,
//      "QZ"    => 0,
//      "AK"    => 0,
//      "GA"    => 0.01
//    );
    if($price > 0){
      if($diskon[0]->type == 1){
        $hasil = ceil($diskon[0]->nilai/100 * $price);
      }
      else{
        $hasil = $diskon[0]->nilai * $total;
      }
    }
    else{
      $hasil = 0;
    }
    return $hasil;
  }
  
  function format_angka_atas($nilai, $koma = 0, $pemisah = ",", $jarak = "."){
    $hasil = number_format($nilai, 0, ",", ".");
//    $harga_array = explode(".", $harga);
//    $hasil = "";
//    foreach ($harga_array AS $j => $ha){
//      if($j == (count($harga_array)-1)){
//        $hasil .= "<sup>{$ha}<sup>";
//      }
//      else{
//        $hasil .= $ha.",";
//      }
//    }
    return $hasil;
  }
  
  function generate_code(&$kode, $table, $num){
    $this->load->helper('string');
    $kode_data = random_string('alnum', $num);
    $kode = strtoupper($kode_data);
    $cek = $this->get_field($table, "id_{$table}", array("code" => $kode));
    if($cek > 0){
      $this->generate_code($kode, $table);
    }
  }
	
	/**
   * @author Andi Wibowo
	 * @param $table : nama tabel
	 * @param $field : nama field yg di global_variable
	 * @param $tanggal_field : nama field tanggal
	 * @param $tanggal : value field tanggal
   * @abstract fungsi membuat nomor otomatis
   * @abstract format berada di global_variable->hrmd_development_format()
   */
	function generate_nomor_format($table='', $field='', $tanggal_field = '', $tanggal = '', $urut = 'urut'){
    # Get Format
		$this->load->library('global_variable');
    $format = $this->global_variable->nomor_format();
		
		
		# ---- Compare tanggal sekarang atau tidak -----
		if($format[$field]['reset'] == 0){ // Reset per hari / bulan / minggu / tahun
			$date_format = "%Y-%m-%d";
		}elseif($format[$field]['reset'] == 1){
			$date_format = "%Y-%m-%d";
		}elseif($format[$field]['reset'] == 2){
			$date_format = "%Y-%m";
		}elseif($format[$field]['reset'] == 3){
			$date_format = "%Y";
		}	
		
		# ------------ GET DATA LAST -----------
		$result = $this->global_models->get_query("SELECT A.*, MAX(A.{$urut}) MAX"
      . " FROM ".$table." AS A"
      . " WHERE DATE_FORMAT(".$tanggal_field.",'".$date_format."') = DATE_FORMAT('".$tanggal."','".$date_format."')");
		
		if(empty($result[0]->MAX)){
			$next = '' + 1;
		}else{
			$next = $result[0]->MAX + 1; // ambil database
		}
		
		#tambah 0 di sebelah kiri agar menjadi 4 digit
		$no = str_pad($next, $format[$field]['no'], "0", STR_PAD_LEFT);

		# --- Formated Here ----
		$year = str_replace("[yy]", date("Y", strtotime($tanggal)), $format[$field]['code']);
		$month = str_replace("[mm]", date("m", strtotime($tanggal)), $year);
		$day = str_replace("[dd]", date("d", strtotime($tanggal)), $month);
		$nomor = str_replace("[#####]", $no, $day);
		# ----------------------
		
		$data['nomor'] = $nomor;
		$data['urut'] = $next;

		return $data;
	}
  
   
  
}
?>
