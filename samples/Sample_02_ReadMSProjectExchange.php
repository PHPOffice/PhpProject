<?php

include_once 'Sample_Header.php';

use PhpOffice\PhpProject\PHPProject;
use PhpOffice\PhpProject\IOFactory;
    
// Create new PHPProject object
echo date('H:i:s') . ' Create new PHPProject object'.EOL;
$objReader = IOFactory::createReader('MsProjectMPX');
$objPHPProject = $objReader->load(__DIR__ .DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'Sample_02.mpx');

// Set properties
echo date('H:i:s') . ' Get properties'.EOL;
echo 'Creator > '.$objPHPProject->getProperties()->getCreator().EOL;
echo 'LastModifiedBy > '.$objPHPProject->getProperties()->getLastModifiedBy().EOL;
echo 'Title > '.$objPHPProject->getProperties()->getTitle().EOL;
echo 'Subject > '.$objPHPProject->getProperties()->getSubject().EOL;
echo 'Description > '.$objPHPProject->getProperties()->getDescription().EOL;
echo EOL;

// Add some data
echo date('H:i:s') . ' Get some data'.EOL;
echo 'StartDate > '.$objPHPProject->getInformations()->getStartDate().EOL;
echo 'EndDate > '.$objPHPProject->getInformations()->getEndDate().EOL;
echo EOL;

// Ressources
echo date('H:i:s') . ' Get ressources'.EOL;
$oResources = $objPHPProject->getAllResources();
foreach ($oResources as $item){
    echo 'Resource : '.$item->getTitle().EOL;
}
echo EOL;

// Tasks
echo date('H:i:s') . ' Get tasks'.EOL;
$arrTasks = $objPHPProject->getAllTasks();

foreach ($arrTasks as $oTask){
	echoTask($objPHPProject, $oTask);
}

// Echo done
echo date('H:i:s') . ' Done reading file.'.EOL;

if (!CLI) {
    include_once 'Sample_Footer.php';
}