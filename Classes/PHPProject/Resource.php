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
 * PHPProject_Resource
 *
 * @category	PHPProject
 * @package		PHPProject
 * @copyright	Copyright (c) 2012 - 2012 PHPProject (https://github.com/Progi1984/PHPProject)
 */
class PHPProject_Resource
{
	/**
	 * Title
	 * 
	 * @var string
	 */
	private $_title;
	
	/**
	 * Parent Project
	 * 
	 * @var PHPProject
	 */
	private $_parent;
	
	/**
	 * Index
	 * 
	 * @var integer
	 */
	private $_index;
	
	public function __construct(PHPProject $pParent, $pIndex){
		$this->_parent = $pParent;
		$this->_index = $pIndex;
	}
	
	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->_title;
	}
	
	/**
	 * Set title
	 *
	 * @param string $pTitle Title of the resource
	 * @return PHPProject_Resource
	 */
	public function setTitle($pTitle)
	{
		$this->_title = $pTitle;
		return $this;
	}
	
	/**
	 * Get index
	 *
	 * @return index
	 */
	public function getIndex()
	{
		return $this->_index;
	}
	
	/**
	 * Get parent
	 *
	 * @return PHPProject
	 */
	public function getParent() {
		return $this->_parent;
	}

}