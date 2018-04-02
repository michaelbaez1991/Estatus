<?php 
	require_once"../src/core/Model/SqlConexion.php";
    require_once "../PHPExcel-1.8/Classes/PHPExcel.php";

    $db = new SqlConexion();

	//XML GETORDERS
		$nombre_archivo_descargado = "estatus_tous.xlsx";
		$excelReader = PHPExcel_IOFactory::createReaderForFile($nombre_archivo_descargado);
		$excelObj = $excelReader->load($nombre_archivo_descargado);
		$worksheet = $excelObj->getSheet(0);
		$lastRow = $worksheet->getHighestRow();
 
		for ($row = 2; $row <= $lastRow; $row++) {
	        $orden = $worksheet->getCell('I'.$row)->getValue();
	        $ref = $worksheet->getCell('J'.$row)->getValue();
	        $factura = $worksheet->getCell('K'.$row)->getValue();
	        $guia = $worksheet->getCell('L'.$row)->getValue();

	        if($factura != ''){
		        if ($guia != '') {
		        	$query = "UPDATE [KRONO].[dbo].[TEMP-ORDENES_API_LINIO_ITEMS] SET [Status_] = 'Despachado', [NMRFCT] = '$factura', [TrackingCode] = '$guia' WHERE portal = 'TOUS' AND OrderId = '00$orden-TOUS' AND Sku = '$ref'";
		        	$consulta = $db->query($query); 
		        	print_r($consulta);
		        }else{
		        	$query = "UPDATE [KRONO].[dbo].[TEMP-ORDENES_API_LINIO_ITEMS] SET [Status_] = 'Despachado', [NMRFCT] = '$factura' WHERE portal = 'TOUS' AND OrderId = '00$orden-TOUS' AND Sku = '$ref'";
		        	$consulta = $db->query($query); 
		        	print_r($consulta);
		        }
	        }else{
	        	 if ($guia != '') {
		        	$query = "UPDATE [KRONO].[dbo].[TEMP-ORDENES_API_LINIO_ITEMS] SET [Status_] = 'Despachado', [NMRFCT] = '$factura', [TrackingCode] = '$guia' WHERE portal = 'TOUS' AND OrderId = '00$orden-TOUS' AND Sku = '$ref'";
		        	$consulta = $db->query($query); 
		        	print_r($consulta);
		        }else{
		        	$query = "UPDATE [KRONO].[dbo].[TEMP-ORDENES_API_LINIO_ITEMS] SET [Status_] = 'Despachado' WHERE portal = 'TOUS' AND OrderId = '00$orden-TOUS' AND Sku = '$ref'";
		        	$consulta = $db->query($query); 
		        	print_r($consulta);
		        }
	        }
		}
?>