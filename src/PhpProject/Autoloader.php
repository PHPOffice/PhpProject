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
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */

PHPProject_Autoloader::Register();
// check mbstring.func_overload
if (ini_get('mbstring.func_overload') & 2) {
    throw new Exception('Multibyte function overloading in PHP must be disabled for string functions (2).');
}


/**
 * PHPProject_Autoloader
 *
 * @category	PHPProject
 * @package		PHPProject
 * @copyright	Copyright (c) 2006 - 2012 PHPProject (https://github.com/Progi1984/PHPProject)
 */
class PHPProject_Autoloader
{
	/**
	 * Register the Autoloader with SPL
	 *
	 */
	public static function Register() {
		if (function_exists('__autoload')) {
			//	Register any existing autoloader function with SPL, so we don't get any clashes
			spl_autoload_register('__autoload');
		}
		//	Register ourselves with SPL
		return spl_autoload_register(array('PHPProject_Autoloader', 'Load'));
	}	//	function Register()


	/**
	 * Autoload a class identified by name
	 *
	 * @param	string	$pClassName		Name of the object to load
	 */
	public static function Load($pClassName){
		if ((class_exists($pClassName)) || (strpos($pClassName, 'PHPProject') !== 0)) {
			//	Either already loaded, or not a PHPProject class request
			return FALSE;
		}

		$pClassFilePath = PHPPROJECT_ROOT .
						  str_replace('_',DIRECTORY_SEPARATOR,$pClassName) .
						  '.php';

		if ((file_exists($pClassFilePath) === false) || (is_readable($pClassFilePath) === false)) {
			//	Can't load
			return FALSE;
		}

		require($pClassFilePath);
	}	//	function Load()

}