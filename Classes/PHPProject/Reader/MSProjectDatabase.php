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
* @license	http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
* @version	##VERSION##, ##DATE##
*/

namespace PHPProject\Reader;

/**
 * PHPProject\Reader\MSProjectDatabase
 *
 * @author	Tuomas Angervuori <tuomas.angervuori@gmail.com>
 * @category	PHPProject
 * @package	PHPProject
 */
class MSProjectDatabase {
	/**
	 * PHPProject object
	 *
	 * @var PHPProject
	 */
	public $mdbToolsPath;
	private $_phpProject;
	private $_pFilename;
	
	
	/**
	 * Create a new PHPProject\Reader\MSProjectDatabase
	 *
	 * @param	PHPProject	$phpProject	PHPProject object
	 */
	public function __construct() {
		$this->_phpProject = new \PHPProject();
	}
	
	/**
	 * 
	 *
	 * @param unknown_type $pFilename
	 * @param $projectId Project id to load. If null then select the first project.
	 * @return PHPProject
	 */
	public function load($pFilename = null, $projectId = null){
		
		$this->_pFilename = $pFilename;
		
		//Check required tables from document
		$requiredTables = array(
			'MSP_PROJECTS',
			'MSP_RESOURCES',
			'MSP_TASKS'
		);
		$tables = $this->_getMdpTables();
		foreach($requiredTables as $reqTable) {
			if(!in_array($reqTable, $tables)) {
				throw new Exception("Unknown file format");
			}
		}
		
		$data = $this->_getMdpTableData('MSP_PROJECTS');
		if($data) {
			
			if($projectId !== null) {
				$rowNum = null;
				foreach($data as $i => $row) {
					if($row['PROJ_ID'] == $projectId) {
						$rowNum = $i;
						break;
					}
				}
				if($rowNum === null) {
					throw new Exception("Project #$projectId not found");
				}
			}
			else {
				$rowNum = 0;
			}
			
			$projectData = $data[$rowNum];
			$projectId = $projectData['PROJ_ID'];
			
			$this->_phpProject->getProperties()->setLastModifiedBy($projectData['PROJ_PROP_AUTHOR']);
			$this->_phpProject->getProperties()->setCreated($projectData['PROJ_CREATION_DATE']);
			$this->_phpProject->getProperties()->setModified($projectData['PROJ_LAST_SAVED']);
			$this->_phpProject->getProperties()->setTitle($projectData['PROJ_PROP_TITLE']);
			$this->_phpProject->getProperties()->setSubject($projectData['PROJ_PROP_SUBJECT']);
			$this->_phpProject->getProperties()->setKeywords($projectData['PROJ_PROP_KEYWORDS']);
			$this->_phpProject->getProperties()->setCategory($projectData['PROJ_PROP_CATEGORY']);
			$this->_phpProject->getProperties()->setCompany($projectData['PROJ_PROP_COMPANY']);
			$this->_phpProject->getProperties()->setManager($projectData['PROJ_PROP_MANAGER']);
			
			$this->_phpProject->getInformations()->setStartDate($projectData['PROJ_INFO_START_DATE']);
			$this->_phpProject->getInformations()->setEndDate($projectData['PROJ_INFO_FINISH_DATE']);
			
			//Project resources
			$data = $this->_getMdpTableData('MSP_RESOURCES');
			foreach($data as $row) {
				if($row['PROJ_ID'] == $projectId) {
					$resource = $this->_phpProject->createResource();
					$resource->setTitle($row['RES_NAME']);
				}
			}
			///TODO connect resources to tasks
			
			//Project tasks
			$data = $this->_getMdpTableData('MSP_TASKS');
			$tasks = array();
			foreach($data as $row) {
				if($row['PROJ_ID'] == $projectId) {
					$taskId = $row['TASK_OUTLINE_NUM'];
					$parts = explode('.',$taskId);
					$level = count($parts) - 1;
					if(!isset($tasks[$level])) {
						$tasks[$level] = array();
					}
					$tasks[$level][$taskId] = $row;
					$tasks[$level][$taskId]['parts'] = $parts;
				}
			}
			ksort($tasks);
			$taskItems = array();
			foreach($tasks as $level => $levelTasks) {
				foreach($levelTasks as $taskId => $row) {
					if($level > 0) {
						$parentIdArray = $row['parts'];
						array_pop($parentIdArray);
						$parentId = implode('.',$parentIdArray);
						if(isset($taskItems[$parentId])) {
							$taskItems[$taskId] = $taskItems[$parentId]->createTask();
						}
						else {
							$taskItems[$taskId] = $this->_phpProject->createTask();
						}
					}
					else {
						$taskItems[$taskId] = $this->_phpProject->createTask();
					}
					$taskItems[$taskId]->setName($row['TASK_NAME']);
					$taskItems[$taskId]->setDuration($row['TASK_DUR']);
					$taskItems[$taskId]->setStartDate($row['TASK_ACT_START']);
					$taskItems[$taskId]->setEndDate($row['TASK_ACT_FINISH']);
					$taskItems[$taskId]->setProgress($row['TASK_ACT_DUR']/$row['TASK_DUR']);
				}
			}
		}
		
		return $this->_phpProject;
	}
	
	/**
	 * Get contents of a table as an assosiated array
	 * 
	 * @param $table Table to be exported
	 * @returns array Table contents
	 */
	protected function _getMdpTableData($table) {
		$csvRows = $this->_getCSVArray($table, true);
		$result = array();
		if($csvRows) {
			$columns = str_getcsv($csvRows[0]);
			
			$rows = count($csvRows);
			for($i=1;$i<$rows;$i++) {
				$rowData = str_getcsv($csvRows[$i]);
				$row = array();
				foreach($columns as $num => $name) {
					$row[$name] = $rowData[$num];
				}
				$result[] = $row;
			}
		}
		return $result;
	}
	
	/**
	 * Get table columns
	 * @returns array
	 */
	protected function _getMdpTableColumns($table) {
		$csvRows = $this->_getCSVArray($table, true);
		if($csvRows) {
			return str_getcsv($csvRows[0]);
		}
		else {
			return array();
		}
	}
	
	protected function _getCSVArray($table, $includeHeaders = true) {
		$args = '';
		if(!$includeHeaders) {
			$args .= '-H ';
		}
		$args .= '-D "%F %T" ' . escapeshellarg($this->_pFilename) . ' ' . escapeshellarg($table);
		return $this->_execute('mdb-export', $args);
	}
	
	/**
	 * Get tables from MDP database
	 * 
	 * @returns array List of tables
	 */
	protected function _getMdpTables() {
		$args = ' -1 ' . escapeshellarg($this->_pFilename);
		return $this->_execute('mdb-tables', $args);
	}
	
	/**
	 * Execute the mdbtools command line apps
	 * 
	 * @param $app Name of the application
	 * @param $paramString Attributes for the application
	 * @returns array Response lines
	 */
	protected function _execute($app, $paramString = null) {
		if($this->mdbToolsPath) {
			$app = escapeshellarg($this->mdbToolsPath) . '/' . $app;
		}
		exec($app . ' ' . $paramString, $outputArray, $exitValue);
		if($exitValue != 0) {
			throw new Exception("Could not execute command");
		}
		return $outputArray;
	}
}
