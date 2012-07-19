<?php

	// http://www.microsoft.com/france/project/project-2010/premiers-pas.aspx

	/** Error reporting */
	error_reporting(E_ALL);

	/** Include path **/
	ini_set('include_path', ini_get('include_path').';../Classes/');

	/** PHPProject */
	include 'PHPProject.php';

	// Create new PHPProject object
	echo date('H:i:s') . " Create new PHPProject object\n";
	$objPHPProject = new PHPProject();

	// Set properties
	echo date('H:i:s') . " Set properties\n";
	$objPHPProject->getProperties()->setCreator("Progi1984");
	$objPHPProject->getProperties()->setLastModifiedBy("Progi1984");
	$objPHPProject->getProperties()->setTitle("Office 2007 MPP Test Document");
	$objPHPProject->getProperties()->setSubject("Office 2007 MPP Document");
	$objPHPProject->getProperties()->setDescription("Test document for Office 2007 MPP, generated using PHPProject.");


	// Add some data
	echo date('H:i:s') . " Add some data\n";
	$objPHPProject->getInformations()->setStartDate("01/01/2012");
	$objPHPProject->getInformations()->setEndDate("31/12/2012");

	$objRes1 = $objPHPProject->addResource();
	$objRes1->getInformations()->getTitle('Progi1984');

	$objRes2 = $objPHPProject->addResource();
	$objRes2->getInformations()->getTitle('AnotherMan');

	$objTask1 = $objPHPProject->addTask();
	$objTask1->getInformations()->setName('Start of the project');
	$objTask1->getInformations()->setDuration('1 day');
	$objTask1->getInformations()->setStartDate('01/01/2012');
	$objTask1->getInformations()->setEndDate('15/01/2012');
	$objTask1->getInformations()->setProgress(0.5);
	$objTask1->addResource($objRes1);
	$objTask1Res = $objTask1->getResources();
	foreach ($objTask1Res as $res){
		 echo $res->getTitle();
	}

	$objTask2 = $objPHPProject->addTask();
	$objTask2->getInformations()->setName('Etude');

	$objTask21 = $objPHPProject->addTask();
	$objTask21->getInformations()->setName('Spécifications fonctionnelles');
	$objTask21->getInformations()->setDuration('1 day');
	$objTask21->getInformations()->setStartDate('01/01/2012');
	$objTask21->getInformations()->setEndDate('15/01/2012');
	$objTask21->getInformations()->setProgress(1);
	$objTask21->setParentTask(objTask2);
	$objTask21->addResource($objRes2);
	$objTask21Res = $objTask21->getResources();
	foreach ($objTask21Res as $res){
		 echo $res->getTitle();
	}

	$objTask22 = $objPHPProject->addTask();
	$objTask22->getInformations()->setName('Spécifications techniques');
	$objTask22->getInformations()->setDuration('1 day');
	$objTask22->getInformations()->setStartDate('01/01/2012');
	$objTask22->getInformations()->setEndDate('15/01/2012');
	$objTask22->getInformations()->setProgress(0.3);
	$objTask21->setParentTask(objTask2);


		   
	// Save MSProject2007 file
	echo date('H:i:s') . " Write to MSProject2007 format\n";
	$objWriter = new PHPProject_Writer_MSProject2007($objPHPProject);
	$objWriter->save(str_replace('.php', '.mpp', __FILE__));

	// Save GanttProject file
	echo date('H:i:s') . " Write to GanttProject format\n";
	$objWriter = new PHPProject_Writer_GanttProject($objPHPProject);
	$objWriter->save(str_replace('.php', '.gan', __FILE__));

	// Echo done
	echo date('H:i:s') . " Done writing file.\r\n";

?>