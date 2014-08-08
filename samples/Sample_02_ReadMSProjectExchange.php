<?php

include_once 'Sample_Header.php';

use PhpOffice\PhpProject\PHPProject;
use PhpOffice\PhpProject\IOFactory;
    
// Create new PHPProject object
echo date('H:i:s') . ' Create new PHPProject object'.EOL;
$objReader = IOFactory::createReader('MSProjectExchange');
$objPHPProject = $objReader->load('02file.mpx');

// Set properties
echo date('H:i:s') . ' Set properties'.EOL;
echo 'Creator >'.$objPHPProject->getProperties()->getCreator().EOL;
echo 'LastModifiedBy >'.$objPHPProject->getProperties()->getLastModifiedBy().EOL;
echo 'Title >'.$objPHPProject->getProperties()->getTitle().EOL;
echo 'Subject >'.$objPHPProject->getProperties()->getSubject().EOL;
echo 'Description >'.$objPHPProject->getProperties()->getDescription().EOL;
echo EOL;

// Add some data
echo date('H:i:s') . ' Get some data'.EOL;
echo 'StartDate >'.$objPHPProject->getInformations()->getStartDate().EOL;
echo 'EndDate >'.$objPHPProject->getInformations()->getEndDate().EOL;
echo EOL;

// Ressources
echo date('H:i:s') . ' Get ressources'.EOL;
$oResources = $objPHPProject->getAllResources();
foreach ($oResources as $item){
    echo 'Resource :'.$item->getTitle().EOL;
}
echo EOL;

// Tasks
echo date('H:i:s') . ' Get tasks'.EOL;
$oTasks = $objPHPProject->getAllTasks();
foreach ($oTasks as $item){
    echo 'Task :'.$item->getName().EOL;
    echo ' >> Duration :'.$item->getDuration().EOL;
    echo ' >> StartDate :'.$item->getStartDate().EOL;
    echo ' >> EndDate :'.$item->getEndDate().EOL;
    echo ' >> Progress :'.$item->getProgress().EOL;
    echo ' >> Resources :'.EOL;
    $oTaskResources = $item->getResources();
    if(!empty($oTaskResources)){
        foreach ($oTaskResources as $itemRes){
            echo ' >>>> Resource :'.$objPHPProject->getResource($itemRes)->getTitle().EOL;
        }
    }
    
    echo ' >> SubTasks :'.EOL;
    $oSubTasks = $item->getTasks();
    if(!empty($oSubTasks)){
        foreach ($oSubTasks as $itemSub){
            echo ' >>>> Task :'.$itemSub->getName().EOL;
            echo ' >>>>>> Duration :'.$itemSub->getDuration().EOL;
            echo ' >>>>>> StartDate :'.$itemSub->getStartDate().EOL;
            echo ' >>>>>> EndDate :'.$itemSub->getEndDate().EOL;
            echo ' >>>>>> Progress :'.$itemSub->getProgress().EOL;
            echo ' >>>>>> Resources :'.EOL;
            $oTaskResources = $itemSub->getResources();
            if(!empty($oTaskResources)){
                foreach ($oTaskResources as $itemRes){
                    echo ' >>>>>>>> Resource :'.$objPHPProject->getResource($itemRes)->getTitle().EOL;
                }
            }
        }
    }
}
echo EOL;

// Echo done
echo date('H:i:s') . ' Done reading file.'.EOL;

if (!CLI) {
    include_once 'Sample_Footer.php';
}