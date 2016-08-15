<?php
session_start();
require_once("../../../DB.php");
require_once '../../../PHPExcel/Classes/PHPExcel.php';
require_once '../../../PHPExcel/Classes/PHPExcel/IOFactory.php';

$db = new DB();

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$query="select * from crp_tables left join crp_crptables on crp_crptables.tableid=crp_tables.id where crp_crptables.crpid=".$_SESSION['crpid']." order by crp_tables.position";
$res=mysql_query($query);
$i=0;
while($row=mysql_fetch_object($res)){
  
  // Create a new worksheet, after the default sheet
  if($i>0)
    $objPHPExcel->createSheet();
  // Create a first sheet, representing sales data
  $objPHPExcel->setActiveSheetIndex($i);
  $sql="select * from crp_tablecols where tableid=$row->tableid and name!='' ";
  $rs=mysql_query($sql);
  $j="A";
  while($rw=mysql_fetch_object($rs)){
    //$j++;
    $objPHPExcel->getActiveSheet()->setCellValue($j.'1', $rw->name);    
    $j++;
  }
  
  // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle($row->name);
    
  $i++;
}

// Redirect output to a client?s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$_SESSION['crp'].'-Tpl.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>