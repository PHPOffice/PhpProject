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
 * @category   PHPProject
 * @package    PHPProject
 * @copyright  Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** PHPProject root directory */
if (!defined('PHPPROJECT_ROOT')) {
	define('PHPPROJECT_ROOT', dirname(__FILE__) . '/');
	require(PHPPROJECT_ROOT . 'PHPProject/Autoloader.php');
}

/**
 * PHPProject
 *
 * @category   PHPProject
 * @package    PHPProject
 * @copyright  Copyright (c) 2006 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 */

class PHPProject {
	/**
	 * Document properties
	 *
	 * @var PHPProject\DocumentProperties
	 */
	private $_properties;

	/**
	 * Document informations
	 *
	 * @var PHPProject\DocumentInformations
	 */
	private $_informations;
	
	/**
	 * Collection of task objects
	 *
	 * @var PHPProject\Task[]
	 */
	private $_taskCollection = array();
	
	/**
	 * Collection of resource objects
	 *
	 * @var PHPProject\Resource[]
	 */
	private $_resourceCollection = array();
	
	/**
	 * Collection of calendar objects
	 * 
	 * @var PHPProject\Calendar[]
	 */
	private $_calendarCollection = array();
	
	/**
	 * Active task
	 *
	 * @var int
	 */
	private $_activeTaskIndex = 0;

	/**
	 * Active resource
	 *
	 * @var int
	 */
	private $_activeResourceIndex = 0;
	
	/**
	 * Active calendar
	 * 
	 * @var int
	 */
	private $_activeCalendarIndex = 0;
	
	/**
	 * Create a new PHPProject
	 */
	public function __construct() {
		// Create document properties
		$this->_properties = new PHPProject\DocumentProperties();
		// Create document informations
		$this->_informations = new PHPProject\DocumentInformations();
	}

	//===============================================
	// Document Properties
	//===============================================
	/**
	 * Get properties
	 *
	 * @return PHPProject_DocumentProperties
	 */
	public function getProperties()
	{
		return $this->_properties;
	}

	/**
	 * Set properties
	 *
	 * @param PHPProject_DocumentProperties	$pValue
	 */
	public function setProperties(PHPProject\DocumentProperties $pValue)
	{
		$this->_properties = $pValue;
	}

	//===============================================
	// Document Informations
	//===============================================
	/**
	 * Get informations
	 * 
	 * @return PHPProject_DocumentInformations
	 */
	public function getInformations()
	{
		return $this->_informations;
	}
	
	/**
	 * Set informations
	 *
	 * @param PHPProject_DocumentProperties	$pValue
	 */
	public function setInformations(PHPProject\DocumentInformations $pValue)
	{
		$this->_informations = $pValue;
	}
	
	//===============================================
	// Resources
	//===============================================
	/**
	 * Create a resource
	 *
	 * @return PHPProject_Resource
	 * @throws Exception
	 */
	public function createResource() {
		$newRessource = new PHPProject\Resource($this, $this->getResourceCount());
		$this->_resourceCollection[] = $newRessource;
		$this->_activeResourceIndex = $this->getResourceCount() - 1;
		return $newRessource;
	}

	/**
	 * Get resource count
	 *
	 * @return int
	 */
	public function getResourceCount()
	{
		return count($this->_resourceCollection);
	}
	
	/**
	 * Get all resources
	 *
	 * @return PHPProject_Resource[]
	 */
	public function getAllResources(){
		return $this->_resourceCollection;
	}
	
	/**
	 * Get active resource
	 *
	 * @return PHPProject_Resource
	 */
	public function getActiveResource()
	{
		return $this->_resourceCollection[$this->_activeResourceIndex];
	}
	
	/**
	 * Get resource by index
	 *
	 * @param int $pIndex Resource index
	 * @return PHPProject_Resource
	 * @throws Exception
	 */
	public function getResource($pIndex = 0)
	{
		if ($pIndex > count($this->_resourceCollection) - 1) {
			throw new \Exception('Resource index is out of bounds.');
		} else {
			return $this->_resourceCollection[$pIndex];
		}
	}
	
	/**
	 * Get active resource index
	 *
	 * @return int Active resource index
	 */
	private function getActiveResourceIndex()
	{
		return $this->$_activeResourceIndex;
	}
	
	/**
	 * Set active resource index
	 *
	 * @param int $pIndex Active resource index
	 * @throws Exception
	 * @return PHPProject_Resource
	 */
	private function setActiveResourceIndex($pIndex = 0)
	{
		if ($pIndex > count($this->_resourceCollection) - 1) {
			throw new \Exception('Active resource index is out of bounds.');
		} else {
			$this->_activeResourceIndex = $pIndex;
		}
		return $this->getActiveResource();
	}
	
