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

namespace PHPProject;

/**
 * PHPProject_Calendar
 *
 * @category	PHPProject
 * @package	PHPProject
 * @author	Tuomas Angervuori <tuomas.angervuori@gmail.com>
 */
class Calendar {
	
	const WEEKDAY_SUNDAY = 1;
	const WEEKDAY_MONDAY = 2;
	const WEEKDAY_TUESDAY = 3;
	const WEEKDAY_WEDNESDAY = 4;
	const WEEKDAY_THURSDAY = 5;
	const WEEKDAY_FRIDAY = 6;
	const WEEKDAY_SATURDAY = 7;
	
	/**
	 * Calendar UID
	 * @var string
	 */
	private $_uid;
	
	/**
	 * Calendar name
	 * 
	 * @var string
	 */
	private $_name;
	
	/**
	 * Is the calendar base calendar
	 * 
	 * @var bool
	 */
	private $_isBaseCalendar = true;
	
	/**
	 * Attributes for weekdays
	 * 
	 * @var array
	 */
	private $_weekDays = array();
	
	/**
	 * Exception dates in calendar
	 * 
	 * @var array
	 */
	private $_exceptions = array();
	
	public function __construct($uid = 1) {
		$this->setUID($uid);
	}
	
	/**
	 * Calendar UID
	 */
	public function setUID($uid) {
		$this->_uid = $uid;
	}
	public function getUID() {
		return $this->_uid;
	}
	
	public function setName($string) {
		$this->_name = $string;
	}
	public function getName() {
		return $this->_name;
	}
	
	public function isBaseCalendar($bool = null) {
		$value = $this->_isBaseCalendar;
		if($bool !== null) {
			$this->_isBaseCalendar = (bool)$bool;
		}
		return $value;
	}
	
	
	public function addException($fromTime, $toTime, $name) {
		
	}
	public function getExceptions() {
		return $this->_exceptions;
	}
}