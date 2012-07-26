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


/**
 * PHPProject_Reader_MSProjectExchange
 *
 * Docs : 
 * http://support.microsoft.com/default.aspx?scid=KB;EN-US;Q270139
 *
 * @category	PHPProject
 * @package		PHPProject
 * @copyright	Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 */
class PHPProject_Reader_MSProjectExchange
{
	/**
	 * PHPProject object
	 *
	 * @var PHPProject
	 */
	private $_phpProject;
	
	
	/**
	 * Create a new PHPProject_Reader_MSProjectExchange
	 *
	 * @param	PHPProject	$phpProject	PHPProject object
	 */
	public function __construct() {
		$this->_phpProject	= new PHPProject();
	}
	
	/**
	 * 
	 *
	 * @param unknown_type $pFilename
	 * @return PHPProject
	 */
	public function load($pFilename = null){
	
		return $this->_phpProject;
	}
}


?>