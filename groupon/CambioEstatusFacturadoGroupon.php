<?php 
	require_once"../src/core/Model/SqlConexion.php";
    require_once "../PHPExcel-1.8/Classes/PHPExcel.php";

    $db = new SqlConexion();

	//XML GETORDERS
		$nombre_archivo_descargado = "estatus_groupon.xlsx";
		$excelReader = PHPExcel_IOFactory::createReaderForFile($nombre_archivo_descargado);
		$excelObj = $excelReader->load($nombre_archivo_descargado);
		$worksheet = $excelObj->getSheet(0);
		$lastRow = $worksheet->getHighestRow();
 
		for ($row = 2; $row <= $lastRow; $row++) {
	        $orden = $worksheet->getCell('E'.$row)->getValue();

        	$query = "UPDATE [KRONO].[dbo].[TEMP-ORDENES_API_LINIO_ITEMS] SET [Status_] = 'Facturado' WHERE portal = 'GROUPON' AND OrderId = '$orden-GROUPON_KRONOTIME'";
        	$consulta = $db->query($query); 
        	print_r($consulta);
		}
?>