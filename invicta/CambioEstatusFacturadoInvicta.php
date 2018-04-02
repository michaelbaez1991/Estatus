<?php 
	require_once"../src/core/Model/SqlConexion.php";
    require_once "../PHPExcel-1.8/Classes/PHPExcel.php";

    $db = new SqlConexion();

	//XML GETORDERS
		$nombre_archivo_descargado = "estatus(1).xlsx";
		$excelReader = PHPExcel_IOFactory::createReaderForFile($nombre_archivo_descargado);
		$excelObj = $excelReader->load($nombre_archivo_descargado);
		$worksheet = $excelObj->getSheet(0);
		$lastRow = $worksheet->getHighestRow();
 
		for ($row = 2; $row <= $lastRow; $row++) {
	        $orden = $worksheet->getCell('E'.$row)->getValue();
	        $ref = $worksheet->getCell('F'.$row)->getValue();
	        $factura = $worksheet->getCell('G'.$row)->getValue();
	        $guia = $worksheet->getCell('H'.$row)->getValue();

	        $sql = "SELECT TP.OrderId FROM [dbo].[TEMP-ORDENES_API_LINIO] AS TP INNER JOIN [dbo].[TEMP-ORDENES_API_LINIO_ITEMS] 
		    AS TH ON TP.OrderId = TH.OrderId WHERE TP.portal = 'INVICTA_MD' AND TP.OrderNumber = '$orden-INVICTA_MD'";

		    $consulta = $db->query($sql); 

		    $productos = $db->getResultQueryMatriz($sql);   

		    foreach ($productos as $value) {
		        foreach ($value as $value1) {
		            if($factura != ''){
				        if ($guia != '') {
				        	$query = "UPDATE [KRONO].[dbo].[TEMP-ORDENES_API_LINIO_ITEMS] SET [Status_] = 'Facturado', [NMRFCT] = '$factura', [TrackingCode] = '$guia' WHERE portal = 'INVICTA_MD' AND OrderId = '$value1' AND Sku = '$ref'";
				        	$consulta = $db->query($query); 
				        	print_r($consulta);
				        }else{
				        	$query = "UPDATE [KRONO].[dbo].[TEMP-ORDENES_API_LINIO_ITEMS] SET [Status_] = 'Facturado', [NMRFCT] = '$factura' WHERE portal = 'INVICTA_MD' AND OrderId = '$value1' AND Sku = '$ref'";
				        	$consulta = $db->query($query); 
				        	print_r($consulta);
				        }
			        }else{
			        	 if ($guia != '') {
				        	$query = "UPDATE [KRONO].[dbo].[TEMP-ORDENES_API_LINIO_ITEMS] SET [Status_] = 'Facturado', [NMRFCT] = '$factura', [TrackingCode] = '$guia' WHERE portal = 'INVICTA_MD' AND OrderId = '$value1' AND Sku = '$ref'";
				        	$consulta = $db->query($query); 
				        	print_r($consulta);
				        }else{
				        	$query = "UPDATE [KRONO].[dbo].[TEMP-ORDENES_API_LINIO_ITEMS] SET [Status_] = 'Facturado' WHERE portal = 'INVICTA_MD' AND OrderId = '$value1' AND Sku = '$ref'";
				        	$consulta = $db->query($query); 
				        	print_r($consulta);
				        }
			        }
		        }
		    }
		}
?>