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
	        $orden = $worksheet->getCell('C'.$row)->getValue();
	        $ref = $worksheet->getCell('D'.$row)->getValue();

	        $query = "UPDATE [KRONO].[dbo].[TEMP-ORDENES_API_LINIO_ITEMS] SET [Status_] = 'Cancelado' WHERE portal = 'TOUS' AND OrderId = '00$orden-TOUS' AND Sku = '$ref'";
	        $consulta = $db->query($query); 
	        print_r($consulta);
		}
?>