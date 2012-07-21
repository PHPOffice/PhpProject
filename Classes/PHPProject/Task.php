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
 * @copyright	Copyright (c) 2012 - 2012 PHPProject (https://github.com/Progi1984/PHPProject)
 * @license	http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version	##VERSION##, ##DATE##
 */


/**
 * PHPProject_Task
 *
 * @category	PHPProject
 * @package		PHPProject
 * @copyright	Copyright (c) 2012 - 2012 PHPProject (https://github.com/Progi1984/PHPProject)
 */
class PHPProject_Task
{
	/**
	 * Name
	 * 
	 * @var string
	 */
	private $_name;
	
	/**
	 * Duration
	 * 
	 * @var string
	 */
	private $_duration;
	
	/**
	 * Start Date
	 *
	 * @var	datetime
	 */
	private $_startDate;
	
	/**
	 * End Date
	 *
	 * @var	datetime
	 */
	private $_endDate;
	
	/**
	 * Progress
	 *
	 * @var	float
	 */
	private $_progress;
	
	/**
	 * Parent Project
	 * 
	 * @var PHPProject
	 */
	private $_parentProject;
	
	/**
	 * Parent Task
	 *
	 * @var PHPProject_Task
	 */
	private $_parentTask;
	
	/**
	 * Index
	 *
	 * @var integer
	 */
	private $_index;
	
	public function __construct(PHPProject $pParent, $pIndex, PHPProject $pParentTask = null){
		$this->_parentProject = $pParent;
		$this->_parentTask = $pParentTask;
		$this->_index = $pIndex;
	}
	
	/**
	 * Get parent
	 *
	 * @return PHPProject
	 */
	public function getParent() {
		return $this->_parent;
	}

	/**
	 * Get parent task
	 *
	 * @return PHPProject_Task
	 */
	public function getParentTask() {
		return $this->_parentTask;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}
	
	/**
	 * Set name
	 *
	 * @param string $pValue Name of the task
	 * @return PHPProject_Task
	 */
	public function setName($pValue)
	{
		$this->_name = $pValue;
		return $this;
	}
	
	/**
	 * Get duration
	 *
	 * @return string
	 */
	public function getDuration()
	{
		return $this->_duration;
	}
	
	/**
	 * Set duration
	 *
	 * @param string $pValue Duration of the resource
	 * @return PHPProject_Task
	 */
	public function setDuration($pValue)
	{
		$this->_duration = $pValue;
		return $this;
	}
	
	/**
	 * Get Start Date
	 *
	 * @return	datetime
	 */
	public function getStartDate() {
		return $this->_startDate;
	}

	/**
	 * Set Start Date
	 *
	 * @param	datetime	$pValue
	 * @return	PHPProject_DocumentInformations
	 */
	public function setStartDate($pValue = null) {
		if ($pValue === NULL) {
			$pValue = time();
		} elseif (is_string($pValue)) {
			if (is_numeric($pValue)) {
				$pValue = intval($pValue);
			} else {
				$pValue = strtotime($pValue);
			}
		}

		$this->_startDate = $pValue;
		return $this;
	}

	/**
	 * Get End Date
	 *
	 * @return	datetime
	 */
	public function getEndDate() {
		return $this->_endDate;
	}

	/**
	 * Set End Date
	 *
	 * @param	datetime	$pValue
	 * @return	PHPProject_DocumentInformations
	 */
	public function setEndDate($pValue = null) {
		if ($pValue === NULL) {
			$pValue = time();
		} elseif (is_string($pValue)) {
			if (is_numeric($pValue)) {
				$pValue = intval($pValue);
			} else {
				$pValue = strtotime($pValue);
			}
		}

		$this->_endDate = $pValue;
		return $this;
	}
	
	/**
	 * Get Progress
	 *
	 * @return float
	 */
	public function getProgress()
	{
		return $this->_progress;
	}
	
	/**
	 * Set progress
	 *
	 * @param float $pValue Progress of the task
	 * @return PHPProject_Task
	 */
	public function setProgress($pValue = 0)
	{
		if($pValue > 1){
			$this->_progress = 1;
		} elseif($pValue < 0){
			$this->_progress = 0;
		} else {
			$this->_progress = $pValue;
		}
		return $this;
	}
	



}