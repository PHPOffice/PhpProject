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
 * PHPProject\DocumentInformations
 *
 * @category	PHPProject
 * @package	PHPProject
 * @copyright	Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 */
class DocumentInformations
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
		$this->_startDate = self::_getDateTime($pValue);
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
		$this->_endDate = self::_getDateTime($pValue);
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
	
	protected static function _getDateTime($pValue) {
		if($pValue instanceof DateTime) {
			$dateTime = $pValue;
		}
		elseif ($pValue === NULL) {
			$dateTime = new DateTime();
		} elseif (is_string($pValue)) {
			if (is_numeric($pValue)) {
				$dateTime = new DateTime();
				$dateTime->setTimestamp($pValue);
			} else {
				$dateTime = new DateTime($pValue);
			}
		}
		return $dateTime;
	}
}
