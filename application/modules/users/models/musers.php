<?php
class Musers extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function insert($kirim){
      $post = array(
        "name"            => $kirim['name'],
        "pass"            => $kirim['pass'],
        "email"           => $kirim['email'],
        "id_privilege"    => $kirim['id_privilege'],
        "status"          => $kirim['status'],
        "create_by_users" => $this->session->userdata("id"),
        "create_date"     => date("Y-m-d H:i:s"),
      );
      return $this->global_models->insert("m_users", $post);
    }
    
    function insert_user($kirim){
      $this->db->insert('m_users', $kirim);
      return $this->db->insert_id();
    }
    function update_user($id, $kirim){
      $this->db->where("id_users", $id);
      return $this->db->update("m_users", $kirim);
    }
    function get_detail($id){
      $this->db->where("id_users", $id);
      return $this->db->get("m_users")->row();
    }
    function change_status($id, $status){
      $this->db->where("id_users", $id);
      if($status == 1)
        $kirim['id_status_user'] = 2;
      else if($status == 2)
        $kirim['id_status_user'] = 1;
      else
        $kirim['id_status_user'] = $status;
      return $this->db->update("m_users", $kirim);
    }
    function get(){
      $this->db->select('m_users.*, m_privilege.name as privilege');
//      $this->db->join('m_status_user', 'm_status_user.id_status_user = m_users.id_status_user', 'left');
      $this->db->join('d_user_privilege', 'm_users.id_users = d_user_privilege.id_users', 'left');
      $this->db->join('m_privilege', 'd_user_privilege.id_privilege = m_privilege.id_privilege', 'left');
      $this->db->where("m_users.id_status_user <>", 3);
      $this->db->order_by("m_users.id_users", "DESC");
      $data = $this->db->get("m_users")->result();
      
      return $data;
    }
    function export_xls($filename){
      $objPHPExcel = $this->phpexcel;
      $objPHPExcel->getProperties()->setCreator("Mr Montir")
							 ->setLastModifiedBy("Mr Montir")
							 ->setTitle("Users Data")
							 ->setSubject("Users Data")
							 ->setDescription("Report users data.")
							 ->setKeywords("report users data")
							 ->setCategory("Users");

      $objPHPExcel->setActiveSheetIndex(0);
      
      $objPHPExcel->getActiveSheet()->mergeCells('A1:C2');
      $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Data Users');
      $objPHPExcel->getActiveSheet()->getStyle('A1:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
      $objPHPExcel->getActiveSheet()->getStyle('A1:C2')->getFill()->getStartColor()->setARGB('FF808080');
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
      $objPHPExcel->getActiveSheet()->setCellValue('A4', 'Name');
      $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Email');
      $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Status');
      $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->applyFromArray(
          array(
            'font'    => array(
              'bold'      => true
            ),
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
            'borders' => array(
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
            ),
            'fill' => array(
              'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation'   => 90,
              'startcolor' => array(
                'argb' => 'FFA0A0A0'
              ),
              'endcolor'   => array(
                'argb' => 'FFFFFFFF'
              )
            )
          )
      );
      
      $data = $this->get();
      if(is_array($data)){
        foreach ($data as $key => $value) {
          $objPHPExcel->getActiveSheet()->setCellValue('A'.(5+$key), $value->name);
          $objPHPExcel->getActiveSheet()->setCellValue('B'.(5+$key), $value->email);
          $objPHPExcel->getActiveSheet()->setCellValue('C'.(5+$key), $value->status);
        }
      }
      $objPHPExcel->getActiveSheet()->getStyle('A5:C'.(5+$key))->applyFromArray(
          array(
            'font'    => array(
              'bold'      => false
            ),
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
            'borders' => array(
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
            ),
            'fill' => array(
              'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation'   => 90,
              'startcolor' => array(
                'argb' => 'FFA0A0A0'
              ),
              'endcolor'   => array(
                'argb' => 'FFFFFFFF'
              )
            )
          )
      );
      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
//      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(30);
//      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(50);
//      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
      
      $objPHPExcel->setActiveSheetIndex(0);
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename."-".date("Y m d").'"');
      header('Cache-Control: max-age=0');
      $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
//$objWriter->save(str_replace('.php', '.xls', __FILE__));
      $objWriter->save('php://output');die;
    }
    
    function group_users_set($kirim){
      if($kirim['id_m_users_group']){
        $post = array(
          "title"             => $kirim['title'],
          "update_by_users"   => $this->session->userdata("id"),
        );
        $this->global_models->update("m_users_group", array("id_m_users_group" => $kirim['id_m_users_group']), $post);
        $id_m_users_group = $kirim['id_m_users_group'];
      }
      else{
        $this->global_models->generate_id($id_m_users_group, "m_users_group");
        $post = array(
          "id_m_users_group"  => $id_m_users_group,
          "title"             => $kirim['title'],
          "status"            => 1,
          "create_by_users"   => $this->session->userdata("id"),
          "create_date"       => date("Y-m-d H:i:s")
        );
        $this->global_models->insert("m_users_group", $post);
      }
      $hasil = array(
        "status"    => 2,
        "id"        => $id_m_users_group
      );
      return $hasil;
    }
    
    function group_approval_users_set($kirim){
      if($kirim['id_m_users_group_approval']){
        $post = array(
          "id_m_users_group"          => $kirim['id_m_users_group'],
          "id_users"                  => $kirim['id_users'],
          "update_by_users"           => $this->session->userdata("id"),
        );
        $this->global_models->update("m_users_group_approval", array("id_m_users_group_approval" => $kirim['id_m_users_group_approval']), $post);
        $id_m_users_group_approval = $kirim['id_m_users_group_approval'];
      }
      else{
        $this->global_models->generate_id($id_m_users_group_approval, "m_users_group_approval");
        $post = array(
          "id_m_users_group_approval" => $id_m_users_group_approval,
          "id_m_users_group"          => $kirim['id_m_users_group'],
          "id_users"                  => $kirim['id_users'],
          "create_by_users"           => $this->session->userdata("id"),
          "create_date"               => date("Y-m-d H:i:s")
        );
        $this->global_models->insert("m_users_group_approval", $post);
      }
      $hasil = array(
        "status"    => 2,
        "id"        => $id_m_users_group_approval
      );
      return $hasil;
    }
    
    function group_approval_users_delete($kirim){
      if($kirim['id_m_users_group_approval']){
        $this->global_models->delete("m_users_group_approval", array("id_m_users_group_approval" => $kirim['id_m_users_group_approval']));
      }
      $hasil = array(
        "status"    => 2,
        "id"        => $kirim['id_m_users_group_approval']
      );
      return $hasil;
    }
    
    function group_teams_users_delete($kirim){
      if($kirim['id_m_users_group_teams']){
        $this->global_models->delete("m_users_group_teams", array("id_m_users_group_teams" => $kirim['id_m_users_group_teams']));
      }
      $hasil = array(
        "status"    => 2,
        "id"        => $kirim['id_m_users_group_teams']
      );
      return $hasil;
    }
    
    function group_teams_users_set($kirim){
      if($kirim['id_m_users_group_teams']){
        $post = array(
          "id_m_users_group"          => $kirim['id_m_users_group'],
          "id_users"                  => $kirim['id_users'],
          "update_by_users"           => $this->session->userdata("id"),
        );
        $this->global_models->update("m_users_group_teams", array("id_m_users_group_teams" => $kirim['id_m_users_group_teams']), $post);
        $id_m_users_group_teams = $kirim['id_m_users_group_teams'];
      }
      else{
        $this->global_models->generate_id($id_m_users_group_teams, "m_users_group_teams");
        $post = array(
          "id_m_users_group_teams" => $id_m_users_group_teams,
          "id_m_users_group"       => $kirim['id_m_users_group'],
          "id_users"               => $kirim['id_users'],
          "create_by_users"        => $this->session->userdata("id"),
          "create_date"            => date("Y-m-d H:i:s")
        );
        $this->global_models->insert("m_users_group_teams", $post);
      }
      $hasil = array(
        "status"    => 2,
        "id"        => $id_m_users_group_teams
      );
      return $hasil;
    }
    
  function session_users_cek(){
    if($this->session->userdata("id") > 1 AND $this->session->userdata("id_cms") <= 1){
      $this->session->set_userdata(array(
        "id_cms"    => $this->session->userdata("id")
      ));
      $hasil = array(
        "status"  => 2
      );
    }
    else if($this->session->userdata("id_cms") > 1){
      $hasil = array(
        "status"  => 2
      );
    }
    else{
      redirect("users/users-settings/session-users");
    }
    return $hasil;
  }
  
  function session_group_cek(){
    if($this->session->userdata("id") > 1 AND !$this->session->userdata("code_users")){
      $group = $this->global_models->get_query("SELECT (SELECT B.code FROM m_users_group AS B WHERE B.id_m_users_group = A.id_m_users_group) AS code"
        . " FROM m_users_group_teams AS A"
        . " WHERE A.id_users = '{$this->session->userdata("id")}'");
      $this->session->set_userdata(array(
        "code_users"    => $group[0]->code
      ));
      $hasil = array(
        "status"  => 2
      );
    }
    else if($this->session->userdata("code_users")){
      $hasil = array(
        "status"  => 2
      );
    }
    else{
      redirect("users/users-settings/session-group");
    }
    return $hasil;
  }
  
  function group_info_get($id_users){
    $id_m_users_group = $this->global_models->get_field("m_users_group_teams", "id_m_users_group", array("id_users" => $id_users));
    $group_approval = $this->global_models->get("m_users_group_approval", array("id_m_users_group" => $id_m_users_group));
    foreach ($group_approval AS $ga){
      $approval[] = $ga->id_users;
    }
    if($id_m_users_group AND $group_approval){
      $hasil = array(
        "status"          => 2,
        "approval"        => $group_approval,
        "approval_array"  => $approval,
      );
    }
    else{
      $hasil = array(
        "status"          => 3
      );
    }
    return $hasil;
  }
  
  function group_info_member_get($id_users){
    $id_m_users_group = $this->global_models->get_field("m_users_group_approval", "id_m_users_group", array("id_users" => $id_users));
    $group_teams = $this->global_models->get("m_users_group_teams", array("id_m_users_group" => $id_m_users_group));
    foreach ($group_teams AS $ga){
      $teams[] = $ga->id_users;
    }
    if($id_m_users_group AND $group_teams){
      $hasil = array(
        "status"          => 2,
        "teams"           => $group_teams,
        "teams_array"     => $teams,
      );
    }
    else{
      $hasil = array(
        "status"          => 3
      );
    }
    return $hasil;
  }
  
}
?>
