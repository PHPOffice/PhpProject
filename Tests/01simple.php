<?php

	/** Error reporting */
	error_reporting(E_ALL);

	/** Include path **/
	ini_set('include_path', ini_get('include_path').';../Classes/');

	/** PHPProject */
	include 'PHPProject.php';
	
	if(php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])) {
		define('EOL', PHP_EOL);
	}
	else {
		define('EOL', '<br />');
	}
	
	// Create new PHPProject object
	echo date('H:i:s') . ' Create new PHPProject object'.EOL;
	$objPHPProject = new PHPProject();

	// Set properties
	echo date('H:i:s') . ' Set properties'.EOL;
	$objPHPProject->getProperties()->setCreator('Progi1984');
	$objPHPProject->getProperties()->setLastModifiedBy('Progi1984');
	$objPHPProject->getProperties()->setTitle('Office 2007 MPP Test Document');
	$objPHPProject->getProperties()->setSubject('Office 2007 MPP Document');
	$objPHPProject->getProperties()->setDescription('Test document for Office 2007 MPP, generated using PHPProject.');

	// Add some data
	echo date('H:i:s') . ' Add some data'.EOL;
	$objPHPProject->getInformations()->setStartDate('01/01/2012');
	$objPHPProject->getInformations()->setEndDate('31/12/2012');

	// Create a first resource
	$objRes1 = $objPHPProject->createResource();
	$objRes1->setTitle('Progi1984');

	// Create a second resource
	$objRes2 = $objPHPProject->createResource();
	$objRes2->setTitle('AnotherMan');

	$objTask1 = $objPHPProject->createTask();
	$objTask1->setName('Start of the project');
	$objTask1->setDuration('1 day');
	$objTask1->setStartDate('01/01/2012');
	$objTask1->setEndDate('15/01/2012');
	$objTask1->setProgress(0.5);
	$objTask1->addResource($objRes1);
	$objTask1Res = $objTask1->getResources();
	echo 'Resources "Start of the project"'.EOL;
	foreach ($objTask1Res as $res){
		 echo ' > '.$objPHPProject->getResource($res)->getTitle().EOL;;
	}

	$objTask2 = $objPHPProject->createTask();
	$objTask2->setName('Analysis');

	$objTask21 = $objTask2->createTask();
	$objTask21->setName('Analysis Code');
	$objTask21->setDuration('1 day');
	$objTask21->setStartDate('01/01/2012');
	$objTask21->setEndDate('15/01/2012');
	$objTask21->setProgress(1);
	$objTask21->addResource($objRes2);
	$objTask21Res = $objTask21->getResources();
	echo 'Resources "Analysis Code"'.EOL;
	foreach ($objTask21Res as $res){
		 echo ' > '.$objPHPProject->getResource($res)->getTitle().EOL;;
	}

	$objTask22 = $objTask2->createTask();
	$objTask22->setName('Analysis Database');
	$objTask22->setDuration('1 day');
	$objTask22->setStartDate('01/01/2012');
	$objTask22->setEndDate('15/01/2012');
	$objTask22->setProgress(0.3);
 
	// Save MSProject2007 file
	echo date('H:i:s') . ' Write to MSProjectExchange format'.EOL;
	$objWriter = PHPProject_IOFactory::createWriter($objPHPProject, 'MSProjectExchange');
	$objWriter->save(str_replace('.php', '.mpx', __FILE__));

	// Save GanttProject file
	echo date('H:i:s') . ' Write to GanttProject format'.EOL;
	$objWriter = PHPProject_IOFactory::createWriter($objPHPProject, 'GanttProject');
	$objWriter->save(str_replace('.php', '.gan', __FILE__));

	// Echo done
	echo date('H:i:s') . ' Done writing file.'.EOL;

?>