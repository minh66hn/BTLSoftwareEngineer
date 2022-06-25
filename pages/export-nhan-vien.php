<?php 
	
	// PHPExcel
  	include('Classes/PHPExcel.php');
  	// connect database
  	require_once('../config.php');

  	// export file excel
  	$objExcel = new PHPExcel;
  	$objExcel->setActiveSheetIndex(0);
  	$sheet = $objExcel->getActiveSheet()->setTitle('Bảng nhân viên');
  	// dinh dang file excel
  	// - dinh dang cho du kich thuoc noi dung
  	$sheet->getColumnDimension("A")->setAutoSize(true);
  	$sheet->getColumnDimension("B")->setAutoSize(true);
  	$sheet->getColumnDimension("C")->setAutoSize(true);
  	$sheet->getColumnDimension("D")->setAutoSize(true);
  	$sheet->getColumnDimension("E")->setAutoSize(true);
  	$sheet->getColumnDimension("F")->setAutoSize(true);
  	$sheet->getColumnDimension("G")->setAutoSize(true);
  	$sheet->getColumnDimension("H")->setAutoSize(true);
    $sheet->getColumnDimension("I")->setAutoSize(true);

  	// chinh mau dong title
  	$sheet->getStyle('A1:W1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');
  	// canh giua
  	$sheet->getStyle('A1:W1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

  	// dem so dong
  	$rowCount = 1;
  	// set cho dong dau tien (dong tieu de)
  	$sheet->setCellValue('A' . $rowCount, 'STT');
  	$sheet->setCellValue('B' . $rowCount, 'Mã nhân viên');
  	$sheet->setCellValue('C' . $rowCount, 'Tên nhân viên');
  	$sheet->setCellValue('D' . $rowCount, 'Giới tính');
  	$sheet->setCellValue('E' . $rowCount, 'Ngày sinh');
  	$sheet->setCellValue('F' . $rowCount, 'Số CMND');
    $sheet->setCellValue('G' . $rowCount, 'Tạm trú');
    $sheet->setCellValue('H' . $rowCount, 'Phòng ban');
    $sheet->setCellValue('I' . $rowCount, 'Chức vụ');


  	// do du lieu tu db
  	$sql = "SELECT nv.id as id, ma_nv, hinh_anh, ten_nv, gioi_tinh, nv.ngay_tao as ngay_tao, ngay_sinh,  so_cmnd,tam_tru,  ten_phong_ban, ten_chuc_vu FROM nhanvien nv,  phong_ban pb, chuc_vu cv WHERE nv.phong_ban_id = pb.id AND nv.chuc_vu_id = cv.id  ORDER BY nv.id DESC";
  	$result = mysqli_query($conn, $sql);
  	$stt = 0;
  	while ($row = mysqli_fetch_array($result)) 
  	{
  		// do du lieu tang len theo cac cot
  		$rowCount++;
  		$stt++;

      // cau hinh lai cac truong
      if($row['gioi_tinh'] == 1)
      {
        $gioiTinh = 'Nam';
      }
      else
      {
        $gioiTinh = 'Nữ';
      }



  		// do het du lieu ra cac dong
  		$sheet->setCellValue('A' . $rowCount, $stt);
	  	$sheet->setCellValue('B' . $rowCount, $row['ma_nv']);
	  	$sheet->setCellValue('C' . $rowCount, $row['ten_nv']);
	  	$sheet->setCellValue('D' . $rowCount, $gioiTinh);
		$sheet->setCellValue('E' . $rowCount, $row['ngay_sinh']);
	  	$sheet->setCellValue('F' . $rowCount, $row['so_cmnd']);
      $sheet->setCellValue('G' . $rowCount, $row['tam_tru']);
      $sheet->setCellValue('H' . $rowCount, $row['ten_phong_ban']);
      $sheet->setCellValue('I' . $rowCount, $row['ten_chuc_vu']);
  	}

  	// tao border
  	$styleArray = array(
  		'borders' => array(
  			'allborders' => array(
  				'style' => PHPExcel_Style_Border::BORDER_THIN
  			)
  		)
  	);
  	$sheet->getStyle('A1:' . 'W'.($rowCount))->applyFromArray($styleArray);

  	// tao tac xuat file
  	$objWriter = new PHPExcel_Writer_Excel2007($objExcel);
  	$filename = 'nhan-vien.xlsx';
  	$objWriter->save($filename);

  	// cau hinh khi xuat file
  	header('Content-Disposition: attachment; filename="' .$filename. '"'); // tra ve file kieu attachment
  	header('Content-Type: application/vnd.openxmlformatsofficedocument.spreadsheetml.sheet');
  	header('Content-Legth: ' . filesize($filename));
  	header('Content-Transfer-Encoding: binary');
  	header('Cache-Control: must-revalidate');
  	header('Pragma: no-cache');
  	readfile($filename);
  	return;

?>