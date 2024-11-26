<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class export_excel{
    function to_excel($array, $filename) {
        $h = array();
   		foreach($array[0] as $key=>$val){
   			if(!in_array($key, $h)){
   				$h[] = $key;
   			}
   		}
   		$objPHPExcel = new PHPExcel();

   		// Set properties
   		$objPHPExcel->getProperties()->setCreator("Cecaitra");
   		$objPHPExcel->getProperties()->setLastModifiedBy("Cecaitra");
   		$objPHPExcel->getProperties()->setTitle("Equipos");
   		$objPHPExcel->getProperties()->setSubject("Listado");
   		$objPHPExcel->setActiveSheetIndex(0);

         $styleArray = array(
               'font' => array(
               'bold' => true,
             ),
               'alignment' => array(
               'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             ),
         );

   		$row = 1; $col = 'A';
		// Armo header
   		foreach ($h as $header) {
   			$objPHPExcel->getActiveSheet()->SetCellValue("{$col}{$row}", $header);
            $objPHPExcel->getActiveSheet()->getStyle("{$col}{$row}", $header)->applyFromArray($styleArray);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension("{$col}")->setAutoSize(TRUE);
   			$col++;
   		}
   		// Lleno el contenido
   		foreach ($array as $equipo) {
   			$row++; $col = 'A';
   			foreach ($equipo as $campo) {
   				$objPHPExcel->getActiveSheet()->SetCellValue("{$col}{$row}", $campo);
               $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension("{$col}")->setAutoSize(TRUE);
   				$col++;
   			}
   		}

   		$ruta = $config['base_url'].'tmp/';
      //$ruta = 'var/www/html/sistemac/documentacion/';

   		// Save Excel 2007 file
   		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
   		$objWriter->save($ruta.$filename);
   		header('Content-Description: File Transfer');
   		header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
   		header('Content-Disposition: attachment; filename='.$filename.'.xlsx');
   		header('Content-Transfer-Encoding: binary');
   		header('Expires: 0');
   		header('Cache-Control: must-revalidate');
   		header('Pragma: public');
   		header('Content-Length: ' . filesize($ruta.$filename));
   		ob_clean();
   		flush();
   		readfile($ruta.$filename);
   		unlink($ruta.$filename);
    }

    function diasOperativos($array, $filename, $fecha_desde, $fecha_hasta) {
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Cecaitra");
        $objPHPExcel->getProperties()->setLastModifiedBy("Cecaitra");
        $objPHPExcel->getProperties()->setTitle("Equipos");
        $objPHPExcel->getProperties()->setSubject("Informe de días no operativos");
        $objPHPExcel->setActiveSheetIndex(0);

        $styleBoldHorizontal = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );

        $styleBold = array(
            'font' => array(
                'bold' => true,
            )
        );

        // Título
        $objPHPExcel->getActiveSheet()->SetCellValue("A1", "Informe de días no operativos de equipos");
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($styleBold);
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setWrapText(TRUE);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');

        $objPHPExcel->getActiveSheet()->SetCellValue("A2", "Fecha de emisión");
        $objPHPExcel->getActiveSheet()->getStyle("A2")->applyFromArray($styleBold);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->SetCellValue("C2", date('d/m/Y'));

        $objPHPExcel->getActiveSheet()->SetCellValue("A3", "Fecha Desde");
        $objPHPExcel->getActiveSheet()->getStyle("A3")->applyFromArray($styleBold);
        $objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
        $objPHPExcel->getActiveSheet()->SetCellValue("C3", date('d/m/Y',strtotime($fecha_desde)));

        $objPHPExcel->getActiveSheet()->SetCellValue("A4", "Fecha Hasta");
        $objPHPExcel->getActiveSheet()->getStyle("A4")->applyFromArray($styleBold);
        $objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
        $objPHPExcel->getActiveSheet()->SetCellValue("C4", date('d/m/Y',strtotime($fecha_hasta)));

        // Armo header
        $objPHPExcel->getActiveSheet()->SetCellValue("A5", "Proyecto");
        $objPHPExcel->getActiveSheet()->getStyle("A5")->applyFromArray($styleBoldHorizontal);

        $objPHPExcel->getActiveSheet()->SetCellValue("B5", "Equipo");
        $objPHPExcel->getActiveSheet()->getStyle("B5")->applyFromArray($styleBoldHorizontal);

        $objPHPExcel->getActiveSheet()->SetCellValue("C5", "Ubicación");
        $objPHPExcel->getActiveSheet()->getStyle("C5")->applyFromArray($styleBoldHorizontal);

        $objPHPExcel->getActiveSheet()->SetCellValue("D5", "KM / Altura");
        $objPHPExcel->getActiveSheet()->getStyle("D5")->applyFromArray($styleBoldHorizontal);

        $objPHPExcel->getActiveSheet()->SetCellValue("E5", "Vel. perm.");
        $objPHPExcel->getActiveSheet()->getStyle("E5")->applyFromArray($styleBoldHorizontal);

        $objPHPExcel->getActiveSheet()->SetCellValue("F5", "Fecha de cal.");
        $objPHPExcel->getActiveSheet()->getStyle("F5")->applyFromArray($styleBoldHorizontal);

        $objPHPExcel->getActiveSheet()->SetCellValue("G5", "Vto. Cal.");
        $objPHPExcel->getActiveSheet()->getStyle("G5")->applyFromArray($styleBoldHorizontal);

        $objPHPExcel->getActiveSheet()->SetCellValue("H5", "Rep.");
        $objPHPExcel->getActiveSheet()->getStyle("H5")->applyFromArray($styleBoldHorizontal);

        $objPHPExcel->getActiveSheet()->SetCellValue("I5", "Op.");
        $objPHPExcel->getActiveSheet()->getStyle("I5")->applyFromArray($styleBoldHorizontal);

        $objPHPExcel->getActiveSheet()->SetCellValue("J5", "%");
        $objPHPExcel->getActiveSheet()->getStyle("J5")->applyFromArray($styleBoldHorizontal);

        // Lleno el contenido
        $linea = 6;
        $dStart = new DateTime($fecha_desde);
        $dEnd  = new DateTime($fecha_hasta);
        $dDiff = $dStart->diff($dEnd);

        foreach ($array as $row) {
            $objPHPExcel->getActiveSheet()->SetCellValue("A{$linea}", $row->proyecto);
            $objPHPExcel->getActiveSheet()->SetCellValue("B{$linea}", $row->equipo);
            $objPHPExcel->getActiveSheet()->SetCellValue("C{$linea}", $row->ubicacion);
            $objPHPExcel->getActiveSheet()->SetCellValue("D{$linea}", $row->altura);
            $objPHPExcel->getActiveSheet()->SetCellValue("E{$linea}", $row->vel_per);
            $objPHPExcel->getActiveSheet()->SetCellValue("F{$linea}", $row->fecha_cal);
            $objPHPExcel->getActiveSheet()->SetCellValue("G{$linea}", $row->vto_cal);
            $objPHPExcel->getActiveSheet()->SetCellValue("H{$linea}", $row->dias_reparacion);
            $objPHPExcel->getActiveSheet()->SetCellValue("I{$linea}", $dDiff->days-$row->dias_reparacion);
            $objPHPExcel->getActiveSheet()->SetCellValue("J{$linea}", $row->porcentaje);

            $linea++;
        }

        for ($i = 'A'; $i <= 'J'; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension("{$i}")->setAutoSize(TRUE);
        }

        $ruta = $config['base_url'].'tmp/';
        // Save Excel 2007 file
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($ruta.$filename);
        header('Content-Description: File Transfer');
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename='.$filename.'.xlsx');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($ruta.$filename));
        ob_clean();
        flush();
        readfile($ruta.$filename);
        unlink($ruta.$filename);
    }
}
?>