	//===============================================
	// Tasks
	//===============================================
	/**
	 * Create a task
	 *
	 * @return PHPProject_Task
	 * @throws Exception
	 */
	public function createTask() {
		$newTask = new PHPProject\Task($this, $this->getTaskCount());
		$this->_taskCollection[] = $newTask;
		$this->_activeTaskIndex = $this->getTaskCount() - 1;
		return $newTask;
	}
	
	/**
	 * Get task count
	 *
	 * @return int
	 */
	public function getTaskCount() {
		return count($this->_taskCollection);
	}
	
	/**
	 * Get all tasks
	 *
	 * @return PHPProject\Task[]
	 */
	public function getAllTasks() {
		return $this->_taskCollection;
	}
	
	/**
	 * Get active task
	 *
	 * @return PHPProject\Task
	 */
	public function getActiveTask() {
		return $this->getTask($this->_activeTaskIndex);
	}
	
	/**
	 * Get task by index
	 *
	 * @param int $pIndex Task index
	 * @return PHPProject\Task
	 * @throws Exception
	 */
	public function getTask($pIndex = 0) {
		if(!isset($this->_taskCollection[$pIndex])) {
			throw new \Exception("Task #$pIndex is out of bounds.");
		}
		return $this->_taskCollection[$pIndex];
	}
	
	/**
	 * Remove task by index
	 *
	 * @param int $pIndex Active task index
	 * @throws Exception
	 */
	public function removeTaskByIndex($pIndex = 0) {
		if(!isset($this->_taskCollection[$pIndex])) {
			throw new \Exception("Task #$pIndex is out of bounds.");
		}
		unset($this->_taskCollection[$pIndex]);
	}
	
	/**
	 * Get active task index
	 *
	 * @return int Active task index
	 */
	public function getActiveTaskIndex() {
		return $this->_activeTaskIndex;
	}

	/**
	 * Set active task index
	 *
	 * @param int $pIndex Active task index
	 * @throws Exception
	 * @return PHPProject\Task
	 */
	public function setActiveTaskIndex($pIndex = 0) {
		if(!isset($this->_taskCollection[$pIndex])) {
			throw new \Exception("Task #$pIndex is out of bounds.");
		}
		$this->_activeTaskIndex = $pIndex;
		return $this->getActiveTask();
	}
	
	//===============================================
	// Tasks
	//===============================================
	/**
	 * Create a calendar
	 * 
	 * @param $uid Calendar UID
	 * @returns PHPProject\Calendar
	 */
	public function createCalendar($uid) {
		$newCalendar = new PHPProject\Calendar($uid);
		$this->_calendarCollection[] = $newCalendar;
		$this->_activeCalendarIndex = $this->getCalendarCount() - 1;
		return $newCalendar;
	}
	
	/**
	 * Get calendar count
	 *
	 * @return int
	 */
	public function getCalendarCount() {
		return count($this->_calendarCollection);
	}
	
	/**
	 * Get all calendars
	 *
	 * @return PHPProject\Calendar[]
	 */
	public function getAllCalendars() {
		return $this->_calendarCollection;
	}
	
	/**
	 * Get active calendar
	 *
	 * @return PHPProject\Calendar
	 */
	public function getActiveCalendar() {
		return $this->getCalendar($this->_activeCalendarIndex);
	}
	
	/**
	 * Get calendar by index
	 *
	 * @param int $pIndex Calendar index
	 * @return PHPProject\Calendar
	 * @throws Exception
	 */
	public function getCalendar($pIndex = 0) {
		if(!isset($this->_calendarCollection[$pIndex])) {
			throw new \Exception("Calendar #$pIndex is out of bounds.");
		}
		return $this->_calendarCollection[$pIndex];
	}
	
	/**
	 * Remove calendar by index
	 *
	 * @param int $pIndex Active calendar index
	 * @throws Exception
	 */
	public function removeCalendarByIndex($pIndex = 0) {
		if(!isset($this->_calendarCollection[$pIndex])) {
			throw new \Exception("Calendar #$pIndex is out of bounds.");
		}
		unset($this->_calendarCollection[$pIndex]);
	}
	
	/**
	 * Get active calendar index
	 *
	 * @return int Active calendar index
	 */
	public function getActiveCalendarIndex() {
		return $this->_activeCalendarIndex;
	}
	
	/**
	 * Set active calendar index
	 *
	 * @param int $pIndex Active calendar index
	 * @throws Exception
	 * @return PHPProject\Calendar
	 */
	public function setActiveCalendarIndex($pIndex = 0) {
		if(!isset($this->_calendarCollection[$pIndex])) {
			throw new \Exception("Calendar #$pIndex is out of bounds.");
		}
		$this->_activeCalendarIndex = $pIndex;
		return $this->getActiveCalendar();
	}
}
