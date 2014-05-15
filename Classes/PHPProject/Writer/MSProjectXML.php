<?php 
/**
 * PHPProject
 *
 * Copyright (c) 2012 - 2012 PHPProject
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category	PHPProject
 * @package	PHPProject
 * @copyright	Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 * @license	http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version	##VERSION##, ##DATE##
 */

namespace PHPProject\Writer;

/**
 * PHPProject\Writer\MSProjectXML
 *
 * @link	http://msdn.microsoft.com/en-us/library/office/bb968701(v=office.12).aspx
 *
 * @category	PHPProject
 * @package	PHPProject
 * @copyright	Tuomas Angervuori <tuomas.angervuori@gmail.com>
 */
class MSProjectXML {
	/**
	 * PHPProject object
	 *
	 * @var PHPProject
	 */
	private $_phpProject;
	
	
	/**
	 * Create a new PHPProject_Writer_MSProjectXML
	 *
	 * @param	PHPProject	$phpProject	PHPProject object
	 */
	public function __construct(\PHPProject $phpProject) {
		$this->_phpProject	= $phpProject;
	}
	
	public function save($pFilename = null){
		
		$xml = new \XMLWriter();
		$xml->openMemory();
		$xml->setIndent(true);
		
		$xml->startDocument('1.0','UTF-8','yes');
		
		$xml->startElement('Project');
		$xml->writeAttribute('xmlns', 'http://schemas.microsoft.com/project');
		
		//Project information
		$project = $this->_phpProject->getProperties();
		$info = $this->_phpProject->getInformations();
		$values = array(
			'SaveVersion' => '12',
			'Name' => $project->getTitle(),
			'Subject' => $project->getSubject(),
			'Category' => $project->getCategory(),
			'Company' => $project->getCompany(),
			'Manager' => $project->getManager(),
			//'Author' => $project->getAuthor(),
			//'CreationDate' => $project->getCreationDate()->format('c'),
			//'Revision' => $project->getRevision(),
			//'LastSaved' => $project->getLastSaved()->format('c'),
			//'ScheduleFromStart' => $project->isScheduleFromStart(),
			'StartDate' => $info->getStartDate()->format('c'),
			'FinishDate' => $info->getEndDate()->format('c'),
			//'StatusDate' => $info->getStatusDate()->format('c'),
			//'CurrentDate' => $info->getCurrentDate()->format('c')
		);
		foreach($values as $element => $value) {
			if($value !== null) {
				$xml->startElement($element);
				$xml->text($value);
				$xml->fullEndElement();
			}
		}
		
		
		//Calendars FIXME add proper calendar suppor
		$xml->startElement('Calendars');
		$xml->startElement('Calendar');
		$xml->startElement('UID');
		$xml->text(1); //TODO Support more calendars than just 1?
		
		$xml->fullEndElement(); //UID
		$xml->fullEndElement(); //Calendar
		$xml->fullEndElement(); //Calendars
		
		
		//Tasks
		$tasks = $this->_phpProject->getAllTasks();
		if($tasks) {
			$xml->startElement('Tasks');
			foreach($tasks as $task) {
				$xml->startElement('Task');
				$values = array(
					'UID' => $task->getUid(),
					'ID' => $task->getId(),
					'Name' => $task->getName(),
					'Type' => $task->getType(), //0=fixed units, 1=fixed duration, 2=fixed work
					'CreateDate' => $task->getCreateDate(),
					'Contact' => $task->getContact(),
					'OutlineNumber' => $task->getOutlineNumber(), //eg "2.3.5"
					'Priority' => $task->getPriority(), //500 = default
					'Start' => $task->getStart(),
					'Finish' => $task->getFinish(),
					'Duration' => $task->getDuration(),
					'PercentComplete' => $task->getPercentComplete(), 
					'Notes' => $task->getNotes(),
					'CalendarUID' => '1' //$task->getCalendarUID()
				);
				foreach($values as $element => $value) {
					$xml->startElement($element);
					$xml->text($value);
					$xml->fullEndElement();
				}
				$xml->fullEndElement(); //Task
			}
			$xml->fullEndElement(); //Tasks
		}
		
		$resources = $this->_phpProject->getAllResources();
		if($resources) {
			$xml->startElement('Resources');
			///TODO
			$xml->fullEndElement(); //Resources
		}
		
		
		//TODO...
		//$xml->startElement('Assignments');
		//$xml->fullEndElement(); //Assignments
		
		
		$xml->fullEndElement(); //Project
		
		$xml->endDocument();
		
		echo $xml->outputMemory();
	}
}
