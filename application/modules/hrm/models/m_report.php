<?php
class M_report extends CI_Model {

  function __construct(){
      parent::__construct();
      $this->load->library('PHPExcel');
  }
  
  function data_absen($id){
       $data = $this->global_models->get_query("SELECT A.*,MONTH(A.last_date)AS bulan,YEAR(A.last_date)AS tahun,"
      . "B.name,B.category,B.unit,B.no,B.npwp"
      . " FROM site_transport_komisi_partner AS A"
      . " LEFT JOIN site_transport_partner AS B ON A.id_site_transport_partner = B.id_site_transport_partner"
      . " WHERE A.id_site_transport_komisi='{$id}' "         
      . " ORDER BY B.name ASC"
      . "");
      
        return $data;
  }
  
function export_komisi($id){
    $get = $this->global_models->get("site_transport_komisi",array("id_site_transport_komisi" => "{$id}"));
    $bln =$this->global_variable->bulan();  
    $filename = "Absen-Crew-".$bln[$get[0]->bulan].$get[0]->tahun;
    $objPHPExcel = $this->phpexcel;
      $objPHPExcel->getProperties()->setCreator("AntaVaya")
							 ->setLastModifiedBy("AntaVaya Transport")
							 ->setTitle("Data Absen Crew")
							 ->setSubject("Data Absen Crew")
							 ->setDescription("Absen Crew")
							 ->setKeywords("Absen Crew")
							 ->setCategory("Absen Crew");
      
     
      $objPHPExcel->setActiveSheetIndex(0);
      $objPHPExcel->getActiveSheet()->mergeCells('A1:S1');
      $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Data Absen Crew');
      $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
      $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
     
      $objPHPExcel->getActiveSheet()->getStyle("A1:S1")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->mergeCells('A2:S2');
      $objPHPExcel->getActiveSheet()->setCellValue('A2', $bln[$get[0]->bulan]." ".$get[0]->tahun);
      $objPHPExcel->getActiveSheet()->getStyle('A2:S2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
      $objPHPExcel->getActiveSheet()->getStyle('A2:S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle('A2:S2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle("A2:S2")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->setCellValue('A3', 'NO');
      $objPHPExcel->getActiveSheet()->getStyle("A3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Type Bus');
      $objPHPExcel->getActiveSheet()->getStyle("B3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Driver');
      $objPHPExcel->getActiveSheet()->getStyle("C3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      
      $objPHPExcel->getActiveSheet()->setCellValue('D3', 'NIK');
      $objPHPExcel->getActiveSheet()->getStyle("D3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
    $objPHPExcel->getActiveSheet()->setCellValue('E3', 'NPWP');
      $objPHPExcel->getActiveSheet()->getStyle("E3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->setCellValue('F3', 'J');
      $objPHPExcel->getActiveSheet()->getStyle("F3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->setCellValue('G3', 'M');
      $objPHPExcel->getActiveSheet()->getStyle("G3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->setCellValue('H3', 'O');
      $objPHPExcel->getActiveSheet()->getStyle("H3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->setCellValue('I3', "Hari\nKerja");
      $objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setWrapText(true);
      $objPHPExcel->getActiveSheet()->getStyle("I3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->setCellValue('J3', "Uang\nPengganti\nTransport");
      $objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setWrapText(true);
      $objPHPExcel->getActiveSheet()->getStyle("J3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->setCellValue('K3', "Biaya\nRetensi");
      $objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setWrapText(true);
      $objPHPExcel->getActiveSheet()->getStyle("K3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->setCellValue('L3', 'Premi');
      $objPHPExcel->getActiveSheet()->getStyle("L3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->setCellValue('M3', "BPJS\nKesehatan");
      $objPHPExcel->getActiveSheet()->getStyle('M3')->getAlignment()->setWrapText(true);
      $objPHPExcel->getActiveSheet()->getStyle("M3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
     $objPHPExcel->getActiveSheet()->setCellValue('N3', "Total\nRetensi + \nBPJS Kes");
     $objPHPExcel->getActiveSheet()->getStyle('N3')->getAlignment()->setWrapText(true);
      $objPHPExcel->getActiveSheet()->getStyle("N3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $objPHPExcel->getActiveSheet()->setCellValue('O3', "Total\nPendapatan");
      $objPHPExcel->getActiveSheet()->getStyle('O3')->getAlignment()->setWrapText(true);
      $objPHPExcel->getActiveSheet()->getStyle("O3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
       $objPHPExcel->getActiveSheet()->setCellValue('P3', 'Gross');
      $objPHPExcel->getActiveSheet()->getStyle("P3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
       $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'Pajak');
      $objPHPExcel->getActiveSheet()->getStyle("Q3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
       $objPHPExcel->getActiveSheet()->setCellValue('R3', 'Denda');
      $objPHPExcel->getActiveSheet()->getStyle("R3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
       $objPHPExcel->getActiveSheet()->setCellValue('S3', 'Total PPH');
      $objPHPExcel->getActiveSheet()->getStyle("S3")->applyFromArray(
          array(
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_DOUBLE
              ),
            ),
          )
      );
      
      $data = $this->data_absen($id);
      
//      print_r($data);
//      die;
////     print $this->db->last_query();
////     die;
////        $lvl = array(1 => "Direktorat",2 => "Divisi",3 => "Department",4 => "Section");
//        $no = $qty = $jumlah = 0;
//        $angka = 6;
        $no=0;
        $total_retensi = 0;
        $total_uang_pengganti_transport = 0;
        $total_biaya_premi = 0;
        $total_bpjs_kesehatan = 0;
        $all_total_pendapatan = 0;
        $total_gross = 0;
        $total_pajak = 0;
        $total_denda = 0;
        $all_total_pph = 0;
        foreach ($data as $key => $da) {
            $no = $no+1;
             $unit = $this->global_variable->site_transport_bus_unit();
             
             $awal = "{$da->tahun}-{$da->bulan}-01";
        $dcogs = array(1 => "COGS Driver",
              2 => "COGS Helper");
        $vc = $this->global_models->get_query("SELECT SUM(D.nominal) AS total"
              . " FROM site_transport_spj AS A "
              . " LEFT JOIN site_transport_spj_cogs AS B ON A.id_site_transport_spj= B.id_site_transport_spj"
              . " LEFT JOIN site_transport_spj_close AS C ON A.id_site_transport_spj = C.id_site_transport_spj"
              . " LEFT JOIN site_transport_spj_partner AS D ON D.id_site_transport_spj = A.id_site_transport_spj"
              . " LEFT JOIN site_transport_partner AS E ON D.id_site_transport_partner = E.id_site_transport_partner"
              . " WHERE B.status=3 AND D.id_site_transport_partner ='{$da->id_site_transport_partner}' AND "
              . " (C.tanggal >= '{$awal}' AND C.tanggal <= '{$da->last_date}') AND B.debit='{$dcogs[$da->category]}'  "
//              . " GROUP BY D.id_site_transport_komisi_partner"
              );
       
//             print $this->db->last_query();
//              die;
      $button = "";
      $biaya_premi = $vc[0]->total;
      
      if($da->status_partner == 1){
          if($da->masuk+$da->jalan >= 15){
              $biaya_retensi = $da->biaya_retensi;
          }else{
              $biaya_retensi = 0;
          }
      }else{
          $biaya_retensi = round((($da->masuk+$da->jalan)/30)* $da->biaya_retensi);
      }
      
      
      $uang_pengganti_transport = $da->masuk * $da->uang_pengganti;
      $total_pendapatan = $uang_pengganti_transport+$biaya_retensi+$biaya_premi+$da->bpjs_kesehatan;
      
      if($da->npwp == 1){
         $gross =  round($total_pendapatan/(1-0.025));
         $pajak = round((2.5/100)*$gross);
         $denda = 0;
      }else{
          $gross = round($total_pendapatan/(1-(0.025*1.2)));
          $pajak = round((2.5/100)*$gross);
          $denda = round((20/100)*$pajak);
      }
      $total_pph = $pajak+$denda;
      
      $total_retensi = $total_retensi + $biaya_retensi;
      $total_uang_pengganti_transport = $total_uang_pengganti_transport + $uang_pengganti_transport;
      $total_biaya_premi = $total_biaya_premi + $biaya_premi;
      $total_bpjs_kesehatan = $total_bpjs_kesehatan + $da->bpjs_kesehatan;
      $all_total_pendapatan = $all_total_pendapatan + $total_pendapatan;
      $total_gross = $total_gross + $gross;
      $total_pajak = $total_pajak + $pajak;
      $total_denda = $total_denda + $denda;
      $all_total_pph = $all_total_pph + $total_pph;
      
            $objPHPExcel->getActiveSheet()->setCellValue('A'.(4+$key),$no);
            $objPHPExcel->getActiveSheet()->getStyle("A".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
            
        $objPHPExcel->getActiveSheet()->setCellValue('B'.(4+$key),$unit[$da->unit]);
             $objPHPExcel->getActiveSheet()->getStyle("B".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
          
            $objPHPExcel->getActiveSheet()->setCellValue('C'.(4+$key),$da->name);
        $objPHPExcel->getActiveSheet()->getStyle("C".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );  
        
          $objPHPExcel->getActiveSheet()->setCellValue('D'.(4+$key),$da->no);
        $objPHPExcel->getActiveSheet()->getStyle("D".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );  
        
         $objPHPExcel->getActiveSheet()->setCellValue('E'.(4+$key),$da->npwp);
        $objPHPExcel->getActiveSheet()->getStyle("E".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );  
        
        $objPHPExcel->getActiveSheet()->setCellValue('F'.(4+$key),$da->jalan);
             $objPHPExcel->getActiveSheet()->getStyle("F".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.(4+$key),$da->masuk);
        $objPHPExcel->getActiveSheet()->getStyle("G".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );     
          
         $objPHPExcel->getActiveSheet()->setCellValue('H'.(4+$key),$da->off);
         $objPHPExcel->getActiveSheet()->getStyle("H".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          ); 
         $objPHPExcel->getActiveSheet()->setCellValue('I'.(4+$key),$da->jalan+$da->masuk);
         $objPHPExcel->getActiveSheet()->getStyle("I".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('J'.(4+$key),$uang_pengganti_transport);
         $objPHPExcel->getActiveSheet()->getStyle("J".(4+$key))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("J".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          ); 
          
         $objPHPExcel->getActiveSheet()->setCellValue('K'.(4+$key),$biaya_retensi);
         $objPHPExcel->getActiveSheet()->getStyle("K".(4+$key))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("K".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          ); 
            
         $objPHPExcel->getActiveSheet()->setCellValue('L'.(4+$key),$biaya_premi);
         $objPHPExcel->getActiveSheet()->getStyle("L".(4+$key))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("L".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('M'.(4+$key),$da->bpjs_kesehatan);
         $objPHPExcel->getActiveSheet()->getStyle("M".(4+$key))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("M".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('N'.(4+$key),$biaya_retensi+$da->bpjs_kesehatan);
         $objPHPExcel->getActiveSheet()->getStyle("N".(4+$key))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("N".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('O'.(4+$key),$total_pendapatan);
         $objPHPExcel->getActiveSheet()->getStyle("O".(4+$key))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("O".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('P'.(4+$key),$gross);
         $objPHPExcel->getActiveSheet()->getStyle("P".(4+$key))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("P".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('Q'.(4+$key),$pajak);
         $objPHPExcel->getActiveSheet()->getStyle("Q".(4+$key))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("Q".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('R'.(4+$key),$denda);
         $objPHPExcel->getActiveSheet()->getStyle("R".(4+$key))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("R".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('S'.(4+$key),$total_pph);
         $objPHPExcel->getActiveSheet()->getStyle("S".(4+$key))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("S".(4+$key))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
        }
        
        $num =4+$no;
         $merger = "F".$num.":I".$num;
         $objPHPExcel->getActiveSheet()->mergeCells($merger);
         $objPHPExcel->getActiveSheet()->setCellValue('F'.($num),"Total");
         $objPHPExcel->getActiveSheet()->getStyle($merger)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle($merger)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($merger)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
         $objPHPExcel->getActiveSheet()->getStyle($merger)->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle($merger)->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
        $objPHPExcel->getActiveSheet()->setCellValue('J'.($num),$total_uang_pengganti_transport);
         $objPHPExcel->getActiveSheet()->getStyle("J".($num))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("J".($num))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('K'.($num),$total_retensi);
         $objPHPExcel->getActiveSheet()->getStyle("K".($num))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("K".($num))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('L'.($num),$total_biaya_premi);
         $objPHPExcel->getActiveSheet()->getStyle("L".($num))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("L".($num))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('M'.($num),$total_bpjs_kesehatan);
         $objPHPExcel->getActiveSheet()->getStyle("M".($num))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("M".($num))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('N'.($num),$total_retensi+$total_bpjs_kesehatan);
         $objPHPExcel->getActiveSheet()->getStyle("N".($num))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("N".($num))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('O'.($num),$all_total_pendapatan);
         $objPHPExcel->getActiveSheet()->getStyle("O".($num))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("O".($num))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('P'.($num),$total_gross);
         $objPHPExcel->getActiveSheet()->getStyle("P".($num))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("P".($num))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('Q'.($num),$total_pajak);
         $objPHPExcel->getActiveSheet()->getStyle("Q".($num))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("Q".($num))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
          $objPHPExcel->getActiveSheet()->setCellValue('R'.($num),$total_denda);
         $objPHPExcel->getActiveSheet()->getStyle("R".($num))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("R".($num))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
         $objPHPExcel->getActiveSheet()->setCellValue('S'.($num),$all_total_pph);
         $objPHPExcel->getActiveSheet()->getStyle("S".($num))->getNumberFormat()->setFormatCode('#,##0');
         $objPHPExcel->getActiveSheet()->getStyle("S".($num))->applyFromArray(
            array(
                'alignment' => array(
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                ),
                'borders' => array(
                  'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                  ),
                  'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                  ),
                ),
              )
          );
         
      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->freezePane('A4');
      
     
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
      header('Cache-Control: max-age=0');
      $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
//$objWriter->save(str_replace('.php', '.xls', __FILE__));
      $objWriter->save('php://output');die;
}

}