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
 * PHPProject_DocumentInformations
 *
 * @category	PHPProject
 * @package		PHPProject
 * @copyright	Copyright (c) 2012 - 2012 PHPProject (https://github.com/Progi1984/PHPProject)
 */
class PHPProject_DocumentInformations
{
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
	 * Create a new PHPProject_DocumentInformations
	 */
	public function __construct()
	{
		$this->_startDate	= time();
		$this->_endDate		= time();
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
	 * Implement PHP __clone to create a deep clone, not just a shallow copy.
	 */
	public function __clone() {
		$vars = get_object_vars($this);
		foreach ($vars as $key => $value) {
			if (is_object($value)) {
				$this->$key = clone $value;
			} else {
				$this->$key = $value;
			}
		}
	}
}
