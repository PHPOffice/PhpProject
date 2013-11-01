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
* @author	Tuomas Angervuori <tuomas.angervuori@gmail.com>
* @link		http://msdn.microsoft.com/en-us/library/office/bb968701(v=office.12).aspx
* @license	http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
* @version	##VERSION##, ##DATE##
*/


/**
 * PHPProject_Reader_MSProjectXML
 *
 * @category	PHPProject
 * @package	PHPProject
 */
class PHPProject_Reader_MSProjectXML
{
	/**
	 * PHPProject object
	 *
	 * @var PHPProject
	 */
	private $_phpProject;
	
	
	/**
	 * Create a new PHPProject_Reader_MSProjectXML
	 *
	 * @param	PHPProject	$phpProject	PHPProject object
	 */
	public function __construct() {
		$this->_phpProject = new PHPProject();
	}
	
	/**
	 * 
	 *
	 * @param unknown_type $pFilename
	 * @param $projectId Project id to load. If null then select the first project.
	 * @return PHPProject
	 */
	public function load($pFilename = null){
		
		$xml = simplexml_load_file($pFilename);
		if($xml->getName() != 'Project') {
			throw new Exception("Unknown XML file format");
		}
		
		$this->_phpProject->getProperties()->setLastModifiedBy($xml->Author);
		$this->_phpProject->getProperties()->setCreated($xml->CreationDate);
		if($xml->LastSaved) {
			$this->_phpProject->getProperties()->setModified($xml->LastSaved);
		}
		if($xml->Title) {
			$title = $xml->Title;
		}
		else {
			$title = $xml->Name;
		}
		$this->_phpProject->getProperties()->setTitle($title);
		$this->_phpProject->getProperties()->setSubject($xml->Subject);
		$this->_phpProject->getProperties()->setCategory($xml->Category);
		$this->_phpProject->getProperties()->setCompany($xml->Company);
		$this->_phpProject->getProperties()->setManager($xml->Manager);
		
		$this->_phpProject->getInformations()->setStartDate($xml->StartDate);
		$this->_phpProject->getInformations()->setEndDate($xml->FinishDate);
		
		
		if($xml->Resources) {
			foreach($xml->Resources->Resource as $resXml) {
				$res = $this->_phpProject->createResource();
				$res->setName($resXml->Name);
			}
		}
		
		if($xml->Tasks) {
			foreach($xml->Tasks->Task as $taskXml) {
				$task = $this->_phpProject->createTask();
				$task->setName($taskXml->Name);
				$task->setDuration($taskXml->Duration);
				$task->setStartDate($taskXml->Start);
				$task->setEndDate($taskXml->Finish);
				$task->setProgress($taskXml->PercentComplete);
			}
		}
		
		//TODO subTasks, link resources to tasks, calendars, etc..
		
		return $this->_phpProject;
	}
	
}


?>